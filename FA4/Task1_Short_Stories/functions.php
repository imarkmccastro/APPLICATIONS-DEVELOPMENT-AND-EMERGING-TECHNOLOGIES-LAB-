<?php

// Custom function to display a short story with a title, image, and content paragraph.
// Parameters: $title (string), $image (string) — image filename, $content (string).
function displayStory($title, $image, $content) {
    echo "<div class='story-box'>";
    echo "<img src='img/" . $image . "' alt='" . $title . "'>";
    echo "<h2>" . $title . "</h2>";
    echo "<p>" . $content . "</p>";
    echo "</div>";
}

// Custom function to format text in multiple ways.
// Parameter: $text (string) — the input text to format.
// Returns an associative array with keys: uppercase, replaced, reversed.
function formatText($text) {
    return [
        'uppercase' => strtoupper($text),
        'replaced'  => str_replace(' ', '_', $text),
        'reversed'  => strrev($text)
    ];
}

// Custom function to count characters in a string using strlen().
// Parameter: $str (string) — the string to measure.
// Returns a formatted result string.
function countChars($str) {
    $count = strlen($str);
    return "The string \"$str\": $count characters.";
}
