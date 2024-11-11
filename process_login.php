<?php
session_start();
include 'db_connection.php'; // Connect to the database

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['pwd'];

    // Check if user exists in the database
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE Username = :email AND password = :password LIMIT 1");
    $stmt->execute(['email' => $email, 'password' => $password]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // User is authenticated
        $_SESSION['username'] = $user['Username']; // Store the username in the session
        header("Location: dashboard.php"); // Redirect to a protected page
        exit();
    } else {
        // Redirect back to login with an error message
        header("Location: login.php?error=invalid_credentials");
        exit();
    }
} else {
    // Redirect to login page if accessed directly
    header("Location: login.php");
    exit();
}