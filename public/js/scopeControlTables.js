// scopeControlTables.js

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#scopeControlTable tbody tr').forEach(row => {
      row.addEventListener('click', function() {
        // Assuming the project number is in the first cell
        const projectNumber = this.cells[0].textContent.trim(); // Use trim() to remove any whitespace
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
    const workspaceTableBody = document.querySelector('#wbsTable tbody');
    workspaceTableBody.innerHTML = ''; // Clear existing rows
  
    wbsData.forEach(item => {
      const row = workspaceTableBody.insertRow();
      
      // Populate the row with WBS item details.
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
      addFormattedPercentageCell(row, item.org_margin);
      addFormattedDollarCell(row, item.cp_contract_plus_changes);
      addFormattedDollarCell(row, item.ctc_cost_to_complete);
      addFormattedPercentageCell(row, item.current_margin);
      addFormattedDollarCell(row, item.cp_labor);
      addCell(row, item.cp_hrs);
      addFormattedDollarCell(row, item.cp_material);
      addFormattedDollarCell(row, item.labor_budget);
      addCell(row, item.hrs_budget);
      addFormattedDollarCell(row, item.material_budget);
      addFormattedDollarCell(row, item.actual_labor);
      addFormattedDollarCell(row, item.invoiced_amount); // Actual Material (Invoiced Amount)
      addFormattedDollarCell(row, item.open_commit);     // Open Commit
      addFormattedDollarCell(row, item.ctc_labor);
      addCell(row, item.ctc_hrs);
      addFormattedDollarCell(row, item.ctc_material);
      addFormattedDollarCell(row, item.org_crew_rate);
      addFormattedDollarCell(row, item.current_crew_rate);
    });
  }
  
  // Helper functions
  function addCell(row, text) {
    const cell = row.insertCell();
    cell.textContent = text;
  }
  
  function addFormattedDollarCell(row, amount) {
    const cell = row.insertCell();
    cell.textContent = formatCurrency(amount);
  }
  
  function addFormattedPercentageCell(row, percentage) {
    const cell = row.insertCell();
    cell.textContent = formatPercentage(percentage);
  }
  
  function formatCurrency(value) {
    if (isNaN(parseFloat(value)) || value === null) {
      return '$0.00';
    } else {
      return `$${parseFloat(value).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
    }
  }
  
  function formatPercentage(value) {
    if (isNaN(parseFloat(value)) || value === null) {
      return '0.00%';
    } else {
      return `${parseFloat(value).toFixed(2)}%`;
    }
  }
  