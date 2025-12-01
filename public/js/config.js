// ===========================
// Load config.ini from backend
// ===========================
async function loadConfig() {
    try {
        const res = await fetch('/api/config');
        const result = await res.json();

        if (!result.success) {
            alert("Failed to load configuration");
            return;
        }

        const data = result.data; // contains parsed ini data
        const container = document.getElementById('form-sections');
        container.innerHTML = "";

        // Loop through INI sections
        for (const sectionName in data) {
            const section = data[sectionName];

            const block = document.createElement('div');
            block.classList.add("config-block");

            block.innerHTML = `
                <h3>${sectionName}</h3>

                <label class="mt-2">IP</label>
                <input 
                    class="form-control"
                    type="text"
                    name="${sectionName}.IP"
                    value="${section.IP || ''}"
                >

                <label class="mt-2">User</label>
                <input 
                    class="form-control"
                    type="text"
                    name="${sectionName}.User"
                    value="${section.User || ''}"
                >

                <label class="mt-2">Pass</label>
                <input 
                    class="form-control"
                    type="password"
                    name="${sectionName}.Pass"
                    placeholder="Enter new password"
                >
            `;

            container.appendChild(block);
        }

    } catch (err) {
        console.error("Error loading config:", err);
        alert("Failed to load configuration from server.");
    }
}

// ===========================
// Submit updated config data
// ===========================
document.getElementById("configForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const payload = {};

    // Convert FormData → INI compatible object
    for (const [key, value] of formData.entries()) {
        const [section, field] = key.split(".");
        if (!payload[section]) payload[section] = {};
        payload[section][field] = value;
    }

    try {
        const res = await fetch("/api/config", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload),
        });

        const result = await res.json();

        if (result.success) {
            alert("Configuration Updated Successfully");
        } else {
            alert("Failed to update config.ini");
        }
    } catch (err) {
        console.error("Error submitting config:", err);
        alert("Error sending update request.");
    }
});

// Run at page load
loadConfig();

