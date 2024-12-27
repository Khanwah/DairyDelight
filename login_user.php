<?php
session_start(); // Start the session at the very top
require_once 'db.php'; // Include your database connection file

$error_message = ""; // Initialize an empty error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) { // Check if both fields are set
        $email = mysqli_real_escape_string($conn, $_POST['email']); // Sanitize email input!
        $password = $_POST['password'];

       // $sql = "SELECT user_id, password FROM users WHERE email = '$email'"; // Select only necessary fields
        
        $sql = "SELECT id, password FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        if ($result) { // Check if the query was successful
            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    // Password matches - Login successful
                    $_SESSION['user_id'] = $user['user_id']; // Store user ID in session
                    header("Location: products.html"); // Redirect
                    exit(); // Stop further script execution
                } else {
                    $error_message = "Invalid password.";
                }
            } else {
                $error_message = "Invalid email.";
            }
        } else {
            $error_message = "Database error: " . $conn->error;
        }
    } else {
        $error_message = "Please enter both email and password.";
    }
}
?>
