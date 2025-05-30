<?php
require_once __DIR__ . '/../../src/controllers/CustomerInfoController.php';
$controller = new CustomerInfoController();
$member = $controller->handleRequest();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông Tin Cá Nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/global.css" />
    <link rel="stylesheet" href="../../public/css/styleguide.css" />
    <link rel="stylesheet" href="../../public/css/style.css" />
    <style>
        .profile-section { background-color: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .avatar img { width: 100px; height: 100px; border-radius: 50%; }
        .info-card { max-width: 900px; margin: 0 auto; }
    </style>
</head>
<body>
<?php include __DIR__ . '/../components/header.php'; ?>
<div class="container py-5">
    <div class="info-card card p-4">
        <h2 class="mb-4 text-center">THÔNG TIN CÁ NHÂN</h2>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Cập nhật thành công!</div>
        <?php endif; ?>
        <div class="row profile-section p-4 align-items-center">
            <div class="col-md-4 text-center mb-4 mb-md-0">
                <div class="avatar mb-3">
                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="avatar">
                </div>
                <form method="post" id="infoForm">
                    <div class="mb-3">
                        <label class="form-label">Tên đăng nhập</label>
                        <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($member['username'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" name="full_name" value="<?php echo htmlspecialchars($member['full_name'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($member['address'] ?? ''); ?>">
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Lưu thay đổi</button>
                </form>
                <a href="index.php" class="btn btn-outline-secondary w-100 mt-2">Về trang chủ</a>
                <a href="member_orders.php" class="btn btn-outline-primary w-100 mt-2">Xem đơn hàng của tôi</a>
            </div>
            <div class="col-md-8">
                <h4 class="mb-4">Số điện thoại và Email</h4>
                <div class="mb-3 d-flex align-items-center">
                    <span class="me-2">Số điện thoại:</span>
                    <span id="phone" class="fw-bold me-2"><?php echo htmlspecialchars($member['phone_number'] ?? ''); ?></span>
                    <button class="btn btn-outline-primary btn-sm" onclick="updateField('phone_number')">Cập nhật</button>
                </div>
                <div class="mb-3 d-flex align-items-center">
                    <span class="me-2">Email:</span>
                    <span id="email" class="fw-bold me-2"><?php echo htmlspecialchars($member['email'] ?? ''); ?></span>
                    <button class="btn btn-outline-primary btn-sm" onclick="updateField('email')">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function updateField(field) {
    let current = document.getElementById(field === 'phone_number' ? 'phone' : 'email').innerText;
    let label = field === 'phone_number' ? 'số điện thoại' : 'email';
    let value = prompt('Nhập ' + label + ' mới:', current);
    if (value !== null && value.trim() !== "") {
        const formData = new FormData();
        formData.append('ajax', 1);
        formData.append('field', field);
        formData.append('value', value);
        fetch(window.location.pathname, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById(field === 'phone_number' ? 'phone' : 'email').innerText = value;
                alert('Đã cập nhật ' + label + '!');
            } else {
                alert('Cập nhật thất bại!');
            }
        });
    }
}
</script>
</body>
</html>
