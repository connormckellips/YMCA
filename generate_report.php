<!DOCTYPE html>
<html>
<head>
    <title>Generate Report</title>
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
            max-width: 600px;
            margin: 50px auto;
            background-color: #01A490;
            border: 1px solid #dce7f3;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* Header Styles */
        h1 {
            text-align: center;
            color: #000000; /* Dodger Blue */
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #000000; 
        }

        input[type="date"],
        input[type="submit"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #dce7f3;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="date"]:focus {
            outline: none;
            border-color: #1e90ff;
            box-shadow: 0 0 5px rgba(30, 144, 255, 0.5);
        }

        input[type="submit"] {
            background-color: #1e90ff;
            color: #ffffff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #4682b4;
        }

        /* Footer Styles */
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #000000;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Enter Date Range</h1>
        <form method="POST" action="process_generate_report.php">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <input type="submit" value="Generate Report">
        </form>
        <div class="footer">
            <p>&copy; 2024 McKellips & Fraker Industries. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
