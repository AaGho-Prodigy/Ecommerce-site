-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2025 at 12:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `checkoutdetails`
--

CREATE TABLE `checkoutdetails` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('Pending','User_Confirmed','Admin_Confirmed') NOT NULL DEFAULT 'Pending',
  `payment_status` enum('Unpaid','Paid') DEFAULT 'Unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_confirmed_at` datetime DEFAULT NULL,
  `admin_confirmed_at` datetime DEFAULT NULL,
  `is_confirmed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `payment_status`, `created_at`, `user_confirmed_at`, `admin_confirmed_at`, `is_confirmed`) VALUES
(7, 30, 199.00, '', 'Paid', '2025-03-02 17:12:40', '2025-03-03 17:21:50', '2025-03-03 17:24:20', 0),
(8, 30, 6666.00, '', '', '2025-03-02 17:21:02', NULL, NULL, 0),
(9, 30, 3333.00, '', 'Unpaid', '2025-03-02 17:28:07', NULL, NULL, 0),
(10, 30, 199.00, '', 'Unpaid', '2025-03-02 18:11:50', NULL, NULL, 0),
(11, 30, 3333.00, '', 'Unpaid', '2025-03-02 18:18:49', NULL, NULL, 0),
(12, 30, 3333.00, 'Pending', 'Unpaid', '2025-03-03 04:34:50', NULL, NULL, 0),
(13, 30, 3333.00, '', 'Unpaid', '2025-03-03 07:13:02', NULL, NULL, 0),
(14, 30, 3532.00, 'Pending', 'Unpaid', '2025-03-03 11:30:38', NULL, NULL, 0),
(15, 30, 199.00, '', 'Unpaid', '2025-03-03 16:24:01', NULL, NULL, 0),
(17, 30, 100.00, 'Pending', 'Unpaid', '2025-03-03 16:48:31', NULL, NULL, 0),
(18, 30, 199.00, 'Pending', 'Unpaid', '2025-03-03 16:49:12', NULL, NULL, 0),
(19, 30, 398.00, '', 'Unpaid', '2025-03-03 16:52:34', NULL, NULL, 0),
(20, 30, 199.00, 'Pending', 'Unpaid', '2025-03-03 16:58:28', NULL, NULL, 0),
(21, 30, 199.00, 'Pending', 'Unpaid', '2025-03-03 17:05:02', NULL, NULL, 0),
(22, 30, 3333.00, 'Pending', 'Unpaid', '2025-03-03 17:11:26', NULL, NULL, 0),
(23, 30, 3333.00, 'Pending', 'Unpaid', '2025-03-03 17:11:39', NULL, NULL, 0),
(24, 30, 888.00, 'Pending', 'Unpaid', '2025-03-03 17:12:42', NULL, NULL, 0),
(25, 30, 888.00, '', 'Unpaid', '2025-03-03 17:14:22', '2025-03-15 15:35:09', NULL, 1),
(26, 30, 888.00, '', 'Unpaid', '2025-03-03 17:25:13', NULL, NULL, 0),
(27, 30, 888.00, '', 'Paid', '2025-03-03 17:35:58', NULL, '2025-03-03 23:21:30', 0),
(28, 30, 888.00, '', 'Paid', '2025-03-03 17:56:01', NULL, '2025-03-03 23:41:18', 0),
(29, 30, 199.00, '', 'Paid', '2025-03-04 02:16:43', NULL, '2025-03-04 08:02:13', 0),
(30, 30, 888.00, '', 'Unpaid', '2025-03-04 02:19:15', NULL, NULL, 0),
(31, 30, 199000.00, '', 'Paid', '2025-03-09 01:45:42', NULL, '2025-03-09 07:33:27', 0),
(32, 29, 150000.00, '', 'Unpaid', '2025-03-15 08:25:25', NULL, NULL, 0),
(33, 30, 368000.00, '', 'Unpaid', '2025-03-15 08:31:09', '2025-03-15 15:34:22', NULL, 1),
(34, 30, 150000.00, '', 'Unpaid', '2025-03-15 08:33:55', NULL, NULL, 0),
(35, 30, 120000.00, 'User_Confirmed', 'Paid', '2025-03-15 08:38:48', NULL, '2025-03-15 14:40:44', 0),
(36, 30, 120000.00, 'User_Confirmed', 'Paid', '2025-03-15 08:58:30', '2025-03-15 14:43:30', '2025-03-15 14:43:57', 0),
(37, 30, 99999.00, '', 'Unpaid', '2025-03-15 13:36:24', '2025-03-15 19:21:37', NULL, 1),
(38, 29, 199000.00, 'User_Confirmed', 'Paid', '2025-03-15 14:26:54', '2025-03-15 21:40:51', '2025-03-15 21:42:14', 1),
(39, 29, 199000.00, 'User_Confirmed', 'Paid', '2025-03-15 15:46:37', '2025-03-15 21:42:43', '2025-03-15 21:42:49', 1),
(40, 29, 567000.00, 'User_Confirmed', 'Paid', '2025-03-16 01:27:56', '2025-03-16 07:13:26', '2025-03-16 07:13:32', 1),
(41, 29, 14985.00, 'Pending', 'Unpaid', '2025-03-16 02:04:15', '2025-03-16 07:49:15', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(24, 31, 24, 1),
(25, 32, 25, 1),
(26, 33, 24, 1),
(27, 33, 23, 1),
(28, 34, 25, 1),
(29, 35, 27, 1),
(30, 36, 27, 1),
(31, 37, 28, 1),
(32, 38, 24, 1),
(33, 39, 24, 1),
(34, 40, 24, 2),
(35, 40, 23, 1),
(36, 41, 30, 15);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `title`, `description`, `price`, `image_url`, `created_at`) VALUES
(1, 'Iste qui aliquid mol', 'Dolore commodo sunt ', 449.00, '', '2025-01-20 17:17:18');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `price`, `image_url`, `created_at`, `category`, `quantity`) VALUES
(23, 'Iphone 15 Plus', 'Amazing Camera Quality', 169000.00, 'uploads/iphone 15 plus.webp', '2025-03-09 01:39:12', 'Phone', 3),
(24, 'Iphone 16', 'Amazing Camera Quality', 199000.00, 'uploads/iphone 16.webp', '2025-03-09 01:39:43', 'Phone', 0),
(25, 'Playstation 5', 'Smooth gaming experience', 150000.00, 'uploads/playstation 5.webp', '2025-03-09 01:40:49', 'Video Game Console', 5),
(27, 'Playstation 4', 'Smooth gaming experience', 120000.00, 'uploads/playstation 4.webp', '2025-03-09 01:41:25', 'Video Game Console', 2),
(28, 'Apple Watch Series 10', 'Available with Google Maps, Bluetooth', 99999.00, 'uploads/apple-watch-series-10.jpg', '2025-03-09 01:42:12', 'Smartwatch', 2),
(29, 'Samsung Galaxy Watch FE', 'Available with Google Maps, Bluetooth, Heart Monitor', 89999.00, 'uploads/samsung galaxy watch fe.webp', '2025-03-09 01:42:40', 'Smartwatch', 2),
(30, '123', 'zgldfskg', 999.00, 'uploads/2.jpeg', '2025-03-16 02:00:15', 'Phone', -13);

-- --------------------------------------------------------

--
-- Table structure for table `purchased_products`
--

CREATE TABLE `purchased_products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `purchased_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchased_products`
--

