-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2026 at 01:36 AM
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

--
-- Dumping data for table `applicant_feedback`
--

INSERT INTO `applicant_feedback` (`id`, `application_id`, `employer_id`, `feedback`, `rating`, `feedback_type`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'you can start next week', 5, 'professionalism', '2026-03-18 21:36:27', '2026-03-18 21:36:27'),
(2, 3, 1, 'i will contact you when the decision is final.', 4, 'interview_experience', '2026-03-18 21:38:37', '2026-03-18 21:38:37');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_post_id` bigint(20) UNSIGNED NOT NULL,
  `applicant_id` bigint(20) UNSIGNED NOT NULL,
  `cover_letter` text DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','reviewing','shortlisted','interview','hired','rejected') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `interview_scheduled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `job_post_id`, `applicant_id`, `cover_letter`, `resume_path`, `status`, `notes`, `applied_at`, `interview_scheduled_at`, `created_at`, `updated_at`) VALUES
(1, 17, 3, 'i want  to apply', 'resumes/r8hODcj0tPkmkOAN6LfuofZkd2SXGV0K71pEfYT0.pdf', 'hired', 'Please don\'t be late...', '2026-03-16 16:37:09', '2026-03-19 01:30:00', '2026-03-16 16:37:09', '2026-03-18 18:46:16'),
(2, 13, 3, 'pa apply', 'resumes/FD4sNuJR4AznDvSxxW5DHEbkVZ4FEwsrD9P02eHY.pdf', 'rejected', NULL, '2026-03-16 19:11:30', '2026-03-20 03:00:00', '2026-03-16 19:11:30', '2026-03-16 19:26:52'),
(3, 12, 3, 'Dear Hiring Manager,\r\n\r\nI am applying for the Junior Web Developer position. I have basic experience in HTML, CSS, JavaScript, PHP, and MySQL, and I can build simple, responsive web applications.\r\n\r\nMy skills include frontend development, basic backend coding, database management, and problem-solving. I am eager to learn, hardworking, and willing to improve my skills.\r\n\r\nI would appreciate the opportunity to contribute to your team. Thank you for your time and consideration.\r\n\r\nSincerely,\r\nYami C. Uy\r\n09126536757', 'resumes/9dkRlSHgUOWt78jDgAaibDji2cCw5iHeV0WRpovl.pdf', 'interview', 'Don\'t be late', '2026-03-17 19:30:40', '2026-03-18 01:00:00', '2026-03-17 19:30:40', '2026-03-17 22:51:56'),
(4, 10, 3, NULL, 'resumes/9dkRlSHgUOWt78jDgAaibDji2cCw5iHeV0WRpovl.pdf', 'hired', NULL, '2026-03-18 19:15:35', NULL, '2026-03-18 19:15:35', '2026-03-18 19:16:11'),
(5, 14, 3, 'pa apply', 'resumes/9dkRlSHgUOWt78jDgAaibDji2cCw5iHeV0WRpovl.pdf', 'pending', NULL, '2026-04-15 01:08:17', NULL, '2026-04-15 01:08:17', '2026-04-15 01:08:17');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
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
  `office_type` varchar(255) DEFAULT NULL,
  `tin` varchar(255) DEFAULT NULL,
  `employer_type` varchar(255) DEFAULT NULL,
  `employer_type_detail` varchar(255) DEFAULT NULL,
  `workforce_size` varchar(255) DEFAULT NULL,
  `line_of_business` varchar(255) DEFAULT NULL,
  `street_village` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `city_municipality` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `company_size` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `establishment_phone` varchar(255) DEFAULT NULL,
  `establishment_email` varchar(255) DEFAULT NULL,
  `establishment_contact_person` varchar(255) DEFAULT NULL,
  `establishment_contact_position` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'Philippines',
  `logo_path` varchar(255) DEFAULT NULL,
  `business_permit_path` varchar(255) DEFAULT NULL,
  `dti_sec_registration_path` varchar(255) DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `contact_person_email` varchar(255) DEFAULT NULL,
  `contact_person_phone` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `verification_notes` text DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_profiles`
--

INSERT INTO `company_profiles` (`id`, `user_id`, `company_name`, `business_name`, `trade_name`, `acronym_abbreviation`, `office_type`, `tin`, `employer_type`, `employer_type_detail`, `workforce_size`, `line_of_business`, `street_village`, `barangay`, `city_municipality`, `province`, `industry`, `company_size`, `description`, `website`, `establishment_phone`, `establishment_email`, `establishment_contact_person`, `establishment_contact_position`, `phone`, `address`, `city`, `country`, `logo_path`, `business_permit_path`, `dti_sec_registration_path`, `contact_person_name`, `contact_person_email`, `contact_person_phone`, `is_verified`, `status`, `verification_notes`, `verified_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'NexaCore Solutions Inc.', 'NexaCore Solutions Inc.', 'NexaCore Solutions', 'NCSI', 'main_office', NULL, NULL, 'gocc', 'small', 'IT Services, Software Development, and Network Solutions', '123 Mabini Street, Golden Meadows Subdivision', 'Carmen', 'Cagayan de Oro City', 'Misamis Oriental', 'Information Technology / Software Development', NULL, 'A technology solutions company specializing in custom web and mobile application development, database systems, and cloud-based platforms for schools and small businesses.', NULL, NULL, 'nexcor@gmail.com', 'Adrian Michael Cruz', 'HR manager', NULL, 'Cagayan de Oro City', 'Cagayan de Oro City', 'Philippines', 'company_logos/JqVDpFqXjLHmWVxdeB2nNPn992jlMHPJ5O9QsOd2.png', 'company_documents/rQvA0BdV0gVVvqXSc30u2spFyS2MWOG3UxjNa0ah.pdf', 'company_documents/u0Bm0B73k5HF243afrU2vUSjn7DHRvUd3rPj7D6P.pdf', 'Michael Cole', '20221230@nbsc.edu.ph', '09351432467', 1, 'pending', NULL, NULL, '2026-03-04 21:50:34', '2026-04-15 22:16:50'),
(2, 4, 'NexaCore Solutions Inc.', 'NexaCore Solutions Inc.', 'NexaCore Solutions', 'NCSI', 'main_office', NULL, NULL, 'gocc', 'small', 'IT Services, Software Development, and Network Solutions', '123 Mabini Street, Golden Meadows Subdivision', 'Carmen', 'Cagayan de Oro City', 'Misamis Oriental', NULL, NULL, NULL, NULL, NULL, '20221230@nbsc.edu.ph', 'Michael Cole', 'HR manager', NULL, NULL, NULL, 'Philippines', 'company_logos/t1QuJ11U86aqUfxcXsEHlQEG2O5r0rKCYptK6I0o.png', NULL, NULL, 'Adrian Michael Cruz', NULL, '09351432467', 0, 'pending', NULL, NULL, '2026-03-10 19:35:54', '2026-03-10 19:35:54'),
(3, 2, 'NexaCore Solutions Inc.', 'NexaCore Solutions Inc.', 'NexaCore Solutions', 'NCSI', 'main_office', NULL, NULL, 'gocc', 'small', 'IT Services, Software Development, and Network Solutions', '123 Mabini Street, Golden Meadows Subdivision', 'Carmen', 'Cagayan de Oro City', 'Misamis Oriental', NULL, NULL, NULL, NULL, NULL, '20221230@nbsc.edu.ph', 'Michael Cole', 'HR manager', NULL, NULL, NULL, 'Philippines', 'company_logos/r98AuAZZWNKytVfnZzOBQ7JiGUg1xf6iPawsG4fy.png', NULL, NULL, 'Adrian Michael Cruz', NULL, '09351432467', 0, 'pending', NULL, NULL, '2026-03-10 22:26:44', '2026-03-10 22:26:44');

-- --------------------------------------------------------

--
-- Table structure for table `employer_documents`
--

CREATE TABLE `employer_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employer_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `original_file_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
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

