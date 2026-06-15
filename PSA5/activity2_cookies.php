<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['clear_cookies'])) {
        setcookie('firstname', '', time() - 3600, "/");
        setcookie('middlename', '', time() - 3600, "/");
        setcookie('lastname', '', time() - 3600, "/");
    } else {
        $firstname = $_POST['firstname'] ?? '';
        $middlename = $_POST['middlename'] ?? '';
        $lastname = $_POST['lastname'] ?? '';

        setcookie('firstname', $firstname, time() + 20, "/"); // expires in 20 secs
        setcookie('middlename', $middlename, time() + 30, "/"); // expires in 30 secs
        setcookie('lastname', $lastname, time() + 10, "/"); // expires in 10 secs
    }

    // Redirect to the same page to avoid re-submission and see the cookies
    header("Location: activity2_cookies.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP Cookies - Activity 2</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #fafbfc; background-image: radial-gradient(circle at 15% 50%, rgba(200, 220, 255, 0.5), transparent 50%), radial-gradient(circle at 85% 30%, rgba(255, 210, 220, 0.5), transparent 50%), radial-gradient(circle at 50% 80%, rgba(220, 240, 220, 0.5), transparent 50%); color: #1a1a1a; display: flex; flex-direction: column; align-items: center; padding-top: 8vh; min-height: 100vh; margin: 0; font-size: 15px; }
        h2 { font-weight: 300; letter-spacing: -0.5px; margin-bottom: 40px; color: #111; z-index: 1; }
        form, .cookie-list { width: 100%; max-width: 500px; background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.5); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.05); border-radius: 16px; padding: 35px; box-sizing: border-box; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 15px 10px; }
        input[type="text"] { width: 100%; padding: 10px 5px; border: none; border-bottom: 1px solid rgba(0,0,0,0.1); background: transparent; transition: border-color 0.3s; font-size: 15px; outline: none; }
        input[type="text"]:focus { border-bottom: 1px solid #1a1a1a; }
        input[type="submit"] { margin-top: 15px; padding: 12px 30px; background-color: rgba(26, 26, 26, 0.85); color: #fff; border: 1px solid transparent; border-radius: 6px; cursor: pointer; font-size: 14px; letter-spacing: 0.5px; transition: all 0.3s; }
        input[type="submit"]:hover { background-color: rgba(255, 255, 255, 0.8); color: #1a1a1a; border-color: rgba(26, 26, 26, 0.3); }
        .btn-clear { background-color: transparent !important; color: #1a1a1a !important; border: 1px solid rgba(26, 26, 26, 0.3) !important; margin-left: 10px; }
        .btn-clear:hover { background-color: rgba(26, 26, 26, 0.05) !important; }
        .cookie-list { line-height: 2; text-align: left; margin-top: 0; }
        .help-text { color: #777; font-size: 0.85em; margin-top: 20px; font-weight: 300; }
    </style>
</head>
<body>

<h2>Activity 2 - PHP Cookies</h2>

<form method="POST" action="activity2_cookies.php">
    <table>
        <tr>
            <td>First Name:</td>
            <td><input type="text" name="firstname" value="<?php echo isset($_COOKIE['firstname']) ? htmlspecialchars($_COOKIE['firstname']) : ''; ?>"></td>
        </tr>
        <tr>
            <td>Middle Name:</td>
            <td><input type="text" name="middlename" value="<?php echo isset($_COOKIE['middlename']) ? htmlspecialchars($_COOKIE['middlename']) : ''; ?>"></td>
        </tr>
        <tr>
            <td>Last Name:</td>
            <td><input type="text" name="lastname" value="<?php echo isset($_COOKIE['lastname']) ? htmlspecialchars($_COOKIE['lastname']) : ''; ?>"></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Set Cookies">
                <input type="submit" name="clear_cookies" value="Clear Cookies" class="btn-clear" formnovalidate>
            </td>
        </tr>
    </table>
</form>

<br>
<div class="cookie-list">
    <h3>Current Cookies:</h3>
    <p>
        First Name (expires in 20s): <strong><?php echo isset($_COOKIE['firstname']) ? htmlspecialchars($_COOKIE['firstname']) : 'Cookie expired'; ?></strong><br>
        Middle Name (expires in 30s): <strong><?php echo isset($_COOKIE['middlename']) ? htmlspecialchars($_COOKIE['middlename']) : 'Cookie expired'; ?></strong><br>
        Last Name (expires in 10s): <strong><?php echo isset($_COOKIE['lastname']) ? htmlspecialchars($_COOKIE['lastname']) : 'Cookie expired'; ?></strong><br>
    </p>
    <p class="help-text">Refresh the page to check if cookies have expired.</p>
</div>

<?php
$hasCookies = isset($_COOKIE['firstname']) || isset($_COOKIE['middlename']) || isset($_COOKIE['lastname']);
if ($hasCookies): 
?>
<script>
    // Simple auto-refresh script
    // Refreshes the page every 10 seconds to visually update which cookies have expired
    setTimeout(function() {
        window.location.reload();
    }, 10000);
</script>
<?php endif; ?>

</body>
</html>
