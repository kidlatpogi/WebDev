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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Account</title>
    <link rel="stylesheet" href="nav-account.css" />
</head>
<body>
    <!-- Desktop Navbar -->
    <nav class="desktop-navbar">
        <!--NU Logo -->
        <div class="logo-container">
            <a href="nav-home.php"><img src="Photos/nu-logo-label-blue.png" class="nu-logo" /></a>
        </div>

        <!-- Clickable Navigation -->
        <ul>
            <li><a href="nav-home.php">Home</a></li>
            <li><a href="nav-rooms.php">Rooms</a></li>
            <li><a href="nav-reservation.php">Reservation</a></li>
            <li><a href="nav-account.php">Account</a></li>
            <li><a href="nav-history.php">History</a></li>
        </ul>

        <!-- User dropdown -->
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
            <form
                id="photo-upload-form"
                method="POST"
                enctype="multipart/form-data"
                onsubmit="return false;"
            >
                <label for="account-photo-input" style="cursor:pointer;">
                    <img
                        id="account-photo-preview"
                        src="show_photo.php"
                        alt="Account Photo"
                    />
                </label>
                <span class="photo-hover-label">Click here to add your photo</span>
                <input
                    type="file"
                    id="account-photo-input"
                    name="account_photo"
                    accept="image/*"
                    style="display:none"
                    required
                />
                <button type="submit" style="display:none" id="upload-photo-button">
                    Upload Photo
                </button>
            </form>
            <p id="person-photo"><?php echo htmlspecialchars($first_two_names); ?></p>
        </div>

        <!-- Account Details -->
        <form class="account-form">
            <h4 style="text-align: center;">Contact your Admin to change you Name and Email.</h4>
            <div class="account-form-row">
                <!-- First name -->
                <div>
                    <label for="account-fname">Firstname</label><br />
                    <input
                        type="text"
                        id="account-fname"
                        name="fname"
                        placeholder="Firstname"
                        required
                    />
                </div>
                <!-- Last name -->
                <div>
                    <label for="account-lname">Lastname</label><br />
                    <input
                        type="text"
                        id="account-lname"
                        name="lname"
                        placeholder="Lastname"
                        required
                    />
                </div>
            </div>
            <!-- Email -->
            <div>
                <label for="account-email">Email</label><br />
                <input
                    type="email"
                    id="account-email"
                    name="email"
                    placeholder="Email"
                    required
                />
            </div>
            <!-- Password -->
            <div><h3>Change Password</h3></div>

            <div>
                <label for="account-password">Old Password</label><br />
                <input
                    type="password"
                    id="account-password"
                    name="password"
                    placeholder="Old Password"
                    required
                />
            </div>
            <!-- New Password -->
            <div>
                <label for="account-new-password">New Password</label><br />
                <input
                    type="password"
                    id="account-new-password"
                    name="new_password"
                    placeholder="New Password"
                    required
                />
            </div>
            <!-- Update Button -->
            <div class="submit-row">
                <button type="submit">Confirm Changes</button>
            </div>
        </form>
    </div>

    <script src="function-fetch-userDesc-others.js"></script>
    <script src="function-account-photo-preview.js"></script>
    <script src="function-active-navbar.js"></script>
    <script src="function-update-account.js"></script>
    <script src="function-logout.js"></script>

    <script>
        document.getElementById('account-photo-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                // Check file size (client-side validation)
                if (file.size > 2 * 1024 * 1024) {
                    alert("File too large. Max size allowed is 2MB.");
                    return;
                }

                // Check file type
                const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    alert("Invalid file type. Only JPG, PNG, and GIF are allowed.");
                    return;
                }

                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('account-photo-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);

                // Submit via AJAX
                const formData = new FormData();
                formData.append('account_photo', file);

                fetch('upload_photo.php', {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin' // include session cookies
                })
                .then(response => response.text())
                .then(data => {
                    if (data === 'success') {
                        // Success - no redirect needed
                        // You could show a success message if you want
                        console.log('Upload successful');
                    } else {
                        // Show error message to user
                        alert(data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred during upload');
                });
            }
        });
    </script>

</body>
</html>
