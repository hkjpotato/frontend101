Hello World MVC
=====================
Here are some simple examples for MVC in plain JS from "Hello World" to "TodoMVC"

#### The Basic
Below is the simplest example of MVC I have found from StackOverflow By [Raynos](http://stackoverflow.com/questions/8497833/hello-world-in-mvc-pattern)

```html
<input id="myBtn" type="button" value="click"></input>
```

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


#H1
##H2
###H3
#H1
