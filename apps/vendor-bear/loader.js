module.exports = (path) => {
    const fs = require('fs');
    const join = require('path').join;
    const files = join(__dirname, path);

    // Bootstrap models
    fs
        .readdirSync(files)
        .filter(file => ~file.search(/^[^.].*\.js$/))
        .forEach(file => require(join(files, file)))
    ;
};
