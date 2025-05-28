<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet"> 
    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../public/css/global.css" />
    <link rel="stylesheet" href="../../public/css/styleguide.css" />
    <link rel="stylesheet" href="../../public/css/style.css" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<header class="HEADER">
    <div class="overlap-group bg-primary">
        <div class="h-green-line"><div class="text"></div></div>
        <p class="shipping-banner-text text-white text-center py-2 mb-0">Enjoy Free Shipping On All Orders</p>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container">
            <a class="navbar-brand" href="../../views/pages/index.php">
                <div class="logo">
                    <div class="title">
                        <span class="material-symbols-rounded logo-icon">store</span>
                        <div class="logo-title">LeatherForLocal</div>
                    </div>
                    <div class="logo-subtitle">Thời trang da cho nam giới</div>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item position-relative mega-parent" id="collectionNavItem">
        <a class="nav-link" href="#">Bộ Sưu Tập</a>
        <div class="mega-menu bg-white shadow" id="collectionMegaMenu">
            <div class="container py-4 d-flex">
                <div class="row w-100">
                    <div class="col-3">
                        <h6 class="fw-bold mb-3">Phân Loại</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-dark text-decoration-none">Áo Khoác Da</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Quần Da</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Giày Da</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Quần Ngắn Da</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Áo Sơ Mi Da</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Phụ Kiện Da</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Đồ Liền Da</a></li>
                        </ul>
                    </div>
                    <div class="col-3">
                        <h6 class="fw-bold mb-3">Nổi Bật</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-dark text-decoration-none">Sản Phẩm Mới</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Kích Cỡ Lớn</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Sản Phẩm Bán Chạy</a></li>
                        </ul>
                    </div>
                    <div class="col-3">
                        <h6 class="fw-bold mb-3">Nhiều Hơn</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-dark text-decoration-none">Phong Cách Street</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Biker</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Cổ Điển</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Trang Phục Lễ Hội</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Hàng Limited</a></li>
                        </ul>
                    </div>
                    <div class="col-3 d-flex flex-column align-items-center">
                        <img src="../../public/images/collection/leather-pants.jpg" alt="Blouses" style="width:100%;max-width:140px;object-fit:cover;">
                        <span class="mt-2">Quần Da</span>
                        <img src="../../public/images/collection/leather-jackets(+size).jpg" alt="Plus Size" class="mt-4" style="width:100%;max-width:140px;object-fit:cover;">
                        <span class="mt-2">Kích Cỡ Lớn</span>
                    </div>
                </div>
            </div>
        </div>
    </li>
                    <li class="nav-item position-relative mega-parent" id="newInNavItem">
        <a class="nav-link" href="#">Sản Phẩm Mới</a>
        <div class="mega-menu bg-white shadow" id="newInMegaMenu">
            <div class="container py-4 d-flex">
                <div class="row w-100">
                    <div class="col-4">
                        <h6 class="fw-bold mb-3">Hàng Mới</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-dark text-decoration-none">Túi Xách Mới Nhất</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Áo Khoác Mới Nhất</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Phụ Kiện Mới Nhất</a></li>
                        </ul>
                    </div>
                    <div class="col-4">
                        <h6 class="fw-bold mb-3">Xu Hướng</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-dark text-decoration-none">Sản Phẩm Bán Chạy</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Top Rated</a></li>
                        </ul>
                    </div>
                    <div class="col-4 d-flex flex-column align-items-center">
                        <img src="../../public/images/collection/leather-newin.jpg" alt="New In" style="width:100%;max-width:140px;object-fit:cover;">
                        <span class="mt-2">Sản Phẩm Mới</span>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <li class="nav-item position-relative mega-parent" id="leatherWeekNavItem">
        <a class="nav-link" href="#">LeatherWeek</a>
        <div class="mega-menu bg-white shadow" id="leatherWeekMegaMenu">
            <div class="container py-4 d-flex">
                <div class="row w-100">
                    <div class="col-6">
                        <h6 class="fw-bold mb-3">LeatherWeek Specials</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-dark text-decoration-none">Sunday</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Monday</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Tuesday</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Wednesday</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Thursday</a></li>
                        </ul>
                    </div>
                    <div class="col-6 d-flex flex-column align-items-center">
                        <img src="../../Diagrams/Landing/02.jpg" alt="LeatherWeek" style="width:100%;max-width:140px;object-fit:cover;">
                        <span class="mt-2">LeatherWeek</span>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <li class="nav-item position-relative mega-parent" id="aboutNavItem">
        <a class="nav-link" href="#">Về chúng tôi</a>
        <div class="mega-menu bg-white shadow" id="aboutMegaMenu">
            <div class="container py-4 d-flex">
                <div class="row w-100">
                    <div class="col-6">
                        <h6 class="fw-bold mb-3">About LeatherForLocal</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-dark text-decoration-none">Our Story</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Phát Triển Bền Vững</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Tuyển Dụng</a></li>
                            <li><a href="#" class="text-dark text-decoration-none">Liên Hệ Chúng Tôi</a></li>
                        </ul>
                    </div>
                    <div class="col-6 d-flex flex-column align-items-center">
                        <img src="../../Diagrams/Landing/022.jpg" alt="About" style="width:100%;max-width:140px;object-fit:cover;">
                        <span class="mt-2">About Us</span>
                    </div>
                </div>
            </div>
        </div>
    </li>
                </ul>
                <div class="navbar-functions d-flex gap-3">
                    <button class="search-button" id="searchButton">
                    <span class="material-symbols-rounded search-icon">search</span>
                    </button>
                    <span class="material-symbols-rounded">favorite</span>
                    <span class="material-symbols-rounded">shopping_cart</span>
                    <span class="material-symbols-rounded">account_circle</span>
                </div>
            </div>
        </div>
    </nav>
    <div class="search-box" id="searchBox">
            <div class="search-wrapper">
              <span class="material-symbols-rounded search-icon">search</span>
              <input type="text" class="form-control search-input" placeholder="Search products..." id="searchInput">
              <button class="clear-button" id="clearButton">
                <span class="material-symbols-rounded">close</span>
              </button>
            </div>
            <div class="search-results" id="searchResults"></div>
          </div>
    <script>
  const navbarFunctions = document.querySelector('.navbar-functions');
  const searchButton = document.getElementById('searchButton');
  const searchBox = document.getElementById('searchBox');
  const searchInput = document.getElementById('searchInput');
  const searchResults = document.getElementById('searchResults');
  const clearButton = document.getElementById('clearButton');

  let allProducts = [];

  // Fetch products once on page load
  fetch('../../src/api/products.php')
    .then(response => response.json())
    .then(data => { allProducts = data; });

  searchButton.addEventListener('click', (e) => {
    e.stopPropagation();
    searchBox.style.display = searchBox.style.display === 'block' ? 'none' : 'block';
  });

  navbarFunctions.addEventListener('mouseenter', () => {
    searchBox.style.display = 'block';
  });

  searchBox.addEventListener('mouseenter', () => {
    searchBox.style.display = 'block';
  });

  navbarFunctions.addEventListener('click', (e) => {
    e.stopPropagation();
  });

  searchBox.addEventListener('click', (e) => {
    e.stopPropagation();
  });

  document.addEventListener('click', (e) => {
    searchBox.style.display = 'none';
    searchResults.style.display = 'none';
  });

  function performSearch() {
    const searchTerm = searchInput.value.toLowerCase();
    clearButton.style.display = searchTerm ? 'block' : 'none';
    searchResults.innerHTML = '';

    if (!searchTerm) {
      searchResults.style.display = 'none';
      return;
    }

    const filtered = allProducts.filter(product =>
      (product.product_name && product.product_name.toLowerCase().includes(searchTerm)) ||
      (product.description && product.description.toLowerCase().includes(searchTerm))
    );

    if (filtered.length > 0) {
      filtered.forEach(product => {
        const resultItem = document.createElement('div');
        resultItem.classList.add('result-item');
        resultItem.innerHTML = `<strong>${product.product_name}</strong><br><span class="text-muted">${product.description}</span>`;
        resultItem.addEventListener('click', (e) => {
          e.stopPropagation();
          window.location.href = 'productDetails.php?id=' + product.product_id;
        });
        searchResults.appendChild(resultItem);
      });
      searchResults.style.display = 'block';
    } else {
      searchResults.style.display = 'none';
    }
  }

  searchInput.addEventListener('input', performSearch);

  searchInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      performSearch();
    }
  });

  clearButton.addEventListener('click', (e) => {
    e.stopPropagation();
    searchInput.value = '';
    clearButton.style.display = 'none';
    searchResults.style.display = 'none';
  });
  // Show/hide mega menu on hover
  const megaParent = document.getElementById('collectionNavItem');
const megaMenu = document.getElementById('collectionMegaMenu');
if (megaParent && megaMenu) {
  megaParent.addEventListener('mouseenter', () => {
    megaMenu.style.display = 'block';
  });
  megaParent.addEventListener('mouseleave', () => {
    megaMenu.style.display = 'none';
  });
}
function setupMegaMenu(parentId, menuId) {
    const parent = document.getElementById(parentId);
    const menu = document.getElementById(menuId);
    if (parent && menu) {
        parent.addEventListener('mouseenter', () => {
            menu.style.display = 'block';
        });
        parent.addEventListener('mouseleave', () => {
            menu.style.display = 'none';
        });
    }
}
setupMegaMenu('collectionNavItem', 'collectionMegaMenu');
setupMegaMenu('newInNavItem', 'newInMegaMenu');
setupMegaMenu('leatherWeekNavItem', 'leatherWeekMegaMenu');
setupMegaMenu('aboutNavItem', 'aboutMegaMenu');
</script>
</header> 