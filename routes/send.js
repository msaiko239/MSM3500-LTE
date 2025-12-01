const express = require("express");
const router = express.Router();
const fs = require("fs");
const ini = require("ini");
const https = require("https");

const iniPath = "/var/www/MSM3500/config.ini";

// Helper: read config.ini
function readConfig() {
    const data = fs.readFileSync(iniPath, "utf-8");
    return ini.parse(data).Raemis_EPC_System;
}

// GET list of MSISDNs
router.get("/list", (req, res) => {
    try {
        const { IP, User, Pass } = readConfig();

        const url = `https://${User}:${Pass}@${IP}/api/subscriber`;

        https.get(url, { rejectUnauthorized: false }, (apiRes) => {
            let body = "";
            apiRes.on("data", chunk => body += chunk);

            apiRes.on("end", () => {
                try {
                    const arr = JSON.parse(body);
                    const msisdnList = arr.map(u => u.msisdn);
                    res.json({ success: true, msisdn: msisdnList });
                } catch {
                    res.status(500).json({ success: false, error: "Failed to parse subscriber list" });
                }
            });
        });
    } catch (err) {
        res.status(500).json({ success: false, error: "Failed to load config or API" });
    }
});

// POST send message
router.post("/message", (req, res) => {
    const { msg, msisdn } = req.body;

    // TODO: Write logic to send the actual text
    // You didn’t provide the original send logic
    // So we just confirm receipt

    res.json({
        success: true,
        debug: { msg, msisdn }
    });
});

module.exports = router;

