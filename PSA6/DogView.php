<?php
require 'database.php';

$sql = "SELECT * FROM dog_info";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dog View</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #fafbfc; background-image: radial-gradient(circle at 15% 50%, rgba(200, 220, 255, 0.5), transparent 50%), 
        radial-gradient(circle at 85% 30%, rgba(255, 210, 220, 0.5), transparent 50%), radial-gradient(circle at 50% 80%, rgba(220, 240, 220, 0.5), transparent 50%); color: #1a1a1a; display: flex; flex-direction: column; align-items: 
        center; padding-top: 5vh; padding-bottom: 5vh; min-height: 100vh; margin: 0; font-size: 15px; }
        .grid-container { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; width: 100%; max-width: 1000px; padding: 0 20px; box-sizing: border-box; }
        .dog-card { width: 100%; background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.5); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.05); border-radius: 16px; padding: 30px; box-sizing:
         border-box; line-height: 1.8; text-align: left; }
        .dog-card p { margin: 5px 0; color: #333; }
        .dog-card .title { font-weight: 600; color: #111; margin-bottom: 15px; font-size: 18px; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 10px; }
        .nav-links { margin-bottom: 30px; text-align: center; }
        .nav-links a { text-decoration: none; color: #555; font-size: 14px; border-bottom: 1px solid transparent; transition: border-bottom 0.2s; padding: 0 10px; }
        .nav-links a:hover { color: #1a1a1a; border-bottom: 1px solid #1a1a1a; }
        h2 { font-weight: 300; letter-spacing: -0.5px; margin-bottom: 30px; color: #111; z-index: 1; }
    </style>
</head>
<body>

<div class="nav-links">
    <a href="DogRegister.php">Add New Dog</a>
</div>

<?php
if ($result->num_rows > 0) {
    echo "<div class='grid-container'>";
    $count = 1;
    while($row = $result->fetch_assoc()) {
        echo "<div class='dog-card'>";
        echo "<p class='title'>Dog " . $count . "</p>";
        echo "<p>Name: " . htmlspecialchars($row["d_name"]) . "</p>";
        echo "<p>Breed: " . htmlspecialchars($row["d_breed"]) . "</p>";
        echo "<p>Age: " . htmlspecialchars($row["d_age"]) . "</p>";
        echo "<p>Address: " . htmlspecialchars($row["d_add"]) . "</p>";
        echo "<p>Color: " . htmlspecialchars($row["d_color"]) . "</p>";
        echo "<p>Height: " . htmlspecialchars($row["d_height"]) . "</p>";
        echo "<p>Weight: " . htmlspecialchars($row["d_weight"]) . "</p>";
        echo "</div>";
        $count++;
    }
    echo "</div>";
} else {
    echo "<p>No dog records found in the database. <a href='init_dogs.php'>Click here to generate 10 records.</a></p>";
}
$conn->close();
?>

</body>
</html>
