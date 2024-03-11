<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethos Mechanical Requisitions</title>
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
<div class="create-req-container">
    <button id="submitReqButton">Submit For Approval</button>
</div>

<div class="container">
    <div class="po-filter-box" id="filterBox">
    <form id="requisitionOrder">
            <div class="form-group">
                <label for="Project">Project:</label>
                <input type="text" id="Project" name="Project">
            </div>
            
            <div class="form-group">
                <label for="Task">Task:</label>
                <input type="number" id="Task" name="Task" min="1">
            </div>
            
            <div class="form-group">
                <label for="System">System:</label>
                <input type="text" id="System" name="System" step="0.02">
            </div>

            <div class="form-group">
                <label for="Approver">Approver:</label>
                <select id="Approver" name="Approver">
                </select>
            </div>
        </form>
    </div>

    <div class="table-container">
        <h1>Requisitions</h1>
        <div class="scrollable-table">
            <table id="requisitionsTable" border="1">
                <thead>
                    <tr>
                        <th>Req Number</th>
                        <th>Vendor</th>
                        <th>Vendor Code</th>
                        <th>PO Date</th>
                        <th>Need By Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    include '../src/config/db_connect.php';

                    $sql = "SELECT * FROM requisitions";
                    $stmt = $pdo->query($sql);

                    while ($row = $stmt->fetch()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["req_number"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["vendor_name"]) . "</td>"; 
                        echo "<td>" . htmlspecialchars($row["vendor_code"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["po_date"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["need_by_date"]) . "</td>";
                        echo "</tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<h2>Workspace</h2>
<div class="scrollableTable">
    <table id="workspaceTable" border="1">
        <thead>
            <tr>
                <Th>Req number</th>
                <th>Material Spec</th>
                <th>Brand</th>
                <th>Size 1</th>
                <th>Size 2</th>
                <th>Size 3</th>
                <th>Description</th>
                <th>Details</th>
                <th>PN</th>
                <th>Callout</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Ext. Price</th>
                <th>Labor Rate</th>
                <th>Ext. Labor</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamically populated by JavaScript -->
        </tbody>
    </table>
</div>

<!-- JavaScript Files -->
<script src="../public/js/purchaseOrderTables.js"></script>
<script src="../public/js/allTableFunctions.js"></script>


</body>
</html>
