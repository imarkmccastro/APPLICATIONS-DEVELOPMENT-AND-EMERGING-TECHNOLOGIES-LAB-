<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/database.php';

require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/SMTP.php';

function displayText($text) {
    return htmlspecialchars($text ?? "", ENT_QUOTES, "UTF-8");
}

function moneyFormat($amount) {
    return "PHP " . number_format((float)$amount, 2);
}

function cartCount() {
    $count = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $qty) {
            $count += (int)$qty;
        }
    }
    return $count;
}

function currentUserName() {
    return $_SESSION['complete_name'] ?? "Guest";
}

function isLocalEnvironment() {
    $host = strtolower(preg_replace('/:\\d+$/', '', $_SERVER['HTTP_HOST'] ?? ''));
    return in_array($host, array('localhost', '127.0.0.1', '::1'));
}

function getMailConfig() {
    $defaults = array(
        'enabled' => false,
        'host' => '',
        'port' => 587,
        'encryption' => 'tls',
        'username' => '',
        'password' => '',
        'from_email' => '',
        'from_name' => 'BBB Clothing Store',
        'site_url' => ''
    );

    $configFile = __DIR__ . '/config/mail_config.php';
    if (!is_file($configFile)) {
        return $defaults;
    }

    $configured = require $configFile;
    return is_array($configured) ? array_merge($defaults, $configured) : $defaults;
}

function confirmationLink($code) {
    $config = getMailConfig();
    $configuredUrl = rtrim(trim($config['site_url']), '/');
    if ($configuredUrl != '') {
        return $configuredUrl . '/confirm_email.php?code=' . urlencode($code);
    }

    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    if (!preg_match('/^[a-z0-9.-]+(?::\d+)?$/i', $host)) {
        $host = 'localhost';
    }
    $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['PHP_SELF'] ?? '/')), '/');
    return $scheme . '://' . $host . $basePath . '/confirm_email.php?code=' . urlencode($code);
}

