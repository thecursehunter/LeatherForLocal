<?php
// Example: Fetch report data from database/controller
$report = [
    'total_revenue' => 2500000,
    'total_orders' => 120,
    'new_users' => 35,
    'trend' => [400000, 500000, 600000, 550000, 450000]
];
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
    <header class="admin-header text-center">
        <h1>Reports & Analytics</h1>
        <p>Sales, Revenue, and Performance</p>
    </header>
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
                    <div class="stat-label">New Users</div>
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
            <button class="btn btn-primary" onclick="alert('Exporting report...')">Export as PDF</button>
            <button class="btn btn-outline-secondary" onclick="alert('Exporting report...')">Export as Excel</button>
        </div>
    </main>
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