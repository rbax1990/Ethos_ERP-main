<?php
session_start();

// Database configuration
$host = 'localhost'; // Adjust as necessary
$dbname = 'ethos_mech_db'; // Your database name
$username = 'your_database_username'; // Your database username
$password = 'your_database_password'; // Your database password

// Create database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user input
$email = $conn->real_escape_string($_POST['email']);
$passwordInput = $conn->real_escape_string($_POST['password']);

// SQL to check if the email exists and password verification
$sql = "SELECT id, password FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($passwordInput, $row['password'])) {
        // Password is correct, redirect to dashboard
        $_SESSION['user_id'] = $row['id']; // Set user session or similar
        header('Location: ../dashboard/index.html');
        exit();
    } else {
        // Password is incorrect
        echo "Invalid password.";
    }
} else {
    // Email does not exist
    echo "Email does not exist.";
}

$conn->close();
?>