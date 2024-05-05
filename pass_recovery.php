<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parental"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_phone = $_POST['email'];

    $sql = "SELECT * FROM users WHERE email = '$email_phone' OR phone = '$email_phone'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $_SESSION['email_phone'] = $email_phone;
        header("Location: reset_pass.php");
        exit();
    } else {
  
       $error_message = "<span style='font-size: smaller;'>Your search did not return any results, please try again.</span>";

    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Password Recovery</title>
  <link rel="stylesheet" type="text/css" href="/css/pass_recovery.css">
</head>
<body>
  <div class="container">
    <div class="form-container">
      <h2>Reset Password</h2><hr>
      <p>Please enter your email address or phone number to search for your account.</p>
      
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" id="email" name="email" placeholder="Email or phone number" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$|^\d{10,}$" required>
        <span style="color: red;"><?php echo $error_message; ?></span><br><br>
        <button type="button" onclick="cancel()">Cancel</button>
        <input type="submit" value="Search">
      </form>
    </div>
  </div>

  <script>
    function cancel() {
      window.location.href = "signin.php"; 
    }
  </script>
</body>
</html>
