<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['Username'];
    // Query for UserID based on Username
    $userQuery = $pdo->prepare("SELECT UserID FROM Users WHERE Username = :username");
    $userQuery->execute(['username' => $username]);
    $user = $userQuery->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $classQuery = $pdo->prepare("SELECT Class FROM EnrollmentRecords WHERE User = :user_id");
        $classQuery->execute(['user_id' => $user['UserID']]);

        if ($classQuery) {
            $classes = $classQuery->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<form action='action_ViewClasses.php' method='POST'>";
            echo "<table border='2'>";
            echo "<tr><th>Select</th><th>Class Name</th><th>Start Date</th><th>End Date</th><th>Days</th><th>Start Time</th><th>End Time</th><th>Location</th></tr>";
    
            foreach ($classes as $class) {
                $classInfoQuery = $pdo->prepare("SELECT Name, StartDate, EndDate, Days, StartTime, EndTime, Location FROM Classes WHERE ClassID = :class_id");
                $classInfoQuery->execute(['class_id' => $class['Class']]);
                $classInfo = $classInfoQuery->fetch(PDO::FETCH_ASSOC);
                
                if ($classInfo) {
                    echo "<tr>";
                    echo "<td><input type='radio' name='classList' id='" . htmlspecialchars($class['Class']) . "' value='" . htmlspecialchars($class['Class']) . "'></td>";
                    echo "<td>" . htmlspecialchars($classInfo['Name']) . "</td>";
                    echo "<td>" . htmlspecialchars($classInfo['StartDate']) . "</td>";
                    echo "<td>" . htmlspecialchars($classInfo['EndDate']) . "</td>";
                    echo "<td>" . htmlspecialchars($classInfo['Days']) . "</td>";
                    echo "<td>" . htmlspecialchars($classInfo['StartTime']) . "</td>";
                    echo "<td>" . htmlspecialchars($classInfo['EndTime']) . "</td>";
                    echo "<td>" . htmlspecialchars($classInfo['Location']) . "</td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
            echo "<input type='submit' name='submitType' value='Cancel Entire Class'>";
            echo "</form>";

            echo "<script>
                    document.querySelector('form').addEventListener('submit', function(event) {
                        const selectedRadio = document.querySelector('input[name='classList']:checked');

                        if (!selectedRadio) {
                        event.preventDefault();
                            alert('Please select a class.');
                        }
                    });
                </script>";
        } else {
          
            echo "<p>No classes found for the specified user.</p>";
        }
    } else {
        echo "<p>Unable to find user.</p>";
    }
} else {
    header("Location: viewClasses.php");
    exit();
}
?>
