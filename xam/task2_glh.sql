-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2026 at 11:57 AM
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
-- Database: `task2_glh`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL COMMENT 'unique cart id',
  `user_id` int(11) NOT NULL COMMENT 'links cart to user',
  `product_id` int(11) NOT NULL COMMENT 'products added to cart',
  `quantity` int(11) NOT NULL,
  `added_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'time product was added'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(7, 4, 7, 1, '2026-04-20 12:03:12');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(5, 'Bakery'),
(4, 'Dairy'),
(1, 'Fruit'),
(3, 'Meat'),
(2, 'Vegetables');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL COMMENT 'order id',
  `user_id` int(11) NOT NULL COMMENT 'links order to customer placing it',
  `order_total` decimal(8,2) NOT NULL COMMENT 'total cost of order',
  `order_status` varchar(50) NOT NULL COMMENT 'status of order (pending, confirmed, completed)',
  `order_type` varchar(50) NOT NULL COMMENT 'collection or delivery',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'date time order was placed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_total`, `order_status`, `order_type`, `created_at`) VALUES
(0, 4, 3.50, 'pending', 'delivery', '2026-04-20 09:11:04');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL COMMENT 'unique id for order item',
  `order_id` int(11) NOT NULL COMMENT 'links to order',
  `product_id` int(11) NOT NULL COMMENT 'links to product ordered',
  `quantity` int(11) NOT NULL COMMENT 'number of items ordered',
  `price` decimal(6,2) NOT NULL COMMENT 'price of product'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 0, 2, 1, 3.50);

-- --------------------------------------------------------

--
-- Table structure for table `producers`
--

CREATE TABLE `producers` (
  `producer_id` int(11) NOT NULL COMMENT 'unique producer id',
  `user_id` int(11) NOT NULL COMMENT 'links to user account',
  `business_name` varchar(150) NOT NULL COMMENT 'name of producer or farm',
  `description` text DEFAULT NULL COMMENT 'description of producer & products',
  `location` varchar(150) NOT NULL COMMENT 'location/address of producer',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'date account created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `producers`
--

INSERT INTO `producers` (`producer_id`, `user_id`, `business_name`, `description`, `location`, `created_at`) VALUES
(1, 2, 'Rabbit Hole', NULL, '', '2026-04-13 09:54:00'),
(2, 3, 'Cantarella', NULL, '', '2026-04-14 11:31:40');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL COMMENT 'products id',
  `producer_id` int(11) NOT NULL COMMENT 'links product to producer selling',
  `product_name` varchar(150) NOT NULL COMMENT 'name of product',
  `category_id` int(10) UNSIGNED NOT NULL COMMENT 'links the product to the categories for filtering',
  `description` text DEFAULT NULL COMMENT 'description',
  `price` decimal(6,2) NOT NULL COMMENT 'price',
  `quantity` int(11) NOT NULL COMMENT 'number of items available',
  `image_url` varchar(255) NOT NULL COMMENT 'path to image of product'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `producer_id`, `product_name`, `category_id`, `description`, `price`, `quantity`, `image_url`) VALUES
(1, 1, 'Cherries', 1, NULL, 4.99, 10, ''),
(2, 1, 'Apples', 1, NULL, 3.50, 10, ''),
(3, 1, 'Raspberries', 1, NULL, 5.99, 20, ''),
(5, 2, 'Parsley', 2, NULL, 1.50, 15, ''),
(6, 2, 'Coriander', 2, NULL, 2.99, 40, ''),
(7, 1, 'British Beef', 3, NULL, 9.99, 0, ''),
(8, 2, 'Cheddar Cheese', 4, NULL, 8.00, 8, ''),
(9, 1, 'Sourdough Bread', 5, NULL, 7.50, 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT 'user id',
  `name` varchar(100) NOT NULL COMMENT 'users name',
  `email` varchar(100) NOT NULL COMMENT 'users login email',
  `password` varchar(255) DEFAULT NULL COMMENT 'encrypted password',
  `phone_number` int(11) DEFAULT NULL COMMENT 'users phone number',
  `address` varchar(255) DEFAULT NULL COMMENT 'users address for delivery',
  `user_role` enum('customer','producer','admin','') NOT NULL COMMENT 'user role - ''customer'' ''producer'' ''admin''',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'account creation date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone_number`, `address`, `user_role`, `created_at`) VALUES
(1, 'glh', 'glh@greenfield.co.uk', '$2y$10$dj8AA2VRu66MODqF3sIIFu5xkXNq1Gw99LTUP.c9TXuzzn5yAqDx2', NULL, NULL, 'admin', '2026-04-13 09:50:30'),
(2, 'producer1', 'producer1@email.com', '$2y$10$3aq/B//3jFq7ShfkxuVmme7JHTh3pBu1qB8Q.9iI0Kcz01QHCU21K', NULL, NULL, 'producer', '2026-04-13 09:51:41'),
(3, 'producer2', 'producer2@email.com', '$2y$10$I/UVT3fJzEeLEtlrwsmEieyi4bhEtq/I5KRiAUH7iCvIT0nU7IPNO', NULL, NULL, 'producer', '2026-04-13 09:51:41'),
(4, 'customer1', 'customer1@email.com', '$2y$10$BkettpNxyQaQXq4sNlm/a.bClrXbAdGZVuVZD/3R69qEBpf22eOgi', NULL, NULL, 'customer', '2026-04-16 10:55:25'),
(5, 'customer2', 'customer2@email.com', '$2y$10$2v87S.4ONb1KtADxVULceOwDipmKtCYW4WnxDrFzubnIwG0mEf2qK', NULL, NULL, 'customer', '2026-04-16 13:38:47'),
(7, 'customer3', 'customer3@email.com', '$2y$10$VV9vPsGpH5IID0UYSAv9NOaL4ia6qwxJKIfz/R1KZAGq8ySjAj/xa', NULL, NULL, 'customer', '2026-04-20 11:36:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `producers`
--
ALTER TABLE `producers`
  ADD PRIMARY KEY (`producer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `producer_id` (`producer_id`),
  ADD KEY `fk_products_category` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique cart id', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id for order item', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `producers`
--
ALTER TABLE `producers`
  MODIFY `producer_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique producer id', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'products id', AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'user id', AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `producers`
--
ALTER TABLE `producers`
  ADD CONSTRAINT `producers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`producer_id`) REFERENCES `producers` (`producer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
