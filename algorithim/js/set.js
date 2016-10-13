// var a = {};
// var b = a = {};

// if (a == b) {
// 	console.log("object equal")
// }

function myFun(val) {
	this.val = val;
}

var objMade = new myFun(1);
console.log(objMade.__proto__);
console.log(myFun.prototype);

if (objMade.__proto__ == myFun.prototype) {
	console.log("instance __proto__ equals to constructor prototype");
	console.log("对象具有属性__proto__，可称为隐式原型，一个对象的隐式原型指向构造该对象的构造函数的原型，这也保证了实例能够访问在构造函数原型中定义的属性和方法。");
}

function funcObj() {

}

var var1 = "string"

console.log(var1.__proto__);

console.log(funcObj.prototype.)