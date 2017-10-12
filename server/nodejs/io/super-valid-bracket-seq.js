function isSuperValid(s, k) {
  var count = 0;
  for (var i = 0; i <= s.length - 2; i++) {
    if (s[i] !== s[i + 1]) {
      count += 1;
    }
  }
  return count >= k;
}


var seq = "()()";
console.log(isSuperValid(seq, 2));


var modulo = Math.pow(10, 9) + 7;
console.log(1 % modulo);


