async function fetchServiceStatus(name) {
    const res = await fetch(`/api/service/${name}`);
    if (!res.ok) throw new Error("HTTP " + res.status);
    return res.json();
}

async function loadServices() {
    const services = ["asterisk", "axi", "rabbitmq-server"];

    for (const svc of services) {
        let result;
        try {
            result = await fetchServiceStatus(svc);
        } catch (err) {
            console.error(`Failed to load ${svc}:`, err);
            result = { success: false, output: "Error loading service", running: false };
        }

        // Determine if service is running
        const isRunning = result.output && result.output.includes("Active: active");

        // Status icon
        const statusEl = document.getElementById(`${svc}-status`);
        if (statusEl) {
            statusEl.innerHTML = isRunning
                ? `<i class="fa-solid fa-circle-check text-success"></i>`
                : `<i class="fa-solid fa-circle-xmark text-danger"></i>`;
        }

        // Output log
        const outputEl = document.getElementById(`${svc}-output`);
        if (outputEl) {
            outputEl.innerHTML = result.output || "No output";
        }
    }
}

loadServices();

