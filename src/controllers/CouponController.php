<?php
require_once(__DIR__ . '/../models/CouponModel.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$action = $_GET['action'] ?? '';

if ($action === 'apply') {
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);
    $code = $data['code'] ?? '';

    if (empty($code)) {
        echo json_encode(['success' => false, 'error' => 'Vui lòng nhập mã giảm giá']);
        exit;
    }

    $couponModel = new CouponModel();
    $coupon = $couponModel->getCouponByCode($code);

    if ($coupon) {
        // Store in session for final order calculation later if needed
        $_SESSION['applied_coupon'] = $coupon;
        echo json_encode([
            'success' => true, 
            'discount_percentage' => (int)$coupon['discount_percentage'],
            'message' => 'Áp dụng mã thành công!'
        ]);
    } else {
        unset($_SESSION['applied_coupon']);
        echo json_encode(['success' => false, 'error' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn']);
    }
}
