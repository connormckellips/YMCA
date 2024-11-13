<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Redirect to login page if session variable is not set
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Classes</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center; 
            align-items: center; 
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }

        .create-class-container {
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            background-color: #28b3b5;
        }

        form {
            display: flex;
            flex-wrap: wrap;
        }

        label {
            width: 48%;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"],
        input[type="number"] {
            width: 45%; 
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .days-fieldset {
            width: 100%;
            margin: 10px 0;
        }

        .days-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .days-container input[type="checkbox"] {
            margin-right: 5px;
        }

        input[type="submit"] {
            background-color: #1f0236;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="create-class-container">
        <form action="process_createClasses.php" method="POST">
            <label for="className">Class Name:</label>
            <input type="text" id="className" name="className" required>
            
            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" name="startDate" required>

            <label for="endDate">End date:</label>
            <input type="date" id="endDate" name="endDate" required>

            <fieldset class="days-fieldset">
                <legend>Days:</legend>
                <div class="days-container">
                    <input type="checkbox" name="days[]" id="Sunday"><label for="Sunday">Sunday</label>
                    <input type="checkbox" name="days[]" id="Monday"><label for="Monday">Monday</label>
                    <input type="checkbox" name="days[]" id="Tuesday"><label for="Tuesday">Tuesday</label>
                    <input type="checkbox" name="days[]" id="Wednesday"><label for="Wednesday">Wednesday</label>
                    <input type="checkbox" name="days[]" id="Thursday"><label for="Thursday">Thursday</label>
                    <input type="checkbox" name="days[]" id="Friday"><label for="Friday">Friday</label>
                    <input type="checkbox" name="days[]" id="Saturday"><label for="Saturday">Saturday</label>
                </div>
            </fieldset>
            
            <label for="startTime">Start Time:</label>
            <input type="time"id="startTime" name="startTime" required>

            <label for="endTime">End Time:</label>
            <input type="time" id="endTime" name="endTime" required>

            <label for="nonPrice">Non-Member Price:</label>
            <input type="number" id="nonPrice" name="nonPrice" required>

            <label for="memPrice">Member Price:</label>
            <input type="number" id="memPrice" name="memPrice" required>

            <label for="roomNum">Room Number:</label>
            <input type="number" id="roomNum" name="roomNum" required>

            <label for="style">Style:</label>
            <input type="text" id="style" name="style">

            <label for="maxSize">Size:</label>
            <input type="number" id="maxSize" name="maxSize">

            <label for="description">Class Description:</label>
            <input type="text" id="description" name="description" required>

            <label for="prerequisites">Prerequisites:</label>
            <input type="text" id="prerequisites" name="prerequisites" required>

            <input type="submit" value="Create">
        </form>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            const checkboxes = document.querySelectorAll('input[name="days[]"]');
            const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

            if (!isChecked) {
                event.preventDefault();
                alert("Please select at least one day.");
            }
        });
    </script>

</body>
</html>