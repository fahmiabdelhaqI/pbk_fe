-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 18, 2019 at 06:30 AM
-- Server version: 10.1.39-MariaDB
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pbk_scoring_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `member_code` varchar(30) DEFAULT NULL,
  `member_name` varchar(255) DEFAULT NULL,
  `active_flag` char(1) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `member_code`, `member_name`, `active_flag`, `image`) VALUES
(1, 'BCA', 'Bank Central Asia', 'Y', NULL),
(2, 'BRI', 'Bank Rakyat Indonesia', 'Y', NULL),
(3, 'BNI', 'Bank Negara Indonesia', 'Y', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `endpoint_tradisional` text,
  `endpoint_ai` text,
  `endpoint_bre` text,
  `base_score` float DEFAULT NULL,
  `icons` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `nama`, `endpoint_tradisional`, `endpoint_ai`, `endpoint_bre`, `base_score`, `icons`) VALUES
(1, 'E-Commerce', NULL, NULL, NULL, 300, 'fa-shopping-bag'),
(2, 'Telco', '/tb/telco', '/ai/telco', '/bre/telco', 250, 'fa-mobile-alt'),
(3, 'Credit', NULL, NULL, NULL, 200, 'fa-credit-card');

-- --------------------------------------------------------

--
-- Table structure for table `model_parameters`
--

CREATE TABLE `model_parameters` (
  `id` int(11) NOT NULL,
  `parameter` varchar(100) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `tipe_data` varchar(50) DEFAULT NULL,
  `is_web` char(1) DEFAULT NULL,
  `id_model` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `model_parameters`
--

INSERT INTO `model_parameters` (`id`, `parameter`, `label`, `tipe_data`, `is_web`, `id_model`) VALUES
(1, 'cust_id', 'Customer ID', 'STRING', 'N', 1),
(4, 'gender', 'Gender', 'STRING', 'N', 1),
(5, 'Date of Birth', 'Date of Birth', 'DATETIME', 'A', 1),
(6, 'phone_no', 'Phone Number', 'STRING', 'Y', 1),
(7, 'email', 'Email', 'STRING', 'N', 1),
(8, '2_digit_zip_code_address', 'Zip Code', 'STRING', 'N', 1),
(9, 'transaction_date_min', 'Date Transaction Minimum', 'DATETIME', 'N', 1),
(10, 'transaction_date_max', 'Date Transaction Maximum', 'DATETIME', 'N', 1),
(11, 'full_name', 'Full Name', 'STRING', 'Y', 1),
(12, 'phone_no', 'Phone Number', 'STRING', 'Y', 2),
(15, 'test_params_1', 'Test Parameter 1', 'STRING', 'N', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parameter_details`
--

CREATE TABLE `parameter_details` (
  `id` int(11) NOT NULL,
  `sequence` int(11) DEFAULT NULL,
  `operator` varchar(255) DEFAULT NULL,
  `start_value` float DEFAULT NULL,
  `end_value` float DEFAULT NULL,
  `like_value` varchar(255) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `reason_code` varchar(255) DEFAULT NULL,
  `id_model_parameter` int(11) DEFAULT NULL,
  `id_reason_code` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reasons`
--

CREATE TABLE `reasons` (
  `id` int(11) NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reasons`
--

INSERT INTO `reasons` (`id`, `code`, `description`) VALUES
(1, 'INTL2', 'Kurang dari 2 menit');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `role_code` varchar(30) DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL,
  `id_member` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role_code`, `ip_address`, `id_member`) VALUES
(1, 'Pefindo Admin', 'pefindo', 'c7b557751602c9cfbafd0b93086621df', 'superadmin', '192.168.20.75', NULL),
(2, 'BCA Key User 1', 'bcakeyuser1', 'f6d9e73fba8edbeeb6f700d0df65e111', 'keyuser', NULL, 1),
(3, 'BBBB', 'bbbb', '65ba841e01d6db7733e90a5b7f9e6f80', 'keyuser', '192.168.20.96', 1),
(4, 'BCA User 1', 'bcauser1', '310f551e8c8e09bd7117849807ee4686', 'user', NULL, 1),
(6, 'BCA Key User 2', 'bcauser2', '301c311b72d1553ce7d2a4211880f072', 'keyuser', NULL, 1),
(7, 'BCA User 3', 'bcauser3', 'dbb1ecdb9ab9c89e7438abe9b5ec625d', 'user', NULL, 1),
(9, 'Raka Admiral A', 'rakaflyhigh', '69e86d0eea6974a7585c916284b0da4b', 'keyuser', '114.124.147.161', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_parameters`
--
ALTER TABLE `model_parameters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mp_1` (`id_model`);

--
-- Indexes for table `parameter_details`
--
ALTER TABLE `parameter_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pd_fk_1` (`id_model_parameter`),
  ADD KEY `pd_fk_2` (`id_reason_code`);

--
-- Indexes for table `reasons`
--
ALTER TABLE `reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_1` (`id_member`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `model_parameters`
--
ALTER TABLE `model_parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `parameter_details`
--
ALTER TABLE `parameter_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reasons`
--
ALTER TABLE `reasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_parameters`
--
ALTER TABLE `model_parameters`
  ADD CONSTRAINT `fk_mp_1` FOREIGN KEY (`id_model`) REFERENCES `models` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parameter_details`
--
ALTER TABLE `parameter_details`
  ADD CONSTRAINT `pd_fk_1` FOREIGN KEY (`id_model_parameter`) REFERENCES `model_parameters` (`id`),
  ADD CONSTRAINT `pd_fk_2` FOREIGN KEY (`id_reason_code`) REFERENCES `reasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_1` FOREIGN KEY (`id_member`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
