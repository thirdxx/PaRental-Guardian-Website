<?php
session_start();

require_once "../components/db_connect.php";

$error = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_phone = $_POST['email_phone'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE phone_number = '$email_phone' OR email = '$email_phone'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $userId = $row['id'];
            $_SESSION['id'] = $userId; // Set the session ID here
            if (isset($_SESSION['productId'])){
                $productID = $_SESSION['productId'];
                unset($_SESSION['productId']);
                header("Location: product_details.php?id=".$productID);
            } else {
                header("Location: homepage.php");
            }
            exit();
        } else {
            $error = "Incorrect email or phone, or password.";
            $_SESSION['email_phone'] = $email_phone; 
        }
    } else {
        $error = "Incorrect email or phone, or password.";
        $_SESSION['email_phone'] = $email_phone; 
    }
}

if ($_SERVER["REQUEST_METHOD"] != "POST" || isset($error)) {
    unset($_SESSION['email_phone']);
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>renta.com/sign in</title>
  <link rel="stylesheet" href="../css/signin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>
  <div class="container" id="container">
    <div class="form-container sign-up-container"></div>
    <div class="form-container sign-in-container">
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <h1>Sign in </h1>
        <div class="social-container">
          <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
          <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <span>or use your account</span>
        <input type="text" name="email_phone" placeholder="Email or Phone" value="<?php echo isset($_SESSION['email_phone']) ? $_SESSION['email_phone'] : ''; ?>" />
        <input type="password" name="password" placeholder="Password" />
        <?php if (isset($_GET['error'])) { ?>
          <span style="color: red;"><?php echo $_GET['error']; ?></span></>
        <?php } ?>
        <span style="color: red;"><?php echo $error; ?></span>
        <a href="pass_recovery.php" class="forgotpass">Forgot your password?</a>
        <button type="submit">Sign In</button>
      </form>
    </div>
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1>Welcome Back!</h1>
          <p>To keep connected with us please login</p>
        </div>
        <div class="overlay-panel overlay-right">
          <h1>Hello, Customer!</h1>
          <p>Don't have an account? Create an account and start your event journey with us</p>
          <a href="../login/signup.php" id="login" class="ghost">Sign Up</a>
        </div>
      </div>
    </div>
  </div>
  <?php
    unset($_SESSION['email_phone']); 
  ?>
</body>
</html>
