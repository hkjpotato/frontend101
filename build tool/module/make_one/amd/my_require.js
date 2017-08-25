//load JS 
RequireJS.loadJS = function(url, callback) {
    var node = document.createElement("script");
    node.type = "text/javascript";
    //onload callback
    node.onload = function() {
        if (callback) {
            callback();
        }
    }
    node.onerror = function() {
        throw Error('load script:' + url + " failed!");
    }
    node.src = url;
    //insert into head, will not block rendering
    var head = document.getElementByTagName('head')[0];
    head.appendChild(node);
}

//modules
/*
a collection of modules and their states
modules = {
    ...
    id: {
        state: 1,
        deps: [], //dependecy
        factory: callback,
        exports: {}
    }
}
*/

//define
RequireJS.define = function(deps, callback) {
    var id = RequireJS.getCurrentJS();
    var depsId = [];
    deps.map(function(name) {
        desId.push(RequireJS.getScriptId(name));
    })
    //register
    if (!modules[id] {
        modules[id] = {
            id: id,
            state: 1, //state
            deps: depsId,
            callback: callback,
            exports = null, 
        }
    })
}

//Tobe continued
//http://foio.github.io/requireJS/