<?php
require 'functions.php';
requireBuyer();

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    setFlashMessage("Your cart is empty.", "warning");
    header("Location: cart.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$buyer = $stmt->get_result()->fetch_assoc();
$stmt->close();

$cart = getCartItems($conn);
$items = $cart['items'];
$total = $cart['total'];
$message = "";
$shippingAddress = trim($_POST['shipping_address'] ?? $buyer['address']);
$contactNumber = trim($_POST['contact_number'] ?? $buyer['contact_number']);

foreach ($items as $item) {
    if ($item['status'] != 'Active' || $item['cart_qty'] > $item['quantity']) {
        $message = $item['name'] . " does not have enough available stock. Please update your cart.";
        break;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order']) && $message == "") {
    if ($shippingAddress == "") {
        $message = "Please enter a complete shipping address.";
    } else if (!preg_match('/^[0-9+() -]{7,20}$/', $contactNumber)) {
        $message = "Please enter a valid contact number.";
    } else {
        $status = "For Payment";
        $userId = $_SESSION['user_id'];
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status, shipping_address, contact_number) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("idsss", $userId, $total, $status, $shippingAddress, $contactNumber);
        $stmt->execute();
        $orderId = $stmt->insert_id;
        $stmt->close();

        foreach ($items as $item) {
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iisidd", $orderId, $item['id'], $item['name'], $item['price'], $item['cart_qty'], $item['subtotal']);
            $stmt->execute();
            $stmt->close();

            $newQuantity = $item['quantity'] - $item['cart_qty'];
            $stmt = $conn->prepare("UPDATE products SET quantity = ? WHERE id = ?");
            $stmt->bind_param("ii", $newQuantity, $item['id']);
            $stmt->execute();
            $stmt->close();
        }

        $_SESSION['cart'] = array();
        logActivity($conn, "Placed order #" . $orderId);
        header("Location: payment.php?order_id=" . $orderId);
        exit();
    }
}

$pageTitle = "Checkout";
require 'header.php';
?>

<div class="checkout-steps" aria-label="Checkout progress">
    <span class="complete">1. Cart</span><span class="active">2. Checkout</span><span>3. Payment</span>
</div>

<section class="checkout-layout">
    <div class="panel checkout-form-panel">
        <h2>Shipping Details</h2>
        <?php if ($message != "") { ?><div class="message error" role="alert"><?php echo displayText($message); ?></div><?php } ?>
        <form method="POST" action="checkout.php">
            <div class="form-group">
                <label for="shipping-address">Complete Address <span class="required">Required</span></label>
                <textarea id="shipping-address" name="shipping_address" autocomplete="street-address" required><?php echo displayText($shippingAddress); ?></textarea>
            </div>
            <div class="form-group">
                <label for="checkout-contact">Contact Number <span class="required">Required</span></label>
                <input id="checkout-contact" type="text" name="contact_number" value="<?php echo displayText($contactNumber); ?>" pattern="[0-9+() -]{7,20}" autocomplete="tel" required>
            </div>
            <input type="submit" name="place_order" value="Place Order" class="full-button">
        </form>
    </div>
    <aside class="panel order-summary">
        <h2>Order Summary</h2>
        <?php foreach ($items as $item) { ?>
            <div class="summary-item"><span><?php echo displayText($item['name']); ?> x <?php echo displayText($item['cart_qty']); ?></span><strong><?php echo moneyFormat($item['subtotal']); ?></strong></div>
        <?php } ?>
        <div class="summary-total"><span>Total</span><strong><?php echo moneyFormat($total); ?></strong></div>
        <a href="cart.php" class="text-link">Return to Cart</a>
    </aside>
</section>

<?php require 'footer.php'; ?>
