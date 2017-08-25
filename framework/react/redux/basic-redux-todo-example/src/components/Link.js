import React, { PropTypes } from 'react';

const Link = ({active, children, onClick}) => {
  if (active) {
    return <span>{children}</span>
  }
  return (
    <a 
      href="#"
      onClick={e=>{
        e.preventDefault();
        onClick();
      }}
    >
     {children}
    </a>
  )
}

Link.propTypes = {
  active: PropTypes.bool.isRequired,
  children: PropTypes.node.isRequired, //Anything that can be rendered: numbers, strings, elements or an array
  onClick: PropTypes.func.isRequired
}

export default Link;