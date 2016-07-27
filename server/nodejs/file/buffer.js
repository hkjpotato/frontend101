//Buffer extends js data power from string to binary
var bin = new Buffer([ 0x68, 0x65, 0x6c, 0x6c, 0x6f ]);
var str = bin.toString('utf-8');
console.log(str);
console.log(bin[0].toString(16));
bin[0] = 0x48;
console.log(bin.toString('utf-8'));

