function factorial(n) {
	if(n === 1) {
		return 1;
	} else {
		return n * factorial(n - 1);
	}
}

function interative(n) {
	var result = 1;
	while(n > 0) {
		result *= n--;
	}
	return result;
}

// console.log(factorial(10));
// console.log(interative(10));


//DFS + Preorder
/*
	A
   / \
  B   C
 / \   \
D   E   F

A->B->D->E->C->F
*/

var fs = require('fs');
var path = require('path');

function travelSync(dir, cb) {
	//should be array
	console.log(fs.readdirSync(dir));

	fs.readdirSync(dir).forEach(function(file) {
		var pathname = path.join(dir, file);
		// console.log(pathname);
		if (fs.statSync(pathname).isDirectory()) {
			travelSync(pathname, cb);
		} else {
			//should be a file
			cb(pathname);
		}
	});
}

// travelSync("./root", function(pathname) {
// 	console.log(pathname);
// });

function travel(dir, callback, finish) {
    fs.readdir(dir, function (err, files) {
        (function next(i) {
        	console.log(i);
            if (i < files.length) {
                var pathname = path.join(dir, files[i]);

                fs.stat(pathname, function (err, stats) {
                    if (stats.isDirectory()) {
                        travel(pathname, callback, function () {
                            next(i + 1);
                        });
                    } else {
                        callback(pathname, function () {
                            next(i + 1);
                        });
                    }
                });
            } else {
                finish && finish();
            }
        }(0));
    });
}


function travelTest(dir, cb, finish) {
	//async
	fs.readdir(dir, function(err, files) {
		console.log(files);
	});
	//sync
	console.log(fs.readdirSync(dir));
}

//during async, how to gurantee the order of traverse
function travelAsync(dir, cb, finish) {
	fs.readdir(dir, function(err, files) {
		if (files.length > 0) {
			files.forEach(function(file) {
				var pathname = path.join(dir, file);
                fs.stat(pathname, function (err, stats) {
                    if (stats.isDirectory()) {
                        travelAsync(pathname, cb, finish)
                    } else {
        				console.log(pathname);
                    }
                });
			})
		}
	});
}

travel('./root', function(pathname, cb) {
	console.log(pathname);
	cb();
}, function() {
	console.log("finish");
});

