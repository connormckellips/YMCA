<?php
session_start();
include 'db_connection.php';

$UserID = $_SESSION['UserID'];

// Fetch messages where the user is the receiver
$stmt = $pdo->prepare("SELECT * FROM messages WHERE receiver_id = :UserID ORDER BY created_at DESC");
$stmt->execute(['UserID' => $UserID]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Inbox</h2>
<table border="1">
    <tr><th>From</th><th>Message</th><th>Date</th></tr>
    <?php foreach ($messages as $message): ?>
        <tr>
            <td><?php echo htmlspecialchars($message['sender_id']); // Display sender ID or fetch name ?></td>
            <td><?php echo htmlspecialchars($message['message']); ?></td>
            <td><?php echo $message['created_at']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
