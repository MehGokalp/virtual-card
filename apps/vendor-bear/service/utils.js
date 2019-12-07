const ccGenerator = require('creditcard-generator');
const _ = require('underscore');

module.exports = {
    generateCreditCardNumber: () => {
        return ccGenerator.GenCC()[0];
    },
    generateCVC: () => {
        return _.random(100, 999);
    }
};
