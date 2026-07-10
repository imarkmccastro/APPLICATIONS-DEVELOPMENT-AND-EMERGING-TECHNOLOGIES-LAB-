<?php
$pageTitle = "Stock Form";
require 'functions.php';
requireAdmin();
require 'header.php';

$id = (int)($_GET['id'] ?? 0);
$editing = $id > 0;
$message = "";
$product = array(
    "name" => "",
    "category" => "Tops",
    "description" => "",
    "price" => "",
    "quantity" => "",
    "image" => "img/product-shirt.svg",
    "status" => "Active"
);

if ($editing) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $name = trim($_POST['name']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];
    $quantity = (int)$_POST['quantity'];
    $image = trim($_POST['image']);
    $status = $_POST['status'];

    if ($editing) {
        $stmt = $conn->prepare("UPDATE products SET name = ?, category = ?, description = ?, price = ?, quantity = ?, image = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sssdissi", $name, $category, $description, $price, $quantity, $image, $status, $id);
        $activity = "Modified stock " . $name;
    } else {
        $stmt = $conn->prepare("INSERT INTO products (name, category, description, price, quantity, image, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdiss", $name, $category, $description, $price, $quantity, $image, $status);
        $activity = "Added stock " . $name;
    }

    if ($stmt->execute()) {
        logActivity($conn, $activity);
        header("Location: admin_products.php");
        exit();
    }
    $message = "Error: " . $stmt->error;
    $stmt->close();
}
?>

<div class="nav-links">
    <a href="admin_products.php">Back to Stocks</a>
    <a href="admin_dashboard.php">Dashboard</a>
</div>

<div class="panel form-container">
    <h2><?php echo $editing ? "Modify Stock" : "Add Stock"; ?></h2>
    <?php if ($message != "") { ?><div class="message error"><?php echo displayText($message); ?></div><?php } ?>
    <form method="POST" action="">
        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="name" value="<?php echo displayText($product['name']); ?>" required>
        </div>
        <div class="form-group">
            <label>Category</label>
            <select name="category" required>
                <?php foreach (array("Tops", "Bottoms", "Outerwear", "Dresses", "Accessories") as $cat) { ?>
                    <option value="<?php echo displayText($cat); ?>" <?php if ($product['category'] == $cat) echo 'selected'; ?>><?php echo displayText($cat); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" required><?php echo displayText($product['description']); ?></textarea>
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label>Price</label>
                <input type="number" step="0.01" min="0" name="price" value="<?php echo displayText($product['price']); ?>" required>
            </div>
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" min="0" name="quantity" value="<?php echo displayText($product['quantity']); ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label>Image Path</label>
            <input type="text" name="image" value="<?php echo displayText($product['image']); ?>" required>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" required>
                <option value="Active" <?php if ($product['status'] == 'Active') echo 'selected'; ?>>Active</option>
                <option value="Inactive" <?php if ($product['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
            </select>
        </div>
        <input type="submit" name="save" value="Save" class="full-button">
    </form>
</div>

<?php require 'footer.php'; ?>
