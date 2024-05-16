<?php
// Retrieve parameters from the URL
$productName = isset($_GET['product']) ? $_GET['product'] : '';
$customerName = isset($_GET['name']) ? $_GET['name'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';
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
        .form-group input[type="submit"] {
            width: auto;
            background-color: #5cb85c;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
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
    <form action="rate.php" method="POST">
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
        <div class="form-group">
            <input type="submit" value="Submit Review">
        </div>
    </form>
</div>
</main>
</body>
</html>
