<?php
// Include the database connection file
include 'conn.php';

// Initialize error variable
$error = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $date = $_POST['date'];
    $max_attendees = $_POST['max_attendees'];
    $ticket_price_vip = $_POST['ticket_price_vip'];
    $ticket_price_regular = $_POST['ticket_price_regular'];

    // Insert event data into the database
    $sql = "INSERT INTO events (title, date, max_attendees, ticket_price_vip, ticket_price_regular)
            VALUES ('$title', '$date', '$max_attendees', '$ticket_price_vip', '$ticket_price_regular')";

    if ($conn->query($sql) === TRUE) {
        // Event added successfully, redirect to admin.php
        header("Location: admin.php");
        exit();
    } else {
        // Error occurred, set error message
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event - Ticket Booking System</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    form {
    max-width: 400px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

form h1 {
    text-align: center;
    margin-bottom: 20px;
}

form label {
    display: block;
    margin-bottom: 5px;
}

form input[type="text"],
form input[type="date"],
form input[type="number"] {
    width: calc(100% - 12px);
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

form input[type="submit"] {
    width: 100%;
    background-color: #333;
    color: #fff;
    border: none;
    padding: 10px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

form input[type="submit"]:hover {
    background-color: #555;
}

.error-message {
    color: red;
    text-align: center;
}
</style>
<body>
<header>
        <div class="logo">
            <h1>TBSK</h1>
        </div>
        <div class="menu_nav"><a href="admin.php">Back to dashboard</a></div>
        

    </header>
    <?php
    // Display error message if present
    if ($error) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
    <form action="add_event_process.php" method="POST">
    <h1>Add Event</h1>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        <label for="max_attendees">Max Attendees:</label>
        <input type="number" id="max_attendees" name="max_attendees" required>
        <label for="ticket_price_vip">Ticket Price (VIP):</label>
        <input type="number" id="ticket_price_vip" name="ticket_price_vip" step="0.01" required>
        <label for="ticket_price_regular">Ticket Price (Regular):</label>
        <input type="number" id="ticket_price_regular" name="ticket_price_regular" step="0.01" required>
        <input type="submit" value="Add Event">
    </form>
    <script>
    // Check if the page URL contains the success parameter
    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('success');

    // If success parameter is set to 1, show success message and redirect
    if (successParam === '1') {
        alert('Event added successfully!');
        window.location.href = 'manage_events.php';
    }
</script>

</body>
</html>
