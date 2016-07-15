#view.js
This is the "View" of the MVC framework. Remember that in the basic tutorial, I am not sure who should be in charge of binding the event from the UI. Here we have the answer:

Here, view abstracts away the browser's DOM completely by using the template.js.

It has two simple entry points (interface):
   *. bind(eventName, handler)
      Takes a todo application event and registers the handler
   *. render(command, parameterObject)
      Renders the given command with the options
 
Notice that the todo application "event" is not a "click" event from the UI. It is more like a self-defined observer pattern.

##Points to know


####data-id

```javascript
	var listItem = qs('[data-id="' + id + '"]');
```
Use the data-id attribute to store the key with the dom element, that's how we identify and select a todo list item.

####viewCmd

```javascript
	View.prototype.render = function (viewCmd, parameter) {
		var self = this;

		var viewCommands = {
			showEntries: function () {
				self.$todoList.innerHTML = self.template.show(parameter);
			},
			removeItem: function () {
				self._removeItem(parameter);
			},
			updateElementCount: function () {
				self.$todoItemCounter.innerHTML = self.template.itemCounter(parameter);
			},
			
			... ...

		}

		viewCommands[viewCmd]();
	}

```

The View layer implements its render function with input from Controller. This input is so called "viewCmd", which corresponding to different methods (strategies) to render the UI.

#### "bind"

```javascript
	View.prototype.bind = function (event, handler) {
		var self = this;
		if (event === 'newTodo') {
			$on(self.$newTodo, 'change', function () {
				handler(self.$newTodo.value);
			});
			
		} else if (event === 'removeCompleted') {
			$on(self.$clearCompleted, 'click', function () {
				handler();
			});

		} else if (event === 'toggleAll') {
			$on(self.$toggleAll, 'click', function () {
				handler({completed: this.checked});
			});

		... ...
	}
```
The View want to let the Controller to register some event listeners on the UI. However, instead of exposing the specific UI element, such as $newTodo (get by querySelector(".new-todo")), it provides a "bind" method to the Controller. Controller only needs to know the event name to bind the callback function to it, but it does not need to know which element it is binded to. Highly abstract!

