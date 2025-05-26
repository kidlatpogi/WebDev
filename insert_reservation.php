<?php
// Include your database connection file
include 'connection.php';

// Check if form data is sent
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data safely
    $fname = $_POST['fname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $floor = $_POST['floor'] ?? '';
    $room_type = $_POST['roomType'] ?? '';
    $room = $_POST['room'] ?? '';
    $start_time = $_POST['starttime'] ?? '';
    $end_time = $_POST['endtime'] ?? '';
    $reservation_date = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO simple_reservations (fname, lname, floor, room_type, room, reservation_date, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $fname, $lname, $floor, $room_type, $room, $reservation_date, $start_time, $end_time);

    if ($stmt->execute()) {
        echo "Reservation successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
