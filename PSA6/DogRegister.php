<?php
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $color = $_POST['color'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];

    $stmt = $conn->prepare("INSERT INTO dog_info (d_name, d_breed, d_age, d_add, d_color, d_height, d_weight) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $breed, $age, $address, $color, $height, $weight);
    
    if ($stmt->execute()) {
        echo "<script>alert('Information saved to the database successfully!'); window.location.href='DogView.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dog Register</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #fafbfc; background-image: radial-gradient(circle at 15% 50%, rgba(200, 220, 255, 0.5), transparent 50%), 
        radial-gradient(circle at 85% 30%, rgba(255, 210, 220, 0.5), transparent 50%), radial-gradient(circle at 50% 80%, rgba(220, 240, 220, 0.5), transparent 50%); color: #1a1a1a; display: flex; flex-direction: column; align-items: center; padding-top: 5vh; min-height: 100vh; margin: 0; font-size: 15px; }
        .form-container { width: 100%; max-width: 500px; background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.5); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.05); 
        border-radius: 16px; padding: 35px; box-sizing: border-box; margin-bottom: 30px; }
        h3 { font-weight: 300; letter-spacing: -0.5px; margin-top: 0; margin-bottom: 20px; color: #111; font-size: 24px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #555; font-size: 14px; font-weight: 500; }
        input[type="text"] { width: 100%; padding: 10px 5px; border: none; border-bottom: 1px solid rgba(0,0,0,0.1); background: transparent; transition: border-color 0.3s; font-size: 15px; outline: none; }
        input[type="text"]:focus { border-bottom: 1px solid #1a1a1a; }
        input[type="submit"] { margin-top: 15px; padding: 12px 30px; background-color: rgba(26, 26, 26, 0.85); color: #fff; border: 1px solid transparent; border-radius: 6px; cursor: pointer; font-size: 14px; letter-spacing: 0.5px; transition: all 0.3s; width: 100%; }
        input[type="submit"]:hover { background-color: rgba(255, 255, 255, 0.8); color: #1a1a1a; border-color: rgba(26, 26, 26, 0.3); }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
        .nav-links { margin-bottom: 20px; text-align: center; }
        .nav-links a { text-decoration: none; color: #555; font-size: 14px; border-bottom: 1px solid transparent; transition: border-bottom 0.2s; padding: 0 10px; }
        .nav-links a:hover { color: #1a1a1a; border-bottom: 1px solid #1a1a1a; }
    </style>
</head>
<body>

<div class="nav-links">
    <a href="DogView.php">View All Dogs</a>
</div>

<div class="form-container">
    <h3>Dog Information</h3>
    <form method="POST" action="">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Breed</label>
            <input type="text" name="breed" required>
        </div>
        <div class="form-group">
            <label>Age</label>
            <input type="text" name="age" required>
        </div>
        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" required>
        </div>
        <div class="form-group">
            <label>Color</label>
            <input type="text" name="color" required>
        </div>
        <div class="form-group">
            <label>Height</label>
            <input type="text" name="height" required>
        </div>
        <div class="form-group">
            <label>Weight</label>
            <input type="text" name="weight" required>
        </div>
        <input type="submit" name="save" value="save">
    </form>
    <div class="footer">&copy; Mark Benedict Castro - TW22</div>
</div>

</body>
</html>
