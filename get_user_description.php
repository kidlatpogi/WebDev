<?php
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$fname = $_SESSION['first_name'] ?? null;
$lname = $_SESSION['last_name'] ?? null;
$email = $_SESSION['email'] ?? null;

if (!$fname || !$lname) {
    echo json_encode(['error' => 'User name not found in session']);
    exit();
}

if (!$email) {
    // Optional: you can still send the response but with a warning or empty email
    $email = '';
}

echo json_encode([
    'fname' => $fname,
    'lname' => $lname,
    'email' => $email,
]);
