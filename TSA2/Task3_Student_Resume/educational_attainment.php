<?php
$pageTitle = "Educational Attainment";

$education = array(
    array("level" => "Tertiary",  "school" => "FEU Institute of Technology — BSIT",          "year" => "2024 - Present"),
    array("level" => "Secondary", "school" => "Columban College - Barretto",                  "year" => "2022 - 2024"),
    array("level" => "Primary",   "school" => "International Philippine School in Al-Khobar", "year" => "2012 - 2016")
);

require('header.php');
?>

<h2>Educational Attainment</h2>
<table>
    <tr><th>Level</th><th>School</th><th>Year</th></tr>
    <?php foreach ($education as $ed) { ?>
    <tr>
        <td><?php echo $ed["level"]; ?></td>
        <td><?php echo $ed["school"]; ?></td>
        <td><?php echo $ed["year"]; ?></td>
    </tr>
    <?php } ?>
</table>

<?php include('footer.php'); ?>
