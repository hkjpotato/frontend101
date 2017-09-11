/*
This is to init the Todo app, including

1. init the storage (database)
2. init the model (data model to talk to database)
3. init the view (with a simple template engine)
4. init the controller (the tie between view and model)
5. init the url event by hash (in fact, url is part of controller)

*/

function Todo(name) {
  this.storage = new Storage(name);
  this.model = new Model(this.storage);
  this.view = new View();
  this.controller = new Controller(this.model, this.view);
}

var todo = new Todo('kj-simple-todo-mvc');


// //url(hash) is one part of control
window.addEventListener('load', function() {
  todo.controller.setRouteState(document.location.hash);
}, false);

window.addEventListener('hashchange', function() {
  console.log('hash change');
  todo.controller.setRouteState(document.location.hash);
}, false);