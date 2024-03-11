function editLineItem(row) {
        // Retrieve the PN (Part Number) as the unique identifier from the data-id attribute
        const itemPN = row.getAttribute('data-id');
    // Save the original data in case the user cancels editing
    const originalData = {
        callout: row.cells[8].textContent.trim(),
        price: parseFloat(row.cells[10].textContent.trim()),
        laborRate: parseFloat(row.cells[12].textContent.trim())
    };

    // Change the cell content to input fields
    row.cells[8].innerHTML = `<input type="text" value="${originalData.callout}" class="edit-callout">`;
    row.cells[10].innerHTML = `<input type="number" value="${originalData.price}" class="edit-price" step="0.01">`;
    row.cells[12].innerHTML = `<input type="number" value="${originalData.laborRate}" class="edit-labor-rate" step="0.01">`;

    // Add Save and Cancel buttons
    const actionsCell = row.cells[row.cells.length - 1]; // Assuming the last cell is the actions cell
    actionsCell.innerHTML = `<button class="save-changes">Save</button> <button class="cancel-changes">Cancel</button>`;

// Save button functionality
actionsCell.querySelector('.save-changes').addEventListener('click', function() {
    // Get the new values
    const newCallout = row.querySelector('.edit-callout').value.trim();
    const newPrice = row.querySelector('.edit-price').value;
    const newLaborRate = row.querySelector('.edit-labor-rate').value;

    // Prepare data to be sent to the server
    const dataToSend = {
        pn: itemPN, // Use the retrieved itemPN for the 'pn' field
        callout: newCallout,
        price: newPrice,
        laborRate: newLaborRate
    };

    // Send the data to the server using fetch
    fetch('/databaseItemMasterEdit.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json', // Sending the data as JSON
        },
        body: JSON.stringify(dataToSend)
    })
    .then(response => response.json())
    .then(data => {
        // Handle response from the server
        if (data.success) {
            // Update the row cells with new values
            row.cells[8].textContent = newCallout;
            row.cells[11].textContent = parseFloat(newPrice).toFixed(2);
            row.cells[12].textContent = parseFloat(newLaborRate).toFixed(2);
        } else {
            // Handle error, revert changes or show an error message
            alert('Error saving changes: ' + data.error);
        }
    })
    .catch(error => {
        // Handle network errors
        alert('Network error while saving changes');
    })
    .finally(() => {
        // Clear the action buttons in any case
        actionsCell.innerHTML = '';
    });
});

 // Cancel button functionality
actionsCell.querySelector('.cancel-changes').addEventListener('click', function() {
    // Revert the cells to the original values
    row.cells[8].textContent = originalData.callout;
    row.cells[10].textContent = !isNaN(originalData.price) ? originalData.price.toFixed(2) : '';
    row.cells[12].textContent = !isNaN(originalData.laborRate) ? originalData.laborRate.toFixed(2) : '';

    // Clear the action buttons
    actionsCell.innerHTML = '';
});
}

function addLineItem(row) {
    // Logic for adding a new line item
    console.log('Adding line item', row);
}

function deleteLineItem(row) {
    // Logic for deleting a line item
    console.log('Deleting line item', row);
}

function copyLineItem(row) {
    // Logic for copying a line item
    console.log('Copying line item', row);
}

function closeAllContextMenus() {
    const menus = document.querySelectorAll('.custom-context-menu');
    menus.forEach(menu => menu.style.display = 'none');
}

document.getElementById("selectedItemsTable").addEventListener("contextmenu", function(event) {
    closeAllContextMenus();
    event.preventDefault();
    const menu = document.getElementById("selectedItemsMenu");
    menu.style.display = "block";
    menu.style.left = `${event.pageX}px`;
    menu.style.top = `${event.pageY}px`;
});

document.getElementById("itemMasterTable").addEventListener("contextmenu", function(event) {
    closeAllContextMenus();
    event.preventDefault();
    const menu = document.getElementById("itemMasterMenu");
    menu.style.display = "block";
    menu.style.left = `${event.pageX}px`;
    menu.style.top = `${event.pageY}px`;
});

document.addEventListener("click", function(event) {
    if (!event.target.closest('.custom-context-menu')) {
        closeAllContextMenus();
    }
});
