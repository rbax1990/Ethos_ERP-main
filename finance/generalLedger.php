<?php
include '../src/config/db_connect.php'; // Correct path to your db_connect.php file

$sql = "SELECT project_number FROM wbs_data";
$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}

if ($result->num_rows > 0) {
    // Output each row as a dropdown option
    while($row = $result->fetch_assoc()) {
        echo "<option value='".$row["project_number"]."'>".$row["project_number"]."</option>";
    }
} else {
    echo "<option>No projects found</option>";
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General Ledger</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <script src="../navbar.js"></script>
</head>
<body>

<div id="navbar"></div>

<main>
    <h1>General Ledger</h1>
    <section id="ledger-overview">
        <h2>Ledger Overview</h2>
        <!-- Ledger overview content goes here -->
    </section>
    <section id="chart-of-accounts">
        <h2>Chart of Accounts</h2>
        <table>
            <thead>
                <tr>
                    <th>Account Code</th>
                    <th>Account Name</th>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example row -->
                <tr>
                    <td>1000</td>
                    <td>Cash</td>
                    <td>Asset</td>
                    <td>Cash on hand and in the bank</td>
                </tr>
                <!-- Additional account rows will go here -->
            </tbody>
        </table>
        <!-- Optionally, include buttons or links for adding, editing, and deleting accounts -->
    </section>
    
    <section id="budget-vs-actual">
        <h2>Budget vs Actual</h2>
        <div class="filter-options">
            <label for="project-select">Select Project:</label>
            <select id="project-select">
                <?php
                $sql = "SELECT project_number FROM wbs_data";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    // Output each row as a dropdown option
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='".$row["project_number"]."'>".$row["project_number"]."</option>";
                    }
                } else {
                    echo "<option>No projects found</option>";
                }
                $conn->close();
                ?>
                <option value="all">All Projects</option>
            </select>

            <label for="period-select">Select Period:</label>
            <select id="period-select">
                <!-- Period options like Monthly, Quarterly, Yearly -->
                <option value="duration">Duration</option>
                <option value="monthly">Monthly</option>
                <option value="quarterly">Quarterly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Account</th>
                    <th>Budgeted Amount</th>
                    <th>Actual Amount</th>
                    <th>Variance</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data rows will be dynamically populated here -->
            </tbody>
        </table>
    </section>
    
    <section id="transactions">
        <h2>Transactions</h2>
        <!-- Transactions content goes here -->
    </section>
    <section id="reports">
        <h2>Reports</h2>
        <!-- Reports content goes here -->
    </section>
</main>

</body>
</html>
