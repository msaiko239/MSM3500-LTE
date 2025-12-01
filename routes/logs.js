const express = require("express");
const fs = require("fs");
const router = express.Router();

// Path to AXI log file
const axiLogPath = "/var/log/axi.log";

// GET /api/logs/axi
router.get("/axi", (req, res) => {
    try {
        const contents = fs.readFileSync(axiLogPath, "utf8");
        res.json({ success: true, log: contents });
    } catch (err) {
        console.error("Log read failed:", err);
        res.status(500).json({ success: false, error: "Unable to read log file" });
    }
});

module.exports = router;

