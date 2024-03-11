//ITEM MASTER TABLES ONLY

//Make quantity and price cells editable
document.addEventListener('DOMContentLoaded', () => {
    const table = document.getElementById('selectedItemsTable');
    const masterTableRows = document.querySelectorAll('#itemMasterTable tbody tr');
    const itemMasterMenu = document.getElementById('itemMasterMenu');

    // Function to close the context menu
    function closeContextMenu() {
        itemMasterMenu.style.display = 'none';
    }

    // Function to position and show the context menu
    function showContextMenu(event, menu) {
        event.preventDefault(); // Prevent the default context menu from opening
        closeContextMenu(); // Close the context menu if it's already open
        menu.style.top = `${event.clientY}px`;
        menu.style.left = `${event.clientX}px`;
        menu.style.display = 'block';
    }

    // Event listener for right-click on master table rows
    masterTableRows.forEach(row => {
        row.addEventListener('contextmenu', (event) => {
            showContextMenu(event, itemMasterMenu);

            // Set actions for context menu items
            itemMasterMenu.querySelector('[onclick^="editLineItem"]').onclick = () => editLineItem(row);
            itemMasterMenu.querySelector('[onclick^="addLineItem"]').onclick = () => addLineItem(row);
            itemMasterMenu.querySelector('[onclick^="deleteLineItem"]').onclick = () => deleteLineItem(row);
            itemMasterMenu.querySelector('[onclick^="copyLineItem"]').onclick = () => copyLineItem(row);
        });
    });

    // Event listener for closing the context menu when clicking outside
    document.addEventListener('click', (event) => {
        if (!event.target.closest('.custom-context-menu')) {
            closeContextMenu();
        }
    });

    // Event listener for closing the context menu with the Escape key
    document.addEventListener('keydown', (event) => {
        if (event.key === "Escape") {
            closeContextMenu();
        }
    });

    
    masterTableRows.forEach(row => {
        row.addEventListener('dblclick', () => {
            const clonedRow = row.cloneNode(true);
            clonedRow.classList.remove('selected-row');
    
            // Positions for quantity and price cells based on the original table structure
            const quantityCellPosition = 9; // Index for the Quantity cell
            const priceCellPosition = 10; // Index for the Price cell
            const laborRateCellPosition = 12; // Index for the Labor Rate cell
    
            // Change the Quantity cell to an input
            const quantityCell = clonedRow.cells[quantityCellPosition];
            const currentQuantity = quantityCell.textContent; // Get current quantity
            quantityCell.innerHTML = `<input type="number" class="quantity-input" value="${currentQuantity}" min="0" style="width: 60px;">`;
    
            // Change the Price cell to a span (if you want it to be non-editable)
            const priceCell = clonedRow.cells[priceCellPosition];
            priceCell.innerHTML = `<span>${priceCell.textContent}</span>`;
    
            // Change the Labor Rate cell to a span (assuming it's non-editable)
            const laborRateCell = clonedRow.cells[laborRateCellPosition];
            laborRateCell.innerHTML = `<span>${laborRateCell.textContent}</span>`;
    
            // Add event listener for quantity change
            const quantityInput = quantityCell.querySelector('.quantity-input');
            quantityInput.addEventListener('change', function() {
                const quantity = parseFloat(this.value);
                const extPriceCell = clonedRow.cells[priceCellPosition + 1]; // Assuming Ext. Price is right after Price
                const extLaborCell = clonedRow.cells[laborRateCellPosition + 1]; // Assuming Ext. Labor is right after Labor Rate
    
                const itemPrice = parseFloat(priceCell.textContent);
                const laborRate = parseFloat(laborRateCell.textContent);
    
                const extPrice = quantity * itemPrice;
                const extLabor = quantity * laborRate;
    
                extPriceCell.innerHTML = `<span>${extPrice.toFixed(2)}</span>`;
                extLaborCell.innerHTML = `<span>${extLabor.toFixed(2)}</span>`;
            });
    
            document.querySelector('#selectedItemsTable tbody').appendChild(clonedRow);
        });
    });
});
