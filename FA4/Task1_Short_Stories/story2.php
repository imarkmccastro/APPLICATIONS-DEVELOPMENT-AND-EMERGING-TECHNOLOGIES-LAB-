<?php
$pageTitle = "A Rainy Afternoon";

// require() used: page cannot function without the header
require('header.php');

// require() used: custom functions are essential
require('functions.php');

// Hardcoded arguments passed to displayStory()
$content = "The rain tapped gently on the window as Leo sat by the fire with a warm cup of tea. He had nowhere to be and nothing to do. For the first time in months, he felt completely at peace.";

// Call displayStory() with hardcoded title, image filename, and content
displayStory("A Rainy Afternoon", "story2.svg", $content);

// ucfirst() Demo — capitalizes the first character of a hardcoded lowercase sentence
$original  = "the rain made everything feel calm and new.";
$formatted = ucfirst($original); // predefined PHP function
?>

<table class="string-demo">
    <tr><td colspan="2">ucfirst() Demo</td></tr>
    <tr><td>Original</td><td><?php echo $original; ?></td></tr>
    <tr><td>After ucfirst()</td><td><?php echo $formatted; ?></td></tr>
</table>

<?php
// include() used: footer is optional, page still works without it
include('footer.php');
?>
