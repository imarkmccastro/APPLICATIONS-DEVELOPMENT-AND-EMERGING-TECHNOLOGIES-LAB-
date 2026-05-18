<?php
$pageTitle = "The Last Letter";

// require() used: page cannot function without the header
require('header.php');

// require() used: custom functions are essential
require('functions.php');

// Hardcoded arguments passed to displayStory()
$content = "Ana found an old letter tucked inside a library book. It was written in faded ink, addressed to someone named 'Dear Friend.' She read it slowly, feeling as though the words were meant for her all along.";

// Call displayStory() with hardcoded title, image filename, and content
displayStory("The Last Letter", "story5.svg", $content);

// strrev() Demo — reverses a hardcoded word
$original = "LETTER";
$reversed = strrev($original); // predefined PHP function
?>

<table class="string-demo">
    <tr><td colspan="2">strrev() Demo</td></tr>
    <tr><td>Original</td><td><?php echo $original; ?></td></tr>
    <tr><td>After strrev()</td><td><?php echo $reversed; ?></td></tr>
</table>

<br>

<?php
// Call countChars() — custom function using strlen() internally
// Hardcoded argument: the page title string
$result = countChars("The Last Letter");
echo "<p><strong>countChars() Demo:</strong> " . $result . "</p>";

// include() used: footer is optional, page still works without it
include('footer.php');
?>
