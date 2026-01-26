-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2025 at 10:22 AM
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
-- Database: `pro`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `a_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`a_id`, `username`, `password`) VALUES
(1, 'parth', '1210');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `c_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `c_name` varchar(100) NOT NULL,
  `c_image` varchar(255) NOT NULL,
  `c_quantity` int(100) NOT NULL DEFAULT 1,
  `c_price` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `f_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `f_name` varchar(200) NOT NULL,
  `f_email` varchar(100) NOT NULL,
  `f_subject` varchar(100) NOT NULL,
  `f_txt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `o_name` varchar(100) NOT NULL,
  `o_email` varchar(100) NOT NULL,
  `o_mobile` int(10) NOT NULL,
  `o_address` varchar(200) NOT NULL,
  `o_pincode` int(6) NOT NULL,
  `o_city` varchar(50) NOT NULL,
  `o_state` varchar(50) NOT NULL,
  `o_price` float(10,2) NOT NULL,
  `o_quantity` int(200) NOT NULL,
  `o_pname` varchar(200) NOT NULL,
  `o_pimg` varchar(255) NOT NULL,
  `o_date` date NOT NULL,
  `o_payment_method` varchar(50) NOT NULL,
  `o_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(100) NOT NULL,
  `p_price_ori` float(10,2) NOT NULL,
  `p_price_des` float(10,2) NOT NULL,
  `p_image` varchar(255) NOT NULL,
  `p_quantity` int(100) NOT NULL,
  `p_description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`p_id`, `p_name`, `p_price_ori`, `p_price_des`, `p_image`, `p_quantity`, `p_description`) VALUES
(1, 'Park Avenue Euphoria,100ml ', 353.00, 320.00, 'park 2.jpeg', 50, 'Park Avenue Euphoria,100ml ,Gift for valentine day,premium luxury fragrance scent,long lasting smell'),
(2, 'Wild Stone Ultra', 333.00, 316.00, 'wild stone 2.jpeg', 50, 'Wild Stone Ultra sensual long lasting perfume for men,100ml,aromatic of masculine fragrances'),
(3, 'Denver Hamliton Perfume-100ml', 420.00, 380.00, 'danver.jpeg', 50, 'Denver Hamliton Perfume-100ml,long lasting perfume body scent for man,fresh'),
(4, 'Beardo Legend Perfume-100ml', 574.00, 519.00, 'legend berado.jpeg', 50, 'Beardo Legend Perfume-100ml,Eau De perfume,strong long lasting perfume,gift for man'),
(5, 'Embark My Life For Him-100ml', 708.00, 641.00, 'embark.jpeg', 50, 'Embark My Life For Him-100ml,liquid perfume for man-100ml,premium eau de perfume,ambery and citrus fragrance'),
(6, 'Beardo Godfather Perfume For man-50ml', 222.00, 201.00, 'berado.jpeg', 50, 'Beardo Godfather Perfume For man-50ml,aromatic,spicy perfume lon lasting perfume for date night fragrances,body spray for man'),
(7, 'The Man Company Destiny Perfume For Man-100ml', 523.00, 474.00, 'destiny.jpeg', 50, 'The Man Company Destiny Perfume For Man-100ml,premium long lasting fragrances'),
(8, 'Bella Vita Luxury CEO Man Eau De Perfume-100ml', 523.00, 474.00, 'bellvita.jpeg', 50, 'Bella Vita Luxury CEO Man Eau De Perfume with lemon,lavender,tonka | premium long lasting woody fragrances for man'),
(9, 'Djokr On The Rocks Perfume For Man 100ml', 497.00, 450.00, 'djoker.jpeg', 50, 'Djokr On The Rocks Perfume For Man 100ml,eau de perfume,premium luxury long lasting fragrance spray'),
(10, 'Park Avenue Voyage Obsession Signature Collection 50ml', 187.00, 170.00, 'park.jpeg', 50, 'Park Avenue Voyage Obsession Signature Collection 50ml,Eau de perfume | long lasting perfume for man'),
(11, 'Wild Stone Edge Perfume For Man 50ml', 208.00, 189.00, 'wild stone.jpeg', 50, 'Wild Stone Edge Perfume For Man 50ml | Long lasting perfume for man'),
(12, 'Embark My Story For Him Liquid Perfume For Man 100ml', 1464.00, 1325.00, 'embark2.jpeg', 50, 'Embark My Story For Him Liquid Perfume For Man 100ml,Premium Eau de perfume');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `u_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `confirm_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `c_id` (`c_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `register` (`u_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`p_id`) REFERENCES `product` (`p_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `register` (`u_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `register` (`u_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`c_id`) REFERENCES `cart` (`c_id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`p_id`) REFERENCES `product` (`p_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
