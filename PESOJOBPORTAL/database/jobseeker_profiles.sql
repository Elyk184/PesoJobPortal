-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2026 at 02:51 AM
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
-- Table structure for table `jobseeker_profiles`
--

CREATE TABLE `jobseeker_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `middle_initial` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `date_of_birth` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `civil_status` varchar(255) DEFAULT NULL,
  `height` varchar(255) DEFAULT NULL,
  `tin` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `skills` varchar(255) DEFAULT NULL,
  `years_of_experience` int(11) DEFAULT NULL,
  `education` text DEFAULT NULL,
  `training` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`training`)),
  `work_experience` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`work_experience`)),
  `employment_status` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`employment_status`)),
  `job_preference` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`job_preference`)),
  `disability` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`disability`)),
  `avatar_path` varchar(255) DEFAULT NULL,
  `certifications` text DEFAULT NULL,
  `languages` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobseeker_profiles`
--

INSERT INTO `jobseeker_profiles` (`id`, `user_id`, `first_name`, `last_name`, `middle_initial`, `suffix`, `bio`, `phone`, `date_of_birth`, `religion`, `civil_status`, `height`, `tin`, `email_address`, `gender`, `address`, `city`, `province`, `postal_code`, `skills`, `years_of_experience`, `education`, `training`, `work_experience`, `employment_status`, `job_preference`, `disability`, `avatar_path`, `certifications`, `languages`, `created_at`, `updated_at`) VALUES
(1, 10, 'James Ivan', 'asdad', NULL, NULL, NULL, 'sdasda', '2021-12-22', 'axsaxs', 'axsax', 'xxa', 'axax', '20221351@nbsc.edu.ph', 'Male', 'Purok 2 Miranda, Damilag, Manolo Fortich, Bukidknown', 'Manolo Fortich', 'Bukidknown', NULL, 'Database Management, API Integration & Development, Software Development & Debugging, Graphic Design, Node.js, Backend Development (Server-side), Virtual Assistance, Filing and Documentation', NULL, '[{\"school\":\"harvard state university\",\"course\":\"STEM\",\"year\":\"2015\"}]', '[{\"course\":\"asmda;ld\",\"hours\":\"adma d,a\",\"institution\":\"aldkla;d\",\"dates\":\"a.dmad\",\"skills\":\"Computer Literate, Programming, Database, JavaScript, HTML\\/CSS, Git, Database Management, Frontend Development (Web UI), API Integration & Development, Network Configuration & Troubleshooting James Ivan Crossing Libona Contract\",\"certificates\":\"klajdlada\"}]', NULL, '{\"wage_employed_specify\":\"lmlasa\",\"self_employed_specify\":\"kladjads\"}', '{\"occupation_text\":null}', '{\"speech\":\"1\",\"hearing\":\"1\",\"physical\":\"1\",\"other_text\":null}', NULL, 'asmda;ld', '[{\"language\":\"English\",\"read\":\"1\",\"write\":\"1\",\"speak\":\"1\",\"understand\":\"1\"},{\"language\":\"Tagalog\",\"read\":\"1\",\"write\":\"1\",\"speak\":\"1\",\"understand\":\"1\"},{\"language\":\"Visayan\",\"read\":\"1\",\"write\":\"1\",\"speak\":\"1\",\"understand\":\"1\"},{\"language\":\"Others:\",\"read\":\"1\",\"write\":\"1\",\"speak\":\"1\",\"understand\":\"1\",\"other\":null}]', '2026-05-24 17:15:04', '2026-05-24 19:46:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobseeker_profiles`
--
ALTER TABLE `jobseeker_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jobseeker_profiles_user_id_unique` (`user_id`),
  ADD KEY `jobseeker_profiles_user_id_index` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobseeker_profiles`
--
ALTER TABLE `jobseeker_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jobseeker_profiles`
--
ALTER TABLE `jobseeker_profiles`
  ADD CONSTRAINT `jobseeker_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
