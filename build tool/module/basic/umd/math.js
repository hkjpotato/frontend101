// math.js
(function (name, context, definition) {
  if (typeof module != 'undefined' && module.exports)
    module.exports = definition();
  else if (typeof define == 'function' && define.amd)
    define(name, definition);
  else
    context[name] = definition();
}('math', this, function () {
  // your module here!
  return {
    addOne: function(x) { return x + 1; }
  };
});

//UMD (Universal Module Definition).