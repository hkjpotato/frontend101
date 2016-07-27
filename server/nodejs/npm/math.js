var addOne = function(x) {
	return x + 1;
}

var i = 0;
var count = function() {
	return ++i;
}

exports.addOne = addOne;
exports.count = count;