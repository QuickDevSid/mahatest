-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2024 at 07:02 AM
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
-- Table structure for table `current_affair_setting`
--

CREATE TABLE `current_affair_setting` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `icon_img` varchar(100) NOT NULL,
  `section_title_1` varchar(100) NOT NULL,
  `section_title_2` varchar(100) NOT NULL,
  `section_title_3` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `current_affair_setting`
--

INSERT INTO `current_affair_setting` (`id`, `title`, `subtitle`, `icon_img`, `section_title_1`, `section_title_2`, `section_title_3`, `created_at`, `updated_at`) VALUES
(1, 'Current Affairs', 'abc,qwe,eee', 'exam_material_icon_2_1706699120.png', 'Category wise', 'Year wise', 'Recent', '2024-01-28 14:21:39', '2024-01-28 14:21:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `current_affair_setting`
--
ALTER TABLE `current_affair_setting`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `current_affair_setting`
--
ALTER TABLE `current_affair_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
