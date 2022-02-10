const path = require('path');

module.exports = {
    entry: {
        index: './videoblock/index.js',
        edit: './videoblock/edit.js'
    },
    output: {
        path: path.resolve(__dirname, '../../views/js'),
        filename: '[name].bundle.js',
        publicPath: 'public',
    },
}
