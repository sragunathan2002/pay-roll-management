<?php
// Start session to access session variables
session_start();

// Destroy the session
session_unset();  // Clears all session variables
session_destroy(); // Destroys the session

// Redirect to login page after logout
header("Location: login.php");
exit();  // Ensure that no further code is executed
?>
