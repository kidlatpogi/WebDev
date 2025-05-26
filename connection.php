<?php
$servername = "localhost"; // Change if your DB server is different
$username = "root";        // Change to your MySQL username
$password = "";            // Change to your MySQL password
$dbname = "reservationTry";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Optional: echo to confirm connection (for testing only)
// echo "Connected successfully";
?>
