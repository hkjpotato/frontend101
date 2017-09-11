Hello World MVC
=====================
Here are some simple examples for MVC in plain JS from "Hello World" to "TodoMVC"

### The Basic
Below is the simplest example of MVC I have found from StackOverflow By [Raynos](http://stackoverflow.com/questions/8497833/hello-world-in-mvc-pattern)

#### html
```html
<input id="myBtn" type="button" value="click"></input>
```

#### javascript
```javascript
var Model = {}, View = {}, Controller = {};

// Model manage the data source
Model.data = "Hello World";

// View render the data
View.render = function(data) { console.log(data); }

// Controller ties Model and View
Controller.handleClick = function(event) {
	var data = Model.data;
	V.render(data);
}

document.getElementById("myBtn").addEventListener("click", Controller.handleClick);
```
As Raynos mentioned:

_"Controller (C) listens on some kind of interaction/event stream._

_Model (M) is an abstraction of a data source._

_View (V) knows how to render data from the Model._

_The Controller tells to View to do something with something from the Model._

_In this example_

 1. _the View knows nothing about the Model apart from it implements some interface_
 2. _the Model knows nothing of the View and the Controller_
 3. _the Controller knows about both the Model and the View and tells the View to go do something with the data from the Model."_

### A little more
The more complete example with the Object-oriented design approach is shown below, which includes the idea of "class" and "object". The MVC are separate and abstract to each other.

#### html
```html
<input type="text" />
<input type="button" value="add"></input>
<span id="display"></span>
```

#### javascript
```javascript
//------------Database-----------------
var Storage = function(data) {
	this.data = data;
}

Storage.prototype.fetchData = function(callback) {
	console.log("fetch in the storage");
	callback.call(this, this.data);
}

Storage.prototype.saveData = function(data, callback) {
	console.log("save in the storage");
	this.data.push(data);
	callback.call(this, [this.data]);
}

//------------Model-----------------
var Model = function(storage) {
	this.data = null;
	this.storage = storage;
}
Model.prototype.read = function(callback) {
	console.log("read in the model");
	this.storage.fetchData(callback);
}

Model.prototype.create = function(data, callback) {
	console.log("create in the model");
	this.storage.saveData(data, callback);
}

//------------View-----------------
var View = function() {
	this.display = document.querySelector("#display");
	this.button = document.querySelector("input[type='button']");
	this.input = document.querySelector("input[type='text']");
}

View.prototype.render = function(data) {
	console.log("render in the view");
	this.display.innerHTML = data;
}

View.prototype.bind = function(event, handler) {
	var self = this;
	if (event == "add") {
		self.button.addEventListener("click", function() {
			console.log("click in the view");
			handler(self.input.value);
		});
	} else {
		console.log("this event is not supported!");
	}
}

//------------Model-----------------
var Controller = function(V, M) {
	var self = this;
	self.model = M;
	self.view = V;
	self.view.bind("add", function(data) {
		self.add(data);
	});
}

Controller.prototype.show = function() {
	console.log("show in the controller");
	var self = this;
	self.model.read(function(data) {
		self.view.render(data);
	});
}

Controller.prototype.add = function(data) {
	//handler's logic is here
	console.log("add in the controller");
	var self = this;
	self.model.create(data, function() {
		self.show();
	});
}

//------------Setup-----------------
var view = new View();
var model = new Model(new Storage([]));
var controller = new Controller(view, model);
```

I add some logs to console so as to show the data flow of the application. 

```
	click in the view
	add in the controller
	create in the model
	save in the storage
	show in the controller
	read in the model
	fetch in the storage
	render in the view
```

As you can see: When the view detect a click event, it will triggers controller's "add" method. The add method will call the model's "create" method, which will "save" the passed in data in the storage. Once this action is finished, the callback will be triggered, which calls the controller's "show" method. It will call the model's "read" method to "fetch" data from storage, and pass it to the callback, so as to "render" the view.


### Next
 1. [Simplified TodoMVC](../simplified todomvc)
 2. with backend, check [here](https://www.codeproject.com/Articles/753724/JavaScript-Front-End-Web-App-Tutorial-Part)
