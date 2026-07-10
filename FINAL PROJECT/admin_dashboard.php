<?php
$pageTitle = "Seller Part";
require 'functions.php';
requireAdmin();
require 'header.php';

$productCount = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'];
$adminCount = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'admin'")->fetch_assoc()['total'];
$orderCount = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total'];
?>

<div class="panel wide-container">
    <h2>Seller Part Dashboard</h2>
    <div class="message success">Welcome, <?php echo displayText($_SESSION['complete_name']); ?>.</div>

    <div class="dashboard-grid">
        <div class="report-card">
            <h3>Admin Users</h3>
            <p class="lead"><?php echo displayText($adminCount); ?> system admin account(s)</p>
            <a href="admin_users.php" class="button-link">Manage Users</a>
        </div>
        <div class="report-card">
            <h3>Stocks</h3>
            <p class="lead"><?php echo displayText($productCount); ?> clothing product(s)</p>
            <a href="admin_products.php" class="button-link">Manage Stocks</a>
        </div>
        <div class="report-card">
            <h3>Reports</h3>
            <p class="lead"><?php echo displayText($orderCount); ?> order record(s)</p>
            <a href="admin_reports.php" class="button-link">View Reports</a>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>
