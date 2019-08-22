-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2019 at 05:02 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopping_cart`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `order_datetime` datetime NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `taxable_amount` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `shipping_total` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `total_weight` decimal(10,2) NOT NULL,
  `company_name` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `first_name` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `last_name` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `phone` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `shipping_method` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `shipping_name` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `shipping_address1` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `shipping_address2` varchar(35) COLLATE latin1_general_ci DEFAULT NULL,
  `shipping_address3` varchar(35) COLLATE latin1_general_ci DEFAULT NULL,
  `shipping_city` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `shipping_state` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `shipping_country` varchar(35) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `customer_id`, `order_datetime`, `sub_total`, `taxable_amount`, `discount`, `tax`, `shipping_total`, `total_amount`, `total_weight`, `company_name`, `email`, `first_name`, `last_name`, `phone`, `shipping_method`, `shipping_name`, `shipping_address1`, `shipping_address2`, `shipping_address3`, `shipping_city`, `shipping_state`, `shipping_country`) VALUES
(101, 1, '2008-01-01 09:00:00', '32.00', '7.00', '0.00', '0.70', '25.00', '57.70', '21.00', '', 'frodo@hobbits.com', 'Frodo', 'Baggins', '8881234', 'Ground', 'Frodo Baggins', 'Bag-End, Bagshot Row', '', '', 'Hobbiton', 'The Shire', 'Middle Earth');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(10) UNSIGNED NOT NULL,
  `cart_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `product_id`, `weight`, `qty`, `unit_price`, `price`) VALUES
(111, 101, 1, '10.00', 5, '1.00', '5.00'),
(112, 101, 2, '10.00', 100, '0.20', '20.00'),
(113, 101, 3, '1.00', 1, '7.00', '7.00'),
(114, 102, 2, '10.00', 100, '0.20', '20.00');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `company_name` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `first_name` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `last_name` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `phone` varchar(20) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `email`, `password`, `company_name`, `first_name`, `last_name`, `phone`) VALUES
(1, 'frodo@hobbits.com', 'default1', '', 'Frodo', 'Baggins', '8881234'),
(2, 'gandalf@wizards.com', 'default1', 'Wizards of the First Order', 'Gandalf', 'Grey', '1234567'),
(3, 'peter@weta.com', 'default1', 'Weta Digital', 'Peter', 'Jackson', '6443809080');

-- --------------------------------------------------------

--
-- Table structure for table `job_items`
--

CREATE TABLE `job_items` (
  `job_item_id` int(10) UNSIGNED NOT NULL,
  `job_order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `job_items`
--

INSERT INTO `job_items` (`job_item_id`, `job_order_id`, `product_id`, `weight`, `qty`, `unit_price`, `price`) VALUES
(1, 1, 1, '10.00', 5, '1.00', '5.00'),
(2, 1, 2, '10.00', 100, '0.20', '20.00'),
(3, 1, 3, '1.00', 1, '7.00', '7.00'),
(4, 2, 2, '10.00', 100, '0.20', '20.00'),
(5, 3, 3, '10.00', 10, '7.00', '70.00'),
(6, 3, 1, '20.00', 10, '1.00', '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `job_orders`
--

CREATE TABLE `job_orders` (
  `job_order_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `order_datetime` datetime NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `taxable_amount` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `shipping_total` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `total_weight` decimal(10,2) NOT NULL,
  `company_name` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `first_name` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `last_name` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `phone` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `shipping_method` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `shipping_name` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `shipping_address1` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `shipping_address2` varchar(35) COLLATE latin1_general_ci DEFAULT NULL,
  `shipping_address3` varchar(35) COLLATE latin1_general_ci DEFAULT NULL,
  `shipping_city` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `shipping_state` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `shipping_country` varchar(35) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `job_orders`
--

INSERT INTO `job_orders` (`job_order_id`, `customer_id`, `order_datetime`, `sub_total`, `taxable_amount`, `discount`, `tax`, `shipping_total`, `total_amount`, `total_weight`, `company_name`, `email`, `first_name`, `last_name`, `phone`, `shipping_method`, `shipping_name`, `shipping_address1`, `shipping_address2`, `shipping_address3`, `shipping_city`, `shipping_state`, `shipping_country`) VALUES
(1, 1, '2008-01-01 09:00:00', '32.00', '7.00', '0.00', '0.70', '25.00', '57.70', '21.00', '', 'frodo@hobbits.com', 'Frodo', 'Baggins', '8881234', 'Ground', 'Frodo Baggins', 'Bag-End, Bagshot Row', '', '', 'Hobbiton', 'The Shire', 'Middle Earth'),
(2, 1, '2008-01-01 09:00:01', '20.00', '0.00', '0.00', '0.00', '12.00', '32.00', '10.00', '', 'frodo@hobbits.com', 'Frodo', 'Baggins', '8881234', 'Ground', 'Gollum', 'Great Goblin\'s Cavern', '', '', 'Goblin Town', 'Misty Mountain', 'Middle Earth'),
(3, 3, '2008-01-01 09:00:02', '80.00', '70.00', '10.00', '7.00', '30.00', '107.00', '30.00', 'Weta Digital', 'peter@weta.com', 'Peter', 'Jackson', '6443809080', 'Expedited', 'Fran Walsh', '9-11 Manuka Street', '', '', 'Miramar', 'Wellington', 'New Zealand');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `product_desc` text COLLATE latin1_general_ci DEFAULT NULL,
  `product_image` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `product_thumbnail` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `weight` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_qty` int(11) UNSIGNED NOT NULL,
  `taxable_flag` char(1) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_desc`, `product_image`, `product_thumbnail`, `weight`, `price`, `stock_qty`, `taxable_flag`) VALUES
(1, 'Rock', 'Hardest rocks quarried from the foot of Mount Doom.', '/img/rock.png', '/img/rock_thumb.png', '2.00', '1.00', 100, 'n'),
(2, 'Paper', 'Finest papers made from barks of centuries-old Ents.', '/img/paper.png', '/img/paper_thumb.png', '0.10', '0.20', 1000, 'n'),
(3, 'Scissor', 'Sharpest pair of scissors forged from the shards of Narsil.', '/img/scissors.png', '/img/scissors_thumb.png', '1.00', '7.00', 20, 'y');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `shipping_id` smallint(5) UNSIGNED NOT NULL,
  `min_weight` decimal(10,2) NOT NULL,
  `max_weight` decimal(10,2) NOT NULL,
  `shipping_method` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `shipping_rate` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`shipping_id`, `min_weight`, `max_weight`, `shipping_method`, `shipping_rate`) VALUES
(1, '0.00', '5.00', 'Ground', '8.00'),
(2, '6.00', '10.00', 'Ground', '12.00'),
(3, '11.00', '20.00', 'Ground', '18.00'),
(4, '21.00', '40.00', 'Ground', '25.00'),
(5, '0.00', '5.00', 'Expedited', '12.00'),
(6, '6.00', '10.00', 'Expedited', '15.00'),
(7, '11.00', '20.00', 'Expedited', '22.00'),
(8, '21.00', '40.00', 'Expedited', '30.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `job_items`
--
ALTER TABLE `job_items`
  ADD PRIMARY KEY (`job_item_id`);

--
-- Indexes for table `job_orders`
--
ALTER TABLE `job_orders`
  ADD PRIMARY KEY (`job_order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_name` (`product_name`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`shipping_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `job_items`
--
ALTER TABLE `job_items`
  MODIFY `job_item_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `job_orders`
--
ALTER TABLE `job_orders`
  MODIFY `job_order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `shipping_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
