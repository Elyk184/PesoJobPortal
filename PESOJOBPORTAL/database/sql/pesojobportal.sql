-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2026 at 03:05 AM
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
-- Database: `pesojobportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicant_feedback`
--

CREATE TABLE `applicant_feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `employer_id` bigint(20) UNSIGNED NOT NULL,
  `feedback` text NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `feedback_type` enum('interview_experience','job_performance','professionalism','general') NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_profiles`
--

CREATE TABLE `company_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `trade_name` varchar(255) DEFAULT NULL,
  `acronym_abbreviation` varchar(255) DEFAULT NULL,
  `office_type` enum('main_office','branch') NOT NULL DEFAULT 'main_office',
  `employer_type_detail` enum('national_gov','local_gov','gocc','state_college','direct_hire','local_recruitment','overseas_recruitment','do174') DEFAULT NULL,
  `workforce_size` enum('micro','small','medium','large') DEFAULT NULL,
  `tin` varchar(255) DEFAULT NULL,
  `line_of_business` text DEFAULT NULL,
  `street_village` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `city_municipality` varchar(255) DEFAULT NULL,
  `establishment_contact_person` varchar(255) DEFAULT NULL,
  `establishment_contact_position` varchar(255) DEFAULT NULL,
  `establishment_email` varchar(255) DEFAULT NULL,
  `establishment_phone` varchar(255) DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `contact_person_phone` varchar(255) DEFAULT NULL,
  `business_permit_path` varchar(255) DEFAULT NULL,
  `dti_sec_registration_path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `company_size` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `tin_number` varchar(255) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `verification_status` enum('pending','under_review','verified','rejected') NOT NULL DEFAULT 'pending',
  `verification_notes` text DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `about_company` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employer_documents`
--

CREATE TABLE `employer_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employer_notifications`
--

CREATE TABLE `employer_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employer_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('job_fair_invite','referral_update','general') NOT NULL DEFAULT 'general',
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobseeker_profiles`
--

CREATE TABLE `jobseeker_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `date_of_birth` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `skills` varchar(255) DEFAULT NULL,
  `years_of_experience` int(11) DEFAULT NULL,
  `education` text DEFAULT NULL,
  `avatar_path` varchar(255) DEFAULT NULL,
  `certifications` text DEFAULT NULL,
  `languages` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `peso_job_id` bigint(20) UNSIGNED NOT NULL,
  `is_referred` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('pending','reviewed','interviewed','hired','rejected') NOT NULL DEFAULT 'pending',
  `admin_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_approved_at` timestamp NULL DEFAULT NULL,
  `employer_status` enum('interview_scheduled','hired','not_selected') DEFAULT NULL,
  `final_decision` enum('pending','hired','not_selected') NOT NULL DEFAULT 'pending',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL,
  `employer_feedback` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin_approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `user_id`, `peso_job_id`, `is_referred`, `status`, `admin_status`, `admin_approved_at`, `employer_status`, `final_decision`, `applied_at`, `notes`, `employer_feedback`, `created_at`, `updated_at`, `admin_approved_by`, `admin_notes`) VALUES
