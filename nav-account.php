<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$full_name = $_SESSION['first_name'] ?? 'User';

// Get first two parts of the full name
$name_parts = explode(' ', $full_name);
$first_two_names = implode(' ', array_slice($name_parts, 0, 2));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Account</title>

    <link rel="stylesheet" href="nav-account.css">
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
            Hi, <?php echo htmlspecialchars($first_two_names); ?>

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
        <h1>Account</h1>
    </div>
    
    <!-- Textfields -->
    <div class="account-main">

        <!-- Photo and name -->
        <div class="account-photo-col">
            <form id="photo-upload-form" enctype="multipart/form-data">
                <label for="account-photo-input" style="cursor:pointer;">
                    <img id="account-photo-preview" src="photos/sample_account_photo.png" alt="Account Photo">
                </label>
                <span class="photo-hover-label">Click here to add your photo</span>
                <input type="file" id="account-photo-input" name="account-photo" accept="image/*" style="display:none;">
            </form>
            <p id="person-photo"><?php echo htmlspecialchars($first_two_names); ?></p>
        </div>

        <!-- Account Details -->
        <form class="account-form">
            <div class="account-form-row">
                <!-- First name -->
                <div>
                    <label for="account-fname">Firstname</label><br />
                    <input type="text" id="account-fname" name="fname" placeholder="Firstname" required />
                </div>
                <!-- Last name -->
                <div>
                    <label for="account-lname">Lastname</label><br />
                    <input type="text" id="account-lname" name="lname" placeholder="Lastname" required />
                </div>
            </div>
            <!-- Email -->
            <div>
                <label for="account-email">Email</label><br />
                <input type="email" id="account-email" name="email" placeholder="Email" required />
            </div>
            <!-- Password -->
            <div><h3>Change Password</h3></div>

            <div>
                <label for="account-password">Old Password</label><br />
                <input type="password" id="account-password" name="password" placeholder="Password" required />
            </div>
            <!-- Confirm Password -->
            <div>
                <label for="account-new-password">New Password</label><br />
                <input type="password" id="account-new-password" name="new-password" placeholder="New Password" required />
            </div>
            <!-- Update Button -->
            <div class="submit-row">
                <button type="submit">Confirm Changes</button>
            </div>
        </form>
    </div>

    <script src="function-logout.js"></script>
    <script src="function-fetch-userDesc-others.js"></script>
    <script src="function-account-photo-preview.js"></script>
    <script src="function-active-navbar.js"></script>
</body>
</html>
