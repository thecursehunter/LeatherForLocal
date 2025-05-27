<?php
// Usage: include this file and set $breadcrumb_items as an array of ['label' => ..., 'url' => ...] (url can be null for current page)
if (!isset($breadcrumb_items) || !is_array($breadcrumb_items)) {
    $breadcrumb_items = [
        ['label' => 'Home', 'url' => '#']
    ];
}
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <?php foreach ($breadcrumb_items as $index => $item): ?>
            <?php if (!empty($item['url']) && $index < count($breadcrumb_items) - 1): ?>
                <li class="breadcrumb-item"><a href="<?= htmlspecialchars($item['url']) ?>"><?= htmlspecialchars($item['label']) ?></a></li>
            <?php else: ?>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($item['label']) ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav> 