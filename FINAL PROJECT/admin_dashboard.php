<?php
$pageTitle = "Seller Dashboard";
require 'functions.php';
requireAdmin();

$productCount = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'];
$lowStockCount = $conn->query("SELECT COUNT(*) AS total FROM products WHERE status = 'Active' AND quantity <= 5")->fetch_assoc()['total'];
$adminCount = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'admin'")->fetch_assoc()['total'];
$orderCount = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total'];
$lowStock = $conn->query("SELECT id, name, quantity FROM products WHERE status = 'Active' AND quantity <= 5 ORDER BY quantity, name LIMIT 6");
$recentLogs = $conn->query("SELECT user_name, activity, created_at FROM audit_logs ORDER BY created_at DESC, id DESC LIMIT 8");

require 'header.php';
?>

<div class="nav-links"><a href="admin_users.php">Users</a><a href="admin_products.php">Stocks</a><a href="admin_reports.php">Reports</a></div>

<section class="panel wide-container dashboard-panel">
    <div class="section-heading"><div><h2>Seller Dashboard</h2><p class="muted">Inventory, account, order, and activity overview.</p></div><span class="badge positive">Administrator</span></div>
    <div class="dashboard-grid metric-grid">
        <a class="report-card metric-card" href="admin_products.php"><span>Products</span><strong><?php echo displayText($productCount); ?></strong><small>Manage stock catalog</small></a>
        <a class="report-card metric-card" href="admin_products.php?stock=low"><span>Low Stock</span><strong><?php echo displayText($lowStockCount); ?></strong><small>Five items or fewer</small></a>
        <a class="report-card metric-card" href="admin_users.php?role=admin"><span>Admin Users</span><strong><?php echo displayText($adminCount); ?></strong><small>System administrators</small></a>
        <a class="report-card metric-card" href="admin_reports.php"><span>Orders</span><strong><?php echo displayText($orderCount); ?></strong><small>Submitted checkouts</small></a>
    </div>
</section>

<div class="admin-summary-grid">
    <section class="panel compact-section">
        <div class="section-heading"><h2>Low Stock</h2><a href="admin_products.php?stock=low" class="text-link">View Stocks</a></div>
        <?php if ($lowStock->num_rows == 0) { ?><div class="empty-state compact-empty"><p>All active products have more than five items.</p></div><?php } else { ?>
            <div class="list-stack"><?php while ($row = $lowStock->fetch_assoc()) { ?><a href="admin_product_form.php?id=<?php echo displayText($row['id']); ?>"><span><?php echo displayText($row['name']); ?></span><span class="badge <?php echo statusClass(stockLabel($row['quantity'])); ?>"><?php echo displayText($row['quantity']); ?> left</span></a><?php } ?></div>
        <?php } ?>
    </section>
    <section class="panel compact-section">
        <div class="section-heading"><h2>Recent Activity</h2><a href="admin_reports.php" class="text-link">View Audit Log</a></div>
        <div class="activity-list"><?php while ($row = $recentLogs->fetch_assoc()) { ?><div><strong><?php echo displayText($row['user_name']); ?></strong><span><?php echo displayText($row['activity']); ?></span><small><?php echo displayText(date("M d, h:i A", strtotime($row['created_at']))); ?></small></div><?php } ?></div>
    </section>
</div>

<?php require 'footer.php'; ?>
