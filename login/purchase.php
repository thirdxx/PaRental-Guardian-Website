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
      $picture = $row['image'];
  }

  // Fetch order items for the user
  $orderItemsQuery = "
    SELECT 
      orders.id AS order_id,
      orders.date AS order_date,
      products.image AS product_image,
      products.name AS product_name,
      products.price AS product_price,
      order_item.quantity AS order_quantity,
      order_item.start_date AS start_date,
      order_item.end_date AS end_date,
      order_item.status AS order_status,
      (DATEDIFF(order_item.end_date, order_item.start_date)) * products.price * order_item.quantity AS subtotal
    FROM 
      orders 
    JOIN 
      order_item ON orders.id = order_item.order_id
    JOIN 
      products ON order_item.product_id = products.id
    WHERE 
      orders.user_id = $userId
    ORDER BY 
      orders.id ASC
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
                  <img src="../images/users/<?php echo $picture; ?>" alt="Avatar" id="avatar-image" />
                </label>
                <input type="file" id="avatar-upload" accept="image/*" style="display: none;" />
            </div>
            <br><br><br><br><br>
            <label class="avatarname"><?php echo $fullName; ?></label>
            <br>
            <a class="accountbutton" href="user_profile.php"><i class="fas fa-solid fa-user" ></i> My Account</a><br><br>
            <a class="purchasebutton" href="purchase.php"><i class="fas fa-solid fas fa-clipboard-list"></i> My Purchase</a><br><br>
             <a class="accountbutton" href="reviews.php"><i class="fas fa-regular fa-star"></i> My Reviews</a><br><br><br><br><br><br><br><br><br><br>
            <a class="logoutbutton" href="../index.php"><i class="fas fa-solid fas fa-clipboard-list"></i> Logout</a>
          </div>

          <div class="contact-form scrollable-table">      
            <table>
            <thead>
              <tr>
                <th>Product</th>
                <th></th>
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
              $currentOrderId = null;
              if ($orderItemsResult && mysqli_num_rows($orderItemsResult) > 0) {
                  while ($itemRow = mysqli_fetch_assoc($orderItemsResult)) {
                      if ($itemRow['order_status'] == 'Pending' || $itemRow['order_status'] == 'Processing') {
                          if ($currentOrderId != $itemRow['order_id']) {
                              if ($currentOrderId !== null) {
                                
                                  $laborFee = $total * 0.12;
                                  $overall_total = $total + $laborFee;
                                  echo "
                                  <tr>
                                    <td colspan='3'></td>
                                    <td colspan='1'></td>
                                    <td ><strong>Cart Total:</strong></td>
                                    <td>₱" . number_format($total, 2) . "</td>
                                    <td></td>
                                  </tr>";
                                  echo "
                                  <tr>
                                    <td colspan='3'></td>
                                    <td colspan='1'></td>
                                    <td ><strong>Labor Fee:</strong></td>
                                    <td>₱" . number_format($laborFee, 2) . "</td>
                                    <td></td>
                                  </tr>";
                                  echo "
                                  <tr style='background-color: #f3ffe3;'>
                                    <td colspan='3'><strong>Order Date: " . $orderDate . "</strong></td>
                                    <td colspan='1'></td>
                                    <td class='total'>Total:</td>
                                    <td>₱" . number_format($overall_total, 2) . "</td>
                                    <td><button class='modal-button-confirm' onclick='downloadPDF()'>Print Invoice</button></td>
                                  </tr>";
                                  $total = 0; // Reset total for the next order
                              }
                              $currentOrderId = $itemRow['order_id'];
                              $orderDate = $itemRow['order_date'];
                          }
                          $total += $itemRow['subtotal'];
                          
              ?>
              <tr>
                <td><img src="../images/products/<?php echo $itemRow['product_image']; ?>" alt="Product Image"></td>
                <td><?php echo $itemRow['product_name']; ?></td>
                <td>x<?php echo $itemRow['order_quantity']; ?></td>
                <td>₱<?php echo number_format($itemRow['product_price'], 2); ?></td>
                <td>₱<?php echo number_format($itemRow['subtotal'], 2); ?></td>
                <td><?php echo $itemRow['order_status']; ?></td>
                <td>
                <?php 
                if ($itemRow['order_status'] == "Returned") {
                    echo "<a class='againbutton'  href='rate.php?product=" . urlencode($itemRow['product_name']) . "&name=" . urlencode($fullName) . "&email=" . urlencode($row['email']) . "'>Rate</a>";
                } else {
                    
                }
                ?>
                </td>
              </tr>
              <?php
                      }
                  }
                  // Close the last order total row
                  $laborFee = $total * 0.12;
                  $overall_total = $total + $laborFee;
                  echo "
                  <tr>
                    <td colspan='3'></td>
                    <td colspan='1'></td>
                    <td ><strong>Cart Total:</strong></td>
                    <td>₱" . number_format($total, 2) . "</td>
                    <td></td>
                  </tr>";
                  echo "
                  <tr>
                    <td colspan='3'></td>
                    <td colspan='1'></td>
                    <td ><strong>Labor Fee:</strong></td>
                    <td>₱" . number_format($laborFee, 2) . "</td>
                    <td></td>
                  </tr>";
                  echo "
                  <tr style='background-color: #f3ffe3;'>
                    <td colspan='3'><strong>Order Date: " . $orderDate . "</strong></td>
                    <td colspan='1'></td>
                    <td class='total'>Total:</td>
                    <td>₱" . number_format($overall_total, 2) . "</td>
                    <td><button class='modal-button-confirm' onclick='downloadPDF()'>Print Invoice</button></td>
                  </tr>";
                  $total = 0; // Reset total for the next order
              } else {
                  echo "<tr><td colspan='7'>No orders found</td></tr>";
              }
              ?>
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
    <?php require '../components/footer.php'; ?>
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
