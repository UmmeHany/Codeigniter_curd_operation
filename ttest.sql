-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2018 at 02:22 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ttest`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` varchar(255) NOT NULL,
  `b_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `b_name`) VALUES
('b11', 'puma'),
('b22', 'MSN'),
('b33', 'Levis'),
('b44', 'maskand'),
('b55', 'puma');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand_id` varchar(255) NOT NULL,
  `model_id` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `brand_id`, `model_id`, `date_added`) VALUES
('a11', 'puma t shirt', 'b11', 'm11', '2018-02-11 00:57:33'),
('a22', 'msn polo shirt', 'b22', 'm22', '2018-02-11 01:04:35'),
('a33', 'levis denim pant', 'b33', 'm33', '2018-02-11 01:05:37'),
('a44', 'maskand tank top', 'b44', 'm44', '2018-02-11 01:06:26'),
('a55', 'puma ladies jacket ', 'b55', 'm55', '2018-02-11 01:08:03');

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `model_id` varchar(255) NOT NULL,
  `brand_id` varchar(255) NOT NULL,
  `m_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`model_id`, `brand_id`, `m_name`) VALUES
('m11', 'b11', 't shirt'),
('m22', 'b22', 'polo shirt'),
('m33', 'b33', 'denim pant'),
('m44', 'b44', 'tank top'),
('m55', 'b55', 'ladies jacket');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
