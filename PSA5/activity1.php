<!DOCTYPE html>
<html>
<head>
    <title>Activity 1 - Personal Information</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #fafbfc; background-image: radial-gradient(circle at 15% 50%, rgba(200, 220, 255, 0.5), transparent 50%), radial-gradient(circle at 85% 30%, rgba(255, 210, 220, 0.5), 
        transparent 50%), radial-gradient(circle at 50% 80%, rgba(220, 240, 220, 0.5), transparent 50%); color: #1a1a1a; display: flex; flex-direction: column; align-items: center; padding-top: 5vh; min-height: 100vh; margin: 0; font-size: 15px; }
        h2 { font-weight: 300; letter-spacing: -0.5px; margin-bottom: 20px; color: #111; z-index: 1; }
        form, .output { width: 100%; max-width: 500px; background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.5); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.05); border-radius: 16px; padding: 35px; box-sizing: border-box; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 10px 10px; }
        input[type="text"] { width: 100%; padding: 10px 5px; border: none; border-bottom: 1px solid rgba(0,0,0,0.1); background: transparent; transition: border-color 0.3s; font-size: 15px; outline: none; }
        input[type="text"]:focus { border-bottom: 1px solid #1a1a1a; }
        input[type="submit"], .btn-clear { margin-top: 15px; padding: 12px 30px; background-color: rgba(26, 26, 26, 0.85); color: #fff; border: 1px solid transparent; border-radius: 6px; cursor: pointer; font-size: 14px; letter-spacing: 0.5px; transition: all 0.3s; text-decoration: none; display: inline-block; }
        input[type="submit"]:hover { background-color: rgba(255, 255, 255, 0.8); color: #1a1a1a; border-color: rgba(26, 26, 26, 0.3); }
        .btn-clear { background-color: transparent; color: #1a1a1a; border: 1px solid rgba(26, 26, 26, 0.3); margin-left: 10px; }
        .btn-clear:hover { background-color: rgba(26, 26, 26, 0.05); color: #1a1a1a; }
        .output { line-height: 2; text-align: left; margin-top: 0; }
        .method-title { font-weight: 600; font-size: 1.1em; margin-bottom: 15px; display: block; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 10px;}
    </style>
</head>
<body>

<h2>Activity 1 - Personal Info</h2>

<!-- GET FORM -->
<form method="GET" action="activity1.php">
    <span class="method-title">Using GET Method</span>
    <table>
        <tr>
            <td>First Name:</td>
            <td><input type="text" name="firstname" value="<?php echo isset($_GET['submit_get']) && isset($_GET['firstname']) ? htmlspecialchars($_GET['firstname']) : ''; ?>" required></td>
        </tr>
        <tr>
            <td>Middle Name:</td>
            <td><input type="text" name="middlename" value="<?php echo isset($_GET['submit_get']) && isset($_GET['middlename']) ? htmlspecialchars($_GET['middlename']) : ''; ?>" required></td>
        </tr>
        <tr>
            <td>Last Name:</td>
            <td><input type="text" name="lastname" value="<?php echo isset($_GET['submit_get']) && isset($_GET['lastname']) ? htmlspecialchars($_GET['lastname']) : ''; ?>" required></td>
        </tr>
        <tr>
            <td>Date of Birth:</td>
            <td><input type="text" name="dob" value="<?php echo isset($_GET['submit_get']) && isset($_GET['dob']) ? htmlspecialchars($_GET['dob']) : ''; ?>" required></td>
        </tr>
        <tr>
            <td>Address</td>
            <td><input type="text" name="address" value="<?php echo isset($_GET['submit_get']) && isset($_GET['address']) ? htmlspecialchars($_GET['address']) : ''; ?>" required></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" name="submit_get" value="Submit via GET">
                <a href="activity1.php" class="btn-clear">Clear Form</a>
            </td>
        </tr>
    </table>
</form>

<?php
if (isset($_GET['submit_get'])) {
    echo '<div class="output">';
    echo "<strong>Submitted via GET:</strong><br><br>";
    echo "First Name: " . htmlspecialchars($_GET['firstname'] ?? '') . "<br>";
    echo "Middle Name: " . htmlspecialchars($_GET['middlename'] ?? '') . "<br>";
    echo "Last Name: " . htmlspecialchars($_GET['lastname'] ?? '') . "<br>";
    echo "Date of Birth: " . htmlspecialchars($_GET['dob'] ?? '') . "<br>";
    echo "Address: " . htmlspecialchars($_GET['address'] ?? '') . "<br>";
    echo '</div>';
}
?>

<!-- POST FORM -->
<form method="POST" action="activity1.php">
    <span class="method-title">Using POST Method</span>
    <table>
        <tr>
            <td>First Name:</td>
            <td><input type="text" name="firstname" value="<?php echo isset($_POST['submit_post']) && isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : ''; ?>" required></td>
        </tr>
        <tr>
            <td>Middle Name:</td>
            <td><input type="text" name="middlename" value="<?php echo isset($_POST['submit_post']) && isset($_POST['middlename']) ? htmlspecialchars($_POST['middlename']) : ''; ?>" required></td>
        </tr>
        <tr>
            <td>Last Name:</td>
            <td><input type="text" name="lastname" value="<?php echo isset($_POST['submit_post']) && isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : ''; ?>" required></td>
        </tr>
        <tr>
            <td>Date of Birth:</td>
            <td><input type="text" name="dob" value="<?php echo isset($_POST['submit_post']) && isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : ''; ?>" required></td>
        </tr>
        <tr>
            <td>Address</td>
            <td><input type="text" name="address" value="<?php echo isset($_POST['submit_post']) && isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>" required></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" name="submit_post" value="Submit via POST">
                <a href="activity1.php" class="btn-clear">Clear Form</a>
            </td>
        </tr>
    </table>
</form>

<?php
if (isset($_POST['submit_post'])) {
    echo '<div class="output">';
    echo "<strong>Submitted via POST:</strong><br><br>";
    echo "First Name: " . htmlspecialchars($_POST['firstname'] ?? '') . "<br>";
    echo "Middle Name: " . htmlspecialchars($_POST['middlename'] ?? '') . "<br>";
    echo "Last Name: " . htmlspecialchars($_POST['lastname'] ?? '') . "<br>";
    echo "Date of Birth: " . htmlspecialchars($_POST['dob'] ?? '') . "<br>";
    echo "Address: " . htmlspecialchars($_POST['address'] ?? '') . "<br>";
    echo '</div>';
}
?>

</body>
</html>
