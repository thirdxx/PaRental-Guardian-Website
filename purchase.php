<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>renta.com/purchase</title>
    <link rel="stylesheet" href="css/purchase.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
  </head>
  <body>
    <header>
      <div class="logo">
        <span>renta.com</span>
      </div>
       <nav>
        <ul>
          <li><a href="homepage.html">Home</a></li>
    <li class="dropdown">
      <a href="product_categories.html">Products</a>
      <div class="dropdown-content">
        <div class="column">
          <a href="products/chairs.html"><i class="fas fa-chair" style="margin-right: 5px"></i> Chairs </a>
          <a href="products/tables.html"><i class="fas fa-square" style="margin-right: 5px"></i> Tables </a>
            <a href="products/serving.html"><i class="fas fa-circle" style="margin-right: 5px"></i> Serving </a>
        </div>
        <div class="column">
            <a href="products/glassware.html"><i class="fas fa-wine-glass" style="margin-right: 5px"></i> Glassware </a>
           <a href="products/flatware.html"><i class="fas fa-utensils" style="margin-right: 5px"></i> Flatware </a>
           <a href="products/linens.html"><i class="fas fa-sticky-note" style="margin-right: 5px"></i> Linens </a>
        </div>
        <div class="column">
          <a href="products/tent.html"><i class="fas fa-campground" style="margin-right: 5px"></i> Tent </a>
          <a href="products/lighting.html"><i class="fas fa-regular fa-lightbulb" style="margin-right: 5px"></i> Lighting </a>
        </div>
      </div>
    </li>
    <li class="dropdown">
      <a href="packages.html">Packages</a>
      <div class="dropdown-content">
        <div class="column">
          <a href="/packages/package1.html"><i class="fas fa-solid fa-box-open" style="margin-right: 5px"></i> Package 1 </a>
          <a href="#"><i class="fas fa-solid fa-box-open" style="margin-right: 5px"></i> Package 2 </a>
          <a href="#"><i class="fas fa-solid fa-box-open" style="margin-right: 5px"></i> Package 3 </a>
        </div>
        <div class="column">
            <a href="#"><i class="fas fa-solid fa-box-open" style="margin-right: 5px"></i> Package 4 </a>
           <a href="#"><i class="fas fa-solid fa-box-open" style="margin-right: 5px"></i> Package 5 </a>
           <a href="#"><i class="fas fa-solid fa-box-open" style="margin-right: 5px"></i> Package 6 </a>
        </div>
        <div class="column">
          <a href="#"><i class="fas fa-solid fa-box-open" style="margin-right: 5px"></i>Package 7 </a>
          <a href="#"><i class="fas fa-solid fa-box-open" style="margin-right: 5px"></i>Package 8 </a>
        </div>
      </div>
    </li>
    <li><a href="about.html">About</a></li>
    <li><a href="contact.html">Contact</a></li>
        </ul>
      </nav>
      </div>
      <div>
        <a href="/cart.html" class="cart-button">
  <i class="fas fa-shopping-cart"></i>
    </a>
        <a href="#" class="login-link">Sign in</a>
      </div>
  
    </header>

    <main>
        <!-- <div class="container"> -->
        <div class="banner"><br>
          <h2>My Purchase</h2>
          </div>
         <div class="container">
 <div class="userprofile">
  <div class="avatar">
    <label for="avatar-upload">
      <img src="/images/diogenes.png" alt="Avatar" id="avatar-image" />
    </label>
    <input type="file" id="avatar-upload" accept="image/*" style="display: none;" />
  </div>
  <!-- <label for="avatar-upload" class="upload-button">Upload Image</label> -->
</br><br><br><br><br>
  <label class="avatarname">Diogenes Tayam</label>
  <br>
  <a class="accountbutton" href="user_profile.php"><i class="fas fa-solid fa-user" ></i> My Account</a><br><br>
 <a class="purchasebutton" href="purchase.php"><i class="fas fa-solid fas fa-clipboard-list"></i> My Purchase</a>
</div>


      <div class="contact-form">      
        <table>
        <thead>
          <tr>
            <th>Product</th>
            <th></th>
            <th></th>
            <th>Price</th>
            <th>Subtotal</th>
            <th>Action</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><img src="/images/chair.jpg" alt="Product 1"></td> 
            <td>Stemless Champagne Glass 8.5 oz.</td> 
            <td>x1</td>
            <td> ₱150.00</td> 
            <td>₱150.00</td>
            <td>Completed</td>
            <td><a class="againbutton">Rent Again</a></td>
          </tr>
          <tr>
    </a></td>
            <td><img src="/images/table.jpg" alt="Product 2"></td> 
            <td>Cubist Square Glassware</td> 
            <td>x1</td>
            <td>₱100.00</td> 
            <td>₱100.00</td> 
            <td>Completed</td>
            <td><a class="againbutton">Rent Again</a><br></td>
            
          </tr>
          <tr>
    </a></td> 
            <td><img src="/images/chair.jpg" alt="Product 1"></td> 
            <td>Stemless Champagne Glass 8.5 oz.</td> 
            <td>x1</td>
            <td> ₱150.00</td> 
            <td> ₱150.00</td> 
            <td>Completed</td>
            <td><a class="againbutton">Rent Again</a></td>
          </tr>
          </a></td> </td> 
            <td></td> 
            <td</td>
            <td></td> 
            <td> </td> 
            <td class="total"> Total: </td> 
            <td>₱400.00</td>
            <td></td>
            <td><button class="modal-button-confirm" onclick="downloadPDF()">Print Invoice</button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
    </main>
    <footer>
      <div class="container">
        <div class="contact-info">
  <div class="column">
    <h2 class="contact">Contact</h2>
    <p>Barangay 1, Em’s Barrio, Legazpi City, Albay, Philippines, 4500</p>
    <p>parentalguardians@gmail.com</p>
    <p>+639273298367</p>
     <a href="facebook.com" class="social-icon"><i class="fab fa-facebook-f"></i></a>
  <a href="instagram.com" class="social-icon"><i class="fab fa-instagram"></i></a>
  <a href="pinterest.com" class="social-icon"><i class="fab fa-pinterest"></i></a>
  </div>
  <div class="column">
    <h2 class="business-hours">Business Hours</h2>
    <p class="business-hours">Monday-Friday: 9:00 AM - 5:00 PM</p>
<p class="business-hours">Saturday: 1:00 PM - 5:00 PM</p>
<p class="business-hours">Sunday: Closed</p>
 <p class="copyright">&copy; 2024 PaRental Guardians. All Rights Reserved.</p>
  </div>
  <div class="column">
    <h2 class="links">Links</h2>
    <p class="links" href="#">Home</p>
    <p class="links" href="#">Products</p>
    <p class="links" href="#">Pacakges</p>
    <p class="links" href="#">About</p>
    <p class="links" href="#">Contact</p>
  </div>
</div>
<div class="banner-footer">
  <!-- <a href="facebook.com" class="social-icon"><i class="fab fa-facebook-f"></i></a>
  <a href="instagram.com" class="social-icon"><i class="fab fa-instagram"></i></a>
  <a href="pinterest.com" class="social-icon"><i class="fab fa-pinterest"></i></a> -->
  </div>
  </div>
    </footer>
    <script>
        function downloadPDF() {
  var pdfUrl = 'receipt.pdf';
  var anchor = document.createElement('a');

  anchor.href = pdfUrl;
  
  anchor.download = 'official_receipt.pdf';
  
  anchor.click();
}
    </script>
  </body>
</html>
