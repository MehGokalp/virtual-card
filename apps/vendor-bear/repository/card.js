const cardSchema = require('mongoose').model('Card');
const cardService = require('../service/card');

const create = async (data) => {
    let card = new cardSchema(data);
    await card.save();

    return card;
};

const find = async (query) => {
    return await cardSchema.findOne(query).exec();
};

module.exports = {
    create: create,
    find: find
};