<?php 
// This script retrieves all the records from the users and creditcard tables.
// It displays user details along with their credit card information.

$page_title = 'View the Current Users and Credit Card Info';
include ('includes2/header.html');
echo '<h1>Registered Users and Their Credit Card Information</h1>';

require ('../mysqli_connect.php');

// Define the INNER JOIN query:
$q = "SELECT 
        users.user_id, 
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
    ORDER BY users.registration_date ASC";

$r = @mysqli_query($dbc, $q);

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it runs ok it will display the records.

    // Print how many users there are
    echo "<p>There are currently $num records displaying users with their credit card information.</p>\n";

    // Create table header
    echo '<div class="table-container">
    <table>
    <thead>
        <tr>
            <th>Edit</th>
            <th>Delete</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Credit Card Number</th>
            <th>Expiration Date</th>
            <th>CCSN</th>
        </tr>
    </thead>
    <tbody>
    ';
    
    // Fetch and print all the records:
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        echo '<tr>
            <td><a href="edit_user.php?id=' . $row['user_id'] . '" class="btn">Edit</a></td>
            <td><a href="delete_user.php?id=' . $row['user_id'] . '" class="btn btn-danger">Delete</a></td>
            <td>' . htmlspecialchars($row['first_name']) . '</td>
            <td>' . htmlspecialchars($row['last_name']) . '</td>
            <td>' . htmlspecialchars($row['email']) . '</td>
            <td>' . htmlspecialchars($row['phone_No']) . '</td>
            <td>****' . substr($row['CCNum'], -4) . '</td>
            <td>' . htmlspecialchars($row['CCEXPDate']) . '</td>
            <td>*</td>
        </tr>
        ';
    }

    echo '</tbody>
    </table>
    </div>';
    mysqli_free_result($r); // Free memory associated with $r    

} else { // If no records were returned.
    echo '<p class="error">There are currently no records to display.</p>';
}

mysqli_close($dbc); // Close database connection

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

    .table-container {
        max-width: 90%;
        margin: 30px auto;
        overflow-x: auto;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 0 auto;
    }

    table th, table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    table th {
        background-color: #007BFF;
        color: #ffffff;
        font-weight: bold;
    }

    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    table tr:hover {
        background-color: #f1f1f1;
    }

    .btn {
        text-decoration: none;
        padding: 8px 12px;
        background-color: #007BFF;
        color: #ffffff;
        border-radius: 4px;
        text-align: center;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .btn-danger {
        background-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #b21f2d;
    }

    .error {
        color: red;
        text-align: center;
        margin: 20px 0;
    }
</style>
