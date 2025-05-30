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
    $conn->query("UPDATE `order` SET status='Cancelled' WHERE order_id=$oid AND member_id=$member_id AND status='Pending'");
    header('Location: member_orders.php');
    exit;
}

// Fetch orders for this member
$sql = "SELECT * FROM `order` WHERE member_id = $member_id ORDER BY order_date DESC";
$orders = $conn->query($sql);

// Breadcrumb
$breadcrumb_items = [
    ['label' => 'Home', 'url' => 'index.php'],
    ['label' => 'Đơn hàng của tôi', 'url' => null]
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <title>Quản Lý Đơn Hàng Của Tôi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../public/css/global.css" />
    <link rel="stylesheet" href="../../public/css/styleguide.css" />
    <link rel="stylesheet" href="../../public/css/style.css" />
</head>
<body>
    <?php include __DIR__ . '/../components/header.php'; ?>
    <div class="container mt-4">
        <?php include __DIR__ . '/../components/breadcrumb.php'; ?>
        <h2 class="mb-4 fw-bold text-center">Đơn Hàng Của Tôi</h2>
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
    </div>
    <?php include __DIR__ . '/../components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>