async function loadAxiLog() {
    const logArea = document.getElementById("axiLog");

    try {
        const res = await fetch("/api/logs/axi");
        const data = await res.json();

        if (!data.success) {
            logArea.textContent = "Failed to load log.";
            return;
        }

        logArea.textContent = data.log;
    } catch (err) {
        console.error("Error loading logs:", err);
        logArea.textContent = "Error loading log file.";
    }
}

window.addEventListener("DOMContentLoaded", loadAxiLog);

