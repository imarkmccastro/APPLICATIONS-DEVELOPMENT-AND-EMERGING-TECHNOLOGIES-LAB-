<?php
$pageTitle = "Short Stories — All Stories";

// require() used: page cannot function without the header
require('header.php');
?>

<h2 style="text-align:center; margin-bottom: 16px;">All Short Stories</h2>

<!-- 5-column grid layout matching the lab format -->
<div class="stories-grid">

    <div class="story-card">
        <img src="img/story1.svg" alt="The Lost Key">
        <p><strong>Story 1</strong><br>The Lost Key</p>
        <a href="story1.php">Read Story</a>
    </div>

    <div class="story-card">
        <img src="img/story2.svg" alt="A Rainy Afternoon">
        <p><strong>Story 2</strong><br>A Rainy Afternoon</p>
        <a href="story2.php">Read Story</a>
    </div>

    <div class="story-card">
        <img src="img/story3.svg" alt="The Old Lighthouse">
        <p><strong>Story 3</strong><br>The Old Lighthouse</p>
        <a href="story3.php">Read Story</a>
    </div>

    <div class="story-card">
        <img src="img/story4.svg" alt="Midnight Snack">
        <p><strong>Story 4</strong><br>Midnight Snack</p>
        <a href="story4.php">Read Story</a>
    </div>

    <div class="story-card">
        <img src="img/story5.svg" alt="The Last Letter">
        <p><strong>Story 5</strong><br>The Last Letter</p>
        <a href="story5.php">Read Story</a>
    </div>

</div>

<?php
// include() used: footer is optional, page still works without it
include('footer.php');
?>
