<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
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

        .login-container {
            width: 300px;
            padding: 20px;
            background-color: #28b3b5;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            text-align: center;
        }

        .login-container label,
        .login-container input {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .login-container input[type="submit"] {
            background-color: #1f0236;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .login-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .create-account {
            margin-top: 15px;
            display: block;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
   <div class="login-container">
        <form action="process_login.php" method="POST">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            
            <label for="pwd">Password:</label>
            <input type="password" id="pwd" name="pwd" required>
            
            <input type="submit" value="Submit">
        </form>
        <a href="createAccount.php" class="create-account">Create Account</a>
   </div>
</body>
</html>