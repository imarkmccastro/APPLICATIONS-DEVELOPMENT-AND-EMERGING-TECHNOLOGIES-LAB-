<?php
$pageTitle = "Manage Users";
require 'functions.php';
requireAdmin();

$search = trim($_GET['q'] ?? "");
$role = in_array($_GET['role'] ?? "All", array("All", "admin", "buyer")) ? ($_GET['role'] ?? "All") : "All";
$status = in_array($_GET['status'] ?? "All", array("All", "Confirmed", "Pending")) ? ($_GET['status'] ?? "All") : "All";
$searchLike = "%" . $search . "%";
$confirmed = $status == "Confirmed" ? 1 : 0;
$stmt = $conn->prepare("SELECT id, complete_name, email, contact_number, role, email_confirmed, created_at FROM users WHERE (? = '' OR complete_name LIKE ? OR email LIKE ?) AND (? = 'All' OR role = ?) AND (? = 'All' OR email_confirmed = ?) ORDER BY role, complete_name");
$stmt->bind_param("ssssssi", $search, $searchLike, $searchLike, $role, $role, $status, $confirmed);
$stmt->execute();
$users = $stmt->get_result();

require 'header.php';
?>

<div class="nav-links"><a href="admin_dashboard.php">Dashboard</a><a href="admin_user_form.php">Add User</a><a href="admin_products.php">Stocks</a><a href="admin_reports.php">Reports</a></div>

<section class="panel wide-container">
    <div class="section-heading"><div><h2>Admin Users</h2><p class="muted"><?php echo displayText($users->num_rows); ?> account(s) found</p></div><a href="admin_user_form.php" class="button-link">Add User</a></div>
    <form method="GET" action="admin_users.php" class="filter-form admin-filter">
        <div class="form-group"><label for="user-search">Search</label><input id="user-search" type="text" name="q" value="<?php echo displayText($search); ?>" placeholder="Name or email"></div>
        <div class="form-group"><label for="user-role">Role</label><select id="user-role" name="role"><option value="All">All Roles</option><option value="admin" <?php if ($role == 'admin') echo 'selected'; ?>>Admin</option><option value="buyer" <?php if ($role == 'buyer') echo 'selected'; ?>>Buyer</option></select></div>
        <div class="form-group"><label for="user-status">Confirmation</label><select id="user-status" name="status"><option value="All">All Statuses</option><option value="Confirmed" <?php if ($status == 'Confirmed') echo 'selected'; ?>>Confirmed</option><option value="Pending" <?php if ($status == 'Pending') echo 'selected'; ?>>Pending</option></select></div>
        <div class="filter-actions"><button type="submit">Apply</button><a href="admin_users.php" class="button-link secondary-button">Clear</a></div>
    </form>
    <?php if ($users->num_rows == 0) { ?><div class="empty-state"><h3>No users found</h3><p>Clear the filters or try another search.</p></div><?php } else { ?>
        <div class="table-scroll"><table><thead><tr><th>Name</th><th>Email</th><th>Contact</th><th>Role</th><th>Confirmation</th><th>Action</th></tr></thead><tbody>
        <?php while ($row = $users->fetch_assoc()) { ?><tr><td><strong><?php echo displayText($row['complete_name']); ?></strong></td><td><?php echo displayText($row['email']); ?></td><td><?php echo displayText($row['contact_number']); ?></td><td><span class="badge <?php echo $row['role'] == 'admin' ? 'neutral' : 'positive'; ?>"><?php echo displayText(ucfirst($row['role'])); ?></span></td><td><span class="badge <?php echo $row['email_confirmed'] ? 'positive' : 'warning'; ?>"><?php echo $row['email_confirmed'] ? "Confirmed" : "Pending"; ?></span></td><td><a href="admin_user_form.php?id=<?php echo displayText($row['id']); ?>">Modify</a></td></tr><?php } ?>
        </tbody></table></div>
    <?php } ?>
</section>
<?php require 'footer.php'; ?>
