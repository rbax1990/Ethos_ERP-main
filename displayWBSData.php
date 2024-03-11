<?php
// Set the content type to application/json for proper JSON response
header('Content-Type: application/json');

if (headers_sent($filename, $linenum)) {
    echo "Headers already sent in $filename on line $linenum\n";
    exit;
}

// Include the database connection file
include 'src/config/db_connect.php';

// Initialize an array to hold the response
$response = [];

// Decode the incoming JSON payload
$inputData = json_decode(file_get_contents('php://input'), true);

// Check if the project number is set in the inputData
if (isset($inputData['projectNumber'])) {
    $projectNumber = $inputData['projectNumber'];

    // Modify the query to join with the purchaseOrdersTable and calculate the sum of invoiced_amount and open_commit
    $sql = "SELECT 
                wbs.*,
                COALESCE(SUM(po.invoiced_amount), 0) AS invoiced_amount,
                COALESCE(SUM(po.open_commit), 0) AS open_commit
            FROM 
                wbs_data AS wbs
            LEFT JOIN 
                purchase_orders AS po 
                ON wbs.project_number = po.project_number AND wbs.task_number = po.task_number
            WHERE 
                wbs.project_number = :projectNumber
            GROUP BY 
                wbs.project_number, wbs.task_number";

    // Security measure: Prepared statement to prevent SQL injection
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['projectNumber' => $projectNumber]);

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
    // Project number key is missing in the inputData
    $response = ['error' => 'Project number key is missing in the request.'];
}

// Encode the response to JSON and output it
echo json_encode($response);

// Check for JSON encoding errors
if (json_last_error() !== JSON_ERROR_NONE) {
    // Log the error message
    error_log('JSON encoding error: ' . json_last_error_msg());
}
?>
