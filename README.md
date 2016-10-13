#Front End 101 -  beginner tutorial for front end.

One challenge of learning front end development is that universities normally don't have front end specific courses. They only teach you about OO language, database and basic knowledge about CS. The good news is that most of the front end development knowledge can be found online and there are tons of excellent tutorials. Through my study about front end, I get help from different people and varous online resource. Thus here I want to summarize what I know about front end development and share with anyone who is interested in becoming a Front End Developer/UI developer/UX Engineer/Design Technologist/Whatever you call.

**Note:** This material is designed for people of entry level. It is not for people who is seeking for high level knowledge. I will continue updating this respository. The table of contents might change.

**Know How:** Frankly speaking, the best way to study the front end development is to start to build something by yourself. There are tons of excellent tutorials in teaching you to build your first app. Here is a quick link to [Know How](#know-how).

## Table of Contents

  1. [Web in General](#web-in-general)
  2. [HTML](#html)
  3. [CSS](#css)
  3. [Javascript](#js)
  5. [Design Pattern](#design-pattern)
  4. [Framework](#framework)
  5. [Build Tool](#build-tool)
  6. [Algorithm](#algorithm)
  7. [Server Side](#server-side)
  8. [UI&#47;UX](#uiux)
  9. [Online Resource](#online-resource)
  10. [Know How](#know-how)


####  Web in General:

How Browser works, Performance...
  * [Web History](./web-general/history)
    To understand why we have html, html5, XHTML, CSS, SQL, JS, PHP, ASP.NET, Web Services, frontend framework, backend framework(or web framework)...
  * How broswer works
    * [window.onload vs $(document).ready](http://stackoverflow.com/questions/3698200/window-onload-vs-document-ready)
    * [window.onload vs document/onload](http://stackoverflow.com/questions/588040/window-onload-vs-document-onload)
  * [High Perfomance](https://developer.yahoo.com/performance/rules.html)
    * [where to put script tag](http://stackoverflow.com/questions/436411/where-is-the-best-place-to-put-script-tags-in-html-markup)
    * [Thinking Async](https://css-tricks.com/thinking-async/)
  * [Single Web App](./web-general/single)
  * [CDN](https://www.nczonline.net/blog/2011/11/29/how-content-delivery-networks-cdns-work/)

#### HTML:

Understand the basic of HTML as well as new technology of the HTML5 is a key to manipulate the DOM.
  * Semantic
  * Attributes
  * Cookie, sessionStorage and localStorage
  * API
  * Template

#### CSS:

Even though developers are generally dealing with coding language like javascript, understanding how the css layout works is essential in making your UI works as desired. Besides, CSS is also important in creating responsive web so it can fit in different screen size.
  * Box model
  * How to center a div
    * Check out my __[20 POTATOES PROJECT](http://codepen.io/hkjpotato/full/yJjLRW/)__ on codepen to see how different styles of centering a div are used.
  * Responsive web
  * Flex
  * CSS animation

#### Javascript:

JS is the key for front end development. Javascript basics: scope, closure, array manipulation, callback ...
  * Object
  * Scope
  * Array mainipulation
  * Apply, call and bind
  * [Event delegation](./javascript/event delegation)
  * IIFE
  * Asynchronous
  * ES6

#### Design&#32;Pattern:
Before going into framework such as MVC and Flux, it is better to know the basic of design patterns. Below is a list of them in js:
  * [Singleton](./design pattern/singleton)
  * [Observer Pattern](./design pattern/observer pattern)
  * [Strategy Pattern](./design pattern/strategy pattern)
  * Proxy Pattern
  * Iterator Pattern
  * Command Pattern

#### Framework:

A deep understanding of framework is essential in making the website to be a functional application. A very good resource about MVC framework is [TodoMVC]. In fact, I think the best way to understand the MVC is to make a native JS MVC by yourself. I will update one soon.
  * [MVC](./framework/mvc)
      * [Basic](./framework/mvc/basic)
      * [Simplified TodoMVC](./framework/mvc/simplified todomvc)
      * AngularJS TodoMVC
  * Flux
  * Redux

  
#### Build Tool:

Gulp, Webpack, Bower, Preprocessor, Testing, Git...
  * [Background](./build tool/background)
  * [Webpack](./build tool/webpack)

#### Algorithm:
  * [JS solutions to Algorithim Problems](./algorithm/)

#### Server Side:

NodeJS, Database...
  * [NodeJS](./server/nodejs)

#### UI/UX:

Making your website user friendly.
  * UX principles
  * User Study Methods
  * Prototyping

#### Online Resource

[W3School], CSS-Tricks, [egghead.io], AngularJS, ReactJS...

#### Know How

  - [First App in React]: Build your first ReactJS application.
  - [Angular and Webpack]: A very good tutorial for understanding build tool webpack.
  - [RESTful api in NodeJS]: A simple tutorial about REST and NodeJS.


   [W3School]: <http://expressjs.com>
   [TodoMVC]: <http://todomvc.com/>
   [egghead.io]: <https://egghead.io/>
   [Angular and Webpack]:<https://egghead.io/series/angular-and-webpack-for-modular-applications>
   [First App in React]:<https://egghead.io/series/build-your-first-react-js-application> 
   [RESTful api in Nodejs]:<https://scotch.io/tutorials/build-a-restful-api-using-node-and-express-4>


