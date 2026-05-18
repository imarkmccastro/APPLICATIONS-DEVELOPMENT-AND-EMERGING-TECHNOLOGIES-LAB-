<?php
$pageTitle = "The Old Lighthouse";

// require() used: page cannot function without the header
require('header.php');

// require() used: custom functions are essential
require('functions.php');

// Hardcoded arguments passed to displayStory()
$content = "The old lighthouse stood at the edge of the dark cliff, its light sweeping the dark sea below. Sailors had trusted it for generations. Tonight, a young girl climbed its dark stairs for the very first time.";

// Call displayStory() with hardcoded title, image filename, and content
displayStory("The Old Lighthouse", "story3.svg", $content);

// str_replace() Demo — replaces all occurrences of "dark" with "misty"
$original = "The dark sea was full of dark secrets.";
$replaced = str_replace("dark", "misty", $original); // predefined PHP function
?>

<table class="string-demo">
    <tr><td colspan="2">str_replace() Demo</td></tr>
    <tr><td>Original</td><td><?php echo $original; ?></td></tr>
    <tr><td>After str_replace("dark", "misty")</td><td><?php echo $replaced; ?></td></tr>
</table>

<?php
// include() used: footer is optional, page still works without it
include('footer.php');
?>
