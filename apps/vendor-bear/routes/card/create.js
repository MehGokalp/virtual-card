const express = require('express');
const router = express.Router();
const validator = require('../../service/validator');
const cardRepository = require('../../repository/card');
const cardService = require('../../service/card');
const debug = require('debug')('card-api:create');

router.post('/create', function (req, res) {
    return (new Promise((resolve, reject) => {
        let data = {
            balance: req.body.balance,
            activationDate: req.body.activationDate,
            expireDate: req.body.expireDate,
            currency: req.body.currency,
        };
        const isValid = validator.validate('createCard', data);

        if (isValid === false) {
            return reject(validator.errorsText());
        }

        // Create card with given options
        return resolve(data);
    })).then(async cardData => {
        await cardService.populate(cardData);
        let card = await cardRepository.create(cardData);

        return res.status(200).json({
            currency: card.currency,
            balance: card.balance,
            activationDate: card.activationDate,
            expireDate: card.expireDate,
            reference: card.reference,
            cardNumber: card.cardNumber,
            cvc: card.cvc
        });
    }, errors => {
        debug(errors);
        return res.status(400).json({
            'message': `Card could not created with given options. Errors: ${errors}`
        })
    }).catch(err => {
        debug(err);

        if (err.name === 'ValidationError') {
            return res.status(400).json({
                'message': err.message
            })
        }

        return res.status(503).json({
            'message': 'An error occurred. Please try again later.'
        })
    })
});

module.exports = router;