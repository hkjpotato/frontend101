/*
	async relies on callback, but callback does not mean async
*/

function heavyCompute(n, callback) {
	var count = 0,
		i, j;
	for (i = n; i > 0; i--) {
		for (j = n; j > 0; j--) {
			count += 1;
		}
	}

	callback(count)
}

heavyCompute(10000, function(count) {
	console.log(count);
})

console.log("hello");

// "hello always later than 100000000" since js is SINGLE THREAD
// console.log("\n");
// setTimeout(function() {
// 	console.log("world");
// }, 1000);

// console.log("hello");

/* 
to understand that: setTimeout create a parallel THREAD and return to 
the main thread.
*/

console.log("\n");

/*
However, it still needs to wait the main thread to be available
*/

var t = new Date();
setTimeout(function() {
	console.log("should launch after 1000");
	console.log(new Date() - t);
}, 1000);

heavyCompute(50000, function() {
	console.log("main thread finish");
})