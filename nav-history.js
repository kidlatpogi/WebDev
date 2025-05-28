// Dummy data for reservation history
const historyData = [
    {
        status: "Ongoing",
        room: "Room 401",
        type: "Lecture",
        time: "7:00 am - 9:00 am",
        date: "01/01/2025"
    },
    {
        status: "Ongoing",
        room: "Room 510",
        type: "Laboratory",
        time: "10:00 am - 12:00 pm",
        date: "01/02/2025"
    },
    {
        status: "Completed",
        room: "Room 402",
        type: "Lecture",
        time: "8:00 am - 10:00 am",
        date: "12/20/2024"
    },
    {
        status: "Completed",
        room: "Room 515",
        type: "Laboratory",
        time: "1:00 pm - 3:00 pm",
        date: "12/18/2024"
    },
    {
        status: "Cancelled",
        room: "Room 420",
        type: "Laboratory",
        time: "2:00 pm - 4:00 pm",
        date: "12/15/2024"
    }
];

function renderHistoryCards(status) {
    const wrapper = document.getElementById("history-cardview-wrapper");
    wrapper.innerHTML = "";

    const filtered = historyData.filter(item => item.status === status);

    if (filtered.length === 0) {
        wrapper.innerHTML = `<div class="history-card"><p>No ${status} reservations found.</p></div>`;
        return;
    }

    filtered.forEach(item => {
        const card = document.createElement("div");
        card.className = "history-card";
        // Add status class for color
        let statusClass = "";
        if (item.status === "Completed") statusClass = "completed";
        if (item.status === "Cancelled") statusClass = "cancelled";
        card.innerHTML = `
            <p class="history-status ${statusClass}">${item.status}...</p>
            <h1 class="history-title">${item.room} &nbsp;|&nbsp; ${item.type}</h1>
            <p class="history-time">Time: ${item.time}</p>
            <p class="history-date">Reserved on: ${item.date}</p>
        `;
        wrapper.appendChild(card);
    });
}

document.addEventListener("DOMContentLoaded", function() {
    // Initial render
    renderHistoryCards("Ongoing");

    // Add event listeners to radio buttons
    document.querySelectorAll('input[name="history-status"]').forEach(radio => {
        radio.addEventListener("change", function() {
            renderHistoryCards(this.value);
        });
    });
});