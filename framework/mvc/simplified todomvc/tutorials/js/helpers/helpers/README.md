#helpers/helpers.js
It is not related to MVC framework, just some helpers function to wrap the querySelector and event attach functions.

##Explanation

```javascript
(function(window) {
	'use strict'
	//the code
})(window);
```
The above code is an IIFE which create a private scope, the use of "use strict" defines that within this function, JavaScript code should be executed in ["strict mode"](http://www.w3schools.com/js/js_strict.asp). With strict mode, you can not, for example, use undeclared variables. This will ensure everything in the scope is private and won't pollute the global namespace. However, it pass in window as a parameter to access those private function.

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


```javascript
	// Allow for looping on nodes by chaining:
	// qsa('.foo').forEach(function () {})
	NodeList.prototype.forEach = Array.prototype.forEach;
```

Why is NodeList not an Array?(from [MDN](https://developer.mozilla.org/en-US/docs/Web/API/NodeList#Why_is_NodeList_not_an_Array))

NodeList are used very much like arrays and it's tempting to invoke Array.prototype methods on them, however NodeList objects don't have any of the familiar Array methods.

JavaScript has an inheritance mechanism based on prototypes for both built–in objects (like Arrays) and host objects (like NodeLists). Array instances inherit array methods (such as forEach or map) because their prototype chain looks like the following:

```myArray --> Array.prototype --> Object.prototype --> null (The prototype chain of an object can be obtained by calling Object.getPrototypeOf several times.)```

forEach, map and the likes are own properties of the Array.prototype object.

Unlike arrays, NodeList prototype chain looks like the following:

```myNodeList --> NodeList.prototype --> Object.prototype --> null```

NodeList.prototype contains the item method, but none of the Array.prototype methods, so they cannot be used on NodeLists.