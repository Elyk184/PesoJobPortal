-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2026 at 03:25 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_submissions`
--

CREATE TABLE `contact_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_code` varchar(40) DEFAULT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(40) DEFAULT NULL,
  `subject` varchar(180) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'open',
  `last_message_at` timestamp NULL DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `portal_notification_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_submissions`
--

INSERT INTO `contact_submissions` (`id`, `reference_code`, `name`, `email`, `phone`, `subject`, `message`, `status`, `last_message_at`, `replied_at`, `portal_notification_id`, `created_at`, `updated_at`) VALUES
(1, 'INQ-2026-000001', 'James Ivan', '20221351@nbsc.edu.ph', '09704439764', 'dasdadadadadla;dad', 'adadadad', 'replied', '2026-05-10 19:45:25', '2026-05-10 19:45:25', 12, '2026-05-10 19:13:06', '2026-05-10 19:45:25'),
(2, 'INQ-2026-000002', 'James Ivan', 'jamesivanfelicitas@gmail.com', '09704439764', 'Testing', 'hello', 'replied', '2026-05-12 16:05:07', '2026-05-12 16:05:07', 13, '2026-05-12 16:03:56', '2026-05-12 16:05:07'),
(3, 'INQ-2026-000003', 'James Ivan', '20201293@nbsc.edu.ph', '09704439764', 'Testing', 'hello', 'open', '2026-05-21 22:00:40', NULL, 14, '2026-05-21 22:00:40', '2026-05-21 22:00:40'),
(4, 'INQ-2026-000004', 'Naviiiii', 'jamesivanfelicitas@gmail.com', '09502341371', 'sdada', 'adad', 'replied', '2026-05-21 22:01:44', '2026-05-21 22:01:44', 15, '2026-05-21 22:01:20', '2026-05-21 22:01:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contact_submissions_reference_code_unique` (`reference_code`),
  ADD KEY `contact_submissions_portal_notification_id_foreign` (`portal_notification_id`),
  ADD KEY `contact_submissions_created_at_index` (`created_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD CONSTRAINT `contact_submissions_portal_notification_id_foreign` FOREIGN KEY (`portal_notification_id`) REFERENCES `portal_notifications` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
