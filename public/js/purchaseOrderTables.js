document.addEventListener('DOMContentLoaded', function() {
    // Attach event listener to each row in the purchaseOrdersTable
    document.querySelectorAll('#purchaseOrdersTable tbody tr').forEach(row => {
        row.addEventListener('click', function() {
            // Assuming the PO number is in the first cell
            const poNumber = this.cells[0].textContent;
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

    items.forEach(item => {
        const row = workspaceTableBody.insertRow();
        // Populate the row with PO item details
        // The following assumes your items have properties that match your table headers
        Object.values(item).forEach(text => {
            const cell = row.insertCell();
            cell.textContent = text;
        });
    });
}