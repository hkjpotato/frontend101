var fs = require('fs');

var rs = fs.createReadStream('./doc/src.txt');
var ws = fs.createWriteStream('./dst.txt');


rs.on('data', function(chunk) {
	// ws.write(chunk); //this is bad since write might be slower than read and they will stackoverflow
	if (ws.write(chunk) === false) {
		//fail to write, now in the internal buffer
		console.log("should be in internal buffer");
		rs.pause();
	}
})

rs.on('end', function() {
	// cleanUp();
	console.log("end");
});

ws.on('drain') {
	//ok internal buffer emptied
	rs.resume();
}