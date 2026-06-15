<?php
session_start();

if (isset($_GET['clear'])) {
    session_unset();
    session_destroy();
    header("Location: FavoriteColor.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['color1'] = $_POST['color1'] ?? '';
    $_SESSION['color2'] = $_POST['color2'] ?? '';
    $_SESSION['color3'] = $_POST['color3'] ?? '';
    $_SESSION['color4'] = $_POST['color4'] ?? '';
    $_SESSION['color5'] = $_POST['color5'] ?? '';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ResultColors.php</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #fafbfc; background-image: radial-gradient(circle at 15% 50%, rgba(200, 220, 255, 0.5), transparent 50%), radial-gradient(circle at 85% 30%, rgba(255, 210, 220, 0.5), transparent 50%), radial-gradient(circle at 50% 80%, rgba(220, 240, 220, 0.5), transparent 50%); color: #1a1a1a; display: flex; flex-direction: column; align-items: center; padding-top: 8vh; min-height: 100vh; margin: 0; font-size: 15px; }
        h2 { font-weight: 300; letter-spacing: -0.5px; margin-bottom: 40px; color: #111; z-index: 1; }
        .color-list { width: 100%; max-width: 500px; background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.5); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.05); border-radius: 16px; padding: 35px; box-sizing: border-box; margin-bottom: 30px; line-height: 2.2; text-align: left; }
        .color-box { display: inline-block; width: 20px; height: 20px; vertical-align: middle; border-radius: 50%; border: 1px solid rgba(255,255,255,0.8); margin-left: 12px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .nav-link { display: inline-block; margin-top: 20px; text-decoration: none; color: #555; font-size: 14px; border-bottom: 1px solid transparent; transition: border-bottom 0.2s; }
        .nav-link:hover { color: #1a1a1a; border-bottom: 1px solid #1a1a1a; }
    </style>
</head>
<body>

<h2>Activity 3 - Favorite Colors Result</h2>

<?php
echo '<div class="color-list">';
for ($i = 1; $i <= 5; $i++) {
    $color = $_SESSION["color$i"] ?? '';
    if ($color !== '') {
        echo "My Favorite Color $i: <strong>" . htmlspecialchars($color) . "</strong>";
        echo ' <div class="color-box" style="background-color: ' . htmlspecialchars($color) . ';"></div><br>';
    } else {
        echo "My Favorite Color $i: <em>Not Set</em><br>";
    }
}
echo '<div>';
echo '<a href="FavoriteColor.php" class="nav-link">&larr; Go Back</a>';
echo '<a href="ResultColors.php?clear=1" class="nav-link" style="margin-left: 20px; color: #d9534f; border-bottom: none;">Clear Session &times;</a>';
echo '</div>';
echo '</div>';
?>

</body>
</html>
