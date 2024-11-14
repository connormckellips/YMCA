<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page with Background</title>
    <style>
        /* Body and HTML setup for full-screen background */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background: url('Bball.jpg') no-repeat center center fixed; /* Ensure path is correct */
            background-size: cover;
            position: relative;
            z-index: 0; /* Ensure the background is layered correctly */
        }

        /* Centering container for login content */
        .container {
            position: relative;
            z-index: 1; /* Above background */
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background for readability */
            padding: 30px;
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Styling for welcome message and login form */
        .welcome-message {
            font-size: 1.6rem;
            font-weight: bold;
            margin-bottom: 25px;
            color: #333;
        }

        .login-container label, .login-container input[type="text"], .login-container input[type="password"], .login-container input[type="submit"] {
            display: block;
            margin: 10px 0;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        .login-container input[type="submit"] {
            background-color: #1f0236;
            color: white;
            border: none;
            cursor: pointer;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-message">
            Welcome! Please log in, or create an account.
        </div>
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

