document.addEventListener("DOMContentLoaded", function () {
    fetch('completed_reservations.php')
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                console.log(`Completed reservations update success. Rows updated: ${result.updated_rows}`);
                if (result.message) {
                    console.log(`Message: ${result.message}`);
                }
            } else {
                console.error("Failed to update completed reservations:", result.error);
            }
            fetchHistoryData("Ongoing");
        })
        .catch(error => {
            console.error("Failed to update completed reservations:", error);
            fetchHistoryData("Ongoing");
        });

    document.querySelectorAll('input[name="history-status"]').forEach(radio => {
        radio.addEventListener("change", function () {
            fetchHistoryData(this.value);
        });
    });
});

function fetchHistoryData(status) {
    fetch(`get_reservation_history.php?user_id=${userId}&status=${status}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById("history-cardview-wrapper").innerHTML =
                    `<div class="history-card"><p>Error: ${data.error}</p></div>`;
                return;
            }
            renderHistoryCards(status, data);
        })
        .catch(error => {
            console.error("Fetch error:", error);
            document.getElementById("history-cardview-wrapper").innerHTML =
                `<div class="history-card"><p>Failed to load ${status} reservations.</p></div>`;
        });
}

function renderHistoryCards(status, data) {
    const wrapper = document.getElementById("history-cardview-wrapper");
    wrapper.innerHTML = "";

    if (!data || data.length === 0) {
    const noDataMessages = {
        "Ongoing": "No Ongoing Reservation.",
        "Cancelled": "No Cancelled Reservation.",
        "Completed": "No Completed Reservation."
    };
    wrapper.innerHTML = `<div class="history-card no-data"><p>${noDataMessages[status] || "No reservations found."}</p></div>`;
    return;
    }

    // Sort data by room, then time, then date
    data.sort((a, b) => {
        // Compare room (string)
        if (a.room.toLowerCase() < b.room.toLowerCase()) return -1;
        if (a.room.toLowerCase() > b.room.toLowerCase()) return 1;

        // If rooms are equal, compare time (assuming time format like "HH:MM" 24-hour)
        if (a.time < b.time) return -1;
        if (a.time > b.time) return 1;

        // If times are equal, compare date (assuming format "YYYY-MM-DD")
        if (a.date < b.date) return -1;
        if (a.date > b.date) return 1;

        return 0; // all equal
    });

    data.forEach(item => {
        const card = document.createElement("div");
        card.className = "history-card";

        let statusClass = "";
        if (item.status === "Completed") statusClass = "completed";
        else if (item.status === "Cancelled") statusClass = "cancelled";

        card.innerHTML = `
            <p class="history-status ${statusClass}">${item.status}</p>
            <h1 class="history-title">${item.room} &nbsp;|&nbsp; ${item.type}</h1>
            <p class="history-time">Time: ${item.time}</p>
            <p class="history-date">Reserved on: ${item.date}</p>
            ${item.status === "Ongoing" ? `<button class="cancel-btn">Cancel</button>` : ""}
        `;

        if (item.status === "Ongoing") {
            const cancelBtn = card.querySelector(".cancel-btn");
            cancelBtn.addEventListener("click", () => {
                if (confirm("Are you sure you want to cancel this reservation?")) {
                    cancelReservation(item.reservation_id);
                }
            });
        }

        wrapper.appendChild(card);
    });
}


function cancelReservation(reservationId) {
    fetch('cancel_reservation.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ reservation_id: reservationId })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert("Reservation cancelled successfully.");
            fetchHistoryData("Ongoing");
        } else {
            alert("Failed to cancel reservation. " + (result.error || ""));
            console.error("Cancel error detail:", result.error);
        }
    })
    .catch(error => {
        console.error("Cancel fetch error:", error);
        alert("Error cancelling reservation.");
    });
}
