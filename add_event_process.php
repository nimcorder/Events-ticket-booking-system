<?php
// Include the database connection file
include 'conn.php';
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Retrieve admin ID from session
$admin_id = $_SESSION['admin_id'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $date = $_POST['date'];
    $max_attendees = $_POST['max_attendees'];
    $ticket_price_vip = $_POST['ticket_price_vip'];
    $ticket_price_regular = $_POST['ticket_price_regular'];

    // Insert event data into the database, including admin_id
    $sql = "INSERT INTO events (admin_id, title, date, max_attendees, ticket_price_vip, ticket_price_regular)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssdd", $admin_id, $title, $date, $max_attendees, $ticket_price_vip, $ticket_price_regular);

    if ($stmt->execute()) {
        // Event added successfully, redirect to add_event.php with success parameter
        header("Location: admin.php?success=1");
        exit();
    } else {
        // Error occurred
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
