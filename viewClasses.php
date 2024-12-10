<?php
session_start();
include 'db_connection.php'; 
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Classes</title>
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

        /* Container styling */
        .view-classes-container {
            text-align: center;
            max-width: 500px;
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

        /* Form styling */
        label {
            font-weight: bold;
            color: #333;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        /* Search button styling */
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #28b3b5;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #1f8fa3;
        }

        /* Return to Dashboard button styling */
        .dashboard-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #1f0236;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .dashboard-button:hover {
            background-color: #3a215e;
        }
    </style>
</head>
<body>
    <!-- Return to Dashboard button in the top-right corner -->
    <a href="dashboard.php" class="dashboard-button">Return to Dashboard</a>

    <!-- Main content container -->
    <div class="view-classes-container">
        <h2>Search for Classes</h2>
        <form action="process_viewClasses.php" method="POST">
            <label for="Username">Username:</label>
            <input type="email" id="Username" name="Username" placeholder="johndoe@ymca.com">
            <label for="Class Name">Class Name:</label>
            <input type="text" id="className" name="className" placeholder="Strength & Conditioning">
            <!-- Two separate buttons -->
            <button type="submit" name="action" value="searchByUsername">Search by Username</button>
            <button type="submit" name="action" value="searchByClassName">Search by Class Name</button>
        </form>
    </div>
</body>
</html>
