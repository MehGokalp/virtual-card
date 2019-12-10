const express = require('express');
const router = express.Router();
const debug = require('debug')('card-api:find');
const cardRepository = require('../../repository/card');

router.get('/:reference', function (req, res) {
    return (new Promise(async (resolve, reject) => {
        let card = await cardRepository.find({ reference: req.params.reference });
    
        if (!card) {
            return reject();
        }

        return  resolve(card);
    })).then(card => {
        if (card.isActive() === false) {
            return res.status(200).json({
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
        return res.status(503).json({
            'message': 'An error occurred. Please try again later.'
        })
    })
});

module.exports = router;
