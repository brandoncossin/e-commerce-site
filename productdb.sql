-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2021 at 06:05 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `productdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `producttb`
--

CREATE TABLE `producttb` (
  `id` int(11) NOT NULL,
  `product_name` varchar(25) NOT NULL,
  `product_price` float DEFAULT NULL,
  `product_image` varchar(100) DEFAULT NULL,
  `brand` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `producttb`
--

INSERT INTO `producttb` (`id`, `product_name`, `product_price`, `product_image`, `brand`) VALUES
(1, 'Apple Macbook Pro', 1799, './upload/product1.png', 'Apple'),
(2, 'Apple Mac Pro', 5999, './upload/product2.png', 'Apple'),
(3, 'iPad Air', 749, './upload/product3.png', 'Apple'),
(4, 'iPad Pro', 1099, './upload/product4.png', 'Apple'),
(5, 'iPod', 299, './upload/product5.png', 'Apple'),
(6, 'iPhone Xr', 499, './upload/product6.png', 'Apple'),
(7, 'Airpod Pro', 249, './upload/product7.png', 'Apple'),
(8, 'Apple Watch Series 3', 199, './upload/product8.png', 'Apple'),
(9, 'HomePod', 299, './upload/product9.png', 'Apple'),
(10, 'Samsung Galaxy S21', 899, './upload/product10.png', 'Samsung'),
(11, 'Galaxy Chromebook 2', 549, './upload/product11.png', 'Samsung'),
(12, 'Galaxy Buds Pro', 199, './upload/product12.png', 'Samsung'),
(13, 'Galaxy Note20 5G', 999, './upload/product13.png', 'Samsung'),
(14, 'Galaxy Tab S7', 649, './upload/product14.png', 'Samsung'),
(15, 'Surface Duo', 1099, './upload/product15.png', 'Microsoft'),
(16, 'Surface Headphones', 249, './upload/product16.png', 'Microsoft');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usersID` int(11) NOT NULL,
  `usersName` varchar(128) NOT NULL,
  `usersEmail` varchar(128) NOT NULL,
  `usersUid` varchar(128) NOT NULL,
  `usersPwd` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `producttb`
--
ALTER TABLE `producttb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usersID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `producttb`
--
ALTER TABLE `producttb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
