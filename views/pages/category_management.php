<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
$activePage = 'category';
require_once '../../src/config/Database.php';
$conn = Database::getInstance();
$categories = $conn->query("SELECT * FROM category ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Category Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
    <?php include __DIR__ . '/../components/admin_sidebar.php'; ?>
    <main class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Category Management</h2>
            <button class="btn btn-success" id="addCategoryBtn">Add Category</button>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($cat = $categories->fetch_assoc()): ?>
                        <tr id="cat-row-<?= $cat['category_id'] ?>">
                            <td><?= htmlspecialchars($cat['category_id']) ?></td>
                            <td><?= htmlspecialchars($cat['name']) ?></td>
                            <td><?= htmlspecialchars($cat['description']) ?></td>
                            <td>
                                <span class="badge bg-<?= $cat['is_active'] ? 'success' : 'secondary' ?>"><?= $cat['is_active'] ? 'Active' : 'Inactive' ?></span>
                            </td>
                            <td><?= htmlspecialchars($cat['created_at']) ?></td>
                            <td>
                                <button class="btn btn-info btn-sm edit-cat-btn" data-id="<?= $cat['category_id'] ?>">Edit</button>
                                <button class="btn btn-danger btn-sm delete-cat-btn" data-id="<?= $cat['category_id'] ?>">Delete</button>
                                <button class="btn btn-warning btn-sm toggle-cat-btn" data-id="<?= $cat['category_id'] ?>">Toggle</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Category Modal -->
        <div class="modal fade" id="catModal" tabindex="-1" aria-labelledby="catModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="catModalLabel">Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body" id="catModalBody">
                <!-- Content loaded by AJAX -->
              </div>
            </div>
          </div>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const catModal = new bootstrap.Modal(document.getElementById('catModal'));
document.getElementById('addCategoryBtn').onclick = function() {
    fetch('category_modal.php?action=add')
        .then(res => res.text())
        .then(html => {
            document.getElementById('catModalLabel').textContent = 'Add Category';
            document.getElementById('catModalBody').innerHTML = html;
            catModal.show();
        });
};
document.querySelectorAll('.edit-cat-btn').forEach(btn => {
    btn.onclick = function() {
        fetch('category_modal.php?action=edit&id=' + btn.dataset.id)
            .then(res => res.text())
            .then(html => {
                document.getElementById('catModalLabel').textContent = 'Edit Category';
                document.getElementById('catModalBody').innerHTML = html;
                catModal.show();
            });
    };
});
document.querySelectorAll('.delete-cat-btn').forEach(btn => {
    btn.onclick = function() {
        if (confirm('Delete this category?')) {
            fetch('category_modal.php?action=delete&id=' + btn.dataset.id, { method: 'POST' })
                .then(res => res.json())
                .then(data => { if (data.success) location.reload(); else alert('Delete failed!'); });
        }
    };
});
document.querySelectorAll('.toggle-cat-btn').forEach(btn => {
    btn.onclick = function() {
        fetch('category_modal.php?action=toggle&id=' + btn.dataset.id, { method: 'POST' })
            .then(res => res.json())
            .then(data => { if (data.success) location.reload(); else alert('Toggle failed!'); });
    };
});
</script>
</body>
</html> 