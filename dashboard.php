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
    <style>
        /* Center container styling */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
        }

        .dashboard-container {
            text-align: center;
            max-width: 500px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .dashboard-container h1 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .option-box {
            margin: 10px 0;
            padding: 15px;
            background-color: #28b3b5;
            color: #fff;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
        }

        .option-box:hover {
            background-color: #1f8fa3;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Hi, <?php echo $firstName . ' ' . $lastName; ?>!</h1>
        <?php if ($role == "MEM" || $role == "NON"): ?>
            <a href="register_classes.php" class="option-box">Register for Classes</a>
            <?php if ($role == "MEM"): ?>
                <a href="membership_benefits.php" class="option-box">View Membership Benefits</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="createClasses.php" class="option-box">Create Classes</a>
            <a href="viewClasses.php" class="option-box">View Classes</a>
            <a href="cancelClasses.php" class="option-box">Cancel Classes</a>
        <?php endif; ?>
        <a href="viewAccountInformation.php" class="option-box">View Account Information</a>
    </div>
</body>
</html>
