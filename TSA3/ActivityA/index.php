<?php
session_start();

if (isset($_SESSION['tsa3_a_username'])) {
    header("Location: home.php");
    exit();
}

header("Location: login.php");
exit();
?>
