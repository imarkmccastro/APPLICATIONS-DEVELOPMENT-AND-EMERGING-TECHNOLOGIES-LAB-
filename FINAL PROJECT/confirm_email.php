<?php
$pageTitle = "Email Confirmation";
require 'header.php';

$code = $_GET['code'] ?? "";
$message = "Invalid confirmation code.";
$messageClass = "error";

if ($code != "") {
    $stmt = $conn->prepare("UPDATE users SET email_confirmed = 1, confirmation_code = NULL WHERE confirmation_code = ? AND role = 'buyer' AND email_confirmed = 0");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        $message = "Email confirmed successfully. You may now login.";
        $messageClass = "success";
        logActivity($conn, "Confirmed buyer email");
    }
    $stmt->close();
}
?>

<div class="panel form-container">
    <h2>Email Confirmation</h2>
    <div class="message <?php echo $messageClass; ?>" role="<?php echo $messageClass == 'error' ? 'alert' : 'status'; ?>"><?php echo displayText($message); ?></div>
    <a href="login.php" class="button-link full-button">Go to Buyer Login</a>
</div>

<?php require 'footer.php'; ?>
