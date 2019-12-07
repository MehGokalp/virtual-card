const express = require('express');
const router = express.Router();
const mongoose = require('mongoose');
const cardSchema = mongoose.model('Card');
const debug = require('debug')('card-api');

router.get('/:reference', function (req, res, next) {
    return (new Promise((resolve, reject) => {
        cardSchema.findOne({ reference: req.params.reference }).exec((err, card) => {
            if (err) {
                throw err;
            }

            if (!card) {
                return reject();
            }

            return resolve(card);
        });
    })).then(card => {
        if (card.isActive() === false) {
            res.status(200).json({
                'message': 'Card is not activated yet'
            });
        }
        return res.status(200).json({
            currency: card.currency,
            balance: card.balance,
            activationDate: card.activationDate,
            expireDate: card.expireDate,
            reference: card.reference,
            cardNumber: card.cardNumber,
            cvc: card.cvc,
            isExpired: card.isExpired()
        });
    }, () => {
        return res.status(404).json({
            'message': 'Card not found'
        })
    }).catch(err => {
        debug(err);
        res.status(503).json({
            'message': 'An error occurred while fetching card from database'
        })
    })
});

module.exports = router;
