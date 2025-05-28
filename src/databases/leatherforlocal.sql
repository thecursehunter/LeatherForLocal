-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2025 at 05:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

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
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(10,3) NOT NULL,
  `is_new` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `colors` text DEFAULT NULL,
  `images` text DEFAULT NULL,
  `features` text DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL,
  `material_description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`id`, `name`, `description`, `price`, `is_new`, `created_at`, `colors`, `images`, `features`, `material`, `material_description`, `category`) VALUES
(1, 'Balo Hành Trình\n', 'Da bò thật cao cấp, thiết kế rộng rãi, đa năng. Đồng hành lý tưởng cho công sở và du lịch, toát lên vẻ đẳng cấp, tự tin.', 380.000, 0, '2025-05-13 11:21:40', NULL, 'backpack_1.jpg', NULL, NULL, NULL, NULL),
(2, 'Balo Thành Thị\n', 'Da thật mềm mại, tối giản, tinh tế. Ngăn laptop chuyên dụng, hoàn hảo cho phong cách hiện đại, năng động giữa lòng đô thị.\n', 450.000, 1, '2025-05-13 11:21:40', NULL, 'backpack_2.jpg', NULL, NULL, NULL, NULL),
(3, 'Túi Xách Elegant\n', 'Biểu tượng của sự sang trọng, quý phái. Da cao cấp, đường may tỉ mỉ, giúp quý cô tỏa sáng tự tin trong mọi hoàn cảnh.', 650.000, 0, '2025-05-13 11:21:40', NULL, 'bag_1.jpg', NULL, NULL, NULL, NULL),
(4, 'Áo Khoác Stylish', 'Kiểu dáng biker kinh điển từ da thật dày dặn. Mạnh mẽ, bụi bặm, khẳng định phong cách tự do, cá tính riêng của bạn.', 750.000, 0, '2025-05-13 11:21:40', NULL, 'jacket_1.jpg', NULL, NULL, NULL, NULL),
(5, 'Áo Khoác Bụi Bặm', 'Thiết kế tối giản, lịch lãm, làm từ da mềm mại cao cấp. Dễ dàng phối hợp mọi trang phục, tôn lên vẻ ngoài sang trọng, tinh tế.', 700.000, 0, '2025-05-13 11:21:40', NULL, 'jacket_3.jpg', NULL, NULL, NULL, NULL),
(6, 'Áo Khoác Nomad', 'Lấy cảm hứng từ sự khám phá, với chất liệu da độc đáo và chi tiết tinh xảo. Bền bỉ, phóng khoáng, tuyên ngôn cho tinh thần phiêu lưu, khác biệt.\n', 750.000, 1, '2025-05-13 11:21:40', NULL, 'jacket_2.jpg', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
