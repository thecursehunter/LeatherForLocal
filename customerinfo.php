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
</head>
<body>
<?php include __DIR__ . '/../components/header.php'; ?>

<div class="container py-5">
    <h2 class="mb-4">THÔNG TIN CÁ NHÂN</h2>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Cập nhật thành công!</div>
    <?php endif; ?>
    <div class="row profile-section p-4">
        <div class="col-md-4 text-center">
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
                <div class="mb-3">
                    <label class="form-label">Số điện thoại:</label>
                    <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($member['phone_number'] ?? ''); ?>">
                </div>
                                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($member['email'] ?? ''); ?>">
                </div>
        <!-- Hình ảnh bên phải -->
        </div>
        <div class="col-md-8 d-flex align-items-center justify-content-center">
            <img id="customerinfo-slider-img" src="../../public/images/products/backpack_1.jpg" alt="Ảnh sản phẩm" class="img-fluid rounded shadow" style="max-height:500px; width:80%; object-fit:cover;">
        </div>
        <div class="w-1000"></div>
        <div class="col-12 mt-3">
    </div>
                <button type="submit" class="btn btn-dark w-100">Lưu thay đổi</button>
            </form>
            <a href="index.php" class="btn btn-secondary w-100 mt-2">Về trang chủ</a>
        </div>
    </div>  
</div>
    </div>
    <?php include __DIR__ . '/../components/footer.php';?>
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
    document.getElementById('customerinfo-slider-img').src = sliderImages[sliderIndex];
}, 5000);

function saveInfo() {
    const fullName = document.getElementById('fullName').value;
    const nickname = document.getElementById('nickname').value;
    const day = document.getElementById('day').value;
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;
    const nationality = document.getElementById('nationality').value;

    const info = {
        username,
        nickname,
        birthday: `${day}/${month}/${year}`,
        nationality
    };

    localStorage.setItem("userInfo", JSON.stringify(info));
    alert("Đã lưu thông tin!");
}

function loadSavedInfo() {
    const saved = localStorage.getItem("userInfo");
    if (saved) {
        const info = JSON.parse(saved);
        document.getElementById('username').value = info.username;
        document.getElementById('nickname').value = info.nickname;

        const [d, m, y] = info.birthday.split('/');
        document.getElementById('day').value = d;
        document.getElementById('month').value = m;
        document.getElementById('year').value = y;

        document.getElementById('nationality').value = info.nationality;
    }
}
    // Hiển thị thông tin khách hàng
    document.getElementById('username').value = '<?php echo $member['username'] ?? ''; ?>';
    document.getElementById('email').innerText = '<?php echo $member['email'] ?? ''; ?>';
    document.getElementById('phone').innerText = '<?php echo $member['phone'] ?? ''; ?>';
</script>