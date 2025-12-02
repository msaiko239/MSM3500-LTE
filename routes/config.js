const express = require("express");
const path = require("path");
const fs = require("fs");
const ini = require("ini");
const router = express.Router();

const iniPath = "/var/www/MSM3500/config.ini";
const stateFile = path.join(__dirname, "..", "state", "config-state.json");

// ----------------------------------------------
// GET – read config.ini
// ----------------------------------------------
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

// ----------------------------------------------
// POST – update config.ini
// ----------------------------------------------
router.post("/", (req, res) => {
    try {
        // Save updated INI file
        const newData = ini.stringify(req.body);
        fs.writeFileSync(iniPath, newData);

        // Update restart-required flag (THIS WAS THE MISSING PART)
        const state = JSON.parse(fs.readFileSync(stateFile, "utf8"));
        state.config_updated = new Date().toISOString();
        fs.writeFileSync(stateFile, JSON.stringify(state, null, 2));

        res.json({ success: true, message: "INI updated" });

    } catch (err) {
        console.error("INI write failed", err);
        res.status(500).json({ success: false, error: "Failed to update INI file" });
    }
});

module.exports = router;

