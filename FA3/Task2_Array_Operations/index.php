<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 2 - Array Operations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="grid-container">
    <div class="header">
        <h1>Task 2: Array Math Operations</h1>
    </div>

    <div class="main">
        <?php
        // Array of 10 numbers
        $numbers = array(1, 2, 3, 4, 5, 6, 7, 8, 10);

        // Calculate Sum
        $sum = 0;
        foreach ($numbers as $num) {
            $sum = $sum + $num;
        }

        // Calculate Difference (start with first, subtract the rest)
        $difference = $numbers[0];
        for ($i = 1; $i < count($numbers); $i++) {
            $difference = $difference - $numbers[$i];
        }

        // Calculate Product
        $product = 1;
        foreach ($numbers as $num) {
            $product = $product * $num;
        }

        // Calculate Quotient (start with first, divide by rest, skip zero)
        $quotient = $numbers[0];
        for ($i = 1; $i < count($numbers); $i++) {
            if ($numbers[$i] != 0) {
                $quotient = $quotient / $numbers[$i];
            }
        }

        // Display results in a table
        echo "<table>";
        echo "<tr><td colspan='2' class='array-list'><strong>Array list:</strong> " . implode(", ", $numbers) . "</td></tr>";
        echo "<tr><td>Addition</td><td>" . $sum . "</td></tr>";
        echo "<tr><td>Subtraction</td><td>" . $difference . "</td></tr>";
        echo "<tr><td>Multiplication</td><td>" . $product . "</td></tr>";
        echo "<tr><td>Division</td><td>" . $quotient . "</td></tr>";
        echo "</table>";
        ?>
    </div>

</div>

</body>
</html>
