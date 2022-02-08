const path = require('path');
const {merge} = require('webpack-merge');
const common = require('./common.js');

const devConfig = () => (merge(
        common,
        {
            devtool: 'inline-source-map',
            devServer: {
                hot: true,
                contentBase: path.resolve(__dirname, '/../public'),
                publicPath: '/',
            },
        },
    )
);

module.exports = devConfig;