<?php
require 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: landing.php");
    exit();
}

$showcaseCartCount = cartCount();
$showcaseCategoryRows = $conn->query("SELECT DISTINCT category FROM products WHERE status = 'Active' ORDER BY category");
$showcaseCategories = array();
if ($showcaseCategoryRows) {
    while ($showcaseCategoryRow = $showcaseCategoryRows->fetch_assoc()) {
        $showcaseCategories[] = $showcaseCategoryRow['category'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBB — The Editorial</title>
    <style>
        :root {
            --ink: #171616;
            --paper: #f8f7f4;
            --plum: #462035;
            --taupe: #685550;
            --stone: #d9d3ca;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            overflow: hidden;
            background: var(--ink);
            color: #fff;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        body.menu-open { overflow: hidden; }
        a { color: inherit; }
        button { font: inherit; }
        a:focus-visible, button:focus-visible { outline: 2px solid currentColor; outline-offset: 4px; }

        .showcase-header {
            position: fixed;
            inset: 0 0 auto;
            z-index: 100;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: start;
            padding: 28px 36px;
            color: #fff;
            mix-blend-mode: difference;
            pointer-events: none;
        }
        .showcase-header > * { pointer-events: auto; }
        .menu-trigger {
            display: flex;
            width: 66px;
            height: 26px;
            flex-direction: column;
            justify-content: center;
            gap: 10px;
            padding: 0;
            border: 0;
            background: transparent;
            color: inherit;
            cursor: pointer;
        }
        .menu-trigger span { display: block; width: 100%; height: 1px; background: currentColor; }
        .showcase-brand {
            font-family: Georgia, "Times New Roman", serif;
            font-size: 48px;
            font-weight: 700;
            letter-spacing: -.13em;
            line-height: .7;
            text-decoration: none;
        }
        .showcase-utilities {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-self: end;
            gap: 9px;
        }
        .showcase-utilities a {
            font-size: 11px;
            font-weight: 400;
            letter-spacing: .04em;
            text-decoration: none;
            text-transform: uppercase;
        }
        .showcase-utilities a:hover { text-decoration: underline; text-underline-offset: 4px; }
        .showcase-search { width: 210px; padding-bottom: 7px; border-bottom: 1px solid currentColor; text-align: right; }
        .showcase-utilities .utility-spacer { height: 108px; }

        .showcase-menu {
            position: fixed;
            inset: 0;
            z-index: 200;
            display: block;
            overflow-y: auto;
            padding: 0;
            background: #fff;
            color: var(--ink);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-16px);
            transition: opacity .35s ease, transform .35s ease, visibility .35s;
        }
        .showcase-menu.open { opacity: 1; visibility: visible; transform: translateY(0); }
        .menu-shell-header {
            position: relative;
            display: grid;
            grid-template-columns: 170px 1fr auto;
            align-items: start;
            min-height: 112px;
            padding: 22px 28px;
        }
        .menu-close {
            position: relative;
            width: 46px;
            height: 46px;
            padding: 0;
            border: 0;
            background: transparent;
            cursor: pointer;
        }
        .menu-close::before, .menu-close::after {
            position: absolute;
            top: 22px;
            left: 4px;
            width: 38px;
            height: 1px;
            background: var(--ink);
            content: "";
        }
        .menu-close::before { transform: rotate(45deg); }
        .menu-close::after { transform: rotate(-45deg); }
        .menu-logo {
            width: fit-content;
            margin-top: 8px;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 46px;
            font-weight: 700;
            letter-spacing: -.13em;
            line-height: .7;
            text-decoration: none;
        }
        .menu-topnav { display: flex; justify-content: flex-end; gap: 18px; padding-top: 1px; }
        .menu-topnav a {
            font-size: 10px;
            letter-spacing: .04em;
            text-decoration: none;
            text-transform: uppercase;
        }
        .menu-body {
            display: grid;
            grid-template-columns: minmax(220px, .7fr) minmax(220px, .75fr) minmax(560px, 2.4fr);
            gap: clamp(40px, 6vw, 120px);
            width: min(1480px, calc(100% - 80px));
            margin: 24px auto 80px;
            align-items: start;
        }
        .menu-categories { display: flex; flex-direction: column; align-items: flex-start; gap: 8px; }
        .menu-categories a {
            width: fit-content;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(24px, 2vw, 33px);
            letter-spacing: -.025em;
            line-height: 1.05;
            text-decoration: none;
            text-transform: uppercase;
        }
        .menu-categories a:hover { color: var(--taupe); }
        .menu-edits { display: flex; flex-direction: column; align-items: flex-start; gap: 9px; padding-top: 4px; }
        .menu-edits h2 {
            margin: 0 0 7px;
            color: var(--ink);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .15em;
            text-transform: uppercase;
        }
        .menu-edits h2:not(:first-child) { margin-top: 32px; color: #e32636; }
        .menu-edits a {
            color: #e32636;
            font-size: 10px;
            letter-spacing: .02em;
            text-decoration: none;
            text-transform: uppercase;
        }
        .menu-edits a:hover, .menu-topnav a:hover { text-decoration: underline; text-underline-offset: 4px; }
        .menu-preview-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: clamp(22px, 3vw, 54px); }
        .menu-preview-card { display: flex; min-width: 0; flex-direction: column; gap: 14px; text-decoration: none; }
        .menu-preview-visual { display: flex; height: min(54vh, 500px); align-items: flex-end; justify-content: center; overflow: hidden; background: #fff; }
        .menu-preview-visual img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center bottom;
            transition: transform .35s ease;
        }
        .menu-preview-card:hover img { transform: scale(1.035); }
        .menu-preview-card span { color: #676767; font-size: 9px; letter-spacing: .04em; text-align: center; text-transform: uppercase; }

        .showcase-scroll {
            height: 100vh;
            overflow-y: auto;
            background: #fff;
            scroll-behavior: smooth;
            scroll-snap-type: none;
            scrollbar-width: none;
        }
        .showcase-scroll::-webkit-scrollbar { display: none; }
        .showcase-panel {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
        }
        .showcase-panel + .showcase-panel { margin-top: 14px; }
        .campaign-image { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
        .campaign-one .campaign-image { object-position: center center; }
        .campaign-two .campaign-image { object-position: center center; }
        .campaign-one::after, .campaign-two::after {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(0,0,0,.38), transparent 55%);
            content: "";
            pointer-events: none;
        }
        .campaign-copy {
            position: absolute;
            bottom: 10vh;
            left: clamp(36px, 9vw, 170px);
            z-index: 2;
            max-width: 680px;
        }
        .campaign-copy p { margin: 0 0 18px; font-size: 11px; letter-spacing: .18em; text-transform: uppercase; }
        .campaign-copy h1, .campaign-copy h2 {
            margin: 0;
            font-size: clamp(58px, 8vw, 138px);
            font-weight: 300;
            letter-spacing: -.07em;
            line-height: .78;
            text-transform: uppercase;
        }
        .campaign-two .campaign-copy { right: clamp(36px, 9vw, 170px); left: auto; max-width: 780px; text-align: right; }

        .scroll-cue {
            position: absolute;
            right: 36px;
            bottom: 30px;
            z-index: 4;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 10px;
            letter-spacing: .12em;
            text-decoration: none;
            text-transform: uppercase;
        }
        .scroll-cue span { font-size: 28px; font-weight: 200; line-height: 1; }

        .showcase-scroll, .showcase-header, .section-dots {
            transition: opacity .8s cubic-bezier(.22, 1, .36, 1), transform .8s cubic-bezier(.22, 1, .36, 1);
        }
        body.store-leaving .showcase-scroll,
        body.store-leaving .showcase-header,
        body.store-leaving .section-dots {
            opacity: .08;
            transform: translateY(-18px) scale(.985);
        }
        .store-transition {
            position: fixed;
            inset: 0;
            z-index: 1000;
            display: grid;
            place-items: center;
            background: #fff;
            color: var(--ink);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity .72s cubic-bezier(.22, 1, .36, 1), visibility .72s;
        }
        .store-transition-inner { display: flex; flex-direction: column; align-items: center; }
        .store-transition-mark {
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(58px, 7vw, 104px);
            font-weight: 700;
            letter-spacing: -.13em;
            line-height: .75;
            opacity: 0;
            transform: translateY(18px) scale(.96);
            transition: opacity .55s ease .28s, transform .75s cubic-bezier(.22, 1, .36, 1) .22s;
        }
        .store-transition-rule {
            display: block;
            width: 110px;
            height: 1px;
            margin-top: 30px;
            overflow: hidden;
            background: #ddd;
        }
        .store-transition-rule::after {
            display: block;
            width: 100%;
            height: 100%;
            background: var(--ink);
            content: "";
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .72s cubic-bezier(.65, 0, .35, 1) .35s;
        }
        body.store-leaving .store-transition { opacity: 1; visibility: visible; }
        body.store-leaving .store-transition-mark { opacity: 1; transform: translateY(0) scale(1); }
        body.store-leaving .store-transition-rule::after { transform: scaleX(1); }
        .store-entry-panel {
            --exit-progress: 0;
            display: grid;
            place-items: center;
            background: #fff;
            color: var(--ink);
        }
        .store-entry-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: var(--ink);
            text-align: center;
            text-decoration: none;
        }
        .store-entry-link h2 {
            margin: 0 0 12px;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(38px, 4vw, 62px);
            font-weight: 400;
            letter-spacing: -.04em;
            text-transform: uppercase;
        }
        .store-entry-link p {
            margin: 0;
            color: #575757;
            font-size: 9px;
            letter-spacing: .08em;
            text-transform: uppercase;
        }
        .store-entry-line {
            position: relative;
            display: block;
            width: 1px;
            height: 116px;
            margin-top: 22px;
            overflow: hidden;
            background: #d8d8d8;
        }
        .store-entry-line::before,
        .store-entry-line::after {
            position: absolute;
            top: 0;
            left: 0;
            width: 1px;
            height: 100%;
            background: var(--ink);
            content: "";
            transform-origin: top;
        }
        .store-entry-line::before { animation: entry-line 1.8s cubic-bezier(.55, 0, .25, 1) infinite; }
        .store-entry-line::after { transform: scaleY(var(--exit-progress)); }
        .store-entry-status { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); }
        @keyframes entry-line {
            0% { transform: translateY(-100%) scaleY(.36); }
            60%, 100% { transform: translateY(115%) scaleY(.56); }
        }

        .models-panel {
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #fff;
            color: var(--ink);
        }
        .model-stage { position: relative; display: flex; min-height: 100vh; align-items: flex-end; justify-content: center; overflow: hidden; }
        .model-stage--left {
            background:
                radial-gradient(circle at 50% 38%, rgba(255,255,255,.54) 0, rgba(255,255,255,.08) 34%, transparent 58%),
                linear-gradient(145deg, #c9cbc8 0%, #9ba2a5 58%, #747d82 100%);
        }
        .model-stage--right {
            padding: 8vh 9vw 8vh 11vw;
            background: #fff;
            align-items: center;
        }
        .model-stage--left::before {
            position: absolute;
            inset: 7vh 6vw 0;
            border: 1px solid rgba(255,255,255,.3);
            content: "";
        }
        .model-stage--left img {
            position: relative;
            z-index: 1;
            width: min(78%, 650px);
            height: 94vh;
            object-fit: contain;
            object-position: center bottom;
            filter: drop-shadow(0 24px 30px rgba(25,31,35,.2));
            transform: scale(1.5);
            transform-origin: center 78%;
        }
        .model-frame {
            position: relative;
            display: flex;
            width: 100%;
            height: 82vh;
            align-items: flex-end;
            justify-content: center;
            overflow: hidden;
            background:
                radial-gradient(circle at 50% 34%, rgba(133,84,109,.72) 0%, rgba(88,42,65,.42) 34%, transparent 62%),
                linear-gradient(155deg, #55263f 0%, #3b1a2c 62%, #24151c 100%);
        }
        .model-frame::after {
            position: absolute;
            inset: 24px;
            border: 1px solid rgba(255,255,255,.24);
            content: "";
        }
        .model-frame img {
            position: relative;
            z-index: 1;
            width: 82%;
            height: 96%;
            object-fit: contain;
            object-position: center bottom;
            filter: drop-shadow(0 22px 28px rgba(0,0,0,.3));
            transform: scale(1.48);
            transform-origin: center 78%;
        }
        .model-caption {
            position: absolute;
            right: 28px;
            bottom: 24px;
            left: 28px;
            z-index: 3;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            font-size: 10px;
            letter-spacing: .1em;
            text-transform: uppercase;
        }
        .model-stage--right .model-caption { right: calc(9vw + 20px); bottom: calc(8vh + 18px); left: calc(11vw + 20px); color: #fff; }
        .model-caption strong { font-weight: 600; }
        .model-stage--left .model-caption { color: #fff; text-shadow: 0 1px 12px rgba(0,0,0,.28); }

        .section-dots {
            position: fixed;
            bottom: 28px;
            left: 36px;
            z-index: 90;
            display: flex;
            gap: 8px;
            color: #fff;
            mix-blend-mode: difference;
        }
        .section-dots a { display: block; width: 28px; height: 1px; background: currentColor; opacity: .4; }
        .section-dots a:hover { opacity: 1; }

        @media (max-width: 900px) {
            .showcase-header { padding: 22px 20px; }
            .showcase-brand { font-size: 40px; }
            .showcase-search, .showcase-utilities .utility-spacer, .showcase-utilities a:last-child { display: none; }
            .showcase-utilities { padding-top: 2px; }
            .menu-shell-header { grid-template-columns: 70px 1fr; padding: 18px 20px; }
            .menu-logo { margin-left: 8px; }
            .menu-topnav { display: none; }
            .menu-body { grid-template-columns: 1fr 1fr; width: calc(100% - 40px); margin-top: 20px; gap: 38px 24px; }
            .menu-preview-grid { grid-column: 1 / -1; }
            .menu-preview-visual { height: 45vh; }
            .campaign-copy { right: 24px; bottom: 12vh; left: 24px; }
            .campaign-two .campaign-copy { right: 24px; left: 24px; }
            .models-panel { display: block; min-height: 200vh; }
            .model-stage { min-height: 100vh; }
            .model-stage--right { padding: 10vh 10vw; }
            .model-stage--left img { width: 90%; transform: scale(1.32); }
            .model-frame { height: 80vh; }
            .model-frame img { transform: scale(1.32); }
            .model-stage--right .model-caption { right: calc(10vw + 18px); bottom: calc(10vh + 16px); left: calc(10vw + 18px); }
            .section-dots { left: 20px; }
            .scroll-cue { right: 20px; }
        }

        @media (max-width: 560px) {
            .menu-body { grid-template-columns: 1fr; }
            .menu-preview-grid { grid-column: auto; grid-template-columns: 1fr; }
            .menu-preview-card:not(:first-child) { display: none; }
            .menu-preview-visual { height: 52vh; }
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .showcase-scroll { scroll-snap-type: none; }
            *, *::before, *::after { transition-duration: .01ms !important; }
            .store-entry-line::before { animation: none; transform: scaleY(.45); }
            .store-transition-mark, .store-transition-rule::after { transition-delay: 0s; }
        }
    </style>
</head>
<body>
    <header class="showcase-header">
        <button class="menu-trigger" type="button" aria-label="Open menu" aria-controls="showcase-menu" aria-expanded="false">
            <span></span><span></span>
        </button>
        <a class="showcase-brand" href="showcase.php" aria-label="BBB editorial home">bbb</a>
        <nav class="showcase-utilities" aria-label="Showcase navigation">
            <a class="showcase-search" href="index.php">Search</a>
            <span class="utility-spacer" aria-hidden="true"></span>
            <a href="cart.php">Bag [<?php echo displayText($showcaseCartCount); ?>]</a>
            <?php if (($_SESSION['role'] ?? '') == 'admin') { ?>
                <a href="admin_dashboard.php">Admin</a>
            <?php } else { ?>
                <a href="orders.php">Orders</a>
            <?php } ?>
            <a href="logout.php">Log out</a>
            <a href="about.php">Help</a>
        </nav>
    </header>

    <aside class="showcase-menu" id="showcase-menu" aria-hidden="true">
        <div class="menu-shell-header">
            <button class="menu-close" type="button" aria-label="Close menu"></button>
            <a class="menu-logo" href="showcase.php" aria-label="BBB showcase home">bbb</a>
            <nav class="menu-topnav" aria-label="Menu utilities">
                <a href="index.php">Search</a>
                <a href="logout.php">Log out</a>
                <a href="about.php">Help</a>
                <a href="cart.php">Bag [<?php echo displayText($showcaseCartCount); ?>]</a>
            </nav>
        </div>

        <div class="menu-body">
            <nav class="menu-categories" aria-label="Product categories">
                <a href="index.php?category=All">All</a>
                <?php foreach ($showcaseCategories as $showcaseCategory) { ?>
                    <a href="index.php?category=<?php echo urlencode($showcaseCategory); ?>"><?php echo displayText($showcaseCategory); ?></a>
                <?php } ?>
            </nav>

            <nav class="menu-edits" aria-label="Collection edits">
                <h2>New collection</h2>
                <a href="index.php">Sale</a>
                <h2>|01| Featured</h2>
                <a href="index.php">Selected for you</a>
                <a href="index.php">Shop by size</a>
                <h2>|02| Collection</h2>
                <a href="index.php?category=All">View all</a>
                <a href="index.php?category=Dresses">Dresses</a>
                <a href="index.php?category=Men+Tops">Men tops</a>
                <a href="index.php?category=Women+Tops">Women tops</a>
            </nav>

            <div class="menu-preview-grid" aria-label="Featured looks">
                <a class="menu-preview-card" href="index.php">
                    <span class="menu-preview-visual"><img src="BBB/Models/BBB - 28.png" alt="BBB sale edit" loading="lazy" decoding="async"></span>
                    <span>Sale</span>
                </a>
                <a class="menu-preview-card" href="index.php">
                    <span class="menu-preview-visual"><img src="BBB/Models/BBB - 29.png" alt="BBB new collection" loading="lazy" decoding="async"></span>
                    <span>The new</span>
                </a>
                <a class="menu-preview-card" href="index.php?category=Dresses">
                    <span class="menu-preview-visual"><img src="BBB/Models/BBB - 30(1).png" alt="BBB dresses edit" loading="lazy" decoding="async"></span>
                    <span>Dresses</span>
                </a>
            </div>
        </div>
    </aside>

    <main class="showcase-scroll" id="showcase-scroll">
        <section class="showcase-panel campaign-two" id="atelier">
            <img class="campaign-image" src="BBB/Logo & Theme/Background-2.jpg" alt="BBB outdoor atelier campaign" fetchpriority="high" decoding="async">
            <div class="campaign-copy">
                <p>BBB Editorial / 01</p>
                <h2>Form in<br>the open</h2>
            </div>
            <a class="scroll-cue" href="#silhouettes">Scroll <span aria-hidden="true">&#8595;</span></a>
        </section>

        <section class="showcase-panel models-panel" id="silhouettes">
            <article class="model-stage model-stage--left">
                <img src="BBB/Models/BBB - 30(1).png" alt="BBB dark structured womenswear look" loading="lazy" decoding="async">
                <div class="model-caption"><strong>Dark structure</strong><span>Look 01</span></div>
            </article>
            <article class="model-stage model-stage--right">
                <div class="model-frame">
                    <img src="BBB/Models/BBB - 31(1).png" alt="BBB relaxed menswear look" loading="lazy" decoding="async">
                </div>
                <div class="model-caption"><strong>Relaxed form</strong><span>Look 02</span></div>
            </article>
            <a class="scroll-cue" href="#tailoring">Next <span aria-hidden="true">&#8595;</span></a>
        </section>

        <section class="showcase-panel campaign-one" id="tailoring">
            <img class="campaign-image" src="BBB/Logo & Theme/Background-4.jpg" alt="BBB modern tailoring campaign" loading="lazy" decoding="async">
            <div class="campaign-copy">
                <p>BBB Editorial / 03</p>
                <h1>The new<br>tailoring</h1>
            </div>
            <a class="scroll-cue" href="#enter-store">Continue <span aria-hidden="true">&#8595;</span></a>
        </section>

        <section class="showcase-panel store-entry-panel" id="enter-store">
            <a class="store-entry-link" href="index.php?from=showcase">
                <h2>The collection</h2>
                <p>Keep scrolling to enter</p>
                <span class="store-entry-line" aria-hidden="true"></span>
            </a>
            <span class="store-entry-status" id="store-entry-status" aria-live="polite"></span>
        </section>
    </main>

    <nav class="section-dots" aria-label="Showcase sections">
        <a href="#atelier" aria-label="Atelier campaign"></a>
        <a href="#silhouettes" aria-label="Silhouettes"></a>
        <a href="#tailoring" aria-label="Tailoring campaign"></a>
        <a href="#enter-store" aria-label="Enter the collection"></a>
    </nav>

    <div class="store-transition" aria-hidden="true">
        <div class="store-transition-inner">
            <span class="store-transition-mark">bbb</span>
            <span class="store-transition-rule"></span>
        </div>
    </div>

    <script>
        (function () {
            var menu = document.getElementById('showcase-menu');
            var openButton = document.querySelector('.menu-trigger');
            var closeButton = document.querySelector('.menu-close');
            var scrollRoot = document.getElementById('showcase-scroll');
            var entryPanel = document.getElementById('enter-store');
            var entryLink = document.querySelector('.store-entry-link');
            var entryStatus = document.getElementById('store-entry-status');
            var exitDistance = 0;
            var touchY = null;
            var leaving = false;

            function setMenu(open) {
                menu.classList.toggle('open', open);
                menu.setAttribute('aria-hidden', open ? 'false' : 'true');
                openButton.setAttribute('aria-expanded', open ? 'true' : 'false');
                document.body.classList.toggle('menu-open', open);
                (open ? closeButton : openButton).focus();
            }

            openButton.addEventListener('click', function () { setMenu(true); });
            closeButton.addEventListener('click', function () { setMenu(false); });
            menu.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () { setMenu(false); });
            });
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && menu.classList.contains('open')) setMenu(false);
                if ((event.key === 'ArrowDown' || event.key === 'PageDown') && atBottom()) addExitDistance(90);
            });

            function atBottom() {
                return scrollRoot.scrollTop + scrollRoot.clientHeight >= scrollRoot.scrollHeight - 3;
            }

            function resetExitDistance() {
                exitDistance = 0;
                entryPanel.style.setProperty('--exit-progress', 0);
            }

            function enterStore() {
                if (leaving) return;
                leaving = true;
                entryStatus.textContent = 'Opening the BBB collection.';
                document.body.classList.add('store-leaving');
                var transitionDelay = window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 180 : 1280;
                window.setTimeout(function () { window.location.href = 'index.php?from=showcase'; }, transitionDelay);
            }

            function addExitDistance(amount) {
                if (leaving || menu.classList.contains('open') || !atBottom()) return;
                exitDistance += Math.max(0, Math.min(amount, 80));
                entryPanel.style.setProperty('--exit-progress', Math.min(exitDistance / 400, 1));
                if (exitDistance >= 400) enterStore();
            }

            scrollRoot.addEventListener('scroll', function () {
                if (!atBottom() && exitDistance) resetExitDistance();
            }, { passive: true });
            scrollRoot.addEventListener('wheel', function (event) {
                if (event.deltaY > 0) addExitDistance(event.deltaY);
            }, { passive: true });
            scrollRoot.addEventListener('touchstart', function (event) {
                touchY = event.touches[0].clientY;
            }, { passive: true });
            scrollRoot.addEventListener('touchmove', function (event) {
                if (touchY === null) return;
                var nextY = event.touches[0].clientY;
                var downwardDistance = touchY - nextY;
                touchY = nextY;
                if (downwardDistance > 0) addExitDistance(downwardDistance);
            }, { passive: true });
            entryLink.addEventListener('click', function (event) {
                event.preventDefault();
                enterStore();
            });
        })();
    </script>
</body>
</html>
