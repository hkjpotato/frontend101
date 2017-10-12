function Tree(val) {
  this.val = val;
  this.left = null;
  this.right = null;
}

/*
    1
  2   3

4  5  6 7
*/

var root = new Tree(1);
root.left = new Tree(2);
root.right = new Tree(2);


var convert_levelOrder_to_tree = function (levelOrder) {
  var root = new Tree(levelOrder.shift());
  var prev_level = [root];
  while (levelOrder.length !== 0) {
    // construct the curr level
    const curr_level = [];
    for (var i = 0; i < prev_level.length; i++) {
      var curr = prev_level[i];
      var left = new Tree(levelOrder.shift());
      var right = new Tree(levelOrder.shift());
      curr_level.push(left, right);
      curr.left = left;
      curr.right = right;
    }
    prev_level = curr_level;
  }
  return root;
}

var root = convert_levelOrder_to_tree([1,2,3,4,5,6,7]);
var bfs = function (root) {
  var queue = [root];
  var result = [];
  while (queue.length !== 0) {
    var curr = queue.shift();
    if (curr.left) {
      queue.push(curr.left);
    }
    if (curr.right) {
      queue.push(curr.right);
    }
    result.push(curr.val);
  }
  return result;
} 

console.log(bfs(root));