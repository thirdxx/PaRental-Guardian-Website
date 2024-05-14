-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2024 at 06:08 PM
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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `payment` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `date`, `address`, `payment`, `price`, `status_id`, `name`, `note`, `phone`, `email`) VALUES
(1, 2, '2024-05-13 22:12:55', 'Tabaco, Panal, Zone 3, 4511', 'cash_on_delivery', 690.00, NULL, NULL, NULL, NULL, NULL),
(2, 2, '2024-05-13 22:25:08', 'Tabaco, Panal, Zone 3, 4511', 'cash_on_delivery', 0.00, NULL, '0', 'red gate', '09123456789', 'maureenasirit.benitez@bicol-u.edu.ph'),
(3, 2, '2024-05-13 22:40:36', 'Tabaco, Panal, Zone 3, 4511', 'paypal', 0.00, NULL, '0', 'in front of red gate', '09123456789', 'maureenasirit.benitez@bicol-u.edu.ph'),
(4, 2, '2024-05-13 23:10:55', 'Tiwi, Tigbi, 9, 4513', 'cash_on_delivery', 0.00, NULL, '0', '', '09123456789', 'maureenasirit.benitez@bicol-u.edu.ph'),
(5, 2, '2024-05-13 23:19:19', 'Tabaco, Panal, Zone3, 4511', 'cash_on_delivery', 0.00, NULL, '0', '', '09123456789', 'maureenasirit.benitez@bicol-u.edu.ph'),
(6, 2, '2024-05-13 23:44:03', 'A, aa, aaa, aaa', 'credit_card', 170.00, NULL, '0', '', '09123456789', 'maureenasirit.benitez@bicol-u.edu.ph'),
(7, 2, '2024-05-13 23:45:48', 'A, aa, aa, aaa', 'paypal', 90.00, NULL, '0', '', '09123456789', 'maureenasirit.benitez@bicol-u.edu.ph'),
(8, NULL, '2024-05-13 23:51:49', 'A, a, aa, aaa', 'bank_transfer', 180.00, NULL, '0', '', '09123456789', 'maureenasirit.benitez@bicol-u.edu.ph');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
