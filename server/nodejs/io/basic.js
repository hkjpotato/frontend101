// start processing user input
process.stdin.resume();
process.stdin.setEncoding('ascii');
// declare global variables
var input_stdin = "";
var input_stdin_array = "";
var input_currentline = 0;
// standard input is stored into input_stdin
process.stdin.on('data', function (data) {
    input_stdin += data;
});
// standard input is done and stored into an array
// then main is called so that you can start processing your data
process.stdin.on('end', function () {
    input_stdin_array = input_stdin.split("\n");
    main();    
});
// reads a line from the standard input array
function readLine() {
    return input_stdin_array[input_currentline++];
}
/////////////// ignore above this line ////////////////////
// your function that can assist you with solving a problem
function solveMeFirst(a, b) {
  // Hint: Type return a+b below   
  
}
function main() {
    // write your code here.
    // call `readLine()` to read a line.
    // use console.log() to write to stdout
    var a = parseInt(readLine());
    var b = parseInt(readLine());;
    var res = solveMeFirst(a, b);
    console.log(res);
}