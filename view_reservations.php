<?php
// Include the necessary files
include 'conn.php';
session_start();

// Check if the user is logged in and is an admin
if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
} else {
    // Redirect to the login page if the admin is not logged in
    header("Location: login.php");
    exit();
}
// Fetch reservations data along with event details from the database
$reservations_query = "SELECT r.*, e.title AS event_title, e.max_attendees AS total_tickets, (e.max_attendees - COUNT(r.event_id)) AS tickets_pending 
                       FROM reservations r
                       INNER JOIN events e ON r.event_id = e.event_id  
                       WHERE e.admin_id = $admin_id
                       GROUP BY r.event_id";
$reservations_result = $conn->query($reservations_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reservations</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    table {
        width: 100%;
        text-align: center;
        background-color: #222;
        border-radius: 5px;
        font-size: 17px;
        padding: 20px;
        margin-bottom: 20px;
        border: 5px solid;
        border-image: linear-gradient(to right, #222, #FFD700);
        border-image-slice: 1;
    }

    th {
        padding: 20px;
        background-color: #222;
        font-size: 24px;
        color: #FFD700;
    }
    td{
        background-color: #0f0f00;
        color: #fff;
    }

    section {
        display: flex;
        flex-direction: column;
        height: min-content;

    }
</style>

<body>
    <header>
        <div class="logo">
            <h1>TBSK</h1>
        </div>
        <div class="menu_nav"><a href="index.php">home</a></div>
        <div class="menu_nav"><a href="logout.php">Logout</a></div>


    </header><br><br><br><br>
    <div class="header">
        <div class="menu">
            <a href="admin.php">Back to Dashboard</a>
            <a href="manage_events.php">Manage Events</a>
            <a href="view_reservations.php">View Reservations</a>
            <a href="add_event.php">Add New Event</a>
            <!-- Add more links/buttons for other administrative functions -->
        </div>
    </div><br>
    <section>
        <div class="container">

            <div class="content">
                <center><h2>Reservations</h2></center>
                
                <?php if ($reservations_result->num_rows > 0): ?>
                    <table>
                        <tr>
                            <th>Event Title</th>
                            <th>Total Tickets</th>
                            <th>Booked Tickets</th>
                            <th>Pending Tickets</th>
                            <!-- Add more columns as needed -->
                        </tr>
                        <?php while ($row = $reservations_result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?php echo $row['event_title']; ?>
                                </td>
                                <td>
                                    <?php echo $row['total_tickets']; ?>
                                </td>
                                <td>
                                    <?php
                                    echo $row['total_tickets'] - $row['tickets_pending'];
                                    ?>
                                </td>
                                <td>
                                    <?php echo $row['tickets_pending']; ?>
                                </td>
                                <!-- Add more cells for additional reservation details -->
                            </tr>
                        <?php endwhile; ?>
                    </table>
                <?php else: ?>
                    <p>No reservations yet.</p>
                <?php endif; ?>
            </div>

        </div>
        <div class="container">

            <div class="content">
                <center><h2>Reservers</h2></center>
                
                <?php
                $sql = "SELECT r.*, e.title AS event_title, u.name AS user_name
                FROM reservations r
                LEFT JOIN events e ON r.event_id = e.event_id
                LEFT JOIN users u ON r.user_id = u.user_id
                WHERE e.admin_id = $admin_id";
        
        
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table border='1'>
                    <tr>
                        <th>Event Title</th>
                        <th>Booked By</th>
                        <th>Ticket Type</th>
                    </tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo 
                        "<tr>
                        <td>" . $row['event_title'] . "</td>
                        <td>" . $row['user_name'] . "</td>
                        <td>" . $row['ticket_type'] . "</td>
                    </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No Tickets reserved yet";
                }
                // Close the database connection
                $conn->close();
                ?>

            </div>

        </div>

    </section>
    <div class="footer">
        <p>&copy; 2024 Ticket Booking System by isack newton</p>
    </div>
</body>

</html>