<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethos Mechanical Item Master</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>


<div id="navbar"></div> <!-- This ID matches the one used in navbar.js -->
<script src="../navbar.js"></script>

<h1>Scope Control</h1>

<form id="scopeCtrlFilter">
<div class="form-group">
        <label for="ProjectManager">Project Manager:</label>
        <select id="ProjectManager" name="ProjectManager">
            <option value="" disabled selected>Select Project Manager</option>
            <?php
            include '../src/config/db_connect.php';  // Adjust the path as needed

            // SQL query to fetch all employees
            $sql = "SELECT first_name, last_name FROM employees";
            $stmt = $pdo->query($sql);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value=\"" . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']) . "\">" . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']) . "</option>";
            }
            ?>
        </select>
    </div>
</form>

<button class="custom-button">Update Forecast</button>

<!-- NEEDS PERMISSIONS-->
<!-- HIDDEN CONTEXT MENU FOR NEW PROJECT ENTRY -->
<button class="custom-button">New Project Entry</button>

<div id="newProjectMenu" class="custom-context-menu" style="display: none;">
    <form id="newProjectForm">
        <div class="form-group">
            <label for="ProjectName">Project Name:</label>
            <input type="text" id="ProjectName" name="ProjectName" required>
        </div>
        <div class="form-group">
            <label for="StartDate">Start Date:</label>
            <input type="date" id="StartDate" name="StartDate" required>
        </div>
        <div class="form-group">
            <label for="EndDate">End Date:</label>
            <input type="date" id="EndDate" name="EndDate" required>
        </div>
        <div class="form-group">
            <label for="Budget">Budget:</label>
            <input type="number" id="Budget" name="Budget" required>
        </div>
        <div class="form-group">
            <label for="ProjectManagerMenu">Project Manager:</label>
            <select id="ProjectManagerMenu" name="ProjectManager" required>
                <option value="" disabled selected>Select Project Manager</option>
                <!-- Options populated from the database as shown before -->
            </select>
        </div>
        <div class="form-buttons">
            <button type="button" onclick="hideNewProjectMenu()">Cancel</button>
            <button type="submit">Commit</button>
        </div>
    </form>
</div>

<script>
// Function to show the new project entry context menu
function showNewProjectMenu() {
    var menu = document.getElementById("newProjectMenu");
    menu.style.display = "block";
    // Position the menu in the center of the screen or near the button
    // menu.style.left = ...;
    // menu.style.top = ...;
}

// Function to hide the new project entry context menu
function hideNewProjectMenu() {
    var menu = document.getElementById("newProjectMenu");
    menu.style.display = "none";
}

// Add event listener to the New Project Entry button
document.querySelector('.custom-button').addEventListener('click', showNewProjectMenu);

// Handle form submission
document.getElementById("newProjectForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Collect the form data
    var formData = new FormData(this);

    // Send the data to the server using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'add_new_project.php', true); // The server-side script to handle the insertion
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Request was successful
            console.log('Project added successfully:', xhr.responseText);
            // Optionally, update the UI or perform other actions after adding the item to the database
            hideNewProjectMenu(); // Hide the menu
        } else {
            // Request failed
            console.error('Error adding project:', xhr.statusText);
            // Handle errors if any
        }
    };
    xhr.onerror = function() {
        // Request error
        console.error('Error adding project:', xhr.statusText);
        // Handle errors if any
    };
    xhr.send(formData);
});
</script>
 
<table>
    <thead>
        <tr>
            <th>Project ID</th>
            <th>Project Name</th>
            <th>Client ID</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Budget</th>
            <th>Project Manager</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

</body>
</html>


