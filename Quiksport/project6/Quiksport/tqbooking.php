<?php
session_start();

// Include database connection
require('../mysqli_connect.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize inputs
    $user_id = $_SESSION['user_id']; // User ID from session
    $first_name = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
    $last_name = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
    $phone_no = mysqli_real_escape_string($dbc, trim($_POST['phone_No']));
    $venue_id = mysqli_real_escape_string($dbc, trim($_POST['venue_id']));

    // Insert booking into the database
    $q = "INSERT INTO booking (user_id, venueID) VALUES ($user_id, $venue_id)";
    $r = @mysqli_query($dbc, $q);

    if ($r) {
        echo "<h1><center>Thank you, $first_name. Your booking has been successfully submitted!</center></h1>";
    } else {
        echo '<p class="error">An error occurred. Please try again later.</p>';
        echo '<p>' . mysqli_error($dbc) . '</p>'; // For debugging only, remove in production
    }

    // Close the database connection
    mysqli_close($dbc);
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThankYou</title>
    <link rel="stylesheet" href="assets/css/loggin.css">
</head>
<body>
    <!-- Home Button -->
    <div class="home-button-container">
        <a href="index.php" class="home-btn">Go to Home Page</a>
    </div>

</body>
</html>