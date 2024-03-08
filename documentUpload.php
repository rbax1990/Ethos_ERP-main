<?php
header('Content-Type: application/json');

include 'src/config/db_connect.php';


// Check if the file and required data are present
if (isset($_FILES['document']) && isset($_POST['type']) && isset($_POST['poNumber'])) {
    // Perform file validation (e.g., check type, size)
    $file = $_FILES['document'];
    $type = $_POST['type'];
    $poNumber = $_POST['poNumber'];

    // Assuming validation is successful, proceed to save the file
    $uploadDir = 'C:/xampp/htdocs/Ethos_ERP-main/uploaded_documents/';
    $uniqueName = uniqid() . basename($file['name']); // Ensure a unique name to avoid overwriting files
    $uploadPath = $uploadDir . $uniqueName;

    // Move the file to the designated directory
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        // File is uploaded successfully
        try {
            // Prepare your SQL statement
            $stmt = $pdo->prepare("INSERT INTO uploaded_documents (po_number, document_type, original_filename, stored_filename, file_path) VALUES (:po_number, :document_type, :original_filename, :stored_filename, :file_path)");

            // Bind parameters and execute
            $stmt->execute([
                ':po_number' => $poNumber,
                ':document_type' => $type,
                ':original_filename' => basename($file['name']),
                ':stored_filename' => $uniqueName,
                ':file_path' => $uploadPath
            ]);
            
            if ($stmt->rowCount() > 0) {
                // Success! The database was updated.
                echo json_encode(['success' => true, 'message' => 'File uploaded and database updated.']);
            } else {
                // The database was not updated.
                echo json_encode(['success' => false, 'message' => 'File uploaded but database not updated.']);
            }
        } catch (PDOException $e) {
            // Handle any errors here
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload file.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>