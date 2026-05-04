<?php
$meter = 1;
$kilometer = 1;
$centimeter = 1;
$millimeter = 1;
$inch = 1;
$foot = 1;
$yard = 1;
$mile = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Length Conversion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="box conversion-box">
        <h2>Length Conversion</h2>

        <h3>Metric Conversions</h3>
        <table class="conversion-table">
            <tr>
                <th>Given</th>
                <th>Formula</th>
                <th>Answer</th>
            </tr>
            <tr>
                <td><?php echo $meter; ?> meter</td>
                <td>meter * 100</td>
                <td><?php echo $meter * 100; ?> centimeter</td>
            </tr>
            <tr>
                <td><?php echo $meter; ?> meter</td>
                <td>meter * 1000</td>
                <td><?php echo $meter * 1000; ?> millimeter</td>
            </tr>
            <tr>
                <td><?php echo $kilometer; ?> kilometer</td>
                <td>kilometer * 1000</td>
                <td><?php echo $kilometer * 1000; ?> meter</td>
            </tr>
            <tr>
                <td><?php echo $centimeter; ?> centimeter</td>
                <td>centimeter / 100</td>
                <td><?php echo $centimeter / 100; ?> meter</td>
            </tr>
            <tr>
                <td><?php echo $millimeter; ?> millimeter</td>
                <td>millimeter / 1000</td>
                <td><?php echo $millimeter / 1000; ?> meter</td>
            </tr>
        </table>

        <h3>Imperial Conversions</h3>
        <table class="conversion-table">
            <tr>
                <th>Given</th>
                <th>Formula</th>
                <th>Answer</th>
            </tr>
            <tr>
                <td><?php echo $foot; ?> foot</td>
                <td>foot * 12</td>
                <td><?php echo $foot * 12; ?> inches</td>
            </tr>
            <tr>
                <td><?php echo $yard; ?> yard</td>
                <td>yard * 3</td>
                <td><?php echo $yard * 3; ?> feet</td>
            </tr>
            <tr>
                <td><?php echo $mile; ?> mile</td>
                <td>mile * 5280</td>
                <td><?php echo $mile * 5280; ?> feet</td>
            </tr>
            <tr>
                <td><?php echo $foot; ?> foot</td>
                <td>foot / 3</td>
                <td><?php echo number_format($foot / 3, 4); ?> yard</td>
            </tr>
        </table>

        <h3>Metric to Imperial Conversions</h3>
        <table class="conversion-table">
            <tr>
                <th>Given</th>
                <th>Formula</th>
                <th>Answer</th>
            </tr>
            <tr>
                <td><?php echo $meter; ?> meter</td>
                <td>meter * 39.3701</td>
                <td><?php echo number_format($meter * 39.3701, 4); ?> inches</td>
            </tr>
            <tr>
                <td><?php echo $meter; ?> meter</td>
                <td>meter * 3.28084</td>
                <td><?php echo number_format($meter * 3.28084, 4); ?> feet</td>
            </tr>
            <tr>
                <td><?php echo $kilometer; ?> kilometer</td>
                <td>kilometer * 0.621371</td>
                <td><?php echo number_format($kilometer * 0.621371, 4); ?> miles</td>
            </tr>
        </table>

        <h3>Imperial to Metric Conversions</h3>
        <table class="conversion-table">
            <tr>
                <th>Given</th>
                <th>Formula</th>
                <th>Answer</th>
            </tr>
            <tr>
                <td><?php echo $inch; ?> inch</td>
                <td>inch * 2.54</td>
                <td><?php echo $inch * 2.54; ?> centimeters</td>
            </tr>
            <tr>
                <td><?php echo $foot; ?> foot</td>
                <td>foot * 0.3048</td>
                <td><?php echo $foot * 0.3048; ?> meter</td>
            </tr>
            <tr>
                <td><?php echo $mile; ?> mile</td>
                <td>mile * 1.60934</td>
                <td><?php echo number_format($mile * 1.60934, 4); ?> kilometers</td>
            </tr>
        </table>
    </div>
</body>
</html>
