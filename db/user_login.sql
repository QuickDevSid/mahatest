-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2024 at 10:37 AM
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
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `login_id` int(11) NOT NULL,
  `full_name` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `mobile_number` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `gender` text DEFAULT NULL,
  `profile_image` text DEFAULT NULL,
  `selected_exams` text DEFAULT NULL,
  `selected_exams_id` text DEFAULT NULL,
  `login_type` text DEFAULT NULL,
  `device_id` text DEFAULT NULL,
  `place` text DEFAULT NULL,
  `status` text DEFAULT NULL,
  `created_on` datetime DEFAULT current_timestamp(),
  `state_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `last_user_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`login_id`, `full_name`, `email`, `mobile_number`, `password`, `gender`, `profile_image`, `selected_exams`, `selected_exams_id`, `login_type`, `device_id`, `place`, `status`, `created_on`, `state_id`, `district_id`, `last_user_login`) VALUES
(1, 'Pallavi Jaiswal', 'pallavi@gmail.com', '9898986666', NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-12 15:04:22', 14, 1, NULL),
(2, 'Komal Jaiswal', 'komal@gmail.com', '9898989898', NULL, 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-12 15:05:40', 14, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`login_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
