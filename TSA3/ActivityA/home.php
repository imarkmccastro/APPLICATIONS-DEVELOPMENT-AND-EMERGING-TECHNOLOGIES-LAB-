<?php
session_start();

if (!isset($_SESSION['tsa3_a_username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Activity A - Home</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="record-card">
    <h3>Homepage</h3>
    <div class="message success">
        Welcome, <?php echo htmlspecialchars($_SESSION['tsa3_a_username']); ?>.
    </div>
    <div class="nav-links">
        <a href="../index.php">TSA3 Home</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>
