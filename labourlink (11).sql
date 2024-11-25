-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2024 at 06:22 PM
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
-- Database: `labourlink`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_reg`
--

CREATE TABLE `admin_reg` (
  `mail` varchar(100) NOT NULL,
  `password` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_reg`
--

INSERT INTO `admin_reg` (`mail`, `password`) VALUES
('0', '0'),
('0', '0'),
('admin@gmail.com', 'admin@12');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `complainer_email` varchar(255) NOT NULL,
  `complainer_role` varchar(50) NOT NULL,
  `complained_against_email` varchar(255) NOT NULL,
  `complaint` text NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `complainer_email`, `complainer_role`, `complained_against_email`, `complaint`, `rating`, `created_at`) VALUES
(1, 'augustineshaji007@gmail.com', 'seeker', 'augustineshaji007@gmail.com', 'not coming to work', 1, '2024-10-16 20:28:27'),
(2, 'augustineshaji007@gmail.com', 'seeker', 'augustineshaji007@gmail.com', 'not coming to work', 1, '2024-10-16 20:28:35'),
(3, 'augustineshaji007@gmail.com', 'seeker', 'augustineshaji007@gmail.com', 'not coming to work', 1, '2024-10-16 20:28:38'),
(4, 'augustineshaji007@gmail.com', 'seeker', 'augustineshaji007@gmail.com', 'not coming to work', 1, '2024-10-16 20:28:40'),
(5, 'augustineshaji007@gmail.com', 'seeker', 'augustineshaji007@gmail.com', 'not coming to work', 1, '2024-10-16 20:28:42'),
(6, 'augustineshaji007@gmail.com', 'seeker', 'augustineshaji007@gmail.com', 'not coming to work', 1, '2024-10-16 20:28:45'),
(7, 'augustineshaji007@gmail.com', 'seeker', 'augustineshaji005@gmail.com', 'not coming to work', 1, '2024-10-16 20:38:07');

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

CREATE TABLE `job_postings` (
  `job_id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `skills_required` text NOT NULL,
  `openings` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `hours` int(11) NOT NULL,
  `wage` decimal(10,2) NOT NULL,
  `posted_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'gopika', 'suersh', 'painter', 'gopika12@gmail.com', '$2y$10$OJrZbacZ5UkVVmEodiXCIu5R.PEHeyyoI1BKyHYI9QJVATyO9QkBy', NULL, 'kochi', 100.00, '2024-09-08 07:27:13', '', '', NULL, '', 127, 0, NULL, '2024-10-16 12:21:10'),
