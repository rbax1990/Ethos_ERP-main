<?php
// Database connection variables
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Assuming the rest of your PHP code would go here

// Start the session
session_start();

// Check for a logout action
if (isset($_GET['logout'])) {
    // Remove all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header('Location: login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP Dashboard</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
        }
        .logo-container {
            text-align: center; /* Center the logo */
            margin: 20px 0; /* Add some margin above and below the logo */
        }
        .dashboard-container {
            display: flex; /* Align sections horizontally */
            justify-content: space-between; /* Distribute space between sections */
            margin: 20px;
        }
        .content-section {
            border: 1px solid #000; /* Add border around the sections */
            padding: 20px; /* Add some padding inside the containers */
            overflow-y: auto; /* Enable vertical scrolling */
            width: 48%; /* Each section takes up roughly half the container width */
        }
        .section-title {
            font-size: 24px; /* Larger text for section titles */
            margin-bottom: 10px; /* Margin below the title */
            border-bottom: 2px solid #000; /* Line under the title */
        }
        .logout-button {
            position: fixed; /* Fixed position */
            left: 20px; /* Distance from the left */
            bottom: 20px; /* Distance from the bottom */
            padding: 10px 20px; /* Padding inside the button */
        }
    </style>
</head>
<body>
    
    <div id="navbar"></div> <!-- This ID matches the one used in navbar.js -->
    <script src="../navbar.js"></script>

    <!-- Company Logo -->
    <div class="company-logo">
        <img src="/Ethos_ERP-main/public/images/Ethos_Mech_Logo_Small.png" alt="Ethos Mechanical Logo">
    </div>
    
    <div class="dashboard-container">
        <div class="content-section">
            <div class="section-title">Ethos Mechanical Newsletter</div>
            <!-- Static newsletter content -->
            <p>When the company site, and ERP are active, there will be periodic updates from throughout the entire company posted here. 
                Leadership will keep the team informed on the newest bids that Ethos has submitted and bids that have been accepted.
                Along with general project updates.
            </p>
            <!-- Add more content as needed -->
        </div>

        <div class="content-section">
            <div class="section-title">Employee Recognition</div>
            <!-- Employee recognition content goes here -->
            <p>When the company site, and ERP are active, this is where employees will be recognized for their contributions to Ethos Mechanical, and any milestones they
                achieve during their tenure with the company.
            </p>
            <!-- Content inside will be scrollable -->
        </div>
    </div>
    <button onclick="window.location.href='http://www.ethosmech.com'" class="logout-button">Logout</button>

    <script src="dashboard.js"></script> <!-- Dashboard specific JavaScript -->
</body>
</html>
