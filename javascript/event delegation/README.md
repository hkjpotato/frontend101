Event Delegation
=====================
### Illustration

![illustration of oberser pattern](./observer.png)

Read the below two articles to help understand it:
1. [JavaScript Event Delegation is Easier than You Think](https://www.sitepoint.com/javascript-event-delegation-is-easier-than-you-think/)
2. [How JavaScript Event Delegation Works](https://davidwalsh.name/event-delegate)

As the first article from Andrew Tetlaw mentioned:

_"event handlers can potentially cause of memory leaks and performance degradation — the more you have, the greater the risk. JavaScript event delegation is a simple technique by which you add a single event handler to a parent element in order to avoid having to add event handlers to multiple child elements."_

### The Basic
Below is a simple examples for Observer Pattern

#####html
```html
<input id="myBtn" type="button" value="click"></input>
```

#####javascript
```javascript
//the subject
var subject = document.querySelector("#myBtn");

//create observers
var Observer = function(name) {
	this.name = name;
}

Observer.prototype.notify = function() {
	console.log(this.name + " receives notification");
}

var obj1 = new Observer("obj1");
var obj2 = new Observer("obj2");

//observe
subject.addEventListener("click", obj1.notify.bind(obj1));
subject.addEventListener("click", obj2.notify.bind(obj2));
```