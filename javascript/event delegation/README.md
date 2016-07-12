Event Delegation
=====================
### Illustration

Read the below two articles to help understand it:

1. [JavaScript Event Delegation is Easier than You Think](https://www.sitepoint.com/javascript-event-delegation-is-easier-than-you-think/)
2. [How JavaScript Event Delegation Works](https://davidwalsh.name/event-delegate)

And know about the dom event life cycle, [bubbling and capturing](http://javascript.info/tutorial/bubbling-and-capturing), is essential to understand this topic.

As the first article from Andrew Tetlaw mentioned:

_"event handlers can potentially cause of memory leaks and performance degradation — the more you have, the greater the risk. JavaScript event delegation is a simple technique by which you add a single event handler to a parent element in order to avoid having to add event handlers to multiple child elements."_

How it works?

1. attach a single event handler to the parent element.
2. use event.target to determine which element the event originated.

### The Code

[Live Demo](http://codepen.io/hkjpotato/pen/yJPYBN)


#####html & css
We have two mother divs with 3 child divs, when user click on the child div, we want to highlight it by changing its color to yellow for 1 second. We can use two approaches to do that:

1. Attach event listener to each child div.
2. Only attach one event listener to the parent node (mother div).

```html
<div id="mother1" class="mother">
	mother1
	<div class="child"> child1</div>
	<div class="child"> child2</div>
	<div class="child"> child3</div>
</div>
<div id="mother2" class="mother">
  mother2
	<div class="child"> child1</div>
	<div class="child"> child2</div>
	<div class="child"> child3</div>
</div>
```

```css
.mother {
	width: 380px;
	height: 380px;
	background-color: pink;
	border: 1px solid black;
	margin: 10px;
	float: left;
}

.mother>.child {
	width: 100px;
	height: 100px;
	background-color: red;
	border: 1px solid black;
	margin: 10px;
}
```

#####javascript
Shared function for both approaches: the highlight function.
```javascript
//shared function
//highlight the div for 1 second 
function highlight (div) {
	var currentColor = div.style.backgroundColor;
	div.style.backgroundColor = "yellow";
	setTimeout(function() {
		div.style.backgroundColor = currentColor;
	}.bind(div), 1000);
}
```

For mother1, attach event listener to each child.
```javascript
//For Mother1
//get all child elements.
var childrenOfMother1 = document.querySelectorAll("#mother1 .child");
//for each element, register for the event with a callback.
Array.prototype.forEach.call(childrenOfMother1, function(child) {
	child.addEventListener("click", function(e) {
		e = e || event;
		// e = e || event; is a standard way of saying "if the parameter was not passed, default it to whatever's after the ||". In this case, if the event parameter is not passed, then it looks for the global variable.
		highlight(this);
	});
});
```

For mother2, only attach one event listener to the parent node, and check the target event to decide the action.
```javascript
//For Mother2
//private function to get the target element of an event
function getEventTarget(e) {
	e = e || window.event;
	return e.target || e.srcElement;
	// srcElement property in Internet Explorer and the target property in other browsers.
}

//only need to register one callback for the mother elemengt
var mother2 = document.querySelector("#mother2");
mother2.addEventListener("click", function(e) {
	var target = getEventTarget(e);
	//check whether the target element is the desired one
	console.log(target.getAttribute("class"));
	if (target.getAttribute("class") === "child") {
		highlight(target);
	}
});
```

The event delegation does has some pros and cons, and I quote Andrew's summary here:

Pros:
 * __There are less event handlers to setup and reside in memory__. This is the big one; better performance and less crashing.
 * There’s no need to re-attach handlers after a DOM update. If your page content is generated dynamically, via Ajax for example, you don’t need to add and remove event handlers as elements are loaded or unloaded.

Cons:
 * There’s a risk your event management code could become a performance bottleneck, so keep it as lean as possible.
 * Not all events bubble. The __blur, focus, load and unload__ events don’t bubble like other events. The blur and focus events can actually be accessed using the capturing phase (in browsers other than IE) instead of the bubbling phase but that’s a story for another day.
 * You need caution when managing some mouse events. If your code is handling the mousemove event you are in serious risk of creating a performance bottleneck because the mousemove event is triggered so often. The mouseout event has a quirky behaviour that is difficult to manage with event delegation.

Notice the second point of the cons: not all event can bubble (```event.bubbles == false```). This is why in the vanillas js code for todoMVC, you can see it actually set the useCapture to be true for focus and blur event so as to capture the event.

```javascript
	window.$delegate = function (target, selector, type, handler) {
		function dispatchEvent(event) {
			var targetElement = event.target;
			var potentialElements = window.qsa(selector, target);
			var hasMatch = Array.prototype.indexOf.call(potentialElements, targetElement) >= 0;

			if (hasMatch) {
				handler.call(targetElement, event);
			}
		}

		// https://developer.mozilla.org/en-US/docs/Web/Events/blur
		var useCapture = type === 'blur' || type === 'focus'; //if the event is blur or focus, use capturing stage to catch the event.

		window.$on(target, type, dispatchEvent, useCapture);
	};
```
