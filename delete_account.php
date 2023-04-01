<?php
session_start();
ini_set('display_errors', 1);
error_reporting(-1);
if (!isset($_SESSION['email'])) {
  header("Location: login.php"); // redirect to login page if user is not logged in
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
    header("Location: login.php");
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
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="bootstrap-5.3.0-alpha2-dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="bootstrap-5.3.0-alpha2-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="background-color:white;">
    <div class="container-fluid p-5 bg-danger text-white text-center">
        <h1>Delete Account</h1>
        <p >Are you sure you want to delete your account? This action cannot be undone.</p>
    </div>
    <nav class="navbar navbar-expand-sm bg-danger navbar-dark justify-content-center">
			<ul class="navbar-nav">
			  <li class="nav-item">
				<a class="nav-link" href="update_info.php?PHPSESSID=<?php echo session_id(); ?>">Update Information</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="welcome.php">Back to Welcome</a>
			  </li>
              <li class="nav-item">
				<a class="nav-link" href="logout.php">Logout</a>
			  </li>
			</ul>
	</nav>
	<div class="container mt-3">
        <form method="POST" action="">
			<div class="row gy-6">
                <label>Password:</label>
                <input type="password" name="password"><br>
                <?php if (isset($error)) { 
                    echo "<div class='alert alert-danger'>$error</div>"; 
                }
                ?>
            </div>
			<div class="row gy-6">
                <hr>
                <input type="submit" name="submit" value="Delete Account" class="btn btn-danger btn-large justify-content-center">
            </div>
        </form>
    </div>
</body>
</html>
