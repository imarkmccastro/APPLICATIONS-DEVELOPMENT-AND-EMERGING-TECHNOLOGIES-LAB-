<?php
session_start();
require 'database.php';

if (isset($_SESSION['tsa3_b_user_id'])) {
    header("Location: home.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'] ?? "";
    $password = $_POST['password'] ?? "";

    $stmt = $conn->prepare("SELECT id, username FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['tsa3_b_user_id'] = $row['id'];
        $_SESSION['tsa3_b_username'] = $row['username'];
        header("Location: home.php");
        exit();
    } else {
        $message = "Invalid username or password.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Activity B - Login</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="nav-links">
    <a href="../index.php">TSA3 Home</a>
    <a href="register.php">Register</a>
</div>

<div class="form-container">
    <h3>Database Login</h3>

    <?php if ($message != "") { ?>
        <div class="message error"><?php echo htmlspecialchars($message); ?></div>
    <?php } ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <input type="submit" name="login" value="Login" class="full-button">
    </form>
</div>

</body>
</html>
