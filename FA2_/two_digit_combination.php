<?php
$output = "";

if (isset($_POST["show"])) {
    for ($number = 0; $number <= 99; $number++) {
        $output .= str_pad($number, 2, "0", STR_PAD_LEFT) . ", ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Digit Decimal Combination</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="box wide-box">
        <p><b>Two-Digit Decimal Combination</b></p>

        <form method="post">
            <input type="submit" name="show" value="Show Combinations">
        </form>

        <br>

        <?php if ($output != "") { ?>
            <p><?php echo $output; ?></p>
        <?php } ?>
    </div>
</body>
</html>
