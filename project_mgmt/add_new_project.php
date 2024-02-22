<?php
// Assuming you have the PDO connection set up as $pdo
include '../src/config/db_connect.php';

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect data from the POST request
    $projectName = $_POST['ProjectName'];
    $startDate = $_POST['StartDate'];
    $endDate = $_POST['EndDate'];
    $budget = $_POST['Budget'];
    $projectManager = $_POST['ProjectManager'];

    // Prepare an INSERT statement
    $stmt = $pdo->prepare("INSERT INTO scopeControl (project_name, start_date, end_date, budget, project_manager) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$projectName, $startDate, $endDate, $budget, $projectManager]);

    // Check if the insertion was successful
    if ($stmt->rowCount() > 0) {
        echo "New project entry added successfully";
    } else {
        echo "Failed to add new project entry";
    }
} else {
    // Not a POST request
    echo "Invalid request method";
}
?>