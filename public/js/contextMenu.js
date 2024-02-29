// Function to display context menu for selected items table
document.getElementById("selectedItemsTable").addEventListener("contextmenu", function(event) {
    event.preventDefault(); // Prevent default right-click behavior
    var menu = document.getElementById("selectedItemsMenu");
    menu.style.display = "block";
    menu.style.left = event.pageX + "px";
    menu.style.top = event.pageY + "px";
});

// Function to display context menu for item master table
document.getElementById("itemMasterTable").addEventListener("contextmenu", function(event) {
    event.preventDefault(); // Prevent default right-click behavior
    var menu = document.getElementById("itemMasterMenu");
    menu.style.display = "block";
    menu.style.left = event.pageX + "px";
    menu.style.top = event.pageY + "px";
});

// General function to hide context menus when clicking outside
document.addEventListener("click", function(event) {
    const menus = document.querySelectorAll('.custom-context-menu');
    menus.forEach(menu => {
        if (event.target != menu && !menu.contains(event.target)) {
            menu.style.display = "none";
        }
    });
});
