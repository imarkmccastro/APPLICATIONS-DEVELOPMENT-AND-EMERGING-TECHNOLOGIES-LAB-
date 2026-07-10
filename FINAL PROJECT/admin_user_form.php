<?php
$pageTitle = "User Form";
require 'functions.php';
requireAdmin();
require 'header.php';

$id = (int)($_GET['id'] ?? 0);
$editing = $id > 0;
$message = "";
$user = array(
    "complete_name" => "",
    "email" => "",
    "password" => "",
    "address" => "",
    "contact_number" => "",
    "role" => "admin",
    "email_confirmed" => 1
);

if ($editing) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $completeName = trim($_POST['complete_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $address = trim($_POST['address']);
    $contactNumber = trim($_POST['contact_number']);
    $role = $_POST['role'];
    $confirmed = isset($_POST['email_confirmed']) ? 1 : 0;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
    } else if ($editing) {
        if ($password != "") {
            $stmt = $conn->prepare("UPDATE users SET complete_name = ?, email = ?, password = ?, address = ?, contact_number = ?, role = ?, email_confirmed = ? WHERE id = ?");
            $stmt->bind_param("ssssssii", $completeName, $email, $password, $address, $contactNumber, $role, $confirmed, $id);
        } else {
            $stmt = $conn->prepare("UPDATE users SET complete_name = ?, email = ?, address = ?, contact_number = ?, role = ?, email_confirmed = ? WHERE id = ?");
            $stmt->bind_param("sssssii", $completeName, $email, $address, $contactNumber, $role, $confirmed, $id);
        }
        if ($stmt->execute()) {
            logActivity($conn, "Modified user " . $email);
            header("Location: admin_users.php");
            exit();
        }
        $message = "Error: " . $stmt->error;
        $stmt->close();
    } else {
        $code = md5($email . time());
        $stmt = $conn->prepare("INSERT INTO users (complete_name, email, password, address, contact_number, role, email_confirmed, confirmation_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssis", $completeName, $email, $password, $address, $contactNumber, $role, $confirmed, $code);
        if ($stmt->execute()) {
            logActivity($conn, "Added user " . $email);
            header("Location: admin_users.php");
            exit();
        }
        $message = "Error: " . $stmt->error;
        $stmt->close();
    }
}
?>

<div class="nav-links">
    <a href="admin_users.php">Back to Users</a>
    <a href="admin_dashboard.php">Dashboard</a>
</div>

<div class="panel form-container">
    <h2><?php echo $editing ? "Modify User" : "Add User"; ?></h2>
    <?php if ($message != "") { ?><div class="message error"><?php echo displayText($message); ?></div><?php } ?>
    <form method="POST" action="">
        <div class="form-group">
            <label>Complete Name</label>
            <input type="text" name="complete_name" value="<?php echo displayText($user['complete_name']); ?>" required>
        </div>
        <div class="form-group">
            <label>E-mail Address</label>
            <input type="email" name="email" value="<?php echo displayText($user['email']); ?>" required>
        </div>
        <div class="form-group">
            <label>Password <?php if ($editing) echo "(leave blank to keep current password)"; ?></label>
            <input type="password" name="password" <?php if (!$editing) echo "required"; ?>>
        </div>
        <div class="form-group">
            <label>Complete Address</label>
            <textarea name="address" required><?php echo displayText($user['address']); ?></textarea>
        </div>
        <div class="form-group">
            <label>Contact Numbers</label>
            <input type="text" name="contact_number" value="<?php echo displayText($user['contact_number']); ?>" required>
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role" required>
                <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>admin</option>
                <option value="buyer" <?php if ($user['role'] == 'buyer') echo 'selected'; ?>>buyer</option>
            </select>
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="email_confirmed" <?php if ($user['email_confirmed']) echo 'checked'; ?>> Email confirmed</label>
        </div>
        <input type="submit" name="save" value="Save" class="full-button">
    </form>
</div>

<?php require 'footer.php'; ?>
