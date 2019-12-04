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
    activationDate: { type: Date},
    expireDate: { type: Date },
    reference: { type: String },
    cardNumber: { type: String },
    cvc: { type: String },
});

/**
 * Schema validations
 */
CardSchema.path('currency').validate((currency) => {
    //TODO: Implement this method
});

CardSchema.path('activationDate').validate((activationDate) => {
    //TODO: Implement this method
});

CardSchema.path('expireDate').validate((cvc) => {
    //TODO: Implement this method
});

CardSchema.path('cardNumber').validate((cardNumber) => {
    //TODO: Implement this method
});

CardSchema.path('cvc').validate((cvc) => {
    //TODO: Implement this method
});

CardSchema.methods = {
    isExpired: () => {
        //TODO: Implement this method
    },
    isActive: () => {
        //TODO: Implement this method
    },
    canSpend: (amount) => {
        //TODO: Implement this method
    }
};

mongoose.model('Card', CardSchema);