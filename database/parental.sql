-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 11:41 AM
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
(3, 'Dinnerwares', 'Add a touch of elegance to your dining experience with our exquisite flatware collection.', 'furniture.jpg'),
(4, 'Flatware', 'Add a touch of elegance to your dining experience with our exquisite flatware collection.', 'furniture.jpg'),
(5, 'Linens', 'Enhance your table settings with our linens, adding elegance and sophistication to every meal.', 'linen.jpg'),
(6, 'Tent', 'Provide shelter with our tent options, ensuring your event is memorable rain or shine.', 'tent.jpg'),
(7, 'Glassware', 'Elevate your beverage service with our premium glassware, adding a touch of sophistication to every toast.', 'glassware.jpg'),
(8, 'Lights and Decorations', 'Illuminate your event with our lighting options, highlight every moment with elegance and flair.', 'lighting.jpg'),
(9, 'Services', 'Ensure seamless food presentation and service with our quality food service equipment.', 'cooking.png');

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
(6, 2, '2024-05-15 17:39:28', 'Tabaco, Panal, Purok 3, 4511', 'Cash On Delivery', 112.00, 'Maureen Benitez', '', '09123456789', 'maureenasirit.benitez@bicol-u.edu.ph');

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
(8, 6, 1, 1, '2024-05-16', '2024-05-24', 'Processing');

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
(1, 'Folding Chair', 1, 50.00, 'Black', 'Metal and Plastic', '18x18x36 inches', 100, 'folding_chair_black.jpg'),
(2, 'Gold Chiavari Chair', 1, 100.00, 'Gold', 'Metal and Fabric', '16x16x36 inches', 100, 'gold_chiavari_chair.jpg'),
(3, 'Bamboo Folding Chair', 1, 80.00, 'Brown', 'Bamboo', '17x17x34 inches', 50, 'bamboo_folding_chair.jpg'),
(4, 'White Resin Chair', 1, 120.00, 'White', 'Resin', '17x17x35 inches', 80, 'white_resin_chair.jpg'),
(5, 'Rustic Farm Table', 2, 600.00, 'Brown', 'Wood', '8x3 feet', 10, 'rustic_farm_table.jpg'),
(6, 'Glass Top Table', 2, 900.00, 'Clear', 'Glass and Metal', '5x2.5 feet', 15, 'glass_top_table.jpg'),
(7, 'Cocktail Table', 2, 400.00, 'White', 'Metal', '30-inch diameter', 20, 'cocktail_table.jpg'),
(8, 'Round Banquet Table', 2, 600.00, 'Brown', 'Wood', '60-inch diameter', 10, 'round_banquet_table.jpg'),
(9, 'White Dinner Plate', 3, 50.00, 'White', 'Ceramic', '10.5 inches', 200, 'white_dinner_plate.jpg'),
(10, 'Salad Plate', 3, 40.00, 'White', 'Ceramic', '8 inches', 200, 'salad_plate.jpg'),
(11, 'Dessert Plate', 3, 30.00, 'White', 'Ceramic', '6 inches', 200, 'dessert_plate.jpg'),
(12, 'Charger Plate', 3, 70.00, 'Gold', 'Metal', '13 inches', 150, 'charger_plate.jpg'),
(13, 'Bread Plate', 3, 30.00, 'White', 'Ceramic', '5 inches', 200, 'bread_plate.jpg'),
(14, 'Bowl', 3, 35.00, 'White', 'Ceramic', '5 inches diameter', 200, 'bowl.jpg'),
(15, 'Soup Plate', 3, 45.00, 'White', 'Ceramic', '9 inches diameter', 200, 'soup_plate.jpg'),
(16, 'Chafing Dish', 9, 500.00, 'Silver', 'Stainless Steel', '8 quarts', 25, 'chafing_dish.jpg'),
(17, 'Serving Tray', 9, 200.00, 'Silver', 'Stainless Steel', '18x12 inches', 40, 'serving_tray.jpg'),
(18, 'Portable Bar', 9, 2000.00, 'Black', 'Metal and Wood', '5x2x4 feet', 3, 'portable_bar.jpg'),
(19, 'Champagne Fountain', 9, 1200.00, 'Silver', 'Metal', '3 feet tall', 4, 'champagne_fountain.jpg'),
(20, 'Cotton Candy Machine', 9, 3000.00, 'Pink', 'Metal', 'N/A', 2, 'cotton_candy_machine.jpg'),
(21, 'Popcorn Machine', 9, 3500.00, 'Red', 'Metal and Glass', 'N/A', 3, 'popcorn_machine.jpg'),
(22, 'Photo Booth', 9, 15000.00, 'White', 'Plastic and Metal', 'N/A', 1, 'photo_booth.jpg'),
(23, 'Chocolate Fountain', 9, 5000.00, 'Silver', 'Stainless Steel', 'N/A', 2, 'chocolate_fountain.jpg'),
(24, 'Mini Photo Booth', 9, 1200.00, 'White', 'Plastic and Metal', 'N/A', 5, 'photo_booth.jpg'),
(25, 'Wine Glass', 7, 30.00, 'Clear', 'Glass', '12 ounces', 100, 'wine_glass.jpg'),
(26, 'Champagne Flute', 7, 35.00, 'Clear', 'Glass', '6 ounces', 120, 'champagne_flute.jpg'),
(27, 'Martini Glass', 7, 40.00, 'Clear', 'Glass', '10 ounces', 80, 'martini_glass.jpg'),
(28, 'Water Goblet', 7, 35.00, 'Clear', 'Glass', '14 ounces', 120, 'water_goblet.jpg'),
(29, 'Shot Glass', 7, 20.00, 'Clear', 'Glass', '2 ounces', 200, 'shot_glass.jpg'),
(30, 'Glass Pitcher', 7, 80.00, 'Clear', 'Glass', '60 ounces', 50, 'glass_pitcher.jpg'),
(31, 'Highball Glass', 7, 25.00, 'Clear', 'Glass', '12 ounces', 150, 'highball_glass.jpg'),
(32, 'Tumbler Glass', 7, 30.00, 'Clear', 'Glass', '10 ounces', 130, 'tumbler_glass.jpg'),
(33, 'Gold Flatware Set', 4, 80.00, 'Gold', 'Stainless Steel', 'N/A', 150, 'gold_flatware.jpg'),
(34, 'Silver Flatware Set', 4, 60.00, 'Silver', 'Stainless Steel', 'N/A', 200, 'silver_flatware.jpg'),
(35, 'Dessert Fork', 4, 20.00, 'Silver', 'Stainless Steel', 'N/A', 200, 'dessert_fork.jpg'),
(36, 'Steak Knife', 4, 25.00, 'Silver', 'Stainless Steel', 'N/A', 150, 'steak_knife.jpg'),
(37, 'Soup Spoon', 4, 15.00, 'Silver', 'Stainless Steel', 'N/A', 250, 'soup_spoon.jpg'),
(38, 'Dinner Knife', 4, 25.00, 'Silver', 'Stainless Steel', 'N/A', 200, 'dinner_knife.jpg'),
(39, 'Fish Fork', 4, 15.00, 'Silver', 'Stainless Steel', 'N/A', 250, 'fish_fork.jpg'),
(40, 'Silk Tablecloth', 5, 300.00, 'Red', 'Silk', '90x132 inches', 40, 'silk_tablecloth.jpg'),
(41, 'Lace Table Runner', 5, 200.00, 'White', 'Lace', '12x72 inches', 50, 'lace_table_runner.jpg'),
(42, 'White Table Linen', 5, 150.00, 'White', 'Fabric', '90x132 inches', 60, 'white_table_linen.jpg'),
(43, 'Black Table Linen', 5, 150.00, 'Black', 'Fabric', '90x132 inches', 60, 'black_table_linen.jpg'),
(44, 'Round Tablecloth', 5, 200.00, 'Ivory', 'Polyester', '120 inches diameter', 50, 'round_tablecloth.jpg'),
(45, 'Table Runner', 5, 100.00, 'Various', 'Fabric', '12x72 inches', 50, 'table_runner.jpg'),
(46, 'Cotton Napkin', 5, 15.00, 'White', 'Cotton', '20x20 inches', 300, 'cotton_napkin.jpg'),
(47, 'Linen Napkin', 5, 20.00, 'Red', 'Linen', '20x20 inches', 150, 'linen_napkin.jpg'),
(48, 'Napkins', 5, 10.00, 'Various', 'Fabric', '20x20 inches', 200, 'napkins.jpg'),
(49, 'Wedding Tent', 6, 20000.00, 'White', 'Canvas', '20x40 feet', 3, 'wedding_tent.jpg'),
(50, 'Outdoor Tent', 6, 15000.00, 'White', 'Canvas', '15x30 feet', 4, 'outdoor_tent.jpg'),
(51, 'Gazebo Tent', 6, 25000.00, 'White', 'Canvas', '20x20 feet', 2, 'gazebo_tent.jpg'),
(52, 'Pop-Up Tent', 6, 12000.00, 'Blue', 'Polyester', '10x10 feet', 5, 'pop_up_tent.jpg'),
(53, 'Frame Tent', 6, 27000.00, 'White', 'Canvas', '30x50 feet', 2, 'frame_tent.jpg'),
(54, 'Canopy Tent', 6, 35000.00, 'White', 'Canvas', '40x60 feet', 1, 'canopy_tent.jpg'),
(55, 'Tent Sidewalls', 6, 1000.00, 'White', 'Canvas', '20 feet long', 10, 'tent_sidewalls.jpg'),
(56, 'Luxury Portable Restroom', 6, 50000.00, 'White', 'Plastic and Metal', '8x6x8 feet', 1, 'portable_restroom.jpg'),
(57, 'Glass Vase Centerpiece', 8, 150.00, 'Transparent', 'Glass', '12 inches tall', 30, 'glass_vase.jpg'),
(58, 'Elegant Candelabra', 8, 300.00, 'Silver', 'Metal', '3 feet tall', 15, 'elegant_candelabra.jpg'),
(59, 'Marquee Letters', 8, 1500.00, 'White', 'Metal and Plastic', '2 feet tall', 26, 'marquee_letters.jpg'),
(60, 'Lighted Backdrop', 8, 8000.00, 'White', 'Fabric and Lights', '10x8 feet', 3, 'lighted_backdrop.jpg'),
(61, 'LED Uplight', 8, 300.00, 'Multi-color', 'Plastic', '6x6x8 inches', 50, 'led_uplight.jpg'),
(62, 'Bistro Lights', 8, 400.00, 'Warm White', 'Plastic and Metal', '50 feet', 20, 'bistro_lights.jpg'),
(63, 'String Lights', 8, 500.00, 'Warm White', 'Plastic and Metal', '100 feet', 25, 'string_lights.jpg'),
(64, 'Crystal Chandelier', 8, 15000.00, 'Clear', 'Crystal and Metal', '3 feet diameter', 3, 'crystal_chandelier.jpg'),
(65, 'Decorative Lantern', 8, 250.00, 'Black', 'Metal and Glass', '12 inches tall', 30, 'decorative_lantern.jpg'),
(66, 'Fairy Lights', 8, 300.00, 'Warm White', 'Plastic', '50 feet', 40, 'fairy_lights.jpg'),
(67, 'Disco Ball', 8, 700.00, 'Silver', 'Glass and Metal', '20 inches diameter', 10, 'disco_ball.jpg');

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
(2, 'Maureen Benitez', '09123456789', 'Matagbac, Tabaco City', 'maureenasirit.benitez@bicol-u.edu.ph', '$2y$10$0k5ZaAZotog.FKdL15En9OeO2JQFlolEo5v4Gu6GeqBqemlTUjYoC', 'maureen.png', '@maureen30', 'Female', '2002-05-30'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

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
