// const src = require('./../images/google_logo1600.png');
// console.log(src);

export default (text = 'Hello world!') => {
  const element = document.createElement('div');

  element.innerHTML = text;

  return element;
};