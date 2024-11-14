<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Successful Class Creation</title>
    <style>
        /* Background styling */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background-color: #e0f7fa; /* Light blue background */
            color: #333;
        }

        /* Main container styling */
        .container {
            text-align: center;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 90%;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #28b3b5;
        }

        /* Back to Dashboard button styling */
        .back-button {
            display: inline-block;
            padding: 12px 20px;
            margin-top: 15px;
            background-color: #1f0236;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #3a215e;
        }
    </style>
</head>
<body>
    <!-- Main container -->
    <div class="container">
        <h1>Successfully Created a Class!</h1>
        <a href="dashboard.php" class="back-button">Back to Dashboard</a>
    </div>
</body>
</html>
