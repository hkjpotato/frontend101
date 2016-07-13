Singleton
=====================
### Illustration

_"You are my only instantiation in this world."_ said a Class, to an Object.

For example, when you click on the login button on the facebook home page, there is a login window pop up. No matter how many times you click the login button, there is always one single unique login window, which is the single object of the login class. (Just an idea, not sure if facebook really design in this way).

### The traditional Object-oriented way
Follow the tradition OO stype (class -> object)

Below are two simple examples to make singleton.

First exampe: instance as a property (like the static variable in java) of the class.

```javascript
var Singleton = function(name) {
	this.name = name;
	this.instance = null;
}

Singleton.prototype.getName = function() {
	console.log(this.name);
}

// notice this is an attribute of the class, not the prototype
// similar to static method in Java
// this attribute is a function that return the only instance of this class
Singleton.getInstance = function(name) {
	if ( !this.instance) {
		this.instance = new Singleton(name);
	}
	return this.instance;
}
var a = Singleton.getInstance("instance1");
var b = Singleton.getInstance("instance2");

if (a === b) {
	console.log(true, a.getName(), b.getName());
}
```
Another exampe: instance as a variable in the closure.

```javascript
var Singleton = function(name) {
	this.name = name;
};

Singleton.prototype.getName = function() {
	console.log(this.name);
}

Singleton.getInstance = (function(name) {
	//create a closure
	var instance = null;
	return function(name) {
		//this function has reference to the variabe inside the closure
		//it will be return to the getInstance attribute
		if (!instance) {
			instance = new Singleton(name);
		}
		return instance;
	}
})();//self-invoked only once, create the only reference to instance

//What is closure? see below
function closure(input) {
	var valueInClosure = 100;
	return var funcInClosure = function() {
		//remember, a function can also access variables defined outside the function
		//in fact, all functions have access to the scope "above" them.
		console.log(valueInClosure);
	}
}
```
Through ```Singleton.getInstance``` method, we can have a singleton pattern. However, this class is not transparent, and the way to get instance is different from the general "new" function.

#### Improved version
Make the singleton class transparent!

```javascript
This is a class to create the unique Login div in the page
var CreateLoginDiv = (function() {
	//closure
	var instance;

	//the return function is a constructor
	var CreateLoginDiv = function(html) {
		//if the variable in the closure has been defined, the constructor return it
		if (instance) {
			return instance;
		}
		//else, construct a new object and assign it to the variable in the closure
		this.html = html;
		console.log(this);
		this.init();
		return instance = this;
	};

	CreateLoginDiv.prototype.init = function() {
		var div = document.createElement('div');
		div.innerHTML = this.html;
		document.body.appendChild(div);
	}

	return CreateLoginDiv;
})();

//we can now do sth like this:
var a = new CreateLoginDiv("facebook Login");
var b = new CreateLoginDiv("another facebook Login");
if (a === b) {console.log(true)};
```


This method also has some problems. The IIFE makes the real constructor method unclear to read. Besides, the contructor here is in charge of doing two things:
```javascript
	var CreateLoginDiv = function(html) {
		if (instance) {
			return instance;
		}
		this.html = html;
		this.init();
		return instance = this;
	};
```

1. First it runs the init function to setup the object
2. second it also needs to check if the instance already exit

In charge of doing two functions is not good for a function, you know 1 + 1 != 1. 
We can further improve it by proxy.

We first make the init function separate from the checking function
```javascript
//I only in charge of init now
var CreateLoginDiv = function(html) {
	this.html = html;
	this.init();
}

CreateLoginDiv.prototype.init = function() {
	var div = document.createElement('div');
	div.innerHTML = this.html;
	document.body.appendChild(div);
}

//Then we can introduce the proxy to do the checking function
var ProxySingletonCreateLoginDiv = (function() {
	var instance;
	return function(html) {
		if (!instance) {
			instance = new CreateLoginDiv(html);
		}
		return instance;
	}
})();
```
you can use the proxy as constructor, though what it returns is technically not created ("new") by itself, but another constructor (CreateLoginDiv).

For more information about proxy, visit the [Proxy Pattern].

### The javascript way
The above code you see is more like the tradition OO language such as Java, where object always comes from class. However, javascript is class-free. You can simply make an object without class, Thus we don't need to follow the traditional OO style.

Remember, the key of Singleton is to ensure there is only one instantiation, and provide global access to it. As a result, a singleton in js can be as simple as declaring a global variable.

