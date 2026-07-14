<?php
require 'functions.php';

$pageTitle = "Buyer Registration";
$message = "";
$messageClass = "error";
$confirmationLink = "";
$errors = array();
$completeName = trim($_POST['complete_name'] ?? "");
$email = trim($_POST['email'] ?? "");
$address = trim($_POST['address'] ?? "");
$contactNumber = trim($_POST['contact_number'] ?? "");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $password = $_POST['password'] ?? "";
    $confirmPassword = $_POST['confirm_password'] ?? "";

    if ($completeName == "") $errors['complete_name'] = "Complete name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Enter a valid email address.";
    if (strlen($password) < 6) $errors['password'] = "Password must contain at least 6 characters.";
    if ($password != $confirmPassword) $errors['confirm_password'] = "The passwords do not match.";
    if ($address == "") $errors['address'] = "Complete address is required.";
    if (!preg_match('/^[0-9+() -]{7,20}$/', $contactNumber)) $errors['contact_number'] = "Enter a valid contact number.";

    if (count($errors) == 0) {
        $code = md5($email . time());
        $role = "buyer";
        $confirmed = 0;
        $stmt = $conn->prepare("INSERT INTO users (complete_name, email, password, address, contact_number, role, email_confirmed, confirmation_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssis", $completeName, $email, $password, $address, $contactNumber, $role, $confirmed, $code);

        if ($stmt->execute()) {
            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['PHP_SELF'])), '/');
            $confirmationLink = $scheme . "://" . $_SERVER['HTTP_HOST'] . $basePath . "/confirm_email.php?code=" . urlencode($code);
            $emailSent = sendConfirmationEmail($email, $completeName, $confirmationLink);
            logActivity($conn, "Registered buyer account for " . $email);
            if ($emailSent) {
                $message = "Registration saved. A confirmation email was sent to " . $email . ".";
                $messageClass = "success";
            } else {
                $message = isLocalEnvironment()
                    ? "Registration saved. Local mail delivery is not configured; use the testing confirmation link below."
                    : "Registration saved, but the confirmation email could not be sent. Please contact the site administrator.";
                $messageClass = "warning";
            }
            $completeName = $email = $address = $contactNumber = "";
        } else {
            $errors['email'] = "This email address may already be registered.";
        }
        $stmt->close();
    }

    if (count($errors) > 0) {
        $message = "Please correct the highlighted fields.";
    }
}

require 'header.php';
?>

<div class="nav-links"><a href="index.php">Store</a><a href="login.php">Buyer Login</a></div>

<section class="panel form-container compact-panel">
    <div class="form-heading"><h2>Create Buyer Account</h2><p>Register to checkout and review your BBB orders.</p></div>
    <?php if ($message != "") { ?><div class="message <?php echo $messageClass; ?>" role="<?php echo $messageClass == 'error' ? 'alert' : 'status'; ?>"><?php echo displayText($message); ?><?php if ($confirmationLink != "" && isLocalEnvironment()) { ?><br><a href="<?php echo displayText($confirmationLink); ?>">Use local confirmation link</a><?php } ?></div><?php } ?>

    <form method="POST" action="register.php" novalidate>
        <div class="form-group <?php if (isset($errors['complete_name'])) echo 'has-error'; ?>">
            <label for="complete-name">Complete Name <span class="required">Required</span></label>
            <input id="complete-name" type="text" name="complete_name" value="<?php echo displayText($completeName); ?>" autocomplete="name" required aria-describedby="complete-name-error">
            <?php if (isset($errors['complete_name'])) { ?><small id="complete-name-error" class="field-error"><?php echo displayText($errors['complete_name']); ?></small><?php } ?>
        </div>
        <div class="form-group <?php if (isset($errors['email'])) echo 'has-error'; ?>">
            <label for="register-email">E-mail Address <span class="required">Required</span></label>
            <input id="register-email" type="email" name="email" value="<?php echo displayText($email); ?>" autocomplete="email" required aria-describedby="register-email-error">
            <?php if (isset($errors['email'])) { ?><small id="register-email-error" class="field-error"><?php echo displayText($errors['email']); ?></small><?php } ?>
        </div>
        <div class="form-grid">
            <div class="form-group <?php if (isset($errors['password'])) echo 'has-error'; ?>">
                <label for="register-password">Password <span class="required">Required</span></label>
                <input id="register-password" type="password" name="password" minlength="6" autocomplete="new-password" required aria-describedby="password-help">
                <small id="password-help" class="field-help <?php if (isset($errors['password'])) echo 'field-error'; ?>"><?php echo displayText($errors['password'] ?? 'At least 6 characters.'); ?></small>
            </div>
            <div class="form-group <?php if (isset($errors['confirm_password'])) echo 'has-error'; ?>">
                <label for="confirm-password">Confirm Password <span class="required">Required</span></label>
                <input id="confirm-password" type="password" name="confirm_password" minlength="6" autocomplete="new-password" required>
                <?php if (isset($errors['confirm_password'])) { ?><small class="field-error"><?php echo displayText($errors['confirm_password']); ?></small><?php } ?>
            </div>
        </div>
        <div class="form-group <?php if (isset($errors['address'])) echo 'has-error'; ?>">
            <label for="register-address">Complete Address <span class="required">Required</span></label>
            <textarea id="register-address" name="address" autocomplete="street-address" required><?php echo displayText($address); ?></textarea>
            <?php if (isset($errors['address'])) { ?><small class="field-error"><?php echo displayText($errors['address']); ?></small><?php } ?>
        </div>
        <div class="form-group <?php if (isset($errors['contact_number'])) echo 'has-error'; ?>">
            <label for="register-contact">Contact Number <span class="required">Required</span></label>
            <input id="register-contact" type="text" name="contact_number" value="<?php echo displayText($contactNumber); ?>" pattern="[0-9+() -]{7,20}" autocomplete="tel" required>
            <?php if (isset($errors['contact_number'])) { ?><small class="field-error"><?php echo displayText($errors['contact_number']); ?></small><?php } ?>
        </div>
        <input type="submit" name="register" value="Create Account" class="full-button">
    </form>
</section>

<?php require 'footer.php'; ?>
