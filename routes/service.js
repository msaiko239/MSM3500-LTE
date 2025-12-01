const express = require("express");
const { exec } = require("child_process");

const router = express.Router();

// Allowed services to prevent command injection
const ALLOWED_SERVICES = ["asterisk", "axi", "rabbitmq-server"];

// GET /api/service/:name
router.get("/:name", (req, res) => {
    const service = req.params.name;

    // Validate service
    if (!ALLOWED_SERVICES.includes(service)) {
        return res.status(404).json({
            success: false,
            error: `Service '${service}' is not allowed`
        });
    }

    exec(`systemctl status ${service} --no-pager --lines=20`, (err, stdout, stderr) => {
        if (err) {
            return res.status(500).json({
                success: false,
                service,
                error: stderr || "Unknown error",
            });
        }

        res.json({
            success: true,
            service,
            output: stdout
        });
    });
});

module.exports = router;

