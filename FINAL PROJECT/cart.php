<?php
$pageTitle = "Shopping Cart";
require 'header.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_cart'])) {
    foreach ($_POST['qty'] as $productId => $qty) {
        $qty = (int)$qty;
        if ($qty <= 0) {
            unset($_SESSION['cart'][$productId]);
        } else {
            $_SESSION['cart'][$productId] = $qty;
        }
    }
    logActivity($conn, "Updated cart quantities");
    header("Location: cart.php");
    exit();
}

if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][(int)$_GET['remove']]);
    logActivity($conn, "Removed item from cart");
    header("Location: cart.php");
    exit();
}

$items = array();
$total = 0;

if (count($_SESSION['cart']) > 0) {
    $ids = array_keys($_SESSION['cart']);
    $idList = implode(",", array_map("intval", $ids));
    $result = $conn->query("SELECT * FROM products WHERE id IN ($idList)");
    while ($row = $result->fetch_assoc()) {
        $qty = (int)$_SESSION['cart'][$row['id']];
        $subtotal = $qty * $row['price'];
        $total += $subtotal;
        $row['cart_qty'] = $qty;
        $row['subtotal'] = $subtotal;
        $items[] = $row;
    }
}
?>

<div class="panel wide-container">
    <h2>Cart Page</h2>

    <?php if (count($items) == 0) { ?>
        <div class="message">Your cart is empty.</div>
        <a href="index.php" class="button-link">Back to Store</a>
    <?php } else { ?>
        <form method="POST" action="">
            <table>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($items as $item) { ?>
                    <tr>
                        <td><?php echo displayText($item['name']); ?></td>
                        <td><?php echo moneyFormat($item['price']); ?></td>
                        <td><input type="number" name="qty[<?php echo displayText($item['id']); ?>]" min="0" max="<?php echo displayText($item['quantity']); ?>" value="<?php echo displayText($item['cart_qty']); ?>"></td>
                        <td><?php echo moneyFormat($item['subtotal']); ?></td>
                        <td><a href="cart.php?remove=<?php echo displayText($item['id']); ?>">Remove</a></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th colspan="3">Total</th>
                    <td colspan="2"><strong><?php echo moneyFormat($total); ?></strong></td>
                </tr>
            </table>
            <input type="submit" name="update_cart" value="Update Cart">
            <a href="checkout.php" class="button-link">Proceed to Checkout</a>
        </form>
    <?php } ?>
</div>

<?php require 'footer.php'; ?>
