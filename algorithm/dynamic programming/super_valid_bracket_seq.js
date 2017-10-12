/*
https://www.hackerrank.com/contests/ncr-codesprint/challenges/super-valid-bracket-sequences
either a back searching or dp

for a given number n, there are many combination of valid seq

as for k, we need to find an algorthim to calcualte the max K, then the number of valid for a given k is just

len([k in maxK if k >= k])

given a valid seq S of n, the only way to make it a valid seq is

(S) => does not increase max K at all since a valid s start with ( and end with )

sS (s is valid) => increase max K by maxK(s) + 1
Ss (s is valid) => increase max K by maxK(s) + 1
e.g () + (), maxK("()"") = 1, thus maxK("()""()"") = 1 + (1 + 1)


% 2 !== 0, cannot be valid

anyway
maxK(n) = maxK(n - 2) + 3

say n = 2i

thus for i base
maxK(i) = 0 if i = 0
maxK(1) = 1 if i = 1
maxK(2) = 1 + 2 if i = 2

but notice minK is always 1 if i >= 1 e.g. (((())))

all start from 
                k
()              1(1)
(()),()()       1(1), 3(1)
...,(())(),     1(1), 3(2), 5(1)
                1(1), 3(3), 5(3), 7(1)
                1(1), 3(4), 5(6), 7(4), 9(1)


given max n = 200, thus max i = 100
state (100 * 100)
state[i][j] means given n = 2 * i, and the number of valid seq that has a max k of 2j + 1


for a given n % 2 = 0, the maxK for its combination is n - 1

oh, the given condition is that k <= n

so given a k, all things consider is 
target [k, n - 1] number of valid seqs
*/
var state = [];
// var state = [];
for (var i = 0; i < 100; i++) {
    state[i] = [];
    for (var j = 0; j < 100; j++) {
        state[i][j] = (j === 0 ? 1 : 0);
    }
}

function getNumAtMaxK(i, maxK) {
    var j = Math.floor(maxK / 2); 
    if (j > i) {
        return 0;
    }
    if (state[i][j] === 0) {
        state[i][j] = getNumAtMaxK(i - 1, maxK) + getNumAtMaxK(i - 1, maxK - 2);
    }
    return state[i][j];
}

function getNumberOfSeqs(n, k) {
  if (n % 2 !== 0) {
    return 0;
  }
  var sum = 0;
  var target = k % 2 === 0 ? k + 1 : k;
  for (; target <= n - 1; target += 2) {
    sum += getNumAtMaxK(n / 2 - 1, target);
  }
  return sum;
}


function processData(input) {
    //Enter your code here
    var input_lines = input.split('\n');
    var q = parseInt(readLine(input_lines));
    for (var i = 0; i < q; i++) {
        var [n, k] = readLine(input_lines).split(' ').map(x => parseInt(x));
        console.log(getNumberOfSeqs(n, k));
    }
} 
var current_line = 0;
function readLine(input_lines) {
    return input_lines[current_line++];
}

process.stdin.resume();
process.stdin.setEncoding("ascii");
_input = "";
process.stdin.on("data", function (input) {
    _input += input;
});

process.stdin.on("end", function () {
   processData(_input);
});

