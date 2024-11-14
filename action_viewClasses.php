<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $submit = $_POST['submitType'];
    $class = $_POST['classList'];

    if ($submit === "Cancel Entire Class") {
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
        // send notifications each user in user list
        foreach ($users as $user) {
            // do something here
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