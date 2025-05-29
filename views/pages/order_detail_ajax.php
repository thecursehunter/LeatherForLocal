<?php
require_once '../../src/config/Database.php';
$conn = Database::getInstance();
$order_id = intval($_GET['id'] ?? 0);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $conn->real_escape_string($_POST['status'] ?? '');
    $conn->query("UPDATE `order` SET status='$status' WHERE order_id=$order_id");
    echo json_encode(['success'=>true]);
    exit;
}
$res = $conn->query("SELECT o.*, m.username FROM `order` o JOIN member m ON o.member_id = m.member_id WHERE o.order_id = $order_id");
$order = $res ? $res->fetch_assoc() : null;
if (!$order) { echo '<div class=\'text-danger\'>Order not found.</div>'; exit; }
$items = $conn->query("SELECT * FROM orderitem WHERE order_id = $order_id");
?>
<div>
    <strong>Order ID:</strong> <?= htmlspecialchars($order['order_id']) ?><br>
    <strong>User:</strong> <?= htmlspecialchars($order['username']) ?><br>
    <strong>Date:</strong> <?= htmlspecialchars($order['order_date']) ?><br>
    <strong>Status:</strong>
    <form id="orderStatusForm">
        <select name="status" class="form-select form-select-sm w-auto d-inline-block">
            <?php foreach (["Pending","Done","Cancelled"] as $s): ?>
                <option value="<?= $s ?>" <?= $order['status']===$s?'selected':'' ?>><?= $s ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary btn-sm">Save</button>
    </form>
    <strong>Total:</strong> <?= number_format($order['total_amount'], 0) ?> VNĐ
    <hr>
    <strong>Order Items:</strong>
    <ul class="list-group mb-2">
        <?php while($item = $items->fetch_assoc()): ?>
        <li class="list-group-item">
            Product ID: <?= htmlspecialchars($item['product_id']) ?>,
            Quantity: <?= htmlspecialchars($item['quantity']) ?>,
            Unit Price: <?= number_format($item['unit_price'], 0) ?> VNĐ,
            Subtotal: <?= number_format($item['subtotal'], 0) ?> VNĐ
        </li>
        <?php endwhile; ?>
    </ul>
</div>
<script>
const form = document.getElementById('orderStatusForm');
form.onsubmit = function(e) {
    e.preventDefault();
    const formData = new FormData(form);
    fetch('order_detail_ajax.php?id=<?= $order_id ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Status updated!');
        } else {
            alert('Update failed!');
        }
    });
};
</script> 