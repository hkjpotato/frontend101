Hello World MVC
=====================
Here are some simple examples for MVC in plain JS from "Hello World" to "TodoMVC"

### The Basic
Below is the simplest example of MVC I have found from StackOverflow By [Raynos](http://stackoverflow.com/questions/8497833/hello-world-in-mvc-pattern)

#####html
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
The code above is improved with the Object-oriented design approach, which includes the idea of "class" and "object". Notice the "bind" function when binding the callback to the button, since "this" is sensitive to the context. (Without the "bind" function, "this" is actually refering to the button, instead of the controller, when invoked);

#####html
```html
<input id="myBtn" type="button" value="click"></input>
<span id="data"></span>
```

#####javascript
```javascript
//Define MVC
var Model, View, Controller;

//database
var Storage = {
	data: "Hello World!"
}
//Model, only in charge of data & business logic part.
Model = {
	data: null,
	fetchData: function() {
		this.data = Storage["data"];
	}
}

//View, here only in charge of rendering the UI
View = {
	render: function(data) {
		document.getElementById("data").innerHTML = data;
	}
}

//Controller, connect the view and model
Controller = function(M, V) {
	this.model = M;
	this.view = V;
}

Controller.prototype.handleClick = function() {
	//update model
	this.model.fetchData();

	//update view
	this.view.render(this.model.data);
}

//create Controller Object hwController
var hwController = new Controller(Model, View);

document.getElementById("myBtn").addEventListener("click", hwController.handleClick.bind(hwController));
```

### Framework or Design Pattern
The above code is clear since View, Model and Controller are separate objects. However, I am a little bit confused about the below code.

```javascript
document.getElementById("myBtn").addEventListener("click", hwController.handleClick.bind(hwController));
```

I am not sure if this line of code should be regarded as a global action to setup the app, or should I make it as a function of the Controller, or maybe the View? Overall, I am not sure who, M or V or C, should be in charge of registering the event, which is the key point of combining the UI and Model.

If you have the same confusion as me, maybe we are facing the same problem: whether MVC is a design pattern or a framework.

Thus, before we dive into the the vanilla js code for TodoMVC, I highly suggest you to know about some basic ideas of [design patterns](../../design%20pattern) first.

 I think understanding design pattern, especially the [observer pattern](../../design%20pattern/observer%20pattern), can greatly help us answer the above questions (event registration), and understand the MVC as a framework better.

#H1
##H2
###H3
#H1
Hello View is not HTML!,View performs updating the HTML or other interface with data given.
=======


