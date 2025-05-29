<?php
require_once '../../src/config/Database.php';
$conn = Database::getInstance();
$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name'] ?? '');
    $desc = $conn->real_escape_string($_POST['description'] ?? '');
    $conn->query("INSERT INTO category (name, description, is_active) VALUES ('$name', '$desc', 1)");
    echo json_encode(['success'=>true]);
    exit;
}
if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name'] ?? '');
    $desc = $conn->real_escape_string($_POST['description'] ?? '');
    $conn->query("UPDATE category SET name='$name', description='$desc' WHERE category_id=$id");
    echo json_encode(['success'=>true]);
    exit;
}
if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn->query("DELETE FROM category WHERE category_id=$id");
    echo json_encode(['success'=>true]);
    exit;
}
if ($action === 'toggle' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn->query("UPDATE category SET is_active = 1 - is_active WHERE category_id=$id");
    echo json_encode(['success'=>true]);
    exit;
}
if ($action === 'add') {
    ?>
    <form id="catForm">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" class="form-control" name="description">
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
    <script>
    document.getElementById('catForm').onsubmit = function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('category_modal.php?action=add', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => { if (data.success) location.reload(); else alert('Add failed!'); });
    };
    </script>
    <?php
    exit;
}
if ($action === 'edit') {
    $res = $conn->query("SELECT * FROM category WHERE category_id=$id");
    $cat = $res ? $res->fetch_assoc() : null;
    if (!$cat) { echo '<div class="text-danger">Category not found.</div>'; exit; }
    ?>
    <form id="catForm">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($cat['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" class="form-control" name="description" value="<?= htmlspecialchars($cat['description']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    <script>
    document.getElementById('catForm').onsubmit = function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('category_modal.php?action=edit&id=<?= $id ?>', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => { if (data.success) location.reload(); else alert('Update failed!'); });
    };
    </script>
    <?php
    exit;
}
echo '<div class="text-danger">Invalid action.</div>'; 