<?php
// Database connection
$servername = ""; // Update with your servername	
$username = ""; // Update with your db username
$password = "";     // Update with your db password
$dbname = "payroll_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
