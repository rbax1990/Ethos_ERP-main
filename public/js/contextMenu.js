// Function to close all context menus
function closeAllContextMenus() {
    const menus = document.querySelectorAll('.custom-context-menu');
    menus.forEach(menu => menu.style.display = 'none');
}

// Function to display context menu for selected items table
document.getElementById("selectedItemsTable").addEventListener("contextmenu", function(event) {
    closeAllContextMenus(); // Close any open context menus
    event.preventDefault(); // Prevent default right-click behavior
    var menu = document.getElementById("selectedItemsMenu");
    menu.style.display = "block";
    menu.style.left = event.pageX + "px";
    menu.style.top = event.pageY + "px";
});

// Function to display context menu for item master table
document.getElementById("itemMasterTable").addEventListener("contextmenu", function(event) {
    closeAllContextMenus(); // Close any open context menus
    event.preventDefault(); // Prevent default right-click behavior
    var menu = document.getElementById("itemMasterMenu");
    menu.style.display = "block";
    menu.style.left = event.pageX + "px";
    menu.style.top = event.pageY + "px";
});

// General function to hide context menus when clicking outside
document.addEventListener("click", function(event) {
    if (!event.target.matches('.custom-context-menu, .custom-context-menu *')) {
        closeAllContextMenus(); // Close all context menus
    }
});
