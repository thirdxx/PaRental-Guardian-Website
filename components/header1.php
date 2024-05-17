<?php
include "../components/db_connect.php"; // Include the database connection

// Initialize cart count
$cart_count = 0;

// Check if user is logged in and get user ID
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    echo "<script>console.log('User ID: " . $user_id . "');</script>"; // Debugging line for user ID

    // Fetch cart count for the user
    $sql = "SELECT COUNT(*) AS cart_count FROM cart WHERE user_id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $cart_count);
            mysqli_stmt_fetch($stmt);
            echo "<script>console.log('Cart Count Query Result: " . $cart_count . "');</script>"; // Debugging line for cart count
        } else {
            echo "Execute failed: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Prepare failed: " . mysqli_error($conn);
    }
} else {
    echo "<script>console.log('User not logged in');</script>"; // Debugging line for not logged in
}

// Debugging: Output the cart count to the console
echo "<script>console.log('Cart count: " . $cart_count . "');</script>";
?>

<header>
    <div class="logo">
        <span>PaRENTAL</span>
    </div>
    <div>
        <nav>
            <ul>
                <li><a href="../login/homepage.php">Home</a></li>
                <li class="dropdown">
                    <a href="../login/product_categories.php">Products</a>
                    <div class="dropdown-content">
                        <div class="column">
                            <a href="../login/products.php?name=Chairs"><i class="fas fa-chair" style="margin-right: 5px"></i> Chairs </a>
                            <a href="../login/products.php?name=Tables"><i class="fas fa-square" style="margin-right: 5px"></i> Tables </a>
                            <a href="../login/products.php?name=Dinnerwares"><i class="fas fa-record-vinyl" style="margin-right: 5px"></i> Dinnerwares </a> 
                        </div>
                        <div class="column">
                            <a href="../login/products.php?name=Services"><i class="fas fa-circle" style="margin-right: 5px"></i> Services </a>
                            <a href="../login/products.php?name=Glassware"><i class="fas fa-wine-glass" style="margin-right: 5px"></i> Glassware </a>
                            <a href="../login/products.php?name=Flatware"><i class="fas fa-utensils" style="margin-right: 5px"></i> Flatware </a>
                        </div>
                        <div class="column">
                            <a href="../login/products.php?name=Linens"><i class="fas fa-sticky-note" style="margin-right: 5px"></i> Linens </a>
                            <a href="../login/products.php?name=Tent"><i class="fas fa-campground" style="margin-right: 5px"></i> Tent </a>
                            <a href="../login/products.php?name=Lights and Decorations"><i class="fas fa-regular fa-lightbulb" style="margin-right: 5px"></i> Light & Deco </a>
                        </div>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="../login/packages.php">Packages</a>
                </li>
                <li><a href="../login/about.php">About</a></li>
                <li><a href="../login/contact.php">Contact</a></li>
            </ul>
        </nav>
    </div>
    <div>
        <a href="../login/cart.php" class="cart-button">
            <span id="cartCount"><?php echo $cart_count; ?></span> <i class="fas fa-shopping-cart"></i> 
        </a>
        <a href="../login/user_profile.php" style="text-decoration: none; font-size: 20px; color: #4e4d4d; padding: 5px; display: inline-block;">
            <i class="fas fa-solid fa-user" style="margin-right: 20px;"></i>
        </a>
    </div>
</header>
