-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 18, 2021 at 07:22 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `euro2020`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_rows`
--

DROP TABLE IF EXISTS `data_rows`;
CREATE TABLE IF NOT EXISTS `data_rows` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `data_type_id` int(10) UNSIGNED NOT NULL,
  `field` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `browse` tinyint(1) NOT NULL DEFAULT '1',
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `edit` tinyint(1) NOT NULL DEFAULT '1',
  `add` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '1',
  `details` text COLLATE utf8mb4_unicode_ci,
  `order` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `data_rows_data_type_id_foreign` (`data_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_rows`
--

INSERT INTO `data_rows` (`id`, `data_type_id`, `field`, `type`, `display_name`, `required`, `browse`, `read`, `edit`, `add`, `delete`, `details`, `order`) VALUES
(1, 1, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(2, 1, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(3, 1, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, NULL, 3),
(4, 1, 'password', 'password', 'Password', 1, 0, 0, 1, 1, 0, NULL, 4),
(5, 1, 'remember_token', 'text', 'Remember Token', 0, 0, 0, 0, 0, 0, NULL, 5),
(6, 1, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, NULL, 6),
(7, 1, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 7),
(8, 1, 'avatar', 'image', 'Avatar', 0, 1, 1, 1, 1, 1, NULL, 8),
(9, 1, 'user_belongsto_role_relationship', 'relationship', 'Role', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsTo\",\"column\":\"role_id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"roles\",\"pivot\":0}', 10),
(10, 1, 'user_belongstomany_role_relationship', 'relationship', 'Roles', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"user_roles\",\"pivot\":\"1\",\"taggable\":\"0\"}', 11),
(11, 1, 'settings', 'hidden', 'Settings', 0, 0, 0, 0, 0, 0, NULL, 12),
(12, 2, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(13, 2, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(14, 2, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, NULL, 3),
(15, 2, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(16, 3, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(17, 3, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(18, 3, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, NULL, 3),
(19, 3, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(20, 3, 'display_name', 'text', 'Display Name', 1, 1, 1, 1, 1, 1, NULL, 5),
(21, 1, 'role_id', 'text', 'Role', 1, 1, 1, 1, 1, 1, NULL, 9);

-- --------------------------------------------------------

--
-- Table structure for table `data_types`
--

DROP TABLE IF EXISTS `data_types`;
CREATE TABLE IF NOT EXISTS `data_types` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_singular` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_plural` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT '0',
  `server_side` tinyint(4) NOT NULL DEFAULT '0',
  `details` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `data_types_name_unique` (`name`),
  UNIQUE KEY `data_types_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_types`
--

INSERT INTO `data_types` (`id`, `name`, `slug`, `display_name_singular`, `display_name_plural`, `icon`, `model_name`, `policy_name`, `controller`, `description`, `generate_permissions`, `server_side`, `details`, `created_at`, `updated_at`) VALUES
(1, 'users', 'users', 'User', 'Users', 'voyager-person', 'TCG\\Voyager\\Models\\User', 'TCG\\Voyager\\Policies\\UserPolicy', 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController', '', 1, 0, NULL, '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(2, 'menus', 'menus', 'Menu', 'Menus', 'voyager-list', 'TCG\\Voyager\\Models\\Menu', NULL, '', '', 1, 0, NULL, '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(3, 'roles', 'roles', 'Role', 'Roles', 'voyager-lock', 'TCG\\Voyager\\Models\\Role', NULL, 'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController', '', 1, 0, NULL, '2021-04-28 11:52:15', '2021-04-28 11:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, 'E'),
(6, 'F');

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

DROP TABLE IF EXISTS `matches`;
CREATE TABLE IF NOT EXISTS `matches` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_h` int(11) DEFAULT NULL,
  `team_a` int(11) DEFAULT NULL,
  `score_h` int(11) DEFAULT NULL,
  `score_a` int(11) DEFAULT NULL,
  `pen_h` int(11) DEFAULT NULL,
  `pen_a` int(11) DEFAULT NULL,
  `stadium_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `qualification_h` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification_a` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`id`, `team_h`, `team_a`, `score_h`, `score_a`, `pen_h`, `pen_a`, `stadium_id`, `type`, `date`, `qualification_h`, `qualification_a`, `group_id`) VALUES
