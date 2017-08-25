// if (module.hot) {
//   console.log('HMR enable')
// }


// import { createStore } from 'redux';
// import todoApp from './reducers';


//--DATA FLOW
/*
redux has a strict unidirectional data flow, which means
1. all data follows the same lifecycle pattern
2. encourages data normalization(so that you dont end up with duplicate data)

the second point is very important but less awared by newbie like me.

in database, database normalization is the process of organizing
the columns and tables to reduce data redundancy and improve data integrity

you see, thats why a frontend guy should know about database concept

lifecylce in 4 steps
1. store.dispatch(action) //action dispatch can happen anywhere, including React Component lifecyle, AJAX callback, or even intervals(reducer is pure, action can be async with side effect)
2. store call the reducers
// reducer is pure, no api call or router transitions, those thing should happen before action is dispatch
// it means, when action is dispatch, you cant make any more change to state of the app, say byebye to any side effect
3. reducers is called which means root reducer may combine the output of children reducers back into a SINGLE state tree
4. when nextState is available, notify the listeners. Listener can get the state by calling store.getState()
// in react, this is the point at which setState(newState) is called
*/
import { createStore } from 'redux';
import React from 'react';
import ReactDOM from 'react-dom';

//Let's try to understand how connect is born.

//The presentational component
class Counter extends React.Component {
  render() {
    return (
      <div>
      {this.props.value}
      <button onClick={this.props.onAdd}>add</button>
      </div>)
  }
}

//STEP1: a hand made container
//https://facebook.github.io/react/docs/higher-order-components.html
class Container extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      value: this.props.store.getState()
    }
    this.onAdd = this.onAdd.bind(this);
    this.handleChange = this.handleChange.bind(this);
  }
  componentDidMount() {
    this.unsubscribe = this.props.store.subscribe(this.handleChange)
  }
  handleChange() {
    this.setState({
      value: this.props.store.getState()
    })
  }
  componentWillUnmount() {
    this.unsubscribe()
  }
  onAdd() {
    this.props.store.dispatch({
      type: 'ADD'
    })
  }
  render() {
    return <Counter value={this.state.value} onAdd={this.onAdd} />
  }
}

//STEP2: let's make an HOC based on the above example
// the first args is the wrappedComponent(presentation), the second args retrive the interested data from the given store
/**

'CommentList and BlogPost aren't identical — they call different methods on DataSource, and they render different output. But much of their implementation is the same:
On mount, add a change listener to DataSource.
Inside the listener, call setState whenever the data source changes.
On unmount, remove the change listener.

So you see, the basic idea is that if the only difference in the pattern
is how to retrieve data and react to the change of data, and they share
common behaviors such as subscribtion, we can make a function to do the common part,
and let the difference be the arguments.' ...from tutorial

That is the same goal of connect
You can think of HOCs as parameterized container component definitions.

the logic here:
1. we want to use container to inject some props&callback to the wrappedComponent
2. we get a wrappedComponent, two methods on how to generate the injected props as object
3. we pass them as additional props to the wrap component
4. the common thing is subscription

notice the difference from the React tutorial example,
instead of passing only one additional fix props as data
we pass the additional props as object
*/

//convert store's info to props for presentational component
//similar to mapStateToProps and mapDispatchToProps
function getInjectedProps(store, ownProps) {
  return {
    value: store.getState()
  }
}

function getInjectedCallBack(store, ownProps) {
  return {
    onAdd: (ownProps)=>{
      store.dispatch({
        type: 'ADD'
      })
    }
  }
}

function withSubscription(WrappedComponent, getInjectedProps, getInjectedCallBack) {
  return class extends React.Component {
    constructor(props) {
      super(props);
      this.state = getInjectedProps(store, props);
      this.handleChange = this.handleChange.bind(this);
    }
    handleChange() {
      this.setState(getInjectedProps(store, this.props));
    }
    componentDidMount() {
      store.subscribe(this.handleChange)
    }
    render() {
      // const injectedProps = {data: this.state.data}; //this is how we map state to props
      // // Inject props into the wrapped component. These are usually state values or
      // // instance methods.
      // const injectedProp = someStateOrInstanceMethod;
      const injectedProps = this.state;
      const injectedCallBack = getInjectedCallBack(store, this.props)
      //notice each time of render we get a new callback func, which is bad for performance
      //however, redux connect solve this by smart shouldComponentUpdate in the container I guess
      return <WrappedComponent {...injectedProps} {...injectedCallBack} {...this.props} />
    }
  }
}

//STEP3: who said that the container needs to have state
function withSubscription2(WrappedComponent, getInjectedProps, getInjectedCallBack) {
  return class extends React.Component {
    componentDidMount() {
      store.subscribe(()=> {
        this.forceUpdate();
      })
    }
    render() {
      const injectedProps = getInjectedProps(store, this.props);
      const injectedCallBack = getInjectedCallBack(store, this.props);
      return <WrappedComponent {...injectedProps} {...injectedCallBack} {...this.props} />
    }
  }
}

//STEP4: composition
//connect is a HOF that return HOC
function myConnect(getInjectedProps, getInjectedCallBack) {
  return function connectHOC(WrappedComponent) {
    return class extends React.Component {
      componentDidMount() {
        store.subscribe(()=>this.forceUpdate())
      }
      render() {
        const injected = {
          ...getInjectedProps(store, this.props),
          ...getInjectedCallBack(store, this.props)
        }
        return <WrappedComponent {...injected} {...this.props} />
      }
    }
  }
}




//Again, in other words, connect is a higher-order function that returns a higher-order component!
function counterReducer(state=0, action) {
  switch (action.type) {
    case 'ADD':
      return state + 1
    default:
      return state;
  }
}

const store = createStore(counterReducer)

// const ContainerHOC3 = withSubscription2(Counter, getInjectedProps, getInjectedCallBack);
const ContainerHOC4 = myConnect(getInjectedProps, getInjectedCallBack)(Counter);

ReactDOM.render(<ContainerHOC4 />, document.getElementById('root'))