```javascript
var a = {};
```
However, we all know that global variable is not good. It might pollute our namespace, and can be easily overwritten by local variables. To reduce the negative effect of global variables, you can try the following two ways:

##### Use proper namespace
```javascript
var namespace1 = {
	a: function() {
		console.log("hello world by ns1");
	},
	b: function() {
		console.log("goodbye world by ns1");
	}
} 
```

Or do it dynamically (quoted from "Object-Oriented Javascript")
```javascript
var myApp = {};

myApp.namespace = function(name) {
	//e.g name = "store.food.meat"
	var parts = name.split("."); //parts = ["store", "food", "meat"]
	var current = myApp;
 	// parts.forEach(function(attr) {
 	// 	if ( !current[attr]) {
 	// 		current[attr] = {}
 	// 	}
 	// 	current = current[attr];
 	// });

 	for (var i in parts) {
 		if (!current[ parts[i] ]) {
 			current[ parts[i] ] = {};
 		}
 		current = current[ parts[i] ];
 	}
}


myApp.namespace("event");
myApp.namespace("dom.style");
```
Oh, here an interesting quetsion will be how to get all names from the object. This is a typical depth-first Search(DFS) question, below is the solution, for more information, go to my link on [Algorithim].
```javascript
var names = [];
function dfs(obj, result, name) {
	var keys = Object.keys(obj);
	if (keys.length == 0) {
		//reach the leaf node, add the name to the result collection
		result.push(name.join("."));
	} else {
		for (var i = 0, key; key = keys[i++];) {
			name.push(key);
			dfs(obj[key], result, name);
			name.pop();
		}
	}
}
dfs(myApp, names, []);
```

##### Use closure to make private variable
```javascript

var user = (function() {
	var _name = "Tom",
		_food = "Jerry";
	return {
		getUserInfo: function() {
			return _name + " eats " + _food;
		}
	}
})();
console.log(user.getUserInfo());
```

### Lazy-loaded Singleton in JS - Singleton initialized on Demand
Say we want to make a button to launch the login window, which is a singleton because no matter how many times you click on the login button, it should only have one login window instance.

Bad Practice, create it when page loaded, and then hide it.

```html
<input id="loginBtn" type="button" value="Log in"></input>
```

```javascript
var loginWindow = (function() {
	var div = document.createElement("div");
	div.innerHTML = "Login Window";
	div.style.display = "none";
	div.setAttribute("id", "login");
	document.body.appendChild(div);
	return div;
})();


document.getElementById("loginBtn").onclick = function() {
	loginWindow.style.display = "block";
}
```
This approach is not good since sometimes user does not needs to login, and the dom node, which always exits, is a waste.

Let's change the code so that the window will only be created when the user click on the "log in" button.

We use the idea of closure here again
```javascript
var createLoginWindow = (function() {
	var div;
	return function() {
		if ( !div ) {
			div = document.createElement("div");
			div.innerHTML = "Login Window";
			div.style.display = "none";
			div.setAttribute("id", "login");
			document.body.appendChild(div);
		}
		return div;
	}
})();

document.getElementById("loginBtn").onclick = function() {
	var loginWindow = createLoginWindow();
	loginWindow.style.display = "block";
}
```
This looks better, but again we are facing the same problems: the createLoginWindow is in charge of two functions, checking singleton and create new object. As mentioned, we want to separate them.

```
logic for checking singleton
	var obj
	if ( !obj ) {
		obj = xxx
	}
```
Below is the general code for getSinglton
```javascript
var getSinglton = function(fn) {
	var result;
	return function() {
		return result || (result = fn.apply(this, arguments));
	}
}

// fn is the function we pass in as a parameter, its duty is to create the object, such as createLoginWindow, createXhr...

var createLoginWindow = function() {
	var div = document.createElement("div");
	div.innerHTML = "Login Window";
	div.style.display = "none";
	div.setAttribute("id", "login");
	document.body.appendChild(div);
	return div;
}



var createSingletonLoginWindow = getSinglton(createLoginWindow);
document.getElementById("loginBtn").onclick = function() {
	var loginWindow = createSingletonLoginWindow();
	loginWindow.style.display = "block";
}

//What's more, getSinglton can also be used to bind the event listener only once.
var bindEvent = getSinglton(function() {
	document.getElementById("bindBtn").addEventListener("click", function() {
		console.log("click");
	});
	return true;
});

var render = function() {
	console.log("rendering...");
	bindEvent();
}

render();
render();
render();
// you can see even though we call rendering 3 times, only one event listener has been bined to the Binding button 
```

