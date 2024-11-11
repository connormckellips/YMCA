<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
</head>
<body>
   <div>
        <!-- Change action to "process_login.php" to handle login in PHP -->
        <form action="process_login.php" method="POST">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            
            <label for="pwd">Password:</label>
            <input type="password" id="pwd" name="pwd" required>
            
            <input type="submit" value="Submit">
        </form>
   </div>
   <div>
        <a href="createAccount.php">Create Account</a>
   </div>

   <!-- Optional: Display error message if login fails -->
   <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_credentials'): ?>
       <p style="color: red;">Invalid email or password. Please try again.</p>
   <?php endif; ?>
</body>
</html>