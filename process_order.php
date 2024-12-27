<?php
include 'db.php';



// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data and sanitize it
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $product = mysqli_real_escape_string($conn, $_POST['product']);
    $quantity = (int) $_POST['quantity'];
    $payment_method = mysqli_real_escape_string($conn, $_POST['paymentMethod']);

    // Validate required fields (for example)
    if (empty($name) || empty($email) || empty($phone) || empty($product) || empty($quantity) || empty($payment_method)) {
        echo "Please fill out all fields.";
        exit;
    }

    // Prepare SQL query to insert data into the orders table
    $sql = "INSERT INTO orders (name, email, phone, product, quantity, payment_method) 
            VALUES ('$name', '$email', '$phone', '$product', '$quantity', '$payment_method')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Order placed successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
