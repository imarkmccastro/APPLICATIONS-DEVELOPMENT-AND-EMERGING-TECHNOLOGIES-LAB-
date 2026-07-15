<?php
$pageTitle = "About BBB";
require 'header.php';

$members = array(
    "Maryclaire Jashley De Jesus",
    "Mark Benedict Castro",
    "Trina Marielle Viloria",
    "Jovs Francis Caburao",
);
?>

<div class="panel wide-container">
    <section class="about-editorial" aria-labelledby="about-title">
        <figure class="about-editorial-visual">
            <img src="BBB/Logo & Theme/Background-1.jpg" alt="BBB models wearing neutral tailored clothing in an open field">
            <figcaption>BBB Editorial &mdash; Built Beyond Basics</figcaption>
        </figure>
        <div class="about-editorial-copy">
            <p class="eyebrow">Our Story</p>
            <span class="about-editorial-rule" aria-hidden="true"></span>
            <h2 id="about-title">About BBB</h2>
            <p class="lead">BBB is a clothing company offering polished wardrobe pieces for men and women. This educational store includes buyer registration, email confirmation, shopping, checkout, stock management, inventory reports, and audit logs.</p>
            <p class="about-signature">Triple B. Atelier</p>
        </div>
    </section>

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
