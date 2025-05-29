<?php
require_once '../../src/controllers/ProductController.php';

$productController = new ProductController();
$product_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$product_id) {
    header('Location: product.php');
    exit;
}

$product = $productController->getProductById($product_id);

if (!$product) {
    header('Location: product.php');
    exit;
}

// Prepare breadcrumb items
$breadcrumb_items = [
    ['label' => 'Home', 'url' => 'index.php'],
    ['label' => 'Tất Cả Sản Phẩm', 'url' => 'product.php'],
    ['label' => $product['product_name'], 'url' => null]
];
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../public/css/style.css" />
  </head>
  <body>
    <?php include __DIR__ . '/../components/header.php'; ?>
    <div class="container-fluid p-0">
      <div class="container mt-4">
        <?php include __DIR__ . '/../components/breadcrumb.php'; ?>
        <!-- Product Display Section -->
        <div class="row justify-content-center align-items-start">
          <div class="col-md-6">
            <div class="product-image-wrapper">
              <div class="product-image-inner">
                <?php if (isset($product['images'][0])): ?>
                <img class="rectangle" src="../../public/images/products/<?php echo htmlspecialchars($product['images'][0]); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" style="width:100%;height:auto;object-fit:cover;" />
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="product-main-info">
              <div class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></div>
              <p class="product-description">
                <?php echo htmlspecialchars($product['description']); ?>
              </p>
            </div>
            
            <div class="product-meta">
              <div class="colors-2">Màu Sắc</div>
              <div class="product-colors d-flex gap-2 mb-3">
                <?php foreach ($product['colors'] as $color): ?>
                <div class="color-7" style="background-color: <?php echo htmlspecialchars($color); ?>"></div>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="product-actions mb-3">
              <div class="button-comp-wrapper">
                <div class="button-comp"><div class="text-wrapper-10">Hướng Dẫn Chọn Size</div></div>
              </div>
              <button class="button"><div class="text-wrapper-11">Thêm Vào Giỏ</div></button>
            </div>

            <div class="size mb-3">
              <label for="sizeSelect" class="form-label">Kích Thước</label>
              <select class="form-select" id="sizeSelect" name="size">
                <option selected>Free size</option>
              </select>
            </div>

            <div class="product-extra-actions mb-3">
              <div class="button-comp-2">
              <span class="material-symbols-rounded">local_shipping</span>
                <div class="text-wrapper-10">Đổi Trả Dễ Dàng</div>
              </div>
              <div class="dislike-like">
              <span class="material-symbols-rounded">favorite</span>
                <div class="text-wrapper-10">Thêm Vào Yêu Thích</div>
              </div>
            </div>

            <div class="product-features">
              <div class="silk-wrapper"><div class="silk"><?php echo htmlspecialchars($product['material']); ?></div></div>
              <p class="this-material-is-our">
                <?php echo htmlspecialchars($product['material_description'] ?? 'Chất liệu da cao cấp, bền bỉ và thời trang.'); ?>
              </p>
              <div class="features-list">
                <?php if (isset($product['features']) && is_array($product['features'])): ?>
                  <?php foreach ($product['features'] as $feature): ?>
                  <div class="chips-component">
                    <div class="lable-wrapper"><div class="lable"><?php echo htmlspecialchars($feature); ?></div></div>
                  </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <!-- Sản Phẩm Tương Tự Section -->
        <div class="related-products-section">Sản Phẩm Tương Tự</div>
        <div class="row">
          <?php
          $related_products = $productController->getRelatedProducts($product['product_id']);
          foreach ($related_products as $related_product):
            $related_image = isset($related_product['images'][0]) ? $related_product['images'][0] : 'default.jpg';
          ?>
          <div class="col-md-4">
            <a href="productDetails.php?id=<?php echo htmlspecialchars($related_product['product_id']); ?>" class="text-decoration-none text-dark">
              <div class="product-card card h-100">
                <img src="../../public/images/products/<?php echo htmlspecialchars($related_image); ?>" class="card-img-top product-img" alt="<?php echo htmlspecialchars($related_product['product_name']); ?>">
                <div class="card-body">
                  <div class="product-name mb-1"><?php echo htmlspecialchars($related_product['product_name']); ?></div>
                  <div class="product-description mb-2"><?php echo htmlspecialchars($related_product['description']); ?></div>
                  <div class="colors d-flex gap-2 mb-2">
                    <?php foreach ($related_product['colors'] as $color): ?>
                    <div class="color rounded-circle" style="background-color: <?php echo htmlspecialchars($color); ?>"></div>
                    <?php endforeach; ?>
                  </div>
                  <div class="element-wrapper">
                    <div class="element"><?php echo number_format($related_product['price'], 3); ?> VNĐ</div>
                  </div>
                </div>
              </div>
            </a>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      
      <?php include __DIR__ . '/../components/footer.php'; ?>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  </body>
</html> 