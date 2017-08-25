import { connect } from 'react-redux';
import { setVisibilityFilter } from '../actions'
import Link from '../components/Link'

const mapStateToProps = (state, ownProps) => {
  //!important, besides get props for Presentational Component from state
  //Container Comp can also pass children as a props
  //It pass the ownProps(including children) of itself to the Presentational!!!!!!!!
  //https://facebook.github.io/react/docs/higher-order-components.html#convention-pass-unrelated-props-through-to-the-wrapped-component
  //To understand better, this map function is to generate the INJECTEDProp
  //they other props that is not from the store state will still be passed through!!!!
  //HOCs add features to a component. They shouldn't drastically alter its contract. I
  return {
    active: ownProps.filter === state.visibilityFilter,
  }
}

const mapDispatchToProps = (dispatch, ownProps) => {
  return {
    //it should be notice that even though 'filter' is passed through to the presentation
    //the actuall argument to callback to dispatch is here at Container level
    //the only concern is about creating new function as props everytime which may harm the performance
    onClick: () => {
      dispatch(setVisibilityFilter(ownProps.filter))
    }
  }
}

const FilterLink = connect(
  mapStateToProps,
  mapDispatchToProps
)(Link);

export default FilterLink;

