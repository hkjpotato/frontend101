var fs = require('fs');

function copy(src, dst) {
	fs.writeFileSync(dst, fs.readFileSync(src));
}

function main(argv) {
	copy(argv[0], argv[1]);
}

console.log(process.argv);
main(process.argv.slice(2));
