<?php  
session_start();
include "../components/db_connect.php";
date_default_timezone_set("Asia/Manila");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checked_cart'])) {
  $checked_carts = $_POST['checked_cart'];
  // Loop through each checked cart item
  foreach ($checked_carts as $cart_id) {
      // Check if the cart item exists in the database
      $cart_id = intval($cart_id);
      $quantity = intval($_POST['cart'][$cart_id]['quantity']);
      $subtotal = $_POST['cart'][$cart_id]['product_price'] * $quantity * $_POST['cart'][$cart_id]['weeks'];

      // Prepare and execute the update query
      $update_query = "UPDATE cart SET quantity = ?, subtotal = ? WHERE id = ?";
      $stmt = $conn->prepare($update_query);
      $stmt->bind_param("idi", $quantity, $subtotal, $cart_id);
      $stmt->execute();
  }

} else {
  // If the form is not submitted or no cart items are checked, redirect to the appropriate page
  header("Location: ../login/cart.php");
  exit();
}

if (isset($_SESSION['id'])) {
  // Fetch user information based on session id
  $userId = $_SESSION['id'];
  $query = "SELECT * FROM users WHERE id = $userId";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $fullName = $row['full_name'];
      // Split full name into first name and last name
      $nameParts = explode(" ", $fullName);
      $firstName = $nameParts[0];
      $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
      $phone = $row['phone_number'];
      $email = $row['email'];

      // Now you have $firstName and $lastName to display in your HTML
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>renta.com/checkout</title>
    <link rel="stylesheet" href="../css/checkout.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <?php require'../components/header1.php';?>
    <main>
        <div class="banner">
          <h2>Checkout</h2>
          </div>
  </div>
</div>
  <div class="card-container">
  <div class="cardcheckout">
    <h2>Billing Details</h2>
    <form method="post" action="../components/checkout.php">
        <div class="heading-textarea">
            <h5 required>First Name<span class="required"></span></h5>
            <textarea name="firstname" required><?php echo $firstName; ?></textarea>
        </div>
        <div class="heading-textarea">
            <h5>Last Name<span class="required"></span></h5>
            <textarea name="lastname" required><?php echo $lastName; ?></textarea>
        </div>
      
       <h5>Town/City<span class="required"></span></h5>
      <textarea name="city" class="custom-width-textarea" required></textarea><br>
       <h5><span class="required">Barangay</span></h5>
      <textarea name="barangay" class="custom-width-textarea" required></textarea><br>
       <h5>House Number/Street Name/Zone</h5>
      <textarea name="apartment"  class="custom-width-textarea"></textarea><br>
       <h5>Zip Code <span class="required"></span></h5>
      <textarea name="zipcode" class="custom-width-textarea" required></textarea><br>
       <h5>Phone<span class="required"></span></h5>
      <textarea name="phone" class="custom-width-textarea" required><?php echo $phone; ?></textarea><br>
       <h5>Email Address<span class="required"></span></h5>
      <textarea name="email" class="custom-width-textarea" required><?php echo $email; ?></textarea><br>
       <h5>Notes (optional)</h5>
      <textarea name="note" class="custom-width-notes"></textarea><br>
       <h3>Rental Dates</h3>
      <div class="date-inputs-container">
  <div class="heading-textarea">
    <h4>Rental Start Date (optional)<span ></span></h4>
    <input type="date" id="rent-from" name="rent-from" onchange="calculateDate(); disablePastDates()">
  </div>
  <div class="heading-textarea">
    <h4>Rental End Date (optional)<span ></span></h4>
    <input type="date" id="rent-to" name="rent-to" onchange="calculateDate()">
  </div>
</div>
 
  </div>

  <div class="cardcheckout2">
    <h2>Your Order</h2>
    <table>
      <thead>
        <tr>
          <th>Product</th>
          <th>Weeks</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
          <?php
          // Fetch checked cart items
          if (isset($_POST['checked_cart'])) {
            $checked_carts = $_POST['checked_cart'];
            $total = 0;
            $fee = 0;
            
            foreach ($checked_carts as $cart_id) {
              $cart_id = intval($cart_id);
              // Modify the query to fetch product name from products table
              $query = "SELECT cart.id, cart.quantity, cart.subtotal, products.name, products.price, cart.start_date, cart.end_date 
                        FROM cart 
                        INNER JOIN products ON cart.product_id = products.id 
                        WHERE cart.id = $cart_id";
          
              $result = mysqli_query($conn, $query);
              if ($result && mysqli_num_rows($result) > 0) {
                  $row = mysqli_fetch_assoc($result);
                  $c_id = $row['id'];
                  $product_price = $row['price'];
                  $product_name = $row['name'];
                  $quantity = $row['quantity'];
                  $subtotal = $row['subtotal'];
                  $total += $subtotal;
                  $start_date = new DateTime($row['start_date']);
                  $end_date = new DateTime($row['end_date']);
                  $interval = $start_date->diff($end_date);
                  $weeks = ceil($interval->days / 7);
                  echo '<tr>';
                  echo '<td>' . $product_name . ' <span class="product-price" data-price="' . $product_price . '" ></span> [ ' . $product_price . ' ] <span class="quantity"> x ' . $quantity . ' </span></td>';
                  echo '<td><span class="weeks" id="weeks">' . $weeks . ' Week/s</span></td>';
                  echo '<td><span id="total-price">₱ ' . number_format($subtotal, 2) . '</td>';
                  echo '</tr>';
                  echo '<input type="hidden" name="checked_cart[]" value="' . $cart_id . '">';
                  echo '<input class="new_weeks" type="hidden" id="new_weeks" name="cart[' . $cart_id . '][weeks]" >';
              }
          }          
              // Display total
              echo '<tr>';
              echo '<td class="subtotal">Cart Total</td>';
              echo '<td></td>';
              echo '<td><span id="semi-total">₱ ' . number_format($total, 2) . '</td>';
              echo '</tr>';
              echo '<tr>';
              $fee = $total * 0.12;
              echo '<tr>';
              echo '<td class="subtotal">Labor Fee 12%</td>';
              echo '<td></td>';
              echo '<td><span id="labor-fee">₱ ' . number_format($fee, 2) . '</td>';
              echo '</tr>';
              echo '<tr>';
              $total = $total + $fee;
              echo '<td class="subtotal">Total</td>';
              echo '<td></td>';
              echo '<td><span id="overall-total">₱ ' . number_format($total, 2) . '</td>';
              echo '<input type="hidden" name="totalprice" value="' . number_format($total, 2) . '">';
              echo '</tr>';
          } else {
              echo '<tr><td colspan="2">No items selected</td></tr>';
          }
          ?>
      </tbody>
    </table>
    <div class="payment-method">
      <h3>Payment Method</h3>
<div class="payment-methods-container" required>
  <label><input type="radio" name="payment_method" value="Credit Card"> Credit Card</label>
  <label><input type="radio" name="payment_method" value="Paypal"> PayPal</label>
  <label><input type="radio" name="payment_method" value="GCash"> GCash</label>
  <label><input type="radio" name="payment_method" value="Bank Transfer"> Bank Transfer</label>
  <label><input type="radio" name="payment_method" value="Cash On Delivery"> Cash on Delivery</label>
</div>
 <button type="button" class="checkout-btn" onclick="showConfirmationModal()">Place order</button>

<div id="confirmationModal" class="modal">
  <div class="modal-content">
    <h2>Confirmation</h2>
    <p>Are you sure you want to place the order?</p>
    <button type="button" class="modal-button"onclick="closeConfirmationModal()">Cancel</button>
    <button  type="button" class="modal-button-confirm"onclick="showOrderConfirmedModal()">Confirm</button>
  </div>
</div>

<div id="orderConfirmedModal" class="modal">
  <div class="modal-content">
    <h2>Order Confirmed</h2>
    <p>Your order has been successfully confirmed.</p>
    <button type="submit" class="modal-button-confirm" onclick="closeOrderConfirmedModal()">Close</button>
  </div>
</div>
</form>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        disablePastDates();
      });
    function showConfirmationModal() {
      document.getElementById('confirmationModal').style.display = 'block';
    }

    function closeConfirmationModal() {
      document.getElementById('confirmationModal').style.display = 'none';
    }

    function showOrderConfirmedModal() {
      closeConfirmationModal(); 
      document.getElementById('orderConfirmedModal').style.display = 'block'; 
    }

    function closeOrderConfirmedModal() {
      document.getElementById('orderConfirmedModal').style.display = 'none';
    }
    function calculateDate() {
      var rentFrom = new Date(document.getElementById("rent-from").value);
      var rentTo = new Date(document.getElementById("rent-to").value);
      var days = Math.ceil((rentTo - rentFrom) / (1000 * 60 * 60 * 24));
      var basePriceElements = document.querySelectorAll('.product-price');
      var newWeeksInputs = document.querySelectorAll('.new_weeks');
      var quantityElements = document.querySelectorAll('.quantity');
      var subtotalElements = document.querySelectorAll('#total-price');
      var total = 0; // Initialize total variable
      var fee = 0;

      basePriceElements.forEach(function(basePriceElement, index) {
          var weeks = 0;
          var basePrice = parseFloat(basePriceElement.getAttribute('data-price'));
          weeks = Math.ceil(days / 7); // Calculate number of weeks
          var quantity = parseInt(quantityElements[index].innerText.split('x')[1].trim());
          var subtotal = basePrice * quantity * weeks;

          

          // Update total
          total += subtotal;

          if (!isNaN(weeks)) {
              // Set weeks text for display
              var weeksText = "" + weeks + " Week/s";
              var weeksElements = document.querySelectorAll('.weeks');
              weeksElements[index].innerText = weeksText;

              // Update subtotal for display
              subtotalElements[index].innerText = '₱' + subtotal.toFixed(2);

              // Set weeks value for form submission
              newWeeksInputs[index].value = weeks;
          }
      });

      // Update overall total display
      document.getElementById('semi-total').innerText = '₱ ' + total.toFixed(2);
      fee = total * 0.12; 
      document.getElementById('labor-fee').innerText = '₱ ' + fee.toFixed(2);
      total = total + fee;
      document.getElementById('overall-total').innerText = '₱ ' + total.toFixed(2);
      document.querySelector('input[name="totalprice"]').value = total.toFixed(2);
    }


  function disablePastDates() {
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('rent-from').setAttribute('min', today);
    document.getElementById('rent-to').setAttribute('min', today);
    
    var rentFromDate = document.getElementById('rent-from').value;
    var rentToDateInput = document.getElementById('rent-to');
    var rentToDate = new Date(rentFromDate);
    rentToDate.setDate(rentToDate.getDate() + 1);
    var minDate = rentToDate.toISOString().split('T')[0];
    rentToDateInput.setAttribute('min', minDate);
  }

</script>
  </div>
</div>

      
        </div>
      </div>
    </main>
    <?php require'../components/footer.php';?>
  </body>
</html>
<?php 
}else{
  header("Location: ../login/signin.php?error=You need to login first");

  exit();
}
?>