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

            echo "<div class='container'>";
            echo "<h2>Classes for " . htmlspecialchars($username) . "</h2>";
            echo "<form action='action_ViewClasses.php' method='POST' class='class-form'>";
            echo "<table class='class-table'>";
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
            echo "<input type='submit' name='submitType' value='Cancel' class='submit-button'>";
            echo "</form>";
            echo "</div>";

            echo "<script>
                    document.querySelector('form').addEventListener('submit', function(event) {
                        const selectedRadio = document.querySelector('input[name=\"classList\"]:checked');

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Classes for Attendee</title>
    <style>
        /* Full-screen background and styling */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background: url('TheY.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        /* Main container styling */
        .container {
            text-align: center;
            max-width: 800px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #333;
        }

        /* Class table styling */
        .class-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .class-table th, .class-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .class-table th {
            background-color: #28b3b5;
            color: #fff;
        }

        .class-table td {
            background-color: #f9f9f9;
        }

        /* Submit button styling */
        .submit-button {
            width: 100%;
            padding: 12px;
            background-color: #1f0236;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
</body>
</html>

