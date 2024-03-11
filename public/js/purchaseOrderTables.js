// PURCHASE ORDER TABLES ONLY
document.addEventListener('DOMContentLoaded', function() {
    // Attach event listener to each row in the purchaseOrdersTable
    document.querySelectorAll('#purchaseOrdersTable tbody tr').forEach(row => {
        row.addEventListener('click', function() {
            // Remove highlighting from all other rows
            document.querySelectorAll('#purchaseOrdersTable tbody tr').forEach(r => {
                r.classList.remove('selected-row');
            });

            // Highlight the clicked row
            this.classList.add('selected-row');

            // Assuming the PO number is in the 4th cell
            const poNumber = this.cells[3].textContent;
            fetchPOItemsAndPopulateWorkspace(poNumber);
        });
    });
});

function fetchPOItemsAndPopulateWorkspace(poNumber) {
    // Example: Fetching PO items from the server
    fetch('../displayPurchaseOrderItems.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ poNumber: poNumber }),
    })
    .then(response => response.json())
    .then(data => {
        populateWorkspaceTable(data);
    })
    .catch(error => console.error('Error fetching PO items:', error));
}

function populateWorkspaceTable(items) {
    const workspaceTableBody = document.querySelector('#workspaceTable tbody');
    workspaceTableBody.innerHTML = ''; // Clear existing rows

    let totalExtPrice = 0;
    let totalExtLabor = 0;
    let totalInvoicedAmount = 0; // Added to keep track of invoiced amounts

    items.forEach(item => {
        const row = workspaceTableBody.insertRow();

        Object.values(item).forEach((text, index) => {
            const cell = row.insertCell();
            cell.textContent = text;

            // Assuming the Ext Price is at index 14 and Ext Labor at index 15
            if (index === 15) {
                totalExtPrice += parseFloat(text) || 0;
            }

            if (index === 17) {
                totalExtLabor += parseFloat(text) || 0;
            }

            // Assuming Invoiced Amount is at a certain index, e.g., 16
            if (index === 18) { 
                totalInvoicedAmount += parseFloat(text) || 0;
            }
        });
    });

    // Update the display with the calculated totals
    document.getElementById('totalExtPrice').textContent = formatAsCurrency(totalExtPrice);
    document.getElementById('totalExtLabor').textContent = totalExtLabor.toFixed(2); // Format as a standard number with two decimals

    // Assuming you have a way to get the PO number for the selected row
    const selectedPONumber = document.querySelector('.selected-row').cells[3].textContent;

    // Calculate Open Commit
    const openCommitAmount = totalExtPrice - totalInvoicedAmount;

    // Update the PO Amount and Open Commit in the purchaseOrdersTable
    updatePurchaseOrderAmounts(selectedPONumber, totalExtPrice, openCommitAmount);
}

function updatePurchaseOrderAmounts(poNumber, poAmount, openCommit) {
    // Locate the row in the purchaseOrdersTable
    let rowToUpdate = null;
    document.querySelectorAll('#purchaseOrdersTable tbody tr').forEach(row => {
        if (row.cells[3].textContent === poNumber) {
            rowToUpdate = row;
        }
    });

    if (rowToUpdate) {
        // Update the PO Amount and Open Commit
        rowToUpdate.cells[8].textContent = formatAsCurrency(poAmount); // Replace 9 with the correct index for PO Amount
        rowToUpdate.cells[10].textContent = formatAsCurrency(openCommit); // Replace 11 with the correct index for Open Commit
    }
}

function formatAsCurrency(value) {
    return '$' + value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}
