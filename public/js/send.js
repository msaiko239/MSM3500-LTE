// Load MSISDN list from backend
async function loadStaffList() {
    const select = document.getElementById("msisdn");

    try {
        const res = await fetch("/api/send/list");
        const data = await res.json();

        select.innerHTML = `<option disabled selected value="">Select Staff Ext</option>`;

        data.msisdn.forEach(num => {
            const opt = document.createElement("option");
            opt.value = num;
            opt.textContent = num;
            select.appendChild(opt);
        });

    } catch (err) {
        console.error("Failed to load staff list", err);
        select.innerHTML = `<option disabled>Error loading list</option>`;
    }
}

// Handle form submit
document.getElementById("sendForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const msg = document.getElementById("msg").value;
    const msisdn = document.getElementById("msisdn").value;

    const res = await fetch("/api/send/message", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ msg, msisdn })
    });

    const result = await res.json();

    if (result.success) {
        alert("Message sent!");
    } else {
        alert("Error sending message.");
    }
});

loadStaffList();