--
-- Dumping data for table `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(1, '63121bc5-bb28-4e84-8b29-dc20e6a8d11f', 'database', 'default', '{\"uuid\":\"63121bc5-bb28-4e84-8b29-dc20e6a8d11f\",\"displayName\":\"App\\\\Events\\\\NewNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\NewNotification\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";N;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1773297733,\"delay\":null}', 'Error: The script tried to call a method on an incomplete object. Please ensure that the class definition \"App\\Events\\NewNotification\" of the object you are trying to operate on was loaded _before_ unserialize() gets called or provide an autoloader to load the class definition in C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php:195\nStack trace:\n#0 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php(195): method_exists()\n#1 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(121): Illuminate\\Broadcasting\\BroadcastEvent->middleware()\n#2 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#3 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#4 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#5 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(442): Illuminate\\Queue\\Worker->process()\n#6 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(365): Illuminate\\Queue\\Worker->runJob()\n#7 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->runNextJob()\n#8 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#9 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#10 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#11 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#12 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#13 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#14 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(280): Illuminate\\Container\\Container->call()\n#15 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Command\\Command.php(291): Illuminate\\Console\\Command->execute()\n#16 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#17 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(1107): Illuminate\\Console\\Command->run()\n#18 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#19 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#20 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#21 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#22 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#23 {main}', '2026-03-25 22:30:29'),
(2, '676e6720-4864-4d7c-b0a5-08309df039c4', 'database', 'default', '{\"uuid\":\"676e6720-4864-4d7c-b0a5-08309df039c4\",\"displayName\":\"App\\\\Events\\\\NewNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\NewNotification\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";N;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1773297857,\"delay\":null}', 'Error: The script tried to call a method on an incomplete object. Please ensure that the class definition \"App\\Events\\NewNotification\" of the object you are trying to operate on was loaded _before_ unserialize() gets called or provide an autoloader to load the class definition in C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php:195\nStack trace:\n#0 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php(195): method_exists()\n#1 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(121): Illuminate\\Broadcasting\\BroadcastEvent->middleware()\n#2 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#3 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#4 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#5 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(442): Illuminate\\Queue\\Worker->process()\n#6 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(365): Illuminate\\Queue\\Worker->runJob()\n#7 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->runNextJob()\n#8 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#9 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#10 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#11 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#12 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#13 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#14 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(280): Illuminate\\Container\\Container->call()\n#15 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Command\\Command.php(291): Illuminate\\Console\\Command->execute()\n#16 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#17 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(1107): Illuminate\\Console\\Command->run()\n#18 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#19 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#20 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#21 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#22 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#23 {main}', '2026-03-25 22:30:31'),
(3, '16d55cdd-e5bb-4f92-9b24-cf87987a5b72', 'database', 'default', '{\"uuid\":\"16d55cdd-e5bb-4f92-9b24-cf87987a5b72\",\"displayName\":\"App\\\\Events\\\\NewNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\NewNotification\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";N;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1773301592,\"delay\":null}', 'Error: The script tried to call a method on an incomplete object. Please ensure that the class definition \"App\\Events\\NewNotification\" of the object you are trying to operate on was loaded _before_ unserialize() gets called or provide an autoloader to load the class definition in C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php:195\nStack trace:\n#0 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php(195): method_exists()\n#1 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(121): Illuminate\\Broadcasting\\BroadcastEvent->middleware()\n#2 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#3 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#4 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#5 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(442): Illuminate\\Queue\\Worker->process()\n#6 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(365): Illuminate\\Queue\\Worker->runJob()\n#7 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->runNextJob()\n#8 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#9 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#10 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#11 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#12 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#13 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#14 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(280): Illuminate\\Container\\Container->call()\n#15 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Command\\Command.php(291): Illuminate\\Console\\Command->execute()\n#16 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#17 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(1107): Illuminate\\Console\\Command->run()\n#18 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#19 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#20 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#21 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#22 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#23 {main}', '2026-03-25 22:30:32'),
(4, '6195bcc2-4799-4858-a15c-89c73dc638fb', 'database', 'default', '{\"uuid\":\"6195bcc2-4799-4858-a15c-89c73dc638fb\",\"displayName\":\"App\\\\Events\\\\NewNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\NewNotification\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";N;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1773621823,\"delay\":null}', 'Error: The script tried to call a method on an incomplete object. Please ensure that the class definition \"App\\Events\\NewNotification\" of the object you are trying to operate on was loaded _before_ unserialize() gets called or provide an autoloader to load the class definition in C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php:195\nStack trace:\n#0 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php(195): method_exists()\n#1 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(121): Illuminate\\Broadcasting\\BroadcastEvent->middleware()\n#2 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#3 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#4 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#5 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(442): Illuminate\\Queue\\Worker->process()\n#6 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(365): Illuminate\\Queue\\Worker->runJob()\n#7 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->runNextJob()\n#8 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#9 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#10 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#11 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#12 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#13 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#14 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(280): Illuminate\\Container\\Container->call()\n#15 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Command\\Command.php(291): Illuminate\\Console\\Command->execute()\n#16 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#17 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(1107): Illuminate\\Console\\Command->run()\n#18 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#19 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#20 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#21 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#22 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#23 {main}', '2026-03-25 22:30:34'),
(5, '491f5aef-1593-4246-ad34-36ede7c6bed3', 'database', 'default', '{\"uuid\":\"491f5aef-1593-4246-ad34-36ede7c6bed3\",\"displayName\":\"App\\\\Events\\\\NewNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\NewNotification\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";N;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1773652049,\"delay\":null}', 'Error: The script tried to call a method on an incomplete object. Please ensure that the class definition \"App\\Events\\NewNotification\" of the object you are trying to operate on was loaded _before_ unserialize() gets called or provide an autoloader to load the class definition in C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php:195\nStack trace:\n#0 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php(195): method_exists()\n#1 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(121): Illuminate\\Broadcasting\\BroadcastEvent->middleware()\n#2 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#3 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#4 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#5 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(442): Illuminate\\Queue\\Worker->process()\n#6 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(365): Illuminate\\Queue\\Worker->runJob()\n#7 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->runNextJob()\n#8 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#9 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#10 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#11 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#12 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#13 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#14 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(280): Illuminate\\Container\\Container->call()\n#15 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Command\\Command.php(291): Illuminate\\Console\\Command->execute()\n#16 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#17 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(1107): Illuminate\\Console\\Command->run()\n#18 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#19 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#20 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#21 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#22 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#23 {main}', '2026-03-25 22:30:36'),
(6, 'd50b0a0b-bf3e-444c-8c73-f5c31b936803', 'database', 'default', '{\"uuid\":\"d50b0a0b-bf3e-444c-8c73-f5c31b936803\",\"displayName\":\"App\\\\Events\\\\NewNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\NewNotification\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";N;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1773707830,\"delay\":null}', 'Error: The script tried to call a method on an incomplete object. Please ensure that the class definition \"App\\Events\\NewNotification\" of the object you are trying to operate on was loaded _before_ unserialize() gets called or provide an autoloader to load the class definition in C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php:195\nStack trace:\n#0 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php(195): method_exists()\n#1 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(121): Illuminate\\Broadcasting\\BroadcastEvent->middleware()\n#2 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#3 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#4 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#5 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(442): Illuminate\\Queue\\Worker->process()\n#6 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(365): Illuminate\\Queue\\Worker->runJob()\n#7 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->runNextJob()\n#8 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#9 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#10 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#11 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#12 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#13 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#14 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(280): Illuminate\\Container\\Container->call()\n#15 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Command\\Command.php(291): Illuminate\\Console\\Command->execute()\n#16 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#17 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(1107): Illuminate\\Console\\Command->run()\n#18 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#19 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#20 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#21 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#22 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#23 {main}', '2026-03-25 22:30:37'),
(7, '4f7d1440-7653-4bb1-ab54-374965e3bb8f', 'database', 'default', '{\"uuid\":\"4f7d1440-7653-4bb1-ab54-374965e3bb8f\",\"displayName\":\"App\\\\Events\\\\NewNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\NewNotification\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";N;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1773717090,\"delay\":null}', 'Error: The script tried to call a method on an incomplete object. Please ensure that the class definition \"App\\Events\\NewNotification\" of the object you are trying to operate on was loaded _before_ unserialize() gets called or provide an autoloader to load the class definition in C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php:195\nStack trace:\n#0 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php(195): method_exists()\n#1 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(121): Illuminate\\Broadcasting\\BroadcastEvent->middleware()\n#2 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#3 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#4 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#5 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(442): Illuminate\\Queue\\Worker->process()\n#6 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(365): Illuminate\\Queue\\Worker->runJob()\n#7 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->runNextJob()\n#8 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#9 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#10 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#11 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#12 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#13 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#14 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(280): Illuminate\\Container\\Container->call()\n#15 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Command\\Command.php(291): Illuminate\\Console\\Command->execute()\n#16 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#17 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(1107): Illuminate\\Console\\Command->run()\n#18 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#19 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#20 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#21 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#22 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#23 {main}', '2026-03-25 22:30:39'),
(8, 'ce561199-a74e-42eb-ae3a-54a9a3f56034', 'database', 'default', '{\"uuid\":\"ce561199-a74e-42eb-ae3a-54a9a3f56034\",\"displayName\":\"App\\\\Events\\\\NewNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\NewNotification\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";N;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1773717149,\"delay\":null}', 'Error: The script tried to call a method on an incomplete object. Please ensure that the class definition \"App\\Events\\NewNotification\" of the object you are trying to operate on was loaded _before_ unserialize() gets called or provide an autoloader to load the class definition in C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php:195\nStack trace:\n#0 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php(195): method_exists()\n#1 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(121): Illuminate\\Broadcasting\\BroadcastEvent->middleware()\n#2 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#3 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#4 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#5 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(442): Illuminate\\Queue\\Worker->process()\n#6 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(365): Illuminate\\Queue\\Worker->runJob()\n#7 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->runNextJob()\n#8 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#9 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#10 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#11 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#12 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#13 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#14 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(280): Illuminate\\Container\\Container->call()\n#15 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Command\\Command.php(291): Illuminate\\Console\\Command->execute()\n#16 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#17 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(1107): Illuminate\\Console\\Command->run()\n#18 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#19 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#20 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#21 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#22 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#23 {main}', '2026-03-25 22:30:41');
INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(9, '4ba2f26a-4ab0-4a5b-9af1-a3a8fc5012b0', 'database', 'default', '{\"uuid\":\"4ba2f26a-4ab0-4a5b-9af1-a3a8fc5012b0\",\"displayName\":\"App\\\\Events\\\\NewNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\NewNotification\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";N;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1773804640,\"delay\":null}', 'Error: The script tried to call a method on an incomplete object. Please ensure that the class definition \"App\\Events\\NewNotification\" of the object you are trying to operate on was loaded _before_ unserialize() gets called or provide an autoloader to load the class definition in C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php:195\nStack trace:\n#0 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php(195): method_exists()\n#1 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(121): Illuminate\\Broadcasting\\BroadcastEvent->middleware()\n#2 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#3 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#4 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#5 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(442): Illuminate\\Queue\\Worker->process()\n#6 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(365): Illuminate\\Queue\\Worker->runJob()\n#7 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->runNextJob()\n#8 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#9 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#10 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#11 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#12 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#13 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#14 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(280): Illuminate\\Container\\Container->call()\n#15 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Command\\Command.php(291): Illuminate\\Console\\Command->execute()\n#16 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#17 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(1107): Illuminate\\Console\\Command->run()\n#18 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#19 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#20 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#21 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#22 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#23 {main}', '2026-03-25 22:30:42'),
(10, 'd745a20b-4fb2-4ef9-805c-15849fbf2a1b', 'database', 'default', '{\"uuid\":\"d745a20b-4fb2-4ef9-805c-15849fbf2a1b\",\"displayName\":\"App\\\\Events\\\\NewNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\NewNotification\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";N;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1773816716,\"delay\":null}', 'Error: The script tried to call a method on an incomplete object. Please ensure that the class definition \"App\\Events\\NewNotification\" of the object you are trying to operate on was loaded _before_ unserialize() gets called or provide an autoloader to load the class definition in C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php:195\nStack trace:\n#0 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php(195): method_exists()\n#1 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(121): Illuminate\\Broadcasting\\BroadcastEvent->middleware()\n#2 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#3 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#4 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#5 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(442): Illuminate\\Queue\\Worker->process()\n#6 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(365): Illuminate\\Queue\\Worker->runJob()\n#7 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->runNextJob()\n#8 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#9 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#10 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#11 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#12 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#13 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#14 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(280): Illuminate\\Container\\Container->call()\n#15 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Command\\Command.php(291): Illuminate\\Console\\Command->execute()\n#16 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#17 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(1107): Illuminate\\Console\\Command->run()\n#18 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#19 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#20 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#21 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#22 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#23 {main}', '2026-03-25 22:30:44'),
(11, 'dc2c3cd5-8eaf-4975-a346-60ee9d79a214', 'database', 'default', '{\"uuid\":\"dc2c3cd5-8eaf-4975-a346-60ee9d79a214\",\"displayName\":\"App\\\\Events\\\\NewNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\NewNotification\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";N;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1773817115,\"delay\":null}', 'Error: The script tried to call a method on an incomplete object. Please ensure that the class definition \"App\\Events\\NewNotification\" of the object you are trying to operate on was loaded _before_ unserialize() gets called or provide an autoloader to load the class definition in C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php:195\nStack trace:\n#0 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php(195): method_exists()\n#1 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(121): Illuminate\\Broadcasting\\BroadcastEvent->middleware()\n#2 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#3 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#4 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#5 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(442): Illuminate\\Queue\\Worker->process()\n#6 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(365): Illuminate\\Queue\\Worker->runJob()\n#7 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->runNextJob()\n#8 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#9 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#10 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#11 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#12 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#13 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#14 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(280): Illuminate\\Container\\Container->call()\n#15 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Command\\Command.php(291): Illuminate\\Console\\Command->execute()\n#16 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#17 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(1107): Illuminate\\Console\\Command->run()\n#18 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#19 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#20 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#21 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#22 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#23 {main}', '2026-03-25 22:30:45'),
(12, 'ee6c4d18-f9a6-464a-9581-4e3bb43867a7', 'database', 'default', '{\"uuid\":\"ee6c4d18-f9a6-464a-9581-4e3bb43867a7\",\"displayName\":\"App\\\\Events\\\\NewNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\NewNotification\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";N;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1773817148,\"delay\":null}', 'Error: The script tried to call a method on an incomplete object. Please ensure that the class definition \"App\\Events\\NewNotification\" of the object you are trying to operate on was loaded _before_ unserialize() gets called or provide an autoloader to load the class definition in C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php:195\nStack trace:\n#0 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php(195): method_exists()\n#1 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(121): Illuminate\\Broadcasting\\BroadcastEvent->middleware()\n#2 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#3 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#4 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#5 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(442): Illuminate\\Queue\\Worker->process()\n#6 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(365): Illuminate\\Queue\\Worker->runJob()\n#7 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->runNextJob()\n#8 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#9 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#10 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#11 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#12 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#13 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#14 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(280): Illuminate\\Container\\Container->call()\n#15 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Command\\Command.php(291): Illuminate\\Console\\Command->execute()\n#16 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#17 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(1107): Illuminate\\Console\\Command->run()\n#18 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#19 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#20 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#21 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#22 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#23 {main}', '2026-03-25 22:30:47'),
(13, 'faedeb8b-8d07-4ad5-8c8a-2010959f9ef7', 'database', 'default', '{\"uuid\":\"faedeb8b-8d07-4ad5-8c8a-2010959f9ef7\",\"displayName\":\"App\\\\Events\\\\NewNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\NewNotification\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";N;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1773890136,\"delay\":null}', 'Error: The script tried to call a method on an incomplete object. Please ensure that the class definition \"App\\Events\\NewNotification\" of the object you are trying to operate on was loaded _before_ unserialize() gets called or provide an autoloader to load the class definition in C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php:195\nStack trace:\n#0 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php(195): method_exists()\n#1 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(121): Illuminate\\Broadcasting\\BroadcastEvent->middleware()\n#2 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#3 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#4 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#5 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(442): Illuminate\\Queue\\Worker->process()\n#6 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(365): Illuminate\\Queue\\Worker->runJob()\n#7 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->runNextJob()\n#8 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#9 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#10 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#11 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#12 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#13 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#14 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(280): Illuminate\\Container\\Container->call()\n#15 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Command\\Command.php(291): Illuminate\\Console\\Command->execute()\n#16 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#17 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(1107): Illuminate\\Console\\Command->run()\n#18 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#19 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#20 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#21 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#22 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#23 {main}', '2026-03-25 22:30:48'),
(14, '85b48690-57b6-41b2-97f4-0c9b953438c9', 'database', 'default', '{\"uuid\":\"85b48690-57b6-41b2-97f4-0c9b953438c9\",\"displayName\":\"App\\\\Events\\\\NewNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\NewNotification\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";N;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1773890171,\"delay\":null}', 'Error: The script tried to call a method on an incomplete object. Please ensure that the class definition \"App\\Events\\NewNotification\" of the object you are trying to operate on was loaded _before_ unserialize() gets called or provide an autoloader to load the class definition in C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php:195\nStack trace:\n#0 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Broadcasting\\BroadcastEvent.php(195): method_exists()\n#1 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(121): Illuminate\\Broadcasting\\BroadcastEvent->middleware()\n#2 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#3 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#4 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#5 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(442): Illuminate\\Queue\\Worker->process()\n#6 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(365): Illuminate\\Queue\\Worker->runJob()\n#7 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->runNextJob()\n#8 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#9 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#10 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#11 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#12 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#13 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#14 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(280): Illuminate\\Container\\Container->call()\n#15 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Command\\Command.php(291): Illuminate\\Console\\Command->execute()\n#16 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#17 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(1107): Illuminate\\Console\\Command->run()\n#18 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#19 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#20 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#21 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#22 C:\\xampp\\htdocs\\PesoJobPortal\\PESOJOBPORTAL\\artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#23 {main}', '2026-03-25 22:30:50');

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

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(15, 'default', '{\"uuid\":\"57f5abbb-5f61-440f-83c8-ee783543b7ee\",\"displayName\":\"App\\\\Events\\\\NewNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:26:\\\"App\\\\Events\\\\NewNotification\\\":1:{s:12:\\\"notification\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\Notification\\\";s:2:\\\"id\\\";i:25;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1776244098,\"delay\":null}', 0, NULL, 1776244098, 1776244098);

-- --------------------------------------------------------

--
-- Table structure for table `jobseeker_profiles`
--

CREATE TABLE `jobseeker_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `city_municipality` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `preferred_industry` varchar(255) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `experience_years` varchar(255) DEFAULT NULL,
  `employment_status` enum('unemployed','employed','underemployed','student','not_seeking') DEFAULT NULL,
  `work_experience` text DEFAULT NULL,
  `certifications` text DEFAULT NULL,
  `education` text DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `resume_file_name` varchar(255) DEFAULT NULL,
  `preferred_location` varchar(255) DEFAULT NULL,
  `preferred_employment_type` varchar(255) DEFAULT NULL,
  `expected_salary_min` decimal(10,2) DEFAULT NULL,
  `expected_salary_max` decimal(10,2) DEFAULT NULL,
  `profile_completion` int(11) NOT NULL DEFAULT 0,
  `is_searchable` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `civil_status` varchar(255) DEFAULT NULL,
  `height` varchar(255) DEFAULT NULL,
  `tin_id` varchar(255) DEFAULT NULL COMMENT 'TIN',
  `present_street` varchar(255) DEFAULT NULL,
  `present_barangay` varchar(255) DEFAULT NULL,
  `present_city` varchar(255) DEFAULT NULL,
  `present_province` varchar(255) DEFAULT NULL,
  `permanent_street` varchar(255) DEFAULT NULL,
  `permanent_barangay` varchar(255) DEFAULT NULL,
  `permanent_city` varchar(255) DEFAULT NULL,
  `permanent_province` varchar(255) DEFAULT NULL,
  `employment_status_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`employment_status_details`)),
  `job_preferences` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`job_preferences`)),
  `language_proficiency` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`language_proficiency`)),
  `disability_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`disability_details`)),
  `trainings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`trainings`)),
  `professional_licenses` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`professional_licenses`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobseeker_profiles`
