import React from 'react'
import { PropTypes } from 'react'
const storeShape = PropTypes.shape({
  subscribe: PropTypes.func.isRequired,
  dispatch: PropTypes.func.isRequired,
  getState: PropTypes.func.isRequired
})
const subscriptionShape = PropTypes.shape({
  trySubscribe: PropTypes.func.isRequired,
  notifyNestedSubs: PropTypes.func.isRequired
})
export function connect(
    mapStateToProps,
    mapDispatchToProps
  ) {
  //connectHOC is a function that return the Higher Order Component with connect to the store 
  return connectHOC(mapStateToProps, mapDispatchToProps);
}

export class Provider extends React.Component {
  constructor(props, context) {
    super(props, context)
    this.store = props.store;
  }
  getChildContext() {
    return { store: this.store, parentSub: null }
  }
  render() {
    return React.Children.only(this.props.children)
  }
}
Provider.childContextTypes = {
  store: storeShape,
  parentSub: subscriptionShape,
}

class Subscription {
  constructor(store, parentSub, onStateChange) {
    this.store = store //global store from context
    this.parentSub = parentSub //parentSub from context
    this.onStateChange = onStateChange //its own listener
    this.subscribed = false //a flag for testing whether itself has been subscribed
    this.listeners = [] //nested subscription listeners subscribed here
  }
  //notify the listeners subscribed to itself
  notifyNestedSubs() {
    this.listeners.forEach(l=>l());
  }
  trySubscribe() {
    //if not yet subscribed
    if (!this.subscribed) {
      if (this.parentSub !== null) {
        //if has parentSub(from context), subscribe to parentSub
        this.parentSub.addNestedSub(this.onStateChange)
      }
      else {
        //if root component, subscribe directly to store
        this.store.subscribe(this.onStateChange)
      }
      //mark it as subscribed
      this.subscribed = true;
    }
  }
  //for adding nested subscription listener to itself
  addNestedSub(listener) {
    //First, ensure itself has been subscribed, that's how the order of subscription is maintained
    this.trySubscribe()
    //THEN, subscribe the nested listener to its own listener collection
    this.listeners.push(listener)
  }
}

//a factory function that return selector based on the mapping functions and store.dispatch method
//the return selector can then use the mapping functions to convert the nextState and ownProps to the mergedProps
function selectorFactory(dispatch, mapStateToProps, mapDispatchToProps) {
  //cache the DIRECT INPUT for the selector
  //the store state
  let state
  //the container's own props
  let ownProps

  //cache the itermediate results from mapping functions
  //the derived props from the state
  let stateProps
  //cache the derived props from the store.dispatch
  let dispatchProps

  //cache the output
  //the return merged props(stateProps + dispatchProps + ownProps) to be injected to wrappedComponent
  let mergedProps

  // the source selector is memorizable.
  return function selector(nextState, nextOwnProps) {
    //before running the actual mapping function, compare its arguments with the previous one
    const propsChanged = !shallowEqual(nextOwnProps, ownProps)
    const stateChanged = !strictEqual(nextState, state)

    state = nextState
    ownProps = nextOwnProps
 
    //calculate the return mergedProps based on different scenarios 
    //to MINIMIZE the call to actual mapping functions
    //notice: the mapping function itself can be optimized by Reselect, but it is not the concern here
    
    //case 1: both state in redux and own props change
    if (propsChanged && stateChanged) {
      //derive new props based on state
      stateProps = mapStateToProps(state, ownProps)
      //since the ownProps change, update dispatch callback if it depends on props
      if (mapDispatchToProps.length !== 1) dispatchProps = mapDispatchToProps(dispatch, ownProps)
      //merge the props
      mergedProps = mergeProps(stateProps, dispatchProps, ownProps)
      return mergedProps
    }

    //case 2: only own props changes
    if (propsChanged) {
      //only update stateProps and dispatchProps if they rely on ownProps
      if (mapStateToProps.length !== 1) stateProps = mapStateToProps(state, ownProps) //it just call the mapping function
      if (mapDispatchToProps.length !== 1) dispatchProps = mapDispatchToProps(dispatch, ownProps)
      mergedProps = mergeProps(stateProps, dispatchProps, ownProps)
      return mergedProps
    }

    //case 3: only store state changes
    // 1.since stateProps depends on state so must run mapStateToProps again
    // 2.for dispatch, since store.dispatch and ownProps remain the same, no need to update
    if (stateChanged) {
      const nextStateProps = mapStateToProps(state, ownProps)
      const statePropsChanged = !shallowEqual(nextStateProps, stateProps)
      stateProps = nextStateProps
      //if stateProps changed, update mergedProps by calling the mergeProps function
      if (statePropsChanged) mergedProps = mergeProps(stateProps, dispatchProps, ownProps)
      return mergedProps
    }

    //case 4: no change, return the cached result if no change in input
    return mergedProps;
  }
}


