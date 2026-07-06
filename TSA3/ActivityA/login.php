<?php
session_start();

if (isset($_SESSION['tsa3_a_username'])) {
    header("Location: home.php");
    exit();
}

$validUsername = "mark";
$validPassword = "castro123";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'] ?? "";
    $password = $_POST['password'] ?? "";

    if ($username == $validUsername && $password == $validPassword) {
        $_SESSION['tsa3_a_username'] = $username;

        if (isset($_POST['remember'])) {
            setcookie('tsa3_a_username', $username, time() + 86400, "/");
            setcookie('tsa3_a_password', $password, time() + 86400, "/");
        } else {
            setcookie('tsa3_a_username', '', time() - 3600, "/");
            setcookie('tsa3_a_password', '', time() - 3600, "/");
        }

        header("Location: home.php");
        exit();
    } else {
        $message = "Invalid username or password.";
    }
}

$savedUsername = $_COOKIE['tsa3_a_username'] ?? "";
$savedPassword = $_COOKIE['tsa3_a_password'] ?? "";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Activity A - Login</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="nav-links">
    <a href="../index.php">TSA3 Home</a>
    <a href="register.php">Register</a>
</div>

<div class="form-container">
    <h3>Login Form</h3>

    <?php if ($message != "") { ?>
        <div class="message error"><?php echo htmlspecialchars($message); ?></div>
    <?php } ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($savedUsername); ?>" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" value="<?php echo htmlspecialchars($savedPassword); ?>" required>
        </div>
        <div class="checkbox-row">
            <input type="checkbox" name="remember" id="remember" <?php if ($savedUsername != "") echo "checked"; ?>>
            <label for="remember">Remember me</label>
        </div>
        <input type="submit" name="login" value="Login" class="full-button">
    </form>
    <div class="footer">Static account: mark / castro123</div>
</div>

</body>
</html>
