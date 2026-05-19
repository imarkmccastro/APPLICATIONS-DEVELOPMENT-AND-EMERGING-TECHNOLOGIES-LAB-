<?php
$pageTitle = "Work Experience";

$workExperience = array(
    array("position" => "Student Developer",    "company" => "Academic Projects — FEU Institute of Technology", "year" => "2024 - Present"),
    array("position" => "Project Collaborator", "company" => "Group Assignments — BSIT Coursework",             "year" => "2024 - Present"),
    array("position" => "Independent Learner",  "company" => "Self-Study and Lab Exercises",                    "year" => "2025 - Present")
);

require('header.php');
?>

<h2>Work Experience</h2>
<table>
    <tr><th>Position</th><th>Company / Organization</th><th>Year</th></tr>
    <?php foreach ($workExperience as $job) { ?>
    <tr>
        <td><?php echo $job["position"]; ?></td>
        <td><?php echo $job["company"]; ?></td>
        <td><?php echo $job["year"]; ?></td>
    </tr>
    <?php } ?>
</table>

<?php include('footer.php'); ?>
