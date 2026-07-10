<?php
require 'functions.php';
requireAdmin();

$id = (int)($_GET['id'] ?? 0);
$editing = $id > 0;
$message = "";
$categories = array("Men Tops", "Women Tops", "Bottoms", "Dresses", "Outerwear", "Accessories");
$product = array("name" => "", "category" => "Men Tops", "description" => "", "price" => "", "quantity" => "", "image" => "BBB/JPG Files/BBB - 18.jpg", "status" => "Active");

if ($editing) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $record = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$record) {
        setFlashMessage("The selected stock item could not be found.", "error");
        header("Location: admin_products.php");
        exit();
    }
    $product = $record;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $product['name'] = trim($_POST['name'] ?? "");
    $product['category'] = in_array($_POST['category'] ?? "", $categories) ? $_POST['category'] : "Men Tops";
    $product['description'] = trim($_POST['description'] ?? "");
    $product['price'] = (float)($_POST['price'] ?? 0);
    $product['quantity'] = (int)($_POST['quantity'] ?? 0);
    $product['image'] = trim($_POST['image'] ?? "");
    $product['status'] = in_array($_POST['status'] ?? "", array("Active", "Inactive")) ? $_POST['status'] : "Active";

    if ($product['name'] == "" || $product['description'] == "" || $product['image'] == "") {
        $message = "Product name, description, and image path are required.";
    } else if ($product['price'] < 0 || $product['quantity'] < 0) {
        $message = "Price and quantity cannot be negative.";
    } else {
        if ($editing) {
            $stmt = $conn->prepare("UPDATE products SET name = ?, category = ?, description = ?, price = ?, quantity = ?, image = ?, status = ? WHERE id = ?");
            $stmt->bind_param("sssdissi", $product['name'], $product['category'], $product['description'], $product['price'], $product['quantity'], $product['image'], $product['status'], $id);
            $activity = "Modified stock " . $product['name'];
        } else {
            $stmt = $conn->prepare("INSERT INTO products (name, category, description, price, quantity, image, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssdiss", $product['name'], $product['category'], $product['description'], $product['price'], $product['quantity'], $product['image'], $product['status']);
            $activity = "Added stock " . $product['name'];
        }
        if ($stmt->execute()) {
            logActivity($conn, $activity);
            setFlashMessage($product['name'] . ($editing ? " was updated." : " was added."));
            header("Location: admin_products.php");
            exit();
        }
        $message = "The stock item could not be saved.";
        $stmt->close();
    }
}

$pageTitle = $editing ? "Modify Stock" : "Add Stock";
$imageExists = $product['image'] != "" && file_exists(__DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $product['image']));
require 'header.php';
?>
<div class="nav-links"><a href="admin_products.php">Back to Stocks</a><a href="admin_dashboard.php">Dashboard</a></div>
<section class="admin-form-layout">
    <div class="panel admin-form-panel">
        <div class="form-heading"><h2><?php echo $editing ? "Modify Stock" : "Add Stock"; ?></h2><p>Maintain product details, price, availability, and image.</p></div>
        <?php if ($message != "") { ?><div class="message error" role="alert"><?php echo displayText($message); ?></div><?php } ?>
        <form method="POST" action="admin_product_form.php<?php if ($editing) echo '?id=' . displayText($id); ?>">
            <div class="form-group"><label for="product-name">Product Name <span class="required">Required</span></label><input id="product-name" type="text" name="name" value="<?php echo displayText($product['name']); ?>" required></div>
            <div class="form-group"><label for="product-category">Category <span class="required">Required</span></label><select id="product-category" name="category" required><?php foreach ($categories as $category) { ?><option value="<?php echo displayText($category); ?>" <?php if ($product['category'] == $category) echo 'selected'; ?>><?php echo displayText($category); ?></option><?php } ?></select></div>
            <div class="form-group"><label for="product-description">Description <span class="required">Required</span></label><textarea id="product-description" name="description" required><?php echo displayText($product['description']); ?></textarea></div>
            <div class="form-grid"><div class="form-group"><label for="product-price">Price <span class="required">Required</span></label><input id="product-price" type="number" step="0.01" min="0" name="price" value="<?php echo displayText($product['price']); ?>" required></div><div class="form-group"><label for="product-quantity">Quantity <span class="required">Required</span></label><input id="product-quantity" type="number" min="0" name="quantity" value="<?php echo displayText($product['quantity']); ?>" required></div></div>
            <div class="form-group"><label for="product-image">Image Path <span class="required">Required</span></label><input id="product-image" type="text" name="image" value="<?php echo displayText($product['image']); ?>" required><small class="field-help">Use a project-relative path from the supplied BBB folder.</small></div>
            <div class="form-group"><label for="product-status">Status <span class="required">Required</span></label><select id="product-status" name="status" required><option value="Active" <?php if ($product['status'] == 'Active') echo 'selected'; ?>>Active</option><option value="Inactive" <?php if ($product['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option></select></div>
            <input type="submit" name="save" value="Save Stock" class="full-button">
        </form>
    </div>
    <aside class="panel image-preview-panel"><h2>Image Preview</h2><?php if ($imageExists) { ?><img src="<?php echo displayText($product['image']); ?>" alt="Preview of <?php echo displayText($product['name'] ?: 'product image'); ?>"><p><?php echo displayText($product['image']); ?></p><?php } else { ?><div class="empty-state compact-empty"><p>Save a valid image path to display its preview.</p></div><?php } ?></aside>
</section>
<?php require 'footer.php'; ?>
