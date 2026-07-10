<?php
require_once 'functions.php';
if (!isset($pageTitle)) {
    $pageTitle = "ThreadLine Clothing";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo displayText($pageTitle); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="site-shell">
    <header class="site-header">
        <a class="brand" href="index.php">
            <img src="img/logo.svg" alt="2ND3T Tech Group Logo">
            <span>
                <strong>2ND3T Tech Group</strong>
                <small>ThreadLine Clothing</small>
            </span>
        </a>
        <nav class="main-nav">
            <a href="index.php">Store</a>
            <a href="cart.php">Cart (<?php echo cartCount(); ?>)</a>
            <a href="about.php">About</a>
            <?php if (isset($_SESSION['user_id'])) { ?>
                <?php if (($_SESSION['role'] ?? "") == "admin") { ?>
                    <a href="admin_dashboard.php">Seller Part</a>
                <?php } ?>
                <a href="logout.php">Logout</a>
            <?php } else { ?>
                <a href="login.php">Buyer Login</a>
                <a href="register.php">Register</a>
                <a href="admin_login.php">Admin</a>
            <?php } ?>
        </nav>
    </header>
    <main class="page-content">
