<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$user_first_name = $_SESSION['first_name'] ?? 'User'; // fallback to 'User' if empty
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>

    <link rel="stylesheet" href="nav-rooms.css">
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
            <li><a class="menu__item" href="index.php">Logout</a></li>
        </ul>
    </div>
    <!-- Hamburger Navigation End -->

    <!-- Header -->
    <div class="header-center">
        <h1>Rooms</h1>
    </div>

    <!-- Chooser -->
    <table class="chooser-table" cellpadding="5">
        <tr>
            <td>
                <input type="radio" id="4th-floor" name="floor" value="4th Floor" checked>
                <label for="4th-floor">4th Floor</label>
            </td>
            <td>
                <input type="radio" id="5th-floor" name="floor" value="5th Floor">
                <label for="5th-floor">5th Floor</label>
            </td>
        </tr>
        <tr>
            <td>
                <input type="radio" id="lecture-room" name="room-type" value="Lecture Room" checked>
                <label for="lecture-room">Lecture</label>
            </td>
            <td>
                <input type="radio" id="laboratory-room" name="room-type" value="Laboratory Room">
                <label for="laboratory-room">Laboratory</label>
            </td>
        </tr>
    </table>

    <!-- Room grid -->
    <div id="room-grid"></div>

    <!-- Photo Modal: Update to include a description box beside the image -->
    <div id="photo-modal">
        <div id="modal-content">
            <img id="modal-img" src="" alt="Room Preview">
            <div id="modal-desc"></div>
        </div>
    </div>

    <script src="nav-rooms.js"></script>
    <script src="function-logout.js"></script>
    <script src="function-active-navbar.js"></script>
</body>
</html>