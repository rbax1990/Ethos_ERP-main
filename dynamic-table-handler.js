//DOUBLE CLICK EVENT FOR TABLES
document.addEventListener('DOMContentLoaded', (function() {
    const itemMasterTableBody = document.getElementById('itemMasterTable').querySelector('tbody');
    const selectedItemsTableBody = document.getElementById('selectedItemsTable').querySelector('tbody');
  
    // Use event delegation to attach a listener to the entire table body
    itemMasterTableBody.addEventListener('dblclick', function(e) {
        // Check if the target of the click is a cell
        if (e.target.tagName === 'TD') {
            const originalRow = e.target.parentNode; // Get the parent row of the clicked cell
            const clonedRow = originalRow.cloneNode(true); // Clone the entire row
  
            // Attach a listener to the cloned row for removal on double-click
            clonedRow.addEventListener('dblclick', function() {
                this.remove(); // Remove the cloned row from the selected items table
            });
  
            selectedItemsTableBody.appendChild(clonedRow); // Append the cloned row to the selected items table
        }
    });
  })());

  // Function to add a new item
function addItem() {
    fetch('/itemMaster/add', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        // your item details here
      }),
    })
    .then(response => response.json())
    .then(data => console.log(data))
    .catch((error) => console.error('Error:', error));
  }
  
  // Function to delete an item
  function deleteItem(itemId) {
    fetch(`/itemMaster/delete/${itemId}`, { method: 'DELETE' })
    .then(response => response.text())
    .then(data => console.log(data))
    .catch((error) => console.error('Error:', error));
  }
  
  // Function to copy an item
  function copyItem(itemId) {
    // Assuming you have a way to get the details of the item to be copied
    const itemDetails = {/* item details to be copied */};
    fetch('/itemMaster/copy', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(itemDetails),
    })
    .then(response => response.json())
    .then(data => console.log(data))
    .catch((error) => console.error('Error:', error));
  }