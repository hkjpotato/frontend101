import React from 'react';
import ReactDOM from 'react-dom';

console.log('hello');


const counter = (state={value1: 0, value2: 0}, action) => {
  switch (action.type) {
    case 'ADD':
      return {
        value1: state.value1 + 10,
        value2: state.value2 + 1,
      }
    default:
      return state
  }
}


import { createStore } from 'redux';

const store = createStore(counter);


// const PresCounter = ({ value, onClick}) => {
//   // console.log('render CounterPresentaional');
//   return <div onClick={onClick}>{value}</div>;
// }


class PresCounter extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      color: 'black',
    }
  }
  render() {
    const { onClick, value } = this.props;
    return (
      <div 
        style={{
          color: this.state.color
        }}
        onClick={onClick}
        onMouseOut={this.onMouseOut}
        onMouseOver={this.onMouseOver}
      >
        {value}
        <div>{"=>"}</div>
        <DumpParent />
      </div>
    )
  }
}





function StringVal ({strval}) {
  return (
    <div>
    {strval}
    </div>
  )
}

function s2p (state, props) {
  return {
    strval: state.value2 + '',
  }
} 

function d2p (dispatch, props) {
  return {
    onClick: ()=> {
      dispatch();
    }
  }
}




//container 见鬼
function mapStateToProps(state, ownProps) {
  return {
    value: state.value1,
  }
}

function mapDispatchToProps(dispatch, ownProps) {
  return {
    onClick: ()=>{
      dispatch({
        type: 'ADD'
      })
    }
  }
}
import { connect, Provider } from './medium.js';



const myHOC = window.myHOC = connect(mapStateToProps, mapDispatchToProps);


const ContCounter = myHOC(PresCounter);


var StringValCont = connect(s2p, d2p)(StringVal);


// const ContCounter = connect(mapStateToProps, mapDispatchToProps)(PresCounter);

class DumpParent extends React.PureComponent {
  render() {
    console.log('DumpParent render');
    return (
    <div>
      <StringValCont />
    </div>);
  }
}

console.log('------***render***------')
// ReactDOM.render(
//   (<Provider store={store}>
//     <div>
//       <ContCounter msg="hello" />
//     </div>
//   </Provider>),
//   document.getElementById('root')
// )

// setInterval(
// ()=>{
//   ReactDOM.render(
//   (<Provider store={store}>
//     <div>
//       <ContCounter msg="hello" rand={Math.random()}/>
//     </div>
//   </Provider>),
//   document.getElementById('root')
// )
// }

// , 2000)

var listeners = [];

class Parent extends React.Component {
  constructor(props) {
    super(props)
    window.parentOnStateChange = this.onStateChange.bind(this)

  }
  componentDidMount() {
    listeners.push(this.onStateChange.bind(this))
  }
  onStateChange() {
    console.log('parent onStateChange')
    this.setState({})
  }
  render() {
    console.log('parent render')
    return <Child />
  }
}

class Child extends React.Component {
  componentDidMount() {
    console.log('child componentDidMount')
    listeners.push(this.onStateChange.bind(this))
    // window.test = () => {
    //   this.setState({})
    //   window.parentOnStateChange()
    // }
    // this.testMethod()
    window.test = this.testMethod.bind(this)
  }
  testMethod() {
    console.log('crazy method')
    this.setState({})
    window.parentOnStateChange()
  }
  onStateChange() {
    console.log('child onStateChange')
    this.setState({})
  }
  render() {
    console.log('child render')
    return (<div>child</div>)
  }
}
var element = <Parent />
window.listeners = listeners

ReactDOM.render(
  element,
  document.getElementById('root')
)



