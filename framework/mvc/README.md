Hello World MVC
=====================
Here are some simple examples for MVC in plain JS from "Hello World" to "TodoMVC"


```html
<div id="container">
</div>

<input id="myBtn" type="button" value="click"></input>
<script src="//d3js.org/d3.v3.min.js" charset="utf-8"></script>

<script type="text/javascript">
var M = {}, V = {}, C = {};

M.data = "Hello World";
V.render = function(M) { console.log(M.data); }

C.handleClick = function() {
  V.render(M);
}

document.getElementById("myBtn").addEventListener("click", C.handleClick);
</script>

<script type="text/javascript">
var M = {}, V = {}, C = {};

M.data = "Hello World";
V.render = function(M) { console.log(M.data); }

C.handleClick = function() {
  V.render(M);
}

document.getElementById("myBtn").addEventListener("click", C.handleClick);
</script>
```
