/* Given a sequence of integers, find the longest increasing subsequence (LIS). 
You code should return the length of the LIS. 
Example For [5, 4, 1, 2, 3], the LIS is [1, 2, 3], return 3 
For [4, 2, 4, 5, 3, 7], the LIS is [4, 4, 5, 7], return 4
*/

var inputArray1 = [5, 4, 1, 2, 3];
var inputArray2 = [4, 2, 4, 5, 3, 7];


//最终结果，可以由前面的中间结果获得。
//存储中间结果，有利于最终结果的计算

/*
[5, 4, 1, 2, 3] result [1, 2, 3]   = 3
[5, 4, 1, 2] result [1, 2]         = 2
[5, 4, 1] result [5] || [4] || [1] = 1



confusion,
when [100, 200, 1, 2] and next is [3, 300...] which should I compare when at "3"
should I compare to "2" or "200". 


to avoid the confusion, let make the state as follows:
-- state[i] means the LIS ends "at" i --


can state[i] < state[j] ? while i > j
yes
[400, 500, 600, 1, 2]
so we have to check all the state[j] where j < i
*/


var findLIS = function(inputArray) {
	//state
	// var state = new Array(inputArray.length);

	//boundary condition / initial condition
	// state[0] = 1;
	//ES6
	var state = new Array(inputArray.length).fill(1);



	//function
	//坐标型动态规划研究的总是上一步怎么来的
	//f[i] = max{f[j] + 1} when (j < i && array[j] <= array[i])

	for (var i = 0; i < inputArray.length; i++) {
		// var currentLIS = 1;
		console.log('dealing with index i = ' + i);

		for (var j = 0; j < i; j++) {

			console.log('	checking if previous index j = ' + j + " is smaller than current [i] = " + inputArray[i]);
			if (inputArray[j] <= inputArray[i]) {
				state[i] = state[i] > state[j] + 1 ? state[i] : state[j] + 1;
				// state[i] = currentLIS < (state[j] + 1) ? (state[j] + 1) : currentLIS;
				console.log('		oh yes index j  = ' + j + " is smaller than current, currentLIS is update to " + state[i]);

			}
		}
		// state[i] = currentLIS;
	}
	
	//result
	//from 0 to n - 1
	var maxLIS = state[0];
	for (var i = 0; i < state.length; i++) {
		maxLIS = state[i] > maxLIS ? state[i] : maxLIS;
	}

	console.log(state);
	return maxLIS;

}

var inputArray3 = [1, 2, 3];

console.log('LIS is ', findLIS(inputArray2));