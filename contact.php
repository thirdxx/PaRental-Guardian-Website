<?php  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact</title>
    <link rel="stylesheet" href="css/contact.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
  </head>
  <body>
  <?php require'./components/header.php';?>
    <main>
        <div class="container">
        <div class="banner">
          <h2>Contact Form</h2>
          <p>We’d love to hear from you. Let’s get in touch and discuss your needs.</p>
          </div>
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
    <button class="submit"type="submit">Submit</button>
    <button class="reset" type="reset">Reset</button>
  </div>
</div>
        </div>
    </main>
    <?php require'./components/footer.php';?>
  </body>
</html>
