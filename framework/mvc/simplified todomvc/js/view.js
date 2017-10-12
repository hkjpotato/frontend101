/*
View is an abstraction of UI
By abstraction it means
1. it does not expose the actual dom and dom event to external(such as controller)
2. instead, it expose API function 'on' and different render methods
3. 'on' let exteneral bind certain event to certain element
4. render methods let exteneral call the view to render UI based on passed data
5. it use template engine(Template) to talk to html

...notice we use data-id to bind data to the dom for later searching
in d3, we use __data__
in React, we use react-id
*/

// helper function to get parent List Item's data-id
function getListItemId(element) {
  //given a dom element, find its parent li element's id
  if (!element.parentNode) {
    return;
  }
  if (element.parentNode.tagName.toLowerCase() === 'li') {
    return parseInt(element.parentNode.dataset.id, 10);
  } else {
    return getListItemId(element.parentNode);
  }
}

var defaultTemplate
    = '<li data-id="{{id}}" class="{{completed}}">'
    +   '<div class="view">'
    +     '<input class="toggle" type="checkbox" {{checked}}>'
    +     '<label>{{title}}</label>'
    +     '<button class="destroy"></button>'
    +   '</div>'
    + '</li>';

var charToEscape = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    '\'': '&#x27;',
    '`': '&#x60;'
  };

function View() {

  this.ENTER_KEY = 13;
  this.ESCAPE_KEY = 27;

  // View contains different UI doms, assign them here for later reference
  this.todoListDOM = document.querySelector('.todo-list');
  this.footer = document.querySelector('.footer');
  // this.toggleAllCheck = document.querySelector('.toggle-all');
  this.newTodoInput = document.querySelector('.new-todo');

}

//------render function-------
View.prototype.showEntries = function(data) {
  log('view show todos');
  var template = '';

  for (var i = 0; i < data.length; i++) {
    // template engine do this part
    var completed = data[i].completed ? 'completed' : '';
    var checked = data[i].completed ? 'checked' : '';

    //do escape, who know what the user will input, e.g. '>' will mess up your template
    var title = /[$<>"'`]/.test(data[i].title) ? data[i].title.replace(/[$<>"'`]/g, function (char) {
      return charToEscape[char];
    }) : data[i].title;

    var currItemTemplate = defaultTemplate;
    currItemTemplate = currItemTemplate.replace('{{id}}', data[i].id);
    currItemTemplate = currItemTemplate.replace('{{title}}', title);
    currItemTemplate = currItemTemplate.replace('{{completed}}', completed);
    currItemTemplate = currItemTemplate.replace('{{checked}}', checked);
    
    template += currItemTemplate;
  }

  this.todoListDOM.innerHTML = template;
}

View.prototype.clearNewTodo = function () {
  log('view clear input');
  this.newTodoInput.value = "";
}

View.prototype.editItemStart = function (id, title) {
  var listItem = document.querySelector('[data-id="' + id + '"]');
  if (!listItem) {
    return;
  }
  listItem.className = listItem.className + ' editing';

  // create the edit input
  var input = document.createElement('input');
  input.className = 'edit';

  listItem.appendChild(input);
  input.focus();
  input.value = title;
}

// can be trigger by both itemEditDone and itemEditCancel
View.prototype.editItemDone = function (id, title) {
  var listItem = document.querySelector('[data-id="' + id + '"]');

  if (!listItem) {
    return;
  }

  var input = listItem.querySelector('input.edit');
  listItem.removeChild(input);

  listItem.className = listItem.className.replace('editing', '');

  listItem.querySelector('label').textContent = title;
}

// yes, it just remove the child elem
View.prototype.removeItem = function(id) {
  var removeElem = document.querySelector('[data-id="' + id + '"]');
  if (removeElem) {
    this.todoListDOM.removeChild(removeElem);
  }
}

View.prototype.setItemCompleted = function (id, completed) {
  var listItem = document.querySelector('[data-id="' + id + '"]');
  
  if (!listItem) {
    return;
  }

  // update UI
  listItem.className = completed ? 'completed' : '';
};

View.prototype.setFilter = function (route) {
  // update UI
  // clean selected
  document.querySelector('.filters .selected').className = '';
  // set selected
  document.querySelector('.filters [href="#/' + route + '"]').className = 'selected';
};



//---------bind event--------
// binding dom event with callback
// it is still some level of abstraction since view decide what kind of dom event listener
View.prototype.bindNewTodo = function (callback) {
  var self = this;
  //notice change event is happened when focus is blurred
  self.newTodoInput.addEventListener('change', function(event) {
    log('dom input change event');
    callback(self.newTodoInput.value);
  });
};


View.prototype.bindItemEditStart = function (callback) {
  //use event delegation, because the item is added/removed dynamically & save memory
  var self = this;
  this.todoListDOM.addEventListener('dblclick', function(event) {

    var targetElement = event.target;


    if (targetElement.tagName.toLowerCase() === 'label') {
      callback({
        id: getListItemId(targetElement)
      });
    }
  }, false);
}

View.prototype.bindItemEditCancel = function (callback) {
  var self = this;

  this.todoListDOM.addEventListener('keyup', function(event) {
    var targetElement = event.target;
    if (targetElement.classList.contains('edit')) {
      if (event.keyCode === self.ESCAPE_KEY) {
        // evil, use dataset here as a flag, so ItemEditDone(by blur event) knows it is blurred due to cancel
        targetElement.dataset.iscanceled = true;
        // trigger the blur effect, will trigger blur event but since iscanceled, nothing happen
        targetElement.blur();

        // still need to trigger the callback
        callback({
          id: getListItemId(targetElement)
        });
      }
    }
  }, false);
}

View.prototype.bindItemEditDone = function (callback) {
  var self = this;
  //https://developer.mozilla.org/en-US/docs/Web/Events/blur
  this.todoListDOM.addEventListener('blur', function (event) {
    var targetElement = event.target;
    if (targetElement.classList.contains('edit')) {
      if (!this.dataset.iscanceled) {
        // only if the blur is not trigger by cancel, we call editDone's callback
        callback({
          id: getListItemId(targetElement),
          title: targetElement.value
        });
      }
    }
  }, true); //capture phase

  // alow click enter to finish editing
  this.todoListDOM.addEventListener('keypress', function (event) {
    var targetElement = event.target;
    if (targetElement.classList.contains('edit')) {
      if (event.keyCode === self.ENTER_KEY) {
        targetElement.blur(); //trigger blur event
      }
    }
  }, false)
}

View.prototype.bindItemRemove = function (callback) {
  //use event delegation, because the item is added/removed dynamically & save memory
  var self = this;
  this.todoListDOM.addEventListener('click', function(event) {
    var targetElement = event.target;
    if (targetElement.classList.contains('destroy')) {
      callback({
        id: getListItemId(targetElement)
      });
    }
  }, false);
}

// ui event => controller callback 
// => model method => db update => ui update
View.prototype.bindItemToggle = function (callback) {
  //use event delegation, because the item is added/removed dynamically & save memory
  var self = this;
  this.todoListDOM.addEventListener('click', function(event) {
    var targetElement = event.target;
    if (targetElement.classList.contains('toggle')) {
      callback({
        id: getListItemId(targetElement),
        completed: targetElement.checked
      });
    }
  }, false);
}

