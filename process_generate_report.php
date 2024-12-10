<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #009dc4; /* Alice Blue */
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Center Content */
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #ffffff;
            border: 1px solid #dce7f3;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* Header Styles */
        h1, h2 {
            text-align: center;
            color: #000000; /* Dodger Blue */
        }

        h2 {
            margin-top: 20px;
            font-size: 20px;
        }

        /* List Styles */
        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            padding: 8px 12px;
            margin: 5px 0;
            background-color: #e6f7ff; /* Light Blue */
            border: 1px solid #dce7f3;
            border-radius: 4px;
        }

        li:hover {
            background-color: #d0efff; /* Slightly darker blue */
        }

        p {
            text-align: center;
            color: #666;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #999;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Enable error reporting for debugging
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Include the database connection
        include 'db_connection.php';

        // Check if form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            if (!empty($start_date) && !empty($end_date)) {
                echo "<h1>Report from $start_date to $end_date</h1>";

                // Query to get all User IDs, first, and last names
                $user_query = "SELECT UserID, First, Last FROM Users";
                $users = $pdo->query($user_query)->fetchAll(PDO::FETCH_ASSOC);

                if ($users) {
                    foreach ($users as $user) {
                        $user_id = $user['UserID'];
                        $full_name = htmlspecialchars($user['First'] . ' ' . $user['Last']);
                        echo "<h2>$full_name</h2>";

                        // Query to get all classes for the user
                        $class_query = "
                            SELECT 
                                Classes.Name AS ClassName, 
                                Classes.StartDate, 
                                Classes.EndDate
                            FROM 
                                EnrollmentRecords
                            JOIN 
                                Classes 
                            ON 
                                EnrollmentRecords.Class = Classes.ClassID
                            WHERE 
                                EnrollmentRecords.User = :user_id
                            ORDER BY 
                                Classes.StartDate";

                        $stmt = $pdo->prepare($class_query);
                        $stmt->execute([':user_id' => $user_id]);

                        $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if ($classes) {
                            echo "<ul>";
                            foreach ($classes as $class) {
                                echo "<li>";
                                echo htmlspecialchars($class['ClassName']) . " - ";
                                echo "Start Date: " . htmlspecialchars($class['StartDate']) . ", ";
                                echo "End Date: " . htmlspecialchars($class['EndDate']);
                                echo "</li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "<p>No classes found for User ID: $user_id.</p>";
                        }
                    }
                } else {
                    echo "<p>No users found.</p>";
                }
            } else {
                echo "<p>Please provide both start and end dates.</p>";
            }
        }
        ?>
        <div class="footer">
            <p>&copy; 2024 McKellips & Fraker Industries. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
