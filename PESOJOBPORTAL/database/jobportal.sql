-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2026 at 02:46 AM
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
  `company_name` varchar(255) DEFAULT '',
  `business_name` varchar(255) DEFAULT '',
  `trade_name` varchar(255) DEFAULT '',
  `acronym_abbreviation` varchar(255) DEFAULT '',
  `office_type` enum('main_office','branch') NOT NULL DEFAULT 'main_office',
  `employer_type_detail` enum('national_gov','local_gov','gocc','state_college','direct_hire','local_recruitment','overseas_recruitment','do174') DEFAULT NULL,
  `workforce_size` enum('micro','small','medium','large') DEFAULT NULL,
  `tin` varchar(255) DEFAULT '',
  `line_of_business` longtext DEFAULT '',
  `street_village` varchar(255) DEFAULT '',
  `barangay` varchar(255) DEFAULT '',
  `city_municipality` varchar(255) DEFAULT '',
  `establishment_contact_person` varchar(255) DEFAULT '',
  `establishment_contact_position` varchar(255) DEFAULT '',
  `establishment_email` varchar(255) DEFAULT '',
  `establishment_phone` varchar(255) DEFAULT '',
  `contact_person_name` varchar(255) DEFAULT '',
  `contact_person_phone` varchar(255) DEFAULT '',
  `business_permit_path` varchar(255) DEFAULT '',
  `dti_sec_registration_path` varchar(255) DEFAULT '',
  `description` text DEFAULT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `company_size` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT '',
  `postal_code` varchar(255) DEFAULT NULL,
  `tin_number` varchar(255) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT '',
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
  `type` enum('job_fair_invite','referral_update','general','job_update','verification_update') NOT NULL DEFAULT 'general',
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employer_notifications`
--

INSERT INTO `employer_notifications` (`id`, `employer_id`, `type`, `title`, `message`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 11, 'job_update', 'Job Post Approved', 'Your job post \'sdsdaadada\' has been approved by PESO admin and is now active.', 0, NULL, '2026-05-05 17:58:38', '2026-05-05 17:58:38'),
(2, 11, 'job_update', 'New Job Application Received', 'James Ivan C. Felicitas applied for \"sdsdaadada\". Review this in View Applicants or Notifications.', 0, NULL, '2026-05-05 17:59:55', '2026-05-05 17:59:55'),
(3, 11, 'job_update', 'Job Post Approved', 'Your job post \'ajdoadjaokaofafpoa\' has been approved by PESO admin and is now active.', 0, NULL, '2026-05-05 18:39:20', '2026-05-05 18:39:20'),
(4, 11, 'job_update', 'Job Post Approved', 'Your job post \'dfasfdsfsdf\' has been approved by PESO admin and is now active.', 0, NULL, '2026-05-24 17:58:24', '2026-05-24 17:58:24'),
(5, 11, 'job_update', 'Job Post Approved', 'Your job post \'Computer Literate, Programming, Database, JavaScript, HTML/CSS, Git, Database Management, Frontend Development (Web UI), API Integration & Development, Network Configuration & Troubleshooting\' has been approved by PESO admin and is now active.', 0, NULL, '2026-05-24 19:03:17', '2026-05-24 19:03:17');

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

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `peso_job_id` bigint(20) UNSIGNED NOT NULL,
  `is_referred` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('pending','reviewed','interviewed','hired','rejected','reviewing','shortlisted','interview') DEFAULT 'pending',
  `admin_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_approved_at` timestamp NULL DEFAULT NULL,
  `employer_status` enum('interview_scheduled','hired','not_selected') DEFAULT NULL,
  `final_decision` enum('pending','hired','not_selected') NOT NULL DEFAULT 'pending',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `resume_original_filename` varchar(255) DEFAULT NULL,
  `resume_file_extension` varchar(255) DEFAULT NULL,
  `resume_type` enum('upload','profile','builder') NOT NULL DEFAULT 'upload',
  `employer_feedback` text DEFAULT NULL,
  `interview_scheduled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin_approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `user_id`, `peso_job_id`, `is_referred`, `status`, `admin_status`, `admin_approved_at`, `employer_status`, `final_decision`, `applied_at`, `notes`, `resume_path`, `resume_original_filename`, `resume_file_extension`, `resume_type`, `employer_feedback`, `interview_scheduled_at`, `created_at`, `updated_at`, `admin_approved_by`, `admin_notes`) VALUES
