<?php
if (!isset($activePage)) $activePage = '';
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Material Symbols -->
    <link rel=  "stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 220px; min-height: 100vh;">
    <a href="dashboard.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <span class="fs-4 fw-bold">Admin Panel</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php if($activePage==='dashboard') echo 'active'; ?>">Dashboard</a>
        </li>
        <li>
            <a href="orders.php" class="nav-link <?php if($activePage==='orders') echo 'active'; ?>">Orders</a>
        </li>
        <li>
            <a href="reports.php" class="nav-link <?php if($activePage==='reports') echo 'active'; ?>">Reports</a>
        </li>
        <li>
            <a href="category_management.php" class="nav-link <?php if($activePage==='category') echo 'active'; ?>">Category Management</a>
        </li>
        <li>
            <a href="product_management.php" class="nav-link <?php if($activePage==='product') echo 'active'; ?>">Product Management</a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="material-symbols-rounded me-2">account_circle</span>
            <strong><?= $_SESSION['admin_full_name'] ?? 'Admin' ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
            <li><a class="dropdown-item" href="admin_logout.php">Logout</a></li>
        </ul>
    </div>
</div> 