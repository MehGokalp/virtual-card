module.exports = () => {
    const fs = require('fs');
    const join = require('path').join;
    const models = join(__dirname, 'models');

    // Bootstrap models
    fs
        .readdirSync(models)
        .filter(file => ~file.search(/^[^.].*\.js$/))
        .forEach(file => require(join(models, file)))
    ;
};
