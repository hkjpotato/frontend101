Strategy Pattern
=====================
### Illustration

In javascript, strategy pattern is normally replaced by the "function", which make it implicit. However, it is still good to learn about strategy pattern from an OO (object-oriented) approach, which not only help us to understand it's meaning, but can also manipulate "function" better.

There are a lot of different ways to achieve the same goals. Strategy pattern, is a design pattern which, according to wikipedia:

1. defines a family of algorithms,
2. encapsulates each algorithm, and
3. makes the algorithms interchangeable within that family.

![illustration of strategy pattern](./strategy.png)

A strategy pattern design can be devided to two parts: context and strategies.
The context gets request from client, it is in charge of how to "use" the algorithims.

The context then assign the request to a strategy algorithm, which in charge of the logic.

### The Basic

Let's start from a simple example:
Say you want to find out the price for the gas, and you have this function
```javascript
function getGasPrice(type, gallons) {
	if (type === "regular") {
		return gallons * 1.9;
	}

	if (type === "midgrade") {
		return gallons * 2.3;
	}

	if (type === "premium") {
		return gallons * 2.9;
	}

	if (type === "diesel") {
		return gallons * 2.1;
	}
}
```

You can see this ```getGasPrice``` function is not good since it's complex, and lack of elasticity: what if you want to add a new gas type (e.g super premium)? or what if the gas price per gallon changes?

We first use the traditional OO approach to improve it.

### The Object-oriented Way
Traditional OO approach follows the class->project style. Strategies and context are all object.

#### Strategies
```javascript
var GetRegularGasPrice = function() {}
GetRegularGasPrice.prototype.calculate = function(gallons) {
	return gallons * 1.9;
}

var GetMidgradeGasPrice = function() {}
GetMidgradeGasPrice.prototype.calculate = function(gallons) {
	return gallons * 2.3;
}

var GetPremiumGasPrice = function() {}
GetPremiumGasPrice.prototype.calculate = function(gallons) {
	return gallons * 2.9;
}

var GetDieselGasPrice = function() {}
GetDieselGasPrice.prototype.calculate = function(gallons) {
	return gallons * 2.1;
}
```

#### Context

```javascript

var GasCalculator = function() {
	this.gallons = 0;
	this.strategy = null;
}

//store the strategy and parameter.
GasCalculator.prototype.setGallons = function(gallons) {
	this.gallons = gallons;
}

GasCalculator.prototype.setStrategy = function(strategy) {
	this.strategy = strategy;
}

GasCalculator.prototype.getPrice = function() {
	return this.strategy.calculate(this.gallons);
}
````

You can see how different strategies are encapsulated in separate classes. When we want to use it, we can assign different strategies to the gasCalculator obj, which is our context object.

```javascript
var gasCalculator = new GasCalculator();
gasCalculator.setGallons(10);
gasCalculator.setStrategy(new GetRegularGasPrice());

console.log(gasCalculator.getPrice());
```

### The JavaScript Way
Javascript is class-free, and function itself is an object, thus we can simplify the OO code to below:

```javascript
//strategies
var strategies = {
	"regular": function(gallons) {return gallons * 1.9},
	"midgrade": function(gallons) {return gallons * 2.3},
	"premium": function(gallons) {return gallons * 2.9},
	"diesel": function(gallons) {return gallons * 2.1},
}

//context
var getPrice = function(strategy, gallons) {
	return strategies[strategy](gallons);
}


### Polymorphism and Strategy Pattern
Each strategy has its own logic, but they does share sth in common, such as the calculate method. Polymorphism ensures that "the algorithms are interchangeable within that family". The power in polymorphic design is to share behaviors.


### Animation with Strategy Pattern

Ready to get some fun? Below we are going to use Strategy Pattern to do some animation. Personally, I am a big fan of web animation, because it can help to achieve the one of three elements of good design: desirability. (the other two are utility and usability).

Here is an example of how to use strategy pattern to make the easing animation for a small ball. To do that, we need four parameters:

 1. The starting location.
 2. The ending location.
 3. How long the animation has performed.
 4. How long the total duration of the animation is.

 html & css

 ```css
#ball {
	width: 50px;
	height: 50px;
	border-radius: 50%;
	background-color: lightgrey;
	position: absolute;
}
 ```

 ```html
<div id="ball"></div>
 ```

 Below is the easing functions from Flash

 ```javascript
//t = time, b = begin, c = change, d = duration
var linear = function(t, b, c, d) {
	return c * t / d + b;
}

var easeIn = function(t, b, c, d) {
	return c * (t /= d) * t + b;
}

var strongEaseIn = function(t, b, c, d) {
	return c * (t /= d ) * t * t * t * t + b;
}

var strongEaseOut = function(t, b, c, d) {
	return c * ((t = t/d - 1) * t * t * t * t + 1) + b;
}

var sineaseIn = function(t, b, c, d) {
	return c * (t /= d) * t * t + b;
}


var sineaseOut = function(t, b, c, d) {
	return c * ((t = t/d - 1) * t * t + 1) + b;
}

var tween = {
	linear: linear,
	easeIn: easeIn,
	strongEaseIn: strongEaseIn,
	strongEaseOut: strongEaseOut,
	sineaseIn: sineaseIn,
	sineaseOut: sineaseOut
}
 ```

 Now we define an Animate class, which accept a dom node as input

```javascript
var Animate = function(dom) {
	this.dom = dom;
	this.startTime = 0;
	this.startPos = 0;
	this.endPos = 0;
	this.propertName = null;
	this.easing = null;
	this.duration = null;
}

Animate.prototype.start = function(propertName, endPos, duration, easing) {
	//set up paramters
	this.startTime = +new Date;
	this.startPos = this.dom.getBoundingClientRect()[propertName];
	this.propertName = propertName;
	this.endPos = endPos;
	this.duration = duration;
	this.easing = tween[easing];

	var timeId = setInterval(function() {
		if (this.step() === false) {
			clearInterval(timeId);
		}
	}.bind(this), 19);
}

//define what to do in each step
Animate.prototype.step = function() {
	var t = +new Date();
	if (t > this.startTime + this.duration) {
		this.update(this.endPos);
		return false;
	}

	var pos = this.easing(t - this.startTime, this.startPos, this. endPos - this.startPos, this.duration);

	this.update(pos);
}

//define how to update the dom based on new position
Animate.prototype.update = function(pos) {
	console.log("here");
	console.log(this.propertName);
	this.dom.style[this.propertName] = pos + "px";
}

var animate = new Animate(div);
animate.start("left", 500, 1000, "easeIn");
```

Or we can use requestAnimationFrame
```javascript
Animate.prototype.startRAF = function(propertName, endPos, duration, easing) {
	this.startTime = +new Date;
	this.startPos = this.dom.getBoundingClientRect()[propertName];
	this.propertName = propertName;
	this.endPos = endPos;
	this.duration = duration;
	this.easing = tween[easing];
	this.paintByStep();
}

Animate.prototype.paintByStep = function() {
	var t = + new Date();
	if (t > this.startTime + this.duration) {
		this.update(this.endPos);
		return false;
	} else {
		var pos = this.easing(t - this.startTime, this.startPos, this. endPos - this.startPos, this.duration);
		this.update(pos);
		requestAnimationFrame(this.paintByStep.bind(this));
	}
}

var animate = new Animate(div);

animate.startRAF("left", 500, 1000, "strongEaseOut");
```