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
    <title>Cart</title>
    <link rel="stylesheet" href="../css/cart.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
  </head>
  <body>
  <?php require'../components/header1.php';?>
    <main>
        <script src="../js/quantity.js"></script>
</div>

      <!-- <div class="container"> -->
        <div class="banner">
          <h2>Cart Summary</h2>
          </div>
  </div>
</div>
  <div class="card-container">
  <!-- First Card - Products -->
  <div class="cardproduct">
    <!-- Table Container -->
    <div class="table-container">
    <form method="post" action="../login/checkout.php">
    <input type="hidden" name="action" value="update_cart">
      <table>
        <!-- Table Header -->
        <thead>
          <tr>
            <th></th>
            <th>Product</th>
            <th></th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php
        // Fetch cart items for the current user from the database
        $user_id = $_SESSION['id']; // Assuming you have user ID stored in session
        $query = "SELECT cart.*, products.name AS product_name, products.image AS product_image, products.color AS product_color, products.price AS product_price, cart.start_date AS start_date, cart.end_date AS end_date FROM cart 
                  INNER JOIN products ON cart.product_id = products.id
                  WHERE cart.user_id = $user_id";
        $result = mysqli_query($conn, $query);

        // Check if there are any items in the cart
        if (mysqli_num_rows($result) > 0) {
            // Loop through each cart item and generate HTML rows dynamically
            while ($row = mysqli_fetch_assoc($result)) {
                // Calculate the number of day
                $start_date = new DateTime($row['start_date']);
                $end_date = new DateTime($row['end_date']);
                $interval = $start_date->diff($end_date);
                $day = ceil($interval->days);
                // $total = $row['product_price'] * $row['quantity'] * $day;
                echo '<input class="product-price" type="hidden" name="cart[' . $row['id'] . '][product_price]" value="' . $row['product_price'] . '">';
                echo '<input class="newsubtotal" type="hidden" name="cart[' . $row['id'] . '][day]" value="' . $day . '">';

                echo '<tr>';
                echo '<td><input type="checkbox" name="checked_cart[]" value="' . $row['id'] . '" onclick="checkboxupdateTotal(this)"></td>';
                echo '<td><img src="../images/products/' . $row['product_image'] . '" alt="' . $row['product_name'] . '"></td>'; // Fetching the image URL from the database
                echo '<td class="product-details">' . $row['product_name'] . '<br>From: ' . $row['start_date'] . '—To: ' . $row['end_date'] . ' <br>Color: ' . $row['product_color'] . '</td>'; // Fetching the product name from the database
                echo '<td class="product-price">₱' . $row['product_price'] . ' x <br>' . $day . ' Day/s</td>'; // Fetching price and the number of day
                echo '<td>';
                echo '<div class="quantity">';
                echo '<button type="button" class="minus" onclick="decrementQuantity(this.parentNode.querySelector(\'.textarea\'))">-</button>';
                echo '<input class="textarea quantity-input" name="cart[' . $row['id'] . '][quantity]" type="number" value="' . $row['quantity'] . '" min="1">'; // Fetching quantity from the database
                echo '<button type="button" class="plus" onclick="incrementQuantity(this.parentNode.querySelector(\'.textarea\'))">+</button>';
                echo '</div>';
                echo '</td>';
                echo '<td class="subtotal" name="cart[' . $row['id'] . '][subtotal]">₱' . $row['subtotal'] . '</td>';
                echo '<td class="day" style="display: none;">' . $day . '</td>'; // Hidden field for day 
                echo '<td><button type="button" class="delete-button" data-id="' . $row['id'] . '"><i class="fas fa-trash"></i></button></td>';
                echo '</tr>';                
            }
        
        } else {
            // If cart is empty, display a message
            echo '<tr><td colspan="2"><td colspan="2"></td><td>Your cart is empty</td><td colspan="2"></td></tr>';
        }
        $conn->close();
        ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Second Card - Subtotal, Total, and Checkout Button -->
  <div class="cardproduct2">
    <!-- Table Container -->
    <div class="table-container">
      <table>
        <!-- Table Body -->
        <tbody>
          <!-- Subtotal Row -->
          <tr>
            <h2>Summary</h2>
            <td>Cart Total</td>
            <td class="subtotalvalue"></td>
          </tr>
          <!-- Total Row -->
          <tr>
            <td><h3>Total</h3></td>
            <td class="total"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <button type="submit" class="checkout-btn">Checkout</button>
    
