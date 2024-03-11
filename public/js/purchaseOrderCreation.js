document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('createPoButton').addEventListener('click', displayPoModal);
    document.getElementById('submitPoButton').addEventListener('click', createPurchaseOrder);
});

function displayPoModal() {
    const poModal = document.getElementById('poModal');
    poModal.style.display = 'block';
    poModal.style.position = 'fixed';
    poModal.style.left = '50%';
    poModal.style.top = '50%';
    poModal.style.transform = 'translate(-50%, -50%)';
}

function closeModal() {
    document.getElementById('poModal').style.display = 'none';
}

function createPurchaseOrder() {
    var projectNumber = document.getElementById('projectNumber') ? document.getElementById('projectNumber').value : '';
    var taskNumber = document.getElementById('taskNumber') ? document.getElementById('taskNumber').value : '';
    var taskName = document.getElementById('taskName') ? document.getElementById('taskName').value : '';
    var vendorName = document.getElementById('vendorName') ? document.getElementById('vendorName').value : '';
    var vendorCode = document.getElementById('vendorCode') ? document.getElementById('vendorCode').value : '';
    var poDate = document.getElementById('poDate') ? document.getElementById('poDate').value : '';
    var needByDate = document.getElementById('needByDate') ? document.getElementById('needByDate').value : '';

    var selectedItems = [];
    var tableRows = document.getElementById('selectedItemsTable').querySelectorAll('tbody tr');

    for (var row of tableRows) {
        var priceSpan = row.querySelector('td:nth-child(11) span'); // Adjust the child index as necessary
        var extPriceSpan = row.querySelector('td:nth-child(12) span'); // Adjust the child index as necessary
        var laborRateSpan = row.querySelector('td:nth-child(13) span'); // Adjust the child index as necessary
        var extLaborSpan = row.querySelector('td:nth-child(14) span'); // Adjust the child index as necessary

        var item = {
            material_spec: row.cells[0] ? row.cells[0].innerText.trim() : '',
            brand: row.cells[1] ? row.cells[1].innerText.trim() : '',
            size_1: row.cells[2] ? row.cells[2].innerText.trim() : '',
            size_2: row.cells[3] ? row.cells[3].innerText.trim() : '',
            size_3: row.cells[4] ? row.cells[4].innerText.trim() : '',
            description: row.cells[5] ? row.cells[5].innerText.trim() : '',
            details: row.cells[6] ? row.cells[6].innerText.trim() : '',
            pn: row.cells[7] ? row.cells[7].innerText.trim() : '',
            callout: row.cells[8] ? row.cells[8].innerText.trim() : '',
            quantity: row.querySelector('.quantity-input') ? row.querySelector('.quantity-input').value : '',
            price: priceSpan ? priceSpan.innerText : '', // Capture the span content
            ext_price: extPriceSpan ? extPriceSpan.innerText : '',
            labor_rate: laborRateSpan ? laborRateSpan.innerText : '',
            ext_labor: extLaborSpan ? extLaborSpan.innerText : '',
        };

        selectedItems.push(item);
    }

    if (selectedItems.length === 0) {
        alert("No Items in Workspace");
        return;
    }

    var postData = {
        projectNumber: projectNumber,
        taskNumber: taskNumber,
        taskName: taskName,
        vendorName: vendorName,
        vendorCode: vendorCode,
        poDate: poDate,
        needByDate: needByDate,
        items: selectedItems
    };

    console.log(postData);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/ETHOS_ERP-MAIN/createPurchaseOrder.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    alert('Purchase Order Created Successfully: ' + response.po_number);
                    closeModal();
                } else {
                    alert('Error: ' + response.message);
                }
            } catch (e) {
                alert('Error processing the response: ' + e.message);
            }
        } else {
            alert('HTTP Error: ' + xhr.status);
        }
    };
    xhr.send(JSON.stringify(postData));
}
