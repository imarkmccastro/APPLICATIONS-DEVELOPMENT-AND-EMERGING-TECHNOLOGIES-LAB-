<?php
require 'functions.php';

if (isset($_SESSION['user_id'])) {
    header("Location: showcase.php");
    exit();
}

$message = "";
$email = trim($_POST['email'] ?? "");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $password = $_POST['password'] ?? "";
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($user && $user['email_confirmed'] == 1) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['complete_name'] = $user['complete_name'];
        $_SESSION['role'] = $user['role'];
        logActivity($conn, "User logged in from landing page");
        header("Location: showcase.php");
        exit();
    } else if ($user) {
        $message = "Please confirm your email address before logging in.";
    } else {
        $message = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBB - Landing</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            background-color: #fff;
            color: #000;
        }
        .landing-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .header-logo {
            text-align: center;
            height: 140px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 40px;
            margin-bottom: 0px;
        }
        .header-logo img {
            width: 400px;
            height: auto;
        }
        .content-area {
            display: flex;
            flex: 1;
            padding: 0 0 20px 40px;
            max-width: 100%;
            margin: 0;
            width: 100%;
            box-sizing: border-box;
            min-height: 0;
        }
        .left-panel {
            width: 25%;
            padding-right: 40px;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
        }
        .form-wrapper {
            margin: auto 0;
        }
        .left-panel h2 {
            font-size: 11px;
            font-weight: 300;
            margin-bottom: 30px;
            text-transform: uppercase;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 9px;
            color: #999;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            border: none;
            border-bottom: 1px solid #ccc;
            padding: 4px 0;
            font-size: 12px;
            outline: none;
            background: transparent;
        }
        .form-group input:focus {
            border-bottom: 1px solid #000;
        }
        .btn-continue {
            border: 1px solid #000;
            background: transparent;
            color: #000;
            text-transform: uppercase;
            font-size: 10px;
            padding: 10px 0;
            width: 180px;
            cursor: pointer;
            margin-bottom: 20px;
            margin-top: 10px;
            font-weight: normal;
        }
        .btn-continue:hover {
            background: #000;
            color: #fff;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            font-size: 11px;
            color: #333;
        }
        .checkbox-group input {
            margin-right: 8px;
            appearance: none;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            border-radius: 0;
            outline: none;
            cursor: pointer;
            position: relative;
        }
        .checkbox-group input:checked::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 6px;
            height: 6px;
            background: #000;
        }
        .right-panel {
            width: 75%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 0;
        }
        .luxury-rectangle {
            width: 100%;
            height: 85%;
            background: transparent;
            position: relative;
            overflow: hidden;
        }
        .luxury-rectangle::before {
            content: '';
            position: absolute;
            top: 25px; left: 25px; right: 25px; bottom: 25px;
            border: 1px solid rgba(180, 160, 130, 0.4); /* Champagne gold inner frame */
            pointer-events: none;
            z-index: 2; /* Places the frame elegantly OVER the model (magazine style) */
        }
        .luxury-rectangle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            mix-blend-mode: multiply;
            position: relative;
            z-index: 1;
        }
        .bottom-links {
            margin-top: auto;
            margin-bottom: 10px;
            font-size: 9px;
            text-transform: uppercase;
        }
        .bottom-links a {
            color: #666;
            text-decoration: none;
            margin-right: 25px;
        }
        .bottom-links a:hover {
            color: #000;
        }
        .error-msg {
            color: #a32b3d;
            font-size: 11px;
            margin-bottom: 15px;
        }
        @media (max-width: 768px) {
            body, html {
                height: auto;
                overflow: auto;
            }
            .content-area {
                flex-direction: column;
                padding: 0 20px;
            }
            .left-panel {
                width: 100%;
                padding-right: 0;
                margin-bottom: 40px;
            }
            .right-panel {
                width: 100%;
                height: 50vh;
                padding-right: 0;
                justify-content: center;
            }
            .luxury-rectangle {
                width: 100%;
                height: 100%;
            }
            .header-logo img {
                width: 250px;
            }
        }
    </style>
</head>
<body>

<div class="landing-container">
    <div class="header-logo">
        <img src="BBB/JPG Files/BBB - 2.jpg" alt="BBB Logo">
    </div>
    
    <div class="content-area">
        <div class="left-panel">
            <div class="form-wrapper">
                <h2>LOG IN TO YOUR ACCOUNT</h2>
                <?php if ($message): ?>
                    <div class="error-msg"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>
                
                <form method="POST" action="landing.php">
                    <div class="form-group">
                        <label>EMAIL</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>PASSWORD</label>
                        <input type="password" name="password" required>
                    </div>
                    
                    <button type="submit" name="login" class="btn-continue">LOG IN</button>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember selection</label>
                    </div>
                </form>
            </div>
            
            <div class="bottom-links">
                <a href="register.php">REGISTER</a>
                <a href="#">COOKIES SETTINGS</a>
            </div>
        </div>
        
        <div class="right-panel">
            <div class="luxury-rectangle">
                <img src="BBB/Logo & Theme/Background-3.jpg" alt="BBB Collection">
            </div>
        </div>
    </div>
</div>

</body>
</html>
