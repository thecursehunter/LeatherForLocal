<?php
session_start();
require_once __DIR__ . '/../models/LeadModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $utmSource = $_SESSION['utm_source'] ?? null;

    if (empty($fullName) || empty($email) || empty($phone)) {
        $_SESSION['lead_error'] = "Vui lòng nhập đầy đủ thông tin.";
        header("Location: ../../views/pages/coupons.php");
        exit();
    }

    $leadModel = new LeadModel();
    $leadId = $leadModel->createLead($fullName, $email, $phone, $utmSource);

    if ($leadId) {
        // Save lead ID to session and show success on landing page
        $_SESSION['lead_id'] = $leadId;
        $_SESSION['lead_success'] = true;
        header("Location: ../../views/pages/coupons.php");
        exit();
    } else {
        $_SESSION['lead_error'] = "Có lỗi xảy ra, vui lòng thử lại sau.";
        header("Location: ../../views/pages/coupons.php");
        exit();
    }
} else {
    header("Location: ../../views/pages/coupons.php");
    exit();
}
