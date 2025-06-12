<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "room_reservation";

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT u.user_id, ud.fname, ud.lname, u.email 
        FROM USERS u
        INNER JOIN USER_DETAILS ud ON u.user_id = ud.user_id
        WHERE u.is_deleted = 0"; 

$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Query failed: " . $conn->error]);
    exit;
}

$users = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($users);
?>
