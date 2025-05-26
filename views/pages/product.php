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
    <link rel="stylesheet" href="../../public/css/global.css" />
    <link rel="stylesheet" href="../../public/css/styleguide.css" />
    <link rel="stylesheet" href="../../public/css/style.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="desktop-shop-all">
        <div class="div">
            <header class="HEADER">
                <div class="overlap-group">
                    <div class="h-green-line"><div class="text"></div></div>
                    <p class="text-wrapper">Enjoy Free Shipping On All Orders</p>
                </div>
                <div class="frame">
                    <div class="header-footer-texts"><div class="text-wrapper-2">Collection</div></div>
                    <div class="header-footer-texts"><div class="collection">New In</div></div>
                    <div class="header-footer-texts"><div class="collection-2">Modiweek</div></div>
                    <div class="header-footer-texts"><div class="collection-3">Plus Size</div></div>
                    <div class="collection-wrapper"><div class="collection-4">Sustainability</div></div>
                </div>
                <div class="frame-2">
                    <div class="header-search-icon"></div>
                    <div class="header-profile-icon"><img class="img" src="../../img/person-4.svg" /></div>
                    <div class="header-favorite-icon"></div>
                    <div class="header-bag-icon"><img class="img" src="../../img/shopping-bag.svg" /></div>
                </div>
                <div class="logo">
                    <div class="frame-3">
                        <div class="text-wrapper-3">LeatherForLocal</div>
                        <img class="subtract" src="../../img/subtract.svg" />
                    </div>
                    <div class="text-wrapper-4">women clothing</div>
                </div>
            </header>
            <div class="filter">
                <div class="filters">Filters</div>
                <div class="div-2">
                    <div class="text-wrapper-5">Sort By</div>
                    <img class="vector" src="../../img/vector-3.svg" />
                </div>
                <div class="div-2">
                    <div class="text-wrapper-5">Size</div>
                    <img class="vector" src="../../img/vector-2.svg" />
                </div>
                <div class="div-2">
                    <div class="text-wrapper-5">Color</div>
                    <img class="vector" src="../../img/image.svg" />
                </div>
                <div class="div-2">
                    <div class="text-wrapper-5">Collection</div>
                    <img class="vector" src="../../img/vector.svg" />
                </div>
                <div class="component">
                    <div class="fabric">Fabric</div>
                    <img class="vector-2" src="../../img/vector-4.svg" />
                </div>
            </div>
            <div class="breadcrumbb">
                <div class="component-2"><div class="text-2">Home</div></div>
                <div class="component-3"><div class="text-wrapper-6">/</div></div>
                <div class="component-2"><div class="text-3">Shop All</div></div>
            </div>

            <!-- Hiển thị sản phẩm từ cơ sở dữ liệu -->
            <?php
            $frame_counter = 0; // Đếm để phân chia sản phẩm vào các frame
            $frames = ['frame-9', 'frame-13', 'frame-14'];
            $products_per_frame = 2; // Mỗi frame chứa 2 sản phẩm
            $total_products = count($products);
            $current_product_index = 0;

            foreach ($frames as $frame) {
                if ($current_product_index >= $total_products) break; // Dừng nếu không còn sản phẩm
                echo "<div class='$frame' id='product-list-$frame'>";
                for ($i = 0; $i < $products_per_frame && $current_product_index < $total_products; $i++) {
                    $product = $products[$current_product_index];
                    $card_class = $i % 2 == 0 ? "product-card" : "product-card-2";
                    $overlap_class = $i % 2 == 0 ? "overlap-group-2" : "overlap-3";
                    echo "<div class='$card_class'>";
                    echo "<div class='frame-10'>";
                    echo "<div class='frame-11'>";
                    echo "<div class='product-name'>" . htmlspecialchars($product['name']) . "</div>";
                    echo "<div class='product-description'>" . htmlspecialchars($product['description']) . "</div>";
                    echo "<div class='colors'>";
                    foreach ($product['colors'] as $color) {
                        echo "<div class='color' style='background-color: " . htmlspecialchars($color) . ";'></div>";
                    }
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='frame-12'><div class='text-wrapper-10'>$" . number_format($product['price'], 2) . "</div></div>";
                    echo "</div>";
                    if (isset($product['is_new']) && $product['is_new']) {
                        echo "<div class='overlap-2'>";
                        echo "<div class='chips-component'><div class='lable-wrapper'><div class='lable'>New</div></div></div>";
                        echo "<div class='header-favorite-icon-3'></div>";
                        echo "</div>";
                    } else {
                        echo "<div class='$overlap_class'><div class='header-favorite-icon-2'></div></div>";
                    }
                    echo "</div>";
                    $current_product_index++;
                }
                echo "</div>";
            }
            ?>

            <button id="load-more" class="button-comp">
                <div class="add-to-cart">Load More</div>
            </button>

            <footer class="footer">
                <div class="overlap">
                    <div class="frame-4">
                        <div class="footer-text-box">
                            <div class="text-wrapper-7">About Modimal</div>
                            <div class="frame-5">
                                <div class="div-wrapper"><div class="text-wrapper-8">Collection</div></div>
                                <div class="div-wrapper"><div class="text-wrapper-8">Sustainability</div></div>
                                <div class="div-wrapper"><div class="text-wrapper-8">Privacy Policy</div></div>
                                <div class="div-wrapper"><div class="text-wrapper-8">Support System</div></div>
                                <div class="div-wrapper"><div class="text-wrapper-8">Terms & Condition</div></div>
                                <div class="div-wrapper"><div class="text-wrapper-8">Copyright Notice</div></div>
                            </div>
                        </div>
                        <div class="footer-text-box-2">
                            <div class="text-wrapper-7">Help & Support</div>
                            <div class="frame-5">
                                <div class="header-footer-texts-2"><div class="text-wrapper-8">Orders & Shipping</div></div>
                                <div class="header-footer-texts-2"><div class="text-wrapper-8">Returns & Refunds</div></div>
                                <div class="header-footer-texts-2"><div class="text-wrapper-8">Faqs</div></div>
                                <div class="header-footer-texts-2"><div class="text-wrapper-8">Contact Us</div></div>
                            </div>
                        </div>
                        <div class="footer-text-box-3">
                            <div class="text-wrapper-9">Join Up</div>
                            <div class="frame-6">
                                <div class="header-footer-texts-3"><div class="text-wrapper-8">Modimal Club</div></div>
                                <div class="header-footer-texts-3"><div class="text-wrapper-8">Careers</div></div>
                                <div class="header-footer-texts-3"><div class="text-wrapper-8">Visit Us</div></div>
                            </div>
                        </div>
                    </div>
                    <div class="footer-chat-box"><img class="element" src="../../img/3p.svg" /></div>
                </div>
                <div class="copyright">
                    <img class="img" src="../../img/copyright.svg" />
                    <p class="element-modimal-all">2023 Modimal. All Rights Reserved.</p>
                </div>
                <div class="footer-social-media">
                    <img class="img" src="../../img/social-media-3.svg" />
                    <img class="img" src="../../img/social-media-2.svg" />
                    <img class="img" src="../../img/social-media.svg" />
                    <img class="img" src="../../img/social-media-4.svg" />
                </div>
                <p class="join-our-club-get">Join Our Club, Get 15% Off For Your Birthday</p>
                <div class="frame-7">
                    <div class="input-orginal">
                        <div class="label">Enter Your Email Address</div>
                        <img class="arrow-forward" src="../../img/arrow-forward.svg" />
                    </div>
                    <div class="frame-wrapper">
                        <div class="frame-8">
                            <div class="checkmark-approval"></div>
                            <p class="p">By Submitting your email, you agree to receive advertising emails from Modimal.</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let offset = <?php echo $total_products; ?>; // Số sản phẩm đã hiển thị ban đầu

            $('#load-more').click(function() {
                $.ajax({
                    url: '../../src/controllers/ProductController.php',
                    method: 'POST',
                    data: { action: 'loadMore', offset: offset },
                    dataType: 'json',
                    success: function(response) {
                        if (response.products.length > 0) {
                            // Chia sản phẩm vào các frame
                            let frameIndex = Math.floor(offset / 2); // Mỗi frame chứa 2 sản phẩm
                            let frameClass = frameIndex === 0 ? 'frame-9' : frameIndex === 1 ? 'frame-13' : 'frame-14';
                            let $frame = $(`#product-list-${frameClass}`);
                            
                            if ($frame.length === 0) {
                                // Nếu frame chưa tồn tại, tạo mới
                                $frame = $(`<div class="${frameClass}" id="product-list-${frameClass}"></div>`);
                                $('.breadcrumbb').after($frame);
                            }

                            response.products.forEach(function(product, index) {
                                let cardClass = (offset + index) % 2 === 0 ? 'product-card' : 'product-card-2';
                                let overlapClass = (offset + index) % 2 === 0 ? 'overlap-group-2' : 'overlap-3';
                                let productHtml = `
                                    <div class="${cardClass}">
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
                                        ${product.is_new ? `
                                            <div class="overlap-2">
                                                <div class="chips-component"><div class="lable-wrapper"><div class="lable">New</div></div></div>
                                                <div class="header-favorite-icon-3"></div>
                                            </div>
                                        ` : `
                                            <div class="${overlapClass}">
                                                <div class="header-favorite-icon-2"></div>
                                            </div>
                                        `}
                                    </div>
                                `;
                                $frame.append(productHtml);
                            });

                            offset += response.products.length; // Cập nhật offset
                            if (response.products.length < 2) {
                                $('#load-more').hide(); // Ẩn nút nếu không còn sản phẩm để tải
                            }
                        } else {
                            $('#load-more').hide(); // Ẩn nút nếu không còn sản phẩm
                        }
                    },
                    error: function() {
                        alert('Không thể tải thêm sản phẩm. Vui lòng thử lại sau.');
                    }
                });
            });
        });
    </script>
</body>
</html>