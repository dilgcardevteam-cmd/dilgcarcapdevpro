-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2026 at 05:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capdevpro`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_certifications`
--

CREATE TABLE `account_certifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `certification_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `user_id`, `course_id`, `title`, `message`, `created_at`, `updated_at`) VALUES
(1, 3, 12, 'hi', 'hi', '2026-02-20 06:33:10', '2026-02-20 06:33:10');

-- --------------------------------------------------------

--
-- Table structure for table `announcement_comments`
--

CREATE TABLE `announcement_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `announcement_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('seatwork','quiz','exam') NOT NULL,
  `description` text DEFAULT NULL,
  `questions_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`questions_json`)),
  `due_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_templates`
--

CREATE TABLE `assessment_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('seatwork','quiz','exam') NOT NULL,
  `description` text DEFAULT NULL,
  `questions_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`questions_json`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_templates`
--

INSERT INTO `assessment_templates` (`id`, `user_id`, `title`, `type`, `description`, `questions_json`, `created_at`, `updated_at`) VALUES
(3, 3, 'bbbbbbbbbb', 'seatwork', 'ggggggggggg', '\"[{\\\"type\\\":\\\"multiple_choice\\\",\\\"text\\\":\\\"hhhhhhhhhh\\\",\\\"choices\\\":[\\\"hhhhhhhhhhhhha\\\",\\\"zzzzzzzzzz\\\"],\\\"answer_index\\\":0},{\\\"type\\\":\\\"identification\\\",\\\"text\\\":\\\"zzzzzzzzz\\\",\\\"answer\\\":\\\"zzzzzzzzzzzzz\\\"},{\\\"type\\\":\\\"true_false\\\",\\\"text\\\":\\\"zzzzzzzzzzzzzzzzzzzz\\\",\\\"answer\\\":true}]\"', '2026-02-22 21:12:03', '2026-02-22 21:12:03');

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
-- Table structure for table `calendar_events`
--

CREATE TABLE `calendar_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'event',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certifications`
--

CREATE TABLE `certifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `display_on_landing_page` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `certifications`
--

INSERT INTO `certifications` (`id`, `name`, `category`, `file_path`, `display_on_landing_page`, `created_at`, `updated_at`) VALUES
(4, 'a', 'Core Governance & Administration', 'certifications/rDrOOf3fEx4bp9kdaV3uGQdx6zBtXNOfVmx3o8aq.png', 0, '2026-02-23 05:23:43', '2026-02-23 05:23:43');

-- --------------------------------------------------------

--
-- Table structure for table `certification_user`
--

CREATE TABLE `certification_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `certification_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `certificate_number` varchar(20) DEFAULT NULL,
  `issued_at` timestamp NULL DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `certification_user`
--

INSERT INTO `certification_user` (`id`, `certification_id`, `user_id`, `course_id`, `certificate_number`, `issued_at`, `file_path`, `created_at`, `updated_at`) VALUES
(8, 4, 4, 18, 'Cert 0001', '2026-02-23 11:52:58', NULL, '2026-02-23 11:52:58', '2026-02-23 11:52:58');

-- --------------------------------------------------------

--
-- Table structure for table `class_announcements`
--

CREATE TABLE `class_announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_announcements`
--

INSERT INTO `class_announcements` (`id`, `course_id`, `user_id`, `title`, `body`, `created_at`, `updated_at`) VALUES
(1, 12, 4, 'hi', 'hi', '2026-02-20 08:13:02', '2026-02-20 08:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `class_comments`
--

CREATE TABLE `class_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_announcement_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_comments`
--

INSERT INTO `class_comments` (`id`, `class_announcement_id`, `user_id`, `body`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'hey', '2026-02-20 08:13:22', '2026-02-20 08:13:22');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `subject_area` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `modules` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`modules`)),
  `video_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `subject_area`, `video_url`, `image_path`, `modules`, `video_path`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Basic Research', 'try', 'Core Governance & Administration', 'https://www.youtube.com/watch?v=CC3IrUVRZpM&list=RDCC3IrUVRZpM&start_radio=1&pp=oAcB0gcJCZEKAYcqIYzv', 'course_images/XTqpIw3p1ZsCH9j3KpwrE9b8z45Wa7xKwWk6ZuUh.jpg', '[{\"title\":\"test\",\"topics\":[{\"title\":\"test\",\"fields\":[{\"type\":\"text\",\"html\":\"zxczxcxz\"},{\"type\":\"text\",\"html\":\"wdawdawdawzzzzz\"}]}]}]', NULL, '2026-02-15 17:44:06', '2026-02-25 16:15:21', NULL),
