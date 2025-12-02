//
// --------------------------------------
// Load Sidebar HTML Into Sidebar Container
// --------------------------------------
document.addEventListener("DOMContentLoaded", () => {
    fetch("sidebar.html")
        .then(response => response.text())
        .then(html => {
            document.getElementById("sidebar-container").innerHTML = html;
        })
        .catch(err => console.error("Sidebar load error:", err));

    // Start the banner check after page load
    checkRestartBanner();
});

//
// --------------------------------------
// Helper: Wait until .main-content exists
// --------------------------------------
function waitForMainContent() {
    return new Promise(resolve => {
        const check = () => {
            const el = document.querySelector(".main-content");
            if (el) return resolve(el);
            requestAnimationFrame(check);
        };
        check();
    });
}

//
// --------------------------------------
// Restart Required Banner Logic
// --------------------------------------
let bannerVisible = false;

async function checkRestartBanner() {
    try {
        const res = await fetch("/api/pending-restart");
        const data = await res.json();

        // Ensure main content exists before inserting anything
        const mainContent = await waitForMainContent();

        // Check if banner already exists
        const existingBanner = document.getElementById("restart-required-banner");

        // Remove existing banner if restart is no longer needed
        if (existingBanner && !data.needsRestart) {
            existingBanner.remove();
            bannerVisible = false;
            return;
        }

        // Add banner only if needed and not currently visible
        if (data.needsRestart && !bannerVisible) {
            const banner = document.createElement("div");
            banner.id = "restart-required-banner";

            // Banner styling
            banner.style.background = "#cc3300";
            banner.style.color = "white";
            banner.style.padding = "10px 16px";
            banner.style.fontSize = "0.95rem";
            banner.style.fontWeight = "600";
            banner.style.display = "flex";
            banner.style.justifyContent = "space-between";
            banner.style.alignItems = "center";
            banner.style.borderRadius = "6px";
            banner.style.marginBottom = "15px";
            banner.style.boxShadow = "0 2px 4px rgba(0,0,0,0.15)";

            banner.innerHTML = `
                <span>⚠️ System configuration was updated. AXI service restart is required.</span>
                <button id="restartAxiBannerBtn" class="btn btn-light btn-sm">
                    Restart AXI
                </button>
            `;

            // Insert banner at the top of main content
            mainContent.insertAdjacentElement("afterbegin", banner);
            bannerVisible = true;

            // Restart button handler
            document.getElementById("restartAxiBannerBtn").onclick = async () => {
                await fetch("/api/service/axi/restart", { method: "POST" });
                // Auto-refresh loop will remove banner once restart is detected
            };
        }

    } catch (err) {
        console.error("Restart banner error:", err);
    }
}

//
// --------------------------------------
// Auto-refresh banner state every 5 seconds
// --------------------------------------
setInterval(checkRestartBanner, 5000);

