/*
Understand mapStateToProps and connect
data flow

1. target is presentational component, it just render the props it received
2. it get the props from the container component

container component get this props from the state in store.

question is, how does container component fetch those state
and does it store it locally or does the container component just pass it to presentational component?

//an HOC composes the original component by wrapping it in a container component. 
An HOC is a pure function with zero side-effects.

//but let's forget about HOC for a while, lets focus on container component
*/


//a simple presentaional
class Show extends React.Component {
  render() {
    const {value} = this.props;
    return (
      <div>{value}</div>
    )
  }
}


//a hand made container
class ValueContainer extends React.Component {
  render() {
    const injectedProps = {
      value: 100
    }
    //the question is where does this injectedProps comes from

    // //it could come from self props
    // const injectedProps = {
    //   ...this.props,
    // }

    // //it could come from self state
    // const injectedProps = {
    //   ...this.state,
    // }

    // //it could come from a function in the current scope
    // const injectedProps = getInjectedProps(this.props); 
    return (
      <Show {...injectedProps} />
    )
  }
}

//remember container component is just a component show it can have state and props
<ValueContainer sth={100} />

