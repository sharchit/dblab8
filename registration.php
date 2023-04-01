<!-- registration.php -->

<?php
// Connect to the MySQL database
ini_set('display_errors', 1);
error_reporting(-1);
$host = "localhost";
$username = "root";
$password = "sharchit";
$conn = mysqli_connect($host, $username, $password);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Check if the connection was successful
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
    else {
        // echo "<b>Connected successfully</b><hr><br>";
        // Get the user input data from the form
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        // Validate the user input data
        if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
            $error="Please fill out all the required fields.<br>";
        } elseif ($password != $confirm_password) {
            $error="The passwords do not match.<br>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error="Invalid email format.<br>";
        } elseif (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])(?=.*[a-zA-Z]).{8,}$/", $password)) {
            $error="Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.<br>";
        } else {
            // Hash the password before storing it in the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Insert the user data into the "users" table

            $sql = "INSERT INTO dblab8.users (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$hashed_password')";
            if (mysqli_query($conn, $sql)) {
                $message=urlencode("Registration Successful!");
                header("Location:login.php?message=".$message);
            } else {
                $error="Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }


    // Close the database connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>User Registration Form</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="bootstrap-5.3.0-alpha2-dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="bootstrap-5.3.0-alpha2-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="background-color:powderblue;"">
	<div class="container-fluid p-5 bg-primary text-white text-center">
		<h1 class="display-1">User Registration Form</h1>
		<p>Enter your name, email and password to register.</p>
	</div>
	<nav class="navbar navbar-expand-sm bg-primary navbar-dark justify-content-center">
		<ul class="navbar-nav">
			<li class="nav-item">
			<a class="nav-link" href="login.php">Login Page</a>
			</li>
			<li class="nav-item">
			<a class="nav-link active" href="registration.php">Registration Page</a>
			</li>
		</ul>
	</nav>
	<div class="container mt-3">
		<form action="registration.php" method="post">
			<div class="row gy-3">
				<div class="col">
					<label for="first_name" class="form-label">First Name:</label>
					<input class="form-control form-control-lg" type="text" name="first_name" required placeholder="John"><br><br>
				</div>
				<div class="col">
					<label for="last_name" class="form-label">Last Name:</label>
					<input class="form-control form-control-lg" type="text" name="last_name" required placeholder="Doe"><br><br>
				</div>
			</div>
			<div class="row gy-6">
				<label for="email" class="form-label">Email:</label>
				<input class="form-control" type="email" name="email" required placeholder="john.doe@example.com"><br><br>
			</div>
			<div class="row gy-6">
				<label for="password" class="form-label">Password:</label>
				<input class="form-control form-control-sm"  type="password" name="password" required placeholder="Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character."><br><br>
			</div>
			<div class="row gy-6">
				<label for="confirm_password" class="form-label">Confirm Password:</label>
				<input class="form-control form-control-sm" type="password" name="confirm_password" required placeholder="Repeat password to confirm""><br><br>
			</div>
			<div class="row gy-6">
				<hr>
				<input type="submit" value="Register" class="btn btn-success btn-large justify-content-center">
			</div>
		</form>
        <?php if (isset($error)): 
            echo "<hr><div class='alert alert-danger justify-content-center'><strong>$error</strong></div>";    
        ?>
        <?php endif; ?>
	</div>
</body>
</html>