<?php
// Include the database connection file
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>YMCA</title>
</head>
<body>
    <div id="top-ribbon">
        <a href="login.html"> Account </a>
    </div>
    <div>
        <a href="classes.html"> Classes </a>
    </div>

    <header>
        <h1>Welcome to the YMCA!</h1>
        <button id="myButton">Click Me!</button>
        <script src="script.js"></script>
    </header>

    <section>
        <h2>Enroll in Our Classes</h2>
        <p>
            Our classes offer state-of-the-art fitness programs, ensuring
            you will feel happier and healthier!
        </p>
    </section>

    <section>
        <h2>Sign up for a membership!</h2>
        <p>
            Within our membership plan, you can enroll in your favorite
            classes at a discounted price!
        </p>
    </section>
    
    <footer>
        <div> 
            Classes
        </div>
        <div>
            Contact Us
        </div>
    </footer>
    <?php
    try {
    // Example query (replace 'sample_table' with your actual table name)
    $query = $pdo->query("SELECT * FROM Users");
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        echo "<p>No data available in the table.</p>";
    } else {
        echo "<ul>";
        foreach ($results as $row) {
            // Replace 'column_name' with your actual column name
            echo "<li>" . htmlspecialchars($row['First']) . "</li>";
        }
        echo "</ul>";
    }
} catch (PDOException $e) {
    echo "Error retrieving data: " . $e->getMessage();
}
?>
</body>
</html>
