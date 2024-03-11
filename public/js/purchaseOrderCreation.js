document.addEventListener('DOMContentLoaded', function() {
    // Attach event listeners when the document is fully loaded
    document.getElementById('createPoButton').addEventListener('click', displayPoModal);
    document.getElementById('submitPoButton').addEventListener('click', createPurchaseOrder);
});

// Function to display the Purchase Order modal
function displayPoModal() {
    const poModal = document.getElementById('poModal');
    poModal.style.display = 'block';
    poModal.style.position = 'fixed';
    poModal.style.left = '50%';
    poModal.style.top = '50%';
    poModal.style.transform = 'translate(-50%, -50%)';
}

// Function to close the Purchase Order modal
function closeModal() {
    document.getElementById('poModal').style.display = 'none';
}

// Function to create a Purchase Order
function createPurchaseOrder() {
    // Extract values from the modal inputs
    var vendorName = document.getElementById('vendorName').value;
    var vendorCode = document.getElementById('vendorCode').value;
    var poDate = document.getElementById('poDate').value;
    var needByDate = document.getElementById('needByDate').value;


    // Extract the data from the selected items table
    var selectedItems = [];
    var tableRows = document.getElementById('selectedItemsTable').querySelectorAll('tbody tr');
    for (var row of tableRows) {
        var item = {
            material_spec: row.cells[0] && row.cells[0].innerText.trim() !== '' ? row.cells[0].innerText : null,
            brand: row.cells[1] && row.cells[1].innerText.trim() !== '' ? row.cells[1].innerText : null,
            size_1: row.cells[2] && row.cells[2].innerText.trim() !== '' ? row.cells[2].innerText : null,
            size_2: row.cells[3] && row.cells[3].innerText.trim() !== '' ? row.cells[3].innerText : null,
            size_3: row.cells[4] && row.cells[4].innerText.trim() !== '' ? row.cells[4].innerText : null,
            description: row.cells[5] && row.cells[5].innerText.trim() !== '' ? row.cells[5].innerText : null,
            details: row.cells[6] && row.cells[6].innerText.trim() !== '' ? row.cells[6].innerText : null,
            pn: row.cells[7] && row.cells[7].innerText.trim() !== '' ? row.cells[7].innerText : null,
            callout: row.cells[8] && row.cells[8].innerText.trim() !== '' ? row.cells[8].innerText : null,
            quantity: row.cells[9].querySelector('.quantity-input')?.value || null,
            price: row.cells[10].querySelector('.price-input')?.value || null,
            ext_price: row.cells[11].querySelector('.ext-price-input')?.value || null,
            labor_rate: row.cells[12] && row.cells[12].innerText.trim() !== '' ? row.cells[12].innerText : null,
            ext_labor: row.cells[13].querySelector('.ext-labor-input')?.value || null,

        };

        selectedItems.push(item);
    }

    if (selectedItems.length === 0) {
        alert("No Items in Workspace");
    }

    // Create data object to send to server
    var postData = {
        vendorName: vendorName,
        vendorCode: vendorCode,
        poDate: poDate,
        needByDate: needByDate,
        items: selectedItems
    };
  
    console.log(postData)

    // Make AJAX call to server-side script
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/ETHOS_ERP-MAIN/createPurchaseOrder.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    alert('Purchase Order Created Successfully: ' + response.po_number);
                    // Close the modal after successful creation
                    closeModal();
                } else {
                    // Handle application-specific errors returned from the server
                    alert('Error: ' + response.message);
                }
            } catch (e) {
                // Handle JSON parsing error
                alert('Error processing the response: ' + e.message);
            }
        } else {
            // Handle HTTP errors
            alert('HTTP Error: ' + xhr.status);
        }
    };
    xhr.send(JSON.stringify(postData));
}