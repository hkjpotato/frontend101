
const node = (state={}, action)=> {
  switch (action.type) {
    case 'ADD_NODE':
    case 'REMOVE_NODE':
    case 'SELECT':
      return {
        ...state,
        selected: true
      }
    case 'UNSELECT':
      return {
        ...state,
        selected: false
      }
    case 'FOCUS':
      return {
        ...state,
        forcused: true
      }
    case 'UNFOCUS':

    default:
      return state;
  }
}


const nodes = (state=[], action) => {
  switch (action.type) {
    case 'ADD_NODE':
    case 'SELECT_NODE':
    case 'FOCUS_NODE':
      return state.map(n=>node(n, action))
    

  }
}