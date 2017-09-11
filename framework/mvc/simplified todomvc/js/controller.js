function Controller(model, view) {
  this.model = model;
  this.view = view;

  var self = this;

  //when we init the controller, we bind view's event to the controller's methods
  this.view.bindNewTodo(function (title) {
    //new todo enter(change)
    self.addItem(title);
  });

  this.view.bindItemEditStart(function (item) {
    //trigger label dbclick
    self.editItemStart(item.id);
  });

  this.view.bindItemEditCancel(function (item) {
    // esc on edit input
    self.editItemCancel(item.id);
  });

  this.view.bindItemEditDone(function (item) {
    // blur (or enter key=>blur) on edit input
    self.editItemSave(item.id, item.title);
  });

  this.view.bindItemRemove(function (item) {
    // .destroy click
    self.removeItem(item.id);
  });

  this.view.bindItemToggle(function (item) {
    // .toggle check click
    self.toggleComplete(item.id, item.completed);
  });
}

/*
Controller controls the state, including the state in url
The only route related state is filter
@param {string} '' | 'active' | 'completed'
*/
Controller.prototype.setRouteState = function (locationHash) {
  // the route
  var route = locationHash.split('/')[1];
  // the route related state
  route = route || ''; //route could be undefined
  this.updateFilterState(route);
}

Controller.prototype.updateFilterState = function(route) {
  // store the filter state
  this.filter = route === '' ? 'all' : route; 
  this.filterTodos();

  this.view.setFilter(route);
}

/*
Filter todos based on route
*/
Controller.prototype.filterTodos = function (itemAdded) {
  var filter = this.filter;

  /*
  notice this is a heavy duty, so when we need to re-render filtered todos?

  if lastFilter is not all, then we must re-render
  if lastFilter is different from current filter, then we must re-render
  
  in case of previous is all and current is all, no need to re-render
  this is because those UI update is handled in item level (e.g. removeItem, toggleComplete, )

  there is one case we need to force re-render: addItem
  the UI does not insert the item directly, the new item (when show all/active) get displayed through this total re-render
  */
  if (itemAdded || this.lastFilter !== 'all' || this.lastFilter !== filter) {
    var self = this;
    if (filter === 'all') {
      self.model.read(function (data) {
        self.view.showEntries(data);
      });
    } else if (filter === 'active') {
      self.model.read({ completed : false }, function (data) {
        self.view.showEntries(data);
      });
    } else {
      self.model.read({ completed : true}, function (data) {
        self.view.showEntries(data);
      })
    }
  }

  // for later comparison
  this.lastFilter = filter;
}


Controller.prototype.addItem = function (title) {
  var self = this;
  if (title.trim() === '') {
    return; //add nothing
  }
  self.model.create(title, function () {
    // call UI update
    self.view.clearNewTodo();
    self.filterTodos(true);
  });
};

Controller.prototype.editItemStart = function (id) {
  var self = this;
  self.model.read(id, function (data) {
    self.view.editItemStart(id, data[0].title);
  });
};


Controller.prototype.editItemSave = function (id, title) {
  var self = this;
  title = title.trim();

  if (title.length !== 0) {
    self.model.update(id, {title: title}, function () {
      self.view.editItemDone(id, title);
    });
  } else {
    self.removeItem(id);
  }
};

Controller.prototype.editItemCancel = function (id) {
  var self = this;
  self.model.read(id, function (data) {
    // cancel is another form of edit done(done without change)
    self.view.editItemDone(id, data[0].title);
  });
};


Controller.prototype.removeItem = function (id) {
  var self = this;
  self.model.remove(id, function () {
    self.view.removeItem(id);
  });
  //may need to trigger re-render
  self.filterTodos();
};


Controller.prototype.toggleComplete = function (id, completed) {
  var self = this;
  // first update data
  self.model.update(id, {completed: completed}, function (data) {
    self.view.setItemCompleted(id, completed);
  });

  self.filterTodos();
};