(1, 3, 1, 0, 2, NULL, NULL, 11, 0, '2021-06-11 21:00:00', NULL, NULL, 1),
(2, 4, 2, 1, 1, NULL, NULL, 2, 0, '2021-06-12 15:00:00', NULL, NULL, 1),
(3, 6, 7, NULL, NULL, NULL, NULL, 6, 0, '2021-06-12 18:00:00', NULL, NULL, 2),
(4, 5, 8, NULL, NULL, NULL, NULL, 12, 0, '2021-06-12 21:00:00', NULL, NULL, 2),
(5, 15, 13, NULL, NULL, NULL, NULL, 9, 0, '2021-06-13 15:00:00', NULL, NULL, 4),
(6, 9, 11, NULL, NULL, NULL, NULL, 4, 0, '2021-06-13 18:00:00', NULL, NULL, 3),
(7, 10, 12, NULL, NULL, NULL, NULL, 1, 0, '2021-06-13 21:00:00', NULL, NULL, 3),
(8, 16, 14, NULL, NULL, NULL, NULL, 8, 0, '2021-06-14 15:00:00', NULL, NULL, 4),
(9, 17, 18, NULL, NULL, NULL, NULL, 12, 0, '2021-06-14 18:00:00', NULL, NULL, 5),
(10, 19, 20, NULL, NULL, NULL, NULL, 3, 0, '2021-06-14 21:00:00', NULL, NULL, 5),
(11, 23, 24, NULL, NULL, NULL, NULL, 5, 0, '2021-06-15 18:00:00', NULL, NULL, 6),
(12, 21, 22, NULL, NULL, NULL, NULL, 10, 0, '2021-06-15 21:00:00', NULL, NULL, 6),
(13, 7, 8, NULL, NULL, NULL, NULL, 12, 0, '2021-06-16 15:00:00', NULL, NULL, 2),
(14, 3, 4, NULL, NULL, NULL, NULL, 2, 0, '2021-06-16 18:00:00', NULL, NULL, 1),
(15, 1, 2, NULL, NULL, NULL, NULL, 11, 0, '2021-06-16 21:00:00', NULL, NULL, 1),
(16, 12, 11, NULL, NULL, NULL, NULL, 4, 0, '2021-06-17 15:00:00', NULL, NULL, 3),
(17, 6, 5, NULL, NULL, NULL, NULL, 6, 0, '2021-06-17 18:00:00', NULL, NULL, 2),
(18, 10, 9, NULL, NULL, NULL, NULL, 1, 0, '2021-06-17 21:00:00', NULL, NULL, 3),
(19, 20, 18, NULL, NULL, NULL, NULL, 12, 0, '2021-06-18 15:00:00', NULL, NULL, 5),
(20, 13, 14, NULL, NULL, NULL, NULL, 8, 0, '2021-06-18 18:00:00', NULL, NULL, 4),
(21, 15, 16, NULL, NULL, NULL, NULL, 9, 0, '2021-06-18 21:00:00', NULL, NULL, 4),
(22, 23, 21, NULL, NULL, NULL, NULL, 5, 0, '2021-06-19 15:00:00', NULL, NULL, 6),
(23, 24, 22, NULL, NULL, NULL, NULL, 10, 0, '2021-06-19 18:00:00', NULL, NULL, 6),
(24, 19, 17, NULL, NULL, NULL, NULL, 3, 0, '2021-06-19 21:00:00', NULL, NULL, 5),
(25, 1, 4, NULL, NULL, NULL, NULL, 11, 0, '2021-06-20 18:00:00', NULL, NULL, 1),
(26, 2, 3, NULL, NULL, NULL, NULL, 2, 0, '2021-06-20 18:00:00', NULL, NULL, 1),
(27, 12, 9, NULL, NULL, NULL, NULL, 4, 0, '2021-06-21 18:00:00', NULL, NULL, 3),
(28, 11, 10, NULL, NULL, NULL, NULL, 1, 0, '2021-06-21 18:00:00', NULL, NULL, 3),
(29, 7, 5, NULL, NULL, NULL, NULL, 12, 0, '2021-06-21 21:00:00', NULL, NULL, 2),
(30, 8, 6, NULL, NULL, NULL, NULL, 6, 0, '2021-06-21 21:00:00', NULL, NULL, 2),
(31, 14, 15, NULL, NULL, NULL, NULL, 9, 0, '2021-06-22 21:00:00', NULL, NULL, 4),
(32, 13, 16, NULL, NULL, NULL, NULL, 8, 0, '2021-06-22 21:00:00', NULL, NULL, 4),
(33, 20, 17, NULL, NULL, NULL, NULL, 12, 0, '2021-06-23 18:00:00', NULL, NULL, 5),
(34, 18, 19, NULL, NULL, NULL, NULL, 3, 0, '2021-06-23 18:00:00', NULL, NULL, 5),
(35, 22, 23, NULL, NULL, NULL, NULL, 10, 0, '2021-06-23 21:00:00', NULL, NULL, 6),
(36, 24, 21, NULL, NULL, NULL, NULL, 5, 0, '2021-06-23 21:00:00', NULL, NULL, 6),
(37, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2021-06-26 18:00:00', '2_A', 'B_2', NULL),
(38, NULL, NULL, NULL, NULL, NULL, NULL, 9, 1, '2021-06-26 21:00:00', '1_A', '2_C', NULL),
(39, NULL, NULL, NULL, NULL, NULL, NULL, 5, 1, '2021-06-27 18:00:00', '1_C', '3_DEF', NULL),
(40, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '2021-06-27 21:00:00', '1B', '3ADEF', NULL),
(41, NULL, NULL, NULL, NULL, NULL, NULL, 6, 1, '2021-06-28 18:00:00', '2D', '2E', NULL),
(42, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, '2021-06-28 21:00:00', '1F', '3ABC', NULL),
(43, NULL, NULL, NULL, NULL, NULL, NULL, 9, 1, '2021-06-29 18:00:00', '1D', '2F', NULL),
(44, NULL, NULL, NULL, NULL, NULL, NULL, 8, 1, '2021-06-29 21:00:00', '1E', '3ABCD', NULL),
(45, NULL, NULL, NULL, NULL, NULL, NULL, 12, 2, '2021-07-02 18:00:00', 'W42', 'W41', NULL),
(46, NULL, NULL, NULL, NULL, NULL, NULL, 10, 2, '2021-07-02 21:00:00', 'W40', 'W38', NULL),
(47, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, '2021-07-03 18:00:00', 'W39', 'W37', NULL),
(48, NULL, NULL, NULL, NULL, NULL, NULL, 11, 2, '2021-07-03 21:00:00', 'W44', 'W43', NULL),
(49, NULL, NULL, NULL, NULL, NULL, NULL, 9, 3, '2021-07-06 21:00:00', 'W46', 'W45', NULL),
(50, NULL, NULL, NULL, NULL, NULL, NULL, 9, 3, '2021-07-07 21:00:00', 'W48', 'W47', NULL),
(51, NULL, NULL, NULL, NULL, NULL, NULL, 9, 4, '2021-07-11 21:00:00', 'W49', 'W50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menus_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2021-04-28 11:52:15', '2021-04-28 11:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon_class` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `menu_items_menu_id_foreign` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `title`, `url`, `target`, `icon_class`, `color`, `parent_id`, `order`, `created_at`, `updated_at`, `route`, `parameters`) VALUES
(1, 1, 'Dashboard', '', '_self', 'voyager-boat', NULL, NULL, 1, '2021-04-28 11:52:15', '2021-04-28 11:52:15', 'voyager.dashboard', NULL),
(2, 1, 'Media', '', '_self', 'voyager-images', NULL, NULL, 5, '2021-04-28 11:52:15', '2021-04-28 11:52:15', 'voyager.media.index', NULL),
(3, 1, 'Users', '', '_self', 'voyager-person', NULL, NULL, 3, '2021-04-28 11:52:15', '2021-04-28 11:52:15', 'voyager.users.index', NULL),
(4, 1, 'Roles', '', '_self', 'voyager-lock', NULL, NULL, 2, '2021-04-28 11:52:15', '2021-04-28 11:52:15', 'voyager.roles.index', NULL),
(5, 1, 'Tools', '', '_self', 'voyager-tools', NULL, NULL, 9, '2021-04-28 11:52:15', '2021-04-28 11:52:15', NULL, NULL),
(6, 1, 'Menu Builder', '', '_self', 'voyager-list', NULL, 5, 10, '2021-04-28 11:52:15', '2021-04-28 11:52:15', 'voyager.menus.index', NULL),
(7, 1, 'Database', '', '_self', 'voyager-data', NULL, 5, 11, '2021-04-28 11:52:15', '2021-04-28 11:52:15', 'voyager.database.index', NULL),
(8, 1, 'Compass', '', '_self', 'voyager-compass', NULL, 5, 12, '2021-04-28 11:52:15', '2021-04-28 11:52:15', 'voyager.compass.index', NULL),
(9, 1, 'BREAD', '', '_self', 'voyager-bread', NULL, 5, 13, '2021-04-28 11:52:15', '2021-04-28 11:52:15', 'voyager.bread.index', NULL),
(10, 1, 'Settings', '', '_self', 'voyager-settings', NULL, NULL, 14, '2021-04-28 11:52:15', '2021-04-28 11:52:15', 'voyager.settings.index', NULL),
(11, 1, 'Hooks', '', '_self', 'voyager-hook', NULL, 5, 13, '2021-04-28 11:52:15', '2021-04-28 11:52:15', 'voyager.hooks', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_01_01_000000_add_voyager_user_fields', 1),
(4, '2016_01_01_000000_create_data_types_table', 1),
(5, '2016_05_19_173453_create_menu_table', 1),
(6, '2016_10_21_190000_create_roles_table', 1),
(7, '2016_10_21_190000_create_settings_table', 1),
(8, '2016_11_30_135954_create_permission_table', 1),
(9, '2016_11_30_141208_create_permission_role_table', 1),
(10, '2016_12_26_201236_data_types__add__server_side', 1),
(11, '2017_01_13_000000_add_route_to_menu_items_table', 1),
(12, '2017_01_14_005015_create_translations_table', 2),
(13, '2017_01_15_000000_make_table_name_nullable_in_permissions_table', 2),
(14, '2017_03_06_000000_add_controller_to_data_types_table', 2),
(15, '2017_04_21_000000_add_order_to_data_rows_table', 2),
(16, '2017_07_05_210000_add_policyname_to_data_types_table', 2),
(17, '2017_08_05_000000_add_group_to_settings_table', 2),
(18, '2017_11_26_013050_add_user_role_relationship', 2),
(19, '2017_11_26_015000_create_user_roles_table', 2),
(20, '2018_03_11_000000_add_user_settings', 2),
(21, '2018_03_14_000000_add_details_to_data_types_table', 2),
(22, '2018_03_16_000000_make_settings_value_nullable', 2),
(23, '2019_08_19_000000_create_failed_jobs_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permissions_key_index` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `key`, `table_name`, `created_at`, `updated_at`) VALUES
(1, 'browse_admin', NULL, '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(2, 'browse_bread', NULL, '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(3, 'browse_database', NULL, '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(4, 'browse_media', NULL, '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(5, 'browse_compass', NULL, '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(6, 'browse_menus', 'menus', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(7, 'read_menus', 'menus', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(8, 'edit_menus', 'menus', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(9, 'add_menus', 'menus', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(10, 'delete_menus', 'menus', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(11, 'browse_roles', 'roles', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(12, 'read_roles', 'roles', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(13, 'edit_roles', 'roles', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(14, 'add_roles', 'roles', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(15, 'delete_roles', 'roles', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(16, 'browse_users', 'users', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(17, 'read_users', 'users', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(18, 'edit_users', 'users', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(19, 'add_users', 'users', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(20, 'delete_users', 'users', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(21, 'browse_settings', 'settings', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(22, 'read_settings', 'settings', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(23, 'edit_settings', 'settings', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(24, 'add_settings', 'settings', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(25, 'delete_settings', 'settings', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(26, 'browse_hooks', NULL, '2021-04-28 11:52:15', '2021-04-28 11:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE IF NOT EXISTS `permission_role` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pronostics`
--

DROP TABLE IF EXISTS `pronostics`;
CREATE TABLE IF NOT EXISTS `pronostics` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` smallint(5) UNSIGNED NOT NULL,
  `match_id` smallint(5) UNSIGNED NOT NULL,
  `team_h` smallint(5) UNSIGNED DEFAULT NULL,
  `team_a` smallint(5) UNSIGNED DEFAULT NULL,
  `score_h` smallint(5) UNSIGNED DEFAULT NULL,
  `score_a` smallint(5) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prognostics_user_id_match_id_unique` (`user_id`,`match_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pronostics`
--

INSERT INTO `pronostics` (`id`, `user_id`, `match_id`, `team_h`, `team_a`, `score_h`, `score_a`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, 2, 1, '2021-05-17 18:17:30', '2021-05-17 18:25:41');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', '2021-04-28 11:52:15', '2021-04-28 11:52:15'),
(2, 'user', 'Normal User', '2021-04-28 11:52:15', '2021-04-28 11:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `details` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `display_name`, `value`, `details`, `type`, `order`, `group`) VALUES
(1, 'site.title', 'Site Title', 'Site Title', '', 'text', 1, 'Site'),
(2, 'site.description', 'Site Description', 'Site Description', '', 'text', 2, 'Site'),
(3, 'site.logo', 'Site Logo', '', '', 'image', 3, 'Site'),
(4, 'site.google_analytics_tracking_id', 'Google Analytics Tracking ID', '', '', 'text', 4, 'Site'),
(5, 'admin.bg_image', 'Admin Background Image', '', '', 'image', 5, 'Admin'),
(6, 'admin.title', 'Admin Title', 'Voyager', '', 'text', 1, 'Admin'),
(7, 'admin.description', 'Admin Description', 'Welcome to Voyager. The Missing Admin for Laravel', '', 'text', 2, 'Admin'),
(8, 'admin.loader', 'Admin Loader', '', '', 'image', 3, 'Admin'),
(9, 'admin.icon_image', 'Admin Icon Image', '', '', 'image', 4, 'Admin'),
(10, 'admin.google_analytics_client_id', 'Google Analytics Client ID (used for admin dashboard)', '', '', 'text', 1, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `stadia`
--

DROP TABLE IF EXISTS `stadia`;
CREATE TABLE IF NOT EXISTS `stadia` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` decimal(8,6) NOT NULL,
  `lng` decimal(8,6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stadia`
--

INSERT INTO `stadia` (`id`, `name`, `city`, `lat`, `lng`) VALUES
(1, 'Johan Cruijff ArenA', 'Amsterdam', '52.367600', '4.904100'),
(2, 'Baku Olympic Stadium', 'Baku', '40.409300', '49.867100'),
(3, 'Estadio La Cartuja', 'Seville', '43.263000', '-2.935000'),
(4, 'National Aréna', 'Bucharest', '44.426800', '26.102500'),
(5, 'Puskás Arena', 'Budapest', '47.497900', '19.040200'),
(6, 'Parken Stadium', 'Copenhagen', '55.676100', '12.568300'),
(7, 'Dublin Arena', 'Dublin', '53.349800', '-6.260300'),
(8, 'Hampden Park', 'Glasgow', '55.864200', '-4.251800'),
(9, 'Wembley Stadium', 'London', '51.507400', '-0.127800'),
(10, 'Football Arena Munich', 'Munich', '48.135100', '11.582000'),
(11, 'Olimpico', 'Rome', '41.902800', '12.496800'),
(12, 'Sain Petersburg Stadium', 'Sain Petersburg', '59.931100', '30.360900');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abr` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `iso` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `abr`, `group_id`, `iso`) VALUES
(1, 'Italie', 'ita', 1, 'it'),
(2, 'Suisse', 'sui', 1, 'ch'),
(3, 'Turquie', 'tur', 1, 'tr'),
(4, 'Pays de Gâles', 'wal', 1, 'gb-wls'),
(5, 'Belgique', 'bel', 2, 'be'),
(6, 'Danemark', 'den', 2, 'dk'),
(7, 'Finlande', 'fin', 2, 'fi'),
(8, 'Russie', 'rus', 2, 'ru'),
(9, 'Autriche', 'aut', 3, 'at'),
(10, 'Pays Bas', 'ned', 3, 'nl'),
(11, 'Nord Macédonie', 'mkd', 3, 'mk'),
(12, 'Ucraine', 'ukr', 3, 'ua'),
(13, 'Croatie', 'cro', 4, 'hr'),
(14, 'République Cheque', 'cze', 4, 'cz'),
(15, 'Angleterre', 'eng', 4, 'gb-eng'),
(16, 'Écosse', 'sco', 4, 'gb-sct'),
(17, 'Pologne', 'pol', 5, 'pl'),
(18, 'Slovaquie', 'svk', 5, 'sk'),
(19, 'Espagne', 'esp', 5, 'es'),
(20, 'Suède', 'swe', 5, 'se'),
(21, 'France', 'fra', 6, 'fr'),
(22, 'Allemagne', 'ger', 6, 'de'),
(23, 'Hongrie', 'hun', 6, 'hu'),
(24, 'Portugal', 'por', 6, 'pt');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
CREATE TABLE IF NOT EXISTS `translations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `table_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'users/default.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `settings`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'ricardo.gomes@alro.ch', 'users/default.png', NULL, '$2y$10$v8fXEI0c0senTduvcDXf0O65m5obLwflFlJTYGTy5VJNl7dramvDy', NULL, NULL, '2021-04-28 11:53:38', '2021-04-28 11:53:38');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE IF NOT EXISTS `user_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `user_roles_user_id_index` (`user_id`),
  KEY `user_roles_role_id_index` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
