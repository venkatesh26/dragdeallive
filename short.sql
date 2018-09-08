-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2018 at 04:43 AM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `short`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `sitename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `setting_fields` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Serialize all admin setting fields',
  `is_active` tinyint(1) NOT NULL COMMENT '1-Active,0-Inactive'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `created`, `modified`, `sitename`, `setting_fields`, `is_active`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Drg.tw', 'a:11:{s:13:\"email_address\";s:23:\"damovenkatesh@gmail.com\";s:7:\"contact\";s:10:\"9791447542\";s:15:\"back_pagination\";s:1:\"5\";s:16:\"front_pagination\";s:1:\"6\";s:13:\"facebook_link\";s:23:\"http://www.facebook.com\";s:12:\"twitter_link\";s:23:\"http://www.twittter.com\";s:15:\"googleplus_link\";s:19:\"http://www.plus.com\";s:12:\"youtube_link\";s:18:\"http://www.you.com\";s:17:\"home_page_summary\";s:32:\"drg.tw - Create Pretty Short URL\";s:8:\"Keywords\";s:32:\"drg.tw - Create Pretty Short URL\";s:11:\"description\";s:32:\"drg.tw - Create Pretty Short URL\";}', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shorten_url`
--

CREATE TABLE `shorten_url` (
  `id` bigint(20) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `long_url` varchar(1000) NOT NULL,
  `code` varchar(10) NOT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shorten_url`
--

INSERT INTO `shorten_url` (`id`, `created`, `modified`, `name`, `user_id`, `long_url`, `code`, `domain`, `is_active`, `deleted`) VALUES
(1, '2018-08-25 07:05:05', '2018-08-25 07:05:05', 'ddfsfdfd', 10, 'https:/www.dragdeal.com/', 'VpmS', NULL, 1, NULL),
(2, '2018-08-26 07:06:05', '2018-08-26 07:06:05', 'New Campign', 10, 'https://www.drgdeal.com?cam=1', 'c19bf', NULL, 1, NULL),
(3, '2018-08-26 07:06:38', '2018-08-26 07:06:38', 'Damo', 10, 'https://www.dragdeal.com', '53be0', NULL, 1, NULL),
(4, '2018-08-26 07:30:05', '2018-08-26 07:30:05', 'damo2', 10, 'https://www.dragdeal.com', 'f9d6a', NULL, 0, NULL),
(5, '2018-08-26 08:15:28', '2018-08-26 08:15:28', 'Stack', 10, 'https://stackoverflow.com/questions/742013/how-to-code-a-url-shortener', '80476', NULL, 1, NULL),
(6, '2018-08-26 08:48:29', '2018-08-26 08:48:29', 'short', 2, 'http://localhost/short_url/c19bf', '9acfd', NULL, 1, NULL),
(7, '2018-08-26 08:50:14', '2018-08-26 08:50:14', 'neq', 2, 'https://www.dragdeal.com', 'e3055', NULL, 1, NULL),
(8, '2018-08-26 08:53:52', '2018-08-26 08:53:52', 'neq1', 2, 'https://www.dragdeal.com/contact', '1768f', NULL, 1, NULL),
(9, '2018-08-26 10:33:16', '2018-08-26 10:33:16', 'Short', 2, 'https://www.dragdeal.com', '53614', NULL, 1, NULL),
(10, '2018-08-26 06:06:08', '2018-08-26 06:06:08', 'https://www.dragdeal.com', 1, 'https://www.dragdeal.com', '41217', NULL, 1, '2018-08-26 18:52:22'),
(11, '2018-08-26 06:53:46', '2018-08-26 06:53:46', 'first', 1, 'https://www.dragdeal.com', 'e37ce', NULL, 1, NULL),
(12, '2018-09-01 06:53:55', '2018-09-01 06:53:55', 'Damo', 1, 'http://localhost/short_url/create-short-url', 'aaf83', NULL, 1, NULL),
(13, '2018-09-01 07:18:59', '2018-09-01 07:18:59', 'facebook.com', 1, 'https://www.facebook.com', 'f9e95', NULL, 1, NULL),
(14, '2018-09-01 07:19:50', '2018-09-01 07:19:50', 'face', 1, 'http://www.facebook.com', '559ac', NULL, 1, NULL),
(15, '2018-09-01 07:20:45', '2018-09-01 07:20:45', 'Common', 1, 'https://www.dragdeal.com', 'fbcb3', NULL, 1, NULL),
(16, '2018-09-01 07:22:31', '2018-09-01 07:22:31', 'g', 1, 'https://www.dragdeal.com', '78804', NULL, 1, '2018-09-01 08:54:20'),
(17, '2018-09-01 07:23:26', '2018-09-01 07:23:26', 'd', 1, 'http://www.dragdeal.com', 'd6d87', NULL, 1, NULL),
(18, '2018-09-01 07:24:06', '2018-09-01 07:24:06', 'Short', 1, 'https://www.dragdeal.com', '06a07', NULL, 1, NULL),
(19, '2018-09-01 07:25:14', '2018-09-01 11:07:29', 'Hai', 1, 'https://www.facebook.com', 'e7257', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `short_url_visit`
--

CREATE TABLE `short_url_visit` (
  `id` bigint(20) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `short_url_id` bigint(20) NOT NULL,
  `visit_count` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `short_url_visit`
--

INSERT INTO `short_url_visit` (`id`, `created`, `modified`, `short_url_id`, `visit_count`) VALUES
(1, '2018-08-26 06:39:38', '2018-08-26 06:48:47', 10, 7),
(2, '2018-08-26 06:53:55', '0000-00-00 00:00:00', 11, 1),
(3, '2018-09-01 06:54:09', '0000-00-00 00:00:00', 12, 1),
(4, '2018-09-01 08:53:54', '2018-09-01 08:54:06', 19, 2),
(5, '2018-09-01 11:14:22', '2018-09-01 11:14:30', 18, 2);

-- --------------------------------------------------------

--
-- Table structure for table `short_url_visit_details`
--

CREATE TABLE `short_url_visit_details` (
  `id` bigint(20) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `visit_id` bigint(20) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `browser_version` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `short_url_visit_details`
--

INSERT INTO `short_url_visit_details` (`id`, `created`, `modified`, `visit_id`, `ip_address`, `browser`, `browser_version`, `platform`, `city`) VALUES
(1, '2018-08-26 06:47:08', '0000-00-00 00:00:00', 1, '', 'Google Chrome', '68.0.3440.106', 'windows', ''),
(2, '2018-08-26 06:48:08', '0000-00-00 00:00:00', 1, '', 'Google Chrome', '68.0.3440.106', 'windows', ''),
(3, '2018-08-26 06:48:47', '0000-00-00 00:00:00', 1, '', 'Google Chrome', '68.0.3440.106', 'windows', ''),
(4, '2018-08-26 06:53:56', '0000-00-00 00:00:00', 2, '', 'Google Chrome', '68.0.3440.106', 'windows', ''),
(5, '2018-09-01 06:54:10', '0000-00-00 00:00:00', 3, '', 'Google Chrome', '68.0.3440.106', 'windows', ''),
(6, '2018-09-01 08:53:54', '0000-00-00 00:00:00', 4, '', 'Google Chrome', '68.0.3440.106', 'windows', ''),
(7, '2018-09-01 08:54:06', '0000-00-00 00:00:00', 4, '', 'Google Chrome', '68.0.3440.106', 'windows', ''),
(8, '2018-09-01 11:14:22', '0000-00-00 00:00:00', 5, '', 'Google Chrome', '68.0.3440.106', 'windows', ''),
(9, '2018-09-01 11:14:30', '0000-00-00 00:00:00', 5, '', 'Google Chrome', '68.0.3440.106', 'windows', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` tinyint(4) NOT NULL COMMENT '1-Admin,2-customer',
  `is_email_confirmed` tinyint(1) NOT NULL,
  `uid` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created`, `modified`, `first_name`, `last_name`, `email`, `password`, `user_type`, `is_email_confirmed`, `uid`, `is_active`) VALUES
(1, '2018-08-25 00:00:00', '2018-08-25 00:00:00', 'Admin', 'Admin', 'admin@short.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, NULL, 1),
(6, '2018-08-26 02:05:40', '2018-08-26 02:05:40', 'venkatesh', 'elakiya', 'damo1@20minute.email', 'e10adc3949ba59abbe56e057f20f883e', 2, 1, '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shorten_url`
--
ALTER TABLE `shorten_url`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `short_url_visit`
--
ALTER TABLE `short_url_visit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `short_url_visit_details`
--
ALTER TABLE `short_url_visit_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `shorten_url`
--
ALTER TABLE `shorten_url`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `short_url_visit`
--
ALTER TABLE `short_url_visit`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `short_url_visit_details`
--
ALTER TABLE `short_url_visit_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
