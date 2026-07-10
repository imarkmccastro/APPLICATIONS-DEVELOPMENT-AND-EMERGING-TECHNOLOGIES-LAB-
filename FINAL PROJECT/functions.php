<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'database.php';

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
    if ($url != "" && preg_match('/^[a-zA-Z0-9_.?=&%+-]+$/', $url)) {
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
