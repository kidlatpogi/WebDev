// Dynamically display clickable rooms (4 per row) based on selected floor and room type, using your custom logic.

document.addEventListener("DOMContentLoaded", function () {
    const roomDescriptions = {
        401: "Lecture Room 401: TV, 40 seats, whiteboard.",
        402: "Lecture Room 402: TV, 40 seats, whiteboard.",
        403: "Lecture Room 403: TV, 40 seats, whiteboard.",
        404: "Lecture Room 404: TV, 40 seats, whiteboard.",
        405: "Lecture Room 405: TV, 40 seats, whiteboard.",
        406: "Lecture Room 406: TV, 40 seats, whiteboard.",
        407: "Lecture Room 407: TV, 40 seats, whiteboard.",
        408: "Lecture Room 408: TV, 40 seats, whiteboard.",
        409: "Lecture Room 409: TV, 40 seats, whiteboard.",
        410: "Lecture Room 410: TV, 40 seats, whiteboard.",
        411: "Lecture Room 411: TV, 40 seats, whiteboard.",
        412: "Lecture Room 412: TV, 40 seats, whiteboard.",
        413: "Lecture Room 413: TV, 40 seats, whiteboard.",
        414: "Lecture Room 414: TV, 40 seats, whiteboard.",
        415: "Lecture Room 415: TV, 40 seats, whiteboard.",
        416: "Lecture Room 416: TV, 40 seats, whiteboard.",
        417: "Lecture Room 417: TV, 40 seats, whiteboard.",
        418: "Lecture Room 418: TV, 40 seats, whiteboard.",
        419: "Lecture Room 419: TV, 40 seats, whiteboard.",
        420: "Lecture Room 420: TV, 40 seats, whiteboard.",
        421: "Lecture Room 421: TV, 40 seats, whiteboard.",
        422: "Lecture Room 422: TV, 40 seats, whiteboard.",
        423: "Lecture Room 423: TV, 40 seats, whiteboard.",
        424: "Lecture Room 424: TV, 40 seats, whiteboard.",
        425: "Lecture Room 425: TV, 40 seats, whiteboard.",
        426: "Lecture Room 426: TV, 40 seats, whiteboard.",
        427: "Lecture Room 427: TV, 40 seats, whiteboard.",
        428: "Lecture Room 428: TV, 40 seats, whiteboard.",
        429: "Lecture Room 429: TV, 40 seats, whiteboard.",
        430: "Lecture Room 430: TV, 40 seats, whiteboard.",
        431: "Lecture Room 431: TV, 40 seats, whiteboard.",
        432: "Lecture Room 432: TV, 40 seats, whiteboard.",
        433: "Lecture Room 433: TV, 40 seats, whiteboard.",
        434: "Lecture Room 434: TV, 40 seats, whiteboard.",
        435: "Lecture Room 435: TV, 40 seats, whiteboard.",
        436: "Lecture Room 436: TV, 40 seats, whiteboard.",
        438: "Zoology Laboratory 438: TV, 40 seats, whiteboard.",

        501: "Computer Laboratory 501: TV, 40 seats, whiteboard.",
        502: "Lecture Room 502: TV, 40 seats, whiteboard.",
        503: "Physical Education Room 503: NULL, 0 seats, whiteboard.",
        504: "Lecture Room 504: TV, 40 seats, whiteboard.",
        505: "Lecture Room 505: TV, 40 seats, whiteboard.",
        506: "Drawing Room 506: TV, 45 seats, whiteboard.",
        507: "Computer Laboratory Room 507: TV, 40 seats, whiteboard.",
        508: "Computer Laboratory 508: TV, 40 seats, whiteboard.",
        509: "Circuit Laboratory 509: TV, 33 seats, whiteboard.",
        510: "Lecture Room 510: TV, 40 seats, whiteboard.",
        511: "Hydraulics Laboratory 511: TV, 45 seats, whiteboard.",
        512: "Geotech Laboratory 512: TV, 40 seats, whiteboard.",
        513: "Lecture Room 513: TV, 40 seats, whiteboard.",
        514: "Chemical Laboratory 514: TV, 40 seats, whiteboard.",
        515: "Lecture Room 515: TV, 40 seats, whiteboard.",
        516: "Chemical Laboratory 516: TV, 32 seats, whiteboard.",
        517: "Physics Laboratory 517: TV, 53 seats, whiteboard.",
        518: "Lecture Room 518: TV, 40 seats, whiteboard.",
        519: "Physics Laboratory 519: TV, 50 seats, whiteboard.",
        520: "Lecture Room 520: TV, 40 seats, whiteboard.",
        521: "Drawing Room 521: TV, 45 seats, whiteboard.",
        522: "Lecture Room 522: TV, 40 seats, whiteboard.",
        523: "Lecture Room 523: TV, 40 seats, whiteboard.",
        524: "Lecture Room 524: TV, 40 seats, whiteboard.",
        525: "Drawing Room 525: TV, 40 seats, whiteboard.",
        526: "Lecture Room 526: TV, 40 seats, whiteboard.",
        527: "Lecture Room 527: TV, 40 seats, whiteboard.",
        528: "Lecture Room 528: TV, 40 seats, whiteboard.",
        529: "Lecture Room 529: TV, 40 seats, whiteboard.",
        530: "Lecture Room 530: TV, 40 seats, whiteboard.",
        531: "Lecture Room 531: TV, 40 seats, whiteboard.",
        532: "Lecture Room 532: TV, 40 seats, whiteboard.",
        533: "Lecture Room 533: TV, 40 seats, whiteboard.",
        534: "Computer Laboratory 534: TV, 40 seats, whiteboard.",
        535: "Lecture Room 535: TV, 40 seats, whiteboard.",
        536: "Lecture Room 536: TV, 40 seats, whiteboard.",
        537: "Lecture Room 537: TV, 40 seats, whiteboard.",
        538: "Lecture Room 538: TV, 40 seats, whiteboard.",
        539: "Lecture Room 539: TV, 40 seats, whiteboard.",
        540: "Lecture Room 540: TV, 40 seats, whiteboard.",
        541: "Lecture Room 541: TV, 40 seats, whiteboard.",
        542: "Lecture Room 542: TV, 40 seats, whiteboard.",
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
            // Use 1 per row on mobile, 5 per row otherwise
            var isMobile = window.innerWidth <= 700;
            var perRow = isMobile ? 1 : 5;

            if (idx % perRow === 0) {
                row = document.createElement("div");
                row.style.display = "flex";
                row.style.justifyContent = "center";
                row.style.marginBottom = "20px";
                roomGrid.appendChild(row);
            }

            var cell = document.createElement("div");
            cell.classList.add("room-cell");
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
            label.style.color = "white";
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

    // Handle window resize
    let lastIsMobile = window.innerWidth <= 700;
    window.addEventListener("resize", function() {
        const isMobile = window.innerWidth <= 700;
        if (isMobile !== lastIsMobile) {
            lastIsMobile = isMobile;
            renderRooms();
        }
    });
});