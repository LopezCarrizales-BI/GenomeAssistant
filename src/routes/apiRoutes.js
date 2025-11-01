const express = require("express");
const router = express.Router();

const { genericSearch } = require("../controllers/NCBIController");

router.post("/search", genericSearch);

module.exports = router;
