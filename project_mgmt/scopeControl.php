<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethos Mechanical Project Data</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

<div id="navbar"></div>
<script src="../navbar.js"></script>

<!-- CONTEXT MENUS -->
<div id="itemMasterMenu" class="custom-context-menu" style="display: none;">
    <ul>
        <li onclick="editLineItem()">Edit Line Item</li>
        <li onclick="addLineItem()">Add Line Item</li>
        <li onclick="deleteLineItem()">Delete Line Item</li>
        <li onclick="copyLineItem()">Copy Line Item</li>
    </ul>
</div>

<div id="selectedItemsMenu" class="custom-context-menu" style="display: none;">
    <ul>
        <li onclick="editItem()">Edit</li>
        <li onclick="addLine()">Add Line</li>
        <li onclick="deleteLine()">Delete Line</li>
        <li onclick="copy()">Copy</li>
        <li onclick="paste()">Paste</li>
    </ul>
</div>

<!-- PRINT PO BUTTON - NEED TO UPDATE/DISCO FROM PRINTPO -->
<div class="create-po-container">
    <button id="updateForecastButton">Update Forecast</button>
    <button id="printForecastButton">Print Forecast</button>
    <button id="coEntryButton">C/O Entry</button>
</div>


<div id="updateForecastModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Update Forecast</h2>
        <form id="updateForecastForm">
            <input type="hidden" id="projectIdToUpdate" name="project_id">
            <div class="form-group">
                <label for="ctcInput">CTC (Cost to Complete):</label>
                <input type="number" id="ctcInput" name="ctc" step="0.01" required>
            </div>
            <button type="submit" class="update-button">Update</button>
        </form>
    </div>
</div>


<div class="container">
    <div class="po-filter-box" id="filterBox">
    <form id="purchaseOrder">
            <div class="form-group">
                <label for="Project">Project:</label>
                <input type="text" id="Project" name="Project">
            </div>
            
            <div class="form-group">
                <label for="Task">Task:</label>
                <input type="number" id="Task" name="Task" min="1">
            </div>
            
            <div class="form-group">
                <label for="Buyer">Project Manager:</label>
                <select id="Buyer" name="Buyer">
                    <option value="Buyer 1">Tuttle, Ryan</option>
                    <option value="Buyer 2">Baxley, Ryan</option>
                    <option value="Buyer 3">Maxwell, Alexander</option>
                    <option value="Buyer 4">Baker, Benjamin</option>
                </select>
            </div>

            <div class="form-group">
                <label for="Keyword">Keyword:</label>
                <input type="text" id="Keyword" name="Keyword" step="0.02">
            </div>
        </form>
    </div>

    <div class="table-container">
        <h1>Project Data</h1>
        <div class="scrollable-table">
            <table id="scopeControlTable" border="1">
                <thead>
                    <tr>
                        <th>Project Number</th>
                        <th>Project Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Client Number</th>
                        <th>Client Name</th>
                        <th>Project Manager</th>
                        <th>Org Contract Amount</th>
                        <TH>Org Cost</th>
                        <th>C+P (contract plus changes)</th>
                        <th>Forecasted Cost</th>
                        <th>Org Margin</th>
                        <th>Current Margin</th>
                        <th>Gross Profit</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    include '../src/config/db_connect.php';

                    $sql = "SELECT * FROM projects";
                    $stmt = $pdo->query($sql);

                    while ($row = $stmt->fetch()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["project_number"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["project_name"]) . "</td>"; 
                        echo "<td>" . htmlspecialchars($row["start_date"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["end_date"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["client_number"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["client_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["project_manager"]) . "</td>";
                        echo "<td>$" . number_format($row["org_contract_amount"], 2) . "</td>";
                        echo "<td>$" . number_format($row["org_cost"], 2) . "</td>";
                        echo "<td>$" . number_format($row["cp_contract_plus_changes"], 2) . "</td>";
                        echo "<td>$" . number_format($row["forecasted_cost"], 2) . "</td>";
                        echo "<td>" . number_format($row["org_margin"], 2) . "%</td>";
                        echo "<td>" . number_format($row["current_margin"]) . "%</td>";
                        echo "<td>$" . number_format($row["gross_profit"], 2) . "</td>";
                        echo "</tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<h2>WBS</h2>
<div class="scrollable-table2">
    <table id="wbsTable" border="1">
        <thead>
            <tr>
                <th>Project Number</th>
                <th>Project Name</th>
                <th>Task Name</th>
                <th>Task Number</th>
                <th>Design Start</th>
                <th>Design Finish</th>
                <th>Pre-hookup Start</th>
                <th>Pre-hookup Finish</th>
                <th>Move-in Start</th>
                <th>Move-in Finish</th>
                <th>FA</th>
                <th>Type</th>
                <th>Org Contract Amount</th>
                <th>Org Cost</th>
                <th>C+P (Contract Plus Changes)</th>
                <th>CTC (Cost to Complete)</th>
                <th>Org Margin</th>
                <th>Current Margin</th>
                <th>Gross Profit</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamically populated by JavaScript -->
        </tbody>
    </table>
</div>


<!-- JavaScript Files -->
<script src="../public/js/allTableFunctions.js"></script>
<script src="../public/js/scopeControlTables.js"></script>





</body>
</html>
