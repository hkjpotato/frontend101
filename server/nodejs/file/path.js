var path = require('path');
var _path1 = "foo/barz/..//bar";
var _path2 = "foo\\bar";
console.log(path.normalize(_path2.replace(/\\/g, '/')));


console.log(path.join(_path1, _path2));

console.log(path.extname('hello.js'));