--

INSERT INTO `jobseeker_profiles` (`id`, `user_id`, `first_name`, `surname`, `last_name`, `birth_date`, `gender`, `phone`, `address`, `barangay`, `city_municipality`, `province`, `postal_code`, `industry`, `preferred_industry`, `skills`, `experience_years`, `employment_status`, `work_experience`, `certifications`, `education`, `resume_path`, `resume_file_name`, `preferred_location`, `preferred_employment_type`, `expected_salary_min`, `expected_salary_max`, `profile_completion`, `is_searchable`, `created_at`, `updated_at`, `middle_name`, `suffix`, `religion`, `civil_status`, `height`, `tin_id`, `present_street`, `present_barangay`, `present_city`, `present_province`, `permanent_street`, `permanent_barangay`, `permanent_city`, `permanent_province`, `employment_status_details`, `job_preferences`, `language_proficiency`, `disability_details`, `trainings`, `professional_licenses`) VALUES
(1, 3, 'Yami', 'Uy', 'Uy', '1976-02-17', 'female', '09126536757', 'Kalye Sigbin', 'Tankulan', 'Manolo Fortich', 'Bukidnon', NULL, 'Information Technology', NULL, '{\"auto_mechanic\":\"1\",\"plumbing\":\"1\",\"housekeeping\":\"1\",\"electrician\":\"1\",\"driver\":\"1\",\"microsoft_office\":\"1\",\"web_development\":\"1\",\"programming\":\"1\",\"database\":\"1\",\"javascript\":\"1\",\"html_css\":\"1\",\"git\":\"1\",\"database_management\":\"1\",\"frontend_development\":\"1\",\"api_development\":\"1\",\"software_development\":\"1\",\"network_config\":\"1\",\"hardware_installation\":\"1\",\"graphic_design\":\"1\",\"react_js\":\"1\",\"node_js\":\"1\",\"backend_development\":\"1\",\"virtual_assistance\":\"1\",\"mysql_database\":\"1\",\"laravel_backend\":\"1\",\"critical_thinking\":\"1\",\"problem_solving\":\"1\",\"adaptability\":\"1\",\"time_management\":\"1\",\"team_collaboration\":\"1\",\"with_cert\":\"0\",\"by_experience\":\"0\"}', NULL, 'unemployed', '[{\"company\":\"PixelCraft Web Services\",\"job_title\":\"Freelance Web Developer\",\"address\":\"Cagayan de Oro City\",\"status\":\"Freelance \\/ Project-Based\",\"from_date\":\"2024-06\",\"to_date\":\"2024-09\",\"salary_amount\":\"15000\",\"salary_type\":null,\"reason_left\":\"Project completed. Developed responsive websites for small businesses using HTML, CSS, and JavaScript. Integrated basic PHP and MySQL for contact forms and simple systems. Ensured mobile-friendly design and optimized website performance.\"},{\"company\":\"CodeWave Innovations\",\"job_title\":\"Junior App Developer\",\"address\":\"Cagayan de Oro City\",\"status\":\"Contractual\",\"from_date\":\"2024-10\",\"to_date\":\"2024-12\",\"salary_amount\":\"18000\",\"salary_type\":\"monthly\",\"reason_left\":\"End of contract. Assisted in developing a mobile application using Flutter. Helped design user interfaces and tested application features. Fixed minor bugs and improved app performance.\"},{\"company\":\"BrightTech Office Solutions\",\"job_title\":\"Admin & IT Support Assistant\",\"address\":\"Cagayan de Oro City\",\"status\":\"Contractual\",\"from_date\":\"2024-02\",\"to_date\":\"2024-03\",\"salary_amount\":\"14000\",\"salary_type\":\"monthly\",\"reason_left\":\"Contract completed. Provided administrative support including data entry, document organization, and report preparation. Assisted in basic IT troubleshooting, system setup, and maintaining office computers.\"}]', '[{\"name\":null,\"issuer\":null,\"date_obtained\":null,\"expiration_date\":null,\"credential_id\":null}]', '{\"elementary\":{\"school\":\"Lingi-on Elementary School\",\"year_graduated\":\"2014\",\"level_reached\":null,\"year_last_attended\":null},\"secondary\":{\"k12\":\"1\",\"school\":\"Manlo Fortich National High School\",\"year_graduated\":\"2020\",\"level_reached\":null,\"year_last_attended\":null},\"senior_high_strand\":\"ICT\",\"tertiary\":{\"school\":\"Northern Bukidnon State College\",\"year_graduated\":\"2024\",\"level_reached\":null,\"year_last_attended\":null,\"course\":\"Bachelor of Science in Information Technology\"},\"graduate\":{\"school\":null,\"year_graduated\":null,\"level_reached\":null,\"year_last_attended\":null}}', 'resumes/9dkRlSHgUOWt78jDgAaibDji2cCw5iHeV0WRpovl.pdf', 'Yami Uy Cruz Resume.pdf', 'Cagayan De Oro City', 'full-time', NULL, NULL, 100, 1, '2026-03-11 04:02:02', '2026-03-17 23:54:40', 'Cruz', NULL, 'Roman Catholic', 'single', '160', '123-456-789', 'Zone 4', 'Lingi-on', 'Manolo Fortich', 'Bukidnon', NULL, NULL, NULL, NULL, '{\"self_others\":null,\"unemployed\":\"1\",\"last_employment_date\":\"2025-05-30\",\"reason_finished_contract\":\"1\"}', '{\"part_time\":\"1\",\"full_time\":\"1\",\"preferred_occupation\":\"programming, web development, graphic design\",\"local\":\"1\",\"local_cities\":\"Cagayan De Oro City\",\"overseas_countries\":null}', '{\"english\":{\"read\":\"on\",\"write\":\"on\",\"speak\":\"on\",\"understand\":\"on\"},\"tagalog\":{\"read\":\"on\",\"write\":\"on\",\"speak\":\"on\",\"understand\":\"on\"},\"visayan\":{\"read\":\"on\",\"write\":\"on\",\"speak\":\"on\",\"understand\":\"on\"},\"other_name\":null}', '{\"visual\":\"1\",\"others\":null}', '[{\"course\":\"Web Development Fundamentals\",\"hours\":\"80\",\"institution\":\"TESDA Training Center \\u2013 Cagayan de Oro\",\"inclusive_dates\":\"01\\/2023 - 03\\/2023\",\"skills\":\"HTML, CSS, JavaScript basics, Responsive web design, Basic website deployment\",\"certificates\":\"NC II \\u2013 Web Development\"}]', '[{\"eligibility\":\"Civil Service Professional Eligibility (Sub-Professional)\",\"date_taken\":\"2023-08-14\",\"prc_license\":null,\"valid_until\":null}]'),
(2, 4, 'Marky', 'Apsalay', NULL, '2026-03-19', 'male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"with_cert\":\"0\",\"by_experience\":\"0\"}', NULL, NULL, NULL, NULL, '{\"elementary\":{\"school\":null,\"year_graduated\":null,\"level_reached\":null,\"year_last_attended\":null},\"secondary\":{\"school\":null,\"year_graduated\":null,\"level_reached\":null,\"year_last_attended\":null},\"senior_high_strand\":null,\"tertiary\":{\"school\":null,\"year_graduated\":null,\"level_reached\":null,\"year_last_attended\":null,\"course\":null},\"graduate\":{\"school\":null,\"year_graduated\":null,\"level_reached\":null,\"year_last_attended\":null}}', NULL, NULL, NULL, NULL, NULL, NULL, 50, 1, '2026-03-13 03:20:39', '2026-03-18 19:27:18', 'Uy', NULL, 'Roman Catholic', 'single', '175', '123-456-789', 'Zone 5', 'Tankulan', 'Manolo Fortich', 'Bukidnon', NULL, NULL, NULL, NULL, '{\"self_others\":null,\"last_employment_date\":null}', '{\"preferred_occupation\":null,\"local_cities\":null,\"overseas_countries\":null}', '{\"other_name\":null}', '{\"others\":null}', NULL, NULL);

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
-- Table structure for table `job_posts`
--

