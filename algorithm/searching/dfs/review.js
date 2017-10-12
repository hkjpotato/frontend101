



/*
Important

DFS in recursion is similar to Stack

In fact, recursion is similar to stack (you function call is in stack)

two types of recursion, tail or untail

both devide&conquer and traverse are dfs recursion
dfs can be done without recursion by just stack

the difference is:
devide&conquer=> bottom up =>devide first, small result in return and combine, so it is untail

traverse => top down => do sth for current level, then go deeper, get more info

devide & conquer is like "boss assign tasks to child"

traverse is like "carry the result and go through all possibility" (might be a tail recursion)

a good starting point is max_depth_of_bst
*/




var arr = [3, 2, 1, 4];

//get the combination

//DFS
//return the actual result
function combination_dfs(input) {
    var result = [];
    dfs_helper(input, 0, [], result)
    return result;
}

function dfs_helper(input, newIndex, currResult, result) {


    result.push(currResult.slice(0));
    // currResult.push(input[newIndex]);

    // currResult.pop();

    // console.log(currResult.slice(0))

    for (var i = newIndex; i < input.length; i++) {
        //with the input, and the index of where to start, 
        //get all the combination with the current result, 
        //and push them into the result
        //after that, you should give me a result
        //and the currResult should be the same as the input
        currResult.push(input[i]);
        // result.push(currResult.slice(0));
        dfs_helper(input, i + 1, currResult, result);
        currResult.pop();


    }
    // currResult.pop();
}

/* 
         3        2       1      4
    2    1   4
  1   4    4   0
*/

result = []

dfs_helper(arr, 0, [], result)
// console.log(result)
//BFS
//return the number of result


function help(num, index) {
    console.log(num[index]);
    for (var i = index; i < num.length - 1; i++) {
        help(num, i + 1);
    }
    console.log('end')
}

// help([1,2,3], 0);

/*

1, 2, 3
(1 -> (2-> (3-end) end) -> (3->end) -> end)

*/


//subset 2
// Given a collection of integers that might contain duplicates, S, return all possible subsets. Note: Elements in a subset must be in non-descending order. The solution set must not contain duplicate subsets. For example, If S = [1,2,2], a solution is: [ [2], [1], [1,2,2], [2,2], [1,2], [] ]
var nums = [1, 2, 2]

var solution = function(input) {
    var result = [];
    if (input == null || input.length == 0) {
        return result;
    }

    input.sort(function(a, b) {
        return a - b;
    });

    var path = [];
    helper(result, path, input, 0);
    return result;
}


var helper = function(result, path, input, index) {
    //should check if it exits
    result.push(path.slice(0));
    for (var i = index; i < input.length; i++) {
        //or we can check in the same level
        if (i > index && input[i] == input[i - 1]) {
            continue;
        }
        path.push(input[i]);
        helper(result, path, input, index + 1);
        path.pop()
    }
}

var result = solution(nums);
console.log(result)