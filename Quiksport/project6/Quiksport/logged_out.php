<?php
session_start();
$page_title = "Logged Out";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out</title>
    <link rel="stylesheet" href="assets/css/logged.css">
</head>
<body>

    <!-- Logged Out Message -->
    <div class="logout-message">
        <h1>You have logged out!</h1>
    </div>

    <!-- Go to login page -->
    <div class="next-button-container">
        <a href="login.php" class="next-btn">Go to Login</a>
    </div>

</body>
</html>

