// var kjtest =  require('kjtest'); //this is from modules
var math = require("./math.js"); //this is from root
var math3 = require("./math.js");
var cat = require("./cat");
console.log(require.resolve('kjtest'));
//// module will be initianized for once
// console.log(math.count());
// console.log(math3.count());
// console.log(math === math3);

console.log(cat.create("hkj"));
