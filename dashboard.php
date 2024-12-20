<?php
session_start();
include 'db_connection.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}
//set up session and prepare query
$username = $_SESSION['username'];
$userStmt = $pdo->prepare("SELECT UserID, First, Last, Role FROM Users WHERE Username = :username LIMIT 1");
$userStmt->execute(['username' => $username]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $firstName = htmlspecialchars($user['First']);
    $lastName = htmlspecialchars($user['Last']);
    $role = htmlspecialchars($user['Role']);
    $userID = $user['UserID'];

    try {
        // Query to count unread messages
        $testStmt = $pdo->prepare("SELECT count(*) AS unread_count FROM messages WHERE read = 0 AND receiver_id = :userID");
        $testStmt->execute(['userID' => $userID]);
        $testResult = $testStmt->fetch(PDO::FETCH_ASSOC);
        // Get the count of unread messages
        $unreadCount = $testResult['unread_count'] ?? 0;
        // Determine the button style
        $buttonStyle;
        $buttonText = "View Messages";
        //echo $unreadCount;
        if ($unreadCount > 0) {
            $buttonStyle = $unreadCount > 0 ? 'font-weight: bold !important;' : '';;
            $buttonText = "View Messages (" . $unreadCount . ")";
        }
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $buttonStyle = '';
        $buttonText = "View Messages";
    }
} else {
    header("Location: login.php");
    exit();
}

?>
<!-- Style code. Make it look like its beyond 1999 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Existing head content -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Existing CSS styles */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background: url('TheY.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .dashboard-container {
            text-align: center;
            max-width: 700px; /* Increased width to accommodate more options */
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
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

        .logout-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #ff4d4d;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <!-- Logout button in the top-right corner -->
    <a href="logout.php" class="logout-button">Logout</a>

    <div class="dashboard-container">
        <h1>Hi, <?php echo $firstName . ' ' . $lastName; ?>!</h1>

        <!-- Member, Employee, and ADM Options -->
        <?php if (in_array($role, ["MEM", "EMP", "ADM", "NON"])): ?>
            <a href="register_classes.php" class="option-box">Register for Classes</a>
            
            <?php if (in_array($role, ["MEM", "EMP", "ADM"])): ?>
                <a href="membership_benefits.php" class="option-box">View Membership Benefits</a>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Employee and ADM-Specific Options -->
        <?php if (in_array($role, ["EMP", "ADM"])): ?>
            <a href="createClasses.php" class="option-box">Create Classes</a>
            <a href="viewClasses.php" class="option-box">View Classes</a>
            <a href="cancelClasses.php" class="option-box">Cancel Classes</a>
        <?php endif; ?>

        <!-- ADM-Specific Options -->
        <?php if ($role === "ADM"): ?>
            <a href="ManageMembers.php" class="option-box">Manage Members</a>
            <a href="generate_report.php" class="option-box">Generate User Registration Report</a> <!-- New Link Added -->
        <?php endif; ?>

        <!-- Common Option for All Roles -->
        <a href="viewInbox.php" class="option-box" style="<?php echo $buttonStyle; ?>">
            <?php echo htmlspecialchars($buttonText); ?>
        </a>
    </div>
</body>
</html>
