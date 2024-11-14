<?php
include 'db_connection.php';
session_start();

$user_id = $_SESSION['UserID'];
$role = $_SESSION['Role'];

// Query to get all required details of available classes, sorted alphabetically by class name
$class_list = $pdo->query("
    SELECT ClassID, Name, StartDate, EndDate, Days, StartTime, EndTime, Price, MemPrice, Location, MaxSize, Description
    FROM Classes
    ORDER BY Name ASC
");
$classes = $class_list->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for a Class</title>
    <style>
        /* Background color inspired by YMCA’s light blue */
        body {
            background-color: #e0f7fa;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-direction: column;
        }

        h1 {
            text-align: center;
            color: #333;
            width: 100%;
        }

        .classes-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .class-container {
            width: 100%;
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .class-details {
            margin: 0;
            padding: 5px 0;
            color: #333;
        }

        .register-button {
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
        }

        .register-button:hover {
            background-color: #218838;
        }

        .dashboard-button {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 10px 15px;
            background-color: #1f0236;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 0.9rem;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .dashboard-button:hover {
            background-color: #3a215e;
        }
    </style>
</head>
<body>
    <!-- Return to Dashboard button -->
    <a href="dashboard.php" class="dashboard-button">Return to Dashboard</a>

    <h1>Available Classes</h1>
    <div class="classes-container">
        <?php foreach ($classes as $class): ?>
            <div class="class-container">
                <h2><?php echo htmlspecialchars($class['Name']); ?></h2>
                <p class="class-details"><strong>Start Date:</strong> <?php echo htmlspecialchars($class['StartDate']); ?></p>
                <p class="class-details"><strong>End Date:</strong> <?php echo htmlspecialchars($class['EndDate']); ?></p>
                <p class="class-details"><strong>Days:</strong> <?php echo htmlspecialchars($class['Days']); ?></p>
                <p class="class-details"><strong>Start Time:</strong> <?php echo htmlspecialchars($class['StartTime']); ?></p>
                <p class="class-details"><strong>End Time:</strong> <?php echo htmlspecialchars($class['EndTime']); ?></p>
                <?php if ($role == 'MEM'): ?>
                    <p class="class-details"><strong>Member Price:</strong> $<?php echo htmlspecialchars($class['MemPrice']); ?></p>
                <?php else: ?>
                    <p class="class-details"><strong>Non-Member Price:</strong> $<?php echo htmlspecialchars($class['Price']); ?></p>
                <?php endif; ?>
                <p class="class-details"><strong>Location:</strong> <?php echo htmlspecialchars($class['Location']); ?></p>
                <p class="class-details"><strong>Max Size:</strong> <?php echo htmlspecialchars($class['MaxSize']); ?> participants</p>
                <p class="class-details"><strong>Description:</strong> <?php echo htmlspecialchars($class['Description']); ?></p>
                
                <form action="process_registration.php" method="POST">
                    <input type="hidden" name="ClassID" value="<?php echo $class['ClassID']; ?>">
                    <input type="hidden" name="ClassName" value="<?php echo htmlspecialchars($class['Name']); ?>">
                    <input type="submit" value="Register" class="register-button">
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
    // Display success or error messages based on URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const error = urlParams.get('error');

    if (success === 'registered') {
        alert('Registration successful!');
    } else if (error) {
        switch(error) {
            case 'prerequisite_not_met':
                alert('Registration failed: Prerequisites are not met.');
                break;
            case 'already_enrolled':
                alert('Registration failed: You are already enrolled in this class.');
                break;
            case 'schedule_conflict':
                alert('Registration failed: Schedule conflict with another class.');
                break;
            default:
                alert('Registration failed: Unknown error.');
        }
    }
</script>
</body>
</html>
