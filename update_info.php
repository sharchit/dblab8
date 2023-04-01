<?php
session_start();

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
<html>
<head>
    <title>Update Information</title>
</head>
<body>
    <h1>Update Information</h1>
    <form method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>"><br><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>"><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>"><br><br>
        <label for="password">Password:</label>
        <input type="password" name="password"><br><br>
        <input type="submit" value="Update Information">
    </form>
    <br>
    <a href="welcome.php">Back to Welcome Page</a>
</body>
</html>
