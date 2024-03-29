<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethos Mechanical Purchase Orders</title>
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
    <button id="printPoButton">Print Purchase Order</button>
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
                <label for="Buyer">Buyer:</label>
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
        <h1>Purchase Orders</h1>
        <div class="scrollable-table">
            <table id="purchaseOrdersTable" border="1">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Task</th>
                        <th>Task Name</th>   
                        <th>PO Number</th>
                        <th>Vendor</th>
                        <th>Vendor Code</th>
                        <th>PO Date</th>
                        <th>Need By Date</th>
                        <th>PO Amount</th>
                        <th>Invoiced Amount</th>
                        <th>Open Commit</th>
                        <th>Notes</th>
                        <th>Qu</th>
                        <th>PS</th>
                        <th>In</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    include '../src/config/db_connect.php';

                    $sql = "SELECT * FROM purchase_orders";
                    $stmt = $pdo->query($sql);

                    while ($row = $stmt->fetch()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["project_number"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["task_number"]) . "</td>"; 
                        echo "<td>" . htmlspecialchars($row["task_name"]) . "</td>"; 
                        echo "<td>" . htmlspecialchars($row["po_number"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["vendor_name"]) . "</td>"; 
                        echo "<td>" . htmlspecialchars($row["vendor_code"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["po_date"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["need_by_date"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["po_amount"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["invoiced_amount"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["open_commit"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["notes"]) . "</td>";
                        echo "<td><input type='checkbox' disabled ".($row["quote_attached"] ? "checked" : "")."></td>";
                        echo "<td><input type='checkbox' disabled ".($row["packing_slip_attached"] ? "checked" : "")."></td>";
                        echo "<td><input type='checkbox' disabled ".($row["invoice_attached"] ? "checked" : "")."></td>";
                        echo "</tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <!-- PO SUMMARY - EXT. PRICE AND EXT. LABOR ROLLUP -->
    <div id="totalsDisplay" class="totals-summary">
        <p>Total Ext Price: <span id="totalExtPrice">0</span></p>
        <p>Total Ext Labor: <span id="totalExtLabor">0</span></p>
    </div>
</div>

<h2>Workspace</h2>
<div class="scrollableTable">
    <table id="workspaceTable" border="1">
        <thead>
            <tr>
                <th>Project</th>
                <th>Task</th> 
                <th>Task Name</th>   
                <Th>PO number</th>
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
                <th>Labor</th>
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
<script src="../public/js/poAttachHandler.js"></script>



</body>
</html>
