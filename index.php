<?php
// Include the database connection file
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YMCA</title>
    <style>
        /* Basic styling */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
        }

        /* Top ribbon */
        .top-ribbon {
            background-color: #1f0236;
            padding: 10px;
            text-align: right;
        }
        .top-ribbon .account-link {
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
            background-color: #45a049;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .top-ribbon .account-link:hover {
            background-color: #367837;
        }

        /* Navigation */
        .main-nav {
            display: flex;
            justify-content: center;
            gap: 15px;
            padding: 20px;
            background-color: #28b3b5;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        .main-nav .nav-link {
            text-decoration: none;
            color: white;
            font-weight: bold;
            padding: 15px;
            background-color: #1f0236;
            border-radius: 8px;
            transition: background-color 0.3s;
        }
        .main-nav .nav-link:hover {
            background-color: #45a049;
        }

        /* Header */
        .header {
            text-align: center;
            padding: 50px;
            background-color: #1f0236;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 2.5rem;
        }
        .cta-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #45a049;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .cta-button:hover {
            background-color: #367837;
        }

        /* Content sections */
        .content-section {
            padding: 40px;
            text-align: center;
            background-color: #ffffff;
            margin: 20px auto;
            max-width: 800px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        .content-section.alt-section {
            background-color: #f9f9f9;
        }
        .content-section h2 {
            color: #333;
        }

        /* Footer */
        .footer {
            padding: 20px;
            text-align: center;
            background-color: #1f0236;
            color: white;
            margin-top: 40px;
        }
        .footer .footer-links a {
            color: #45a049;
            text-decoration: none;
            padding: 5px 10px;
            background-color: #333;
            border-radius: 5px;
            margin: 0 5px;
            transition: background-color 0.3s;
        }
        .footer .footer-links a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <!-- login button -->
    <div class="top-ribbon">
        <a href="login.php" class="account-link">Login</a>
    </div>

    <!-- Main Navigation -->
    <nav class="main-nav">
        <a href="classes.html" class="nav-link">Classes</a>
        <a href="membership.html" class="nav-link">Membership</a>
        <a href="contact.html" class="nav-link">Contact Us</a>
    </nav>

    <!-- Main Header -->
    <header class="header">
        <h1>Welcome to the YMCA!</h1>
        <button id="myButton" class="cta-button">Explore Our Programs</button>
    </header>

    <!-- Main Content -->
    <main>
        <section class="content-section">
            <h2>Enroll in Our Classes</h2>
            <p>
                Our classes offer state-of-the-art fitness programs, ensuring
                you will feel happier and healthier!
            </p>
        </section>

        <section class="content-section alt-section">
            <h2>Sign Up for a Membership</h2>
            <p>
                With our membership plan, you can enroll in your favorite
                classes at a discounted price!
            </p>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-links">
            <a href="classes.html">Classes</a>
            <a href="contact.html">Contact Us</a>
        </div>
        <p>&copy; 2023 YMCA. All rights reserved.</p>
    </footer>
</body>
</html>
