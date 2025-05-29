<?php
session_start();
require_once '../../src/controllers/LoginController.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username && $password) {
        $controller = new LoginController();
        // Kiểm tra đăng nhập admin trước
        $admin = $controller->handleAdminLogin($username, $password);
        if ($admin) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_full_name'] = $admin['full_name'];
            header('Location: ../admin/dashboard.php'); // Đổi đường dẫn trang admin cho phù hợp
            exit;
        }
        // Nếu không phải admin, kiểm tra member
        $user = $controller->handleLogin($username, $password);
        if ($user) {
            $_SESSION['member_id'] = $user['member_id'];
            $_SESSION['full_name'] = $user['full_name'];
            header('Location: product.php');
            exit;
        } else {
            $error = 'Tên đăng nhập hoặc mật khẩu không đúng!';
        }
    } else {
        $error = 'Vui lòng nhập đầy đủ thông tin!';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - LEATHERFORLOCAL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/global.css" />
    <link rel="stylesheet" href="../../public/css/styleguide.css" />
    <link rel="stylesheet" href="../../public/css/style.css" />
</head>
<body>
    <?php include __DIR__ . '/../components/header.php'; ?>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="row w-100 justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm p-4 login-card">
                    <h2 class="mb-4 text-center">Đăng nhập</h2>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" name="username" id="username" required autocomplete="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" name="password" id="password" required autocomplete="current-password">
                        </div>
                        <button type="submit" class="btn btn-outline-primary w-100">Đăng nhập</button>
                    </form>
                    <div class="text-center mt-3">
                        <span>Chưa có tài khoản?</span>
                        <a href="register.php" class="ms-1">Đăng ký ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
            <div class="login-slider position-relative">
                <img id="login-slider-img" src="../../public/images/products/backpack_1.jpg" class="img-fluid rounded-3 shadow login-side-img" alt="Slider">
            </div>
        </div>
        </div>
    </div>
    <?php include __DIR__ . '/../components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
const sliderImages = [
    '../../public/images/products/backpack_1.jpg',
    '../../public/images/products/backpack_2.jpg',
    '../../public/images/products/bag_1.jpg',
    '../../public/images/products/jacket_1.jpg',
    '../../public/images/products/jacket_2.jpg',
    '../../public/images/products/jacket_3.jpg'
];
let sliderIndex = 0;
setInterval(() => {
    sliderIndex = (sliderIndex + 1) % sliderImages.length;
    document.getElementById('login-slider-img').src = sliderImages[sliderIndex];
}, 5000);
</script>
</body>
</html>