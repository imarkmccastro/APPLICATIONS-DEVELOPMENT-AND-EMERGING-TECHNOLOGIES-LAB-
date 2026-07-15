<?php
require 'functions.php';
requireBuyer();

$selectedId = (int)($_GET['id'] ?? 0);
$selectedOrder = null;
$selectedItems = null;
if ($selectedId > 0) {
    $stmt = $conn->prepare("SELECT current_order.*, (SELECT COUNT(*) FROM orders earlier_order WHERE earlier_order.user_id = current_order.user_id AND earlier_order.id <= current_order.id) AS customer_order_number FROM orders current_order WHERE current_order.id = ? AND current_order.user_id = ?");
    $stmt->bind_param("ii", $selectedId, $_SESSION['user_id']);
    $stmt->execute();
    $selectedOrder = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if ($selectedOrder) {
        $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ? ORDER BY id");
        $stmt->bind_param("i", $selectedId);
        $stmt->execute();
        $selectedItems = $stmt->get_result();
        $stmt->close();
        logActivity($conn, "Viewed order #" . $selectedId);
    } else {
        setFlashMessage("That order does not belong to your account or does not exist.", "error");
        header("Location: orders.php");
        exit();
    }
}

$stmt = $conn->prepare("SELECT current_order.*, (SELECT COUNT(*) FROM orders earlier_order WHERE earlier_order.user_id = current_order.user_id AND earlier_order.id <= current_order.id) AS customer_order_number FROM orders current_order WHERE current_order.user_id = ? ORDER BY current_order.created_at DESC, current_order.id DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$orders = $stmt->get_result();
$stmt->close();

$pageTitle = "My Orders";
require 'header.php';
?>

<section class="panel wide-container">
    <div class="section-heading"><div><h2>My Orders</h2><p class="muted">Review your BBB order history and payment status.</p></div><a href="index.php" class="text-link">Continue Shopping</a></div>
    <?php if ($orders->num_rows == 0) { ?>
        <div class="empty-state"><h3>No orders yet</h3><p>Your completed checkouts will appear here.</p><a href="index.php" class="button-link">Browse Products</a></div>
    <?php } else { ?>
        <div class="table-scroll">
            <table>
                <thead><tr><th>Order</th><th>Date</th><th>Total</th><th>Payment</th><th>Status</th><th>Action</th></tr></thead>
                <tbody><?php while ($row = $orders->fetch_assoc()) { ?>
                    <tr>
                        <td><strong>#<?php echo displayText($row['customer_order_number']); ?></strong></td>
                        <td><?php echo displayText(date("M d, Y", strtotime($row['created_at']))); ?></td>
                        <td><?php echo moneyFormat($row['total_amount']); ?></td>
                        <td><?php echo displayText($row['payment_method'] ?: 'Not selected'); ?></td>
                        <td><span class="badge <?php echo statusClass($row['status']); ?>"><?php echo displayText($row['status']); ?></span></td>
                        <td><a href="orders.php?id=<?php echo displayText($row['id']); ?>">View Details</a></td>
                    </tr>
                <?php } ?></tbody>
            </table>
        </div>
    <?php } ?>
</section>

<?php if ($selectedOrder) { ?>
    <section class="panel wide-container order-detail-panel">
        <div class="section-heading"><div><h2>Order #<?php echo displayText($selectedOrder['customer_order_number']); ?></h2><p class="muted"><?php echo displayText(date("F d, Y - h:i A", strtotime($selectedOrder['created_at']))); ?></p></div><span class="badge <?php echo statusClass($selectedOrder['status']); ?>"><?php echo displayText($selectedOrder['status']); ?></span></div>
        <div class="order-detail-grid"><div><span>Shipping Address</span><strong><?php echo displayText($selectedOrder['shipping_address']); ?></strong></div><div><span>Contact Number</span><strong><?php echo displayText($selectedOrder['contact_number']); ?></strong></div><div><span>Payment Method</span><strong><?php echo displayText($selectedOrder['payment_method'] ?: 'Not selected'); ?></strong></div></div>
        <div class="table-scroll"><table><thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr></thead><tbody>
            <?php while ($item = $selectedItems->fetch_assoc()) { ?><tr><td><?php echo displayText($item['product_name']); ?></td><td><?php echo moneyFormat($item['price']); ?></td><td><?php echo displayText($item['quantity']); ?></td><td><?php echo moneyFormat($item['subtotal']); ?></td></tr><?php } ?>
            <tr><th colspan="3">Total</th><td><strong><?php echo moneyFormat($selectedOrder['total_amount']); ?></strong></td></tr>
        </tbody></table></div>
    </section>
<?php } ?>

<?php require 'footer.php'; ?>
