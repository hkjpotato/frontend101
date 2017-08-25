import React from 'react'
import { connect } from 'react-redux'
import { addTodo } from '../actions'

/*
'Sometimes it's hard to tell if some component should be a presentational component or a container. 
For example, sometimes form and function are really coupled together, 
such as in case of this tiny component:

AddTodo is an input field with an “Add” button

Technically we could split it into two components but 
it might be too early at this stage. 
It's fine to mix presentation and logic in a component that is very small. As it grows, it will be more obvious how to split it, so we'll leave it mixed.
'...from redux tutorial


What it says is that
well, presentation organize the outlook
but it is dump and does not connect to the store

container connect to store and know what the app state is and how to change it

however. for a tiny component, that will have to show how thing is look (input field)
and how it affect the change of state(onClick and addTodo button). It is meaningless to
separate the outlook from the action
*/

/*
the result:
Originally, the logic is in those mapTo functions(how state is convert to props and how event affect the state)


Now we are not going to handle the state to props and dispatch to props 
in those injected props function, (map2, map2)


instead, we connect the presentation component
with nothing, in that case, dispatch is the only additional props passed to 
the presentation comp, and it deals with the action logic by itself
*/

let AddTodo = (props) => {
  //props include dispatch as default injected when no mapDispatchToProps is passedhttps://github.com/reactjs/react-redux/blob/master/docs/api.md
  let dispatch = props.dispatch;
  let input; //scope as this

  return (
    <div>
      <form
        onSubmit={
          e => {
            e.preventDefault();
            if (!input.value.trim()) {
              return
            }
            if (input.value === 'test') {
              dispatch({
                type: 'TEST'
              })
            } else {
              dispatch(addTodo(input.value));
            }
            input.value = '';
          }
        }
      >
        <input
          ref={node=>{
            input = node;
          }} />
        <button type="submit">
          Add Todo
        </button>
      </form>
    </div>
  )
}

//make the presentational a component to connect to store
AddTodo = connect()(AddTodo);

export default AddTodo;