(1, 10, 1, 0, 'interview', 'pending', NULL, 'interview_scheduled', 'pending', '2026-05-06 01:59:55', NULL, 'builder:8', NULL, NULL, 'builder', NULL, '2026-05-06 03:04:00', '2026-05-05 17:59:55', '2026-05-05 19:04:59', NULL, NULL);

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
(7, '2026_03_26_000001_add_role_to_users_table', 1),
(8, '2026_03_30_053607_create_sessions_table', 2),
(9, '2026_04_15_000001_add_resume_sections_to_user_profiles_table', 3),
(10, '2026_04_15_000002_add_resume_identity_to_user_profiles_table', 4),
(11, '2026_04_16_000001_add_dynamic_profile_sections_to_user_profiles_table', 5),
(12, '2026_04_15_000001_add_employer_feature_fields', 6),
(13, '2026_04_15_000002_create_recruitment_activity_requests_table', 6),
(14, '2026_04_15_000003_create_employer_notifications_table', 6),
(15, '2026_04_15_000004_add_approval_fields_to_users_table', 6),
(16, '2026_04_16_000004_add_employer_profile_fields_to_user_profiles_and_username_to_users', 6),
(17, '2026_04_16_120000_add_optional_job_detail_columns_to_peso_jobs_table', 6),
(18, '2026_04_16_123000_expand_peso_jobs_status_enum', 6),
(19, '2026_04_21_000000_create_missing_tables', 6),
(20, '2026_04_21_000001_create_portal_notifications_table', 6),
(21, '2026_04_21_000001_setup_approval_workflow', 6),
(22, '2026_04_21_000002_create_user_notifications_table', 6),
(23, '2026_04_22_000001_add_admin_approval_to_job_applications_table', 6),
(24, '2026_04_22_000001_create_company_profiles_table', 6),
(25, '2026_04_23_000001_add_verification_to_company_profiles_table', 6),
(26, '2026_04_23_000002_add_profile_photo_to_users_table', 6),
(27, '2026_04_23_003000_fix_company_profiles_defaults', 6),
(28, '2026_04_27_000001_add_deletion_reason_to_peso_jobs_table', 6),
(29, '2026_04_27_000001_update_peso_clearances_for_requests', 6),
(30, '2026_04_28_000001_add_updated_profile_sections_to_user_profiles_table', 6),
(31, '2026_04_28_000010_update_employer_notifications_type_enum', 6),
(32, '2026_04_29_000000_add_documents_to_peso_clearances', 6),
(33, '2026_04_30_000001_add_resume_fields_to_job_applications', 6),
(34, '2026_04_30_000002_add_interview_scheduled_at_to_job_applications_table', 6),
(35, '2026_04_30_000003_expand_job_applications_status_enum', 6),
(36, '2026_05_05_000001_add_resume_original_filename_to_job_applications', 6),
(37, '2026_05_05_000002_add_resume_file_extension_to_job_applications', 6),
(38, '2026_05_11_000001_create_contact_submissions_table', 7),
(39, '2026_05_11_000002_add_inquiry_fields_to_contact_submissions_table', 8),
(40, '2026_05_25_000001_add_missing_profile_fields_to_jobseeker_profiles_table', 9);

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
  `request_date` datetime DEFAULT NULL,
  `clearance_number` varchar(255) NOT NULL,
  `issue_date` datetime DEFAULT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `remarks` text DEFAULT NULL,
  `peso_clearance_assurance_receipt_path` varchar(255) DEFAULT NULL,
  `barangay_clearance_path` varchar(255) DEFAULT NULL,
  `is_first_time_jobseeker` tinyint(1) NOT NULL DEFAULT 0,
  `first_time_jobseeker_document_path` varchar(255) DEFAULT NULL,
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
(1, 11, 'sdsdaadada', 'sdsdaadada', 'adadadadadada', '• zczczc', '• zczczc', '• zczczc', '• zczcz', 'zczczc', '• zczczc', 'James Ivan', 'cc', 'full_time', 1, '2026-05-05', '2033-01-02', '3000 - 4000', '3000 - 4000', NULL, 'active', '2026-05-05 17:58:38', 8, NULL, NULL, NULL, 0, NULL, NULL, '2026-05-04 22:52:01', '2026-05-05 17:58:38'),
(2, 11, 'ajdoadjaokaofafpoa', 'ajdoadjaokaofafpoa', 'dalkdaodkapdap', '• adlkjad;akd;a', '• adalkmd;lsadma', '• adkjad;kadpakd', '• adoajpodakdpa', 'adsaokda', '• adssadsad', 'James Ivan', 'ajoafjpoafkjapofa', 'contract', 1, '2026-05-06', '4220-12-31', '0 - 2000', '0 - 2000', NULL, 'active', '2026-05-05 18:39:20', 8, NULL, NULL, NULL, 0, NULL, NULL, '2026-05-05 18:39:13', '2026-05-05 18:39:20'),
(3, 11, 'dfasfdsfsdf', 'dfasfdsfsdf', 'asdadadafsgaflksfdslkfmslfmslfs', '• alda;kd;ada', '• jxjzscojcoscaosadadoakdo', '• Computer Literate, Programming, Database, JavaScript, HTML/CSS, Git, Database Management, Frontend Development (Web UI), API Integration & Development, Network Configuration & Troubleshooting', '• kjdflakfjlksfdsa', 'adiuaodaodaodsa', '• ljaskdjalkd', 'James Ivan', 'Crossing Libona', 'part_time', 100, '2026-05-25', '2026-06-07', '12000 - 14000', '12000 - 14000', NULL, 'active', '2026-05-24 17:58:24', 8, NULL, NULL, NULL, 0, NULL, NULL, '2026-05-24 17:58:05', '2026-05-24 17:58:24'),
(4, 11, 'Computer Literate, Programming, Database, JavaScript, HTML/CSS, Git, Database Management, Frontend Development (Web UI), API Integration & Development, Network Configuration & Troubleshooting', 'Computer Literate, Programming, Database, JavaScript, HTML/CSS, Git, Database Management, Frontend Development (Web UI), API Integration & Development, Network Configuration & Troubleshooting', 'Computer Literate, Programming, Database, JavaScript, HTML/CSS, Git, Database Management, Frontend Development (Web UI), API Integration & Development, Network Configuration & Troubleshooting', '• Computer Literate, Programming, Database, JavaScript, HTML/CSS, Git, Database Management, Frontend Development (Web UI), API Integration & Development, Network Configuration & Troubleshooting', '• Computer Literate, Programming, Database, JavaScript, HTML/CSS, Git, Database Management, Frontend Development (Web UI), API Integration & Development, Network Configuration & Troubleshooting', '• Computer Literate, Programming, Database, JavaScript, HTML/CSS, Git, Database Management, Frontend Development (Web UI), API Integration & Development, Network Configuration & Troubleshooting', '• Computer Literate, Programming, Database, JavaScript, HTML/CSS, Git, Database Management, Frontend Development (Web UI), API Integration & Development, Network Configuration & Troubleshooting', 'Computer Literate, Programming, Database, JavaScript, HTML/CSS, Git, Database Management, Frontend Development (Web UI), API Integration & Development, Network Configuration & Troubleshooting', '• Computer Literate, Programming, Database, JavaScript, HTML/CSS, Git, Database Management, Frontend Development (Web UI), API Integration & Development, Network Configuration & Troubleshooting', 'James Ivan', 'Crossing Libona', 'contract', 120, '2026-05-25', '2026-06-27', '12000 - 14000', '12000 - 14000', NULL, 'active', '2026-05-24 19:03:17', 8, NULL, NULL, NULL, 0, NULL, NULL, '2026-05-24 19:03:08', '2026-05-24 19:03:17');

