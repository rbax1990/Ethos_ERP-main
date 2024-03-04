<?php
header('Content-Type: application/json');

// Assuming your db_connect.php handles establishing the $pdo connection
include 'src/config/db_connect.php';

// Validate and retrieve the PO number from the incoming JSON payload
$poNumber = json_decode(file_get_contents('php://input'), true)['poNumber'];

// Security measure: Prepared statement to prevent SQL injection
$stmt = $pdo->prepare("SELECT * FROM po_items WHERE po_number = ?");
$stmt->execute([$poNumber]);

// Fetch the matching PO items
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the items as JSON
echo json_encode($items);