<?php
// Example: Fetch stats and notifications from database or controller
$stats = [
    'completed' => 300,
    'pending' => 10,
    'cancelled' => 100,
    'users' => 350
];
$notifications = [
    'Low stock alert: Balo Hành Trình',
    '2 new support tickets'
];
$recent_activities = [
    'Admin John added a new product.',
    'Order #1234 was completed.',
    'User Jane registered.'
];
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
    <header class="admin-header text-center">
        <h1>Admin Dashboard</h1>
        <p>Overview & Quick Stats</p>
    </header>
    <main class="container my-5">
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="bg-white p-4 dashboard-card shadow-sm text-center" data-bs-toggle="modal" data-bs-target="#ordersCompletedModal">
                    <div class="stat-label">Orders Completed</div>
                    <div class="stat-value"><?= $stats['completed'] ?>K</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="bg-white p-4 dashboard-card shadow-sm text-center" data-bs-toggle="modal" data-bs-target="#ordersPendingModal">
                    <div class="stat-label">Orders Pending</div>
                    <div class="stat-value"><?= $stats['pending'] ?>K</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="bg-white p-4 dashboard-card shadow-sm text-center" data-bs-toggle="modal" data-bs-target="#ordersCancelledModal">
                    <div class="stat-label">Orders Cancelled</div>
                    <div class="stat-value"><?= $stats['cancelled'] ?>K</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="bg-white p-4 dashboard-card shadow-sm text-center">
                    <div class="stat-label">Total Users</div>
                    <div class="stat-value"><?= $stats['users'] ?>K</div>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="bg-white p-4 dashboard-card shadow-sm">
                    <h5>Recent Activity</h5>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($recent_activities as $activity): ?>
                        <li class="list-group-item"><?= htmlspecialchars($activity) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-white p-4 dashboard-card shadow-sm">
                    <h5>Notifications</h5>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($notifications as $note): ?>
                        <li class="list-group-item notification-item" data-bs-toggle="modal" data-bs-target="#notificationModal" data-message="<?= htmlspecialchars($note) ?>">
                            <?= htmlspecialchars($note) ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </main>
    <footer class="admin-footer text-center">
        &copy; 2025 LeatherForLocal Admin Panel
    </footer>

    <!-- Orders Completed Modal -->
    <div class="modal fade" id="ordersCompletedModal" tabindex="-1" aria-labelledby="ordersCompletedModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ordersCompletedModalLabel">Orders Completed</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- You can fetch and display more details here -->
            <p>Details about completed orders...</p>
          </div>
        </div>
      </div>
    </div>
    <!-- Orders Pending Modal -->
    <div class="modal fade" id="ordersPendingModal" tabindex="-1" aria-labelledby="ordersPendingModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ordersPendingModalLabel">Orders Pending</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Details about pending orders...</p>
          </div>
        </div>
      </div>
    </div>
    <!-- Orders Cancelled Modal -->
    <div class="modal fade" id="ordersCancelledModal" tabindex="-1" aria-labelledby="ordersCancelledModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ordersCancelledModalLabel">Orders Cancelled</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Details about cancelled orders...</p>
          </div>
        </div>
      </div>
    </div>
    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="notificationModalLabel">Notification</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="notificationModalBody">
            <!-- Notification message will be inserted here -->
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Show notification details in modal
    document.querySelectorAll('.notification-item').forEach(function(item) {
        item.addEventListener('click', function() {
            document.getElementById('notificationModalBody').textContent = this.getAttribute('data-message');
        });
    });
    </script>
</body>
</html>