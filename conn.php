<?php
// Database configuration
$servername = "localhost"; // Change if your MySQL server is hosted elsewhere
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP
$dbname = "booking"; // Name of the database you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
