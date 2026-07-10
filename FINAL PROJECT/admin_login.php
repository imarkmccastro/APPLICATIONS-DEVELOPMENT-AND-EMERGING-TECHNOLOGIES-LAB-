<?php
require 'functions.php';
$message = "";
$email = trim($_POST['email'] ?? "");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $password = $_POST['password'] ?? "";
    $role = "admin";
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ? AND role = ?");
    $stmt->bind_param("sss", $email, $password, $role);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['complete_name'] = $user['complete_name'];
        $_SESSION['role'] = $user['role'];
        logActivity($conn, "Admin logged in");
        setFlashMessage("Welcome to the seller dashboard, " . $user['complete_name'] . ".");
        header("Location: admin_dashboard.php");
        exit();
    }
    $message = "Invalid administrator email or password.";
}

$pageTitle = "Admin Login";
require 'header.php';
?>
<div class="nav-links"><a href="index.php">Store</a><a href="login.php">Buyer Login</a></div>
<section class="panel form-container compact-panel">
    <div class="form-heading"><h2>System Admin Login</h2><p>Manage BBB users, inventory, and reports.</p></div>
    <?php if ($message != "") { ?><div class="message error" role="alert"><?php echo displayText($message); ?></div><?php } ?>
    <form method="POST" action="admin_login.php">
        <div class="form-group"><label for="admin-email">E-mail Address</label><input id="admin-email" type="email" name="email" value="<?php echo displayText($email); ?>" autocomplete="email" required></div>
        <div class="form-group"><label for="admin-password">Password</label><input id="admin-password" type="password" name="password" autocomplete="current-password" required></div>
        <input type="submit" name="login" value="Login" class="full-button">
    </form>
</section>
<?php require 'footer.php'; ?>
