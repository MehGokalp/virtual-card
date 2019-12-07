const express = require('express');
const router = express.Router();

router.get('/', function (req, res, next) {
    res.status(403).json({ message: 'Not allowed request' });
});

module.exports = router;
