// Import modules
const express = require("express");
const cors = require("cors");
const morgan = require("morgan");
const path = require("path");
const fs = require("fs");

const configRoutes = require("./routes/config");
const subscribersRoutes = require("./routes/subscribers");
const pageRoutes = require("./routes/page");
const serviceRoutes = require("./routes/service");
const logsRoutes = require("./routes/logs");

const app = express();
const PORT = 3000;

// ------------------------------
//  STATE FILE (config + restart)
// ------------------------------
const stateDir = path.join(__dirname, "state");
const stateFile = path.join(stateDir, "config-state.json");

if (!fs.existsSync(stateDir)) fs.mkdirSync(stateDir);

if (!fs.existsSync(stateFile)) {
    fs.writeFileSync(
        stateFile,
        JSON.stringify(
            {
                config_updated: null,
                axi_restarted: null
            },
            null,
            2
        )
    );
}

function getState() {
    return JSON.parse(fs.readFileSync(stateFile, "utf8"));
}

function saveState(newState) {
    fs.writeFileSync(stateFile, JSON.stringify(newState, null, 2));
}

// ------------------------------
//  Middleware
// ------------------------------
app.use(cors());
app.use(express.json());
app.use(morgan("dev"));

// --------------------------------------------------
//  API ROUTES — MUST COME BEFORE STATIC FILES
// --------------------------------------------------
app.use("/api/config", configRoutes);
app.use("/api/subscribers", subscribersRoutes);
app.use("/api/page", pageRoutes);
app.use("/api/service", serviceRoutes);
app.use("/api/logs", logsRoutes);

// --------------------------------------------------
//  Restart Banner Check Route
// --------------------------------------------------
app.get("/api/pending-restart", (req, res) => {
    const state = getState();

    const needsRestart =
        state.config_updated &&
        (!state.axi_restarted ||
            new Date(state.axi_restarted) < new Date(state.config_updated));

    res.json({ needsRestart });
});

// Health check
app.get("/api/status", (req, res) => {
    res.json({ status: "OK", timestamp: new Date().toISOString() });
});

// --------------------------------------------------
//  STATIC FILES (served last)
// --------------------------------------------------
app.use(express.static(path.join(__dirname, "public")));

// Start server
app.listen(PORT, () => {
    console.log(`MSM3500 backend running at http://localhost:${PORT}`);
});


