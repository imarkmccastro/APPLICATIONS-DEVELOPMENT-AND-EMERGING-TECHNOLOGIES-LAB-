<?php
$pageTitle = "The Lost Key";

// require() used: page cannot function without the header
require('header.php');

// require() used: custom functions are essential
require('functions.php');

// Hardcoded arguments passed to displayStory()
$content = "Maria searched everywhere for her key. She checked her coat, her bag, and even the flowerpot by the door. Just as she was about to give up, she felt something cold in her shoe. There it was — the lost key, smiling up at her.";

// Call displayStory() with hardcoded title, image filename, and content
displayStory("The Lost Key", "story1.svg", $content);

// strlen() Demo — counts characters in a hardcoded sentence
$sentence = "Maria searched everywhere for her key.";
$length   = strlen($sentence); // predefined PHP function
?>

<table class="string-demo">
    <tr><td colspan="2">strlen() Demo</td></tr>
    <tr><td>Sentence</td><td><?php echo $sentence; ?></td></tr>
    <tr><td>Character Count</td><td><?php echo $length; ?></td></tr>
</table>

<?php
// include() used: footer is optional, page still works without it
include('footer.php');
?>
