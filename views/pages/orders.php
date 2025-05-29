<?php
// Example: Fetch orders from database/controller
$orders = [
    [
        'id' => 1234,
        'user' => 'Jane Doe',
        'date' => '2025-05-28',
        'status' => 'Paid',
        'total' => 650000
    ],
    [
        'id' => 1235,
        'user' => 'John Smith',
        'date' => '2025-05-27',
        'status' => 'Pending',
        'total' => 450000
    ],
    [
        'id' => 1236,
        'user' => 'Mary Lee',
        'date' => '2025-05-26',
        'status' => 'Cancelled',
        'total' => 380000
    ]
];
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
    <header class="admin-header text-center">
        <h1>Orders Management</h1>
        <p>View, filter, and manage all orders</p>
    </header>
    <main class="container my-5">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <form class="d-flex gap-2">
                <input type="text" class="form-control" placeholder="Search by user or ID">
                <select class="form-select">
                    <option value="">All Statuses</option>
                    <option value="Paid">Paid</option>
                    <option value="Pending">Pending</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
                <button class="btn btn-primary" type="submit">Filter</button>
            </form>
            <button class="btn btn-success" onclick="alert('Exporting orders...')">Export</button>
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
                        <?php foreach ($orders as $order): ?>
                        <tr class="order-row" data-bs-toggle="modal" data-bs-target="#orderDetailModal" data-order='<?= json_encode($order) ?>'>
                            <td><?= htmlspecialchars($order['id']) ?></td>
                            <td><?= htmlspecialchars($order['user']) ?></td>
                            <td><?= htmlspecialchars($order['date']) ?></td>
                            <td>
                                <?php if ($order['status'] === 'Paid'): ?>
                                    <span class="order-status-paid">Paid</span>
                                <?php elseif ($order['status'] === 'Pending'): ?>
                                    <span class="order-status-pending">Pending</span>
                                <?php else: ?>
                                    <span class="order-status-cancelled">Cancelled</span>
                                <?php endif; ?>
                            </td>
                            <td><?= number_format($order['total'], 0) ?></td>
                            <td>
                                <button class="btn btn-info btn-sm view-btn" data-bs-toggle="modal" data-bs-target="#orderDetailModal" data-order='<?= json_encode($order) ?>'>View</button>
                                <?php if ($order['status'] !== 'Cancelled'): ?>
                                <button class="btn btn-danger btn-sm" onclick="alert('Order cancelled!')">Cancel</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <footer class="admin-footer text-center">
        &copy; 2025 LeatherForLocal Admin Panel
    </footer>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Show order details in modal
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
    </script>
</body>
</html>