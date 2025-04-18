<?php
session_start();
session_destroy();  // Destroys the session

// Redirect to logout confirmation page
header("Location: logged_out.php");
exit();
?>
