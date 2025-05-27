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
            <a class="navbar-brand" href="/views/pages/product.php">
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
                    <li class="nav-item"><a class="nav-link" href="#">Bộ Sưu Tập</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Sản Phẩm Mới</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Leatherweek</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Về chúng tôi</a></li>
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
</header> 