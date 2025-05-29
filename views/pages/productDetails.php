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
    ['label' => $product['category'], 'url' => null],
    ['label' => $product['name'], 'url' => null]
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
    <div class="container py-5 d-flex flex-column align-items-center justify-content-center">
      <div class="w-100" style="max-width: 1200px;">
        <?php include __DIR__ . '/../components/breadcrumb.php'; ?>
        <!-- Product Display Section -->
        <div class="row justify-content-center align-items-start">
          <div class="col-md-6">
            <div class="frame-13">
              <div class="frame-14">
                <?php foreach ($product['images'] as $image): ?>
                <img class="rectangle" src="../../public/images/products/<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                <?php endforeach; ?>
              </div>
              <div class="scroll">
                <img class="arrow-drop-down" src="../../public/images/icons/arrow-drop-down-2.svg" />
                <img class="arrow-drop-up" src="../../public/images/icons/arrow-drop-up.svg" />
                <img class="rectangle-3" src="../../public/images/icons/scroll-thumb.svg" />
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="frame-15">
              <div class="wrap-top"><?php echo htmlspecialchars($product['name']); ?></div>
              <p class="versatile-and">
                <?php echo htmlspecialchars($product['description']); ?>
              </p>
            </div>
            
            <div class="frame-16">
              <div class="colors-2">Colors</div>
              <div class="frame-17">
                <?php foreach ($product['colors'] as $color): ?>
                <div class="color-7" style="background-color: <?php echo htmlspecialchars($color); ?>"></div>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="frame-20">
              <div class="button-comp-wrapper">
                <div class="button-comp"><div class="text-wrapper-10">Size Guide</div></div>
              </div>
              <button class="button"><div class="text-wrapper-11">Add To Cart</div></button>
            </div>

            <div class="size">
              <div class="frame-21">
                <div class="sort-text"><div class="text-wrapper-12">Size</div></div>
                <img class="img" src="../../public/images/icons/arrow-drop-down.svg" />
              </div>
            </div>

            <div class="frame-22">
              <div class="button-comp-2">
                <img class="img" src="../../public/images/icons/local-shipping.svg" />
                <div class="text-wrapper-10">Easy Return</div>
              </div>
              <div class="dislike-like">
                <img class="vector" src="../../public/images/icons/vector.svg" />
                <div class="text-wrapper-10">Add To Wish List</div>
              </div>
            </div>

            <div class="product-description">
              <div class="silk-wrapper"><div class="silk"><?php echo htmlspecialchars($product['material']); ?></div></div>
              <p class="this-material-is-our">
                <?php echo htmlspecialchars($product['material_description']); ?>
              </p>
              <div class="frame-23">
                <?php foreach ($product['features'] as $feature): ?>
                <div class="chips-component">
                  <div class="lable-wrapper"><div class="lable"><?php echo htmlspecialchars($feature); ?></div></div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>

        <!-- You May Also Like Section -->
        <div class="you-may-also-like">You May Also Like</div>
        <div class="row">
          <?php
          $related_products = $productController->getRelatedProducts($product_id);
          foreach ($related_products as $related_product):
          ?>
          <div class="col-md-4">
            <div class="product-card">
              <div class="frame-5">
                <div class="frame-6">
                  <div class="product-name"><?php echo htmlspecialchars($related_product['name']); ?></div>
                  <div class="product-description"><?php echo htmlspecialchars($related_product['description']); ?></div>
                  <div class="colors">
                    <?php foreach ($related_product['colors'] as $color): ?>
                    <div class="color" style="background-color: <?php echo htmlspecialchars($color); ?>"></div>
                    <?php endforeach; ?>
                  </div>
                </div>
                <div class="element-wrapper">
                  <div class="element"><?php echo number_format($related_product['price'], 3); ?> VNĐ</div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <?php include __DIR__ . '/../components/footer.php'; ?>
      </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  </body>
</html> 