//sync vs async

//sync
var fn1 = function(input) {
	// console.log(input);
}
var fn2 = function(input) {
	return input;
}
fn1(fn2("hello world sync"));

//async
var fn2a = function(input, cb) {
	var output = input;
	cb(output);
}

var fn1a = function(output, cb) {
	cb(output);
}

fn2a("hello world async", function(output) {
	//so terrible
	fn1a(output, function(val) {
		// console.log(val);
	})
} )

//traverse array
for (var i = 0, arr = []; i < 10; i++) {
	arr[i] = i;
}
//sync
function sync(data) {
	console.log(data);
}

for (var i = 0; i < arr.length; i++) {
	// sync(arr[i]);
}

//async
// function next(i, len, callback) {
// 	//in this scope, you have access to the current index
// 	if (i < len) {
// 		setTimeout(function() {
// 			console.log(arr[i]);
// 			next(i + 1, len, callback);
// 		}, Math.random() * 500);
// 	} else {
// 		callback();
// 	}
// }

// next(0, arr.length, function() {
// 	console.log("all done");
// });




