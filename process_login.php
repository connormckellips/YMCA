<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['pwd'];
    $userCheck = $pdo->prepare("SELECT * FROM Users WHERE Username = :email AND password = :password LIMIT 1");
    $userCheck->execute(['email' => $email, 'password' => $password]);

    //if there is data, assign it here.
    $user = $userCheck->fetch(PDO::FETCH_ASSOC);//
    //check if user, if not, send 'em back to the login screen to try again. 
    if ($user) {
        //we are a user, now we got to create a session to be maintained.
        $_SESSION['username'] = $user['Username'];
        header("Location: dashboard.php"); //send us to the dashboard
        exit();
    } else {
        header("Location: login.php?error=invalid_credentials");//retry login. add code for max login attempts?
        exit();
    }
} else {
    // just in case accessed directly
    header("Location: login.php");
    exit();
}
