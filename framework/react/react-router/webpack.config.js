const path = require('path');
const webpack = require('webpack');

module.exports = {
  devtool: 'inline-source-map',
  entry: [
    // 'react-hot-loader/patch',
    // // activate HMR for React
    
    'webpack-dev-server/client?http://localhost:3000',
    // bundle the client for webpack-dev-server
    // and connect to the provided endpoint
    
    'webpack/hot/only-dev-server',
    // bundle the client for hot reloading
    // only- means to only hot reload for successful updates

    './src/index.js',
    // the entry point of our app
  ],
  output: {
    filename: 'bundle.js',
    // the output bundle

    path: path.resolve(__dirname, 'dist'),

    publicPath: '/static/'
    // necessary for HMR to know where to load the hot update chunks
  },
  module: {
    rules: [
      {
        test: /\.jsx?$/,
        use: [
          'babel-loader',
        ],
        exclude: /node_modules/,
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
    port: 3001,

    historyApiFallback: true,
    // respond to 404s with index.html...that's it. all the explanation online fail to provide such a succinct idea
    
    hot: true,
    // enable HMR on the server
  },
};

