<?php
session_start(); // Start a new session or resume the existing one
include '../src/config/db_connect.php'; // Adjust the path to your db_connect.php file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare a select statement
    $sql = "SELECT id, first_name, last_name, email, password FROM employees WHERE email = :email";
    
    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Check if email exists, if yes then verify password
            if ($stmt->rowCount() == 1) {
                if ($row = $stmt->fetch()) {
                    $id = $row['id'];
                    $hashed_password = $row['password'];
                    // Verify password
                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, start a new session
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["email"] = $email;
                        
                        // Redirect user to dashboard
                        header("Location: /Ethos_ERP-main/dashboard/index.html");
                        exit(); // Prevent further execution
                    } else {
                        // Display an error message if password is not valid
                        echo "The password you entered was not valid.";
                    }
                }
            } else {
                // Display an error message if email doesn't exist
                echo "No account found with that email.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }
}

// Close connection
$pdo = null;
?>