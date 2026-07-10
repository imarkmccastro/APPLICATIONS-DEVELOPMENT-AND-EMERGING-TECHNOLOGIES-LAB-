<?php
$pageTitle = "ThreadLine Store";
require 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_cart'])) {
    $productId = (int)$_POST['product_id'];
    $qty = 1;

    $stmt = $conn->prepare("SELECT id, name, quantity FROM products WHERE id = ? AND status = 'Active'");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();

    if ($product && $product['quantity'] > 0) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + $qty;
        logActivity($conn, "Added " . $product['name'] . " to cart");
        header("Location: cart.php");
        exit();
    }
}

$category = $_GET['category'] ?? "All";
$categories = $conn->query("SELECT DISTINCT category FROM products WHERE status = 'Active' ORDER BY category");

if ($category != "All") {
    $stmt = $conn->prepare("SELECT * FROM products WHERE status = 'Active' AND category = ? ORDER BY name");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $products = $stmt->get_result();
} else {
    $products = $conn->query("SELECT * FROM products WHERE status = 'Active' ORDER BY category, name");
}

$productCount = $conn->query("SELECT COUNT(*) AS total FROM products WHERE status = 'Active'")->fetch_assoc()['total'];
$stockCount = $conn->query("SELECT SUM(quantity) AS total FROM products WHERE status = 'Active'")->fetch_assoc()['total'];
?>

<section class="hero">
    <div class="panel hero-copy">
        <h1>ThreadLine Clothing</h1>
        <p class="lead">A student-built online shop for shirts, hoodies, pants, dresses, and accessories. Products are grouped by category and can be added to the cart before checkout.</p>
        <div class="stat-grid">
            <div class="stat"><strong><?php echo displayText($productCount); ?></strong><span>Products</span></div>
            <div class="stat"><strong><?php echo displayText($stockCount ?? 0); ?></strong><span>Items in stock</span></div>
            <div class="stat"><strong>2ND3T</strong><span>Project Group</span></div>
        </div>
    </div>
    <div class="panel">
        <h3>Buyer Part</h3>
        <p class="lead">Register, confirm your email, add clothing items to the cart, checkout, and select a sample payment method.</p>
        <a class="button-link" href="register.php">Create Buyer Account</a>
        <a class="button-link secondary-button" href="cart.php">View Cart</a>
    </div>
</section>

<div class="panel">
    <h2>Store Products</h2>
    <div class="category-tabs">
        <a href="index.php" class="<?php if ($category == 'All') echo 'active'; ?>">All</a>
        <?php while ($cat = $categories->fetch_assoc()) { ?>
            <a href="index.php?category=<?php echo urlencode($cat['category']); ?>" class="<?php if ($category == $cat['category']) echo 'active'; ?>">
                <?php echo displayText($cat['category']); ?>
            </a>
        <?php } ?>
    </div>

    <div class="product-grid">
        <?php while ($row = $products->fetch_assoc()) { ?>
            <div class="product-card">
                <img src="<?php echo displayText($row['image']); ?>" alt="<?php echo displayText($row['name']); ?>">
                <div class="product-body">
                    <h3><?php echo displayText($row['name']); ?></h3>
                    <p class="muted"><?php echo displayText($row['description']); ?></p>
                    <div class="product-meta">
                        <span class="price"><?php echo moneyFormat($row['price']); ?></span>
                        <span><?php echo displayText($row['quantity']); ?> left</span>
                    </div>
                    <form method="POST" action="">
                        <input type="hidden" name="product_id" value="<?php echo displayText($row['id']); ?>">
                        <input type="submit" name="add_cart" value="Add to Cart" class="full-button" <?php if ($row['quantity'] <= 0) echo 'disabled'; ?>>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php require 'footer.php'; ?>
