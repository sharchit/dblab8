<?php
    session_start();
    ini_set('display_errors', 1);
    error_reporting(-1);
?>
<h1>Welcome <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?></h1>

<p>Here's your information:</p>

<ul>
  <li><strong>First Name:</strong> <?php echo $_SESSION['first_name']; ?></li>
  <li><strong>Last Name:</strong> <?php echo $_SESSION['last_name']; ?></li>
  <li><strong>Email:</strong> <?php echo $_SESSION['email']; ?></li>
</ul>

<p><a href="update_info.php?PHPSESSID=<?php echo session_id(); ?>">Update Information</a></p>
<p><a href="logout.php">Logout</a></p>
<p><a href="delete_account.php?PHPSESSID=<?php echo session_id(); ?>">Delete Account?</a></p>