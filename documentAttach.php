<?php
// Basic security checks (authentication, validation, etc.)
// Ensure the user is authenticated and authorized to upload documents

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'], $_POST['poNumber'], $_POST['docType'])) {
    $file = $_FILES['document'];
    $poNumber = $_POST['poNumber'];
    $docType = $_POST['docType'];

    // Validate file type and size
    if ($file['type'] !== 'application/pdf') {
        echo json_encode(['success' => false, 'message' => 'Only PDF documents are allowed.']);
        exit;
    }

    // Generate a unique filename to prevent overwriting
    $destinationPath = 'uploads/' . uniqid('doc_', true) . '.pdf';

    if (move_uploaded_file($file['tmp_name'], $destinationPath)) {
        // Update the database to link the document with the PO
        include 'src/config/db_connect.php'; // Your database connection file

        // Example: Update your database here
        // The SQL query will depend on your database schema
        $stmt = $pdo->prepare("UPDATE purchase_orders SET document_path = :documentPath WHERE po_number = :poNumber AND document_type = :docType");
        $result = $stmt->execute([
            ':documentPath' => $destinationPath,
            ':poNumber' => $poNumber,
            ':docType' => $docType,
        ]);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Document attached successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
