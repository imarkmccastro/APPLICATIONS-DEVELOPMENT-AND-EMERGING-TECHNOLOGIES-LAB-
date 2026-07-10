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

function logActivity($conn, $activity) {
    $userId = $_SESSION['user_id'] ?? 0;
    $userName = currentUserName();
    $stmt = $conn->prepare("INSERT INTO audit_logs (user_id, user_name, activity) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $userId, $userName, $activity);
    $stmt->execute();
    $stmt->close();
}

function requireBuyer() {
    if (!isset($_SESSION['user_id'])) {
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
