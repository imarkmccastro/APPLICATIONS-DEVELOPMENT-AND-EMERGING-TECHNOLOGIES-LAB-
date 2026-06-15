<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['clear_session'])) {
    session_unset();
    session_destroy();
    header("Location: FavoriteColor.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>FavoriteColor.php</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #fafbfc; background-image: radial-gradient(circle at 15% 50%, rgba(200, 220, 255, 0.5), transparent 50%), radial-gradient(circle at 85% 30%, rgba(255, 210, 220, 0.5), 
        transparent 50%), radial-gradient(circle at 50% 80%, rgba(220, 240, 220, 0.5), transparent 50%); color: #1a1a1a; display: flex; flex-direction: column; align-items: center; padding-top: 8vh; min-height: 100vh; margin: 0; font-size: 15px; }
        h2 { font-weight: 300; letter-spacing: -0.5px; margin-bottom: 40px; color: #111; z-index: 1; }
        form { width: 100%; max-width: 500px; background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.5); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.05); border-radius: 16px; padding: 35px; box-sizing: border-box; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 0 0 15px 0; font-weight: 500; border-bottom: 1px solid rgba(0,0,0,0.05); }
        td { padding: 15px 10px; border: none; }
        input[type="text"] { width: 100%; padding: 10px 5px; border: none; border-bottom: 1px solid rgba(0,0,0,0.1); background: transparent; transition: border-color 0.3s; font-size: 15px; outline: none; }
        input[type="text"]:focus { border-bottom: 1px solid #1a1a1a; }
        input[type="submit"] { margin-top: 15px; padding: 12px 30px; background-color: rgba(26, 26, 26, 0.85); color: #fff; border: 1px solid transparent; border-radius: 6px; cursor: pointer; font-size: 14px; letter-spacing: 0.5px; transition: all 0.3s; }
        input[type="submit"]:hover { background-color: rgba(255, 255, 255, 0.8); color: #1a1a1a; border-color: rgba(26, 26, 26, 0.3); }
        .btn-clear { background-color: transparent !important; color: #1a1a1a !important; border: 1px solid rgba(26, 26, 26, 0.3) !important; margin-left: 10px; }
        .btn-clear:hover { background-color: rgba(26, 26, 26, 0.05) !important; }
    </style>
</head>
<body>

<h2>Activity 3 - Favorite Colors Form</h2>

<form method="POST" action="ResultColors.php">
    <table>
        <tr>
            <th colspan="2">Enter your favorite colors</th>
        </tr>
        <tr>
            <td>Favorite color 1:</td>
            <td><input type="text" name="color1" value="<?php echo isset($_SESSION['color1']) ? htmlspecialchars($_SESSION['color1']) : ''; ?>"></td>
        </tr>
        <tr>
            <td>Favorite color 2:</td>
            <td><input type="text" name="color2" value="<?php echo isset($_SESSION['color2']) ? htmlspecialchars($_SESSION['color2']) : ''; ?>"></td>
        </tr>
        <tr>
            <td>Favorite color 3:</td>
            <td><input type="text" name="color3" value="<?php echo isset($_SESSION['color3']) ? htmlspecialchars($_SESSION['color3']) : ''; ?>"></td>
        </tr>
        <tr>
            <td>Favorite color 4:</td>
            <td><input type="text" name="color4" value="<?php echo isset($_SESSION['color4']) ? htmlspecialchars($_SESSION['color4']) : ''; ?>"></td>
        </tr>
        <tr>
            <td>Favorite color 5:</td>
            <td><input type="text" name="color5" value="<?php echo isset($_SESSION['color5']) ? htmlspecialchars($_SESSION['color5']) : ''; ?>"></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <input type="submit" value="send colors">
                <input type="submit" name="clear_session" value="Clear Colors" class="btn-clear" formnovalidate>
            </td>
        </tr>
    </table>
</form>

</body>
</html>
