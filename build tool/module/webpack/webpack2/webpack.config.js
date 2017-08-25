const HtmlWebpackPlugin = require('html-webpack-plugin');//used to generate an html with script pointing to bundle
const path = require('path');

module.exports = {
  entry: {
    hmr: [
      'webpack-dev-server/client?http://localhost:3000',
      // bundle the client for webpack-dev-server
      // and connect to the provided endpoint
      'webpack/hot/only-dev-server',
      // bundle the client for hot reloading
      // only- means to only hot reload for successful updates
    ],
    app: path.resolve(__dirname, 'app'),
  },
  output: {
    path: path.resolve(__dirname, 'build'),
    filename: '[name].bundle.js',
    publicPath: '/abcdefg/'
    // necessary for HMR to know where to load the hot update chunks
  },
  module: {
    rules: [
      {
        test: /\.jsx?$/,
        use: [
          'babel-loader',
        ],
        include: PATHS.app,
      },
    ],
  },
  plugins: [
    new webpack.HotModuleReplacementPlugin(),
    // enable HMR globally

    new webpack.NamedModulesPlugin(),
    // prints more readable module names in the browser console on HMR updates

    new webpack.NoEmitOnErrorsPlugin(),
    // do not emit compiled assets that include errors
  ],
  devServer: {
    host: 'localhost',
    port: 3000,

    historyApiFallback: true,
    // respond to 404s with index.html...that's it. all the explanation online fail to provide such a succinct idea
    
    hot: true,
    // enable HMR on the server

    // hotOnly: true, //dont't refresh while hot loading fails


    //CORS
    headers: {
      "Access-Control-Allow-Origin": "http://localhost:8000",
      // or simply "Access-Control-Allow-Origin": "*" 
    },
    /*
    whether you need Access Control depends on:
    1. you dont need this if your index.html is served by the same WDS, which serves the bundles & HMR
       In this case, the frontend code fetch the HMR json from the same server and thus no CORS problem
    2. you need this if your frontend code is served by another server(e.g. Django) 
       you need to allow that code(HMR runtime) to get updated HMR json through HTTP from this WDS
       (which is in another domain, their ports are different)
       http://andrewhfarmer.com/understanding-hmr/
    */
  },

  // proxy: {}
  /*
  whether you need proxy depends on:
  1. If your frontend code(which make the ajax) is served by
     this WDS, and it makes ajax call to an external api,
     e.g. xxx/api/jsondata
     then you (might)need to proxy the api call here due to CORS.

  2. If you frontend is served by the server which also serve the api data
    (e.g. Django for index.html && api data)
     then you dont need to worry about this
  */
};

