<?php
require 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_cart'])) {
    $result = addProductToCart($conn, $_POST['product_id'] ?? 0, 1);
    setFlashMessage($result['message'], $result['success'] ? "success" : "error");
    header("Location: " . safeReturnUrl($_POST['return_url'] ?? "index.php"));
    exit();
}

$pageTitle = "BBB Store";
$search = trim($_GET['q'] ?? "");
$category = trim($_GET['category'] ?? "All");
$sort = $_GET['sort'] ?? "featured";
$sortOptions = array(
    "featured" => "Featured",
    "name" => "Name",
    "price_low" => "Lowest Price",
    "price_high" => "Highest Price"
);
if (!isset($sortOptions[$sort])) {
    $sort = "featured";
}

$categoryRows = $conn->query("SELECT DISTINCT category FROM products WHERE status = 'Active' ORDER BY category");
$categories = array();
while ($row = $categoryRows->fetch_assoc()) {
    $categories[] = $row['category'];
}
if ($category != "All" && !in_array($category, $categories)) {
    $category = "All";
}

$orderBy = array(
    "featured" => "category, name",
    "name" => "name",
    "price_low" => "price ASC, name",
    "price_high" => "price DESC, name"
)[$sort];

$searchLike = "%" . $search . "%";
if ($search != "" && $category != "All") {
    $stmt = $conn->prepare("SELECT * FROM products WHERE status = 'Active' AND category = ? AND (name LIKE ? OR description LIKE ?) ORDER BY $orderBy");
    $stmt->bind_param("sss", $category, $searchLike, $searchLike);
    $stmt->execute();
    $products = $stmt->get_result();
} else if ($search != "") {
    $stmt = $conn->prepare("SELECT * FROM products WHERE status = 'Active' AND (name LIKE ? OR description LIKE ?) ORDER BY $orderBy");
    $stmt->bind_param("ss", $searchLike, $searchLike);
    $stmt->execute();
    $products = $stmt->get_result();
} else if ($category != "All") {
    $stmt = $conn->prepare("SELECT * FROM products WHERE status = 'Active' AND category = ? ORDER BY $orderBy");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $products = $stmt->get_result();
} else {
    $products = $conn->query("SELECT * FROM products WHERE status = 'Active' ORDER BY $orderBy");
}

$currentParams = array();
if ($search != "") $currentParams['q'] = $search;
if ($category != "All") $currentParams['category'] = $category;
if ($sort != "featured") $currentParams['sort'] = $sort;
$returnUrl = "index.php" . (count($currentParams) ? "?" . http_build_query($currentParams) : "");

$heroImage = "BBB/JPG Files/BBB - 6.jpg";
if ($category != "All") {
    $stmtImg = $conn->prepare("SELECT image FROM products WHERE category = ? AND status = 'Active' LIMIT 1");
    $stmtImg->bind_param("s", $category);
    $stmtImg->execute();
    $resImg = $stmtImg->get_result();
    if ($rowImg = $resImg->fetch_assoc()) {
        $heroImage = $rowImg['image'];
    }
}


require 'header.php';
?>

<section class="hero">
    <div class="hero-copy">
        <p class="hero-kicker">NEW COLLECTION</p>
        <h1>BBB</h1>
        <p>Refined essentials. Modern silhouettes. Clothing designed beyond the basics.</p>
        <div class="hero-actions">
            <a class="button-link" href="#collection">Shop Collection</a>
            <a class="button-link secondary-button" href="about.php">Discover BBB</a>
        </div>
    </div>
    <div class="hero-visual">
        <img src="<?php echo displayText($heroImage); ?>" alt="BBB Collection">
    </div>
</section>

<section class="store-panel" id="collection">
    <div class="section-heading">
        <div>
            <h2>Shop the Collection</h2>
            <p class="muted"><?php echo displayText($products->num_rows); ?> styles</p>
        </div>
    </div>

    <form method="GET" action="index.php" class="filter-form store-filter" role="search">
        <div class="form-group">
            <label for="store-search">Search products</label>
            <input id="store-search" type="text" name="q" value="<?php echo displayText($search); ?>" placeholder="Search by name or description">
        </div>
        <div class="form-group">
            <label for="store-category">Category</label>
            <select id="store-category" name="category">
                <option value="All">All Categories</option>
                <?php foreach ($categories as $itemCategory) { ?>
                    <option value="<?php echo displayText($itemCategory); ?>" <?php if ($category == $itemCategory) echo 'selected'; ?>><?php echo displayText($itemCategory); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="store-sort">Sort by</label>
            <select id="store-sort" name="sort">
                <?php foreach ($sortOptions as $value => $label) { ?>
                    <option value="<?php echo displayText($value); ?>" <?php if ($sort == $value) echo 'selected'; ?>><?php echo displayText($label); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="filter-actions">
            <button type="submit">Apply</button>
            <a href="index.php" class="button-link secondary-button">Clear</a>
        </div>
    </form>

    <div class="category-tabs" aria-label="Product categories">
        <?php
        $allParams = array();
        if ($search != "") $allParams['q'] = $search;
        if ($sort != "featured") $allParams['sort'] = $sort;
        ?>
        <a href="index.php<?php echo count($allParams) ? '?' . displayText(http_build_query($allParams)) : ''; ?>" class="<?php if ($category == 'All') echo 'active'; ?>">All</a>
        <?php foreach ($categories as $itemCategory) {
            $categoryParams = $allParams;
            $categoryParams['category'] = $itemCategory;
        ?>
            <a href="index.php?<?php echo displayText(http_build_query($categoryParams)); ?>" class="<?php if ($category == $itemCategory) echo 'active'; ?>">
                <?php echo displayText($itemCategory); ?>
            </a>
        <?php } ?>
    </div>

    <?php if ($products->num_rows == 0) { ?>
        <div class="empty-state">
            <h3>No products found</h3>
            <p>Try another search term or clear the current filters.</p>
            <a href="index.php" class="button-link">View All Products</a>
        </div>
    <?php } else { ?>
        <div class="product-grid">
            <?php while ($row = $products->fetch_assoc()) { ?>
                <article class="product-card">
                    <a class="product-image-link" href="product.php?id=<?php echo displayText($row['id']); ?>">
                        <img src="<?php echo displayText($row['image']); ?>" alt="<?php echo displayText($row['name']); ?>">
                    </a>
                    <div class="product-body">
                        <p class="eyebrow"><?php echo displayText($row['category']); ?></p>
                        <h3><a href="product.php?id=<?php echo displayText($row['id']); ?>"><?php echo displayText($row['name']); ?></a></h3>
                        <p class="muted product-description"><?php echo displayText($row['description']); ?></p>
                        <div class="product-meta">
                            <span class="price"><?php echo moneyFormat($row['price']); ?></span>
                            <span class="badge <?php echo statusClass(stockLabel($row['quantity'])); ?>"><?php echo displayText(stockLabel($row['quantity'])); ?></span>
                        </div>
                        <div class="product-actions">
                            <a class="button-link secondary-button" href="product.php?id=<?php echo displayText($row['id']); ?>">View Product</a>
                            <form method="POST" action="index.php">
                                <input type="hidden" name="product_id" value="<?php echo displayText($row['id']); ?>">
                                <input type="hidden" name="return_url" value="<?php echo displayText($returnUrl); ?>">
                                <input type="submit" name="add_cart" value="ADD" class="full-button" <?php if ($row['quantity'] <= 0) echo 'disabled'; ?>>
                            </form>
                        </div>
                    </div>
                </article>
            <?php } ?>
        </div>
    <?php } ?>
</section>

<?php require 'footer.php'; ?>
