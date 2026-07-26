// ===============================
// Dashboard JavaScript
// Ohaiyo Japan Surplus
// ===============================

// Wait hanggang fully loaded ang page
document.addEventListener("DOMContentLoaded", function () {

    // ===============================
    // Notification Button
    // ===============================

    const notificationBtn = document.querySelector(".notification-btn");

    if (notificationBtn) {

        notificationBtn.addEventListener("click", function () {

            alert("No new notifications.");

        });

    }

    // ===============================
    // Dashboard Cards Hover Effect
    // ===============================

    const cards = document.querySelectorAll(".dashboard-card");

    cards.forEach(card => {

        card.addEventListener("mouseenter", () => {

            card.style.transform = "translateY(-5px)";

        });

        card.addEventListener("mouseleave", () => {

            card.style.transform = "translateY(0px)";

        });

    });

});