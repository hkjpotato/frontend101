var triangle =  [
	[2],
	[3, 4],
	[6, 5, 7],
	[4, 1, 8, 3]
];



console.log("-----START RUNING-----" + "\n");

//-----------Devide and Conquer-------------
var dcCount = 0;

var dc = function(triangle) {
	if (triangle === null || triangle[0] === null) {
		return null;
	}

	return dcMin(triangle, 0, 0);
}

//@return the min path num from the input location
var dcMin = function(triangle, i, j) {
	dcCount++;
	//the depth of the triangle 
	var depth = triangle.length - 1;
	//to the bottom point
	if (i === depth) {
		return triangle[i][j];
	}

	return Math.min(dcMin(triangle, i + 1, j), dcMin(triangle, i + 1, j + 1)) + triangle[i][j];
}

var minByDC = dc(triangle);

console.log("minByDC is " +  minByDC + ", count is " +  dcCount + "\n");

//-----------devide and conquer + hash = memorize search ---------
var memorizeSearchCount = 0;

var memorizeSearch = function(triangle) {
	if (triangle === null || triangle.length == 0) {
		return -1;
	}

	if (triangle[0] === null || triangle[0].length == 0) {
		return -1;
	}

	var hashForMemorySearch = [];
	triangle.forEach(function(path, i) {
		hashForMemorySearch[i] = [];
		path.forEach(function(point, j) {
			hashForMemorySearch[i][j] = Number.MAX_VALUE;
		})
	});

	function memorizeSeachHelper(i, j) {
		memorizeSearchCount++;
		if (i === triangle.length - 1) {
			return triangle[i][j];
		}

		if (hashForMemorySearch[i][j] !== Number.MAX_VALUE) {
			return hashForMemorySearch[i][j];
		} else {
			hashForMemorySearch[i][j] = Math.min(memorizeSeachHelper(i + 1, j), memorizeSeachHelper(i + 1, j + 1)) + triangle[i][j];
			return hashForMemorySearch[i][j];
		}
	}

	return memorizeSeachHelper(0, 0);
}

var minByMemorizeSearch = memorizeSearch(triangle);

console.log("minByMemorizeSearch is " +  minByMemorizeSearch + ", count is " +  memorizeSearchCount + "\n");


//-----------Bottom Up---------
var bottomUpCount = 0;
var bottomUp = function(triangle) {
	if (triangle === null || triangle.length == 0) {
		return -1;
	}

	if (triangle[0] === null || triangle[0].length == 0) {
		return -1;
	}
	// state is the min path sum from this point to the bottom
	var state = [];
	triangle.forEach(function(path, i) {
		state[i] = [];
		path.forEach(function(point, j) {
			state[i][j];
		})
	});

	var n = triangle.length;

	// console.log(state[0][0]);


	//init(boundary condition)
	for (var j = 0; j < n; j++) {
		state[n - 1][j] = triangle[n - 1][j];
	}

	//Looping 
	//from bottom
	for (var i = n - 2; i >= 0; i--) {
		for (var j = 0; j <= i; j++) {
			bottomUpCount++;
			// if (state[i][j] === Number.MAX_VALUE) {
			state[i][j] = Math.min(state[i + 1][j], state[i + 1][j + 1]) + triangle[i][j]; 
			// }
		}
	}

	//return result
	return state[0][0];
}

var minByButtomUp = bottomUp(triangle);

console.log("minByButtomUp is " +  minByButtomUp + ", count is " +  bottomUpCount + "\n");


//-----------Top Down--------
var topDownCount = 0;
var topDown = function(triangle) {
	if (triangle === null || triangle.length == 0) {
		return -1;
	}

	if (triangle[0] === null || triangle[0].length == 0) {
		return -1;
	}
	// state is the min path sum from Top to this point
	var state = [];
	triangle.forEach(function(path, i) {
		state[i] = [];
		path.forEach(function(point, j) {
			state[i][j] = 0;
		})
	});

	var n = triangle.length;
	state[0][0] = triangle[0][0]
	//init(boundary condition)
	for (var i = 1; i < n; i++) {
		//every level, two boundary
		state[i][0] = state[i - 1][0] + triangle[i][0];
		state[i][i] = state[i - 1][i - 1] + triangle[i][i];
	}

	//Looping 
	//from bottom
	for (var i = 1; i < n; i++) {
		for (var j = 1; j < i; j++) {
			topDownCount++;
			// if (state[i][j] === Number.MAX_VALUE) {
			state[i][j] = Math.min(state[i - 1][j - 1], state[i - 1][j]) + triangle[i][j]; 
			// }
		}
	}

	//return result
	var min = state[n - 1][0];
	state[n - 1].forEach(function(d) {
		topDownCount++;
		if (d < min) {
			min = d;
		}
	});
	return min;
}

var minByTopDown = topDown(triangle);

console.log("minByTopDown is " +  minByTopDown + ", count is " +  topDownCount + "\n");



console.log("-----END OF TEST-----" + "\n");




