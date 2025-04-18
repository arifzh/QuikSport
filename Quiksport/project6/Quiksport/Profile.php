<?php
session_start();

$page_title = 'Profile Page';
include('assets/header.php');

require ('../mysqli_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .form-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group input:focus {
            border-color: #007BFF;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
        }

        .form-group button {
            width: 100%;
            padding: 10px;
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

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        
        .success {
        color: #28a745;
        text-align: center;
        margin: 20px 0;
    }
    </style>
</head>
<body>

<?php 
// Check for a valid user ID, through GET or POST:
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} elseif (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

// Update user data in database
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone_No = trim($_POST['phone_No']);

    $q = "UPDATE users SET first_name=?, last_name=?, email=?, phone_No=? WHERE user_id=?";
    $stmt = mysqli_prepare($dbc, $q);

    mysqli_stmt_bind_param($stmt, 'ssssi', $first_name, $last_name, $email, $phone_No, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo '<p class="success">The user has been updated successfully.</p>';
    } else {
        echo '<p class="error">The user could not be updated due to a system error.</p>';
    }

    mysqli_stmt_close($stmt);
}

//Add credit card to database
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_credit_card'])) {
    $ccnum = trim($_POST['ccnum']);
    $ccexpdate = trim($_POST['ccexpdate']);
    $ccsn = trim($_POST['ccsn']);

    $expdate_parts = explode('/', $ccexpdate);
    if (count($expdate_parts) == 2) {
        $month = str_pad($expdate_parts[0], 2, '0', STR_PAD_LEFT);
        $year = $expdate_parts[1];
        $ccexpdate = "$year-$month-01";
    } else {
        echo '<p class="error">Invalid expiration date format. Use MM/YYYY.</p>';
        exit();
    }

    $q = "INSERT INTO creditcard (user_id, CCNum, CCEXPDate, CCSN) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($dbc, $q);

    mysqli_stmt_bind_param($stmt, 'isss', $id, $ccnum, $ccexpdate, $ccsn);

    if (mysqli_stmt_execute($stmt)) {
        echo '<p class="success">The credit card has been added successfully.</p>';
    } else {
        echo '<p class="error">The credit card could not be added due to a system error.</p>';
    }
    mysqli_stmt_close($stmt);
}

// Delete user account
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    if (isset($_POST["sure"]) && $_POST["sure"] == "Yes") { // Delete the record.

        // Delete from creditcard table first
        $q1 = "DELETE FROM creditcard WHERE user_id = ?";
        $stmt1 = $dbc->prepare($q1);
        $stmt1->bind_param('i', $id);
        $stmt1->execute();

        if ($stmt1->affected_rows > 0) {
            // Then delete from users table
            $q2 = "DELETE FROM users WHERE user_id = ?";
            $stmt2 = $dbc->prepare($q2);
            $stmt2->bind_param('i', $id);
            $stmt2->execute();

            if ($stmt2->affected_rows > 0) {
                echo '<p class="success">The user and their associated credit card have been deleted.</p>';
                header("Location: deleted.php");
            exit();
            } else {
                echo '<p class="error">The user could not be deleted.</p>';
            }
        } else {
            echo '<p class="error">The credit card could not be deleted.</p>';
        }

    } else { 
        echo '<p class="success">The user has NOT been deleted.</p>';
    }
}

// Retrieve the user's information
$q = "SELECT first_name, last_name, email, phone_No FROM users WHERE user_id=?";
$stmt = mysqli_prepare($dbc, $q);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) == 1) {
    mysqli_stmt_bind_result($stmt, $first_name, $last_name, $email, $phone_No);
    mysqli_stmt_fetch($stmt);

    //Form for updating user info
    echo '<div class="form-container">
        <h2>Update User Information</h2>
        <form action="profile.php" method="post" class="form-group">
            <label>First Name:</label>
            <input type="text" name="first_name" value="' . htmlspecialchars($first_name) . '" />
            <label>Last Name:</label>
            <input type="text" name="last_name" value="' . htmlspecialchars($last_name) . '" />
            <label>Email:</label>
            <input type="text" name="email" value="' . htmlspecialchars($email) . '" />
            <label>Phone Number:</label>
            <input type="text" name="phone_No" value="' . htmlspecialchars($phone_No) . '" />
            <button type="submit" name="update_user">Update User</button>
            <input type="hidden" name="id" value="' . htmlspecialchars($id) . '" />
        </form>
    </div>';

    //Form for adding credit card info
    echo '<div class="form-container">
        <h2>Add Credit Card</h2>
        <form action="profile.php" method="post" class="form-group">
            <label>Credit Card Number:</label>
            <input type="text" name="ccnum" />
            <label>Expiration Date (MM/YYYY):</label>
            <input type="text" name="ccexpdate" />
            <label>Security Number:</label>
            <input type="text" name="ccsn" />
            <button type="submit" name="add_credit_card">Add Credit Card</button>
            <input type="hidden" name="id" value="' . htmlspecialchars($id) . '" />
        </form>
    </div>';

    //Form to delete user account
    echo '<div class="form-container">
        <h2>Delete Account</h2>
        <form action="Profile.php" method="post" class="form-group">
        <label><input type="radio" name="sure" value="Yes" /> Yes </label>
        <label><input type="radio" name="sure" value="No" checked="checked" /> No</label>
        <input type="submit" name="delete" value="Submit" class="btn-primary"/>
        <input type="hidden" name="id" value="' . htmlspecialchars($id) . '" />
        </form>
    </div>';
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
}

mysqli_stmt_close($stmt);
mysqli_close($dbc); 
include('assets/footer.php');
?>
</body>
</html>
