/*
model is the simple
1. it represents your data in memory
2. it talks to persistent data storage in Storage(database)

In backend, it could be your RESTful API, django model(ORM)...
*/

function Model(storage) {
  this.storage = storage;
}

Model.prototype.create = function (title, callback) {
  log('model create');
  //default value, miss es5 right?
  title = title || '';
  callback = callback || function() {};

  var newItem = {
    title: title.trim(),
    completed: false
  };

  // persistent data storage
  this.storage.save(newItem, callback);
};


Model.prototype.read = function (query, callback) {
  //3 situations
  log('model read ' + JSON.stringify(query));

  //no query, return all
  if (typeof query === 'function') {
    //the passed in is the callback, no query, return all
    return this.storage.findAll(query);
  } else if (typeof query === 'string' || typeof query === 'number') {
    //pass in is id
    query = +query; //convert to a number
    this.storage.find({
      id: query
    }, callback);
  } else {
    // pass in is object for matching
    this.storage.find(query, callback);
  }
};

Model.prototype.update = function (id, data, callback) {
  // given id and data to be updated
  this.storage.save(data, callback, id);
};

Model.prototype.remove = function (id, callback) {
  this.storage.remove(id, callback);
};

Model.prototype.removeAll = function (callback) {
  this.storage.drop(callback);
}

// Model.prototype.getCount = function (callback) {
//   // get count of all todos
//   this.storage.findAll(function (todos) {
//     //callback receives todos from storage
//     var res = todos.reduce(function (count, todo) {
//       if (todo.completed) {
//         count.completed ++;
//       } else {
//         count.active ++;
//       }
//       count.total++;
//       return count;
//     }, {active: 0, completed: 0, total: 0});

//     callback(res);
//   })
// }