(1, 5, 1, 0, 'pending', 'pending', NULL, NULL, 'pending', '2026-04-28 00:59:52', 'hello', NULL, '2026-04-27 16:59:52', '2026-04-27 16:59:52', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lra_requests`
--

CREATE TABLE `lra_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `lra_code` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `request_date` datetime DEFAULT NULL,
  `approved_date` datetime DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_10_01_000001_create_peso_jobs_table', 1),
(5, '2024_10_01_000002_create_job_applications_table', 1),
(6, '2024_10_01_000003_create_user_profiles_table', 1),
(8, '2026_03_26_000001_add_role_to_users_table', 2),
(9, '2026_03_30_053607_create_sessions_table', 1),
(10, '2026_04_15_000001_add_resume_sections_to_user_profiles_table', 3),
(11, '2026_04_15_000002_add_resume_identity_to_user_profiles_table', 3),
(12, '2026_04_15_000004_add_approval_fields_to_users_table', 3),
(13, '2026_04_15_000001_add_employer_feature_fields', 4),
(14, '2026_04_15_000002_create_recruitment_activity_requests_table', 4),
(15, '2026_04_15_000003_create_employer_notifications_table', 4),
(16, '2026_04_16_000004_add_employer_profile_fields_to_user_profiles_and_username_to_users', 4),
(17, '2026_04_16_120000_add_optional_job_detail_columns_to_peso_jobs_table', 4),
(18, '2026_04_16_123000_expand_peso_jobs_status_enum', 4),
(19, '2026_04_21_000000_create_missing_tables', 5),
(20, '2026_04_21_000001_setup_approval_workflow', 6),
(21, '2026_04_22_000001_add_admin_approval_to_job_applications_table', 7),
(22, '2026_04_22_000001_create_company_profiles_table', 8),
(23, '2026_04_23_000001_add_verification_to_company_profiles_table', 9),
(24, '2026_04_23_000002_add_profile_photo_to_users_table', 10),
(25, '2026_04_27_000001_add_deletion_reason_to_peso_jobs_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `action_url` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peso_clearances`
--

CREATE TABLE `peso_clearances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `clearance_number` varchar(255) NOT NULL,
  `issue_date` datetime NOT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peso_jobs`
--

CREATE TABLE `peso_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `qualifications` text DEFAULT NULL,
  `key_responsibilities` text DEFAULT NULL,
  `preferred_skills` text DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `education` text DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  `employer_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `job_type` varchar(255) DEFAULT NULL,
  `vacancies` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `application_start_date` date DEFAULT NULL,
  `application_end_date` date DEFAULT NULL,
  `salary_range` varchar(255) DEFAULT NULL,
  `salary` varchar(255) DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `status` enum('active','pending','draft','closed') NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `deletion_reason` text DEFAULT NULL,
  `archived_at` timestamp NULL DEFAULT NULL,
  `is_filled` tinyint(1) NOT NULL DEFAULT 0,
  `filled_at` timestamp NULL DEFAULT NULL,
  `source_job_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peso_jobs`
--

INSERT INTO `peso_jobs` (`id`, `employer_id`, `title`, `position`, `description`, `qualifications`, `key_responsibilities`, `preferred_skills`, `experience`, `education`, `benefits`, `employer_name`, `location`, `job_type`, `vacancies`, `application_start_date`, `application_end_date`, `salary_range`, `salary`, `requirements`, `status`, `approved_at`, `approved_by`, `rejection_reason`, `deletion_reason`, `archived_at`, `is_filled`, `filled_at`, `source_job_id`, `created_at`, `updated_at`) VALUES
(1, 2, 'weeb', 'weeb', 'hello', '• hello', '• hello', '• hello', '• 24 years', 'school', '• with friends', 'vince', 'bukidnon', 'full_time', 1, '2026-04-21', '2026-04-23', '2000 - 99000', '2000 - 99000', NULL, 'active', '2026-04-20 21:37:57', 1, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-20 19:58:35', '2026-04-20 21:37:57'),
(2, 2, 'test', 'test', 'tst', '• sgrsfd', '• xfrgs', '• sfdf', '• sfd', 'sfsd', '• sdf', 'vince', 'ggg', 'part_time', 1, '2026-04-27', '2026-04-28', '1200000 - 1222222222000', '1200000 - 1222222222000', NULL, 'active', '2026-04-27 17:02:51', 1, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-27 00:36:06', '2026-04-27 17:02:51');

-- --------------------------------------------------------

--
-- Table structure for table `recommended_jobs`
--

CREATE TABLE `recommended_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `match_score` decimal(5,2) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recruitment_activity_requests`
--

CREATE TABLE `recruitment_activity_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employer_id` bigint(20) UNSIGNED NOT NULL,
  `activity_type` enum('lra','sra') NOT NULL,
  `letter_of_intent_path` varchar(255) NOT NULL,
  `company_profile_path` varchar(255) NOT NULL,
  `job_advertisement_path` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recruitment_activity_requests`
--

INSERT INTO `recruitment_activity_requests` (`id`, `employer_id`, `activity_type`, `letter_of_intent_path`, `company_profile_path`, `job_advertisement_path`, `status`, `approved_at`, `approved_by`, `notes`, `created_at`, `updated_at`) VALUES
(1, 2, 'lra', 'recruitment-documents/En0Wp2NLSnzDKeJccIFnSPmd2CdaS8VbtqMlSwTr.docx', 'recruitment-documents/xg2kZD5eJzk2nK89UcqSQzbGAGKJVnLOEnOoEVhs.docx', '', 'approved', '2026-04-21 17:06:24', 1, NULL, '2026-04-21 16:35:06', '2026-04-21 17:06:24');

-- --------------------------------------------------------

--
-- Table structure for table `report_templates`
--

CREATE TABLE `report_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sql_query` varchar(255) DEFAULT NULL,
  `template_type` varchar(255) NOT NULL,
  `fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`fields`)),
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saved_jobs`
--

CREATE TABLE `saved_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('wAxw0kxCZjZINjIYZCNpzv9Xpu5tdTgKauyYlYGV', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJjZTd4V2VhRTA1SnlPZlhpN0hWcVZ1NFdyVmx0dGZSRWQ2MVl5eW9vIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2VtcGxveWVyXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImVtcGxveWVyLmRhc2hib2FyZCJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6Mn0=', 1777338276);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `role` enum('admin','employer','jobseeker') NOT NULL DEFAULT 'jobseeker',
  `is_employer_verified` tinyint(1) NOT NULL DEFAULT 0,
  `is_approved` tinyint(1) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `rejected_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `profile_photo`, `username`, `role`, `is_employer_verified`, `is_approved`, `approved_at`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `approved_by`, `rejection_reason`, `rejected_at`, `rejected_by`) VALUES
(1, 'Vince Kenneth L. Olemberio', '20221077@nbsc.edu.ph', 'profile-photos/xLtgH8DyjvYD8Z7Jpkvqcpr3BLmx3RJf0U4ZXkgW.png', NULL, 'admin', 0, NULL, NULL, NULL, '$2y$12$RadbOw2iXppfXLP5/iTjDuiXbBmTTTjtz0zJPkh8x6JA5PENKimqq', NULL, '2026-04-15 17:34:00', '2026-04-22 23:25:21', NULL, NULL, NULL, NULL),
(2, 'vince', 'vince.olemberio2004@gmail.com', NULL, NULL, 'employer', 0, NULL, NULL, NULL, '$2y$12$pn8r2.EKXIPS73b2FXobEO7pYfAMEAdB95EXrn1MAwvLLPp1paGXi', NULL, '2026-04-20 16:51:20', '2026-04-20 16:51:20', NULL, NULL, NULL, NULL),
(4, 'bins', 'bins@gmail.com', NULL, NULL, 'employer', 0, NULL, NULL, NULL, '$2y$12$i4vXsO2VGs4b9vTm68Obsug5mr2j1Aax4jc8C0Qj/5UJ6A6j8ub1i', NULL, '2026-04-22 21:41:40', '2026-04-22 21:41:40', NULL, NULL, NULL, NULL),
(5, 'test', 'tailadmin@gmail.com', NULL, NULL, 'jobseeker', 0, NULL, NULL, NULL, '$2y$12$bI5RSZbn97Mg5me4R.bAPe1G4xR97E.3drkuwEsDRtTkCv40Ej5Wa', NULL, '2026-04-27 16:48:26', '2026-04-27 16:48:26', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `resume_name` varchar(255) DEFAULT NULL,
  `resume_email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `skills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`skills`)),
  `education` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`education`)),
  `experience` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`experience`)),
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

INSERT INTO `user_profiles` (`id`, `user_id`, `resume_name`, `resume_email`, `phone`, `address`, `resume_path`, `skills`, `education`, `experience`, `objective`, `photo_path`, `company_name`, `business_name`, `trade_name`, `acronym_abbreviation`, `office_type`, `tin`, `employer_type_detail`, `workforce_size`, `line_of_business`, `street_village`, `barangay`, `city_municipality`, `province`, `establishment_contact_person`, `contact_person_name`, `establishment_contact_position`, `establishment_phone`, `contact_person_phone`, `establishment_email`, `logo_path`, `business_permit_path`, `dti_sec_registration_path`, `verification_status`, `verification_notes`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'company-profiles/nKCrb1oPu2tld7mCbzDvCYd6jWfAxo236hiOecW9.png', NULL, NULL, 'pending', NULL, '2026-04-20 19:51:10', '2026-04-21 19:03:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicant_feedback`
--
ALTER TABLE `applicant_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applicant_feedback_application_id_foreign` (`application_id`),
  ADD KEY `applicant_feedback_employer_id_foreign` (`employer_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `company_profiles`
--
ALTER TABLE `company_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_profiles_user_id_unique` (`user_id`),
  ADD KEY `company_profiles_user_id_index` (`user_id`),
  ADD KEY `company_profiles_verified_by_foreign` (`verified_by`);

--
-- Indexes for table `employer_documents`
--
ALTER TABLE `employer_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employer_documents_user_id_index` (`user_id`),
  ADD KEY `employer_documents_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `employer_notifications`
--
ALTER TABLE `employer_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employer_notifications_employer_id_foreign` (`employer_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `jobseeker_profiles`
--
ALTER TABLE `jobseeker_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jobseeker_profiles_user_id_unique` (`user_id`),
  ADD KEY `jobseeker_profiles_user_id_index` (`user_id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_applications_user_id_foreign` (`user_id`),
  ADD KEY `job_applications_peso_job_id_foreign` (`peso_job_id`),
  ADD KEY `job_applications_admin_approved_by_foreign` (`admin_approved_by`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lra_requests`
--
ALTER TABLE `lra_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lra_requests_user_id_index` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_is_read_index` (`user_id`,`is_read`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `peso_clearances`
--
ALTER TABLE `peso_clearances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `peso_clearances_clearance_number_unique` (`clearance_number`),
  ADD KEY `peso_clearances_user_id_index` (`user_id`);

--
-- Indexes for table `peso_jobs`
--
ALTER TABLE `peso_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peso_jobs_employer_id_foreign` (`employer_id`),
  ADD KEY `peso_jobs_source_job_id_foreign` (`source_job_id`),
  ADD KEY `peso_jobs_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `recommended_jobs`
--
ALTER TABLE `recommended_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recommended_jobs_job_id_foreign` (`job_id`),
  ADD KEY `recommended_jobs_user_id_created_at_index` (`user_id`,`created_at`);

--
-- Indexes for table `recruitment_activity_requests`
--
ALTER TABLE `recruitment_activity_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recruitment_activity_requests_employer_id_foreign` (`employer_id`),
  ADD KEY `recruitment_activity_requests_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `report_templates`
--
ALTER TABLE `report_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_templates_created_by_index` (`created_by`);

--
-- Indexes for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `saved_jobs_user_id_job_id_unique` (`user_id`,`job_id`),
  ADD KEY `saved_jobs_job_id_foreign` (`job_id`),
  ADD KEY `saved_jobs_user_id_created_at_index` (`user_id`,`created_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_approved_by_foreign` (`approved_by`),
  ADD KEY `users_rejected_by_foreign` (`rejected_by`);

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
-- AUTO_INCREMENT for table `applicant_feedback`
--
ALTER TABLE `applicant_feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_profiles`
--
ALTER TABLE `company_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employer_documents`
--
ALTER TABLE `employer_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employer_notifications`
--
ALTER TABLE `employer_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobseeker_profiles`
--
ALTER TABLE `jobseeker_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lra_requests`
--
ALTER TABLE `lra_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peso_clearances`
--
ALTER TABLE `peso_clearances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peso_jobs`
--
ALTER TABLE `peso_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `recommended_jobs`
--
ALTER TABLE `recommended_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recruitment_activity_requests`
--
ALTER TABLE `recruitment_activity_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `report_templates`
--
ALTER TABLE `report_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicant_feedback`
--
ALTER TABLE `applicant_feedback`
  ADD CONSTRAINT `applicant_feedback_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `job_applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applicant_feedback_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_profiles`
--
ALTER TABLE `company_profiles`
  ADD CONSTRAINT `company_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `company_profiles_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `employer_documents`
--
ALTER TABLE `employer_documents`
  ADD CONSTRAINT `employer_documents_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `employer_documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employer_notifications`
--
ALTER TABLE `employer_notifications`
  ADD CONSTRAINT `employer_notifications_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jobseeker_profiles`
--
ALTER TABLE `jobseeker_profiles`
  ADD CONSTRAINT `jobseeker_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_admin_approved_by_foreign` FOREIGN KEY (`admin_approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `job_applications_peso_job_id_foreign` FOREIGN KEY (`peso_job_id`) REFERENCES `peso_jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lra_requests`
--
ALTER TABLE `lra_requests`
  ADD CONSTRAINT `lra_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `peso_clearances`
--
ALTER TABLE `peso_clearances`
  ADD CONSTRAINT `peso_clearances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `peso_jobs`
--
ALTER TABLE `peso_jobs`
  ADD CONSTRAINT `peso_jobs_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `peso_jobs_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `peso_jobs_source_job_id_foreign` FOREIGN KEY (`source_job_id`) REFERENCES `peso_jobs` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `recommended_jobs`
--
ALTER TABLE `recommended_jobs`
  ADD CONSTRAINT `recommended_jobs_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `peso_jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recommended_jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recruitment_activity_requests`
--
ALTER TABLE `recruitment_activity_requests`
  ADD CONSTRAINT `recruitment_activity_requests_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `recruitment_activity_requests_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_templates`
--
ALTER TABLE `report_templates`
  ADD CONSTRAINT `report_templates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  ADD CONSTRAINT `saved_jobs_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `peso_jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_rejected_by_foreign` FOREIGN KEY (`rejected_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
