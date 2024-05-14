<?php  
session_start();
include "../components/db_connect.php";
date_default_timezone_set("Asia/Manila");


if (isset($_SESSION['id'])) {
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>renta.com/product categories</title>
    <link rel="stylesheet" href="../css/homepage.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
  </head>
  <body>
  <?php require'../components/header1.php';?>

    <main>
  
      <div class="search-container">
  <div class="search-bar">
    <input type="text" placeholder="Search products and packages..." id="searchInput"/>
    <button type="button" class="search-button" id="searchButton">
      <i class="fas fa-search"></i>
    </button>
  </div>
</div>
      <script src="../js/homepage.js"></script>

      <div class="container">
        <div class="banner">
          <h2>Product Categories</h2>
          </div>
          <?php
            
            include "../components/db_connect.php";

            
            $sql = "SELECT * FROM category";
            $result = $conn->query($sql);

            
            if ($result->num_rows > 0) {
                // Initialize an array to store category data
                $categories = array();

                // Fetch each row of category data and store it in the array
                while ($row = $result->fetch_assoc()) {
                    $categories[] = $row;
                }
            }

            // Close the database connection (assuming your db_conn.php file doesn't close the connection)
            $conn->close();

            // Generate HTML for the cards
            $cards_html = '';
            $counter = 0;

            // Check if category data was fetched successfully
            if (!empty($categories)) {
                // Loop through each category and generate the card HTML
                foreach ($categories as $category) {
                    // Increment the counter
                    $counter++;

                    // Create a new cards div every four entries
                    if ($counter % 4 == 1) {
                        $cards_html .= '<div class="cards">';
                    }

                    $cards_html .= '
                        <div class="card">
                            <img class="card-img" src="../images/' . $category["picture"] . '" alt="' . $category["name"] . '">
                            <h3>' . $category["name"] . '</h3>
                            <p>' . $category["description"] . '</p>
                            <a href="products.php?name=' . $category["name"] . '">View More</a>
                        </div>';

                    // Close the cards div every four entries
                    if ($counter % 4 == 0 || $counter == count($categories)) {
                        $cards_html .= '</div>'; // Close the cards div
                    }
                }
            }

            ?>

          <?php echo $cards_html; ?>

    </main>
    <?php require'../components/footer.php';?>
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
<?php  ?>
<?php 
}else{
  header("Location: ../login/signin.php?error=You need to login first");

  exit();
}
?>