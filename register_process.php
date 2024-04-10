<?php
// Include the database connection file
include '../database/conn.php';

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password for security (you should use a stronger hashing algorithm in production)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Set the default role to 'user'
$role = 'user';

// Insert user data into the database
$sql = "INSERT INTO users (name, email, password, role)
        VALUES ('$name', '$email', '$hashedPassword', '$role')";

if ($conn->query($sql) === TRUE) {
    echo "User registered successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
