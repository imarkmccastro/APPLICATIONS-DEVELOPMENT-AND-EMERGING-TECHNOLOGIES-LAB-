<?php
$pageTitle = "Admin Login";
require 'header.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ? AND role = 'admin'");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['complete_name'] = $user['complete_name'];
        $_SESSION['role'] = $user['role'];
        logActivity($conn, "Admin logged in");
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $message = "Invalid admin email or password.";
    }
}
?>

<div class="nav-links">
    <a href="index.php">Store</a>
    <a href="login.php">Buyer Login</a>
</div>

<div class="panel form-container">
    <h2>System Admin Login</h2>
    <?php if ($message != "") { ?><div class="message error"><?php echo displayText($message); ?></div><?php } ?>
    <form method="POST" action="">
        <div class="form-group">
            <label>E-mail Address</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <input type="submit" name="login" value="Login" class="full-button">
    </form>
</div>

<?php require 'footer.php'; ?>
