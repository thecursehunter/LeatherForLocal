<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
require_once '../../src/config/Database.php';
$conn = Database::getInstance();
// Handle cancel order
if (isset($_POST['cancel_order_id'])) {
    $oid = intval($_POST['cancel_order_id']);
    $conn->query("UPDATE `order` SET status='Cancelled' WHERE order_id=$oid");
    header('Location: orders.php');
    exit;
}
// Handle export XML
if (isset($_GET['export']) && $_GET['export'] === 'xml') {
    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="orders.xml"');
    $orders = $conn->query("SELECT o.*, m.username FROM `order` o JOIN member m ON o.member_id = m.member_id");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<orders>\n";
    while ($order = $orders->fetch_assoc()) {
        echo "  <order>\n";
        foreach ($order as $k => $v) {
            echo "    <{$k}>" . htmlspecialchars($v) . "</{$k}>\n";
        }
        // Order items
        $items = $conn->query("SELECT * FROM orderitem WHERE order_id=" . intval($order['order_id']));
        echo "    <items>\n";
        while ($item = $items->fetch_assoc()) {
            echo "      <item>\n";
            foreach ($item as $ik => $iv) {
                echo "        <{$ik}>" . htmlspecialchars($iv) . "</{$ik}>\n";
            }
            echo "      </item>\n";
        }
        echo "    </items>\n";
        echo "  </order>\n";
    }
    echo "</orders>\n";
    exit;
}
// Search/filter
$where = [];
$params = [];
if (!empty($_GET['search'])) {
    $search = '%' . $conn->real_escape_string($_GET['search']) . '%';
    $where[] = "(m.username LIKE '$search' OR o.order_id LIKE '$search')";
}
if (!empty($_GET['status'])) {
    $status = $conn->real_escape_string($_GET['status']);
    $where[] = "o.status = '$status'";
}
$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
$sql = "SELECT o.*, m.username FROM `order` o JOIN member m ON o.member_id = m.member_id $whereSql ORDER BY o.order_date DESC";
$orders = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Orders Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f7f8fa; }
        .admin-header { background: #1fa67a; color: #fff; padding: 1.5rem 0; }
        .admin-footer { background: #222; color: #fff; padding: 1rem 0; margin-top: 3rem; }
        .order-status-paid { background: #d4f8e8; color: #1fa67a; border-radius: 8px; padding: 2px 12px; }
        .order-status-pending { background: #eaf1fb; color: #3b5bfe; border-radius: 8px; padding: 2px 12px; }
        .order-status-cancelled { background: #ffeaea; color: #e74c3c; border-radius: 8px; padding: 2px 12px; }
        .order-row:hover { background: #f0f0f0; cursor: pointer; }
    </style>
</head>
<body>
    <div class="d-flex">
        <?php $activePage = 'orders'; include __DIR__ . '/../components/admin_sidebar.php'; ?>
        <main class="container my-5">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <form class="d-flex gap-2" method="get">
                    <input type="text" class="form-control" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Search by user or ID">
                    <select class="form-select" name="status">
                        <option value="">All Statuses</option>
                        <option value="Done" <?= (($_GET['status'] ?? '')==='Done')?'selected':'' ?>>Done</option>
                        <option value="Pending" <?= (($_GET['status'] ?? '')==='Pending')?'selected':'' ?>>Pending</option>
                        <option value="Cancelled" <?= (($_GET['status'] ?? '')==='Cancelled')?'selected':'' ?>>Cancelled</option>
                    </select>
                    <button class="btn btn-primary" type="submit">Filter</button>
                </form>
                <a class="btn btn-success" href="?export=xml">Export</a>
            </div>
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Orders List</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Total (VNĐ)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = $orders->fetch_assoc()): ?>
                            <tr class="order-row" data-bs-toggle="modal" data-bs-target="#orderDetailModal" data-order-id="<?= $order['order_id'] ?>">
                                <td><?= htmlspecialchars($order['order_id']) ?></td>
                                <td><?= htmlspecialchars($order['username']) ?></td>
                                <td><?= htmlspecialchars($order['order_date']) ?></td>
                                <td>
                                    <?php if ($order['status'] === 'Done'): ?>
                                        <span class="order-status-paid">Done</span>
                                    <?php elseif ($order['status'] === 'Pending'): ?>
                                        <span class="order-status-pending">Pending</span>
                                    <?php else: ?>
                                        <span class="order-status-cancelled">Cancelled</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= number_format($order['total_amount'], 0) ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm view-btn" data-bs-toggle="modal" data-bs-target="#orderDetailModal" data-order-id="<?= $order['order_id'] ?>">View</button>
                                    <?php if ($order['status'] !== 'Cancelled'): ?>
                                    <form method="post" style="display:inline;">
                                        <input type="hidden" name="cancel_order_id" value="<?= $order['order_id'] ?>">
                                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Cancel this order?')">Cancel</button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
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
    </div>
    <footer class="admin-footer text-center">
        &copy; 2025 LeatherForLocal Admin Panel
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Show order details in modal
    const modalBody = document.getElementById('orderDetailBody');
    document.querySelectorAll('.order-row, .view-btn').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.stopPropagation();
            var orderId = this.getAttribute('data-order-id');
            if (orderId) {
                fetch('order_detail_ajax.php?id=' + orderId)
                    .then(res => res.text())
                    .then(html => { modalBody.innerHTML = html; });
            }
        });
    });
    </script>
</body>
</html>