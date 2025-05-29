<?php
session_start();
require_once __DIR__ . '/../../src/controllers/ProductController.php';
$productController = new ProductController();
$products = $productController->getProducts();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../public/css/global.css" />
    <link rel="stylesheet" href="../../public/css/styleguide.css" />
    <link rel="stylesheet" href="../../public/css/style.css" />
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
    <div class="desktop-landing">
      <div class="div">
        <?php include __DIR__ . '/../components/header.php'; ?>
        <div class="hero position-relative d-flex align-items-center text-start" style="background-image: url('path-to-hero-image.jpg'); background-size: cover; background-position: center; min-height: 70vh;">
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <h1 class="elegance-in display-3 fw-bold text-dark mb-4">Elegance In Simplicity, Earth's Harmony</h1>
                <button class="btn btn-outline-dark button-comp-2 px-4 py-2">New In</button>
              </div>
            </div>
          </div>
        </div>
        <div class="best-seller-cards container my-5">
          <div class="row">
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="display-4 fw-bold text-start">Best Sellers</h2>
                <button class="btn btn-link text-decoration-none text-dark">View All</button>
              </div>
            </div>
            <div class="col-12">
              <div class="row row-cols-1 row-cols-md-3 g-4" id="productList">
                <?php
                // Render up to 3 product cards
                for ($i = 0; $i < 3 && $i < count($products); $i++):
                  $product = $products[$i];
                  $product_name = htmlspecialchars($product['name']);
                  $product_description = htmlspecialchars($product['description']);
                  $product_price = number_format($product['price'], 0);
                  $product_colors = isset($product['colors']) ? $product['colors'] : [];
                ?>
                <div class="col product-item" data-name="<?php echo strtolower($product_name); ?>" data-description="<?php echo strtolower($product_description); ?>">
                  <div class="card h-100">
                    <img src="path-to-product-image-<?php echo $i + 1; ?>.jpg" class="card-img-top" alt="<?php echo $product_name; ?>" style="height: 300px; object-fit: cover; background-color: #f0f0f0;">
                    <div class="card-body d-flex flex-column justify-content-between">
                      <div>
                        <span class="position-absolute top-0 end-0 p-2">
                          <span class="material-symbols-rounded">favorite</span>
                        </span>
                        <h5 class="card-title"><?php echo $product_name; ?></h5>
                        <p class="card-text text-muted mb-2"><?php echo $product_description; ?></p>
                        <div class="colors d-flex gap-2 mb-2">
                          <?php
                          for ($j = 0; $j < min(4, count($product_colors)); $j++) {
                            $color_style = isset($product_colors[$j]) && $product_colors[$j] !== '' ? 'style="background-color: '.htmlspecialchars($product_colors[$j]).';"' : '';
                            echo "<div class=\"color rounded-circle\" $color_style></div>";
                          }
                          ?>
                        </div>
                      </div>
                      <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">$<?php echo $product_price; ?></span>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endfor; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="collection-pics container my-5">
          <div class="row">
            <div class="col-12">
              <div class="mb-4">
                <h2 class="display-4 fw-bold text-start">Collection</h2>
              </div>
            </div>
            <div class="col-12">
              <div class="row">
                <div class="col-md-6 collection-pic-left mb-4 mb-md-0">
                  <div class="pic-3 position-relative mb-4" data-name="boluses">
                    <div class="image-placeholder" style="height: 300px; background-color: #f0f0f0;"></div>
                    <button class="btn custom-collection-btn position-absolute bottom-0 start-50 translate-middle-x mb-3">Boluses</button>
                  </div>
                  <div class="pic-4 position-relative" data-name="dresses">
                    <div class="image-placeholder" style="height: 600px; background-color: #f0f0f0;"></div>
                    <button class="btn custom-collection-btn position-absolute bottom-0 start-50 translate-middle-x mb-3">Dresses</button>
                  </div>
                </div>
                <div class="col-md-6 collection-pic-right">
                  <div class="pic position-relative mb-4" data-name="pants">
                    <div class="image-placeholder" style="height: 600px; background-color: #f0f0f0;"></div>
                    <button class="btn custom-collection-btn position-absolute bottom-0 start-50 translate-middle-x mb-3">Pants</button>
                  </div>
                  <div class="pic-2 position-relative" data-name="outwear">
                    <div class="image-placeholder" style="height: 300px; background-color: #f0f0f0;"></div>
                    <button class="btn custom-collection-btn position-absolute bottom-0 start-50 translate-middle-x mb-3">Outwear</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="leatherweek-frame container my-5">
          <div class="row">
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="display-4 fw-bold text-start">LeatherWeek</h2>
              </div>
            </div>
            <div class="col-12">
              <div class="row row-cols-1 row-cols-md-5 g-4">
                <?php
                $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];
                for ($i = 0; $i < 5; $i++):
                ?>
                <div class="col" data-name="<?php echo strtolower($days[$i]); ?>">
                  <div class="position-relative">
                    <div class="image-placeholder" style="height: 300px; background-color: #f0f0f0;"></div>
                    <span class="position-absolute top-0 end-0 p-2">
                      <span class="material-symbols-rounded">favorite</span>
                    </span>
                    <div class="text-center mt-2">
                      <p class="mb-0"><?php echo $days[$i]; ?></p>
                    </div>
                  </div>
                </div>
                <?php endfor; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="sustainability position-relative" data-description="stylish sustainability in clothing promotes eco-friendly choices for a greater future" style="background-image: url('path-to-sustainability-image.jpg'); background-size: cover; background-position: center; min-height: 70vh;">
          <div class="container h-100">
            <div class="row h-100">
              <div class="col-12 h-100 d-flex justify-content-end align-items-end pb-3 pe-3">
                <div class="text-end">
                  <p class="lead text-muted mb-2">
                    Stylish Sustainability In Clothing Promotes Eco-Friendly 
                    Choices For A Greater Future
                  </p>
                  <button class="btn btn-outline-dark px-3 py-1">Sustainability</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="follow-us-container container my-5">
          <div class="row">
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="display-4 fw-bold text-start">Follow Us @leatherforlocal</h2>
              </div>
            </div>
            <div class="col-md-6 frame-6">
              <div class="image-placeholder" style="height: 424px; background-color: #f0f0f0;"></div>
            </div>
            <div class="col-md-6 frame-7">
              <div class="row frame-8">
                <div class="col-6 button-comp-wrapper position-relative">
                  <div class="image-placeholder" style="height: 200px; background-color: #f0f0f0;"></div>
                  <button class="btn btn-primary button-comp-4 position-absolute bottom-0 end-0 mb-3 me-3" data-name="shop now">
                    <span class="add-to-cart-3">Shop Now</span>
                  </button>
                </div>
                <div class="col-6 frame-9 position-relative">
                  <div class="image-placeholder" style="height: 200px; background-color: #f0f0f0;"></div>
                  <button class="btn btn-primary button-comp-4 position-absolute bottom-0 end-0 mb-3 me-3" data-name="shop now">
                    <span class="add-to-cart-3">Shop Now</span>
                  </button>
                </div>
              </div>
              <div class="row frame-10 mt-4">
                <div class="col-6 frame-11 position-relative">
                  <div class="image-placeholder" style="height: 200px; background-color: #f0f0f0;"></div>
                  <button class="btn btn-primary button-comp-4 position-absolute bottom-0 end-0 mb-3 me-3" data-name="shop now">
                    <span class="add-to-cart-3">Shop Now</span>
                  </button>
                </div>
                <div class="col-6 frame-12 position-relative">
                  <div class="image-placeholder" style="height: 200px; background-color: #f0f0f0;"></div>
                  <button class="btn btn-primary button-comp-4 position-absolute bottom-0 end-0 mb-3 me-3" data-name="shop now">
                    <span class="add-to-cart-3">Shop Now</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php include __DIR__ . '/../components/footer.php'; ?>
      </div>
    </div>
    <script>
      const navbarFunctions = document.querySelector('.navbar-functions');
      const searchButton = document.getElementById('searchButton');
      const searchBox = document.getElementById('searchBox');
      const searchInput = document.getElementById('searchInput');
      const searchResults = document.getElementById('searchResults');
      const clearButton = document.getElementById('clearButton');
      const productList = document.getElementById('productList');

      // Lưu trạng thái ban đầu của các phần tử
      const searchableItems = document.querySelectorAll('[data-name], [data-description]');
      const initialDisplayStates = new Map();
      searchableItems.forEach(item => {
        const computedStyle = window.getComputedStyle(item).display;
        initialDisplayStates.set(item, computedStyle);
      });

      // Hiển thị ô tìm kiếm khi nhấp vào button tìm kiếm hoặc hover
      searchButton.addEventListener('click', (e) => {
        e.stopPropagation();
        searchBox.style.display = searchBox.style.display === 'block' ? 'none' : 'block';
      });

      navbarFunctions.addEventListener('mouseenter', () => {
        searchBox.style.display = 'block';
      });

      // Giữ ô tìm kiếm hiển thị khi tương tác với ô tìm kiếm
      searchBox.addEventListener('mouseenter', () => {
        searchBox.style.display = 'block';
      });

      // Ngăn chặn sự kiện click trên navbar-functions và search-box lan truyền lên document
      navbarFunctions.addEventListener('click', (e) => {
        e.stopPropagation();
      });

      searchBox.addEventListener('click', (e) => {
        e.stopPropagation();
      });

      // Đóng ô tìm kiếm khi nhấp ra ngoài
      document.addEventListener('click', (e) => {
        searchBox.style.display = 'none';
        searchResults.style.display = 'none';
        // Nếu ô tìm kiếm rỗng (sau khi xóa), khôi phục trạng thái ban đầu
        if (searchInput.value === '') {
          searchableItems.forEach(item => {
            const initialDisplay = initialDisplayStates.get(item);
            item.style.display = initialDisplay;
          });
        }
      });

      // Hàm tìm kiếm chung
      function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const results = new Map(); // Sử dụng Map để tránh trùng lặp

        // Hiển thị hoặc ẩn nút xóa dựa trên nội dung ô tìm kiếm
        clearButton.style.display = searchTerm ? 'block' : 'none';

        searchableItems.forEach(item => {
          const name = item.getAttribute('data-name') || '';
          const description = item.getAttribute('data-description') || '';
          if (searchTerm !== '' && (name.includes(searchTerm) || description.includes(searchTerm))) {
            results.set(item, { name, description });
            item.style.display = item.classList.contains('product-item') ? 'block' : 'flex';
          } else {
            item.style.display = 'none';
          }
        });

        // Hiển thị kết quả tìm kiếm
        searchResults.innerHTML = '';
        if (results.size > 0) {
          results.forEach((data, item) => {
            const resultItem = document.createElement('div');
            resultItem.classList.add('result-item');
            const displayText = data.name || data.description || 'Unknown';
            resultItem.innerHTML = `<strong>${displayText}</strong>${data.description && data.name ? '<br><span class="text-muted">' + data.description + '</span>' : ''}`;
            resultItem.addEventListener('click', (e) => {
              e.stopPropagation(); // Ngăn đóng ô tìm kiếm khi nhấp vào kết quả
              searchInput.value = data.name || data.description;
              clearButton.style.display = 'block'; // Hiển thị nút xóa
              searchResults.style.display = 'none';
              searchableItems.forEach(i => {
                const iName = i.getAttribute('data-name') || '';
                const iDesc = i.getAttribute('data-description') || '';
                if (iName === data.name || iDesc === data.description) {
                  i.style.display = i.classList.contains('product-item') ? 'block' : 'flex';
                } else {
                  i.style.display = 'none';
                }
              });
            });
            searchResults.appendChild(resultItem);
          });
          searchResults.style.display = 'block';
        } else {
          searchResults.style.display = 'none';
        }
      }

      // Chức năng tìm kiếm khi nhập từ khóa
      searchInput.addEventListener('input', () => {
        performSearch();
      });

      // Chức năng tìm kiếm khi nhấn Enter
      searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
          e.preventDefault(); // Ngăn hành vi mặc định của Enter
          performSearch(); // Gọi lại hàm tìm kiếm
        }
      });

      // Xóa từ khóa khi nhấn nút xóa
      clearButton.addEventListener('click', (e) => {
        e.stopPropagation(); // Ngăn đóng ô tìm kiếm khi nhấp vào nút xóa
        searchInput.value = '';
        clearButton.style.display = 'none';
        searchResults.style.display = 'none';
        // Khôi phục trạng thái ban đầu
        searchableItems.forEach(item => {
          const initialDisplay = initialDisplayStates.get(item);
          item.style.display = initialDisplay;
        });
      });
    </script>
  </body>
</html>