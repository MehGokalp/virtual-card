const express = require('express');
const router = express.Router();
const mongoose = require('mongoose');
const cardSchema = mongoose.model('Card');

router.get('/:reference', function(req, res, next) {
  return (new Promise((resolve, reject) => {
    console.log(cardSchema.find());
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
    res.status(200).json({
      currency: card.currency,
      balance: card.balance,
      activationDate: card.activationDate,
      expireDate: card.expireDate,
      reference: card.reference,
      cardNumber: card.cardNumber,
      cvc: card.cvc,
    });
  }, error => {
    res.status(404).json({
      'message': 'Card not found'
    })
  }).catch(err => {
    console.error(err);
    res.status(503).json({
      'message': 'An error occurred while fetching card from database'
    })
  })
});

module.exports = router;
