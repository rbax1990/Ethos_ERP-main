<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethos Mechanical Item Master</title>
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

<!-- CREATE PO BUTTON -->
<div class="create-po-container">
    <button id="createPoButton">Create Purchase Order</button>
</div>

<!-- PURCHASE ORDER MODAL -->
<div id="poModal" class="modal" style="display:none;">
    <div class="modal-content">
        <h2>Create Purchase Order</h2>
        <form id="poDetailsForm">
            <label for="vendorName">Vendor Name:</label>
            <input type="text" id="vendorName" name="vendor_name" required><br>

            <label for="vendorCode">Vendor Code:</label>
            <input type="text" id="vendorCode" name="vendor_code" required><br>

            <label for="poDate">PO Date:</label>
            <input type="date" id="poDate" name="po_date" required><br>

            <label for="needByDate">Need By Date:</label>
            <input type="date" id="needByDate" name="need_by_date" required><br>

            <!-- Additional fields -->

            <input type="button" value="Create PO" id="submitPoButton" class="create-po-button">
            <input type="button" value="Cancel" onclick="closeModal()" class="cancel-button">
        </form>
    </div>
</div>

<div class="container">
    <div class="selection-tree" id="selectionTree"></div>
    
    <div class="table-container">
        <h1>Item Master</h1>
        <div class="scrollable-table">
            <table id="itemMasterTable" border="1">
                <thead>
                    <tr>
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
                <?php
                    include '../src/config/db_connect.php';

                    $sql = "SELECT *, quantity * price AS extended_price FROM itemMaster";
                    $stmt = $pdo->query($sql);
                    
                    while ($row = $stmt->fetch()) {
                        $pn = htmlspecialchars($row["pn"]); // Ensure to escape the content to prevent XSS
                        echo "<tr data-id='{$pn}'>"; // Set the data-id attribute to the PN value
                        echo "<td>" . htmlspecialchars($row["material_spec"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["brand"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["size_1"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["size_2"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["size_3"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["details"]) . "</td>";
                        echo "<td>" . $pn . "</td>"; // PN is already escaped above
                        echo "<td>" . htmlspecialchars($row["callout"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["quantity"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["price"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["extended_price"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["labor_rate"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["ext_labor"]) . "</td>";
                        echo "</tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<h2>Selected Items</h2>
<div class="scrollableTable">
    <table id="selectedItemsTable" border="1">
        <thead>
            <tr>
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
<script src="../public/js/contextMenu.js"></script>
<script src="../public/js/itemMasterTables.js"></script>
<script src="../public/js/purchaseOrderCreation.js"></script>
<script src="../public/js/allTableFunctions.js"></script>


</body>
</html>