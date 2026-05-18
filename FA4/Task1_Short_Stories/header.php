<?php
// header.php — loaded with require() because it is critical for page structure
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="grid-container">

    <div class="header">
        <h1>PHP Short Stories</h1>
        <nav>
            <a href="index.php">&#8962; All Stories</a>
            <a href="story1.php">The Lost Key</a>
            <a href="story2.php">A Rainy Afternoon</a>
            <a href="story3.php">The Old Lighthouse</a>
            <a href="story4.php">Midnight Snack</a>
            <a href="story5.php">The Last Letter</a>
        </nav>
    </div>

    <div class="main">
