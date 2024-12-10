<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $Name = trim($_POST['className'] ?? '');
    $StartDate = trim($_POST['startDate'] ?? '');
    $EndDate = trim($_POST['endDate'] ?? '');
    $Days = isset($_POST['days']) ? $_POST['days'] : [];
    $StartTime = trim($_POST['startTime'] ?? '');
    $EndTime = trim($_POST['endTime'] ?? '');
    $Price = trim($_POST['nonPrice'] ?? '');
    $MemPrice = trim($_POST['memPrice'] ?? '');
    $Location = trim($_POST['location'] ?? '');
    $Style = trim($_POST['style'] ?? '');
    $MaxSize = trim($_POST['maxSize'] ?? '');
    $Description = trim($_POST['description'] ?? '');
    $Prerequisites = trim($_POST['prerequisites'] ?? '');

    // **Debugging: Log the received days**
    if (isset($_POST['days'])) {
        error_log("Received days: " . implode(", ", $_POST['days']));
    } else {
        error_log("No days received.");
    }

    // Initialize an array to hold error messages
    $errors = [];

    // **1. Required Fields Validation**
    if (empty($Name)) {
        $errors[] = "Class name is required.";
    }
    if (empty($StartDate)) {
        $errors[] = "Start date is required.";
    }
    if (empty($EndDate)) {
        $errors[] = "End date is required.";
    }
    if (empty($Days)) {
        $errors[] = "At least one day must be selected.";
    }
    if (empty($StartTime)) {
        $errors[] = "Start time is required.";
    }
    if (empty($EndTime)) {
        $errors[] = "End time is required.";
    }
    if (empty($Price)) {
        $errors[] = "Non-member price is required.";
    }
    if (empty($MemPrice)) {
        $errors[] = "Member price is required.";
    }
    if (empty($Location)) {
        $errors[] = "Location is required.";
    }
    if (empty($Style)) {
        $errors[] = "Style is required.";
    }
    if (empty($MaxSize)) {
        $errors[] = "Maximum size is required.";
    }
    // Description and Prerequisites can be optional based on your requirements

    // **2. Date Format and Logical Consistency Validation**
    if (!empty($StartDate) && !empty($EndDate)) {
        // Create DateTime objects
        $currentDate = new DateTime('today');
        try {
            $startDateObj = new DateTime($StartDate);
            $endDateObj = new DateTime($EndDate);
        } catch (Exception $e) {
            $errors[] = "Invalid date format.";
        }

        if (isset($startDateObj) && isset($endDateObj)) {
            // Check if Start Date is today or in the future
            if ($startDateObj < $currentDate) {
                $errors[] = "Start date cannot be in the past.";
            }

            // Check if End Date is today or in the future
            if ($endDateObj < $currentDate) {
                $errors[] = "End date cannot be in the past.";
            }

            // Check if End Date is after or equal to Start Date
            if ($endDateObj < $startDateObj) {
                $errors[] = "End date cannot be earlier than Start date.";
            }
        }
    }

    // **3. Additional Validations**
    // Ensure that Price and MemPrice are numeric and positive
    if (!is_numeric($Price) || $Price < 0) {
        $errors[] = "Non-member price must be a positive number.";
    }
    if (!is_numeric($MemPrice) || $MemPrice < 0) {
        $errors[] = "Member price must be a positive number.";
    }
    if (!is_numeric($MaxSize) || $MaxSize <= 0) {
        $errors[] = "Maximum size must be a positive integer.";
    }

    // Validate selected days
    $validDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    foreach ($Days as $day) {
        // Normalize the day string
        $normalizedDay = ucfirst(strtolower(trim($day)));
        if (!in_array($normalizedDay, $validDays)) {
            $errors[] = "Invalid day selected: " . htmlspecialchars($day);
            break;
        }
    }

    // **4. Handling Validation Errors**
    if (!empty($errors)) {
        // Convert the errors array into a single string separated by a delimiter
        $errorString = urlencode(implode(" | ", $errors));
        // Redirect back with error messages
        header("Location: createClasses.php?error=$errorString");
        exit();
    }

    // **5. Proceed with Database Insertion**
    try {
        $statement = $pdo->prepare("INSERT INTO classes 
            (Name, StartDate, EndDate, Days, StartTime, EndTime, Price, MemPrice, Location, Style, MaxSize, Description, Prerequisites)
            VALUES 
            (:Name, :StartDate, :EndDate, :Days, :StartTime, :EndTime, :Price, :MemPrice, :Location, :Style, :MaxSize, :Description, :Prerequisites)");
        
        $result = $statement->execute([
            'Name' => $Name,
            'StartDate' => $StartDate,
            'EndDate' => $EndDate,
            'Days' => implode(",", $Days), 
            'StartTime' => date("g:i A", strtotime($StartTime)),
            'EndTime' => date("g:i A", strtotime($EndTime)),
            'Price' => $Price,
            'MemPrice' => $MemPrice,
            'Location' => $Location,
            'Style' => $Style,
            'MaxSize' => $MaxSize, 
            'Description' => $Description,
            'Prerequisites' => $Prerequisites
        ]);

        if ($result) {
            header("Location: successClass.php");
            exit();
        }
        else {
            header("Location: createClasses.php?error=unable_to_insert_class");
            exit();
        }
    } catch (PDOException $e) {
        // Log the error message to a file or monitoring system
        error_log("Database Insert Error: " . $e->getMessage());

        // Redirect back with a generic error message
        header("Location: createClasses.php?error=database_error");
        exit();
    }
} else {
    // If accessed directly without POST data, redirect to createClasses.php
    header("Location: createClasses.php");
    exit();
}
?>
