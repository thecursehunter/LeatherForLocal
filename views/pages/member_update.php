<?php
require_once '../../src/config/Database.php';
$conn = Database::getInstance();
$id = intval($_GET['id'] ?? 0);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $phone = $conn->real_escape_string($_POST['phone_number'] ?? '');
    $full_name = $conn->real_escape_string($_POST['full_name'] ?? '');
    $address = $conn->real_escape_string($_POST['address'] ?? '');
    $conn->query("UPDATE member SET username='$username', email='$email', phone_number='$phone', full_name='$full_name', address='$address' WHERE member_id=$id");
    $res = $conn->query("SELECT member_id, username, email, phone_number FROM member WHERE member_id=$id");
    $member = $res ? $res->fetch_assoc() : null;
    echo json_encode(['success'=>true, 'member'=>$member]);
    exit;
}
$res = $conn->query("SELECT * FROM member WHERE member_id = $id");
$member = $res ? $res->fetch_assoc() : null;
if (!$member) { echo '<div class="text-danger">Member not found.</div>'; exit; }
?>
<form id="memberUpdateForm">
    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($member['username']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($member['email']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" class="form-control" name="phone_number" value="<?= htmlspecialchars($member['phone_number']) ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($member['full_name']) ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($member['address']) ?>">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form> 