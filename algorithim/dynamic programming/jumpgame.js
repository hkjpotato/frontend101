// Given an array of non-negative integers, you are initially positioned at the first index of the array. 
//Each element in the array represents your maximum jump length at that position. 
//Determine if you are able to reach the last index. 
//For example: A = [2,3,1,1,4], return true. A = [3,2,1,0,4], return false.

var testInput = [];
testInput[0] = [2,3,1,1,4];
testInput[1] = [3,2,1,0,4];

/*
	Thinking...
	when you arrive at a[i] you can go to a[i + 1] to a[i + a[i]]
	if a[i] != 0 for 0 to n -1 then you must be able to jump one by one

	其实只要avoid 0 就好了

	但这个想法太直了 没意思

	state[i] boolean 能否到达这一点 ?如果可以我就不管你之前是怎么到的
	state[i] = (o ~ i - 1) if exist state[j] && (state[j] && j + a[j] > i)
*/

//return boolean
var canJumpTo = function (arr) {
	if (arr == null || arr.length == 0) {
		return false;
	}
	
	//state[i] whether we can jump to arr[i]
	var state = new Array(arr.length);

	//init we are at zero
	state[0] = true;

	//function
	for (var i = 1; i < arr.length; i++) {

		for (var j = 0; j < i; j++) {
			if (state[j] && (j + arr[j] >= i)) {
				state[i] = true;
				break;
			}
		}
		// if (!state[i]) {
		// 	state[i] = false;
		// }
	}

	//result ensure it is boolean
	return !!state[arr.length - 1];
}

testInput.forEach(function(arr) {
	console.log(canJumpTo(arr))
});