CREATE TABLE `job_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employer_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `key_responsibilities` text DEFAULT NULL,
  `qualifications` text DEFAULT NULL,
  `preferred_skills` text DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `education` varchar(255) DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `employment_type` varchar(255) NOT NULL,
  `vacancies` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `salary_min` decimal(10,2) DEFAULT NULL,
  `salary_max` decimal(10,2) DEFAULT NULL,
  `salary_currency` varchar(255) NOT NULL DEFAULT 'PHP',
  `status` enum('active','inactive','closed','draft','pending','rejected','archived') NOT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `application_deadline` date DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `applications_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_posts`
--

INSERT INTO `job_posts` (`id`, `employer_id`, `company_name`, `title`, `description`, `key_responsibilities`, `qualifications`, `preferred_skills`, `experience`, `education`, `benefits`, `location`, `employment_type`, `vacancies`, `salary_min`, `salary_max`, `salary_currency`, `status`, `approved_by`, `approved_at`, `rejected_by`, `rejected_at`, `admin_notes`, `application_deadline`, `views`, `applications_count`, `created_at`, `updated_at`) VALUES
(4, 1, 'NexaCore Solutions Inc.', 'Data Entry Clerk', 'BrightData Services is looking for a Data Entry Clerk responsible for entering and updating information into company databases accurately.', 'Enter and update data in databases and spreadsheets\r\n\r\nMaintain accurate records and files\r\n\r\nReview data for errors and correct them\r\n\r\nPrepare reports when required', 'At least Senior High School graduate or Associate degree preferred\r\n\r\nBasic knowledge of Microsoft Office (Word, Excel)\r\n\r\nGood typing speed and accuracy\r\n\r\nAttention to detail and organization skills\r\n\r\nAbility to handle confidential information', 'Experience with Microsoft Excel or Google Sheets\r\n\r\nBasic database knowledge\r\n\r\nGood organizational skills', NULL, NULL, 'Government benefits (SSS, PhilHealth, Pag-IBIG)\r\n\r\nPaid holidays\r\n\r\nFlexible working schedule\r\n\r\nFriendly working environment', 'Cagayan de Oro City (On-site / Hybrid)', 'contract', 1, 16000.00, 22000.00, 'PHP', 'draft', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '2026-03-08 18:00:03', '2026-03-08 22:19:11'),
(5, 1, 'NexaCore Solutions Inc.', 'Office Clerk', 'PrimeCore Business Services is looking for an organized Office Clerk to assist with administrative tasks and maintain company records.', 'Organize and maintain files and documents\r\n\r\nAssist in data entry and record keeping\r\n\r\nAnswer phone calls and respond to emails\r\n\r\nPrepare reports and office documents\r\n\r\nSupport other office staff with administrative tasks', 'At least Senior High School graduate or Associate degree preferred\r\n\r\nBasic knowledge of Microsoft Office (Word, Excel)\r\n\r\nGood communication and organizational skills\r\n\r\nAbility to work independently and meet deadlines\r\n\r\nAttention to detail and accuracy', 'Experience in data entry or office administration\r\n\r\nFamiliarity with spreadsheets and office databases\r\n\r\nBasic document management skills', NULL, NULL, 'Government benefits (SSS, PhilHealth, Pag-IBIG)\r\n\r\nPaid holidays and leave credits\r\n\r\nFriendly working environment\r\n\r\nOpportunities for training and career growth', 'Cagayan de Oro City (On-site / Hybrid)', 'part-time', 1, 12000.00, 15000.00, 'PHP', 'archived', NULL, NULL, NULL, NULL, NULL, '2026-03-17', 0, 0, '2026-03-08 18:40:17', '2026-03-16 15:55:46'),
(8, 1, 'NexaCore Solutions Inc.', 'Junior Database Administrator', 'NexaCore Solutions Inc. is seeking a Junior Database Administrator to assist in managing and maintaining company databases.', 'Monitor and maintain databases\r\n\r\nPerform backups and recovery tasks\r\n\r\nOptimize database performance\r\n\r\nAssist developers with database queries', 'Bachelor’s degree in Information Technology, Computer Science, or related field\r\n\r\nBasic knowledge of SQL and database systems\r\n\r\nUnderstanding of database security\r\n\r\nStrong analytical skills', 'Experience with MySQL or PostgreSQL\r\n\r\nKnowledge of database optimization\r\n\r\nFamiliarity with cloud databases', NULL, NULL, 'Government benefits (SSS, PhilHealth, Pag-IBIG)\r\n\r\nHealth insurance\r\n\r\nTraining and certification opportunities\r\n\r\nAnnual salary review', 'Cagayan de Oro City', 'full-time', 1, 22000.00, 35000.00, 'PHP', 'closed', NULL, NULL, NULL, NULL, NULL, '2026-03-12', 0, 0, '2026-03-09 17:38:42', '2026-03-09 22:35:06'),
(10, 1, 'NexaCore Solutions Inc.', 'Senior Database Administrator', 'NexaCore Solutions Inc. is seeking a Senior Database Administrator to assist in managing and maintaining company databases', 'Monitor and maintain databases\r\n\r\nPerform backups and recovery tasks\r\n\r\nOptimize database performance\r\n\r\nAssist developers with database queries', 'Experience with MySQL or PostgreSQL\r\n\r\nKnowledge of database optimization\r\n\r\nFamiliarity with cloud databases', 'Experience with MySQL or PostgreSQL\r\n\r\nKnowledge of database optimization\r\n\r\nFamiliarity with cloud databases', NULL, NULL, 'Government benefits (SSS, PhilHealth, Pag-IBIG)\r\n\r\nHealth insurance\r\n\r\nTraining and certification opportunities\r\n\r\nAnnual salary review', 'Cagayan de Oro City (On-site / Hybrid)', 'full-time', 1, 18000.00, 22000.00, 'PHP', 'active', NULL, NULL, NULL, NULL, NULL, '2026-07-09', 0, 1, '2026-03-11 00:14:10', '2026-03-18 19:15:36'),
(11, 1, 'NexaCore Solutions Inc.', 'Technical Support Specialist', 'NexaCore Solutions Inc. is looking for a Technical Support Specialist to provide technical assistance to users and clients.', 'Provide technical support via phone, email, or chat\r\n\r\nTroubleshoot hardware and software problems\r\n\r\nAssist users with system setup and issues\r\n\r\nDocument technical issues and solutions', 'Bachelor’s degree in Information Technology or related field\r\n\r\nBasic knowledge of computer hardware and operating systems\r\n\r\nGood communication and problem-solving skills\r\n\r\nAbility to assist users with technical concerns', 'Experience with helpdesk support systems\r\n\r\nKnowledge of Windows or Linux operating systems\r\n\r\nBasic network troubleshooting', NULL, NULL, 'Government benefits (SSS, PhilHealth, Pag-IBIG)\r\n\r\nHealth insurance\r\n\r\nPaid training and certifications\r\n\r\nPerformance incentives', 'Cagayan de Oro City (On-site / Hybrid)', 'full-time', 1, 16000.00, 23000.00, 'PHP', 'archived', NULL, NULL, NULL, NULL, NULL, '2026-03-27', 1, 0, '2026-03-11 16:11:09', '2026-03-29 16:00:32'),
(12, 1, 'NexaCore Solutions Inc.', 'Junior Web Developer', 'NexaCore Solutions Inc. is looking for a motivated and detail-oriented Junior Web Developer to join our growing development team. The ideal candidate will assist in designing, developing, and maintaining custom web and mobile applications, database systems, and cloud-based platforms for schools and small businesses.\r\n\r\nYou will work closely with senior developers, UI/UX designers, and project managers to deliver secure, scalable, and user-friendly software solutions.', 'Develop and maintain web applications using modern programming languages (e.g., PHP, JavaScript, Laravel, MySQL).\r\n\r\nAssist in database design, integration, and optimization.\r\n\r\nTroubleshoot, debug, and upgrade existing systems.\r\n\r\nCollaborate with team members to gather and analyze system requirements.\r\n\r\nParticipate in system testing and deployment.\r\n\r\nPrepare technical documentation for developed systems.', 'Bachelor’s Degree in Information Technology, Computer Science, or related field.\r\n\r\nBasic knowledge of HTML, CSS, JavaScript, and PHP.\r\n\r\nFamiliarity with frameworks such as Laravel or React is an advantage.\r\n\r\nUnderstanding of database management (MySQL preferred).\r\n\r\nStrong problem-solving and analytical skills.\r\n\r\nAbility to work independently and in a team environment.', 'Experience with cloud platforms (AWS, Azure, or Google Cloud).\r\n\r\nKnowledge of Git version control.\r\n\r\nBasic understanding of cybersecurity principles', '1-2 years or experience of software development', 'Bachelor’s Degree in Information Technology, Computer Science', 'Competitive salary with performance-based increase\r\n\r\nCareer growth and promotion opportunities\r\n\r\nHands-on experience with real client projects\r\n\r\nSupportive and collaborative work environment\r\n\r\nGovernment-mandated benefits (SSS, PhilHealth, Pag-IBIG)\r\n\r\n13th Month Pay', 'Cagayan de Oro City (On-site / Hybrid)', 'full-time', 1, 18000.00, 28000.00, 'PHP', 'archived', NULL, NULL, NULL, NULL, NULL, '2026-04-07', 0, 1, '2026-03-11 16:18:29', '2026-04-15 16:00:31'),
(13, 1, 'NexaCore Solutions Inc.', 'IT Support Specialist', 'NexaTech IT Solutions is seeking an IT Support Specialist to assist with maintaining company computer systems and providing technical support to staff.', 'Install and configure computer hardware and software\r\n\r\nTroubleshoot network and system issues\r\n\r\nMaintain IT equipment and ensure system security\r\n\r\nProvide technical support to employees.', 'Bachelor’s degree in Information Technology, Computer Science, or related field\r\n\r\nBasic knowledge of computer hardware and networking\r\n\r\nStrong troubleshooting and problem-solving skills\r\n\r\nGood communication and customer service skills\r\n\r\nAbility to work independently and in a team.', 'Experience with Windows Server\r\n\r\nKnowledge of network troubleshooting\r\n\r\nFamiliarity with cybersecurity basics', '1-2 years experience with Windows Server', 'Bachelor’s degree in Information Technology, Computer Science', NULL, 'Cagayan de Oro City (On-site / Hybrid)', 'full-time', 3, 16000.00, 22000.00, 'PHP', 'active', NULL, NULL, NULL, NULL, NULL, '2026-05-08', 0, 1, '2026-03-11 16:28:13', '2026-03-18 21:20:05'),
(14, 1, 'NexaCore Solutions Inc.', 'Creative Pixel Studio', 'Creative Pixel Studio is looking for a talented Graphic Designer who can create visually appealing designs for digital and print media.', 'Create marketing materials, social media graphics, and branding assets\r\n\r\nCollaborate with the marketing team for design concepts\r\n\r\nEdit images and layouts for websites and advertisements\r\n\r\nMaintain brand consistency in all designs', 'Bachelor’s degree in Multimedia Arts, Graphic Design, or related field\r\n\r\nAt least 1 year experience in graphic design (preferred but not required)\r\n\r\nProficiency in Adobe Photoshop, Illustrator, or similar design tools\r\n\r\nStrong creativity and attention to detail\r\n\r\nAbility to work under deadlines', 'Knowledge of UI/UX design\r\n\r\nBasic video editing skills\r\n\r\nExperience in social media marketing design', NULL, 'Bachelor’s degree in Multimedia Arts, Graphic Design', 'Competitive salary with performance-based increase\r\n\r\nCareer growth and promotion opportunities\r\n\r\nHands-on experience with real client projects\r\n\r\nSupportive and collaborative work environment\r\n\r\nGovernment-mandated benefits (SSS, PhilHealth, Pag-IBIG)\r\n\r\n13th Month Pay', 'Cagayan de Oro City (On-site / Hybrid)', 'full-time', 1, 18000.00, 25000.00, 'PHP', 'active', NULL, NULL, NULL, NULL, NULL, '2026-05-29', 0, 1, '2026-03-11 16:34:13', '2026-04-15 01:08:17'),
(15, 1, 'NexaCore Solutions Inc.', 'Senior Software Developer', 'NexaCore Solutions Inc. is seeking a skilled Software Developer to design, develop, and maintain software applications that support business operations and client solutions. The ideal candidate will work with a team of developers to build reliable, scalable, and efficient systems.', 'NexaCore Solutions Inc. is seeking a skilled Software Developer to design, develop, and maintain software applications that support business operations and client solutions. The ideal candidate will work with a team of developers to build reliable, scalable, and efficient systems.', 'Develop and maintain web and software applications\r\n\r\nWrite clean, efficient, and well-documented code\r\n\r\nTest and debug applications to ensure optimal performance\r\n\r\nCollaborate with designers, developers, and project managers\r\n\r\nParticipate in code reviews and system improvements\r\n\r\nMaintain application security and data protection standards', 'Proficiency in HTML, CSS, JavaScript, and PHP\r\n\r\nKnowledge of Laravel or other web frameworks\r\n\r\nFamiliarity with MySQL or other relational databases\r\n\r\nUnderstanding of Git version control\r\n\r\nBasic knowledge of RESTful APIs', 'At least 1–2 years of experience in software or web development (fresh graduates may apply).', 'At least 1–2 years of experience in software or web development (fresh graduates may apply).', 'Bachelor’s degree in Information Technology, Computer Science, Software Engineering, or related field', 'Cagayan de Oro City (On-site / Hybrid)', 'full-time', 1, 25000.00, 35000.00, 'PHP', 'draft', NULL, NULL, NULL, NULL, NULL, '2026-06-02', 0, 0, '2026-03-11 21:59:55', '2026-03-11 22:40:15'),
(16, 1, 'NexaCore Solutions Inc.', 'Software Developer', 'NexaCore Solutions Inc. is seeking a skilled Software Developer to design, develop, and maintain software applications that support business operations and client solutions. The ideal candidate will work with a team of developers to build reliable, scalable, and efficient systems.', 'Develop and maintain web and software applications\r\n\r\nWrite clean, efficient, and well-documented code\r\n\r\nTest and debug applications to ensure optimal performance\r\n\r\nCollaborate with designers, developers, and project managers\r\n\r\nParticipate in code reviews and system improvements\r\n\r\nMaintain application security and data protection standards', 'Strong analytical and problem-solving skills\r\n\r\nAbility to work both independently and in a team environment\r\n\r\nGood communication and documentation skills\r\n\r\nAbility to meet project deadlines', 'Proficiency in HTML, CSS, JavaScript, and PHP\r\n\r\nKnowledge of Laravel or other web frameworks\r\n\r\nFamiliarity with MySQL or other relational databases\r\n\r\nUnderstanding of Git version control\r\n\r\nBasic knowledge of RESTful APIs', 'At least 1–2 years of experience in software or web development (fresh graduates may apply).', 'Bachelor’s degree in Information Technology, Computer Science, Software Engineering, or related field', 'Government benefits (SSS, PhilHealth, Pag-IBIG)\r\n\r\nHealth insurance coverage\r\n\r\nPaid leave credits\r\n\r\nTraining and professional development programs\r\n\r\nCareer advancement opportunities', 'Cagayan de Oro City (On-site / Hybrid)', 'full-time', 1, 25000.00, 35000.00, 'PHP', 'archived', NULL, NULL, NULL, NULL, NULL, '2026-03-18', 0, 0, '2026-03-11 22:42:13', '2026-03-23 16:00:33'),
(17, 1, 'NexaCore Solutions Inc.', 'Senior Software Developer', 'NexaCore Solutions Inc. is seeking an experienced Senior Software Developer to lead the design, development, and maintenance of high-quality software applications. The ideal candidate will guide development teams, review code, and ensure that systems are scalable, secure, and efficient while meeting business and client requirements.', 'Design, develop, and maintain complex software applications\r\n\r\nLead and mentor junior developers in coding standards and best practices\r\n\r\nReview, test, and debug software to ensure high performance and reliability\r\n\r\nCollaborate with project managers, designers, and stakeholders\r\n\r\nParticipate in system architecture planning and technical decisions\r\n\r\nEnsure software security, scalability, and maintainability\r\n\r\nDocument system features, processes, and technical specifications', 'Strong leadership and problem-solving abilities\r\n\r\nExcellent communication and teamwork skills\r\n\r\nAbility to manage multiple development tasks and deadlines\r\n\r\nStrong understanding of software development lifecycle (SDLC)', 'Advanced knowledge of PHP, JavaScript, HTML, and CSS\r\n\r\nExperience with Laravel or other modern web frameworks\r\n\r\nStrong knowledge of MySQL or relational databases\r\n\r\nExperience with Git version control\r\n\r\nUnderstanding of RESTful APIs and backend services\r\n\r\nKnowledge of software architecture and design patterns', '4–6 years of professional experience in software development\r\n\r\nExperience leading development teams or mentoring junior developers is an advantage', 'Bachelor’s degree in Computer Science, Information Technology, Software Engineering, or related field', 'Government benefits (SSS, PhilHealth, Pag-IBIG)\r\n\r\nHealth insurance and medical assistance\r\n\r\nPaid vacation and sick leave\r\n\r\nTraining, certifications, and professional development\r\n\r\nPerformance bonuses and career advancement opportunities', 'Cagayan de Oro City (On-site / Hybrid)', 'full-time', 8, 45000.00, 65000.00, 'PHP', 'active', NULL, NULL, NULL, NULL, NULL, '2026-06-04', 1, 1, '2026-03-15 16:43:43', '2026-03-18 21:16:23');

-- --------------------------------------------------------

--
-- Table structure for table `lra_requests`
--

CREATE TABLE `lra_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employer_id` bigint(20) UNSIGNED NOT NULL,
  `request_type` varchar(255) NOT NULL,
  `activity_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requested_date` date NOT NULL,
  `venue` varchar(255) NOT NULL,
  `expected_participants` int(11) NOT NULL,
  `letter_of_intent_path` varchar(255) DEFAULT NULL,
  `job_advertisement_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected','completed') NOT NULL DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
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
(4, '2024_01_01_000003_add_role_to_users_table', 2),
(5, '2024_01_02_000001_create_job_posts_table', 3),
(6, '2024_01_02_000002_create_applications_table', 3),
(7, '2024_01_02_000003_create_company_profiles_table', 3),
(8, '2024_01_02_000004_create_notifications_table', 4),
(9, '2024_01_15_000001_add_job_post_fields', 5),
(10, '2024_01_20_000001_create_lra_requests_table', 6),
(11, '2024_01_20_000002_create_employer_documents_table', 6),
(12, '2024_01_20_000003_create_applicant_feedback_table', 6),
(13, '2024_01_25_000001_add_company_name_to_job_posts_table', 7),
(14, '2024_01_26_000001_change_status_column_type', 8),
(15, '2024_01_16_000001_add_establishment_details_to_company_profiles', 9),
(18, '2024_03_10_000001_add_establishment_contact_to_company_profiles', 10),
(19, '2024_03_15_000001_add_avatar_to_users_table', 11),
(20, '2024_03_20_000001_add_verification_fields_to_users_table', 12),
(21, '2024_03_20_000002_create_peso_clearances_table', 12),
(22, '2024_03_20_000003_create_report_templates_table', 12),
(23, '2024_03_20_000004_add_status_to_company_profiles_table', 12),
(24, '2024_03_20_000005_add_approval_fields_to_job_posts_table', 12),
(25, '2024_04_01_000001_add_pending_to_job_posts_status', 13),
(26, '2024_04_01_000002_add_experience_education_to_job_posts_table', 14),
(27, '2024_04_01_000003_add_archived_to_job_posts_status', 15),
(28, '2024_05_01_000001_create_jobseeker_profiles_table', 1),
(29, '2024_05_01_000002_create_saved_jobs_table', 16),
(30, '2024_05_01_000003_create_recommended_jobs_table', 16),
(31, '2024_05_01_000002_create_saved_jobs_table', 1),
(32, '2024_05_01_000003_create_recommended_jobs_table', 1),
(33, '2024_05_02_000001_add_document_paths_to_company_profiles_table', 1),
(34, '2024_05_10_000001_add_profile_fields_to_jobseeker_profiles_table', 17),
(37, '2024_10_01_000001_add_job_post_id_to_notifications_table', 18),
(38, '2026_03_17_035652_add_detailed_peso_fields_to_jobseeker_profiles_table', 19),
(39, '2026_03_18_030142_add_missing_columns_to_jobseeker_profiles_table', 20),
(40, '2026_03_18_064406_add_approved_at_to_job_posts_table', 21),
(41, '2024_12_01_000001_add_vacancies_to_job_posts_table', 22),
(43, '2026_04_16_000001_add_missing_document_paths_to_company_profiles_table', 23),
(44, '2026_04_16_000002_add_username_to_users_table', 24);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `job_post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `job_post_id`, `title`, `message`, `link`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 2, 'new_job_post', NULL, 'New Job Post Pending Approval', 'A new job post \"Senior Database Administrator\" from NexaCore Solutions Inc. is waiting for your approval.', 'http://127.0.0.1:8000/admin/jobs/10', 1, '2026-03-11 00:14:10', '2026-03-11 23:40:09'),
(2, 1, 'job_approved', NULL, 'Job Post Approved', 'Your job post \"Senior Database Administrator\" has been approved and is now live.', 'http://127.0.0.1:8000/dashboard/jobs/10', 1, '2026-03-11 00:24:55', '2026-03-11 00:24:55'),
(3, 2, 'new_job_post', NULL, 'New Job Post Pending Approval', 'A new job post \"Technical Support Specialist\" from NexaCore Solutions Inc. is waiting for your approval.', 'http://127.0.0.1:8000/admin/jobs/11', 1, '2026-03-11 16:11:09', '2026-03-11 23:40:09'),
(4, 2, 'new_job_post', NULL, 'New Job Post Pending Approval', 'A new job post \"Junior Web Developer\" from NexaCore Solutions Inc. is waiting for your approval.', 'http://127.0.0.1:8000/admin/jobs/12', 1, '2026-03-11 16:18:29', '2026-03-11 23:40:09'),
(5, 2, 'new_job_post', NULL, 'New Job Post Pending Approval', 'A new job post \"IT Support Specialist\" from NexaCore Solutions Inc. is waiting for your approval.', 'http://127.0.0.1:8000/admin/jobs/13', 1, '2026-03-11 16:28:13', '2026-03-11 23:40:09'),
(6, 2, 'new_job_post', NULL, 'New Job Post Pending Approval', 'A new job post \"Creative Pixel Studio\" from NexaCore Solutions Inc. is waiting for your approval.', 'http://127.0.0.1:8000/admin/jobs/14', 1, '2026-03-11 16:34:13', '2026-03-11 23:40:09'),
(7, 1, 'job_approved', NULL, 'Job Post Approved', 'Your job post \"Creative Pixel Studio\" has been approved and is now live.', 'http://127.0.0.1:8000/dashboard/jobs/14', 1, '2026-03-11 16:42:16', '2026-03-11 16:42:16'),
(8, 1, 'job_approved', NULL, 'Job Post Approved', 'Your job post \"Junior Web Developer\" has been approved and is now live.', 'http://127.0.0.1:8000/dashboard/jobs/12', 1, '2026-03-11 17:02:56', '2026-03-11 17:02:56'),
(9, 1, 'job_approved', NULL, 'Job Post Approved', 'Your job post \"Technical Support Specialist\" has been approved and is now live.', 'http://127.0.0.1:8000/dashboard/jobs/11', 1, '2026-03-11 17:03:18', '2026-03-11 17:03:18'),
(10, 2, 'new_job_post', NULL, 'New Job Post Pending Approval', 'A new job post \"NexaCore Solutions Inc.\" from NexaCore Solutions Inc. is waiting for your approval.', 'http://127.0.0.1:8000/admin/jobs/15', 1, '2026-03-11 21:59:55', '2026-03-11 23:40:09'),
(11, 2, 'new_job_post', NULL, 'New Job Post Pending Approval', 'A new job post \"Software Developer\" from NexaCore Solutions Inc. is waiting for your approval.', 'http://127.0.0.1:8000/admin/jobs/16', 1, '2026-03-11 22:42:13', '2026-03-11 22:42:13'),
(12, 1, 'job_approved', NULL, 'Job Post Approved', 'Your job post \"Software Developer\" has been approved and is now live.', 'http://127.0.0.1:8000/dashboard/jobs/16', 1, '2026-03-11 22:44:17', '2026-03-11 23:47:07'),
(13, 1, 'job_approved', NULL, 'Job Post Approved', 'Your job post \"IT Support Specialist\" has been approved and is now live.', 'http://127.0.0.1:8000/dashboard/jobs/13', 1, '2026-03-11 23:46:32', '2026-03-11 23:47:10'),
(14, 2, 'new_job_post', NULL, 'New Job Post Pending Approval', 'A new job post \"Senior Software Developer\" from NexaCore Solutions Inc. is waiting for your approval.', 'http://127.0.0.1:8000/admin/jobs/17', 1, '2026-03-15 16:43:43', '2026-03-16 01:07:14'),
(15, 1, 'job_approved', NULL, 'Job Post Approved', 'Your job post \"Senior Software Developer\" has been approved and is now live.', 'http://127.0.0.1:8000/dashboard/jobs/17', 1, '2026-03-16 01:07:29', '2026-03-18 21:39:38'),
(16, 1, 'new_application', NULL, 'New Job Application', 'A new applicant has applied for your job: Senior Software Developer', 'http://127.0.0.1:8000/dashboard/applicants/1', 1, '2026-03-16 16:37:10', '2026-03-18 21:39:38'),
(17, 1, 'new_application', NULL, 'New Job Application', 'A new applicant has applied for your job: IT Support Specialist', 'http://127.0.0.1:8000/dashboard/applicants/2', 1, '2026-03-16 19:11:30', '2026-03-18 21:39:38'),
(18, 3, 'application_status_update', NULL, 'Interview Scheduled', 'Great news! You\'ve been shortlisted for an interview for \'IT Support Specialist\'. Check your application for details.', 'http://127.0.0.1:8000/dashboard/jobseeker/applications/2', 1, '2026-03-16 19:12:29', '2026-03-29 16:06:55'),
(19, 1, 'new_application', NULL, 'New Job Application', 'A new applicant has applied for your job: Junior Web Developer', 'http://127.0.0.1:8000/dashboard/applicants/3', 1, '2026-03-17 19:30:41', '2026-03-18 21:39:38'),
(20, 3, 'application_status_update', 12, 'Interview Scheduled', 'Great news! You\'ve been shortlisted for an interview for \'Junior Web Developer\'. Check your application for details.', 'http://127.0.0.1:8000/dashboard/jobseeker/applications/3', 1, '2026-03-17 22:51:56', '2026-03-29 16:06:55'),
(21, 1, 'job_approved', 16, 'Job Post Approved', 'Your job post \"Software Developer\" has been approved and is now live.', 'http://127.0.0.1:8000/dashboard/jobs/16', 1, '2026-03-17 22:58:35', '2026-03-18 21:39:38'),
(22, 1, 'job_approved', 10, 'Job Post Approved', 'Your job post \"Senior Database Administrator\" has been approved and is now live.', 'http://127.0.0.1:8000/dashboard/jobs/10', 1, '2026-03-17 22:59:08', '2026-03-18 21:39:38'),
(23, 1, 'new_application', NULL, 'New Job Application', 'A new applicant has applied for your job: Senior Database Administrator', 'http://127.0.0.1:8000/dashboard/applicants/4', 1, '2026-03-18 19:15:36', '2026-03-18 21:39:38'),
(24, 3, 'application_status_update', 10, 'Congratulations! You Are Hired', 'Congratulations! You\'ve been hired for \'Senior Database Administrator\'. Welcome to the team!', 'http://127.0.0.1:8000/dashboard/jobseeker/applications/4', 1, '2026-03-18 19:16:11', '2026-03-29 16:06:55'),
(25, 1, 'new_application', NULL, 'New Job Application', 'A new applicant has applied for your job: Creative Pixel Studio', 'http://127.0.0.1:8000/dashboard/applicants/5', 0, '2026-04-15 01:08:17', '2026-04-15 01:08:17');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('20221230@nbsc.edu.ph', 'bYlOlqO306uRWaqpRxQZVflN23WLSQST4wqjV94fOYiROB0hX3qxxjwCHFNx', '2026-03-10 00:22:14');

-- --------------------------------------------------------

--
-- Table structure for table `peso_clearances`
--

CREATE TABLE `peso_clearances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recipient_type` enum('employer','jobseeker') NOT NULL,
  `recipient_id` bigint(20) UNSIGNED NOT NULL,
  `clearance_type` enum('employment','clearance','verification') NOT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `status` enum('pending','issued','expired','revoked') NOT NULL DEFAULT 'pending',
  `issued_by` bigint(20) UNSIGNED DEFAULT NULL,
  `issued_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `clearance_number` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
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
  `job_post_id` bigint(20) UNSIGNED NOT NULL,
  `match_score` int(11) NOT NULL DEFAULT 0,
  `match_reasons` text DEFAULT NULL,
  `is_dismissed` tinyint(1) NOT NULL DEFAULT 0,
  `recommended_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_templates`
