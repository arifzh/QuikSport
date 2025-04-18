<?php
session_start();
$page_title = "Account Deleted";
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

    <!-- Account deleted message -->
    <div class="logout-message">
        <h1>You have deleted your account!</h1>
    </div>

    <!-- Button to go to login -->
    <div class="next-button-container">
        <a href="login.php" class="next-btn">Go to Login</a>
    </div>

</body>
</html>

