<?php
require 'functions.php';
$message = "";
$email = trim($_POST['email'] ?? "");
$returnTo = safeReturnUrl($_POST['return_to'] ?? $_GET['return_to'] ?? "showcase.php", "showcase.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $password = $_POST['password'] ?? "";
    $role = "buyer";
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ? AND role = ?");
    $stmt->bind_param("sss", $email, $password, $role);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($user && $user['email_confirmed'] == 1) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['complete_name'] = $user['complete_name'];
        $_SESSION['role'] = $user['role'];
        logActivity($conn, "Buyer logged in");
        setFlashMessage("Welcome back, " . $user['complete_name'] . ".");
        header("Location: " . $returnTo);
        exit();
    } else if ($user) {
        $message = "Please confirm your email address before logging in.";
    } else {
        $message = "Invalid buyer email or password.";
    }
}

$pageTitle = "Buyer Login";
require 'header.php';
?>
<div class="nav-links"><a href="index.php">Store</a><a href="register.php">Register</a><a href="admin_login.php">Seller Login</a></div>
<section class="panel form-container compact-panel">
    <div class="form-heading"><h2>Buyer Login</h2><p>Access checkout and your BBB order history.</p></div>
    <?php if ($message != "") { ?><div class="message error" role="alert"><?php echo displayText($message); ?></div><?php } ?>
    <form method="POST" action="login.php">
        <input type="hidden" name="return_to" value="<?php echo displayText($returnTo); ?>">
        <div class="form-group"><label for="buyer-email">E-mail Address</label><input id="buyer-email" type="email" name="email" value="<?php echo displayText($email); ?>" autocomplete="email" required></div>
        <div class="form-group"><label for="buyer-password">Password</label><input id="buyer-password" type="password" name="password" autocomplete="current-password" required></div>
        <input type="submit" name="login" value="Login" class="full-button">
    </form>
</section>
<?php require 'footer.php'; ?>
