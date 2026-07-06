<?php
session_start();
require 'database.php';

if (isset($_SESSION['tsa3_b_user_id'])) {
    header("Location: home.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    if ($_POST['password'] != $_POST['confirm_password']) {
        $message = "Password and Confirm Password are not the same.";
    } else {
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $birthdate = $_POST['birthdate'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("INSERT INTO users (firstname, middlename, lastname, birthdate, address, email, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $firstname, $middlename, $lastname, $birthdate, $address, $email, $username, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration saved to the database successfully!'); window.location.href='login.php';</script>";
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
    <title>Activity B - Registration</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="nav-links">
    <a href="../index.php">TSA3 Home</a>
    <a href="login.php">Login</a>
</div>

<div class="form-container">
    <h3>Database Registration</h3>

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
            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
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
        <input type="submit" name="register" value="Save" class="full-button">
    </form>
</div>

</body>
</html>
