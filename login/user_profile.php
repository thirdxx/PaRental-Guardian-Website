<?php
session_start();
include "../components/db_connect.php";
date_default_timezone_set("Asia/Manila");

if (isset($_SESSION['id'])) {
  // Fetch user information based on session id
  $userId = $_SESSION['id'];
  $query = "SELECT * FROM users WHERE id = $userId";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $fullName = $row['full_name'];
      $nameParts = explode(" ", $fullName);
      $firstName = $nameParts[0];
      $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
      $phone = $row['phone_number'];
      $email = $row['email'];
      $picture = $row['image'];
      $username = $row['username'];
      $address = $row['address'];
      $birthday = $row['birthday'];
      $gender = $row['gender'];
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission
    $newUsername = $_POST['username'];
    $newFullName = $_POST['name'];
    $newEmail = $_POST['email'];
    $newPhone = $_POST['phone'];
    $newAddress = $_POST['address'];
    $newBirthday = $_POST['birthday'];
    $newGender = $_POST['gender']; // Add this line to handle the gender

    // Update the user's information in the database using prepared statements
    $stmt = $conn->prepare("UPDATE users SET 
      username = ?, 
      full_name = ?, 
      email = ?, 
      phone_number = ?, 
      address = ?, 
      birthday = ?, 
      gender = ?
      WHERE id = ?");
    $stmt->bind_param("sssssssi", $newUsername, $newFullName, $newEmail, $newPhone, $newAddress, $newBirthday, $newGender, $userId);

    if ($stmt->execute()) {
      echo "<script>alert('Profile updated successfully');</script>";
      // Refresh the page to load new data
      echo "<script>window.location.href = 'user_profile.php';</script>";
    } else {
      // Update failed
      echo "<script>alert('Error updating profile');</script>";
    }

    $stmt->close();
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile</title>
    <link rel="stylesheet" href="../css/profile.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  </head>
  <body>
  <?php require '../components/header1.php'; ?>
    <main>
      <div class="banner">
        <h2>My Profile</h2>
      </div>
      <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
          <a class="accountbutton" href="user_profile.php"><i class="fas fa-solid fa-user"></i> My Account</a><br><br>
          <a class="purchasebutton" href="purchase.php"><i class="fas fa-solid fas fa-clipboard-list"></i> My Purchase</a><br><br>
           <a class="purchasebutton" href="reviews.php"><i class="fas fa-regular fa-star"></i> My Reviews</a><br><br><br><br><br><br><br><br><br><br>
          <a class="logoutbutton" href="../index.php"><i class="fas fa-solid fas fa-clipboard-list"></i> Log out</a>
        </div>
        
          <div class="contact-form">
            <div class="input-group">
              <label for="username" class="bold-label">Username</label>
              <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
            </div>
            <div class="input-group">
              <label for="name" class="bold-label">Name</label>
              <input type="text" id="name" name="name" value="<?php echo $fullName; ?>" required>
            </div>
            <div class="input-group">
              <label for="email" class="bold-label">Email Address</label>
              <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="input-group">
              <label for="phone" class="bold-label">Phone Number</label>
              <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" required>
            </div>
            <div class="input-group">
              <label for="address" class="bold-label">Address</label>
              <input type="text" id="address" name="address" value="<?php echo $address; ?>" required>
            </div>
            <div class="input-group">
              <div class="radio-container">
                <label for="gender" class="bold-label">Gender</label>
                <label><input type="radio" name="gender" value="Male" <?php echo ($gender == 'Male') ? 'checked' : ''; ?>> Male</label>
                <label><input type="radio" name="gender" value="Female" <?php echo ($gender == 'Female') ? 'checked' : ''; ?>> Female</label>
                <label><input type="radio" name="gender" value="Other" <?php echo ($gender == 'Other') ? 'checked' : ''; ?>> Other</label>
              </div>
            </div>
            <div class="input-group">
              <label for="birthday" class="bold-label">Date of Birth</label>
              <input type="date" id="birthday" name="birthday" value="<?php echo $birthday; ?>" required>
            </div>
            <div class="button-group" style="grid-column: span 2;">
              <button class="submit" type="submit">Save</button>
            </div>
          </div>
        </form>
      </div>
    </main>
    <?php require '../components/footer.php'; ?>
  </body>
</html>
<?php 
} else {
  header("Location: ../login/signin.php?error=You need to login first");
  exit();
}
?>
