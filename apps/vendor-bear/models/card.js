'use strict';

/**
 * Module dependencies.
 */

const mongoose = require('mongoose');
const Schema = mongoose.Schema;


/**
 * Card Schema
 */

const CardSchema = new Schema({
    balance: { type: Number, default: 0 },
    currency: { type: String, default: 'TRY' },
    activationDate: { type: Date },
    expireDate: { type: Date },
    reference: { type: String },
    cardNumber: { type: String },
    cvc: { type: String },
    active: { type: Boolean, default: true },
    isDeleted: { type: Boolean, default: false },
}, {
    collection: 'card'
});

/**
 * Schema validations
 */
CardSchema.path('currency').validate(currency => {
    //TODO: Implement this method
});

CardSchema.path('activationDate').validate(activationDate => {
    //TODO: Implement this method
});

CardSchema.path('expireDate').validate(expireDate => {
    //TODO: Implement this method
});

CardSchema.path('cardNumber').validate(cardNumber => {
    //TODO: Implement this method
});

CardSchema.path('cvc').validate(cvc => {
    //TODO: Implement this method
});

CardSchema.path('reference').validate(reference => {
    //TODO: Implement this method
});

CardSchema.methods = {
    isExpired: function() {
        return this.expireDate < new Date();
    },
    isActive: function() {
        return this.active === true;
    },
    canSpend: (amount) => {
        //TODO: Implement this method
    }
};

mongoose.model('Card', CardSchema);