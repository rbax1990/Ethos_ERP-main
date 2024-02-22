<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethos Mechanical PO System</title>
    <link rel="stylesheet" href="../public/css/style.css">

</head>
<body>

<div id="navbar"></div> <!-- This ID matches the one used in navbar.js -->
<script src="../navbar.js"></script>


        <h1>Purchase Order System</h1> <!-- Updated line -->
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

        <h2>Purchase Orders</h2>
        <div id="PurchaseOrdersTable">
            <table border="1">
                <tr>
                    <th class="sticky-header">PO</th>
                    <th class="sticky-header">Project</th>
                    <th class="sticky-header">Task</th>
                    <th class="sticky-header">Buyer</th>
                    <th class="sticky-header">Vendor</th>
                    <th class="sticky-header">PO Amount</th>
                    <th class="sticky-header">Invoiced Amount</th>
                    <th class="sticky-header">Open Commit</th>
                    <th class="sticky-header">Longest LL</th>
                </tr>
            </table>
        </div>
        <div class="blank-window">
            <!-- Content or data will be dynamically updated here -->
        </div>
        <h3>PO Contents</h3>
        <div id="POContents">
            <table border="1">
                <tr>
                    <th class="sticky-header">Sort</th>
                    <th class="sticky-header">Unit ID</th>
                    <th class="sticky-header">Material Spec</th>
                    <th class="sticky-header">Brand</th>
                    <th class="sticky-header">Size</th>
                    <th class="sticky-header">Size 2</th>
                    <th class="sticky-header">Size 3</th>
                    <th class="sticky-header">Description</th>
                    <th class="sticky-header">Details</th>
                    <th class="sticky-header">PN</th>
                    <th class="sticky-header">Callout</th>
                    <th class="sticky-header">Price</th>
                    <th class="sticky-header">Labor Rate (MCA)</th>    
                </tr>
            </table>
        </div>
        <div class="blank-window">
            <!-- Content or data will be dynamically updated here -->
        </div>
        <!-- Add a button to generate PDF -->
        <div id="pdfButtonContainer">
            <button onclick="generatePDF()">Generate PDF</button>
        </div>
    </div>

    <script src="app.js"></script>
    <script>
        document.getElementById('Buyer').value = ''; // Set the default value to an empty string
        function generatePDF() {
            var pdf = new jsPDF();
            var content = document.getElementById('PurchaseOrders');
            
            // Convert HTML to PDF
            pdf.html(content, {
                callback: function (pdf) {
                    // Get the PDF as a Blob
                    var blob = pdf.output('blob');

                    // Create a URL for the Blob
                    var blobURL = URL.createObjectURL(blob);

                    // Create an anchor element to trigger the download
                    var a = document.createElement('a');
                    a.href = blobURL;
                    a.download = 'purchase_order.pdf';

                    // Append the anchor element to the document
                    document.body.appendChild(a);

                    // Trigger a click on the anchor element to start the download
                    a.click();

                    // Remove the anchor element from the document
                    document.body.removeChild(a);
                }
            });
        }
    </script>
</body>
</html>
