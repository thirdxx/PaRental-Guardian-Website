<?php
session_start();
include "../components/db_connect.php";
date_default_timezone_set("Asia/Manila");

if (isset($_SESSION['id'])) {

// Include necessary files and establish database connection
require_once "../components/db_connect.php";

// Check if the product ID is provided in the URL
if (isset($_GET['id'])) {
    // Sanitize the product ID
    $productId =  $conn->real_escape_string($_GET['id']);

    // Check if the status parameter is present and set
    $status = isset($_GET['status']) ? $_GET['status'] : '';

    // Query to fetch product details from the database
    $sql = "SELECT * FROM products WHERE id = '$productId'";
    $result = $conn->query($sql);


    // Check if the product exists
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        $available_stock = $product['stock'] - ($product['reserve'] + $product['used']);
        // Product details found, display them
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="../css/chair_item.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="../js/totalprice.js"></script>
    <script src="../js/addtocart.js"></script>
    <style>
        .notification {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .success {
            color: green;
            background-color: #dff0d8;
            border-color: #d0e9c6;
        }

        .review-rating .star {
            font-size: 20px;
            color: #f5a623;
        }
        .review p {
            margin: 5px 0 0;
        } 
        table { 
            border-collapse: collapse; 
            border-spacing: 0; 
            width: 100%; 
            border: 0px solid #ddd; 
        } 
            
        th, 
        td { 
            text-align: left; 
            padding: 8px; 
        } 
            
        ::-webkit-scrollbar { 
            width: 10px; 
        } 
    
        ::-webkit-scrollbar-track { 
            background: #e0e0e0; 
        } 
    
        ::-webkit-scrollbar-thumb { 
            background: #e0e0e0; 
        } 
    
        ::-webkit-scrollbar-thumb:hover { 
            background: #adadad; 
        } 
            
        .scroll { 
            display: block; 
            border: 0px solid gray; 
            background-color: #F0F0F0;
            padding: 5px; 
            margin-top: 5px; 
            width: 100%; 
            height: 100px; 
            overflow-y: scroll; 
        } 
    </style>
</head>
<body>
    <?php require'../components/header1.php'; ?>

    <main>
        <div class="search-container">
            <!-- Search bar -->
            
        </div>
        <?php 
            // Display notification if product was added successfully
            if ($status === 'success') {
                echo '<div class="notification success"><p style="text-align: center;">Product added to cart successfully!</p></div>';
            }
        ?>
        <div class="container">
            <div class="banner">
            

                <!-- <h2>?php echo $product['name']; ?></h2> -->
            </div>
            

            <!-- Product details -->
            <div class="cardproduct">
                <div class="image-column">
                    <img class="card-img" src="../images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                </div>
                <div class="details-column">
                    <h2><?php echo $product['name']; ?></h2>
                    <h4 class="product-price" data-price="<?php echo $product['price']; ?>">Price: ₱<?php echo $product['price']; ?></h4>
                    <h5>Per week</h5><br>
                    <p>Color: <?php echo $product['color']; ?></p>
                    <p>Material: <?php echo $product['material']; ?></p>
                    <p>Dimension: <?php echo $product['dimension']; ?></p><br>
                    <p>Stock: <?php echo $available_stock; ?></p>
                    
                    <h3>Reviews</h3>
                        <div class="scroll"> 
                            <?php
                                
                                include "../components/db_connect.php";

                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $sql = "SELECT name, rating, review FROM rate WHERE product_id = $productId";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                            ?>
                                        <div class="review" style="margin-left:10px;">
                                            <div class="review-rating">
                                                <p style="margin-bottom:-10px; color: darkgreen;"><?= $row['name']; ?></p>
                                                <?php
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        echo $i <= $row['rating'] ? '<span class="star">&#9733;</span>' : '<span class="star">&#9734;</span>';
                                                    }
                                                ?>
                                                <span style="font-size: 14px;"> <?= $row['rating']; ?></span>
                                            </div>
                                            <p style="margin-top:-5px"><?= $row['review']; ?></p>
                                        </div>
                                        <hr>
                            <?php
                                    }
                                } else {
                            ?>
                                    <p style="text-align: center; margin-top: 40px;">No reviews</p>
                            <?php
                                }

                             
                            ?>
                </div>
                </div>
                
                
                <!-- Rental section -->
            <form method="post" action="../components/add_cart.php">
                <div class="rental">
                    <h5>Minimum Rental Duration: 1 week</h5>
                    <input type="hidden" name="subtotal" id="total-price-display">
                    <input type="hidden" name="productId" value="<?php echo $productId = $conn->real_escape_string($_GET['id']); ?>">
                    <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
                    <div class="rental-section">
                    <label for="rent-from">Rent from:</label>
                    <input type="date" id="rent-from" name="rent-from" onchange="calculatePrice(); disablePastDates()">
                    </div>
                    <div class="rental-section">
                    <label for="rent-to">Rent to:</label>
                    <input type="date" id="rent-to" name="rent-to" onchange="calculatePrice()">
                    </div>
                    <div class="quantity">
                    <button type="button" class="minus" onclick="decrementQuantity()">-</button>
                    <input name="quantity" id="quantity" type="number" value="1" min="1" onchange="calculatePrice()">
                    <button type="button" class="plus" onclick="incrementQuantity()">+</button>
                    </div>
                    <h4>Total Price: <span id="total-price">₱<?php echo $product['price']; ?></span></h4>
                    <button type="submit" name="submit" class="addtocart" onclick="addToCart(this)" id="add-to-cart-btn" disabled>Add to cart <i class="fas fa-arrow-right"></i></button>
                </div>
            </form>
                
            </div>
        </div>
        
    </main>

    <?php require'../components/footer.php'; ?>
    <script>
        // Disable the "Add to cart" button initially
        document.getElementById('add-to-cart-btn').disabled = true;

        function checkDateSelection() {
            var rentFrom = document.getElementById('rent-from').value;
            var rentTo = document.getElementById('rent-to').value;
            var addToCartButton = document.getElementById('add-to-cart-btn');

            if (rentFrom && rentTo) {
                addToCartButton.removeAttribute('disabled');
            } else {
                addToCartButton.setAttribute('disabled', 'disabled');
            }
        }

        // Call the function initially and on change of rent dates
        checkDateSelection();
        document.getElementById('rent-from').addEventListener('change', checkDateSelection);
        document.getElementById('rent-to').addEventListener('change', checkDateSelection);

        document.addEventListener('DOMContentLoaded', () => {
            const stars = document.querySelectorAll('.rating .star');
            stars.forEach(star => {
                star.addEventListener('click', () => {
                    stars.forEach(s => s.classList.remove('selected'));
                    star.classList.add('selected');
                    const ratingValue = star.getAttribute('data-value');
                    // Save rating value, e.g., send it to the server or use it in the form
                    console.log('Rating value:', ratingValue);
                });
            });
        });
    </script>
</body>
</html>
<?php
    } else {
        // Product not found, display error message or redirect to an error page
        echo "Product not found";
        exit();
    }
} else {
    // Product ID not provided in the URL, display error message or redirect to an error page
    echo "Product ID not provided";
}
?>
<?php 
}else{
  header("Location: ../login/signin.php?error=You need to login first");

  exit();
}
?>