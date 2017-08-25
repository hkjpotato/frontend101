//tutorial source1: https://webpack.github.io/docs/tutorials/getting-started/#setup-compilation
//tutorial source2: https://webpack.js.org/concepts/


//4 core concepts of webpack

/*-------------
Entry
webpack creates a graph of all dependencies
entry is the 'entry' root of this graph

define entry using entry property in webpack.config.js
    
    -------------
    module.exports = {
        entry: './path/to/my/entry/file.js'
    }
    -------------

//more: https://webpack.js.org/concepts/entry-points/
-------------*/

/*-------------
Output
'output' property tells webpack how to treat bundled code

    -------------
    const path = require('path');

    module.exports = {
      entry: './path/to/my/entry/file.js',
      output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'my-first-webpack.bundle.js'
      }
    };
    }
    -------------
//more: https://webpack.js.org/concepts/output/
-------------*/

/*-------------
Loaders
webpack treats every file (.css, .html, .scss, .jpg, etc.) as a module. However, webpack only understands JavaScript.
Loaders in webpack transform these files into modules as they are added to your dependency graph.

At a high level, they have two purposes in your webpack config.

1. Identify what files should be transformed by a certain loader. (test property)
2. Transform that file so that it can be added to your dependency graph (and eventually your bundle). (use property)


    -------------
    const path = require('path');

    const config = {
      entry: './path/to/my/entry/file.js',
      output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'my-first-webpack.bundle.js'
      },
      module: {
        rules: [
          {test: /\.(js|jsx)$/, use: 'babel-loader'}
        ]
      }
    };

    module.exports = config;
    -------------


https://webpack.js.org/concepts/loaders/
-------------*/


/*-------------
Plugins
plugins are most commonly used (but not limited to) performing actions and custom functionality on "compilations" or "chunks" of your bundled modules

In order to use a plugin, you just need to require() it and add it to the plugins array. Most plugins are customizable via options. Since you can use a plugin multiple times in a config for different purposes, you need to create an instance of it by calling it with new.

At a high level, they have two purposes in your webpack config.

1. Identify what files should be transformed by a certain loader. (test property)
2. Transform that file so that it can be added to your dependency graph (and eventually your bundle). (use property)


    -------------
    const HtmlWebpackPlugin = require('html-webpack-plugin'); //installed via npm
    const webpack = require('webpack'); //to access built-in plugins
    const path = require('path');

    const config = {
      entry: './path/to/my/entry/file.js',
      output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'my-first-webpack.bundle.js'
      },
      module: {
        rules: [
          {test: /\.(js|jsx)$/, use: 'babel-loader'}
        ]
      },
      plugins: [
        new webpack.optimize.UglifyJsPlugin(),
        new HtmlWebpackPlugin({template: './src/index.html'})
      ]
    };

    module.exports = config;
    -------------


https://webpack.js.org/concepts/plugins/
-------------*/
