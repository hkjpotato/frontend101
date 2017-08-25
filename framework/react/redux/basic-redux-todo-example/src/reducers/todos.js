/*
check how default get inited the reducer
3 defaults for todosApp's todos
1. global default for todoApp {} //if it has default todos, it will pass down to init those reducer when calling it
2. local default for todos []
3. switch default return the current state

since global default is empty, thus the passed in state for todos for the first call will be undefined and it will use local default []
*/
export default function todos(state = [], action) {
  // console.log('todos', state, action)
  switch (action.type) {
    case 'ADD_TODO':
      return [
        ...state,
        {
          id: action.id,
          text: action.text,
          completed: false
        }
      ]
    case 'TOGGLE_TODO':
      return state.map((todo, index) => {
        if (index === action.index) {
          return Object.assign({}, todo, {
            completed: !todo.completed
          })
        }
        return todo
      })
    default:
      return state
  }
}