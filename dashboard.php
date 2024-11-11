<?php
session_start();
include 'db_connection.php'; 
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}
$username = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT First, Last FROM Users WHERE Username = :username LIMIT 1");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user) {
    $firstName = htmlspecialchars($user['First']);
    $lastName = htmlspecialchars($user['Last']);
} else {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Hi, <?php echo $firstName . ' ' . $lastName; ?>!</h1>
</body>
</html>
