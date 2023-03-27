<!-- registration.php -->

<?php
// Connect to the MySQL database
ini_set('display_errors', 1);
error_reporting(-1);
$host = "localhost";
$username = "root";
$password = "iitp@123";
$conn = mysqli_connect($host, $username, $password);
// Check if the connection was successful
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }
else {
    echo "<b>Connected successfully</b><hr><br>";
    // Get the user input data from the form
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    
    // Validate the user input data
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "Please fill out all the required fields.<br>";
    } elseif ($password != $confirm_password) {
        echo "The passwords do not match.<br>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.<br>";
    } elseif (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])(?=.*[a-zA-Z]).{8,}$/", $password)) {
        echo "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.<br>";
    } else {
        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Insert the user data into the "users" table

        $sql = "INSERT INTO dblab8.users (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$hashed_password')";
        if (mysqli_query($conn, $sql)) {
            echo "Registration successful.<br>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}


// Close the database connection
mysqli_close($conn);
?>
