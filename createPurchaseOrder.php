<?php
// Start output buffering

// Suppress error output to the screen
ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php-error.log'); // Update with the actual path

ob_start();

header('Content-Type: application/json');

include 'src/config/db_connect.php';

// Function to generate the next PO number in sequence
function getNextPONumber($pdo) {
    $stmt = $pdo->query("SELECT po_number FROM purchase_orders ORDER BY po_number DESC LIMIT 1");
    $lastPoNumber = $stmt->fetchColumn();
    $number = intval(substr($lastPoNumber, 3));
    $nextNumber = $number + 1;
    $nextPoNumber = 'PO-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    return $nextPoNumber;
}

$postData = json_decode(file_get_contents('php://input'), true);

try {
    $pdo->beginTransaction();

    $poNumber = getNextPONumber($pdo);

    // Calculate the total PO Amount
    $totalPoAmount = array_sum(array_map(function($item) {
        return $item['ext_price'] ?? 0;
    }, $postData['items']));

    // Assuming initially no amount is invoiced and thus open commit equals PO amount
    $invoicedAmount = 0;
    $openCommit = $totalPoAmount;

    // Insert into purchase_orders with po_amount, invoiced_amount, and open_commit
    $sql = "INSERT INTO purchase_orders (project_number, task_number, task_name, vendor_name, vendor_code, po_date, need_by_date, po_number, po_amount, invoiced_amount, open_commit) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $postData['projectNumber'],
        $postData['taskNumber'],
        $postData['taskName'],
        $postData['vendorName'],
        $postData['vendorCode'],
        $postData['poDate'],
        $postData['needByDate'],
        $poNumber, // Use to generate Unique PO number
        $totalPoAmount,
        $invoicedAmount,
        $openCommit
    ]);

    $poId = $pdo->lastInsertId();

// Insert into po_items
$itemsSql = "INSERT INTO po_items (project_number, task_number, task_name, po_number, material_spec, brand, size_1, size_2, size_3, description, details, pn, callout, quantity, price, ext_price, labor_rate, ext_labor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$itemsStmt = $pdo->prepare($itemsSql);

error_log("Generated PO Number: " . $poNumber);

foreach ($postData['items'] as $item) {
    // Now, include $poNumber as the first argument to execute()
    $itemsStmt->execute([
        $postData['project_number'] ?? null,
        $postData['task_number'] ?? null,
        $postData['task_name'] ?? null,
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
        $item['quantity'] ?? null,
        $item['price'] ?? null,
        $item['ext_price'] ?? null,
        $item['labor_rate'] ?? null,
        $item['ext_labor'] ?? null,

    ]);
}
    $pdo->commit();

    if (ob_get_contents()) {
        error_log("Unexpected output detected before JSON response.");
    }

    ob_end_clean();


   // Assuming the PDO commit was successful, send the JSON response
   $json = json_encode(['status' => 'success', 'po_number' => $poNumber]);
   if (false === $json) {
       // JSON encoding failed, log the error and send an error response
       error_log('JSON encode error: ' . json_last_error_msg());
       echo json_encode(['status' => 'error', 'message' => 'An error occurred.']);
   } else {
       // JSON encoding successful, send the JSON response
       echo $json;
   }
} catch (Exception $e) {
   // Rollback the transaction
   $pdo->rollBack();

   // Log the exception
   error_log("Exception caught during PDO operation: " . $e->getMessage());

   // Clean (erase) the output buffer and turn off output buffering
   if (ob_get_level() > 0) {
       ob_end_clean();
   }
   
   // Send an error response
   echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

// If output buffering is still on, end and flush it
if (ob_get_level() > 0) {
   ob_end_flush();
}