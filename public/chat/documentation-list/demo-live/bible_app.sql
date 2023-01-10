-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 03, 2022 at 02:22 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bible_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `black_lists`
--

CREATE TABLE `black_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `member_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `black_lists`
--

INSERT INTO `black_lists` (`id`, `user_id`, `member_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(28, 4, 11, '2022-01-19 05:26:56', '2022-01-19 05:26:56', NULL),
(35, 26, 10, '2022-01-19 06:01:07', '2022-01-19 06:01:07', NULL),
(37, 26, 12, '2022-01-19 06:01:12', '2022-01-19 06:01:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `calendars`
--

CREATE TABLE `calendars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `calendars`
--

INSERT INTO `calendars` (`id`, `user_id`, `title`, `description`, `schedule`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 12, 'calender event best', 'calendar event description', '2021-11-19 11:41:46', '2021-12-01 05:15:24', '2021-12-01 05:41:26', NULL),
(3, 12, 'calender event title', 'calendar event description', '2021-11-19 11:41:46', '2021-12-01 05:38:54', '2021-12-01 05:38:54', NULL),
(6, 10, 'My First Church', 'There are two entrances: South (main entrance) and West (VCKids check-in). Vancouver Church is following current state regulations. Please enter wearing a mask, even if fully vaccinated. Install our church app in advance for events, news updates, and directions.', '2021-12-02 15:13:51', '2021-12-02 09:43:51', '2021-12-02 09:43:51', NULL),
(7, 10, 'Second Church', 'Whether you\'re new to church, have been a Christian for many years, or are looking for a fresh start, you\'re welcome here. Our hope is to give you a place where you experience a fresh, enjoyable connection to God and a community of people.', '2021-12-02 11:41:46', '2021-12-02 09:48:03', '2021-12-02 09:48:03', NULL),
(8, 10, 'Super Church', 'Whether you\'re new to church, have been a Christian for many years.', '2021-12-02 11:41:46', '2021-12-02 09:48:22', '2021-12-02 09:48:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `churches`
--

CREATE TABLE `churches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uniqid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `church_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `church_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `churches`
--

INSERT INTO `churches` (`id`, `email`, `password`, `user_id`, `uniqid`, `church_name`, `location`, `mobile_number`, `website_url`, `church_image`, `longitude`, `latitude`, `email_verified_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'church1010@mailinator.com', '$2y$10$ga/cWDmUgRBI8uL4qkHf0eAq731xxf2X22DBJ/tLfK7BmY8ga/mae', '2', '1637814576', 'Richmond Church', 'surat', '9999999999999', 'richmondChurch.com', '1637837017.png', -84.302964, 47.42808726171425, NULL, '2021-11-24 22:59:36', '2021-12-22 11:49:05', NULL),
(2, 'rinchurch@mailinator.com', '$2a$10$4UooeEZ71jLX25c5KxFAK.wa9l69e1UN9XVfmqMowBQfCKH7NJejK', '7', '1637833211', 'trst', 'test', '9876543210', 'ytest', '1637837026.png', NULL, NULL, NULL, '2021-11-25 04:10:11', '2021-11-30 08:19:24', NULL),
(3, 'vancouverchurch@mailinator.com', '$2y$10$XAtdsE5cyJELv7tslN./UuYQYX6TP3R01pSxD4QKUwLS6o3ISiR5S', '20', '1638268280', 'vancouver church', 'vancouver', '9876543210', 'vancouverchurch.com', '1638339324.png', NULL, NULL, NULL, '2021-11-30 10:31:20', '2021-12-01 06:15:24', NULL),
(4, 'vancouverchurch@gmail.com', '$2y$10$fKNXvEu3G4vxsKe24fmv.eCTIQBpgv4Rsc0VR97dwx2h/Ll7ex93i', '21', '1638269715', 'vancouverchurc', 'vancouver', '9876543210', 'vancouverchurch.com', '1638269780.png', NULL, NULL, NULL, '2021-11-30 10:55:15', '2021-11-30 10:56:20', NULL),
(5, 'test@gmail.com', 'eyJpdiI6InJKdXhzR2paUnQzbHJEZ0l4VUZ3a0E9PSIsInZhbHVlIjoiYkcyOVpYSVJBY2luM0ZCMjlSMW9rQT09IiwibWFjIjoiMzdkNjA1NzRiYTE0MmZmYTZkZTg5NGJiMTY2N2NjZmU4ODg5MDI0ZTA3MjcxMWRiYmI1ZDlmNTBhMjk0ZWM2YiIsInRhZyI6IiJ9', '23', '1638269977', 'test', 'test', '9876543210', 'test.com', '1638269977.png', NULL, NULL, NULL, '2021-11-30 10:59:37', '2021-11-30 10:59:37', NULL),
(6, 'test12@gmail.com', 'eyJpdiI6ImhabUdZUHpOK1ZBTEt0REV3c3M4YXc9PSIsInZhbHVlIjoiZTJmRXlId2NuYjlGRU93TWExbFFJQT09IiwibWFjIjoiMzFiNTNiMjJhYjhjMzI0ODUzMDY4ZGI5NmI2NmEzYzQxNzEyZTlmMjgwZjg1OGU5MjQxOWY4MTIyNzY2NDI5YiIsInRhZyI6IiJ9', '33', '1640158034', 'VancouverCahund', 'Vancouver Church, place_of_worship, United States', '9876543210', 'https://www.google.com/', '1640158034.png', NULL, NULL, NULL, '2021-12-22 07:27:14', '2021-12-22 07:27:14', NULL),
(7, 'tes@gmail.com', '$2y$10$HVJa/WO0kWMFapjvTVQ2yuIdCZhh/C6FKhdAaDIZTwECbKHs4V6Gm', '34', '1640160110', 'test', 'wr', '9876543210', 'test', '1640160110.png', 75.31127929687501, 21.06399706324597, NULL, '2021-12-22 08:01:50', '2021-12-22 10:43:34', NULL),
(8, 'tes0@gmail.com', '$2y$10$cUkFGA20ddo8Bc1/M8umg.O/Ua.xMrRQvBDJyDVNXb522m4xuuJFC', '35', '1640160209', 'tes', 'sdfd', '9876543210', 'ts', '1640160209.png', 75.31127929687501, 21.06399706324597, NULL, '2021-12-22 08:03:29', '2021-12-22 10:41:56', NULL),
(9, 'tst@gmail.com', '$2a$10$7eH8a2KWW.9ITZ/HP65NGur6xhMuN/zzcDZDnYidAt4kpcNp4bbsW', '36', '1640162354', 'test', 'Surat', '9876543210', 'https://www.maps.ie/coordinates.html', '1640162354.png', 3.9111328126, 3.9111328125, NULL, '2021-12-22 08:39:14', '2021-12-22 13:37:47', NULL),
(10, 'tets@mailinator.com', 'eyJpdiI6Im5lTmlPaFlnL2NKNXg4bEVBWEpPc3c9PSIsInZhbHVlIjoibjFxY3RSODN3VnhDSHpITjZlRW5SUT09IiwibWFjIjoiYWMyNTlhMWNhMjljMzExNjUyNDhlMDY1ZjU1ZjhlODY3ZmJhM2NlYzgwMjY2NjJhYjAzM2VlZWU3MWM1NzMxYyIsInRhZyI6IiJ9', '37', '1640595693', 'mailinator', 'mailinator', '9876543210', 'mailinator', '1640595693.png', -123.0323005, 49.2335832, NULL, '2021-12-27 09:01:33', '2021-12-27 09:01:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `church_banners`
--

CREATE TABLE `church_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `church_id` bigint(20) UNSIGNED DEFAULT NULL,
  `serial_number` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1 COMMENT '0: Not Active, 1: Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `church_banners`
--

INSERT INTO `church_banners` (`id`, `banner_image`, `church_id`, `serial_number`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, '1640179585.png', 1, 3, 1, '2021-12-22 13:26:25', '2021-12-23 06:43:03', NULL),
(3, '1640179764.png', 1, NULL, 1, '2021-12-22 13:29:24', '2021-12-23 06:50:29', NULL),
(6, '1640237915.png', 2, NULL, 1, '2021-12-23 05:04:35', '2021-12-23 06:34:02', NULL),
(7, '1640237829.png', 2, 3, 1, '2021-12-23 05:37:09', '2021-12-23 06:19:52', NULL),
(8, '1640240530.png', 2, 1, 1, '2021-12-23 06:22:10', '2021-12-23 06:34:58', NULL),
(9, '1640240535.png', 2, 4, 1, '2021-12-23 06:22:15', '2021-12-23 06:24:06', NULL),
(10, '1640240542.png', 2, NULL, 1, '2021-12-23 06:22:22', '2021-12-23 06:34:58', NULL),
(11, '1640240547.png', 2, 2, 1, '2021-12-23 06:22:27', '2021-12-23 06:22:45', NULL),
(12, '1640241764.png', 1, 2, 1, '2021-12-23 06:42:44', '2021-12-23 06:43:43', NULL),
(13, '1640241797.png', 1, 5, 1, '2021-12-23 06:43:12', '2021-12-23 06:44:20', NULL),
(14, '1640241811.png', 1, 8, 1, '2021-12-23 06:43:31', '2021-12-23 06:49:50', NULL),
(15, '1640241827.png', 1, NULL, 1, '2021-12-23 06:43:47', '2021-12-23 07:08:13', NULL),
(16, '1640241832.png', 1, 7, 1, '2021-12-23 06:43:52', '2021-12-23 06:49:54', NULL),
(18, '1640241843.png', 1, 4, 1, '2021-12-23 06:44:03', '2021-12-23 06:44:10', NULL),
(19, '1640242978.png', 9, NULL, 1, '2021-12-23 07:02:58', '2021-12-23 07:02:58', NULL),
(20, '1640243020.png', 2, NULL, 1, '2021-12-23 07:03:40', '2021-12-23 07:03:40', NULL),
(21, '1640243267.png', 1, 9, 1, '2021-12-23 07:06:11', '2021-12-23 07:08:13', NULL),
(22, '1640243499.png', 9, 1, 1, '2021-12-23 07:11:39', '2021-12-23 07:11:46', NULL),
(23, '1640243544.png', 7, NULL, 1, '2021-12-23 07:12:24', '2021-12-23 07:12:24', NULL),
(24, '1640409438.png', 3, 1, 1, '2021-12-23 07:12:51', '2021-12-25 05:17:18', NULL),
(25, '1640243697.png', 6, 4, 1, '2021-12-23 07:14:57', '2021-12-23 07:22:22', NULL),
(26, '1640243761.png', 6, 9, 1, '2021-12-23 07:16:01', '2021-12-23 07:22:27', NULL),
(27, '1640409943.png', 3, 2, 1, '2021-12-25 05:14:12', '2021-12-25 05:25:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: InActive, 1: Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `user_id`, `first_name`, `last_name`, `email`, `mobile_number`, `description`, `is_read`, `created_at`, `updated_at`) VALUES
(3, 26, 'Twelve', 'number', '1', '88888888888', NULL, 0, '2022-02-21 11:38:44', '2022-02-21 11:38:44');

-- --------------------------------------------------------

--
-- Table structure for table `diaries`
--

CREATE TABLE `diaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diaries`
--

INSERT INTO `diaries` (`id`, `user_id`, `title`, `description`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 12, 'diary title old', 'diary description old', '', '2021-12-01 05:03:00', '2021-12-01 05:07:49', NULL),
(2, 12, 'Diaty Good', 'diary description', '', '2021-12-01 05:06:08', '2021-12-01 05:09:44', '2021-12-01 05:09:44'),
(3, 10, 'Diaty Good', 'diary description', '', '2021-12-02 13:08:01', '2021-12-02 13:08:01', NULL),
(4, 26, 'Diary daily news', 'diary description check daily', '1640685460.png', '2021-12-28 09:52:22', '2021-12-28 09:57:40', NULL),
(5, 26, 'Super diary', 'diary description', '', '2021-12-28 09:57:59', '2021-12-28 09:57:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule` datetime DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `user_id`, `title`, `schedule`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 7, 'ttt', '2021-11-24 10:03:00', 'gdgfd', '2021-11-30 04:33:29', '2021-11-30 08:19:24', NULL),
(6, 7, 'next', '2021-11-30 12:09:00', 'test', '2021-11-30 06:39:54', '2021-11-30 08:19:24', NULL),
(7, 7, 'best', '2021-12-01 12:10:00', 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2021-11-30 06:40:07', '2021-11-30 08:33:28', NULL),
(8, 2, 'bes', '2021-12-02 12:22:00', 'test', '2021-11-30 06:52:43', '2021-11-30 08:20:57', NULL),
(9, 2, 'Best Event', '2021-12-01 13:47:00', 'trest', '2021-11-30 08:17:44', '2021-12-23 06:57:00', NULL),
(10, 20, 'Today Meet', '2021-12-01 16:47:00', 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nWhy do we use it?\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '2021-11-30 11:18:00', '2021-11-30 11:18:00', NULL),
(11, 20, 'weekly meeting now', '2021-12-02 11:44:00', 'church building, church house, or simply church, is a building used for Christian worship services and other Christian religious activities. The term is usually used to refer to the physical buildings where Christians worship and also to refer to the community of Christians.', '2021-12-01 06:15:09', '2021-12-01 06:15:09', NULL),
(12, 36, 'dd', '2021-12-16 11:34:00', 'dd', '2021-12-25 06:04:49', '2021-12-25 06:04:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `favourite_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `select_id` bigint(20) UNSIGNED DEFAULT NULL,
  `chapterId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `versionId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bookId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `languageId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verseName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`id`, `user_id`, `favourite_type`, `select_id`, `chapterId`, `versionId`, `bookId`, `languageId`, `verseName`, `created_at`, `updated_at`) VALUES
(10, 26, 'posts', 3, NULL, NULL, NULL, NULL, NULL, '2021-12-31 08:27:47', '2021-12-31 08:27:47'),
(19, 26, 'bible_verses', NULL, 'ROM.1', '685d1470fe4d5c3b-01', 'ROM', 'eng', 'test', '2021-12-31 09:10:46', '2021-12-31 09:10:46'),
(21, 26, 'messages', 5, NULL, NULL, NULL, NULL, NULL, '2021-12-31 09:10:58', '2021-12-31 09:10:58');

-- --------------------------------------------------------

--
-- Table structure for table `favourite_types`
--

CREATE TABLE `favourite_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `favourite_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favourite_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favourite_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favourite_types`
--

INSERT INTO `favourite_types` (`id`, `favourite_type`, `favourite_name`, `favourite_description`, `created_at`, `updated_at`) VALUES
(1, 'messages', 'Messages', 'Messages from chat', '2021-12-08 06:30:00', '2021-12-08 06:30:00'),
(2, 'posts', 'Posts', 'Posts from news feed (posted by any user)', '2021-12-08 06:30:00', '2021-12-08 06:30:00'),
(3, 'songs', 'Songs', 'Songs', '2021-12-08 06:30:00', '2021-12-08 06:30:00'),
(4, 'diary_posts', 'Diary posts', 'Diary posts', '2021-12-08 06:30:00', '2021-12-08 06:30:00'),
(5, 'bible_verses', 'Bible verses', 'Bible verses', '2021-12-08 06:30:00', '2021-12-08 06:30:00'),
(6, 'calendar_events', 'Calendar events', 'Calendar events', '2021-12-08 06:30:00', '2021-12-08 06:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `friend_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `friend_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(27, 10, 4, '2021-12-01 13:14:13', '2021-12-01 13:14:13', NULL),
(28, 4, 10, '2021-12-01 13:14:13', '2021-12-01 13:14:13', NULL),
(31, 26, 10, '2021-12-07 10:58:59', '2021-12-07 10:58:59', NULL),
(32, 10, 26, '2021-12-07 10:58:59', '2021-12-07 10:58:59', NULL),
(33, 26, 30, '2021-12-22 09:03:32', '2021-12-22 09:03:32', NULL),
(34, 30, 26, '2021-12-22 09:03:32', '2021-12-22 09:03:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `sender_id`, `receiver_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 11, 26, '2021-12-01 11:04:05', '2021-12-01 11:04:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `group_chats`
--

CREATE TABLE `group_chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `members_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`members_id`)),
  `group_pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_chats`
--

INSERT INTO `group_chats` (`id`, `user_id`, `group_id`, `members_id`, `group_pic`, `group_name`, `created_at`, `updated_at`) VALUES
(6, 4, 1639022815, '\"[\\\"4\\\", \\\"8\\\", \\\"9\\\", \\\"10\\\", \\\"11\\\"]\"', '1639022815.png', 'Technomads Office', '2021-12-09 04:06:55', '2021-12-09 13:58:05'),
(8, 26, 1639024503, '\"[\\\"4\\\",\\\"11\\\",\\\"29\\\"]\"', '1639032185.png', 'Web', '2021-12-09 04:35:03', '2021-12-09 12:57:29'),
(9, 10, 1639029618, '\"[\\\"4\\\", \\\"8\\\", \\\"9\\\", \\\"10\\\", \\\"11\\\"]\"', NULL, 'Technomads Office', '2021-12-09 06:00:18', '2021-12-09 06:00:18'),
(10, 25, 1639029920, '\"[\\\"4\\\", \\\"8\\\", \\\"9\\\", \\\"10\\\", \\\"11\\\"]\"', NULL, 'Tech', '2021-12-09 06:05:20', '2021-12-09 06:05:20'),
(13, 10, 1639043160, '\"[\\\"4\\\",\\\"8\\\",\\\"9\\\",\\\"11\\\"]\"', '1639043160.png', 'Best', '2021-12-09 09:46:00', '2021-12-09 09:46:00'),
(14, 4, 1639043221, '\"[\\\"4\\\",\\\"8\\\",\\\"9\\\",\\\"11\\\",\\\"24\\\",\\\"25\\\"]\"', '1639043221.png', 'Infotech', '2021-12-09 09:47:01', '2021-12-09 09:47:01'),
(15, 11, 1639043240, '\"[\\\"4\\\",\\\"8\\\",\\\"9\\\",\\\"11\\\",\\\"24\\\",\\\"25\\\"]\"', '1639043240.png', 'Infotech', '2021-12-09 09:47:20', '2021-12-09 09:47:20'),
(16, 25, 1639043263, '\"[\\\"4\\\",\\\"8\\\",\\\"9\\\",\\\"11\\\",\\\"24\\\",\\\"25\\\"]\"', '1639043263.png', 'Infotech', '2021-12-09 09:47:43', '2021-12-09 09:47:43'),
(17, 9, 1639043296, '\"[\\\"10\\\",\\\"8\\\",\\\"9\\\",\\\"11\\\",\\\"24\\\",\\\"25\\\"]\"', '1639043296.png', 'Infotech', '2021-12-09 09:48:16', '2021-12-09 09:48:16'),
(18, 9, 1639043325, '\"[\\\"10\\\",\\\"10\\\",\\\"8\\\",\\\"9\\\",\\\"11\\\",\\\"24\\\",\\\"25\\\"]\"', '1639043325.png', 'Infotech', '2021-12-09 09:48:45', '2021-12-09 09:48:45'),
(19, 9, 1639043756, '\"[\\\"10\\\",\\\"4\\\",\\\"8\\\",\\\"9\\\",\\\"11\\\",\\\"24\\\",\\\"25\\\"]\"', '1639043756.png', 'Infotech', '2021-12-09 09:55:56', '2021-12-09 09:55:56'),
(20, 11, 1639043775, '\"[\\\"4\\\",\\\"8\\\"]\"', '1639043775.png', 'Google', '2021-12-09 09:56:15', '2021-12-09 12:57:56'),
(21, 26, 1639050061, '\"[\\\"26\\\",\\\"4\\\",\\\"8\\\",\\\"9\\\",\\\"24\\\"]\"', '1639050061.png', 'Google', '2021-12-09 11:41:01', '2021-12-09 11:41:01');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, 10, 6, '2021-11-30 09:03:04', '2021-11-30 09:18:16', '2021-11-30 09:18:16'),
(17, 10, 9, '2021-11-30 12:34:52', '2021-11-30 12:34:52', NULL),
(18, 12, 9, '2021-12-01 07:13:24', '2021-12-01 07:13:24', NULL),
(19, 12, 9, '2021-12-01 07:17:23', '2021-12-01 07:17:23', NULL),
(20, 12, 9, '2021-12-01 07:18:15', '2021-12-01 07:18:15', NULL),
(21, 12, 9, '2021-12-01 07:19:06', '2021-12-01 07:19:06', NULL),
(22, 24, 9, '2021-12-01 08:41:23', '2021-12-01 08:41:23', NULL),
(23, 17, 9, '2021-12-01 08:43:18', '2021-12-01 08:43:18', NULL),
(24, 24, 9, '2021-12-01 08:45:40', '2021-12-01 08:45:40', NULL),
(25, 10, 6, '2021-12-01 08:47:57', '2021-12-01 08:47:57', NULL),
(26, 10, 6, '2021-12-01 09:32:23', '2021-12-01 09:32:23', NULL),
(27, 10, 6, '2021-12-01 09:34:07', '2021-12-01 09:34:07', NULL),
(28, 10, 6, '2021-12-01 09:35:05', '2021-12-01 09:35:05', NULL),
(29, 26, 23, '2022-01-03 06:36:51', '2022-01-03 06:43:07', '2022-01-03 06:43:07'),
(30, 26, 25, '2022-01-03 06:39:12', '2022-01-03 06:39:12', NULL),
(31, 26, 9, '2022-01-17 07:10:40', '2022-01-17 07:10:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2021_10_22_060919_create_songs_table', 1),
(11, '2021_10_23_040145_create_churches_table', 1),
(12, '2021_10_27_045718_create_events_table', 1),
(13, '2021_10_27_055944_add_otp_to_password_resets_table', 1),
(14, '2021_10_27_114745_add_filed_to_users_table', 1),
(15, '2021_10_29_073240_edit_description_to_users_table', 1),
(16, '2021_10_29_073304_edit_description_type_to_events_table', 1),
(17, '2021_11_01_114941_create_posts_table', 1),
(18, '2021_11_01_114952_create_post_media_table', 1),
(20, '2021_11_12_041902_create_diaries_table', 1),
(21, '2021_11_12_111118_create_calendars_table', 1),
(22, '2021_11_17_040218_create_likes_table', 1),
(23, '2021_11_17_080307_create_friend_requests_table', 1),
(24, '2021_11_17_105150_create_friends_table', 1),
(25, '2021_11_25_044645_add_qr_code_to_users', 2),
(26, '2021_11_01_115008_create_post_comments_table', 3),
(27, '2021_11_25_085031_add_pic_to_users', 4),
(29, '2021_11_26_100402_add_column_device_token_to_users', 5),
(30, '2021_11_26_133340_create_notifications_table', 6),
(31, '2021_11_30_164457_alter_table_churches_change_password', 7),
(32, '2021_12_02_122626_edit_schedule_and_remove_date_to_calendars_table', 8),
(34, '2021_12_02_123426_edit_title_to_events_table', 9),
(35, '2021_12_03_082833_create_push_subscriptions_table', 10),
(36, '2021_12_08_100249_create_favourites_table', 11),
(37, '2021_12_08_100309_create_favourite_types_table', 11),
(38, '2021_12_08_105231_insert_values_to_favourite_types_table', 12),
(41, '2021_12_08_161706_create_group_chats_table', 13),
(42, '2021_12_17_113705_add_ios_device_token_to_users_table', 14),
(45, '2021_12_22_112223_add_language_to_users_table', 15),
(46, '2021_12_22_115623_add_latitude_and_longitude_to_churches_table', 16),
(48, '2021_12_22_172421_create_church_banners_table', 17),
(52, '2021_12_31_122905_add_fields_bible_verses_to_favourites_table', 18),
(54, '2022_01_17_122948_add_shares_to_posts_table', 19),
(58, '2022_01_19_094839_create_black_lists_table', 20),
(59, '2022_02_21_163205_create_contact_us_table', 21),
(60, '2022_02_21_163245_create_work_us_table', 21),
(61, '2022_03_03_121414_add_church_website_to_users_table', 22),
(62, '2022_03_03_171755_add_church_name_to_users_table', 23);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0465c64e-360c-4476-90cd-1b85d16b7bf6', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 32, '{\"user_id\":26,\"post_id\":23,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2022-01-03 06:36:51', '2022-01-03 06:36:51'),
('0b98efae-0cee-42ad-b6d0-7f0e523242ea', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-03 13:24:53', '2021-12-03 12:51:28', '2021-12-03 13:24:53'),
('11aab1be-dce9-41bc-8c5f-1484849f8d04', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":4,\"user_name\":\"Michel\",\"type\":\"new\"}', '2021-12-21 10:44:45', '2021-12-11 10:56:21', '2021-12-21 10:44:45'),
('18fab224-1194-4593-8cbd-f39e7e973514', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-21 10:44:37', '2021-12-09 10:43:28', '2021-12-21 10:44:37'),
('1ad631a7-d0a6-46c4-bbcb-edf4938e9dce', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":10,\"user_name\":\"12numbrs\",\"type\":\"new\"}', '2021-12-21 10:44:41', '2021-12-09 05:05:11', '2021-12-21 10:44:41'),
('2464e77a-1576-41a1-8037-96984d50f18b', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 10, '{\"user_id\":26,\"post_id\":9,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2022-01-17 07:10:40', '2022-01-17 07:10:40'),
('24c46957-fe56-4a16-b3f1-58e6281e3490', 'App\\Notifications\\CommentNotification', 'App\\Models\\User', 26, '{\"user_id\":26,\"post_id\":25,\"type\":\"comment\",\"message\":\"Commented on your post\"}', NULL, '2022-01-03 06:53:19', '2022-01-03 06:53:19'),
('321f7adf-45ad-47b7-8dff-c6864ae53dfe', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":41,\"user_name\":\"testamnssss\",\"type\":\"new\"}', NULL, '2022-03-03 06:54:38', '2022-03-03 06:54:38'),
('3464ca68-bf78-4326-963f-a08da3722fc6', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-21 10:44:37', '2021-12-07 04:34:50', '2021-12-21 10:44:37'),
('3dcb175e-1447-4596-a5a2-df20dabbd1f0', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-21 10:44:37', '2021-12-20 07:14:19', '2021-12-21 10:44:37'),
('41f1735b-82d4-435c-9082-ba7d2df55148', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-21 10:44:37', '2021-12-07 10:50:59', '2021-12-21 10:44:37'),
('4420dd0f-408d-46bd-909b-83af56cd6eff', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-03 13:24:53', '2021-12-03 12:52:25', '2021-12-03 13:24:53'),
('5e031988-933f-4e33-8aba-5a1f74d03013', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', NULL, '2021-12-31 04:33:11', '2021-12-31 04:33:11'),
('61d6e622-586e-4275-8093-dbd9f6fcfeae', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', NULL, '2022-01-03 05:16:02', '2022-01-03 05:16:02'),
('64772c6c-abb4-4633-9cd0-9c6e0ab5414b', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', NULL, '2022-01-03 05:15:49', '2022-01-03 05:15:49'),
('6567748d-8d9b-4656-8594-68f01f536e81', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', NULL, '2022-01-03 05:15:56', '2022-01-03 05:15:56'),
('68282ff2-1808-43ab-8f25-e4b3b6fa1bbf', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":10,\"user_name\":\"12numbrs\",\"type\":\"new\"}', '2021-12-21 10:44:41', '2021-12-09 05:04:24', '2021-12-21 10:44:41'),
('6f6c7014-e05f-47b4-a718-c94af53c9c48', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', NULL, '2021-12-21 10:52:07', '2021-12-21 10:52:07'),
('8279c858-3d71-40a2-aced-2a17b7da6725', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-21 10:44:37', '2021-12-14 08:44:55', '2021-12-21 10:44:37'),
('873a4e1e-968d-4e23-94bb-c4241f1e4e1a', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 4, '{\"user_id\":10,\"member_id\":4,\"type\":\"call\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IACNwJjg3+nh+husQnG7SSESBt1meRKf9BtrtdVUgeTOYL5QmzThJV2hQAAsYAAAhNO1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 10:48:36', '2021-12-11 10:48:36'),
('8819d30f-3c80-4492-9c26-e0464ae5bbaf', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-21 10:44:37', '2021-12-07 04:32:54', '2021-12-21 10:44:37'),
('985a5d23-f894-4653-afb7-e670391cafc4', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 10, '{\"user_id\":26,\"type\":\"request\",\"message\":\"Request received\"}', NULL, '2021-12-07 10:48:10', '2021-12-07 10:48:10'),
('9e0187c9-b309-4c54-a5c9-af8b8691e780', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":10,\"user_name\":\"12numbrs\",\"type\":\"new\"}', '2021-12-21 10:44:41', '2021-12-07 11:40:27', '2021-12-21 10:44:41'),
('9f45e44f-ed9c-4de1-80d8-b816c42ab8d2', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-21 10:44:37', '2021-12-14 08:45:44', '2021-12-21 10:44:37'),
('a45e89d0-e021-4805-ac9a-24b629bd490d', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-03 13:24:53', '2021-12-03 12:54:18', '2021-12-03 13:24:53'),
('b16c72ad-1cd6-4483-8364-80d68adac248', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-21 10:44:37', '2021-12-09 05:24:36', '2021-12-21 10:44:37'),
('b8313c7e-2544-419c-baec-68f62b15bc11', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":32,\"user_name\":\"userapi12345\",\"type\":\"new\"}', '2021-12-21 10:44:43', '2021-12-06 11:13:15', '2021-12-21 10:44:43'),
('bd4187e1-bf65-4a15-bb82-430e746dd10b', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-21 10:44:37', '2021-12-14 08:44:16', '2021-12-21 10:44:37'),
('cda43533-9860-47dc-9e1f-d733e171d343', 'App\\Notifications\\CommentNotification', 'App\\Models\\User', 26, '{\"user_id\":26,\"post_id\":25,\"type\":\"comment\",\"message\":\"Commented on your post\"}', NULL, '2022-01-03 06:52:02', '2022-01-03 06:52:02'),
('d5c6b525-5d96-48ab-8f47-d0f32d8a4c6b', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-03 13:24:53', '2021-12-03 12:54:07', '2021-12-03 13:24:53'),
('d711a67a-d945-4fe1-8405-0e526474bac4', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', NULL, '2021-12-21 10:51:56', '2021-12-21 10:51:56'),
('d92d54d9-aee4-4da3-9013-f6303ad4162f', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-21 10:44:37', '2021-12-09 05:23:42', '2021-12-21 10:44:37'),
('da47e2c9-8886-47c0-ba1d-c5ba76f6187f', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 10, '{\"user_id\":26,\"type\":\"accept\",\"message\":\"Request accepted\"}', NULL, '2021-12-07 10:58:59', '2021-12-07 10:58:59'),
('dbd92ab9-f2af-4399-a0f4-ec330d7391e1', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', NULL, '2021-12-21 10:44:50', '2021-12-21 10:44:50'),
('e273ff4e-4887-4c31-b6a5-6a52ac8ab6f2', 'App\\Notifications\\CommentNotification', 'App\\Models\\User', 3, '{\"user_id\":43,\"post_id\":6,\"type\":\"comment\",\"message\":\"Commented on your post\"}', NULL, '2022-03-03 13:00:05', '2022-03-03 13:00:05'),
('e4170cc9-5ed4-4803-bc3b-cd0a4ab3fe15', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-03 13:24:53', '2021-12-03 12:53:28', '2021-12-03 13:24:53'),
('e9afab97-62ca-483c-ab19-a06adea68262', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":10,\"user_name\":\"12numbrs\",\"type\":\"new\"}', '2021-12-21 10:44:41', '2021-12-09 12:49:58', '2021-12-21 10:44:41'),
('ea84ca56-d061-4189-aa34-befc983dd5f2', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', NULL, '2022-01-03 05:16:14', '2022-01-03 05:16:14'),
('eae21103-cfce-42cb-ae8d-fe54ab774b1d', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 30, '{\"user_id\":26,\"type\":\"accept\",\"message\":\"Request accepted\"}', NULL, '2021-12-22 09:03:32', '2021-12-22 09:03:32'),
('eb668b73-910a-4b96-8da1-c810d3d280e3', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-21 10:44:37', '2021-12-21 10:44:27', '2021-12-21 10:44:37'),
('ebd30d26-a708-47f5-8679-b82071783672', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-21 10:44:37', '2021-12-14 08:50:37', '2021-12-21 10:44:37'),
('ed553b4c-c46c-45a6-96af-331383e18bfd', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":32,\"user_name\":\"userapi12345\",\"type\":\"new\"}', '2021-12-21 10:44:43', '2021-12-06 06:36:53', '2021-12-21 10:44:43'),
('ef940bd3-0b41-4508-a5b2-446ab96aa3cd', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-03 13:24:53', '2021-12-03 12:50:53', '2021-12-03 13:24:53'),
('f2a35849-7eda-493d-9747-75dc7072180e', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":24,\"user_name\":\"michel\",\"type\":\"new\"}', '2021-12-21 10:44:42', '2021-12-09 10:10:09', '2021-12-21 10:44:42'),
('f37810bf-7bcd-4623-8780-2cc452f89186', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 26, '{\"user_id\":26,\"post_id\":25,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2022-01-03 06:39:12', '2022-01-03 06:39:12'),
('f39e0e3d-d326-4df6-bf61-5dcad7e531cd', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-21 10:44:37', '2021-12-07 04:33:52', '2021-12-21 10:44:37'),
('f991f6a1-c0f6-423e-a35f-27012b740b88', 'App\\Notifications\\CommentNotification', 'App\\Models\\User', 32, '{\"user_id\":26,\"post_id\":23,\"type\":\"comment\",\"message\":\"Commented on your post\"}', NULL, '2022-01-03 06:46:49', '2022-01-03 06:46:49'),
('fa5f8466-929e-4434-918a-cf3b00d3ff29', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-03 13:24:53', '2021-12-03 12:52:41', '2021-12-03 13:24:53'),
('ff91926f-9811-411f-814c-1ce2704e99d7', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":26,\"user_name\":\"michelUse\",\"type\":\"new\"}', '2021-12-21 10:44:37', '2021-12-06 08:12:14', '2021-12-21 10:44:37');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0113110150b789c9e821ebf751e25a179635b65362ead0a034075ba7468e8aa6b228eca2afc3d909', 24, 1, 'API Token', '[]', 0, '2021-12-01 08:35:46', '2021-12-01 08:35:46', '2022-12-01 14:05:46'),
('0567c168a580399a1e895049bd75ad9bbe8ad526d65f8468c384de1762f7447dc167c9cac10afef3', 41, 1, 'API Token', '[]', 0, '2022-03-03 06:54:38', '2022-03-03 06:54:38', '2023-03-03 12:24:38'),
('06b0dab9167f28c79fd2b7ad3346ccc71eb32429f6bf32aaeb9ff659a2e8ce2811156ff6e069f94d', 24, 1, 'API Token', '[]', 0, '2021-12-01 06:42:27', '2021-12-01 06:42:27', '2022-12-01 12:12:27'),
('08cf229919423c54f068955ed5ea3f867d12b707fe35cbb9890ad491d892e30c822c130e8eab4a9e', 1, 1, 'API Token', '[]', 0, '2021-11-26 06:49:20', '2021-11-26 06:49:20', '2022-11-26 12:19:20'),
('0c6d83f81975a216d189dc6d3969ada3b8e83469eca5b4400581f613cadbb1991519c0e999cf3466', 26, 1, 'API Token', '[]', 0, '2022-01-03 05:16:02', '2022-01-03 05:16:02', '2023-01-03 10:46:02'),
('0d150fb1e42d532e5ed9e4265946183bd30b51d905b6cd9223bec6428e81071ba49ff6bed6457b2c', 3, 1, 'API Token', '[]', 0, '2021-11-25 00:00:53', '2021-11-25 00:00:53', '2022-11-25 05:30:53'),
('0e2526945f618fda1f0209124f323d8104481219c08181cc88fe1f7e5f22634ba3592a01c9614f72', 1, 1, 'API Token', '[]', 0, '2021-11-26 06:49:20', '2021-11-26 06:49:20', '2022-11-26 12:19:20'),
('10a638487eaf4b60089ce3c7f7e7ee2eea37fb0b6e6ed18d1e3143d0f715c06c3061cc15c44d51a6', 24, 1, 'API Token', '[]', 0, '2021-12-01 08:45:05', '2021-12-01 08:45:05', '2022-12-01 14:15:05'),
('12def3b896feb9be276e5b731e6ececc39dccaace48489ae1fc55b35667eca4e1aeb583bf253b973', 26, 1, 'API Token', '[]', 0, '2021-12-09 05:24:36', '2021-12-09 05:24:36', '2022-12-09 10:54:36'),
('132779b05fad0be809bbbb9239841d957df72d9792f55d0ddb11d1429cf17e17760a34c4c892bb18', 24, 1, 'API Token', '[]', 0, '2021-12-28 09:50:22', '2021-12-28 09:50:22', '2022-12-28 15:20:22'),
('13e687561d762b650d62f6bc311c9ddcd97f6e112c04c9307ea132f766ef0b8094904e72ecc8e63b', 10, 1, 'API Token', '[]', 0, '2021-12-01 08:46:26', '2021-12-01 08:46:26', '2022-12-01 14:16:26'),
('1582f935ff3dd9da2ca37b8f4169b2141ef496420e4fd9b6824f9ac3a792ad837262db23d91ee282', 24, 1, 'API Token', '[]', 0, '2021-12-09 10:09:52', '2021-12-09 10:09:52', '2022-12-09 15:39:52'),
('187e24a76ec15c66bf7c2577c8372b35fd03a3d021f907ebd351ea3e5c261ddcea2e9bc447f7bfef', 10, 1, 'API Token', '[]', 0, '2021-11-26 07:06:20', '2021-11-26 07:06:20', '2022-11-26 12:36:20'),
('1a3f6adf396e50c387d9185d4a084ff7f21768364fafa1e5684c52fd1be35c41c21cc31b948a1129', 26, 1, 'API Token', '[]', 0, '2021-12-14 08:44:55', '2021-12-14 08:44:55', '2022-12-14 14:14:55'),
('1d380f36ec2d0565382160f1ff45a1d43831714ff0d2e781a9375f10a049877f69b7e6dd2948c3e0', 24, 1, 'API Token', '[]', 0, '2021-12-01 08:44:41', '2021-12-01 08:44:41', '2022-12-01 14:14:41'),
('1d6b13d2a1f2844f1d8ebe1defe6b35e2c64ada4ee0cf3438cf06587c937486416a54f711d8b7775', 26, 1, 'API Token', '[]', 0, '2021-12-21 10:44:50', '2021-12-21 10:44:50', '2022-12-21 16:14:50'),
('21780a6faa8a0068b4b8cc35370fa623c68e0d4909ba5b6109919190864dc772258a497ba900a540', 26, 1, 'API Token', '[]', 0, '2021-12-07 10:50:32', '2021-12-07 10:50:32', '2022-12-07 16:20:32'),
('223b2737925c8dd88f32e166f8302802c26edb262f363bd2fcc0bb148e4be3d0466dcfcf47cd1fcd', 24, 1, 'API Token', '[]', 0, '2021-12-01 08:39:01', '2021-12-01 08:39:01', '2022-12-01 14:09:01'),
('2300b654ab0178d2b0428f67a5337b254795c88d73f7f64877f632fd62346264c25b445d4c179428', 15, 1, 'API Token', '[]', 0, '2021-11-30 09:19:34', '2021-11-30 09:19:34', '2022-11-30 14:49:34'),
('2443a7b83a4029c6cb170fdf6fbcd580118d0228e981a68cae1758e2531fea644c62ae999c43793b', 26, 1, 'API Token', '[]', 0, '2021-12-07 04:33:52', '2021-12-07 04:33:52', '2022-12-07 10:03:52'),
('2979c7c51a3cfa0f0c73dd40dab5f450770ea2be730ba9f975f9f86b17b73ef94ac381478e318921', 26, 1, 'API Token', '[]', 0, '2021-12-07 04:32:54', '2021-12-07 04:32:54', '2022-12-07 10:02:54'),
('29e2f5545939de16446bd86903084c9628f0836cd52369316965dc3ba7a7700f164bb9e0ea5e4dfd', 26, 1, 'API Token', '[]', 0, '2021-12-21 10:44:27', '2021-12-21 10:44:27', '2022-12-21 16:14:27'),
('300810f2402189ace8053264bd424c9413b8400237c6f018a6eef749fc799a19e1fb99a7dc9bc8b7', 3, 1, 'API Token', '[]', 0, '2021-11-24 23:51:40', '2021-11-24 23:51:40', '2022-11-25 05:21:40'),
('3020113568a076aeeed2c30d93a44707053f99b46009354e1e1948aad1493775d24e651ad66225b8', 17, 1, 'API Token', '[]', 0, '2021-12-01 08:42:26', '2021-12-01 08:42:26', '2022-12-01 14:12:26'),
('31f2590166748977de08527edf151b4726ae71e5d5e632a02304666bdd3f79ad6901609557408371', 1, 1, 'API Token', '[]', 0, '2021-11-26 06:49:19', '2021-11-26 06:49:19', '2022-11-26 12:19:19'),
('338a79c1031451cce6ab9536a9c0811c452c21702b5c1d5889b39f8c29943b30de8a39df5e5c0fff', 3, 1, 'API Token', '[]', 0, '2021-11-25 00:15:12', '2021-11-25 00:15:12', '2022-11-25 05:45:12'),
('33a192f3183c2812b7198485b55f14a4eaafdb06ab47a87e888b659ada7fa5bfe660c679772565e0', 26, 1, 'API Token', '[]', 0, '2022-01-03 05:15:56', '2022-01-03 05:15:56', '2023-01-03 10:45:56'),
('35dd85d8ddab82f67664bd114acca9d276a11c29317c5f907f864fe51f1adf6f97eed7e8a60886a8', 24, 1, 'API Token', '[]', 0, '2021-12-01 08:40:24', '2021-12-01 08:40:24', '2022-12-01 14:10:24'),
('3698f55aebd64d6e8e26a6493f3fb63d242e6cd2a49b96a4e4c17e907ceff8f7d5bd4df7eeb11ad1', 1, 1, 'API Token', '[]', 0, '2021-11-26 06:40:57', '2021-11-26 06:40:57', '2022-11-26 12:10:57'),
('3ea26e25042285ba2bfbe9f008d34245993d85f3b1ac24d49d3ee455d0d01fc6dc932e6faaff44da', 4, 1, 'API Token', '[]', 0, '2021-11-25 04:43:37', '2021-11-25 04:43:37', '2022-11-25 10:13:37'),
('4c42e367064d7b0575130f217a63797eb712a7203029aa097cdbe58284ef70d84d02d1bb066db20e', 26, 1, 'API Token', '[]', 0, '2021-12-14 08:44:16', '2021-12-14 08:44:16', '2022-12-14 14:14:16'),
('4cf1b30b41d172666c7fee1725cbf310bbc370b9c4e92c32b0e36343de801dd0f2d788913701c446', 10, 1, 'API Token', '[]', 0, '2021-12-07 11:40:07', '2021-12-07 11:40:07', '2022-12-07 17:10:07'),
('51e0ef51e5fdbdc97e430d9a2c1cc41083fe15526e6ac31f26146cf45b667b330ce65bcae7541800', 3, 1, 'API Token', '[]', 0, '2021-11-25 00:00:53', '2021-11-25 00:00:53', '2022-11-25 05:30:53'),
('52ad23b575d221f696e246537a0cbab17d0457be7a6bd8074f4f72acee6930a14172c0f7f90b67a7', 26, 1, 'API Token', '[]', 0, '2021-12-31 04:33:12', '2021-12-31 04:33:12', '2022-12-31 10:03:12'),
('5323b86a8689cf1d0a58b5ced68bdc9c1d63454a8b9ae80de0e21d39d08ade8bac29e2998878afca', 24, 1, 'API Token', '[]', 0, '2021-12-01 06:41:43', '2021-12-01 06:41:43', '2022-12-01 12:11:43'),
('5340e6f2503423b124abacce359b2ee4fff14d3f7c23f90dfbf7bb03274a5bc9ddefc4677faed63c', 24, 1, 'API Token', '[]', 0, '2021-12-09 10:10:09', '2021-12-09 10:10:09', '2022-12-09 15:40:09'),
('5483db8f96fa3b42539a3b03f0bacd1db895ad60ab00c3728245ec9537fd7a74ccbfce212a4997b6', 4, 1, 'API Token', '[]', 0, '2021-12-11 10:56:01', '2021-12-11 10:56:01', '2022-12-11 16:26:01'),
('57680a373e3bcd6c3dcc9af8b5369eb94cd59e39df54f3ec2c341b317206f44b1cfd94202f8a4431', 26, 1, 'API Token', '[]', 0, '2021-12-14 08:50:37', '2021-12-14 08:50:37', '2022-12-14 14:20:37'),
('59fb9ce866b171612d9d80884944ffe630371c55729af2f7ef7b6b900526fe636ae3ee3d6204a73a', 10, 1, 'API Token', '[]', 0, '2021-12-01 08:47:13', '2021-12-01 08:47:13', '2022-12-01 14:17:13'),
('5fa6bf01f30a93116ddb348d58cb5eb5c0e8a263b859cbfc8ea39b42db8ca5f8f16a196c804c2bb5', 10, 1, 'API Token', '[]', 0, '2021-12-09 05:05:11', '2021-12-09 05:05:11', '2022-12-09 10:35:11'),
('62bad5ffdad44faf3d6b5e4ad52df730fdfa9005538c58cc1cbb4a888a34f88445343bbbcd26557d', 26, 1, 'API Token', '[]', 0, '2021-12-06 08:12:14', '2021-12-06 08:12:14', '2022-12-06 13:42:14'),
('64c00979656467c7c82177a35ac325f41ebb89eed9262459433d4a460a06fa8dd1c4bd78a7da2131', 12, 1, 'API Token', '[]', 0, '2021-11-30 12:56:49', '2021-11-30 12:56:49', '2022-11-30 18:26:49'),
('6cc3717332e0ccb6b207a3ca5f18baa86baaebad1419c15b22a8eecc1c3b42eff6b08289b673affb', 1, 1, 'API Token', '[]', 0, '2021-11-27 01:23:16', '2021-11-27 01:23:16', '2022-11-27 06:53:16'),
('6dc331e915bf2de9005fe279b086ad53417788c566ddbb06d83580f5e64c4458438f0e6a022bbf3a', 10, 1, 'API Token', '[]', 0, '2021-12-02 05:52:04', '2021-12-02 05:52:04', '2022-12-02 11:22:04'),
('79634fd6e5b93fa8866e4ee18b439c9dd0e9b1fe4aee2d25673a0d97ed27eb9f324dbec1fc6cc03e', 1, 1, 'API Token', '[]', 0, '2021-11-26 07:49:54', '2021-11-26 07:49:54', '2022-11-26 13:19:54'),
('7bbde1086f02a187ad475530cd54af429846a3ec470d6369f2810566ab6c96325ba6bc851e9532ba', 10, 1, 'API Token', '[]', 0, '2021-11-26 08:04:24', '2021-11-26 08:04:24', '2022-11-26 13:34:24'),
('7d84d94bbecfa7a3c87ea13a0c1966c4ea45bb939e6013a9dc045bb4b4f2d274c0f87b6865c2337c', 1, 1, 'API Token', '[]', 0, '2021-11-26 07:49:52', '2021-11-26 07:49:52', '2022-11-26 13:19:52'),
('7f99e6dd35431bb00645259b3e4c6c2261f6e4166a5f7af1e3db25e9a43d392feac6562dee922555', 10, 1, 'API Token', '[]', 0, '2021-11-26 07:05:51', '2021-11-26 07:05:51', '2022-11-26 12:35:51'),
('7fde3207eb72ec86ec636d576aab7905322923be6c3e263e28108574a440fd8aeb32e3b03236686b', 3, 1, 'API Token', '[]', 0, '2021-11-25 00:15:41', '2021-11-25 00:15:41', '2022-11-25 05:45:41'),
('83de41912e7dbbc3cf0fb8681bdfe6eb4d62b4bf8439131703c01eba50a401f13ed9e91527476615', 10, 1, 'API Token', '[]', 0, '2021-12-09 12:49:58', '2021-12-09 12:49:58', '2022-12-09 18:19:58'),
('8b2bcc5463ed2f7d266029992376650d9ee19a71fb8101f71b2ca05c24b7b4b85ad92c6a3a455dd2', 1, 1, 'API Token', '[]', 0, '2021-11-26 06:49:19', '2021-11-26 06:49:19', '2022-11-26 12:19:19'),
('8b2f39a76f11bb7cf8c99116de2395c53af5d9ac59d3d72700d4fc29ba9ad9891dbafa9d701ac016', 26, 1, 'API Token', '[]', 0, '2021-12-21 10:51:57', '2021-12-21 10:51:57', '2022-12-21 16:21:57'),
('8c5ead1999b7a1fc490f4c1a0d61dac40fb6863dfff2aa40b7748771c62d1e02649eb3cb3b939fb3', 26, 1, 'API Token', '[]', 0, '2021-12-14 08:45:44', '2021-12-14 08:45:44', '2022-12-14 14:15:44'),
('91b2a4ccf7124f80e0d2e6924ade45ab8298355172e0fb11e96a33e370b1f7a5f5d23cdd5e4381e3', 26, 1, 'API Token', '[]', 0, '2022-01-03 05:15:49', '2022-01-03 05:15:49', '2023-01-03 10:45:49'),
('9e243b5463df553802e9eef13ae1cb346a83c8be9a46b9648261c59dcf8288f0579de9f544743bbc', 1, 1, 'API Token', '[]', 0, '2021-11-27 01:22:33', '2021-11-27 01:22:33', '2022-11-27 06:52:33'),
('9e7aaf7968c6dca934067c570b262fa7e2df9c2b80cc8383839d3afaa32b2666cd49c72ba263bb22', 3, 1, 'API Token', '[]', 0, '2021-11-24 23:59:50', '2021-11-24 23:59:50', '2022-11-25 05:29:50'),
('a03bbe965d8828efd483bacc96094aae111dc0e81cccef9127a14b7f2b56bce937db02daa4ab78f2', 32, 1, 'API Token', '[]', 0, '2021-12-06 06:36:53', '2021-12-06 06:36:53', '2022-12-06 12:06:53'),
('a3aaf30aab7c0a2da622e364bb0bf3834c6e36674273ae8b1bcc80d1ad404502ec996efcce257996', 26, 1, 'API Token', '[]', 0, '2021-12-09 10:43:28', '2021-12-09 10:43:28', '2022-12-09 16:13:28'),
('a4614545a742751bc7c3b99b61fbd8ab1235d9622753d9e6f5f4e0e03cb8b08783ef4c082bf7440c', 32, 1, 'API Token', '[]', 0, '2021-12-06 11:12:12', '2021-12-06 11:12:12', '2022-12-06 16:42:12'),
('a77f1a528abbedeef7fbcdf3054db4c005cce2edad611ffa5bcfc60779427ed68548b7ebcbc5ba55', 10, 1, 'API Token', '[]', 0, '2021-12-02 05:42:14', '2021-12-02 05:42:14', '2022-12-02 11:12:14'),
('a80f434d9bdaa053f338391116efb7334ae9c1d068000fd722a6038764e81517867a523f44e081e3', 26, 1, 'API Token', '[]', 0, '2021-12-20 07:14:20', '2021-12-20 07:14:20', '2022-12-20 12:44:20'),
('a8a38766f0e8002cbf15caf8d907564befc4bd48bd364514e6ec17acc763916009970cbb0d396718', 10, 1, 'API Token', '[]', 0, '2021-12-02 05:51:40', '2021-12-02 05:51:40', '2022-12-02 11:21:40'),
('ab3004b9559013c555cadfffacf6b881bbfa05a8bc210d95d3e368a4969e4bed9bb2ccdb084011c3', 1, 1, 'API Token', '[]', 0, '2021-11-26 06:49:20', '2021-11-26 06:49:20', '2022-11-26 12:19:20'),
('af9002915aa123029ef882f55e570ef187b7c3b177c26feae02494a5a8bbab2b38f6b6c2dac0b772', 1, 1, 'API Token', '[]', 0, '2021-11-27 01:23:15', '2021-11-27 01:23:15', '2022-11-27 06:53:15'),
('b1f7b301c30e0bf48cc7422dcbeb6fb51ad47f9594bd2ba58c315177c437d1838b09c051042dd373', 26, 1, 'API Token', '[]', 0, '2021-12-07 04:34:50', '2021-12-07 04:34:50', '2022-12-07 10:04:50'),
('b7dd1f11956a6ed416b5fd49278e98503a2a34b3f4bd646b7e7a4a43d99fa2e245cabd553bf8d453', 1, 1, 'API Token', '[]', 0, '2021-11-27 01:23:16', '2021-11-27 01:23:16', '2022-11-27 06:53:16'),
('c1fa20c9730c246ea3992dac9de1447672cfa64623d0e39ddee44c24a1289fa894acb5ea18a6c519', 43, 1, 'API Token', '[]', 0, '2022-03-03 12:47:44', '2022-03-03 12:47:44', '2023-03-03 18:17:44'),
('c8f648cf712cf57cb1873ee55e55d9595c4e9f30f1b7046410146808a02375b395e0df71424833cf', 32, 1, 'API Token', '[]', 0, '2021-12-06 11:11:13', '2021-12-06 11:11:13', '2022-12-06 16:41:13'),
('ccbcae3e2d55d7066516eb8319300639a1c9f0274306df401590ca81a77e9fff61c8d2cc768f98d6', 10, 1, 'API Token', '[]', 0, '2021-11-26 08:02:34', '2021-11-26 08:02:34', '2022-11-26 13:32:34'),
('ce8cd8fe00fb5f9a357c7b165f828b6e7b2dbef608581bd485f0079eeb2ad0283f201ab08caf01fd', 26, 1, 'API Token', '[]', 0, '2021-12-09 05:23:42', '2021-12-09 05:23:42', '2022-12-09 10:53:42'),
('d36ef785f77ea369f916c06ccde1a3ef5fed4846ccdd0ac63c5b449364c174828421448d9d00a367', 26, 1, 'API Token', '[]', 0, '2021-12-07 10:50:59', '2021-12-07 10:50:59', '2022-12-07 16:20:59'),
('d68f533442c0e5480510e24ef7f610c94e230b9104188d0e785303f51b5e67336659059e1e5b2d43', 1, 1, 'API Token', '[]', 0, '2021-11-26 06:38:31', '2021-11-26 06:38:31', '2022-11-26 12:08:31'),
('dd317996fb8a6b1b331ba93234e2952ad54095a983c40bb8e36c3fb227d544791173b88f35f537f6', 12, 1, 'API Token', '[]', 0, '2021-11-30 12:56:29', '2021-11-30 12:56:29', '2022-11-30 18:26:29'),
('dd3f1ed297df350fc2332cbe22635646a303a2ca6538a1ee64a528cd4755e209daaa91979606c4df', 3, 1, 'API Token', '[]', 0, '2021-11-25 00:00:22', '2021-11-25 00:00:22', '2022-11-25 05:30:22'),
('def0302004482c72da7dbefdea9289cc6f60020e503d382beae2070a71dca3e4d63dcd00fc5e19f0', 10, 1, 'API Token', '[]', 0, '2021-12-07 11:40:27', '2021-12-07 11:40:27', '2022-12-07 17:10:27'),
('e1e5019f3b9b01d245d8bd3517bc93493e895920561769e0a000c6db4aa6022ed4ec769acf79878c', 26, 1, 'API Token', '[]', 0, '2021-12-21 10:52:07', '2021-12-21 10:52:07', '2022-12-21 16:22:07'),
('e28c2079f41e039d57a04b011178e34e0d0ba3b1a9eec1fdb74e6597250d04183bbc558373455ecc', 3, 1, 'API Token', '[]', 0, '2021-11-25 23:07:33', '2021-11-25 23:07:33', '2022-11-26 04:37:33'),
('e38a77e0e2551b08afae3925a3901f15d8a3417955c3838948d6b47859b36ccb0bfacd98727fcdc5', 32, 1, 'API Token', '[]', 0, '2021-12-06 11:13:15', '2021-12-06 11:13:15', '2022-12-06 16:43:15'),
('e5a07e7dfce4185b92c750604dc27c346550142abc2135d548898935fb27dc0b49a41ba57e5cecb8', 1, 1, 'API Token', '[]', 0, '2021-11-27 01:23:14', '2021-11-27 01:23:14', '2022-11-27 06:53:14'),
('e800a665cba4229b2e1b36a85f7477ad143134229d52ee819a979b49033f5eb331c992efa7ffc173', 24, 1, 'API Token', '[]', 0, '2021-12-06 08:08:31', '2021-12-06 08:08:31', '2022-12-06 13:38:31'),
('e9b9d2f573ff1a6a90f7fd2a7ecaf28768c545748618ec22ea90b820ec6601c6a80e6bf3066afba1', 24, 1, 'API Token', '[]', 0, '2021-12-01 06:40:03', '2021-12-01 06:40:03', '2022-12-01 12:10:03'),
('ea0dcac6da77687985791b5c4e74d7554a447f42046b1344398d1f54a17812879db9a2ecf2be0000', 17, 1, 'API Token', '[]', 0, '2021-12-01 08:42:47', '2021-12-01 08:42:47', '2022-12-01 14:12:47'),
('eeebc4449aa0410e7a48af409e1f33082adca4ac8fcd37b6aca021ba801aca25b51923d682066a16', 24, 1, 'API Token', '[]', 0, '2021-12-01 06:39:55', '2021-12-01 06:39:55', '2022-12-01 12:09:55'),
('f0012e9612a17f699b6d2e563447d8b983fcc055bf8534ba6bcf1174736ccd5eab46d12cf7c62f5c', 4, 1, 'API Token', '[]', 0, '2021-12-11 10:56:21', '2021-12-11 10:56:21', '2022-12-11 16:26:21'),
('f10d4d54450aca2a5c6397509e7fd1b5f8d6dd40e2e2acb3fc8d086737e2a000dd17597dfbad6379', 26, 1, 'API Token', '[]', 0, '2022-01-03 05:16:14', '2022-01-03 05:16:14', '2023-01-03 10:46:14'),
('f91c1196ab960422a0ba86ce0084e3e926e1b4eaf990c430d4b85ff1c27a12374be7531276d91c05', 1, 1, 'API Token', '[]', 0, '2021-11-27 01:22:30', '2021-11-27 01:22:30', '2022-11-27 06:52:30'),
('fa295149553b4b452f713c51caaf4069747e03ff932757880c95f6f1385636be4c8d05dde7f6eb0a', 10, 1, 'API Token', '[]', 0, '2021-12-09 05:04:24', '2021-12-09 05:04:24', '2022-12-09 10:34:24'),
('fa9966be010a9a44a0a484a1f65662be9302c21ecb1a319ae8a64022bf2c8f0f8a8f4460a2b1085c', 24, 1, 'API Token', '[]', 0, '2021-12-01 06:39:17', '2021-12-01 06:39:17', '2022-12-01 12:09:17'),
('fbc16e43d8f7770622c412725c5b1702b404b13b28c76d302d2ee586b259d4172c1ae4049a74d24e', 1, 1, 'API Token', '[]', 0, '2021-11-27 01:22:32', '2021-11-27 01:22:32', '2022-11-27 06:52:32'),
('fe3d0c347b58b89db26d91bc7054ff3170afb415114da21f701f7e56935cff135d49643bc16df330', 24, 1, 'API Token', '[]', 0, '2021-11-30 13:44:08', '2021-11-30 13:44:08', '2022-11-30 19:14:08');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'BibleChat Personal Access Client', 'XQhiBl9bWSJS4ATNy2g0BkLOCBFApumQPcnp8Fsv', NULL, 'http://localhost', 1, 0, 0, '2021-11-24 23:49:56', '2021-11-24 23:49:56'),
(2, NULL, 'BibleChat Password Grant Client', 'srTEAfgax95LOfi6ojPK3oWsMQUo1QaluLZSkEkD', 'users', 'http://localhost', 0, 1, 0, '2021-11-24 23:49:56', '2021-11-24 23:49:56');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-11-24 23:49:56', '2021-11-24 23:49:56');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expire_otp_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `otp`, `expire_otp_time`, `token`, `created_at`) VALUES
('test1010@mailinator.com', '320162', '1637901573', NULL, NULL),
('test2010@mailinator.com', '675673', '1639220281', NULL, NULL),
('user9@mailinator.com', '806476', '1637911054', NULL, NULL),
('user10@mailinator.com', '297963', '1637915656', NULL, NULL),
('user11@mailinator.com', '230820', '1639054302', NULL, NULL),
('11user@mailinator.com', '299090', '1638257044', NULL, NULL),
('12number@mailinator.com', '163761', '1638277109', NULL, NULL),
('12number1@mailinator.com', '812174', '1638259267', NULL, NULL),
('12number12@mailinator.com', '366432', '1638262437', NULL, NULL),
('chandni@mailinator.com', '532307', '1638264064', NULL, NULL),
('12number112@mailinator.com', '582232', '1638266414', NULL, NULL),
('12number1112@mailinator.com', '742595', '1638348266', NULL, NULL),
('michelUser@mailinator.com', '196535', '1640685142', NULL, NULL),
('testMan@mailinator1.com', '335338', '1638359959', NULL, NULL),
('testMan@mailinator.com', '548128', '1641187012', NULL, NULL),
('testMan@mailinator.com2', '482044', '1638444102', NULL, NULL),
('testMan@mailinator2.com', '924183', '1638446053', NULL, NULL),
('testMan@mailinator3.com', '427795', '1638513085', NULL, NULL),
('userapi123@mailinator.com', '556877', '1638771358', NULL, NULL),
('userapi1234@mailinator.com', '504414', '1638771444', NULL, NULL),
('userapi12345@mailinator.com', '183359', '1638789252', NULL, NULL),
('testMans@mailinator.com', '343631', '1646290369', NULL, NULL),
('testMansss@mailinator.com', '832968', '1646290432', NULL, NULL),
('testMans11ss@mailinator.com', '646110', '1646290506', NULL, NULL),
('testMans11sss@mailinator.com', '496464', '1646290548', NULL, NULL),
('testMan2@mailinator.com', '627642', '1646309246', NULL, NULL),
('testMan365@mailinator.com', '885219', '1646311675', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `shares` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `description`, `likes`, `shares`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 3, 'test post3', 'atest post description data', NULL, 0, '2021-11-25 06:02:14', '2021-11-25 06:20:31', NULL),
(6, 3, 'Test post', 'Test post description data', 11, 0, '2021-11-25 06:22:38', '2021-12-01 09:35:05', NULL),
(7, 3, 'Test post', 'Test post description data', NULL, 0, '2021-11-25 06:23:26', '2021-11-25 06:23:26', NULL),
(8, 3, 'Test post', 'Test post description data', NULL, 0, '2021-11-25 06:39:33', '2021-11-25 06:39:33', NULL),
(9, 10, 'Test post', 'Test post description data', 9, 9, '2021-11-30 08:35:56', '2022-01-17 07:22:39', NULL),
(10, 12, 'Best Post', 'Church 2 Test post description data', NULL, 0, '2021-11-30 12:57:49', '2021-11-30 12:57:49', NULL),
(11, 12, 'Best 2 Post 2', 'Church 3 Test post description data', NULL, 0, '2021-11-30 12:58:12', '2021-11-30 12:58:12', NULL),
(12, 12, 'Best 2 Post 2', 'Church 3 Test post description data', NULL, 0, '2021-11-30 12:58:39', '2021-11-30 12:58:39', NULL),
(13, 12, 'Best 2 Post 2', 'Church 3 Test post description data', NULL, 0, '2021-12-02 10:12:01', '2021-12-01 07:12:01', NULL),
(14, 12, 'Best 2 Post 2', 'Church 3 Test post description data', NULL, 0, '2021-12-01 07:13:17', '2021-12-01 07:13:17', NULL),
(15, 10, 'Best 2 Post 2', 'Church 3 Test post description data', NULL, 0, '2021-12-02 10:11:20', '2021-12-02 10:11:20', NULL),
(16, 32, 'test post', 'description in title', NULL, 0, '2021-12-06 06:44:17', '2021-12-06 06:44:17', NULL),
(17, 32, 'test post', 'description in title', NULL, 0, '2021-12-06 06:44:58', '2021-12-06 06:44:58', NULL),
(18, 32, 'kjgbkj', 'FYI thugs. Hkhk. Highly highly ghj h ghj hi', NULL, 0, '2021-12-06 06:50:15', '2021-12-06 06:50:15', NULL),
(19, 32, 'kjgbkj', 'FYI thugs. Hkhk. Highly highly ghj h ghj hi', NULL, 0, '2021-12-06 06:50:34', '2021-12-06 06:50:34', NULL),
(20, 32, 'Derry', 'Duffy fghfgh fghfghj', NULL, 0, '2021-12-06 06:54:16', '2021-12-06 06:54:16', NULL),
(21, 32, 'Trujillo', 'gyjigy ghj gym', NULL, 0, '2021-12-06 10:24:42', '2021-12-06 10:24:42', NULL),
(22, 32, 'add new image', 'Ghj ghj mghghkghkhgkgk', NULL, 0, '2021-12-06 10:37:32', '2021-12-06 10:37:32', NULL),
(23, 32, 'nvm', 'Bmmnbmn,man,man.m.m,.m,.,m.m,.', 0, 0, '2021-12-06 10:40:27', '2022-01-03 06:43:07', NULL),
(24, 26, 'Best 2 Post 2', 'Church 3 Test post description data', NULL, 0, '2021-12-28 10:11:33', '2021-12-28 10:11:33', NULL),
(25, 26, 'test 2 Post 2', 'Church 3', 1, 0, '2021-12-28 10:11:58', '2022-01-03 06:39:12', NULL),
(26, 26, 'Best 2 Post 2', 'Church 3 Test post description data', NULL, 0, '2022-01-17 05:39:47', '2022-01-17 05:39:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`id`, `user_id`, `post_id`, `comment`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 5, 'hellofgdfg i\'m comment', '2021-11-25 06:03:34', '2021-11-25 06:20:31', '2021-11-25 06:20:31'),
(2, 10, 5, 'hiii i\'m comment', '2021-11-29 12:46:16', '2021-11-30 04:45:52', '2021-11-30 04:45:52'),
(3, 10, 6, 'hiii i\'m comment', '2021-11-29 12:46:22', '2021-11-30 09:22:06', '2021-11-30 09:22:06'),
(4, 10, 6, 'hiii i\'m comment', '2021-11-29 12:46:42', '2021-11-29 12:46:42', NULL),
(5, 10, 6, 'hiii i\'m comment', '2021-11-29 12:47:12', '2021-11-29 12:47:12', NULL),
(6, 10, 6, 'Super', '2021-11-29 12:47:22', '2021-12-01 08:43:27', NULL),
(7, 10, 6, 'hiii i\'m comment', '2021-11-29 12:47:28', '2021-11-29 12:47:28', NULL),
(8, 10, 6, 'hiii i\'m comment', '2021-11-29 12:47:38', '2021-11-29 12:47:38', NULL),
(9, 10, 6, 'hiii i\'m comment', '2021-11-29 12:47:57', '2021-11-29 12:47:57', NULL),
(10, 10, 6, 'hi i\'m comment your post', '2021-11-29 12:48:38', '2021-11-29 12:48:38', NULL),
(11, 10, 6, 'hi i\'m comment your post', '2021-11-30 09:20:38', '2021-11-30 09:20:38', NULL),
(12, 10, 6, 'hi i\'m comment your post', '2021-11-30 09:22:51', '2021-11-30 09:22:51', NULL),
(13, 12, 6, 'hi i\'m comment your post', '2021-12-01 07:24:40', '2021-12-01 07:24:40', NULL),
(14, 12, 6, 'hi i\'m comment your post', '2021-12-01 07:28:43', '2021-12-01 07:28:43', NULL),
(15, 12, 6, 'hi i\'m comment your post', '2021-12-01 07:29:51', '2021-12-01 07:29:51', NULL),
(16, 24, 6, 'Super', '2021-12-01 08:41:33', '2021-12-01 08:41:33', NULL),
(17, 17, 6, 'Super', '2021-12-01 08:43:15', '2021-12-01 08:43:15', NULL),
(18, 17, 9, 'Super', '2021-12-01 08:44:04', '2021-12-01 08:44:04', NULL),
(19, 24, 9, 'Super', '2021-12-01 08:45:33', '2021-12-01 08:45:33', NULL),
(20, 10, 6, 'Super', '2021-12-01 08:47:53', '2021-12-01 08:47:53', NULL),
(21, 26, 23, 'Super', '2022-01-03 06:46:49', '2022-01-03 06:46:49', NULL),
(22, 26, 25, 'best caption', '2022-01-03 06:52:02', '2022-01-03 06:52:02', NULL),
(23, 26, 25, 'best caption', '2022-01-03 06:53:09', '2022-01-03 06:53:09', NULL),
(24, 26, 25, 'best caption', '2022-01-03 06:53:11', '2022-01-03 06:53:11', NULL),
(25, 26, 25, 'best caption', '2022-01-03 06:53:12', '2022-01-03 06:53:12', NULL),
(26, 26, 25, 'best caption', '2022-01-03 06:53:19', '2022-01-03 06:53:19', NULL),
(27, 43, 6, 'Super', '2022-03-03 13:00:05', '2022-03-03 13:00:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_media`
--

CREATE TABLE `post_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `media_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media_type` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_media`
--

INSERT INTO `post_media` (`id`, `post_id`, `media_name`, `media_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(27, 5, '16378399340.png', 'png', '2021-11-25 06:02:14', '2021-11-25 06:08:46', '2021-11-25 06:08:46'),
(28, 5, '16378399341.png', 'png', '2021-11-25 06:02:14', '2021-11-25 06:08:46', '2021-11-25 06:08:46'),
(29, 5, '16378403260.png', 'png', '2021-11-25 06:08:46', '2021-11-25 06:20:31', '2021-11-25 06:20:31'),
(30, 5, '16378403261.png', 'png', '2021-11-25 06:08:46', '2021-11-25 06:20:31', '2021-11-25 06:20:31'),
(31, 5, '16378403262.png', 'png', '2021-11-25 06:08:46', '2021-11-25 06:20:31', '2021-11-25 06:20:31'),
(32, 8, '16378421730.mp4', 'mp4', '2021-11-25 06:39:33', '2021-11-25 06:39:33', NULL),
(33, 5, '16382474820.png', 'png', '2021-11-30 04:44:42', '2021-11-30 04:45:52', '2021-11-30 04:45:52'),
(34, 5, '16382474821.png', 'png', '2021-11-30 04:44:42', '2021-11-30 04:45:52', '2021-11-30 04:45:52'),
(35, 5, '16382474822.png', 'png', '2021-11-30 04:44:42', '2021-11-30 04:45:52', '2021-11-30 04:45:52'),
(36, 9, '16382613560.mp4', 'mp4', '2021-11-30 08:35:56', '2021-11-30 08:35:56', NULL),
(37, 10, '16382770690.png', 'png', '2021-11-30 12:57:49', '2021-11-30 12:57:49', NULL),
(38, 11, '16382770920.png', 'png', '2021-11-30 12:58:12', '2021-11-30 12:58:12', NULL),
(39, 12, '16382771190.png', 'png', '2021-11-30 12:58:39', '2021-11-30 12:58:39', NULL),
(40, 13, '16383427210.png', 'png', '2021-12-01 07:12:01', '2021-12-01 07:12:01', NULL),
(41, 14, '16383427970.png', 'png', '2021-12-01 07:13:17', '2021-12-01 07:13:17', NULL),
(42, 23, '16387872270.png', 'png', '2021-12-06 10:40:27', '2021-12-06 10:40:27', NULL),
(43, 24, '16406862930.jpg', 'jpg', '2021-12-28 10:11:33', '2021-12-28 10:11:33', NULL),
(44, 25, '16406863180.png', 'png', '2021-12-28 10:11:58', '2021-12-28 10:11:58', NULL),
(45, 25, '16406863181.png', 'png', '2021-12-28 10:11:58', '2021-12-28 10:11:58', NULL),
(46, 25, '16406863182.png', 'png', '2021-12-28 10:11:58', '2021-12-28 10:11:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `push_subscriptions`
--

CREATE TABLE `push_subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscribable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscribable_id` bigint(20) UNSIGNED NOT NULL,
  `endpoint` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_encoding` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `song_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `song_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `song_name`, `song_link`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'best', 'https://open.spotify.com/track/4iKGu3xtvm90eBw0EIPWJP?si=dcf97623bc254e08', '2021-11-30 13:14:59', '2021-12-01 05:53:56', NULL),
(2, 'tum mile', 'https://open.spotify.com/track/4iKGu3xtvm90eBw0EIPWJP?si=dcf97623bc254e08', '2021-12-01 05:53:51', '2021-12-01 05:53:59', '2021-12-01 05:53:59'),
(3, 'tum mile', 'https://open.spotify.com/track/4iKGu3xtvm90eBw0EIPWJP?si=dcf97623bc254e08', '2021-12-01 05:54:03', '2021-12-01 05:54:03', NULL),
(4, 'song border', 'https://open.spotify.com/track/4iKGu3xtvm90eBw0EIPWJP?si=dcf97623bc254e08', '2021-12-28 12:18:48', '2022-02-21 13:01:50', '2022-02-21 13:01:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uniqid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `church_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `u_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USR' COMMENT 'ADM=Admin, USR=User, CHR=Church',
  `ref_user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_code` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pic` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ios_device_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'en = English, zh-CN = Chinese',
  `church_website` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `church_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `first_name`, `last_name`, `uniqid`, `mobile_number`, `church_id`, `email`, `email_verified_at`, `password`, `remember_token`, `u_type`, `ref_user_id`, `qr_code`, `pic`, `device_token`, `ios_device_token`, `language`, `church_website`, `church_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', NULL, NULL, '', NULL, NULL, 'admin@test.com', '2021-10-22 05:40:15', '$2a$12$2kkEKi9W.YGAFOZVyxI7f..CveZ5KxLWKxNvbprKTq0/WunjfHFIm', NULL, 'ADM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-10-22 14:30:47', '2021-11-27 01:23:16', NULL),
(2, 'richmondchurch', NULL, NULL, '1637814576', NULL, NULL, 'church1010@mailinator.com', '2021-11-24 22:59:36', '$2y$10$pRPXHDJwx69zxmJRzePKpODQ9faUwOk8t1jcqYGzddno3tyfxgtVK', 'vKGiWvaoNj9P2C1dLbMnDOsJ8hHN05aX5CHINCVhjijcvrkPl5Wq6pgY8KeK', 'CHR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-24 22:59:36', '2021-12-22 11:13:09', NULL),
(3, 'Mic', 'useri', 'use', '1637816125', '8200148093', '2', 'test1010@mailinator.com', '2021-11-25 00:15:41', '$2y$10$dj2zZmu3VnDXUwJQmrnLJ.1P.fHapwQsROhHO2q.JYF0oEspvMTEW', NULL, 'USR', NULL, 'QR_1637816125.png', '1637837072.png', 'e3y6B0ZdT46K-7nHBhGEla:APA91bEHemHjMuAD8x0U1hCRLzTRqKgwOEvzgh5bfGT6Xf1Og1bqCALSOUrU__ANFiKPj22vtQmNHFuebgcFaFrbzz8k2V1gDuatKX0QCmaXKiMj0ncLgGCePOFFWL6OirqRBuqtvR5Y', NULL, NULL, NULL, NULL, '2021-11-24 23:25:25', '2021-11-25 23:08:07', NULL),
(4, 'Michel', 'User', 'Jackson', '1637828497', '8200148093', '1', 'test2010@mailinator.com', '2021-12-11 10:56:21', '$2y$10$C4Wbzt8jTtq.gUBCBuc5suFlPSdavZUfmNI22B1f7tpMz1RYVmbuK', NULL, 'USR', '1637816125', 'QR_1637828497.png', '1637837072.png', 'cLJTkgGBxUl2iKy1T683qR:APA91bHd3TUEGWBQpc_FjFBEiJnvch0xgCaI6NUF9fP9gsymMsNYWOvlRzsHNtkCX68fBJiy28YcUzav37bBdidWXalF-AXQdt5FnuLT_aSi9RpBsC0uEMT32EnlchQmw4jHC5kRqxmI', '1c6414148519ace652d4616d7071d393db1c72ff772bd0e531cbbf47edf87271', NULL, NULL, NULL, '2021-11-25 02:51:37', '2021-12-11 10:56:21', NULL),
(7, 'trst', NULL, NULL, '1637833211', NULL, NULL, 'rinchurch@mailinator.com', '2021-11-25 04:10:11', '$2a$10$4UooeEZ71jLX25c5KxFAK.wa9l69e1UN9XVfmqMowBQfCKH7NJejK', NULL, 'CHR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-25 04:10:11', '2021-11-30 08:19:24', NULL),
(8, 'userT', 'User', 'Two', '1637910934', '8200148093', '1', 'user9@mailinator.com', '2021-11-28 23:28:32', '$2y$10$1Xl.1bnbXj2Bp4QLH1XkFeJxobfAbqHPKqhU0ZApzl42hYI9gM4yy', NULL, 'USR', '1637816125', 'QR_1637910934.png', NULL, '9efbfcbfdbecf1e5a7d4020bbd64d0f39f879a59adec2f57e45cea1ca5c31e9f', NULL, NULL, NULL, NULL, '2021-11-26 01:45:34', '2021-11-28 23:28:32', NULL),
(9, 'user10', 'U', 'Two1', '1637911199', '8200148093', '1', 'user10@mailinator.com', '2021-11-30 04:14:42', '$2y$10$eFNI3xHdO8G3KEf4FTroYu85w2L7xNek1SIMrLYwmyIr5MPNbT8y.', NULL, 'USR', '1637816125', 'QR_1637911199.png', NULL, '9efbfcbfdbecf1e5a7d4020bbd64d0f39f879a59adec2f57e45cea1ca5c31e9f', NULL, NULL, NULL, NULL, '2021-11-26 01:49:59', '2021-11-30 04:14:42', NULL),
(10, '12numbrs', 'Twelve', 'number', '1637916151', '8200148093', '1', 'user11@mailinator.com', '2021-12-09 12:49:58', '$2y$10$CosAzQbh0R9xEqewx9NoNegWw3ur4eRkxhOFx/kXE9Thw.Gd8V3j6', NULL, 'USR', '1637816125', 'QR_1637916151.png', '1638350429.png', '6efbfcbfdbecf1e5a7d4020bbd64d0f39f879a59adec2f57e45cea1ca5c31e9f', '16140a9a90a2812932c74b28eb1d842200972a19a4b14f8cac097e5efbceb3f0ye', NULL, NULL, NULL, '2021-11-26 03:12:31', '2021-12-09 12:49:58', NULL),
(11, '11ser', 'Eleven', 'User', '1638256924', '8200148091', '1', '11user@mailinator.com', '2021-11-30 07:22:34', '$2y$10$HP4EhnREX2bojCJKnEOHtuq8zly8/1D7lfpZxfs6F9UaNwjNTbr9e', NULL, 'USR', '1637816125', 'QR_1638256924.png', NULL, '9efbfcbfdbecf1e5a7d4020bbd64d0f39f879a59adec2f57e45cea1ca5c31e9f', NULL, NULL, NULL, NULL, '2021-11-30 07:22:04', '2021-11-30 07:22:34', NULL),
(12, '12nu', 'twelve', 'User', '1638257249', '8200148091', '1', '12number@mailinator.com', '2021-11-30 12:56:49', '$2y$10$7AfSdKfIbjccAB.GTdCMRO2Fo9ZHSLHVLJ5Is8NPDOus2loQrLYZu', NULL, 'USR', '1637816125', 'QR_1638257249.png', NULL, '9efbfcbfdbecf1e5a7d4020bbd64d0f39f879a59adec2f57e45cea1ca5c31e9f', NULL, NULL, NULL, NULL, '2021-11-30 07:27:29', '2021-11-30 12:56:49', NULL),
(13, '12numb', 'twelve', 'User', '1638259147', '8200148091', '1', '12number1@mailinator.com', NULL, '$2y$10$W.7bxzZReJ5mhO7e61GFpeqyHHeuXjiFNa/iQjrz5Uvg3HS3NGw3.', NULL, 'USR', '1637816125', 'QR_1638259147.png', NULL, '9efbfcbfdbecf1e5a7d4020bbd64d0f39f879a59adec2f57e45cea1ca5c31e9f', NULL, NULL, NULL, NULL, '2021-11-30 07:59:07', '2021-11-30 07:59:07', NULL),
(14, '12n', 'twelve', 'User', '1638262317', '8200148091', '1', '12number12@mailinator.com', NULL, '$2y$10$UA3RgvhbL1QTAki.9VnFz.g4qizw3e5alqWxhI6ZrG7UYtq8tqLxq', NULL, 'USR', '1637816125', 'QR_1638262317.png', NULL, '9efbfcbfdbecf1e5a7d4020bbd64d0f39f879a59adec2f57e45cea1ca5c31e9f', NULL, NULL, NULL, NULL, '2021-11-30 08:51:57', '2021-11-30 08:51:57', NULL),
(15, 'chandnipatel', 'Chandni', 'Patel', '1638263944', '1234567890', '1', 'chandni@mailinator.com', '2021-11-30 09:19:33', '$2y$10$63G9SXwTBYf2GJmVGuPm5O8ElOmw77oJ2xPjdrzl2ZhG.NiPA7o/u', NULL, 'USR', NULL, 'QR_1638263944.png', '1638266299.png', '9efbfcbfdbecf1e5a7d4020bbd64d0f39f879a59adec2f57e45cea1ca5c31e9f', NULL, NULL, NULL, NULL, '2021-11-30 09:19:04', '2021-11-30 09:58:19', NULL),
(16, 'twelve User', 'twelve', 'User', '1638266294', '8200148091', '1', '12number112@mailinator.com', NULL, '$2y$10$wyiXuPl.vuhBeVuxuor0SelMKwDiBNSYrMjJzGNcqgx7HUWm7yJCe', NULL, 'USR', '1637816125', 'QR_1638266294.png', NULL, '9efbfcbfdbecf1e5a7d4020bbd64d0f39f879a59adec2f57e45cea1ca5c31e9f', NULL, NULL, NULL, NULL, '2021-11-30 09:58:14', '2021-11-30 09:58:14', NULL),
(17, 'twelve', 'twelve', 'User', '1638266651', '8200148091', '1', '12number1112@mailinator.com', '2021-12-01 08:42:47', '$2y$10$LTUrJwMaEd/x1gt19wFIS.LXe4sQonzIGgxKWN6uxftTGM3oHKCL6', NULL, 'USR', '1637816125', 'QR_1638266651.png', '1638266299.png', '9efbfcbfdbecf1e5a7d4020bbd64d0f39f879a59adec2f57e45cea1ca5c31e9f', NULL, NULL, NULL, NULL, '2021-11-30 10:04:11', '2021-12-01 08:42:47', NULL),
(20, 'vancouvchurch', NULL, NULL, '1638268280', NULL, NULL, 'vancouverchurch@mailinator.com', '2021-11-30 10:31:20', '$2a$10$7eH8a2KWW.9ITZ/HP65NGur6xhMuN/zzcDZDnYidAt4kpcNp4bbsW', NULL, 'CHR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-30 10:31:20', '2021-11-30 10:31:20', NULL),
(21, 'vancouverchurc', NULL, NULL, '1638269715', NULL, NULL, 'vancouverchurch@gmail.com', '2021-11-30 10:55:15', '$2a$10$7eH8a2KWW.9ITZ/HP65NGur6xhMuN/zzcDZDnYidAt4kpcNp4bbsW', NULL, 'CHR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-30 10:55:15', '2021-11-30 10:55:15', NULL),
(23, 'test', NULL, NULL, '1638269977', NULL, NULL, 'test@gmail.com', '2021-11-30 10:59:37', '$2a$10$7eH8a2KWW.9ITZ/HP65NGur6xhMuN/zzcDZDnYidAt4kpcNp4bbsW', NULL, 'CHR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-11-30 10:59:37', '2021-11-30 10:59:37', NULL),
(24, 'michel', 'michel', 'User', '1638279820', '9876543211', '1', 'michelUser@mailinator.com', '2021-12-09 10:10:09', '$2y$10$vqEvdPS5vpKUAErUal8Zb./M9kg7MHJxj8YOFoXLkE2ZXP2NRLiAO', NULL, 'USR', NULL, 'QR_1638279820.png', '1638266299.png', '6efbfcbfdbecf1e5a7d4020bbd64d0f39f879a59adec2f57e45cea1ca5c31e9f', NULL, NULL, NULL, NULL, '2021-11-30 13:43:40', '2021-12-09 10:10:09', NULL),
(25, 'michelUser', 'michel', 'User', '1638359149', '9876543211', '1', 'testMan@mailinator1.com', '2021-12-01 11:57:31', '$2y$10$OpBOCJp4eh/dmkx5voSVtu.6xOtesgJV0kWqTKEI54VA9l38Flga6', NULL, 'USR', NULL, 'QR_1638359149.png', NULL, '9efbfcbfdbecf1e5a7d4020bbd64d0f39f879a59adec2f57e45cea1ca5c31e9f', NULL, NULL, NULL, NULL, '2021-12-01 11:45:49', '2021-12-01 11:57:31', NULL),
(26, 'michelUse', 'Twelve', 'number', '1638442698', '88888888888', '1', 'testMan@mailinator.com', '2022-01-03 05:16:14', '$2y$10$dGIM2QQI5ZzRfw/r2lkxse8fZkeES2HKru/7gK/y5YJMwEs5VKRWq', NULL, 'USR', NULL, 'QR_1638442698.png', NULL, 'cLJTkgGBxUl2iKy1T683qR:APA91bHd3TUEGWBQpc_FjFBEiJnvch0xgCaI6NUF9fP9gsymMsNYWOvlRzsHNtkCX68fBJiy28YcUzav37bBdidWXalF-AXQdt5FnuLT_aSi9RpBsC0uEMT32EnlchQmw4jHC5kRqxmI', '1c6414148519ace652d4616d7071d393db1c72ff772bd0e531cbbf47edf87271', 'zh-CN', NULL, NULL, '2021-12-02 10:58:18', '2022-01-19 06:26:58', NULL),
(27, 'michelU250g', 'michel', 'User', '1638443779', '9876543211', '1', 'testMan@mailinator.com2', '2021-12-02 11:19:57', '$2y$10$Wzt8kTONemuCwd3BHj4z4.Es.bgnUMUz9wKzofUYM8vix9jS1cPpe', NULL, 'USR', NULL, 'QR_1638443779.png', NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-02 11:16:19', '2021-12-02 11:19:57', NULL),
(28, 'name-123', 'Name123', 'User2', '1638445933', '9876543211', '1', 'testMan@mailinator2.com', '2021-12-02 11:52:41', '$2y$10$oDe6hRz9Lce3AxtSEjck/eJTuWFs5UQUx5zdbLO6T9PUXK9ocv4FO', NULL, 'USR', '1638443779', 'QR_1638445933.png', NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-02 11:52:13', '2021-12-02 11:52:41', NULL),
(29, 'name154', 'Name1231', 'User2', '1638507643', '9876543211', '1', 'testMan@mailinator3.com', '2021-12-03 11:34:20', '$2y$10$W8Wh34Wq7KIGnv5psgK6CuS7zR9ouhx9FJujrNUFfkIgAZzmwqMQS', NULL, 'USR', '1638443779', 'QR_1638507643.png', NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-03 05:00:43', '2021-12-03 11:34:20', NULL),
(30, 'userapi123', 'User', 'Ali', '1638771238', '1234567890', '3', 'userapi123@mailinator.com', NULL, '$2y$10$No3MQH.0Oq2.EQUGvFS62uLdqZJHQcXesyEs.Jq7MZtjv0j7M7HmW', NULL, 'USR', NULL, 'QR_1638771238.png', NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-06 06:13:58', '2021-12-06 06:13:58', NULL),
(31, 'userapi1234', 'User', 'Ali', '1638771324', '1234567890', '3', 'userapi1234@mailinator.com', NULL, '$2y$10$WS3DoMYDNAH7N2gi6H64.e5qVCqcNLdMqEn1ZMT0Zf37l9ULXg2KK', NULL, 'USR', NULL, 'QR_1638771324.png', NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-06 06:15:24', '2021-12-06 06:15:24', NULL),
(32, 'userapi12345', 'User', 'Ali', '1638772587', '1234567890', '3', 'userapi12345@mailinator.com', '2021-12-06 11:13:15', '$2y$10$jV1pyDorniyZeIjvUZXKKeJbyEEIhdLcsTMHJMMrp.rj7rdFTXdPG', NULL, 'USR', NULL, 'QR_1638772587.png', '1638785112.png', NULL, NULL, NULL, NULL, NULL, '2021-12-06 06:36:27', '2021-12-06 11:13:15', NULL),
(33, 'VancouverCahund', NULL, NULL, '1640158034', NULL, NULL, 'test12@gmail.com', '2021-12-22 07:27:14', '$2a$10$7eH8a2KWW.9ITZ/HP65NGur6xhMuN/zzcDZDnYidAt4kpcNp4bbsW', NULL, 'CHR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-22 07:27:14', '2021-12-22 07:27:14', NULL),
(34, 'test', NULL, NULL, '1640160110', NULL, NULL, 'tes@gmail.com', '2021-12-22 08:01:50', '$2a$10$7eH8a2KWW.9ITZ/HP65NGur6xhMuN/zzcDZDnYidAt4kpcNp4bbsW', NULL, 'CHR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-22 08:01:50', '2021-12-22 08:01:50', NULL),
(35, 'tes', NULL, NULL, '1640160209', NULL, NULL, 'tes0@gmail.com', '2021-12-22 08:03:29', '$2a$10$7eH8a2KWW.9ITZ/HP65NGur6xhMuN/zzcDZDnYidAt4kpcNp4bbsW', NULL, 'CHR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-22 08:03:29', '2021-12-22 08:03:29', NULL),
(36, 'test', NULL, NULL, '1640162354', NULL, NULL, 'tst@gmail.com', '2021-12-22 08:39:14', '$2a$10$7eH8a2KWW.9ITZ/HP65NGur6xhMuN/zzcDZDnYidAt4kpcNp4bbsW', NULL, 'CHR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-22 08:39:14', '2021-12-22 08:39:14', NULL),
(37, 'mailinator', NULL, NULL, '1640595693', NULL, NULL, 'tets@mailinator.com', '2021-12-27 09:01:33', '$2y$10$bpExwPyDxqFQgkGSZO9/gOP48UY162mZgVkl4LxWl4ddXfH6ZosbW', NULL, 'CHR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-27 09:01:33', '2021-12-27 09:01:33', NULL),
(38, 'nowtest', 'Name1231', 'User2', '1646290249', '9876543211', '1', 'testMans@mailinator.com', NULL, '$2y$10$qBQlJ0GnzWagoLjLUDSfrulmLnjvsoWrCdBKObe5P1ts8zf3qMChC', NULL, 'USR', NULL, 'QR_1646290249.png', NULL, NULL, NULL, NULL, NULL, NULL, '2022-03-03 06:50:49', '2022-03-03 06:50:49', NULL),
(39, 'testamn', 'Name1231', 'User2', '1646290312', '9876543211', '1', 'testMansss@mailinator.com', NULL, '$2y$10$Ei0m1aMhpOQ3e.uRhN1WgOUY4iPF2FRW2mI2UIcg26rKtilnMHGZi', NULL, 'USR', NULL, 'QR_1646290312.png', NULL, NULL, NULL, NULL, NULL, NULL, '2022-03-03 06:51:52', '2022-03-03 06:51:52', NULL),
(40, 'testamnss', 'Name1231S', 'User2', '1646290386', '9876543211', '1', 'testMans11ss@mailinator.com', NULL, '$2y$10$M1H73BWdmn5EP4PkWHxVIuEtKlkGHsvAjzUzTEuCxq1dXFo2RzRwO', NULL, 'USR', NULL, 'QR_1646290386.png', NULL, NULL, NULL, NULL, NULL, NULL, '2022-03-03 06:53:06', '2022-03-03 06:53:06', NULL),
(41, 'testamnssss', 'Name1231S', 'User2', '1646290428', '9876543211', '1', 'testMans11sss@mailinator.com', '2022-03-03 06:54:37', '$2y$10$4tlicUZ1ZJdIciym93kzSuYDTrlSqrvaCRtLc92a/46CbYFwJA90G', NULL, 'USR', NULL, 'QR_1646290428.png', NULL, 'cLJTkgGBxUl2iKy1T683qR:APA91bHd3TUEGWBQpc_FjFBEiJnvch0xgCaI6NUF9fP9gsymMsNYWOvlRzsHNtkCX68fBJiy28YcUzav37bBdidWXalF-AXQdt5FnuLT_aSi9RpBsC0uEMT32EnlchQmw4jHC5kRqxmI', '1c6414148519ace652d4616d7071d393db1c72ff772bd0e531cbbf47edf87271', NULL, 'http://localhost/phpmyadmin/index.php?route=/sql&db=bible_app&table=users&pos=0', NULL, '2022-03-03 06:53:48', '2022-03-03 06:54:37', NULL),
(42, 'testdemo', 'Last', 'User2', '1646308897', '9876543211', '0', 'testMan2@mailinator.com', '2022-03-03 12:07:06', '$2y$10$ZR6LWOH.NdSMr8pxysPwiOGagcsNleTk0E/..3BYDMBUH0IEizSzK', NULL, 'USR', NULL, 'QR_1646308897.png', NULL, 'cLJTkgGBxUl2iKy1T683qR:APA91bHd3TUEGWBQpc_FjFBEiJnvch0xgCaI6NUF9fP9gsymMsNYWOvlRzsHNtkCX68fBJiy28YcUzav37bBdidWXalF-AXQdt5FnuLT_aSi9RpBsC0uEMT32EnlchQmw4jHC5kRqxmI', '1c6414148519ace652d4616d7071d393db1c72ff772bd0e531cbbf47edf87271', NULL, NULL, 'Demo Church', '2022-03-03 12:01:37', '2022-03-03 12:07:06', NULL),
(43, 'testdemo2115', 'Twelve', 'number', '1646309560', '88888888888', '1', 'testMan365@mailinator.com', '2022-03-03 12:47:44', '$2y$10$AQJvc3e3Ljb/.8Swq/Be.e//aqw8ePY06mEcOr.kXOoVMie5hDHPS', NULL, 'USR', NULL, 'QR_1646309560.png', NULL, 'cLJTkgGBxUl2iKy1T683qR:APA91bHd3TUEGWBQpc_FjFBEiJnvch0xgCaI6NUF9fP9gsymMsNYWOvlRzsHNtkCX68fBJiy28YcUzav37bBdidWXalF-AXQdt5FnuLT_aSi9RpBsC0uEMT32EnlchQmw4jHC5kRqxmI', '1c6414148519ace652d4616d7071d393db1c72ff772bd0e531cbbf47edf87271', NULL, NULL, 'Demo Church2', '2022-03-03 12:12:40', '2022-03-03 12:59:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `work_us`
--

CREATE TABLE `work_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: InActive, 1: Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_us`
--

INSERT INTO `work_us` (`id`, `user_id`, `first_name`, `last_name`, `email`, `mobile_number`, `description`, `is_read`, `created_at`, `updated_at`) VALUES
(5, 26, 'Twelve', 'number', 'test@gmail.com', '88888888888', 'work su', 0, '2022-02-21 13:59:52', '2022-02-21 13:59:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `black_lists`
--
ALTER TABLE `black_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calendars`
--
ALTER TABLE `calendars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `churches`
--
ALTER TABLE `churches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `churches_email_unique` (`email`),
  ADD UNIQUE KEY `churches_uniqid_unique` (`uniqid`);

--
-- Indexes for table `church_banners`
--
ALTER TABLE `church_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diaries`
--
ALTER TABLE `diaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favourite_types`
--
ALTER TABLE `favourite_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_chats`
--
ALTER TABLE `group_chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_media`
--
ALTER TABLE `post_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `push_subscriptions_endpoint_unique` (`endpoint`),
  ADD KEY `push_subscriptions_subscribable_type_subscribable_id_index` (`subscribable_type`,`subscribable_id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_uniqid_unique` (`uniqid`);

--
-- Indexes for table `work_us`
--
ALTER TABLE `work_us`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `black_lists`
--
ALTER TABLE `black_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `calendars`
--
ALTER TABLE `calendars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `churches`
--
ALTER TABLE `churches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `church_banners`
--
ALTER TABLE `church_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `diaries`
--
ALTER TABLE `diaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `favourite_types`
--
ALTER TABLE `favourite_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `group_chats`
--
ALTER TABLE `group_chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `post_media`
--
ALTER TABLE `post_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `work_us`
--
ALTER TABLE `work_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
