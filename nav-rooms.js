// Dynamically display clickable rooms (4 per row) based on selected floor and room type, using your custom logic.

document.addEventListener("DOMContentLoaded", function () {
    const roomDescriptions = {
        401: "Lecture Room 401: TV, 40 seats, whiteboard.",
        402: "Lecture Room 402: TV, 40 seats, windows.",
        501: "Lab Room 501: 40 Computers, TV.",
    };

    function getRooms(floor, type) {
        let rooms = [];
        if (floor === "4th Floor") {
            if (type === "Lecture Room") {
                // 4th floor Lecture: 401-435 excluding 415-420
                for (let i = 401; i <= 435; i++) {
                    if (i >= 415 && i <= 420) continue;
                    rooms.push(i);
                }
            } else if (type === "Laboratory Room") {
                // 4th floor Lab: 415-420
                for (let i = 415; i <= 420; i++) {
                    rooms.push(i);
                }
            }
        } else if (floor === "5th Floor") {
            if (type === "Laboratory Room") {
                // 5th floor Lab: 501-510
                for (let i = 501; i <= 510; i++) {
                    rooms.push(i);
                }
            } else if (type === "Lecture Room") {
                // 5th floor Lecture: 511-534
                for (let i = 511; i <= 534; i++) {
                    rooms.push(i);
                }
            }
        }
        return rooms;
    }

    function renderRooms() {
        var floor = document.querySelector('input[name="floor"]:checked').value;
        var type = document.querySelector('input[name="room-type"]:checked').value;
        var roomGrid = document.getElementById("room-grid");
        roomGrid.innerHTML = "";

        var rooms = getRooms(floor, type);

        let row;
        rooms.forEach(function(roomNum, idx) {

            if (idx % 5 === 0) {
                row = document.createElement("div");
                row.style.display = "flex";
                row.style.justifyContent = "center";
                row.style.marginBottom = "20px";
                roomGrid.appendChild(row);
            }

            var cell = document.createElement("div");
            cell.style.width = "220px";
            cell.style.margin = "0 15px";
            cell.style.textAlign = "center";
            cell.style.cursor = "pointer";
            cell.style.display = "flex";
            cell.style.flexDirection = "column";
            cell.style.alignItems = "center";
            cell.onclick = function() {
                alert("You clicked Room " + roomNum + " (" + type + ")");
            };

            var img = document.createElement("img");
            img.src = "photos/sample_image.png";
            img.alt = "Room " + roomNum;
            img.style.width = "200px";
            img.style.height = "200px";
            img.style.objectFit = "cover";
            img.style.display = "block";
            img.style.margin = "0 auto 20px auto";
            img.onclick = function(e) {
                e.stopPropagation();
                var modal = document.getElementById("photo-modal");
                var modalImg = document.getElementById("modal-img");
                var modalDesc = document.getElementById("modal-desc");
                modalImg.src = img.src;
                modalDesc.textContent = roomDescriptions[roomNum] || "No description available.";
                modal.style.display = "flex";
            };
            cell.appendChild(img);

            var label = document.createElement("div");
            label.textContent = "Room " + roomNum;
            label.style.marginTop = "0";
            cell.appendChild(label);

            row.appendChild(cell);
        });
    }

    // Initial render
    renderRooms();

    // Add listeners
    document.querySelectorAll('input[name="floor"], input[name="room-type"]').forEach(function(radio) {
        radio.addEventListener("change", renderRooms);
    });

    // Modal close logic
    var modal = document.getElementById("photo-modal");
    if (modal) {
        modal.onclick = function(e) {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        };
    }
});