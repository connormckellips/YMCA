<?php
session_start();
include 'db_connection.php'; 
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}
$username = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT First, Last, Role FROM Users WHERE Username = :username LIMIT 1");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user) {
    $firstName = htmlspecialchars($user['First']);
    $lastName = htmlspecialchars($user['Last']);
    $role = htmlspecialchars($user['Role']);
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
    <?php if ($role = "MEM" || $role = "NON"):?>
        <h2>
            <a href="classes.html">Register for Classes</a>
        </h2>
        <?php if ($role = "MEM"): ?>
            <h2>
                View Membership Benefits
            </h2>
        <?php endif; ?>
    <?php else: ?>
        <h2>
            <a href="createClasses.php">Create Classes</a>
        </h2>
        <h2>
            View Classes
        </h2>
    <?php endif; ?>
    <h2>
        View Account Information
    </h2>
</body>
</html>