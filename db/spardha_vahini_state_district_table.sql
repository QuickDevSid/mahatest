-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2024 at 05:44 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spardha_vahini`
--

-- --------------------------------------------------------

--
-- Table structure for table `district_list`
--

CREATE TABLE `district_list` (
  `district_id` int(11) NOT NULL,
  `district_name` text DEFAULT NULL,
  `status` text DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `district_list`
--

INSERT INTO `district_list` (`district_id`, `district_name`, `status`, `created_on`, `state_id`) VALUES
(1, 'Chatrapati Sambhajinagar', 'Active', '2024-01-10 19:18:44', 14),
(2, 'Nanded', 'Active', '2024-01-10 19:18:44', 14);

-- --------------------------------------------------------

--
-- Table structure for table `state_list`
--

CREATE TABLE `state_list` (
  `state_id` int(11) NOT NULL,
  `state_name` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `state_list`
--

INSERT INTO `state_list` (`state_id`, `state_name`, `status`, `created_on`) VALUES
(1, 'Andhra Pradesh', 'Active', '2021-04-17 04:53:45'),
(2, 'Arunachal Pradesh', 'Active', '2021-04-17 04:53:45'),
(3, 'Assam', 'Active', '2021-04-17 04:54:45'),
(4, 'Bihar', 'Active', '2021-04-17 04:54:45'),
(5, 'Chhattisgarh', 'Active', '2021-04-17 04:54:45'),
(6, 'Goa ', 'Active', '2021-04-17 04:54:45'),
(8, 'Haryana', 'Active', '2021-04-17 04:54:45'),
(9, 'Himachal Pradesh ', 'Active', '2021-04-17 04:54:45'),
(10, 'Jharkhand', 'Active', '2021-04-17 04:54:45'),
(11, 'Karnataka', 'Active', '2021-04-17 04:54:45'),
(12, 'Kerala', 'Active', '2021-04-17 04:54:45'),
(13, 'Madhya Pradesh ', 'Active', '2021-04-17 04:54:45'),
(14, 'Maharashtra', 'Active', '2021-04-17 04:54:45'),
(15, 'Manipur', '', '2021-04-17 04:57:15'),
(16, 'Meghalaya', 'Active', '2021-04-17 04:58:24'),
(17, 'Mizoram', 'Active', '2021-04-17 04:58:24'),
(18, 'Nagaland', 'Active', '2021-04-17 04:58:24'),
(19, 'Odisha', 'Active', '2021-04-17 04:58:24'),
(20, 'Punjab', 'Active', '2021-04-17 04:58:24'),
(21, 'Rajasthan', 'Active', '2021-04-17 04:58:24'),
(22, 'Sikkim', 'Active', '2021-04-17 04:58:24'),
(23, 'Tamil Nadu ', 'Active', '2021-04-17 04:58:24'),
(24, 'Telangana', 'Active', '2021-04-17 04:58:24'),
(25, 'Tripura', 'Active', '2021-04-17 04:58:24'),
(26, 'Uttar Pradesh ', 'Active', '2021-04-17 04:58:24'),
(27, 'Uttarakhand', 'Active', '2021-04-17 04:58:24'),
(28, 'West Bengal ', 'Active', '2021-04-17 04:58:24'),
(29, 'Andaman and Nicobar Islands ', 'Active', '2021-04-17 04:58:24'),
(30, 'Chandigarh ', 'Active', '2021-04-17 04:58:24'),
(31, 'Dadra and Nagar Haveli and Daman and Diu ', 'Active', '2021-04-17 04:58:24'),
(32, 'Jammu and Kashmir ', 'Active', '2021-04-17 04:58:24'),
(33, 'Ladakh ', 'Active', '2021-04-17 04:58:24'),
(34, 'Lakshadweep ', 'Active', '2021-04-17 04:58:24'),
(35, 'Delhi ', 'Active', '2021-04-17 04:58:24'),
(36, 'Puducherry ', 'Active', '2021-04-17 04:58:24'),
(37, '', '', '2021-04-17 04:58:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `district_list`
--
ALTER TABLE `district_list`
  ADD PRIMARY KEY (`district_id`);

--
-- Indexes for table `state_list`
--
ALTER TABLE `state_list`
  ADD PRIMARY KEY (`state_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `district_list`
--
ALTER TABLE `district_list`
  MODIFY `district_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `state_list`
--
ALTER TABLE `state_list`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