</form>
  </div>
</div>


      </div>
    </main>
    <?php require'../components/footer.php';?>
    <script>
      function incrementQuantity(inputElement) {
          var currentValue = parseInt(inputElement.value);
          inputElement.value = currentValue + 1;
          updateSubtotal(inputElement);
          updateTotal(inputElement);
      }

      function decrementQuantity(inputElement) {
        
          var currentValue = parseInt(inputElement.value);
          if (currentValue > 1) {
              inputElement.value = currentValue - 1;
              updateSubtotal(inputElement);
              updateTotal(inputElement);
          }
      }

      function updateSubtotal(inputElement) {
          var row = inputElement.closest('tr');
          var quantity = parseInt(inputElement.value);
          var pricePerWeek = parseFloat(row.querySelector('.product-price').innerText.replace('₱', '').replace(',', ''));
          var day = parseInt(row.querySelector('.day').innerText);
          var subtotalElement = row.closest('tr').querySelector('.subtotal');
          var currentsubtotal = parseFloat(subtotalElement.innerText.replace('₱', '').replace(',', ''));
          var subtotalvalueElement = document.querySelector('.subtotalvalue');

          var subtotal = quantity * pricePerWeek * day;
          row.querySelector('.subtotal').innerText = '₱' + subtotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

          var checkbox = inputElement.closest('tr').querySelector('input[type="checkbox"]');
          if (checkbox.checked) {
            var totalElement = document.querySelector('.total');
            var currentTotal = parseFloat(totalElement.innerText.replace('₱', '').replace(',', '')) || 0;
            var newTotal = currentTotal - currentsubtotal +subtotal;
            var formattedTotal = '₱' + newTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            totalElement.innerText = formattedTotal;
            subtotalvalueElement.innerText = formattedTotal;
            newTotal = 0;
          }
      }

      function updateTotal(inputElement) {
          var checkbox = inputElement.closest('tr').querySelector('input[type="checkbox"]');
          var subtotalvalueElement = document.querySelector('.subtotalvalue');
          if (checkbox.checked) {
              var row = inputElement.closest('tr');
              var subtotal = parseFloat(row.querySelector('.subtotal').innerText.replace('₱', '').replace(',', ''));
              var totalElement = row.closest('.cardproduct2').querySelector('.total');
              var currentTotal = parseFloat(totalElement.innerText.replace('₱', '').replace(',', '')) || 0;
              var newTotal = currentTotal - subtotal;

              var formattedTotal = '₱' + (newTotal + subtotal).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
              totalElement.innerText = formattedTotal;
              subtotalvalueElement.innerText = formattedTotal;
          }
      }
      
      function checkboxupdateTotal(checkbox) {
        var subtotalElement = checkbox.closest('tr').querySelector('.subtotal');
        var subtotal = parseFloat(subtotalElement.innerText.replace('₱', '').replace(',', ''));
        var totalElement = document.querySelector('.total');
        var currentTotal = parseFloat(totalElement.innerText.replace('₱', '').replace(',', '')) || 0;
        var subtotalvalueElement = document.querySelector('.subtotalvalue');

        if (checkbox.checked) {
            currentTotal += subtotal;
        } else {
            currentTotal -= subtotal;
        }

        currentTotal = Math.max(currentTotal, 0);

        var formattedTotal = '₱' + currentTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        totalElement.innerText = formattedTotal;
        subtotalvalueElement.innerText = formattedTotal;
        currentTotal = 0;
      }

      // JavaScript code to handle delete button click
      document.addEventListener('DOMContentLoaded', function() {
          var deleteButtons = document.querySelectorAll('.delete-button');

          deleteButtons.forEach(function(button) {
              button.addEventListener('click', function() {
                  var id = this.getAttribute('data-id');
                  var confirmation = confirm("Are you sure you want to delete this item from your cart?");
                  
                  if (confirmation) {
                      // Send AJAX request to delete.php
                      var xhr = new XMLHttpRequest();
                      xhr.open('POST', '../components/delete_cart.php', true);
                      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                      xhr.onload = function() {
                          if (xhr.status == 200) {
                              // Refresh the page or update the cart content
                              location.reload(); // Reload the page after successful deletion
                          } else {
                              alert('Error: ' + xhr.statusText);
                          }
                      };
                      xhr.send('id=' + id);
                  }
              });
          });
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