<?php
    session_start();
    ini_set('display_errors', 1);
    error_reporting(-1);
    if (!isset($_SESSION['email'])) {
        header("Location: login.php"); // redirect to login page if user is not logged in
        exit();
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Welcome Page</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="bootstrap-5.3.0-alpha2-dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="bootstrap-5.3.0-alpha2-dist/js/bootstrap.bundle.min.js"></script>
</head>
    <body style="background-color:white;">
	<div class="container-fluid p-5 bg-danger text-white text-center">
        <h1 class="display-3">Welcome <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?></h1>
    </div>
    <nav class="navbar navbar-expand-sm bg-danger navbar-dark justify-content-center">
			<ul class="navbar-nav">
			  <li class="nav-item">
				<a class="nav-link" href="update_info.php?PHPSESSID=<?php echo session_id(); ?>">Update Information</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="delete_account.php?PHPSESSID=<?php echo session_id(); ?>">Delete Account</a>
			  </li>
              <li class="nav-item">
				<a class="nav-link" href="logout.php">Logout</a>
			  </li>
			</ul>
	
	</nav>
	<div class="container mt-3">
        <p>Here's your information:</p>
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge bg-primary rounded-pill">First Name:</span> <?php echo $_SESSION['first_name']; ?></li>
            <li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge bg-primary rounded-pill">Last Name:</span> <?php echo $_SESSION['last_name']; ?></li>
            <li class="list-group-item d-flex justify-content-between align-items-center"><span class="badge bg-primary rounded-pill">Email:</span> <?php echo $_SESSION['email']; ?></li>
        </ul>
    </div>
        <!-- <p><a href="update_info.php?PHPSESSID=<?php echo session_id(); ?>">Update Information</a></p> -->
        <!-- <p><a href="logout.php">Logout</a></p> -->
        <!-- <p><a href="delete_account.php?PHPSESSID=<?php echo session_id(); ?>">Delete Account?</a></p> -->
    </body>
</html>