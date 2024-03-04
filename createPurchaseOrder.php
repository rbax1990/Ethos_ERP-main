<?php
// Start output buffering

// Suppress error output to the screen
ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php-error.log'); //NEED TO UPDATE WITH PATH!

ob_start();

header('Content-Type: application/json');

include 'src/config/db_connect.php';

// Function to generate the next PO number in sequence
function getNextPONumber($pdo) {
    // Retrieve the highest PO number from the database and increment it
    $stmt = $pdo->query("SELECT po_number FROM purchase_orders ORDER BY po_number DESC LIMIT 1");
    $lastPoNumber = $stmt->fetchColumn();

    // Assuming your PO numbers are in the format 'PO-XXXX' where 'XXXX' is a number
    $number = intval(substr($lastPoNumber, 3)); // Extract the numeric part
    $nextNumber = $number + 1; // Increment the number

    // Format the next PO number with leading zeros if necessary
    $nextPoNumber = 'PO-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

    return $nextPoNumber;
}

$postData = json_decode(file_get_contents('php://input'), true);

try {
    $pdo->beginTransaction();

    // Generate the next PO number in sequence
    $poNumber = getNextPONumber($pdo);

    // Insert into purchase_orders
    $sql = "INSERT INTO purchase_orders (vendor_name, vendor_code, po_date, need_by_date, po_number) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $postData['vendorName'],
        $postData['vendorCode'],
        $postData['poDate'],
        $postData['needByDate'],
        $poNumber // Use to generate Unieuqe PO number
    ]);

    $poId = $pdo->lastInsertId();

// Insert into po_items
$itemsSql = "INSERT INTO po_items (po_number, material_spec, brand, size_1, size_2, size_3, description, details, pn, callout, price, labor_rate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$itemsStmt = $pdo->prepare($itemsSql);

error_log("Generated PO Number: " . $poNumber);

foreach ($postData['items'] as $item) {
    // Now, include $poNumber as the first argument to execute()
    $itemsStmt->execute([
        $poNumber, // This is the generated PO number that needs to be included
        $item['material_spec'] ?? null,
        $item['brand'] ?? null,
        $item['size_1'] ?? null,
        $item['size_2'] ?? null,
        $item['size_3'] ?? null,
        $item['description'] ?? null,
        $item['details'] ?? null,
        $item['pn'] ?? null,
        $item['callout'] ?? null,
        $item['price'] ?? null,
        $item['labor_rate'] ?? null,
    ]);
}

    $pdo->commit();
    // Attempt to JSON encode the response
    $json = json_encode(['status' => 'success', 'po_number' => $poNumber]);
    if (json_last_error() !== JSON_ERROR_NONE) {
        // Clear any previous output
        ob_end_clean();
        // Output the JSON error message
        echo json_encode(['status' => 'error', 'message' => json_last_error_msg()]);
        exit;
    }

    // If there's no JSON encoding error, output the success message
    echo $json;

} catch (Exception $e) {
    $pdo->rollBack();
    // Clear any previous output
    ob_end_clean();
    // Output the error message in JSON format
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit;
}

// End the output buffering
ob_end_flush();

