<?php
// Include the database connection file
include 'conn.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Retrieve form data
$email = $_POST['email'];
$password = $_POST['password'];

// Check if the submitted email exists in the users table
$user_query = "SELECT * FROM users WHERE email = '$email'";
$user_result = $conn->query($user_query);

// Check if the submitted email exists in the admins table
$admin_query = "SELECT * FROM admins WHERE email = '$email'";
$admin_result = $conn->query($admin_query);

// Check if either a user or an admin with the submitted email exists
if ($user_result->num_rows > 0) {
    // User authentication
    $user_data = $user_result->fetch_assoc();
    if (password_verify($password, $user_data['password'])) {
        // User authentication successful
        session_start();
        $_SESSION['user_id'] = $user_data['user_id'];
        $_SESSION['username'] = $user_data['username'];
        $_SESSION['role'] = 'user';
        header("Location: index.php"); // Redirect user to home.php
        exit();
    } else {
        // Invalid password for user
        header("Location: login.php?error=invalid");
        exit();
    }
} elseif ($admin_result->num_rows > 0) {
    // Admin authentication
    $admin_data = $admin_result->fetch_assoc();
    if (password_verify($password, $admin_data['password'])) {
        // Admin authentication successful
        session_start();
        $_SESSION['admin_id'] = $admin_data['admin_id'];
        $_SESSION['username'] = $admin_data['username'];
        $_SESSION['role'] = 'admin';
        header("Location: admin.php"); // Redirect admin to their dashboard
        exit();
    } else {
        // Invalid password for admin
        header("Location: login.php?error=invalid");
        exit();
    }
} else {
    // Email does not exist in either users or admins table
    header("Location: login.php?error=invalid");
    exit();
}

// Close the database connection
$conn->close();
?>
