<?php 
session_start();
include "../components/db_connect.php";
date_default_timezone_set("Asia/Manila");

if (isset($_SESSION['id'])) {

function fetchCategories($conn) {
    $sql_categories = "SELECT * FROM category";
    $result_categories = $conn->query($sql_categories);
    $categories = array();
    if ($result_categories->num_rows > 0) {
        while ($row = $result_categories->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    return $categories;
}

function fetchProducts($conn, $searchText = "", $categoryName = "", $sortOption = "") {
    $sql = "SELECT * FROM products WHERE 1=1";
    
    // Add search condition to the SQL query
    if (!empty($searchText)) {
        $searchText = "%$searchText%";
        $sql .= " AND name LIKE ?";
    }

    // Add category filter condition to the SQL query
    if (!empty($categoryName)) {
        $sql .= " AND category_id IN (SELECT id FROM category WHERE name = ?)";
    }

    // Add sorting condition to the SQL query
    switch ($sortOption) {
        case 'price-high-low':
            $sql .= " ORDER BY price DESC";
            break;
        case 'price-low-high':
            $sql .= " ORDER BY price ASC";
            break;
        case 'top-sales':
            $sql .= " ORDER BY counter DESC";
            break;
        case 'top-rated':
            $sql .= " ORDER BY total_ratings DESC";
            break;
        case 'latest':
            $sql .= " ORDER BY id DESC";
            break;
        default:
            // Default sorting option if invalid or not specified
            // You can set your default sorting criteria here
            break;
    }

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    if (!empty($searchText) && !empty($categoryName)) {
        $stmt->bind_param("ss", $searchText, $categoryName);
    } elseif (!empty($searchText)) {
        $stmt->bind_param("s", $searchText);
    } elseif (!empty($categoryName)) {
        $stmt->bind_param("s", $categoryName);
    }

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch products from the result
    $products = array();
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $stmt->close();

    return $products;
}

$h2_value = isset($_GET['search']) ? $_GET['search'] : "Category Not Found";

// Fetch categories from the database
$categories = fetchCategories($conn);

// Fetch products based on search, category, and sort parameters
$products = fetchProducts($conn, $_GET['search'] ?? "", $_GET['name'] ?? "", $_GET['sort'] ?? "");

$cards_html = '';
if (!empty($products)) {
    $counter = 0;
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
            <h3>' . $product["name"] . '</h3>
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Product</title>
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
            <div class="sort-filter-row">
                <div class="sort-buttons">
                    <p><i class="fas fa-arrow-up-wide-short"></i>Sort by</p>
                    <button id="relevanceButton">Top Rated</button>
                    <button id="latestButton">Latest</button>
                    <button id="topSalesButton">Top Sales</button>
                    <select onchange="changeSort(this)">
                        <option disabled selected>Price</option>
                        <option value="price-high-low">Price: High to Low</option>
                        <option value="price-low-high">Price: Low to High</option>
                    </select>
                </div>
                <div class="filter-dropdown">
                    <select onchange="changeCategory(this)">
                        <option value="" disabled selected>Filter by</option>
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
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

        // Function to change sorting option
        function changeSort(select) {
            var sortOption = select.value;
            var searchParams = new URLSearchParams(window.location.search);
            searchParams.set('sort', sortOption);
            window.location.href = window.location.pathname + '?' + searchParams.toString();
        }

        // Function to filter by category
        function changeCategory(select) {
            var categoryOption = select.value;
            var searchParams = new URLSearchParams(window.location.search);
            
            if (categoryOption === '') {
                searchParams.delete('name');
            } else {
                searchParams.set('name', categoryOption);
            }

            window.location.href = 'search_products.php?' + searchParams.toString();
        }

        // Event listener for "Top Rated" button click
        document.getElementById('relevanceButton').addEventListener('click', function() {
            var searchParams = new URLSearchParams(window.location.search);
            searchParams.set('sort', 'top-rated');
            window.location.href = window.location.pathname + '?' + searchParams.toString();
        });

        // Event listener for "Latest" button click
        document.getElementById('latestButton').addEventListener('click', function() {
            var searchParams = new URLSearchParams(window.location.search);
            searchParams.set('sort', 'latest');
            window.location.href = window.location.pathname + '?' + searchParams.toString();
        });

        // Event listener for "Top Sales" button click
        document.getElementById('topSalesButton').addEventListener('click', function() {
            var searchParams = new URLSearchParams(window.location.search);
           
            searchParams.set('sort', 'top-sales');
            window.location.href = window.location.pathname + '?' + searchParams.toString();
        });
    </script>

</body>
</html>

<?php 
} else {
  header("Location: ../login/signin.php?error=You need to login first");
  exit();
}
?>
