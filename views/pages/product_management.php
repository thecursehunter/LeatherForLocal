<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
$activePage = 'product';    
require_once '../../src/config/Database.php';
$conn = Database::getInstance();
$products = $conn->query("SELECT p.*, c.name as category_name FROM products p JOIN category c ON p.category_id = c.category_id ORDER BY p.created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Product Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
    <?php include __DIR__ . '/../components/admin_sidebar.php'; ?>
    <main class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Product Management</h2>
            <button class="btn btn-success" id="addProductBtn">Add Product</button>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($prod = $products->fetch_assoc()): ?>
                        <tr id="prod-row-<?= $prod['product_id'] ?>">
                            <td><?= htmlspecialchars($prod['product_id']) ?></td>
                            <td><?= htmlspecialchars($prod['product_name']) ?></td>
                            <td><?= htmlspecialchars($prod['category_name']) ?></td>
                            <td><?= number_format($prod['price'], 0, ',', '.') ?> VNĐ</td>
                            <td>
                                <span class="badge bg-<?= $prod['is_available'] ? 'success' : 'secondary' ?>"><?= $prod['is_available'] ? 'Available' : 'Unavailable' ?></span>
                            </td>
                            <td><?= htmlspecialchars($prod['created_at']) ?></td>
                            <td>
                                <button class="btn btn-info btn-sm edit-prod-btn" data-id="<?= $prod['product_id'] ?>">Edit</button>
                                <button class="btn btn-danger btn-sm delete-prod-btn" data-id="<?= $prod['product_id'] ?>">Delete</button>
                                <button class="btn btn-warning btn-sm toggle-prod-btn" data-id="<?= $prod['product_id'] ?>">Toggle</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Product Modal -->
        <div class="modal fade" id="prodModal" tabindex="-1" aria-labelledby="prodModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="prodModalLabel">Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body" id="prodModalBody">
                <!-- Content loaded by AJAX -->
              </div>
            </div>
          </div>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const prodModal = new bootstrap.Modal(document.getElementById('prodModal'));
document.getElementById('addProductBtn').onclick = function() {
    fetch('product_modal.php?action=add')
        .then(res => res.text())
        .then(html => {
            document.getElementById('prodModalLabel').textContent = 'Add Product';
            document.getElementById('prodModalBody').innerHTML = html;
            prodModal.show();
        });
};
document.querySelectorAll('.edit-prod-btn').forEach(btn => {
    btn.onclick = function() {
        fetch('product_modal.php?action=edit&id=' + btn.dataset.id)
            .then(res => res.text())
            .then(html => {
                document.getElementById('prodModalLabel').textContent = 'Edit Product';
                document.getElementById('prodModalBody').innerHTML = html;
                prodModal.show();
            });
    };
});
document.querySelectorAll('.delete-prod-btn').forEach(btn => {
    btn.onclick = function() {
        if (confirm('Delete this product?')) {
            fetch('product_modal.php?action=delete&id=' + btn.dataset.id, { method: 'POST' })
                .then(res => res.json())
                .then(data => { if (data.success) location.reload(); else alert('Delete failed!'); });
        }
    };
});
document.querySelectorAll('.toggle-prod-btn').forEach(btn => {
    btn.onclick = function() {
        fetch('product_modal.php?action=toggle&id=' + btn.dataset.id, { method: 'POST' })
            .then(res => res.json())
            .then(data => { if (data.success) location.reload(); else alert('Toggle failed!'); });
    };
});
</script>
</body>
</html> 