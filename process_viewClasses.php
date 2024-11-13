<?php

session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Name = $_POST['Username'];

    $classQuery = $pdo->prepare("SELECT Class FROM EmploymentRecords WHERE User = :Name");
    $classQuery->execute(['Name' => $Name]);

    if($classQuery->rowCount() > 0) {
        $classes = $classQuery->fetchAll(PDO::FETCH_ASSOC);

        echo "<table border='2'>";
        echo "<tr><th>Class Name</th><th>Start Date</th><th>End Date</th><th>Days</th><th>Start Time</th><th>End Time</th><th>Location</th></tr>";
        foreach($classes as $class) {
            $classInfoQuery = $pdo->prepare("SELECT Name, StartDate, EndDate, Days, StartTime, EndTime, Location FROM Classes WHERE ClassID = :ClassID");
            $classInfoQuery->execute(['ClassId' => $class]);
            $classInfo = $classInfoQuery->fetch(PDO::FETCH_ASSOC);
            echo "<tr>";
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
    }
    else {
        echo "<p> No classes found for the specified user. </p>";
    }
}
else {
    echo "<p> Unable to access class information at this time. </p>";
}
?>