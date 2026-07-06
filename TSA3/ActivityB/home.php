<?php
session_start();
require 'database.php';

if (!isset($_SESSION['tsa3_b_user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['tsa3_b_user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Activity B - Home</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="nav-links">
    <a href="../index.php">TSA3 Home</a>
    <a href="reset_password.php">Reset Password</a>
    <a href="logout.php">Logout</a>
</div>

<div class="record-card wide-container">
    <h3>User Side Retrieval of Record</h3>
    <div class="message success">
        Welcome, <?php echo htmlspecialchars($_SESSION['tsa3_b_username']); ?>.
    </div>

    <?php if ($user) { ?>
    <table>
        <tr><th>ID</th><td><?php echo htmlspecialchars($user['id']); ?></td></tr>
        <tr><th>First Name</th><td><?php echo htmlspecialchars($user['firstname']); ?></td></tr>
        <tr><th>Middle Name</th><td><?php echo htmlspecialchars($user['middlename']); ?></td></tr>
        <tr><th>Last Name</th><td><?php echo htmlspecialchars($user['lastname']); ?></td></tr>
        <tr><th>Date of Birth</th><td><?php echo htmlspecialchars($user['birthdate']); ?></td></tr>
        <tr><th>Address</th><td><?php echo htmlspecialchars($user['address']); ?></td></tr>
        <tr><th>Email</th><td><?php echo htmlspecialchars($user['email']); ?></td></tr>
        <tr><th>Username</th><td><?php echo htmlspecialchars($user['username']); ?></td></tr>
    </table>
    <?php } ?>
</div>

</body>
</html>
