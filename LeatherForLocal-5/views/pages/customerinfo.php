<?php
// Kết nối database (sửa thông tin kết nối cho phù hợp)
$host = 'localhost';
$db = 'leatherforlocal';
$user = 'your_username';
$pass = 'your_password';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

session_start();
$member_id = $_SESSION['member_id'] ?? 1; // Thay 1 bằng session thực tế

// Xử lý cập nhật nhanh email hoặc số điện thoại qua AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_field'], $_POST['value'])) {
    $field = $_POST['update_field'];
    $value = $conn->real_escape_string($_POST['value']);
    if (in_array($field, ['phone_number', 'email'])) {
        $sql = "UPDATE member SET $field='$value' WHERE id=$member_id";
        $conn->query($sql);
        exit;
    }
}

// Xử lý lưu toàn bộ thông tin khi submit form (nếu có)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $address = $conn->real_escape_string($_POST['address']);

    $sql = "UPDATE member SET username='$username', email='$email', phone_number='$phone_number', address='$address' WHERE id=$member_id";
    if ($conn->query($sql) === TRUE) {
        $msg = "Cập nhật thành công!";
    } else {
        $msg = "Lỗi: " . $conn->error;
    }
}

// Lấy thông tin khách hàng
$sql = "SELECT * FROM member WHERE member_id = $member_id";
$result = $conn->query($sql);
$member = null;

if ($result) {
    $member = $result->fetch_assoc();
} else {
    echo "<div style='color:red;'>Lỗi truy vấn: " . $conn->error . "</div>";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông Tin Cá Nhân</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>THÔNG TIN CÁ NHÂN</h2>
        <div class="profile-section">
            <div class="left">
                <div class="avatar">
                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="avatar">
                </div>
                <label>Tên đăng nhập</label>
                <input type="text" id="username" value="<?php echo htmlspecialchars($member['username'] ?? ''); ?>" readonly>

                <label>Họ và tên</label>
                <input type="text" id="fullName" value="<?php echo htmlspecialchars($member['full_name'] ?? ''); ?>">
                <label>Ngày sinh</label>
                <div class="birthdate">
                    <select id="day"></select>
                    <select id="month"></select>
                    <select id="year"></select>
                </div>
            <button onclick="window.location.href='index.php'" style="background-color:#8f9125; color:white; margin-top:10px;">Về trang chủ</button>
                <button onclick="saveInfo(); alert('Đã lưu thông tin!');">Lưu thay đổi</button>
            </div>
            <div class="right">
                <h3>Số điện thoại và email</h3>
                <p>Số điện thoại: <span id="phone"><?php echo htmlspecialchars($member['phone_number'] ?? ''); ?></span> 
                    <button type="button" onclick="updateField('phone_number')">Cập nhật</button>
                </p>
                <p>Email: <span id="email"><?php echo htmlspecialchars($member['email'] ?? ''); ?></span>  
                    <button type="button" onclick="updateField('email')">Cập nhật</button>
                </p>
                <script>
                function updateField(field) {
                    let current = document.getElementById(field === 'phone_number' ? 'phone' : 'email').innerText;
                    let label = field === 'phone_number' ? 'số điện thoại' : 'email';
                    let value = prompt("Nhập " + label + " mới:", current);
                    if (value !== null && value.trim() !== "") {
                        fetch(window.location.pathname, {
                            method: "POST",
                            headers: { "Content-Type": "application/x-www-form-urlencoded" },
                            body: `update_field=${field}&value=${encodeURIComponent(value)}`
                        }).then(() => {
                            document.getElementById(field === 'phone_number' ? 'phone' : 'email').innerText = value;
                            alert("Đã cập nhật " + label + "!");
                        });
                    }
                }
                </script>
                <?php
                // Xử lý cập nhật nhanh số điện thoại/email qua AJAX
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_field'], $_POST['value'])) {
                    $field = $_POST['update_field'];
                    $value = $conn->real_escape_string($_POST['value']);
                    if (in_array($field, ['phone_number', 'email'])) {
                        $sql = "UPDATE member SET $field='$value' WHERE id=$member_id";
                        $conn->query($sql);
                        exit; // Dừng trả về HTML nếu là AJAX
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #fff0f3;
    margin: 0;
    padding: 0;
}

.container {
    padding: 20px;
}

h2 {
    color: #666;
    background-color: #ccc;
    padding: 10px;
}

.profile-section {
    display: flex;
    background-color: #8f9125;
    padding: 20px;
    border-radius: 10px;
}

.left, .right {
    flex: 1;
    padding: 20px;
}

.avatar img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
}

label {
    display: block;
    margin-top: 15px;
    font-weight: bold;
}

input, select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #999;
    border-radius: 5px;
}

.birthdate select {
    width: 32%;
    margin-right: 2%;
}

button {
    background-color: #666;
    color: white;
    border: none;
    padding: 10px;
    margin-top: 15px;
    border-radius: 5px;
    cursor: pointer;
}

.right h3 {
    color: #666;
}


.right span {
    font-weight: bold;
}
</style>
<script>
    // Tạo danh sách ngày tháng năm
window.onload = function () {
    loadBirthOptions();
    loadSavedInfo();
};

function loadBirthOptions() {
    for (let i = 1; i <= 31; i++) {
        document.getElementById('day').innerHTML += `<option>${i}</option>`;
    }
    for (let i = 1; i <= 12; i++) {
        document.getElementById('month').innerHTML += `<option>${i}</option>`;
    }
    for (let i = 1970; i <= 2020; i++) {
        document.getElementById('year').innerHTML += `<option>${i}</option>`;
    }
}

// Cập nhật số điện thoại
document.querySelectorAll('button').forEach(btn => {
    if (btn.previousSibling && btn.previousSibling.textContent && btn.previousSibling.textContent.includes('Số điện thoại')) {
        btn.addEventListener('click', function() {
            let newPhone = prompt("Nhập số điện thoại mới:", document.getElementById('phone').innerText);
            if (newPhone !== null && newPhone.trim() !== "") {
                // Gửi AJAX cập nhật
                fetch(window.location.pathname, {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `update_field=phone_number&value=${encodeURIComponent(newPhone)}`
                }).then(() => {
                    document.getElementById('phone').innerText = newPhone;
                    alert("Đã cập nhật số điện thoại!");
                });
            }
        });
    }
    // Cập nhật email
    if (btn.previousSibling && btn.previousSibling.textContent && btn.previousSibling.textContent.includes('Email')) {
        btn.addEventListener('click', function() {
            let newEmail = prompt("Nhập email mới:", document.getElementById('email').innerText);
            if (newEmail !== null && newEmail.trim() !== "") {
                fetch(window.location.pathname, {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `update_field=email&value=${encodeURIComponent(newEmail)}`
                }).then(() => {
                    document.getElementById('email').innerText = newEmail;
                    alert("Đã cập nhật email!");
                });
            }
        });
    }
});

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
<?php $conn->close(); ?>
