-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2024 at 06:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `labourlink`
--

-- --------------------------------------------------------

--
-- Table structure for table `job_seekers`
--

CREATE TABLE `job_seekers` (
  `s_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `hourly_rate` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `skills` text DEFAULT NULL,
  `gender` varchar(30) NOT NULL,
  `ban_end_date` tinyint(1) DEFAULT NULL,
  `permanently_banned` tinyint(1) DEFAULT 0,
  `otp` varchar(6) DEFAULT NULL,
  `ban_start_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_seekers`
--

INSERT INTO `job_seekers` (`s_id`, `first_name`, `last_name`, `job_title`, `email`, `password`, `dob`, `location`, `hourly_rate`, `created_at`, `phone`, `address`, `skills`, `gender`, `ban_end_date`, `permanently_banned`, `otp`, `ban_start_date`) VALUES
(15, 'gopika', 's', 'interior', 'sureshg0pikaal@gmail.com', 'gopika@2003', '1997-10-14', 'vengaloor', 560.00, '2024-09-23 00:11:02', '9951002591', 'Alackal', 'good skill in drawing and designing', 'female', 127, 0, NULL, '2024-10-16 12:17:43'),
(233, 'Augustinina', 'shaji', 'painter', 'augustineshaji007@gmail.com', '123456', '2024-10-11', 'Edadu', 11.00, '2024-10-16 19:27:07', '08458585555', 'Kalapurackal', '4 years of experience in painting', 'female', NULL, 0, NULL, NULL),
(234, 'suresh', 'a v', 'electrician', 'suresh743@gmail.com', 'suresh@1', NULL, 'Thodupuzha', 250.00, '2024-11-13 17:48:52', '9961507612', 'Alackal', 'Good Practice on electronics', 'male', NULL, 0, NULL, NULL),
(235, 'liana', 'S', 'Tailor', 'liyanasalimraj123@gmail.com', 'liana@123', NULL, 'Palakkad', 300.00, '2024-11-13 17:52:00', '9400029321', 'Malik mansil', 'Stiching and Embriodary', 'female', NULL, 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `job_seekers`
--
ALTER TABLE `job_seekers`
  ADD PRIMARY KEY (`s_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `job_seekers`
--
ALTER TABLE `job_seekers`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
