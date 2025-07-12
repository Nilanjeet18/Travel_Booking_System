<?php
session_start();

// Destroy session to log the user out
session_unset();  // Removes all session variables
session_destroy();  // Destroys the session

// Redirect to login page
header("Location: login.php");
exit();
?>
