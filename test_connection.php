<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "POST request received.<br>";
    echo "Data received:<br>";
    print_r($_POST);
} else {
    echo "Please send a POST request.";
}
?>
