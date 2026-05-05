-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2026 at 03:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.5.3

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

--
-- Dumping data for table `company_profiles`
--

INSERT INTO `company_profiles` (`id`, `user_id`, `company_name`, `business_name`, `trade_name`, `acronym_abbreviation`, `office_type`, `employer_type_detail`, `workforce_size`, `tin`, `line_of_business`, `street_village`, `barangay`, `city_municipality`, `establishment_contact_person`, `establishment_contact_position`, `establishment_email`, `establishment_phone`, `contact_person_name`, `contact_person_phone`, `business_permit_path`, `dti_sec_registration_path`, `description`, `industry`, `company_size`, `website`, `phone`, `address`, `city`, `province`, `postal_code`, `tin_number`, `logo_path`, `verification_status`, `verification_notes`, `verified_at`, `about_company`, `created_at`, `updated_at`, `verified_by`, `deleted_at`) VALUES
(1, 1, 'NexaCore Solutions Inc.', 'NexaCore Solutions Inc.', 'NexaCore Solutions', 'NCSI', 'main_office', 'gocc', 'medium', '123-456-789-683', 'IT Services, Software Development, and Network Solutions', '123 Mabini Street, Golden Meadows Subdivision', 'Carmen', 'Cagayan de Oro City', 'Zean Kyle Tapac', 'HR manager', '20221230@nbsc.edu.ph', '', 'James Ivan Felicitas', '09351432467', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Misamis Oriental', NULL, NULL, 'company-profiles/nEJsAtGiUVHIBz7lWi7JrpuDnLLKhrqldbE7C8cI.png', 'pending', NULL, NULL, NULL, '2026-04-23 00:00:43', '2026-04-23 00:01:18', NULL, NULL);

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
(4, '2024_10_01_000001_create_peso_jobs_table', 2),
(5, '2024_10_01_000002_create_job_applications_table', 2),
(6, '2024_10_01_000003_create_user_profiles_table', 2),
(7, '2026_03_26_000001_add_role_to_users_table', 3),
(8, '2026_04_15_000001_add_employer_feature_fields', 4),
(9, '2026_04_15_000002_create_recruitment_activity_requests_table', 4),
(10, '2026_04_15_000003_create_employer_notifications_table', 4),
(11, '2026_04_16_000004_add_employer_profile_fields_to_user_profiles_and_username_to_users', 5),
(12, '2026_04_16_120000_add_optional_job_detail_columns_to_peso_jobs_table', 6),
(13, '2026_04_16_123000_expand_peso_jobs_status_enum', 7),
(14, '2026_03_30_053607_create_sessions_table', 8),
(15, '2026_04_15_000001_add_resume_sections_to_user_profiles_table', 8),
(16, '2026_04_15_000002_add_resume_identity_to_user_profiles_table', 8),
(17, '2026_04_15_000004_add_approval_fields_to_users_table', 8),
(18, '2026_04_16_000001_add_dynamic_profile_sections_to_user_profiles_table', 8),
(19, '2026_04_21_000000_create_missing_tables', 8),
(20, '2026_04_21_000001_create_portal_notifications_table', 8),
(21, '2026_04_21_000001_setup_approval_workflow', 8),
(22, '2026_04_21_000002_create_user_notifications_table', 8),
(23, '2026_04_22_000001_add_admin_approval_to_job_applications_table', 8),
(24, '2026_04_22_000001_create_company_profiles_table', 9),
(25, '2026_04_23_000001_add_verification_to_company_profiles_table', 10),
(26, '2026_04_23_000002_add_profile_photo_to_users_table', 10);

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

INSERT INTO `peso_jobs` (`id`, `employer_id`, `title`, `position`, `description`, `qualifications`, `key_responsibilities`, `preferred_skills`, `experience`, `education`, `benefits`, `employer_name`, `location`, `job_type`, `vacancies`, `application_start_date`, `application_end_date`, `salary_range`, `salary`, `requirements`, `status`, `approved_at`, `approved_by`, `rejection_reason`, `archived_at`, `is_filled`, `filled_at`, `source_job_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Software Developer', 'Software Developer', 'NexaCore Solutions Inc. is seeking a skilled Software Developer to design, develop, and maintain software applications that support business operations and client solutions. The ideal candidate will work with a team of developers to build reliable, scalable, and efficient systems.', 'Strong analytical and problem-solving skills\r\nAbility to work both independently and in a team environment\r\nGood communication and documentation skills\r\nAbility to meet project deadlines', 'Develop and maintain web and software applications\r\nWrite clean, efficient, and well-documented code\r\nTest and debug applications to ensure optimal performance\r\nCollaborate with designers, developers, and project managers\r\nParticipate in code reviews and system improvements\r\nMaintain application security and data protection standards', 'Proficiency in HTML, CSS, JavaScript, and PHP\r\nKnowledge of Laravel or other web frameworks\r\nFamiliarity with MySQL or other relational databases\r\nUnderstanding of Git version control\r\nBasic knowledge of RESTful APIs', 'At least 1–2 years of experience in software or web development (fresh graduates may apply).', 'Bachelor’s degree in Information Technology, Computer Science, Software Engineering, or related field', 'Government benefits (SSS, PhilHealth, Pag-IBIG)\r\nHealth insurance coverage\r\nPaid leave credits\r\nTraining and professional development programs\r\nCareer advancement opportunities', 'NexaCore Solutions Inc.', 'Cagayan de Oro City (On-site / Hybrid)', 'full_time', 4, '2026-04-16', '2026-06-18', '25000 - 35000', '25000 - 35000', NULL, 'pending', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-15 21:18:24', '2026-04-15 21:18:24'),
(2, 1, 'Senior Software Developer', 'Senior Software Developer', 'NexaCore Solutions Inc. is seeking an experienced Senior Software Developer to lead the design, development, and maintenance of high-quality software applications. The ideal candidate will guide development teams, review code, and ensure that systems are scalable, secure, and efficient while meeting business and client requirements.', '• Strong leadership and problem-solving abilities\r\n• Excellent communication and teamwork skills\r\n• Ability to manage multiple development tasks and deadlines\r\n• Strong understanding of software development lifecycle (SDLC)', '• Design, develop, and maintain complex software applications\r\n• Lead and mentor junior developers in coding standards and best practices\r\n• Review, test, and debug software to ensure high performance and reliability\r\n• Collaborate with project managers, designers, and stakeholders\r\n• Participate in system architecture planning and technical decisions\r\n• Ensure software security, scalability, and maintainability\r\n• Document system features, processes, and technical specifications', '• Advanced knowledge of PHP, JavaScript, HTML, and CSS\r\n• Experience with Laravel or other modern web frameworks\r\n• Strong knowledge of MySQL or relational databases\r\n• Experience with Git version control\r\n• Understanding of RESTful APIs and backend services\r\n• Knowledge of software architecture and design patterns', '• 4–6 years of professional experience in software development\r\n• Experience leading development teams or mentoring junior developers is an advantage', 'Bachelor’s degree in Computer Science, Information Technology, Software Engineering, or related field', '• Government benefits (SSS, PhilHealth, Pag-IBIG)\r\n• Health insurance and medical assistance\r\n• Paid vacation and sick leave\r\n• Training, certifications, and professional development\r\n• Performance bonuses and career advancement opportunities', 'NexaCore Solutions Inc.', 'Cagayan de Oro City (On-site / Hybrid)', 'full_time', 3, '2026-04-16', '2026-06-04', '45000 - 65000', '45000 - 65000', NULL, 'pending', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-15 21:41:00', '2026-04-15 21:41:00'),
(3, 1, 'System Analyst', 'System Analyst', 'NexaCore Solutions Inc. is looking for a System Analyst to evaluate business requirements and translate them into technical solutions. The role involves working closely with developers and stakeholders to improve system efficiency.', '• Strong analytical and critical thinking skills\r\n• Good communication and documentation abilities\r\n• Ability to work with both technical and non-technical team', '• Analyze business and system requirements\r\n• Create system specifications and documentation\r\n• Coordinate with developers and project teams\r\n• Test and validate system functionality\r\n• Recommend system improvements', '• Knowledge of system analysis and design\r\n• Familiarity with SDLC (Software Development Life Cycle)\r\n• Basic understanding of databases and programming\r\n• Experience with documentation tools', '• At least 2–4 years of experience in system analysis or related role', 'Bachelor’s degree in Information Technology, Computer Science, or related field', '• Government benefits (SSS, PhilHealth, Pag-IBIG)\r\n• Health insurance\r\n• Paid leave credits\r\n• Career growth opportunities', 'NexaCore Solutions Inc.', 'Cagayan de Oro City (On-site / Hybrid)', 'full_time', 2, '2026-04-20', '2026-05-29', '35000 - 50000', '35000 - 50000', NULL, 'pending', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-19 17:29:03', '2026-04-19 17:29:03'),
(4, 1, 'Network Administrator', 'Network Administrator', 'NexaCore Solutions Inc. is seeking a Network Administrator responsible for maintaining and securing the company’s network infrastructure.', '• Strong problem-solving and troubleshooting skills\r\n• Ability to manage network systems efficiently\r\n• Good communication skills', '• Manage and monitor network systems\r\n• Install and configure network hardware\r\n• Troubleshoot network issues\r\n• Ensure network security and performance\r\n• Maintain network documentatio', '• Knowledge of networking (LAN/WAN)\r\n• Experience with routers, switches, firewalls\r\n• Familiarity with network security practices\r\n• Understanding of Windows/Linux servers', '• At least 2–3 years of experience in network administration', 'Bachelor’s degree in Information Technology, Computer Engineering, or related field', '• Government benefits (SSS, PhilHealth, Pag-IBIG)\r\n• Health insurance\r\n• Paid training and certifications\r\n• Performance bonuses', 'NexaCore Solutions Inc.', 'Cagayan de Oro City (On-site / Hybrid)', 'full_time', 1, '2026-04-20', '2026-06-15', '30000 - 45000', '30000 - 45000', NULL, 'pending', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-19 17:34:39', '2026-04-19 17:34:39'),
(5, 1, 'Machine Maintenance Technician', 'Machine Maintenance Technician', 'Responsible for maintaining and repairing factory machines to ensure smooth and continuous production operations.', '• Technical/Vocational course in Electrical or Mechanical Technology', '• Perform routine machine maintenance\r\n• Troubleshoot equipment issues\r\n• Replace defective machine parts\r\n• Maintain maintenance reco', '• Troubleshooting\r\n• Technical repair skills\r\n• Knowledge of factory equipment', '• At least 1 year in machine maintenance', 'Technical/Vocational Diploma in Electrical Technology, Mechanical Technology, or related field', '• Overtime pay\r\n• Free uniform\r\n• Government benefits', 'NexaCore Solutions Inc.', 'Cagayan de Oro City', 'full_time', 2, '2026-04-20', '2026-08-05', '15000 - 22000', '15000 - 22000', NULL, 'pending', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-19 21:01:21', '2026-04-19 21:01:21'),
(6, 1, 'Packaging Specialist', 'Packaging Specialist', 'Handles the design, inspection, and quality of eco-friendly packaging materials produced by the company.', '• Attention to detail\r\n• Basic knowledge of packaging processes', '• Ensure proper packaging standards\r\n• Inspect packaging quality\r\n• Coordinate with production team\r\n• Suggest improvements for eco-friendly packaging', '• Creativity\r\n• Quality control\r\n• Teamwork', '• Experience in packaging or manufacturing is an advantage', 'Senior High School Graduate or College Level (Industrial Technology, Packaging Technology, or related field is an advantage)', '• Meal allowance\r\n• Government benefits\r\n• 13th month pay', 'NexaCore Solutions Inc.', 'Cagayan de Oro City', 'full_time', 4, '2026-04-20', '2026-06-11', '13000 - 16000', '13000 - 16000', NULL, 'pending', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2026-04-19 21:03:12', '2026-04-19 21:03:12');

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
('TkZjSdaA3MM91U2nJi2IMUNFLa0ow44CpAwHj25x', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI5S0tTNHRaWEE5ZU9idTJTc2VhZ1dXelhhUDVRSUJLcDhFb3NxbVluIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2xvZ2luIiwicm91dGUiOiJsb2dpbiJ9fQ==', 1777345231),
('wAxw0kxCZjZINjIYZCNpzv9Xpu5tdTgKauyYlYGV', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJjZTd4V2VhRTA1SnlPZlhpN0hWcVZ1NFdyVmx0dGZSRWQ2MVl5eW9vIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2VtcGxveWVyXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImVtcGxveWVyLmRhc2hib2FyZCJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6Mn0=', 1777338276),
('xTvW5hw69RQVvu6tY8Q6cEnBe1NCh9AehmPUn2e8', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJLbk5IQ2dkaGc2QlprTjNlSUpWSk5kTjNlTWVFaTZXNm1Cbnd4VXJtIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9lbXBsb3llclwvZGFzaGJvYXJkIiwicm91dGUiOiJlbXBsb3llci5kYXNoYm9hcmQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1777339692);

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
(1, 'NexaCore Solutions Inc.', 'jamesivanfelicitas@gmail.com', NULL, 'NCSI', 'employer', NULL, NULL, 0, NULL, '$2y$12$d6/LYzg0Vbwt3hGyqALvv.3eqKLsysA3aXrA3b4LYtVgqFlSlErOq', 'cJs9s28r1b199ksXsyUQ4Xv8QR7xsF64EOTg7GR7pAS14jdyJMT2pfv5cvWz', '2026-04-14 21:23:39', '2026-04-19 19:45:16', NULL, NULL, NULL, NULL),
(3, 'Zean Kyle C. Tapac', 'kyletapac4@gmail.com', NULL, NULL, 'jobseeker', NULL, NULL, 0, NULL, '$2y$12$kPx0wylAsdhoPqDH3Sisf.TqTNfk9tMKSIBG2jiuR98AIMryMiohq', NULL, '2026-04-26 16:27:43', '2026-04-26 16:32:31', NULL, NULL, NULL, NULL);

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
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NexaCore Solutions Inc.', 'NexaCore Solutions Inc.', 'NexaCore Solutions', 'NCSI', 'main_office', '123-456-789-683', 'gocc', 'small', 'IT Services, Software Development, and Network Solutions', '123 Mabini Street, Golden Meadows Subdivision', 'Carmen', 'Cagayan de Oro City', 'Misamis Oriental', 'Zean Kyle Tapac', 'James Ivan Felicitas', 'HR manager', NULL, '09351432467', 'jamesivanfelicitas@gmail.com', 'company-profiles/Pw3kem5HnbdZ0bAzd6CzK2DqgDsPHp1Awas75jnu.png', NULL, NULL, 'pending', NULL, '2026-04-15 15:59:58', '2026-04-15 17:36:50'),
(3, 3, '{\"surname\":\"Tapac\",\"first_name\":\"Zean Kyle\",\"middle_initial\":\"C.\",\"suffix\":null,\"date_of_birth\":\"2004-01-08\",\"sex\":\"Male\",\"religion\":\"Born Again\",\"civil_status\":\"single\",\"height\":\"157\",\"tin\":null,\"contact_number\":\"09126536757\",\"email_address\":\"kyletapac4@gmail.com\",\"currently_in_school\":true}', '{\"house_no\":\"Zone 5 Sayre Highway\",\"barangay\":\"Maluko\",\"municipality\":\"Manolo Fortich\",\"province\":\"Bukidnon\"}', '{\"house_no\":\"Zone 5 Sayre Highway\",\"barangay\":\"Maluko\",\"municipality\":\"Manolo Fortich\",\"province\":\"Bukidnon\"}', 'Zean Kyle C. Tapac', 'kyletapac4@gmail.com', '09126536757', 'Zone 5 Sayre Highway Maluko, Manolo Fortich, Bukidnon', NULL, '[\"Driver\",\"Microsoft Office\",\"Web Development\",\"Programming\",\"Database\",\"JavaScript\",\"HTML\\/CSS\",\"Git\",\"Frontend Development (Web UI)\",\"Network Configuration & Troubleshooting\",\"Hardware Installation & Repair\",\"React.js\",\"Node.js\",\"MySQL (Database)\",\"Laravel (Backend)\",\"Adaptability\",\"Time Management\",\"Team Collaboration\"]', '[{\"school\":\"Maluko Elementary School\",\"course\":\"\",\"year\":\"2015 - 2016\"},{\"school\":\"Manolo Fortich National High School\",\"course\":\"CCS\",\"year\":\"2021 - 2022\"},{\"school\":\"Northern Bukidnon State College\",\"course\":\"Bachelor of Science in Information Technology\",\"year\":\"2025 - 2026\"}]', '[]', '[{\"title\":\"Intern\",\"company\":\"PESO\",\"period\":\"\",\"details\":\"Successfully completed the required 486 hours of on-the-job training (OJT)\"},{\"title\":\"Computer Technician\",\"company\":\"jmwebvision\",\"period\":\"\",\"details\":\"Chose to continue academic studies full-time to strengthen my technical knowledge\"}]', '[]', '{\"trade_manual\":[\"Driver\"],\"it_technical\":[\"Microsoft Office\",\"Web Development\",\"Programming\",\"Database\",\"JavaScript\",\"HTML\\/CSS\",\"Git\",\"Frontend Development (Web UI)\",\"Network Configuration & Troubleshooting\",\"Hardware Installation & Repair\",\"React.js\",\"Node.js\",\"MySQL (Database)\",\"Laravel (Backend)\"],\"soft_skills\":[\"Adaptability\",\"Time Management\",\"Team Collaboration\"],\"other_text\":\"\",\"with_certificate\":false,\"by_experience\":false}', '{\"wage_employed\":false,\"self_employed\":false,\"unemployed\":true,\"has_work_experience\":false}', '{\"part_time\":false,\"full_time\":true,\"local\":true,\"overseas\":false,\"occupation_text\":\"\"}', '[{\"language\":\"English\",\"read\":true,\"write\":true,\"speak\":true,\"understand\":true,\"other\":\"\"},{\"language\":\"Tagalog\",\"read\":true,\"write\":true,\"speak\":true,\"understand\":true,\"other\":\"\"},{\"language\":\"Visayan\",\"read\":true,\"write\":true,\"speak\":true,\"understand\":true,\"other\":\"\"},{\"language\":\"Others:\",\"read\":false,\"write\":false,\"speak\":false,\"understand\":false,\"other\":\"\"}]', '{\"visual\":false,\"speech\":false,\"mental\":false,\"hearing\":false,\"physical\":false,\"other\":false,\"other_text\":\"\"}', 'Motivated Information Technology graduate and detail-oriented Computer Technician seeking an entry-level position to leverage skills in web development, programming, and technical support. Equipped with hands-on experience in hardware installation, PC, laptop, and printer maintenance, I am committed to delivering efficient IT solutions, supporting system operations, and contributing to organizational success while continuously developing my technical expertise.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, '2026-04-26 16:32:31', '2026-04-26 21:21:28');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lra_requests`
--
ALTER TABLE `lra_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `portal_notifications`
--
ALTER TABLE `portal_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recommended_jobs`
--
ALTER TABLE `recommended_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
