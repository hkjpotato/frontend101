import React from 'react';
import ReactDOM from 'react-dom';

//Remake the react-redux tutorial on egghead


//===reducer===
const visibilityFilter = (
  state = 'SHOW_ALL', //default initial value
  action
) => {
  //our work is to return a new state based on the passed in
  switch (action.type) {
    case 'SET_VISIBILITY_FILTER': //this is the action we are going to deal with
      return action.filter;
    default:
      return state;
  }
};

function todo(state, action) {
  switch(action.type) {
    case 'ADD_TODO':
      return {
        id: action.id,
        text: action.text,
        completed: false
      };
    case 'TOGGLE_TODO':
      if (action.id !== state.id) {
        return state;
      } else {
        return {
          ...state,
          completed : !state.completed
        };
      }
    default:
      return state; //return previous state
  }
}
//hey todos reducer, you should have a default init state, that's an empty array
function todos(state=[], action) {
  switch(action.type) {
    case 'ADD_TODO':
      return [
        ...state, 
        todo(undefined, action)
      ];
    case 'TOGGLE_TODO':
      return state.map((t) => todo(t, action));
    default:
      return state; //return previous state
  }
}

// const todoApp = (state = {}, action) => {
//   return {
//     todos: todos(
//       state.todos,
//       action
//     ),
//     visibilityFilter: visibilityFilter(
//       state.visibilityFilter,
//       action
//     )
//   }
// }

import { combineReducers } from 'redux';

const todoApp = combineReducers({
  todos,
  visibilityFilter,
})

// import { createStore } from 'redux';



//===store===
function createStore(reducer) {
  var state;
  var listeners = [];
  window.listeners = listeners;
  function getState() {
    return state;
  }
  function subscribe(listener) {
    listeners.push(listener);
    //return a helper to remove listener
    return function() {
      listeners = listeners.filter(function(l) {return l !== listener;});
    }
  }

  function dispatch(action) {
    console.log('dispatch called', state)
    state = reducer(state, action);
    listeners.forEach(function(l) {
      l();
    })
  }
  //before return, dispatch a dummy action to active the default state by calling reducer with undefined state
  dispatch({});
  return {
    getState: getState,
    dispatch: dispatch,
    subscribe: subscribe
  }
}

//make our store
var store = createStore(todoApp);

console.log(store.getState());

// ReactDOM.render(
//   <TitleHello />,
//   document.getElementById('root')
// )


//===Presentational Component===
const Link = ({
  active,
  children,
  onClick
}) => {
  if (active) {
    return <span>{children}</span>;
  }
  return (
    <a
      href="#"
      onClick={e=>{
        e.preventDefault()
        onClick();
      }}
    >
      {children}
    </a>
  )
}

//Footer is also a presentaional component
//Footer does not receive any props
const Footer = () => (
  <p>
    Show:
    {' '}
    <FilterLink filter="SHOW_ALL">
      All
    </FilterLink>
    {', '}
    <FilterLink filter="SHOW_ACTIVE">
      Active
    </FilterLink>
    {', '}
    <FilterLink filter="SHOW_COMPLETED">
      Completed
    </FilterLink>
  </p>
)


//===Container Compoenent===


//you see, container can be dump(stateless) as well
class FilterLink extends React.Component {
  componentDidMount() {
    this.unsubscribe = store.subscribe(()=>{
      this.forceUpdate(); //still async and react will patch it
      //forceUpdate will call render for sure, and render is where to get the props from state
    });

    // in the HOC, the subscribe function use this.setState instead
    // it reset the state, and the state of this container is going to be injected
    // in that case, the container is stateful, might not neccessary though

  }
  componentWillUnmount() {
    this.unsubscribe();
  }
  render() {
    //here, in render, is where it map the state from store to the props of the wrappedComponent
    const props = this.props; //self props
    const state = store.getState(); //not self state, but redux state
    
    const injectedProps = {
      active: props.filter === state.visibilityFilter
      ,
      onClick: () => 
        store.dispatch({
          type: 'SET_VISIBILITY_FILTER',
          filter: props.filter
        })
    };

    return (
      <Link
        {...injectedProps}
      >
        {props.children}
      </Link>
    )
  }
}

//container component. no self state
//the props is from store, but its child component may access the store by themself
let nextTodoId = 0;
const TodoApp = ({
  todos,
  visibilityFilter
}) => {
  console.log('TodoApp render');
  return (
    <div>
      <Footer />
    </div>
  );
}

// it is a vs between a single container and multiple container

// with single container, only the root component is talking to store and any props required is pass down
// with multiple containers, each will subscribe to the store and get the desired data in their render function from store
// each container also handle self update when state change in store

// const render = () => {
//   console.log('global render');
//   ReactDOM.render(
//     <TodoApp
//       {...store.getState()} />
//     ,
//     document.getElementById('root')
//   );
// }

// store.subscribe(render);
// render();


// //What if App is just a presentational component
const App = () => {
  console.log('App render');
  return (
    <div>
      <Footer />
    </div>
  )
}




// window.store = store;
ReactDOM.render(
  <App />,
  document.getElementById('root')
)