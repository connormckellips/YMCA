<?php
include 'db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get UserID from session and ClassID from POST data
    $user_id = $_SESSION['UserID']; // Assuming UserID is set in session after login
    $class_id = $_POST['ClassID'];   // Get ClassID from form submission
    $class_name = $_POST['ClassName'];

    // Check if the user is already enrolled in the class
    $duplicateCheck = $pdo->prepare("
        SELECT COUNT(*)
        FROM EnrollmentRecords
        WHERE User = :user_id AND Class = :class_id
    ");
    $duplicateCheck->execute(['user_id' => $user_id, 'class_id' => $class_id]);
    $isDuplicate = $duplicateCheck->fetchColumn();

    if ($isDuplicate) {
        header("Location: register_classes.php?error=already_enrolled");
        exit();
    }

    // Insert a new enrollment record if the user is not already enrolled
    $insertStmt = $pdo->prepare("
        INSERT INTO EnrollmentRecords (User, Class, Status, ClassName)
        VALUES (:user_id, :class_id, 'in progress', class_name)
    ");
    $insertStmt->execute(['user_id' => $user_id, 'class_id' => $class_id, 'class_name' => $class_name]);
    // Redirect to register_classes
    header("Location: register_classes.php?success=registered");
    exit();
} else {
    //no direct access
    header("Location: register_classes.php");
    exit();
}