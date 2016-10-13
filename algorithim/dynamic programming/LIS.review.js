/* Given a sequence of integers, find the longest increasing subsequence (LIS). 
You code should return the length of the LIS. 
Example For [5, 4, 1, 2, 3], the LIS is [1, 2, 3], return 3 
For [4, 2, 4, 5, 3, 7], the LIS is [4, 4, 5, 7], return 4
*/

var inputArray1 = [5, 4, 1, 2, 3];
var inputArray2 = [4, 2, 4, 5, 3, 7];

//Question: state what is state??

//state s(i) is the LIS from 1 to i this is really bad, because you cannot build connection between each state
// s(i) = s(j) where j < i ?
// s(i) = s(i - 1) + 1 if a[i - 1] > a[i - 2]


// 1, 2, 100, 88, 99, 3
// the s(5) is 2 but you don't know where the 2 end, it is not necessnary end at a[5 - 1]

//correct
//state(i) means the LIS that end at index i
//thus for arr.length = L we are looking for the maximum of state(i) where (i = 0 to i = L - 1)


//build connection between state
//state[i] = max{state[i - k] + 1 if (a[i] > a[i - k])} where k ~ [1, i]
//base state[0] = 1

function solution(array) {
    console.log('here', array)
    if (array == null || array.length == 0) {
        throw 'no valid input';
    }

    // stateHelper(array, array.length - 1);
    var max = 1;
    var state = new Array(array.length);
    state[0] = 1;
    console.log('again', array)
    for (var i = array.length - 1; i >= 0; i--) {
        var currLISendHere = stateHelper(array, i, state);
        if (currLISendHere > max) {
            max = currLISendHere;
        }
    }
    // stateHelper(array, array.length - 1, state);

    console.log(state);
    return max;

}

//stateHelper(i) is similar to state[i]


//index = 4 i (1 to 4), array[index - i] is (4 - 1)=3  to (4 - 4)=0
//index = 3, i (1 to 3), array[2, 0]
//index = 2, i (1 to 2), array[1, 0]
function stateHelper(array, index, state) {
    if (index == 0) {
        // return 1;
        return state[0];
    }
    if (typeof state[index] != 'undefined') {
        console.log('hit')
        return state[index];
    } 
    var LISendHere = 1;
    for (var i = 1; i <= index; i++) {
        if (array[index - i] <= array[index]) {
            console.log("try to get state of index =  ", index - i)
            testLISendHere = stateHelper(array, index - i, state) + 1;
            LISendHere = testLISendHere > LISendHere ? testLISendHere : LISendHere;
        }
    }
    state[index] = LISendHere;
    return state[index];
}

console.log(solution(inputArray1));