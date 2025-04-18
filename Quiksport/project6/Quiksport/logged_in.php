<?php
// Start a session to check if the user is logged in
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

// Get the user's full name
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];

// Include the header
$page_title = "Logged In";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged In</title>
    <link rel="stylesheet" href="assets/css/loggin.css">
</head>
<body>

    <!-- Logged In Message -->
    <div class="logged-in-message">
        <h1>You have logged in, <?= htmlspecialchars($first_name . ' ' . $last_name) ?>!</h1>
        <p></p>
    </div>

    <!-- Home Button -->
    <div class="home-button-container">
        <a href="index.php" class="home-btn">Go to Home Page</a>
    </div>

</body>
</html>
