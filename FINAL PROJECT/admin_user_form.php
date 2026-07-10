<?php
require 'functions.php';
requireAdmin();

$id = (int)($_GET['id'] ?? 0);
$editing = $id > 0;
$message = "";
$user = array("complete_name" => "", "email" => "", "password" => "", "address" => "", "contact_number" => "", "role" => "admin", "email_confirmed" => 1);

if ($editing) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $record = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$record) {
        setFlashMessage("The selected user could not be found.", "error");
        header("Location: admin_users.php");
        exit();
    }
    $user = $record;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $user['complete_name'] = trim($_POST['complete_name'] ?? "");
    $user['email'] = trim($_POST['email'] ?? "");
    $password = trim($_POST['password'] ?? "");
    $user['address'] = trim($_POST['address'] ?? "");
    $user['contact_number'] = trim($_POST['contact_number'] ?? "");
    $user['role'] = in_array($_POST['role'] ?? "", array("admin", "buyer")) ? $_POST['role'] : "admin";
    $user['email_confirmed'] = isset($_POST['email_confirmed']) ? 1 : 0;

    if ($user['complete_name'] == "" || $user['address'] == "") {
        $message = "Complete name and address are required.";
    } else if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
    } else if (!preg_match('/^[0-9+() -]{7,20}$/', $user['contact_number'])) {
        $message = "Please enter a valid contact number.";
    } else if ((!$editing || $password != "") && strlen($password) < 6) {
        $message = "Password must contain at least 6 characters.";
    } else if ($editing) {
        if ($password != "") {
            $stmt = $conn->prepare("UPDATE users SET complete_name = ?, email = ?, password = ?, address = ?, contact_number = ?, role = ?, email_confirmed = ? WHERE id = ?");
            $stmt->bind_param("ssssssii", $user['complete_name'], $user['email'], $password, $user['address'], $user['contact_number'], $user['role'], $user['email_confirmed'], $id);
        } else {
            $stmt = $conn->prepare("UPDATE users SET complete_name = ?, email = ?, address = ?, contact_number = ?, role = ?, email_confirmed = ? WHERE id = ?");
            $stmt->bind_param("sssssii", $user['complete_name'], $user['email'], $user['address'], $user['contact_number'], $user['role'], $user['email_confirmed'], $id);
        }
        if ($stmt->execute()) {
            logActivity($conn, "Modified user " . $user['email']);
            setFlashMessage("User " . $user['email'] . " was updated.");
            header("Location: admin_users.php");
            exit();
        }
        $message = "The email address may already be in use.";
        $stmt->close();
    } else {
        $code = md5($user['email'] . time());
        $stmt = $conn->prepare("INSERT INTO users (complete_name, email, password, address, contact_number, role, email_confirmed, confirmation_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssis", $user['complete_name'], $user['email'], $password, $user['address'], $user['contact_number'], $user['role'], $user['email_confirmed'], $code);
        if ($stmt->execute()) {
            logActivity($conn, "Added user " . $user['email']);
            setFlashMessage("User " . $user['email'] . " was added.");
            header("Location: admin_users.php");
            exit();
        }
        $message = "The email address may already be in use.";
        $stmt->close();
    }
}

$pageTitle = $editing ? "Modify User" : "Add User";
require 'header.php';
?>
<div class="nav-links"><a href="admin_users.php">Back to Users</a><a href="admin_dashboard.php">Dashboard</a></div>
<section class="panel form-container admin-form-panel">
    <div class="form-heading"><h2><?php echo $editing ? "Modify User" : "Add User"; ?></h2><p>Manage account details and system role.</p></div>
    <?php if ($message != "") { ?><div class="message error" role="alert"><?php echo displayText($message); ?></div><?php } ?>
    <form method="POST" action="admin_user_form.php<?php if ($editing) echo '?id=' . displayText($id); ?>">
        <div class="form-grid"><div class="form-group"><label for="admin-user-name">Complete Name <span class="required">Required</span></label><input id="admin-user-name" type="text" name="complete_name" value="<?php echo displayText($user['complete_name']); ?>" autocomplete="name" required></div><div class="form-group"><label for="admin-user-email">E-mail Address <span class="required">Required</span></label><input id="admin-user-email" type="email" name="email" value="<?php echo displayText($user['email']); ?>" autocomplete="email" required></div></div>
        <div class="form-group"><label for="admin-user-password">Password <?php if ($editing) echo "(leave blank to keep current)"; ?></label><input id="admin-user-password" type="password" name="password" minlength="6" autocomplete="new-password" <?php if (!$editing) echo "required"; ?>><small class="field-help">At least 6 characters when setting a password.</small></div>
        <div class="form-group"><label for="admin-user-address">Complete Address <span class="required">Required</span></label><textarea id="admin-user-address" name="address" autocomplete="street-address" required><?php echo displayText($user['address']); ?></textarea></div>
        <div class="form-grid"><div class="form-group"><label for="admin-user-contact">Contact Number <span class="required">Required</span></label><input id="admin-user-contact" type="text" name="contact_number" value="<?php echo displayText($user['contact_number']); ?>" pattern="[0-9+() -]{7,20}" autocomplete="tel" required></div><div class="form-group"><label for="admin-user-role">Role <span class="required">Required</span></label><select id="admin-user-role" name="role" required><option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option><option value="buyer" <?php if ($user['role'] == 'buyer') echo 'selected'; ?>>Buyer</option></select></div></div>
        <div class="form-group checkbox-group"><label><input type="checkbox" name="email_confirmed" <?php if ($user['email_confirmed']) echo 'checked'; ?>> E-mail address confirmed</label></div>
        <input type="submit" name="save" value="Save User" class="full-button">
    </form>
</section>
<?php require 'footer.php'; ?>
