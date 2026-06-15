<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 1 - Fruit Directory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="grid-container">
    <div class="header">
        <h1>My Fruits</h1>
    </div>

    <div class="main">
        <?php
        $fruits = array(
            array("name" => "Apple",      "image" => "img/apple.svg",      "description" => "Color: Red",    "facts" => "Apples are rich in fiber and vitamin C, and are one of the most popular fruits worldwide."),
            array("name" => "Banana",     "image" => "img/banana.svg",     "description" => "Color: Yellow", "facts" => "Bananas are a healthful addition to a balanced diet, as they provide a range of vital nutrients and are a good source of fiber."),
            array("name" => "Cherry",     "image" => "img/cherry.svg",     "description" => "Color: Red",    "facts" => "Cherries are packed with antioxidants and anti-inflammatory compounds that may reduce chronic disease risk."),
            array("name" => "Durian",     "image" => "img/durian.svg",     "description" => "Color: Green",  "facts" => "Durian is known as the king of fruits in Southeast Asia and is rich in healthy fats and vitamins."),
            array("name" => "Grape",      "image" => "img/grape.svg",      "description" => "Color: Purple", "facts" => "Grapes contain powerful antioxidants known as polyphenols, which may slow or prevent many types of cancer."),
            array("name" => "Mango",      "image" => "img/mango.svg",      "description" => "Color: Orange", "facts" => "Mangoes are high in vitamins, minerals, and antioxidants, and have been associated with many health benefits."),
            array("name" => "Orange",     "image" => "img/orange.svg",     "description" => "Color: Orange", "facts" => "Oranges are an excellent source of vitamin C, which is important for immune system function."),
            array("name" => "Papaya",     "image" => "img/papaya.svg",     "description" => "Color: Orange", "facts" => "Papayas contain an enzyme called papain that aids digestion and has anti-inflammatory properties."),
            array("name" => "Strawberry", "image" => "img/strawberry.svg", "description" => "Color: Red",    "facts" => "Strawberries are loaded with vitamins, fiber, and particularly high levels of antioxidants known as polyphenols."),
            array("name" => "Watermelon", "image" => "img/watermelon.svg", "description" => "Color: Green",  "facts" => "Watermelon is 92% water and contains vitamins A, B6, and C, as well as lycopene and amino acids.")
        );

        usort($fruits, function($a, $b) {
            return strcmp($a["name"], $b["name"]);
        });
        ?>

        <table>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Facts</th>
            </tr>
            <?php foreach ($fruits as $fruit) { ?>
            <tr>
                <td><img src="<?php echo $fruit["image"]; ?>" alt="<?php echo $fruit["name"]; ?>"></td>
                <td><?php echo $fruit["name"]; ?></td>
                <td><?php echo $fruit["description"]; ?></td>
                <td><?php echo $fruit["facts"]; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>

</div>

</body>
</html>