--

CREATE TABLE `report_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `report_type` enum('job_applications','employers','job_vacancies','clearances','lra_approvals') NOT NULL,
  `fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`fields`)),
  `filters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`filters`)),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
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
  `job_post_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saved_jobs`
--

INSERT INTO `saved_jobs` (`id`, `user_id`, `job_post_id`, `created_at`, `updated_at`) VALUES
(2, 3, 16, '2026-03-12 00:32:43', '2026-03-12 00:32:43'),
(3, 4, 16, '2026-03-15 16:18:24', '2026-03-15 16:18:24'),
(4, 3, 14, '2026-03-16 18:58:42', '2026-03-16 18:58:42'),
(5, 3, 13, '2026-03-17 17:25:20', '2026-03-17 17:25:20'),
(6, 4, 17, '2026-03-17 22:48:20', '2026-03-17 22:48:20'),
(7, 4, 14, '2026-03-17 22:48:22', '2026-03-17 22:48:22'),
(8, 3, 17, '2026-04-20 00:37:58', '2026-04-20 00:37:58');

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
('bloL2xDNBF2vrrX9vJrfzYMFP3o97mTnbHtlcwBU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaFk0dTRERXhYbldRTlVsUGZ3aHBFcVI5UlZoeWp4YjdsU0VVZTBrNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9fQ==', 1776674468),
('mBV4LkmfoNcQEE84MtMiZhaIvZIHU1rqUduoTcrG', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieWxmdXpnQUFPbmhHVzZCa3NHNkdPRk5wT1h4R1V6eFBQVmg1b29payI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQvZW1wbG95ZXIiO3M6NToicm91dGUiO3M6MTg6ImRhc2hib2FyZC5lbXBsb3llciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1776330066),
('taw5FTls1P0M5DNI4WTN97SLxo2bP0NvygAA3WQE', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRVdUcUhaSjZpNzNOZkJkRXRtQ1pQQU5rbVZTMmRhTEE2bm1vNHlCayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1776673997);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` enum('jobseeker','admin','employer') NOT NULL DEFAULT 'jobseeker',
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `barangay` varchar(255) DEFAULT NULL,
  `verification_notes` text DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `avatar`, `role`, `status`, `is_verified`, `barangay`, `verification_notes`, `verified_at`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `verified_by`) VALUES
