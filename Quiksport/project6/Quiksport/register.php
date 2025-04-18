<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title = 'Register'; ?></title>
    <link rel="stylesheet" href="includes/error.css"> <!-- Link to your external CSS file -->
</head>

<?php # register.php 
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Register';
include ('includes/header.php');

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $errors = array(); // Initialize an error array.
    
    // Check for a first name:
    if (empty($_POST['first_name'])) {
        $errors[] = 'You forgot to enter your first name.';
    } else {
        $fn = trim($_POST['first_name']);
    }
    
    // Check for a last name:
    if (empty($_POST['last_name'])) {
        $errors[] = 'You forgot to enter your last name.';
    } else {
        $ln = trim($_POST['last_name']);
    }

    // Check for an email address:
    if (empty($_POST['email'])) {
        $errors[] = 'You forgot to enter your email address.';
    } else {
        $e = trim($_POST['email']);
    }

    // Check for a phone number:
    if (empty($_POST['phone'])) {
        $errors[] = 'You forgot to enter your phone number.';
    } else {
        $phone = trim($_POST['phone']);
    }
    
    // Check for a password and match against the confirmed password:
    if (!empty($_POST['pass1'])) {
        if ($_POST['pass1'] != $_POST['pass2']) {
            $errors[] = 'Your password did not match the confirmed password.';
        } else {
            $p = trim($_POST['pass1']);
        }
    } else {
        $errors[] = 'You forgot to enter your password.';
    }
    
    if (empty($errors)) { // If everything's OK.
    
        // Register the user in the database...
        
        require ('../mysqli_connect.php'); // Connect to the db.

        // Make the query:
        $q = "INSERT INTO users (first_name, last_name, email, phone_No, password, registration_date) 
              VALUES ('$fn', '$ln', '$e', '$phone', SHA1('$p'), NOW() )";        
        $r = mysqli_query ($dbc, $q); // Run the query.
        if ($r) { // If it ran OK.

            // Redirect to the login page
            header("Location: login.php");
            exit(); // Ensure no further code is executed after the redirect   

        } else { // If it did not run OK.
    
            // Public message:
            echo '<h1>System Error</h1>
            <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
    
            // Debugging message:
            echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';

        } // End of if ($r) IF.

        mysqli_close($dbc); // Close the database connection.
        
        // Include the footer and quit the script:
        include ('includes/footer.html'); 
        exit();
        
    } else { // Report the errors.
    
        echo '<h1>Error!</h1>
        <div class="error-container">
        <p class="error">The following error(s) occurred:</p>';
        foreach ($errors as $msg) { // Print each error.
            echo "<div class='error-item'> - $msg</div>";
        }
        echo '</div><p>Please try again.</p><p><br /></p>';
        
    } // End of if (empty($errors)) IF.

} // End of the main Submit conditional.
?>
<!-- Main Content -->
<div id="form-container">
    <h1>Register</h1>
    <form action="register.php" method="post">
        <p>First Name: <input type="text" name="first_name" size="15" maxlength="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" /></p>
        <p>Last Name: <input type="text" name="last_name" size="15" maxlength="40" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /></p>
        <p>Email Address: <input type="text" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /></p>
        <p>Phone Number: <input type="text" name="phone" size="15" maxlength="15" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>" /></p>
        <p>Password: <input type="password" name="pass1" size="10" maxlength="20" /></p>
        <p>Confirm Password: <input type="password" name="pass2" size="10" maxlength="20" /></p>
        <p><input type="submit" name="submit" value="Register" /></p>
    </form>
</div>
<?php include ('includes/footer.php'); ?>
