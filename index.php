<?php  
session_unset();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PaRENTAL</title>
    <link rel="shortcut icon" type="x-icon" href="../images/logo.png">
    <link rel="stylesheet" href="css/homepage.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
  </head>
  <body>
    <?php require'./components/header.php';?>
    <main>
  
      <div class="search-container">
  <div class="search-bar">
    <input type="text" placeholder="Search products and packages..." />
    <button type="button" class="search-button">
      <i class="fas fa-search"></i>
    </button>
  </div>
</div>
      <script src="js/homepage.js"></script>
      <div class="image-with-text">
  <img id="slideshow-image" src="images/home3.jpg" alt="Image" />
    <div class="slideshow-images">
      <img src="images/home3.jpg" alt="Image 5" />
    <img src="images/home6.jpg" alt="Image 1" />
    <img src="images/home7.jpg" alt="Image 2" />
    <img src="images/home8.jpg" alt="Image 3" />
    <img src="images/home9.jpg" alt="Image 4" />
  <div class="image-text-welcome">Welcome to PaRental Guardians</div>
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
          <div class="cards">
      <div class="card">
        <img class = card-img src="images/chair.jpg" alt="Chairs">
        <h3>Chairs</h3>
        <p> Elevate your event with our diverse selection of chairs, offering comfort and style for any occasion.</p>
        <a href="products.php?name=Chairs">View More</a>
      </div>
      <div class="card">
        <img class = card-img src="images/table.jpg" alt="Tables">
        <h3>Tables</h3>
        <p>Discover the perfect table to anchor your event space, whether it's for dining, displays, or networking.</p>
        <a hhref="products.php?name=Tables">View More</a>
      </div>
      <div class="card">
        <img class = card-img src="images/furniture.jpg" alt="Furniture">
        <h3>Flatware</h3>
        <p>Add a touch of elegance to your dining experience with our exquisite flatware collection. .</p>
        <a href="products.php?name=Flatware">View More</a>
      </div>
      <div class="card">
        <img class = card-img src="images/linen.jpg" alt="Linens">
        <h3>Linens</h3>
        <p>Enhance your table settings with our linens, adding elegance and sophistication to every meal.</p>
        <a href="products.php?name=Linens">View More</a>
      </div>
    </div>
        </div>
      <div class="cards2">
      <div class="card2">
        <img class = card-img src="images/tent.jpg" alt="tent">
        <h3>Tent</h3>
        <p> Provide shelter with our tent options, ensuring your event is memorable rain or shine.</p>
        <a href="products.php?name=Tent">View More</a>
      </div>
      <div class="card2">
        <img class = card-img src="images/glassware.jpg" alt="Glassware">
        <h3>Glassware</h3>
        <p> Elevate your beverage service with our premium glassware, adding a touch of sophistication to every toast.</p>
        <a href="products.php?name=Glassware">View More</a>
      </div>
      <div class="card2">
        <img class = card-img src="images/lighting.jpg" alt="Lighting">
        <h3>Lighting</h3>
        <p>Illuminate your event with our lighting options, highlight every moment with elegance and flair.</p>
        <a href="products.php?name=Lighting">View More</a>
      </div>
      <div class="card2">
        <img class = card-img src="images/cooking.png" alt="Serving">
        <h3>Serving</h3>
        <p> Ensure seamless food presentation and service with our quality food service equipment.</p>
        <a href="products.php?name=Serving">View More</a>
      </div>  
    </div>
     <div class="container">
        <div class="banner">
          <h2>Event Rental Packages for Every Ocassion</h2>
          <p>
            Planning your perfect wedding, corporate event, or party? 
            PaRental Guradians makes the process simple by providing everything 
            your special event needs under one roof.
          </p>
          </div>
           <div class="cards">
      <div class="card">
        <img class = card-img src="images/chair.jpg" alt="Package">
        <h3>Package 1</h3>
        <p>Our starter package offers everything you need to kickstart your event planning journey. From essential furniture to basic lighting, it provides the foundational elements for a comfortable and memorable occasion.</p>
        <a href="/packages/package1.html">Learn More</a>
      </div>
      <div class="card">
        <img class = card-img src="images/table.jpg" alt="Package">
        <h3>Package 2</h3>
        <p>Elevate your event with our intermediate package, which includes upgraded furniture, stylish décor accents, and enhanced lighting options. Perfect for those seeking a touch of sophistication without breaking the budget.</p>
        <a href="#">Learn More</a>
      </div>
      <div class="card">
        <img class = card-img src="images/chair.jpg" alt="Package">
        <h3>Package 3</h3>
        <p>Make a statement with our premium package, featuring luxury furniture, stunning lighting effects, and exquisite décor details. Designed for those who desire an unforgettable event experience with all the bells and whistles.</p>
        <a href="#">Learn More</a>
      </div>
      <div class="card">
        <img class = card-img src="images/table.jpg" alt="Package">
        <h3>Package 4</h3>
        <p>Go all out with our deluxe package, offering top-of-the-line amenities, personalized décor options, and unparalleled service. Tailored to meet the highest standards of luxury and extravagance, it promises an event that exceeds expectations.</p>
        <a href="#">Learn More</a>
      </div>
    </div>
        </div>
      </div>
    </main>
    <?php require'./components/footer.php';?>
  </body>
</html>
<?php  ?>