Observer Pattern
=====================
### Illustration

![illustration of oberser pattern](./observer.png)


### The Basic
Below is a simple examples for Observer Pattern

html
```html
<input id="myBtn" type="button" value="click"></input>
```

javascript
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
Below is an example of self-defined event with a specific type.

```javascript
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

Client.prototype.getPrice = function(price) {
	console.log(this.name + " receives price is " + price);
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
Notice it's difference from a traditional callback
```javascript
(function success() {
	data = {
		coke: 2,
		cheese, 2.5
	}
	tom.getPrice(data["coke"]);
	jerry.getPrice(data["cheese"]);

})();
```
For a callback mode, you need to call the callback function of each observer by yourself(store). The subject needs to know about the observers and even the details such as the name of the specific callback function. For an observer mode, subject only needs to trigger the event, then it will launch the callbacks from the observers automatically. The subject does not need to know anything about the observer.

### A complete implementation
Make the event listen system an interface.

```javascript
//Make the observer function as an object, so it can be applied to different subjects who implement it (like an interface in java)
//we call it event object/interface
var event = {
	clientList: [], //previously, the clientList is an property of a specific subject
	listen: function(key, fn) {
		//key is the type of the event, fn is the callback from observer
		if (!this.clientList[key]) {
			this.clientList[key] = [];
		}
		this.clientList[key].push(fn);
	}, //the listen function is the same as the addClient
	trigger: function() {
		var key = Array.prototype.shift.call(arguments);
			fns = this.clientList[key];

		if (!fns || fns.length == 0) {
			return false;
		}

		for (var i = 0; i < fns.length; i++) {
			var fn = fns[i];
			fn.apply(this, arguments); //yes, we apply 'this' when trigger the observer's callback. 'this' means the subject here. That's why when the button trigger the event, you will find the the callback function from listener refers 'this' to the button!!!
		}
	},
	remove: function(key, fn) {
		//a method to stop a callback from observer
		//get the callback list corresponding to the key
		var fns = this.clientList[key];
		console.log("here");

		console.log(fns);

		if (!fns || fns.length == 0) {
			return false;
		}

		if (!fn) {
			//if no specifc call is defined, delete all the callbacks corresponding to the key
			fns && (fns.length = 0); //ensure fns still exit at this point
		} else {
			for (var l = fns.length - 1; l >=0; l--) {
				//backward check
				var _fn = fns[l];
				if ( _fn === fn) {
					console.log("find it", fn, fns[l]);
					fns.splice(l, 1);
				}
			}
		}
	}
}

//define an installEvent function to implement the event obj, which is similar to "implements" in java
function installEvent(obj) {
	//get all properties of event obj
	for (var key in event) {
		obj[key] = event[key];
	}
}
```
The above example has some defaults. For example, observers(tom and jerry) need to know the name of the subject(store) so as to listen to a specific event. Besides, each subject(store) needs to maintain its own clientList. To solve that, we can create a middleware, which is a global Event system.

```javascript
var Event = (function(){
	//create a closure using IIFE(immediately-invoked function)
	var clientList = {}, //clientList as a map
		listen,
		trigger,
		remove;

	listen = function(key, fn) {
		if (!clientList[key]) {
			clientList[key] = [];
		}
		clientList[key].push(fn);
	};

	trigger = function() {
		var key = Array.prototype.shift.call(arguments),
			fns = clientList[key];
		if (!fns || fns.length === 0) {
			return false;
		}
		for (var i = 0; i < fns.length; i++) {
			var fn = fns[i];
			fn.apply(this, arguments);
		}
	};

	remove = function(key, fn) {
		var fns = clientList[key];
		if (!fns) {
			return false;
		}
		if (!fn) {
			fns && (fns.length = 0);
		} else {
			for (var l = fns.length; l >= 0; l--) {
				if (fns[l] === fn) {
					fns.splice(l, 1);
				}
			}
		}
	}

	return {
		listen: listen,
		trigger: trigger,
		remove: remove
	}
})();

var store = {
	"coke": 2.5,
	"cheese": 2
}

var tom = {
	name: "tom",
	getCokePrice: function(price) {
		console.log("coke price is " + price)
	}
}

//now the subject and observer don't need to know each other
var eventName = "coke";
Event.listen("coke", tom.getCokePrice.bind(tom));
Event.trigger("coke", store["coke"]);
```
However, the global middleware has some defaults as well. The relationship between observer and subject is hided behind the scene, and thus, we might lose the control over data flow when the system becomes big, and maintenance can be difficult.

I believe this has sth to do with the traditional MVC model and the newly occurred flux model. However, at this moment, I am not quite sure about it. Is the flux model more like a global event system? Let's see... (I will update it when I complete the MVC and Flux framework parts).

Another consideration here is: what if the event is triggered before an observer listens to that subject? This is possible in real world application. For example, say we need to load the user information to render an naviagtion bar (such as the avatar) of the page. We use ajax to fetch the user's information when the user login. When the ajax call successes, an event will be triggerred so that the navigation bar, which listens to this ajax call, can start render itself. However, there is a chance that when the ajax call successes and triggers the event, the code of the navigation bar hasn't be loaded completely, and it hasn't listened to the subject(ajax call). 

In this case, the solution is that when the event is triggered, but no observer has listenered to it, the subject should store the event trigger function in a stack. Later, when the subject gets a new observer, it can traverse the stack and trigger the event.