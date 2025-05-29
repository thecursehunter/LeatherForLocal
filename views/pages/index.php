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
        <div class="hero position-relative d-flex align-items-center text-start" id="heroSection" style="background-size: cover; background-position: center; min-height: 70vh; transition: background-image 0.7s cubic-bezier(0.4,0,0.2,1);">
            <!-- Overlay for better text readability -->
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.35); z-index: 1;"></div>
          <div class="container position-relative" style="z-index: 2;">
            <div class="row">
              <div class="col-md-6">
                <h1 class="Hero-Title display-3 fw-bold text-white mb-4">Đẳng Cấp Phái Mạnh - Chất Da Dẫn Lối</h1>
              </div>
            </div>
          </div>
        </div>
        <script>
          // Array of hero images (update filenames as needed)
          const heroImages = [
            '../../public/images/hero-section/hero-1.jpg',
            '../../public/images/hero-section/hero-2.jpg',
            '../../public/images/hero-section/hero-3.jpg'
          ];
          let currentHeroIndex = 0;
          const heroSection = document.getElementById('heroSection');
          // Set initial background
          heroSection.style.backgroundImage = `url('${heroImages[0]}')`;

          function showNextHeroImage() {
            currentHeroIndex = (currentHeroIndex + 1) % heroImages.length;
            heroSection.style.backgroundImage = `url('${heroImages[currentHeroIndex]}')`;
          }

          // Swipe support (right to left)
          let startX = null;
          heroSection.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
          });
          heroSection.addEventListener('touchend', function(e) {
            if (startX !== null) {
              let endX = e.changedTouches[0].clientX;
              if (startX - endX > 50) { // swipe left
                showNextHeroImage();
              }
              startX = null;
            }
          });

          // Auto slide every 5 seconds
          setInterval(showNextHeroImage, 5000);
        </script>
        <div class="best-seller-cards container my-5">
          <div class="row">
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="display-4 fw-bold text-start">Best Sellers</h2>
                <a href="product.php" class="btn btn-link text-decoration-none text-dark">View All</a>
              </div>
            </div>
            <div class="col-12">
              <div class="row row-cols-1 row-cols-md-3 g-4" id="productList">
                <?php
                // Render up to 3 product cards
                for ($i = 0; $i < 3 && $i < count($products); $i++):
                  $product = $products[$i];
                  $product_name = htmlspecialchars($product['product_name']);
                  $product_description = htmlspecialchars($product['description']);
                  $product_price = number_format($product['price'], 0, ',', '.');
                  $product_colors = isset($product['colors']) ? $product['colors'] : [];
                ?>
                <div class="col product-item" data-name="<?php echo strtolower($product_name); ?>" data-description="<?php echo strtolower($product_description); ?>">
  <a href="productDetails.php?id=<?php echo $product['product_id']; ?>" class="text-decoration-none text-dark">
    <div class="card h-100">
      <?php
        $product_images = isset($product['images']) ? $product['images'] : [];
        $product_img_src = count($product_images) > 0 && $product_images[0] !== '' 
          ? '../../public/images/products/' . htmlspecialchars($product_images[0]) 
          : '../../public/images/products/default.jpg';
      ?>
      <img src="<?php echo $product_img_src; ?>" class="card-img-top" alt="<?php echo $product_name; ?>" style="height: 300px; object-fit: cover; background-color: #f0f0f0;">
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
          <span class="text-muted"><?php echo $product_price,",000"; ?> VNĐ</span>
        </div>
      </div>
    </div>
  </a>
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
                  <div class="pic-3 position-relative mb-4" data-name="shirts">
                    <img src="../../public/images/collection/leather-shirts.jpg" alt="Leather Shirts" style="width:100%; height: 300px; object-fit: cover; display: block;">
                    <button class="btn custom-collection-btn position-absolute bottom-0 start-50 translate-middle-x mb-3">Shirts</button>
                  </div>
                  <div class="pic-4 position-relative" data-name="jackets">
                    <img src="../../public/images/collection/leather-jackets.jpg" alt="Leather Jackets" style="width:100%; height: 600px; object-fit: cover; display: block;">
                    <button class="btn custom-collection-btn position-absolute bottom-0 start-50 translate-middle-x mb-3">Jackets</button>
                  </div>
                </div>
                <div class="col-md-6 collection-pic-right">
                  <div class="pic position-relative mb-4" data-name="pants">
                    <img src="../../public/images/collection/leather-pants.jpg" alt="Leather Pants" style="width:100%; height: 600px; object-fit: cover; display: block;">
                    <button class="btn custom-collection-btn position-absolute bottom-0 start-50 translate-middle-x mb-3">Pants</button>
                  </div>
                  <div class="pic-2 position-relative" data-name="footwear">
                    <img src="../../public/images/collection/leather-footwear.jpg" alt="Leather Footwear" style="width:100%; height: 300px; object-fit: cover; display: block;">
                    <button class="btn custom-collection-btn position-absolute bottom-0 start-50 translate-middle-x mb-3">Footwear</button>
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
        $days = [
          'Sunday' => '../../public/images/leatherweek/week-sun.jpg',
          'Monday' => '../../public/images/leatherweek/week-mon.jpg',
          'Tuesday' => '../../public/images/leatherweek/week-tues.jpg',
          'Wednesday' => '../../public/images/leatherweek/week-wed.jpg',
          'Thursday' => '../../public/images/leatherweek/week-thurs.jpg'
        ];
        foreach ($days as $day => $imgPath):
        ?>
        <div class="col" data-name="<?php echo strtolower($day); ?>">
          <div class="position-relative">
            <img src="<?php echo $imgPath; ?>" alt="<?php echo $day; ?>" style="height: 300px; width: 100%; object-fit: cover; background-color: #f0f0f0;">
            <span class="position-absolute top-0 end-0 p-2">
              <span class="material-symbols-rounded">favorite</span>
            </span>
            <div class="text-center mt-2">
              <p class="mb-0"><?php echo $day; ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
        <div class="sustainability position-relative" style="min-height: 70vh;">
  <img 
    src="../../public/images/hero-section/sustainability.jpg" 
    alt="Sustainability" 
    style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: 1; border-radius: 12px;"
  >
  <div class="container h-100 position-relative" style="position: relative; z-index: 2;">
    <div class="row h-100">
      <div class="col-12 h-100 d-flex flex-column justify-content-end align-items-end">
        <div 
          class="mb-5" 
          style="
            width: 100%;
            display: flex;
            justify-content: flex-end;
          "
        >
          <div 
            style="
              background: rgba(255,255,255,0.25);
              border-radius: 12px;
              padding: 32px 36px 24px 36px;
              max-width: 850px;
              margin-right: 32px;
              margin-bottom: 16px;
              text-align: right;
            "
          >
            <p class="lead mb-3 fw-bold" style="color: #fff; text-shadow: 0 2px 8px rgba(0,0,0,0.5); font-size: 1.5rem; line-height: 2.2rem; word-break: break-word;">
              Thời trang bền vững - phong cách đích thực cho những<br>
              lựa chọn xanh vì một tương lai tốt đẹp hơn
            </p>
            <button class="btn btn-outline-light px-4 py-2">Phát Triển Bền Vững</button>
          </div>
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
      <img src="../../public/images/follow-us/fu_5.jpg" alt="Follow Us 1" class="image-placeholder" style="height: 424px; width: 100%; object-fit: cover; background-color: #f0f0f0; border-radius: 8px;">
    </div>
    <div class="col-md-6 frame-7">
      <div class="row frame-8">
        <div class="col-6 button-comp-wrapper position-relative">
          <img src="../../public/images/follow-us/fu_2.jpg" alt="Follow Us 2" class="image-placeholder" style="height: 200px; width: 100%; object-fit: cover; background-color: #f0f0f0; border-radius: 8px;">
        </div>
        <div class="col-6 frame-9 position-relative">
          <img src="../../public/images/follow-us/fu_3.jpg" alt="Follow Us 3" class="image-placeholder" style="height: 200px; width: 100%; object-fit: cover; background-color: #f0f0f0; border-radius: 8px;">
        </div>
      </div>
      <div class="row frame-10 mt-4">
        <div class="col-6 frame-11 position-relative">
          <img src="../../public/images/follow-us/fu_4.jpg" alt="Follow Us 4" class="image-placeholder" style="height: 200px; width: 100%; object-fit: cover; background-color: #f0f0f0; border-radius: 8px;">
        </div>
        <div class="col-6 frame-12 position-relative">
          <img src="../../public/images/follow-us/fu_1.jpg" alt="Follow Us 5" class="image-placeholder" style="height: 200px; width: 100%; object-fit: cover; background-color: #f0f0f0; border-radius: 8px;">
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