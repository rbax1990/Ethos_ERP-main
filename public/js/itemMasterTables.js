//ITEM MASTER TABLES
document.addEventListener('DOMContentLoaded', function() {
    const itemMasterTableBody = document.getElementById('itemMasterTable').querySelector('tbody');
  
    itemMasterTableBody.addEventListener('dblclick', function(e) {
        if (e.target.tagName === 'TD') {
            const originalRow = e.target.parentNode;
            const clonedRow = originalRow.cloneNode(true);
  
            clonedRow.addEventListener('dblclick', function() {
                this.remove(); // Removes the cloned row on double-click
            });
  
            // This is the only place where we append the cloned row to the selectedItemsTable
            document.getElementById('selectedItemsTable').querySelector('tbody').appendChild(clonedRow);
        }
    });
});