(1, 'Adrian Michael Cruz', '20221230@nbsc.edu.ph', 'NCSI', NULL, 'employer', 'pending', 0, NULL, NULL, NULL, NULL, '$2y$12$ig2Sf3PwA9E/ObSGnwADuOrePRPQCPGdRFb0dzfaRJQEvYCb3r6vi', NULL, '2026-03-04 21:00:26', '2026-04-15 22:00:49', NULL),
(2, 'Kenzou Cruz', '20231691@nbsc.edu.ph', NULL, NULL, 'admin', 'pending', 0, NULL, NULL, NULL, NULL, '$2y$12$69RMcQ2loqcljV5UxCwMAONTXPfMsuoAlZ1hezgvfQYuv9waQcffW', NULL, '2026-03-10 17:59:20', '2026-03-10 22:03:02', NULL),
(3, 'Yami Uy', '20240530@nbsc.edu.ph', NULL, NULL, 'jobseeker', 'approved', 1, 'Tankulan', 'ohhhh', '2026-03-29 19:26:42', NULL, '$2y$12$lDO.VdmDMo4et49397UB2OSuYiXNG2lgSFIVA9wsSDdurhP3Gsf9.', NULL, '2026-03-10 19:01:34', '2026-03-29 19:26:42', 2),
(4, 'Marky Apsalay', 'putothokage@gmail.com', NULL, NULL, 'jobseeker', 'rejected', 0, NULL, 'dfSFDA', '2026-03-29 19:37:11', NULL, '$2y$12$.pb8Pyqv4Or0JDF2Y6NIfuTlYCWVaSX8AP/d/QdZeeEu5W5zOMiHK', NULL, '2026-03-10 19:10:13', '2026-03-29 19:37:11', 2);

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
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applications_job_post_id_foreign` (`job_post_id`),
  ADD KEY `applications_applicant_id_foreign` (`applicant_id`);

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
  ADD KEY `company_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `employer_documents`
