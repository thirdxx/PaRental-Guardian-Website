<?php
// Start PHP session
session_start();

// Include necessary files and establish database connection
require_once "components/db_connect.php";

// Check if the product ID is provided in the URL
if (isset($_GET['id'])) {
    // Sanitize the product ID
    $productId = $conn->real_escape_string($_GET['id']);
    // Set the product ID in session variable
    $_SESSION['productId'] = $conn->real_escape_string($_GET['id']);

    // Query to fetch product details from the database
    $sql = "SELECT * FROM products WHERE id = '$productId'";
    $result = $conn->query($sql);

    // Check if the product exists
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        // Product details found, display them
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="./css/chair_item.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="./js/totalprice.js"></script>
    <script src="./js/addtocart.js"></script>
</head>
<body>
    <?php require'./components/header.php'; ?>

    <main>
        <div class="search-container">
            <!-- Search bar -->
        </div>

        <div class="container">
            <div class="banner">
                <!-- <h2>?php echo $product['name']; ?></h2> -->
            </div>

            <!-- Product details -->
            <div class="cardproduct">
                <div class="image-column">
                    <img class="card-img" src="./images/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                </div>
                <div class="details-column">
                    <h2><?php echo $product['name']; ?></h2>
                    <h4 class="product-price" data-price="<?php echo $product['price']; ?>">Price: ₱<?php echo $product['price']; ?></h4>
                    <!-- Additional product details -->
                    <h5>Per week</h5><br>
                    <div>
                        <h5>Description:</h5>
                        <?php 
                        // Retrieve the items string
                        $items = $product['color'];

                        // Split the string into an array of items
                        $itemsArray = explode(',', $items);

                        // Loop through the array and wrap each item in a <p> tag
                        foreach ($itemsArray as $item) {
                            echo '<p>' . htmlspecialchars(trim($item), ENT_QUOTES, 'UTF-8') . '</p>';
                        }
                        ?>
                    </div>
                    <p>Material: <?php echo $product['material']; ?></p>
                    <p>Dimension: <?php echo $product['dimension']; ?></p><br>
                    <p>Stock: <?php echo $product['stock']; ?></p>
                    
                </div>
                <!-- Rental section -->
                <div class="rental">
                    <h5>Minimum Rental Duration: 1 day</h5>
                    <div class="rental-section">
                    <label for="rent-from">Rent from:</label>
                    <input type="date" id="rent-from" name="rent-from" onchange="calculatePrice(); disablePastDates()">
                    </div>
                    <div class="rental-section">
                    <label for="rent-to">Rent to:</label>
                    <input type="date" id="rent-to" name="rent-to" onchange="calculatePrice()">
                    </div>
                    <div class="quantity">
                    <button class="minus" onclick="decrementQuantity()">-</button>
                    <input id="quantity" type="number" value="1" min="1" onchange="calculatePrice()">
                    <button class="plus" onclick="incrementQuantity()">+</button>
                    </div>
                    <h4>Total Price: <span id="total-price">₱<?php echo $product['price']; ?></span></h4> 
                    <button class="addtocart" onclick="redirectToDashboard()"">Add to cart <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>
        </div>
        
    </main>

    <?php require'./components/footer.php'; ?>
    <script>
        function redirectToDashboard() {
            // Redirecting to the dashboard page
            window.location.href = "./login/signin.php";
        }

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
