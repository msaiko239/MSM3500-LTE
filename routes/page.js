const express = require("express");
const router = express.Router();
const sendPage = require("../lib/sendPage");

// POST /api/page
router.post("/", async (req, res) => {
    const { msisdn, msg } = req.body;

    if (!msisdn || !msg) {
        return res.status(400).json({ success: false, error: "Missing msisdn or msg" });
    }

    try {
        const result = await sendPage(msisdn, msg, "9999", "0");
        res.json({ success: true, response: result });
    } catch (err) {
        console.error("Page send error:", err);
        res.status(500).json({
            success: false,
            error: "Failed to send page",
            details: err.response || err
        });
    }
});

module.exports = router;

