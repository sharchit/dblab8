<?php
session_start();
ini_set('display_errors', 1);
error_reporting(-1);
if (!isset($_SESSION['email'])) {
  header("Location: login.html"); // redirect to login page if user is not logged in
  exit();
}

if (isset($_POST['submit'])) {
  $password = $_POST['password'];
  $email = $_SESSION['email'];

  // retrieve user data from database
  $conn = mysqli_connect("localhost", "root", "sharchit", "dblab8");
  $sql = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($conn, $sql);
  $user = mysqli_fetch_assoc($result);

  // verify password
  if (password_verify($password, $user['password'])) {
    // delete user account
    $sql = "DELETE FROM users WHERE email='$email'";
    mysqli_query($conn, $sql);
    mysqli_close($conn);

    // redirect to login page with success message
    header("Location: login.html");
    exit();
  } else {
    // display error message
    $error = "Invalid password";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Delete Account</title>
</head>
<body>
  <h1>Delete Account</h1>
  <p>Are you sure you want to delete your account? This action cannot be undone.</p>
  <form method="POST" action="">
    <label>Password:</label>
    <input type="password" name="password"><br>
    <?php if (isset($error)) { echo "<p style='color:red'>$error</p>"; } ?>
    <input type="submit" name="submit" value="Delete Account">
  </form>
</body>
</html>
