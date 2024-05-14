-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2024 at 02:21 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parental`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `start_date`, `end_date`, `subtotal`) VALUES
(31, 1, 4, 2, '2024-05-12', '2024-05-31', 2100.00),
(32, 1, 3, 4, '2024-05-13', '2024-05-20', 80.00),
(36, 2, 3, 1, '2024-05-15', '2024-05-24', 40.00),
(37, 2, 2, 1, '2024-05-14', '2024-05-21', 300.00),
(38, 2, 1, 1, '2024-05-15', '2024-05-22', 45.00),
(39, 2, 3, 1, '2024-05-15', '2024-05-23', 40.00);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `picture` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `picture`) VALUES
(1, 'Chairs', 'Elevate your event with our diverse selection of chairs, offering comfort and style for any occasion.', 'chair.jpg'),
(2, 'Tables', 'Discover the perfect table to anchor your event space, whether it\'s for dining, displays, or networking.', 'table.jpg'),
(3, 'Flatware', 'Add a touch of elegance to your dining experience with our exquisite flatware collection.', 'furniture.jpg'),
(4, 'Linens', 'Enhance your table settings with our linens, adding elegance and sophistication to every meal.', 'linen.jpg'),
(5, 'Tent', 'Provide shelter with our tent options, ensuring your event is memorable rain or shine.', 'tent.jpg'),
(6, 'Glassware', 'Elevate your beverage service with our premium glassware, adding a touch of sophistication to every toast.', 'glassware.jpg'),
(7, 'Lighting', 'Illuminate your event with our lighting options, highlight every moment with elegance and flair.', 'lighting.jpg'),
(8, 'Serving', 'Ensure seamless food presentation and service with our quality food service equipment.', 'cooking.png');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `payment` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `date`, `address`, `payment`, `price`, `name`, `note`, `phone`, `email`) VALUES
(5, 2, '2024-05-14 10:32:02', 'Tabaco, Panal, Purok 3, 4511', 'Cash On Delivery', 425.60, 'Maureen Benitez', '', '09123456789', 'maureenasirit.benitez@bicol-u.edu.ph');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`id`, `order_id`, `product_id`, `quantity`, `start_date`, `end_date`, `status`) VALUES
(6, 5, 2, 1, '2024-05-14', '2024-05-16', 'Processing'),
(7, 5, 3, 2, '2024-05-15', '2024-05-23', 'Processing');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `material` varchar(50) DEFAULT NULL,
  `dimension` varchar(50) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `price`, `color`, `material`, `dimension`, `stock`, `image`) VALUES
(1, 'Folding Chair', 1, 45.00, 'Black', 'Aluminum Frame, Plastic Backrest', 'W18*D18*H35', 2000, 'foldingchair.jpg'),
(2, 'Banquet Table', 2, 300.00, 'White', 'Plastic Table Top, Aluminum Table Legs', 'W72*D30*H29', 2000, 'banquettable.jpg'),
(3, 'Dinner Knife', 3, 20.00, 'Silver', 'Stainless Steel', '24 cm', 2000, 'dinnerknife.jpg'),
(4, 'Wood Table', 2, 350.00, 'Brown', 'Wood', 'W72*D30*H29', 500, 'woodtable.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `image` varchar(100) DEFAULT 'profile.jpg',
  `username` varchar(100) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `phone_number`, `address`, `email`, `password`, `image`, `username`, `gender`, `birthday`) VALUES
(1, 'alvan', '09111111111', NULL, 'admin@gmail.com', '$2y$10$DQiIhDYvXrcXcBmxazot9usoDwK9cIhB4c3RtmncS.glNvrH9v1nK', 'profile.jpg', NULL, '', NULL),
(2, 'Maureen Benitez', '09123456789', 'Matagbac, Tabaco City', 'maureenasirit.benitez@bicol-u.edu.ph', '$2y$10$0k5ZaAZotog.FKdL15En9OeO2JQFlolEo5v4Gu6GeqBqemlTUjYoC', 'maureen.png', '@maureen30', 'Other', '2002-05-30'),
(3, 'Joshua Vergara', '09354375689', NULL, 'vedo@gmail.com', '$2y$10$oZ6LSzFBMYJns7m/ZcKD7.dSTIAU2uqDaDw9ChB8x83/cdy20Xa3C', 'profile.jpg', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
