lfunction BSTNode(data, left, right) {
    this.data = data;
    this.left = left;
    this.right = right;
}

// TreeNode.prototype.

BSTNode.prototype.getData = function() {
    return this.data;
}

BSTNode.prototype.setData = function(data) {
    this.data = data;
}

BSTNode.prototype.getLeft = function() {
    return this.left;
}

BSTNode.prototype.setLeft = function(node) {
    this.left = node;
}

BSTNode.prototype.getRight = function() {
    return this.right;
}

BSTNode.prototype.setRight= function(node) {
    this.right = node;
}
function BST(data) {
    this.root = null;
    this.size = 0;
    if (data == null) {
        console.log("no data found, an empty BST is created");
    } else {
        console.log("creating a BST from data");
        for (var element in data) {
            this.add(element);
        }
    }
}

BST.prototype.add = function(data) {
    // console.log('adding data', data);
    if (data == null) {
        throw 'null data cannot be added';
    }

    this.root = this.addHelper(data, this.root);
}

BST.prototype.addHelper = function(data, node) {
    if (node == null) {
        node = new BSTNode(data);
        this.size++
    } else if (data < node.getData()){
        node.setLeft(this.addHelper(data, node.getLeft()))
    } else {
        node.setRight(this.addHelper(data, node.getRight()))
    }
    return node;
}



// var myBST = new BST([1, 2]);
// console.log(myBST)


var Dog = function(name) {
    var privateCounter = 0;
    this.name = name;
    privateCounter++;
}

Dog.prototype.bark = function() {
    console.log(this.name);
}

var dog1 = new Dog('yellow');
dog1.bark();
console.log(dog1);