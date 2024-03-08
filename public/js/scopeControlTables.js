// scopeControlTables.js

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#scopeControlTable tbody tr').forEach(row => {
        row.addEventListener('click', function() {
            // Assuming the project number is in the first cell
            const projectNumber = this.cells[0].textContent;
            fetchWBSDataAndPopulateWorkspace(projectNumber);
        });
    });
});

function fetchWBSDataAndPopulateWorkspace(projectNumber) {
    fetch('../displayWBSData.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ projectNumber: projectNumber }),
    })
    .then(response => response.json())
    .then(data => {
        populateWBSWorkspaceTable(data);
    })
    .catch(error => console.error('Error fetching WBS data:', error));
}

function populateWBSWorkspaceTable(wbsData) {

    console.log(wbsData); // Log the data to inspect its structure

    const workspaceTableBody = document.querySelector('#wbsTable tbody');
    workspaceTableBody.innerHTML = ''; // Clear existing rows

    wbsData.forEach(item => {
        const row = workspaceTableBody.insertRow();
        
        // Populate the row with formatted WBS item details
        addCell(row, item.project_number);
        addCell(row, item.project_name);
        addCell(row, item.task_name);
        addCell(row, item.task_number);
        addCell(row, item.design_start);
        addCell(row, item.design_finish);
        addCell(row, item.pre_hookup_start);
        addCell(row, item.pre_hookup_finish);
        addCell(row, item.move_in_start);
        addCell(row, item.move_in_finish);
        addCell(row, item.fa);
        addCell(row, item.type);
        addFormattedDollarCell(row, item.org_contract_amount);
        addFormattedDollarCell(row, item.org_cost);
        addFormattedDollarCell(row, item.cp_contract_plus_changes);
        addFormattedDollarCell(row, item.ctc_cost_to_complete);
        addFormattedPercentageCell(row, item.org_margin);
        addFormattedPercentageCell(row, item.current_margin);
        addFormattedDollarCell(row, item.gross_profit);
    });
}

function addCell(row, text) {
    const cell = row.insertCell();
    cell.textContent = text;
}

function addFormattedDollarCell(row, amount) {
    const cell = row.insertCell();
    cell.textContent = `$${numberWithCommas(parseFloat(amount).toFixed(2))}`;
}

function addFormattedPercentageCell(row, percentage) {
    const cell = row.insertCell();
    cell.textContent = `${parseFloat(percentage * 100).toFixed(2)}%`; // Assuming percentage is in decimal form
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
