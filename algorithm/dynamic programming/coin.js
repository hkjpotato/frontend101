
//given a number N, find the minimum number of coins that can make up N

//It is a dynamic programming since k(N) can be deducted from K(n)s where n < N
//For dynamic programming, two things are important, 1. state of each step 2. connect each step together

/*
    d(i) = n;
    d(i) = min{d(i-k) + 1} where k is one of the coins
*/

function minAmountSolution(value) {
    if (value < 1) {
        return 0;
    }
    var coins = [1, 3, 5];
    return state(coins, value, {});
}

var stateFuncCounter = 0;

function state(coins, rem, counter) {
    stateFuncCounter++;
    if (rem < 0) {
        return -1;
    } else if (rem == 0) {
        return 0;
    } else {
        if (typeof counter[rem] != 'undefined') {
            return counter[rem];
        } else {
            var min = Number.MAX_VALUE;
            coins.forEach(function(coin) {
                var rest = state(coins, rem - coin, counter);
                if (rest != -1 && rest < min) {
                    min = rest;
                }
            });
            counter[rem] = min == Number.MAX_VALUE ? -1 :min;
            return counter[rem]
        }
        // coins.forEach(function(coin) {
        //     //find the state of i - coin
        //     var currState;
        //     if (typeof counter[i - coin] == 'undefined') {
        //         currState = state(i - coin);
        //         counter[i - coin] = currState;
        //     } else {
        //         currState = counter[i - coin];
        //     }
        //     if (typeof currentMin == 'undefined') {
        //         currentMin = currState + 1;
        //     } else {
        //         currentMin = Math.min(currentMin, currState + 1)
        //     } 
        // })
        // return currentMin;
    }
}

var result = minAmountSolution(11);

console.log(result);
console.log(stateFuncCounter);


// function coinChange(coins, amount) {
//     if (amount < 1) return 0;
//     myCounter = new Array(amount + 1);
//     return helper(coins, amount, myCounter);
// }

// // counter[rem - 1] means that 
// var helperCounter = 0;

// function helper(coins, rem, counter) {
//     helperCounter++;


//     if (rem < 0) {
//         return -1;
//     }
//     if (rem == 0) {
//         return 0
//     }
//     if (typeof counter[rem] != 'undefined') {
//         return counter[rem];
//     }
//     var min = Number.MAX_VALUE;
//     coins.forEach(function(coin) {
//         var rest = helper(coins, rem - coin, counter);
//         if (rest != -1 && rest < min) {
//             min = rest + 1;
//         }
//     })
//     //update counter
//     counter[rem] = (min == Number.MAX_VALUE) ? -1 : min;
//     return counter[rem]
//  }

//  console.log(coinChange([1, 3, 5], 11));
//  console.log(myCounter);
//  console.log(helperCounter);

