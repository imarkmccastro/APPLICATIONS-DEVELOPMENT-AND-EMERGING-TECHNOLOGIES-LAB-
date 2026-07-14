<?php
$pageTitle = "About BBB";
require 'header.php';

$members = array(
    "Mark Benedict Castro",
    "Jovs Francis Caburao",
    "Andrew De Jesus"
);
?>

<div class="panel wide-container">
    <div class="about-intro">
        <img class="about-logo" src="BBB/JPG Files/BBB - 1.jpg" alt="BBB Main Logo">
        <div>
            <h2>About BBB</h2>
            <p class="lead">BBB is a clothing company offering polished wardrobe pieces for men and women. This educational store includes buyer registration, email confirmation, shopping, checkout, stock management, inventory reports, and audit logs.</p>
        </div>
        <img class="about-lifestyle" src="BBB/JPG Files/BBB - 8.jpg" alt="BBB paisley scarf styled with menswear">
    </div>

    <div class="reports-grid">
        <div class="report-card">
            <h3>Company</h3>
            <p>BBB</p>
        </div>
        <div class="report-card">
            <h3>Group</h3>
            <p>BBB</p>
        </div>
        <div class="report-card">
            <h3>Product</h3>
            <p>Clothing line products and accessories</p>
        </div>
    </div>

    <h3>Group Members</h3>
    <div class="table-scroll">
        <table>
            <thead><tr><th>No.</th><th>Name</th></tr></thead>
            <tbody><?php foreach ($members as $index => $member) { ?>
                <tr><td><?php echo $index + 1; ?></td><td><?php echo displayText($member); ?></td></tr>
            <?php } ?></tbody>
        </table>
    </div>
</div>

<?php require 'footer.php'; ?>
