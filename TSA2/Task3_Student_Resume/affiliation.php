<?php
$pageTitle = "Affiliation";

$affiliations = array(
    array("org" => "AITS (Alliance of Information and Technology Students)", "position" => "Member", "year" => "2024 - Present")
);

require('header.php');
?>

<h2>Affiliation</h2>
<table>
    <tr><th>Organization</th><th>Position</th><th>Year</th></tr>
    <?php foreach ($affiliations as $aff) { ?>
    <tr>
        <td><?php echo $aff["org"]; ?></td>
        <td><?php echo $aff["position"]; ?></td>
        <td><?php echo $aff["year"]; ?></td>
    </tr>
    <?php } ?>
</table>

<?php include('footer.php'); ?>
