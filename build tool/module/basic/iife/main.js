//script tag
(function(root) {
    var math = {
        addOne: function(x) {
            return x + 1;
        }
    }
    root.math = math;
})(this);


//script tag
console.log(this.math.addOne(100));