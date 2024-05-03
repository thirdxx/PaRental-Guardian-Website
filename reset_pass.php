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
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    

    if ($new_password !== $confirm_password) {
        $error_message = "Passwords did not match.";
    } else {
 
        if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/', $new_password)) {
            $error_message = "Password must contain at least one uppercase letter, one lowercase letter, one number, one special character, and be at least 8 characters long.";
        } else {

            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

            if(isset($_SESSION['email_phone'])){
                $email_phone = $_SESSION['email_phone'];
                $sql = "UPDATE users SET password = ? WHERE email = ? OR phone = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $hashedPassword, $email_phone, $email_phone);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {

                    $success_message = "Password reset successfully. Please sign in with your new password.";
                    header("Location: signin.php");
                    exit();
                } else {
                    $error_message = "No account found with the provided email or phone number. Please try again.";
                }
            } else {
                $error_message = "No email or phone number provided. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
  <link rel="stylesheet" type="text/css" href="/css/pass_recovery.css">
</head>
<body>
  <div class="container">
    <div class="form-container">
      <h2>Reset Password</h2><hr>
      <p>Please enter your new password and confirm password.</p>
      
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="password" id="new_password" name="new_password" placeholder="New Password" required><br><br>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required><br><br>
        <span id="password-requirements" class="password-requirements"></span>
        <span style="color: red;"><?php echo $error_message; ?></span>
        <span style="color: green;"><?php echo $success_message; ?></span><br><br>
        <button type="button" onclick="back()">Back</button>
        <input type="submit" value="Reset Password">
      </form>
    </div>
  </div>

  <script>
    function back() {
      window.location.href = "pass_recovery.php"; 
    }
  </script>
</body>
</html>
