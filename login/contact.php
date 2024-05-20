<?php  
session_start();
include "../components/db_connect.php";
date_default_timezone_set("Asia/Manila");

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];
        
        $stmt = $conn->prepare("INSERT INTO contact_form (first_name, last_name, email, phone_number, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $phone, $message);

        if ($stmt->execute()) {
            echo "<script>alert('Message sent successfully');</script>";
        } else {
            echo "<script>alert('Error sending message');</script>";
        }

        $stmt->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact</title>
    <link rel="stylesheet" href="../css/contact.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  </head>
  <body>
  <?php require'../components/header1.php';?>
    <main>
        <div class="container">
        <div class="banner">
          <h2>Contact Form</h2>
          <p>We’d love to hear from you. Let’s get in touch and discuss your needs.</p>
          </div>
     
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="contact-form">
          <div class="input-group">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="firstName" required>
          </div>
          <div class="input-group">
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="lastName" required>
          </div>
          <div class="input-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="input-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" required>
          </div>
          <div class="input-group" style="grid-column: span 2;">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="4" required></textarea>
          </div>
          <div class="button-group" style="grid-column: span 2;">
            <button class="submit"type="submit" onclick="">Submit</button>

        </form>
      </div>
        </div>
    </main>
    <?php require'../components/footer.php';?>
    <script>
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
    window.location.reload();
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