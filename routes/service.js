const express = require("express");
const { exec } = require("child_process");

const router = express.Router();

/**
 * Exec wrapper (Promise-based)
 */
function run(cmd) {
    return new Promise((resolve) => {
        exec(cmd, (err, stdout, stderr) => {
            resolve({
                err,
                stdout: stdout || "",
                stderr: stderr || ""
            });
        });
    });
}

/**
 * -----------------------------------------
 * GET SERVICE STATUS
 * /api/service/:name
 * -----------------------------------------
 */
router.get("/:name", async (req, res) => {
    const service = req.params.name;

    const result = await run(`systemctl is-active ${service}`);

    const isRunning = result.stdout.trim() === "active";

    const statusOutput = await run(
        `systemctl status ${service} --no-pager --lines=20`
    );

    res.json({
        success: true,
        service,
        running: isRunning,
        output: statusOutput.stdout || statusOutput.stderr
    });
});

/**
 * -----------------------------------------
 * START SERVICE
 * POST /api/service/:name/start
 * -----------------------------------------
 */
router.post("/:name/start", async (req, res) => {
    const service = req.params.name;

    const result = await run(`sudo systemctl start ${service}`);

    const verify = await run(`systemctl is-active ${service}`);
    const running = verify.stdout.trim() === "active";

    res.json({
        success: running,
        action: "start",
        service,
        running,
        output: result.stdout || result.stderr
    });
});

/**
 * -----------------------------------------
 * STOP SERVICE
 * POST /api/service/:name/stop
 * -----------------------------------------
 */
router.post("/:name/stop", async (req, res) => {
    const service = req.params.name;

    const result = await run(`sudo systemctl stop ${service}`);

    const verify = await run(`systemctl is-active ${service}`);
    const running = verify.stdout.trim() === "active";

    res.json({
        success: !running,
        action: "stop",
        service,
        running,
        output: result.stdout || result.stderr
    });
});

/**
 * -----------------------------------------
 * RESTART SERVICE
 * POST /api/service/:name/restart
 * -----------------------------------------
 */
router.post("/:name/restart", async (req, res) => {
    const service = req.params.name;

    const result = await run(`sudo systemctl restart ${service}`);

    const verify = await run(`systemctl is-active ${service}`);
    const running = verify.stdout.trim() === "active";

    // Update AXI restart timestamp
    if (service === "axi") {
        const fs = require("fs");
        const path = require("path");
        const stateFile = path.join(__dirname, "..", "state", "config-state.json");

        const state = JSON.parse(fs.readFileSync(stateFile, "utf8"));
        state.axi_restarted = new Date().toISOString();
        fs.writeFileSync(stateFile, JSON.stringify(state, null, 2));
    }

    res.json({
        success: running,
        action: "restart",
        service,
        running,
        output: result.stdout || result.stderr
    });
});

module.exports = router;

