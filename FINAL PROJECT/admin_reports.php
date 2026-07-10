<?php
$pageTitle = "Reports";
require 'functions.php';
requireAdmin();
require 'header.php';

$inventory = $conn->query("SELECT name, category, price, quantity, status FROM products ORDER BY quantity ASC, name");
$logs = $conn->query("SELECT * FROM audit_logs ORDER BY created_at DESC, id DESC LIMIT 50");
?>

<div class="nav-links">
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="admin_users.php">Users</a>
    <a href="admin_products.php">Stocks</a>
</div>

<div class="panel wide-container">
    <h2>Inventory Report</h2>
    <table>
        <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Price</th>
            <th>Remaining Items</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $inventory->fetch_assoc()) { ?>
            <tr>
                <td><?php echo displayText($row['name']); ?></td>
                <td><?php echo displayText($row['category']); ?></td>
                <td><?php echo moneyFormat($row['price']); ?></td>
                <td><?php echo displayText($row['quantity']); ?></td>
                <td><?php echo displayText($row['status']); ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

<div class="panel wide-container">
    <h2>Audit Log Report</h2>
    <table>
        <tr>
            <th>Date and Time</th>
            <th>User</th>
            <th>Activity</th>
        </tr>
        <?php while ($row = $logs->fetch_assoc()) { ?>
            <tr>
                <td><?php echo displayText($row['created_at']); ?></td>
                <td><?php echo displayText($row['user_name']); ?></td>
                <td><?php echo displayText($row['activity']); ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

<?php require 'footer.php'; ?>
