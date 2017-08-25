const path = require('path');
const webpack = require('webpack');
// const HtmlWebpackPlugin = require('html-webpack-plugin');//used to generate an html with script pointing to bundle
// process.env.NODE_ENV = 'production'
  // // removes a lot of debugging code in React
  // new webpack.DefinePlugin({
  //   'process.env': {
  //     'NODE_ENV': JSON.stringify('production')
  // }}),
module.exports = {
  entry: [
    'webpack-dev-server/client?http://localhost:3000',
    // bundle the client for webpack-dev-server
    // and connect to the provided endpoint

    'webpack/hot/only-dev-server',
    // bundle the client for hot reloading
    // only- means to only hot reload for successful updates

    path.resolve(__dirname, './src/index'),
    // the entry point of our app
  ],

  output: {
    path: path.resolve(__dirname, 'dist'),
    filename: 'bundle.js',
    publicPath: 'static',
    // necessary for HMR to know where to load the hot update chunks
  },
  module: {
    rules: [
      {
        test: /\.jsx?$/,
        use: [
          'babel-loader',
        ],
        include: [
          path.resolve(__dirname, './src'),
          path.resolve(__dirname, './node_modules/react-redux/src'),
        ],
      },
    ],
  },

  devtool: 'inline-source-map',
  //enough for development, for pruduction, use 'source map' or ignore it
  
  plugins: [
    // new webpack.DefinePlugin({
    //   'process.env': {
    //     'NODE_ENV': JSON.stringify('production')
    // }}),
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
    contentBase: path.resolve(__dirname, './public'),
    historyApiFallback: true,
    // respond to 404s with index.html...that's it. all the explanation online fail to provide such a succinct idea
    
    hot: true,
    // enable HMR on the server

    // hotOnly: true, //dont't refresh while hot loading fails
    //CORS
    // headers: {
    //   "Access-Control-Allow-Origin": "http://localhost:8000",
    //   // or simply "Access-Control-Allow-Origin": "*" 
    // }, 
  },
};

