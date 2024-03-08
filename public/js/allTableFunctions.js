// Highlight selected rows (applies to all scrollable tables and scrollable-table1)
document.addEventListener('DOMContentLoaded', () => {
    // Select tables with either class
    const scrollableTables = document.querySelectorAll('.scrollable-table, .scrollable-table2');

    scrollableTables.forEach(table => {
        const tbody = table.querySelector('tbody'); // Get the tbody element within the table

        tbody.addEventListener('click', (event) => {
            const clickedRow = event.target.closest('tr'); // Find the closest tr ancestor of the clicked element
            if (!clickedRow) return; // If the click wasn't on a row, ignore it

            if (!event.ctrlKey && !event.metaKey) {
                // If Ctrl or Command is NOT held, deselect all other rows
                tbody.querySelectorAll('tr').forEach(row => row.classList.remove('selected-row'));
            }
            // Toggle the class on the clicked row
            clickedRow.classList.toggle('selected-row');
        });
    });
});

//Make cells in table navigatable
document.addEventListener('DOMContentLoaded', () => {
    const table = document.getElementById('selectedItemsTable');
    const masterTableRows = document.querySelectorAll('#itemMasterTable tbody tr');

    // Enhanced keyboard navigation within the table
    table.addEventListener('keydown', (event) => {
        const target = event.target;
        if (target.tagName === 'INPUT') {
            const rowIndex = target.closest('tr').rowIndex;
            const cellIndex = target.closest('td').cellIndex;
            let nextInput = null;

            switch (event.key) {
                case 'ArrowDown':
                    nextInput = table.rows[rowIndex + 1]?.cells[cellIndex].querySelector('input');
                    break;
                case 'ArrowUp':
                    nextInput = table.rows[rowIndex - 1]?.cells[cellIndex].querySelector('input');
                    break;
                case 'ArrowRight':
                case 'Tab':
                    event.preventDefault(); // Prevent the default Tab action
                    if (cellIndex + 1 < table.rows[rowIndex].cells.length) {
                        nextInput = table.rows[rowIndex].cells[cellIndex + 1].querySelector('input');
                    } else {
                        nextInput = table.rows[rowIndex + 1]?.cells[0].querySelector('input');
                    }
                    break;
                case 'ArrowLeft':
                    if (cellIndex > 0) {
                        nextInput = table.rows[rowIndex].cells[cellIndex - 1].querySelector('input');
                    } else {
                        nextInput = table.rows[rowIndex - 1]?.cells[table.rows[rowIndex - 1].cells.length - 1].querySelector('input');
                    }
                    break;
                case 'Enter':
                    nextInput = table.rows[rowIndex + 1]?.cells[cellIndex].querySelector('input');
                    break;
            }

            if (nextInput) {
                nextInput.focus();
            }
        }
    });

    // Automatically select input content on focus
    // Using event delegation for 'focusin' to cover dynamically added inputs
    table.addEventListener('focusin', (event) => {
        if (event.target.tagName === 'INPUT') {
            event.target.select();
        }
    });
});