INSERT INTO `purchased_products` (`id`, `product_name`, `quantity`, `price`, `order_id`, `purchased_at`) VALUES
(1, 'Iphone', 1, 199.00, 14, '2025-02-17 12:40:32'),
(2, 'Iphone', 1, 199.00, 15, '2025-02-17 12:41:32'),
(3, 'Iphone', 1, 199.00, 16, '2025-02-17 12:41:54'),
(4, 'Iphone', 1, 199.00, 17, '2025-02-17 12:54:16'),
(5, 'Iphone', 1, 199.00, 18, '2025-02-20 17:11:49'),
(6, 'Iphone', 1, 199.00, 19, '2025-02-20 17:34:05'),
(7, 'Iphone', 1, 199.00, 20, '2025-02-21 01:37:33'),
(8, 'Iphone', 1, 199.00, 21, '2025-02-21 01:44:48'),
(9, 'Iphone', 1, 199.00, 0, '2025-03-02 16:44:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(6, 'nehirekyv', 'wagybilep@mailinator.com', '$2y$10$zECTVVyvxYBfd7O25ZZ8sOYkJiI0nW5nLlq9GdGqRvOJydIz6EXyO', 'user'),
(7, 'Pratik', 'asd.com', '', 'user'),
(8, 'Budhathoki', 'fgh.com', '', 'user'),
(9, 'eee', 'asd', '', 'user'),
(10, 'fff', 'sdf', '', 'user'),
(11, 'eee', 'asd', '', 'user'),
(12, 'fff', 'sdf', '', 'user'),
(13, 'eee', 'asd', '', 'user'),
(14, 'fff', 'sdf', '', 'user'),
(15, 'eee', 'asd', '', 'user'),
(16, 'fff', 'sdf', '', 'user'),
(17, 'punugyfyn', 'mesan@mailinator.com', '$2y$10$yiQ77E1oeOo7JwuRNqrUtOA66gRWLHEVeS5AX3qS72RveTeMLED5W', 'user'),
(18, 'quqoxanan', 'kybosilela@mailinator.com', '$2y$10$4yE.7jeSF/6ElYcdFnMJHuczH196C2R7AyL2I6GnJ9Q0A9uJC7u9a', 'user'),
(19, 'tirykivixo', 'garubotuhe@mailinator.com', '$2y$10$alS81rn.zveY0/KAAkpz9uJQT88PVebObbkX4uSHLamizM5sGgU8S', 'user'),
(20, 'tirykivixo', 'garubotuhe@mailinator.com', '$2y$10$nxCqm9KscKOybl8vRjgmW.q5tihXHXPHPQUk2UqcUcAMk.Gsnt3yi', 'user'),
(21, 'tirykivixo', 'garubotuhe@mailinator.com', '$2y$10$xLvnEAYytHMPnVVCMltJxO8Do8OzHxLTbNSYTtuHsXVV.knH9lekS', 'user'),
(22, 'kaqavavy', 'kybosilela@mailinator.com', '$2y$10$am5oFUc7G39KJdWOJjdshOfVHFXvS9C47VrCw8V7Yxz2Jrcj0p.hy', 'user'),
(23, 'Aagho', 'sfsd@gmail.com', '$2y$10$4KrHCvB9cv6VN/6a4sYt9uD6w4jjyKUPfJPckIDKwnPwB6q.H71DW', 'user'),
(24, 'ruraziruj', 'lodisez@mailinator.com', '$2y$10$XWzyDjaZ.RYdpqHKIBhDpOUjtfkFY2skAU/gdIzycrN51Un4a9raG', 'user'),
(25, 'xyxus', 'qebaqofiga@mailinator.com', '$2y$10$gOtRbypVjvEqFkQKfz4IQuy4UqyaunMKDA7yKZO4/anrOB8SUtBAu', 'user'),
(26, 'biroxido', 'pizi@mailinator.com', '$2y$10$UxRHOG6ceX76w1KiT7gQsu4MlI.uhuY1LBZgoAWCyCsFe.Z1nBhru', 'user'),
(27, 'pratik', 'budhathokip430@gmail.com', '$2y$10$lYnJKhGUBBR8FMjck9lMNOFohUj86LPXk6nBQx9MnQ/9Bj61wIHr6', 'user'),
(28, 'test', 'test@gmail.com', '$2y$10$yK61CeH0vHjU.EZe2ZgnDuc9TkkzIEIH4FS2Cmkd/S3zjxCiFFe26', 'user'),
(29, 'test10', 'test210@gmail.com', '12345678', 'user'),
(30, 'tttt', 'tttt@gmail.com', '12345678', 'user'),
(31, 'testuser', 'test@example.com', 'password123', 'user'),
(32, 'admin', '', 'Terrorblade97', 'admin'),
(33, 'picidoje', 'coxowexaz@mailinator.com', 'Pa$$w0rd!', 'user'),
(34, 'vocahimuda', 'ribiwodibo@mailinator.com', 'Pa$$w0rd!', 'user'),
(35, 'symupygy', 'ralyfug@mailinator.com', 'Pa$$w0rd!', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `vieworders`
--

CREATE TABLE `vieworders` (
  `productid` int(11) NOT NULL,
  `product` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `deliver` tinyint(1) NOT NULL,
  `paymentstatus` tinyint(1) NOT NULL,
  `orderstatus` tinyint(1) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchased_products`
--
ALTER TABLE `purchased_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `purchased_products`
--
ALTER TABLE `purchased_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
