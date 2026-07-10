<?php
require 'functions.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_id'])) {
    $productId = (int)$_POST['remove_id'];
    unset($_SESSION['cart'][$productId]);
    logActivity($conn, "Removed item from cart");
    setFlashMessage("The product was removed from your cart.");
    header("Location: cart.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_cart'])) {
    $adjusted = false;
    foreach (($_POST['qty'] ?? array()) as $productId => $quantity) {
        $productId = (int)$productId;
        $quantity = (int)$quantity;

        $stmt = $conn->prepare("SELECT quantity, status FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$product || $product['status'] != 'Active' || $quantity <= 0) {
            unset($_SESSION['cart'][$productId]);
        } else {
            if ($quantity > (int)$product['quantity']) {
                $quantity = (int)$product['quantity'];
                $adjusted = true;
            }
            if ($quantity <= 0) {
                unset($_SESSION['cart'][$productId]);
            } else {
                $_SESSION['cart'][$productId] = $quantity;
            }
        }
    }
    logActivity($conn, "Updated cart quantities");
    setFlashMessage($adjusted ? "Cart updated. A quantity was adjusted to match available stock." : "Your cart was updated.", $adjusted ? "warning" : "success");
    header("Location: cart.php");
    exit();
}

$cart = getCartItems($conn);
$items = $cart['items'];
$total = $cart['total'];
$pageTitle = "Shopping Cart";
require 'header.php';
?>

<div class="checkout-steps" aria-label="Checkout progress">
    <span class="active">1. Cart</span><span>2. Checkout</span><span>3. Payment</span>
</div>

<section class="panel wide-container">
    <div class="section-heading">
        <div><h2>Shopping Cart</h2><p class="muted"><?php echo cartCount(); ?> item(s)</p></div>
        <?php if (count($items) > 0) { ?><a href="index.php" class="text-link">Continue Shopping</a><?php } ?>
    </div>

    <?php if (count($items) == 0) { ?>
        <div class="empty-state">
            <h3>Your cart is empty</h3>
            <p>Explore the BBB collection and add an item to begin your order.</p>
            <a href="index.php" class="button-link">Browse Products</a>
        </div>
    <?php } else { ?>
        <form method="POST" action="cart.php">
            <div class="table-scroll">
                <table>
                    <thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Action</th></tr></thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td>
                                <a class="product-cell" href="product.php?id=<?php echo displayText($item['id']); ?>">
                                    <img src="<?php echo displayText($item['image']); ?>" alt="">
                                    <span><strong><?php echo displayText($item['name']); ?></strong><small><?php echo displayText($item['category']); ?></small></span>
                                </a>
                            </td>
                            <td><?php echo moneyFormat($item['price']); ?></td>
                            <td><input class="quantity-input" type="number" name="qty[<?php echo displayText($item['id']); ?>]" min="1" max="<?php echo displayText($item['quantity']); ?>" value="<?php echo displayText($item['cart_qty']); ?>" aria-label="Quantity for <?php echo displayText($item['name']); ?>"></td>
                            <td><strong><?php echo moneyFormat($item['subtotal']); ?></strong></td>
                            <td><button type="submit" name="remove_id" value="<?php echo displayText($item['id']); ?>" class="text-button danger">Remove</button></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="cart-summary">
                <div><span>Order Total</span><strong><?php echo moneyFormat($total); ?></strong></div>
                <p class="muted">Final payment method is selected after checkout.</p>
            </div>
            <div class="cart-actions">
                <input type="submit" name="update_cart" value="Update Cart">
                <a href="checkout.php" class="button-link">Proceed to Checkout</a>
            </div>
        </form>
    <?php } ?>
</section>

<?php require 'footer.php'; ?>