function sendConfirmationEmail($email, $completeName, $confirmationLink) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    $config = getMailConfig();
    if (!$config['enabled'] || $config['host'] == '' || $config['username'] == '' || $config['password'] == '') {
        return false;
    }

    $fromAddress = $config['from_email'] ?: $config['username'];
    if (!filter_var($fromAddress, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    $fromName = $config['from_name'] ?: 'BBB Clothing Store';
    $safeName = str_replace(array("\r", "\n"), '', $completeName);
    $subject = 'Confirm your BBB account';
    $plainBody = "Hello " . $safeName . ",\r\n\r\n"
        . "Thank you for registering with BBB. Confirm your e-mail address using the link below:\r\n\r\n"
        . $confirmationLink . "\r\n\r\n"
        . "If you did not create this account, you may ignore this message.\r\n";

    $escapedName = htmlspecialchars($safeName, ENT_QUOTES, 'UTF-8');
    $escapedLink = htmlspecialchars($confirmationLink, ENT_QUOTES, 'UTF-8');
    $htmlBody = '<div style="font-family:Arial,sans-serif;color:#171717;line-height:1.6;max-width:560px;margin:auto">'
        . '<p style="font-size:12px;letter-spacing:2px;text-transform:uppercase">BBB Clothing Store</p>'
        . '<h1 style="font-size:26px;font-weight:400">Confirm your e-mail</h1>'
        . '<p>Hello ' . $escapedName . ',</p>'
        . '<p>Thank you for registering with BBB. Confirm your e-mail address to activate your buyer account.</p>'
        . '<p style="margin:28px 0"><a href="' . $escapedLink . '" style="background:#171717;color:#fff;padding:13px 22px;text-decoration:none;display:inline-block">Confirm E-mail</a></p>'
        . '<p style="font-size:12px;color:#666">If the button does not work, copy this link:<br>' . $escapedLink . '</p>'
        . '<p style="font-size:12px;color:#666">If you did not create this account, you may ignore this message.</p>'
        . '</div>';

    try {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['username'];
        $mail->Password = $config['password'];
        $mail->Port = (int)$config['port'];
        $mail->Timeout = 20;

        $encryption = strtolower($config['encryption']);
        if ($encryption === 'ssl' || $encryption === 'smtps') {
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
        } elseif ($encryption === 'tls' || $encryption === 'starttls') {
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        } else {
            $mail->SMTPSecure = '';
            $mail->SMTPAutoTLS = false;
        }

        $mail->CharSet = 'UTF-8';
        $mail->setFrom($fromAddress, $fromName);
        $mail->addAddress($email, $safeName);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;
        $mail->AltBody = $plainBody;
        return $mail->send();
    } catch (\PHPMailer\PHPMailer\Exception $exception) {
        error_log('BBB confirmation email failed: ' . $exception->getMessage());
        return false;
    }
}

function setFlashMessage($message, $type = "success") {
    $_SESSION['flash_message'] = array(
        "message" => $message,
        "type" => $type
    );
}

function getFlashMessage() {
    $flash = $_SESSION['flash_message'] ?? null;
    unset($_SESSION['flash_message']);
    return $flash;
}

function stockLabel($quantity) {
    $quantity = (int)$quantity;
    if ($quantity <= 0) {
        return "Out of Stock";
    }
    if ($quantity <= 5) {
        return "Low Stock";
    }
    return "In Stock";
}

function statusClass($status) {
    $value = strtolower(trim($status));
    if (in_array($value, array("active", "confirmed", "payment submitted", "in stock"))) {
        return "positive";
    }
    if (in_array($value, array("inactive", "out of stock"))) {
        return "negative";
    }
    return "warning";
}

function safeReturnUrl($url, $default = "index.php") {
    $url = trim($url ?? "");
    if ($url != "" && preg_match('/^[a-zA-Z0-9_.?=&%+#-]+$/', $url)) {
        return $url;
    }
    return $default;
}

function addProductToCart($conn, $productId, $quantity) {
    $productId = (int)$productId;
    $quantity = max(1, (int)$quantity);

    $stmt = $conn->prepare("SELECT id, name, quantity FROM products WHERE id = ? AND status = 'Active'");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$product) {
        return array("success" => false, "message" => "The selected product is not available.");
    }
    if ((int)$product['quantity'] <= 0) {
        return array("success" => false, "message" => $product['name'] . " is out of stock.");
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    $currentQuantity = (int)($_SESSION['cart'][$productId] ?? 0);
    if ($currentQuantity + $quantity > (int)$product['quantity']) {
        return array("success" => false, "message" => "Only " . $product['quantity'] . " item(s) of " . $product['name'] . " are available.");
    }

    $_SESSION['cart'][$productId] = $currentQuantity + $quantity;
    logActivity($conn, "Added " . $product['name'] . " to cart");
    return array("success" => true, "message" => $product['name'] . " was added to your cart.");
}

function getCartItems($conn) {
    $items = array();
    $total = 0;

    if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
        return array("items" => $items, "total" => $total);
    }

    $ids = array_map("intval", array_keys($_SESSION['cart']));
    $idList = implode(",", $ids);
    $result = $conn->query("SELECT * FROM products WHERE id IN ($idList) AND status = 'Active' ORDER BY name");
    $foundIds = array();

    while ($row = $result->fetch_assoc()) {
        $foundIds[] = (int)$row['id'];
        $quantity = (int)$_SESSION['cart'][$row['id']];
        $row['cart_qty'] = $quantity;
        $row['subtotal'] = $quantity * $row['price'];
        $total += $row['subtotal'];
        $items[] = $row;
    }

    foreach ($ids as $id) {
        if (!in_array($id, $foundIds)) {
            unset($_SESSION['cart'][$id]);
        }
    }

    return array("items" => $items, "total" => $total);
}

function logActivity($conn, $activity) {
    $userId = $_SESSION['user_id'] ?? 0;
    $userName = currentUserName();
    $stmt = $conn->prepare("INSERT INTO audit_logs (user_id, user_name, activity) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $userId, $userName, $activity);
    $stmt->execute();
    $stmt->close();
}

function requireBuyer() {
    if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? "") != "buyer") {
        setFlashMessage("Please log in with a buyer account to continue.", "error");
        header("Location: login.php");
        exit();
    }
}

function requireAdmin() {
    if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? "") != "admin") {
        header("Location: admin_login.php");
        exit();
    }
}
?>
