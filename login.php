<?php
session_start();
ini_set('display_errors', 1);
error_reporting(-1);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // Connect to the MySQL database
    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = 'sharchit';
    $db_name = 'dblab8';
    $db = new mysqli($db_host, $db_user, $db_password, $db_name);
    // Query the "users" table for the user's email and password
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $db->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['password'] = $row['password'];
            // echo $_SESSION['first_name']  ' '  $_SESSION['last_name '];
            header("Location: welcome.php");
        }
    }
    // echo $_SESSION['first_name'] . $_SESSION['last_name'];
    // Authentication failed
    $error = 'Invalid email or password';
}

// Display the login form
?>

<!-- <?php
    if(isset($_GET['message'])){
        echo $_GET['message'];
    }
?> -->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Portal</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="bootstrap-5.3.0-alpha2-dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="bootstrap-5.3.0-alpha2-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="background-color:#42f5b0;"">
    <div class="container-fluid p-5 bg-success text-white text-center">
		<h1 class="display-1">Login Portal</h1>
		<p>Enter your email and password to login.</p>
	</div>
    <nav class="navbar navbar-expand-sm bg-success navbar-dark justify-content-center">
		
			<ul class="navbar-nav">
			  <li class="nav-item">
				<a class="nav-link active" href="login.php">Login Page</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="registration.php">Registration Page</a>
			  </li>
			</ul>
		  
	</nav>
	<div class="container mt-3">
        <?php
            if(isset($_GET['message'])){
                $msg = $_GET['message'];
                echo "<div class='alert alert-info justify-content-center'><strong>$msg</strong> Now you can login with your credentials.</div>";
            }
        ?>
        <form method="post" action="login.php">
			<div class="row gy-6">
                <label for="email" class="form-label">Email:</label>
				<input class="form-control form-control-lg" type="email" name="email" required placeholder="john.doe@example.com">
            </div>
            <div class="row gy-6">
				<label for="password" class="form-label">Password:</label>
				<input class="form-control form-control-lg"  type="password" name="password" required placeholder="Enter your password">
			</div>
			<div class="row gy-6">
                <hr>
                <input type="submit" value="Login" class="btn btn-success btn-large justify-content-center">
            </div>
        </form>
        <?php if (isset($error)): 
            echo "<hr><div class='alert alert-danger justify-content-center'><strong>$error</strong></div>";    
        ?>
        <?php endif; ?>
    </div>
</body>

</html>
