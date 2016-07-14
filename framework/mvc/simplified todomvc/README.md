#Simplified TodoMVC
This is the simplified version of the Vanilla JS code from [todomvc.com](http://todomvc.com/). I believe this is the most simplified version you can find on the web. The original [source code](https://github.com/tastejs/todomvc/tree/gh-pages/examples/vanillajs) includes some unnecessary files(to make it works on the browser), such as node_modules and test files.

These are what I do to simplified them:

1. Delete the uncessary git and node_modules file, move the css file to the root directory.
2. Now the root directory only has three code files: html (index.html), css(index.css) and a js file for the javascript code.
3. The js file contains app.js (to set up the app), and MVC files (controller.js, model.js, view.js) as well as a helpers file.
4. The helpers file contains 
	* helper.js (use to define methods for simplifying dom manipulation methdos such as querySelector, event registration, etc.).
	* store.js (use to interact with database, here is the localStorage). 
	* template.js (help the view.js to render html).


After simplication, the file structure is:

```
root
 -index.html
 -index.css
 -js
 	-app.js
 	-view.js
 	-controller.js
 	-model.js
 	-helpers
 		-helpers.js
 		-template.js
 		-store.js
```

You can download the code file to try it by yourself. You can also click on the following links to check out my comments on each file, so as to know what exactly they are doing. I suggest you follow the order of the links :)

 * [index.html](./tutorial/html)
 * [index.css](./tutorial/css)
 * [helps/helps.js](./tutorial/js/helpers/helpers)
 * [helps/template.js](./tutorial/js/helpers/template)
 * [helps/store.js](./tutorial/js/helpers/store)
 * [view.js](./tutorial/js/view)
 * [model.js](./tutorial/js/model)
 * [controller.js](./tutorial/js/controller)


##Notice
Before you dive into it, there are some basic things you need to know to help understand it:

1. [MVC basic](./../basic)
1. javascript object
2. [event delegation](./../../../javascript/event delegation)
3. IIFE and scope
4. localStorage
5. apply, call and bind methods
7. regex and escapeHTML

It will be good if you understand:

1. [Observer pattern](./../../../design pattern/observer pattern)
2. [Browser events]

