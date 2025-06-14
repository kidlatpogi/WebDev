<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "room_reservation";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $update = "UPDATE RESERVATION SET status_id = (SELECT status_id FROM RESERVATION_STATUS WHERE status = 'Canceled') WHERE reservation_id = ?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("i", $id);
    echo $stmt->execute() ? "Reservation cancelled successfully." : "Failed to cancel reservation.";
    exit;
}

// Fetch ongoing reservations
$sql = "
    SELECT r.reservation_id, r.reservation_date, r.start_time, r.end_time,
           ud.fname, ud.lname,
           ro.floor, ro.room_type,
           rd.description AS room_number,
           rs.status
    FROM RESERVATION r
    JOIN USER_DETAILS ud ON r.userDetails_id = ud.userDetails_id
    JOIN ROOMS ro ON r.room_id = ro.room_id
    JOIN ROOM_DETAILS rd ON ro.room_id = rd.room_id
    JOIN RESERVATION_STATUS rs ON r.status_id = rs.status_id
    WHERE rs.status = 'Ongoing'
      AND r.reservation_date >= CURDATE()
    ORDER BY r.reservation_date, r.start_time
";
$reservations = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reserved Rooms</title>
    <link href="https://fonts.googleapis.com/css2?family=Rowdies&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="admin-reservation.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<nav class="nav">
    <div class="hamburger-menu">
        <input id="menu__toggle" type="checkbox" />
        <label class="menu__btn" for="menu__toggle"><span></span></label>
        <ul class="menu__box">
            <li><a class="menu__item" href="admin-home.html"><i class="fas fa-home"></i> Home</a></li>
            <li><a class="menu__item" href="admin-reservation.php"><i class="fas fa-calendar-check"></i> Reserve Rooms</a></li>
            <li><a class="menu__item" href="admin-logs.html"><i class="fas fa-clipboard-list"></i> Logs</a></li>
            <li><a class="menu__item" href="admin-available-rooms.html"><i class="fas fa-door-open"></i> Available Rooms</a></li>
            <li><a class="menu__item" href="admin-client.html"><i class="fas fa-users"></i> Clients</a></li>
            <li><a class="menu__item" href="admin-archive.html"><i class="fas fa-archive"></i> Archive</a></li>
            <li><a class="menu__item" href="index.html"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
    <div class="logo">
        <img src="Photos/nu-logo-label.png" alt="NU Logo">
    </div>
</nav>

<div class="main">
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search by room, name, or date...">
        <button id="searchBtn"><i class="fas fa-search"></i></button>
    </div>

    <div id="reservationContainer">
        <?php
        if ($reservations->num_rows > 0) {
            $currentDate = '';
            while ($row = $reservations->fetch_assoc()) {
                $date = date("F j, Y", strtotime($row['reservation_date']));
                if ($date !== $currentDate) {
                    echo "<div class='date-title'><i class='fas fa-calendar-day'></i> $date</div>";
                    $currentDate = $date;
                }

                // Extract room type and number from description
                preg_match('/^(.*?)\\s+(\\d{3})/', $row['room_number'], $parts);
                $roomType = isset($parts[1]) ? trim($parts[1]) : $row['room_type'];
                $roomNum = isset($parts[2]) ? $parts[2] : $row['room_number'];

                echo "
                <div class='reservation-card'>
                    <div class='reservation-details'>
                        <p><strong>{$roomType} (Room {$roomNum})</strong></p>
                        <p><i class='fas fa-user'></i> {$row['fname']} {$row['lname']}</p>
                        <p><i class='fas fa-clock'></i> " . date("g:i A", strtotime($row['start_time'])) . " - " . date("g:i A", strtotime($row['end_time'])) . "</p>
                        <p><i class='fas fa-info-circle'></i> Status: {$row['status']}</p>
                    </div>
                    <button class='cancel-btn' onclick='cancelReservation({$row['reservation_id']})'>Cancel</button>
                </div>";
            }
        } else {
            echo "<p>No ongoing reservations found.</p>";
        }
        $conn->close();
        ?>
    </div>
</div>

<script>
function filterReservations() {
    const filter = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.reservation-card').forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(filter) ? 'block' : 'none';
    });
}

document.getElementById('searchInput').addEventListener('input', filterReservations);
document.getElementById('searchBtn').addEventListener('click', filterReservations);

function cancelReservation(id) {
    if (confirm("Are you sure you want to cancel this reservation?")) {
        fetch('admin-reservation.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id=' + id
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        });
    }
}
</script>
</body>
</html>
