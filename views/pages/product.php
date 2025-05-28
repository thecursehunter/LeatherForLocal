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
    <?php include __DIR__ . '/../components/header.php'; ?>
    <div class="container-fluid p-0">
        <div class="container mt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tất Cả Sản Phẩm</li>
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
                                        Sắp xếp theo
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
                                        Kích Thước
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
                                        Màu
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
                                        Bộ Sưu Tập
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
                                $image = isset($product['images'][0]) ? $product['images'][0] : 'default.jpg';
                                echo "<div class='col-md-6 mb-4'>";
                                echo "<a href='productDetails.php?id=" . htmlspecialchars($product['id']) . "' class='text-decoration-none text-dark'>";
                                echo "<div class='card h-100 position-relative'>";
                                echo "<img src='../../public/images/products/" . htmlspecialchars($image) . "' class='card-img-top product-img' alt='" . htmlspecialchars($product['name']) . "'>";
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
                                echo "<div class='product-price-text'>" . number_format($product['price'], 3) . " VNĐ" . "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</a>";
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

        <?php include __DIR__ . '/../components/footer.php'; ?>
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
                                        <div class="card h-100 position-relative">
                                            <img src='../../public/images/products/${product.image}' class='card-img-top product-img' alt='${product.name}'>
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