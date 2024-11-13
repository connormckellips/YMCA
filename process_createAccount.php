<?php
include 'db_connection.php';

// Check if form data was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['pwd']);

    if (empty($email) || empty($password)) {
        header("Location: createAccount.php?error=empty_fields");
        exit();
    }

    try {
        $accountCheck = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE email = :email");
        $accountCheck->execute(['email' => $email]);
        $userExists = $accountCheck->fetchColumn();
        if ($userExists) {
            header("Location: createAccount.php?error=user_exists");
            exit();
        } else {
            $newAccount = $pdo->prepare("INSERT INTO Users (email, password) VALUES (:email, :password)");
            $newAccount->execute([
                'email' => $email,
                'password' => $password 
            ]);
            header("Location: login.php?success=account_created");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    //redirection for naughty users trying direct access. 
    header("Location: createAccount.php");
    exit();
}
?>
