<?php
$pageTitle = "Personal Information";

$fullName      = "Mark Benedict Castro";
$dateOfBirth   = "October 15, 2005";
$age           = "20";
$gender        = "Male";
$nationality   = "Filipino";
$religion      = "Roman Catholic";
$address       = "Manila, Philippines";
$contactNumber = "+63 912 345 6789";
$emailAddress  = "mark.benedict.castro@gmail.com";

require('header.php');
?>

<h2>Personal Information</h2>
<table>
    <tr><th>Full Name</th><td><?php echo $fullName; ?></td></tr>
    <tr><th>Date of Birth</th><td><?php echo $dateOfBirth; ?></td></tr>
    <tr><th>Age</th><td><?php echo $age; ?></td></tr>
    <tr><th>Gender</th><td><?php echo $gender; ?></td></tr>
    <tr><th>Nationality</th><td><?php echo $nationality; ?></td></tr>
    <tr><th>Religion</th><td><?php echo $religion; ?></td></tr>
    <tr><th>Address</th><td><?php echo $address; ?></td></tr>
    <tr><th>Contact Number</th><td><?php echo $contactNumber; ?></td></tr>
    <tr><th>Email Address</th><td><?php echo $emailAddress; ?></td></tr>
</table>

<?php include('footer.php'); ?>