-- --------------------------------------------------------

--
-- Table structure for table `portal_notifications`
--

CREATE TABLE `portal_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `portal_notifications`
--

INSERT INTO `portal_notifications` (`id`, `title`, `message`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Application Status Updated', 'Your application for sdsdaadada has been updated to Rejected.', 11, '2026-05-05 18:36:02', '2026-05-05 18:36:02'),
(2, 'Application Status Updated', 'Your application for sdsdaadada has been updated to Pending.', 11, '2026-05-05 18:37:14', '2026-05-05 18:37:14'),
(3, 'Application Status Updated', 'Your application for sdsdaadada has been updated to Rejected.', 11, '2026-05-05 18:37:26', '2026-05-05 18:37:26'),
(4, 'Job Post Pending Approval', 'James Ivan submitted a new job post \'ajdoadjaokaofafpoa\' and it is waiting for admin approval.', 11, '2026-05-05 18:39:13', '2026-05-05 18:39:13'),
(5, 'Application Status Updated', 'Your application for sdsdaadada has been updated to Pending.', 11, '2026-05-05 18:56:29', '2026-05-05 18:56:29'),
(6, 'Application Status Updated', 'Your application for sdsdaadada has been updated to Interview Scheduled.', 11, '2026-05-05 18:57:20', '2026-05-05 18:57:20'),
(7, 'Application Status Updated', 'Your application for sdsdaadada has been updated to Hired.', 11, '2026-05-05 18:57:37', '2026-05-05 18:57:37'),
(8, 'Application Status Updated', 'Your application for sdsdaadada has been updated to Under Review.', 11, '2026-05-05 18:57:51', '2026-05-05 18:57:51'),
(9, 'Application Status Updated', 'Your application for sdsdaadada has been updated to Interview Scheduled.', 11, '2026-05-05 19:01:28', '2026-05-05 19:01:28'),
(10, 'Application Status Updated', 'Your application for sdsdaadada has been updated to Under Review.', 11, '2026-05-05 19:02:18', '2026-05-05 19:02:18'),
(11, 'Application Status Updated', 'Your application for sdsdaadada has been updated to Interview Scheduled. Interview scheduled for May 06, 2026 11:04 AM.', 11, '2026-05-05 19:04:59', '2026-05-05 19:04:59'),
(12, 'New Contact Form Message', 'James Ivan (20221351@nbsc.edu.ph) submitted a contact form message about \"dasdadadadadla;dad\".', NULL, '2026-05-10 19:13:06', '2026-05-10 19:13:06'),
(13, 'New Contact Form Message', 'James Ivan (jamesivanfelicitas@gmail.com) submitted a contact form message about \"Testing\".', NULL, '2026-05-12 16:03:56', '2026-05-12 16:03:56'),
(14, 'New Contact Form Message', 'James Ivan (20201293@nbsc.edu.ph) submitted a contact form message about \"Testing\".', NULL, '2026-05-21 22:00:40', '2026-05-21 22:00:40'),
(15, 'New Contact Form Message', 'Naviiiii (jamesivanfelicitas@gmail.com) submitted a contact form message about \"sdada\".', NULL, '2026-05-21 22:01:20', '2026-05-21 22:01:20'),
(16, 'Job Post Pending Approval', 'James Ivan submitted a new job post \'dfasfdsfsdf\' and it is waiting for admin approval.', 11, '2026-05-24 17:58:05', '2026-05-24 17:58:05'),
(17, 'Job Post Pending Approval', 'James Ivan submitted a new job post \'Computer Literate, Programming, Database, JavaScript, HTML/CSS, Git, Database Management, Frontend Development (Web UI), API Integration & Development, Network Configuration & Troubleshooting\' and it is waiting for admin approval.', 11, '2026-05-24 19:03:08', '2026-05-24 19:03:08');

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

--
-- Dumping data for table `recommended_jobs`
--

INSERT INTO `recommended_jobs` (`id`, `user_id`, `job_id`, `match_score`, `reason`, `created_at`, `updated_at`) VALUES
(1, 10, 4, 40.00, 'Relevant skills matched: Computer Literate, Programming, Database', '2026-05-24 19:40:50', '2026-05-24 19:40:50'),
(2, 10, 3, 40.00, 'Relevant skills matched: Computer Literate, Programming, Database', '2026-05-24 19:40:50', '2026-05-24 19:40:50'),
(3, 10, 2, 10.00, 'Missing skills to review: Adkjad, Kadpakd', '2026-05-24 19:40:50', '2026-05-24 19:40:50');

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

--
-- Dumping data for table `saved_jobs`
--

INSERT INTO `saved_jobs` (`id`, `user_id`, `job_id`, `created_at`, `updated_at`) VALUES
(4, 10, 1, '2026-05-05 21:48:47', '2026-05-05 21:48:47'),
(5, 10, 2, '2026-05-14 23:08:50', '2026-05-14 23:08:50');

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
('q78sn0X7vlA7pRO59in5Qz2gOfkhC13FUWF5SfGS', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJhWk1iQzNmTlBKR1ZQMTdITUFRcHFmc29WcWRmREJoNFJROVpEMFFGIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2pvYnNlZWtlclwvcHJvZmlsZSIsInJvdXRlIjoiam9ic2Vla2VyLnByb2ZpbGUifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjh9', 1776736792);

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
  `is_approved` tinyint(1) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `is_employer_verified` tinyint(1) NOT NULL DEFAULT 0,
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

INSERT INTO `users` (`id`, `name`, `email`, `profile_photo`, `username`, `role`, `is_approved`, `approved_at`, `is_employer_verified`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `approved_by`, `rejection_reason`, `rejected_at`, `rejected_by`) VALUES
(8, 'James Ivan C. Felicitas', 'jamesivanfelicitas@gmail.com', NULL, NULL, 'admin', NULL, NULL, 0, NULL, '$2y$12$J4WNGmoLNP8ElZzWHxMg5elPIk9VkRLTS22lxFvpG3/bBiTp3sj4u', NULL, '2026-04-15 19:07:47', '2026-04-15 19:07:47', NULL, NULL, NULL, NULL),
(10, 'James Ivan asdad', '20221351@nbsc.edu.ph', NULL, NULL, 'jobseeker', NULL, NULL, 0, NULL, '$2y$12$FYleDLqybvJiylr5sUB3jO3N7HmM5ylUkPZD7QTXjKGahEtsrmyOm', NULL, '2026-04-20 21:53:32', '2026-05-24 19:22:50', NULL, NULL, NULL, NULL),
(11, 'James Ivan', '20201292@nbsc.edu.ph', NULL, NULL, 'employer', NULL, NULL, 0, NULL, '$2y$12$txEfI3sPNoN56iL1w9Gfc.hh2kCoSQ/.2QOvTHUq5tGYXksza0ehe', NULL, '2026-05-04 22:49:44', '2026-05-04 22:49:44', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `portal_notification_id` bigint(20) UNSIGNED NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`id`, `user_id`, `portal_notification_id`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 10, 1, NULL, '2026-05-05 18:36:02', '2026-05-05 18:36:02'),
(2, 10, 2, NULL, '2026-05-05 18:37:14', '2026-05-05 18:37:14'),
(3, 10, 3, NULL, '2026-05-05 18:37:26', '2026-05-05 18:37:26'),
(4, 8, 4, NULL, '2026-05-05 18:39:13', '2026-05-05 18:39:13'),
(5, 10, 5, NULL, '2026-05-05 18:56:29', '2026-05-05 18:56:29'),
(6, 10, 6, NULL, '2026-05-05 18:57:20', '2026-05-05 18:57:20'),
(7, 10, 7, NULL, '2026-05-05 18:57:37', '2026-05-05 18:57:37'),
(8, 10, 8, NULL, '2026-05-05 18:57:51', '2026-05-05 18:57:51'),
(9, 10, 9, '2026-05-21 22:28:07', '2026-05-05 19:01:28', '2026-05-21 22:28:07'),
(10, 10, 10, NULL, '2026-05-05 19:02:18', '2026-05-05 19:02:18'),
(11, 10, 11, NULL, '2026-05-05 19:04:59', '2026-05-05 19:04:59'),
(12, 8, 12, NULL, '2026-05-10 19:13:06', '2026-05-10 19:13:06'),
(13, 8, 13, NULL, '2026-05-12 16:03:56', '2026-05-12 16:03:56'),
(14, 8, 14, NULL, '2026-05-21 22:00:40', '2026-05-21 22:00:40'),
(15, 8, 15, NULL, '2026-05-21 22:01:20', '2026-05-21 22:01:20'),
(16, 8, 16, NULL, '2026-05-24 17:58:05', '2026-05-24 17:58:05'),
(17, 8, 17, NULL, '2026-05-24 19:03:08', '2026-05-24 19:03:08');

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
-- Indexes for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contact_submissions_reference_code_unique` (`reference_code`),
  ADD KEY `contact_submissions_portal_notification_id_foreign` (`portal_notification_id`),
  ADD KEY `contact_submissions_created_at_index` (`created_at`);

