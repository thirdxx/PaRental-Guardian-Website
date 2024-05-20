<?php
session_start();
require_once "db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checked_cart'])) {
    $checked_carts = $_POST['checked_cart'];
    // Loop through each checked cart item
    foreach ($checked_carts as $cart_id) {
        // Check if the cart item exists in the database
        $cart_id = intval($cart_id);
        $quantity = intval($_POST['cart'][$cart_id]['quantity']);
        $subtotal = $_POST['cart'][$cart_id]['product_price'] * $quantity * $_POST['cart'][$cart_id]['weeks'];

        // Prepare and execute the update query
        $update_query = "UPDATE cart SET quantity = ?, subtotal = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("idi", $quantity, $subtotal, $cart_id);
        $stmt->execute();
    }

    // Redirect to the checkout page or any other page
    echo "<script>window.location.href = '../login/checkout.php';</script>";
    exit();
} else {
    // If the form is not submitted or no cart items are checked, redirect to the appropriate page
    header("Location: ../login/cart.php");
    exit();
}
?>
