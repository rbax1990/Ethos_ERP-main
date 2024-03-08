//PURCHASE ORDER TABLES ONLY
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

        // Add cells for each property in the item
        Object.values(item).forEach((text, index) => {
            const cell = row.insertCell();
            cell.textContent = text;
            
            // Adjust these index values to match WORKSPACE TABLE
            if (index === 10) {
                cell.innerHTML = '';
                const quantityInput = document.createElement('input');
                quantityInput.type = 'number';
                quantityInput.className = 'quantity-input';
                quantityInput.value = item.quantity || 0;
                quantityInput.style.width = '100%';
                cell.appendChild(quantityInput);
            }
            
            // Remove or adjust these if you no longer have 'Ext. Price' and 'Ext. Labor' inputs
            // ... (other column adjustments if needed)
        });
    });
}
