<?php
$pageTitle = "Checkout";
require 'functions.php';
requireBuyer();

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header("Location: cart.php");
    exit();
}

require 'header.php';

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$buyer = $stmt->get_result()->fetch_assoc();
$stmt->close();

$message = "";
$items = array();
$total = 0;
$ids = implode(",", array_map("intval", array_keys($_SESSION['cart'])));
$result = $conn->query("SELECT * FROM products WHERE id IN ($ids)");

while ($row = $result->fetch_assoc()) {
    $qty = (int)$_SESSION['cart'][$row['id']];
    if ($qty > $row['quantity']) {
        $message = $row['name'] . " does not have enough stock.";
    }
    $row['cart_qty'] = $qty;
    $row['subtotal'] = $qty * $row['price'];
    $total += $row['subtotal'];
    $items[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order']) && $message == "") {
    $shippingAddress = trim($_POST['shipping_address']);
    $contactNumber = trim($_POST['contact_number']);
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

        $newQty = $item['quantity'] - $item['cart_qty'];
        $stmt = $conn->prepare("UPDATE products SET quantity = ? WHERE id = ?");
        $stmt->bind_param("ii", $newQty, $item['id']);
        $stmt->execute();
        $stmt->close();
    }

    $_SESSION['cart'] = array();
    logActivity($conn, "Placed order #" . $orderId);
    header("Location: payment.php?order_id=" . $orderId);
    exit();
}
?>

<div class="panel wide-container">
    <h2>Checkout Page</h2>
    <?php if ($message != "") { ?><div class="message error"><?php echo displayText($message); ?></div><?php } ?>

    <table>
        <tr><th>Product</th><th>Quantity</th><th>Subtotal</th></tr>
        <?php foreach ($items as $item) { ?>
            <tr>
                <td><?php echo displayText($item['name']); ?></td>
                <td><?php echo displayText($item['cart_qty']); ?></td>
                <td><?php echo moneyFormat($item['subtotal']); ?></td>
            </tr>
        <?php } ?>
        <tr><th colspan="2">Total</th><td><strong><?php echo moneyFormat($total); ?></strong></td></tr>
    </table>

    <form method="POST" action="">
        <div class="form-group">
            <label>Complete Address</label>
            <textarea name="shipping_address" required><?php echo displayText($buyer['address']); ?></textarea>
        </div>
        <div class="form-group">
            <label>Contact Numbers</label>
            <input type="text" name="contact_number" value="<?php echo displayText($buyer['contact_number']); ?>" required>
        </div>
        <input type="submit" name="place_order" value="Place Order" class="full-button">
    </form>
</div>

<?php require 'footer.php'; ?>
