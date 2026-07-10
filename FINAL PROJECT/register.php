<?php
$pageTitle = "Buyer Registration";
require 'header.php';

$message = "";
$messageClass = "error";
$confirmationLink = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $completeName = trim($_POST['complete_name'] ?? "");
    $email = trim($_POST['email'] ?? "");
    $password = $_POST['password'] ?? "";
    $confirmPassword = $_POST['confirm_password'] ?? "";
    $address = trim($_POST['address'] ?? "");
    $contactNumber = trim($_POST['contact_number'] ?? "");

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
    } else if ($password != $confirmPassword) {
        $message = "Password and Confirm Password are not the same.";
    } else {
        $code = md5($email . time());
        $role = "buyer";
        $confirmed = 0;

        $stmt = $conn->prepare("INSERT INTO users (complete_name, email, password, address, contact_number, role, email_confirmed, confirmation_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssis", $completeName, $email, $password, $address, $contactNumber, $role, $confirmed, $code);

        if ($stmt->execute()) {
            $confirmationLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/confirm_email.php?code=" . $code;
            $subject = "ThreadLine Email Confirmation";
            $body = "Hello " . $completeName . ", please confirm your ThreadLine account using this link: " . $confirmationLink;
            @mail($email, $subject, $body);
            logActivity($conn, "Registered buyer account for " . $email);
            $message = "Registration saved. A confirmation email was sent to " . $email . ".";
            $messageClass = "success";
        } else {
            $message = "Error: Email may already be registered.";
        }
        $stmt->close();
    }
}
?>

<div class="nav-links">
    <a href="index.php">Store</a>
    <a href="login.php">Buyer Login</a>
</div>

<div class="panel form-container">
    <h2>Buyer Registration</h2>
    <?php if ($message != "") { ?>
        <div class="message <?php echo $messageClass; ?>">
            <?php echo displayText($message); ?>
            <?php if ($confirmationLink != "") { ?><br>Local test link: <a href="<?php echo displayText($confirmationLink); ?>">Confirm Email</a><?php } ?>
        </div>
    <?php } ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Complete Name</label>
            <input type="text" name="complete_name" value="<?php echo displayText($_POST['complete_name'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>E-mail Address</label>
            <input type="email" name="email" value="<?php echo displayText($_POST['email'] ?? ''); ?>" required>
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required>
            </div>
        </div>
        <div class="form-group">
            <label>Complete Address</label>
            <textarea name="address" required><?php echo displayText($_POST['address'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label>Contact Numbers</label>
            <input type="text" name="contact_number" value="<?php echo displayText($_POST['contact_number'] ?? ''); ?>" required>
        </div>
        <input type="submit" name="register" value="Register" class="full-button">
    </form>
</div>

<?php require 'footer.php'; ?>