(4, 'gopika', 'suersh', 'painter', 'sureshgopikaal@gmail.com', '$2y$10$.4Sg4h.qyAU49JA4BmeeY.nt09N39tpdLht0GBtirHtusPSYL1UgG', NULL, 'kochi', 100.00, '2024-09-08 07:35:07', '', '', NULL, '', NULL, 0, NULL, NULL),
(5, 'hyma', 'suersh', 'carpenter', 'hyma12@gmail.com', '$2y$10$BrZyNSVnvVf.G5GZ7EDvk.qSVE/WsJ9pM6vz9S0F1oWDXn7IMvkWa', NULL, 'kochi', 100.00, '2024-09-08 07:38:38', '', '', NULL, '', NULL, 0, NULL, NULL),
(6, 'gouri', 's', 'interior', 'gouri@gmail.com', '$2y$10$qQTSF2SwvgY536lnv9kyieBxv1J8QpWIjbXyUJxd.4XRNFKDLN5G.', NULL, 'idukki', 150.00, '2024-09-08 07:40:23', '', '', NULL, '', NULL, 0, NULL, NULL),
(7, 'liana', 's', 'tailor', 'liana@gmail.com', 'liana@12', NULL, 'palakkad', 100.00, '2024-09-08 07:55:05', '', '', NULL, '', NULL, 0, NULL, NULL),
(8, 'liana', 's', 'tailor', 'liana1@gmail.com', 'liana@12', NULL, 'palakkad', 100.00, '2024-09-08 07:55:54', '', 'nmnb', 'bn', '', 127, 0, NULL, '2024-10-17 00:28:24'),
(9, 'gopika', 'suersh', 'carpenter', 'gopikasuresh@gmail.com', 'gopika212', '1999-08-18', 'thos', 150.00, '2024-09-18 16:15:30', '7592945712', '0', 'kj', 'female', 127, 0, NULL, '2024-10-16 12:17:20'),
(10, 'gopika', 'suersh', 'carpenter', 'gopikasuresh12@gmail.com', 'gopika@1', '1999-08-18', 'thos', 150.00, '2024-09-18 16:16:53', '7592945712', 'al', 'kj', 'female', NULL, 0, NULL, NULL),
(11, 'gowrika', 'suresh', 'tailor', 'gowrika12@gmail.com', 'gowrika@1', '2004-01-05', 'nedumkandam', 500.00, '2024-09-22 16:30:13', '8921038696', '0', 'bbhhb', 'female', NULL, 0, NULL, NULL),
(12, 'chithra', 'saji', 'interior', 'chithra1@gmail.com', 'chithra@1', '1995-10-14', 'vengaloor', 550.00, '2024-09-22 22:55:09', '9961002591', '0', 'njnjnj', 'female', NULL, 0, NULL, NULL),
(14, 'chithra', 'saji', 'interior', 'hymas743@gmail.com', 'chithra@1', '1995-10-14', 'vengaloor', 550.00, '2024-09-22 23:03:43', '9961002591', '0', 'njnjnj', 'female', NULL, 1, NULL, NULL),
(15, 'gopika', 's', 'interior', 'sureshg0pikaal@gmail.com', 'gopika@2003', '1997-10-14', 'vengaloor', 560.00, '2024-09-23 00:11:02', '9951002591', '0', 'njnjnjjnjnj', 'female', 127, 0, NULL, '2024-10-16 12:17:43'),
(16, 'suresh', 's', 'interior', 'avsuresh877@gmail.com', 'suresh@12', '1997-10-14', 'vengaloor', 560.00, '2024-09-23 00:13:31', '9951002591', '0', 'njnjnjjnjnj', 'female', NULL, 1, NULL, NULL),
(230, 'dd', 'dd', 'fff', 'qqqq', '123', '2024-10-01', 'ww', 11.00, '2024-10-21 21:47:25', '1111', '2333', '3333', '', NULL, 1, NULL, NULL),
(233, 'Augustine', 'shaji', 'painter', 'augustineshaji007@gmail.com', '123456', '2024-10-11', 'cc', 11.00, '2024-10-16 19:27:07', '08458585555', '0', 'kkk', 'female', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `one_star_ratings`
--

CREATE TABLE `one_star_ratings` (
  `id` int(11) NOT NULL,
  `complained_against_email` varchar(255) DEFAULT NULL,
  `one_star_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `one_star_ratings`
--

INSERT INTO `one_star_ratings` (`id`, `complained_against_email`, `one_star_count`) VALUES
(1, 'recruiter1@example.com', 5),
(2, 'recruiter2@example.com', 3),
(3, 'recruiter3@example.com', 4),
(4, 'recruiter4@example.com', 2),
(5, 'recruiter5@example.com', 6),
(6, 'recruiter6@example.com', 7),
(7, 'recruiter7@example.com', 3),
(8, 'recruiter8@example.com', 5),
(9, 'recruiter9@example.com', 4),
(10, 'recruiter10@example.com', 3),
(11, 'recruiter11@example.com', 6),
(12, 'recruiter12@example.com', 5),
(13, 'recruiter13@example.com', 4),
(14, 'recruiter14@example.com', 7),
(15, 'recruiter15@example.com', 2);

-- --------------------------------------------------------

--
-- Table structure for table `recruiter_messages`
--

CREATE TABLE `recruiter_messages` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recruiter_messages`
--

INSERT INTO `recruiter_messages` (`id`, `email`, `message`, `sent_at`) VALUES
(1, 'jinix@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-13 19:36:17'),
(2, 'jinix@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-13 19:37:47'),
(3, 'jinix@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-13 19:37:51'),
(4, 'jinix@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-13 19:44:34'),
(5, 'jinix@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-13 19:44:41'),
(6, 'jinix@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-14 05:40:32'),
(7, 'rajan@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-14 05:45:58'),
(8, 'jinix@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-14 05:48:52'),
(9, 'liana@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-14 06:23:41'),
(10, 'rajan@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-14 06:23:54'),
(11, 'steffy@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-14 06:25:10'),
(12, 'sunimon@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-14 06:26:31'),
(13, 'baaalu@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-14 06:42:02'),
(14, 'baaalu@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-14 19:18:56'),
(15, 'baaalu@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-14 19:19:12'),
(16, 'baaalu@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-14 19:19:23'),
(17, 'baaalu@gmail.com', 'Dear labour link user, we have decided to ban you for 2 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 2-day ban starting from today. Have a good day.', '2024-06-14 19:29:25'),
(18, 'baaalu@gmail.com', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-14 19:34:53'),
(19, 'augustineshaji007@gm', 'Dear labour link user, we have decided to ban you for 10 days. The reason for this is that out of 5 recruiters who rated you, you received an average of 1 star. Due to this, we are imposing a 10-day ban starting from today. Have a good day.', '2024-06-17 06:07:36');

-- --------------------------------------------------------

--
-- Table structure for table `rec_reg`
--

CREATE TABLE `rec_reg` (
  `name` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(8) NOT NULL,
  `address` varchar(50) NOT NULL,
  `pin` int(10) NOT NULL,
  `city` varchar(30) NOT NULL,
  `ban_end_date` datetime DEFAULT NULL,
  `ban_start_date` datetime DEFAULT NULL,
  `banned` tinyint(1) DEFAULT 0,
  `permanently_banned` tinyint(1) DEFAULT 0,
  `otp` varchar(6) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rec_reg`
--

INSERT INTO `rec_reg` (`name`, `email`, `password`, `address`, `pin`, `city`, `ban_end_date`, `ban_start_date`, `banned`, `permanently_banned`, `otp`, `otp_expiry`) VALUES
('Augustine Shaji', 'augustineshaji007@gmail.com', 'ABCD@123', 'abcdd', 123456, 'edadu', '2024-10-26 12:21:22', '2024-10-16 12:21:22', 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seeker_reviews`
--

CREATE TABLE `seeker_reviews` (
  `review_id` int(11) NOT NULL,
  `seeker_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `review_text` text DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seeker_reviews`
--

INSERT INTO `seeker_reviews` (`review_id`, `seeker_id`, `rating`, `review_text`, `review_date`) VALUES
(1, 1, 5, 'fdgvhbjnk', '2024-08-27 07:38:06'),
(2, 1, 5, 'fdgvhbjnk', '2024-08-27 07:38:36'),
(3, 1, 5, 'fdgvhbjnk', '2024-08-27 07:39:39'),
(4, 1, 5, 'fdgvhbjnk', '2024-08-27 07:39:45');

-- --------------------------------------------------------

--
-- Table structure for table `user_reviews`
--

CREATE TABLE `user_reviews` (
  `id` int(11) NOT NULL,
  `reviewer_email` varchar(255) NOT NULL,
  `reviewee_email` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_seekers`
--
ALTER TABLE `job_seekers`
  ADD PRIMARY KEY (`s_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `one_star_ratings`
--
ALTER TABLE `one_star_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recruiter_messages`
--
ALTER TABLE `recruiter_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rec_reg`
--
ALTER TABLE `rec_reg`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `seeker_reviews`
--
ALTER TABLE `seeker_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `seeker_id` (`seeker_id`);

--
-- Indexes for table `user_reviews`
--
ALTER TABLE `user_reviews`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `job_seekers`
--
ALTER TABLE `job_seekers`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT for table `one_star_ratings`
--
ALTER TABLE `one_star_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `recruiter_messages`
--
ALTER TABLE `recruiter_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `seeker_reviews`
--
ALTER TABLE `seeker_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_reviews`
--
ALTER TABLE `user_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
