<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "room_reservation";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getDayOfWeek($date) {
    return date('l', strtotime($date)); // Returns 'Monday', 'Tuesday', etc.
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_number = $_POST['room_number'];
    $date = $_POST['date'];
    $day_of_week = getDayOfWeek($date);

    $sql = "SELECT start_time, end_time FROM ROOM_SCHEDULE WHERE room_id = ? AND day_of_week = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $room_number, $day_of_week);
    $stmt->execute();
    $result = $stmt->get_result();

    $occupied_slots = [];
    while ($row = $result->fetch_assoc()) {
        $occupied_slots[] = $row;
    }

    $available_slots = [];
    $start_time = strtotime("07:00:00");
    $end_time = strtotime("21:00:00");

    while ($start_time < $end_time) {
        $slot_start = date("H:i:s", $start_time);
        $slot_end = date("H:i:s", strtotime("+1 hour", $start_time));

        $is_occupied = false;
        foreach ($occupied_slots as $slot) {
            if (
                ($slot_start >= $slot['start_time'] && $slot_start < $slot['end_time']) ||
                ($slot_end > $slot['start_time'] && $slot_end <= $slot['end_time'])
            ) {
                $is_occupied = true;
                break;
            }
        }

        if (!$is_occupied) {
            $available_slots[] = ["start_time" => $slot_start, "end_time" => $slot_end];
        }

        $start_time = strtotime("+1 hour", $start_time);
    }

    echo json_encode($available_slots);
}

$conn->close();
?>
