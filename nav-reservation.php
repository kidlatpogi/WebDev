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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Room Reservation</title>

    <link rel="stylesheet" href="nav-reservation.css" />

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
        <h1>Room Reservation</h1>
    </div>

    <form action="insert_reservation.php" method="post">

        <div class="account-main">
            <!-- Name fields -->
        <div class="form-names">
            <div class="form-col">
                <label for="fname">Firstname</label>
                <input type="text" id="fname" name="fname" placeholder="Firstname" required />
            </div>
            <div class="form-col">
                <label for="lname">Lastname</label>
                <input type="text" id="lname" name="lname" placeholder="Lastname" required />
            </div>
        </div>

        <!-- Floor, Room Type, Room -->
        <div class="form-row">
            <div class="form-col">
                <label for="floor">Floor</label>
                <select id="floor" name="floor" required>
                    <option value="4th Floor">4th Floor</option>
                    <option value="5th Floor">5th Floor</option>
                </select>
            </div>
            <div class="form-col">
                <label for="roomType">Room Type</label>
                <select id="roomType" name="roomType" required>
                    <option value="Lecture Room">Lecture</option>
                    <option value="Laboratory Room">Laboratory</option>
                </select>
            </div>
            <div class="form-col">
                <label for="room">Room</label>
                <select id="room" name="room" required>
                </select>
            </div>
        </div>

        <!-- Date, Start Time, End Time -->
        <div class="form-date-time">
            <div class="form-col">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" required />
            </div>
            <div class="form-col">
                <label for="starttime">Start Time</label>
                <input type="time" id="starttime" name="starttime" required min="07:00" max="21:00" step="3600" />
            </div>
            <div class="form-col">
                <label for="endtime">End Time</label>
                <input type="time" id="endtime" name="endtime" required min="07:00" max="21:00" step="3600" />
            </div>
        </div>

        <!-- Submit button -->
        <div class="submit-row">
            <button type="submit">Reserve</button>
        </div>
        </div>

    </form>

    <script src="function-fetch-userDesc.js"></script>
    <script src="nav-reservation.js"></script>
    <script src="function-logout.js"></script>
    <script src="function-active-navbar.js"></script>
</body>
</html>
