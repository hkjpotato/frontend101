# Simplified TodoMVC

This is the simplified version of the Vanilla JS code from [todomvc.com](http://todomvc.com/). I believe this is the most simplified version you can find on the web. The original source code is [here](https://github.com/tastejs/todomvc/tree/gh-pages/examples/vanillajs).

There are some basic things you need to know to help understand the [source code]((https://github.com/tastejs/todomvc/tree/gh-pages/examples/vanillajs).



## template.js
This is a helper file for the "View" part of the application. It helps to make writing html in js in a much easier way by providing template HTML string for the common elements (e.g. todo list item).

### EscapeHTML
```javascript
	var htmlEscapes = {
		'&': '&amp;',
		'<': '&lt;',
		'>': '&gt;',
		'"': '&quot;',
		'\'': '&#x27;',
		'`': '&#x60;'
	};

	var escapeHtmlChar = function (chr) {
		return htmlEscapes[chr];
	};
```
Without transferring the escape html, you can not use "<" in your title properly. 

Say I want to have a h1 element with text <My Book>. You can not do the following
```javascript
	text.innerHTML = "<My Book>";
```
Instead, you have to do
```javascript
	text.innerHTML = "&lt;My Book&gt;";
```

### Regex

```javascript
	var reUnescapedHtml = /[&<>"'`]/g;
	var reHasUnescapedHtml = new RegExp(reUnescapedHtml.source);

	var escape = function (string) {
		return (string && reHasUnescapedHtml.test(string))
			? string.replace(reUnescapedHtml, escapeHtmlChar)
			: string;
	};
```

Use [Regex](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/RegExp) to help search for the escapeHTML characters and replace them with proper format.

Together with the regex, we are able to create the html code for the list items easily. Notice only the "title" part needs to run the escapeHTML test. As the comment mentioned, _In real life you should be using a templating engine such as Mustache or Handlebars, however, this is a vanilla JS example._

## helpers.js
This file is not directly related to MVC framework. They are just some helper functions to wrap the querySelector and event attach functions, but they are important to make the code works.

### IIFE
```javascript
(function(window) {
	'use strict'
	//the code
})(window);
```
The above code is an IIFE which create a private scope, the use of "use strict" defines that within this function, JavaScript code should be executed in ["strict mode"](http://www.w3schools.com/js/js_strict.asp). With strict mode, you can not, for example, use undeclared variables. This will ensure everything in the scope is private and won't pollute the global namespace. However, it pass in window as a parameter to access those private function.

### Shortcut Functions
```javascript
	// Get element(s) by CSS selector:
	// scope here can be a parent dom node
	window.qs = function (selector, scope) {
		return (scope || document).querySelector(selector);
	};
	window.qsa = function (selector, scope) {
		return (scope || document).querySelectorAll(selector);
	};

	// addEventListener wrapper:
	window.$on = function (target, type, callback, useCapture) {
		target.addEventListener(type, callback, !!useCapture);
	};

	// Find the element's parent with the given tag name:
	// $parent(qs('a'), 'div');
	window.$parent = function (element, tagName) {
		if (!element.parentNode) {
			return;
		}
		if (element.parentNode.tagName.toLowerCase() === tagName.toLowerCase()) {
			return element.parentNode;
		}
		return window.$parent(element.parentNode, tagName);
	};
```

The above codes are wrappers for the native function. They serves as shortcuts for the native functions, thus you don't need to write long code everytime (e.g. ```document.getElementById()```.

### Event delegation
```javascript
	// Attach a handler to event for all elements that match the selector,
	// now or in the future, based on a root element
	window.$delegate = function (target, selector, type, handler) {
		function dispatchEvent(event) {
			var targetElement = event.target;
			var potentialElements = window.qsa(selector, target);
			//notice that NodeList does not have array function by itself
			var hasMatch = Array.prototype.indexOf.call(potentialElements, targetElement) >= 0;

			if (hasMatch) {
				handler.call(targetElement, event);
			}
		}

		// https://developer.mozilla.org/en-US/docs/Web/Events/blur
		//if event type is blur or focus, use capture phase to detect those event.
		var useCapture = type === 'blur' || type === 'focus';

		window.$on(target, type, dispatchEvent, useCapture);
	};
```

This is what I want most important code for this js file. It uses event delegation technique to handle event from dom list. Thus later when you dynamically add and remove todo item, you don't need to worry about adding/removing event listeners.

Remember that for "focus" and "blur" event, they don't have the bubbling phase and thus it set the useCapture to be true to detect those two events.

### NodeList

Why is NodeList not an Array?(from [MDN](https://developer.mozilla.org/en-US/docs/Web/API/NodeList#Why_is_NodeList_not_an_Array))

NodeList are used very much like arrays and it's tempting to invoke Array.prototype methods on them, however NodeList objects don't have any of the familiar Array methods.

## view.js
This is the "View" of the MVC framework. Remember that in the basic tutorial, I am not sure who should be in charge of binding the event from the UI. Here we have the answer:

Here, view abstracts away the browser's DOM completely by using the template.js.

It has two simple entry points (interface):
   1. bind(eventName, handler)
      Takes a todo application event and registers the handler
   2. render(command, parameterObject)
      Renders the given command with the options
 
Notice that the todo application "event" is not a "click" event from the UI. It is more like a self-defined observer pattern.

### data-id

```javascript
	var listItem = qs('[data-id="' + id + '"]');
```
Use the data-id attribute to store the key with the dom element, that's how we identify and select a todo list item.

### viewCmd

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

### "bind"

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
