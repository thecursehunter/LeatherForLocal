<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
require_once '../../src/config/Database.php';
$conn = Database::getInstance();
// Fetch stats
$stats = [
    'completed' => 0,
    'pending' => 0,
    'cancelled' => 0,
    'users' => 0
];
$res = $conn->query("SELECT COUNT(*) as cnt FROM `order` WHERE status = 'Completed'");
if ($row = $res->fetch_assoc()) $stats['completed'] = $row['cnt'];
$res = $conn->query("SELECT COUNT(*) as cnt FROM `order` WHERE status = 'Pending'");
if ($row = $res->fetch_assoc()) $stats['pending'] = $row['cnt'];
$res = $conn->query("SELECT COUNT(*) as cnt FROM `order` WHERE status = 'Cancelled'");
if ($row = $res->fetch_assoc()) $stats['cancelled'] = $row['cnt'];
$res = $conn->query("SELECT COUNT(*) as cnt FROM member");
if ($row = $res->fetch_assoc()) $stats['users'] = $row['cnt'];
// Fetch members
$members = [];
$res = $conn->query("SELECT member_id, username, email, phone_number FROM member");
while ($row = $res->fetch_assoc()) $members[] = $row;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f7f8fa; }
        .admin-header { background: #3b5bfe; color: #fff; padding: 1.5rem 0; }
        .admin-footer { background: #222; color: #fff; padding: 1rem 0; margin-top: 3rem; }
        .dashboard-card { border-radius: 1rem; cursor: pointer; }
        .stat-label { font-size: 1rem; color: #888; }
        .stat-value { font-size: 2rem; font-weight: bold; }
    </style>
</head>
<body>
<div class="d-flex">
    <?php $activePage = 'dashboard'; include __DIR__ . '/../components/admin_sidebar.php'; ?>
    <main class="container my-5">
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="bg-white p-4 dashboard-card shadow-sm text-center">
                    <div class="stat-label">Orders Completed</div>
                    <div class="stat-value"><?= $stats['completed'] ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="bg-white p-4 dashboard-card shadow-sm text-center">
                    <div class="stat-label">Orders Pending</div>
                    <div class="stat-value"><?= $stats['pending'] ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="bg-white p-4 dashboard-card shadow-sm text-center">
                    <div class="stat-label">Orders Cancelled</div>
                    <div class="stat-value"><?= $stats['cancelled'] ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="bg-white p-4 dashboard-card shadow-sm text-center">
                    <div class="stat-label">Total Users</div>
                    <div class="stat-value"><?= $stats['users'] ?></div>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 dashboard-card shadow-sm">
            <h5>Members List</h5>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($members as $m): ?>
                    <tr id="member-row-<?= $m['member_id'] ?>">
                        <td><?= htmlspecialchars($m['member_id']) ?></td>
                        <td><?= htmlspecialchars($m['username']) ?></td>
                        <td><?= htmlspecialchars($m['email']) ?></td>
                        <td><?= htmlspecialchars($m['phone_number']) ?></td>
                        <td>
                            <button class="btn btn-info btn-sm member-view-btn" data-id="<?= $m['member_id'] ?>">View</button>
                            <button class="btn btn-warning btn-sm member-update-btn" data-id="<?= $m['member_id'] ?>">Update</button>
                            <a href="member_delete.php?id=<?= $m['member_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this member?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Member View/Update Modal -->
        <div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="memberModalLabel">Member Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body" id="memberModalBody">
                <!-- Content loaded by AJAX -->
              </div>
            </div>
          </div>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Member view
const memberModal = new bootstrap.Modal(document.getElementById('memberModal'));
document.querySelectorAll('.member-view-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        fetch('member_view.php?id=' + this.dataset.id)
            .then(res => res.text())
            .then(html => {
                document.getElementById('memberModalLabel').textContent = 'Member Details';
                document.getElementById('memberModalBody').innerHTML = html;
                memberModal.show();
            });
    });
});
// Member update
function updateMemberRow(id, data) {
    const row = document.getElementById('member-row-' + id);
    if (row) {
        row.children[1].textContent = data.username;
        row.children[2].textContent = data.email;
        row.children[3].textContent = data.phone_number;
    }
}
document.querySelectorAll('.member-update-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        fetch('member_update.php?id=' + this.dataset.id)
            .then(res => res.text())
            .then(html => {
                document.getElementById('memberModalLabel').textContent = 'Update Member';
                document.getElementById('memberModalBody').innerHTML = html;
                memberModal.show();
                // Handle update form submit
                const form = document.getElementById('memberUpdateForm');
                if (form) {
                    form.onsubmit = function(e) {
                        e.preventDefault();
                        const formData = new FormData(form);
                        fetch('member_update.php?id=' + btn.dataset.id, {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                updateMemberRow(btn.dataset.id, data.member);
                                memberModal.hide();
                            } else {
                                alert('Update failed!');
                            }
                        });
                    };
                }
            });
    });
});
</script>
</body>
</html>