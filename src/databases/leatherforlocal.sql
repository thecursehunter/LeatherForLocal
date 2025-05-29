-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 08:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leatherforlocal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `permissions` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`, `description`, `is_active`, `created_at`) VALUES
(1, 'Balo', NULL, 1, '2025-05-28 18:39:07'),
(2, 'Túi Xách', NULL, 1, '2025-05-28 18:39:07'),
(3, 'Áo Khoác', NULL, 1, '2025-05-28 18:39:07'),
(4, 'Phụ Kiện', NULL, 1, '2025-05-28 18:39:07');

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `delivery_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `delivery_status` varchar(50) DEFAULT NULL,
  `estimated_delivery` datetime DEFAULT NULL,
  `actual_delivery` datetime DEFAULT NULL,
  `delivery_address` varchar(255) DEFAULT NULL,
  `delivery_notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `username`, `email`, `password_hash`, `full_name`, `phone_number`, `address`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'Lilac', 'PhamQuangMinhMDCH@proton.me', '$2y$10$IFimFm4Oi8l3qxvWg6Ca3.fYpqzVSQVZ8rwIxStTO7boFtfTp.QEa', 'Phạm Quang Minh', 'M!nh20052105', '266 Ni Sư huỳnh Liên', '2025-05-29 15:34:45', '2025-05-29 15:34:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `member_id`, `order_date`, `total_amount`, `status`, `shipping_address`, `phone_number`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-05-30 00:06:52', 760.00, 'Pending', '266 Ni Su Huynh Lien', '0399254984', 'Delivery Method: standard\nPayment Method: cod', '2025-05-30 00:06:52', '2025-05-30 00:06:52');

-- --------------------------------------------------------

--
-- Table structure for table `orderitem`
--

CREATE TABLE `orderitem` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orderitem`
--

INSERT INTO `orderitem` (`order_item_id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`) VALUES
(1, 1, 1, 2, 380.00, 760.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(6,3) NOT NULL,
  `is_new` tinyint(1) DEFAULT 0,
  `colors` varchar(255) DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `description`, `price`, `is_new`, `colors`, `images`, `material`, `stock_quantity`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 1, 'Balo Hành Trình', 'Da bò thật cao cấp, thiết kế rộng rãi, đa năng. Đồng hành lý tưởng cho công sở và du lịch, toát lên vẻ đẳng cấp, tự tin.', 380.000, 1, 'orange', 'backpack_1.jpg', 'Da bò thật', 15, 1, '2025-05-28 18:39:07', '2025-05-29 11:24:18'),
(2, 1, 'Balo Thành Thị', 'Da thật mềm mại, tối giản, tinh tế. Ngăn laptop chuyên dụng, hoàn hảo cho phong cách hiện đại, năng động giữa lòng đô thị.', 450.000, 1, 'crimson, black', 'backpack_2.jpg', 'Da thật', 20, 1, '2025-05-28 18:39:07', '2025-05-29 11:24:15'),
(3, 2, 'Túi Xách Elegant', 'Biểu tượng của sự sang trọng, quý phái. Da cao cấp, đường may tỉ mỉ, giúp quý cô tỏa sáng tự tin trong mọi hoàn cảnh.', 500.000, 0, 'orange', 'bag_1.jpg', 'Da cao cấp', 10, 1, '2025-05-28 18:39:07', '2025-05-29 11:23:37'),
(4, 3, 'Áo Khoác Stylish', 'Kiểu dáng biker kinh điển từ da thật dày dặn. Mạnh mẽ, bụi bặm, khẳng định phong cách tự do, cá tính riêng của bạn.', 750.000, 1, 'black', 'jacket_1.jpg', 'Da thật dày dặn', 8, 1, '2025-05-28 18:39:07', '2025-05-29 11:24:09'),
(5, 3, 'Áo Khoác Bụi Bặm', 'Thiết kế tối giản, lịch lãm, làm từ da mềm mại cao cấp. Dễ dàng phối hợp mọi trang phục, tôn lên vẻ ngoài sang trọng, tinh tế.', 800.000, 0, 'black', 'jacket_3.jpg', 'Da mềm mại cao cấp', 12, 1, '2025-05-28 18:39:07', '2025-05-29 11:23:46'),
(6, 3, 'Áo Khoác Nomad', 'Lấy cảm hứng từ sự khám phá, với chất liệu da độc đáo và chi tiết tinh xảo. Bền bỉ, phóng khoáng, tuyên ngôn cho tinh thần phiêu lưu, khác biệt.', 650.000, 1, 'orange', 'jacket_2.jpg', 'Chất liệu da độc đáo', 7, 1, '2025-05-28 18:39:07', '2025-05-29 11:24:04');

-- --------------------------------------------------------

--
-- Table structure for table `revenuereport`
--

CREATE TABLE `revenuereport` (
  `report_id` int(11) NOT NULL,
  `report_date` date NOT NULL,
  `total_revenue` decimal(12,2) NOT NULL,
  `total_orders` int(11) NOT NULL,
  `generated_at` datetime DEFAULT current_timestamp(),
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `revenuereport`
--
ALTER TABLE `revenuereport`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orderitem`
--
ALTER TABLE `orderitem`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `revenuereport`
--
ALTER TABLE `revenuereport`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`);

--
-- Constraints for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD CONSTRAINT `orderitem_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderitem_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `revenuereport`
--
ALTER TABLE `revenuereport`
  ADD CONSTRAINT `revenuereport_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;