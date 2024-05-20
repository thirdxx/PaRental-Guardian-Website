<?php
session_start();
include "../components/db_connect.php";
date_default_timezone_set("Asia/Manila");


if (isset($_SESSION['id'])) {


if(isset($_GET['name'])) {
    $category_name = $conn->real_escape_string($_GET['name']);

    // Check if the category name is empty
    if(empty($category_name)) {
        echo "Category name is empty";
        exit(); 
    }

    $sql = "SELECT * FROM products WHERE category_id IN (SELECT id FROM category WHERE name = '$category_name')";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $products = array();
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    $conn->close();

    $h2_value = isset($_GET['name']) ? $_GET['name'] : "Category Not Found";

    $cards_html = '';
    $counter = 0;

    if (!empty($products)) {
        foreach ($products as $product) {
            $counter++;
            $counterProduct = $product['counter'];
            if ($counterProduct == 0){
                $ave_rating = 0;
            }else{
                $ratings = $product['total_ratings'];
                $ave_rating = $ratings / $counterProduct;
            }

            if ($counter % 4 == 1) {
                $cards_html .= '<div class="cards">';
            }

            $cards_html .= '
                <div class="card">
                <a href="product_details.php?id=' . $product['id'] . '"><img class="card-img" src="../images/products/' . $product["image"] . '" alt="' . $product["name"] . '"></a>
                <h4>' . $product["name"] . '</h4>
                <p>₱' . $product["price"] . '</p>
                <p>' . number_format($ave_rating, 1) . '⭐</p>
                <a href="product_details.php?id=' . $product['id'] . '" class="addtocart">Add to cart <i class="fas fa-arrow-right"></i></a>
                </div>';

            if ($counter % 4 == 0 || $counter == count($products)) {
                $cards_html .= '</div>'; 
            }
        }
    } else {
        $cards_html = ' 
        <div class="banner">
        <h3>No products available in this category.</h3>
        </div>';
    }
} else {
    echo "Category name not provided";
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="../css/productcategorypage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php require'../components/header1.php'; ?>

    <main>
        <div class="search-container">
            <div class="search-bar">
                <input type="text" placeholder="Search products and packages..." id="searchInput"/>
                <button type="button" class="search-button" id="searchButton">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="container">
            <div class="banner">
                <h2><?php echo $h2_value; ?></h2>
            </div>
            

            <!-- Product cards container -->
            <div id="productContainer">
                <?php echo $cards_html; ?>
            </div>
        </div>
    </main>

    <?php require'../components/footer.php'; ?>

    <script src="../js/addtocart.js"></script>
    <script>
         // Function to redirect to search_product.php when search button is clicked or Enter key is pressed
         function redirectToSearch() {
            var searchText = document.getElementById('searchInput').value.trim();
            if (searchText !== '') {
                window.location.href = 'search_products.php?search=' + encodeURIComponent(searchText);
            }
        }

        // Event listener for search button click
        document.getElementById('searchButton').addEventListener('click', redirectToSearch);

        // Event listener for Enter key press in the input field
        document.getElementById('searchInput').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                redirectToSearch();
            }
        });
    </script>

</body>
</html>
<?php 
}else{
  header("Location: ../login/signin.php?error=You need to login first");

  exit();
}
?>