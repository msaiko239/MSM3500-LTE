// Import modules
const express = require("express");
const cors = require("cors");
const morgan = require("morgan");
const path = require("path");

const configRoutes = require("./routes/config");
const subscribersRoutes = require("./routes/subscribers");
const pageRoutes = require("./routes/page");
const serviceRoutes = require("./routes/service");
const logsRoutes = require("./routes/logs");

const app = express();
const PORT = 3000;

// Middleware
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

