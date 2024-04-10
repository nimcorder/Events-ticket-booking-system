<?php
include('conn.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$status = "";

if (isset($_POST['event_id']) && isset($_POST['title']) && isset($_POST['date']) && isset($_POST['max_attendees']) && isset($_POST['ticket_price_vip']) && isset($_POST['ticket_price_regular'])) {
    $event_id = $_POST['event_id'];
    $title = $_POST['title'];
    $date = $_POST['date'];
    $max_attendees = $_POST['max_attendees'];
    $ticket_price_vip = $_POST['ticket_price_vip'];
    $ticket_price_regular = $_POST['ticket_price_regular'];
    $submittedby = $_SESSION["admin_id"];

    $update_query = "UPDATE events SET title = '$title', date = '$date', max_attendees = '$max_attendees', 
                 ticket_price_vip = '$ticket_price_vip', ticket_price_regular = '$ticket_price_regular', 
                 admin_id = '$submittedby' WHERE event_id = '$event_id'";

    $result = mysqli_query($conn, $update_query);

    if ($result) {
        $status = "Event updated successfully.";
        header("Location: manage_events.php"); // Redirect back to manage_events.php
        exit();
    } else {
        $status = "Error updating event: " . mysqli_error($conn);
    }
}

// Retrieve event data based on event ID
if(isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
    $query = "SELECT * FROM events WHERE event_id = $event_id";
    $result = mysqli_query($conn, $query);
    $event_data = mysqli_fetch_assoc($result);
} else {
    // Redirect if event ID is not provided
    header("Location: manage_events.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <style>
        .event-form {
    max-width: 400px;
    margin: 0 auto;
}
.menu_nav a{
    background-color: orange;
    text-decoration: none;
    font-size: 24px;
    color: black;
    border-radius: 5px;
    padding: 10px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"],
input[type="date"],
input[type="number"],
input[type="submit"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

input[type="submit"] {
    cursor: pointer;
    background-color: darkslategray;
    color: white;
    border: none;
}

input[type="submit"]:hover {
    background-color: green;
}
footer{
    background-color: black;
    color: white;
    align-items: center;
    text-align: center;
}

    </style>
</head>
<body>
    
    <br><br><br><br>
    <div class="container">
        
        <div class="content">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="event-form">
    <div class="menu_nav"><a href="manage_events.php">back</a></div><br><br>
        <input type="hidden" name="event_id" value="<?php echo $event_data['event_id']; ?>">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $event_data['title']; ?>" required>
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo $event_data['date']; ?>" required>
        </div>
        <div class="form-group">
            <label for="max_attendees">Max Attendees:</label>
            <input type="number" id="max_attendees" name="max_attendees" value="<?php echo $event_data['max_attendees']; ?>" required>
        </div>
        <div class="form-group">
            <label for="ticket_price_vip">Ticket Price (VIP):</label>
            <input type="number" id="ticket_price_vip" name="ticket_price_vip" step="0.01" value="<?php echo $event_data['ticket_price_vip']; ?>" required>
        </div>
        <div class="form-group">
            <label for="ticket_price_regular">Ticket Price (Regular):</label>
            <input type="number" id="ticket_price_regular" name="ticket_price_regular" step="0.01" value="<?php echo $event_data['ticket_price_regular']; ?>" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Save Changes">
        </div>
    </form>
</div>

        <footer><div class="footer">
            <p>&copy; 2024 Ticket Booking System by nio</p>
        </div></footer>
    </div>
</body>
</html>
