<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST['className'];
    $StartDate = $_POST['startDate'];
    $EndDate = $_POST['endDate'];
    $Days = $_POST['days'];
    $StartTime = $_POST['startTime'];
    $EndTime = $_POST['endTime'];
    $Price = $_POST['nonPrice'];
    $MemPrice = $_POST['memPrice'];
    $Location = $_POST['roomNum'];
    $Style = $_POST['style'];
    $MaxSize = $_POST['maxSize'];
    $Description = $_POST['description'];
    $Prerequisites = $_POST['prerequisites'];

    try {
        $statement = $pdo->prepare("INSERT INTO classes (Name, StartDate, EndDate, Days, StartTime, EndTime, Price, MemPrice, Location, Style, MaxSize, Description, Prerequisites)
                                    VALUES (:Name, :StartDate, :EndDate, :Days, :StartTime, :EndTime, :Price, :MemPrice, :Location, :Style, :MaxSize, :Description, :Prerequisites)");
        $result = $statement->execute([
                        'Name' => $Name,
                        'StartDate' => $StartDate,
                        'EndDate' => $EndDate,
                        'Days' => implode(",", $Days), 
                        'StartTime' => date("g:i A", strtotime($StartTime)),
                        'EndTime' => date("g:i A", strtotime($EndTime)),
                        'Price' => $Price,
                        'MemPrice' => $MemPrice,
                        'Location' => $Location,
                        'Style' => $Style,
                        'MaxSize' => $MaxSize, 
                        'Description' => $Description,
                        'Prerequisites' => $Prerequisites]);
        if ($result) {
            header("Location: successClass.php");
            exit();
        }
        else {
            header("Location: createClasses.php?error=unable_to_insert_class");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // just in case accessed directly
    header("Location: createClasses.php");
    exit();
}
?>