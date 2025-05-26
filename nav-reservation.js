document.addEventListener("DOMContentLoaded", function () {
    const floorSelect = document.getElementById("floor");
    const roomSelect = document.getElementById("room");
    const roomTypeSelect = document.getElementById("roomType"); // make sure ID matches exactly

    function populateRooms(start, end, floorPrefix, skip = []) {
        roomSelect.innerHTML = ""; // Clear existing options
        for (let i = start; i <= end; i++) {
            if (skip.includes(i)) continue; // skip these room numbers
            const roomNum = `${floorPrefix}${i.toString().padStart(2, "0")}`;
            const option = document.createElement("option");
            option.value = `r${roomNum}`;
            option.textContent = `Room ${roomNum}`;
            roomSelect.appendChild(option);
        }
    }

    function updateRooms() {
        const floor = floorSelect.value;
        const type = roomTypeSelect.value;

        if (floor === "4th") {
            if (type === "Lecture") {
                // 4th floor Lecture: 401-435 excluding 415-420
                populateRooms(1, 35, "4", [15,16,17,18,19,20]);
            } else if (type === "Laboratory") {
                // 4th floor Lab: 415-420
                populateRooms(15, 20, "4");
            }
        } else if (floor === "5th") {
            if (type === "Laboratory") {
                // 5th floor Lab: 501-510
                populateRooms(1, 10, "5");
            } else if (type === "Lecture") {
                // 5th floor Lecture: 511-534
                populateRooms(11, 34, "5");
            }
        } else {
            roomSelect.innerHTML = "";
        }
    }

    floorSelect.addEventListener("change", updateRooms);
    roomTypeSelect.addEventListener("change", updateRooms);

    // Initialize default rooms on page load
    updateRooms();
});
