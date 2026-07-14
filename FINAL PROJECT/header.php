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
    <link rel="stylesheet" href="style.css?v=<?php echo filemtime(__DIR__ . '/style.css'); ?>">
</head>
<body>

<div id="zara-sidebar" class="zara-sidebar">
    <div class="sidebar-header">
        <button class="close-menu" aria-label="Close" onclick="document.getElementById('zara-sidebar').classList.remove('open')">
            <svg viewBox="0 0 24 24" width="40" height="40" stroke="currentColor" stroke-width="0.5" fill="none"><line x1="4" y1="4" x2="20" y2="20"></line><line x1="20" y1="4" x2="4" y2="20"></line></svg>
        </button>
        <a href="showcase.php" class="sidebar-logo-link" aria-label="Return to BBB showcase">
            <img src="BBB/JPG Files/BBB - 2.jpg" alt="BBB Logo" class="sidebar-logo">
        </a>
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
            <a class="brand" href="showcase.php" aria-label="Return to BBB showcase">
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
                <a href="admin_login.php" class="zara-nav-link">Seller</a>
            <?php } ?>
            <a href="about.php" class="zara-nav-link">Help</a>
        </nav>
    </header>
    <main class="page-content">
        <?php if ($flashMessage) { ?>
            <div class="message <?php echo displayText($flashMessage['type']); ?> global-message" id="global-flash-message" role="<?php echo $flashMessage['type'] == 'error' ? 'alert' : 'status'; ?>">
                <?php echo displayText($flashMessage['message']); ?>
            </div>
            <script>
                window.setTimeout(function () {
                    var message = document.getElementById('global-flash-message');
                    if (!message) return;
                    message.classList.add('is-dismissing');
                    window.setTimeout(function () { message.remove(); }, 300);
                }, 2000);
            </script>
        <?php } ?>

<?php if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? "") != "buyer") { ?>
    <div class="auth-modal" id="cart-auth-modal" hidden>
        <div class="auth-modal-backdrop" data-auth-close></div>
        <section class="auth-modal-card" role="dialog" aria-modal="true" aria-labelledby="cart-auth-title" aria-describedby="cart-auth-description">
            <button type="button" class="auth-modal-close" data-auth-close aria-label="Close login prompt">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="auth-modal-brand" aria-hidden="true">bbb</div>
            <p class="auth-modal-kicker">YOUR BBB BAG</p>
            <h2 id="cart-auth-title">Sign in to continue</h2>
            <p id="cart-auth-description">Log in or create an account to add this item and continue shopping.</p>
            <div class="auth-modal-actions">
                <a href="login.php" class="button-link" id="cart-auth-login">Log In</a>
                <a href="register.php" class="button-link secondary-button">Register</a>
            </div>
        </section>
    </div>
    <script>
        (function () {
            var modal = document.getElementById('cart-auth-modal');
            var loginLink = document.getElementById('cart-auth-login');
            var lastTrigger = null;

            function currentReturnUrl() {
                var file = window.location.pathname.split('/').pop() || 'index.php';
                return file + window.location.search;
            }

            function openAuthModal(trigger) {
                lastTrigger = trigger;
                loginLink.href = 'login.php?return_to=' + encodeURIComponent(currentReturnUrl());
                modal.hidden = false;
                document.body.classList.add('auth-modal-open');
                modal.querySelector('.auth-modal-close').focus();
            }

            function closeAuthModal() {
                modal.hidden = true;
                document.body.classList.remove('auth-modal-open');
                if (lastTrigger) lastTrigger.focus();
            }

            document.addEventListener('submit', function (event) {
                var form = event.target;
                var addButton = form.querySelector('[name="add_cart"]');
                if (!addButton) return;
                event.preventDefault();
                openAuthModal(addButton);
            });

            modal.querySelectorAll('[data-auth-close]').forEach(function (control) {
                control.addEventListener('click', closeAuthModal);
            });
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !modal.hidden) closeAuthModal();
            });
        })();
    </script>
<?php } ?>
