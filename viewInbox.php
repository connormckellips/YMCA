<?php
session_start();
include 'db_connection.php';

$UserID = $_SESSION['UserID'];

// Fetch messages where the user is the receiver
$stmt = $pdo->prepare("SELECT * FROM messages WHERE receiver_id = :UserID");
$stmt->execute(['UserID' => $UserID]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Inbox</h2>
<table border="1">
    <tr><th>From</th><th>Message</th></tr>
    <?php foreach ($messages as $message): ?>
        <?php
            $senderStatement = $pdo->prepare("SELECT Username FROM Users WHERE UserID = :sender_id");
            $senderStatement->execute(['sender_id' => $message['sender_id']]);
            $sender = $senderStatement->fetch(PDO::FETCH_ASSOC);
        ?>
        <tr>
            <td><?php echo htmlspecialchars($sender['Username']); // Display sender ID or fetch name ?></td>
            <td><?php echo htmlspecialchars($message['message']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
