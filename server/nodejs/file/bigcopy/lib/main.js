var fs = require('fs');

function copy(src, dst) {
	var readStream = fs.createReadStream(src);
	readStream.pipe(fs.createWriteStream(dst));
}

function main(argv) {
	copy(argv[0], argv[1]);
}

main(process.argv.slice(2));