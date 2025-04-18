<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="includes/error.css"> <!-- Link to external CSS file -->
</head>
<body>
<?php
// Include header
$page_title = 'Login';
include('includes/header.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$admin_email = "ariffahmi26@gmail.com";

// Process login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array(); // Initialize error array

    // Validate email
    if (empty($_POST['email'])) {
        $errors[] = 'You forgot to enter your email address.';
    } else {
        $e = trim($_POST['email']);
    }

    // Validate password
    if (empty($_POST['pass'])) {
        $errors[] = 'You forgot to enter your password.';
    } else {
        $p = trim($_POST['pass']);
    }

    if (empty($errors)) { // If no errors
        require('../mysqli_connect.php'); // Connect to the database

        // Query to check user credentials
        $q = "SELECT user_id, first_name, last_name FROM users WHERE email='$e' AND password=SHA1('$p')";
        $r = mysqli_query($dbc, $q); // Execute query

        if (mysqli_num_rows($r) == 1) { // If user found in the database
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

            // Store user information in session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];

            // Check if the user is the admin
            if ($e === $admin_email) {
                $_SESSION['is_admin'] = true;
                header("Location: view_users.php");
            } else {
                $_SESSION['is_admin'] = false;
                header("Location: logged_in.php");
            }
            exit();
        } else {
            $errors[] = 'The email or password is incorrect.';
        }

        mysqli_close($dbc); // Close database connection
    }
}
?>

<!-- Login Form -->
<div id="form-container">
    <h1>Login</h1>
    <?php
    if (!empty($errors)) {
        echo '<div class="error-container">';
        echo '<p class="error">The following error(s) occurred:</p>';
        foreach ($errors as $msg) {
            echo "<div class='error-item'> - $msg</div>";
        }
        echo '</div>';
    }
    ?>
    <form action="login.php" method="post">
        <p>Email Address: 
            <input type="text" name="email" size="20" maxlength="60" 
            value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>" />
        </p>
        <p>Password: 
            <input type="password" name="pass" size="10" maxlength="20" 
            value="<?php if (isset($_POST['pass'])) echo htmlspecialchars($_POST['pass']); ?>" />
        </p>
        <p><input type="submit" name="submit" value="Login" /></p>
    </form>
    <p><a href="register.php">Don't have an account? Register here.</a></p>
</div>

<?php include('includes/footer.php'); ?>
</body>
</html>
