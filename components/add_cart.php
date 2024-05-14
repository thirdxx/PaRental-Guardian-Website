<?php
session_start();

// Include necessary files and establish database connection
require_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data

    if (isset($_POST['submit'])) {
    $productId = $_POST['productId'];
    $userId = $_POST['id'];
    $quantity = $_POST['quantity'];
    $startDate = $_POST['rent-from'];
    $endDate = $_POST['rent-to'];
    $subtotal = $_POST['subtotal']; // Retrieve subtotal from form data

    // Insert data into cart table
    $sql = "INSERT INTO cart (user_id, product_id, quantity, start_date, end_date, subtotal) VALUES ('$userId', '$productId', '$quantity', '$startDate', '$endDate', '$subtotal')";

    if ($conn->query($sql) === TRUE) {
        // Item added to cart successfully
        header("Location: ../login/product_details.php?id=$productId&status=success"); // Redirect with success status
        exit();
    } else {
        // Error occurred while adding item to cart
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    }
    
}
?>
