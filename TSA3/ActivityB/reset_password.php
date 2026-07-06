<?php
session_start();
require 'database.php';

if (!isset($_SESSION['tsa3_b_user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";
$messageClass = "error";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
    $currentPassword = $_POST['current_password'] ?? "";
    $newPassword = $_POST['new_password'] ?? "";
    $reenterPassword = $_POST['reenter_password'] ?? "";
    $userId = $_SESSION['tsa3_b_user_id'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user || $currentPassword != $user['password']) {
        $message = "Current password is not the same with the old password.";
    } else if ($newPassword != $reenterPassword) {
        $message = "New password and Re-Enter new password should be the same.";
    } else {
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $newPassword, $userId);
        if ($stmt->execute()) {
            $message = "Password reset successfully.";
            $messageClass = "success";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Activity B - Reset Password</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="nav-links">
    <a href="home.php">Home</a>
    <a href="logout.php">Logout</a>
</div>

<div class="form-container">
    <h3>Reset Password</h3>

    <?php if ($message != "") { ?>
        <div class="message <?php echo $messageClass; ?>"><?php echo htmlspecialchars($message); ?></div>
    <?php } ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Enter Current Password</label>
            <input type="password" name="current_password" required>
        </div>
        <div class="form-group">
            <label>Enter New Password</label>
            <input type="password" name="new_password" required>
        </div>
        <div class="form-group">
            <label>Re-Enter New Password</label>
            <input type="password" name="reenter_password" required>
        </div>
        <input type="submit" name="reset" value="Reset Password" class="full-button">
    </form>
</div>

</body>
</html>
