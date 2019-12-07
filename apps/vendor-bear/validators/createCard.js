const validator = require('../service/validator');

const schema = {
    properties: {
        balance: { type: 'integer' },
        activationDate: { type: 'string', format: 'date' },
        expireDate: { type: 'string', format: 'date' },
        currency: { type: 'string', pattern: 'TRY|EUR|USD' }
    },
    required: [ 'balance', 'activationDate', 'expireDate', 'currency' ]
};

validator.addSchema(schema, 'createCard');
