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
      $price = floatval($_POST['cart'][$cart_id]['product_price']);
      $days = intval($_POST['cart'][$cart_id]['day']);

      // Retrieve the product_id from the cart
      $product_query = "SELECT product_id FROM cart WHERE id = ?";
      $stmt = $conn->prepare($product_query);
      $stmt->bind_param("i", $cart_id);
      $stmt->execute();
      $stmt->bind_result($product_id);
      $stmt->fetch();
      $stmt->close();

      // Retrieve the category_id from the products table
      $category_query = "SELECT category_id FROM products WHERE id = ?";
      $stmt = $conn->prepare($category_query);
      $stmt->bind_param("i", $product_id);
      $stmt->execute();
      $stmt->bind_result($category_id);
      $stmt->fetch();
      $stmt->close();

      // Calculate the subtotal based on the category
      if ($category_id == 10) {
          $multiplier = ceil($days / 5);  // Ceiling function applied to (days / 5)
          $subtotal = $price * $quantity * $multiplier;  // Category 10: multiply by the ceiling of (days / 5)
      } else {
          $subtotal = $price * $quantity * $days;  // Default calculation
      }

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
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/checkout.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>

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
          <th>Day/s</th>
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
              $query = "SELECT cart.id, cart.quantity, cart.subtotal, products.name, products.price, cart.start_date, cart.end_date, products.category_id 
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
                  $category_id = $row['category_id'];
                  $total += $subtotal;
                  $start_date = new DateTime($row['start_date']);
                  $end_date = new DateTime($row['end_date']);
                  $interval = $start_date->diff($end_date);
                  $day = ceil($interval->days);
          
                  // Determine if it is a Package or Product
                  $item_type = $category_id == 10 ? "Package" : "Product";
          
                  echo '<tr>';
                  echo '<td>' . $product_name . ' <br><span class="product-price" data-price="' . $product_price . '" data-category="' . $category_id . '">' . $item_type . '</span> [ ' . $product_price . ' ] <span class="quantity"> x ' . $quantity . ' </span></td>';
                  echo '<td><span class="day" id="day">' . $day . ' Day/s</span></td>';
                  echo '<td><span id="total-price">₱ ' . number_format($subtotal, 2) . '</td>';
                  echo '</tr>';
                  echo '<input type="hidden" name="checked_cart[]" value="' . $cart_id . '">';
                  echo '<input class="new_day" type="hidden" id="new_day" name="cart[' . $cart_id . '][day]" >';
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
   <label><input type="radio" name="payment_method" value="GCash" onclick="showGcashModal()"> GCash</label>
   <div id="fileUploadContainer" style="display: none; font-weight: bold;">Upload GCash Receipt
        <input type="file" id="fileInput" name="payment_proof" accept="image/*, .pdf">
    </div>
  <div id="gcashModal" class="modal">
        <div class="modal-content"  style=" max-width: 250px; margin-top:70px; margin-bottom:-50px;">
            <span class="close" onclick="closeGcashModal()">&times;</span>
            <img src="../images/gcash.jpg" alt="GCash QR Code" style=" max-width: 250px;"><br><br>
            <p>Scan this Gcash QR code to place your order.</p>
        </div>
    </div>
  <label><input type="radio" name="payment_method" value="Cash On Delivery"> Cash on Delivery</label>
</div>
 <button type="button" class="checkout-btn" onclick="openTermsModal()">Place order</button>
 
<div id="termsModal" class="modal">
  <div class="modal-content">
    <h2>Terms & Conditions</h2>
    <p style="text-align: justify">Welcome to PaRENTAL. By renting equipment from us, you agree to the following terms and conditions. Please read them carefully.

<br><br>1. Rental Agreement
	This agreement is between PaRENTAL and you. By renting from us, you agree to the following terms and conditions.

<br>2. Rental Period
	The rental period starts on the delivery date and ends on the return date. Please return the equipment on the agreed return date.

<br>3. Rental Fees and Payment
	Payment is due at the time of delivery if Cash on Delivery is the payment method selected, otherwise it is due at the time of booking if the payment method is GCash. Late returns will incur additional charges.

<br>4. No Cancellation or Refunds
	Once booked and paid for, rentals cannot be canceled or refunded. You agree to this no-cancellation policy.

<br>5. Delivery and Pickup
	PaRENTAL delivers the equipment to your specified location. Be present to receive the equipment or have an authorized person do so. We will pick up the equipment from the original delivery location.

<br>6. Late Returns
	Late returns will incur additional charges of 10% of the total rental fee per day. Request extensions by email at least 30 hours before the return date.

<br>7. Condition of Equipment
	Inspect the equipment upon delivery and report any issues within  10 hours. This is to provide a window for PaRENTAL to inspect the rented equipment and replace them. Return the equipment in the same condition as received.

<br>8. Damage and Loss
	You are responsible for any loss or damage to the equipment during the rental period. Pay the cost of repair or replacement if the equipment is damaged or lost.