--
ALTER TABLE `employer_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employer_documents_employer_id_foreign` (`employer_id`),
  ADD KEY `employer_documents_verified_by_foreign` (`verified_by`);

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
  ADD KEY `jobseeker_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_posts`
--
ALTER TABLE `job_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_posts_employer_id_foreign` (`employer_id`),
  ADD KEY `job_posts_approved_by_foreign` (`approved_by`),
  ADD KEY `job_posts_rejected_by_foreign` (`rejected_by`);

--
-- Indexes for table `lra_requests`
--
ALTER TABLE `lra_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lra_requests_employer_id_foreign` (`employer_id`),
  ADD KEY `lra_requests_reviewed_by_foreign` (`reviewed_by`);

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
  ADD KEY `notifications_user_id_foreign` (`user_id`),
  ADD KEY `notifications_job_post_id_foreign` (`job_post_id`);

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
  ADD KEY `peso_clearances_issued_by_foreign` (`issued_by`),
  ADD KEY `peso_clearances_recipient_type_recipient_id_index` (`recipient_type`,`recipient_id`),
  ADD KEY `peso_clearances_barangay_index` (`barangay`),
  ADD KEY `peso_clearances_status_index` (`status`);

--
-- Indexes for table `recommended_jobs`
--
ALTER TABLE `recommended_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `recommended_jobs_user_id_job_post_id_unique` (`user_id`,`job_post_id`),
  ADD KEY `recommended_jobs_job_post_id_foreign` (`job_post_id`),
  ADD KEY `recommended_jobs_user_id_index` (`user_id`),
  ADD KEY `recommended_jobs_is_dismissed_index` (`is_dismissed`);

--
-- Indexes for table `report_templates`
--
ALTER TABLE `report_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_templates_created_by_foreign` (`created_by`),
  ADD KEY `report_templates_report_type_index` (`report_type`);

--
-- Indexes for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `saved_jobs_user_id_job_post_id_unique` (`user_id`,`job_post_id`),
  ADD KEY `saved_jobs_job_post_id_foreign` (`job_post_id`),
  ADD KEY `saved_jobs_user_id_index` (`user_id`);

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
  ADD KEY `users_verified_by_foreign` (`verified_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicant_feedback`
--
ALTER TABLE `applicant_feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `company_profiles`
--
ALTER TABLE `company_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employer_documents`
--
ALTER TABLE `employer_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jobseeker_profiles`
--
ALTER TABLE `jobseeker_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_posts`
--
ALTER TABLE `job_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `lra_requests`
--
ALTER TABLE `lra_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `peso_clearances`
--
ALTER TABLE `peso_clearances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recommended_jobs`
--
ALTER TABLE `recommended_jobs`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicant_feedback`
--
ALTER TABLE `applicant_feedback`
  ADD CONSTRAINT `applicant_feedback_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applicant_feedback_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_applicant_id_foreign` FOREIGN KEY (`applicant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_job_post_id_foreign` FOREIGN KEY (`job_post_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_profiles`
--
ALTER TABLE `company_profiles`
  ADD CONSTRAINT `company_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employer_documents`
--
ALTER TABLE `employer_documents`
  ADD CONSTRAINT `employer_documents_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employer_documents_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `jobseeker_profiles`
--
ALTER TABLE `jobseeker_profiles`
  ADD CONSTRAINT `jobseeker_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_posts`
--
ALTER TABLE `job_posts`
  ADD CONSTRAINT `job_posts_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `job_posts_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_posts_rejected_by_foreign` FOREIGN KEY (`rejected_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `lra_requests`
--
ALTER TABLE `lra_requests`
  ADD CONSTRAINT `lra_requests_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lra_requests_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_job_post_id_foreign` FOREIGN KEY (`job_post_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `peso_clearances`
--
ALTER TABLE `peso_clearances`
  ADD CONSTRAINT `peso_clearances_issued_by_foreign` FOREIGN KEY (`issued_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `recommended_jobs`
--
ALTER TABLE `recommended_jobs`
  ADD CONSTRAINT `recommended_jobs_job_post_id_foreign` FOREIGN KEY (`job_post_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recommended_jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_templates`
--
ALTER TABLE `report_templates`
  ADD CONSTRAINT `report_templates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  ADD CONSTRAINT `saved_jobs_job_post_id_foreign` FOREIGN KEY (`job_post_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
