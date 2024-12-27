<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Get the plain password

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error); // Handle prepare errors
    }

    // Hash the password *after* preparing the statement
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt->bind_param("sss", $name, $email, $hashed_password); // Bind parameters

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error; // Get the statement error
    }

    $stmt->close(); // Close the statement
    $conn->close(); // Close the connection (good practice)
}
?>