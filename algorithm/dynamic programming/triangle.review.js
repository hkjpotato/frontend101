var triangle =  [
    [2],
    [3, 4],
    [6, 5, 7],
    [4, 1, 8, 3]
];

// version 1. top down = traverse dfs
var minimumTotal = function(triangle) {
    var minPathSumRecord = [];
    triangle.forEach(function(layer) {
        // init the initial state
        minPathSumRecord.push(layer.slice(0))
    });
    
    //from top to bottom, each time, update the minimum path to the targeted location
    minPathSumRecord.forEach(function(layer, layerIndex) {
        //skip the first layer (boundary)
        if (layerIndex !== 0) {
            //use map as we want to update the old array
            layer.forEach(function(node, location) {
                var fromLeft = Number.MAX_VALUE, fromRight = Number.MAX_VALUE;
                if (location - 1 >= 0) {
                    fromLeft = minPathSumRecord[layerIndex - 1][location - 1];
                }
                if (location < minPathSumRecord[layerIndex - 1].length) {
                    fromRight = minPathSumRecord[layerIndex - 1][location];
                }
                var minPathToHere = Math.min(fromLeft, fromRight);
                //update the current location
                layer[location] += minPathToHere;
            })
        } 
    });
    
    //search the bottom for the min
    return minPathSumRecord[minPathSumRecord.length - 1].reduce(function(prev, curr) {
        if (curr < prev) {
            return curr;
        } else {
            return prev;
        }
    }, Number.MAX_VALUE)
};

console.log(minimumTotal(triangle));