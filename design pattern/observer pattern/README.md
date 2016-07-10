Observer Pattern
=====================
### Illustration

![illustration of oberser pattern](observer.png)


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

### A little more (self-defined event)
Below is an example of self-defined event with a sepecific type

```javascript
//Self-defined
//Subject
var store = {};
//a cache to store the observers(the callbacks from them)
store.clientList = []; //notice that this is an array of array since we want to let observer listen to different types of events.

//function to add observer , the "listen" function
store.addClient = function(key, fn) {
	//use key to differentiate different events(news)
	if (!this.clientList[key]) {
		this.clientList[key] = [];
	}
		this.clientList[key].push(fn);
}

//notify the observers when sth happened
store.trigger = function() {
	//from the arguments, get the type of the event!
	var key = Array.prototype.shift.call(arguments);

	//get the array of observer callbacks corresponding to that event
	var fns = this.clientList[key];

	if (!fns || fns.length == 0) {
		return false;
	}

	for (var i = 0, fn; i < fns.length; i++) {
		fn = fns[i];
		fn.apply(this, arguments);
	}
}

//observer, here we call it Client
function Client(name) {
	this.name = name;
}

Client.prototype.getPrice = function(item, price) {
	console.log(this.name + " receives the price of " + item + " is " + price);
}

var tom = new Client("Tom");
var jerry = new Client("Jerry");

//add observer
store.addClient("coke", tom.getPrice.bind(tom));
store.addClient("cheese", jerry.getPrice.bind(jerry));

//notify the observer
store.trigger("coke", 2);
store.trigger("cheese", 2.5);
```