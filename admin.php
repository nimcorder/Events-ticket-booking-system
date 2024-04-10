<?php
// Include the necessary files
include 'conn.php';
session_start();

// Check if the user is not logged in or is not an admin, then redirect to the login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the admin's ID from the session
$admin_id = $_SESSION['admin_id'];

// Retrieve the admin's name from the database
$admin_query = "SELECT username FROM admins WHERE admin_id = $admin_id";
$admin_result = $conn->query($admin_query);

// Check if the query was successful
if ($admin_result === false) {
    die("Error: " . $conn->error); // Output error message and stop execution
}

// Fetch the admin's data
if ($admin_result->num_rows > 0) {
    $admin_data = $admin_result->fetch_assoc();
    $admin_name = $admin_data['username'];
} else {
    // Handle the case where admin data is not found
    $admin_name = "Admin";
}

// Fetch events data from the database for the current admin only
$events_query = "SELECT * FROM events WHERE admin_id = $admin_id";
$events_result = $conn->query($events_query);

// Check if the query was successful
if ($events_result === false) {
    die("Error: " . $conn->error); // Output error message and stop execution
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    .reduce{
        align-items: center;
        padding: 5%;
    }
    table {
        width: 100%;
        color: #FFF;
        border-collapse: collapse;
        background-color: #333;
        /* Deep dark grey background */
    }

    table th,
    table td {
        border: 1px solid #222;
        /* Border color for cells */
        padding: 8px;
        text-align: center;
    }

    table th {
        background-color: #555;
        /* Dark grey background for header */
        color: white;
    }

    table tr {
        max-width: 100px;
        /* Maximum width for rows */
        border-bottom: 3px solid yellow;
        /* Thick yellow bottom border for rows */
    }

    /* Style for hover effect */
    table tr:hover {
        background-color: #444;
        /* Dark grey background on hover */
    }
</style>

<body>
    <header>
        <div class="logo">
            <h1>TBSK</h1>
        </div>
        <div class="menu_nav"><a href="index.php">home</a></div>
        <div class="menu_nav"><a href="#"></a></div>
        
        <div class="menu_nav">
            <h3>
                welcome:
                <?php echo $admin_name; ?>
            </h3>
        </div><div class="menu_nav"><h3><a href="logout.php">Logout</a></h3></div>

    </header><br><br><br><br><br>
    <div class="container">
        <div class="header">
            <div class="header">
                <h1>Events Ticket booking System.</h1>

            </div>
        </div>
    </div>
    <div class="menu">
        <a href="manage_events.php">Manage Events</a>
        <a href="view_reservations.php">View Reservations</a>
        <a href="add_event.php">Add New Event</a>
        <!-- Add more links/buttons for other administrative functions -->
    </div>
    <div class="content">
       <div class="reduce">
       <h2>All Events</h2>
        <?php if ($events_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Event Title</th>
                    <th>Date of Event</th>
                    <th>Maximum Attendees</th>
                    <th>Ticket Price for (VIP)</th>
                    <th>Ticket Price for (Regular)</th>
                    <!-- Add more columns as needed -->
                </tr>
                <?php while ($row = $events_result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php echo $row['title']; ?>
                        </td>
                        <td>
                            <?php echo $row['date']; ?>
                        </td>
                        <td>
                            <?php echo $row['max_attendees']; ?>
                        </td>
                        <td>
                            <?php echo $row['ticket_price_vip']; ?>
                        </td>
                        <td>
                            <?php echo $row['ticket_price_regular']; ?>
                        </td>
                        <!-- Add more cells for additional event details -->
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No events found.</p>
        <?php endif; ?>
       </div>
    </div>

    <div class="footer">
            <p>&copy; 2024 Ticket Booking Systed @nimcorder</p>
        </div>

</body>

</html>