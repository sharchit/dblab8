<?php
    session_start();
    session_destroy();
    header("Location: login.php"); // replace index.php with the URL of the desired page
    exit;
?>