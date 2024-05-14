<!DOCTYPE html>
<html>
<head>
  <title>renta.com/sign up</title>
  <link rel="stylesheet" href="../css/signin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <style>
    .password-requirements {
      color: red;
    }
    .password-error {
      outline: 2px solid red;
    }
  </style>
  <script>
    function validatePassword() {
      var password = document.getElementById("password").value;
      var passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;
      var passwordRequirements = document.getElementById("password-requirements");
      var passwordInput = document.getElementById("password");

      if (!passwordPattern.test(password)) {
        var requirements = "";
        if (!/[A-Z]/.test(password)) {
          requirements += "At least one uppercase letter (A-Z).<br>";
        }
        if (!/[a-z]/.test(password)) {
          requirements += "At least one lowercase letter (a-z).<br>";
        }
        if (!/\d/.test(password)) {
          requirements += "At least one number (0-9).<br>";
        }
        if (!/[!@#$%^&*]/.test(password)) {
          requirements += "At least one special character (!@#$%^&*).<br>";
        }
        if (password.length < 8) {
          requirements += "At least 8 characters long.<br>";
        }
        passwordRequirements.innerHTML = requirements;
        passwordInput.classList.add("password-error");
        return false;
      } else {
        passwordRequirements.innerHTML = "";
        passwordInput.classList.remove("password-error");
      }
      return true;
    }
  </script>
</head>
<body>
  <?php
  session_start();
  
  $servername = "localhost";
  $username = "root";
  $pwd = "";
  $dbname = "parental";

  $conn = new mysqli($servername, $username, $pwd, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $userRecordInserted = false;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT MAX(id) FROM users";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $next_id = $row[0] + 1;

    $sql = "INSERT INTO `users`(`id`, `full_name`, `email`, `phone_number`, `password`) 
      VALUES ('$next_id', '$user_name', '$email', '$phone', '$hashedPassword')";

    $rs = mysqli_query($conn, $sql);

    if ($rs) {
      $userRecordInserted = true;
    } else {
      echo "Error: " . mysqli_error($conn);
    }
  }

  if ($userRecordInserted) {
    header("Location: signin.php");
    exit();
  } else {
  ?>
  <div class="container" id="container">
    <div class="form-container sign-up-container"></div>
    <div class="form-container sign-in-container">
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validatePassword()">
        <h1>Create Account</h1>
        <div class="social-container">
          <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
          <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <span>or use your email for registration</span>
        <input type="text" name="user_name" id="user-name" placeholder="Name" required />
        <input type="email" name="email" id="email" placeholder="Email" required />
        <input type="text" name="phone" id="phone" placeholder="Phone" required />
        <input type="password" name="password" id="password" placeholder="Password" required />
        <span id="password-requirements" class="password-requirements"></span>
        <button type="submit" name="add">SIGN UP</button>
      </form>
    </div>
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <!-- <h1>Welcome Back!</h1>
          <p>To keep connected with us please login</p>
          <button class="ghost" href="homepage.html">Sign In</button> -->
        </div>
        <div class="overlay-panel overlay-right">
          <h1>Welcome Back!</h1>
          <p>To keep connected with us please login</p>
          <a href="signin.php" id="login" class="ghost">Sign In</a>
        </div>
      </div>
    </div>
  </div>
  <?php
  }

  $conn->close();
  ?>
</body>
</html>
