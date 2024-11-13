<?php
include 'db_connection.php'; 

function checkPrerequisites($user_id, $prerequisite_name) {
    global $pdo;

    //query for prereq. 
    $prereqcheck = $pdo->prepare("
        SELECT COUNT(*)
        FROM EnrollmentRecords
        WHERE user_id = :user_id
          AND class_name = :prerequisite_name
          AND status = 'complete'
    ");
    $prereqcheck->execute([
        'user_id' => $user_id,
        'prerequisite_name' => $prerequisite_name
    ]);

    // If at least one record is found, the prerequisite is met
    return $prereqcheck->fetchColumn() > 0;
}
?>