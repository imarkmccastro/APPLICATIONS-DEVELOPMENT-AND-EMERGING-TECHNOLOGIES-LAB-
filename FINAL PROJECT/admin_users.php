<?php
$pageTitle = "Manage Users";
require 'functions.php';
requireAdmin();
require 'header.php';

$users = $conn->query("SELECT id, complete_name, email, contact_number, role, email_confirmed, created_at FROM users ORDER BY role, complete_name");
?>

<div class="nav-links">
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="admin_user_form.php">Add User</a>
    <a href="admin_products.php">Stocks</a>
    <a href="admin_reports.php">Reports</a>
</div>

<div class="panel wide-container">
    <h2>System Admin Page</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Role</th>
            <th>Confirmed</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $users->fetch_assoc()) { ?>
            <tr>
                <td><?php echo displayText($row['complete_name']); ?></td>
                <td><?php echo displayText($row['email']); ?></td>
                <td><?php echo displayText($row['contact_number']); ?></td>
                <td><?php echo displayText($row['role']); ?></td>
                <td><?php echo $row['email_confirmed'] ? "Yes" : "No"; ?></td>
                <td><a href="admin_user_form.php?id=<?php echo displayText($row['id']); ?>">Modify</a></td>
            </tr>
        <?php } ?>
    </table>
</div>

<?php require 'footer.php'; ?>
