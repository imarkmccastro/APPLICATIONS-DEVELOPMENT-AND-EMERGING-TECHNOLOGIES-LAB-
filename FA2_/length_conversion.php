<?php
$meter = 1;

if (isset($_POST["meter"])) {
    $meter = $_POST["meter"];
}

$centimeter = $meter * 100;
$millimeter = $meter * 1000;
$kilometer = $meter / 1000;
$inch = $meter * 39.3701;
$foot = $meter * 3.28084;
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

        <form method="post" class="conversion-form">
            <label>Enter meter:</label>
            <input type="number" name="meter" step="0.01" value="<?php echo $meter; ?>">
            <input type="submit" value="Convert">
        </form>

        <div class="result-list">
            <p><?php echo $meter; ?> meter = <span><?php echo $centimeter; ?> centimeter</span></p>
            <p><?php echo $meter; ?> meter = <span><?php echo $millimeter; ?> millimeter</span></p>
            <p><?php echo $meter; ?> meter = <span><?php echo $kilometer; ?> kilometer</span></p>
            <p><?php echo $meter; ?> meter = <span><?php echo number_format($inch, 4); ?> inches</span></p>
            <p><?php echo $meter; ?> meter = <span><?php echo number_format($foot, 4); ?> feet</span></p>
        </div>
    </div>

    <div class="box formula-box">
        <h2>Formula Used</h2>
        <p>Centimeter = meter * 100</p>
        <p>Millimeter = meter * 1000</p>
        <p>Kilometer = meter / 1000</p>
        <p>Inches = meter * 39.3701</p>
        <p>Feet = meter * 3.28084</p>
    </div>
</body>
</html>
