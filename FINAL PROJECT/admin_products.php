<?php
$pageTitle = "Manage Stocks";
require 'functions.php';
requireAdmin();
require 'header.php';

$products = $conn->query("SELECT * FROM products ORDER BY category, name");
?>

<div class="nav-links">
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="admin_product_form.php">Add Stock</a>
    <a href="admin_users.php">Users</a>
    <a href="admin_reports.php">Reports</a>
</div>

<div class="panel wide-container">
    <h2>Stock Management</h2>
    <table>
        <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Price</th>
            <th>Remaining</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $products->fetch_assoc()) { ?>
            <tr>
                <td><?php echo displayText($row['name']); ?></td>
                <td><?php echo displayText($row['category']); ?></td>
                <td><?php echo moneyFormat($row['price']); ?></td>
                <td><?php echo displayText($row['quantity']); ?></td>
                <td><?php echo displayText($row['status']); ?></td>
                <td><a href="admin_product_form.php?id=<?php echo displayText($row['id']); ?>">Modify</a></td>
            </tr>
        <?php } ?>
    </table>
</div>

<?php require 'footer.php'; ?>
