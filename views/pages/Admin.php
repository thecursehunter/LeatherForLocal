<?php
require_once '../../src/controllers/AdminController.php';
$controller = new AdminController();
$admins = $controller->listAdmins();
// Example stats (replace with real data as needed)
$stats = [
    'completed' => 300,
    'pending' => 10,
    'cancelled' => 100,
    'users' => 350,
    'visitors' => 650,
    'views' => 10000,
    'new_orders' => 5,
    'cancelled_orders' => 2
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f7f8fa; }
        .sidebar {
            background: #8f9125;
            min-height: 100vh;
            color: #fff;
            padding-top: 2rem;
        }
        .sidebar .nav-link, .sidebar .navbar-brand { color: #fff; }
        .sidebar .nav-link.active, .sidebar .nav-link:hover { background: #fff; color: #3b5bfe; }
        .dashboard-card { border-radius: 1rem; }
        .stat-label { font-size: 0.95rem; color: #888; }
        .stat-value { font-size: 1.5rem; font-weight: bold; }
        .order-status-paid { background: #d4f8e8; color: #1fa67a; border-radius: 8px; padding: 2px 12px; }
        .order-status-pending { background: #eaf1fb; color: #3b5bfe; border-radius: 8px; padding: 2px 12px; }
        .order-status-cancelled { background: #ffeaea; color: #e74c3c; border-radius: 8px; padding: 2px 12px; }
        .avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }
        .admin-table th, .admin-table td { vertical-align: middle; }
        .sidebar-icon { font-size: 1.5rem; }
    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" />
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="navbar-brand mb-4 d-flex align-items-center gap-2">
                <span class="material-symbols-rounded sidebar-icon">store</span>
                <span>LeatherForLocal</span>
            </div>
            <ul class="nav flex-column gap-2">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php" data-page="dashboard.php"><span class="material-symbols-rounded sidebar-icon">home</span> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#Admin.php" data-page="Admin.php"><span class="material-symbols-rounded sidebar-icon">group</span> Admins</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="product.php" data-page="product.php"><span class="material-symbols-rounded sidebar-icon">inventory_2</span> Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="orders.php" data-page="orders.php"><span class="material-symbols-rounded sidebar-icon">shopping_cart</span> Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reports.php" data-page="reports.php"><span class="material-symbols-rounded sidebar-icon">bar_chart</span> Reports</a>
                </li>
            </ul>
        </nav>
        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-4" id="admin-main-content">
            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                <div>
                    <h4>Welcome Back!</h4>
                    <div class="text-muted">Admin Dashboard Overview</div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <input type="text" class="form-control" placeholder="Search..." style="width: 220px;">
                    <span class="material-symbols-rounded">shopping_cart</span>
                    <span class="material-symbols-rounded">notifications</span>
                    <span class="material-symbols-rounded">account_circle</span>
                </div>
            </div>
            <!-- Stats Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="bg-white p-4 dashboard-card shadow-sm">
                        <div class="stat-label">Orders Completed</div>
                        <div class="stat-value"><?= $stats['completed'] ?>K</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-white p-4 dashboard-card shadow-sm">
                        <div class="stat-label">Orders Pending</div>
                        <div class="stat-value"><?= $stats['pending'] ?>K</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-white p-4 dashboard-card shadow-sm">
                        <div class="stat-label">Orders Cancelled</div>
                        <div class="stat-value"><?= $stats['cancelled'] ?>K</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-white p-4 dashboard-card shadow-sm">
                        <div class="stat-label">Total Users</div>
                        <div class="stat-value"><?= $stats['users'] ?>K</div>
                    </div>
                </div>
            </div>
            <!-- Admin List Table -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Admin List</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                        <span class="material-symbols-rounded align-middle">add</span> Add Admin
                    </button>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover admin-table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Full Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($admins as $admin): ?>
                            <tr>
                                <td><?= htmlspecialchars($admin['admin_id']) ?></td>
                                <td><?= htmlspecialchars($admin['username']) ?></td>
                                <td><?= htmlspecialchars($admin['email']) ?></td>
                                <td><?= htmlspecialchars($admin['full_name']) ?></td>
                                <td>
                                    <form method="post" action="../../src/controllers/AdminController.php" style="display:inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="admin_id" value="<?= $admin['admin_id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this admin?')">
                                            <span class="material-symbols-rounded align-middle">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Add Admin Modal -->
            <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="../../src/controllers/AdminController.php" class="modal-content">
                        <input type="hidden" name="action" value="add">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addAdminModalLabel">Add New Admin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row g-3">
                            <div class="col-12">
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="col-12">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="col-12">
                                <input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
                            </div>
                            <div class="col-12">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add Admin</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Quick Stats -->
            <div class="row g-3 mt-4">
                <div class="col-md-3">
                    <div class="bg-white p-3 dashboard-card shadow-sm text-center">
                        <div class="stat-label">Total Visitors</div>
                        <div class="stat-value"><?= $stats['visitors'] ?>K</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-white p-3 dashboard-card shadow-sm text-center">
                        <div class="stat-label">Product Views</div>
                        <div class="stat-value"><?= number_format($stats['views']) ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-white p-3 dashboard-card shadow-sm text-center">
                        <div class="stat-label">New Orders</div>
                        <div class="stat-value"><?= $stats['new_orders'] ?>K</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-white p-3 dashboard-card shadow-sm text-center">
                        <div class="stat-label">Cancelled</div>
                        <div class="stat-value"><?= $stats['cancelled_orders'] ?>K</div>
                    </div>
                </div>
            </div>
                <!-- Order Detail Modal -->
        <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="orderDetailBody">
                <!-- Order details will be loaded here -->
            </div>
            </div>
        </div>
        </div>
        </main>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar navigation active state
    const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            sidebarLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            // Optional: Scroll to section if you have anchors
            const sectionId = this.getAttribute('href');
            if (sectionId && sectionId.startsWith('#')) {
                e.preventDefault();
                const section = document.querySelector(sectionId);
                if (section) {
                    section.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar navigation active state and AJAX loading
    const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
    const mainContent = document.getElementById('admin-main-content');

    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            sidebarLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            const page = this.getAttribute('data-page');
            if (page) {
                fetch(page)
                    .then(response => response.text())
                    .then(html => {
                        // Extract only the <main> content from the loaded page
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = html;
                        const newMain = tempDiv.querySelector('main');
                        if (newMain) {
                            mainContent.innerHTML = newMain.innerHTML;
                            // Re-initialize scripts for the loaded page
                            initPageScripts(page);
                        } else {
                            mainContent.innerHTML = '<div class="alert alert-danger">Failed to load content.</div>';
                        }
                    })
                    .catch(() => {
                        mainContent.innerHTML = '<div class="alert alert-danger">Failed to load content.</div>';
                    });
            }
        });
    });
});
// Add this function after your AJAX script
function initPageScripts(page) {
    // Orders page: re-attach event listeners for order modals
    if (page === 'orders.php') {
        document.querySelectorAll('.order-row, .view-btn').forEach(function(item) {
            item.addEventListener('click', function(e) {
                e.stopPropagation();
                var order = this.getAttribute('data-order');
                if (order) {
                    var data = JSON.parse(order);
                    document.getElementById('orderDetailBody').innerHTML =
                        `<strong>Order ID:</strong> ${data.id}<br>
                         <strong>User:</strong> ${data.user}<br>
                         <strong>Date:</strong> ${data.date}<br>
                         <strong>Status:</strong> ${data.status}<br>
                         <strong>Total:</strong> ${data.total.toLocaleString()} VNĐ`;
                }
            });
        });
    }
    // Dashboard page: re-attach notification modal logic
    if (page === 'dashboard.php') {
        document.querySelectorAll('.notification-item').forEach(function(item) {
            item.addEventListener('click', function() {
                document.getElementById('notificationModalBody').textContent = this.getAttribute('data-message');
            });
        });
    }
    // Reports page: re-initialize Chart.js
    if (page === 'reports.php' && typeof Chart !== 'undefined') {
        const ctx = document.getElementById('revenueChart');
        if (ctx) {
            new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5'],
                    datasets: [{
                        label: 'Revenue',
                        data: [400000, 500000, 600000, 550000, 450000],
                        borderColor: '#3b5bfe',
                        backgroundColor: 'rgba(59,91,254,0.1)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { callback: v => v.toLocaleString() + ' VNĐ' } }
                    }
                }
            });
        }
    }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>