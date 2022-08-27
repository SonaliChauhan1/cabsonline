-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2020 at 02:06 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `customer_information`
--
CREATE DATABASE IF NOT EXISTS `customer_information` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `customer_information`;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--
-- Creation: Mar 22, 2020 at 03:04 AM
--

CREATE TABLE `customer` (
  `customer_name` varchar(225) NOT NULL,
  `email_id` varchar(225) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_number` int(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `customer`:
--

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_name`, `email_id`, `password`, `contact_number`, `created_at`, `updated_at`) VALUES
('a', 'a@gmail.com', '0cc175b9c0', 2147483647, '2020-03-21 16:12:11', '2020-03-21 23:12:11'),
('Sonali', 'sonali@gmail', '900150983cd24fb0d6963f7d28e17f72', 123456789, '2020-03-21 19:26:17', '2020-03-22 02:26:17'),
('vru', 'v@gmail.com', '92eb5ffee6ae2fec3ad71c777531578f', 456124522, '2020-03-21 19:43:41', '2020-03-22 02:43:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`email_id`);


--
-- Metadata
--
USE `phpmyadmin`;

--
-- Metadata for table customer
--

--
-- Metadata for database customer_information
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
