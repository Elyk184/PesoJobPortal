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
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `personal_information` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`personal_information`)),
  `present_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`present_address`)),
  `permanent_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permanent_address`)),
  `resume_name` varchar(255) DEFAULT NULL,
  `resume_email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `skills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`skills`)),
  `education` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`education`)),
  `training` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`training`)),
  `experience` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`experience`)),
  `eligibility` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`eligibility`)),
  `other_skills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`other_skills`)),
  `employment_status` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`employment_status`)),
  `job_preferences` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`job_preferences`)),
  `languages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`languages`)),
  `disability` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`disability`)),
  `objective` text DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `trade_name` varchar(255) DEFAULT NULL,
  `acronym_abbreviation` varchar(255) DEFAULT NULL,
  `office_type` varchar(255) DEFAULT NULL,
  `tin` varchar(255) DEFAULT NULL,
  `employer_type_detail` varchar(255) DEFAULT NULL,
  `workforce_size` varchar(255) DEFAULT NULL,
  `line_of_business` varchar(255) DEFAULT NULL,
  `street_village` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `city_municipality` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `establishment_contact_person` varchar(255) DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `establishment_contact_position` varchar(255) DEFAULT NULL,
  `establishment_phone` varchar(255) DEFAULT NULL,
  `contact_person_phone` varchar(255) DEFAULT NULL,
  `establishment_email` varchar(255) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `business_permit_path` varchar(255) DEFAULT NULL,
  `dti_sec_registration_path` varchar(255) DEFAULT NULL,
  `verification_status` varchar(255) NOT NULL DEFAULT 'pending',
  `verification_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `personal_information`, `present_address`, `permanent_address`, `resume_name`, `resume_email`, `phone`, `address`, `resume_path`, `skills`, `education`, `training`, `experience`, `eligibility`, `other_skills`, `employment_status`, `job_preferences`, `languages`, `disability`, `objective`, `photo_path`, `company_name`, `business_name`, `trade_name`, `acronym_abbreviation`, `office_type`, `tin`, `employer_type_detail`, `workforce_size`, `line_of_business`, `street_village`, `barangay`, `city_municipality`, `province`, `establishment_contact_person`, `contact_person_name`, `establishment_contact_position`, `establishment_phone`, `contact_person_phone`, `establishment_email`, `logo_path`, `business_permit_path`, `dti_sec_registration_path`, `verification_status`, `verification_notes`, `created_at`, `updated_at`) VALUES
