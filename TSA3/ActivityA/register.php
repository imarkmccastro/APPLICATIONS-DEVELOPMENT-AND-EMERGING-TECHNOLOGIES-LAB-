<?php
session_start();

if (isset($_SESSION['tsa3_a_username'])) {
    header("Location: home.php");
    exit();
}

$message = "";
$submitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    if ($_POST['password'] != $_POST['confirm_password']) {
        $message = "Password and Confirm Password are not the same.";
    } else {
        $submitted = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Activity A - Registration</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="nav-links">
    <a href="../index.php">TSA3 Home</a>
    <a href="login.php">Login</a>
</div>

<div class="form-container">
    <h3>Registration Form</h3>

    <?php if ($message != "") { ?>
        <div class="message error"><?php echo htmlspecialchars($message); ?></div>
    <?php } ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="firstname" value="<?php echo htmlspecialchars($_POST['firstname'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Middle Name</label>
            <input type="text" name="middlename" value="<?php echo htmlspecialchars($_POST['middlename'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="lastname" value="<?php echo htmlspecialchars($_POST['lastname'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" name="birthdate" value="<?php echo htmlspecialchars($_POST['birthdate'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Address</label>
            <textarea name="address" required><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>
        </div>
        <input type="submit" name="register" value="Submit" class="full-button">
    </form>
</div>

<?php if ($submitted) { ?>
<div class="output">
    <h3>Registration Result</h3>
    <table>
        <tr><th>First Name</th><td><?php echo htmlspecialchars($_POST['firstname']); ?></td></tr>
        <tr><th>Middle Name</th><td><?php echo htmlspecialchars($_POST['middlename']); ?></td></tr>
        <tr><th>Last Name</th><td><?php echo htmlspecialchars($_POST['lastname']); ?></td></tr>
        <tr><th>Date of Birth</th><td><?php echo htmlspecialchars($_POST['birthdate']); ?></td></tr>
        <tr><th>Address</th><td><?php echo htmlspecialchars($_POST['address']); ?></td></tr>
        <tr><th>Username</th><td><?php echo htmlspecialchars($_POST['username']); ?></td></tr>
    </table>
</div>
<?php } ?>

</body>
</html>
