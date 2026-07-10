<?php
$pageTitle = "Manage Stocks";
require 'functions.php';
requireAdmin();

$categories = array("All", "Men Tops", "Women Tops", "Bottoms", "Dresses", "Outerwear", "Accessories");
$search = trim($_GET['q'] ?? "");
$category = in_array($_GET['category'] ?? "All", $categories) ? ($_GET['category'] ?? "All") : "All";
$status = in_array($_GET['status'] ?? "All", array("All", "Active", "Inactive")) ? ($_GET['status'] ?? "All") : "All";
$stock = in_array($_GET['stock'] ?? "All", array("All", "in", "low", "out")) ? ($_GET['stock'] ?? "All") : "All";
$searchLike = "%" . $search . "%";
$stmt = $conn->prepare("SELECT * FROM products WHERE (? = '' OR name LIKE ? OR description LIKE ?) AND (? = 'All' OR category = ?) AND (? = 'All' OR status = ?) AND (? = 'All' OR (? = 'in' AND quantity > 5) OR (? = 'low' AND quantity BETWEEN 1 AND 5) OR (? = 'out' AND quantity = 0)) ORDER BY category, name");
$stmt->bind_param("sssssssssss", $search, $searchLike, $searchLike, $category, $category, $status, $status, $stock, $stock, $stock, $stock);
$stmt->execute();
$products = $stmt->get_result();

require 'header.php';
?>
<div class="nav-links"><a href="admin_dashboard.php">Dashboard</a><a href="admin_product_form.php">Add Stock</a><a href="admin_users.php">Users</a><a href="admin_reports.php">Reports</a></div>
<section class="panel wide-container">
    <div class="section-heading"><div><h2>Stock Management</h2><p class="muted"><?php echo displayText($products->num_rows); ?> product(s) found</p></div><a href="admin_product_form.php" class="button-link">Add Stock</a></div>
    <form method="GET" action="admin_products.php" class="filter-form product-admin-filter">
        <div class="form-group"><label for="stock-search">Search</label><input id="stock-search" type="text" name="q" value="<?php echo displayText($search); ?>" placeholder="Product or description"></div>
        <div class="form-group"><label for="stock-category">Category</label><select id="stock-category" name="category"><?php foreach ($categories as $item) { ?><option value="<?php echo displayText($item); ?>" <?php if ($category == $item) echo 'selected'; ?>><?php echo $item == 'All' ? 'All Categories' : displayText($item); ?></option><?php } ?></select></div>
        <div class="form-group"><label for="stock-status">Status</label><select id="stock-status" name="status"><option value="All">All Statuses</option><option value="Active" <?php if ($status == 'Active') echo 'selected'; ?>>Active</option><option value="Inactive" <?php if ($status == 'Inactive') echo 'selected'; ?>>Inactive</option></select></div>
        <div class="form-group"><label for="stock-level">Stock Level</label><select id="stock-level" name="stock"><option value="All">All Levels</option><option value="in" <?php if ($stock == 'in') echo 'selected'; ?>>In Stock</option><option value="low" <?php if ($stock == 'low') echo 'selected'; ?>>Low Stock</option><option value="out" <?php if ($stock == 'out') echo 'selected'; ?>>Out of Stock</option></select></div>
        <div class="filter-actions"><button type="submit">Apply</button><a href="admin_products.php" class="button-link secondary-button">Clear</a></div>
    </form>
    <?php if ($products->num_rows == 0) { ?><div class="empty-state"><h3>No products found</h3><p>Clear the filters or try another search.</p></div><?php } else { ?>
        <div class="table-scroll"><table><thead><tr><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Action</th></tr></thead><tbody>
        <?php while ($row = $products->fetch_assoc()) { ?><tr><td><div class="product-cell"><img src="<?php echo displayText($row['image']); ?>" alt=""><span><strong><?php echo displayText($row['name']); ?></strong><small><?php echo displayText($row['description']); ?></small></span></div></td><td><?php echo displayText($row['category']); ?></td><td><?php echo moneyFormat($row['price']); ?></td><td><span class="badge <?php echo statusClass(stockLabel($row['quantity'])); ?>"><?php echo displayText($row['quantity']); ?> - <?php echo displayText(stockLabel($row['quantity'])); ?></span></td><td><span class="badge <?php echo statusClass($row['status']); ?>"><?php echo displayText($row['status']); ?></span></td><td><a href="admin_product_form.php?id=<?php echo displayText($row['id']); ?>">Modify</a></td></tr><?php } ?>
        </tbody></table></div>
    <?php } ?>
</section>
<?php require 'footer.php'; ?>
