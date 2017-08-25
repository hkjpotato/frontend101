console.log('head.js');
var arr = [], sth;
for (var i = 0; i < 500; i++) {
    //http://stackoverflow.com/questions/8996852/load-and-execute-order-of-scripts
    
    //let's do sth complicate, but we can't use console.log, it is not accurate
    arr.push(i);
    var general = arr.slice(0);
    arr.forEach(function(d) {
        general.forEach(function(t) {
            sth = d * 100 + t / 99;

        })
    })
    if (i == 499) {
        window.msg =  'head.js finished ' + sth;
    }
}

