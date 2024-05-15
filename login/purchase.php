<?php  
session_start();
include "../components/db_connect.php";
date_default_timezone_set("Asia/Manila");

if (isset($_SESSION['id'])) {

  $userId = $_SESSION['id'];
  $query = "SELECT * FROM users WHERE id = $userId";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $fullName = $row['full_name'];
      $nameParts = explode(" ", $fullName);
      $firstName = $nameParts[0];
      $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
      $phone = $row['phone_number'];
      $email = $row['email'];
      $picture = $row['image'];
      $username = $row['username'];
      $address = $row['address'];
  }

  // Fetch order items for the user
  $orderItemsQuery = "
    SELECT 
      products.image AS product_image,
      products.name AS product_name,
      products.price AS product_price,
      order_item.quantity AS order_quantity,
      order_item.start_date AS start_date,
      order_item.end_date AS end_date,
      order_item.status AS order_status,
      (DATEDIFF(order_item.end_date, order_item.start_date) + 1) * products.price * order_item.quantity AS subtotal
    FROM 
      orders 
    JOIN 
      order_item ON orders.id = order_item.order_id
    JOIN 
      products ON order_item.product_id = products.id
    WHERE 
      orders.user_id = $userId
  ";

  $orderItemsResult = mysqli_query($conn, $orderItemsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Purchase</title>
    <link rel="stylesheet" href="../css/purchase.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <style>
        .scrollable-table {
            max-height: 600px; /* Set maximum height */
            overflow-y: auto; /* Enable vertical scrolling */
        }
    </style>
</head>
<body>
  <?php require '../components/header1.php'; ?>
    <main>
        <div class="banner"><br>
          <h2>My Purchase</h2>
        </div>
        <div class="container">
          <div class="userprofile">
            <div class="avatar">
                <label for="avatar-upload">
                  <img src="../images/<?php echo $picture; ?>" alt="Avatar" id="avatar-image" />
                </label>
                <input type="file" id="avatar-upload" accept="image/*" style="display: none;" />
            </div>
            <br><br><br><br><br>
            <label class="avatarname"><?php echo $fullName; ?></label>
            <br>
            <a class="accountbutton" href="user_profile.php"><i class="fas fa-solid fa-user" ></i> My Account</a><br><br>
            <a class="purchasebutton" href="purchase.php"><i class="fas fa-solid fas fa-clipboard-list"></i> My Purchase</a><br><br><br><br><br><br><br><br><br><br><br><br>
            <a class="logoutbutton" href="../index.php"><i class="fas fa-solid fas fa-clipboard-list"></i> Logout</a>
          </div>

          <div class="contact-form scrollable-table">      
            <table>
            <thead>
              <tr>
                <th>Product</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $total = 0;
              if ($orderItemsResult && mysqli_num_rows($orderItemsResult) > 0) {
                  while ($itemRow = mysqli_fetch_assoc($orderItemsResult)) {
                      $total += $itemRow['subtotal'];
              ?>
              <tr>
                <td><img src="../images/products/<?php echo $itemRow['product_image']; ?>" alt="Product Image"></td>
                <td><?php echo $itemRow['product_name']; ?></td>
                <td>x<?php echo $itemRow['order_quantity']; ?></td>
                <td>₱<?php echo number_format($itemRow['product_price'], 2); ?></td>
                <td>₱<?php echo number_format($itemRow['subtotal'], 2); ?></td>
                <td><?php echo $itemRow['order_status']; ?></td>
                <td><a class="againbutton">Rent Again</a></td>
              </tr>
              <?php
                  }
              } else {
                  echo "<tr><td colspan='7'>No orders found</td></tr>";
              }
              ?>
              <tr>
                <td colspan="4"></td>
                <td class="total">Total:</td>
                <td>₱<?php echo number_format($total, 2); ?></td>
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
            <p class="links" href="#">Packages</p>
            <p class="links" href="#">About</p>
            <p class="links" href="#">Contact</p>
          </div>
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
<?php 
}else{
  header("Location: ../login/signin.php?error=You need to login first");
  exit();
}
?>
