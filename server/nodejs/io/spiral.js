function numsOfWords(n, m, matrix) {
    if (matrix === null || matrix.length !== n || matrix[0].length !== m) {
        return null;
    }

    n = n - 1;
    m = m - 1;
    
    var boundary = {x0: 0, y0: 0, x1: n, y1: m};
    var curr = {i: n, j: 0};
    var prevChar = '#';
    var direction = 'UP';
    var wordCount = 0;
    
    // if boundary is valid, go check
    while (boundary.x0 <= boundary.x1 && boundary.y0 <= boundary.y1) {
        var currChar = matrix[curr.i][curr.j];
        if (currChar !== '#' && prevChar == '#') {
          wordCount++;
        }
        prevChar = currChar;
        //move to try to get next location
        var next = move(curr, direction);
        if (next.i > boundary.x1 || next.i < boundary.x0 || next.j > boundary.y1 || next.j < boundary.y0) {
          // just change direction and narrow down the boundary
          direction = changeDirection(direction, boundary);
        } else {
          // do real move
          curr = next;
        } 
    }
    return wordCount;
}

function move(curr, direction) {
    if (direction === 'UP') {
        return {i: curr.i - 1, j: curr.j};
    } else if (direction === 'RIGHT') {
        return {i: curr.i, j: curr.j + 1}
    } else if (direction === 'DOWN') {
        return {i: curr.i + 1, j: curr.j};
    } else if (direction === 'LEFT') {
        return {i: curr.i, j: curr.j - 1};
    }
}
function changeDirection(direction, boundary) {
    if (direction === 'UP') {
        boundary.y0++;
        return 'RIGHT';
    } else if (direction === 'RIGHT') {
        boundary.x0++;
        return 'DOWN';
    } else if (direction === 'DOWN') {
        boundary.y1--;
        return 'LEFT';
    } else if (direction === 'LEFT') {
        boundary.x1--;
        return 'UP';
    }  
}

var matrix = [
'a##ar'.split(''),
'a#aa#'.split(''),
'xxwsr'.split('')
]


var res = numsOfWords(3, 5, matrix);
console.log(res);