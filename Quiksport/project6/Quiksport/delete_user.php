<?php 
// This page is for deleting a user record along with their credit card details.
// This page is accessed through view_users.php.

$page_title = 'Delete a User';
include ('includes2/header.html');  
echo '<h1>Delete a User</h1>';

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
    $id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { 
    $id = $_POST['id'];
} else { 
    echo '<p class="error">This page has been accessed in error.</p>';
    include ('includes2/footer.html'); 
    exit();
}

require ('../mysqli_connect.php');

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['sure'] == 'Yes') { // Delete the record.

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
            } else {
                echo '<p class="error">The user could not be deleted.</p>';
            }
        } else {
            echo '<p class="error">The credit card could not be deleted.</p>';
        }

    } else { 
        echo '<p class="success">The user has NOT been deleted.</p>';
    }

} else { // Show the form.

    // Retrieve the user's information
    $q = "SELECT 
            users.first_name, 
            users.last_name, 
            users.email, 
            users.phone_No, 
            creditcard.CCNum, 
            creditcard.CCEXPDate, 
            creditcard.CCSN 
        FROM users 
        INNER JOIN creditcard 
        ON users.user_id = creditcard.user_id 
        WHERE users.user_id = ?";
    $stmt = $dbc->prepare($q);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) { 
        $row = $result->fetch_assoc();
        
        // Form to delete user info as admin
        echo "<div class='form-container'>
        <h3>Name: {$row['first_name']} {$row['last_name']}</h3>
        <p>Email: {$row['email']}</p>
        <p>Phone: {$row['phone_No']}</p>
        <p>Are you sure you want to delete this user details?</p>
        
        <form action='delete_user.php' method='post'>
        <label><input type='radio' name='sure' value='Yes' /> Yes </label>
        <label><input type='radio' name='sure' value='No' checked='checked' /> No</label>
        <input type='submit' name='submit' value='Submit' class='btn-primary'/>
        <input type='hidden' name='id' value='" . htmlspecialchars($id) . "' />
        </form>
        </div>";
    } else {
        echo '<p class="error">User not found or invalid user ID.</p>';
    }
    
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
    display: inline-flex;  
    align-items: center;   
    margin-right: 20px;  
}

.form-container input[type="radio"] {
    margin-right: 5px;     
    vertical-align: middle; 
}


    .form-container input[type="text"],
    .form-container input[type="submit"] {
        width: auto;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .form-container input[type="radio"],
    .form-container input[type="submit"] {
        width: auto;
        margin-bottom: 20px;
        margin-right: 10px; 
        padding: 10px;
    }

    .form-container input[type="submit"] {
        margin-top: 10px; 
        padding: 15px 30px;
        width: auto; 
    }

    .form-container input[type="radio"]:not(:last-child) {
        margin-right: 20px;
    }

    .form-container input[type="submit"].btn-primary {
        background-color: #007BFF;
        color: #fff;
        border: none;
        cursor: pointer;
        padding: 15px 30px;
    }

    .form-container input[type="submit"].btn-primary:hover {
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
