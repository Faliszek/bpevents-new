const webpack = require('webpack');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = {
  entry: "./js/main.js",
  output: {
    path: __dirname + '/assets/',
    publicPath: '/wp-content/themes/bpevents/assets/',
    filename: "bundle.js"
  },
  module: {
    rules: [

      {
        test: /\.vue$/,
        loader: 'vue-loader'

      },

      {
        test: /\.js$/,
        exclude: /(node_modules|bower_components|wp-includes)/,
        loader: 'babel-loader',
        query: {
          presets: ['es2015']
        }
      },

      {
        test: /\.scss$/,
        loader: ExtractTextPlugin.extract({
          fallback: 'style-loader',
          use: [
            'css-loader',
            {
              loader: 'postcss-loader',
              options: {
                plugins: function () {
                  return [
                    require('autoprefixer')
                  ];
                }
              }
            },
            {
              loader: 'sass-loader'
            }
          ]
        })
      },
      {
        test: /\.css$/,
        use: [ 'style-loader', 'css-loader' ]
      },
      {
        test: /\.(eot|svg|ttf|woff(2)?)(\?v=\d+\.\d+\.\d+)?/,
        loader: 'url-loader'
      },
      {
        test: /\.png/,
        loader: 'file-loader?name=[hash].[ext]'
      }
    ]
  },


  resolve: {
    alias: {
      vue: 'vue/dist/vue.js',
    }
  },

  plugins: [
    new ExtractTextPlugin("../assets/main.css"),
  ],
};