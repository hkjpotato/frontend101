//to make amd/requirejs, we first need to implement asyn loading of JS code.

//--- method1: XHR + eval ---
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        eval(this.responseText);
    }
}
xhttp.open("GET", './main.js', true);
xhttp.send();

//because it is async, we cant ensure the order. It cannot cross domain


//--- script dom element ---
var scriptElem = document.createElement('script');
scriptElem.async = true;
document.getElementByTagName('head')[0].appendChild(scriptElem);

//can cross domain
//what requirejs does


//--- script tag ---
document.write('<script type="text/javascript" src="A.js"></script>');
//unlike the above approach, this approach will ensure the order of script loading but block dom rendering
//https://www.stevesouders.com/blog/2012/04/10/dont-docwrite-scripts/


//review of http://foio.github.io/javascript-async/