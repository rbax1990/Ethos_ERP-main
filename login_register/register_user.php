<?php
// Assuming you have a database called 'ethos_mech_db' and a table called 'users'

// Database connection variables
$host = 'localhost'; // or your host
$dbname = 'ethos_mech_db';
$username = 'your_database_username';
$password = 'your_database_password';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the data from the form
$firstName = $conn->real_escape_string($_POST['first-name']);
$lastName = $conn->real_escape_string($_POST['last-name']);
$email = $conn->real_escape_string($_POST['email']);
$password = $conn->real_escape_string($_POST['create-password']); // Consider hashing the password

// SQL to insert new user
$sql = "INSERT INTO users (first_name, last_name, email, password) VALUES ('$firstName', '$lastName', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    // Redirect to login page or somewhere else
    header('Location: login.html');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>