document.addEventListener('DOMContentLoaded', function() {
    const purchaseOrdersTable = document.getElementById('purchaseOrdersTable');

    // Prevent the default context menu from opening
    purchaseOrdersTable.addEventListener('contextmenu', function(event) {
        event.preventDefault();
        const clickedRow = event.target.closest('tr');
        if (!clickedRow) return; // Click was not on a row

        // Call function to show custom context menu
        showContextMenu(event.pageX, event.pageY, clickedRow);
    });

    // Function to display the custom context menu
    function showContextMenu(x, y, row) {
        // Hide any currently visible context menu
        hideContextMenu();

        const contextMenu = document.createElement('div');
        contextMenu.id = 'poContextMenu';
        contextMenu.style.position = 'fixed';
        contextMenu.style.left = `${x}px`;
        contextMenu.style.top = `${y}px`;
        contextMenu.style.backgroundColor = '#fff';
        contextMenu.style.border = '1px solid #ccc';
        contextMenu.style.padding = '10px';
        contextMenu.innerHTML = `
            <ul>
                <li onclick="attachDocument('quote', '${row.dataset.poNumber}')">Attach Quote</li>
                <li onclick="attachDocument('packingSlip', '${row.dataset.poNumber}')">Attach Packing Slip</li>
                <li onclick="attachDocument('invoice', '${row.dataset.poNumber}')">Attach Invoice</li>
            </ul>
        `;
        document.body.appendChild(contextMenu);
    }

    // Function to hide the context menu
    function hideContextMenu() {
        const existingMenu = document.getElementById('poContextMenu');
        if (existingMenu) {
            existingMenu.remove();
        }
    }

    // Close the context menu if the user clicks elsewhere
    document.addEventListener('click', function(event) {
        if (!event.target.closest('#poContextMenu')) {
            hideContextMenu();
        }
    });

    // Document attachment functionality
    window.attachDocument = function(type, poNumber) {
        // Dynamically create a file input element
        var fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.accept = '.pdf'; // Accept only PDFs
        fileInput.style.display = 'none'; // Hide the file input
        document.body.appendChild(fileInput);
    
        // Simulate a click on the file input to open the file dialog
        fileInput.click();
    
        // Handle file selection
        fileInput.onchange = function(event) {
            if (this.files.length > 0) {
                var file = this.files[0];
                // Prepare FormData object for AJAX request
                var formData = new FormData();
                formData.append('document', file);
                formData.append('type', type);
                formData.append('poNumber', poNumber);
    
                // AJAX request to upload the file
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/ETHOS_ERP-MAIN/documentUpload.php', true);
                xhr.onload = function () {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        // Handle success
                        alert('Document uploaded successfully.');
                        // Optionally, update the UI to indicate the document is attached
                    } else {
                        // Handle failure
                        alert('Failed to upload document.');
                    }
                };
                xhr.send(formData);
            }
    
            // Clean up by removing the temporary file input
            document.body.removeChild(fileInput);
        };
    };

});
