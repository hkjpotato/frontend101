//provide 4 basic variables
/*
module
exports
require
global
*/

//an empty module
// var module = {
//     exports: {}
// };

// (function(module, exports) {
//   exports.addOne = function (x) { return x + 1 };
// }(module, module.exports))

// var f = module.exports.addOne;
// f(5) // 5000 

//require

function require(p){
  console.log('require get called');
  var path = require.resolve(p);
  console.log(path);
  var mod = require.modules[path];
  if (!mod) throw new Error('failed to require "' + p + '"');
  if (!mod.exports) {
    mod.exports = {};
    mod.call(mod.exports, mod, mod.exports, require.relative(path));
  }
  return mod.exports;
}

require.modules = {};

require.resolve = function (path){
  var orig = path;
  var reg = path + '.js';
  var index = path + '/index.js';
  return require.modules[reg] && reg
    || require.modules[index] && index
    || orig;
};

require.register = function (path, fn){
  require.modules[path] = fn;
};

require.relative = function (parent) {
  return function(p){
    if ('.' != p.charAt(0)) return require(p);
    var path = parent.split('/');
    var segs = p.split('/');
    path.pop();

    for (var i = 0; i < segs.length; i++) {
      var seg = segs[i];
      if ('..' == seg) path.pop();
      else if ('.' != seg) path.push(seg);
    }
    return require(path.join('/'));
  };
};