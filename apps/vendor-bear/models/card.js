'use strict';

/**
 * Module dependencies.
 */

const mongoose = require('mongoose');
const Schema = mongoose.Schema;
const luhn = require('luhn');


/**
 * Card Schema
 */

const CardSchema = new Schema({
    balance: {
        type: Number,
        default: 0,
        min: [1, 'Balance must greater than 1'],
        required: true
    },
    currency: {
        type: String,
        default: 'TRY',
        enum: [ 'TRY', 'USD', 'EUR' ],
        required: true
    },
    activationDate: {
        type: Date,
        required: true,
        validate: {
            validator: (value) => {
                return value >= new Date();
            },
            message: props => `${props.value} must be in feature!`
        }
    },
    expireDate: {
        type: Date,
        required: true,
        validate: {
            validator: function(value) {
                return value >= new Date() && value > this.activationDate;
            },
            message: props => `${props.value} must be in feature and it must be greater than activation date!`
        }
    },
    reference: {
        type: String,
        required: true
    },
    cardNumber: {
        type: String,
        required: true,
        validate: {
            validator: function(value) {
                return luhn.validate(value);
            },
            message: props => `${props.value} must be valid card number!`
        }
    },
    cvc: {
        type: String,
        required: true,
        validate: {
            validator: function(value) {
                return /^[0-9]{3}$/.test(value);
            },
            message: props => `${props.value} must be valid card number!`
        }
    },
    active: {
        type: Boolean,
        default: true
    },
    isDeleted: {
        type: Boolean,
        default: false
    },
}, {
    collection: 'card'
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