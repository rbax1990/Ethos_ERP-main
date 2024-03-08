<?php
// Set the content type to application/json for proper JSON response
header('Content-Type: application/json');

// Include the database connection file
require_once 'src/config/db_connect.php'; // Use require_once to ensure the script stops if the file is not found

// Initialize an array to hold the response
$response = [];

// Decode the incoming JSON payload to get the project number
$inputData = json_decode(file_get_contents('php://input'), true);

// Check if the project number is set in the inputData
if (isset($inputData['projectNumber'])) {
    $projectNumber = $inputData['projectNumber'];

    // Security measure: Prepared statement to prevent SQL injection
    $stmt = $pdo->prepare("SELECT * FROM wbs_data WHERE project_number = ?");
    $stmt->execute([$projectNumber]);

    // Fetch the matching WBS items
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if items were found
    if ($items) {
        $response = $items;
    } else {
        // No items found for the project number
        $response = ['error' => 'No WBS data found for the provided project number.'];
    }
} else {
    // project number key is not found in the inputData
    $response = ['error' => 'Project number key is missing in the request.'];
}

// Encode the response to JSON and output it
echo json_encode($response);

// Check for JSON encoding errors
if (json_last_error() !== JSON_ERROR_NONE) {
    // Log the error message
    error_log('JSON encoding error: ' . json_last_error_msg());
}
