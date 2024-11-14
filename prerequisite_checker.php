<?php
include 'db_connection.php';

function checkPrerequisites($user_id, $class_id) {
    global $pdo;

    $prerequisiteQuery = $pdo->prepare("
        SELECT prerequisite
        FROM Classes
        WHERE ClassID = :class_id
    ");
    $prerequisiteQuery->execute(['class_id' => $class_id]);
    $prerequisite_name = $prerequisiteQuery->fetchColumn();

    if ($prerequisite_name === null) {
        return true;
    }

    // Check if the user has completed the prerequisite class
    $prereqCheck = $pdo->prepare("
        SELECT COUNT(*)
        FROM EnrollmentRecords
        WHERE user_id = :user_id
          AND class_name = :prerequisite_name
          AND status = 'complete'
    ");
    $prereqCheck->execute([
        'user_id' => $user_id,
        'prerequisite_name' => $prerequisite_name
    ]);

    // If at least one record is found, the prerequisite is met
    return $prereqCheck->fetchColumn() > 0;
}
?>