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

Model = {
	data: null,
	fetchData: function() {
		this.data = Storage["data"];
	}
}

View = {
	render: function(data) {
		document.getElementById("data").innerHTML = data;
	}
}


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
After reading some materials, I got a little bit confused about whether MVC is a framework or a design pattern. To clearify that, I decide to focus on some popular [design patterns](../../design%20pattern/observer%20pattern) first.

Before we dive into the the vanilla js code for TodoMVC, I highly suggest you to know about some ideas about [design patterns](../../design%20pattern/observer%20pattern) first. Personally, I got confused about who should trigger the view event, who should be in charge of attach the event listener, what should be update, and the role of the controller. I think understanding design pattern like observer pattern can greatly help us understand the MVC.

#H1
##H2
###H3
#H1
Hello View is not HTML!,View performs updating the HTML or other interface with data given.
=======


