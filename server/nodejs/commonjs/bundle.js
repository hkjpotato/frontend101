(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
var add = function(x, y) {
	return x + y;
}

var multiply = function(x, y) {
	return x * y;
}

var addOne = function(x) {
	return x + 1;
}

exports.add = add;
exports.multiply = multiply;
exports.addOne = addOne;

},{}],2:[function(require,module,exports){
var math = require("./math.js");
console.log(math.addOne(99999));
console.log(math.add(10, 100));
console.log(math.multiply(10, 100));


},{"./math.js":1}]},{},[2]);
