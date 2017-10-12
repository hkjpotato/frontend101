/*
# 257

Given a binary tree, return all root-to-leaf paths.

For example, given the following binary tree:

   1
 /   \
2     3
 \
  5
All root-to-leaf paths are:

["1->2->5", "1->3"]
*/



//devide and conquer, weird tail recursion
//return all tree path from the current node
var binaryTreePaths = function(root) {
    //default
    paths = [];

    if (root === null) {
      return paths;
    }

    var leftPaths = binaryTreePaths(root.left);
    var rightPaths = binaryTreePaths(root.right);

    leftPaths.forEach(function (path) {
      paths.push(root.val + '->' + path);
    });


    rightPaths.forEach(function (path) {
      paths.push(root.val + '->' + path);
    });
    
    if (paths.length === 0) {
      //leaf node
      paths.push('' + root.val);
    }
    return paths;
};


//traverse
var binaryTreePathsHelper = function(root, currPath, result) {
  if (root.left === null && root.right === null) {
    // reach the leaf
    if (currPath === '') {
      currPath = '' + root.val;
    } else {
      currPath += ('->' + root.val);
    }
    result.push(currPath);
    return;
  }

  // go deeper
  if (root.left) {
    binaryTreePathsHelper(root.left, currPath, result);
  }
  if (root.right) {
    binaryTreePathsHelper(root.right, currPath, result);
  }
}

var binaryTreePaths = function(root) {

    var result = [];
    var currPath = '';
    if (root === null) {
      return result;
    }
    binaryTreePathsHelper(root, currPath, result);
    return result;
};


//traverse case 2, currPath cover the current node
var binaryTreePathsHelper = function(root, currPath, result) {
  // if (root === null) {
  //   //but when will we reach this?
  //   return;
  // }

  if (root.left === null && root.right === null) {
    result.push(currPath);
    return;
  }

  // go deeper
  if (root.left !== null) {
    binaryTreePathsHelper(root.left, currPath + '->' + root.left.val, result);
  }

  if (root.right !== null) {
    binaryTreePathsHelper(root.right, currPath + '->' + root.right.val, result);
  }
}

var binaryTreePaths = function(root) {

    var result = [];
    var currPath = '';
    if (root === null) {
      return result;
    }
    binaryTreePathsHelper(root, '' + root.val, result);
    return result;
};


var binaryTreePaths = function(root) {
    //default empty
    var paths = [];

    if (root === null) {
      return paths;
    }
    
    var leftPaths = binaryTreePaths(root.left);
    var rightPaths = binaryTreePaths(root.right);

    leftPaths.forEach(function (path) {
      paths.push(root.val + '->' + path);
    });

    rightPaths.forEach(function (path) {
      paths.push(root.val + '->' + path);
    });
    
    if (paths.length === 0) {
      //leaf node
      paths.push('' + root.val);
    }
    
    return paths;
};

