/*
# 37
Given a set of candidate numbers (C) (without duplicates) and a target number (T), find all unique combinations in C where the candidate numbers sums to T.

The same repeated number may be chosen from C unlimited number of times.

Note:
All numbers (including target) will be positive integers.
The solution set must not contain duplicate combinations.
For example, given candidate set [2, 3, 6, 7] and target 7, 
*/


//let's see #78, subsets first


/*
Given a set of distinct integers, nums, return all possible subsets.

Note: The solution set must not contain duplicate subsets.

For example,
If nums = [1,2,3], a solution is:
[
  [3],
  [1],
  [2],
  [1,2,3],
  [1,3],
  [2,3],
  [1,2],
  []
]
*/

//traverse, need helper
var subsets = function(nums) {
  var result = [];
  if (nums === null || nums.length === 0) {
    return result;
  }
  var currset = [];
  result.push(currset);
  //because 1, 2 is the same as 2, 1. this is a question of combination, not permutation
  //order does not matter
  for (var i = 0; i < nums.length; i++) {
    subsetsHelper(currset, result, nums, i);
  }
  return result;
};

/*
@currset is the set being collected, already in result, pass in to get more if possible
currset does not include nums[index]
index is the next candidate
*/
var subsetsHelper = function(currset, result, nums, index) {
  if (index === nums.length) {
    //no candidate
    return;
  }
  // can get more
  var currset = currset.slice(0); //slice, otherwise need to backtrack
  var next = nums[index];
  currset.push(next);

  // add curr to result
  result.push(currset);

  // check other possibility, tail recursion
  for (var i = index + 1; i < nums.length; i++) {
    subsetsHelper(currset, result, nums, i);
  }
}


// ======a different helper logic=====

var subsets = function(nums) {
  var result = [];
  if (nums === null || nums.length === 0) {
    return result;
  }
  //because 1, 2 is the same as 2, 1. this is a question of combination, not permutation
  //order does not matter
  subsetsHelper([], result, nums, 0);
  return result;
};

/*
currset is collected so far
index is not the next candidate, but the starting point for further search

so, instead just add the one at index and check next possibility

the logic here is to do searching from [index to length - 1], index itself also need to be considered, shit

*/
var subsetsHelper = function(currset, result, nums, index) {
  // add curr to result
  result.push(currset);

  //start to check all other possibility
  for (var i = index; i < nums.length; i++) {
    var nextSet = currset.slice(0)
    nextSet.push(nums[i]);
    subsetsHelper(nextSet, result, nums, i);
  }
}


