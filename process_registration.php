<?php
include 'db_connection.php';
include 'prerequisite_checker.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['UserID'];
    $class_id = (int)$_POST['ClassID'];
    $class_name = $_POST['ClassName'];

    // Debugging to confirm received values
    var_dump($user_id, $class_id, $class_name);

    // Check if prerequisites are met
    if (!checkPrerequisites($pdo, $user_id, $class_id)) {
        header("Location: register_classes.php?error=prerequisite_not_met");
        exit();
    }

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

    // Check for conflicting schedules
    $conflictCheck = $pdo->prepare("
    SELECT Classes.Name, Classes.StartDate, Classes.EndDate, Classes.Days, Classes.StartTime, Classes.EndTime
    FROM EnrollmentRecords
    JOIN Classes ON EnrollmentRecords.Class = Classes.ClassID
    WHERE EnrollmentRecords.User = :user_id
      AND (
        Classes.Days = (SELECT Days FROM Classes WHERE ClassID = :class_id)
        AND Classes.StartTime = (SELECT StartTime FROM Classes WHERE ClassID = :class_id)
        AND Classes.EndTime = (SELECT EndTime FROM Classes WHERE ClassID = :class_id)
        AND (
          DATE(Classes.StartDate) <= DATE((SELECT EndDate FROM Classes WHERE ClassID = :class_id))
          AND DATE(Classes.EndDate) >= DATE((SELECT StartDate FROM Classes WHERE ClassID = :class_id))
        )
      )
");
$conflictCheck->execute(['user_id' => $user_id, 'class_id' => $class_id]);
$conflict = $conflictCheck->fetch(PDO::FETCH_ASSOC);
    if ($conflict) {
        header("Location: register_classes.php?error=schedule_conflict");
        exit();
    }

    // Insert a new enrollment record if no conflicts or duplicates
    $insertStmt = $pdo->prepare("
        INSERT INTO EnrollmentRecords (User, Class, Status, ClassName)
        VALUES (:user_id, :class_id, 'in progress', :class_name)
    ");
    $insertStmt->execute([
        'user_id' => $user_id,
        'class_id' => $class_id,
        'class_name' => $class_name
    ]);

    // Redirect to register_classes with a success message
    header("Location: register_classes.php?success=registered");
    exit();
} else {
    // Redirect if accessed directly
    header("Location: register_classes.php");
    exit();
}