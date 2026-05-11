<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiplication Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            padding: 30px;
            margin: 0;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        h1 {
            text-align: center;
            color: #333333;
            padding: 20px;
            margin: 0 0 30px 0;
            font-size: 2.2em;
            border-bottom: 3px solid #333333;
            letter-spacing: 2px;
        }
        
        .table-wrapper {
            overflow-x: auto;
            text-align: center;
            margin-bottom: 20px;
        }
        
        table {
            border-collapse: collapse;
            margin: 0 auto;
            border: 3px solid #333333;
        }
        
        td {
            width: 55px;
            height: 55px;
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
            font-size: 16px;
            border: 2px solid #333333;
        }
        
        .yellow {
            background-color: #FFD700;
            color: #000000;
        }
        
        .red {
            background-color: #FF6B6B;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Multiplication Table</h1>
        <div class="table-wrapper">
            <table>
                <?php
                // Generate multiplication table with alternating yellow and red colors
                // Using control structures (nested for loops)
                for ($i = 0; $i <= 10; $i++) {
                    echo "<tr>";
                    for ($j = 0; $j <= 10; $j++) {
                        $result = $i * $j;
                        
                        // Alternating color pattern - checkerboard style
                        // Yellow when sum of indices is even, Red when odd
                        if (($i + $j) % 2 == 0) {
                            $colorClass = 'yellow';
                        } else {
                            $colorClass = 'red';
                        }
                        
                        echo "<td class='" . $colorClass . "'>" . $result . "</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