(6, 'dilgcar', 'dilgcar', 'Digital Transformation', 'https://www.youtube.com/watch?v=CC3IrUVRZpM&list=RDCC3IrUVRZpM&start_radio=1&pp=oAcB0gcJCZEKAYcqIYzv', 'course_images/MBMeDeTFk60bqYAZWEh4YzqScaRzVFe8VtMs1ARg.png', NULL, NULL, '2026-02-15 22:37:24', '2026-02-15 22:37:24', NULL),
(11, 'Basic Research', 'researchh', 'Core Governance & Administration', '', 'course_images/6yYf9JaMY83ijZ5f2GPnsZ49pWmsAhGU437m9hls.jpg', '[{\"title\":\"mod1\",\"topics\":[{\"title\":\"intro\",\"subtopics\":[{\"title\":\"first time\",\"fields\":[{\"type\":\"text\",\"html\":\"hi\"}]},{\"title\":\"why is hould take it\",\"fields\":[{\"type\":\"text\",\"html\":\"hello\"}]},{\"title\":\"video\",\"fields\":[{\"type\":\"text\",\"html\":\"<p>[video removed]<\\/p>\"}]},{\"title\":\"pic\",\"fields\":[{\"type\":\"text\",\"html\":\"<p>[image removed]<\\/p><br>\"}]},{\"title\":\"multiple choice\",\"fields\":[{\"type\":\"question\",\"question\":{\"type\":\"multiple_choice\",\"title\":\"pogi ako\",\"required\":false,\"options\":[\"oo\",\"hindi\"],\"answer_index\":0}}]},{\"title\":\"\",\"fields\":null},{\"title\":\"\",\"fields\":null}]}]},{\"title\":\"try\",\"topics\":[{\"title\":\"try\",\"subtopics\":[{\"title\":\"try\",\"fields\":[{\"type\":\"text\",\"html\":\"\"}]}]},{\"title\":\"try\",\"fields\":null},{\"title\":\"try\",\"fields\":null},{\"title\":\"try\",\"subtopics\":[{\"title\":\"try\",\"fields\":null},{\"title\":\"try\",\"fields\":null}]}]},{\"title\":\"try again\",\"topics\":[{\"title\":\"yey\",\"subtopics\":[{\"title\":\"yey\",\"fields\":[{\"type\":\"text\",\"html\":\"\"}]},{\"title\":\"yey\",\"fields\":null}]}]}]', NULL, '2026-02-18 07:01:03', '2026-02-18 07:01:03', NULL),
(12, 'NATURE AND TYPES OF LOCAL GOVERNMENTS', 'Local governments are administrative units established to manage specific areas within a country. They are responsible for delivering public services, enforcing laws, promoting development, and addressing community needs. They operate with a degree of autonomy granted by national law.', 'Core Governance & Administration', '', 'course_images/WtIZ3NheIfsS9nVdQrKV54rH4bVCTTa4DlkJ5VxM.jpg', '[{\"title\":\"Everything is Nature\",\"topics\":[{\"title\":\"Introduction\",\"subtopics\":[{\"title\":\"First Time in the Course\",\"fields\":[{\"type\":\"text\",\"html\":\"<p style=\\\"overflow-wrap: break-word; color: rgb(0, 0, 0); font-family: CiscoSansTT, Arial, sans-serif; font-size: 16px; background-color: rgb(240, 240, 240);\\\"><span style=\\\"font-weight: 600;\\\">First Time in this Course<\\/span><\\/p><p style=\\\"overflow-wrap: break-word; color: rgb(0, 0, 0); font-family: CiscoSansTT, Arial, sans-serif; font-size: 16px; background-color: rgb(240, 240, 240);\\\">Did you know that farmers can put sensors on their crops that tell them when to water, how much water is needed, and when to harvest? With this information, farmers can get the best quality and quantity from their crops. Coal miners can place sensors in a mine that detect tiny amounts of dangerous gases. This information saves lives. Automobile insurance companies can offer drivers lower rates in exchange for access to their driving data. This allows for fairer and more accurate pricing and increases profits while lowering costs.<\\/p><p style=\\\"overflow-wrap: break-word; color: rgb(0, 0, 0); font-family: CiscoSansTT, Arial, sans-serif; font-size: 16px; background-color: rgb(240, 240, 240);\\\">The IoT is about data. The IoT is about digitizing aspects of our lives, our businesses, and our governments to provide actionable insights into how lives can be saved, efficiencies can be created, and communities can be improved. Maybe you would like a career in the IoT.<\\/p><p style=\\\"overflow-wrap: break-word; color: rgb(0, 0, 0); font-family: CiscoSansTT, Arial, sans-serif; font-size: 16px; background-color: rgb(240, 240, 240);\\\">The Introduction to the Internet of Things course (I2IoT) explains what the IoT is, what it does, how it is part of digital transformation, and how you can become part of this. You will learn about the exponential increase of intelligent devices connected to the internet and you will learn to program one of these intelligent devices. The course explains artificial intelligence and the impact of automation to our future. Lastly you will understand the increased importance of privacy and security.<\\/p><p style=\\\"overflow-wrap: break-word; color: rgb(0, 0, 0); font-family: CiscoSansTT, Arial, sans-serif; font-size: 16px; background-color: rgb(240, 240, 240);\\\">The goal of this course is to explain the Internet of Things and digital technology and to highlight how these two factors are now part of a broader category called digital transformation.<\\/p><p style=\\\"overflow-wrap: break-word; color: rgb(0, 0, 0); font-family: CiscoSansTT, Arial, sans-serif; font-size: 16px; background-color: rgb(240, 240, 240);\\\">After completing this course, you will be able to do the following:<\\/p><ul style=\\\"color: rgb(0, 0, 0); font-family: CiscoSansTT, Arial, sans-serif; font-size: 16px; background-color: rgb(240, 240, 240);\\\"><li>Explain the meaning and impact of digital transformation.<\\/li><li>Apply basic programming to support IoT devices.<\\/li><li>Explain how data provides value to digital business and society.<\\/li><li>Explain the benefits of automation in the digitized world.<\\/li><li>Explain the need for enhanced security in the digitized world.<\\/li><li>Discover opportunities provided by digital transformation.<\\/li><\\/ul>\"}]},{\"title\":\"Why Should I Take this Course?\",\"fields\":[{\"type\":\"text\",\"html\":\"<span style=\\\"color: rgb(0, 0, 0); font-family: CiscoSansTT, Arial, sans-serif; font-size: 16px;\\\">Hello! Welcome to the Internet of Things! I\\u2019m Iota, and I\\u2019ll be your Tour Guide. What did you think of that video? Do you have any of that technology in your home or car? Is that a smartphone in your hand? Then I\\u2019ll bet that much of the Internet of Things, or as we like to call it, the IoT, is already familiar to you. Do you use your smartphone to stay connected to family and friends? If so, your smartphone is the center of your own network, and your network is part of the IoT. But the IoT is so much more! Are you ready? Let\\u2019s go!<\\/span>\"}]}]}]},{\"title\":\"Everthing is human\",\"topics\":[{\"title\":\"Basic Human Data\",\"subtopics\":[{\"title\":\"Importance of Data\",\"fields\":[{\"type\":\"text\",\"html\":\"<p style=\\\"overflow-wrap: break-word; color: rgb(0, 0, 0); font-family: CiscoSansTT, Arial, sans-serif; font-size: 16px; background-color: rgb(240, 240, 240);\\\">Data comes from a variety of sources, such as people, pictures, text, sensors, and web sites. Data also comes from devices like cell phones, computers, kiosks, tablets, and cash registers. Most recently, there has been a spike in the volume of data generated by sensors. Sensors are now installed in an ever-growing number of locations and objects. These include security cameras, traffic lights, intelligent cars, thermometers, and even grape vines!<\\/p><p style=\\\"overflow-wrap: break-word; color: rgb(0, 0, 0); font-family: CiscoSansTT, Arial, sans-serif; font-size: 16px; background-color: rgb(240, 240, 240);\\\">Big Data is a lot of data, but what is a lot? No one has an exact number that says when data from an organization is considered \\u201cBig Data.\\u201d Here are three characteristics that indicate an organization may be dealing with Big Data:<\\/p><ul style=\\\"color: rgb(0, 0, 0); font-family: CiscoSansTT, Arial, sans-serif; font-size: 16px; background-color: rgb(240, 240, 240);\\\"><li>They have a large amount of data that increasingly requires more storage space (volume).<\\/li><li>They have an amount of data that is growing at ever-increasing speed (velocity).<\\/li><li>They have data that is generated in different formats (variety).<\\/li><\\/ul><p style=\\\"overflow-wrap: break-word; color: rgb(0, 0, 0); font-family: CiscoSansTT, Arial, sans-serif; font-size: 16px; background-color: rgb(240, 240, 240);\\\">How much data do sensors collect? Here are some estimated examples. For comparison, assume that the average MP3 song is about 3 megabytes.<\\/p><ul style=\\\"color: rgb(0, 0, 0); font-family: CiscoSansTT, Arial, sans-serif; font-size: 16px; background-color: rgb(240, 240, 240);\\\"><li>Sensors in one smart connected home can produce as much as 1 gigabyte (GB) of information a week, or the equivalent of 333 MP3 songs.<\\/li><li>Sensors in one autonomous car can generate 4,000 gigabits (Gb) of data per day. That\\u2019s 500 gigabytes (GB) of data, which is the equivalent of about 167,000 MP3 songs.<\\/li><li>Safety sensors in mining operations can generate up to 2.4 terabits (TB) of data every minute. That is 300 GB or about 100,000 MP3 songs.<\\/li><li>An Airbus A380 Engine generates 1 petabyte (PB) of data on a flight from London to Singapore. That is one million GB, or about 334 million MP3 songs.<\\/li><\\/ul><p style=\\\"overflow-wrap: break-word; color: rgb(0, 0, 0); font-family: CiscoSansTT, Arial, sans-serif; font-size: 16px; background-color: rgb(240, 240, 240);\\\">While Big Data does create challenges for organizations in terms of storage and analytics, it can also provide invaluable information to fine-tune operations and improve customer satisfaction.<\\/p>\"},{\"type\":\"question\",\"question\":{\"type\":\"multiple_choice\",\"title\":\"An orange grove company has sensors in the trees and on the machines that harvest the oranges. A camera mounted on the harvester takes a close-up picture of the orange every 5 minutes. Live data is sent to the distributor who gets this data from 100 companies. Does the distributor have big data?\",\"required\":false,\"options\":[\"Yes\",\"No\"],\"answer_index\":0,\"feedback_correct\":\"Yes, the vendor is getting lots of data (volume) and getting it live (velocity). The distributor is also getting different kinds of data.\",\"feedback_incorrect\":\"because the amount of data may still be small enough for regular systems.\"}},{\"type\":\"question\",\"question\":{\"type\":\"multiple_choice\",\"title\":\"An independent t-shirt vendor advertises through Facebook and other social media sites. The vendor receives statistics on the customer demographics. Does the vendor have big data?\",\"required\":false,\"options\":[\"Yes\",\"No\"],\"answer_index\":1,\"feedback_incorrect\":\"Not really\\u2026the vendor\\u2019s customers are generating big data on the social media sites and the vendor is getting results of that big data, but the vendor does not have to deal with the volume, storage, and variety of the data as is required in big data.\"}}]}]}]}]', NULL, '2026-02-18 17:15:25', '2026-02-18 17:15:25', NULL),
(17, 'aaaa', 'aaaaaaaaaaaaaaaa', 'Finance & Compliance', '', 'course_images/S7NVTmSvM4JGj142vw0OWF6OuaQj9rtOtVU70WMu.jpg', '[{\"title\":\"a\",\"topics\":[{\"title\":\"aaaaaaaaaaaaaaa\",\"subtopics\":[{\"title\":\"aaaaaaaaaaaaaaaaaaaa\",\"fields\":[{\"type\":\"text\",\"html\":\"aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\"},{\"type\":\"question\",\"question\":{\"type\":\"multiple_choice\",\"title\":\"aaaaaaaaa\",\"required\":false,\"options\":[\"aaaaaaaaaaaaaaaa\",\"aaaaaaaaaaaaaaaaaaaaaaaaa\"]}},{\"type\":\"reflection\",\"prompts\":[\"What did you learn?\"]}]}]},{\"title\":\"aaaaaaaaaaaaaaaaaa\",\"subtopics\":[{\"title\":\"aaaaaaaaaaaaaa\",\"fields\":[{\"type\":\"reflection\",\"prompts\":[\"What did you learn?\"]}]},{\"title\":\"aaaaaaaaaaaaaaaaaaa\",\"fields\":[{\"type\":\"reflection\",\"prompts\":[\"What did you learn?\"]}]}]},{\"title\":\"aaaaaaaaaaaaaaaa\",\"subtopics\":[{\"title\":\"aaaaaaaaaaaaaaaa\",\"fields\":[{\"type\":\"reflection\",\"prompts\":[\"What did you learn?\"]}]},{\"title\":\"aaaaaaaaaaaaaaaaaaaaaaaa\",\"fields\":[{\"type\":\"question\",\"question\":{\"type\":\"multiple_choice\",\"title\":\"aaaaaaaaaaa\",\"required\":false,\"options\":[\"aaa\",\"aa\"]}},{\"type\":\"reflection\",\"prompts\":[\"What did you learn?\"]}]}]}]}]', NULL, '2026-02-22 06:29:07', '2026-02-22 06:29:07', NULL),
(18, 'aa', 'aaaaaaaaaaaaaaaaaaaaaa', 'Finance & Compliance', '', 'course_images/UZ28mDDHB0pjeaq6Z3OLLYKxEOZG2m9n0McXBW5v.jpg', '[{\"title\":\"aaaaaaaa\",\"topics\":[{\"title\":\"aaaaaaaaaaaaa\",\"subtopics\":[{\"title\":\"aaaaaaaaaaaaaaaaa\",\"fields\":[{\"type\":\"text\",\"html\":\"aaaaaaaaaaaaa\"},{\"type\":\"reflection\",\"prompts\":[\"What did you learn?\"]}]}]}]}]', NULL, '2026-02-23 00:58:40', '2026-02-23 00:58:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_user`
--

CREATE TABLE `course_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_user`
--

INSERT INTO `course_user` (`id`, `course_id`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(13, 11, 'active', 1, '2026-02-18 07:01:03', '2026-02-18 07:01:03'),
(14, 11, 'active', 4, '2026-02-18 07:02:07', '2026-02-18 07:02:39'),
(15, 12, 'active', 12, '2026-02-18 17:15:25', '2026-02-18 17:15:25'),
(16, 12, 'active', 4, '2026-02-18 17:15:55', '2026-02-18 17:16:53'),
(17, 12, 'active', 3, '2026-02-18 17:16:53', '2026-02-18 17:16:53'),
(19, 2, 'active', 12, '2026-02-18 22:45:38', '2026-02-18 22:45:38'),
(22, 12, 'pending', 15, '2026-02-20 02:39:58', '2026-02-20 02:39:58'),
(23, 12, 'pending', 16, '2026-02-21 01:02:07', '2026-02-21 01:02:07'),
(24, 6, 'pending', 16, '2026-02-21 01:05:42', '2026-02-21 01:05:42'),
(35, 17, 'active', 12, '2026-02-22 06:29:07', '2026-02-22 06:29:07'),
(36, 17, 'active', 4, '2026-02-22 06:29:41', '2026-02-22 06:30:01'),
(37, 18, 'active', 12, '2026-02-23 00:58:40', '2026-02-23 00:58:40'),
(38, 18, 'active', 4, '2026-02-23 00:59:10', '2026-02-23 00:59:47'),
(39, 18, 'active', 3, '2026-02-23 00:59:47', '2026-02-23 00:59:47'),
(43, 2, 'active', 17, '2026-02-25 13:48:17', '2026-02-25 13:53:24'),
(44, 2, 'active', 3, '2026-02-25 13:53:35', '2026-02-25 13:53:35');

-- --------------------------------------------------------

--
-- Table structure for table `deletion_audits`
--

CREATE TABLE `deletion_audits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `actor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `entity_type` varchar(20) NOT NULL,
  `entity_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(20) NOT NULL,
  `meta_json` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discussions`
--

CREATE TABLE `discussions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `body` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discussions`
--

INSERT INTO `discussions` (`id`, `course_id`, `user_id`, `title`, `body`, `image_path`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 12, 3, 'ssssssssssssssss', 'sssssssssss', NULL, '2026-02-21 03:44:09', '2026-02-21 03:44:21', '2026-02-21 03:44:21'),
(7, 12, 4, 'asssssssssssssss', 'assssssssssss', NULL, '2026-02-22 06:41:22', '2026-02-22 06:42:11', '2026-02-22 06:42:11'),
(8, 12, 4, 'asssssssssss', 'sassssssssss', NULL, '2026-02-22 06:43:06', '2026-02-22 06:43:06', NULL),
(9, 12, 4, 'qqqqqqqqqqqqqqqqq', 'qqqqqqqqqqqqqqq', 'discussion_images/q4y1NNl7SyTGiqLbJEQObB3XSIpKmpvmTGffHx3b.png', '2026-02-22 07:51:07', '2026-02-22 07:51:19', '2026-02-22 07:51:19'),
(10, 17, 4, 'ddddddddd', 'dddddddddddddddddd', NULL, '2026-02-22 10:26:45', '2026-02-22 10:26:45', NULL),
(11, 2, 17, 'testt', 'testtwdadawdawddawdwa', NULL, '2026-02-25 14:16:46', '2026-02-25 14:16:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `discussion_reactions`
--

CREATE TABLE `discussion_reactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `discussion_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('like','dislike') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discussion_replies`
--

CREATE TABLE `discussion_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `discussion_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discussion_replies`
--

INSERT INTO `discussion_replies` (`id`, `discussion_id`, `user_id`, `body`, `parent_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 7, 4, 'asassss', NULL, '2026-02-22 06:41:28', '2026-02-22 06:41:44', '2026-02-22 06:41:44'),
(5, 7, 4, 'aasssssssss', NULL, '2026-02-22 06:41:48', '2026-02-22 06:42:05', '2026-02-22 06:42:05'),
(6, 8, 4, 'hi', NULL, '2026-02-22 07:38:02', '2026-02-22 07:38:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `discussion_reply_reactions`
--

CREATE TABLE `discussion_reply_reactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `discussion_reply_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('like','dislike') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assessment_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `score` decimal(8,2) DEFAULT NULL,
  `submission_file_path` varchar(255) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `landing_page_contents`
--

CREATE TABLE `landing_page_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'file',
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
(4, '2026_02_04_001235_add_address_fields_to_users_table', 1),
(5, '2026_02_05_001341_remove_postal_code_from_users_table', 1),
(6, '2026_02_05_002742_add_role_to_users_table', 1),
(7, '2026_02_05_012811_add_status_to_users_table', 1),
(8, '2026_02_05_021111_create_courses_table', 1),
(9, '2026_02_05_024217_create_course_user_table', 1),
(10, '2026_02_05_024223_change_default_user_status_to_pending', 1),
(11, '2026_02_05_035610_add_deleted_at_to_courses_table', 1),
(12, '2026_02_05_054835_create_email_logs_table', 1),
(13, '2026_02_06_014442_add_subject_area_to_courses_table', 1),
(14, '2026_02_06_020217_add_status_to_course_user_table', 1),
(15, '2026_02_06_033455_create_materials_table', 1),
(16, '2026_02_06_033456_create_assessments_table', 1),
(17, '2026_02_06_033456_create_grades_table', 1),
(18, '2026_02_06_052739_create_questions_table', 1),
(19, '2026_02_06_052811_add_user_id_to_assessments_table', 1),
(20, '2026_02_06_053242_make_course_id_nullable_in_assessments', 1),
(21, '2026_02_06_055759_make_video_url_nullable_in_courses_table', 1),
(22, '2026_02_06_063049_add_missing_status_to_course_user_table', 1),
(23, '2026_02_06_071119_create_calendar_events_table', 1),
(24, '2026_02_06_120000_create_announcements_table', 1),
(25, '2026_02_06_082929_add_job_title_to_users_table', 2),
(26, '2026_02_06_084219_create_landing_page_contents_table', 3),
(27, '2026_02_06_085632_add_display_details_to_users_table', 3),
(28, '2026_02_06_144204_create_certifications_table', 4),
(29, '2026_02_06_144206_create_certification_user_table', 4),
(30, '2026_02_06_154202_add_landing_display_type_to_users_table', 5),
(31, '2026_02_06_160525_add_submission_file_path_to_grades_table', 6),
(32, '2026_02_06_162100_add_display_on_landing_to_users_table', 7),
(33, '2026_02_06_162934_add_display_type_to_users_table', 8),
(34, '2026_02_06_172545_create_notifications_table', 9),
(35, '2026_02_06_230332_update_notifications_table', 10),
(36, '2026_02_13_000001_add_google_id_to_users_table', 11),
(37, '2026_02_13_020000_add_mobile_number_and_gender_to_users_table', 11),
(38, '2026_02_16_000001_add_modules_to_courses_table', 11),
(39, '2026_02_16_000001_create_modules_table', 12),
(40, '2026_02_16_000002_create_topics_table', 12),
(41, '2026_02_16_000002_add_video_path_to_courses_table', 13),
(42, '2026_02_19_000001_add_profile_completed_to_users_table', 13),
(43, '2026_02_19_000002_add_date_of_birth_to_users_table', 14),
(44, '2026_02_19_000003_add_questions_json_to_assessments_table', 15),
(45, '2026_02_20_000001_create_account_certifications_table', 15),
(46, '2026_02_20_000010_add_account_id_to_users_table', 15),
(47, '2026_02_20_000001_add_course_id_to_announcements', 16),
(48, '2026_02_20_000002_create_announcement_comments_table', 16),
(49, '2026_02_20_000001_create_class_announcements_table', 17),
(50, '2026_02_20_000002_create_class_comments_table', 17),
(51, '2026_02_20_000101_create_discussions_table', 18),
(52, '2026_02_20_000102_create_discussion_replies_table', 18),
(53, '2026_02_21_000201_add_image_path_to_discussions_table', 19),
(54, '2026_02_21_001101_create_assessment_templates_table', 19),
(55, '2026_02_21_120000_create_reflection_responses_table', 19),
(56, '2026_02_21_180000_add_parent_id_to_discussion_replies_table', 19),
(57, '2026_02_21_180100_create_discussion_reply_reactions_table', 19),
(58, '2026_02_21_190000_add_deleted_at_to_discussions_and_replies', 20),
(59, '2026_02_21_200000_create_deletion_audits_table', 21),
(60, '2026_02_22_000000_create_discussion_reactions_table', 21),
(61, '2026_02_23_000500_add_fields_to_certification_user_table', 22),
(62, '2026_02_23_001000_add_file_path_to_certification_user_table', 23),
(63, '2026_02_24_000001_create_regions_table', 24),
(64, '2026_02_24_000002_create_provinces_table', 25);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `position` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `course_id`, `title`, `position`, `created_at`, `updated_at`) VALUES
(1, 6, 'testing', 0, '2026-02-15 22:37:24', '2026-02-15 22:37:24');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `type` varchar(255) DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `related_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `is_read`, `type`, `data`, `created_at`, `updated_at`, `link`, `related_id`) VALUES
(3, 2, 'New User Registration', 'New user dilgcar has registered and is awaiting approval.', 1, 'registration', NULL, '2026-02-06 17:26:19', '2026-02-06 17:26:46', 'http://127.0.0.1:8000/dashboard?tab=user-management&search=dilgcar', 8),
(4, 2, 'New User Registration', 'New user Atty. Anthony C. Nuyda has registered and is awaiting approval.', 1, 'registration', NULL, '2026-02-06 17:54:00', '2026-02-06 17:54:24', 'http://127.0.0.1:8000/dashboard?tab=user-management&search=Atty.%20Anthony%20C.%20Nuyda', 9),
(5, 2, 'New User Registration', 'New user Shaquile L. Buraga has registered and is awaiting approval.', 1, 'registration', NULL, '2026-02-06 17:57:10', '2026-02-15 17:39:50', 'http://127.0.0.1:8000/dashboard?tab=user-management&search=Shaquile%20L.%20Buraga', 10),
(6, 1, 'New Course Submission', 'Trainer Trainer User submitted \'trainer\' for review.', 0, 'course_submission', NULL, '2026-02-17 22:21:03', '2026-02-17 22:21:03', 'http://127.0.0.1:8000/dashboard?tab=course-management', 9),
(10, 2, 'Course Enrollment Request', 'User Trainee User requested to join course trainer.', 1, 'enrollment', NULL, '2026-02-17 23:08:06', '2026-02-17 23:08:45', 'http://127.0.0.1:8000/dashboard?tab=trainer-trainee-management', 4),
(11, 3, 'Course Assignment', 'You have been assigned as a trainer for the course: Operation Listo LGU Disaster Preparedness Manual for Landslide V1.', 0, 'course_assignment', NULL, '2026-02-17 23:55:54', '2026-02-17 23:55:54', 'http://127.0.0.1:8000/dashboard', 1),
(12, 4, 'Course Enrollment', 'You have been enrolled in the course: Operation Listo LGU Disaster Preparedness Manual for Landslide V1.', 0, 'enrollment_approved', NULL, '2026-02-17 23:55:54', '2026-02-17 23:55:54', 'http://127.0.0.1:8000/dashboard', 1),
(14, 4, 'Course Enrollment Approved', 'Your request to join the course trainer has been approved.', 0, 'enrollment_approved', NULL, '2026-02-18 00:01:30', '2026-02-18 00:01:30', 'http://127.0.0.1:8000/dashboard', 9),
(15, 2, 'Course Enrollment Request', 'User Trainee User requested to join course a.', 0, 'enrollment', NULL, '2026-02-18 00:27:42', '2026-02-18 00:27:42', 'http://127.0.0.1:8000/dashboard?tab=trainer-trainee-management', 4),
(16, 3, 'Course Assignment', 'You have been assigned as a trainer for the course: a.', 1, 'course_assignment', NULL, '2026-02-18 00:28:15', '2026-02-18 21:18:45', 'http://127.0.0.1:8000/dashboard', 10),
(17, 4, 'Course Enrollment Approved', 'Your request to join the course a has been approved.', 0, 'enrollment_approved', NULL, '2026-02-18 00:28:15', '2026-02-18 00:28:15', 'http://127.0.0.1:8000/dashboard', 10),
(18, 2, 'Course Enrollment Request', 'User Trainee User requested to join course Basic Research.', 1, 'enrollment', NULL, '2026-02-18 07:02:07', '2026-02-18 22:47:37', 'http://127.0.0.1:8000/dashboard?tab=trainer-trainee-management', 4),
(19, 4, 'Course Enrollment Approved', 'Your request to join the course Basic Research has been approved.', 0, 'enrollment_approved', NULL, '2026-02-18 07:02:39', '2026-02-18 07:02:39', 'http://127.0.0.1:8000/dashboard', 11),
(20, 2, 'New User Registration', 'New user try try try has registered and is awaiting approval.', 1, 'registration', NULL, '2026-02-18 13:52:29', '2026-02-18 13:54:31', 'http://127.0.0.1:8000/dashboard?tab=user-management&search=try%20try%20try', 11),
(21, 2, 'New User Registration', 'New user Admin Admin Admin has registered and is awaiting approval.', 1, 'registration', NULL, '2026-02-18 16:38:33', '2026-02-18 22:47:08', 'http://127.0.0.1:8000/dashboard?tab=user-management&search=Admin%20Admin%20Admin', 12),
(22, 2, 'Course Enrollment Request', 'User Trainee User requested to join course NATURE AND TYPES OF LOCAL GOVERNMENTS.', 1, 'enrollment', NULL, '2026-02-18 17:15:55', '2026-02-18 22:46:59', 'http://127.0.0.1:8000/dashboard?tab=trainer-trainee-management', 4),
(23, 3, 'Course Assignment', 'You have been assigned as a trainer for the course: NATURE AND TYPES OF LOCAL GOVERNMENTS.', 0, 'course_assignment', NULL, '2026-02-18 17:16:53', '2026-02-18 17:16:53', 'http://127.0.0.1:8000/dashboard', 12),
(24, 4, 'Course Enrollment Approved', 'Your request to join the course NATURE AND TYPES OF LOCAL GOVERNMENTS has been approved.', 1, 'enrollment_approved', NULL, '2026-02-18 17:16:53', '2026-02-18 22:50:30', 'http://127.0.0.1:8000/dashboard', 12),
(25, 2, 'New User Registration', 'New user Mark G Zareno has registered and is awaiting approval.', 0, 'registration', NULL, '2026-02-18 23:32:02', '2026-02-18 23:32:02', 'http://127.0.0.1:8000/dashboard?tab=user-management&search=Mark%20G%20Zareno', 13),
(26, 2, 'New User Registration', 'New user Kevin Aquino has registered and is awaiting approval.', 0, 'registration', NULL, '2026-02-18 23:47:00', '2026-02-18 23:47:00', 'http://127.0.0.1:8000/dashboard?tab=user-management&search=Kevin%20Aquino', 14),
(27, 2, 'Course Enrollment Request', 'User Kevin Aquino requested to join course NATURE AND TYPES OF LOCAL GOVERNMENTS.', 1, 'enrollment', NULL, '2026-02-19 00:01:35', '2026-02-19 00:05:30', 'http://127.0.0.1:8000/dashboard?tab=trainer-trainee-management', 14),
(29, 2, 'Course Enrollment Request', 'User Kevin Aquino requested to join course Operation Listo LGU Disaster Preparedness Manual for Landslide V1.', 0, 'enrollment', NULL, '2026-02-19 00:28:02', '2026-02-19 00:28:02', 'http://127.0.0.1:8000/dashboard?tab=trainer-trainee-management', 14),
(30, 2, 'New User Registration', 'New user try try has registered and is awaiting approval.', 0, 'registration', NULL, '2026-02-19 17:55:21', '2026-02-19 17:55:21', 'http://127.0.0.1:8000/dashboard?tab=user-management&search=try%20try', 15),
(31, 2, 'Course Enrollment Request', 'User try try requested to join course NATURE AND TYPES OF LOCAL GOVERNMENTS.', 0, 'enrollment', NULL, '2026-02-20 02:39:58', '2026-02-20 02:39:58', 'http://127.0.0.1:8000/dashboard?tab=trainer-trainee-management', 15),
(32, 2, 'New User Registration', 'New user Law Malanum has registered and is awaiting approval.', 0, 'registration', NULL, '2026-02-21 00:58:20', '2026-02-21 00:58:20', 'http://127.0.0.1:8000/dashboard?tab=user-management&search=Law%20Malanum', 16),
(33, 2, 'Course Enrollment Request', 'User Law Malanum requested to join course NATURE AND TYPES OF LOCAL GOVERNMENTS.', 1, 'enrollment', NULL, '2026-02-21 01:02:07', '2026-02-21 01:05:54', 'http://127.0.0.1:8000/dashboard?tab=trainer-trainee-management', 16),
(34, 2, 'Course Enrollment Request', 'User Law Malanum requested to join course dilgcar.', 0, 'enrollment', NULL, '2026-02-21 01:05:42', '2026-02-21 01:05:42', 'http://127.0.0.1:8000/dashboard?tab=trainer-trainee-management', 16),
(35, 2, 'Course Enrollment Request', 'User Trainee User requested to join course a.', 0, 'enrollment', NULL, '2026-02-21 07:08:34', '2026-02-21 07:08:34', 'http://127.0.0.1:8000/dashboard?tab=trainer-trainee-management', 4),
(36, 4, 'Course Enrollment Approved', 'Your request to join the course a has been approved.', 0, 'enrollment_approved', NULL, '2026-02-21 07:09:06', '2026-02-21 07:09:06', 'http://127.0.0.1:8000/dashboard', 13),
(37, 2, 'Course Enrollment Request', 'User Trainee User requested to join course s.', 0, 'enrollment', NULL, '2026-02-21 07:26:46', '2026-02-21 07:26:46', 'http://127.0.0.1:8000/dashboard?tab=trainer-trainee-management', 4),
(38, 3, 'Course Assignment', 'You have been assigned as a trainer for the course: s.', 0, 'course_assignment', NULL, '2026-02-21 07:28:01', '2026-02-21 07:28:01', 'http://127.0.0.1:8000/dashboard', 14),
(39, 4, 'Course Enrollment Approved', 'Your request to join the course s has been approved.', 0, 'enrollment_approved', NULL, '2026-02-21 07:28:01', '2026-02-21 07:28:01', 'http://127.0.0.1:8000/dashboard', 14),
(40, 2, 'Course Enrollment Request', 'User Trainee User requested to join course Finance.', 0, 'enrollment', NULL, '2026-02-22 02:06:52', '2026-02-22 02:06:52', 'http://127.0.0.1:8000/dashboard?tab=trainer-trainee-management', 4),
(41, 3, 'Course Assignment', 'You have been assigned as a trainer for the course: Finance.', 0, 'course_assignment', NULL, '2026-02-22 02:07:28', '2026-02-22 02:07:28', 'http://127.0.0.1:8000/dashboard', 16),
(42, 2, 'Course Enrollment Request', 'User Trainee User requested to join course Finance.', 0, 'enrollment', NULL, '2026-02-22 02:08:40', '2026-02-22 02:08:40', 'http://127.0.0.1:8000/dashboard?tab=trainer-trainee-management', 4),
(43, 4, 'Course Enrollment Approved', 'Your request to join the course Finance has been approved.', 0, 'enrollment_approved', NULL, '2026-02-22 02:08:49', '2026-02-22 02:08:49', 'http://127.0.0.1:8000/dashboard', 16),
(44, 2, 'Course Enrollment Request', 'User Trainee User requested to join course aaaa.', 0, 'enrollment', NULL, '2026-02-22 06:29:41', '2026-02-22 06:29:41', 'http://127.0.0.1:8000/dashboard?tab=trainer-trainee-management', 4),
(45, 4, 'Course Enrollment Approved', 'Your request to join the course aaaa has been approved.', 0, 'enrollment_approved', NULL, '2026-02-22 06:30:01', '2026-02-22 06:30:01', 'http://127.0.0.1:8000/dashboard', 17),
(46, 2, 'Course Enrollment Request', 'User Trainee User requested to join course aa.', 0, 'enrollment', NULL, '2026-02-23 00:59:10', '2026-02-23 00:59:10', 'http://127.0.0.1:8000/dashboard?tab=trainer-trainee-management', 4),
(47, 3, 'Course Assignment', 'You have been assigned as a trainer for the course: aa.', 0, 'course_assignment', NULL, '2026-02-23 00:59:47', '2026-02-23 00:59:47', 'http://127.0.0.1:8000/dashboard', 18),
(48, 4, 'Course Enrollment Approved', 'Your request to join the course aa has been approved.', 0, 'enrollment_approved', NULL, '2026-02-23 00:59:47', '2026-02-23 00:59:47', 'http://127.0.0.1:8000/dashboard', 18),
(49, 2, 'New User Registration', 'New user Billy John Ferreol has registered and is awaiting approval.', 0, 'registration', NULL, '2026-02-24 01:04:07', '2026-02-24 01:04:07', 'http://127.0.0.1:8000/dashboard?tab=user-management&search=Billy%20John%20Ferreol', 17),
(50, 2, 'Course Enrollment Request', 'User Billy John Ferreol requested to join course Basic Research.', 0, 'enrollment', NULL, '2026-02-25 13:48:17', '2026-02-25 13:48:17', 'http://127.0.0.1:8000/dashboard?tab=trainer-trainee-management', 17),
(51, 17, 'Course Enrollment Approved', 'Your request to join the course Basic Research has been approved.', 1, 'enrollment_approved', NULL, '2026-02-25 13:53:24', '2026-02-25 14:46:28', 'http://127.0.0.1:8000/dashboard', 2),
(52, 3, 'Course Assignment', 'You have been assigned as a trainer for the course: Basic Research.', 0, 'course_assignment', NULL, '2026-02-25 13:53:35', '2026-02-25 13:53:35', 'http://127.0.0.1:8000/dashboard', 2);

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
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `region_id` bigint(20) UNSIGNED NOT NULL,
  `province_code` varchar(10) NOT NULL,
  `province_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `region_id`, `province_code`, `province_name`, `created_at`, `updated_at`) VALUES
(1741, 1, '1380100000', 'City of Caloocan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1742, 1, '1380200000', 'City of Las Pi–as', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1743, 1, '1380300000', 'City of Makati', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1744, 1, '1380400000', 'City of Malabon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1745, 1, '1380500000', 'City of Mandaluyong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1746, 1, '1380600000', 'City of Manila', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1747, 1, '1380601000', 'Tondo I/II', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1748, 1, '1380602000', 'Binondo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1749, 1, '1380603000', 'Quiapo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1750, 1, '1380604000', 'San Nicolas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1751, 1, '1380605000', 'Santa Cruz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1752, 1, '1380606000', 'Sampaloc', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1753, 1, '1380607000', 'San Miguel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1754, 1, '1380608000', 'Ermita', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1755, 1, '1380609000', 'Intramuros', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1756, 1, '1380610000', 'Malate', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1757, 1, '1380611000', 'Paco', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1758, 1, '1380612000', 'Pandacan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1759, 1, '1380613000', 'Port Area', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1760, 1, '1380614000', 'Santa Ana', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1761, 1, '1380700000', 'City of Marikina', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1762, 1, '1380800000', 'City of Muntinlupa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1763, 1, '1380900000', 'City of Navotas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1764, 1, '1381000000', 'City of Para–aque', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1765, 1, '1381100000', 'Pasay City', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1766, 1, '1381200000', 'City of Pasig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1767, 1, '1381300000', 'Quezon City', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1768, 1, '1381400000', 'City of San Juan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1769, 1, '1381500000', 'City of Taguig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1770, 1, '1381600000', 'City of Valenzuela', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1771, 1, '1381701000', 'Pateros', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1772, 2, '1400100000', 'Abra', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1773, 2, '1400101000', 'Bangued', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1774, 2, '1400102000', 'Boliney', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1775, 2, '1400103000', 'Bucay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1776, 2, '1400104000', 'Bucloc', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1777, 2, '1400105000', 'Daguioman', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1778, 2, '1400106000', 'Danglas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1779, 2, '1400107000', 'Dolores', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1780, 2, '1400108000', 'La Paz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1781, 2, '1400109000', 'Lacub', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1782, 2, '1400110000', 'Lagangilang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1783, 2, '1400111000', 'Lagayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1784, 2, '1400112000', 'Langiden', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1785, 2, '1400113000', 'Licuan-Baay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1786, 2, '1400114000', 'Luba', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1787, 2, '1400115000', 'Malibcong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1788, 2, '1400116000', 'Manabo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1789, 2, '1400117000', 'Pe–arrubia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1790, 2, '1400118000', 'Pidigan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1791, 2, '1400119000', 'Pilar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1792, 2, '1400120000', 'Sallapadan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1793, 2, '1400121000', 'San Isidro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1794, 2, '1400122000', 'San Juan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1795, 2, '1400123000', 'San Quintin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1796, 2, '1400124000', 'Tayum', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1797, 2, '1400125000', 'Tineg', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1798, 2, '1400126000', 'Tubo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1799, 2, '1400127000', 'Villaviciosa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1800, 2, '1401100000', 'Benguet', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1801, 2, '1401101000', 'Atok', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1802, 2, '1401103000', 'Bakun', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1803, 2, '1401104000', 'Bokod', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1804, 2, '1401105000', 'Buguias', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1805, 2, '1401106000', 'Itogon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1806, 2, '1401107000', 'Kabayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1807, 2, '1401108000', 'Kapangan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1808, 2, '1401109000', 'Kibungan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1809, 2, '1401110000', 'La Trinidad', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1810, 2, '1401111000', 'Mankayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1811, 2, '1401112000', 'Sablan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1812, 2, '1401113000', 'Tuba', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1813, 2, '1401114000', 'Tublay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1814, 2, '1402700000', 'Ifugao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1815, 2, '1402701000', 'Banaue', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1816, 2, '1402702000', 'Hungduan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1817, 2, '1402703000', 'Kiangan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1818, 2, '1402704000', 'Lagawe', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1819, 2, '1402705000', 'Lamut', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1820, 2, '1402706000', 'Mayoyao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1821, 2, '1402707000', 'Alfonso Lista', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1822, 2, '1402708000', 'Aguinaldo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1823, 2, '1402709000', 'Hingyon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1824, 2, '1402710000', 'Tinoc', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1825, 2, '1402711000', 'Asipulo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1826, 2, '1403200000', 'Kalinga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1827, 2, '1403201000', 'Balbalan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1828, 2, '1403206000', 'Lubuagan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1829, 2, '1403208000', 'Pasil', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1830, 2, '1403209000', 'Pinukpuk', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1831, 2, '1403211000', 'Rizal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1832, 2, '1403213000', 'City of Tabuk', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1833, 2, '1403214000', 'Tanudan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1834, 2, '1403215000', 'Tinglayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1835, 2, '1404400000', 'Mountain Province', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1836, 2, '1404401000', 'Barlig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1837, 2, '1404402000', 'Bauko', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1838, 2, '1404403000', 'Besao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1839, 2, '1404404000', 'Bontoc', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1840, 2, '1404405000', 'Natonin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1841, 2, '1404406000', 'Paracelis', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1842, 2, '1404407000', 'Sabangan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1843, 2, '1404408000', 'Sadanga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1844, 2, '1404409000', 'Sagada', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1845, 2, '1404410000', 'Tadian', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1846, 2, '1408100000', 'Apayao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1847, 2, '1408101000', 'Calanasan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1848, 2, '1408102000', 'Conner', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1849, 2, '1408103000', 'Flora', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1850, 2, '1408104000', 'Kabugao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1851, 2, '1408105000', 'Luna', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1852, 2, '1408106000', 'Pudtol', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1853, 2, '1408107000', 'Santa Marcela', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1854, 2, '1430300000', 'City of Baguio', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1855, 3, '0102800000', 'Ilocos Norte', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1856, 3, '0102801000', 'Adams', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1857, 3, '0102802000', 'Bacarra', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1858, 3, '0102803000', 'Badoc', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1859, 3, '0102804000', 'Bangui', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1860, 3, '0102805000', 'City of Batac', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1861, 3, '0102806000', 'Burgos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1862, 3, '0102807000', 'Carasi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1863, 3, '0102808000', 'Currimao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1864, 3, '0102809000', 'Dingras', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1865, 3, '0102810000', 'Dumalneg', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1866, 3, '0102811000', 'Banna', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1867, 3, '0102812000', 'City of Laoag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1868, 3, '0102813000', 'Marcos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1869, 3, '0102814000', 'Nueva Era', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1870, 3, '0102815000', 'Pagudpud', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1871, 3, '0102816000', 'Paoay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1872, 3, '0102817000', 'Pasuquin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1873, 3, '0102818000', 'Piddig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1874, 3, '0102819000', 'Pinili', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1875, 3, '0102820000', 'San Nicolas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1876, 3, '0102821000', 'Sarrat', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1877, 3, '0102822000', 'Solsona', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1878, 3, '0102823000', 'Vintar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1879, 3, '0102900000', 'Ilocos Sur', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1880, 3, '0102901000', 'Alilem', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1881, 3, '0102902000', 'Banayoyo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1882, 3, '0102903000', 'Bantay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1883, 3, '0102904000', 'Burgos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1884, 3, '0102905000', 'Cabugao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1885, 3, '0102906000', 'City of Candon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1886, 3, '0102907000', 'Caoayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1887, 3, '0102908000', 'Cervantes', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1888, 3, '0102909000', 'Galimuyod', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1889, 3, '0102910000', 'Gregorio del Pilar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1890, 3, '0102911000', 'Lidlidda', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1891, 3, '0102912000', 'Magsingal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1892, 3, '0102913000', 'Nagbukel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1893, 3, '0102914000', 'Narvacan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1894, 3, '0102915000', 'Quirino', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1895, 3, '0102916000', 'Salcedo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1896, 3, '0102917000', 'San Emilio', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1897, 3, '0102918000', 'San Esteban', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1898, 3, '0102919000', 'San Ildefonso', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1899, 3, '0102920000', 'San Juan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1900, 3, '0102921000', 'San Vicente', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1901, 3, '0102922000', 'Santa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1902, 3, '0102923000', 'Santa Catalina', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1903, 3, '0102924000', 'Santa Cruz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1904, 3, '0102925000', 'Santa Lucia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1905, 3, '0102926000', 'Santa Maria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1906, 3, '0102927000', 'Santiago', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1907, 3, '0102928000', 'Santo Domingo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1908, 3, '0102929000', 'Sigay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1909, 3, '0102930000', 'Sinait', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1910, 3, '0102931000', 'Sugpon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1911, 3, '0102932000', 'Suyo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1912, 3, '0102933000', 'Tagudin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1913, 3, '0102934000', 'City of Vigan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1914, 3, '0103300000', 'La Union', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1915, 3, '0103301000', 'Agoo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1916, 3, '0103302000', 'Aringay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1917, 3, '0103303000', 'Bacnotan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1918, 3, '0103304000', 'Bagulin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1919, 3, '0103305000', 'Balaoan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1920, 3, '0103306000', 'Bangar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1921, 3, '0103307000', 'Bauang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1922, 3, '0103308000', 'Burgos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1923, 3, '0103309000', 'Caba', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1924, 3, '0103310000', 'Luna', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1925, 3, '0103311000', 'Naguilian', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1926, 3, '0103312000', 'Pugo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1927, 3, '0103313000', 'Rosario', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1928, 3, '0103314000', 'City of San Fernando', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1929, 3, '0103315000', 'San Gabriel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1930, 3, '0103316000', 'San Juan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1931, 3, '0103317000', 'Santo Tomas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1932, 3, '0103318000', 'Santol', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1933, 3, '0103319000', 'Sudipen', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1934, 3, '0103320000', 'Tubao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1935, 3, '0105500000', 'Pangasinan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1936, 3, '0105501000', 'Agno', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1937, 3, '0105502000', 'Aguilar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1938, 3, '0105503000', 'City of Alaminos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1939, 3, '0105504000', 'Alcala', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1940, 3, '0105505000', 'Anda', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1941, 3, '0105506000', 'Asingan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1942, 3, '0105507000', 'Balungao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1943, 3, '0105508000', 'Bani', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1944, 3, '0105509000', 'Basista', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1945, 3, '0105510000', 'Bautista', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1946, 3, '0105511000', 'Bayambang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1947, 3, '0105512000', 'Binalonan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1948, 3, '0105513000', 'Binmaley', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1949, 3, '0105514000', 'Bolinao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1950, 3, '0105515000', 'Bugallon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1951, 3, '0105516000', 'Burgos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1952, 3, '0105517000', 'Calasiao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1953, 3, '0105518000', 'City of Dagupan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1954, 3, '0105519000', 'Dasol', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1955, 3, '0105520000', 'Infanta', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1956, 3, '0105521000', 'Labrador', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1957, 3, '0105522000', 'Lingayen', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1958, 3, '0105523000', 'Mabini', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1959, 3, '0105524000', 'Malasiqui', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1960, 3, '0105525000', 'Manaoag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1961, 3, '0105526000', 'Mangaldan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1962, 3, '0105527000', 'Mangatarem', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1963, 3, '0105528000', 'Mapandan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1964, 3, '0105529000', 'Natividad', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1965, 3, '0105530000', 'Pozorrubio', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1966, 3, '0105531000', 'Rosales', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1967, 3, '0105532000', 'City of San Carlos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1968, 3, '0105533000', 'San Fabian', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1969, 3, '0105534000', 'San Jacinto', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1970, 3, '0105535000', 'San Manuel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1971, 3, '0105536000', 'San Nicolas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1972, 3, '0105537000', 'San Quintin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1973, 3, '0105538000', 'Santa Barbara', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1974, 3, '0105539000', 'Santa Maria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1975, 3, '0105540000', 'Santo Tomas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1976, 3, '0105541000', 'Sison', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1977, 3, '0105542000', 'Sual', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1978, 3, '0105543000', 'Tayug', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1979, 3, '0105544000', 'Umingan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1980, 3, '0105545000', 'Urbiztondo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1981, 3, '0105546000', 'City of Urdaneta', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1982, 3, '0105547000', 'Villasis', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1983, 3, '0105548000', 'Laoac', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1984, 4, '0200900000', 'Batanes', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1985, 4, '0200901000', 'Basco', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1986, 4, '0200902000', 'Itbayat', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1987, 4, '0200903000', 'Ivana', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1988, 4, '0200904000', 'Mahatao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1989, 4, '0200905000', 'Sabtang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1990, 4, '0200906000', 'Uyugan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1991, 4, '0201500000', 'Cagayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1992, 4, '0201501000', 'Abulug', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1993, 4, '0201502000', 'Alcala', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1994, 4, '0201503000', 'Allacapan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1995, 4, '0201504000', 'Amulung', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1996, 4, '0201505000', 'Aparri', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1997, 4, '0201506000', 'Baggao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1998, 4, '0201507000', 'Ballesteros', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(1999, 4, '0201508000', 'Buguey', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2000, 4, '0201509000', 'Calayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2001, 4, '0201510000', 'Camalaniugan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2002, 4, '0201511000', 'Claveria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2003, 4, '0201512000', 'Enrile', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2004, 4, '0201513000', 'Gattaran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2005, 4, '0201514000', 'Gonzaga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2006, 4, '0201515000', 'Iguig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2007, 4, '0201516000', 'Lal-Lo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2008, 4, '0201517000', 'Lasam', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2009, 4, '0201518000', 'Pamplona', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2010, 4, '0201519000', 'Pe–ablanca', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2011, 4, '0201520000', 'Piat', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2012, 4, '0201521000', 'Rizal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2013, 4, '0201522000', 'Sanchez-Mira', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2014, 4, '0201523000', 'Santa Ana', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2015, 4, '0201524000', 'Santa Praxedes', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2016, 4, '0201525000', 'Santa Teresita', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2017, 4, '0201526000', 'Santo Ni–o', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2018, 4, '0201527000', 'Solana', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2019, 4, '0201528000', 'Tuao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2020, 4, '0201529000', 'Tuguegarao City', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2021, 4, '0203100000', 'Isabela', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2022, 4, '0203101000', 'Alicia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2023, 4, '0203102000', 'Angadanan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2024, 4, '0203103000', 'Aurora', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2025, 4, '0203104000', 'Benito Soliven', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2026, 4, '0203105000', 'Burgos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2027, 4, '0203106000', 'Cabagan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2028, 4, '0203107000', 'Cabatuan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2029, 4, '0203108000', 'City of Cauayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2030, 4, '0203109000', 'Cordon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2031, 4, '0203110000', 'Dinapigue', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2032, 4, '0203111000', 'Divilacan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2033, 4, '0203112000', 'Echague', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2034, 4, '0203113000', 'Gamu', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2035, 4, '0203114000', 'City of Ilagan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2036, 4, '0203115000', 'Jones', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2037, 4, '0203116000', 'Luna', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2038, 4, '0203117000', 'Maconacon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2039, 4, '0203118000', 'Delfin Albano', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2040, 4, '0203119000', 'Mallig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2041, 4, '0203120000', 'Naguilian', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2042, 4, '0203121000', 'Palanan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2043, 4, '0203122000', 'Quezon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2044, 4, '0203123000', 'Quirino', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2045, 4, '0203124000', 'Ramon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2046, 4, '0203125000', 'Reina Mercedes', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2047, 4, '0203126000', 'Roxas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2048, 4, '0203127000', 'San Agustin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2049, 4, '0203128000', 'San Guillermo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2050, 4, '0203129000', 'San Isidro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2051, 4, '0203130000', 'San Manuel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2052, 4, '0203131000', 'San Mariano', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2053, 4, '0203132000', 'San Mateo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2054, 4, '0203133000', 'San Pablo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2055, 4, '0203134000', 'Santa Maria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2056, 4, '0203135000', 'City of Santiago', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2057, 4, '0203136000', 'Santo Tomas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2058, 4, '0203137000', 'Tumauini', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2059, 4, '0205000000', 'Nueva Vizcaya', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2060, 4, '0205001000', 'Ambaguio', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2061, 4, '0205002000', 'Aritao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2062, 4, '0205003000', 'Bagabag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2063, 4, '0205004000', 'Bambang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2064, 4, '0205005000', 'Bayombong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2065, 4, '0205006000', 'Diadi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2066, 4, '0205007000', 'Dupax del Norte', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2067, 4, '0205008000', 'Dupax del Sur', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2068, 4, '0205009000', 'Kasibu', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2069, 4, '0205010000', 'Kayapa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2070, 4, '0205011000', 'Quezon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2071, 4, '0205012000', 'Santa Fe', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2072, 4, '0205013000', 'Solano', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2073, 4, '0205014000', 'Villaverde', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2074, 4, '0205015000', 'Alfonso Castaneda', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2075, 4, '0205700000', 'Quirino', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2076, 4, '0205701000', 'Aglipay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2077, 4, '0205702000', 'Cabarroguis', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2078, 4, '0205703000', 'Diffun', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2079, 4, '0205704000', 'Maddela', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2080, 4, '0205705000', 'Saguday', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2081, 4, '0205706000', 'Nagtipunan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2082, 5, '0300800000', 'Bataan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2083, 5, '0300801000', 'Abucay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2084, 5, '0300802000', 'Bagac', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2085, 5, '0300803000', 'City of Balanga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2086, 5, '0300804000', 'Dinalupihan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2087, 5, '0300805000', 'Hermosa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2088, 5, '0300806000', 'Limay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2089, 5, '0300807000', 'Mariveles', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2090, 5, '0300808000', 'Morong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2091, 5, '0300809000', 'Orani', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2092, 5, '0300810000', 'Orion', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2093, 5, '0300811000', 'Pilar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2094, 5, '0300812000', 'Samal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2095, 5, '0301400000', 'Bulacan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2096, 5, '0301401000', 'Angat', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2097, 5, '0301402000', 'Balagtas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2098, 5, '0301403000', 'City of Baliwag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2099, 5, '0301404000', 'Bocaue', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2100, 5, '0301405000', 'Bulacan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2101, 5, '0301406000', 'Bustos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2102, 5, '0301407000', 'Calumpit', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2103, 5, '0301408000', 'Guiguinto', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2104, 5, '0301409000', 'Hagonoy', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2105, 5, '0301410000', 'City of Malolos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2106, 5, '0301411000', 'Marilao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2107, 5, '0301412000', 'City of Meycauayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2108, 5, '0301413000', 'Norzagaray', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2109, 5, '0301414000', 'Obando', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2110, 5, '0301415000', 'Pandi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2111, 5, '0301416000', 'Paombong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2112, 5, '0301417000', 'Plaridel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2113, 5, '0301418000', 'Pulilan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2114, 5, '0301419000', 'San Ildefonso', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2115, 5, '0301420000', 'City of San Jose Del Monte', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2116, 5, '0301421000', 'San Miguel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2117, 5, '0301422000', 'San Rafael', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2118, 5, '0301423000', 'Santa Maria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2119, 5, '0301424000', 'Do–a Remedios Trinidad', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2120, 5, '0304900000', 'Nueva Ecija', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2121, 5, '0304901000', 'Aliaga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2122, 5, '0304902000', 'Bongabon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2123, 5, '0304903000', 'City of Cabanatuan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2124, 5, '0304904000', 'Cabiao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2125, 5, '0304905000', 'Carranglan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2126, 5, '0304906000', 'Cuyapo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2127, 5, '0304907000', 'Gabaldon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2128, 5, '0304908000', 'City of Gapan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2129, 5, '0304909000', 'General Mamerto Natividad', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2130, 5, '0304910000', 'General Tinio', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2131, 5, '0304911000', 'Guimba', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2132, 5, '0304912000', 'Jaen', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2133, 5, '0304913000', 'Laur', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2134, 5, '0304914000', 'Licab', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2135, 5, '0304915000', 'Llanera', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2136, 5, '0304916000', 'Lupao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2137, 5, '0304917000', 'Science City of Mu–oz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2138, 5, '0304918000', 'Nampicuan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2139, 5, '0304919000', 'City of Palayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2140, 5, '0304920000', 'Pantabangan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2141, 5, '0304921000', 'Pe–aranda', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2142, 5, '0304922000', 'Quezon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2143, 5, '0304923000', 'Rizal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2144, 5, '0304924000', 'San Antonio', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2145, 5, '0304925000', 'San Isidro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2146, 5, '0304926000', 'San Jose City', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2147, 5, '0304927000', 'San Leonardo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2148, 5, '0304928000', 'Santa Rosa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2149, 5, '0304929000', 'Santo Domingo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2150, 5, '0304930000', 'Talavera', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2151, 5, '0304931000', 'Talugtug', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2152, 5, '0304932000', 'Zaragoza', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2153, 5, '0305400000', 'Pampanga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2154, 5, '0305402000', 'Apalit', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2155, 5, '0305403000', 'Arayat', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2156, 5, '0305404000', 'Bacolor', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2157, 5, '0305405000', 'Candaba', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2158, 5, '0305406000', 'Floridablanca', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2159, 5, '0305407000', 'Guagua', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2160, 5, '0305408000', 'Lubao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2161, 5, '0305409000', 'Mabalacat City', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2162, 5, '0305410000', 'Macabebe', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2163, 5, '0305411000', 'Magalang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2164, 5, '0305412000', 'Masantol', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2165, 5, '0305413000', 'Mexico', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2166, 5, '0305414000', 'Minalin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2167, 5, '0305415000', 'Porac', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2168, 5, '0305416000', 'City of San Fernando', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2169, 5, '0305417000', 'San Luis', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2170, 5, '0305418000', 'San Simon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2171, 5, '0305419000', 'Santa Ana', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2172, 5, '0305420000', 'Santa Rita', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2173, 5, '0305421000', 'Sto. Tomas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2174, 5, '0305422000', 'Sasmuan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2175, 5, '0306900000', 'Tarlac', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2176, 5, '0306901000', 'Anao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2177, 5, '0306902000', 'Bamban', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2178, 5, '0306903000', 'Camiling', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2179, 5, '0306904000', 'Capas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2180, 5, '0306905000', 'Concepcion', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2181, 5, '0306906000', 'Gerona', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2182, 5, '0306907000', 'La Paz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2183, 5, '0306908000', 'Mayantoc', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2184, 5, '0306909000', 'Moncada', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2185, 5, '0306910000', 'Paniqui', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2186, 5, '0306911000', 'Pura', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2187, 5, '0306912000', 'Ramos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2188, 5, '0306913000', 'San Clemente', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2189, 5, '0306914000', 'San Manuel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2190, 5, '0306915000', 'Santa Ignacia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2191, 5, '0306916000', 'City of Tarlac', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2192, 5, '0306917000', 'Victoria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2193, 5, '0306918000', 'San Jose', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2194, 5, '0307100000', 'Zambales', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2195, 5, '0307101000', 'Botolan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2196, 5, '0307102000', 'Cabangan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2197, 5, '0307103000', 'Candelaria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2198, 5, '0307104000', 'Castillejos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2199, 5, '0307105000', 'Iba', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2200, 5, '0307106000', 'Masinloc', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2201, 5, '0307108000', 'Palauig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2202, 5, '0307109000', 'San Antonio', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2203, 5, '0307110000', 'San Felipe', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2204, 5, '0307111000', 'San Marcelino', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2205, 5, '0307112000', 'San Narciso', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2206, 5, '0307113000', 'Santa Cruz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2207, 5, '0307114000', 'Subic', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2208, 5, '0307700000', 'Aurora', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2209, 5, '0307701000', 'Baler', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2210, 5, '0307702000', 'Casiguran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2211, 5, '0307703000', 'Dilasag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2212, 5, '0307704000', 'Dinalungan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2213, 5, '0307705000', 'Dingalan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2214, 5, '0307706000', 'Dipaculao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2215, 5, '0307707000', 'Maria Aurora', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2216, 5, '0307708000', 'San Luis', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2217, 5, '0330100000', 'City of Angeles', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2218, 5, '0331400000', 'City of Olongapo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2219, 6, '0401000000', 'Batangas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2220, 6, '0401001000', 'Agoncillo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2221, 6, '0401002000', 'Alitagtag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2222, 6, '0401003000', 'Balayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2223, 6, '0401004000', 'Balete', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2224, 6, '0401005000', 'Batangas City', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2225, 6, '0401006000', 'Bauan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2226, 6, '0401007000', 'City of Calaca', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2227, 6, '0401008000', 'Calatagan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2228, 6, '0401009000', 'Cuenca', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2229, 6, '0401010000', 'Ibaan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2230, 6, '0401011000', 'Laurel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2231, 6, '0401012000', 'Lemery', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2232, 6, '0401013000', 'Lian', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2233, 6, '0401014000', 'City of Lipa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2234, 6, '0401015000', 'Lobo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2235, 6, '0401016000', 'Mabini', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2236, 6, '0401017000', 'Malvar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2237, 6, '0401018000', 'Mataasnakahoy', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2238, 6, '0401019000', 'Nasugbu', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2239, 6, '0401020000', 'Padre Garcia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2240, 6, '0401021000', 'Rosario', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2241, 6, '0401022000', 'San Jose', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2242, 6, '0401023000', 'San Juan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2243, 6, '0401024000', 'San Luis', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2244, 6, '0401025000', 'San Nicolas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2245, 6, '0401026000', 'San Pascual', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2246, 6, '0401027000', 'Santa Teresita', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2247, 6, '0401028000', 'City of Sto. Tomas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2248, 6, '0401029000', 'Taal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2249, 6, '0401030000', 'Talisay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2250, 6, '0401031000', 'City of Tanauan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2251, 6, '0401032000', 'Taysan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2252, 6, '0401033000', 'Tingloy', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2253, 6, '0401034000', 'Tuy', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2254, 6, '0402100000', 'Cavite', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2255, 6, '0402101000', 'Alfonso', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2256, 6, '0402102000', 'Amadeo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2257, 6, '0402103000', 'City of Bacoor', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2258, 6, '0402104000', 'City of Carmona', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2259, 6, '0402105000', 'City of Cavite', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2260, 6, '0402106000', 'City of Dasmari–as', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2261, 6, '0402107000', 'General Emilio Aguinaldo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2262, 6, '0402108000', 'City of General Trias', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2263, 6, '0402109000', 'City of Imus', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2264, 6, '0402110000', 'Indang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2265, 6, '0402111000', 'Kawit', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2266, 6, '0402112000', 'Magallanes', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2267, 6, '0402113000', 'Maragondon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2268, 6, '0402114000', 'Mendez', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2269, 6, '0402115000', 'Naic', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2270, 6, '0402116000', 'Noveleta', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2271, 6, '0402117000', 'Rosario', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2272, 6, '0402118000', 'Silang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2273, 6, '0402119000', 'City of Tagaytay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2274, 6, '0402120000', 'Tanza', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2275, 6, '0402121000', 'Ternate', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2276, 6, '0402122000', 'City of Trece Martires', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2277, 6, '0402123000', 'Gen. Mariano Alvarez', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2278, 6, '0403400000', 'Laguna', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2279, 6, '0403401000', 'Alaminos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2280, 6, '0403402000', 'Bay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2281, 6, '0403403000', 'City of Bi–an', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2282, 6, '0403404000', 'City of Cabuyao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2283, 6, '0403405000', 'City of Calamba', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2284, 6, '0403406000', 'Calauan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2285, 6, '0403407000', 'Cavinti', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2286, 6, '0403408000', 'Famy', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2287, 6, '0403409000', 'Kalayaan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2288, 6, '0403410000', 'Liliw', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2289, 6, '0403411000', 'Los Ba–os', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2290, 6, '0403412000', 'Luisiana', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2291, 6, '0403413000', 'Lumban', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2292, 6, '0403414000', 'Mabitac', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2293, 6, '0403415000', 'Magdalena', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2294, 6, '0403416000', 'Majayjay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2295, 6, '0403417000', 'Nagcarlan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2296, 6, '0403418000', 'Paete', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2297, 6, '0403419000', 'Pagsanjan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2298, 6, '0403420000', 'Pakil', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2299, 6, '0403421000', 'Pangil', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2300, 6, '0403422000', 'Pila', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2301, 6, '0403423000', 'Rizal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2302, 6, '0403424000', 'City of San Pablo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2303, 6, '0403425000', 'City of San Pedro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2304, 6, '0403426000', 'Santa Cruz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2305, 6, '0403427000', 'Santa Maria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2306, 6, '0403428000', 'City of Santa Rosa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2307, 6, '0403429000', 'Siniloan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2308, 6, '0403430000', 'Victoria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2309, 6, '0405600000', 'Quezon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2310, 6, '0405601000', 'Agdangan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2311, 6, '0405602000', 'Alabat', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2312, 6, '0405603000', 'Atimonan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2313, 6, '0405605000', 'Buenavista', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2314, 6, '0405606000', 'Burdeos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2315, 6, '0405607000', 'Calauag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2316, 6, '0405608000', 'Candelaria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2317, 6, '0405610000', 'Catanauan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2318, 6, '0405615000', 'Dolores', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2319, 6, '0405616000', 'General Luna', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2320, 6, '0405617000', 'General Nakar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2321, 6, '0405618000', 'Guinayangan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2322, 6, '0405619000', 'Gumaca', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2323, 6, '0405620000', 'Infanta', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2324, 6, '0405621000', 'Jomalig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2325, 6, '0405622000', 'Lopez', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2326, 6, '0405623000', 'Lucban', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2327, 6, '0405625000', 'Macalelon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2328, 6, '0405627000', 'Mauban', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2329, 6, '0405628000', 'Mulanay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2330, 6, '0405629000', 'Padre Burgos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2331, 6, '0405630000', 'Pagbilao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2332, 6, '0405631000', 'Panukulan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2333, 6, '0405632000', 'Patnanungan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2334, 6, '0405633000', 'Perez', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2335, 6, '0405634000', 'Pitogo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2336, 6, '0405635000', 'Plaridel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2337, 6, '0405636000', 'Polillo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2338, 6, '0405637000', 'Quezon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2339, 6, '0405638000', 'Real', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2340, 6, '0405639000', 'Sampaloc', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2341, 6, '0405640000', 'San Andres', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2342, 6, '0405641000', 'San Antonio', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2343, 6, '0405642000', 'San Francisco', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2344, 6, '0405644000', 'San Narciso', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2345, 6, '0405645000', 'Sariaya', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2346, 6, '0405646000', 'Tagkawayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2347, 6, '0405647000', 'City of Tayabas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2348, 6, '0405648000', 'Tiaong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2349, 6, '0405649000', 'Unisan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2350, 6, '0405800000', 'Rizal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2351, 6, '0405801000', 'Angono', '2026-02-24 02:25:17', '2026-02-24 02:25:17');
INSERT INTO `provinces` (`id`, `region_id`, `province_code`, `province_name`, `created_at`, `updated_at`) VALUES
(2352, 6, '0405802000', 'City of Antipolo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2353, 6, '0405803000', 'Baras', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2354, 6, '0405804000', 'Binangonan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2355, 6, '0405805000', 'Cainta', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2356, 6, '0405806000', 'Cardona', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2357, 6, '0405807000', 'Jala-Jala', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2358, 6, '0405808000', 'Rodriguez', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2359, 6, '0405809000', 'Morong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2360, 6, '0405810000', 'Pililla', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2361, 6, '0405811000', 'San Mateo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2362, 6, '0405812000', 'Tanay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2363, 6, '0405813000', 'Taytay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2364, 6, '0405814000', 'Teresa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2365, 6, '0431200000', 'City of Lucena', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2366, 7, '1704000000', 'Marinduque', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2367, 7, '1704001000', 'Boac', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2368, 7, '1704002000', 'Buenavista', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2369, 7, '1704003000', 'Gasan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2370, 7, '1704004000', 'Mogpog', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2371, 7, '1704005000', 'Santa Cruz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2372, 7, '1704006000', 'Torrijos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2373, 7, '1705100000', 'Occidental Mindoro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2374, 7, '1705101000', 'Abra De Ilog', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2375, 7, '1705102000', 'Calintaan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2376, 7, '1705103000', 'Looc', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2377, 7, '1705104000', 'Lubang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2378, 7, '1705105000', 'Magsaysay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2379, 7, '1705106000', 'Mamburao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2380, 7, '1705107000', 'Paluan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2381, 7, '1705108000', 'Rizal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2382, 7, '1705109000', 'Sablayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2383, 7, '1705110000', 'San Jose', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2384, 7, '1705111000', 'Santa Cruz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2385, 7, '1705200000', 'Oriental Mindoro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2386, 7, '1705201000', 'Baco', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2387, 7, '1705202000', 'Bansud', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2388, 7, '1705203000', 'Bongabong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2389, 7, '1705204000', 'Bulalacao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2390, 7, '1705205000', 'City of Calapan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2391, 7, '1705206000', 'Gloria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2392, 7, '1705207000', 'Mansalay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2393, 7, '1705208000', 'Naujan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2394, 7, '1705209000', 'Pinamalayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2395, 7, '1705210000', 'Pola', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2396, 7, '1705211000', 'Puerto Galera', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2397, 7, '1705212000', 'Roxas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2398, 7, '1705213000', 'San Teodoro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2399, 7, '1705214000', 'Socorro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2400, 7, '1705215000', 'Victoria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2401, 7, '1705300000', 'Palawan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2402, 7, '1705301000', 'Aborlan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2403, 7, '1705302000', 'Agutaya', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2404, 7, '1705303000', 'Araceli', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2405, 7, '1705304000', 'Balabac', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2406, 7, '1705305000', 'Bataraza', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2407, 7, '1705306000', 'Brooke\'s Point', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2408, 7, '1705307000', 'Busuanga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2409, 7, '1705308000', 'Cagayancillo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2410, 7, '1705309000', 'Coron', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2411, 7, '1705310000', 'Cuyo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2412, 7, '1705311000', 'Dumaran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2413, 7, '1705312000', 'El Nido', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2414, 7, '1705313000', 'Linapacan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2415, 7, '1705314000', 'Magsaysay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2416, 7, '1705315000', 'Narra', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2417, 7, '1705317000', 'Quezon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2418, 7, '1705318000', 'Roxas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2419, 7, '1705319000', 'San Vicente', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2420, 7, '1705320000', 'Taytay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2421, 7, '1705321000', 'Kalayaan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2422, 7, '1705322000', 'Culion', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2423, 7, '1705323000', 'Dr. Jose P. Rizal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2424, 7, '1705324000', 'Sofronio Espa–ola', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2425, 7, '1705900000', 'Romblon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2426, 7, '1705901000', 'Alcantara', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2427, 7, '1705902000', 'Banton', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2428, 7, '1705903000', 'Cajidiocan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2429, 7, '1705904000', 'Calatrava', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2430, 7, '1705905000', 'Concepcion', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2431, 7, '1705906000', 'Corcuera', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2432, 7, '1705907000', 'Looc', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2433, 7, '1705908000', 'Magdiwang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2434, 7, '1705909000', 'Odiongan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2435, 7, '1705910000', 'Romblon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2436, 7, '1705911000', 'San Agustin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2437, 7, '1705912000', 'San Andres', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2438, 7, '1705913000', 'San Fernando', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2439, 7, '1705914000', 'San Jose', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2440, 7, '1705915000', 'Santa Fe', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2441, 7, '1705916000', 'Ferrol', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2442, 7, '1705917000', 'Santa Maria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2443, 7, '1731500000', 'City of Puerto Princesa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2444, 8, '0500500000', 'Albay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2445, 8, '0500501000', 'Bacacay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2446, 8, '0500502000', 'Camalig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2447, 8, '0500503000', 'Daraga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2448, 8, '0500504000', 'Guinobatan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2449, 8, '0500505000', 'Jovellar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2450, 8, '0500506000', 'City of Legazpi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2451, 8, '0500507000', 'Libon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2452, 8, '0500508000', 'City of Ligao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2453, 8, '0500509000', 'Malilipot', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2454, 8, '0500510000', 'Malinao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2455, 8, '0500511000', 'Manito', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2456, 8, '0500512000', 'Oas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2457, 8, '0500513000', 'Pio Duran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2458, 8, '0500514000', 'Polangui', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2459, 8, '0500515000', 'Rapu-Rapu', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2460, 8, '0500516000', 'Santo Domingo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2461, 8, '0500517000', 'City of Tabaco', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2462, 8, '0500518000', 'Tiwi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2463, 8, '0501600000', 'Camarines Norte', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2464, 8, '0501601000', 'Basud', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2465, 8, '0501602000', 'Capalonga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2466, 8, '0501603000', 'Daet', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2467, 8, '0501604000', 'San Lorenzo Ruiz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2468, 8, '0501605000', 'Jose Panganiban', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2469, 8, '0501606000', 'Labo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2470, 8, '0501607000', 'Mercedes', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2471, 8, '0501608000', 'Paracale', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2472, 8, '0501609000', 'San Vicente', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2473, 8, '0501610000', 'Santa Elena', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2474, 8, '0501611000', 'Talisay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2475, 8, '0501612000', 'Vinzons', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2476, 8, '0501700000', 'Camarines Sur', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2477, 8, '0501701000', 'Baao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2478, 8, '0501702000', 'Balatan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2479, 8, '0501703000', 'Bato', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2480, 8, '0501704000', 'Bombon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2481, 8, '0501705000', 'Buhi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2482, 8, '0501706000', 'Bula', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2483, 8, '0501707000', 'Cabusao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2484, 8, '0501708000', 'Calabanga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2485, 8, '0501709000', 'Camaligan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2486, 8, '0501710000', 'Canaman', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2487, 8, '0501711000', 'Caramoan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2488, 8, '0501712000', 'Del Gallego', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2489, 8, '0501713000', 'Gainza', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2490, 8, '0501714000', 'Garchitorena', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2491, 8, '0501715000', 'Goa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2492, 8, '0501716000', 'City of Iriga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2493, 8, '0501717000', 'Lagonoy', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2494, 8, '0501718000', 'Libmanan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2495, 8, '0501719000', 'Lupi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2496, 8, '0501720000', 'Magarao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2497, 8, '0501721000', 'Milaor', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2498, 8, '0501722000', 'Minalabac', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2499, 8, '0501723000', 'Nabua', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2500, 8, '0501724000', 'City of Naga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2501, 8, '0501725000', 'Ocampo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2502, 8, '0501726000', 'Pamplona', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2503, 8, '0501727000', 'Pasacao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2504, 8, '0501728000', 'Pili', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2505, 8, '0501729000', 'Presentacion', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2506, 8, '0501730000', 'Ragay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2507, 8, '0501731000', 'Sag–ay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2508, 8, '0501732000', 'San Fernando', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2509, 8, '0501733000', 'San Jose', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2510, 8, '0501734000', 'Sipocot', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2511, 8, '0501735000', 'Siruma', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2512, 8, '0501736000', 'Tigaon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2513, 8, '0501737000', 'Tinambac', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2514, 8, '0502000000', 'Catanduanes', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2515, 8, '0502001000', 'Bagamanoc', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2516, 8, '0502002000', 'Baras', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2517, 8, '0502003000', 'Bato', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2518, 8, '0502004000', 'Caramoran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2519, 8, '0502005000', 'Gigmoto', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2520, 8, '0502006000', 'Pandan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2521, 8, '0502007000', 'Panganiban', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2522, 8, '0502008000', 'San Andres', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2523, 8, '0502009000', 'San Miguel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2524, 8, '0502010000', 'Viga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2525, 8, '0502011000', 'Virac', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2526, 8, '0504100000', 'Masbate', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2527, 8, '0504101000', 'Aroroy', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2528, 8, '0504102000', 'Baleno', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2529, 8, '0504103000', 'Balud', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2530, 8, '0504104000', 'Batuan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2531, 8, '0504105000', 'Cataingan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2532, 8, '0504106000', 'Cawayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2533, 8, '0504107000', 'Claveria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2534, 8, '0504108000', 'Dimasalang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2535, 8, '0504109000', 'Esperanza', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2536, 8, '0504110000', 'Mandaon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2537, 8, '0504111000', 'City of Masbate', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2538, 8, '0504112000', 'Milagros', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2539, 8, '0504113000', 'Mobo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2540, 8, '0504114000', 'Monreal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2541, 8, '0504115000', 'Palanas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2542, 8, '0504116000', 'Pio V. Corpus', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2543, 8, '0504117000', 'Placer', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2544, 8, '0504118000', 'San Fernando', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2545, 8, '0504119000', 'San Jacinto', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2546, 8, '0504120000', 'San Pascual', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2547, 8, '0504121000', 'Uson', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2548, 8, '0506200000', 'Sorsogon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2549, 8, '0506202000', 'Barcelona', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2550, 8, '0506203000', 'Bulan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2551, 8, '0506204000', 'Bulusan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2552, 8, '0506205000', 'Casiguran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2553, 8, '0506206000', 'Castilla', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2554, 8, '0506207000', 'Donsol', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2555, 8, '0506208000', 'Gubat', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2556, 8, '0506209000', 'Irosin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2557, 8, '0506210000', 'Juban', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2558, 8, '0506211000', 'Magallanes', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2559, 8, '0506212000', 'Matnog', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2560, 8, '0506213000', 'Pilar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2561, 8, '0506214000', 'Prieto Diaz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2562, 8, '0506215000', 'Santa Magdalena', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2563, 8, '0506216000', 'City of Sorsogon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2564, 9, '0600400000', 'Aklan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2565, 9, '0600401000', 'Altavas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2566, 9, '0600402000', 'Balete', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2567, 9, '0600403000', 'Banga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2568, 9, '0600404000', 'Batan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2569, 9, '0600405000', 'Buruanga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2570, 9, '0600406000', 'Ibajay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2571, 9, '0600407000', 'Kalibo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2572, 9, '0600408000', 'Lezo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2573, 9, '0600409000', 'Libacao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2574, 9, '0600410000', 'Madalag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2575, 9, '0600411000', 'Makato', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2576, 9, '0600412000', 'Malay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2577, 9, '0600413000', 'Malinao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2578, 9, '0600414000', 'Nabas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2579, 9, '0600415000', 'New Washington', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2580, 9, '0600416000', 'Numancia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2581, 9, '0600417000', 'Tangalan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2582, 9, '0600600000', 'Antique', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2583, 9, '0600601000', 'Anini-Y', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2584, 9, '0600602000', 'Barbaza', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2585, 9, '0600603000', 'Belison', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2586, 9, '0600604000', 'Bugasong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2587, 9, '0600605000', 'Caluya', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2588, 9, '0600606000', 'Culasi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2589, 9, '0600607000', 'Tobias Fornier', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2590, 9, '0600608000', 'Hamtic', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2591, 9, '0600609000', 'Laua-An', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2592, 9, '0600610000', 'Libertad', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2593, 9, '0600611000', 'Pandan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2594, 9, '0600612000', 'Patnongon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2595, 9, '0600613000', 'San Jose', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2596, 9, '0600614000', 'San Remigio', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2597, 9, '0600615000', 'Sebaste', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2598, 9, '0600616000', 'Sibalom', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2599, 9, '0600617000', 'Tibiao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2600, 9, '0600618000', 'Valderrama', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2601, 9, '0601900000', 'Capiz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2602, 9, '0601901000', 'Cuartero', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2603, 9, '0601902000', 'Dao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2604, 9, '0601903000', 'Dumalag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2605, 9, '0601904000', 'Dumarao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2606, 9, '0601905000', 'Ivisan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2607, 9, '0601906000', 'Jamindan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2608, 9, '0601907000', 'Ma-Ayon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2609, 9, '0601908000', 'Mambusao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2610, 9, '0601909000', 'Panay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2611, 9, '0601910000', 'Panitan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2612, 9, '0601911000', 'Pilar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2613, 9, '0601912000', 'Pontevedra', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2614, 9, '0601913000', 'President Roxas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2615, 9, '0601914000', 'City of Roxas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2616, 9, '0601915000', 'Sapi-An', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2617, 9, '0601916000', 'Sigma', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2618, 9, '0601917000', 'Tapaz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2619, 9, '0603000000', 'Iloilo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2620, 9, '0603001000', 'Ajuy', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2621, 9, '0603002000', 'Alimodian', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2622, 9, '0603003000', 'Anilao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2623, 9, '0603004000', 'Badiangan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2624, 9, '0603005000', 'Balasan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2625, 9, '0603006000', 'Banate', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2626, 9, '0603007000', 'Barotac Nuevo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2627, 9, '0603008000', 'Barotac Viejo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2628, 9, '0603009000', 'Batad', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2629, 9, '0603010000', 'Bingawan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2630, 9, '0603012000', 'Cabatuan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2631, 9, '0603013000', 'Calinog', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2632, 9, '0603014000', 'Carles', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2633, 9, '0603015000', 'Concepcion', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2634, 9, '0603016000', 'Dingle', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2635, 9, '0603017000', 'Due–as', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2636, 9, '0603018000', 'Dumangas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2637, 9, '0603019000', 'Estancia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2638, 9, '0603020000', 'Guimbal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2639, 9, '0603021000', 'Igbaras', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2640, 9, '0603023000', 'Janiuay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2641, 9, '0603025000', 'Lambunao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2642, 9, '0603026000', 'Leganes', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2643, 9, '0603027000', 'Lemery', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2644, 9, '0603028000', 'Leon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2645, 9, '0603029000', 'Maasin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2646, 9, '0603030000', 'Miagao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2647, 9, '0603031000', 'Mina', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2648, 9, '0603032000', 'New Lucena', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2649, 9, '0603034000', 'Oton', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2650, 9, '0603035000', 'City of Passi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2651, 9, '0603036000', 'Pavia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2652, 9, '0603037000', 'Pototan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2653, 9, '0603038000', 'San Dionisio', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2654, 9, '0603039000', 'San Enrique', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2655, 9, '0603040000', 'San Joaquin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2656, 9, '0603041000', 'San Miguel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2657, 9, '0603042000', 'San Rafael', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2658, 9, '0603043000', 'Santa Barbara', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2659, 9, '0603044000', 'Sara', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2660, 9, '0603045000', 'Tigbauan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2661, 9, '0603046000', 'Tubungan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2662, 9, '0603047000', 'Zarraga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2663, 9, '0607900000', 'Guimaras', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2664, 9, '0607901000', 'Buenavista', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2665, 9, '0607902000', 'Jordan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2666, 9, '0607903000', 'Nueva Valencia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2667, 9, '0607904000', 'San Lorenzo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2668, 9, '0607905000', 'Sibunag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2669, 9, '0631000000', 'City of Iloilo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2670, 10, '1804500000', 'Negros Occidental', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2671, 10, '1804502000', 'City of Bago', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2672, 10, '1804503000', 'Binalbagan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2673, 10, '1804504000', 'City of Cadiz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2674, 10, '1804505000', 'Calatrava', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2675, 10, '1804506000', 'Candoni', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2676, 10, '1804507000', 'Cauayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2677, 10, '1804508000', 'Enrique B. Magalona', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2678, 10, '1804509000', 'City of Escalante', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2679, 10, '1804510000', 'City of Himamaylan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2680, 10, '1804511000', 'Hinigaran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2681, 10, '1804512000', 'Hinoba-an', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2682, 10, '1804513000', 'Ilog', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2683, 10, '1804514000', 'Isabela', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2684, 10, '1804515000', 'City of Kabankalan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2685, 10, '1804516000', 'City of La Carlota', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2686, 10, '1804517000', 'La Castellana', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2687, 10, '1804518000', 'Manapla', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2688, 10, '1804519000', 'Moises Padilla', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2689, 10, '1804520000', 'Murcia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2690, 10, '1804521000', 'Pontevedra', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2691, 10, '1804522000', 'Pulupandan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2692, 10, '1804523000', 'City of Sagay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2693, 10, '1804524000', 'City of San Carlos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2694, 10, '1804525000', 'San Enrique', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2695, 10, '1804526000', 'City of Silay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2696, 10, '1804527000', 'City of Sipalay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2697, 10, '1804528000', 'City of Talisay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2698, 10, '1804529000', 'Toboso', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2699, 10, '1804530000', 'Valladolid', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2700, 10, '1804531000', 'City of Victorias', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2701, 10, '1804532000', 'Salvador Benedicto', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2702, 10, '1804600000', 'Negros Oriental', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2703, 10, '1804601000', 'Amlan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2704, 10, '1804602000', 'Ayungon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2705, 10, '1804603000', 'Bacong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2706, 10, '1804604000', 'City of Bais', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2707, 10, '1804605000', 'Basay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2708, 10, '1804606000', 'City of Bayawan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2709, 10, '1804607000', 'Bindoy', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2710, 10, '1804608000', 'City of Canlaon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2711, 10, '1804609000', 'Dauin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2712, 10, '1804610000', 'City of Dumaguete', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2713, 10, '1804611000', 'City of Guihulngan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2714, 10, '1804612000', 'Jimalalud', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2715, 10, '1804613000', 'La Libertad', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2716, 10, '1804614000', 'Mabinay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2717, 10, '1804615000', 'Manjuyod', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2718, 10, '1804616000', 'Pamplona', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2719, 10, '1804617000', 'San Jose', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2720, 10, '1804618000', 'Santa Catalina', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2721, 10, '1804619000', 'Siaton', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2722, 10, '1804620000', 'Sibulan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2723, 10, '1804621000', 'City of Tanjay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2724, 10, '1804622000', 'Tayasan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2725, 10, '1804623000', 'Valencia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2726, 10, '1804624000', 'Vallehermoso', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2727, 10, '1804625000', 'Zamboanguita', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2728, 10, '1806100000', 'Siquijor', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2729, 10, '1806101000', 'Enrique Villanueva', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2730, 10, '1806102000', 'Larena', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2731, 10, '1806103000', 'Lazi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2732, 10, '1806104000', 'Maria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2733, 10, '1806105000', 'San Juan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2734, 10, '1806106000', 'Siquijor', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2735, 10, '1830200000', 'City of Bacolod', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2736, 11, '0701200000', 'Bohol', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2737, 11, '0701201000', 'Alburquerque', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2738, 11, '0701202000', 'Alicia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2739, 11, '0701203000', 'Anda', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2740, 11, '0701204000', 'Antequera', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2741, 11, '0701205000', 'Baclayon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2742, 11, '0701206000', 'Balilihan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2743, 11, '0701207000', 'Batuan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2744, 11, '0701208000', 'Bilar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2745, 11, '0701209000', 'Buenavista', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2746, 11, '0701210000', 'Calape', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2747, 11, '0701211000', 'Candijay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2748, 11, '0701212000', 'Carmen', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2749, 11, '0701213000', 'Catigbian', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2750, 11, '0701214000', 'Clarin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2751, 11, '0701215000', 'Corella', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2752, 11, '0701216000', 'Cortes', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2753, 11, '0701217000', 'Dagohoy', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2754, 11, '0701218000', 'Danao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2755, 11, '0701219000', 'Dauis', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2756, 11, '0701220000', 'Dimiao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2757, 11, '0701221000', 'Duero', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2758, 11, '0701222000', 'Garcia Hernandez', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2759, 11, '0701223000', 'Guindulman', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2760, 11, '0701224000', 'Inabanga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2761, 11, '0701225000', 'Jagna', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2762, 11, '0701226000', 'Getafe', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2763, 11, '0701227000', 'Lila', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2764, 11, '0701228000', 'Loay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2765, 11, '0701229000', 'Loboc', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2766, 11, '0701230000', 'Loon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2767, 11, '0701231000', 'Mabini', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2768, 11, '0701232000', 'Maribojoc', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2769, 11, '0701233000', 'Panglao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2770, 11, '0701234000', 'Pilar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2771, 11, '0701235000', 'President Carlos P. Garcia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2772, 11, '0701236000', 'Sagbayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2773, 11, '0701237000', 'San Isidro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2774, 11, '0701238000', 'San Miguel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2775, 11, '0701239000', 'Sevilla', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2776, 11, '0701240000', 'Sierra Bullones', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2777, 11, '0701241000', 'Sikatuna', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2778, 11, '0701242000', 'City of Tagbilaran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2779, 11, '0701243000', 'Talibon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2780, 11, '0701244000', 'Trinidad', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2781, 11, '0701245000', 'Tubigon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2782, 11, '0701246000', 'Ubay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2783, 11, '0701247000', 'Valencia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2784, 11, '0701248000', 'Bien Unido', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2785, 11, '0702200000', 'Cebu', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2786, 11, '0702201000', 'Alcantara', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2787, 11, '0702202000', 'Alcoy', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2788, 11, '0702203000', 'Alegria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2789, 11, '0702204000', 'Aloguinsan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2790, 11, '0702205000', 'Argao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2791, 11, '0702206000', 'Asturias', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2792, 11, '0702207000', 'Badian', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2793, 11, '0702208000', 'Balamban', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2794, 11, '0702209000', 'Bantayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2795, 11, '0702210000', 'Barili', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2796, 11, '0702211000', 'City of Bogo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2797, 11, '0702212000', 'Boljoon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2798, 11, '0702213000', 'Borbon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2799, 11, '0702214000', 'City of Carcar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2800, 11, '0702215000', 'Carmen', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2801, 11, '0702216000', 'Catmon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2802, 11, '0702218000', 'Compostela', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2803, 11, '0702219000', 'Consolacion', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2804, 11, '0702220000', 'Cordova', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2805, 11, '0702221000', 'Daanbantayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2806, 11, '0702222000', 'Dalaguete', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2807, 11, '0702223000', 'Danao City', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2808, 11, '0702224000', 'Dumanjug', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2809, 11, '0702225000', 'Ginatilan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2810, 11, '0702227000', 'Liloan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2811, 11, '0702228000', 'Madridejos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2812, 11, '0702229000', 'Malabuyoc', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2813, 11, '0702231000', 'Medellin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2814, 11, '0702232000', 'Minglanilla', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2815, 11, '0702233000', 'Moalboal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2816, 11, '0702234000', 'City of Naga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2817, 11, '0702235000', 'Oslob', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2818, 11, '0702236000', 'Pilar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2819, 11, '0702237000', 'Pinamungajan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2820, 11, '0702238000', 'Poro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2821, 11, '0702239000', 'Ronda', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2822, 11, '0702240000', 'Samboan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2823, 11, '0702241000', 'San Fernando', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2824, 11, '0702242000', 'San Francisco', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2825, 11, '0702243000', 'San Remigio', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2826, 11, '0702244000', 'Santa Fe', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2827, 11, '0702245000', 'Santander', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2828, 11, '0702246000', 'Sibonga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2829, 11, '0702247000', 'Sogod', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2830, 11, '0702248000', 'Tabogon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2831, 11, '0702249000', 'Tabuelan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2832, 11, '0702250000', 'City of Talisay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2833, 11, '0702251000', 'City of Toledo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2834, 11, '0702252000', 'Tuburan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2835, 11, '0702253000', 'Tudela', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2836, 11, '0730600000', 'City of Cebu', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2837, 11, '0731100000', 'City of Lapu-Lapu', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2838, 11, '0731300000', 'City of Mandaue', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2839, 12, '0802600000', 'Eastern Samar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2840, 12, '0802601000', 'Arteche', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2841, 12, '0802602000', 'Balangiga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2842, 12, '0802603000', 'Balangkayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2843, 12, '0802604000', 'City of Borongan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2844, 12, '0802605000', 'Can-Avid', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2845, 12, '0802606000', 'Dolores', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2846, 12, '0802607000', 'General Macarthur', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2847, 12, '0802608000', 'Giporlos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2848, 12, '0802609000', 'Guiuan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2849, 12, '0802610000', 'Hernani', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2850, 12, '0802611000', 'Jipapad', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2851, 12, '0802612000', 'Lawaan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2852, 12, '0802613000', 'Llorente', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2853, 12, '0802614000', 'Maslog', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2854, 12, '0802615000', 'Maydolong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2855, 12, '0802616000', 'Mercedes', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2856, 12, '0802617000', 'Oras', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2857, 12, '0802618000', 'Quinapondan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2858, 12, '0802619000', 'Salcedo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2859, 12, '0802620000', 'San Julian', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2860, 12, '0802621000', 'San Policarpo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2861, 12, '0802622000', 'Sulat', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2862, 12, '0802623000', 'Taft', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2863, 12, '0803700000', 'Leyte', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2864, 12, '0803701000', 'Abuyog', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2865, 12, '0803702000', 'Alangalang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2866, 12, '0803703000', 'Albuera', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2867, 12, '0803705000', 'Babatngon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2868, 12, '0803706000', 'Barugo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2869, 12, '0803707000', 'Bato', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2870, 12, '0803708000', 'City of Baybay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2871, 12, '0803710000', 'Burauen', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2872, 12, '0803713000', 'Calubian', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2873, 12, '0803714000', 'Capoocan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2874, 12, '0803715000', 'Carigara', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2875, 12, '0803717000', 'Dagami', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2876, 12, '0803718000', 'Dulag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2877, 12, '0803719000', 'Hilongos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2878, 12, '0803720000', 'Hindang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2879, 12, '0803721000', 'Inopacan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2880, 12, '0803722000', 'Isabel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2881, 12, '0803723000', 'Jaro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2882, 12, '0803724000', 'Javier', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2883, 12, '0803725000', 'Julita', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2884, 12, '0803726000', 'Kananga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2885, 12, '0803728000', 'La Paz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2886, 12, '0803729000', 'Leyte', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2887, 12, '0803730000', 'Macarthur', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2888, 12, '0803731000', 'Mahaplag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2889, 12, '0803733000', 'Matag-Ob', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2890, 12, '0803734000', 'Matalom', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2891, 12, '0803735000', 'Mayorga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2892, 12, '0803736000', 'Merida', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2893, 12, '0803738000', 'Ormoc City', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2894, 12, '0803739000', 'Palo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2895, 12, '0803740000', 'Palompon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2896, 12, '0803741000', 'Pastrana', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2897, 12, '0803742000', 'San Isidro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2898, 12, '0803743000', 'San Miguel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2899, 12, '0803744000', 'Santa Fe', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2900, 12, '0803745000', 'Tabango', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2901, 12, '0803746000', 'Tabontabon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2902, 12, '0803748000', 'Tanauan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2903, 12, '0803749000', 'Tolosa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2904, 12, '0803750000', 'Tunga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2905, 12, '0803751000', 'Villaba', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2906, 12, '0804800000', 'Northern Samar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2907, 12, '0804801000', 'Allen', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2908, 12, '0804802000', 'Biri', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2909, 12, '0804803000', 'Bobon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2910, 12, '0804804000', 'Capul', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2911, 12, '0804805000', 'Catarman', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2912, 12, '0804806000', 'Catubig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2913, 12, '0804807000', 'Gamay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2914, 12, '0804808000', 'Laoang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2915, 12, '0804809000', 'Lapinig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2916, 12, '0804810000', 'Las Navas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2917, 12, '0804811000', 'Lavezares', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2918, 12, '0804812000', 'Mapanas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2919, 12, '0804813000', 'Mondragon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2920, 12, '0804814000', 'Palapag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2921, 12, '0804815000', 'Pambujan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2922, 12, '0804816000', 'Rosario', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2923, 12, '0804817000', 'San Antonio', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2924, 12, '0804818000', 'San Isidro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2925, 12, '0804819000', 'San Jose', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2926, 12, '0804820000', 'San Roque', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2927, 12, '0804821000', 'San Vicente', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2928, 12, '0804822000', 'Silvino Lobos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2929, 12, '0804823000', 'Victoria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2930, 12, '0804824000', 'Lope De Vega', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2931, 12, '0806000000', 'Samar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2932, 12, '0806001000', 'Almagro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2933, 12, '0806002000', 'Basey', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2934, 12, '0806003000', 'City of Calbayog', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2935, 12, '0806004000', 'Calbiga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2936, 12, '0806005000', 'City of Catbalogan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2937, 12, '0806006000', 'Daram', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2938, 12, '0806007000', 'Gandara', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2939, 12, '0806008000', 'Hinabangan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2940, 12, '0806009000', 'Jiabong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2941, 12, '0806010000', 'Marabut', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2942, 12, '0806011000', 'Matuguinao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2943, 12, '0806012000', 'Motiong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2944, 12, '0806013000', 'Pinabacdao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2945, 12, '0806014000', 'San Jose De Buan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2946, 12, '0806015000', 'San Sebastian', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2947, 12, '0806016000', 'Santa Margarita', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2948, 12, '0806017000', 'Santa Rita', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2949, 12, '0806018000', 'Santo Ni–o', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2950, 12, '0806019000', 'Talalora', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2951, 12, '0806020000', 'Tarangnan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2952, 12, '0806021000', 'Villareal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2953, 12, '0806022000', 'Paranas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2954, 12, '0806023000', 'Zumarraga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2955, 12, '0806024000', 'Tagapul-An', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2956, 12, '0806025000', 'San Jorge', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2957, 12, '0806026000', 'Pagsanghan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2958, 12, '0806400000', 'Southern Leyte', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2959, 12, '0806401000', 'Anahawan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2960, 12, '0806402000', 'Bontoc', '2026-02-24 02:25:17', '2026-02-24 02:25:17');
INSERT INTO `provinces` (`id`, `region_id`, `province_code`, `province_name`, `created_at`, `updated_at`) VALUES
(2961, 12, '0806403000', 'Hinunangan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2962, 12, '0806404000', 'Hinundayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2963, 12, '0806405000', 'Libagon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2964, 12, '0806406000', 'Liloan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2965, 12, '0806407000', 'City of Maasin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2966, 12, '0806408000', 'Macrohon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2967, 12, '0806409000', 'Malitbog', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2968, 12, '0806410000', 'Padre Burgos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2969, 12, '0806411000', 'Pintuyan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2970, 12, '0806412000', 'Saint Bernard', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2971, 12, '0806413000', 'San Francisco', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2972, 12, '0806414000', 'San Juan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2973, 12, '0806415000', 'San Ricardo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2974, 12, '0806416000', 'Silago', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2975, 12, '0806417000', 'Sogod', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2976, 12, '0806418000', 'Tomas Oppus', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2977, 12, '0806419000', 'Limasawa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2978, 12, '0807800000', 'Biliran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2979, 12, '0807801000', 'Almeria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2980, 12, '0807802000', 'Biliran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2981, 12, '0807803000', 'Cabucgayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2982, 12, '0807804000', 'Caibiran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2983, 12, '0807805000', 'Culaba', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2984, 12, '0807806000', 'Kawayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2985, 12, '0807807000', 'Maripipi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2986, 12, '0807808000', 'Naval', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2987, 12, '0831600000', 'City of Tacloban', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2988, 13, '0906600000', 'Sulu', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2989, 13, '0906601000', 'Indanan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2990, 13, '0906602000', 'Jolo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2991, 13, '0906603000', 'Kalingalan Caluang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2992, 13, '0906604000', 'Luuk', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2993, 13, '0906605000', 'Maimbung', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2994, 13, '0906606000', 'Hadji Panglima Tahil', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2995, 13, '0906607000', 'Old Panamao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2996, 13, '0906608000', 'Pangutaran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2997, 13, '0906609000', 'Parang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2998, 13, '0906610000', 'Pata', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(2999, 13, '0906611000', 'Patikul', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3000, 13, '0906612000', 'Siasi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3001, 13, '0906613000', 'Talipao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3002, 13, '0906614000', 'Tapul', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3003, 13, '0906615000', 'Tongkil', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3004, 13, '0906616000', 'Panglima Estino', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3005, 13, '0906617000', 'Lugus', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3006, 13, '0906618000', 'Pandami', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3007, 13, '0906619000', 'Omar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3008, 13, '0907200000', 'Zamboanga del Norte', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3009, 13, '0907201000', 'City of Dapitan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3010, 13, '0907202000', 'City of Dipolog', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3011, 13, '0907203000', 'Katipunan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3012, 13, '0907204000', 'La Libertad', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3013, 13, '0907205000', 'Labason', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3014, 13, '0907206000', 'Liloy', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3015, 13, '0907207000', 'Manukan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3016, 13, '0907208000', 'Mutia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3017, 13, '0907209000', 'Pi–an', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3018, 13, '0907210000', 'Polanco', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3019, 13, '0907211000', 'Pres. Manuel A. Roxas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3020, 13, '0907212000', 'Rizal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3021, 13, '0907213000', 'Salug', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3022, 13, '0907214000', 'Sergio Osme–a Sr.', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3023, 13, '0907215000', 'Siayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3024, 13, '0907216000', 'Sibuco', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3025, 13, '0907217000', 'Sibutad', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3026, 13, '0907218000', 'Sindangan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3027, 13, '0907219000', 'Siocon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3028, 13, '0907220000', 'Sirawai', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3029, 13, '0907221000', 'Tampilisan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3030, 13, '0907222000', 'Jose Dalman', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3031, 13, '0907223000', 'Gutalac', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3032, 13, '0907224000', 'Baliguian', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3033, 13, '0907225000', 'Godod', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3034, 13, '0907226000', 'Leon T. Postigo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3035, 13, '0907227000', 'Kalawit', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3036, 13, '0907300000', 'Zamboanga del Sur', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3037, 13, '0907302000', 'Aurora', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3038, 13, '0907303000', 'Bayog', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3039, 13, '0907305000', 'Dimataling', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3040, 13, '0907306000', 'Dinas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3041, 13, '0907307000', 'Dumalinao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3042, 13, '0907308000', 'Dumingag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3043, 13, '0907311000', 'Kumalarang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3044, 13, '0907312000', 'Labangan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3045, 13, '0907313000', 'Lapuyan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3046, 13, '0907315000', 'Mahayag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3047, 13, '0907317000', 'Margosatubig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3048, 13, '0907318000', 'Midsalip', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3049, 13, '0907319000', 'Molave', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3050, 13, '0907322000', 'City of Pagadian', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3051, 13, '0907323000', 'Ramon Magsaysay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3052, 13, '0907324000', 'San Miguel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3053, 13, '0907325000', 'San Pablo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3054, 13, '0907327000', 'Tabina', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3055, 13, '0907328000', 'Tambulig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3056, 13, '0907330000', 'Tukuran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3057, 13, '0907333000', 'Lakewood', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3058, 13, '0907337000', 'Josefina', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3059, 13, '0907338000', 'Pitogo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3060, 13, '0907340000', 'Sominot', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3061, 13, '0907341000', 'Vincenzo A. Sagun', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3062, 13, '0907343000', 'Guipos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3063, 13, '0907344000', 'Tigbao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3064, 13, '0908300000', 'Zamboanga Sibugay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3065, 13, '0908301000', 'Alicia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3066, 13, '0908302000', 'Buug', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3067, 13, '0908303000', 'Diplahan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3068, 13, '0908304000', 'Imelda', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3069, 13, '0908305000', 'Ipil', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3070, 13, '0908306000', 'Kabasalan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3071, 13, '0908307000', 'Mabuhay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3072, 13, '0908308000', 'Malangas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3073, 13, '0908309000', 'Naga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3074, 13, '0908310000', 'Olutanga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3075, 13, '0908311000', 'Payao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3076, 13, '0908312000', 'Roseller Lim', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3077, 13, '0908313000', 'Siay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3078, 13, '0908314000', 'Talusan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3079, 13, '0908315000', 'Titay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3080, 13, '0908316000', 'Tungawan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3081, 13, '0990100000', 'City of Isabela (Not a Province)', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3082, 13, '0990101000', 'City of Isabela', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3083, 13, '0931700000', 'City of Zamboanga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3084, 14, '1001300000', 'Bukidnon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3085, 14, '1001301000', 'Baungon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3086, 14, '1001302000', 'Damulog', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3087, 14, '1001303000', 'Dangcagan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3088, 14, '1001304000', 'Don Carlos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3089, 14, '1001305000', 'Impasug-ong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3090, 14, '1001306000', 'Kadingilan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3091, 14, '1001307000', 'Kalilangan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3092, 14, '1001308000', 'Kibawe', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3093, 14, '1001309000', 'Kitaotao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3094, 14, '1001310000', 'Lantapan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3095, 14, '1001311000', 'Libona', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3096, 14, '1001312000', 'City of Malaybalay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3097, 14, '1001313000', 'Malitbog', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3098, 14, '1001314000', 'Manolo Fortich', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3099, 14, '1001315000', 'Maramag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3100, 14, '1001316000', 'Pangantucan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3101, 14, '1001317000', 'Quezon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3102, 14, '1001318000', 'San Fernando', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3103, 14, '1001319000', 'Sumilao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3104, 14, '1001320000', 'Talakag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3105, 14, '1001321000', 'City of Valencia', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3106, 14, '1001322000', 'Cabanglasan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3107, 14, '1001800000', 'Camiguin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3108, 14, '1001801000', 'Catarman', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3109, 14, '1001802000', 'Guinsiliban', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3110, 14, '1001803000', 'Mahinog', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3111, 14, '1001804000', 'Mambajao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3112, 14, '1001805000', 'Sagay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3113, 14, '1003500000', 'Lanao del Norte', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3114, 14, '1003501000', 'Bacolod', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3115, 14, '1003502000', 'Baloi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3116, 14, '1003503000', 'Baroy', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3117, 14, '1003505000', 'Kapatagan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3118, 14, '1003506000', 'Sultan Naga Dimaporo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3119, 14, '1003507000', 'Kauswagan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3120, 14, '1003508000', 'Kolambugan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3121, 14, '1003509000', 'Lala', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3122, 14, '1003510000', 'Linamon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3123, 14, '1003511000', 'Magsaysay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3124, 14, '1003512000', 'Maigo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3125, 14, '1003513000', 'Matungao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3126, 14, '1003514000', 'Munai', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3127, 14, '1003515000', 'Nunungan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3128, 14, '1003516000', 'Pantao Ragat', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3129, 14, '1003517000', 'Poona Piagapo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3130, 14, '1003518000', 'Salvador', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3131, 14, '1003519000', 'Sapad', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3132, 14, '1003520000', 'Tagoloan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3133, 14, '1003521000', 'Tangcal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3134, 14, '1003522000', 'Tubod', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3135, 14, '1003523000', 'Pantar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3136, 14, '1004200000', 'Misamis Occidental', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3137, 14, '1004201000', 'Aloran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3138, 14, '1004202000', 'Baliangao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3139, 14, '1004203000', 'Bonifacio', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3140, 14, '1004204000', 'Calamba', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3141, 14, '1004205000', 'Clarin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3142, 14, '1004206000', 'Concepcion', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3143, 14, '1004207000', 'Jimenez', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3144, 14, '1004208000', 'Lopez Jaena', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3145, 14, '1004209000', 'City of Oroquieta', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3146, 14, '1004210000', 'City of Ozamiz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3147, 14, '1004211000', 'Panaon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3148, 14, '1004212000', 'Plaridel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3149, 14, '1004213000', 'Sapang Dalaga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3150, 14, '1004214000', 'Sinacaban', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3151, 14, '1004215000', 'City of Tangub', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3152, 14, '1004216000', 'Tudela', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3153, 14, '1004217000', 'Don Victoriano Chiongbian', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3154, 14, '1004300000', 'Misamis Oriental', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3155, 14, '1004301000', 'Alubijid', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3156, 14, '1004302000', 'Balingasag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3157, 14, '1004303000', 'Balingoan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3158, 14, '1004304000', 'Binuangan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3159, 14, '1004306000', 'Claveria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3160, 14, '1004307000', 'City of El Salvador', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3161, 14, '1004308000', 'City of Gingoog', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3162, 14, '1004309000', 'Gitagum', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3163, 14, '1004310000', 'Initao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3164, 14, '1004311000', 'Jasaan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3165, 14, '1004312000', 'Kinoguitan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3166, 14, '1004313000', 'Lagonglong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3167, 14, '1004314000', 'Laguindingan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3168, 14, '1004315000', 'Libertad', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3169, 14, '1004316000', 'Lugait', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3170, 14, '1004317000', 'Magsaysay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3171, 14, '1004318000', 'Manticao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3172, 14, '1004319000', 'Medina', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3173, 14, '1004320000', 'Naawan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3174, 14, '1004321000', 'Opol', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3175, 14, '1004322000', 'Salay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3176, 14, '1004323000', 'Sugbongcogon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3177, 14, '1004324000', 'Tagoloan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3178, 14, '1004325000', 'Talisayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3179, 14, '1004326000', 'Villanueva', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3180, 14, '1030500000', 'City of Cagayan De Oro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3181, 14, '1030900000', 'City of Iligan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3182, 15, '1102300000', 'Davao del Norte', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3183, 15, '1102301000', 'Asuncion', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3184, 15, '1102303000', 'Carmen', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3185, 15, '1102305000', 'Kapalong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3186, 15, '1102314000', 'New Corella', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3187, 15, '1102315000', 'City of Panabo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3188, 15, '1102317000', 'Island Garden City of Samal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3189, 15, '1102318000', 'Santo Tomas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3190, 15, '1102319000', 'City of Tagum', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3191, 15, '1102322000', 'Talaingod', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3192, 15, '1102323000', 'Braulio E. Dujali', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3193, 15, '1102324000', 'San Isidro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3194, 15, '1102400000', 'Davao del Sur', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3195, 15, '1102401000', 'Bansalan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3196, 15, '1102403000', 'City of Digos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3197, 15, '1102404000', 'Hagonoy', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3198, 15, '1102406000', 'Kiblawan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3199, 15, '1102407000', 'Magsaysay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3200, 15, '1102408000', 'Malalag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3201, 15, '1102410000', 'Matanao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3202, 15, '1102411000', 'Padada', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3203, 15, '1102412000', 'Santa Cruz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3204, 15, '1102414000', 'Sulop', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3205, 15, '1102500000', 'Davao Oriental', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3206, 15, '1102501000', 'Baganga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3207, 15, '1102502000', 'Banaybanay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3208, 15, '1102503000', 'Boston', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3209, 15, '1102504000', 'Caraga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3210, 15, '1102505000', 'Cateel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3211, 15, '1102506000', 'Governor Generoso', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3212, 15, '1102507000', 'Lupon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3213, 15, '1102508000', 'Manay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3214, 15, '1102509000', 'City of Mati', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3215, 15, '1102510000', 'San Isidro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3216, 15, '1102511000', 'Tarragona', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3217, 15, '1108200000', 'Davao de Oro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3218, 15, '1108201000', 'Compostela', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3219, 15, '1108202000', 'Laak', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3220, 15, '1108203000', 'Mabini', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3221, 15, '1108204000', 'Maco', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3222, 15, '1108205000', 'Maragusan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3223, 15, '1108206000', 'Mawab', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3224, 15, '1108207000', 'Monkayo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3225, 15, '1108208000', 'Montevista', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3226, 15, '1108209000', 'Nabunturan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3227, 15, '1108210000', 'New Bataan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3228, 15, '1108211000', 'Pantukan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3229, 15, '1108600000', 'Davao Occidental', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3230, 15, '1108601000', 'Don Marcelino', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3231, 15, '1108602000', 'Jose Abad Santos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3232, 15, '1108603000', 'Malita', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3233, 15, '1108604000', 'Santa Maria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3234, 15, '1108605000', 'Sarangani', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3235, 15, '1130700000', 'City of Davao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3236, 16, '1204700000', 'Cotabato', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3237, 16, '1204701000', 'Alamada', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3238, 16, '1204702000', 'Carmen', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3239, 16, '1204703000', 'Kabacan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3240, 16, '1204704000', 'City of Kidapawan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3241, 16, '1204705000', 'Libungan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3242, 16, '1204706000', 'Magpet', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3243, 16, '1204707000', 'Makilala', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3244, 16, '1204708000', 'Matalam', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3245, 16, '1204709000', 'Midsayap', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3246, 16, '1204710000', 'M\'Lang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3247, 16, '1204711000', 'Pigkawayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3248, 16, '1204712000', 'Pikit', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3249, 16, '1204713000', 'President Roxas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3250, 16, '1204714000', 'Tulunan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3251, 16, '1204715000', 'Antipas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3252, 16, '1204716000', 'Banisilan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3253, 16, '1204717000', 'Aleosan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3254, 16, '1204718000', 'Arakan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3255, 16, '1206300000', 'South Cotabato', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3256, 16, '1206302000', 'Banga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3257, 16, '1206306000', 'City of Koronadal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3258, 16, '1206311000', 'Norala', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3259, 16, '1206312000', 'Polomolok', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3260, 16, '1206313000', 'Surallah', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3261, 16, '1206314000', 'Tampakan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3262, 16, '1206315000', 'Tantangan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3263, 16, '1206316000', 'T\'Boli', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3264, 16, '1206317000', 'Tupi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3265, 16, '1206318000', 'Santo Ni–o', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3266, 16, '1206319000', 'Lake Sebu', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3267, 16, '1206500000', 'Sultan Kudarat', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3268, 16, '1206501000', 'Bagumbayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3269, 16, '1206502000', 'Columbio', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3270, 16, '1206503000', 'Esperanza', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3271, 16, '1206504000', 'Isulan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3272, 16, '1206505000', 'Kalamansig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3273, 16, '1206506000', 'Lebak', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3274, 16, '1206507000', 'Lutayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3275, 16, '1206508000', 'Lambayong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3276, 16, '1206509000', 'Palimbang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3277, 16, '1206510000', 'President Quirino', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3278, 16, '1206511000', 'City of Tacurong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3279, 16, '1206512000', 'Sen. Ninoy Aquino', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3280, 16, '1208000000', 'Sarangani', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3281, 16, '1208001000', 'Alabel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3282, 16, '1208002000', 'Glan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3283, 16, '1208003000', 'Kiamba', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3284, 16, '1208004000', 'Maasim', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3285, 16, '1208005000', 'Maitum', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3286, 16, '1208006000', 'Malapatan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3287, 16, '1208007000', 'Malungon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3288, 16, '1230800000', 'City of General Santos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3289, 17, '1600200000', 'Agusan del Norte', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3290, 17, '1600201000', 'Buenavista', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3291, 17, '1600203000', 'City of Cabadbaran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3292, 17, '1600204000', 'Carmen', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3293, 17, '1600205000', 'Jabonga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3294, 17, '1600206000', 'Kitcharao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3295, 17, '1600207000', 'Las Nieves', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3296, 17, '1600208000', 'Magallanes', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3297, 17, '1600209000', 'Nasipit', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3298, 17, '1600210000', 'Santiago', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3299, 17, '1600211000', 'Tubay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3300, 17, '1600212000', 'Remedios T. Romualdez', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3301, 17, '1600300000', 'Agusan del Sur', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3302, 17, '1600301000', 'City of Bayugan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3303, 17, '1600302000', 'Bunawan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3304, 17, '1600303000', 'Esperanza', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3305, 17, '1600304000', 'La Paz', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3306, 17, '1600305000', 'Loreto', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3307, 17, '1600306000', 'Prosperidad', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3308, 17, '1600307000', 'Rosario', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3309, 17, '1600308000', 'San Francisco', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3310, 17, '1600309000', 'San Luis', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3311, 17, '1600310000', 'Santa Josefa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3312, 17, '1600311000', 'Talacogon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3313, 17, '1600312000', 'Trento', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3314, 17, '1600313000', 'Veruela', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3315, 17, '1600314000', 'Sibagat', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3316, 17, '1606700000', 'Surigao del Norte', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3317, 17, '1606701000', 'Alegria', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3318, 17, '1606702000', 'Bacuag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3319, 17, '1606704000', 'Burgos', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3320, 17, '1606706000', 'Claver', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3321, 17, '1606707000', 'Dapa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3322, 17, '1606708000', 'Del Carmen', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3323, 17, '1606710000', 'General Luna', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3324, 17, '1606711000', 'Gigaquit', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3325, 17, '1606714000', 'Mainit', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3326, 17, '1606715000', 'Malimono', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3327, 17, '1606716000', 'Pilar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3328, 17, '1606717000', 'Placer', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3329, 17, '1606718000', 'San Benito', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3330, 17, '1606719000', 'San Francisco', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3331, 17, '1606720000', 'San Isidro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3332, 17, '1606721000', 'Santa Monica', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3333, 17, '1606722000', 'Sison', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3334, 17, '1606723000', 'Socorro', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3335, 17, '1606724000', 'City of Surigao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3336, 17, '1606725000', 'Tagana-An', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3337, 17, '1606727000', 'Tubod', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3338, 17, '1606800000', 'Surigao del Sur', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3339, 17, '1606801000', 'Barobo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3340, 17, '1606802000', 'Bayabas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3341, 17, '1606803000', 'City of Bislig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3342, 17, '1606804000', 'Cagwait', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3343, 17, '1606805000', 'Cantilan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3344, 17, '1606806000', 'Carmen', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3345, 17, '1606807000', 'Carrascal', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3346, 17, '1606808000', 'Cortes', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3347, 17, '1606809000', 'Hinatuan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3348, 17, '1606810000', 'Lanuza', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3349, 17, '1606811000', 'Lianga', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3350, 17, '1606812000', 'Lingig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3351, 17, '1606813000', 'Madrid', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3352, 17, '1606814000', 'Marihatag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3353, 17, '1606815000', 'San Agustin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3354, 17, '1606816000', 'San Miguel', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3355, 17, '1606817000', 'Tagbina', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3356, 17, '1606818000', 'Tago', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3357, 17, '1606819000', 'City of Tandag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3358, 17, '1608500000', 'Dinagat Islands', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3359, 17, '1608501000', 'Basilisa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3360, 17, '1608502000', 'Cagdianao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3361, 17, '1608503000', 'Dinagat', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3362, 17, '1608504000', 'Libjo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3363, 17, '1608505000', 'Loreto', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3364, 17, '1608506000', 'San Jose', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3365, 17, '1608507000', 'Tubajon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3366, 17, '1630400000', 'City of Butuan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3367, 18, '1900700000', 'Basilan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3368, 18, '1900702000', 'City of Lamitan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3369, 18, '1900703000', 'Lantawan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3370, 18, '1900704000', 'Maluso', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3371, 18, '1900705000', 'Sumisip', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3372, 18, '1900706000', 'Tipo-Tipo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3373, 18, '1900707000', 'Tuburan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3374, 18, '1900708000', 'Akbar', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3375, 18, '1900709000', 'Al-Barka', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3376, 18, '1900710000', 'Hadji Mohammad Ajul', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3377, 18, '1900711000', 'Ungkaya Pukan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3378, 18, '1900712000', 'Hadji Muhtamad', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3379, 18, '1900713000', 'Tabuan-Lasa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3380, 18, '1903600000', 'Lanao del Sur', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3381, 18, '1903601000', 'Bacolod-Kalawi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3382, 18, '1903602000', 'Balabagan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3383, 18, '1903603000', 'Balindong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3384, 18, '1903604000', 'Bayang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3385, 18, '1903605000', 'Binidayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3386, 18, '1903606000', 'Bubong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3387, 18, '1903607000', 'Butig', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3388, 18, '1903609000', 'Ganassi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3389, 18, '1903610000', 'Kapai', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3390, 18, '1903611000', 'Lumba-Bayabao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3391, 18, '1903612000', 'Lumbatan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3392, 18, '1903613000', 'Madalum', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3393, 18, '1903614000', 'Madamba', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3394, 18, '1903615000', 'Malabang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3395, 18, '1903616000', 'Marantao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3396, 18, '1903617000', 'City of Marawi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3397, 18, '1903618000', 'Masiu', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3398, 18, '1903619000', 'Mulondo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3399, 18, '1903620000', 'Pagayawan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3400, 18, '1903621000', 'Piagapo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3401, 18, '1903622000', 'Poona Bayabao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3402, 18, '1903623000', 'Pualas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3403, 18, '1903624000', 'Ditsaan-Ramain', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3404, 18, '1903625000', 'Saguiaran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3405, 18, '1903626000', 'Tamparan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3406, 18, '1903627000', 'Taraka', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3407, 18, '1903628000', 'Tubaran', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3408, 18, '1903629000', 'Tugaya', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3409, 18, '1903630000', 'Wao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3410, 18, '1903631000', 'Marogong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3411, 18, '1903632000', 'Calanogas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3412, 18, '1903633000', 'Buadiposo-Buntong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3413, 18, '1903634000', 'Maguing', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3414, 18, '1903635000', 'Picong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3415, 18, '1903636000', 'Lumbayanague', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3416, 18, '1903637000', 'Amai Manabilang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3417, 18, '1903638000', 'Tagoloan II', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3418, 18, '1903639000', 'Kapatagan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3419, 18, '1903640000', 'Sultan Dumalondong', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3420, 18, '1903641000', 'Lumbaca-Unayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3421, 18, '1907000000', 'Tawi-Tawi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3422, 18, '1907001000', 'Panglima Sugala', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3423, 18, '1907002000', 'Bongao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3424, 18, '1907003000', 'Mapun', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3425, 18, '1907004000', 'Simunul', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3426, 18, '1907005000', 'Sitangkai', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3427, 18, '1907006000', 'South Ubian', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3428, 18, '1907007000', 'Tandubas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3429, 18, '1907008000', 'Turtle Islands', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3430, 18, '1907009000', 'Languyan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3431, 18, '1907010000', 'Sapa-Sapa', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3432, 18, '1907011000', 'Sibutu', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3433, 18, '1908700000', 'Maguindanao del Norte', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3434, 18, '1908701000', 'Barira', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3435, 18, '1908702000', 'Buldon', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3436, 18, '1908703000', 'City of Cotabato', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3437, 18, '1908704000', 'Datu Blah T. Sinsuat', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3438, 18, '1908705000', 'Datu Odin Sinsuat', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3439, 18, '1908706000', 'Kabuntalan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3440, 18, '1908707000', 'Matanog', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3441, 18, '1908708000', 'Northern Kabuntalan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3442, 18, '1908709000', 'Parang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3443, 18, '1908710000', 'Sultan Kudarat', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3444, 18, '1908711000', 'Sultan Mastura', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3445, 18, '1908712000', 'Talitay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3446, 18, '1908713000', 'Upi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3447, 18, '1908800000', 'Maguindanao del Sur', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3448, 18, '1908801000', 'Ampatuan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3449, 18, '1908802000', 'Buluan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3450, 18, '1908803000', 'Datu Abdullah Sangki', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3451, 18, '1908804000', 'Datu Anggal Midtimbang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3452, 18, '1908805000', 'Datu Hoffer Ampatuan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3453, 18, '1908806000', 'Datu Paglas', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3454, 18, '1908807000', 'Datu Piang', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3455, 18, '1908808000', 'Datu Salibo', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3456, 18, '1908809000', 'Datu Saudi Ampatuan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3457, 18, '1908810000', 'Datu Unsay', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3458, 18, '1908811000', 'Gen. S.K. Pendatun', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3459, 18, '1908812000', 'Guindulungan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3460, 18, '1908813000', 'Mamasapano', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3461, 18, '1908814000', 'Mangudadatu', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3462, 18, '1908815000', 'Pagagawan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3463, 18, '1908816000', 'Pagalungan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3464, 18, '1908817000', 'Paglat', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3465, 18, '1908818000', 'Pandag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3466, 18, '1908819000', 'Rajah Buayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3467, 18, '1908820000', 'Shariff Aguak', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3468, 18, '1908821000', 'Shariff Saydona Mustapha', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3469, 18, '1908822000', 'South Upi', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3470, 18, '1908823000', 'Sultan Sa Barongis', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3471, 18, '1908824000', 'Talayan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3472, 18, '1999900000', 'Special Geographic Area', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3473, 18, '1999901000', 'Kapalawan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3474, 18, '1999902000', 'Old Kaabakan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3475, 18, '1999903000', 'Kadayangan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3476, 18, '1999904000', 'Nabalawag', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3477, 18, '1999905000', 'Pahamuddin', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3478, 18, '1999906000', 'Malidegao', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3479, 18, '1999907000', 'Ligawasan', '2026-02-24 02:25:17', '2026-02-24 02:25:17'),
(3480, 18, '1999908000', 'Tugunan', '2026-02-24 02:25:17', '2026-02-24 02:25:17');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reflection_responses`
--

CREATE TABLE `reflection_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `module_index` int(10) UNSIGNED NOT NULL,
  `topic_index` int(10) UNSIGNED NOT NULL,
  `sub_index` int(10) UNSIGNED DEFAULT NULL,
  `questions_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`questions_json`)),
  `answers_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`answers_json`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reflection_responses`
--

INSERT INTO `reflection_responses` (`id`, `user_id`, `course_id`, `module_index`, `topic_index`, `sub_index`, `questions_json`, `answers_json`, `created_at`, `updated_at`) VALUES
(3, 4, 18, 0, 0, 0, '[{\"id\":\"learned\",\"text\":\"What did you learn?\"}]', '{\"learned\":\"wow\"}', '2026-02-23 01:00:18', '2026-02-23 01:00:18');

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `region_code` varchar(10) NOT NULL,
  `region_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `region_code`, `region_name`, `created_at`, `updated_at`) VALUES
(1, '1300000000', 'National Capital Region (NCR)', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(2, '1400000000', 'Cordillera Administrative Region (CAR)', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(3, '0100000000', 'Region I (Ilocos Region)', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(4, '0200000000', 'Region II (Cagayan Valley)', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(5, '0300000000', 'Region III (Central Luzon)', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(6, '0400000000', 'Region IV-A (CALABARZON)', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(7, '1700000000', 'MIMAROPA Region', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(8, '0500000000', 'Region V (Bicol Region)', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(9, '0600000000', 'Region VI (Western Visayas)', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(10, '1800000000', 'Negros Island Region (NIR)', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(11, '0700000000', 'Region VII (Central Visayas)', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(12, '0800000000', 'Region VIII (Eastern Visayas)', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(13, '0900000000', 'Region IX (Zamboanga Peninsula)', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(14, '1000000000', 'Region X (Northern Mindanao)', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(15, '1100000000', 'Region XI (Davao Region)', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(16, '1200000000', 'Region XII (SOCCSKSARGEN)', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(17, '1600000000', 'Region XIII (Caraga)', '2026-02-24 02:11:52', '2026-02-24 02:11:52'),
(18, '1900000000', 'Bangsamoro Autonomous Region in Muslim Mindanao (BARMM)', '2026-02-24 02:11:52', '2026-02-24 02:11:52');

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
('0NmVM6cpFKeHD6hjX62nblLpUFZQOtt3N5xBcXyL', 12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTHVCWUdPUmlwUjdmdmYyejBqZWNXdGNvNkVkenRpRlc3b21ZUnNOYiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9jb3Vyc2VzLzI/ZW1iZWRkZWQ9MSI7czo1OiJyb3V0ZSI7czoxODoiYWRtaW4uY291cnNlcy5zaG93Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTI7fQ==', 1772036131);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `position` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `module_id`, `title`, `file_path`, `position`, `created_at`, `updated_at`) VALUES
(1, 1, 'test1', 'topic_files/GNHtGd13gfxCxSJJQQTRrYNxWG2GG6hN4JLVVJ9S.doc', 0, '2026-02-15 22:37:24', '2026-02-15 22:37:24'),
(2, 1, 'test2', 'topic_files/4kHGRBIOs0Li8LMSUvhFq0MztuCVlqly6NVHmCbW.docx', 1, '2026-02-15 22:37:24', '2026-02-15 22:37:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` varchar(12) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `gender` varchar(30) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'trainee',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `profile_picture` varchar(255) DEFAULT NULL,
  `additional_details` text DEFAULT NULL,
  `display_type` varchar(255) DEFAULT NULL,
  `landing_display_type` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `profile_completed` tinyint(1) NOT NULL DEFAULT 0,
  `profile_completed_at` timestamp NULL DEFAULT NULL,
  `display_on_landing` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `account_id`, `name`, `job_title`, `email`, `mobile_number`, `gender`, `google_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `region`, `province`, `city`, `barangay`, `date_of_birth`, `role`, `status`, `profile_picture`, `additional_details`, `display_type`, `landing_display_type`, `description`, `profile_completed`, `profile_completed_at`, `display_on_landing`) VALUES
(1, '26-0000-001', 'Admin User', 'Regional DIrector', 'admin@gmail.com', '0000000000', NULL, NULL, NULL, '$2y$12$nSnkKr.B6H2YCQbhCmCH7OFLWTUbbfcQFW.wYCFvGBHm1MHFUG/X2', NULL, '2026-02-06 00:12:46', '2026-02-18 13:49:31', 'CAR (Cordillera Administrative Region)', 'Benguet', 'City of Baguio', 'Balsigan', NULL, 'admin', 'active', 'profile_pictures/VCUjW2Sq03yj10aWpcJMQLJITQjo1OqpGHyeZWdv.png', 'Matino, Mahusay, Maasahan', 'our_team', NULL, 'u', 1, '2026-02-18 13:48:52', 0),
(2, '26-0000-002', 'Registrar User', 'Regional DIrector', 'registrar@gmail.com', '0000000000', NULL, NULL, NULL, '$2y$12$/JDOv2vopwVaYrf0Sv.OVOouWFF3txSiX.Egm/iOlYKOc3AOePUxK', NULL, '2026-02-06 00:12:46', '2026-02-18 13:54:22', 'CAR (Cordillera Administrative Region)', 'Benguet', 'City of Baguio', 'Balsigan', NULL, 'registrar', 'active', 'C:\\xampp\\tmp\\php6A6F.tmp', NULL, NULL, NULL, 'rrrrr', 1, '2026-02-18 13:54:22', 0),
(3, '26-0000-003', 'Trainer User', 'Trainer', 'trainer@gmail.com', '0000000000', NULL, NULL, NULL, '$2y$12$/Tb6ckKWlAuBGgg9W7o56OwH6nOuQXNQEstK95nL1asH/r0EF9iTq', NULL, '2026-02-06 00:12:47', '2026-02-18 16:47:20', 'CAR (Cordillera Administrative Region)', 'Benguet', 'City of Baguio', 'Balsigan', NULL, 'trainer', 'active', NULL, NULL, NULL, NULL, NULL, 1, '2026-02-18 16:47:20', 0),
(4, '26-0000-004', 'Trainee User', 'Trainee', 'trainee@gmail.com', '0000000000', NULL, NULL, NULL, '$2y$12$bevvGVgY7z5bBpW6hvhp2.RiebeqxyorOahL5vO3ixa9l0u.O.WZO', NULL, '2026-02-06 00:12:47', '2026-02-18 16:51:21', 'CAR (Cordillera Administrative Region)', 'Benguet', 'City of Baguio', 'Balsigan', NULL, 'trainee', 'active', 'profile_pictures/Aa7KFsPRREEMRoFvKkGx0vdO352ue2NdYbQGjWt1.png', 'CARaise the BAR', 'past_trainees', NULL, 'The Course is Great and help me a lot', 1, '2026-02-18 16:51:21', 0),
(12, '26-0000-005', 'Admin Admin Admin', 'Trainer', 'admin1@gmail.com', 'Admin', 'Male', NULL, NULL, '$2y$12$sXlyDt3qaqUhKq/PZGeQD.t0iYET/4nDvZzGgczjR/uwcitM8jT66', NULL, '2026-02-18 16:38:33', '2026-02-25 11:45:07', 'CAR', 'Benguet', 'La Trinidad', 'Alapang', NULL, 'admin', 'active', 'profile_pictures/7OKimlaP4UUDCGmGxRaDZbKwowowASGT0Yd7bxAM.jpg', NULL, NULL, NULL, NULL, 1, '2026-02-18 16:45:15', 0),
(15, '26-0000-006', 'try try', 'Trainer', 'zarenomark8@gmail.com', '0000000000', 'Male', NULL, NULL, '$2y$12$x.zCk2YIDbJIyGCSm9REt.xFd0djAp7K4rG4bk/cTkK2uUMtdT9tO', NULL, '2026-02-19 17:55:21', '2026-02-20 02:35:54', 'CAR', 'Benguet', 'City of Baguio', 'Aurora Hill, North Central', NULL, 'trainee', 'active', NULL, NULL, NULL, NULL, NULL, 1, '2026-02-20 02:35:54', 0),
(16, '26-0000-007', 'Law Malanum', 'Trainer', 'laurencemalanum56@gmail.com', '09511287670', 'Prefer not to say', NULL, NULL, '$2y$12$GluBUDvdTsnml.bbn8Xejud.EVkbWNqrT2crehp6JdFV.nbyQDp0W', NULL, '2026-02-21 00:58:20', '2026-02-21 01:00:29', 'CAR', 'Benguet', 'City of Baguio', 'Camp 8', NULL, 'trainee', 'active', NULL, NULL, NULL, NULL, NULL, 1, '2026-02-21 00:58:19', 0),
(17, '26-0000-008', 'Billy John Ferreol', 'Trainer', 'bdferreol@dilg.gov.ph', '09212119301', NULL, '103749359924696556969', '2026-02-24 01:04:07', '$2y$12$MTgK46Co0JsgzCg0ps85ZuxfjU4hQ6fgeVgc8V0agQ4YteSr/5RaK', 'CjqUblLPk0cwTbHVCBxQFBjrEIfERBWhQD5HKN008izQZzQDPvL7tkjqB1J0', '2026-02-24 01:04:07', '2026-02-25 12:42:06', 'CAR', 'Abra', 'Bangued', 'Agtangao', NULL, 'trainee', 'active', 'profile_pictures/KMEY7BfYRsWhtNPsjhspxNRRg7WUtuAKxd6DYVGm.jpg', NULL, NULL, NULL, NULL, 1, '2026-02-25 12:40:26', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_certifications`
--
ALTER TABLE `account_certifications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_certifications_unique` (`account_id`,`certification_id`),
  ADD KEY `account_certifications_certification_id_foreign` (`certification_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_user_id_foreign` (`user_id`),
  ADD KEY `announcements_course_id_foreign` (`course_id`);

--
-- Indexes for table `announcement_comments`
--
ALTER TABLE `announcement_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcement_comments_announcement_id_foreign` (`announcement_id`),
  ADD KEY `announcement_comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessments_course_id_foreign` (`course_id`);

--
-- Indexes for table `assessment_templates`
--
ALTER TABLE `assessment_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_templates_user_id_type_index` (`user_id`,`type`);

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
-- Indexes for table `calendar_events`
--
ALTER TABLE `calendar_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `calendar_events_user_id_foreign` (`user_id`);

--
-- Indexes for table `certifications`
--
ALTER TABLE `certifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certification_user`
--
ALTER TABLE `certification_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certification_user_certificate_number_unique` (`certificate_number`),
  ADD KEY `certification_user_certification_id_foreign` (`certification_id`),
  ADD KEY `certification_user_user_id_foreign` (`user_id`),
  ADD KEY `certification_user_course_id_foreign` (`course_id`);

--
-- Indexes for table `class_announcements`
--
ALTER TABLE `class_announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_announcements_user_id_foreign` (`user_id`),
  ADD KEY `class_announcements_course_id_created_at_index` (`course_id`,`created_at`);

--
-- Indexes for table `class_comments`
--
ALTER TABLE `class_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_comments_user_id_foreign` (`user_id`),
  ADD KEY `class_comments_class_announcement_id_created_at_index` (`class_announcement_id`,`created_at`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_user`
--
ALTER TABLE `course_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_user_course_id_foreign` (`course_id`),
  ADD KEY `course_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `deletion_audits`
--
ALTER TABLE `deletion_audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deletion_audits_entity_type_entity_id_index` (`entity_type`,`entity_id`),
  ADD KEY `deletion_audits_course_id_index` (`course_id`),
  ADD KEY `deletion_audits_actor_id_index` (`actor_id`);

--
-- Indexes for table `discussions`
--
ALTER TABLE `discussions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discussions_user_id_foreign` (`user_id`),
  ADD KEY `discussions_course_id_created_at_index` (`course_id`,`created_at`);

--
-- Indexes for table `discussion_reactions`
--
ALTER TABLE `discussion_reactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discussion_reactions_discussion_id_user_id_unique` (`discussion_id`,`user_id`),
  ADD KEY `discussion_reactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `discussion_replies`
--
ALTER TABLE `discussion_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discussion_replies_user_id_foreign` (`user_id`),
  ADD KEY `discussion_replies_discussion_id_created_at_index` (`discussion_id`,`created_at`),
  ADD KEY `discussion_replies_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `discussion_reply_reactions`
--
ALTER TABLE `discussion_reply_reactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `discussion_reply_reactions_discussion_reply_id_user_id_unique` (`discussion_reply_id`,`user_id`),
  ADD KEY `discussion_reply_reactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grades_assessment_id_foreign` (`assessment_id`),
  ADD KEY `grades_user_id_foreign` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landing_page_contents`
--
ALTER TABLE `landing_page_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materials_course_id_foreign` (`course_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modules_course_id_foreign` (`course_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provinces_province_code_unique` (`province_code`),
  ADD KEY `provinces_region_id_index` (`region_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reflection_responses`
--
ALTER TABLE `reflection_responses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_reflection_scope` (`user_id`,`course_id`,`module_index`,`topic_index`,`sub_index`),
  ADD KEY `reflection_responses_course_id_foreign` (`course_id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `regions_region_code_unique` (`region_code`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topics_module_id_foreign` (`module_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`),
  ADD UNIQUE KEY `users_account_id_unique` (`account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_certifications`
--
ALTER TABLE `account_certifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcement_comments`
--
ALTER TABLE `announcement_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `assessment_templates`
--
ALTER TABLE `assessment_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `calendar_events`
--
ALTER TABLE `calendar_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certifications`
--
ALTER TABLE `certifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `certification_user`
--
ALTER TABLE `certification_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `class_announcements`
--
ALTER TABLE `class_announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `class_comments`
--
ALTER TABLE `class_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `course_user`
--
ALTER TABLE `course_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `deletion_audits`
--
ALTER TABLE `deletion_audits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discussions`
--
ALTER TABLE `discussions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `discussion_reactions`
--
ALTER TABLE `discussion_reactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discussion_replies`
--
ALTER TABLE `discussion_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `discussion_reply_reactions`
--
ALTER TABLE `discussion_reply_reactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `landing_page_contents`
--
ALTER TABLE `landing_page_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3481;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reflection_responses`
--
ALTER TABLE `reflection_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_certifications`
--
ALTER TABLE `account_certifications`
  ADD CONSTRAINT `account_certifications_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `account_certifications_certification_id_foreign` FOREIGN KEY (`certification_id`) REFERENCES `certifications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `announcements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `announcement_comments`
--
ALTER TABLE `announcement_comments`
  ADD CONSTRAINT `announcement_comments_announcement_id_foreign` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `announcement_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assessments`
--
ALTER TABLE `assessments`
  ADD CONSTRAINT `assessments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assessment_templates`
--
ALTER TABLE `assessment_templates`
  ADD CONSTRAINT `assessment_templates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `calendar_events`
--
ALTER TABLE `calendar_events`
  ADD CONSTRAINT `calendar_events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `certification_user`
--
ALTER TABLE `certification_user`
  ADD CONSTRAINT `certification_user_certification_id_foreign` FOREIGN KEY (`certification_id`) REFERENCES `certifications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certification_user_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certification_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `class_announcements`
--
ALTER TABLE `class_announcements`
  ADD CONSTRAINT `class_announcements_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_announcements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `class_comments`
--
ALTER TABLE `class_comments`
  ADD CONSTRAINT `class_comments_class_announcement_id_foreign` FOREIGN KEY (`class_announcement_id`) REFERENCES `class_announcements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_user`
--
ALTER TABLE `course_user`
  ADD CONSTRAINT `course_user_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discussions`
--
ALTER TABLE `discussions`
  ADD CONSTRAINT `discussions_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discussion_reactions`
--
ALTER TABLE `discussion_reactions`
  ADD CONSTRAINT `discussion_reactions_discussion_id_foreign` FOREIGN KEY (`discussion_id`) REFERENCES `discussions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_reactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discussion_replies`
--
ALTER TABLE `discussion_replies`
  ADD CONSTRAINT `discussion_replies_discussion_id_foreign` FOREIGN KEY (`discussion_id`) REFERENCES `discussions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_replies_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `discussion_replies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discussion_reply_reactions`
--
ALTER TABLE `discussion_reply_reactions`
  ADD CONSTRAINT `discussion_reply_reactions_discussion_reply_id_foreign` FOREIGN KEY (`discussion_reply_id`) REFERENCES `discussion_replies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_reply_reactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `provinces`
--
ALTER TABLE `provinces`
  ADD CONSTRAINT `provinces_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reflection_responses`
--
ALTER TABLE `reflection_responses`
  ADD CONSTRAINT `reflection_responses_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reflection_responses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
