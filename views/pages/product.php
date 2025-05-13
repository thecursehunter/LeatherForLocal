<?php
require_once '../../src/controllers/ProductController.php';
$productController = new ProductController();
$products = $productController->getProducts();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/public/css/global.css" />
    <link rel="stylesheet" href="/public/css/styleguide.css" />
    <link rel="stylesheet" href="/public/css/style.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>
    <div class="desktop-shop-all">
      <div class="div">
        <header class="HEADER">
          <!-- ...existing header code... -->
        </header>
        <div class="filter">
          <!-- ...existing filter code... -->
        </div>
        <div id="product-list">
          <?php foreach ($products as $product): ?>
          <div class="product-card">
            <div class="frame-10">
              <div class="frame-11">
                <div class="tailored-stretch"><?php echo $product['name']; ?></div>
                <div class="turn-it-up-pants"><?php echo $product['description']; ?></div>
                <div class="colors">
                  <?php foreach ($product['colors'] as $color): ?>
                  <div class="color" style="background-color: <?php echo $color; ?>;"></div>
                  <?php endforeach; ?>
                </div>
              </div>
              <div class="frame-12">
                <div class="text-wrapper-10">$<?php echo $product['price']; ?></div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <button id="load-more" class="button-comp">
          <div class="add-to-cart">Load More</div>
        </button>
        <footer class="footer">
          <!-- ...existing footer code... -->
        </footer>
      </div>
    </div>
    <script>
      $(document).ready(function() {
        $('#load-more').click(function() {
          $.ajax({
            url: 'src/controllers/ProductController.php',
            method: 'POST',
            data: { action: 'loadMore' },
            dataType: 'json',
            success: function(response) {
              response.products.forEach(function(product) {
                $('#product-list').append(`
                  <div class="product-card">
                    <div class="frame-10">
                      <div class="frame-11">
                        <div class="tailored-stretch">${product.name}</div>
                        <div class="turn-it-up-pants">${product.description}</div>
                        <div class="colors">
                          ${product.colors.map(color => `<div class="color" style="background-color: ${color};"></div>`).join('')}
                        </div>
                      </div>
                      <div class="frame-12">
                        <div class="text-wrapper-10">$${product.price}</div>
                      </div>
                    </div>
                  </div>
                `);
              });
            }
          });
        });
      });
    </script>
  </body>
</html>