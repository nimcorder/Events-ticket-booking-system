<?php
session_start();

// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
include 'conn.php';
$name = '';

// Check if a regular user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_query = "SELECT name FROM users WHERE user_id = $user_id";
    $user_result = $conn->query($user_query);

    if ($user_result->num_rows > 0) {
        $user_data = $user_result->fetch_assoc();
        $name = $user_data['name'];
    }
}

// Check if an admin is logged in
if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
    $admin_query = "SELECT username FROM admins WHERE admin_id = $admin_id";
    $admin_result = $conn->query($admin_query);

    if ($admin_result->num_rows > 0) {
        $admin_data = $admin_result->fetch_assoc();
        $name = $admin_data['username'];
    }
}

// Fetch events data from the database
$events_query = "SELECT * FROM events";
$events_result = $conn->query($events_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Ticket Booking System</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    /* Global styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 90%;
        margin: 0 auto;
        padding: 20px;
    }

    /* Header styles */

    .logo h1 {
        margin: 0;
    }

    .menu_nav {
        display: inline-block;
        margin: 0 10px;
    }

    .container {
        width: 90%;
        margin: 0 auto;
        padding: 20px;
    }

    .events-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .event-card {
        display: flex;
        width: 550px;
        text-align: center;
        background-color: aqua;
        border-radius: 5px;
        font-size: 20px;
        padding: 20px;
        margin-bottom: 20px;
        border: 5px solid;
        border-image: linear-gradient(to right, #ddd, #FFD700);
        border-image-slice: 1;
    }


    .event-card .description {
        padding: 10px;
        text-align: center;
        background-image: url("https://rb.gy/nqce8g");
        height: 200px;
        width: 100%;
        background-color: unset;
        color: black;
        font-size: 20px;
        border: 5px solid;
        border-image: linear-gradient(to right, #ddd, #FFD700);
        border-image-slice: 1;
    }





    .event-card p {
        margin: 10px 0;
    }

    .reserve-button {
        background-color: #333;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    td {
        padding-left: 30px;
    }



    @media screen and (max-width: 768px) {
        .event-card {
            width: calc(50% - 20px);
        }
    }

    @media screen and (max-width: 480px) {
        .event-card {
            width: calc(100% - 20px);
        }
    }
</style>

<body>
    <header>
        <div class="logo">
            <h1>TBSK</h1>
        </div>
        <div class="menu_nav"><a href="index.php">home</a></div>
        <div class="menu_nav"><a href="#"></a></div>
        <div class="menu_nav"><a href="#"></a></div>
        <div class="menu_nav"><a href="logout.php">Logout</a></div>
        <div class="menu_nav">
            <h3>
                welcome:
                <?php
                echo $name; ?>
            </h3>
        </div>

    </header>
    </div class=""><br><br><br><br><br>
    <div>
        <center>
            <h1>Event Ticket Booking system</h1>
        </center>
    </div>
    <div>
        <center>
            <h1>All Events</h1>
        </center>
    </div>

    <div class="container">
        <div class="events-container">
            <?php if ($events_result->num_rows > 0): ?>
                <!-- Display each event as a card -->
                <?php while ($event = $events_result->fetch_assoc()): ?>
                    <div class="event-card">
                        <div class="background-image" >
                            <div class="description">
                                <h2>
                                    <?php echo isset($event['title']) ? $event['title'] : 'N/A'; ?>
                                </h2>
                                <p>Event Date:
                                    <?php echo isset($event['date']) ? $event['date'] : 'N/A'; ?>
                                </p>
                                <p>Event Venue:
                                    <?php echo isset($event['location']) ? $event['location'] : 'N/A'; ?>
                                </p>
                            </div>
                        </div>


                        <div>
                            <table>
                                <tr>
                                </tr>
                                <tr>
                                    <td>VIP<p>KSH
                                            <?php echo isset($event['ticket_price_vip']) ? $event['ticket_price_vip'] : 'N/A'; ?>
                                        </p>
                                    </td>
                                    <td>Regular<p>KSH
                                            <?php echo isset($event['ticket_price_regular']) ? $event['ticket_price_regular'] : 'N/A'; ?>
                                        </p>
                                    </td>
                                </tr>
                            </table>


                            <form action="reserve_ticket.php" method="post">
                                <input type="hidden" name="event_id"
                                    value="<?php echo isset($event['event_id']) ? $event['event_id'] : ''; ?>">
                                <label for="ticket_type">Ticket Type:</label>
                                <div>
                                    <label>
                                        <input type="radio" name="ticket_type" value="vip">
                                        VIP
                                    </label>
                                    <label>
                                        <input type="radio" name="ticket_type" value="regular">
                                        Regular
                                    </label>
                                </div>


                                <button type="submit" class="reserve-button">Reserve Ticket</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No events found.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="app.js"></script>
</body>

</html>