//1. it also cache the last output(mergedProps)
//2. it is stateful because it tracks the result and knows whether the React Component should update
function makeSelectorStateful(selector, store) {
  // wrap the selector in an object that tracks its results between runs.
  const statefulSelector = {
    run: function (props) {
      //when it runs, it will call the selector to calculate the next mergedProps
      const nextProps = selector(store.getState(), props);
      //but it only set shouldComponentUpdate to true if result is different from previous
      if (nextProps !== statefulSelector.props) {
        //update info for React
        statefulSelector.shouldComponentUpdate = true;
        statefulSelector.props = nextProps;
      }
    }
  }
  return statefulSelector
}


//in the source code, it is called 'connectAdvanced'
function connectHOC(mapStateToProps, mapDispatchToProps) {
  //wrapWithConnect is the actual HOC
  return function wrapWithConnect(WrappedComponent) {
    //Connect is the actual Container Component
    class Connect extends React.Component {
      constructor(props, context) {
        super(props, context)
        this.store = context.store //access store from context
        this.initSelector()
        this.initSubscription()
      }
      getChildContext() {
        //replace subscription context variable for the child
        return {
          parentSub : this.subscription
        }
      }
      initSelector() {
        //selector: (reduxStore.state + ownProps) => injected mergedProps 
        const selector = selectorFactory(this.store.dispatch, mapStateToProps, mapDispatchToProps)
        this.selector = makeSelectorStateful(selector, this.store)
        this.selector.run(this.props)
      }
      initSubscription() {
        const parentSub = this.context.parentSub //for the root it is null
        this.subscription = new Subscription(this.store, parentSub, this.onStateChange.bind(this))
      }
      componentDidMount() {
        this.subscription.trySubscribe()
      }
      //data source 1: store state change
      onStateChange() {
        //run the stateful selector to update mergedProps
        this.selector.run(this.props)
        if (!this.selector.shouldComponentUpdate) {
          //if it does not get re-render, we still need to notify the nested subscription
          this.subscription.notifyNestedSubs()
        } else {
          this.componentDidUpdate = this.notifyNestedSubsOnComponentDidUpdate
          this.setState({})
        }
      }
      notifyNestedSubsOnComponentDidUpdate() {
        this.componentDidUpdate = undefined; //unimplement it to avoid notification due to normal update(e.g. parent's re-render)
        this.subscription.notifyNestedSubs();
      }
      //data source 2: ownProps change
      componentWillReceiveProps(nextProps) {
        //run the stateful selector to update mergedProps
        this.selector.run(nextProps)
      }
      shouldComponentUpdate() {
        //rely on the stateful selector, prevent unnecessary re-render
        return this.selector.shouldComponentUpdate
      }
      render() {
        const selector = this.selector
        selector.shouldComponentUpdate = false //reset the flag of the selector
        return React.createElement(WrappedComponent, selector.props) //get the mergedProps from the selector 
      }
    }
    //the context exposed to container itself
    Connect.contextTypes = {
      store : storeShape,
      parentSub : subscriptionShape,
    }
    //replace the context of parentSub for the child component
    Connect.childContextTypes = { 
      parentSub: subscriptionShape,
    }
    return Connect;
  }
}

//------util helper functions---------
const hasOwn = Object.prototype.hasOwnProperty

function is(x, y) {
  if (x === y) {
    return x !== 0 || y !== 0 || 1 / x === 1 / y
  } else {
    return x !== x && y !== y
  }
}

function shallowEqual(objA, objB) {
  if (is(objA, objB)) return true

  if (typeof objA !== 'object' || objA === null ||
      typeof objB !== 'object' || objB === null) {
    return false
  }

  const keysA = Object.keys(objA)
  const keysB = Object.keys(objB)

  if (keysA.length !== keysB.length) return false

  for (let i = 0; i < keysA.length; i++) {
    if (!hasOwn.call(objB, keysA[i]) ||
        !is(objA[keysA[i]], objB[keysA[i]])) {
      return false
    }
  }

  return true
}

function strictEqual(a, b) { return a === b }

function mergeProps(stateProps, dispatchProps, ownProps) {
  //use spread operator to match to new object
  return { ...ownProps, ...stateProps, ...dispatchProps }
}
