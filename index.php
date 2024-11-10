
<?php
// Path to your SQLite database file
$databasePath = __DIR__ . '/your_database.db'; // Replace with your database path

try {
    // Create (connect to) SQLite database
    $pdo = new PDO("sqlite:" . $databasePath);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to the SQLite database successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
