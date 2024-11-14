<?php

session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Name = $_POST['Username'];

    $userQuery = $pdo->prepare("SELECT UserID FROM Users WHERE Username = :Name");
    $userQuery->execute(['Name' => $Name]);
    $user = $userQuery->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $classQuery = $pdo->prepare("SELECT Class FROM EnrollmentRecords WHERE User = :ID");
        $classQuery->execute(['ID' => $user['UserID']]);
        if($classQuery->rowCount() > 0) {
            $classes = $classQuery->fetchAll(PDO::FETCH_ASSOC);
            echo "<form action='action_ViewClasses.php' method='POST'>";
            echo "<table border='2'>";
            echo "<tr><th>Select</th><th>Class Name</th><th>Start Date</th><th>End Date</th><th>Days</th><th>Start Time</th><th>End Time</th><th>Location</th></tr>";
    
            foreach($classes as $class) {
                $classInfoQuery = $pdo->prepare("SELECT Name, StartDate, EndDate, Days, StartTime, EndTime, Location FROM Classes WHERE ClassID = :ClassID");
                $classInfoQuery->execute(['ClassId' => $class]);
                $classInfo = $classInfoQuery->fetch(PDO::FETCH_ASSOC);
                echo "<tr>";
                echo "<td><input type='radio' name=classList id=" . $class . " value=" . $class . "></td>";
                echo "<td>" . $classInfo['Name'] . "</td>";
                echo "<td>" . $classInfo['StartDate'] . "</td>";
                echo "<td>" . $classInfo['EndDate'] . "</td>";
                echo "<td>" . $classInfo['Days'] . "</td>";
                echo "<td>" . $classInfo['StartTime'] . "</td>";
                echo "<td>" . $classInfo['EndTime'] . "</td>";
                echo "<td>" . $classInfo['Location'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<input type='submit' value='Cancel'>";
            echo "</form>";
    
        }
        else {
            header("Location: viewClasses.php?error=no_classes_found_for_user");
            echo "<p> No classes found for the specified user. </p>";
            exit();
        }
    }
    else {
        header("Location: viewClasses.php?error=unable_to_find_user");
        echo "<p>Unable to find user</p>";
        exit();
    }
}
else {
    header("Location: viewClasses.php");
    echo "<p> Unable to access class information at this time. </p>";
    exit();
}
?>