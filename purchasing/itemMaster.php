<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethos Mechanical Item Master</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>


<div id="navbar"></div> <!-- This ID matches the one used in navbar.js -->
<script src="../navbar.js"></script>

<!--CONTEXT MENU - itemMaster-->
<div id="itemMasterMenu" class="custom-context-menu" style="display: none;">
    <ul>
        <li onclick="editLineItem()">Edit Line Item</li> <!-- Added line to add a new line item -->
        <li onclick="addLineItem()">Add Line Item</li>
        <li onclick="deleteLineItem()">Delete Line Item</li>
        <li onclick="copyLineItem()">Copy Line Item</li>
    </ul>
</div>

<!-- CONTEXT MENU - selectedItems -->
<div id="selectedItemsMenu" class="custom-context-menu" style="display: none;">
    <ul>
        <li onclick="editItem()">Edit</li>
        <li onclick="addLine()">Add Line</li>
        <li onclick="deleteLine()">Delete Line</li>
        <li onclick="copy()">Copy</li>
        <li onclick="paste()">Paste</li>
    </ul>
</div>

<!--CREATE PO BUTTON-->
<div class="create-po-container">
    <button id="createPoButton">Create Purchase Order</button>
</div>

<!-- CREATE PO CONTEXT MENU -->
<div id="createPoContextMenu" class="custom-context-menu" style="display: none;">
    <form id="poDetailsForm">
        <div>
            <label for="supplierNameContextMenu">Supplier Name:</label>
            <input type="text" id="supplierNameContextMenu" name="supplierName"><br>
        </div>
        <div>
            <label for="poDateContextMenu">PO Date:</label>
            <input type="date" id="poDateContextMenu" name="poDate"><br>
        </div>
        <div>
            <input type="button" value="Submit" onclick="createPurchaseOrder()">
        </div>
    </form>
</div>

<!--CREATE PO BUTTON-->
<div class="create-po-container">
    <button id="createPoButton">Create Purchase Order</button>
</div>

<!-- CREATE PO CONTEXT MENU -->
<div id="createPoContextMenu" class="custom-context-menu" style="display: none;">
    <form id="poDetailsForm">
        <div>
            <label for="supplierNameContextMenu">Supplier Name:</label>
            <input type="text" id="supplierNameContextMenu" name="supplierName"><br>
        </div>
        <div>
            <label for="poDateContextMenu">PO Date:</label>
            <input type="date" id="poDateContextMenu" name="poDate"><br>
        </div>
        <div>
            <input type="button" value="Submit" onclick="createPurchaseOrder()">
        </div>
    </form>
</div>

<!--NEED TO UPDATE THIS FOR SELECTION TREE-->
<div class="container">
    <div class="selection-tree" id="selectionTree">
    <!-- Selection tree will be populated by JavaScript -->
    </div>
    
<div class="table-container">
    <h1>Item Master</h1>
<div class="scrollable-table">
    <table id="itemMasterTable" border="1" onpaste="processPastedData(event)">
        <thead>
            <tr>
                <th>Unit ID</th>
                <th>Material Spec</th>
                <th>Brand</th>
                <th>Size 1</th>
                <th>Size 2</th>
                <th>Size 3</th>
                <th>Description</th>
                <th>Details</th>
                <th>PN</th>
                <th>Callout</th>
                <th>Price</th>
                <th>Labor Rate</th>

            </tr>
        </thead>
        <tbody>
        <?php
                include '../src/config/db_connect.php';  // Include your database connection

                // SQL query to fetch the item data
                $sql = "SELECT * FROM itemMaster";
                $stmt = $pdo->query($sql);

                while ($row = $stmt->fetch()) {
                    // DOUBLE CHECK THIS FIRST LINE. WAS <TR>
                    echo "<tr ondblclick='addItemToSelected(this)'>";
                    // DOUBLE CHECK THIS FIRST LINE. WAS <TR>
                    echo "<tr ondblclick='addItemToSelected(this)'>";
                    echo "<td>". htmlspecialchars($row['unit_id']) . "</td>";
                    echo "<td>". htmlspecialchars($row['material_spec']) . "</td>";
                    echo "<td>". htmlspecialchars($row["brand"]) . "</td>"; 
                    echo "<td>". htmlspecialchars($row["size_1"]) . "</td>";
                    echo "<td>". htmlspecialchars($row["size_2"]) . "</td>";
                    echo "<td>". htmlspecialchars($row["size_3"]) . "</td>";
                    echo "<td>". htmlspecialchars($row["description"]) . "</td>";
                    echo "<td>". htmlspecialchars($row["details"]) . "</td>";
                    echo "<td>". htmlspecialchars($row["pn"]) . "</td>";
                    echo "<td>". htmlspecialchars($row["callout"]) . "</td>";
                    echo "<td>". htmlspecialchars($row["price"]) . "</td>";
                    echo "<td>". htmlspecialchars($row["labor_rate"]) . "</td>";
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
                <th>Unit ID</th>
                <th>Material Spec</th>
                <th>Brand</th>
                <th>Size 1</th>
                <th>Size 2</th>
                <th>Size 3</th>
                <th>Description</th>
                <th>Details</th>
                <th>PN</th>
                <th>Callout</th>
                <th>Price</th>
                <th>Labor Rate</th>
            </tr>
        </thead>
        <tbody>

        <script>
function addItemToSelected(row) {
    var table = document.getElementById("selectedItemsTable").getElementsByTagName('tbody')[0];
    var newRow = row.cloneNode(true);
    newRow.removeAttribute('ondblclick'); // Remove the ondblclick attribute from the cloned row
    table.appendChild(newRow); // Append the cloned row to the Selected Items table
}
</script>

        <script src="../public/js/tableInteractions.js"></script>
        <script src="../public/js/contextMenu.js"></script>
        



        </tbody>
    </table>
</div>
</html>