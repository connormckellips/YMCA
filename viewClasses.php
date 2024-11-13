<?php
session_start();
include 'db_connection.php'; 
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Classes</title>
</head>
<body>
    <h2>Search for Classes by Attendee</h2>
    <div class="view-classes-container">
        <form action="process_viewClasses.php" method="POST">
            <label for="Username">Username:</label>
            <input type="email" id="Username" name="Username" required>

            <input type="submit" value="Search">
        </form>
    </div>
</body>
</html>