/*
  Redux will call reducer with an undefined for the first time
  (check tutorial to see how this is achieved by a dispatch a dummy action
  )

  behind the scene:
  in the createStore function, the state is initially declared by unedefined
  before return the store, createStore will dispatch a dummy(empty) action {type: @redux/INIT} to init the state
  this action, together with the undefine state will be used as input for the reducer
  thus the first call of the reducer(when calling createStore) has an unedefined state

  thus if we checked the state in our reducer called, undefined will be the init value(when creatStore is called)
*/

import { combineReducers } from 'redux'
import todos from './todos'
import visibilityFilter from './visibilityFilter'


function test(state=true, action) {
  switch (action.type) {
    case 'TEST':
      return !state;
    default:
      return state;
  }
}

const todoApp = combineReducers({
  visibilityFilter,
  todos,
  test
});
/*
check how default get inited the reducer
3 defaults for todosApp's todos
1. global default for todoApp {} //if it has default todos, it will pass down to init those reducer when calling it
2. local default for todos []
3. switch default return the current state

since global default is empty, thus the passed in state for todos for the first call will be undefined and it will use local default []

function todoApp(state = {}, action) {
  return {
    visibilityFilter: visibilityFilter(state.visibilityFilter, action), //init undefined
    todos: todos(state.todos, action)
  }
}

*/

/* 
  check the implementation of combineReducer 
  the logic is 
  the pass in is a map 
    {
      key1: reducer1,
      key2: reducer2
    }
  with ES6 object naming shortcut this is achieve by {
    reducer1,
    reducer2
  } and the keys are [reducer1, reducer2]

  those reducers will be call using
  [reducer1, reducer2].reduce
  that's why it is called 'REDUCE'r


  var combineReducers(reducers) {
      //return a function, the parent reducer
      return (state={}, action) => {
        //the parent reducer will return next state based on the return of each child reducer
        // instead of do branching here, we just return the result of the children reducers
        // drawback, every reducer will be call no matter what action type is
        // if we do branching here, we will eliminate some uneccessary child reducer call
        // however, since the reducer call is just a switch and will return the current (from the child reducer not here in parent), it is fine, we just put the branching logic inside the child
        // notice whenever this reducer is called, it call the child reducers explicitly and thats why when it is passed to createStore, the state is init with the empty dummy action
              
        return {
          reducer1: reducers[reducer1](state[reducer1], action),
          reducer2: reducers[reducer2](state[reducer2], action)
          ...
        }
      }

      //a more general format
      return (state={}, action) => {
        return Object.keys(reducers).reduce(
          (nextState, key) => {
            nextState[key] = reducers[key](
              state[key],
              action
            )
          }
          , 
          {} //always a new empty state
        )
      }
  }
*/

/*
you can do your combine with more freedom, who said that the reducer name must be the same as the state

function reducer(state = {}, action) {
  return {
    a: doSomethingWithA(state.a, action),
    b: processB(state.b, action),
    c: differentReducerNameOtherThanC(state.c, action)
  }
} 
*/
export default todoApp
