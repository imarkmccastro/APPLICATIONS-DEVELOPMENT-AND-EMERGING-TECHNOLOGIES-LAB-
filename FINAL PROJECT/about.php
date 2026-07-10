<?php
$pageTitle = "About ThreadLine";
require 'header.php';

$members = array(
    "Mark Benedict Castro",
    "Jovs Francis Caburao",
    "Andrew De Jesus",
    "Ivan Frondarina",
    "Cedrick Valera"
);
?>

<div class="panel wide-container">
    <h2>About Page</h2>
    <p class="lead">ThreadLine Clothing is a sample company website that sells clothing line products for school project purposes. The buyer side includes account registration, email confirmation, store browsing, cart, checkout, and a simple payment page. The seller side includes admin users, stock management, inventory reporting, and audit logs.</p>

    <div class="reports-grid">
        <div class="report-card">
            <h3>Company</h3>
            <p>ThreadLine Clothing</p>
        </div>
        <div class="report-card">
            <h3>Group</h3>
            <p>2ND3T Tech Group</p>
        </div>
        <div class="report-card">
            <h3>Product</h3>
            <p>Clothing line products and accessories</p>
        </div>
    </div>

    <h3>Group Members</h3>
    <table>
        <tr><th>No.</th><th>Name</th></tr>
        <?php foreach ($members as $index => $member) { ?>
            <tr><td><?php echo $index + 1; ?></td><td><?php echo displayText($member); ?></td></tr>
        <?php } ?>
    </table>
</div>

<?php require 'footer.php'; ?>
