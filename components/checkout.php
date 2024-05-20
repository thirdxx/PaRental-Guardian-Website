<?php
session_start();
include "../components/db_connect.php";
date_default_timezone_set("Asia/Manila");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checked_cart'])) {
    
    // Retrieve address information from form
    $userId = $_SESSION['id'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $apartment = $_POST['apartment'];
    $zipcode = $_POST['zipcode'];
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $fullName = $fname . ' ' . $lname;

    // Construct address string
    $address = "$city, $barangay, $apartment, $zipcode";

    // Retrieve payment method
    $paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

    // Retrieve additional information from the form
    $note = isset($_POST['note']) ? $_POST['note'] : ''; // Note is optional
    $email = isset($_POST['email']) ? $_POST['email'] : ''; // Email
    $phone = isset($_POST['phone']) ? $_POST['phone'] : ''; // Phone

    // Calculate total price
    $totalPrice = $_POST['totalprice'];
    if (isset($_POST['checked_cart']) && is_array($_POST['checked_cart'])) {
        // Insert order into database
        $insert_order_query = "INSERT INTO orders (user_id, date, address, payment, price, name, note, email, phone) VALUES (?, NOW(), ?, ?, ?, ?, ?, ?, ?)";
        $stmt_order = $conn->prepare($insert_order_query);
        $stmt_order->bind_param("issdssss", $userId, $address, $paymentMethod, $totalPrice, $fullName, $note, $email, $phone);
        $stmt_order->execute();
        
        // Retrieve the order ID
        $orderId = $stmt_order->insert_id;

        if ($orderId) {
            foreach ($_POST['checked_cart'] as $cart_id) {
                $cart_id = intval($cart_id);
                $query = "SELECT subtotal, product_id, quantity, start_date, end_date FROM cart WHERE id = $cart_id";
                $result = mysqli_query($conn, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $subtotal = $row['subtotal'];
                    $product_id = $row['product_id'];
                    $quantity = $row['quantity'];
                    $startDate = $row['start_date'];
                    $endDate = $row['end_date'];

                    // Check if rental dates are provided
                    if (isset($_POST['rent-from']) && isset($_POST['rent-from'])) {
                        // If rental dates are provided, use them
                        $start_date = $_POST['rent-from'];
                        $end_date = $_POST['rent-to'];
                        $newsubtotal = $_POST['new_subtotal'];
                    } else {
                        // If rental dates are not provided, use dates from the database
                        $start_date = $startDate;
                        $end_date = $endDate;
                        $newsubtotal = $subtotal;

                    }

                    $insert_item_query = "INSERT INTO order_item (order_id, product_id, quantity, start_date, end_date, status, subtotal) VALUES (?, ?, ?, ?, ?, 'Pending', ?)";
                    $stmt_item = $conn->prepare($insert_item_query);
                    $stmt_item->bind_param("iiissd", $orderId, $product_id, $quantity, $start_date, $end_date, $newsubtotal);
                    $stmt_item->execute();

                    // Update the reserve column in the products table
                    $update_reserve_query = "UPDATE products SET reserve = reserve + ? WHERE id = ?";
                    $stmt_update = $conn->prepare($update_reserve_query);
                    $stmt_update->bind_param("ii", $quantity, $product_id);
                    $stmt_update->execute();

                    // Delete the cart item after storing it in order_item
                    $delete_cart_query = "DELETE FROM cart WHERE id = ?";
                    $stmt_delete = $conn->prepare($delete_cart_query);
                    $stmt_delete->bind_param("i", $cart_id);
                    $stmt_delete->execute();


                }
            }
            // Order successfully inserted, redirect to a success page or do any other necessary actions
            header("Location: ../login/purchase.php");
            exit();
        } else {
            // Order insertion failed, handle the error appropriately
            echo "Error occurred while placing the order.";
        }
    }

} else {
    // If the form is not submitted or no cart items are checked, redirect to the appropriate page
    header("Location: ../login/cart.php");
    exit();
}
?>
