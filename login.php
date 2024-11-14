<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
    <style>
        /* Full-screen setup and centering */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center; 
            align-items: center; 
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }

        /* Centering container for welcome message and login form */
        .container {
            text-align: center;
        }

        /* Welcome message styling */
        .welcome-message {
            font-size: 1.6rem;
            font-weight: bold;
            margin-bottom: 25px;
            color: #333;
        }

        /* Login form styling */
        .login-container {
            width: 320px;
            padding: 30px;
            background-color: #28b3b5;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            text-align: center;
            margin: 0 auto;
        }

        .login-container label {
            color: #333; /* Darker label color */
            font-weight: bold;
            display: block;
            width: 100%;
            margin-bottom: 8px; /* Add space below labels */
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            color: #333;
            font-weight: bold;
            margin-bottom: 15px; /* Add space below input fields */
        }

        /* Placeholder text styling */
        .login-container input::placeholder {
            color: #555;
            opacity: 1;
        }

        .login-container input[type="submit"] {
            background-color: #1f0236;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 15px; /* Space above submit button */
            margin-bottom: 10px; /* Space below submit button */
        }

        .login-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .create-account {
            margin-top: 20px;
            display: block;
            font-size: 0.9em;
            color: #ffffff;
            text-decoration: none;
        }

        .create-account:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Welcome message -->
        <div class="welcome-message">
            Welcome! Please log in, or create an account.
        </div>

        <!-- Login form container -->
        <div class="login-container">
            <form action="process_login.php" method="POST">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" required>
                
                <label for="pwd">Password:</label>
                <input type="password" id="pwd" name="pwd" placeholder="Enter your password" required>
                
                <input type="submit" value="Submit">
            </form>
            <a href="createAccount.php" class="create-account">Create Account</a>
        </div>
    </div>
</body>
</html>
