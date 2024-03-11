<?php
// Include database connection script
include_once 'db_connect.php';

// Create connection
$conn = new mysqli($servername, $username, $password, 'ethos_database');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO employees (first_name, last_name, personal_email, company_email, union_member, created_at) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");

// The `s` in bind_param refers to string type for all parameters
$stmt->bind_param("sssss", $firstName, $lastName, $personalEmail, $companyEmail, $unionMember);

// Set parameters from the form submission
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$personalEmail = $_POST['personal_email'];
$companyEmail = $_POST['company_email'];
$unionMember = $_POST['unionMember']; // Directly use the value from the dropdown

// Execute the statement
if ($stmt->execute()) {
    // Send a JSON response back to the AJAX call
    echo json_encode(['status' => 'success', 'message' => 'Employee registration successful.']);
} else {
    // Send a JSON error message
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>

