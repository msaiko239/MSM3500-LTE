async function loadSubscribers() {
    const select = document.getElementById("subscriberSelect");

    try {
        const res = await fetch("/api/subscribers");
        const data = await res.json();

        select.innerHTML = "";

        data.subscribers.forEach(sub => {
            const opt = document.createElement("option");
            opt.value = sub.msisdn;
            opt.textContent = `${sub.name} (${sub.msisdn})`;
            select.appendChild(opt);
        });

    } catch (err) {
        console.error("Failed to load subscribers", err);
        select.innerHTML = `<option>Error loading list</option>`;
    }
}

document.getElementById("sendForm").addEventListener("submit", async e => {
    e.preventDefault();

    const msg = document.getElementById("msg").value;
    const msisdn = document.getElementById("subscriberSelect").value;

    const res = await fetch("/api/page", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ msg, msisdn })
    });

    const data = await res.json();

    if (data.success) {
        alert(`Message sent to ${msisdn}`);
    } else {
        alert("Failed to send message");
    }
});

loadSubscribers();

