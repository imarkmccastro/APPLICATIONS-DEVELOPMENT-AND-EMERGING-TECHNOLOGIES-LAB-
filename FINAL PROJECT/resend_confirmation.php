<?php
require 'functions.php';

$pageTitle = "Resend Confirmation";
$message = "";
$messageClass = "success";
$email = trim($_POST['email'] ?? "");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['resend'])) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Enter a valid e-mail address.";
        $messageClass = "error";
    } elseif (isset($_SESSION['confirmation_resend_at']) && time() - (int)$_SESSION['confirmation_resend_at'] < 60) {
        $message = "Please wait one minute before requesting another confirmation email.";
        $messageClass = "warning";
    } else {
        $stmt = $conn->prepare("SELECT id, complete_name, email_confirmed FROM users WHERE email = ? AND role = 'buyer' LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($user && (int)$user['email_confirmed'] === 0) {
            $code = bin2hex(random_bytes(32));
            $update = $conn->prepare("UPDATE users SET confirmation_code = ? WHERE id = ?");
            $update->bind_param("si", $code, $user['id']);
            $update->execute();
            $update->close();

            $_SESSION['confirmation_resend_at'] = time();
            if (!sendConfirmationEmail($email, $user['complete_name'], confirmationLink($code))) {
                $message = "The confirmation email could not be sent. Please try again later or contact the site administrator.";
                $messageClass = "warning";
            } else {
                $message = "A new confirmation email was sent. Check your inbox and spam folder.";
                logActivity($conn, "Resent buyer confirmation email for " . $email);
            }
        } else {
            $message = "If an unconfirmed buyer account exists for that address, a confirmation email will be sent.";
        }
    }
}

require 'header.php';
?>

<div class="nav-links"><a href="index.php">Store</a><a href="login.php">Buyer Login</a><a href="register.php">Register</a></div>

<section class="panel form-container compact-panel">
    <div class="form-heading"><h2>Resend Confirmation</h2><p>Request a new activation link for your BBB buyer account.</p></div>
    <?php if ($message != "") { ?><div class="message <?php echo $messageClass; ?>" role="status"><?php echo displayText($message); ?></div><?php } ?>
    <form method="POST" action="resend_confirmation.php">
        <div class="form-group">
            <label for="resend-email">E-mail Address</label>
            <input id="resend-email" type="email" name="email" value="<?php echo displayText($email); ?>" autocomplete="email" required>
        </div>
        <input type="submit" name="resend" value="Send Confirmation Email" class="full-button">
    </form>
</section>

<?php require 'footer.php'; ?>
