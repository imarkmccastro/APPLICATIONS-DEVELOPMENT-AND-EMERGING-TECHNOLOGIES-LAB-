<?php
require 'functions.php';

$productId = (int)($_GET['id'] ?? $_POST['product_id'] ?? 0);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_cart'])) {
    $result = addProductToCart($conn, $productId, $_POST['quantity'] ?? 1);
    setFlashMessage($result['message'], $result['success'] ? "success" : "error");
    header("Location: product.php?id=" . $productId);
    exit();
}

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND status = 'Active'");
$stmt->bind_param("i", $productId);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

$pageTitle = $product ? $product['name'] . " - BBB" : "Product Not Found";
$relatedProducts = null;
if ($product) {
    $stmt = $conn->prepare("SELECT id, name, price, quantity, image FROM products WHERE category = ? AND status = 'Active' AND id != ? ORDER BY name LIMIT 3");
    $stmt->bind_param("si", $product['category'], $productId);
    $stmt->execute();
    $relatedProducts = $stmt->get_result();
}

require 'header.php';
?>

<?php if (!$product) { http_response_code(404); ?>
    <div class="panel form-container empty-state">
        <h2>Product Not Found</h2>
        <p>The product may be inactive or no longer available.</p>
        <a href="index.php" class="button-link">Return to Store</a>
    </div>
<?php } else { ?>
    <div class="nav-links"><a href="index.php">Back to Store</a></div>
    <section class="panel product-detail">
        <div class="product-detail-image">
            <img src="<?php echo displayText($product['image']); ?>" alt="<?php echo displayText($product['name']); ?>">
        </div>
        <div class="product-detail-copy">
            <p class="eyebrow"><?php echo displayText($product['category']); ?></p>
            <h1><?php echo displayText($product['name']); ?></h1>
            <p class="price detail-price"><?php echo moneyFormat($product['price']); ?></p>
            <span class="badge <?php echo statusClass(stockLabel($product['quantity'])); ?>"><?php echo displayText(stockLabel($product['quantity'])); ?></span>
            <p class="lead"><?php echo displayText($product['description']); ?></p>
            <p class="muted"><?php echo displayText($product['quantity']); ?> item(s) currently available</p>
            <form method="POST" action="product.php?id=<?php echo displayText($productId); ?>" class="detail-cart-form">
                <input type="hidden" name="product_id" value="<?php echo displayText($productId); ?>">
                <div class="form-group quantity-field">
                    <label for="product-quantity">Quantity</label>
                    <input id="product-quantity" type="number" name="quantity" value="1" min="1" max="<?php echo displayText($product['quantity']); ?>" required>
                </div>
                <input type="submit" name="add_cart" value="ADD" class="full-button" <?php if ($product['quantity'] <= 0) echo 'disabled'; ?>>
            </form>
        </div>
    </section>

    <?php if ($relatedProducts && $relatedProducts->num_rows > 0) { ?>
        <section class="related-section">
            <h2>More From <?php echo displayText($product['category']); ?></h2>
            <div class="product-grid compact-grid">
                <?php while ($related = $relatedProducts->fetch_assoc()) { ?>
                    <article class="product-card">
                        <a class="product-image-link" href="product.php?id=<?php echo displayText($related['id']); ?>">
                            <img src="<?php echo displayText($related['image']); ?>" alt="<?php echo displayText($related['name']); ?>">
                        </a>
                        <div class="product-body">
                            <h3><a href="product.php?id=<?php echo displayText($related['id']); ?>"><?php echo displayText($related['name']); ?></a></h3>
                            <div class="product-meta"><span class="price"><?php echo moneyFormat($related['price']); ?></span><span class="badge <?php echo statusClass(stockLabel($related['quantity'])); ?>"><?php echo displayText(stockLabel($related['quantity'])); ?></span></div>
                        </div>
                    </article>
                <?php } ?>
            </div>
        </section>
    <?php } ?>
<?php } ?>

<?php require 'footer.php'; ?>
