<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 2 - String Functions</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="grid-container">

    <div class="header">
        <h1>Task 2: String Functions</h1>
    </div>

    <div class="main">
        <h2 style="text-align:center;">List of Names</h2>

        <?php
        // Array of 20 hardcoded names
        $names = [
            "chrisa", "benjamin", "maria", "joshua", "elena",
            "patrick", "sophia", "daniel", "isabella", "michael",
            "olivia", "samuel", "natalie", "andrew", "victoria",
            "thomas", "amanda", "nicholas", "stephanie", "jonathan"
        ];

        echo "<table class='names-table'>";
        echo "<tr>
                <th>Name</th>
                <th>Number of characters</th>
                <th>Uppercase first character</th>
                <th>Replace vowels with @</th>
                <th>Check position of character \"a\"</th>
                <th>Reverse name</th>
              </tr>";

        // Loop through each name and apply string functions
        foreach ($names as $name) {

            // strlen() — number of characters including spaces (none here, but counts all chars)
            $charCount = strlen($name);

            // ucfirst() — capitalize the first character
            $upperFirst = ucfirst($name);

            // str_replace() — replace all vowels with @
            $replaceVowels = str_replace(['a','e','i','o','u'], '@', $name);

            // strpos() — find position of first "a"; false if not found
            $posA = strpos($name, 'a');
            $posDisplay = ($posA !== false) ? $posA : "—";

            // strrev() — reverse the name
            $reversed = strrev($name);

            echo "<tr>";
            echo "<td>" . $name . "</td>";
            echo "<td>" . $charCount . "</td>";
            echo "<td>" . $upperFirst . "</td>";
            echo "<td>" . $replaceVowels . "</td>";
            echo "<td>" . $posDisplay . "</td>";
            echo "<td>" . $reversed . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        ?>
    </div>


</div>
</body>
</html>
