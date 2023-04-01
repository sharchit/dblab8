<?php
session_start();
ini_set('display_errors', 1);
error_reporting(-1);
// Connect to MySQL database
$dbhost = 'localhost';
$dbname = 'dblab8';
$dbuser = 'root';
$dbpass = 'sharchit';

try {
    $db = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get the user's information from the "users" table
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM users WHERE id=:id");
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Update the user's information in the "users" table
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $execute = 'y';
    if ($_POST['password'] == "") {
        $hashed_password = $_SESSION['password'];
    }
    else {
        $password = $_POST['password'];
        if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])(?=.*[a-zA-Z]).{8,}$/", $password)) {
            echo "<script>alert('Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.');</script>";
            $execute = 'n';
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }


    // Update the user's information in the database
    if($execute == 'y') {
        $stmt = $db->prepare("UPDATE users SET first_name=:first_name, last_name=:last_name, email=:email, password=:password WHERE id=:id");
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();

        // Update the user variable with the new information
        $user['first_name'] = $first_name;
        $user['last_name'] = $last_name;
        $user['email'] = $email;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['email'] = $email;
        header("Location: welcome.php");
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Information</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="bootstrap-5.3.0-alpha2-dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="bootstrap-5.3.0-alpha2-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="background-color:white;">
    <div class="container-fluid p-5 bg-danger text-white text-center">
        <h1 class="display-3">Update Information</h1>
        <p>In the form below change the relevant fields.</p>
    </div>
    <nav class="navbar navbar-expand-sm bg-danger navbar-dark justify-content-center">
			<ul class="navbar-nav">
			  <li class="nav-item">
				<a class="nav-link" href="welcome.php">Back to Welcome</a>
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
        <form method="POST">
			<div class="row gy-3">
				<div class="col">
                    <label for="first_name" class="form-label">First Name:</label>
                    <input class="form-control" type="text" name="first_name" value="<?php echo $user['first_name']; ?>">
                </div>
				<div class="col">
                    <label for="last_name" class="form-label">Last Name:</label>
                    <input class="form-control" type="text" name="last_name" value="<?php echo $user['last_name']; ?>">
                </div>
            </div>
			<div class="row gy-6">
                <hr>
                <label for="email" class="form-label">Email:</label>
                <input class="form-control" type="email" name="email" value="<?php echo $user['email']; ?>">
			</div>
			<div class="row gy-6">
                <hr>
                <label for="password" class="form-label">Password:</label>
                <input class="form-control" type="password" name="password">
            </div>
			<div class="row gy-6">
                <hr>
                <input type="submit" value="Update Information" class="btn btn-success btn-large justify-content-center">
            </div>
        </form>
    </div>
    <!-- <a href="welcome.php">Back to Welcome Page</a> -->
</body>
</html>
