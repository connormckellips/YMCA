<?php
session_start();
include 'db_connection.php';
//Again checking for if requested. 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['email'];
    $password = $_POST['pwd'];
    $userCheck = $pdo->prepare("SELECT * FROM Users WHERE Username = :username LIMIT 1");
    $userCheck->execute(['username' => $username]);

    $user = $userCheck->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['Password'])) {
        // Password is correct; create session
        $_SESSION['username'] = $user['Username'];
        $_SESSION['UserID'] = $user['UserID'];
        $_SESSION['Role'] = $user['Role'];
        header("Location: dashboard.php");
        exit();
    } else {
        // Invalid credentials
        header("Location: login.php?error=invalid_credentials");
        exit();
    }
} else {
    // Redirect if accessed directly
    header("Location: login.php");
    exit();
}
