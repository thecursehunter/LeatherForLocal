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
<body>
    <div class="container-fluid p-0">
        <header class="HEADER">
            <div class="overlap-group bg-primary">
                <div class="h-green-line"><div class="text"></div></div>
                <p class="shipping-banner-text text-white text-center py-2 mb-0">Enjoy Free Shipping On All Orders</p>
            </div>
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
                <div class="container">
                    <a class="navbar-brand" href="#">
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
                            <div class="header-search-icon"></div>
                            <span class="material-symbols-rounded">account_circle</span>
                            <div class="header-favorite-icon"></div>
                            <span class="material-symbols-rounded">shopping_cart</span>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <div class="container mt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shop All</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Filter Sidebar -->
                <div class="col-lg-3">
                    <div class="filter">
                        <h3 class="filters mb-3">Filters</h3>
                        <div class="accordion" id="filterAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#sortBy">
                                        Sort By
                                    </button>
                                </h2>
                                <div id="sortBy" class="accordion-collapse collapse show" data-bs-parent="#filterAccordion">
                                    <div class="accordion-body">
                                        <!-- Sort options here -->
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#size">
                                        Size
                                    </button>
                                </h2>
                                <div id="size" class="accordion-collapse collapse" data-bs-parent="#filterAccordion">
                                    <div class="accordion-body">
                                        <!-- Size options here -->
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#color">
                                        Color
                                    </button>
                                </h2>
                                <div id="color" class="accordion-collapse collapse" data-bs-parent="#filterAccordion">
                                    <div class="accordion-body">
                                        <!-- Color options here -->
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collection">
                                        Collection
                                    </button>
                                </h2>
                                <div id="collection" class="accordion-collapse collapse" data-bs-parent="#filterAccordion">
                                    <div class="accordion-body">
                                        <!-- Collection options here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="col-lg-9">
                    <div class="row">
                        <?php
                        $row_counter = 0;
                        $product_rows = ['product-row-1', 'product-row-2', 'product-row-3'];
                        $products_per_row = 2;
                        $total_products = count($products);
                        $current_product_index = 0;

                        foreach ($product_rows as $row_section) {
                            if ($current_product_index >= $total_products) break;
                            echo "<div class='$row_section row mb-4' id='product-list-$row_section'>";
                            for ($i = 0; $i < $products_per_row && $current_product_index < $total_products; $i++) {
                                $product = $products[$current_product_index];
                                echo "<div class='col-md-6 mb-4'>";
                                echo "<div class='card h-100'>";
                                if (isset($product['is_new']) && $product['is_new']) {
                                    echo "<div class='product-badge'>";
                                    echo "<span class='badge bg-white text-dark'>New</span>";
                                    echo "</div>";
                                }
                                echo "<div class='card-body'>";
                                echo "<div class='product-info-container'>";
                                echo "<div class='product-details'>";
                                echo "<h5 class='product-name'>" . htmlspecialchars($product['name']) . "</h5>";
                                echo "<p class='product-description'>" . htmlspecialchars($product['description']) . "</p>";
                                echo "<div class='colors d-flex gap-2'>";
                                foreach ($product['colors'] as $color) {
                                    echo "<div class='color rounded-circle' style='background-color: " . htmlspecialchars($color) . ";'></div>";
                                }
                                echo "</div>";
                                echo "</div>";
                                echo "<div class='product-price'>";
                                echo "<div class='product-price-text'>$" . number_format($product['price'], 2) . "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                $current_product_index++;
                            }
                            echo "</div>";
                        }
                        ?>
                    </div>

                    <div class="text-center my-4">
                        <button id="load-more" class="btn btn-outline-primary">Load More</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer bg-dark text-white mt-5">
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-4">
                        <h5 class="footer-section-title">Về LeatherForLocal</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white text-decoration-none">Bộ Sưu Tập</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Phát Triển Bền Vững</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Chính Sách Bảo Mật</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Hệ Thống Hỗ Trợ</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Điều Khoản & Điều Kiện</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Bản Quyền</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5 class="footer-section-title">Trợ Giúp & Hỗ Trợ</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white text-decoration-none">Đơn Hàng & Vận Chuyển</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Đổi Trả & Hoàn Tiền</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Câu Hỏi Thường Gặp</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Liên Hệ Chúng Tôi</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5 class="footer-join-title">Tham Gia</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white text-decoration-none">Câu Lạc Bộ LeatherForLocal</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Tuyển Dụng</a></li>
                            <li><a href="#" class="text-white text-decoration-none">Ghép Thăm Chúng Tôi</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h5 class="mb-3">Tham Gia Câu Lạc Bộ, Nhận Ngay 15% Cho Ngày Sinh Nhật</h5>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Nhập Địa Chỉ Email Của Bạn">
                            <button class="btn btn-primary" type="button">Đăng Ký</button>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="termsCheck">
                            <label class="form-check-label" for="termsCheck">
                                Bằng việc gửi email của bạn, bạn đồng ý nhận email quảng cáo từ LeatherForLocal.
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid bg-dark py-3">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <p class="mb-0">&copy; 2025 LeatherForLocal. Bảo Lưu Mọi Quyền.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="footer-social-media d-flex justify-content-center gap-3">
                            <img class="img" src="../../img/social-media-3.svg" />
                            <img class="img" src="../../img/social-media-2.svg" />
                            <img class="img" src="../../img/social-media.svg" />
                            <img class="img" src="../../img/social-media-4.svg" />
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        $(document).ready(function() {
            let offset = <?php echo $total_products; ?>;

            $('#load-more').click(function() {
                $.ajax({
                    url: '../../src/controllers/ProductController.php',
                    method: 'POST',
                    data: { action: 'loadMore', offset: offset },
                    dataType: 'json',
                    success: function(response) {
                        if (response.products.length > 0) {
                            let rowIndex = Math.floor(offset / 2);
                            let rowClass = `product-row-${rowIndex + 1}`;
                            let $row = $(`#product-list-${rowClass}`);
                            
                            if ($row.length === 0) {
                                $row = $(`<div class="${rowClass} row mb-4" id="product-list-${rowClass}"></div>`);
                                $('.row').last().after($row);
                            }

                            response.products.forEach(function(product, index) {
                                let productHtml = `
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100">
                                            ${product.is_new ? `
                                                <div class="product-badge">
                                                    <span class="badge bg-white text-dark">New</span>
                                                </div>
                                            ` : ''}
                                            <div class="card-body">
                                                <div class="product-info-container">
                                                    <div class="product-details">
                                                        <h5 class="product-name">${product.name}</h5>
                                                        <p class="product-description">${product.description}</p>
                                                        <div class="colors d-flex gap-2">
                                                            ${product.colors.map(color => `
                                                                <div class="color rounded-circle" style="background-color: ${color};"></div>
                                                            `).join('')}
                                                        </div>
                                                    </div>
                                                    <div class="product-price">
                                                        <div class="product-price-text">$${product.price}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                $row.append(productHtml);
                            });

                            offset += response.products.length;
                            if (response.products.length < 2) {
                                $('#load-more').hide();
                            }
                        } else {
                            $('#load-more').hide();
                        }
                    },
                    error: function() {
                        alert('Could not load more products. Please try again later.');
                    }
                });
            });
        });
    </script>
</body>
</html>