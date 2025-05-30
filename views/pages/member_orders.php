<?php
// filepath: views/pages/member_orders.php
session_start();
if (!isset($_SESSION['member_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../../src/config/Database.php';
$conn = Database::getInstance();
$member_id = $_SESSION['member_id'];

// Handle cancel order
if (isset($_POST['cancel_order_id'])) {
    $oid = intval($_POST['cancel_order_id']);
    // Only allow cancel if order belongs to this member and is not already cancelled/done
    $conn->query("UPDATE `order` SET status='Cancelled' WHERE order_id=$oid AND member_id=$member_id AND status='Pending'");
    header('Location: member_orders.php');
    exit;
}

// Fetch orders for this member
$sql = "SELECT * FROM `order` WHERE member_id = $member_id ORDER BY order_date DESC";
$orders = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Quản Lý Đơn Hàng Của Tôi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f7f8fa; }
        .member-header { background: #3b5bfe; color: #fff; padding: 1.5rem 0; }
        .member-footer { background: #222; color: #fff; padding: 1rem 0; margin-top: 3rem; }
        .order-status-paid { background: #d4f8e8; color: #1fa67a; border-radius: 8px; padding: 2px 12px; }
        .order-status-pending { background: #eaf1fb; color: #3b5bfe; border-radius: 8px; padding: 2px 12px; }
        .order-status-cancelled { background: #ffeaea; color: #e74c3c; border-radius: 8px; padding: 2px 12px; }
        .order-row:hover { background: #f0f0f0; cursor: pointer; }
    </style>
</head>
<body>
    <div class="member-header text-center mb-4">
        <h2>Đơn Hàng Của Tôi</h2>
    </div>
    <main class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Danh Sách Đơn Hàng</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Ngày Đặt</th>
                            <th>Trạng Thái</th>
                            <th>Tổng Tiền (VNĐ)</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = $orders->fetch_assoc()): ?>
                        <tr class="order-row">
                            <td><?= htmlspecialchars($order['order_id']) ?></td>
                            <td><?= htmlspecialchars($order['order_date']) ?></td>
                            <td>
                                <?php if ($order['status'] === 'Done'): ?>
                                    <span class="order-status-paid">Đã giao</span>
                                <?php elseif ($order['status'] === 'Pending'): ?>
                                    <span class="order-status-pending">Đang giao</span>
                                <?php else: ?>
                                    <span class="order-status-cancelled">Đã hủy</span>
                                <?php endif; ?>
                            </td>
                            <td><?= number_format($order['total_amount'], 0) ?></td>
                            <td>
                                <?php if ($order['status'] === 'Pending'): ?>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="cancel_order_id" value="<?= $order['order_id'] ?>">
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Bạn chắc chắn muốn hủy đơn này?')">Hủy đơn</button>
                                </form>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <footer class="member-footer text-center">
        &copy; 2025 LeatherForLocal
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>