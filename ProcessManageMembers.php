<?php
session_start();
include 'db_connection.php'; 

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$currentUsername = $_SESSION['username'];

// Fetch current user's role
$stmt = $pdo->prepare("SELECT Role FROM Users WHERE Username = :username LIMIT 1");
$stmt->execute(['username' => $currentUsername]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Verify that the user has ADM role
if (!$user || $user['Role'] !== "ADM") {
    // If user is not ADM, banish them to dashboard
    header("Location: dashboard.php");
    exit();
}

// Initialize variables for messages
$message = '';
$messageType = '';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "Invalid CSRF token.";
        $messageType = 'error';
    }
    // Check if delete_username is set and not empty
    elseif (!isset($_POST['delete_username']) || empty($_POST['delete_username'])) {
        $message = "No user selected for deletion.";
        $messageType = 'error';
    }
    else {
        //trim user for possible white space.
        $deleteUsername = trim($_POST['delete_username']);
        $deleteUsername = filter_var($deleteUsername, FILTER_SANITIZE_STRING);

        // Safety check, should never be able to get here though. 
        if ($deleteUsername === $currentUsername) {
            $message = "You cannot delete your own account.";
            $messageType = 'error';
        }
        else {
            try {
                $pdo->beginTransaction();
                // Fetch the UserID of the user to be deleted
                $fetchUserIDStmt = $pdo->prepare("SELECT UserID, Role FROM Users WHERE Username = :username LIMIT 1");
                $fetchUserIDStmt->execute(['username' => $deleteUsername]);
                $userToDelete = $fetchUserIDStmt->fetch(PDO::FETCH_ASSOC);

                if (!$userToDelete) {
                    $message = "User '$deleteUsername' does not exist.";
                    $messageType = 'error';
                    $pdo->rollBack();
                }
                elseif ($userToDelete['Role'] === "ADM") {
                    // Prevent ADM from deleting another ADM
                    $message = "You cannot delete another administrator.";
                    $messageType = 'error';
                    $pdo->rollBack();
                }
                else {
                    $userID = $userToDelete['UserID'];
                    // Purge EnrollmentRecords for user
                    $deleteEnrollmentsStmt = $pdo->prepare("DELETE FROM EnrollmentRecords WHERE User = :userID");
                    $deleteEnrollmentsStmt->execute(['userID' => $userID]);

                    $deleteUserStmt = $pdo->prepare("DELETE FROM Users WHERE UserID = :userID");
                    $deleteUserStmt->execute(['userID' => $userID]);


                    $pdo->commit();

                    $message = "User '$deleteUsername' has been deleted successfully.";
                    $messageType = 'success';
                }
            }
            catch (Exception $e) {
                //errpr handling.
                $pdo->rollBack();
                //log
                error_log("Deletion Error: " . $e->getMessage());
                $message = "An error occurred while deleting the user. Please try again.";
                $messageType = 'error';
            }
        }
    }

    // Store error messages in session to display on delete_member.php
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $messageType;

    // Redirect back to delete_member.php
    header("Location: ManageMembers.php");
    exit();
}
else {
    // If accessed without POST, redirect to delete_member.php
    header("Location: ManageMembers.php");
    exit();
}
?>
