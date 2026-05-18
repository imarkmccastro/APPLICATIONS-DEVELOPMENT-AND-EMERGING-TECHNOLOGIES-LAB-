<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 1 - Array Display</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="grid-container">
    <div class="header">
        <h1>Task 1: Array with Personal Data</h1>
    </div>

    <div class="main">
        <?php
        // Multidimensional array of 10 people
        $people = array(
            array("name" => "Mark Benedict Castro", "image" => "img/markcastro.jpg", "age" => 20, "birthday" => "2005-10-15", "contact" => "09171234567"),
            array("name" => "Jovs Francis Caburao", "image" => "img/jovscaburao.jpg", "age" => 21, "birthday" => "2005-03-20", "contact" => "09181234567"),
            array("name" => "Andrew De Jesus", "image" => "img/andrewdejesus.jpg", "age" => 21, "birthday" => "2005-01-05", "contact" => "09191234567"),
            array("name" => "Ivan Frondarina", "image" => "img/ivanfrondarina.jpg", "age" => 21, "birthday" => "2005-04-10", "contact" => "09201234567"),
            array("name" => "Pipoy Bagtas", "image" => "img/pipoybagtas.jpg", "age" => 20, "birthday" => "2005-06-25", "contact" => "09211234567"),
            array("name" => "Maryclaire Jashley", "image" => "img/maryclairejashley.jpg", "age" => 20, "birthday" => "2005-09-12", "contact" => "09221234567"),
            array("name" => "Trina Marielle", "image" => "img/trinamarielle.jpg", "age" => 20, "birthday" => "2005-11-08", "contact" => "09231234567"),
            array("name" => "Cedrick Valera", "image" => "img/cedrickvalera.jpg", "age" => 20, "birthday" => "2005-12-30", "contact" => "09241234567"),
            array("name" => "Miles Morales", "image" => "img/milesmorales.jpg", "age" => 21, "birthday" => "2005-02-18", "contact" => "09251234567"),
            array("name" => "Peter Parker", "image" => "img/peterparker.jpg", "age" => 20, "birthday" => "2006-02-14", "contact" => "09261234567")
        );

        // Sort alphabetically by name using usort
        usort($people, function($a, $b) {
            return strcmp($a["name"], $b["name"]);
        });

        // Display using foreach loop in a table
        echo "<table>";
        echo "<tr><th>No.</th><th>Name</th><th>Image</th><th>Age</th><th>Birthday</th><th>Contact</th></tr>";

        $no = 1;
        foreach ($people as $person) {
            echo "<tr>";
            echo "<td>" . $no . "</td>";
            echo "<td>" . $person["name"] . "</td>";
            $no++;
            echo "<td><img src='" . $person["image"] . "' alt='Photo'></td>";
            echo "<td>" . $person["age"] . "</td>";
            echo "<td>" . $person["birthday"] . "</td>";
            echo "<td>" . $person["contact"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        ?>
    </div>

    
</div>

</body>
</html>
