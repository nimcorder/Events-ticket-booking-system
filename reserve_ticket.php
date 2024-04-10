<?php
// Include the necessary files
include 'conn.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if form is submitted
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $event_id = $_POST['event_id'];
    $ticket_type = $_POST['ticket_type']; // VIP or Regular

    // Count the number of reservations made by the user for the event
    $count_query = "SELECT COUNT(*) AS total_reservations FROM reservations WHERE user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($count_query);
    $stmt->bind_param("ii", $_SESSION['user_id'], $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_reservations = $row['total_reservations'];
    $stmt->close();

    // Check if the user has already reserved five tickets for the event
    if ($total_reservations >= 5) {
        // Alert the user that they cannot reserve more than five tickets for the event
        echo '<script>alert("You can only reserve up to five tickets for this event."); window.location.href = "index.php";</script>';
        exit(); // Stop further execution
    }

    // Perform reservation logic here
    // This is where you would typically insert the reservation into a database table

    // Example reservation logic:
    $reservation_query = "INSERT INTO reservations (user_id, event_id, ticket_type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($reservation_query);
    $stmt->bind_param("iis", $_SESSION['user_id'], $event_id, $ticket_type);
    $reservation_successful = $stmt->execute();
    $stmt->close();

    if ($reservation_successful) {
        // Reservation successful, display JavaScript alert
        echo '<script>alert("Ticket reserved successfully!"); window.location.href = "index.php";</script>';
    } else {
        // Reservation failed
        echo "Reservation failed.";
    }
} else {
    // If form is not submitted, redirect back to events page
    header("Location: index.php");
    exit();
}

?>
