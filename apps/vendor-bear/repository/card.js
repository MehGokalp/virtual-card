const cardSchema = require('mongoose').model('Card');

const create = async (data) => {
    let card = new cardSchema(data);
    await card.save();

    return card;
};

const find = async (query) => {
    return await cardSchema.findOne(Object.assign({}, query, { isDeleted: false })).exec();
};

const remove = (query) => {
    return updateOne(query, { isDeleted: true });
};

const updateOne = async (query, dataSet, options) => {
    return await cardSchema.updateOne(query, dataSet, options);
};

const updateMany = async (query, dataSet, options) => {
    return await cardSchema.updateMany(query, dataSet, options);
};

module.exports = {
    create: create,
    find: find,
    remove: remove,
    updateOne: updateOne,
    updateMany: updateMany,
};