var child_process = require('child_process');
var util = require('util');

// function copy(source, target, callback) {
// 	child_process.exec(
// 		util.format('cp -r %s/* %s', source, target), callback);
// }

// copy('a', 'b', function(err) {
// 	console.log("error");
// });

function main(arg) {
	child_process.exec(
		util.format('mkdir %s', arg[0]),function() {
			console.log(arguments);
		});
}

main(process.argv.slice(2));