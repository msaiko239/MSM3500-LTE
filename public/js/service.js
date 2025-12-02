console.log("SERVICE.JS LOADED");

const services = ["asterisk", "axi", "rabbitmq-server"];

// Fetch service status + output
async function fetchServiceStatus(name) {
    const res = await fetch(`/api/service/${name}`);

    if (!res.ok) {
        return { success: false, running: false, output: "Error retrieving status" };
    }

    const data = await res.json();

    // Determine if service is active from systemctl output
    const running = data.output.includes("Active: active");

    return {
        success: true,
        running,
        output: data.output
    };
}

// Control service (start/stop/restart)
async function controlService(name, action) {
    const res = await fetch(`/api/service/${name}/${action}`, { method: "POST" });

    if (!res.ok) {
        alert(`Failed to ${action} ${name}`);
        return;
    }

    alert(`${name} ${action}ed successfully`);

    loadServices();  // Refresh UI
}

// Load full UI (cards + logs)
async function loadServices() {
    const cardContainer = document.getElementById("service-status-cards");
    const logContainer = document.getElementById("service-logs");

    cardContainer.innerHTML = "";
    logContainer.innerHTML = "";

    for (const svc of services) {
        const data = await fetchServiceStatus(svc);

        // PICK ICON
        const icon = data.running
            ? `<i class="fa-solid fa-circle-check text-success status-icon"></i>`
            : `<i class="fa-solid fa-circle-xmark text-danger status-icon"></i>`;

        // STATUS CARD
        cardContainer.innerHTML += `
            <div class="col-md-4">
                <div class="service-card">
                    ${icon}
                    <h4 class="mt-2 text-capitalize">${svc}</h4>

                    <div class="mt-3">
                        <button class="btn btn-success svc-btn" onclick="controlService('${svc}', 'start')">Start</button>
                        <button class="btn btn-warning svc-btn" onclick="controlService('${svc}', 'restart')">Restart</button>
                        <button class="btn btn-danger svc-btn" onclick="controlService('${svc}', 'stop')">Stop</button>
                    </div>
                </div>
            </div>
        `;

        // LOG BOX
        logContainer.innerHTML += `
            <h3 class="mt-4">${svc} Output</h3>
            <div id="${svc}-output" class="service-log-box">${data.output}</div>
        `;
    }
}

loadServices();

