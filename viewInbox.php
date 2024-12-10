<?php
session_start();
include 'db_connection.php';

$UserID = $_SESSION['UserID'];

// Fetch messages where the user is the receiver
$stmt = $pdo->prepare("SELECT * FROM messages WHERE receiver_id = :UserID");
$stmt->execute(['UserID' => $UserID]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

$read = $pdo->prepare("UPDATE messages SET read = 1 WHERE read = 0 AND receiver_id = :userID;");
$read->execute(['userID' => $UserID]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox</title>
    <style>
        /* Full-screen background styling */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background-color: #e0f7fa; /* Light blue background */
            color: #333;
        }

        /* Main container styling */
        .container {
            width: 90%;
            max-width: 700px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 20px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #28b3b5;
            color: white;
            font-weight: bold;
        }

        td {
            background-color: #f9f9f9;
        }

        /* Return to Dashboard button styling */
        .dashboard-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #1f0236;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .dashboard-button:hover {
            background-color: #3a215e;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Inbox</h2>
        <table>
            <tr>
                <th>From</th>
                <th>Message</th>
            </tr>
            <?php foreach ($messages as $message): ?>
                <?php
                    // Fetch sender's username
                    $senderStatement = $pdo->prepare("SELECT Username FROM Users WHERE UserID = :sender_id");
                    $senderStatement->execute(['sender_id' => $message['sender_id']]);
                    $sender = $senderStatement->fetch(PDO::FETCH_ASSOC);
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($sender['Username']); ?></td>
                    <td><?php echo htmlspecialchars($message['message']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a href="dashboard.php" class="dashboard-button">Back to Dashboard</a>
    </div>
</body>
</html>
