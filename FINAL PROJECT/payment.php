<?php
require 'functions.php';
requireBuyer();

$orderId = (int)($_GET['order_id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $orderId, $_SESSION['user_id']);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$order) {
    setFlashMessage("The requested order could not be found.", "error");
    header("Location: orders.php");
    exit();
}

$paymentMethods = array("Cash on Delivery", "Bank Transfer", "Store Pickup Payment");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pay']) && $order['status'] != "Payment Submitted") {
    $method = $_POST['payment_method'] ?? "";
    if (in_array($method, $paymentMethods)) {
        $status = "Payment Submitted";
        $stmt = $conn->prepare("UPDATE orders SET payment_method = ?, status = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssii", $method, $status, $orderId, $_SESSION['user_id']);
        $stmt->execute();
        $stmt->close();
        logActivity($conn, "Completed payment selection for order #" . $orderId);
        setFlashMessage("Payment information for order #" . $orderId . " was submitted.");
        header("Location: payment.php?order_id=" . $orderId);
        exit();
    }
    setFlashMessage("Please select a valid payment method.", "error");
    header("Location: payment.php?order_id=" . $orderId);
    exit();
}

$stmt = $conn->prepare("SELECT product_name, price, quantity, subtotal FROM order_items WHERE order_id = ? ORDER BY id");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$orderItems = $stmt->get_result();
$stmt->close();

$pageTitle = "Payment";
require 'header.php';
?>

<div class="checkout-steps" aria-label="Checkout progress">
    <span class="complete">1. Cart</span><span class="complete">2. Checkout</span><span class="active">3. Payment</span>
</div>

<section class="checkout-layout">
    <div class="panel payment-panel">
        <?php if ($order['status'] == "Payment Submitted") { ?>
            <div class="completion-mark" aria-hidden="true">&#10003;</div>
            <h2>Order Confirmed</h2>
            <p class="lead">Your payment selection has been recorded for order #<?php echo displayText($order['id']); ?>.</p>
            <div class="completion-actions"><a href="orders.php?id=<?php echo displayText($order['id']); ?>" class="button-link">View Order</a><a href="index.php" class="button-link secondary-button">Continue Shopping</a></div>
        <?php } else { ?>
            <h2>Select Payment</h2>
            <form method="POST" action="payment.php?order_id=<?php echo displayText($orderId); ?>">
                <div class="form-group">
                    <label for="payment-method">Payment Method <span class="required">Required</span></label>
                    <select id="payment-method" name="payment_method" required>
                        <?php foreach ($paymentMethods as $method) { ?><option value="<?php echo displayText($method); ?>"><?php echo displayText($method); ?></option><?php } ?>
                    </select>
                </div>
                <input type="submit" name="pay" value="Submit Payment" class="full-button">
            </form>
            <p class="muted center-text">No payment API is used for this educational project.</p>
        <?php } ?>
    </div>
    <aside class="panel order-summary">
        <h2>Order #<?php echo displayText($order['id']); ?></h2>
        <?php while ($item = $orderItems->fetch_assoc()) { ?>
            <div class="summary-item"><span><?php echo displayText($item['product_name']); ?> x <?php echo displayText($item['quantity']); ?></span><strong><?php echo moneyFormat($item['subtotal']); ?></strong></div>
        <?php } ?>
        <div class="summary-total"><span>Total</span><strong><?php echo moneyFormat($order['total_amount']); ?></strong></div>
        <div class="summary-detail"><span>Status</span><span class="badge <?php echo statusClass($order['status']); ?>"><?php echo displayText($order['status']); ?></span></div>
        <div class="summary-detail"><span>Payment</span><strong><?php echo displayText($order['payment_method'] ?: 'Not selected'); ?></strong></div>
    </aside>
</section>

<?php require 'footer.php'; ?>
