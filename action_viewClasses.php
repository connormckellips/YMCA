<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $submit = $_POST['submitType'];
    $class = $_POST['classList'];

    if ($submit === "Cancel") {
        // gather class information to use for the message
        $classQuery = $pdo->prepare("SELECT Name, StartTime, EndTime FROM Classes WHERE ClassID = :class");
        $classQuery->execute(['class' => $class]);
        $classInfo = $classQuery->fetch(PDO::FETCH_ASSOC);
        // gather users in user list in class to be cancelled
        $userQuery = $pdo->prepare("SELECT User FROM EnrollmentRecords WHERE Class = :class");
        $userQuery->execute(['class' => $class]);
        $users = $userQuery->fetchAll(PDO::FETCH_ASSOC);
        // update class status to cancelled
        $updateQuery = $pdo->prepare("UPDATE EnrollmentRecords SET Status = 'canceled' WHERE Class = :class");
        $updateQuery->execute(['class' => $class]);
        // delete class in class table
        $deleteQuery = $pdo->prepare("DELETE FROM Classes WHERE ClassID = :class");
        $deleteQuery->execute(['class' => $class]);
        // send cancel notifications each user that signed up for the class
        $sender = $_SESSION['UserID'];
        $className = $classInfo['Name'];
        $classStartTime = $classInfo['StartTime'];
        $classEndTime = $classInfo['EndTime'];
        $message = "Unfortunately, your " . $className . " class from " . $classStartTime . " - " . $classEndTime . " has been cancelled.";
        foreach ($users as $user) {
            $recipient = $user['User'];
            $send = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)");
            $send->execute(['sender_id' => $sender, 'receiver_id' => $recipient, 'message' => $message]);
        }
        header("Location: successCancel.php");
        exit();
    }
    else {
        header("Location: viewClasses.php?error=unable_to_cancel_class");
        exit();
    }
}
?>