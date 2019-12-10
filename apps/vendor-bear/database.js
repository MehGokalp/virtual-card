const mongoose = require('mongoose');
const config = require('./config');

function connect(callback) {
    mongoose.connection
        .on('error', console.log)
        .on('disconnected', connect)
        .once('open', callback);
    return mongoose.connect(config.db, { useUnifiedTopology: true, keepAlive: 1, useNewUrlParser: true });
}

module.exports = connect;
