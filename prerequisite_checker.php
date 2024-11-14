<?php
include 'db_connection.php';

function checkPrerequisites($pdo, $user_id, $class_id) {
    // Retrieve the prerequisite (class name or NULL) for the target class
    $prerequisiteQuery = $pdo->prepare("
        SELECT prerequisites
        FROM Classes
        WHERE ClassID = :class_id
    ");
    $prerequisiteQuery->execute(['class_id' => $class_id]);
    $prerequisite_name = $prerequisiteQuery->fetchColumn();

    // If there's no prerequisite (NULL or empty), allow registration
    if ($prerequisite_name === null || $prerequisite_name === '') {
        return true;
    }

    // Check if the user has completed any class with the name specified in `prerequisites`
    $prereqCheck = $pdo->prepare("
        SELECT COUNT(*)
        FROM EnrollmentRecords
        WHERE User = :user_id
          AND ClassName = :prerequisite_name
          AND Status = 'complete'
    ");
    $prereqCheck->execute([
        'user_id' => $user_id,
        'prerequisite_name' => $prerequisite_name
    ]);

    // Return true if at least one record is found, meaning prerequisite is met
    return $prereqCheck->fetchColumn() > 0;
}
?>