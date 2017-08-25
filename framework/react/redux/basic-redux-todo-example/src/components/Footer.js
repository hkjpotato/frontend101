import React from 'react';
import FilterLink from '../containers/FilterLink';

//attention, this is a presentational component that render a container component inside
//Which is fine, since presentational in charge of how UI look, and those UI is an abstract concept
//it can be a HTML node as well as a React Component, and that component could be a container component
//notice that even presentational comp often reads data from props
//they can still have embeded info about how things looks, e.g. Show, All, Active
//they can pass ui embedded props(not related to state) to container comp as well
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

export default Footer;