<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$full_first_name = $_SESSION['first_name'] ?? 'User';
$user_first_name = explode(' ', trim($full_first_name))[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>History</title>

    <link rel="stylesheet" href="nav-history.css">
</head>
<body>
    <!-- Desktop Navbar -->
    <nav class="desktop-navbar">

    <!--NU Logo -->
    <div class="logo-container">
        <a href="nav-home.php"><img src="Photos/nu-logo-label-blue.png" class="nu-logo"></a>
    </div>
    
    <!-- Clicable Navigation -->
    <ul>
        <li><a href="nav-home.php">Home</a></li>
        <li><a href="nav-rooms.php">Rooms</a></li>
        <li><a href="nav-reservation.php">Reservation</a></li>
        <li><a href="nav-account.php">Account</a></li>
        <li><a href="nav-history.php">History</a></li>
    </ul>

    <!-- User drowdown -->
    <!-- Logout -->
    <div class="user-dropdown-wrapper">
        <div id="user-dropdown">
            Hi, <?php echo htmlspecialchars($user_first_name); ?>

            <div id="logout-menu">
                <button onclick="logoutUser()">Logout</button>
            </div>

        </div>
    </div>
    </nav>

    <!-- Hamburger Navigation Start -->
    <div class="hamburger-menu">

    <input id="menu__toggle" type="checkbox" />
    
    <label class="menu__btn" for="menu__toggle">
        <span></span>
    </label>

        <ul class="menu__box">
            <li><a class="menu__item" href="nav-home.php">Home</a></li>
            <li><a class="menu__item" href="nav-rooms.php">Rooms</a></li>
            <li><a class="menu__item" href="nav-reservation.php">Reservation</a></li>
            <li><a class="menu__item" href="nav-account.php">Account</a></li>
            <li><a class="menu__item" href="nav-history.php">History</a></li>
            <li><a class="menu__item" href="index.html">Logout</a></li>
        </ul>
    </div>
    <!-- Hamburger Navigation End -->
    
    <!-- Header -->
    <div class="header-center">
        <h1>Reservation History</h1>
    </div>

    <table class="chooser-table" cellpadding="5">
        <tr class = "radio-toolbar">
            <td>
                <input type="radio" id="ongoing" name="history-status" value="Ongoing" checked class="radio-toolbar">
                <label for="ongoing">Ongoing</label>
            </td>
            <td>
                <input type="radio" id="completed" name="history-status" value="Completed">
                <label for="completed">Completed</label>
            </td>
            <td>
                <input type="radio" id="cancelled" name="history-status" value="Cancelled">
                <label for="cancelled">Cancelled</label>
            </td>
        </tr>
    </table>

    

    <!-- History Cardview Wrapper -->
    <div class="history-cardview-wrapper" id="history-cardview-wrapper">
        <!-- Cards will be rendered here by JS -->
    </div>

    <script>
        const userId = <?php echo json_encode($_SESSION['user_id']); ?>;
    </script>

    <script src="function-logout.js"></script>
    <script src="nav-history.js"></script>
    <script src="function-active-navbar.js"></script>
</body>
</html>