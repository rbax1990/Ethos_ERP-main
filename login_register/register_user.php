<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../src/config/db_connect.php'; // Adjust the path as needed

    // Retrieve and sanitize form data
    $firstName = filter_var($_POST['first-name'], FILTER_SANITIZE_STRING);
    $lastName = filter_var($_POST['last-name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Get the raw password

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to insert data into the 'employees' table
    $sql = "INSERT INTO employees (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$firstName, $lastName, $email, $hashedPassword]);

    // Redirect or handle success
    // For example, you could redirect to a login page on success
    header('Location: login.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Ethos Mechanical ERP</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
        }
        .register-form {
            width: 300px;
        }
        .register-form label,
        .register-form input,
        .register-form button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        .register-form button {
            width: auto;
            padding: 10px 20px;
            margin-right: 10px;
        }
        .show-password-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .register-form input[type="checkbox"] {
            display: inline-block;
            width: auto;
            margin-left: 5px;
        }
        .register-form button {
            display: inline-block;
            background-color: #b90f16; /* Red color */
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .register-form button:hover {
            background-color: #a00f15; /* Slightly darker red for hover effect */
        }
        .password-requirements {
        font-size: 0.5rem;
        color: #747474;
        margin: 5px 0 15px 0; /* Adjust spacing as needed */
    }
    </style>
</head>
<body>
    <img src="../public/images/Ethos_Mech_Logo_Small.png" alt="Ethos Mech Logo" class="logo">
    <h2>Ethos Mechanical ERP<br>Please Register Your Account Below</h2>

    <?php if ($errorMessage): ?>
        <p class="error"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <form id="register-form" class="register-form" action="register_user.php" method="POST">
        <input type="text" name="first-name" id="first-name" placeholder="First Name" required>
        <input type="text" name="last-name" id="last-name" placeholder="Last Name" required>
        <input type="email" name="email" id="email" placeholder="Email" required>
        <input type="password" name="password" id="create-password" placeholder="Create Password" required>
        <p class="password-requirements">Password: 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.</p>
        <div class="show-password-container">
            <input type="checkbox" id="show-create-password" onclick="togglePassword('create-password', 'show-create-password')">
            <label for="show-create-password">Show Password</label>
        </div>
        <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password" required>
        <div class="show-password-container">
            <input type="checkbox" id="show-confirm-password" onclick="togglePassword('confirm-password', 'show-confirm-password')">
            <label for="show-confirm-password">Show Password</label>
        </div>
        <div>
            <button type="submit">Register</button>
            <button type="button" onclick="location.href='index.html'">Cancel</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('show-create-password').addEventListener('change', function() {
                togglePassword('create-password', 'show-create-password');
            });
        
            document.getElementById('show-confirm-password').addEventListener('change', function() {
                togglePassword('confirm-password', 'show-confirm-password');
            });
        });
    
        function togglePassword(inputId, checkboxId) {
            var passwordInput = document.getElementById(inputId);
            var passwordCheckbox = document.getElementById(checkboxId);
            passwordInput.type = passwordCheckbox.checked ? 'text' : 'password';
        }
    </script>
</body>
</html>