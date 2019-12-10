const express = require('express');
const router = express.Router();
const debug = require('debug')('card-api:find');
const cardRepository = require('../../repository/card');

router.delete('/remove/:reference', function (req, res) {
    return (new Promise((resolve, reject) => {
        let card = cardRepository.find({ reference: req.params.reference });

        if (!card) {
            return reject();
        }

        return resolve(card);
    })).then(card => {
        if (card.isActive() === false) {
            return res.status(200).json({
                'message': 'Card is not activated yet'
            });
        }

        if (card.isExpired() === true) {
            return res.status(200).json({
                'message': 'Expired cards are can not removed'
            });
        }

        cardRepository.remove({ reference: card.reference });

        return res.status(200).json({
            'message': 'Card successfully removed'
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
