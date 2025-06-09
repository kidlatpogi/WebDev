<?php
session_start();
header('Content-Type: application/json');

// Disable error display on screen, log errors instead (for clean JSON output)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL); // still report errors but don't display

require 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit();
}

// Check required POST fields
if (!isset($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['password'], $_POST['new_password'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$old_password = $_POST['password'];
$new_password = $_POST['new_password'];

// Step 1: Fetch current user data (hashed password and userDetails_id)
$stmt = $conn->prepare("SELECT u.password, ud.userDetails_id FROM USERS u JOIN USER_DETAILS ud ON u.user_id = ud.user_id WHERE u.user_id = ?");
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    exit();
}

$stmt->bind_param("i", $user_id);
if (!$stmt->execute()) {
    echo json_encode(["success" => false, "message" => "Execute failed: " . $stmt->error]);
    exit();
}

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "User not found"]);
    exit();
}

$row = $result->fetch_assoc();
$hashed_password = $row['password'];
$userDetails_id = $row['userDetails_id'];

// Step 2: Verify old password
if (!password_verify($old_password, $hashed_password)) {
    echo json_encode(["success" => false, "message" => "Old password is incorrect"]);
    exit();
}

// Step 3: Update USERS (email + password)
$new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

$stmt1 = $conn->prepare("UPDATE USERS SET email = ?, password = ? WHERE user_id = ?");
if (!$stmt1) {
    echo json_encode(["success" => false, "message" => "Prepare failed (update USERS): " . $conn->error]);
    exit();
}

$stmt1->bind_param("ssi", $email, $new_hashed_password, $user_id);
if (!$stmt1->execute()) {
    echo json_encode(["success" => false, "message" => "Failed to update USERS: " . $stmt1->error]);
    exit();
}

// Step 4: Update USER_DETAILS (fname + lname)
$stmt2 = $conn->prepare("UPDATE USER_DETAILS SET fname = ?, lname = ? WHERE userDetails_id = ?");
if (!$stmt2) {
    echo json_encode(["success" => false, "message" => "Prepare failed (update USER_DETAILS): " . $conn->error]);
    exit();
}

$stmt2->bind_param("ssi", $fname, $lname, $userDetails_id);
if (!$stmt2->execute()) {
    echo json_encode(["success" => false, "message" => "Failed to update USER_DETAILS: " . $stmt2->error]);
    exit();
}

// If we got here, everything succeeded
echo json_encode(["success" => true, "message" => "Account updated successfully!"]);
exit();