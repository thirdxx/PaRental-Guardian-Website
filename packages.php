<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>renta.com/packages</title>
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

      <div class="container">
        <div class="banner">
          <h2>Packages</h2>
        </div>
        <div class="cards">
          <div class="card">
            <img
              class="card-img"
              src="images/chair.jpg"
              alt="Party Decorations"
            />
            <h3>Package 1</h3>
            <p>
              Our starter package offers everything you need to kickstart your
              event planning journey. From essential furniture to basic
              lighting, it provides the foundational elements for a comfortable
              and memorable occasion.
            </p>
            <a href="/packages/package1.html">Learn More</a>
          </div>
          <div class="card">
            <img
              class="card-img"
              src="images/table.jpg"
              alt="Party Decorations"
            />
            <h3>Package 2</h3>
            <p>
              Elevate your event with our intermediate package, which includes
              upgraded furniture, stylish décor accents, and enhanced lighting
              options. Perfect for those seeking a touch of sophistication
              without breaking the budget.
            </p>
            <a href="#">Learn More</a>
          </div>
          <div class="card">
            <img
              class="card-img"
              src="images/chair.jpg"
              alt="Party Decorations"
            />
            <h3>Package 3</h3>
            <p>
              Make a statement with our premium package, featuring luxury
              furniture, stunning lighting effects, and exquisite décor details.
              Designed for those who desire an unforgettable event experience
              with all the bells and whistles.
            </p>
            <a href="#">Learn More</a>
          </div>
          <div class="card">
            <img
              class="card-img"
              src="images/table.jpg"
              alt="Party Decorations"
            />
            <h3>Package 4</h3>
            <p>
              Go all out with our deluxe package, offering top-of-the-line
              amenities, personalized décor options, and unparalleled service.
              Tailored to meet the highest standards of luxury and extravagance,
              it promises an event that exceeds expectations.
            </p>
            <a href="#">Learn More</a>
          </div>
        </div>
        <div class="cards">
          <div class="card">
            <img
              class="card-img"
              src="images/chair.jpg"
              alt="Party Decorations"
            />
            <h3>Package 5</h3>
            <p>
              Our starter package offers everything you need to kickstart your
              event planning journey. From essential furniture to basic
              lighting, it provides the foundational elements for a comfortable
              and memorable occasion.
            </p>
            <a href="#">Learn More</a>
          </div>
          <div class="card">
            <img
              class="card-img"
              src="images/table.jpg"
              alt="Party Decorations"
            />
            <h3>Package 6</h3>
            <p>
              Elevate your event with our intermediate package, which includes
              upgraded furniture, stylish décor accents, and enhanced lighting
              options. Perfect for those seeking a touch of sophistication
              without breaking the budget.
            </p>
            <a href="#">Learn More</a>
          </div>
          <div class="card">
            <img
              class="card-img"
              src="images/chair.jpg"
              alt="Party Decorations"
            />
            <h3>Package 7</h3>
            <p>
              Make a statement with our premium package, featuring luxury
              furniture, stunning lighting effects, and exquisite décor details.
              Designed for those who desire an unforgettable event experience
              with all the bells and whistles.
            </p>
            <a href="#">Learn More</a>
          </div>
          <div class="card">
            <img
              class="card-img"
              src="images/table.jpg"
              alt="Party Decorations"
            />
            <h3>Package 8</h3>
            <p>
              Go all out with our deluxe package, offering top-of-the-line
              amenities, personalized décor options, and unparalleled service.
              Tailored to meet the highest standards of luxury and extravagance,
              it promises an event that exceeds expectations.
            </p>
            <a href="#">Learn More</a>
          </div>
          <!-- <div class="buttons">
            <a href="#">Shop Now</a>
            <a href="#">Learn More</a>
          </div> -->
        </div>
      </div>
    </main>
    <?php require'./components/footer.php';?>
  </body>
</html>