<br>9. Use of Equipment
	Use the equipment only for its intended purpose. Do not alter or modify the equipment.

<br>10. Liability
	We are not liable for any injury, loss, or damage arising from the use of the equipment. You agree to repay us against any claims arising from your use of the equipment.

<br>11. Termination
	We may terminate this agreement if you breach any terms. If terminated, return the equipment immediately.

<br>12. Governing Law
	This agreement is governed by the laws of  The Republic of the Philippines.

<br>13. Entire Agreement
	This is the entire agreement between us and you.

<br>By renting from us, you acknowledge and agree to these terms and conditions.

<br>Customer Signature: ________________________

<br>Customer Name (Printed): ____________________

<br>Date: ________________________

<br>Company Representative Signature: ________________________

<br>Company Representative Name (Printed): ____________________

<br>Date: ________________________</p>
    <button type="button" class="modal-button"onclick="closeTermsModal()">Cancel</button>
    <button  type="button" class="modal-button-confirm" style="background-color:midnightblue"onclick="conditionsModal(); downloadPDF()">Print</button>
    <button  type="button" class="modal-button-confirm"onclick="showConfirmationModal()">Agree</button>
  </div>
</div>

<div id="conditionsModal" class="modal">
  <div class="modal-content">
    <h2>Terms & Conditions</h2>
    <p>Please hand this over to our staff during the delivery process.<br>Thank you</p>
    <button type="button" class="modal-button"onclick="openTermsModal()">Back</button>
    <button  type="button" class="modal-button-confirm"onclick="showConfirmationModal()">Continue</button>
  </div>
</div>

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
    <button type="submit" class="modal-button-confirm" onclick="closeAllModals()">Close</button>
  </div>
</div>
</form>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        disablePastDates();
      });
    function showConfirmationModal() {
      closeTermsModal();
      closeConditionModal();
      document.getElementById('confirmationModal').style.display = 'block';
    }
    function conditionsModal() {
      closeTermsModal();
      document.getElementById('conditionsModal').style.display = 'block';
    }
    function closeConditionModal() {
      document.getElementById('conditionsModal').style.display = 'none';
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
    function openTermsModal() {
      closeConfirmationModal(); 
      closeConditionModal();
    document.getElementById('termsModal').style.display = 'block';
    }

    function closeTermsModal() {
      closeConfirmationModal(); 
      document.getElementById('termsModal').style.display = 'none';
    }
    function closeAllModals() {
      document.getElementById('termsModal').style.display = 'none';
      document.getElementById('confirmationModal').style.display = 'none';
      document.getElementById('orderConfirmedModal').style.display = 'none';
       document.getElementById('conditionsModal').style.display = 'none';
    }

    function calculateDate() {
    var rentFrom = new Date(document.getElementById("rent-from").value);
    var rentTo = new Date(document.getElementById("rent-to").value);
    var days = Math.ceil((rentTo - rentFrom) / (1000 * 60 * 60 * 24));
    var basePriceElements = document.querySelectorAll('.product-price');
    var newDayInputs = document.querySelectorAll('.new_day');
    var quantityElements = document.querySelectorAll('.quantity');
    var subtotalElements = document.querySelectorAll('#total-price');
    var total = 0; 
    var fee = 0;

    basePriceElements.forEach(function(basePriceElement, index) {
        var day = 0;
        var multiplier = 0
        var basePrice = parseFloat(basePriceElement.getAttribute('data-price'));
        var category = parseInt(basePriceElement.getAttribute('data-category'));
        var quantity = parseInt(quantityElements[index].innerText.split('x')[1].trim());
        
        
        if (category === 10) {

          multiplier = Math.ceil(days / 5);
        } else {
          multiplier = Math.ceil(days);
        }
        day = Math.ceil(days);

        var subtotal = basePrice * quantity * multiplier;

        // Update total
        total += subtotal;

        if (!isNaN(day)) {
            // Set day text for display
            var dayText = "" + day + " Day/s";
            var dayElements = document.querySelectorAll('.day');
            dayElements[index].innerText = dayText;

            // Update subtotal for display
            subtotalElements[index].innerText = '₱' + subtotal.toFixed(2);

            // Set day value for form submission
            newDayInputs[index].value = day;
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
  // Function to show the GCash modal
    function showGcashModal() {
        var modal = document.getElementById("gcashModal");
        var fileUploadContainer = document.getElementById("fileUploadContainer");
        modal.style.display = "block";
          fileUploadContainer.style.display = "block";
    }

    // Function to close the GCash modal
    function closeGcashModal() {
        var modal = document.getElementById("gcashModal");
          var fileUploadContainer = document.getElementById("fileUploadContainer");
        modal.style.display = "none";
        fileUploadContainer.style.display = "block"; 
    }
    function downloadPDF() {
            var pdfUrl = 'TermsAndConditions.pdf';
            var anchor = document.createElement('a');

            anchor.href = pdfUrl;
            anchor.download = 'Parental Terms & Conditions.pdf';
            anchor.click();
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