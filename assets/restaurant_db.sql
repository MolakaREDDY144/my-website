-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2025 at 12:40 PM
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
-- Database: `restaurant_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `restaurant_id`, `name`, `description`, `price`, `category`) VALUES
(1, 1, 'Seared Scallops', 'With a cauliflower purée and truffle oil.', 24.50, 'Appetizer'),
(2, 1, 'Filet Mignon', '8oz center-cut tenderloin with a red wine reduction sauce.', 55.00, 'Main Course'),
(3, 1, 'Chocolate Lava Cake', 'Molten chocolate center served with vanilla bean ice cream.', 14.00, 'Dessert'),
(4, 2, 'Vegetable Samosa', 'Crispy pastry filled with spiced potatoes and peas.', 8.00, 'Appetizer'),
(5, 2, 'Butter Chicken', 'Tender chicken in a creamy tomato sauce.', 22.00, 'Main Course'),
(6, 2, 'Garlic Naan', 'Traditional Indian flatbread with garlic and butter.', 4.50, 'Side'),
(7, 3, 'Bruschetta', 'Toasted bread with fresh tomatoes, garlic, and basil.', 9.50, 'Appetizer'),
(8, 3, 'Spaghetti Carbonara', 'Classic Roman pasta with egg, pecorino cheese, and pancetta.', 19.00, 'Main Course'),
(9, 3, 'Margherita Pizza', 'Wood-fired pizza with tomato, mozzarella, and fresh basil.', 16.00, 'Main Course');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('placed','preparing','ready','completed') DEFAULT 'placed',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `reservation_id`, `total_amount`, `status`, `created_at`) VALUES
(1, 1, 93.50, 'completed', '2025-10-20 20:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `menu_item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `menu_item_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 24.50),
(2, 1, 2, 1, 55.00),
(3, 1, 3, 1, 14.00);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `reservation_time` datetime NOT NULL,
  `party_size` int(11) NOT NULL,
  `status` enum('confirmed','cancelled','pending') DEFAULT 'pending',
  `payment_status` varchar(50) NOT NULL DEFAULT 'not_required',
  `stripe_payment_intent_id` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `restaurant_id`, `reservation_time`, `party_size`, `status`, `payment_status`, `stripe_payment_intent_id`, `created_at`) VALUES
(1, 2, 1, '2025-10-20 19:30:00', 2, 'cancelled', 'not_required', NULL, '2025-10-03 15:00:00'),
(2, 3, 2, '2025-10-22 20:00:00', 4, 'cancelled', 'not_required', NULL, '2025-10-04 09:15:00'),
(3, 2, 3, '2025-10-18 18:00:00', 3, 'cancelled', 'not_required', NULL, '2025-10-05 12:00:00'),
(4, 3, 3, '2025-10-03 20:48:00', 2, '', 'not_required', NULL, '2025-10-03 15:44:00'),
(5, 3, 1, '2025-10-03 20:50:00', 3, 'confirmed', 'not_required', NULL, '2025-10-03 15:45:26'),
(6, 2, 1, '2025-10-03 20:06:00', 4, 'cancelled', 'not_required', NULL, '2025-10-03 16:06:11');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `cuisine` varchar(100) NOT NULL,
  `opening_time` time NOT NULL,
  `closing_time` time NOT NULL,
  `image_url` varchar(255) DEFAULT 'assets/default-restaurant.jpg',
  `deposit_amount` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `description`, `address`, `cuisine`, `opening_time`, `closing_time`, `image_url`, `deposit_amount`) VALUES
(1, 'The Golden Spoon', 'A fine dining experience with a fusion of classic and modern cuisine. Perfect for special occasions.', '123 Elegance Avenue, City Center', 'Modern European', '18:00:00', '23:00:00', 'restaurant1.jpg', 5.00),
(2, 'Spice Route', 'Authentic Indian flavors that take you on a journey through the heart of India. Known for our rich curries and tandoori dishes.', '456 Spice Street, Market Square', 'Indian', '12:00:00', '22:00:00', 'restaurant2.jpg', 0.00),
(3, 'Pasta Bella', 'Cozy and rustic Italian eatery serving homemade pasta and wood-fired pizzas. A taste of Italy in your neighborhood.', '789 Vineyard Lane, Old Town', 'Italian', '11:30:00', '21:30:00', 'restaurant3.jpg', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `restaurant_id`, `rating`, `comment`, `created_at`) VALUES
(1, 2, 1, 5, 'Absolutely fantastic! The food was exquisite and the service was impeccable. A truly memorable evening.', '2025-09-28 22:00:00'),
(2, 3, 1, 4, 'Great ambiance and delicious food. The dessert was a bit of a letdown, but overall a wonderful experience.', '2025-09-29 21:00:00'),
(3, 3, 2, 5, 'The best butter chicken I have ever had! The staff was very friendly and welcoming. Highly recommended.', '2025-09-30 14:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`, `phone`, `created_at`) VALUES
(1, 'AdminUser', '$2a$12$p82dBMAyppfXNSzIvtgRAOsolRtBdBzJIpU/2eZSASeYKeepv5duC', 'admin', 'admin@reserveeats.com', '9876543210', '2025-10-01 10:00:00'),
(2, 'JohnDoe', '$2a$12$Ozng0aQg0GJIwbECTLWYbuAwI1OzgAcqcxbmqblMXnYJX7RrxUynS', 'user', 'john.doe@email.com', '1234567890', '2025-10-02 14:30:00'),
(3, 'JaneSmith', '$2a$12$IaM98qwsA5sCOXM219SAW.nSMkmf4u5m/A5joRqR7KVlYYo/mHLMm', 'user', 'jane.smith@email.com', '', '2025-10-03 11:20:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `menu_item_id` (`menu_item_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
