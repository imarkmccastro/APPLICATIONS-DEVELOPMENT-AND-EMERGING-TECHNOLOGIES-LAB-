<?php
require_once 'functions.php';
if (!isset($pageTitle)) {
    $pageTitle = "BBB";
}
$currentPage = basename($_SERVER['PHP_SELF']);
$flashMessage = getFlashMessage();
?>
<?php
$sidebarCategoryRows = $conn->query("SELECT DISTINCT category FROM products WHERE status = 'Active' ORDER BY category");
$sidebarCategories = array();
if ($sidebarCategoryRows) {
    while ($row = $sidebarCategoryRows->fetch_assoc()) {
        $sidebarCategories[] = $row['category'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo displayText($pageTitle); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div id="zara-sidebar" class="zara-sidebar">
    <div class="sidebar-header">
        <button class="close-menu" aria-label="Close" onclick="document.getElementById('zara-sidebar').classList.remove('open')">
            <svg viewBox="0 0 24 24" width="40" height="40" stroke="currentColor" stroke-width="0.5" fill="none"><line x1="4" y1="4" x2="20" y2="20"></line><line x1="20" y1="4" x2="4" y2="20"></line></svg>
        </button>
        <img src="BBB/JPG Files/BBB - 2.jpg" alt="BBB Logo" class="sidebar-logo">
        <div class="sidebar-top-right">
            <a href="index.php">SEARCH</a>
            <a href="login.php">LOG IN</a>
            <a href="about.php">HELP</a>
            <a href="cart.php">BAG | 0</a>
        </div>
    </div>
    <div class="sidebar-content">
        <div class="sidebar-col sidebar-categories-col">
            <ul class="sidebar-categories">
                <li><a href="index.php?category=All">ALL</a></li>
                <?php foreach ($sidebarCategories as $cat) { ?>
                    <li><a href="index.php?category=<?php echo urlencode($cat); ?>"><?php echo strtoupper(displayText($cat)); ?></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="sidebar-col sidebar-subcategories-col">
            <p class="sidebar-sub-heading">NEW COLLECTION</p>
            <a href="#" class="highlight-red">SALE</a>
            <br><br>
            <p class="sidebar-sub-heading highlight-red">|01| FEATURED</p>
            <a href="#" class="highlight-red">SELECTED FOR YOU</a>
            <a href="#" class="highlight-red">SHOP BY SIZE</a>
            <br><br>
            <p class="sidebar-sub-heading highlight-red">|02| COLLECTION</p>
            <a href="#" class="highlight-red">VIEW ALL</a>
            <a href="#" class="highlight-red">DRESSES</a>
            <a href="#" class="highlight-red">T-SHIRTS | SWEATSHIRTS</a>
            <a href="#" class="highlight-red">SHIRTS</a>
            <a href="#" class="highlight-red">TOPS | BODIES</a>
        </div>
        <div class="sidebar-col sidebar-images-col">
            <div class="sidebar-promo-image">
                <img src="BBB/Models/BBB - 28.png" alt="Promo">
                <span>SALE</span>
            </div>
            <div class="sidebar-promo-image">
                <img src="BBB/Models/BBB - 29.png" alt="Promo">
                <span>THE NEW</span>
            </div>
            <div class="sidebar-promo-image">
                <img src="BBB/Models/BBB - 30.png" alt="Promo">
                <span>DRESSES</span>
            </div>
        </div>
    </div>
</div>

<div class="site-shell">
    <header class="site-header zara-header">
        <div class="header-left">
            <button class="hamburger-menu" aria-label="Menu" onclick="document.getElementById('zara-sidebar').classList.add('open')">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="1" fill="none"><line x1="3" y1="8" x2="21" y2="8"></line><line x1="3" y1="16" x2="21" y2="16"></line></svg>
            </button>
            <a class="brand" href="index.php">
                <img src="BBB/JPG Files/BBB - 2.jpg" alt="BBB Logo" style="max-height: 40px; width: auto; object-fit: contain;">
                <!-- <span><strong>BBB</strong></span> -->
            </a>
        </div>
        <nav class="main-nav header-right" aria-label="Main navigation">
            <a href="index.php" class="zara-nav-link search-link">Search</a>
            <a href="cart.php" class="zara-nav-link bag-link">Bag <span class="bag-count">[ <?php echo cartCount(); ?> ]</span></a>
            <?php if (isset($_SESSION['user_id'])) { ?>
                <?php if (($_SESSION['role'] ?? "") == "admin") { ?>
                    <a href="admin_dashboard.php" class="zara-nav-link">Admin</a>
                <?php } else { ?>
                    <a href="orders.php" class="zara-nav-link">Orders</a>
                <?php } ?>
                <a href="logout.php" class="zara-nav-link">Log Out</a>
            <?php } else { ?>
                <a href="login.php" class="zara-nav-link">Log In</a>
            <?php } ?>
            <a href="about.php" class="zara-nav-link">Help</a>
        </nav>
    </header>
    <main class="page-content">
        <?php if ($flashMessage) { ?>
            <div class="message <?php echo displayText($flashMessage['type']); ?> global-message" role="<?php echo $flashMessage['type'] == 'error' ? 'alert' : 'status'; ?>">
                <?php echo displayText($flashMessage['message']); ?>
            </div>
        <?php } ?>
