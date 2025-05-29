<?php
require_once '../../src/config/Database.php';
$conn = Database::getInstance();
$id = intval($_GET['id'] ?? 0);
$res = $conn->query("SELECT * FROM member WHERE member_id = $id");
$member = $res ? $res->fetch_assoc() : null;
if (!$member) { echo '<div class="text-danger">Member not found.</div>'; exit; }
?>
<ul class="list-group">
    <li class="list-group-item"><strong>ID:</strong> <?= htmlspecialchars($member['member_id']) ?></li>
    <li class="list-group-item"><strong>Username:</strong> <?= htmlspecialchars($member['username']) ?></li>
    <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($member['email']) ?></li>
    <li class="list-group-item"><strong>Phone:</strong> <?= htmlspecialchars($member['phone_number']) ?></li>
    <li class="list-group-item"><strong>Full Name:</strong> <?= htmlspecialchars($member['full_name']) ?></li>
    <li class="list-group-item"><strong>Address:</strong> <?= htmlspecialchars($member['address']) ?></li>
</ul> 