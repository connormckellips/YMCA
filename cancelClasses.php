<?php
include 'db_connection.php';
session_start();

$user_id = $_SESSION['UserID'];
$role = $_SESSION['Role']; // Assuming 'Role' is stored in the session

// Query to get all required details of available classes
$class_list = $pdo->query("
    SELECT ClassID, Name, StartDate, EndDate, Days, StartTime, EndTime, Price, MemPrice, Location, MaxSize, Description
    FROM Classes
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
        .class-container {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .class-details {
            margin: 0;
            padding: 5px 0;
        }
        .cancel-button {
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .cancel-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Available Classes</h1>
    <?php foreach ($classes as $class): ?>
        <div class="class-container">
            <h2><?php echo htmlspecialchars($class['Name']); ?></h2>
            <p class="class-details"><strong>Start Date:</strong> <?php echo htmlspecialchars($class['StartDate']); ?></p>
            <p class="class-details"><strong>End Date:</strong> <?php echo htmlspecialchars($class['EndDate']); ?></p>
            <p class="class-details"><strong>Days:</strong> <?php echo htmlspecialchars($class['Days']); ?></p>
            <p class="class-details"><strong>Start Time:</strong> <?php echo htmlspecialchars($class['StartTime']); ?></p>
            <p class="class-details"><strong>End Time:</strong> <?php echo htmlspecialchars($class['EndTime']); ?></p>
            <p class="class-details"><strong>Member Price:</strong> $<?php echo htmlspecialchars($class['MemPrice']); ?></p>
            <p class="class-details"><strong>Non-Member Price:</strong> $<?php echo htmlspecialchars($class['Price']); ?></p>
            <p class="class-details"><strong>Location:</strong> <?php echo htmlspecialchars($class['Location']); ?></p>
            <p class="class-details"><strong>Max Size:</strong> <?php echo htmlspecialchars($class['MaxSize']); ?> participants</p>
            <p class="class-details"><strong>Description:</strong> <?php echo htmlspecialchars($class['Description']); ?></p>
            
            <form action="action_ViewClasses.php" method="POST">
                <input type="hidden" name="classList" value="<?php echo $class['ClassID']; ?>">
                <!-- <input type="hidden" name="ClassName" value="<?php echo htmlspecialchars($class['Name']); ?>"> -->
                <input type="submit" name="submitType" value="Cancel" class="cancel-button">
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>