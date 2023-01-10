-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 31, 2021 at 12:52 PM
-- Server version: 10.5.13-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hostapps_bibleappbackend`
--

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
(1, 2, 'Super Church', 'Whether you\'re new to church, have been a Christian for many years.', '2021-12-02 11:41:46', '2021-12-08 06:54:33', '2021-12-08 06:54:33', NULL),
(2, 2, 'Super Church', 'Whether you\'re new to church, have been a Christian for many years.', '2021-12-02 11:41:46', '2021-12-08 06:56:00', '2021-12-08 06:56:00', NULL);

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
(1, 'vancouverchurch@mailinator.com', '$2y$10$ilmgVudVrL1vtA5kwAAJueZY3YpRZuvOxfSb2FJs1ta1YZM8TNZm2', '3', '1638770235', 'Vancouver Church', 'Vancouver', '9876543210', 'vancouverchurch.com', '1638770235.png', 3.9111328125000004, 47.42808726171425, NULL, '2021-12-06 05:57:15', '2021-12-22 06:22:15', NULL),
(2, 'californiachurch@mailinator.com', '$2y$10$7YTw5Mq14Iu.SolIjuyiFuIHbf/OChKO35oWzVE.lu8YwtWv83Oou', '11', '1638886861', 'California', 'nothing', '7788445511', 'california.com', '1638886861.jpg', -84.302964, 21.1864607, NULL, '2021-12-07 14:21:01', '2021-12-22 05:31:26', NULL),
(3, 'eastmidlands@mailinator.com', '$2y$10$j2Wext0evGIyZet1WSykIu.xcpfOTiKegbuaCkqpG4vpSNnv5p5yW', '13', '1638938899', 'East Midlands Church', 'America', '9876543210', 'eastmidlands.com', '1638938899.png', 3.9111328125000004, 3.911132812566, NULL, '2021-12-08 04:48:23', '2021-12-22 08:08:29', NULL);

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
(5, '1640410130.png', 1, 3, 1, '2021-12-22 08:14:54', '2021-12-24 23:59:07', NULL),
(7, '1640410141.png', 1, 1, 1, '2021-12-22 08:15:13', '2021-12-24 23:59:31', NULL),
(8, '1640180738.png', 1, 2, 1, '2021-12-22 08:15:38', '2021-12-23 01:22:06', NULL),
(10, '1640410108.png', 1, NULL, 1, '2021-12-23 00:29:55', '2021-12-24 23:58:28', NULL),
(11, '1640239322.png', 1, NULL, 1, '2021-12-23 00:32:02', '2021-12-23 00:32:02', NULL),
(12, '1640239330.png', 1, NULL, 1, '2021-12-23 00:32:10', '2021-12-23 00:32:10', NULL),
(13, '1640243908.png', 1, NULL, 1, '2021-12-23 01:48:29', '2021-12-23 01:48:29', NULL),
(14, '1640243910.png', 1, 7, 1, '2021-12-23 01:48:31', '2021-12-23 01:48:50', NULL),
(15, '1640410043.png', 3, 3, 1, '2021-12-23 01:49:32', '2021-12-24 23:57:23', NULL),
(16, '1640244010.png', 2, 2, 1, '2021-12-23 01:50:10', '2021-12-23 01:50:16', NULL),
(17, '1640244023.png', 2, 6, 1, '2021-12-23 01:50:23', '2021-12-23 01:50:29', NULL);

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
(1, 2, 'Diaty Good', 'diary description', '', '2021-12-06 10:13:19', '2021-12-06 10:13:19', NULL),
(2, 7, 'won the tournament', 'it was a good day.', '1638803842.jpg', '2021-12-06 15:17:24', '2021-12-06 15:17:24', NULL),
(3, 5, 'Test', 'test', '1638848720.jpg', '2021-12-07 03:45:20', '2021-12-07 03:45:20', NULL),
(4, 5, NULL, NULL, '', '2021-12-08 22:48:50', '2021-12-08 22:50:57', '2021-12-08 22:50:57'),
(5, 6, 'post', 'Description', '', '2021-12-28 01:31:25', '2021-12-28 05:39:36', '2021-12-28 05:39:36'),
(6, 6, 'test', 'Diary description', '', '2021-12-28 05:40:43', '2021-12-28 05:40:43', NULL);

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
(1, 3, 'Today Event', '2021-12-06 13:28:00', 'yes', '2021-12-06 07:58:40', '2021-12-06 07:58:40', NULL),
(2, 3, 'Festival Monday', '2021-12-13 10:11:00', '“Can there be peace?” Explore the answer to this question during the second week of our 2021 Advent series. Advent means...', '2021-12-08 04:43:00', '2021-12-08 04:43:00', NULL),
(3, 3, 'Redesign Church', '2021-12-15 10:25:00', '“Is there hope?” Explore the answer to this question during the first week of our 2021 Advent series. Advent means...', '2021-12-08 04:43:38', '2021-12-08 04:43:38', NULL),
(4, 3, 'Marriege Event', '2021-12-13 12:13:00', 'I had been looking for a church home for over a year and we are so happy that we found Voice Church. We stand behind Voice Church\'s values, principles and spiritual formations and we couldn\'t be more excited. The culture being formed, the community that is being established and the people in the team is what has become contagiou', '2021-12-08 04:44:40', '2021-12-08 04:44:40', NULL),
(5, 11, 'Festival Event', '2021-12-13 13:15:00', 'A truly remarkable community!  Our family loves Voice Church.  It is diverse, dynamic, responsive to needs in the city of Tustin as well as missional needs around the world, all while being biblically based and focused on speaking God\'s love and hope to all. In other words, it\'s a little church that packs a big punch!!!!!', '2021-12-08 04:45:16', '2021-12-08 04:45:16', NULL),
(6, 11, 'Redesign  Event California', '2021-12-10 10:15:00', 'Christ Church is a daughter church of St. James\' Anglican Church. The first service was held, without a church building, on December 23, 1888, at 720 Granville Street. On February 14, 1889, a building committee was formed to collect the necessary funds for the erection of the church. It would be located on land bought from the Canadian Pacific Railway (CPR); Henry John Cambie, chief engineer of CPR\'s Pacific Division and people\'s warden of the new church, was a key negotiator in acquiring the property.', '2021-12-08 04:46:07', '2021-12-08 04:46:07', NULL),
(7, 13, 'Redesign Church', '2021-12-16 13:18:00', 'By October 1889, Christ Church\'s basement was built and on October 6, the opening service was held for 52 parishioners. The joy of a new church did not last forever. By 1891 the CPR objected to the unfinished building that had quickly been nicknamed the root house. It was viewed an \"eyesore\" and the parishioners feared they would lose their location due to lack of funds to complete the building. The architect Robert Mackay Fripp submitted a proposal for completion of the church, 1892.', '2021-12-08 04:48:59', '2021-12-08 04:48:59', NULL),
(8, 3, 'Test', '2021-12-08 14:52:00', 'Test', '2021-12-08 09:22:46', '2021-12-08 09:26:06', '2021-12-08 09:26:06');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`id`, `user_id`, `favourite_type`, `select_id`, `created_at`, `updated_at`) VALUES
(32, 5, 'calendar_events', 1, '2021-12-28 05:36:57', '2021-12-28 05:36:57'),
(33, 5, 'songs', 1, '2021-12-28 05:37:18', '2021-12-28 05:37:18'),
(35, 6, 'diary_posts', 5, '2021-12-28 05:39:04', '2021-12-28 05:39:04'),
(63, 5, 'posts', 25, '2021-12-30 01:26:45', '2021-12-30 01:26:45'),
(64, 5, 'posts', 2, '2021-12-30 01:27:08', '2021-12-30 01:27:08'),
(82, 5, 'bible_verses', 121, '2021-12-31 01:20:28', '2021-12-31 01:20:28');

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
(1, 6, 5, '2021-12-07 06:35:28', '2021-12-07 06:35:28', NULL),
(2, 5, 6, '2021-12-07 06:35:28', '2021-12-07 06:35:28', NULL),
(3, 5, 8, '2021-12-07 09:17:11', '2021-12-07 09:17:11', NULL),
(4, 8, 5, '2021-12-07 09:17:11', '2021-12-07 09:17:11', NULL),
(5, 8, 6, '2021-12-07 09:38:16', '2021-12-07 09:38:16', NULL),
(6, 6, 8, '2021-12-07 09:38:16', '2021-12-07 09:38:16', NULL),
(7, 6, 9, '2021-12-07 09:42:11', '2021-12-07 09:42:11', NULL),
(8, 9, 6, '2021-12-07 09:42:11', '2021-12-07 09:42:11', NULL),
(9, 5, 10, '2021-12-07 11:53:35', '2021-12-07 11:53:35', NULL),
(10, 10, 5, '2021-12-07 11:53:35', '2021-12-07 11:53:35', NULL),
(11, 4, 5, '2021-12-07 12:10:46', '2021-12-07 12:10:46', NULL),
(12, 5, 4, '2021-12-07 12:10:46', '2021-12-07 12:10:46', NULL),
(13, 5, 15, '2021-12-12 23:33:34', '2021-12-12 23:33:34', NULL),
(14, 15, 5, '2021-12-12 23:33:34', '2021-12-12 23:33:34', NULL),
(15, 8, 15, '2021-12-15 03:22:35', '2021-12-15 03:22:35', NULL),
(16, 15, 8, '2021-12-15 03:22:35', '2021-12-15 03:22:35', NULL),
(17, 6, 4, '2021-12-16 23:38:20', '2021-12-16 23:38:20', NULL),
(18, 4, 6, '2021-12-16 23:38:20', '2021-12-16 23:38:20', NULL);

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
(1, 2, 5, '2021-12-07 06:22:02', '2021-12-07 06:22:02', NULL),
(2, 5, 6, '2021-12-07 06:31:16', '2021-12-07 06:35:28', '2021-12-07 06:35:28'),
(3, 5, 7, '2021-12-07 06:49:15', '2021-12-07 06:49:15', NULL),
(4, 8, 5, '2021-12-07 08:27:59', '2021-12-07 09:17:11', '2021-12-07 09:17:11'),
(5, 6, 8, '2021-12-07 09:36:43', '2021-12-07 09:37:23', '2021-12-07 09:37:23'),
(6, 6, 8, '2021-12-07 09:37:37', '2021-12-07 09:38:16', '2021-12-07 09:38:16'),
(7, 9, 6, '2021-12-07 09:41:52', '2021-12-07 09:42:11', '2021-12-07 09:42:11'),
(8, 4, 6, '2021-12-07 10:23:01', '2021-12-07 10:23:26', '2021-12-07 10:23:26'),
(9, 10, 5, '2021-12-07 11:49:38', '2021-12-07 11:53:35', '2021-12-07 11:53:35'),
(10, 5, 4, '2021-12-07 12:09:29', '2021-12-07 12:10:46', '2021-12-07 12:10:46'),
(11, 12, 7, '2021-12-09 22:44:57', '2021-12-09 22:44:57', NULL),
(12, 6, 12, '2021-12-10 00:37:07', '2021-12-10 00:37:07', NULL),
(13, 15, 4, '2021-12-12 23:29:41', '2021-12-12 23:29:41', NULL),
(14, 15, 5, '2021-12-12 23:29:52', '2021-12-12 23:33:34', '2021-12-12 23:33:34'),
(15, 15, 8, '2021-12-15 03:20:44', '2021-12-15 03:22:35', '2021-12-15 03:22:35'),
(16, 4, 6, '2021-12-16 23:37:27', '2021-12-16 23:38:20', '2021-12-16 23:38:20'),
(17, 6, 15, '2021-12-17 03:58:35', '2021-12-17 03:58:35', NULL);

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
(3, 2, 1638970222, '\"[\\\"4\\\", \\\"8\\\", \\\"9\\\", \\\"10\\\", \\\"11\\\"]\"', '1638970222.png', 'Technomads Office', '2021-12-08 08:00:22', '2021-12-08 08:00:22'),
(7, 5, 1639024838, '\"[\\\"5\\\",\\\"2\\\",\\\"6\\\",\\\"8\\\",\\\"9\\\"]\"', NULL, 'Technomads Office', '2021-12-08 23:10:38', '2021-12-09 06:49:01'),
(9, 5, 1639025651, '\"[\\\"6\\\",\\\"8\\\",\\\"10\\\",\\\"9\\\"]\"', '1639025651.jpg', 'Group 3', '2021-12-08 23:24:11', '2021-12-08 23:24:11'),
(10, 4, 1639035064, '\"[\\\"4\\\", \\\"8\\\", \\\"9\\\", \\\"10\\\", \\\"11\\\"]\"', '1639035064.png', 'Group 1', '2021-12-09 02:01:04', '2021-12-09 02:01:04'),
(11, 4, 1639035363, '\"[\\\"4\\\", \\\"8\\\", \\\"9\\\", \\\"10\\\", \\\"11\\\"]\"', NULL, 'Group 2', '2021-12-09 02:06:03', '2021-12-09 02:06:03'),
(12, 4, 1639035518, '\"[\\\"4\\\", \\\"8\\\", \\\"9\\\", \\\"10\\\", \\\"11\\\"]\"', NULL, 'Test', '2021-12-09 02:08:38', '2021-12-09 02:08:38'),
(13, 5, 1639047957, '\"[\\\"5\\\",\\\"4\\\"]\"', '1639047956.png', 'Google', '2021-12-09 05:35:57', '2021-12-09 05:35:57'),
(14, 5, 1639049383, '\"[\\\"5\\\",\\\"4\\\"]\"', '1639049383.png', 'Google', '2021-12-09 05:59:43', '2021-12-09 05:59:43'),
(15, 5, 1639052177, '\"[\\\"5\\\",\\\"4\\\",\\\"8\\\",\\\"9\\\"]\"', '1639052177.png', 'Google', '2021-12-09 06:46:17', '2021-12-09 06:46:17'),
(18, 5, 1639563812, '\"[\\\"5\\\",\\\"4\\\",\\\"6\\\",\\\"8\\\",\\\"9\\\"]\"', '1639563812.jpg', 'Test', '2021-12-15 04:53:32', '2021-12-15 04:53:32'),
(22, 5, 1639565941, '\"[\\\"5\\\",\\\"4\\\",\\\"8\\\",\\\"9\\\"]\"', NULL, 'Google', '2021-12-15 05:29:01', '2021-12-15 05:29:01'),
(23, 5, 1639566011, '\"[\\\"5\\\",\\\"4\\\",\\\"8\\\",\\\"9\\\"]\"', NULL, 'Google', '2021-12-15 05:30:11', '2021-12-15 05:30:11'),
(26, 5, 1639567110, '\"[\\\"5\\\",\\\"4\\\",\\\"8\\\",\\\"9\\\"]\"', NULL, 'Google', '2021-12-15 05:48:30', '2021-12-15 05:48:30'),
(27, 15, 1639567260, '\"[\\\"15\\\",\\\"5\\\",\\\"6\\\",\\\"8\\\"]\"', NULL, 'Dfgfh', '2021-12-15 05:51:00', '2021-12-15 05:51:00'),
(28, 6, 1639735819, '\"[]\"', NULL, 'New group', '2021-12-17 04:40:19', '2021-12-17 04:40:19');

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
(1, 5, 5, '2021-12-07 05:20:54', '2021-12-07 05:38:13', '2021-12-07 05:38:13'),
(2, 5, 5, '2021-12-07 05:38:17', '2021-12-30 00:58:33', '2021-12-30 00:58:33'),
(3, 5, 4, '2021-12-07 05:47:08', '2021-12-07 05:47:08', NULL),
(4, 5, 2, '2021-12-07 12:41:04', '2021-12-30 02:38:01', '2021-12-30 02:38:01'),
(5, 5, 1, '2021-12-07 12:41:08', '2021-12-07 12:41:08', NULL),
(6, 6, 1, '2021-12-09 01:18:36', '2021-12-09 01:22:09', '2021-12-09 01:22:09'),
(7, 6, 1, '2021-12-09 01:22:11', '2021-12-09 01:27:04', '2021-12-09 01:27:04'),
(8, 6, 1, '2021-12-09 01:27:06', '2021-12-09 01:31:37', '2021-12-09 01:31:37'),
(9, 6, 1, '2021-12-09 01:31:38', '2021-12-09 01:42:25', '2021-12-09 01:42:25'),
(10, 6, 1, '2021-12-09 01:42:28', '2021-12-30 02:44:28', '2021-12-30 02:44:28'),
(11, 9, 2, '2021-12-09 04:13:26', '2021-12-09 04:14:17', '2021-12-09 04:14:17'),
(12, 9, 2, '2021-12-09 04:14:23', '2021-12-09 04:14:23', NULL),
(13, 6, 7, '2021-12-10 00:37:01', '2021-12-10 00:37:01', NULL),
(14, 4, 5, '2021-12-10 00:53:19', '2021-12-10 01:13:22', '2021-12-10 01:13:22'),
(15, 4, 5, '2021-12-10 01:13:25', '2021-12-10 01:28:53', '2021-12-10 01:28:53'),
(16, 4, 5, '2021-12-10 01:28:54', '2021-12-10 01:29:11', '2021-12-10 01:29:11'),
(17, 4, 5, '2021-12-10 01:29:11', '2021-12-10 01:42:19', '2021-12-10 01:42:19'),
(18, 4, 5, '2021-12-10 01:42:19', '2021-12-10 01:45:27', '2021-12-10 01:45:27'),
(19, 4, 5, '2021-12-10 01:45:27', '2021-12-10 01:47:44', '2021-12-10 01:47:44'),
(20, 4, 5, '2021-12-10 01:47:44', '2021-12-10 01:58:41', '2021-12-10 01:58:41'),
(21, 4, 5, '2021-12-10 01:58:41', '2021-12-11 00:52:00', '2021-12-11 00:52:00'),
(22, 4, 5, '2021-12-11 00:52:01', '2021-12-11 00:52:15', '2021-12-11 00:52:15'),
(23, 4, 5, '2021-12-11 00:52:16', '2021-12-11 00:52:32', '2021-12-11 00:52:32'),
(24, 4, 5, '2021-12-11 00:52:33', '2021-12-11 00:52:59', '2021-12-11 00:52:59'),
(25, 4, 5, '2021-12-11 00:52:59', '2021-12-11 00:57:11', '2021-12-11 00:57:11'),
(26, 4, 5, '2021-12-11 00:57:11', '2021-12-11 00:58:30', '2021-12-11 00:58:30'),
(27, 4, 5, '2021-12-11 00:58:30', '2021-12-11 00:59:34', '2021-12-11 00:59:34'),
(28, 4, 5, '2021-12-11 00:59:34', '2021-12-11 01:00:08', '2021-12-11 01:00:08'),
(29, 4, 5, '2021-12-11 01:00:09', '2021-12-11 01:01:19', '2021-12-11 01:01:19'),
(30, 4, 5, '2021-12-11 01:01:20', '2021-12-11 01:04:42', '2021-12-11 01:04:42'),
(31, 4, 5, '2021-12-11 01:04:43', '2021-12-11 01:09:07', '2021-12-11 01:09:07'),
(32, 4, 5, '2021-12-11 01:09:07', '2021-12-11 01:09:42', '2021-12-11 01:09:42'),
(33, 4, 5, '2021-12-11 01:09:42', '2021-12-11 05:43:59', '2021-12-11 05:43:59'),
(34, 4, 5, '2021-12-11 05:44:00', '2021-12-11 05:45:52', '2021-12-11 05:45:52'),
(35, 4, 5, '2021-12-11 05:45:52', '2021-12-16 23:24:49', '2021-12-16 23:24:49'),
(36, 15, 8, '2021-12-16 06:55:52', '2021-12-16 06:55:53', '2021-12-16 06:55:53'),
(37, 8, 5, '2021-12-16 23:23:58', '2021-12-30 00:30:14', '2021-12-30 00:30:14'),
(38, 4, 5, '2021-12-16 23:24:50', '2021-12-16 23:26:31', '2021-12-16 23:26:31'),
(39, 4, 5, '2021-12-16 23:26:32', '2021-12-16 23:33:16', '2021-12-16 23:33:16'),
(40, 4, 5, '2021-12-16 23:33:16', '2021-12-16 23:33:16', NULL),
(41, 6, 5, '2021-12-21 23:14:06', '2021-12-21 23:14:06', NULL),
(42, 8, 5, '2021-12-30 00:30:19', '2021-12-30 00:30:19', NULL),
(43, 6, 2, '2021-12-30 00:58:15', '2021-12-30 00:58:15', NULL),
(44, 5, 5, '2021-12-30 00:58:37', '2021-12-30 03:18:20', '2021-12-30 03:18:20'),
(45, 5, 2, '2021-12-30 02:37:21', '2021-12-30 02:38:01', '2021-12-30 02:38:01'),
(46, 5, 2, '2021-12-30 02:38:14', '2021-12-30 03:06:48', '2021-12-30 03:06:48'),
(47, 6, 1, '2021-12-30 02:44:29', '2021-12-30 02:44:29', NULL),
(48, 5, 2, '2021-12-30 03:06:35', '2021-12-30 03:06:48', '2021-12-30 03:06:48'),
(49, 5, 2, '2021-12-30 03:06:55', '2021-12-30 03:16:09', '2021-12-30 03:16:09'),
(50, 5, 2, '2021-12-30 03:16:02', '2021-12-30 03:16:09', '2021-12-30 03:16:09'),
(51, 5, 2, '2021-12-30 03:16:23', '2021-12-30 03:16:23', NULL),
(52, 6, 4, '2021-12-30 03:17:54', '2021-12-30 03:17:54', NULL),
(53, 5, 5, '2021-12-30 03:18:23', '2021-12-30 03:18:23', NULL);

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
(19, '2021_11_01_115008_create_post_comments_table', 1),
(20, '2021_11_12_041902_create_diaries_table', 1),
(21, '2021_11_12_111118_create_calendars_table', 1),
(22, '2021_11_17_040218_create_likes_table', 1),
(23, '2021_11_17_080307_create_friend_requests_table', 1),
(24, '2021_11_17_105150_create_friends_table', 1),
(25, '2021_11_25_044645_add_qr_code_to_users', 1),
(26, '2021_11_25_085031_add_pic_to_users', 1),
(27, '2021_11_26_100402_add_column_device_token_to_users', 1),
(28, '2021_11_26_133340_create_notifications_table', 1),
(29, '2021_11_30_164457_alter_table_churches_change_password', 1),
(30, '2021_12_02_122626_edit_schedule_and_remove_date_to_calendars_table', 1),
(31, '2021_12_02_123426_edit_title_to_events_table', 1);

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
('009c5952-b58d-48c9-a2b3-d57ad47ca604', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:14:30', '2021-12-03 13:11:17', '2021-12-03 13:14:30'),
('02952587-2f1c-4778-a7e2-f6b710e11f4e', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-10 01:29:11', '2021-12-10 01:29:11'),
('030e3991-ad89-4f15-9581-931c08e9bc60', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":15,\"user_name\":\"chandni123\",\"type\":\"new\"}', '2021-12-17 09:14:05', '2021-12-15 05:19:53', '2021-12-17 09:14:05'),
('034bbdbf-bca9-48b3-ba42-1707e25816fe', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 12, '{\"user_id\":6,\"post_id\":7,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-10 00:37:01', '2021-12-10 00:37:01'),
('0363cb03-a61c-4bf9-894e-cd316f085646', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-09 01:15:54', '2021-12-17 09:13:57'),
('045292a6-2fb0-4184-b2ef-815a57f556a8', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', '2021-12-17 09:13:36', '2021-12-10 01:28:47', '2021-12-17 09:13:36'),
('046639ae-1856-48f8-bb8c-8679699e0c16', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-10 00:51:51', '2021-12-17 09:13:57'),
('04ce428a-a403-4238-b98e-d209e9380799', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 11:40:28', '2021-12-03 11:40:23', '2021-12-03 11:40:28'),
('04f37fca-5e4b-4bf1-9598-3e1e634c3062', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":15,\"member_id\":5,\"type\":\"audio\",\"message\":\"Request chat\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IAA\\/NKPu58vpQ74eVZBBh1kO+18CX6NAb4z6n0eXuZP+j0U6wwQAAAAAQAD38QAA2Si4YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\",\"channel_name\":\"1639372633z4Y2GVCiJfojqw8sk2LqOadyItym7x6eEhdgKgtr\"}', NULL, '2021-12-12 23:47:13', '2021-12-12 23:47:13'),
('08852792-79df-43fe-af33-10f6957df970', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:05:01', '2021-12-03 13:03:49', '2021-12-03 13:05:01'),
('08f6aa63-0c50-40e9-9d57-56727ecc1734', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":6,\"post_id\":1,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-09 01:42:28', '2021-12-09 01:42:28'),
('096feb5e-452a-42bf-a601-3acb8e14632e', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 4, '{\"user_id\":6,\"type\":\"accept\",\"message\":\"Request accepted\"}', NULL, '2021-12-16 23:38:20', '2021-12-16 23:38:20'),
('09a7b1ea-b6e7-4832-99b8-ffb287289f5d', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-16 23:33:16', '2021-12-16 23:33:16'),
('0a5919ff-ee41-469b-b7e3-4cf0c110363f', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-16 23:26:32', '2021-12-16 23:26:32'),
('0a6e1850-24b5-4739-87ac-6ee0ad091de4', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-10 01:45:27', '2021-12-10 01:45:27'),
('0c7df9e9-d21f-4215-bf37-2a6504ea510d', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":5,\"post_id\":2,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-30 02:38:14', '2021-12-30 02:38:14'),
('0ce4184a-b846-4108-b4bd-c4f828bb68be', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"12numbrs\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-17 00:50:22', '2021-12-17 09:14:02'),
('0dc65fa0-6e11-4988-aa41-9f62be717e8b', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":8,\"member_id\":5,\"type\":\"voice\",\"message\":\"Request chat\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IACL6OP6OzT61sXImkS4dHNNPrQ4GoGvtFlmN1+T73+v5aMoHrgAAAAAQAAHYgAAVC24YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\",\"channel_name\":\"1639373780IfdbhImKX9ZG1h2NiuPLeC5qvKeqqJev93b26xqe\"}', NULL, '2021-12-13 00:06:20', '2021-12-13 00:06:20'),
('0e730a3b-c0cc-444c-bcd8-345068737750', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"12numbrs\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-08 23:52:32', '2021-12-17 09:14:02'),
('0f21dbdf-5337-4718-b9db-c413ca8abfb7', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"12numbrs\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-08 23:36:56', '2021-12-17 09:14:02'),
('0f7ff06e-bf33-4ffc-b311-52fe6b21ab20', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:03:18', '2021-12-03 13:02:10', '2021-12-03 13:03:18'),
('1026ff28-4b79-4d1c-a48a-73bb835ef546', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-21 05:23:10', '2021-12-19 23:17:17', '2021-12-21 05:23:10'),
('12776b0a-8f40-4c6f-91b3-b7461ca6f022', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 08:55:03', '2021-12-03 06:43:28', '2021-12-03 08:55:03'),
('13613ef4-e29d-4574-8842-b7d3eb7e05f7', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 5, '{\"user_id\":4,\"type\":\"request\",\"message\":\"Request received\"}', NULL, '2021-12-07 12:09:29', '2021-12-07 12:09:29'),
('16980023-e801-44aa-a172-ddb7b37c5d38', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-07 10:44:47', '2021-12-17 09:13:57'),
('169cd745-36c1-4bc0-91a2-cb7cb538e5e8', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-11 01:09:42', '2021-12-11 01:09:42'),
('172571e0-f1fa-49a5-a413-fed938d409e5', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-07 08:31:37', '2021-12-17 09:13:57'),
('1730bfa9-ca92-45f9-a8be-fbef1aa7355b', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":6,\"member_id\":5,\"type\":\"audio\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IADdZH5kW0T+0obqedtKwKmazCaAJ5R1Lx\\/E+uAEM3hzHyEKv50AAAAAQAC+VAEAzOW1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 06:36:36', '2021-12-11 06:36:36'),
('17a8ee62-0e20-47a2-bd66-e4af64ef3fd0', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":17,\"user_name\":\"texttoday\",\"type\":\"new\"}', '2021-12-17 09:12:59', '2021-12-17 09:08:55', '2021-12-17 09:12:59'),
('1841d29e-ff36-4218-9a74-b6f43979ab7f', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', NULL, '2021-12-30 00:55:43', '2021-12-30 00:55:43'),
('19ce5abc-2a89-4e6f-a632-0a8ca8116496', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', '2021-12-17 09:13:36', '2021-12-17 04:21:43', '2021-12-17 09:13:36'),
('19d4e9a0-5fad-496d-adaf-0f7e00cee336', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":6,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-21 23:14:06', '2021-12-21 23:14:06'),
('1a68ac94-b9f4-4f5b-b17f-5695a1a60a5c', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 08:55:03', '2021-12-03 06:43:33', '2021-12-03 08:55:03'),
('1af17fac-6939-4604-a4cd-d3837a16532d', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":8,\"member_id\":5,\"type\":\"voice\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IACCnh2T7oTUX2+Is9ob0MoTM82MJ+ay9Vxp1lJKkZ9E2Sus\\/oUAAAAAQACO+wAADOK1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 06:20:36', '2021-12-11 06:20:36'),
('1e296d13-60a4-49ed-96ed-1f7333f33b91', 'App\\Notifications\\CommentNotification', 'App\\Models\\User', 5, '{\"user_id\":12,\"post_id\":2,\"type\":\"comment\",\"message\":\"Commented on your post\"}', NULL, '2021-12-09 22:39:24', '2021-12-09 22:39:24'),
('1f035372-7ac8-4037-9df1-830e82c5085c', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 08:55:03', '2021-12-03 08:54:33', '2021-12-03 08:55:03'),
('1faafd2c-75ef-4a27-9c70-9551f1f95067', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":5,\"post_id\":2,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-30 03:06:55', '2021-12-30 03:06:55'),
('204713a0-e7ef-4fd3-a76e-7dcfc7f28643', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-06 11:25:21', '2021-12-06 06:19:39', '2021-12-06 11:25:21'),
('234f4e8e-9e90-4bab-9f57-0c4260cef5da', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":6,\"member_id\":5,\"type\":\"audio\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IAD+O9\\/Ol3kBCsL9TEVmn54QHv4ZbdI2j8G+pbCISvZvZu3B8oUAAAAAQABymQAA5OK1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 06:24:12', '2021-12-11 06:24:12'),
('23e62f71-ca51-4476-94bf-8a0efb89132e', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 8, '{\"user_id\":5,\"member_id\":8,\"type\":\"call\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IAAYSLKQSEo5FbNH+3f619WVtkqm06l0HdUd\\/xclhohk\\/UisEDuuK7GEQAAamQAAnNa1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 05:31:48', '2021-12-11 05:31:48'),
('24c3f13f-124a-4dc5-a312-b1bf3b9b65db', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":6,\"post_id\":1,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-30 02:44:29', '2021-12-30 02:44:29'),
('25ce5f4c-37d1-47ba-abf5-166e08809438', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 11:51:12', '2021-12-03 11:50:32', '2021-12-03 11:51:12'),
('25dcf6d7-182e-4236-9156-e39fbb8a84a4', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":6,\"post_id\":2,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-30 00:58:15', '2021-12-30 00:58:15'),
('2a031826-4c7a-427d-bdc9-d89618d91098', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":8,\"user_name\":\"sandip123\",\"type\":\"new\"}', '2021-12-17 09:14:19', '2021-12-09 23:46:48', '2021-12-17 09:14:19'),
('2a13b08f-d417-4968-a236-9548c4569389', 'App\\Notifications\\CommentNotification', 'App\\Models\\User', 6, '{\"user_id\":5,\"post_id\":5,\"type\":\"comment\",\"message\":\"Commented on your post\"}', NULL, '2021-12-10 00:54:05', '2021-12-10 00:54:05'),
('2a4755c9-159d-47fb-bf7c-bc3e3ab33134', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', '2021-12-17 09:13:36', '2021-12-12 22:34:36', '2021-12-17 09:13:36'),
('2b7cd77e-bf15-4239-b320-227b3a2f2f14', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":6,\"post_id\":4,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-30 03:17:54', '2021-12-30 03:17:54'),
('2bb962dc-e9ff-4378-a182-ab264749f963', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', NULL, '2021-12-22 06:08:13', '2021-12-22 06:08:13'),
('2c07290d-016d-4540-8760-7231fb18c91f', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 8, '{\"user_id\":5,\"member_id\":8,\"type\":\"call\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IACAnVLivRBby6TGwlaDmHJqTVg6W4y79fgbWUqzWDStLheL3OwAAAAAQADqKgEAHOG1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 06:16:36', '2021-12-11 06:16:36'),
('2cf9cda0-a102-43f7-a48f-2cf0fe7637d0', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 8, '{\"user_id\":5,\"member_id\":8,\"type\":\"voice\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IAAVW72fv8zAQpau7wpZR\\/E9GFuZ6g7iDCi\\/rEeWjjqFbdCiL9EAAAAAQADiOgEAmeG1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 06:18:41', '2021-12-11 06:18:41'),
('2d6aaba1-6bdf-4419-a231-3174ac929569', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":5,\"post_id\":2,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-30 03:06:35', '2021-12-30 03:06:35'),
('2de50466-117c-43a6-acfe-2f61634a08aa', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:14:30', '2021-12-03 13:09:21', '2021-12-03 13:14:30'),
('2f3c98aa-54dd-46bc-84ed-022afd309a44', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":15,\"user_name\":\"chandni123\",\"type\":\"new\"}', '2021-12-17 09:14:05', '2021-12-17 01:56:22', '2021-12-17 09:14:05'),
('2f8c6a9a-3250-414a-9a5e-c934be96ccbe', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":8,\"user_name\":\"sandip123\",\"type\":\"new\"}', '2021-12-21 05:23:05', '2021-12-20 00:18:22', '2021-12-21 05:23:05'),
('3027ea7b-39a1-4f72-b6fd-faf6d68d8ac8', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-03 13:16:26', '2021-12-17 09:14:02'),
('304be008-1ef4-438a-9551-a9e687ad0b42', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":15,\"user_name\":\"chandni123\",\"type\":\"new\"}', '2021-12-17 09:14:05', '2021-12-12 23:25:28', '2021-12-17 09:14:05'),
('305b4fa3-447a-4f82-81aa-ef828bca49b6', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 09:07:35', '2021-12-03 09:06:42', '2021-12-03 09:07:35'),
('30968bb5-a570-4cc6-86db-e63b99232971', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 7, '{\"user_id\":12,\"type\":\"received\",\"message\":\"Request received\"}', NULL, '2021-12-09 22:44:57', '2021-12-09 22:44:57'),
('30f4bf0e-5034-407e-a63f-fd0e7904f7f9', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', NULL, '2021-12-21 22:21:43', '2021-12-21 22:21:43'),
('315b50df-bfc3-4d12-bfcc-aa4a0d612905', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-06 11:25:21', '2021-12-06 11:11:25', '2021-12-06 11:25:21'),
('315e794f-6b8c-48a8-bfa6-d26ba9d1af10', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":9,\"user_name\":\"johndoe\",\"type\":\"new\"}', '2021-12-17 09:14:09', '2021-12-09 04:12:46', '2021-12-17 09:14:09'),
('31cebae7-16b2-4cbe-abe6-d9c1e12eaeed', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:08:07', '2021-12-03 13:05:17', '2021-12-03 13:08:07'),
('321bc8ff-ff71-40a7-8916-6f04a8711e1a', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-09 23:48:55', '2021-12-17 09:13:57'),
('324d2ff7-2db9-404d-a488-3c82d8c76854', 'App\\Notifications\\CommentNotification', 'App\\Models\\User', 5, '{\"user_id\":12,\"post_id\":2,\"type\":\"comment\",\"message\":\"Commented on your post\"}', NULL, '2021-12-09 22:39:25', '2021-12-09 22:39:25'),
('34fbd758-4482-45ec-8a95-45e4bcdf9431', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-07 06:44:49', '2021-12-17 09:14:02'),
('35b287a3-350c-4854-ba35-897147a24baa', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 8, '{\"user_id\":5,\"member_id\":8,\"type\":\"call\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IAAZocQlh\\/0XvyQFOt3S9dInrtT0L8ZVzlk\\/vZOhrz9fvv6+H56uK7GEQADX8wAA3Na1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 05:32:52', '2021-12-11 05:32:52'),
('36331ba5-dff2-4eb8-a301-e1886126f9f4', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 11:50:26', '2021-12-03 11:50:17', '2021-12-03 11:50:26'),
('36b550cc-677b-4578-ad99-74ea6b00e713', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-11 01:04:43', '2021-12-11 01:04:43'),
('36d252c6-abbb-44b1-82f5-9ee415a540bc', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 4, '{\"user_id\":5,\"member_id\":4,\"type\":\"call\",\"message\":\"Request chat\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IACzah0XJ9zGT5D60bUTTnpRcysb4Vacl3rZT4VxJ52w47IuoU0AAAAAQABlegAA6yu4YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\",\"channel_name\":\"1639373419CV3Fod2KUJvQKmCS286v9ibFshNe5ShsX67qVhxn\"}', NULL, '2021-12-13 00:00:19', '2021-12-13 00:00:19'),
('379b280b-e291-461a-afb2-f2dba6245654', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 15, '{\"user_id\":8,\"type\":\"request\",\"message\":\"Request received\"}', NULL, '2021-12-15 03:20:45', '2021-12-15 03:20:45'),
('37fc8c3c-f52d-4093-8e1b-6f67534df2a5', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 15, '{\"user_id\":8,\"type\":\"accept\",\"message\":\"Request accepted\"}', NULL, '2021-12-15 03:22:35', '2021-12-15 03:22:35'),
('3814b0d2-2c36-42dc-a86c-1e4ca4b8fbce', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":8,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-16 23:23:58', '2021-12-16 23:23:58'),
('3896404b-e9cf-41c2-83fa-0031e207a557', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', '2021-12-17 09:13:36', '2021-12-12 23:22:44', '2021-12-17 09:13:36'),
('396f1a4b-ae2e-4ec9-8f27-8bde4c48331f', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-06 08:41:32', '2021-12-17 09:14:02'),
('3ad414f7-49ad-4244-9b6c-1920e2747437', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-07 04:02:45', '2021-12-17 09:13:57'),
('3b739455-a956-4f2d-9dfa-dc7137a28e21', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:14:30', '2021-12-03 13:13:53', '2021-12-03 13:14:30'),
('3bbf4fa7-15c9-4b6f-844c-a46b2e07712a', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-11 00:58:30', '2021-12-11 00:58:30'),
('3cfadf74-e63c-4c9d-8392-2021c1eb4b47', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:14:30', '2021-12-03 13:12:53', '2021-12-03 13:14:30'),
('3d18c472-fd23-4ed5-a27a-c381cfcc51f0', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 11:48:48', '2021-12-03 11:43:19', '2021-12-03 11:48:48'),
('3dc7b779-7566-4c5c-b799-e61143dfe59d', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":8,\"user_name\":\"sandip123\",\"type\":\"new\"}', '2021-12-17 09:14:19', '2021-12-14 03:09:11', '2021-12-17 09:14:19'),
('3eed10db-4df1-45b4-8e09-162ff8e30e88', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', '2021-12-17 09:13:36', '2021-12-07 10:22:53', '2021-12-17 09:13:36'),
('3fe4f120-4f9a-40cb-a65d-9514df0fd338', 'App\\Notifications\\CommentNotification', 'App\\Models\\User', 6, '{\"user_id\":5,\"post_id\":5,\"type\":\"comment\",\"message\":\"Commented on your post\"}', NULL, '2021-12-07 05:30:55', '2021-12-07 05:30:55'),
('3febdd43-826d-4392-a932-5bdeb19efb74', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-11 00:52:33', '2021-12-11 00:52:33'),
('41094d74-294b-4b98-8d9e-b706580b0064', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":6,\"member_id\":5,\"type\":\"audio\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IADfcSWjK1vn8oWLD5E6VmQchwitek5x31L+e0lIVjFY3eYxHRgAAAAAQAC\\/IgEAY+S1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 06:30:35', '2021-12-11 06:30:35'),
('411e1991-73ff-4037-b386-8c8ea60e11de', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 8, '{\"user_id\":5,\"member_id\":8,\"type\":\"call\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IACtp2m2XBeo+uH67TD6h0SHpeXtHnPCbRv50BReY6v4BIK+4TgAAAAAQABtEQAAutq1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 05:49:22', '2021-12-11 05:49:22'),
('41dac99f-a93a-471f-8a20-77dfc2b0650f', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', NULL, '2021-12-30 02:35:04', '2021-12-30 02:35:04'),
('42536cb8-01b0-4872-a8a8-a5b82a2d31ed', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-07 06:45:36', '2021-12-17 09:14:02'),
('4276f7dc-df3a-4692-a9e0-e01bea524b54', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":17,\"user_name\":\"texttoday\",\"type\":\"new\"}', '2021-12-17 09:12:59', '2021-12-17 09:09:08', '2021-12-17 09:12:59'),
('45ca749e-e13d-4ae1-beb6-93ecfe2d6f0c', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":9,\"post_id\":2,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-09 04:14:23', '2021-12-09 04:14:23'),
('469a529b-1b54-461a-81a6-ab0bdd58a940', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":6,\"member_id\":5,\"type\":\"audio\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IAD2IeLlgxMZemTUt\\/\\/MYUhH+PUyd\\/qT2uyn6ACZVp0bZOZqD08AAAAAQADhagEAm+W1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 06:35:47', '2021-12-11 06:35:47'),
('47352308-ab26-4ebe-bdd9-97238587bf91', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":6,\"post_id\":1,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-09 01:31:38', '2021-12-09 01:31:38'),
('48535975-045a-4884-bef2-a2e0ce205cca', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 6, '{\"user_id\":8,\"type\":\"accept\",\"message\":\"Request accepted.\"}', NULL, '2021-12-07 09:38:16', '2021-12-07 09:38:16'),
('49567dd2-6ac5-401b-949e-2173db4a06e0', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-11 00:52:02', '2021-12-11 00:52:02'),
('49936c68-1686-47fa-85f1-6b4c9b0fd8b4', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":6,\"post_id\":1,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-09 01:18:36', '2021-12-09 01:18:36'),
('4a742d15-7a86-4202-9d9c-de94a5426e6d', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', '2021-12-17 09:13:36', '2021-12-12 23:14:07', '2021-12-17 09:13:36'),
('4c1aca9b-5676-4225-8bd1-a46cfeddebad', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-07 04:36:51', '2021-12-17 09:14:02'),
('4cc770d7-99df-493f-88b5-a32bf30c03dd', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 10, '{\"user_id\":5,\"type\":\"accept\",\"message\":\"Request accepted\"}', NULL, '2021-12-07 11:53:35', '2021-12-07 11:53:35'),
('5038da3a-ffa8-4ef9-9c94-f47301ef4b1c', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', '2021-12-17 09:13:36', '2021-12-07 05:44:04', '2021-12-17 09:13:36'),
('53123bf6-850d-4d99-83e5-5d471efb21f8', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"12numbrs\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-17 00:51:25', '2021-12-17 09:14:02'),
('54ffb37a-4244-4438-9f5a-01b328acd3ea', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":8,\"member_id\":5,\"type\":\"voice\",\"message\":\"Request chat\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IAAS0dRd6LGdri6SPomYeWXFTz7PMOQHIDInTIK8kG5MJxWr4FEAAAAAQAAjpgAAFCe4YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\",\"channel_name\":\"1639372180SIAUJijgs4Pj0bIadfPmCypQpS2Z1VvvxWwaHEJ9\"}', NULL, '2021-12-12 23:39:40', '2021-12-12 23:39:40'),
('554debb6-1cc6-4f7b-8c6e-2e5361828792', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:03:18', '2021-12-03 13:02:29', '2021-12-03 13:03:18'),
('555e311d-4f3b-4a99-96cf-10f968dcb7e2', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-11 05:44:00', '2021-12-11 05:44:00'),
('5647d38a-2038-4ea5-b03b-088f3846d171', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:03:18', '2021-12-03 11:54:44', '2021-12-03 13:03:18'),
('56738bb4-7472-468a-810e-b13b2436fdd2', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-10 01:05:00', '2021-12-17 09:13:57'),
('56c10dfe-2c43-4ef7-81d8-6537174f9c59', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 5, '{\"user_id\":6,\"type\":\"request\",\"message\":\"Request sent.\"}', NULL, '2021-12-07 06:31:16', '2021-12-07 06:31:16'),
('5786f855-5700-4a41-8c8c-de332a5a0448', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-07 04:38:35', '2021-12-17 09:13:57'),
('57dde496-2ee2-4e63-9b7b-0bc1d393ae5e', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:03:46', '2021-12-03 13:03:35', '2021-12-03 13:03:46'),
('57e9354d-d763-494e-b233-e0581be63158', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":16,\"user_name\":\"venom\",\"type\":\"new\"}', '2021-12-17 09:13:53', '2021-12-17 07:28:48', '2021-12-17 09:13:53'),
('585af154-3a25-4694-8843-fa783e19f0b7', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:03:18', '2021-12-03 13:02:23', '2021-12-03 13:03:18'),
('589aedc7-c529-4487-96bc-f099171d53b2', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 6, '{\"user_id\":8,\"type\":\"request\",\"message\":\"Request sent.\"}', NULL, '2021-12-07 09:36:43', '2021-12-07 09:36:43'),
('58aad37c-25ad-4c68-bca8-c5cfa70989dd', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 08:55:03', '2021-12-03 06:47:59', '2021-12-03 08:55:03'),
('59f4b97f-0448-4c4f-9368-7a7dccb40212', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":5,\"post_id\":2,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-07 12:41:05', '2021-12-07 12:41:05'),
('5a20ec91-5106-4159-90e9-f6d04a79a793', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 15, '{\"user_id\":15,\"post_id\":8,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-16 06:55:52', '2021-12-16 06:55:52'),
('5b4877f4-3dbd-4d1c-8c56-dd0a307a143f', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":9,\"user_name\":\"johndoe\",\"type\":\"new\"}', '2021-12-17 09:14:09', '2021-12-07 09:41:41', '2021-12-17 09:14:09'),
('5c1a0461-810f-4cb2-b02d-310fa18024f3', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:03:18', '2021-12-03 13:03:12', '2021-12-03 13:03:18'),
('5c4c5a09-60f1-44c3-8da6-e0cf01a99d57', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 11:43:15', '2021-12-03 11:43:12', '2021-12-03 11:43:15'),
('5e88c63d-7002-4a7b-8693-afc056580baa', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 4, '{\"user_id\":5,\"member_id\":4,\"type\":\"call\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IACEnyktlVXoR8ROmxOABxdHZIk9rtq4IDUXqppYodPNtlpEP3MAAAAAQADKugAActq1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 05:48:10', '2021-12-11 05:48:10'),
('5feeb45e-ec0e-4345-84cf-81f261db857f', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 15, '{\"user_id\":5,\"type\":\"accept\",\"message\":\"Request accepted\"}', NULL, '2021-12-12 23:33:34', '2021-12-12 23:33:34'),
('603a6838-a4d4-4aa4-9955-350ea86c0181', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-03 13:15:55', '2021-12-17 09:14:02'),
('612063ee-3053-4860-b36d-b4217346ebdd', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:08:07', '2021-12-03 13:05:03', '2021-12-03 13:08:07'),
('62dd7c1f-6e02-4034-b85b-69fbb3829ab0', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":8,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-30 00:30:20', '2021-12-30 00:30:20'),
('63a91ded-2576-498b-bac1-b527cf89b380', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 6, '{\"user_id\":15,\"type\":\"request\",\"message\":\"Request received\"}', NULL, '2021-12-17 03:58:35', '2021-12-17 03:58:35'),
('64639cc6-f7e8-4039-899d-9ee5a592a8e8', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-11 00:57:11', '2021-12-11 00:57:11'),
('64deef51-05c9-4262-8b59-95017dac9328', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 09:07:35', '2021-12-03 08:56:56', '2021-12-03 09:07:35'),
('660f3125-0293-4a53-ac62-34db80e5699b', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', '2021-12-17 09:13:36', '2021-12-10 00:50:20', '2021-12-17 09:13:36'),
('666f2021-36da-4499-becb-e43a03a7a08e', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 08:55:03', '2021-12-03 06:43:15', '2021-12-03 08:55:03'),
('67bd85c5-c8e8-4b97-90c3-b70e6a2667fb', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":5,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-07 05:20:54', '2021-12-07 05:20:54'),
('69361133-3f7e-4db2-9e15-4064ea0232fb', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 5, '{\"user_id\":7,\"type\":\"request\",\"message\":\"Request sent.\"}', NULL, '2021-12-07 06:49:15', '2021-12-07 06:49:15'),
('6a1cc90f-ccc0-4205-9242-6d0111773221', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 6, '{\"user_id\":8,\"type\":\"request\",\"message\":\"Request sent.\"}', NULL, '2021-12-07 09:37:37', '2021-12-07 09:37:37'),
('6a987524-d387-4a7b-877d-0ad7d3a19092', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 2, '{\"user_id\":5,\"member_id\":2,\"type\":\"call\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IADzVHpj7npKEPJ3CTtB6MnifjJiGMa2Xk2jrBBec+OLkQu06moAAAAAQABjxgAA\\/OC1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 06:16:04', '2021-12-11 06:16:04'),
('6ccc48f6-24bf-4656-89d7-3e2c8872be13', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 6, '{\"user_id\":12,\"type\":\"request\",\"message\":\"Request received\"}', NULL, '2021-12-10 00:37:07', '2021-12-10 00:37:07'),
('6cf92dca-49fe-4524-a49f-e1aae695d4d3', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', NULL, '2021-12-26 22:54:10', '2021-12-26 22:54:10'),
('6e1b162e-98b4-44e9-a313-2ba991ca85b7', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', NULL, '2021-12-27 03:03:18', '2021-12-27 03:03:18'),
('6f18771d-76c2-4e37-9560-f33de94ee729', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-12 23:25:19', '2021-12-17 09:13:57'),
('6f8b4d24-991b-471e-9a77-1951e00101d9', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-10 01:47:44', '2021-12-10 01:47:44'),
('73026ffa-9408-4707-915b-ea843ce106b0', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 12, '{\"user_id\":7,\"type\":\"request\",\"message\":\"Request received\"}', NULL, '2021-12-09 22:44:57', '2021-12-09 22:44:57'),
('763895dd-880d-4a0c-a0dc-e021c0ba3fc9', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":8,\"user_name\":\"sandip123\",\"type\":\"new\"}', '2021-12-17 09:14:19', '2021-12-07 09:18:04', '2021-12-17 09:14:19'),
('78fdba6e-6a12-40c5-9b0c-4089ad512a2e', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":6,\"post_id\":1,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-09 01:22:11', '2021-12-09 01:22:11'),
('7a1cdb61-cea5-485d-b409-a71a36d8baf7', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 11:50:26', '2021-12-03 11:50:21', '2021-12-03 11:50:26'),
('7a1e14fe-8f8e-4e54-b321-0ff6935f641b', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:14:30', '2021-12-03 13:11:32', '2021-12-03 13:14:30'),
('7a468470-555b-48a2-8f4b-1ab6c73f2e63', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":8,\"user_name\":\"sandip123\",\"type\":\"new\"}', '2021-12-17 09:14:19', '2021-12-07 08:23:29', '2021-12-17 09:14:19'),
('7c38ba03-a7a0-447d-b251-fa00bc2950f8', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 09:07:35', '2021-12-03 09:07:19', '2021-12-03 09:07:35'),
('7c61313c-4d01-4f12-b090-abe21ffb2a5a', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":17,\"user_name\":\"texttoday\",\"type\":\"new\"}', '2021-12-17 09:16:22', '2021-12-17 09:15:09', '2021-12-17 09:16:22'),
('7c81d794-5736-4009-9b36-ea6710083ca1', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:03:18', '2021-12-03 11:54:34', '2021-12-03 13:03:18'),
('7d48d947-0157-4cff-ab87-2405460fe577', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":15,\"member_id\":5,\"type\":\"audio\",\"message\":\"Request chat\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IABvjJ\\/fUS6SbeiKAUM9nvZCYTDlE8SAd+dOUmKAuAlDGahydgAAAAAAQADKqgAA5Ci4YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\",\"channel_name\":\"1639372644Fi9QMfCrVR5s2jVWSdzeMuD55E9kmsfjebS2Cpdu\"}', NULL, '2021-12-12 23:47:24', '2021-12-12 23:47:24'),
('7d4f0285-efb4-47b9-ab29-0faa9628197f', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":9,\"user_name\":\"johndoe\",\"type\":\"new\"}', '2021-12-17 09:14:09', '2021-12-07 08:30:21', '2021-12-17 09:14:09'),
('7d6e6d6c-d234-4d40-8e62-d3869fd40f96', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":7,\"user_name\":\"eminem\",\"type\":\"new\"}', '2021-12-17 09:14:23', '2021-12-06 16:07:11', '2021-12-17 09:14:23'),
('7e3f8b92-a92e-46f7-8a85-0d6545363025', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 09:07:35', '2021-12-03 08:57:19', '2021-12-03 09:07:35'),
('7e64acb4-c64e-43b5-9dbe-0bbeccf21aa3', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":7,\"user_name\":\"eminem\",\"type\":\"new\"}', '2021-12-17 09:14:23', '2021-12-06 13:34:11', '2021-12-17 09:14:23'),
('80c4ebb8-764b-4315-bd04-33afdbd38ed2', 'App\\Notifications\\CommentNotification', 'App\\Models\\User', 7, '{\"user_id\":2,\"post_id\":6,\"type\":\"comment\",\"message\":\"Commented on your post\"}', NULL, '2021-12-07 05:38:04', '2021-12-07 05:38:04'),
('818462d8-f401-485f-b0ef-ebc218d4af9d', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', NULL, '2021-12-30 01:26:14', '2021-12-30 01:26:14'),
('81d440ac-e8e7-4033-8f4d-a6013733997a', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-07 11:50:11', '2021-12-17 09:13:57'),
('821bbb15-0f95-4a02-8f40-f41ff57f79e1', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 8, '{\"user_id\":5,\"type\":\"accept\",\"message\":\"Request accepted.\"}', NULL, '2021-12-07 09:17:11', '2021-12-07 09:17:11'),
('8392ec9f-999e-4c63-88bb-226acf5b05f0', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', '2021-12-21 05:23:08', '2021-12-20 00:16:03', '2021-12-21 05:23:08'),
('83b38541-7110-4db8-95a0-3a3fc03a1de2', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-07 03:44:42', '2021-12-17 09:13:57'),
('8401925a-6011-489c-a21d-814967b07c36', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:14:30', '2021-12-03 13:14:10', '2021-12-03 13:14:30'),
('845a0d06-fc06-4da0-9296-1d0a94c4fba7', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', NULL, '2021-12-27 06:16:05', '2021-12-27 06:16:05'),
('867275e2-be42-45d3-83e8-4788b89552c9', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:03:18', '2021-12-03 13:01:28', '2021-12-03 13:03:18'),
('8833ec50-4e28-4e4c-a019-d3deef616592', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":5,\"post_id\":4,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-07 05:47:08', '2021-12-07 05:47:08'),
('89025b1f-6928-4c00-959f-c14813e40ab3', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":7,\"user_name\":\"eminem\",\"type\":\"new\"}', '2021-12-17 09:14:23', '2021-12-06 13:33:38', '2021-12-17 09:14:23'),
('8ccd5a62-de4b-4f63-a556-71372b17f2b8', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-11 00:52:16', '2021-12-11 00:52:16'),
('8cdc2d09-adfe-4caa-8788-1634391199af', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-10 01:42:19', '2021-12-10 01:42:19'),
('8d4370b2-5d81-4d83-b728-0985a360203a', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":5,\"post_id\":2,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-30 02:37:21', '2021-12-30 02:37:21'),
('8e1842ca-5442-4fbf-9e76-88917bc78026', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-11 01:01:20', '2021-12-11 01:01:20'),
('90ca7ec6-9222-4998-826e-831a46866aec', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 12, '{\"user_id\":6,\"type\":\"received\",\"message\":\"Request received\"}', NULL, '2021-12-10 00:37:07', '2021-12-10 00:37:07'),
('92b01023-42aa-445f-820c-afeb7abbeefc', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', NULL, '2021-12-30 22:33:24', '2021-12-30 22:33:24'),
('92bbadff-ea2f-49c0-b1f2-65e0bd14de96', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 15, '{\"user_id\":4,\"type\":\"request\",\"message\":\"Request received\"}', NULL, '2021-12-12 23:29:41', '2021-12-12 23:29:41'),
('92f7f5a6-6438-4a15-b23b-eaf4eb0582e2', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":6,\"member_id\":5,\"type\":\"audio\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IAAzqzh8VwRlqKhFB5oeodumhcj+Y+hIJx2xJji+e2ItlxVolNwAAAAAQACvAAEAjuS1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 06:31:18', '2021-12-11 06:31:18'),
('93941949-3f5a-408b-8da2-25d0f9891796', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 4, '{\"user_id\":6,\"type\":\"request\",\"message\":\"Request received\"}', NULL, '2021-12-16 23:37:27', '2021-12-16 23:37:27'),
('94738b34-c09e-4fad-bf69-5a489bef4647', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":4,\"user_name\":\"bhavesh123\",\"type\":\"new\"}', '2021-12-17 09:14:27', '2021-12-07 10:21:25', '2021-12-17 09:14:27'),
('95b34672-f680-4eb6-b5ac-133129e22189', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-12 23:29:34', '2021-12-17 09:13:57'),
('95d04332-2363-409d-a858-62e49ae984c9', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":9,\"post_id\":2,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-09 04:13:26', '2021-12-09 04:13:26'),
('96731100-5a89-4740-9561-7c5514eda2a2', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-11 00:59:34', '2021-12-11 00:59:34'),
('993b76d0-9f05-4c98-a23a-86b4737ae721', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 11:49:41', '2021-12-03 11:49:38', '2021-12-03 11:49:41'),
('998f1404-6aef-4f5f-97c6-4a5cd69b4f18', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":15,\"user_name\":\"chandni123\",\"type\":\"new\"}', '2021-12-17 09:14:05', '2021-12-15 05:15:35', '2021-12-17 09:14:05'),
('99c75406-d3ef-4d8e-8142-a31fde94c0a0', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":12,\"user_name\":\"mrfeast\",\"type\":\"new\"}', '2021-12-17 09:14:29', '2021-12-09 22:39:08', '2021-12-17 09:14:29'),
('9a59a34e-927d-4688-b5dc-6448b2a22e6b', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 09:07:35', '2021-12-03 09:07:11', '2021-12-03 09:07:35'),
('9ac90b8a-f18c-4d60-9481-4d9d4b8fef93', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-10 22:36:42', '2021-12-17 09:13:57'),
('9b3bab58-2e47-48a3-ac17-c2f3bc817f0b', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 08:55:03', '2021-12-03 08:54:07', '2021-12-03 08:55:03'),
('9b5a77b0-76d2-4fbf-b166-f3963002bfef', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":6,\"post_id\":1,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-09 01:27:06', '2021-12-09 01:27:06'),
('9bf5927f-e2b0-4d92-913f-67c19d4db0f0', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":9,\"user_name\":\"johndoe\",\"type\":\"new\"}', '2021-12-17 09:14:09', '2021-12-14 03:11:32', '2021-12-17 09:14:09'),
('9ce48238-1627-45a1-9a09-cf046c465bbe', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:03:18', '2021-12-03 13:01:18', '2021-12-03 13:03:18'),
('9d124dc0-db56-44f1-8821-eaab8217f849', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-11 05:45:52', '2021-12-11 05:45:52'),
('9d25c256-e34a-4ba0-b222-af940120d850', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:05:01', '2021-12-03 13:04:58', '2021-12-03 13:05:01'),
('9d403400-afad-49d6-8451-5b9d28e52f4b', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":17,\"user_name\":\"texttoday\",\"type\":\"new\"}', '2021-12-17 09:16:22', '2021-12-17 09:15:24', '2021-12-17 09:16:22'),
('9e49e2f3-d9e1-4002-8b2d-0134be9a993c', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-03 13:15:42', '2021-12-17 09:14:02'),
('9ec40f0e-ce1a-45ad-8f69-235cc4d9ceaa', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 4, '{\"user_id\":6,\"member_id\":4,\"type\":\"call\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IABsnaR3XMLIUUFHUb\\/MlU1Hzv3TNV9GdZ7ktMLMe3L6A9lr3cMAAAAAQAD30AAAz9y1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 05:58:15', '2021-12-11 05:58:15'),
('9f014d48-863c-4452-842b-374968bd4478', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":8,\"member_id\":5,\"type\":\"voice\",\"message\":\"Request chat\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IABWQSjH6uRs8HoQ+bXhh6q1QQ0LPpIu6SL01UZEqcK5TXqVgL8AAAAAQACT1QAAuSy4YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\",\"channel_name\":\"1639373625C5Y27pCu2J0h8mouZQEG32Ii2obCWJD9JxQ0QMmA\"}', NULL, '2021-12-13 00:03:45', '2021-12-13 00:03:45'),
('9f9a19b6-ea5b-4122-99e8-1e8a72c54d12', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', NULL, '2021-12-23 23:55:28', '2021-12-23 23:55:28'),
('a06ced78-5574-436f-954e-547397631683', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', '2021-12-17 09:13:36', '2021-12-10 01:58:29', '2021-12-17 09:13:36'),
('a5b1751c-cb77-4e3c-8117-05daaadcc4c1', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 4, '{\"user_id\":8,\"member_id\":4,\"type\":\"voice\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IAC1kCPHPq352Ekt3ST1o+cZjcP1fX5T0x50KsgBBwiIGw4WrFcAAAAAQABmygAAu921YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 06:02:11', '2021-12-11 06:02:11'),
('a85a7ae2-defc-4a1f-a61c-3a87f4a1d504', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 5, '{\"user_id\":4,\"type\":\"accept\",\"message\":\"Request accepted\"}', NULL, '2021-12-07 12:10:46', '2021-12-07 12:10:46');
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('a8837012-e8fd-460f-8236-8aa35108d584', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 4, '{\"user_id\":6,\"type\":\"request\",\"message\":\"Request sent.\"}', NULL, '2021-12-07 10:23:01', '2021-12-07 10:23:01'),
('a8d2e51a-08aa-4ae0-b171-d689d739c466', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-06 11:25:21', '2021-12-06 06:22:07', '2021-12-06 11:25:21'),
('ae185bca-3a64-4640-b1ef-0679c9dd9130', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-07 04:04:32', '2021-12-17 09:13:57'),
('af777380-7166-4532-bf0d-61696be921cd', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"12numbrs\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-10 00:58:44', '2021-12-17 09:14:02'),
('b007b3a3-21c2-43df-bcf0-473bfa7003c1', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":15,\"user_name\":\"chandni123\",\"type\":\"new\"}', NULL, '2021-12-22 06:01:25', '2021-12-22 06:01:25'),
('b0d4b146-2541-4e9b-b070-ccf0fd82f46d', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-17 02:31:15', '2021-12-17 09:13:57'),
('b1838de9-27cb-408c-8566-1f8353b1e724', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-07 07:00:44', '2021-12-17 09:13:57'),
('b29de745-ec8c-40cc-929c-38bf3049062d', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:03:18', '2021-12-03 13:02:01', '2021-12-03 13:03:18'),
('b2e35784-2bf5-4464-b493-39175cc4a5d5', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 4, '{\"user_id\":5,\"member_id\":4,\"type\":\"call\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IACV4144WeG56vx\\/vlR2\\/NTbEEG94RR3IW\\/YCtvJxwsZQWappiGuK7GEQAC1QwAAg9a1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 05:31:23', '2021-12-11 05:31:23'),
('b462a8ad-310d-4f47-a6ee-8fa9e4915fd1', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":6,\"member_id\":5,\"type\":\"audio\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IAAJVnqTEHsz6+zvwuMbzIewpdLyqH49MPGu3fICB8u9v2c6RoEAAAAAQACckgAABeO1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 06:24:45', '2021-12-11 06:24:45'),
('b4b951ef-1ec4-4f41-b99e-ded4ee6efd8a', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:03:18', '2021-12-03 11:51:14', '2021-12-03 13:03:18'),
('b5005cfc-e65d-40f2-85fc-84fffecb9e6e', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 08:55:03', '2021-12-03 08:53:54', '2021-12-03 08:55:03'),
('b5248780-71a7-45a2-98d0-dfcd17517e7e', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 11:43:15', '2021-12-03 11:40:41', '2021-12-03 11:43:15'),
('b5344077-3d56-438e-b619-ac730459e35e', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":17,\"user_name\":\"texttoday\",\"type\":\"new\"}', '2021-12-17 09:12:59', '2021-12-17 09:09:32', '2021-12-17 09:12:59'),
('b745a3f9-780a-4f55-8fb1-9080bd450640', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":14,\"user_name\":\"chandnipatel\",\"type\":\"new\"}', '2021-12-17 09:14:12', '2021-12-12 23:20:55', '2021-12-17 09:14:12'),
('b91fcca5-2030-4de3-bec7-71b40297e380', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":8,\"user_name\":\"sandip123\",\"type\":\"new\"}', '2021-12-17 09:14:19', '2021-12-15 03:22:06', '2021-12-17 09:14:19'),
('bc17b842-f5e5-47b4-af16-2e99edb04b58', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', NULL, '2021-12-27 06:30:25', '2021-12-27 06:30:25'),
('bc1a35f3-1795-4ee9-b727-7746f2648352', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":5,\"post_id\":2,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-30 03:16:23', '2021-12-30 03:16:23'),
('bcf2ef18-d0f8-4947-bea7-1316f858ff44', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":17,\"user_name\":\"texttoday\",\"type\":\"new\"}', '2021-12-17 09:12:59', '2021-12-17 09:09:42', '2021-12-17 09:12:59'),
('bcf5789a-6cf0-4e52-b747-8fbe8a015ec1', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', '2021-12-17 09:13:36', '2021-12-06 12:32:28', '2021-12-17 09:13:36'),
('bee11ab4-6516-4bde-a994-97169a285d33', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-16 23:24:50', '2021-12-16 23:24:50'),
('bf764318-5c39-4fa8-9840-6c3533bbb044', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":8,\"user_name\":\"sandip123\",\"type\":\"new\"}', '2021-12-17 09:14:19', '2021-12-14 03:08:49', '2021-12-17 09:14:19'),
('bf936003-348e-4535-894d-d9b37d86f31b', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', '2021-12-17 09:13:36', '2021-12-12 22:34:25', '2021-12-17 09:13:36'),
('bfcb87db-0af9-447c-987b-8d129863a61e', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":8,\"user_name\":\"sandip123\",\"type\":\"new\"}', '2021-12-17 09:14:19', '2021-12-14 03:34:50', '2021-12-17 09:14:19'),
('c1b75012-373e-46c3-b785-0eacaddb3c53', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', '2021-12-17 09:13:36', '2021-12-07 09:57:42', '2021-12-17 09:13:36'),
('c4860c41-ad8e-4707-a8dc-d38d251949fd', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":8,\"user_name\":\"sandip123\",\"type\":\"new\"}', NULL, '2021-12-24 23:00:15', '2021-12-24 23:00:15'),
('c588da95-1b34-4ff7-97b5-00a82c8620a9', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 6, '{\"user_id\":5,\"member_id\":6,\"type\":\"voice\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IAAsTzly3KlHrMBB5p62bxcRfspu6sNwSeeRYvpF6hTNXa4vNQAAAAAAQADZGgAAuOa1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 06:40:32', '2021-12-11 06:40:32'),
('c5f026e1-6ba5-40c4-8b41-cdba8d7d00f1', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 8, '{\"user_id\":5,\"member_id\":8,\"type\":\"voice\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IACR0V86i2a\\/zh9QZ4OUFxv2ILxz\\/+CgdC+10BeUbUsFYjRSZL0AAAAAQABbWwAAreG1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 06:19:01', '2021-12-11 06:19:01'),
('c6a497c3-e29c-4e18-a80b-3e9e419bab83', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 15, '{\"user_id\":6,\"type\":\"received\",\"message\":\"Request received\"}', NULL, '2021-12-17 03:58:35', '2021-12-17 03:58:35'),
('c6e05597-4724-40b7-add2-d7530b5e87be', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 08:55:03', '2021-12-03 06:50:40', '2021-12-03 08:55:03'),
('c7002b76-0a9e-47d3-a7fc-979e7afbe40b', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":5,\"post_id\":2,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-30 03:16:02', '2021-12-30 03:16:02'),
('c7c513c6-1bff-471b-b320-0baa543c2d86', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', NULL, '2021-12-22 06:01:13', '2021-12-22 06:01:13'),
('c815ad71-1760-404a-b5ad-fd88ac316f72', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-07 06:43:08', '2021-12-17 09:13:57'),
('c83982d9-5cd3-4ede-8afc-149ea65ffb3a', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:14:30', '2021-12-03 13:10:39', '2021-12-03 13:14:30'),
('c9abb0e1-3100-4d07-8089-1d9b04a6460a', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 08:55:03', '2021-12-03 08:54:17', '2021-12-03 08:55:03'),
('ca2e0a88-4ce1-4edd-a0be-a70771138e93', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-11 00:52:59', '2021-12-11 00:52:59'),
('caa72c96-c9a9-4003-b750-5f0226ed3e9e', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-10 00:53:19', '2021-12-10 00:53:19'),
('cbd84882-3a2c-4fec-83a5-4d2c12c3f921', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"12numbrs\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-08 23:56:01', '2021-12-17 09:14:02'),
('cbe524da-b373-4cae-81d4-09a099fdcc76', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:14:30', '2021-12-03 13:14:21', '2021-12-03 13:14:30'),
('ccbe6dd0-12a0-4954-876a-9b3121eac29b', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 11:43:15', '2021-12-03 11:40:31', '2021-12-03 11:43:15'),
('cd2b7445-aca2-4c1e-adcc-0c5c20f6615b', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 11:49:41', '2021-12-03 11:49:03', '2021-12-03 11:49:41'),
('ce32cb1e-d797-4df5-a0fb-388a5e4fbec4', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 4, '{\"user_id\":5,\"member_id\":4,\"type\":\"call\",\"message\":\"Request chat\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IAB07zv\\/WEIokU3p\\/c8Xwn5bfnV\\/K\\/0FqdHOyQ3m6kSERUlKyAwAAAAAQACzcQAApya4YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\",\"channel_name\":\"1639372071Zwp3qzWKhr22yBgYzHAVYNVZW7s2gMhX5LlVBrKd\"}', NULL, '2021-12-12 23:37:51', '2021-12-12 23:37:51'),
('ce524ac8-7538-4377-aea5-3c0ab82c52b6', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', '2021-12-06 11:53:24', '2021-12-06 11:27:08', '2021-12-06 11:53:24'),
('ceb2a63f-6c99-4879-9a70-b8ff4edbb73b', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', NULL, '2021-12-28 00:07:12', '2021-12-28 00:07:12'),
('cebfc38b-a46a-412b-b288-9902b6b4e7ec', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 4, '{\"user_id\":5,\"member_id\":4,\"type\":\"call\",\"message\":\"Request chat\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IABoDWn6Z0lflDbdV2UqB1n1sIbdzHO04uAV07B5cs7YMrMySBQAAAAAQAC+DQAAriy4YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\",\"channel_name\":\"16393736145qUv67SwyDB0p8MrBrUsJCKAdXuNUWXYJ6ROkaE3\"}', NULL, '2021-12-13 00:03:34', '2021-12-13 00:03:34'),
('d0c03f84-be50-473e-92eb-12f2b345da52', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":6,\"member_id\":5,\"type\":\"audio\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IAB6HxHT7Kze02PIAxNGZzYvr+lcngEydlcS361xM1U8bht4osEAAAAAQADdVwEA\\/eW1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 06:37:25', '2021-12-11 06:37:25'),
('d12d4df0-b24e-4be1-9919-716bd4dc7224', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":5,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-30 03:18:23', '2021-12-30 03:18:23'),
('d1389151-c208-440b-9fdb-7613678c474c', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 8, '{\"user_id\":5,\"type\":\"request\",\"message\":\"Request sent.\"}', NULL, '2021-12-07 08:27:59', '2021-12-07 08:27:59'),
('d16e4324-eacd-4568-bfb1-5c0e8de85da1', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', '2021-12-17 09:13:36', '2021-12-10 02:25:37', '2021-12-17 09:13:36'),
('d2e3a6c8-7674-4093-bc24-3f67c7c52e9d', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', NULL, '2021-12-24 00:01:16', '2021-12-24 00:01:16'),
('d2f9713a-bbf6-4b98-87b4-3284b930716e', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:14:30', '2021-12-03 13:13:45', '2021-12-03 13:14:30'),
('d49a0b50-71da-4fe9-bde9-d23b997947cf', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-11 01:09:07', '2021-12-11 01:09:07'),
('d4e066ff-b3e5-4a0b-acb5-22a112c2f57d', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"12numbrs\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-08 23:52:25', '2021-12-17 09:14:02'),
('d50be782-d72c-495e-bb21-08f5d179c761', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":15,\"user_name\":\"chandni123\",\"type\":\"new\"}', '2021-12-17 09:14:05', '2021-12-16 23:34:24', '2021-12-17 09:14:05'),
('d5328f91-8f31-4d27-9c33-7880becc3150', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-06 11:25:21', '2021-12-06 06:29:56', '2021-12-06 11:25:21'),
('d567e42a-b645-49c9-82e6-da8640d29bff', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"12numbrs\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-08 23:36:22', '2021-12-17 09:14:02'),
('d57a84bf-71fb-4339-bfdd-1430b93ab9d9', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:03:18', '2021-12-03 12:03:26', '2021-12-03 13:03:18'),
('d6951cbe-1047-4af3-a3a3-7d060305e206', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 10, '{\"user_id\":5,\"type\":\"request\",\"message\":\"Request received\"}', NULL, '2021-12-07 11:49:38', '2021-12-07 11:49:38'),
('d8cdcaa1-6741-42b5-9457-e66504822163', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 08:55:03', '2021-12-03 06:45:24', '2021-12-03 08:55:03'),
('db649b88-440d-4302-8dd1-c917c0bd7061', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', NULL, '2021-12-24 22:44:07', '2021-12-24 22:44:07'),
('dbcb7bfd-3ba5-4229-b9b9-6885105da104', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-07 06:44:25', '2021-12-17 09:14:02'),
('dd363144-3f90-4abc-8777-69e1eeb9a6a5', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-03 13:15:33', '2021-12-17 09:14:02'),
('ddd0d554-df25-4748-8674-af713c65d738', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:14:30', '2021-12-03 13:08:14', '2021-12-03 13:14:30'),
('decc349d-34b3-4aa3-8943-254860eba1ca', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":6,\"member_id\":5,\"type\":\"audio\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IACFLjQcFtX+k0caaAyynjoGy8D7JM7OffaKMRcZbFdqtZQWLSEAAAAAQAB\\/LwEAUeS1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 06:30:17', '2021-12-11 06:30:17'),
('deff52d7-cc48-45e9-aa12-f7f7e7f90f3a', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 13:03:18', '2021-12-03 12:03:21', '2021-12-03 13:03:18'),
('dfa14b4d-5de2-439b-a989-78e319d93f07', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":8,\"user_name\":\"sandip123\",\"type\":\"new\"}', '2021-12-17 09:14:19', '2021-12-14 03:37:59', '2021-12-17 09:14:19'),
('dfbf0739-05a3-45da-88ef-9904690cd5be', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 09:07:35', '2021-12-03 09:06:58', '2021-12-03 09:07:35'),
('e0538756-dd5e-4860-89ae-3dc3f24f4895', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 09:07:35', '2021-12-03 09:01:24', '2021-12-03 09:07:35'),
('e14f5775-212e-4fcd-9d33-fbbf5a86e379', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 08:55:03', '2021-12-03 06:49:13', '2021-12-03 08:55:03'),
('e1e33266-90ae-4477-a1d1-2e5467a869d2', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 5, '{\"user_id\":5,\"post_id\":1,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-07 12:41:08', '2021-12-07 12:41:08'),
('e28b4b3f-e5e1-40a8-a1e6-2e766f7a598d', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-07 04:28:39', '2021-12-17 09:13:57'),
('e3427c5f-614a-4296-a2e9-9495ac5dda65', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', '2021-12-17 09:13:36', '2021-12-10 01:13:14', '2021-12-17 09:13:36'),
('e3c3f2c0-cdf9-4bd7-9b5c-30d91ee6cd08', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-21 05:23:10', '2021-12-19 23:49:46', '2021-12-21 05:23:10'),
('e4098145-4005-41df-a069-ea769986f7c6', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":6,\"member_id\":5,\"type\":\"audio\",\"message\":\"Commented on your post\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IADVDKMlSbCPhvQ62rTIuglU+s0GyDwT\\/Gl0q8QYintJuFZu0lQAAAAAQABnUwAA5uS1YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\"}', NULL, '2021-12-11 06:32:46', '2021-12-11 06:32:46'),
('e4b817a4-372f-4f37-ac72-2a81e6142ef6', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":5,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-30 00:58:37', '2021-12-30 00:58:37'),
('e4bd2a08-9ac9-42a1-8ace-cd7b5c9f43be', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":5,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-07 05:38:17', '2021-12-07 05:38:17'),
('e573cca0-1707-4a57-9f7b-4bdc0643b1ae', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 5, '{\"user_id\":6,\"type\":\"accept\",\"message\":\"Request accepted.\"}', NULL, '2021-12-07 06:35:28', '2021-12-07 06:35:28'),
('e5e8c8d9-c3af-48d5-9dbe-ccdaa4b8af26', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 08:55:03', '2021-12-03 06:43:24', '2021-12-03 08:55:03'),
('e656d581-6080-4944-b00a-be3bdcca3480', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":17,\"user_name\":\"texttoday\",\"type\":\"new\"}', '2021-12-17 09:12:59', '2021-12-17 09:10:59', '2021-12-17 09:12:59'),
('e73e44c0-31a4-494a-a970-dfb9c627b2f1', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 15, '{\"user_id\":5,\"type\":\"request\",\"message\":\"Request received\"}', NULL, '2021-12-12 23:29:52', '2021-12-12 23:29:52'),
('e7888051-1bac-40c0-a258-6dfed1f41474', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-10 01:28:54', '2021-12-10 01:28:54'),
('e963644a-5916-45e2-a4f0-7d41e0fb3b4a', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 9, '{\"user_id\":6,\"type\":\"accept\",\"message\":\"Request accepted.\"}', NULL, '2021-12-07 09:42:11', '2021-12-07 09:42:11'),
('ea7d66d2-0f5d-4d0d-bb6d-36223a13ec8d', 'App\\Notifications\\CommentNotification', 'App\\Models\\User', 5, '{\"user_id\":12,\"post_id\":2,\"type\":\"comment\",\"message\":\"Commented on your post\"}', NULL, '2021-12-09 22:39:29', '2021-12-09 22:39:29'),
('eb0a1429-7fb7-45bb-a848-1939eb39cd7d', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-10 01:58:41', '2021-12-10 01:58:41'),
('ec137640-bccd-4235-962f-849a4e7f5718', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-07 04:01:11', '2021-12-17 09:13:57'),
('ec66a639-08f5-4af7-b4aa-221e6ebfef64', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":8,\"member_id\":5,\"type\":\"voice\",\"message\":\"Request chat\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IABmFgmVnqKMVEpyCA97C1PWPHeZP+MpVYMi1meE2hXiy\\/kzYvAAAAAAQABfigAAdSe4YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\",\"channel_name\":\"16393722779doA7y3rPkBWGevEoXJc3v5xa0NQmJxKCMKSzuju\"}', NULL, '2021-12-12 23:41:17', '2021-12-12 23:41:17'),
('ec686338-4f34-4ffd-9b76-db4951bf9e6c', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', NULL, '2021-12-24 23:26:30', '2021-12-24 23:26:30'),
('ecd1ce8d-e7d6-4a01-b959-3400b2f6ed01', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":17,\"user_name\":\"texttoday\",\"type\":\"new\"}', '2021-12-17 09:16:22', '2021-12-17 09:15:17', '2021-12-17 09:16:22'),
('efbac03a-ab53-4b4d-9ded-312b8a3d5b04', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"12numbrs\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-14 03:22:40', '2021-12-17 09:14:02'),
('f0e54526-a0b5-4de8-b4d2-417fc4d044ac', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-03 13:16:21', '2021-12-17 09:14:02'),
('f10233d6-3308-4f07-bbe8-653ba13dbc43', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 11:50:26', '2021-12-03 11:49:45', '2021-12-03 11:50:26'),
('f1d0dba5-d55e-4379-b873-62749f325d6c', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":8,\"member_id\":5,\"type\":\"voice\",\"message\":\"Request chat\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IAA+uOuGh9fqd5LSSFDHsIPi0qWCiDRx1KGfLNQCt7x2fkr3ZqsAAAAAQABtTAAA+Cu4YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\",\"channel_name\":\"16393734326F5EcwCI4vQ9kC8QC0xZE1OZSzu9QJgKSXAya0Pf\"}', NULL, '2021-12-13 00:00:32', '2021-12-13 00:00:32'),
('f3beda07-05a5-44e7-8dd6-a18446e58dee', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', '2021-12-17 09:13:57', '2021-12-07 06:38:38', '2021-12-17 09:13:57'),
('f4c784fa-698f-4e8c-b09d-21ff936010f6', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 9, '{\"user_id\":6,\"type\":\"request\",\"message\":\"Request sent.\"}', NULL, '2021-12-07 09:41:52', '2021-12-07 09:41:52'),
('f4eb124e-69b1-46d1-b1ac-cb51e6ed187c', 'App\\Notifications\\FriendNotification', 'App\\Models\\User', 4, '{\"user_id\":15,\"type\":\"received\",\"message\":\"Request received\"}', NULL, '2021-12-12 23:29:41', '2021-12-12 23:29:41'),
('f7c9ddee-80fc-48b3-b183-9444e81fd5db', 'App\\Notifications\\ChatAgoraNotificaions', 'App\\Models\\User', 5, '{\"user_id\":8,\"member_id\":5,\"type\":\"voice\",\"message\":\"Request chat\",\"chat_token\":\"00685cc4d7e5b824b4a931232d6ea02a078IACguxabX6AXiDCr6NSlQ+D0cgiFOWYy+roKy9hCfsAach2n9i0AAAAAQAAZowAA5iu4YQkAAQAAAAAAAgAAAAAAAwAAAAAABAAAAAAABQAAAAAABgAAAAAACgAAAAAACwAAAAAADAAAAAAA\",\"channel_name\":\"1639373414ndezIFXILydfAWzdQtQJJrN0z5FAjSj606X9hnMD\"}', NULL, '2021-12-13 00:00:14', '2021-12-13 00:00:14'),
('f7fdb38e-de05-4121-baa4-7e58cfb81796', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":10,\"user_name\":\"cpatel\",\"type\":\"new\"}', '2021-12-17 09:14:15', '2021-12-07 11:49:23', '2021-12-17 09:14:15'),
('f8ab05c9-c4ea-497f-8a7a-8cc0206511fa', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-11 01:00:09', '2021-12-11 01:00:09'),
('f93bf2d3-4ea9-4d3e-84ab-67710c005c2a', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 08:55:03', '2021-12-03 06:42:37', '2021-12-03 08:55:03'),
('f9bb02c1-92f1-463a-865d-fdb4e11777ed', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":8,\"user_name\":\"sandip123\",\"type\":\"new\"}', '2021-12-17 09:14:19', '2021-12-07 08:25:17', '2021-12-17 09:14:19'),
('fa985a4a-0c98-4857-9e06-2cb5816a87fd', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":5,\"user_name\":\"bhavesh1234\",\"type\":\"new\"}', NULL, '2021-12-23 22:20:09', '2021-12-23 22:20:09'),
('fb46c1e7-bfd3-46d6-9df6-d080a053f5fb', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":6,\"user_name\":\"userapi123\",\"type\":\"new\"}', NULL, '2021-12-27 22:45:04', '2021-12-27 22:45:04'),
('fbc8c0e6-7767-4bbd-acdc-bb2a3658bada', 'App\\Notifications\\LikeNotification', 'App\\Models\\User', 6, '{\"user_id\":4,\"post_id\":5,\"type\":\"like\",\"message\":\"Liked on your post\"}', NULL, '2021-12-10 01:13:25', '2021-12-10 01:13:25'),
('ffc8ab50-cb99-4621-be57-9b83fa91129a', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"name154\",\"type\":\"new\"}', '2021-12-03 11:51:12', '2021-12-03 11:51:09', '2021-12-03 11:51:12'),
('fffd199b-8ac7-42d0-8ce4-68eea9a39ea3', 'App\\Notifications\\UserNewAdd', 'App\\Models\\User', 1, '{\"user_id\":2,\"user_name\":\"12numbrs\",\"type\":\"new\"}', '2021-12-17 09:14:02', '2021-12-14 03:12:54', '2021-12-17 09:14:02');

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
('00b3275aa1e03183a0e14c98e561a0702575fb17abaa3072c4877fbd21fa9397101bb0cb583a5bcb', 9, 1, 'API Token', '[]', 0, '2021-12-07 09:41:16', '2021-12-07 09:41:16', '2022-12-07 15:11:16'),
('0265df4d58af7b2954ec73228df0eefe36a3fd2817e41f8152213f82abb279480130d9b6c6d10eca', 5, 1, 'API Token', '[]', 0, '2021-12-10 22:36:12', '2021-12-10 22:36:12', '2022-12-11 04:06:12'),
('04b4eb9c639aae1e3e132586556151a70fa8c7783f7b97ff0382718e3dbf4582b07d8512b6ec1272', 5, 1, 'API Token', '[]', 0, '2021-12-23 23:55:29', '2021-12-23 23:55:29', '2022-12-24 05:25:29'),
('05117e740a576be2d0cf78b54b016721f51b775eff7b85340ab8e2204abd44607e89167c9f0ec4bf', 5, 1, 'API Token', '[]', 0, '2021-12-26 22:54:11', '2021-12-26 22:54:11', '2022-12-27 04:24:11'),
('0700ba05be913eea25f8dbf9277bd86e2ce43e2fdc327f1902ca96dee20e15cdba21541fd52dc197', 5, 1, 'API Token', '[]', 0, '2021-12-24 00:01:16', '2021-12-24 00:01:16', '2022-12-24 05:31:16'),
('073b678ddcbd916865d8200543226941687b38e54cac1e37d26bf686ba9c0978a889277016d2e9c0', 5, 1, 'API Token', '[]', 0, '2021-12-30 02:35:05', '2021-12-30 02:35:05', '2022-12-30 08:05:05'),
('075fe7c33930bb0cdb2e9fb17cdc413a6d65c981024177a638acbbfbfeb758780c0212c1f5727224', 2, 1, 'API Token', '[]', 0, '2021-12-08 23:56:01', '2021-12-08 23:56:01', '2022-12-09 05:26:01'),
('07b004e096e31e284fdf5e5e42a5a381363ba722241a3841e5249f9ef8dd678a4b9d821ce08b7aa6', 6, 1, 'API Token', '[]', 0, '2021-12-12 22:34:36', '2021-12-12 22:34:36', '2022-12-13 04:04:36'),
('07b7fdeb6cfe69d47d2679ee30a10e9e744850918e4db7b4e752d2d99c7a4e5efba89e293e6240a8', 6, 1, 'API Token', '[]', 0, '2021-12-10 01:12:39', '2021-12-10 01:12:39', '2022-12-10 06:42:39'),
('088f60e920d74c5c3684502c38682287f5396b23638f360e983f9db775eaacb7b2c606d4b4cbd148', 8, 1, 'API Token', '[]', 0, '2021-12-14 03:08:28', '2021-12-14 03:08:28', '2022-12-14 08:38:28'),
('0892e49bdbe5a8a05d02080d31140579e4bed8c642aad4f129538813ebf709740c8fa5918e97f327', 6, 1, 'API Token', '[]', 0, '2021-12-28 00:06:45', '2021-12-28 00:06:45', '2022-12-28 05:36:45'),
('0963dd040bb7706caabb250ba717c092593e1c710b2c1a5854479a82c6ef932fd353f8b0c6a3df97', 6, 1, 'API Token', '[]', 0, '2021-12-10 02:25:38', '2021-12-10 02:25:38', '2022-12-10 07:55:38'),
('0a2082e672246586304cbd6a87df32cc1021673727e54e89fcfa3bf587b76f7345d33fd83defd599', 2, 1, 'API Token', '[]', 0, '2021-12-08 23:52:25', '2021-12-08 23:52:25', '2022-12-09 05:22:25'),
('0b3a7abb300296791443135fb9e65300a011948bee5a8ba26a1b46b369e0b06a51eaa46f8fc51dc3', 5, 1, 'API Token', '[]', 0, '2021-12-30 01:26:14', '2021-12-30 01:26:14', '2022-12-30 06:56:14'),
('0c3e31b9f9f4a1d37268f5bd3f57f6a12a6edb1c1246b33bbd3f48ed3f2185fff42409aadab6f226', 8, 1, 'API Token', '[]', 0, '2021-12-07 08:25:17', '2021-12-07 08:25:17', '2022-12-07 13:55:17'),
('0ca7b4f0c7db60d2592044c87574d0ac3636c75116ef859c7bf3bdee709d81aae4960d319b1f045a', 8, 1, 'API Token', '[]', 0, '2021-12-14 03:34:50', '2021-12-14 03:34:50', '2022-12-14 09:04:50'),
('0ea481c403f1f366d26f1b82466bd1b58cbc10c6ca4ed33213b7c47811ae9a15288e077fc667df44', 5, 1, 'API Token', '[]', 0, '2021-12-10 01:04:44', '2021-12-10 01:04:44', '2022-12-10 06:34:44'),
('0efa38e0f5c5d8b12e8263fcf2b0210d9daee04c068c564de60849371d79b3a71a4056764417870b', 15, 1, 'API Token', '[]', 0, '2021-12-22 06:01:25', '2021-12-22 06:01:25', '2022-12-22 11:31:25'),
('101032ecd8d2c439bfd78b985053c18cdfdf3df47dcf5c9159f5ecc1fa277fa62aea3c2559dfc031', 6, 1, 'API Token', '[]', 0, '2021-12-12 22:34:26', '2021-12-12 22:34:26', '2022-12-13 04:04:26'),
('102ab092e117c45543fddf5556d043bfe2fe2c72ba295d2ad7495f45b0a1ed1b41ab21da9355e1d6', 5, 1, 'API Token', '[]', 0, '2021-12-07 06:38:38', '2021-12-07 06:38:38', '2022-12-07 12:08:38'),
('140b90614777c490efc8e9c569318d40e9fcf5462d0558f3d0ca7317035439bae5a031f98b4f9b0c', 15, 1, 'API Token', '[]', 0, '2021-12-15 05:19:53', '2021-12-15 05:19:53', '2022-12-15 10:49:53'),
('16cf9b41032a93fac3e8b9d06ea7a8f2c2422c439a0daf3c92a8c044daa6a0c5a64c58a36c8f8fb7', 6, 1, 'API Token', '[]', 0, '2021-12-10 01:28:48', '2021-12-10 01:28:48', '2022-12-10 06:58:48'),
('16e677eeb1f3573a754ff72c6a13906776781d8a98983914fd036982f950f6332ed1a8f22ed40c8c', 12, 1, 'API Token', '[]', 0, '2021-12-09 22:37:30', '2021-12-09 22:37:30', '2022-12-10 04:07:30'),
('17607b5aa77dcfedf5182f04a5729ec095694f23573fa34f02ccafdbf003ad8e9a400b359dd3956f', 5, 1, 'API Token', '[]', 0, '2021-12-07 06:42:49', '2021-12-07 06:42:49', '2022-12-07 12:12:49'),
('187e5abae614cda70c512b989f68884e57bd480446c41f2beb2484d74ea42a85562684080e976ea7', 5, 1, 'API Token', '[]', 0, '2021-12-21 22:21:43', '2021-12-21 22:21:43', '2022-12-22 03:51:43'),
('18a26b778c116a09071ff9e746011e9bd8d2fc1e19d4e777e03b6f7ea1b855cf310ac7096435dcc3', 15, 1, 'API Token', '[]', 0, '2021-12-15 05:15:18', '2021-12-15 05:15:18', '2022-12-15 10:45:18'),
('191eb82bc86815d117f7ec4a41d74cf9e56ea68dc1e494da77befdd070961009d875bb276de4514f', 2, 1, 'API Token', '[]', 0, '2021-12-06 08:41:33', '2021-12-06 08:41:33', '2022-12-06 14:11:33'),
('19d6aff26ab65b4fc21ecfb018d843e4a03ae231a33224ea8574feb9ef7baec13609bdec5973f490', 12, 1, 'API Token', '[]', 0, '2021-12-09 01:28:49', '2021-12-09 01:28:49', '2022-12-09 06:58:49'),
('1a90fd888ef27c462b6aa52ba60a9054e00fee98c9e4add78f8fbda56dabe9b63875633885cc078c', 8, 1, 'API Token', '[]', 0, '2021-12-20 00:18:22', '2021-12-20 00:18:22', '2022-12-20 05:48:22'),
('1aa9feb46af363b8c46c1b22ac467e0a8d01215412e6f9c1bb16eeba2ad1200939e0ebbf3606cef3', 4, 1, 'API Token', '[]', 0, '2021-12-07 10:20:57', '2021-12-07 10:20:57', '2022-12-07 15:50:57'),
('1b5a66e3df3495e14cca36fcf95616893e5e128b41846a27864203a2bb590494d1133c8027cbd368', 12, 1, 'API Token', '[]', 0, '2021-12-09 01:30:35', '2021-12-09 01:30:35', '2022-12-09 07:00:35'),
('1cbe4bdbc60059b31163ff12881a2b7c5e41726b07c25975dfc26fb5f1c002589adcaa46e9d45568', 7, 1, 'API Token', '[]', 0, '2021-12-06 13:33:59', '2021-12-06 13:33:59', '2022-12-06 19:03:59'),
('1cbf292a0fe09e5aad54b47633e4c1e28058ffa2677c29119029c2ee3eedcb3b2329e2f170f176af', 15, 1, 'API Token', '[]', 0, '2021-12-15 05:15:36', '2021-12-15 05:15:36', '2022-12-15 10:45:36'),
('2048e90501e498ac6735842981c9ecc764e3d44b5197493197d16e0981a4ee3443b7802af7952311', 2, 1, 'API Token', '[]', 0, '2021-12-07 06:45:36', '2021-12-07 06:45:36', '2022-12-07 12:15:36'),
('21d5114aa3e9233a2c916a40d7f521d53c5fc75b9c4c89a9da0db520294d796c048a2cd3d86bd204', 7, 1, 'API Token', '[]', 0, '2021-12-06 13:34:12', '2021-12-06 13:34:12', '2022-12-06 19:04:12'),
('23325f8b383e5b6e54d58874544dfbdb37101157d1024d4886650e8314c87dc64b7149ea37105c5c', 8, 1, 'API Token', '[]', 0, '2021-12-24 23:00:16', '2021-12-24 23:00:16', '2022-12-25 04:30:16'),
('2584dfaae19670ef8843c6f8725d4edd86003e43cd28f8a2190f1bc520e17d943b6b88e46f123214', 5, 1, 'API Token', '[]', 0, '2021-12-06 11:11:07', '2021-12-06 11:11:07', '2022-12-06 16:41:07'),
('25ef057cf9337533b8347084226563b4c870746f5961d28f7f125cd459d7a02f17d2f9ca27e61203', 17, 1, 'API Token', '[]', 0, '2021-12-17 09:09:32', '2021-12-17 09:09:32', '2022-12-17 14:39:32'),
('26326269c983dd3b660e5405b009300083b8276b0906892dd0f3e7a634c1554a0a0d127837fb78c3', 5, 1, 'API Token', '[]', 0, '2021-12-06 11:11:26', '2021-12-06 11:11:26', '2022-12-06 16:41:26'),
('267726c41713d78d0a1738eca9bef9a6f356e671e530b977c3d66c40079e805f36ce17882cad4556', 5, 1, 'API Token', '[]', 0, '2021-12-07 11:50:11', '2021-12-07 11:50:11', '2022-12-07 17:20:11'),
('268a72cebb39d32d8f589a3add03b48112c24fc778ac1f6b8a973820709acc51ee7d9a84ab0ac4a0', 6, 1, 'API Token', '[]', 0, '2021-12-20 00:20:49', '2021-12-20 00:20:49', '2022-12-20 05:50:49'),
('27a2918a1cc36161b1557715d1fc21a915aef7ad2369448ce477eb4386c97c0079ea7d2349907504', 5, 1, 'API Token', '[]', 0, '2021-12-24 00:01:01', '2021-12-24 00:01:01', '2022-12-24 05:31:01'),
('286226c600e9e8b0b4d13da8374b129f33f617e0f372315c4602057527574156c9a29ef70bc37585', 8, 1, 'API Token', '[]', 0, '2021-12-15 03:22:07', '2021-12-15 03:22:07', '2022-12-15 08:52:07'),
('28851d7f43f4acb4d57c07f660fab6a94bf602b7693852d85d653be4448c572722f50a94aeefc9d4', 8, 1, 'API Token', '[]', 0, '2021-12-09 23:46:32', '2021-12-09 23:46:32', '2022-12-10 05:16:32'),
('293db8cc90fd48814c70bd77aa6a8f2bb6d4044d992205080017e8139a0d821fe3faaa34ce24d493', 5, 1, 'API Token', '[]', 0, '2021-12-06 06:29:56', '2021-12-06 06:29:56', '2022-12-06 11:59:56'),
('298423ea18fcd69f4cfb7b9698ded4895ca7e10fb53c85c63950e89f1a759f76fa3639e162a9f9a9', 6, 1, 'API Token', '[]', 0, '2021-12-10 01:09:23', '2021-12-10 01:09:23', '2022-12-10 06:39:23'),
('29d88b3bb7a1e361fe9fce89fd53d694d1b08fc140bda37a9db0d20f805002602e5362782ca3b2b5', 5, 1, 'API Token', '[]', 0, '2021-12-30 00:55:46', '2021-12-30 00:55:46', '2022-12-30 06:25:46'),
('2a59a53e0e2670524dd29c10ba5444f44c1639c7baa16810b3c14c35af6d2c4a001edf806e22188f', 6, 1, 'API Token', '[]', 0, '2021-12-07 09:57:09', '2021-12-07 09:57:09', '2022-12-07 15:27:09'),
('2a98efc38828e25ea8b8cf301624971bc5ce79d269182e19876eda52bf89a6b076c5f7ac89fef86e', 5, 1, 'API Token', '[]', 0, '2021-12-09 01:15:24', '2021-12-09 01:15:24', '2022-12-09 06:45:24'),
('2c52d0bbe8fc367c7c5ebb5f450feecac16940ca9569f5b7c9e259e77a856cf7385d754f0075fd26', 6, 1, 'API Token', '[]', 0, '2021-12-10 01:58:29', '2021-12-10 01:58:29', '2022-12-10 07:28:29'),
('2f1aa7f2827e2968e4b3610da935da8513fd1ac0c78b7b543c52f38db38d3ad8ef19d64975717a47', 14, 1, 'API Token', '[]', 0, '2021-12-12 23:20:55', '2021-12-12 23:20:55', '2022-12-13 04:50:55'),
('2ff784e8733046b82cc7f17f10af3a6e742580cd4fec8c09f66d8e07752a1cc1482a6148e4ac1d9c', 6, 1, 'API Token', '[]', 0, '2021-12-20 00:21:06', '2021-12-20 00:21:06', '2022-12-20 05:51:06'),
('3169c3d788b65df64ca4cbfc46e59a1957a3e31abc22d44adc5b3d4fde32c0d321d1a5b6cbf8de20', 8, 1, 'API Token', '[]', 0, '2021-12-20 01:56:00', '2021-12-20 01:56:00', '2022-12-20 07:26:00'),
('318020f3a293dfbca15a4a1d2a81e195159a46d944cc31398f2999afbb28bc7ccd953c07dde9e8aa', 5, 1, 'API Token', '[]', 0, '2021-12-24 22:43:49', '2021-12-24 22:43:49', '2022-12-25 04:13:49'),
('3432879baed638b3bd2207d5b3b8db39b5b7e03fd405d6390bb0cdbd4ba9789cec84b6c4baeb9bb1', 5, 1, 'API Token', '[]', 0, '2021-12-07 10:44:22', '2021-12-07 10:44:22', '2022-12-07 16:14:22'),
('3566da82bdf4b58cf8807d70566b34a5266aac044954e874e0196ab6144567d5921d27bd70cdc659', 6, 1, 'API Token', '[]', 0, '2021-12-07 05:44:05', '2021-12-07 05:44:05', '2022-12-07 11:14:05'),
('39ca8cc328f23e59e3bcf4350283618d04f0334645fe9a9098d2d1097eebf911ddf24a14b2a9a7f9', 2, 1, 'API Token', '[]', 0, '2021-12-08 23:52:32', '2021-12-08 23:52:32', '2022-12-09 05:22:32'),
('3a4c8c85f4266b885c0228588e5d8655985ac1980c7f136cafca55f54a82e7c3a26e1058b41cea29', 8, 1, 'API Token', '[]', 0, '2021-12-19 23:55:38', '2021-12-19 23:55:38', '2022-12-20 05:25:38'),
('3b6694ca557ff42189520044811061c7d56f0c372586e7e108c9136b6a395303407232c29c385cb9', 7, 1, 'API Token', '[]', 0, '2021-12-06 16:06:50', '2021-12-06 16:06:50', '2022-12-06 21:36:50'),
('3e6d1985bad02a5f55754cfd425848b7eb5b6feab99bc8be3ed0fe5a7421f466ab336e600c86666c', 12, 1, 'API Token', '[]', 0, '2021-12-09 22:39:09', '2021-12-09 22:39:09', '2022-12-10 04:09:09'),
('3eb7b167657c897bb5e56f12ac292de43f2ddf0e1c3d83cacda557e97b432716f0a31b4b110e8eb1', 17, 1, 'API Token', '[]', 0, '2021-12-17 09:09:09', '2021-12-17 09:09:09', '2022-12-17 14:39:09'),
('3ec827795dabd65ceeeb4dda3d0f61e4ff50ab9d0f4d21d82f314761b820ce8f30692dba142d128d', 5, 1, 'API Token', '[]', 0, '2021-12-10 00:51:18', '2021-12-10 00:51:18', '2022-12-10 06:21:18'),
('4037b992233d183274c5dd61f726d3b83fc3ec17e7ef84524ac76af5609566b1578b297a959e4ca8', 5, 1, 'API Token', '[]', 0, '2021-12-30 00:55:20', '2021-12-30 00:55:20', '2022-12-30 06:25:20'),
('411578717d0c98f02ad62a99a10689241e41f727235ac740d44f4d86894ec452c17dddcc90d326b3', 5, 1, 'API Token', '[]', 0, '2021-12-20 00:19:58', '2021-12-20 00:19:58', '2022-12-20 05:49:58'),
('42081951337804a8a8acc0b5469b0103c4b662953a879894993c1cafd8781f0b5f4ffc57af229d52', 6, 1, 'API Token', '[]', 0, '2021-12-27 06:16:05', '2021-12-27 06:16:05', '2022-12-27 11:46:05'),
('44f4b680b4685b9af0ca188eeef106fceb8c047d2886c8fe266a4903ed4517a93e893deee3f2bc0e', 5, 1, 'API Token', '[]', 0, '2021-12-19 23:17:17', '2021-12-19 23:17:17', '2022-12-20 04:47:17'),
('45aef161f6f7dbb8949b61b37fb67fee92b62d1197ad73ba26425ef3b40f841706a8a5d8470024e7', 17, 1, 'API Token', '[]', 0, '2021-12-17 09:15:17', '2021-12-17 09:15:17', '2022-12-17 14:45:17'),
('486cdcfe671c719efe994e45f49da15a76133900badcbb78dfda6ba0e60bc4b321f222420e33cdd1', 5, 1, 'API Token', '[]', 0, '2021-12-27 06:28:50', '2021-12-27 06:28:50', '2022-12-27 11:58:50'),
('49c7ae316cd9de74022ab588477a178e52b0913d229977684a920d8fa9aae05b57e86f8983989977', 6, 1, 'API Token', '[]', 0, '2021-12-27 22:44:43', '2021-12-27 22:44:43', '2022-12-28 04:14:43'),
('49fbe040d28febea3d9d0087c0fc0d515a83ec84b3a2e306b5d6d29a2bc17b15867e0984dc7328de', 6, 1, 'API Token', '[]', 0, '2021-12-07 10:22:53', '2021-12-07 10:22:53', '2022-12-07 15:52:53'),
('4aa3a862e999a0423101def108dbde4714c2960d391a5ad273317ba6185969c38d89ce0a9268f228', 8, 1, 'API Token', '[]', 0, '2021-12-24 22:59:59', '2021-12-24 22:59:59', '2022-12-25 04:29:59'),
('4b5200af0b786952dbfa8431baf55ab6c5a3335ca7b9d4a8e6026a0399f403aec98c5d1e831e4f5a', 6, 1, 'API Token', '[]', 0, '2021-12-10 01:57:59', '2021-12-10 01:57:59', '2022-12-10 07:27:59'),
('4bc4edeca571bd46052471d2c594c27c4941edadc5930f15180fdb5c59d15a04aa42fa28b0c8a692', 5, 1, 'API Token', '[]', 0, '2021-12-10 01:05:01', '2021-12-10 01:05:01', '2022-12-10 06:35:01'),
('4f207ad034aeb78b9c856430c20355361a7910571583c8380c48441b07c928fb46098c16177deeb1', 5, 1, 'API Token', '[]', 0, '2021-12-10 22:36:43', '2021-12-10 22:36:43', '2022-12-11 04:06:43'),
('54435d87d0d988735136b04c1e94bc7e6d1c48f244c3a4ccced692a3092820d1e610038b69cbee3f', 8, 1, 'API Token', '[]', 0, '2021-12-20 00:44:42', '2021-12-20 00:44:42', '2022-12-20 06:14:42'),
('54d20ff4c5e5f4f692ef58ab4c176272b7cdee816eb19c49d1dcbedd1d9f9f4b1111187163e6d21d', 4, 1, 'API Token', '[]', 0, '2021-12-21 04:26:24', '2021-12-21 04:26:24', '2022-12-21 09:56:24'),
('55ad8881fb9aee522bf9f927c53efdfcc005e230ad7b42e229106c824903491217a62c1a10021964', 5, 1, 'API Token', '[]', 0, '2021-12-26 22:53:53', '2021-12-26 22:53:53', '2022-12-27 04:23:53'),
('55b120ac35a6c8c59133e6459ba632f23ceebbe988c3e47c02ef5f9a166fbf721e23a1a0f2bc6c59', 5, 1, 'API Token', '[]', 0, '2021-12-07 06:38:23', '2021-12-07 06:38:23', '2022-12-07 12:08:23'),
('566e51f35476557045e5a5c2010a7c60d38180084dec3c17e43f0accd5cc84044761f729f86475a6', 6, 1, 'API Token', '[]', 0, '2021-12-12 23:22:44', '2021-12-12 23:22:44', '2022-12-13 04:52:44'),
('56e411abb2865d6228e9f311d0aa8bbdc0609fb98de05b2d5b5968dc01109aa2173ad868cbd5a663', 4, 1, 'API Token', '[]', 0, '2021-12-21 04:21:10', '2021-12-21 04:21:10', '2022-12-21 09:51:10'),
('57376eb587ea7a2d67ae2d240ab8421bd72fc4089168d065c0beac7917a5ba5bd335b59423e0a864', 5, 1, 'API Token', '[]', 0, '2021-12-07 03:44:43', '2021-12-07 03:44:43', '2022-12-07 09:14:43'),
('57b9cb6c5f09865d793c666bdaadcb0612bbd96602ae4e75a84951f53a9be80c78c5f338d941b804', 6, 1, 'API Token', '[]', 0, '2021-12-10 02:25:21', '2021-12-10 02:25:21', '2022-12-10 07:55:21'),
('5ccd4f5444fc5677ba45d9f3193ebbe16d8db834f3d7952e330cfa3db73bd849a9b5c7becb28c9ca', 5, 1, 'API Token', '[]', 0, '2021-12-12 23:29:34', '2021-12-12 23:29:34', '2022-12-13 04:59:34'),
('5d1a422049fc1619c70185e3dbc279d7352a901134f09d050b867d5445922e47a5d68ea9399de633', 8, 1, 'API Token', '[]', 0, '2021-12-14 03:37:45', '2021-12-14 03:37:45', '2022-12-14 09:07:45'),
('5e2f8b25aee16372bc259990767fe8d8254e112f9c319de760aead1fdd0ca9e6f1491b249d78f1bb', 5, 1, 'API Token', '[]', 0, '2021-12-07 04:02:46', '2021-12-07 04:02:46', '2022-12-07 09:32:46'),
('61fc7e2664f740d6e00f6894b7672db906abe76bcb614fe44292cf303eb0c2bb064f0016196a42cb', 5, 1, 'API Token', '[]', 0, '2021-12-07 04:02:31', '2021-12-07 04:02:31', '2022-12-07 09:32:31'),
('665ced95290e7f3e6e63edf9e1ae34dc7fb3f4b4f31f3166afac41285cb41978b4eb6adb40144d2f', 15, 1, 'API Token', '[]', 0, '2021-12-12 23:25:28', '2021-12-12 23:25:28', '2022-12-13 04:55:28'),
('66be9a6e3e00ee1312ec92e5f9411e973850f0e49a36e307b72e55da0175f2ba3c65501b5e9377ae', 2, 1, 'API Token', '[]', 0, '2021-12-17 00:50:23', '2021-12-17 00:50:23', '2022-12-17 06:20:23'),
('6706f27730bc1269c49f7abfaa69e9848e613c2b48f7044583b315e913c6610550f68bcc3295705e', 8, 1, 'API Token', '[]', 0, '2021-12-14 03:09:11', '2021-12-14 03:09:11', '2022-12-14 08:39:11'),
('6960b62a42494457ca39ae7d07ae140cf37ead3983f13affc491eb3ecf73c0dc9a1db24c3b854aa2', 5, 1, 'API Token', '[]', 0, '2021-12-20 00:36:46', '2021-12-20 00:36:46', '2022-12-20 06:06:46'),
('6a8f625a93c9b6806d5cc627e52275fc1eec4817588339cf03b696cbe2f2f278fe4c0db5d38070ce', 7, 1, 'API Token', '[]', 0, '2021-12-06 16:07:12', '2021-12-06 16:07:12', '2022-12-06 21:37:12'),
('6b7ad6e672c261dc52a560f344fc28292ee52f05596d48ed4839cf5341714539acc6fca1e4e098f4', 6, 1, 'API Token', '[]', 0, '2021-12-17 04:21:44', '2021-12-17 04:21:44', '2022-12-17 09:51:44'),
('6daf752631dd83a9351ee7de497e592efdfd48c08f489bc493bfe6d1f25d8a0fce5f98f29d5370f2', 6, 1, 'API Token', '[]', 0, '2021-12-12 23:14:08', '2021-12-12 23:14:08', '2022-12-13 04:44:08'),
('6fb87f09e276ea1a9068347b6bd80b4a53d681d36a1f3487c1193a3d506be260fa50d0579de87c13', 6, 1, 'API Token', '[]', 0, '2021-12-12 22:33:54', '2021-12-12 22:33:54', '2022-12-13 04:03:54'),
('7185391fccdafd987959589413368f820947a474ff38df136893a6a1c6b91ee8de8248372ca95e40', 5, 1, 'API Token', '[]', 0, '2021-12-24 23:26:30', '2021-12-24 23:26:30', '2022-12-25 04:56:30'),
('758dfeb443d3212af5c9a332ffe04fd2b7ddc6ddca26e3fdf46cfdecbba11c96d145aeef194dbaf7', 2, 1, 'API Token', '[]', 0, '2021-12-07 06:44:49', '2021-12-07 06:44:49', '2022-12-07 12:14:49'),
('77e43513ac3a4fe1dbad8cbd7f04782d037271daa3cdd943a778f739d7bf2dbcf009ae71fee90098', 6, 1, 'API Token', '[]', 0, '2021-12-28 00:07:13', '2021-12-28 00:07:13', '2022-12-28 05:37:13'),
('77eb0936e17ec67f6ebcf75518ac289425cadf180270cedcbae14d4a5663b7f9314e1cbed59ab303', 9, 1, 'API Token', '[]', 0, '2021-12-07 08:30:21', '2021-12-07 08:30:21', '2022-12-07 14:00:21'),
('787c7ee7615f173de933732f18c9ada0ac3b0ff95f1a0478b3c244a802bc321fed61c4cd3d23106f', 5, 1, 'API Token', '[]', 0, '2021-12-23 23:55:08', '2021-12-23 23:55:08', '2022-12-24 05:25:08'),
('787ea049bc3a6dbb5791b884614f73cc98389db78ff6bdfb8465d211385802181856d4cfe9caa9f9', 12, 1, 'API Token', '[]', 0, '2021-12-09 22:38:33', '2021-12-09 22:38:33', '2022-12-10 04:08:33'),
('78cc85cf9e1fac7273bec4c5cca1df6ea1443c999d23716121203badacf4ff66872fc7965530f745', 6, 1, 'API Token', '[]', 0, '2021-12-27 06:14:50', '2021-12-27 06:14:50', '2022-12-27 11:44:50'),
('793820acf85003ea21cdec81c2916daefbf0611cd518556ad6a91c1472dae45109e51f845c91d50f', 17, 1, 'API Token', '[]', 0, '2021-12-17 09:15:24', '2021-12-17 09:15:24', '2022-12-17 14:45:24'),
('7a815e30a15633778544c66ce43831754a64e56e8a0991ecf5518ca8d0d5972b4478d636cd4727b2', 2, 1, 'API Token', '[]', 0, '2021-12-06 10:23:19', '2021-12-06 10:23:19', '2022-12-06 15:53:19'),
('7c6084a351466c05c7ce3dd43cecd355c4920b96778650f0d03b54906299008d45c267c6ff8e3482', 5, 1, 'API Token', '[]', 0, '2021-12-07 08:31:37', '2021-12-07 08:31:37', '2022-12-07 14:01:37'),
('7e270c8ca65a42745cd89b0b59fe37fe07c88509ea3ba5fa4e47af70a799eb074f4f6d3e90793844', 2, 1, 'API Token', '[]', 0, '2021-12-10 00:58:45', '2021-12-10 00:58:45', '2022-12-10 06:28:45'),
('7e99282994ab421ac4a9daad8a6ba4109987f3c6bc4fe37c917c7345435526dd8e01ec3ca4d14200', 8, 1, 'API Token', '[]', 0, '2021-12-14 03:25:29', '2021-12-14 03:25:29', '2022-12-14 08:55:29'),
('7fc6f717400dd8b19c61ba467c5ca8745330c7adcccf579d9560f43c470a6c7828b39c55fd187798', 6, 1, 'API Token', '[]', 0, '2021-12-12 23:37:20', '2021-12-12 23:37:20', '2022-12-13 05:07:20'),
('811b37450f86536f572b57eda235c1be2f0c21f00c0d1b3cca412326195838d6cd43fae3e828abed', 5, 1, 'API Token', '[]', 0, '2021-12-23 22:19:52', '2021-12-23 22:19:52', '2022-12-24 03:49:52'),
('817a24c0b734f409f192dc19f19885d6a8583be439df890863349455d0b2ee4d2ec2a55d37fe3cc8', 8, 1, 'API Token', '[]', 0, '2021-12-09 23:46:49', '2021-12-09 23:46:49', '2022-12-10 05:16:49'),
('8332c8948e17c411cc137efb2c1148c8870bd9adc652cd2fe7ab01db6efa55f84913c2f848608d7e', 5, 1, 'API Token', '[]', 0, '2021-12-06 06:29:39', '2021-12-06 06:29:39', '2022-12-06 11:59:39'),
('8388fab77c0d6f3ad314581b3f4cdc0e05843744a4a5a1ad044f45ccd204bd0d72a74148ca6d86d0', 5, 1, 'API Token', '[]', 0, '2021-12-19 23:49:46', '2021-12-19 23:49:46', '2022-12-20 05:19:46'),
('858e43adc9a3c6106c198a1934c29072b3a250e87fd7cc1eee6a087dc263de36b953659fee861b8a', 6, 1, 'API Token', '[]', 0, '2021-12-22 06:08:13', '2021-12-22 06:08:13', '2022-12-22 11:38:13'),
('887201276d8be2e5aa9bb20497e7622215bc989ae3243bd3ade1b0fce88e2b845b6a94bbbbc797c7', 8, 1, 'API Token', '[]', 0, '2021-12-19 23:55:53', '2021-12-19 23:55:53', '2022-12-20 05:25:53'),
('8adb1bab2058bfd8b4d2688d0bc103683efdac838eba029bc4f732f988f9f9f02ace625f6ef29cd7', 8, 1, 'API Token', '[]', 0, '2021-12-07 09:17:42', '2021-12-07 09:17:42', '2022-12-07 14:47:42'),
('8d4c0e61e48db295069ede7dd93a5e9ed951ac88f51b2229fe461b2470e4bb9c54bd0adad573f9d3', 5, 1, 'API Token', '[]', 0, '2021-12-20 00:37:02', '2021-12-20 00:37:02', '2022-12-20 06:07:02'),
('8f8daa42cbd20a01c19889abf061d1ed5b7677e8126be58c97d8441f1a85463fa77cf5d262dab214', 4, 1, 'API Token', '[]', 0, '2021-12-07 10:21:25', '2021-12-07 10:21:25', '2022-12-07 15:51:25'),
('90bffb0afdf6627e255e33708a5571077fdfbf0fde966d332b9f373dc91554e04e6f43ae557753b9', 6, 1, 'API Token', '[]', 0, '2021-12-30 22:33:24', '2021-12-30 22:33:24', '2022-12-31 04:03:24'),
('90d6871aef7c012d77437806a8fccd54c7e8dbd488640f0fc489008fff9c9672363ebff90e08129b', 17, 1, 'API Token', '[]', 0, '2021-12-17 09:09:43', '2021-12-17 09:09:43', '2022-12-17 14:39:43'),
('9249e688b09f8e064cf52053ee2d33a594fc54136b174de880f794af62127fa706feb2526e76cc86', 17, 1, 'API Token', '[]', 0, '2021-12-17 09:15:10', '2021-12-17 09:15:10', '2022-12-17 14:45:10'),
('925790e20a8d17f40618bb9a19bfd9d0af5f42b65fe988f02b93fe196e4874431091425d22b67a99', 9, 1, 'API Token', '[]', 0, '2021-12-14 03:11:33', '2021-12-14 03:11:33', '2022-12-14 08:41:33'),
('92fcb428f1a6e3521eb70e447664401b98ed9b0e8b9e8b30c8c1ac813c4f6cf32cacacade2660af7', 9, 1, 'API Token', '[]', 0, '2021-12-07 09:41:41', '2021-12-07 09:41:41', '2022-12-07 15:11:41'),
('931ec42eddf490ddb4d4ef93dccacb80005ed366559d55490b6c94c6f83b2491795d6105171bb178', 9, 1, 'API Token', '[]', 0, '2021-12-09 04:11:47', '2021-12-09 04:11:47', '2022-12-09 09:41:47'),
('9406f88589326ee831b0d3360add51c3b7c3ff6e6ac7b42bd7b94f7a817938fcc2db46ae01597e73', 2, 1, 'API Token', '[]', 0, '2021-12-06 08:41:07', '2021-12-06 08:41:07', '2022-12-06 14:11:07'),
('95f905ebf92ec25dc84d14c533bf9306040094e5026c9b1fe42a20303e7724d1d567e777037fa2c7', 6, 1, 'API Token', '[]', 0, '2021-12-10 01:13:14', '2021-12-10 01:13:14', '2022-12-10 06:43:14'),
('9608167b1148e495604d078309a0a4789f142e8d41bd40f0701b11e11848b67d05e49ab75a125975', 6, 1, 'API Token', '[]', 0, '2021-12-07 09:55:44', '2021-12-07 09:55:44', '2022-12-07 15:25:44'),
('9623c7b74401c6403da6618eb95a5a357ef2fe2b794c372014d8a870170ac9e4501ec436b34c1e00', 6, 1, 'API Token', '[]', 0, '2021-12-07 05:43:33', '2021-12-07 05:43:33', '2022-12-07 11:13:33'),
('97628f3c564d5ba9621e879e1c1d128874724741da0ac117985971d9cb1ed881af211eb7cae33778', 5, 1, 'API Token', '[]', 0, '2021-12-23 22:20:09', '2021-12-23 22:20:09', '2022-12-24 03:50:09'),
('984bfeafc16418e76ad54e2f51b3b13bd8433fbd4c116fb1e03d505b4615559d546b5152030393b0', 8, 1, 'API Token', '[]', 0, '2021-12-14 03:08:50', '2021-12-14 03:08:50', '2022-12-14 08:38:50'),
('9b70920f977e78b825353d13a6472047aaa746dff68702da4a866af64a8ca3ffb253f7e279134ee0', 2, 1, 'API Token', '[]', 0, '2021-12-07 06:44:26', '2021-12-07 06:44:26', '2022-12-07 12:14:26'),
('9be03c65150f62e21bdb8aec3af5ddce29888c814976e9efcc717ae765551f506c324c5f0d43b482', 6, 1, 'API Token', '[]', 0, '2021-12-30 22:32:55', '2021-12-30 22:32:55', '2022-12-31 04:02:55'),
('9c63f9f10f0c7b390d85a1d45f2dffb6458e44b86ba0ba87de180b03f7fed2329f2fe6b89fb017bf', 4, 1, 'API Token', '[]', 0, '2021-12-21 04:19:55', '2021-12-21 04:19:55', '2022-12-21 09:49:55'),
('a05e42656948ff8062a614bf2a9e65f87f8ac12dd501bf9940822b3a6ace60e1115ef87ecc01f900', 5, 1, 'API Token', '[]', 0, '2021-12-07 04:00:58', '2021-12-07 04:00:58', '2022-12-07 09:30:58'),
('a31afe72de66fb097283dc4cee25ac0fd12b73e5e48f5877f6893f44525c57ae3a1acb556a26812c', 5, 1, 'API Token', '[]', 0, '2021-12-24 22:44:08', '2021-12-24 22:44:08', '2022-12-25 04:14:08'),
('a32cc3372bb887db83e52790beb738914a98a4a5efac0f0fd9f93e4fdf4b23522a283740de798fd4', 6, 1, 'API Token', '[]', 0, '2021-12-10 01:27:15', '2021-12-10 01:27:15', '2022-12-10 06:57:15'),
('a368aa6c2697d524a2a80fbb69ce46d2e4e498e0626edeb632e0a1b1da428dd1267a767f4248661f', 6, 1, 'API Token', '[]', 0, '2021-12-17 04:18:16', '2021-12-17 04:18:16', '2022-12-17 09:48:16'),
('a437d11a81f9010094516604e2c5b28a9b5fa6c46b06cdfbe53676d25adb2071c30304b2667a5947', 5, 1, 'API Token', '[]', 0, '2021-12-07 11:49:49', '2021-12-07 11:49:49', '2022-12-07 17:19:49'),
('a6757e9be0e38462777f57d8f66097912a6043acd04c2aa9272a1f5e40f49a2d4590ac649b396c8b', 8, 1, 'API Token', '[]', 0, '2021-12-07 08:25:04', '2021-12-07 08:25:04', '2022-12-07 13:55:04'),
('a774eaff74aaa06cd7414675cdc0347fa550e8d1d251a5c07fbb58be9b54f7ff89268c989bc7cf2c', 5, 1, 'API Token', '[]', 0, '2021-12-07 04:01:12', '2021-12-07 04:01:12', '2022-12-07 09:31:12'),
('ab18d35492ae7f31ffefcc3e3741597d0f9a665c3047b318e2f38d28f4a9af802aa48a3de686c0b9', 15, 1, 'API Token', '[]', 0, '2021-12-15 05:19:31', '2021-12-15 05:19:31', '2022-12-15 10:49:31'),
('abd3a0cf2e68facd88a4a2878c4772cb458ab1ccee8ec9a652bc2256cb6d3216988bb86056b2e7a8', 9, 1, 'API Token', '[]', 0, '2021-12-09 04:12:47', '2021-12-09 04:12:47', '2022-12-09 09:42:47'),
('ad4ec84e1c1ee7e0793fd31c43239314a4a8cd98dd573601976d8cfc261c58f3573eb27324bc0629', 6, 1, 'API Token', '[]', 0, '2021-12-07 10:22:14', '2021-12-07 10:22:14', '2022-12-07 15:52:14'),
('ad7febc67efeaa1097ab291baff05ebd08ebb54ee33fd0d5ae6ecee998eb90a2e6774a9b9cc1751d', 5, 1, 'API Token', '[]', 0, '2021-12-27 06:30:26', '2021-12-27 06:30:26', '2022-12-27 12:00:26'),
('ae62f3b059724edf68cd04a3442527ee8e1614e1bfa68f14e30d3f792e2d987be3734e2f7be73fd3', 8, 1, 'API Token', '[]', 0, '2021-12-07 09:18:05', '2021-12-07 09:18:05', '2022-12-07 14:48:05'),
('af0b94f70020dcfbcc358c3df557252bf7cefba9a0add12863be5c0d35e1aaf62498063d3abfe2c5', 5, 1, 'API Token', '[]', 0, '2021-12-07 03:44:25', '2021-12-07 03:44:25', '2022-12-07 09:14:25'),
('b213d8858ee80cfda5465195b81af675f6191004861d04d0bd112648d833debb1e821da2f7e14517', 2, 1, 'API Token', '[]', 0, '2021-12-08 23:36:57', '2021-12-08 23:36:57', '2022-12-09 05:06:57'),
('b2460cc129980e50e8c4b704c67be578e7b46cd74377dc9701d880928624de4bd096b7f28a239d9f', 6, 1, 'API Token', '[]', 0, '2021-12-12 23:35:32', '2021-12-12 23:35:32', '2022-12-13 05:05:32'),
('b37b627641f6dfa22cef08d56687a37ed93a976d26603223ed4d885b3fc2dc444bd699c41b5d2b1c', 9, 1, 'API Token', '[]', 0, '2021-12-14 03:11:06', '2021-12-14 03:11:06', '2022-12-14 08:41:06'),
('b3adc13a60385d1e7d75a007868a5fce290711028534aa9577182e368978ef4876e38c2df6c98eaf', 5, 1, 'API Token', '[]', 0, '2021-12-07 10:44:48', '2021-12-07 10:44:48', '2022-12-07 16:14:48'),
('b709863ece75b0ed35e9ad1d470d86d778bc541f9a1f0e74b5774d74f70fe184a84809c54372fb5c', 4, 1, 'API Token', '[]', 0, '2021-12-21 04:26:44', '2021-12-21 04:26:44', '2022-12-21 09:56:44'),
('b77c72ce333e168b1267dded2a2b29cfd740b862fe1a7f103bc0aa095133a795684fa3f98a118c42', 5, 1, 'API Token', '[]', 0, '2021-12-09 23:48:32', '2021-12-09 23:48:32', '2022-12-10 05:18:32'),
('b850529d272bf350c97686519bd5f120bf738afb16e253469a3a51fe58fe50a7a3c31ba2d580c15d', 5, 1, 'API Token', '[]', 0, '2021-12-10 00:51:52', '2021-12-10 00:51:52', '2022-12-10 06:21:52'),
('b9837e2972cff1629eebc7cad46d1a443763be264af67c9c59ae8b7b4ffb4b657021a13c6b4230c1', 6, 1, 'API Token', '[]', 0, '2021-12-27 22:45:05', '2021-12-27 22:45:05', '2022-12-28 04:15:05'),
('bb7cbd84e1b221c7f4757d4cb93b83e9808cc535317b3f4a3d94e6badfdc76e07e924d70cdc28059', 2, 1, 'API Token', '[]', 0, '2021-12-07 04:36:53', '2021-12-07 04:36:53', '2022-12-07 10:06:53'),
('bc0c8fc7b7a558449832fa704a883c4d00f6fc5ffd5d5c10aea5e7ada82090eac72754ff011e883a', 6, 1, 'API Token', '[]', 0, '2021-12-12 23:13:34', '2021-12-12 23:13:34', '2022-12-13 04:43:34'),
('bc0ff52cb1108e276ed7c3f5c0ef57f83080da07dcf34ebb2beba42a81e60378af9ebf221fa7324e', 2, 1, 'API Token', '[]', 0, '2021-12-17 00:51:25', '2021-12-17 00:51:25', '2022-12-17 06:21:25'),
('bc83aceb9ddc2cf1c057adfcbef61901358b92ac6b6f84992f08e08fae2aa41dca2446b873a9c980', 2, 1, 'API Token', '[]', 0, '2021-12-08 23:36:23', '2021-12-08 23:36:23', '2022-12-09 05:06:23'),
('bd9e8f70299694c3869586abd38bd4ff75eb021fea237ddb987ba9eed879e698d1c797b6eb2aa7bf', 5, 1, 'API Token', '[]', 0, '2021-12-07 04:28:39', '2021-12-07 04:28:39', '2022-12-07 09:58:39'),
('bdc27676e94549adad1fce4db3bb3e90fede93236668d9bdd3968a2b710109c24b83c73380acd1a2', 5, 1, 'API Token', '[]', 0, '2021-12-07 04:38:21', '2021-12-07 04:38:21', '2022-12-07 10:08:21'),
('bf795bb6d5302d622769e21b40bb9389ff40da076f97742d06ac375c6aae717a7cfa9de424021821', 6, 1, 'API Token', '[]', 0, '2021-12-07 09:57:42', '2021-12-07 09:57:42', '2022-12-07 15:27:42'),
('bf9fc416b3dee3fda934bdf8c802e5f3bbf1987520f7f1e74fd10623e8ef7fcadde60f9d53ff6016', 5, 1, 'API Token', '[]', 0, '2021-12-09 01:15:54', '2021-12-09 01:15:54', '2022-12-09 06:45:54'),
('c217d22b0affe54431eb55e32dc7391a39f4850e06f89837c06c8bcb15cc1d71b7a9f5a5baefdb6e', 5, 1, 'API Token', '[]', 0, '2021-12-12 23:24:54', '2021-12-12 23:24:54', '2022-12-13 04:54:54'),
('c2815571ad2073dad0be964366ef8424582bb4eb94c8902bd2dd2ce25ff461e12629ac4acba16ffe', 5, 1, 'API Token', '[]', 0, '2021-12-07 04:04:17', '2021-12-07 04:04:17', '2022-12-07 09:34:17'),
('c3a64d0fed0c7687b9f1fb22d1e13574a490d5b3064f13a989d47d5a4af97d49f76ccad2727bc564', 5, 1, 'API Token', '[]', 0, '2021-12-07 07:00:30', '2021-12-07 07:00:30', '2022-12-07 12:30:30'),
('c46d4ba4b29b7b2b9f84895f07a54e32bc4ec6b571d6f0f617fe41cf4dd38fdc21e4e14ad1135a97', 5, 1, 'API Token', '[]', 0, '2021-12-07 07:00:44', '2021-12-07 07:00:44', '2022-12-07 12:30:44'),
('c49e0e0bdbd5e2fd383a2dce9e16f1d5606ad52f087db770ce72fbd08c2993aaded7ecc714163529', 6, 1, 'API Token', '[]', 0, '2021-12-10 00:50:20', '2021-12-10 00:50:20', '2022-12-10 06:20:20'),
('c5b1433471cd37d0b537fd76135f88e073df040d8b0e3cad2a4a5cc0d5501ad0168551b9973f72ba', 5, 1, 'API Token', '[]', 0, '2021-12-07 04:38:35', '2021-12-07 04:38:35', '2022-12-07 10:08:35'),
('c796753b21a420fa0e9702b6cec70610d5c9863b8a8a629f4eb859e2f7928e208b2bc38ac11a8b48', 17, 1, 'API Token', '[]', 0, '2021-12-17 09:08:55', '2021-12-17 09:08:55', '2022-12-17 14:38:55'),
('c83f72b551e08ba34ddbe97e62414b1b291de89d1881f78b09481ac6e3b63eaebf604bb3e8a7dfc5', 6, 1, 'API Token', '[]', 0, '2021-12-06 12:32:07', '2021-12-06 12:32:07', '2022-12-06 18:02:07'),
('c8e555b033cd907a962fb9d3891dee3cb33f60e9bcb8674f551489fd887176f1683d6b3c25368aff', 6, 1, 'API Token', '[]', 0, '2021-12-10 00:49:46', '2021-12-10 00:49:46', '2022-12-10 06:19:46'),
('ca309587c159d4ecb986a7d7ddde1dedda3a9ca60cf949fef01855234c77a289619902b244e171b6', 17, 1, 'API Token', '[]', 0, '2021-12-17 09:10:59', '2021-12-17 09:10:59', '2022-12-17 14:40:59'),
('cd2250ae26010bdde74a3b38dcbc506dcc06404b6d3389a43404c585a6063cc5fd3f70ad20b4b879', 16, 1, 'API Token', '[]', 0, '2021-12-17 07:28:49', '2021-12-17 07:28:49', '2022-12-17 12:58:49'),
('ce8e1022d33b826c5abf1eb56a40da64305f075869924ec22a9df3224af6929d8fb6ac5e9b4a1969', 10, 1, 'API Token', '[]', 0, '2021-12-07 11:49:25', '2021-12-07 11:49:25', '2022-12-07 17:19:25'),
('cef7c66e3b68418e1f5e43742b362298c98e8683d18b482a133c9461c33703f2b0661b266484ef17', 6, 1, 'API Token', '[]', 0, '2021-12-22 06:01:14', '2021-12-22 06:01:14', '2022-12-22 11:31:14'),
('cefa3ab5eca80b8b3a32ffe8f11b3f5908416b12db0dfbb61b8a12aef57951a4af882f71e6a2975a', 5, 1, 'API Token', '[]', 0, '2021-12-07 06:43:09', '2021-12-07 06:43:09', '2022-12-07 12:13:09'),
('cf643ba73663333da4dda3cd21687b088110a23bfa3009d47f03715d92e25db853ed24d24f337c20', 5, 1, 'API Token', '[]', 0, '2021-12-06 06:22:08', '2021-12-06 06:22:08', '2022-12-06 11:52:08'),
('d01733483de84b8483cb84c1cfa49f6187429f147ab707bb7ece92fbbe7f2eeb1b60b65ef5a33d55', 6, 1, 'API Token', '[]', 0, '2021-12-12 23:22:11', '2021-12-12 23:22:11', '2022-12-13 04:52:11'),
('d0f22d317c55afdbc8e4316ffb1d091a91410b5bfcb94631de794392058d5c8d10ac8c1f6e43665e', 8, 1, 'API Token', '[]', 0, '2021-12-15 03:21:23', '2021-12-15 03:21:23', '2022-12-15 08:51:23'),
('d2d1bf51791d5d8cf4d34b0d130eff4c68b069d48d2c0b7ece4ece84fd6ad4899d292c21625df802', 5, 1, 'API Token', '[]', 0, '2021-12-17 02:31:15', '2021-12-17 02:31:15', '2022-12-17 08:01:15'),
('d2f93f92f9786c786e2678c6c984c10e9ace67619e1d18641f98ac9aa2df3388fb003e7a083d2561', 6, 1, 'API Token', '[]', 0, '2021-12-22 06:00:54', '2021-12-22 06:00:54', '2022-12-22 11:30:54'),
('d49a93dd876e3d63940f71a4e0803a1b62ec8e742fcceff2b76d74ab176555a2b9351210f298e991', 6, 1, 'API Token', '[]', 0, '2021-12-06 11:27:09', '2021-12-06 11:27:09', '2022-12-06 16:57:09'),
('d5a868ef908b16b0c8c6fba88647bd1c00e2d60718c8582e9a035d3a3c5f530986f604a372aa1150', 8, 1, 'API Token', '[]', 0, '2021-12-20 01:56:20', '2021-12-20 01:56:20', '2022-12-20 07:26:20'),
('d71ea74a1ec82e34204c038fbd765d61c63c8d930a36225909d84c82e904c6b5222fa7d6e92bc40d', 5, 1, 'API Token', '[]', 0, '2021-12-19 23:16:51', '2021-12-19 23:16:51', '2022-12-20 04:46:51'),
('db96f74afe46934f98c137bdd0b77ebcd75ebfe6346bde84d4492583362e8d6222fb537cf35972ce', 6, 1, 'API Token', '[]', 0, '2021-12-22 06:07:54', '2021-12-22 06:07:54', '2022-12-22 11:37:54'),
('ddc38f624a74d396ba330c4766cd879dc7113568b5f7faf80659e389c0476d74861ed960aa1e3371', 15, 1, 'API Token', '[]', 0, '2021-12-17 01:56:23', '2021-12-17 01:56:23', '2022-12-17 07:26:23'),
('de0db8b4b210868fb0ca639e09f124ef1cd597851a77a3398f80942bc038fd1e31b8f115a9d16f72', 5, 1, 'API Token', '[]', 0, '2021-12-30 02:34:48', '2021-12-30 02:34:48', '2022-12-30 08:04:48'),
('e00232d720377c1f80df39120080738267d4d3b6010194563962f9e360e3c2cd6f0b97f8179a3267', 15, 1, 'API Token', '[]', 0, '2021-12-16 23:34:01', '2021-12-16 23:34:01', '2022-12-17 05:04:01'),
('e4386e0e5018e7d78f1aaafd25c2f0204748418c94880ed04041de0fbd424b3bdf7ea6514efd08dc', 6, 1, 'API Token', '[]', 0, '2021-12-20 00:16:03', '2021-12-20 00:16:03', '2022-12-20 05:46:03'),
('e47c9cf1523e66d9d68b10c2ba6a50189968e46d9d74371330a32aa8cfa12baa86722476b2587ed3', 5, 1, 'API Token', '[]', 0, '2021-12-07 04:28:01', '2021-12-07 04:28:01', '2022-12-07 09:58:01'),
('e4f83d6b44b991bbfb724282daacea72b2c6bd2648d69e9eaf3c5b8c802cfbcc5f87872acbb5c43f', 5, 1, 'API Token', '[]', 0, '2021-12-09 23:48:55', '2021-12-09 23:48:55', '2022-12-10 05:18:55'),
('e979f2c232827699358874dc21d362322871d66d70dca3a73f7185cde3af532f483f062eae93fb6d', 2, 1, 'API Token', '[]', 0, '2021-12-14 03:12:54', '2021-12-14 03:12:54', '2022-12-14 08:42:54'),
('e9b83be70ed476c75f052d3103bba704c180c2de012bdf1434c44997f04c98f5493d6d6863e704d1', 6, 1, 'API Token', '[]', 0, '2021-12-17 04:20:55', '2021-12-17 04:20:55', '2022-12-17 09:50:55'),
('eab0b3f1c099aab96641a3be2194860c116b4ba57fcaa2973c1e8015c84762263c150b3f96dbfa80', 8, 1, 'API Token', '[]', 0, '2021-12-14 03:38:00', '2021-12-14 03:38:00', '2022-12-14 09:08:00'),
('ec3ca5b75df8c1c40efbd6a61908bd0744750427dc291dddc47ebe3c2ad525ff0be4275bcfbe3597', 5, 1, 'API Token', '[]', 0, '2021-12-06 06:21:53', '2021-12-06 06:21:53', '2022-12-06 11:51:53'),
('ec4c15197becb54539b3af1d3e194fe45afbd3ca9527a4c48d5f9ee4eebdee30ae6c2e975e326bcd', 6, 1, 'API Token', '[]', 0, '2021-12-27 03:02:49', '2021-12-27 03:02:49', '2022-12-27 08:32:49'),
('f2fef24b96025b24e82123db581a7ab213b8a20380cd78d207c2e35e4ed57253ab5b220de32d571e', 5, 1, 'API Token', '[]', 0, '2021-12-07 04:04:33', '2021-12-07 04:04:33', '2022-12-07 09:34:33'),
('f3f56a11f251d9c926dda3bad9438fee31daa937e8a311cf85a1c1e164fe4c964d8825f9c2a57cfc', 8, 1, 'API Token', '[]', 0, '2021-12-20 00:44:27', '2021-12-20 00:44:27', '2022-12-20 06:14:27'),
('f46a20b426dbe1b8780c8bbeb6484837ea033cfaa8b5c76acbc48367032d2d050cb2ff79eb15b05f', 5, 1, 'API Token', '[]', 0, '2021-12-19 23:49:25', '2021-12-19 23:49:25', '2022-12-20 05:19:25'),
('f4dae725fb9205c6aef24c0564793aa8ca8c0b4b9a5eac7a3e97d4714677c84cf15cd7d6ea5935ed', 15, 1, 'API Token', '[]', 0, '2021-12-16 23:34:25', '2021-12-16 23:34:25', '2022-12-17 05:04:25'),
('f5ae1f2139eb7f9b6c3247b917c00040f2b165c14544084f4b3490923c1f801098619a348abec07e', 5, 1, 'API Token', '[]', 0, '2021-12-20 00:20:18', '2021-12-20 00:20:18', '2022-12-20 05:50:18'),
('f69d9d589035bd765ac294bdfaf62e2f9910d731b7009cf104a5aa0be656b8b02271b4e8ef41a6ec', 6, 1, 'API Token', '[]', 0, '2021-12-20 00:15:26', '2021-12-20 00:15:26', '2022-12-20 05:45:26'),
('fa305f233889f89bfb98b5e2a8019fcf97d9a4c405499dc99fe196774cee1381f53ed1b3d2b147a7', 8, 1, 'API Token', '[]', 0, '2021-12-20 00:18:06', '2021-12-20 00:18:06', '2022-12-20 05:48:06'),
('fa8ca020c26097a598e913969dffc3d0d65ec103f409e1e78692ecfb8c1ef2445f5a7a84327f0ec3', 6, 1, 'API Token', '[]', 0, '2021-12-06 12:32:28', '2021-12-06 12:32:28', '2022-12-06 18:02:28'),
('fae748bc9df5bb86fb026821a8a38e18a5b7d61a288c2b4a6c6f23e84caafbf2b83c3f2f22a995fa', 2, 1, 'API Token', '[]', 0, '2021-12-14 03:22:40', '2021-12-14 03:22:40', '2022-12-14 08:52:40'),
('fc507a3ee7f096b4b5c593009086e9559fb07a3b039e61b03147af4edd6e5e8a7251ea9bcec570db', 5, 1, 'API Token', '[]', 0, '2021-12-07 08:31:14', '2021-12-07 08:31:14', '2022-12-07 14:01:14'),
('fcd771c0cc6fc3ccaa8eba50eb090c821f96ffffe71c7ebaf421b746add5725002e7bfc7d1742878', 5, 1, 'API Token', '[]', 0, '2021-12-21 22:21:23', '2021-12-21 22:21:23', '2022-12-22 03:51:23'),
('fd297cdea7b1b8aac56d540f780de09fb06e07c3a76366d8b8de15f6620f44dfb21413b92bd88f78', 6, 1, 'API Token', '[]', 0, '2021-12-27 03:03:19', '2021-12-27 03:03:19', '2022-12-27 08:33:19'),
('fea050a8b2b5ba6b8d8f3ee9d67028a63eabbe937f29c57dcff31adba029001f07f043cf8426646b', 4, 1, 'API Token', '[]', 0, '2021-12-06 06:21:23', '2021-12-06 06:21:23', '2022-12-06 11:51:23'),
('ff8011bc39e6724389cc3338036d3037c0aa40ca9eca94914bbfb13edbc6ed293cd73e17ce33f797', 5, 1, 'API Token', '[]', 0, '2021-12-12 23:25:19', '2021-12-12 23:25:19', '2022-12-13 04:55:19');

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
(1, NULL, 'BibleChat Personal Access Client', 'EqRVfQXKDAJIScDAPDhKcPLecuh6JUfml2H7Dxwj', NULL, 'http://localhost', 1, 0, 0, '2021-12-03 05:53:49', '2021-12-03 05:53:49'),
(2, NULL, 'BibleChat Password Grant Client', 'XTvrwaEtrNUOhETeTvZRoRCFnbYOS93HmCElfZsY', 'users', 'http://localhost', 0, 1, 0, '2021-12-03 05:53:49', '2021-12-03 05:53:49');

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
(1, 1, '2021-12-03 05:53:49', '2021-12-03 05:53:49');

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
('testMan@mailinator.com', '211373', '1639722093', NULL, NULL),
('bhavesh123@mailinator.com', '841864', '1640080704', NULL, NULL),
('bhavesh1234@mailinator.com', '890462', '1640851608', NULL, NULL),
('userapi123@mailinator.com', '847783', '1640923495', NULL, NULL),
('eminemm@mailinator.com', '695171', '1638806930', NULL, NULL),
('sandip123@mailinator.com', '235581', '1640406719', NULL, NULL),
('johndoe123@mailinator.com', '831970', '1639471386', NULL, NULL),
('cpatel@mailinator.com', '816483', '1638877860', NULL, NULL),
('mrfeast@chuangmedia.com', '488167', '1639109433', NULL, NULL),
('chandni@mailinator.com', '541634', '1639371143', NULL, NULL),
('chandni123@mailinator.com', '584143', '1640172780', NULL, NULL),
('pranavbegade@gmail.com', '111655', '1639746027', NULL, NULL),
('text1today@mailinator.com', '704221', '1639752407', NULL, NULL);

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `description`, `likes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 'Test', 'Test post', 2, '2021-12-06 06:32:56', '2021-12-30 02:44:29', NULL),
(2, 5, 'Second post', 'second post', 6, '2021-12-06 06:50:05', '2021-12-30 03:16:23', NULL),
(3, 2, 'Best 2 Post 2', 'Church 3 Test post description data', NULL, '2021-12-06 08:46:03', '2021-12-06 08:46:03', NULL),
(4, 5, 'Hello', 'hello', 2, '2021-12-06 10:26:35', '2021-12-30 03:17:54', NULL),
(5, 6, 'test', 'Test', 4, '2021-12-06 12:33:38', '2021-12-30 03:18:23', NULL),
(6, 7, 'nice', 'spotlight', NULL, '2021-12-06 13:34:49', '2021-12-06 13:34:49', NULL),
(7, 12, 'eric test 1', NULL, 1, '2021-12-09 22:41:14', '2021-12-10 00:37:01', NULL),
(8, 15, 'test post', 'ABC description', 0, '2021-12-12 23:26:09', '2021-12-16 06:55:53', NULL);

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
(1, 5, 5, 'Test', '2021-12-07 05:30:55', '2021-12-07 05:30:55', NULL),
(2, 2, 6, 'Super', '2021-12-07 05:38:04', '2021-12-07 05:38:04', NULL),
(3, 6, 3, 'heheh', '2021-12-07 11:31:53', '2021-12-07 11:31:53', NULL),
(4, 12, 2, 'hello', '2021-12-09 22:39:24', '2021-12-09 22:39:24', NULL),
(5, 12, 2, 'hello', '2021-12-09 22:39:25', '2021-12-09 22:39:25', NULL),
(6, 12, 2, 'hi', '2021-12-09 22:39:29', '2021-12-09 22:39:29', NULL),
(7, 5, 5, 'Eceff', '2021-12-10 00:54:05', '2021-12-10 00:54:05', NULL);

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
(1, 2, '16387734050.jpg', 'jpg', '2021-12-06 06:50:09', '2021-12-06 06:50:09', NULL),
(2, 4, '16387863950.jpg', 'jpg', '2021-12-06 10:26:35', '2021-12-06 10:26:35', NULL),
(3, 5, '16387940180.png', 'png', '2021-12-06 12:33:38', '2021-12-06 12:33:38', NULL),
(4, 6, '16387976890.jpg', 'jpg', '2021-12-06 13:34:51', '2021-12-06 13:34:51', NULL),
(5, 7, '16391094740.png', 'png', '2021-12-09 22:41:19', '2021-12-09 22:41:19', NULL),
(6, 8, '16393713690.png', 'png', '2021-12-12 23:26:09', '2021-12-12 23:26:09', NULL);

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
(1, 'Desires', 'https://open.spotify.com/track/5pcmtf1lwrMqmAWWm248fY?si=a6193e9f4abc42d3', '2021-12-06 15:16:47', '2021-12-06 15:16:47', NULL);

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
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '	en = English, zh-CN = Chinese',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `first_name`, `last_name`, `uniqid`, `mobile_number`, `church_id`, `email`, `email_verified_at`, `password`, `remember_token`, `u_type`, `ref_user_id`, `qr_code`, `pic`, `device_token`, `ios_device_token`, `language`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', NULL, NULL, '', NULL, NULL, 'admin@test.com', '2021-10-22 05:40:15', '$2a$12$2kkEKi9W.YGAFOZVyxI7f..CveZ5KxLWKxNvbprKTq0/WunjfHFIm', NULL, 'ADM', NULL, NULL, NULL, NULL, NULL, NULL, '2021-10-22 14:30:47', '2021-10-21 19:27:15', NULL),
(2, '12numbrs', 'Twelve', 'number', '1638513728', '9876543211', '1', 'testMan@mailinator.com', '2021-12-17 00:51:24', '$2y$10$FxJkJrtaheu4bMa3oKO4L.kXqWEKjZFxISSkvzAF71YYJV36j2SgK', NULL, 'USR', NULL, 'QR_1638513728.png', NULL, 'dlDuIFgRRhaIiogumQtgls:APA91bGEHRRyKKGBvWDuxN7I6pWQfdeSOpkmGVjc6HjxFeYHx6gp2qMiRmvy5_0cfYRZZ6kodZNtXHFZH3VLsLXg6eBPqNB2TG3UoB50EnEIJFY9F25_EH39KvN5TXuZSo6IoCAotzUE', 'cS6N0FiqEEzjmqNBCW48vC:APA91bGKHMUC1viZDxgJPBK5L6pkBRSlDrp2WrRBoSh6E6l7V4MugCJiJ4zbXc4nDOXPpwTdId1YZJtLhhRDKsjIRSy_zwAirDlGDTvBIQAOQKrzxyGNzRNRDMOmGXQZ8my1_5_2Mdni', NULL, '2021-12-03 06:42:09', '2021-12-17 00:51:24', NULL),
(3, 'Vancouver Church', NULL, NULL, '1638770235', NULL, NULL, 'vancouverchurch@mailinator.com', '2021-12-06 05:57:15', '$2y$10$ilmgVudVrL1vtA5kwAAJueZY3YpRZuvOxfSb2FJs1ta1YZM8TNZm2', NULL, 'CHR', NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-06 05:57:15', '2021-12-06 05:57:15', NULL),
(4, 'bhavesh123', 'Bhavesh', 'Gohil', '1638771195', '9639639639', '1', 'bhavesh123@mailinator.com', '2021-12-21 04:26:44', '$2y$10$Dsxc4DfUxRncwrJBn6RI0u2jc2kLb9qpZtYD4pnwjl1R4qSifrg4C', NULL, 'USR', NULL, 'QR_1638771195.png', NULL, 'fvyXbKKuikcqncHAE92vq_:APA91bEBeXOuTaPoVYFLVShONR9nj63YyQM2zUJz8_CwuMqEWsCEsXFeKeShCv8My61Im4vNXjM4HiTnNaZxegI-uqv36jFgA_LlRKyO1QvWOHAPzgbhp7Fd59J6WqfL9d7bP34clG9G', '16140a9a90a2812932c74b28eb1d842200972a19a4b14f8cac097e5efbceb3f0', NULL, '2021-12-06 06:13:16', '2021-12-21 04:26:44', NULL),
(5, 'bhavesh1234', 'Bhavesh', 'Gohil', '1638771405', '9639639639', '1', 'bhavesh1234@mailinator.com', '2021-12-30 02:35:04', '$2y$10$yfWnVWg3roHeWTKHsBAs2.33ufnXzVHe3vvj15KOyFA/7UgAsjdfC', NULL, 'USR', NULL, 'QR_1638771405.png', '1638880848.jpg', 'cgfITiWpRqatuh4ugOcUBT:APA91bEar0g8Blq5QC1VMFvV8hoNQ7l9M7yFn3wipxbb77flfYocON_o6y6a2mfDUFGMpEq5vhDOZvNzkY1mclyNHCjB2g9pSr-LF9eC0tYX9-1k117OKc3majaRCSS1sXh8KOgS33BL', 'cS6N0FiqEEzjmqNBCW48vC:APA91bGKHMUC1viZDxgJPBK5L6pkBRSlDrp2WrRBoSh6E6l7V4MugCJiJ4zbXc4nDOXPpwTdId1YZJtLhhRDKsjIRSy_zwAirDlGDTvBIQAOQKrzxyGNzRNRDMOmGXQZ8my1_5_2Mdni', NULL, '2021-12-06 06:16:45', '2021-12-30 02:35:04', NULL),
(6, 'userapi123', 'User', 'Api', '1638789958', '1234567890', '1', 'userapi123@mailinator.com', '2021-12-30 22:33:23', '$2y$10$0yewIvtS6D.Dh2/NjrwoYOBeVS2kV9md2a2eVL5EyBPTisSQtB/gy', NULL, 'USR', NULL, 'QR_1638789958.png', '1638852722.png', 'cLJTkgGBxUl2iKy1T683qR:APA91bHd3TUEGWBQpc_FjFBEiJnvch0xgCaI6NUF9fP9gsymMsNYWOvlRzsHNtkCX68fBJiy28YcUzav37bBdidWXalF-AXQdt5FnuLT_aSi9RpBsC0uEMT32EnlchQmw4jHC5kRqxmI', '1c6414148519ace652d4616d7071d393db1c72ff772bd0e531cbbf47edf87271', 'en', '2021-12-06 11:26:00', '2021-12-30 22:33:23', NULL),
(7, 'eminem', 'Marshal', 'Eminem', '1638797599', '9725789197', '1', 'eminemm@mailinator.com', '2021-12-06 16:07:10', '$2y$10$gFB8rfHsdBXyD5IHeWbckumfCA9RUzHLo/7Gs7cBV5G76yWLQoYBi', NULL, 'USR', NULL, 'QR_1638797599.png', NULL, NULL, NULL, NULL, '2021-12-06 13:33:20', '2021-12-06 16:07:10', NULL),
(8, 'sandip123', 'Sandip', 'Chaudhari', '1638865389', '9090909090', '1', 'sandip123@mailinator.com', '2021-12-24 23:00:15', '$2y$10$XHkY4P4aJVfFxEMoge5EnOP2tUMmpNj62cX/ybNLBl6TA.qZy8fni', NULL, 'USR', NULL, 'QR_1638865389.png', '1639472926.jpg', 'divDTguWSJifpGux1B3O4e:APA91bHhUBVX82yax1EmYOlVxMr_mO8CV1ss67zThMWex4ZSe7cICiLpWFOVO2mRoo-Twb8HMu24w8pG8oHwb31EGpNmLeNIE51ppJ7AkQxOlDpORC3vdWsLUARHFMBokN8gQJMu3X1j', NULL, NULL, '2021-12-07 08:23:11', '2021-12-24 23:00:15', NULL),
(9, 'johndoe', 'John', 'Doe', '1638865792', '1471471471', '1', 'johndoe123@mailinator.com', '2021-12-14 03:11:32', '$2y$10$SnUKmfOyi1.ltbZEk6IT8.Pf6q1OVTfbVGteqgnMmuCAgmbiImnUy', NULL, 'USR', NULL, 'QR_1638865792.png', '1639471352.jpg', 'e3y6B0ZdT46K-7nHBhGEla:APA91bEHemHjMuAD8x0U1hCRLzTRqKgwOEvzgh5bfGT6Xf1Og1bqCALSOUrU__ANFiKPj22vtQmNHFuebgcFaFrbzz8k2V1gDuatKX0QCmaXKiMj0ncLgGCePOFFWL6OirqRBuqtvR5Y', NULL, NULL, '2021-12-07 08:29:53', '2021-12-14 03:12:34', NULL),
(10, 'cpatel', 'Chandani', 'Patel', '1638877739', '8585858585', '1', 'cpatel@mailinator.com', '2021-12-07 11:49:23', '$2y$10$mTsaZActpxqIxQmNZLwuwuwIy08T8f0FtlFe2ulwByo8SAe5aXemO', NULL, 'USR', NULL, 'QR_1638877739.png', NULL, NULL, NULL, NULL, '2021-12-07 11:49:00', '2021-12-07 11:49:23', NULL),
(11, 'California', NULL, NULL, '1638886861', NULL, NULL, 'californiachurch@mailinator.com', '2021-12-07 14:21:01', '$2y$10$7YTw5Mq14Iu.SolIjuyiFuIHbf/OChKO35oWzVE.lu8YwtWv83Oou', NULL, 'CHR', NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 14:21:01', '2021-12-07 14:21:01', NULL),
(12, 'mrfeast', 'Eric', 'Chuang', '1638910970', '7789268586', '1', 'mrfeast@chuangmedia.com', '2021-12-09 22:39:08', '$2y$10$WdL2YN87aOAOYbQADxGxlucmDaZSnqaog2JyOU2efRjvB5rpxfQYy', NULL, 'USR', NULL, 'QR_1638910970.png', NULL, NULL, NULL, NULL, '2021-12-07 21:02:52', '2021-12-09 22:39:08', NULL),
(13, 'East Midlands Church', NULL, NULL, '1638938899', NULL, NULL, 'eastmidlands@mailinator.com', '2021-12-08 04:48:19', '$2y$10$j2Wext0evGIyZet1WSykIu.xcpfOTiKegbuaCkqpG4vpSNnv5p5yW', NULL, 'CHR', NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-08 04:48:19', '2021-12-08 04:48:19', NULL),
(14, 'chandnipatel', 'Chandni', 'Patel', '1639371022', '1234567890', '3', 'chandni@mailinator.com', '2021-12-12 23:20:55', '$2y$10$rzCoAzKIP7A.VkQD8RbAuel9FTDrrhUQjkUBCfbyLn8X.NHuMBZg2', NULL, 'USR', NULL, 'QR_1639371022.png', NULL, 'cS6N0FiqEEzjmqNBCW48vC:APA91bGKHMUC1viZDxgJPBK5L6pkBRSlDrp2WrRBoSh6E6l7V4MugCJiJ4zbXc4nDOXPpwTdId1YZJtLhhRDKsjIRSy_zwAirDlGDTvBIQAOQKrzxyGNzRNRDMOmGXQZ8my1_5_2Mdni', NULL, NULL, '2021-12-12 23:20:23', '2021-12-12 23:20:55', NULL),
(15, 'chandni123', 'Chandni', 'Patel', '1639371292', '1234567890', '1', 'chandni123@mailinator.com', '2021-12-22 06:01:25', '$2y$10$NcCgddw2Sr1o.SLqOxm9lulsaNC0665.FKHkQmE22XQV.wtmSeFsG', NULL, 'USR', NULL, 'QR_1639371292.png', '1639557587.png', '6efbfcbfdbecf1e5a7d4020bbd64d0f39f879a59adec2f57e45cea1ca5c31e9f', 'cS6N0FiqEEzjmqNBCW48vC:APA91bGKHMUC1viZDxgJPBK5L6pkBRSlDrp2WrRBoSh6E6l7V4MugCJiJ4zbXc4nDOXPpwTdId1YZJtLhhRDKsjIRSy_zwAirDlGDTvBIQAOQKrzxyGNzRNRDMOmGXQZ8my1_5_2Mdni', NULL, '2021-12-12 23:24:52', '2021-12-22 06:01:25', NULL),
(16, 'venom', 'Pranav', 'Begade', '1639745905', '9725789197', '1', 'pranavbegade@gmail.com', '2021-12-17 07:28:48', '$2y$10$CxVnazXsRZ.Ni721Pdn1ZeHa7wN.y7wPXvp9Q09jFlKPj0L1RXWUm', NULL, 'USR', NULL, 'QR_1639745905.png', NULL, 'dsp1AZYLQTWKBoXATFaylh:APA91bHwMZvaxzY7nwtij5RgWVdtaYDWOdicludXwQhKGzhXu6qO9eunCq06j4moQ4ZOLlsPMnNltAJvNMdBVKuheUaU-y6Wre2jZq5b3aut8OT8Pk4gBqr0ycLZW1GukCR6O5XiVfQb', NULL, NULL, '2021-12-17 07:28:27', '2021-12-17 07:28:48', NULL),
(17, 'texttoday', 'Text1', 'Today', '1639751906', '9876543211', '2', 'text1today@mailinator.com', '2021-12-17 09:15:24', '$2y$10$gSubNgvJOY.vRsvtF923q.s0sPfW7J8utMMhu/mSkFxJNvzAWTz.G', NULL, 'USR', NULL, 'QR_1639751906.png', NULL, 'dlDuIFgRRhaIiogumQtgls:APA91bGEHRRyKKGBvWDuxN7I6pWQfdeSOpkmGVjc6HjxFeYHx6gp2qMiRmvy5_0cfYRZZ6kodZNtXHFZH3VLsLXg6eBPqNB2TG3UoB50EnEIJFY9F25_EH39KvN5TXuZSo6IoCAotzUE', 'cS6N0FiqEEzjmqNBCW48vC:APA91bGKHMUC1viZDxgJPBK5L6pkBRSlDrp2WrRBoSh6E6l7V4MugCJiJ4zbXc4nDOXPpwTdId1YZJtLhhRDKsjIRSy_zwAirDlGDTvBIQAOQKrzxyGNzRNRDMOmGXQZ8my1_5_2Mdni', NULL, '2021-12-17 09:08:27', '2021-12-17 09:15:24', NULL);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendars`
--
ALTER TABLE `calendars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `churches`
--
ALTER TABLE `churches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `church_banners`
--
ALTER TABLE `church_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `diaries`
--
ALTER TABLE `diaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `favourite_types`
--
ALTER TABLE `favourite_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `group_chats`
--
ALTER TABLE `group_chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `post_media`
--
ALTER TABLE `post_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
