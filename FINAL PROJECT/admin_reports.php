<?php
$pageTitle = "Reports";
require 'functions.php';
requireAdmin();

$categories = array("All", "Men Tops", "Women Tops", "Bottoms", "Dresses", "Outerwear", "Accessories");
$search = trim($_GET['q'] ?? "");
$category = in_array($_GET['category'] ?? "All", $categories) ? ($_GET['category'] ?? "All") : "All";
$status = in_array($_GET['status'] ?? "All", array("All", "Active", "Inactive")) ? ($_GET['status'] ?? "All") : "All";
$stock = in_array($_GET['stock'] ?? "All", array("All", "in", "low", "out")) ? ($_GET['stock'] ?? "All") : "All";
$searchLike = "%" . $search . "%";
$stmt = $conn->prepare("SELECT id, name, category, price, quantity, status FROM products WHERE (? = '' OR name LIKE ? OR description LIKE ?) AND (? = 'All' OR category = ?) AND (? = 'All' OR status = ?) AND (? = 'All' OR (? = 'in' AND quantity > 5) OR (? = 'low' AND quantity BETWEEN 1 AND 5) OR (? = 'out' AND quantity = 0)) ORDER BY quantity, name");
$stmt->bind_param("sssssssssss", $search, $searchLike, $searchLike, $category, $category, $status, $status, $stock, $stock, $stock, $stock);
$stmt->execute();
$inventory = $stmt->get_result();

$logSearch = trim($_GET['log_q'] ?? "");
$logUser = trim($_GET['log_user'] ?? "All");
$logLike = "%" . $logSearch . "%";
$stmt = $conn->prepare("SELECT * FROM audit_logs WHERE (? = '' OR user_name LIKE ? OR activity LIKE ?) AND (? = 'All' OR user_name = ?) ORDER BY created_at DESC, id DESC LIMIT 50");
$stmt->bind_param("sssss", $logSearch, $logLike, $logLike, $logUser, $logUser);
$stmt->execute();
$logs = $stmt->get_result();
$logUsers = $conn->query("SELECT DISTINCT user_name FROM audit_logs ORDER BY user_name");

require 'header.php';
?>
<div class="nav-links"><a href="admin_dashboard.php">Dashboard</a><a href="admin_users.php">Users</a><a href="admin_products.php">Stocks</a></div>
<section class="panel wide-container report-section">
    <div class="section-heading"><div><h2>Inventory Report</h2><p class="muted"><?php echo displayText($inventory->num_rows); ?> product(s) shown</p></div></div>
    <form method="GET" action="admin_reports.php" class="filter-form product-admin-filter">
        <div class="form-group"><label for="report-search">Search</label><input id="report-search" type="text" name="q" value="<?php echo displayText($search); ?>" placeholder="Product or description"></div>
        <div class="form-group"><label for="report-category">Category</label><select id="report-category" name="category"><?php foreach ($categories as $item) { ?><option value="<?php echo displayText($item); ?>" <?php if ($category == $item) echo 'selected'; ?>><?php echo $item == 'All' ? 'All Categories' : displayText($item); ?></option><?php } ?></select></div>
        <div class="form-group"><label for="report-status">Status</label><select id="report-status" name="status"><option value="All">All Statuses</option><option value="Active" <?php if ($status == 'Active') echo 'selected'; ?>>Active</option><option value="Inactive" <?php if ($status == 'Inactive') echo 'selected'; ?>>Inactive</option></select></div>
        <div class="form-group"><label for="report-stock">Stock</label><select id="report-stock" name="stock"><option value="All">All Levels</option><option value="in" <?php if ($stock == 'in') echo 'selected'; ?>>In Stock</option><option value="low" <?php if ($stock == 'low') echo 'selected'; ?>>Low Stock</option><option value="out" <?php if ($stock == 'out') echo 'selected'; ?>>Out of Stock</option></select></div>
        <div class="filter-actions"><button type="submit">Apply</button><a href="admin_reports.php" class="button-link secondary-button">Clear</a></div>
    </form>
    <div class="table-scroll"><table><thead><tr><th>Product</th><th>Category</th><th>Price</th><th>Remaining</th><th>Status</th><th>Action</th></tr></thead><tbody><?php while ($row = $inventory->fetch_assoc()) { ?><tr><td><strong><?php echo displayText($row['name']); ?></strong></td><td><?php echo displayText($row['category']); ?></td><td><?php echo moneyFormat($row['price']); ?></td><td><span class="badge <?php echo statusClass(stockLabel($row['quantity'])); ?>"><?php echo displayText($row['quantity']); ?> - <?php echo displayText(stockLabel($row['quantity'])); ?></span></td><td><span class="badge <?php echo statusClass($row['status']); ?>"><?php echo displayText($row['status']); ?></span></td><td><a href="admin_product_form.php?id=<?php echo displayText($row['id']); ?>">Modify Stock</a></td></tr><?php } ?></tbody></table></div>
</section>
<section class="panel wide-container report-section">
    <div class="section-heading"><div><h2>Audit Log Report</h2><p class="muted">Most recent 50 matching activities</p></div></div>
    <form method="GET" action="admin_reports.php" class="filter-form audit-filter">
        <input type="hidden" name="q" value="<?php echo displayText($search); ?>"><input type="hidden" name="category" value="<?php echo displayText($category); ?>"><input type="hidden" name="status" value="<?php echo displayText($status); ?>"><input type="hidden" name="stock" value="<?php echo displayText($stock); ?>">
        <div class="form-group"><label for="log-search">Search Activity</label><input id="log-search" type="text" name="log_q" value="<?php echo displayText($logSearch); ?>" placeholder="User or activity"></div>
        <div class="form-group"><label for="log-user">User</label><select id="log-user" name="log_user"><option value="All">All Users</option><?php while ($row = $logUsers->fetch_assoc()) { ?><option value="<?php echo displayText($row['user_name']); ?>" <?php if ($logUser == $row['user_name']) echo 'selected'; ?>><?php echo displayText($row['user_name']); ?></option><?php } ?></select></div>
        <div class="filter-actions"><button type="submit">Apply</button><a href="admin_reports.php" class="button-link secondary-button">Clear</a></div>
    </form>
    <?php if ($logs->num_rows == 0) { ?><div class="empty-state compact-empty"><p>No audit activities match the filters.</p></div><?php } else { ?><div class="table-scroll"><table><thead><tr><th>Date and Time</th><th>User</th><th>Activity</th></tr></thead><tbody><?php while ($row = $logs->fetch_assoc()) { ?><tr><td><?php echo displayText(date("M d, Y - h:i A", strtotime($row['created_at']))); ?></td><td><strong><?php echo displayText($row['user_name']); ?></strong></td><td><?php echo displayText($row['activity']); ?></td></tr><?php } ?></tbody></table></div><?php } ?>
</section>
<?php require 'footer.php'; ?>
