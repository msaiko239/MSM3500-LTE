const express = require("express");
const fs = require("fs");
const ini = require("ini");
const https = require("https");

const router = express.Router();
const iniPath = "/var/www/MSM3500/config.ini";

router.get("/", (req, res) => {
    try {
        const configData = ini.parse(fs.readFileSync(iniPath, "utf-8")).Raemis_EPC_System;

        if (!configData) {
            return res.status(500).json({ success: false, error: "Missing INI section" });
        }

        const { IP, User, Pass } = configData;

        const url = `https://${User}:${Pass}@${IP}/api/subscriber`;

        https.get(url, { rejectUnauthorized: false }, (apiRes) => {
            let raw = "";

            apiRes.on("data", (chunk) => (raw += chunk));

            apiRes.on("end", () => {
                try {
                    const parsed = JSON.parse(raw);

                    // Filter to list of subscribers {msisdn, name}
                    const result = parsed.map((s) => ({
                        msisdn: s.msisdn || "",
                        name: s.name || "",
                    }));

                    res.json({ success: true, subscribers: result });
                } catch (err) {
                    console.error("Parse error", err);
                    res.status(500).json({ success: false, error: "Invalid JSON from EPC" });
                }
            });
        }).on("error", (err) => {
            console.error("HTTPS error", err);
            res.status(500).json({ success: false, error: "Subscriber API unreachable" });
        });

    } catch (err) {
        res.status(500).json({ success: false, error: "Server failed" });
    }
});

module.exports = router;

