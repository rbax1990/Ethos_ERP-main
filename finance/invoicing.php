<?php
// Include the database connection file
require_once 'db_connect.php';

// Check if the search form was submitted
if (isset($_GET['search'])) {
    // Retrieve the PO number from the form input
    $poNumber = $_GET['poNumber'];

    // Prepare a SQL query to search for invoices by PO number
    $query = "SELECT invoice_number, vendor_name, po_number, invoice_cost FROM po_items WHERE po_number = ?";
    
    // Prepare the statement to prevent SQL injection
    if ($stmt = $mysqli->prepare($query)) {
        // Bind the PO number to the query
        $stmt->bind_param("s", $poNumber);
        
        // Execute the query
        $stmt->execute();
        
        // Bind the result variables
        $stmt->bind_result($invoiceNumber, $vendorName, $poNumber, $invoiceCost);
        
        // Fetch the results and display them
        echo "<table>";
        echo "<tr><th>Invoice Number</th><th>Vendor Name</th><th>PO Number</th><th>Invoice Cost</th></tr>";
        while ($stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($invoiceNumber) . "</td>";
            echo "<td>" . htmlspecialchars($vendorName) . "</td>";
            echo "<td>" . htmlspecialchars($poNumber) . "</td>";
            echo "<td>" . htmlspecialchars($invoiceCost) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Close the statement
        $stmt->close();
    }
    // Close the database connection
    $mysqli->close();
} else {
    // Form not submitted
    echo "Please enter a PO number to search.";
}
?>
