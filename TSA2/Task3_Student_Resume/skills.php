<?php
$pageTitle = "Skills";

$skills = array(
    array("skill" => "HTML5 and CSS3",       "level" => "Intermediate"),
    array("skill" => "PHP Programming",      "level" => "Intermediate"),
    array("skill" => "JavaScript",           "level" => "Basic"),
    array("skill" => "Python",               "level" => "Basic"),
    array("skill" => "MySQL Database",       "level" => "Basic"),
    array("skill" => "Responsive Web Design","level" => "Intermediate")
);

require('header.php');
?>

<h2>Skills</h2>
<table>
    <tr><th>Technical Skills</th><th>Level</th></tr>
    <?php foreach ($skills as $s) { ?>
    <tr>
        <td><?php echo $s["skill"]; ?></td>
        <td><?php echo $s["level"]; ?></td>
    </tr>
    <?php } ?>
</table>

<?php include('footer.php'); ?>
