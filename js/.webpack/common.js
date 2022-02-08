const path = require('path');

module.exports = {
    entry: {
        index: './videoblock'
    },
    output: {
        path: path.resolve(__dirname, '../../views/js'),
        filename: '[name].bundle.js',
        publicPath: 'public',
    },
}