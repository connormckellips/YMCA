<?php
include 'db_connection.php';

// Check if form data was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['email']); // Assuming "email" input is used for username
    $password = trim($_POST['pwd']);

    // Basic validation
    if (empty($username) || empty($password)) {
        header("Location: createAccount.php?error=empty_fields");
        exit();
    }

    try {
        // Check if a user with this username already exists
        $accountCheck = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE Username = :username");
        $accountCheck->execute(['username' => $username]);
        $userExists = $accountCheck->fetchColumn();

        if ($userExists) {
            header("Location: createAccount.php?error=user_exists");
            exit();
        } else {
            // Hash the password before storing it in the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new account with the hashed password
            $newAccount = $pdo->prepare("INSERT INTO Users (First, Last, Username, Password, Role)
                VALUES (:first_name, :last_name, :username, :password, 'NON')
            ");
            $newAccount->execute([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'username' => $username,
                'password' => $hashedPassword
            ]);

            header("Location: login.php?success=account_created");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect if accessed directly
    header("Location: createAccount.php");
    exit();
}
?>
