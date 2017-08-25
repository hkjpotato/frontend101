import React from 'react';
import ReactDOM from 'react-dom';

const items = ['tom', 'kj', 'potato'];
class DropDown extends React.Component {
  itemClick(item) {
    console.log('item click', item)
  }
  render() {
    const listItems = items.map(item=>(
      <li>
        <a href="#" onClick={(e)=>{
          e.preventDefault()
          this.itemClick(item)
        }}>{item}</a>
      </li>
    ))

    return (
      <div className="dropdown">
        <button 
          className="btn btn-default dropdown-toggle" 
          type="button" 
          id="dropdownMenu1" 
          data-toggle="dropdown" 
          aria-haspopup="true"
          aria-expanded="true">
          Dropdown
          <span className="caret"></span>
        </button>
        <ul className="dropdown-menu">
          {listItems}
        </ul>
      </div>
    )
  }
}


class CheckBoxList extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      select: null
    }
  }
  filterClick(item) {
    console.log('item ', item)
    this.setState({
      select: item
    })
  }
  render() {
    const checkboxes = items.map(item => (
      <div key={item}>
        <input
          type="checkbox"
          value={item}
          onClick={(e)=>{
            // e.preventDefault()
            this.filterClick(item)
          }}
          checked={item==this.state.select} />
        <label>{item}</label>
      </div>
    )) 

    return (
      <div>
        {checkboxes}
      </div>
    )
  }
}


var element = <CheckBoxList />
ReactDOM.render(
  element,
  document.getElementById('root')
)

