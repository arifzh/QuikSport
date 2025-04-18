<?php
session_start();
$page_title = 'Booking Page';
include('assets/header.php');
require('../mysqli_connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Center form container */
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 25px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Heading styling */
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 1.5rem;
            font-weight: 600;
        }

        /* Form group styling */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 6px;
            color: #555;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #007BFF;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
        }

        .form-group select {
            background-color: #fff;
        }

        /* Submit button */
        .form-group button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        /* Error and Success Messages */
        .error, .success {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .error {
            color: red;
        }

        .success {
            color: #28a745;
        }

        /* Media Query for Smaller Devices */
        @media (max-width: 600px) {
            .form-container {
                padding: 15px;
                margin: 20px;
            }

            .form-container h2 {
                font-size: 1.2rem;
            }

            .form-group input,
            .form-group select,
            .form-group button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<?php
$id = $_SESSION['user_id'];  // Get user ID from session

// Fetch user information
$q = "SELECT first_name, last_name, email, phone_No FROM users WHERE user_id=$id";
$r = @mysqli_query($dbc, $q);

if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

    // Get the user's information:
    $row = mysqli_fetch_array($r, MYSQLI_NUM);

    // Display user information form
    echo '<div class="form-container"><form action="tqbooking.php" method="post">
            <h2>Book Your Venue</h2>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" maxlength="15" value="' .($row[0]). '" />
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" maxlength="30" value="' .($row[1]). '" />
            </div>
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="text" id="email" name="email" maxlength="60" value="' .($row[2]). '" />
            </div>
            <div class="form-group">
                <label for="phone_No">Phone Number:</label>
                <input type="text" id="phone_No" name="phone_No" maxlength="60" value="' .($row[3]). '" />
            </div>
            <div class="form-group">
                <label for="venue_id">Select Venue:</label>
                <select id="venue_id" name="venue_id" required>
                    <option value="">--Select Venue--</option>';

    // Query to select VenueID and VenueName
    $q = "SELECT VenueID, VenueName FROM venue";
    $r = @mysqli_query($dbc, $q);

    if ($r) { // Check if query ran successfully
        if (mysqli_num_rows($r) > 0) { // If rows are found
            while ($venue = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                echo '<option value="' . htmlspecialchars($venue['VenueID']) . '">' . htmlspecialchars($venue['VenueName']) . '</option>';
            }
        } else {
            echo '<option value="">No venues available</option>';
        }
    } else {
        echo '<option value="">Error fetching venues</option>';
    }

    echo '</select></div>
            <div class="form-group">
                <button type="submit">Book Venue</button>
            </div>
        </form></div>';

} else { // Not a valid user ID
    echo '<p class="error">This page has been accessed in error.</p>';
}

// Close the database connection
mysqli_close($dbc);

include('assets/footer.php');
?>

</body>
</html>
