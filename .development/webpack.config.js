const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = {
    mode: 'production',
    entry: ['./js/main.js', './css/main.css'],
    output: {
        path: path.resolve(__dirname, '../dist'),
        filename: 'app.js'
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: ExtractTextPlugin.extract({
                    use: [
                        {loader: 'css-loader', options: {minimize: true}},
                    ]
                })
            }
        ],
    },
    plugins: [
        new ExtractTextPlugin( {
            filename: 'app.css',
        }),
    ]
};
