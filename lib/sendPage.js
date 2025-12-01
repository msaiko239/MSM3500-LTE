const https = require("https");
const fs = require("fs");
const ini = require("ini");
const path = require("path");

const iniPath = "/var/www/MSM3500/config.ini";

function loadConfig() {
    const raw = fs.readFileSync(iniPath, "utf-8");
    const parsed = ini.parse(raw).Raemis_EPC_System;

    return {
        host: parsed.IP,
        user: parsed.User,
        pass: parsed.Pass
    };
}

function sendPage(msisdn, text, fromMsisdn = "9999", msgType = "0") {
    return new Promise((resolve, reject) => {
        const { host, user, pass } = loadConfig();

        const postData = JSON.stringify({
            to_msisdn: msisdn,
            text: text,
            msg_lifetime: "100",
            from_msisdn: fromMsisdn,
            msg_type: msgType
        });

        const options = {
            hostname: host,
            port: 443,
            path: `/api/smsc_message?id=1`,
            method: "POST",
            rejectUnauthorized: false,   // Allow self-signed
            auth: `${user}:${pass}`,
            headers: {
                "Content-Type": "application/json",
                "Content-Length": Buffer.byteLength(postData)
            }
        };

        const req = https.request(options, (res) => {
            let body = "";

            res.on("data", chunk => body += chunk);

            res.on("end", () => {
                if (res.statusCode === 200) {
                    resolve({ success: true, response: body });
                } else {
                    reject({
                        success: false,
                        status: res.statusCode,
                        response: body
                    });
                }
            });
        });

        req.on("error", (err) => reject(err));

        req.write(postData);
        req.end();
    });
}

module.exports = sendPage;