(7, 8, '{\"surname\":\"Felicitas\",\"first_name\":\"James Ivan\",\"middle_initial\":\"C.\",\"suffix\":null,\"date_of_birth\":null,\"sex\":\"Male\",\"religion\":\"Roman Catholic\",\"civil_status\":\"Single\",\"height\":\"155\",\"tin\":\"09013103\",\"contact_number\":\"09704439764\",\"email_address\":\"jamesivanfelicitas@gmail.com\",\"currently_in_school\":false}', '{\"house_no\":\"Purok 2 Miranda\",\"barangay\":\"Damilag\",\"municipality\":\"Manolo Fortich\",\"province\":\"Bukidnon\"}', '{\"house_no\":\"Purok 2 Miranda\",\"barangay\":\"Damilag\",\"municipality\":\"Manolo Fortich\",\"province\":\"Bukidnon\"}', 'James Ivan C. Felicitas', 'jamesivanfelicitas@gmail.com', '09704439764', 'Purok 2 Miranda, Damilag, Manolo Fortich, Bukidnon', NULL, '[\"Auto Mechanic\",\"Beautician\",\"Tailoring\",\"Computer Literate\",\"Hardware Installation & Repair\",\"Node.js\",\"Scheduling and Calendar Management\",\"Flutter\",\"Docker\",\"Teaching\"]', '[{\"school\":\"Northern Bukidnon State College\",\"course\":\"STEM\",\"year\":\"2024\"}]', '[{\"course\":\"zczc\",\"hours\":\"zxczczc\",\"institution\":\"zczczc\",\"dates\":\"zczczc\",\"skills\":\"zczczcc\",\"certificates\":\"zczczc\"}]', '[{\"company\":\"Local Office \\/ Company Name\",\"title\":\"Administrative Assistant Intern\",\"location\":\"\",\"status\":\"\",\"from_date\":\"\",\"to_date\":\"\",\"salary_amount\":\"\",\"salary_type\":\"\",\"details\":\"adsadad\"}]', '[{\"eligibility\":\"wdwadadad\",\"date_taken\":\"adla;d\",\"license\":\"adadad\",\"valid_until\":\"a,ldakdpalda\"}]', '{\"trade_manual\":[\"Auto Mechanic\",\"Beautician\",\"Tailoring\"],\"it_technical\":[\"Computer Literate\",\"Hardware Installation & Repair\",\"Node.js\",\"Scheduling and Calendar Management\",\"Flutter\",\"Docker\"],\"soft_skills\":[],\"other_text\":\"Teaching\",\"with_certificate\":false,\"by_experience\":false}', '{\"wage_employed\":true,\"self_employed\":false,\"unemployed\":false,\"has_work_experience\":false}', '{\"part_time\":true,\"full_time\":false,\"local\":true,\"overseas\":false,\"occupation_text\":\"\"}', '[{\"language\":\"English\",\"read\":true,\"write\":false,\"speak\":false,\"understand\":false,\"other\":\"\"},{\"language\":\"Tagalog\",\"read\":true,\"write\":false,\"speak\":false,\"understand\":false,\"other\":\"\"},{\"language\":\"Visayan\",\"read\":true,\"write\":false,\"speak\":false,\"understand\":false,\"other\":\"\"},{\"language\":\"Others:\",\"read\":true,\"write\":false,\"speak\":false,\"understand\":false,\"other\":\"\"}]', '{\"visual\":false,\"speech\":false,\"mental\":true,\"hearing\":true,\"physical\":true,\"other\":false,\"other_text\":\"\"}', 'guhgiuhiuhih', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, '2026-04-20 00:39:07', '2026-04-26 22:51:01'),
(8, 10, '{\"surname\":\"asdad\",\"first_name\":\"James Ivan\",\"middle_initial\":null,\"suffix\":null,\"date_of_birth\":\"2021-12-22\",\"sex\":\"Male\",\"religion\":\"axsaxs\",\"civil_status\":\"axsax\",\"height\":\"xxa\",\"tin\":\"axax\",\"contact_number\":\"sdasda\",\"email_address\":\"20221351@nbsc.edu.ph\",\"currently_in_school\":false}', '{\"house_no\":\"Purok 2 Miranda\",\"barangay\":\"Damilag\",\"municipality\":\"Manolo Fortich\",\"province\":\"Bukidknown\"}', '{\"house_no\":null,\"barangay\":null,\"municipality\":null,\"province\":null}', 'James Ivan asdad', '20221351@nbsc.edu.ph', 'sdasda', 'Purok 2 Miranda, Damilag, Manolo Fortich, Bukidknown', NULL, '[\"Database Management\",\"API Integration & Development\",\"Software Development & Debugging\",\"Graphic Design\",\"Node.js\",\"Backend Development (Server-side)\",\"Virtual Assistance\",\"Filing and Documentation\"]', '[{\"school\":\"harvard state university\",\"course\":\"STEM\",\"year\":\"2015\"}]', '[{\"course\":\"asmda;ld\",\"hours\":\"adma d,a\",\"institution\":\"aldkla;d\",\"dates\":\"a.dmad\",\"skills\":\"Computer Literate, Programming, Database, JavaScript, HTML\\/CSS, Git, Database Management, Frontend Development (Web UI), API Integration & Development, Network Configuration & Troubleshooting James Ivan Crossing Libona Contract\",\"certificates\":\"klajdlada\"}]', '[]', '[]', '{\"trade_manual\":[],\"it_technical\":[\"Database Management\",\"API Integration & Development\",\"Software Development & Debugging\",\"Graphic Design\",\"Node.js\",\"Backend Development (Server-side)\",\"Virtual Assistance\",\"Filing and Documentation\"],\"soft_skills\":[],\"other_text\":\"\",\"with_certificate\":false,\"by_experience\":false}', '{\"wage_employed\":false,\"wage_employed_specify\":\"lmlasa\",\"self_employed\":false,\"self_employed_specify\":\"kladjads\",\"unemployed\":false,\"has_work_experience\":false}', '{\"part_time\":false,\"full_time\":false,\"local\":false,\"overseas\":false,\"occupation_text\":\"\"}', '[{\"language\":\"English\",\"read\":true,\"write\":true,\"speak\":true,\"understand\":true,\"other\":\"\"},{\"language\":\"Tagalog\",\"read\":true,\"write\":true,\"speak\":true,\"understand\":true,\"other\":\"\"},{\"language\":\"Visayan\",\"read\":true,\"write\":true,\"speak\":true,\"understand\":true,\"other\":\"\"},{\"language\":\"Others:\",\"read\":true,\"write\":true,\"speak\":true,\"understand\":true,\"other\":\"\"}]', '{\"visual\":false,\"speech\":true,\"mental\":false,\"hearing\":true,\"physical\":true,\"other\":false,\"other_text\":\"\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, '2026-04-20 22:07:43', '2026-05-24 19:46:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_profiles_user_id_unique` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
