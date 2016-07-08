Hello World MVC
=====================
Here are some simple examples for MVC in plain JS from "Hello World" to "TodoMVC"

### The Basic
Below is the simplest example of MVC I have found from StackOverflow By [Raynos](http://stackoverflow.com/questions/8497833/hello-world-in-mvc-pattern)

  html
```html
<input id="myBtn" type="button" value="click"></input>
```
#####javascript
```javascript
var M = {}, V = {}, C = {};

M.data = "Hello World";
V.render = function(M) { console.log(M.data); }

C.handleClick = function() {
  V.render(M);
}

document.getElementById("myBtn").addEventListener("click", C.handleClick);
```
As Raynos mentioned:

"Controller (C) listens on some kind of interaction/event stream.

Model (M) is an abstraction of a data source.

View (V) knows how to render data from the Model.

The Controller tells to View to do something with something from the Model.

In this example

the View knows nothing about the Model apart from it implements some interface
the Model knows nothing of the View and the Controller
the Controller knows about both the Model and the View and tells the View to go do something with the data from the Model."

### A little more
The code above is improved with the Object-oriented design approach, which includes the idea of "class" and "object" for MVC. Standard accessors/mutators are introduced to the data layer (Model) to makes it look more similar to the general MVC framework. Notice the "bind" function when binding the callback to the button, since "this" is sensitive to the context. (Without the "bind" function, "this" is actually refering to the button not the controller when invoked);

```html
<input id="myBtn" type="button" value="click"></input>
<span id="data"></span>
```
```javascript
//Define MVC classes
var Model, View, Controller;

Model = function() {
	this.data = null;
}

Model.prototype.setData = function(data) {
	this.data = data;
}

Model.prototype.getData = function() {
	return this.data;
}

View = function() {
	this.data = document.getElementById("data");
}

View.prototype.update = function(M) {
	this.data.innerHTML = M.getData();
}

Controller = function(M, V) {
	this.model = M;
	this.view = V;
}

Controller.prototype.handleClick = function() {
	console.log(this);
	this.view.update(this.model);
}

//create Objects
var hwModel = new Model();
hwModel.setData("Hello World");

var hwView = new View();

var hwController = new Controller(hwModel, hwView);

document.getElementById("myBtn").addEventListener("click", hwController.handleClick.bind(hwController));
```

#H1
##H2
###H3
#H1
Hello
=======
```html
<div></div>
```
	```html
	<div></div>
	```

