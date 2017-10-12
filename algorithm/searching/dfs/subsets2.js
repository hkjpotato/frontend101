//#90
/*
Given a collection of integers that might contain duplicates, nums, return all possible subsets.

Note: The solution set must not contain duplicate subsets.

For example,
If nums = [1,2,2], a solution is:

[
  [2],
  [1],
  [1,2,2],
  [2,2],
  [1,2],
  []
]

//so it is ok that 2 <= 2
//it is not ok to 1 <= 2 and then 1<=2, skip duplicate! so need to be sorted

*/

// var dfs = function(nums, result, path, index) {
//     //base + general
//     //we want to avoid duplicate, which means [1, 2(1)] == [1, 2(2)], but we allow [2(1), 2(2)]. we need to jump over dup
//     result.push(path.slice(0));
//     for (var i = index; i < nums.length; i++) {
//         if (i !== index && nums[i] == nums[i - 1]) {
//             //skip the dup for this choice
//             continue;
//         }
//         path.push(nums[i]);
//         dfs(nums, result, path, i + 1);
//         path.pop();
//     }
// }
// var subsetsWithDup = function(nums) {
//     var result = [];
//     if (nums === null || nums.length === 0) {
//         return result;
//     }
//     var path = [];
//     nums.sort(function(a, b) {
//         return a - b;
//     });
//     dfs(nums, result, path, 0);
//     return result;
// };


var subsetsWithDup = function(nums) {
    var result = [];
    if (nums === null || nums.length === 0) {
        return result;
    }
    var path = [];
    nums.sort(function(a, b) {
        return a - b;
    });
    result.push(path);
    searchPath(nums, result, path, 0);
    return result;
};

//traverse
var searchPath = function (nums, result, path, index) {
  //add the current one to result
  for (var i = index; i < nums.length; i++) {
    if (i !== index &&  nums[i] === nums[i - 1]) {
        continue;
    }
    // add the current i
    path.push(nums[i]); //deal with current level
    result.push(path.slice(0));
    // search furthur path for next layer, no need for checking duplicate as its next layer
    // move next
    searchPath(nums, result, path, i + 1);
    path.pop(); //non-tail...
  }
}
