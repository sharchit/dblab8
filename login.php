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
    $db_password = 'iitp@123';
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
            exit();
        }
    }
    echo $_SESSION['first_name'] . $_SESSION['last_name'];
    // Authentication failed
    $error = 'Invalid email or password';
}

// Display the login form
?>

<form method="post" action="login.php">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <input type="submit" value="Login">
</form>

<?php if (isset($error)): ?>
<p><?php echo $error; ?></p>
<?php endif; ?>
