//storage is your persistent data source, the data base

function Storage(name) {
  this._dbName = name;

  if (!localStorage[name]) {
    localStorage[name] = JSON.stringify({todos: []});
  }
}

Storage.prototype.find = function (query, callback) {
  if (!callback) {
    return;
  }
  var todos = JSON.parse(localStorage[this._dbName]).todos;
  //why use call instead of just ()...
  callback.call(this, todos.filter(function (todo) {
    //compare
    for (var key in query) {
      if (query[key] !== todo[key]) {
        return false;
      }
    }
    return true;
  }));
};

Storage.prototype.findAll = function (callback) {
  callback = callback || function() {};
  callback.call(this, JSON.parse(localStorage[this._dbName]).todos);
};


Storage.prototype.save = function (updated, callback, id) {
  var data = JSON.parse(localStorage[this._dbName]);
  var todos = data.todos;
  if (!id) {
    // create new todo with passed in data
    updated.id = new Date().getTime();
    todos.push(updated);

    localStorage[this._dbName] = JSON.stringify(data);
    callback.call(this, [updated]);
  } else {
    // update current
    for (var i = 0; i < todos.length; i++) {
      if (todos[i].id === id) {
        Object.keys(updated).reduce(function (todo, key) {
          todo[key] = updated[key];
        }, todos[i]);
        break;
      }
    }
    // save back
    localStorage[this._dbName] = JSON.stringify(data);
    callback.call(this, JSON.parse(localStorage[this._dbName]).todos);
  }
};


Storage.prototype.remove = function (id, callback) {
  var data = JSON.parse(localStorage[this._dbName]);
  var todos = data.todos;
  for (var i = 0; i < todos.length; i++) {
    if (todos[i].id === id) {
      todos.splice(i, 1);
      break;
    }
  }

  localStorage[this._dbName] = JSON.stringify(data);
  callback.call(this, JSON.parse(localStorage[this._dbName]).todos);
};


Storage.prototype.drop = function (callback) {
  var data = {todos: []};
  //overwrite the localStorage with empty list
  localStorage[this._dbName] = JSON.stringify(data);
  callback.call(this, data.todos);
};