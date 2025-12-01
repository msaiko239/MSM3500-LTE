const express = require("express");
const fs = require("fs");
const ini = require("ini");
const router = express.Router();

const iniPath = "/var/www/MSM3500/config.ini";

// GET – read config.ini
router.get("/", (req, res) => {
    try {
        const data = fs.readFileSync(iniPath, "utf-8");
        const parsed = ini.parse(data);
        res.json({ success: true, data: parsed });
    } catch (err) {
        console.error("INI read failed", err);
        res.status(500).json({ success: false, error: "Failed to read INI file" });
    }
});

// POST – update config.ini
router.post("/", (req, res) => {
    try {
        const newData = ini.stringify(req.body);
        fs.writeFileSync(iniPath, newData);
        res.json({ success: true, message: "INI updated" });
    } catch (err) {
        console.error("INI write failed", err);
        res.status(500).json({ success: false, error: "Failed to update INI file" });
    }
});

module.exports = router;

