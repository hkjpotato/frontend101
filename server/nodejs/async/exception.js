// function sync(fn) {
// 	try {
// 		return fn();
// 	} catch (err) {
// 		console.log("catch within sync");
// 	}
// }

// try {
// 	sync(null);
// } catch(err) {
// 	console.log('Error:', err.message)
// }

// //async -bad
// function async(fn) {
// 	//cannot catch the error, becomes global error
// 	setTimeout(function() {
// 		fn();
// 	}, 0);
// }
// try {
// 	async(null);
// } catch(err) {
// 	console.log('Error:', err.message)
// }
//async -good

function async(fn, callback) {
	setTimeout(function() {
		try {
			fn();
		} catch (err) {
			callback(err);
		}
	}, 0)
}

async(null, function(err) {
	console.log(err);
})