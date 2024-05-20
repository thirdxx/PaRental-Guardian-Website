<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Packages</title>
    <link rel="stylesheet" href="../css/homepage.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
  </head>
  <body>
  <?php require'../components/header.php';?>
    <main>
      <div class="search-container">
        <div class="search-bar">
         
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
              src="../images/package/birthday.jpg"
              alt="Party Decorations"
            />
            <h3>Birthday</h3>
            <p>
              Our starter package offers everything you need to kickstart your
              event planning journey. From essential furniture to basic
              lighting, it provides the foundational elements for a comfortable
              and memorable occasion.
            </p>
            <a href="../login/package_details.php?id=85">Learn More</a>
          </div>
          <div class="card">
            <img
              class="card-img"
              src="../images/package/corporatee.jpg"
              alt="Party Decorations"
            />
            <h3>Corporate</h3>
            <p>
              Elevate your event with our intermediate package, which includes
              upgraded furniture, stylish décor accents, and enhanced lighting
              options. Perfect for those seeking a touch of sophistication
              without breaking the budget.
            </p>
            <a href="../login/package_details.php?id=86">Learn More</a>
          </div>
          <div class="card">
            <img
              class="card-img"
              src="../images/package/fiesta.jpg"
              alt="Party Decorations"
            />
            <h3>Fiesta</h3>
            <p>
              Make a statement with our premium package, featuring luxury
              furniture, stunning lighting effects, and exquisite décor details.
              Designed for those who desire an unforgettable event experience
              with all the bells and whistles.
            </p>
            <a href="../login/package_details.php?id=87">Learn More</a>
          </div>
          <div class="card">
            <img
              class="card-img"
              src="../images/package/wedding.png"
              alt="Party Decorations"
            />
            <h3>Wedding</h3>
            <p>
              Go all out with our deluxe package, offering top-of-the-line
              amenities, personalized décor options, and unparalleled service.
              Tailored to meet the highest standards of luxury and extravagance,
              it promises an event that exceeds expectations.
            </p>
            <a href="../login/package_details.php?id=88">Learn More</a>
          </div>
        </div>
        
          <!-- <div class="buttons">
            <a href="#">Shop Now</a>
            <a href="#">Learn More</a>
          </div> -->
        </div>
      </div>
    </main>
    <?php require'../components/footer.php';?>
  </body>
</html>
