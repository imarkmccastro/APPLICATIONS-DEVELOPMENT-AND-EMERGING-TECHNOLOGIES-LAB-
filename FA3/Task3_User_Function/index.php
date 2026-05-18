<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 3 - User Defined Function</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="grid-container">
    <div class="header">
        <h1>Task 3: User-Defined Function</h1>
    </div>

    <div class="main">
        <?php
        // User-defined function with 3 parameters
        function calculate($a, $b, $c) {
            // Calculate sum
            $sum = $a + $b + $c;

            // Calculate difference
            $difference = $a - $b - $c;

            // Calculate product
            $product = $a * $b * $c;

            // Calculate quotient (check for zero)
            if ($b != 0 && $c != 0) {
                $quotient = $a / $b / $c;
            } else {
                $quotient = "Cannot divide by zero";
            }

            // Return results as array
            $results = array(
                "sum" => $sum,
                "difference" => $difference,
                "product" => $product,
                "quotient" => $quotient
            );

            return $results;
        }

        // Call the function with sample values
        $a = 25;
        $b = 13;
        $c = 6;
        $results = calculate($a, $b, $c);

        // Display results in a table
        echo "<table border='1'>";
        echo "<tr><td colspan='2' class='array-list'><strong>My Parameter Values:</strong> $a, $b, $c</td></tr>";
        echo "<tr><td>Addition</td><td>" . $results["sum"] . "</td></tr>";
        echo "<tr><td>Subtraction</td><td>" . $results["difference"] . "</td></tr>";
        echo "<tr><td>Multiplication</td><td>" . $results["product"] . "</td></tr>";
        echo "<tr><td>Division</td><td>" . $results["quotient"] . "</td></tr>";
        echo "</table>";
        ?>
    </div>

</div>

</body>
</html>