--
-- Indexes for table `contact_submission_messages`
--
ALTER TABLE `contact_submission_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_submission_messages_contact_submission_id_foreign` (`contact_submission_id`),
  ADD KEY `contact_submission_messages_sent_by_user_id_foreign` (`sent_by_user_id`);

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
-- Indexes for table `portal_notifications`
--
ALTER TABLE `portal_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `portal_notifications_created_by_foreign` (`created_by`);

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
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_notifications_user_id_portal_notification_id_unique` (`user_id`,`portal_notification_id`),
  ADD KEY `user_notifications_portal_notification_id_foreign` (`portal_notification_id`),
  ADD KEY `user_notifications_user_id_read_at_index` (`user_id`,`read_at`);

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
-- AUTO_INCREMENT for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_submission_messages`
--
ALTER TABLE `contact_submission_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employer_documents`
--
ALTER TABLE `employer_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employer_notifications`
--
ALTER TABLE `employer_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `portal_notifications`
--
ALTER TABLE `portal_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `recommended_jobs`
--
ALTER TABLE `recommended_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `recruitment_activity_requests`
--
ALTER TABLE `recruitment_activity_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_templates`
--
ALTER TABLE `report_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- Constraints for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD CONSTRAINT `contact_submissions_portal_notification_id_foreign` FOREIGN KEY (`portal_notification_id`) REFERENCES `portal_notifications` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `contact_submission_messages`
--
ALTER TABLE `contact_submission_messages`
  ADD CONSTRAINT `contact_submission_messages_contact_submission_id_foreign` FOREIGN KEY (`contact_submission_id`) REFERENCES `contact_submissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contact_submission_messages_sent_by_user_id_foreign` FOREIGN KEY (`sent_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `portal_notifications`
--
ALTER TABLE `portal_notifications`
  ADD CONSTRAINT `portal_notifications_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

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
-- Constraints for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `user_notifications_portal_notification_id_foreign` FOREIGN KEY (`portal_notification_id`) REFERENCES `portal_notifications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
