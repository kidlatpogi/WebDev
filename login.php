<?php
session_start();

$email = $_POST["email"] ?? '';
$password = $_POST["password"] ?? '';

// Basic validation
if (empty($email) || empty($password)) {
    echo "Email and password are required.";
    exit();
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "room_reservation");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute query to check user
$stmt = $conn->prepare("SELECT user_id, password FROM USERS WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['email'] = $email;

        // Fetch first name and last name from USER_DETAILS
        $stmt2 = $conn->prepare("SELECT fname, lname FROM USER_DETAILS WHERE user_id = ?");
        $stmt2->bind_param("i", $row['user_id']);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if ($result2->num_rows === 1) {
            $row2 = $result2->fetch_assoc();
            $_SESSION['first_name'] = $row2['fname'];
            $_SESSION['last_name'] = $row2['lname'];
        } else {
            $_SESSION['first_name'] = 'User';
            $_SESSION['last_name'] = '';
        }
        $stmt2->close();

        // Redirect to nav-home.php
        header("Location: nav-home.php");
        exit();
    } else {
        echo "Invalid password.";
        exit();
    }
} else {
    echo "No account found with that email.";
    exit();
}

$stmt->close();
$conn->close();
?>
