<?php
$pageTitle = "Payment";
require 'functions.php';
requireBuyer();

$orderId = (int)($_GET['order_id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $orderId, $_SESSION['user_id']);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$order) {
    header("Location: index.php");
    exit();
}

require 'header.php';

$message = "";
$messageClass = "success";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pay'])) {
    $method = $_POST['payment_method'];
    $status = "Payment Submitted";
    $stmt = $conn->prepare("UPDATE orders SET payment_method = ?, status = ? WHERE id = ?");
    $stmt->bind_param("ssi", $method, $status, $orderId);
    $stmt->execute();
    $stmt->close();
    logActivity($conn, "Submitted payment for order #" . $orderId);
    $message = "Payment information submitted. No payment API is used in this project.";
    $order['payment_method'] = $method;
    $order['status'] = $status;
}
?>

<div class="panel form-container">
    <h2>Payment Page</h2>
    <?php if ($message != "") { ?><div class="message <?php echo $messageClass; ?>"><?php echo displayText($message); ?></div><?php } ?>
    <table>
        <tr><th>Order Number</th><td>#<?php echo displayText($order['id']); ?></td></tr>
        <tr><th>Total Amount</th><td><?php echo moneyFormat($order['total_amount']); ?></td></tr>
        <tr><th>Status</th><td><?php echo displayText($order['status']); ?></td></tr>
        <tr><th>Payment Method</th><td><?php echo displayText($order['payment_method'] ?? 'Not selected'); ?></td></tr>
    </table>

    <form method="POST" action="">
        <div class="form-group">
            <label>Payment Method</label>
            <select name="payment_method" required>
                <option value="Cash on Delivery">Cash on Delivery</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Store Pickup Payment">Store Pickup Payment</option>
            </select>
        </div>
        <input type="submit" name="pay" value="Submit Payment" class="full-button">
    </form>
</div>

<?php require 'footer.php'; ?>
