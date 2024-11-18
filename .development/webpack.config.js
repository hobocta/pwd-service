const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerWebpackPlugin = require("css-minimizer-webpack-plugin");

process.env.NODE_ENV = "'production'";

module.exports = {
    mode: 'production',
    entry: ['./js/main.js', './css/main.css'],
    output: {
        path: path.resolve(__dirname, '../dist'),
        filename: '[name].[contenthash].js'
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader
                    },
                    'css-loader'
                ]
            }
        ],
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "[name].[contenthash].css"
        }),
        new CssMinimizerWebpackPlugin
    ]
};
