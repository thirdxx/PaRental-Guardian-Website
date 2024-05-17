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
    <title>PaRENTAL</title>
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
      <div class="image-with-text">
  <img id="slideshow-image" src="../images/assets/home3.jpg" alt="Image" />
    <div class="slideshow-images">
      <img src="../images/assets/home3.jpg" alt="Image 5" />
    <img src="../images/assets/home6.jpg" alt="Image 1" />
    <img src="../images/assets/home7.jpg" alt="Image 2" />
    <img src="../images/assets/home8.jpg" alt="Image 3" />
    <img src="../images/assets/home9.jpg" alt="Image 4" />
  <div class="image-text-welcome">Welcome to PaRENTAL</div>
  <div class="image-text">ELEVATE YOUR EVENT EXPERIENCE</div>
  </div>
</div>

      <div class="container">
        <div class="banner">
          <h2>Browse From Over 1000+ Event Products</h2>
          <p>
            Our warehouse is overflowing with party products and rental
            equipment of every kind - with new items being added all the time.
            Because of this, your event plans are only limited by your
            imagination.
          </p>
          </div>
          <div class="container">
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
                            <img class="card-img" src="../images/categories/' . $category["picture"] . '" alt="' . $category["name"] . '">
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
    </div>
     <div class="container">
        <div class="banner">
          <h2>Event Rental Packages for Every Ocassion</h2>
          <p>
            Planning your perfect wedding, corporate event, or party? 
            PaRENTAL makes the process simple by providing everything 
            your special event needs under one roof.
          </p>
          </div>
           <div class="cards">
      <div class="card">
        <img class = card-img src="../images/chair.jpg" alt="Package">
        <h3>Package 1</h3>
        <p>Our starter package offers everything you need to kickstart your event planning journey. From essential furniture to basic lighting, it provides the foundational elements for a comfortable and memorable occasion.</p>
        <a href="/packages/package1.html">Learn More</a>
      </div>
      <div class="card">
        <img class = card-img src="../images/table.jpg" alt="Package">
        <h3>Package 2</h3>
        <p>Elevate your event with our intermediate package, which includes upgraded furniture, stylish décor accents, and enhanced lighting options. Perfect for those seeking a touch of sophistication without breaking the budget.</p>
        <a href="#">Learn More</a>
      </div>
      <div class="card">
        <img class = card-img src="../images/chair.jpg" alt="Package">
        <h3>Package 3</h3>
        <p>Make a statement with our premium package, featuring luxury furniture, stunning lighting effects, and exquisite décor details. Designed for those who desire an unforgettable event experience with all the bells and whistles.</p>
        <a href="#">Learn More</a>
      </div>
      <div class="card">
        <img class = card-img src="../images/table.jpg" alt="Package">
        <h3>Package 4</h3>
        <p>Go all out with our deluxe package, offering top-of-the-line amenities, personalized décor options, and unparalleled service. Tailored to meet the highest standards of luxury and extravagance, it promises an event that exceeds expectations.</p>
        <a href="#">Learn More</a>
      </div>
    </div>
        </div>
      </div>
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

<?php 
}else{
  header("Location: ../login/signin.php?error=You need to login first");

  exit();
}
?>