<?php
$pageTitle = "Midnight Snack";

// require() used: page cannot function without the header
require('header.php');

// require() used: custom functions are essential
require('functions.php');

// Hardcoded arguments passed to displayStory()
$content = "At exactly midnight, Sam crept downstairs to the kitchen. He opened the fridge and found leftover pizza from dinner. He ate two slices standing in the dark, feeling like a champion.";

// Call displayStory() with hardcoded title, image filename, and content
displayStory("Midnight Snack", "story4.svg", $content);

// strpos() Demo — finds the position of "pizza" in a hardcoded sentence
$sentence   = "He found pizza in the fridge at midnight.";
$searchWord = "pizza";
$position   = strpos($sentence, $searchWord); // predefined PHP function
?>

<table class="string-demo">
    <tr><td colspan="2">strpos() Demo</td></tr>
    <tr><td>Sentence</td><td><?php echo $sentence; ?></td></tr>
    <tr><td>Search Word</td><td><?php echo $searchWord; ?></td></tr>
    <tr><td>Position Found</td><td><?php echo $position; ?></td></tr>
</table>

<?php
// include() used: footer is optional, page still works without it
include('footer.php');
?>
