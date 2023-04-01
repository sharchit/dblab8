<?php
    session_start();
    session_destroy();
    header("Location: login.html"); // replace index.php with the URL of the desired page
    exit;
?>