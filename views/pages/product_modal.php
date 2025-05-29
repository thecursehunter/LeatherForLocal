<?php
require_once '../../src/config/Database.php';
$conn = Database::getInstance();
$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);
// Fetch categories for dropdown
$catRes = $conn->query("SELECT category_id, name FROM category WHERE is_active=1");
$categories = [];
while ($row = $catRes->fetch_assoc()) $categories[] = $row;
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['product_name'] ?? '');
    $desc = $conn->real_escape_string($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $cat = intval($_POST['category_id'] ?? 0);
    $conn->query("INSERT INTO products (product_name, description, price, category_id, is_available) VALUES ('$name', '$desc', $price, $cat, 1)");
    echo json_encode(['success'=>true]);
    exit;
}
if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['product_name'] ?? '');
    $desc = $conn->real_escape_string($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $cat = intval($_POST['category_id'] ?? 0);
    $conn->query("UPDATE products SET product_name='$name', description='$desc', price=$price, category_id=$cat WHERE product_id=$id");
    echo json_encode(['success'=>true]);
    exit;
}
if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn->query("DELETE FROM products WHERE product_id=$id");
    echo json_encode(['success'=>true]);
    exit;
}
if ($action === 'toggle' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn->query("UPDATE products SET is_available = 1 - is_available WHERE product_id=$id");
    echo json_encode(['success'=>true]);
    exit;
}
if ($action === 'add') {
    ?>
    <form id="prodForm">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="product_name" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" class="form-control" name="description">
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" class="form-control" name="price" step="0.001" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select class="form-select" name="category_id" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
    <script>
    document.getElementById('prodForm').onsubmit = function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('product_modal.php?action=add', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => { if (data.success) location.reload(); else alert('Add failed!'); });
    };
    </script>
    <?php
    exit;
}
if ($action === 'edit') {
    $res = $conn->query("SELECT * FROM products WHERE product_id=$id");
    $prod = $res ? $res->fetch_assoc() : null;
    if (!$prod) { echo '<div class="text-danger">Product not found.</div>'; exit; }
    ?>
    <form id="prodForm">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="product_name" value="<?= htmlspecialchars($prod['product_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" class="form-control" name="description" value="<?= htmlspecialchars($prod['description']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" class="form-control" name="price" step="0.001" value="<?= htmlspecialchars($prod['price']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select class="form-select" name="category_id" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>" <?= $prod['category_id']==$cat['category_id']?'selected':'' ?>><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    <script>
    document.getElementById('prodForm').onsubmit = function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('product_modal.php?action=edit&id=<?= $id ?>', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => { if (data.success) location.reload(); else alert('Update failed!'); });
    };
    </script>
    <?php
    exit;
}
echo '<div class="text-danger">Invalid action.</div>'; 