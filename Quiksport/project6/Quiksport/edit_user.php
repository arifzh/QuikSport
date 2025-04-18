<?php 
// This page is for editing a user record.
// This page is accessed through view_users.php.

$page_title = 'Edit a User';
include ('includes2/header.html');
echo '<h1>Edit a User</h1>';

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From view_users.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	include ('includes2/footer.html'); 
	exit();
}

require ('../mysqli_connect.php'); 

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = array(); // Collect error messages
	
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
	if (empty($_POST['phone_No'])) {
		$errors[] = 'You forgot to enter your phone number.';
	} else {
		$pn = trim($_POST['phone_No']);
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Test for unique email address:
		$q = "SELECT user_id FROM users WHERE email='$e' AND user_id != $id";
		$r = @mysqli_query($dbc, $q);
		if (mysqli_num_rows($r) == 0) {

			// Make the query:
			$q = "UPDATE users SET first_name='$fn', last_name='$ln', email='$e', phone_No='$pn' WHERE user_id=$id LIMIT 1";
			$r = @mysqli_query ($dbc, $q);
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Print a message:
				echo '<p class="success">The user has been edited.</p>';	
				
			} else { // If it did not run OK.
				echo '<p class="error">The user could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
			}
				
		} else { // Already registered.
			echo '<p class="error">The email address has already been registered.</p>';
		}
		
	} else { // Report the errors.

		echo '<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p>';
	
	} // End of if (empty($errors)) IF.

} // End of submit conditional.

// Retrieve the user's information:
$q = "SELECT first_name, last_name, email, phone_No FROM users WHERE user_id=$id";		
$r = @mysqli_query ($dbc, $q);

if (mysqli_num_rows($r) == 1) { // If valid user ID, show the form.

	// Get the user's information:
	$row = mysqli_fetch_array ($r, MYSQLI_NUM);
	
	// Form to edit user info
	echo '<form action="edit_user.php" method="post" class="form-container">
<p><label for="first_name">First Name:</label> <input type="text" name="first_name" id="first_name" size="15" maxlength="15" value="' . htmlspecialchars($row[0]) . '" /></p>
<p><label for="last_name">Last Name:</label> <input type="text" name="last_name" id="last_name" size="15" maxlength="30" value="' . htmlspecialchars($row[1]) . '" /></p>
<p><label for="email">Email Address:</label> <input type="text" name="email" id="email" size="20" maxlength="60" value="' . htmlspecialchars($row[2]) . '"  /> </p>
<p><label for="phone_No">Phone Number:</label> <input type="text" name="phone_No" id="phone_No" size="15" maxlength="15" value="' . htmlspecialchars($row[3]) . '" /></p>
<p><input type="submit" name="submit" value="Submit" class="btn btn-primary" /></p>
<input type="hidden" name="id" value="' . $id . '" />
</form>';

} else { // Not a valid user ID.
	echo '<p class="error">This page has been accessed in error.</p>';
}

mysqli_close($dbc);
		
include ('includes2/footer.html');
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    h1 {
        text-align: center;
        color: #333;
        margin-top: 20px;
    }

    .form-container {
        max-width: 600px;
        margin: 30px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .form-container label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #555;
    }

    .form-container input[type="text"],
    .form-container input[type="submit"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn-primary {
        background-color: #007BFF;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .error {
        color: #dc3545;
        text-align: center;
        margin: 20px 0;
    }

    .success {
        color: #28a745;
        text-align: center;
        margin: 20px 0;
    }
</style>
