<?php
session_start();
include "../components/db_connect.php";
date_default_timezone_set("Asia/Manila");

if (isset($_SESSION['id'])) {
    $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '';
    $productName = isset($_GET['product']) ? $_GET['product'] : '';
    $customerName = isset($_GET['name']) ? $_GET['name'] : '';
    $email = isset($_GET['email']) ? $_GET['email'] : '';
    $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
        $productName = isset($_POST['product']) ? $_POST['product'] : '';
        $customerName = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $rating = isset($_POST['rating']) ? $_POST['rating'] : '';
        $review = isset($_POST['review']) ? $_POST['review'] : '';

        // Check if the product exists in the products table
        $product_check_sql = "SELECT id FROM products WHERE id = '$product_id'";
        $result = mysqli_query($conn, $product_check_sql);
        if (mysqli_num_rows($result) == 0) {
            echo "Error: Product ID does not exist.";
            exit();
        }

        // Insert data into rate table
        $sql = "INSERT INTO rate (product_id, name, email, rating, review) 
                VALUES ('$product_id', '$customerName', '$email', '$rating', '$review')";
        
        if (mysqli_query($conn, $sql)) {
            // Update counter and total_ratings in products table
            $update_product_sql = "UPDATE products 
                                   SET counter = counter + 1, 
                                       total_ratings = total_ratings + '$rating' 
                                   WHERE id = '$product_id'";
            if (mysqli_query($conn, $update_product_sql)) {
                // Update status in order_item table to "Completed"
                $update_status_sql = "UPDATE order_item SET status = 'Completed' WHERE order_id = '$order_id' AND product_id = '$product_id'";
                if(mysqli_query($conn, $update_status_sql)) {
                    header("Location: ../login/reviews.php?success=1");
                    exit();
                } else {
                    echo "Error updating order status: " . mysqli_error($conn);
                }
            } else {
                echo "Error updating product rating: " . mysqli_error($conn);
            }
        } else {
            echo "Error inserting review: " . mysqli_error($conn);
        }

        mysqli_close($conn);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/contact.css" />
     <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <title>Review and Rating Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
            margin-top: -10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group textarea {
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button{
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #5cb85c;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .rating {
            direction: rtl;
            unicode-bidi: bidi-override;
            text-align: center;
            
        }
        .rating input {
            display: none;
            
        }
        .rating label {
            font-size: 50px;
            color: #ccc;
            cursor: pointer;
            display: inline-block;
            margin-right: 20px;
            margin-top: -20px;
            margin-bottom: -20px;
        }
        .rating input:checked ~ label,
        .rating label:hover,
        .rating label:hover ~ label {
            color: #ffca08;
        }
    </style>
</head>
<body>
 <?php require '../components/header1.php'; ?>
 <main>
<div class="container">
    <h2>Rate Product</h2>
    <form class="form" method="post">
        <div class="form-group">
            <label for="product">Product Name:</label>
            <input type="text" id="product" name="product" value="<?php echo $productName; ?>" required>
        </div>
        <div class="form-group">
            <label for="name"> Your Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $customerName; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        </div>
        <div class="form-group">
            <label for="rating">Rating:</label>
            <div class="rating">
                <input type="radio" id="star5" name="rating" value="5">
                <label for="star5">&#9733;</label>
                <input type="radio" id="star4" name="rating" value="4">
                <label for="star4">&#9733;</label>
                <input type="radio" id="star3" name="rating" value="3">
                <label for="star3">&#9733;</label>
                <input type="radio" id="star2" name="rating" value="2">
                <label for="star2">&#9733;</label>
                <input type="radio" id="star1" name="rating" value="1">
                <label for="star1">&#9733;</label>
            </div>
        </div>
        <div class="form-group">
            <label for="review">Review:</label>
            <textarea id="review" name="review" rows="4"></textarea>
        </div>
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
        <div class="form-group">
            <button type="submit">Submit Review</button>
        </div>
    </form>
</div>
</main>
</body>
</html>
<?php 
}else{
  header("Location: ../login/signin.php?error=You need to login first");
  exit();
}
?>
