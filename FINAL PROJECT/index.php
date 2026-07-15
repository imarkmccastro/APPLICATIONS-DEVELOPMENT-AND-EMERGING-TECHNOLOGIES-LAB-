<?php
require 'functions.php';

// Always show the editorial showcase when the Final Project folder is opened.
// The showcase enters the store through index.php?from=showcase, which avoids a loop.
$requestedPath = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? "", PHP_URL_PATH));
$openedProjectFolder = substr(rtrim($requestedPath, "/"), -13) === "FINAL PROJECT";
if ($openedProjectFolder || !isset($_SESSION['showcase_seen'])) {
    header("Location: showcase.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_cart'])) {
    if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? "") != "buyer") {
        setFlashMessage("Please log in or register before adding items to your bag.", "warning");
        header("Location: login.php?return_to=" . urlencode(safeReturnUrl($_POST['return_url'] ?? "index.php")));
        exit();
    }
    $result = addProductToCart($conn, $_POST['product_id'] ?? 0, 1);
    setFlashMessage($result['message'], $result['success'] ? "success" : "error");
    header("Location: " . safeReturnUrl($_POST['return_url'] ?? "index.php"));
    exit();
}

$pageTitle = "BBB Store";
$fromShowcase = ($_GET['from'] ?? '') === 'showcase';
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
$heroImage = "BBB/Logo & Theme/Background-4.jpg";

// Map categories to specific model photos
$modelPhotos = array(
    "Accessories" => "BBB/Models/BBB - 28(1).png",
    "Bottoms" =>     "BBB/Models/BBB - 29(1).png",
    "Dresses" =>     "BBB/Models/BBB - 30(1).png",
    "Men Tops" =>    "BBB/Models/BBB - 31(1).png",
    "Outerwear" =>   "BBB/Models/BBB - 32.png",
    "Women Tops" =>  "BBB/Models/BBB - 33(1).png"
);

if ($category != "All" && isset($modelPhotos[$category])) {
    $heroImage = $modelPhotos[$category];
} else if ($category != "All") {
    // Fallback if we don't have a specific model mapped
    $heroImage = "BBB/Models/BBB - 31.png";
}


require 'header.php';
?>

<?php if ($fromShowcase) { ?>
    <div class="showcase-arrival" id="showcase-arrival" aria-hidden="true">
        <div class="showcase-arrival-inner">
            <span class="showcase-arrival-mark">bbb</span>
            <span class="showcase-arrival-rule"></span>
        </div>
    </div>
    <noscript><style>.showcase-arrival { display: none; }</style></noscript>
    <script>
        window.addEventListener('load', function () {
            var arrival = document.getElementById('showcase-arrival');
            if (!arrival) return;
            var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            window.setTimeout(function () {
                arrival.classList.add('is-revealed');
            }, reducedMotion ? 0 : 120);
            window.setTimeout(function () {
                arrival.remove();
            }, reducedMotion ? 80 : 1420);
        });
    </script>
<?php } ?>

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
    <?php } else { 
        $allProducts = array();
        while ($row = $products->fetch_assoc()) {
            $allProducts[] = $row;
        }
        
        $groupedProducts = array();
        foreach ($allProducts as $p) {
            $groupedProducts[$p['category']][] = $p;
        }
        
        foreach ($groupedProducts as $catName => $items) {
            $count = count($items);
    ?>
        <div class="category-section">
            <div class="category-group-header">
                <h2 class="category-title"><?php echo strtoupper(displayText($catName)); ?> <span class="category-arrows">>></span></h2>
                <div class="category-count"><?php echo $count; ?> / <?php echo $count; ?></div>
            </div>
            
            <div class="product-grid<?php if ($category === 'All') echo ' category-product-track'; ?>"<?php if ($category === 'All') { ?> tabindex="0" aria-label="<?php echo displayText($catName); ?> products; scroll horizontally to view more"<?php } ?>>
                <?php foreach ($items as $row) { ?>
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
            <?php if ($category === 'All') { ?>
                <div class="category-scroll-line" aria-hidden="true"><span></span></div>
            <?php } ?>
        </div>
        <?php if ($category === "All" && $catName === "Bottoms") { ?>
            <figure class="collection-editorial-break">
                <img src="BBB/Logo & Theme/Background-3.jpg" alt="BBB black and white tailoring campaign">
                <figcaption>
                    <span>BBB Editorial / Tailored Form</span>
                    <span>Built Beyond Basics</span>
                </figcaption>
            </figure>
        <?php } ?>
    <?php 
        } 
    } 
    ?>
</section>

<?php if ($category === 'All') { ?>
<script>
    (function () {
        var rails = document.querySelectorAll('.category-product-track');

        function updateIndicator(rail) {
            var line = rail.nextElementSibling;
            if (!line || !line.classList.contains('category-scroll-line')) return;
            var thumb = line.querySelector('span');
            var scrollable = rail.scrollWidth - rail.clientWidth;
            var visibleRatio = Math.min(1, rail.clientWidth / rail.scrollWidth);
            var travel = line.clientWidth * (1 - visibleRatio);
            var progress = scrollable > 0 ? rail.scrollLeft / scrollable : 0;
            thumb.style.width = (visibleRatio * 100) + '%';
            thumb.style.transform = 'translateX(' + (travel * progress) + 'px)';
            line.hidden = scrollable <= 1;
        }

        rails.forEach(function (rail) {
            var dragging = false;
            var moved = false;
            var suppressClick = false;
            var startX = 0;
            var startScrollLeft = 0;

            updateIndicator(rail);
            rail.addEventListener('scroll', function () { updateIndicator(rail); }, { passive: true });
            rail.addEventListener('dragstart', function (event) { event.preventDefault(); });
            rail.addEventListener('pointerdown', function (event) {
                if (event.pointerType !== 'mouse' || event.button !== 0) return;
                // Let product links and form controls receive a normal click.
                // Pointer capture is only needed when grabbing a non-interactive
                // part of the rail to scroll it.
                if (event.target.closest('a, button, input, select, textarea, label, form')) return;
                dragging = true;
                moved = false;
                startX = event.clientX;
                startScrollLeft = rail.scrollLeft;
                rail.classList.add('is-dragging');
                rail.setPointerCapture(event.pointerId);
            });
            rail.addEventListener('pointermove', function (event) {
                if (!dragging) return;
                var distance = event.clientX - startX;
                if (Math.abs(distance) > 4) moved = true;
                if (!moved) return;
                event.preventDefault();
                rail.scrollLeft = startScrollLeft - distance;
            });

            function stopDragging(event) {
                if (!dragging) return;
                dragging = false;
                suppressClick = moved;
                rail.classList.remove('is-dragging');
                if (rail.hasPointerCapture(event.pointerId)) rail.releasePointerCapture(event.pointerId);
                window.setTimeout(function () { suppressClick = false; }, 0);
            }

            rail.addEventListener('pointerup', stopDragging);
            rail.addEventListener('pointercancel', stopDragging);
            rail.addEventListener('click', function (event) {
                if (!suppressClick) return;
                event.preventDefault();
                event.stopPropagation();
            }, true);
        });
        window.addEventListener('resize', function () {
            rails.forEach(updateIndicator);
        });
    })();
</script>
<?php } ?>

<?php require 'footer.php'; ?>
