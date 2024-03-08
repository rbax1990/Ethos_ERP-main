<?php
header('Content-Type: application/json');

// Get the JSON data posted by the AJAX call
$inputData = json_decode(file_get_contents('php://input'), true);

// Database connection setup
// (Make sure to use prepared statements to prevent SQL injection)
include 'src/config/db_connect.php';

// Validate and format price
$price = filter_var($inputData['price'], FILTER_VALIDATE_FLOAT);
// Ensure $price is a valid float
if ($price === false) {
    echo json_encode(['success' => false, 'error' => 'Invalid price']);
    exit; // Stop execution if the price is invalid
}
$price = round($price, 2); // Format the price to 2 decimal places

// Validate and format laborRate, if necessary
$laborRate = filter_var($inputData['laborRate'], FILTER_VALIDATE_FLOAT);
if ($laborRate === false) {
    echo json_encode(['success' => false, 'error' => 'Invalid labor rate']);
    exit; // Stop execution if the labor rate is invalid
}
$laborRate = round($laborRate, 2); // Format the labor rate to 2 decimal places

// Prepared statement for updating the database
$stmt = $pdo->prepare("UPDATE po_items SET callout = :callout, price = :price, labor_rate = :laborRate WHERE pn = :pn");

// Execute the prepared statement with validated and formatted values
$result = $stmt->execute([
    ':callout' => $inputData['callout'],
    ':price' => $price,
    ':laborRate' => $laborRate,
    ':pn' => $inputData['pn']
]);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    // Provide more detail on the error if possible
    $errorInfo = $stmt->errorInfo();
    echo json_encode(['success' => false, 'error' => 'Failed to update the database', 'detail' => $errorInfo[2]]);
}

?>
