<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
require_once '../../src/config/Database.php';
$conn = Database::getInstance();
// Fetch report data (live)
$report = [
    'total_revenue' => 0,
    'total_orders' => 0,
    'new_users' => 0,
    'trend' => []
];
$res = $conn->query("SELECT SUM(total_amount) as tr, COUNT(*) as totd FROM `order` WHERE status = 'Done'");
if ($row = $res->fetch_assoc()) {
    $report['total_revenue'] = $row['tr'] ?? 0;
    $report['total_orders'] = $row['totd'] ?? 0;
}
$res = $conn->query("SELECT COUNT(*) as cnt FROM member WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
if ($row = $res->fetch_assoc()) $report['new_users'] = $row['cnt'];
$res = $conn->query("SELECT DATE(order_date) as d, SUM(total_amount) as r FROM `order` WHERE status = 'Done' GROUP BY d ORDER BY d DESC LIMIT 5");
$trend = [];
while ($row = $res->fetch_assoc()) $trend[] = (float)$row['r'];
$report['trend'] = array_reverse($trend);
// Handle export XML (use live data)
if (isset($_GET['export']) && $_GET['export'] === 'xml') {
    // Insert into revenuereport
    $today = date('Y-m-d');
    $now = date('Y-m-d H:i:s');
    $admin_id = $_SESSION['admin_id'] ?? null;
    $stmt = $conn->prepare("INSERT INTO revenuereport (report_date, total_revenue, total_orders, generated_at, admin_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sddsi', $today, $report['total_revenue'], $report['total_orders'], $now, $admin_id);
    $stmt->execute();
    // Output XML
    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="reports.xml"');
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<report>\n";
    echo "  <total_revenue>" . htmlspecialchars($report['total_revenue']) . "</total_revenue>\n";
    echo "  <total_orders>" . htmlspecialchars($report['total_orders']) . "</total_orders>\n";
    echo "  <new_users>" . htmlspecialchars($report['new_users']) . "</new_users>\n";
    echo "  <trend>\n";
    foreach ($report['trend'] as $t) {
        echo "    <day_revenue>" . htmlspecialchars($t) . "</day_revenue>\n";
    }
    echo "  </trend>\n";
    echo "</report>\n";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Reports & Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f7f8fa; }
        .admin-header { background: #e74c3c; color: #fff; padding: 1.5rem 0; }
        .admin-footer { background: #222; color: #fff; padding: 1rem 0; margin-top: 3rem; }
        .report-card { border-radius: 1rem; }
        .stat-label { font-size: 1rem; color: #888; }
        .stat-value { font-size: 2rem; font-weight: bold; }
    </style>
</head>
<body>
<div class="d-flex">
    <?php $activePage = 'reports'; include __DIR__ . '/../components/admin_sidebar.php'; ?>
    <main class="container my-5">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="bg-white p-4 report-card shadow-sm text-center">
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-value text-success"><?= number_format($report['total_revenue'], 0) ?> VNĐ</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-white p-4 report-card shadow-sm text-center">
                    <div class="stat-label">Total Orders</div>
                    <div class="stat-value"><?= $report['total_orders'] ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-white p-4 report-card shadow-sm text-center">
                    <div class="stat-label">New Users (30d)</div>
                    <div class="stat-value"><?= $report['new_users'] ?></div>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 report-card shadow-sm mb-4">
            <h5>Revenue Trend (Last 5 Days)</h5>
            <canvas id="revenueChart" height="80"></canvas>
        </div>
        <div class="bg-white p-4 report-card shadow-sm">
            <h5>Export Reports</h5>
            <a class="btn btn-primary" href="?export=xml">Export as XML</a>
        </div>
    </main>
</div>
<footer class="admin-footer text-center">
    &copy; 2025 LeatherForLocal Admin Panel
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Render revenue trend chart
const ctx = document.getElementById('revenueChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5'],
        datasets: [{
            label: 'Revenue',
            data: <?= json_encode($report['trend']) ?>,
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
</script>
</body>
</html>