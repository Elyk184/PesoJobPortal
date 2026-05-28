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
-- Table structure for table `contact_submission_messages`
--

CREATE TABLE `contact_submission_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_submission_id` bigint(20) UNSIGNED NOT NULL,
  `sender_type` enum('user','admin') NOT NULL,
  `message` text NOT NULL,
  `sent_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_submission_messages`
--

INSERT INTO `contact_submission_messages` (`id`, `contact_submission_id`, `sender_type`, `message`, `sent_by_user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'user', 'adadadad', NULL, '2026-05-10 19:13:06', '2026-05-10 19:13:06'),
(2, 1, 'admin', 'helloaodjadoiaodajdoad', 8, '2026-05-10 19:45:25', '2026-05-10 19:45:25'),
(3, 2, 'user', 'hello', NULL, '2026-05-12 16:03:56', '2026-05-12 16:03:56'),
(4, 2, 'admin', 's,nmf,smfs', 8, '2026-05-12 16:05:07', '2026-05-12 16:05:07'),
(5, 3, 'user', 'hello', NULL, '2026-05-21 22:00:40', '2026-05-21 22:00:40'),
(6, 4, 'user', 'adad', NULL, '2026-05-21 22:01:20', '2026-05-21 22:01:20'),
(7, 4, 'admin', 'dadadadsaccac', 8, '2026-05-21 22:01:44', '2026-05-21 22:01:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_submission_messages`
--
ALTER TABLE `contact_submission_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_submission_messages_contact_submission_id_foreign` (`contact_submission_id`),
  ADD KEY `contact_submission_messages_sent_by_user_id_foreign` (`sent_by_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_submission_messages`
--
ALTER TABLE `contact_submission_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_submission_messages`
--
ALTER TABLE `contact_submission_messages`
  ADD CONSTRAINT `contact_submission_messages_contact_submission_id_foreign` FOREIGN KEY (`contact_submission_id`) REFERENCES `contact_submissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contact_submission_messages_sent_by_user_id_foreign` FOREIGN KEY (`sent_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
