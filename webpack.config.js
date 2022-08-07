const path = require('path');

module.exports = {
  mode: process.env.NODE_ENV,
  devtool: process.env.NODE_ENV === 'development' ? 'source-map' : '',
  entry: {
    app: ['@babel/polyfill', './public/assets/js/script.js'],
  },
  output: {
    path: path.resolve(__dirname, 'public'),
    filename: '[name].js',
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env'],
            plugins: ['@babel/plugin-transform-runtime'],
          },
        },
      },
    ],
  },
};
