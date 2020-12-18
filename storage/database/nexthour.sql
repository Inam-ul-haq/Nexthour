-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 03, 2020 at 10:56 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dump_2.7`
--

-- --------------------------------------------------------

--
-- Table structure for table `actors`
--

CREATE TABLE `actors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biography` longtext COLLATE utf8mb4_unicode_ci,
  `place_of_birth` mediumtext COLLATE utf8mb4_unicode_ci,
  `DOB` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `ad_type` varchar(100) NOT NULL,
  `ad_image` varchar(100) NOT NULL,
  `ad_video` varchar(100) NOT NULL,
  `ad_url` varchar(100) DEFAULT NULL,
  `ad_location` varchar(100) NOT NULL,
  `ad_target` varchar(100) DEFAULT NULL,
  `ad_hold` int(50) DEFAULT NULL,
  `time` varchar(100) NOT NULL,
  `endtime` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `adsenses`
--

CREATE TABLE `adsenses` (
  `id` int(11) NOT NULL,
  `code` longtext NOT NULL,
  `status` tinyint(1) NOT NULL,
  `ishome` tinyint(1) NOT NULL,
  `isviewall` tinyint(1) NOT NULL,
  `issearch` tinyint(1) NOT NULL,
  `iswishlist` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adsenses`
--

INSERT INTO `adsenses` (`id`, `code`, `status`, `ishome`, `isviewall`, `issearch`, `iswishlist`, `created_at`, `updated_at`) VALUES
(1, '<script type=\"text/javascript\">\r\n    google_ad_client = \"ca-pub-51*****673\";  \r\n    google_ad_slot = \"59*****49\"; \r\n    google_ad_width = 728;\r\n    google_ad_height =  90; \r\n \r\n    </script>', 0, 0, 0, 0, 0, '2019-09-09 12:43:44', '2019-12-28 06:19:03');

-- --------------------------------------------------------

--
-- Table structure for table `audio_languages`
--

CREATE TABLE `audio_languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `language` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_customizes`
--

CREATE TABLE `auth_customizes` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auth_customizes`
--

INSERT INTO `auth_customizes` (`id`, `image`, `detail`, `created_at`, `updated_at`) VALUES
(1, '{\"en\":\"auth_page1524556424login.jpg\"}', '{\"en\":\"<h1 class=\\\"heading--primary\\\"><span>Welcome to<\\/span><br> Next Hour<\\/h1>\\r\\n<h2 class=\\\"heading--secondary\\\">Are you ready to join the elite?<\\/h2>\"}', '2018-04-21 18:30:00', '2018-04-24 02:28:17');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(13) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `image` varchar(255) NOT NULL,
  `detail` varchar(5000) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_active` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `buttons`
--

CREATE TABLE `buttons` (
  `id` int(10) UNSIGNED NOT NULL,
  `rightclick` tinyint(1) NOT NULL DEFAULT '1',
  `inspect` tinyint(1) DEFAULT NULL,
  `goto` tinyint(1) NOT NULL DEFAULT '1',
  `color` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buttons`
--

INSERT INTO `buttons` (`id`, `rightclick`, `inspect`, `goto`, `color`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, '2018-07-31 06:00:00', '2020-02-01 12:39:46');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(13) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(191) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE `configs` (
  `id` int(10) UNSIGNED NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `w_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verify_email` tinyint(1) NOT NULL,
  `download` int(11) DEFAULT '0',
  `free_sub` int(11) NOT NULL DEFAULT '0',
  `free_days` int(11) DEFAULT NULL,
  `stripe_pub_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_secret_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paypal_mar_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_add` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prime_main_slider` tinyint(1) NOT NULL DEFAULT '1',
  `catlog` tinyint(1) NOT NULL,
  `withlogin` tinyint(1) NOT NULL,
  `prime_genre_slider` tinyint(1) NOT NULL DEFAULT '1',
  `donation` tinyint(1) DEFAULT NULL,
  `donation_link` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prime_footer` tinyint(1) NOT NULL DEFAULT '1',
  `prime_movie_single` tinyint(1) NOT NULL DEFAULT '1',
  `terms_condition` text COLLATE utf8mb4_unicode_ci,
  `privacy_pol` text COLLATE utf8mb4_unicode_ci,
  `refund_pol` text COLLATE utf8mb4_unicode_ci,
  `copyright` text COLLATE utf8mb4_unicode_ci,
  `stripe_payment` tinyint(1) NOT NULL DEFAULT '1',
  `paypal_payment` tinyint(1) NOT NULL DEFAULT '1',
  `age_restriction` tinyint(1) DEFAULT '0',
  `payu_payment` tinyint(1) NOT NULL DEFAULT '1',
  `bankdetails` tinyint(1) NOT NULL,
  `account_no` varchar(111) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch` varchar(111) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(111) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifsc_code` varchar(111) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(111) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paytm_payment` int(11) UNSIGNED DEFAULT '0',
  `paytm_test` tinyint(11) DEFAULT NULL,
  `preloader` tinyint(1) NOT NULL DEFAULT '1',
  `fb_login` tinyint(1) NOT NULL,
  `gitlab_login` tinyint(1) NOT NULL,
  `google_login` tinyint(1) NOT NULL,
  `wel_eml` tinyint(1) DEFAULT NULL,
  `blog` tinyint(1) NOT NULL DEFAULT '0',
  `is_playstore` tinyint(1) NOT NULL DEFAULT '0',
  `is_appstore` tinyint(1) NOT NULL DEFAULT '0',
  `playstore` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appstore` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_dark` tinyint(1) DEFAULT NULL,
  `user_rating` tinyint(1) NOT NULL DEFAULT '0',
  `comments` tinyint(1) NOT NULL DEFAULT '0',
  `braintree` tinyint(1) NOT NULL DEFAULT '0',
  `paystack` tinyint(1) NOT NULL DEFAULT '0',
  `remove_landing_page` tinyint(1) NOT NULL DEFAULT '0',
  `coinpay` tinyint(1) NOT NULL DEFAULT '0',
  `aws` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`id`, `logo`, `favicon`, `title`, `w_email`, `verify_email`, `download`, `free_sub`, `free_days`, `stripe_pub_key`, `stripe_secret_key`, `paypal_mar_email`, `currency_code`, `currency_symbol`, `invoice_add`, `prime_main_slider`, `catlog`, `withlogin`, `prime_genre_slider`, `donation`, `donation_link`, `prime_footer`, `prime_movie_single`, `terms_condition`, `privacy_pol`, `refund_pol`, `copyright`, `stripe_payment`, `paypal_payment`, `age_restriction`, `payu_payment`, `bankdetails`, `account_no`, `branch`, `account_name`, `ifsc_code`, `bank_name`, `paytm_payment`, `paytm_test`, `preloader`, `fb_login`, `gitlab_login`, `google_login`, `wel_eml`, `blog`, `is_playstore`, `is_appstore`, `playstore`, `appstore`, `color`, `color_dark`, `user_rating`, `comments`, `braintree`, `paystack`, `remove_landing_page`, `coinpay`, `aws`, `created_at`, `updated_at`) VALUES
(1, 'logo_1550663262logo.png', 'favicon.png', '{\"en\":\"Nexthour\",\"Spanish\":\"Nexthour\",\"spanish\":\"Nexthour\",\"FR\":\"Nexthour\",\"EN\":\"Nexthour\"}', 'contact@nexthour.com', 0, 0, 0, 40, '', '', '', 'USD', 'fa fa-dollar', '{\"en\":null,\"Spanish\":null,\"spanish\":null,\"FR\":null,\"EN\":null}', 0, 1, 1, 1, 0, NULL, 1, 1, '{\"en\":\"<p>new goodes<\\/p>\",\"nl\":\"<p>newvious&nbsp;goodesioanos<\\/p>\"}', NULL, NULL, '{\"en\":\"Next Hour | All Rights Reserved.\"}', 0, 1, 0, 0, 1, '9r9348439', NULL, 'jdhfjd', 'ksdjkdjf093', 'hjdfhjd', 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 'https://www.youtube.com/upload', 'https://www.youtube.com/upload', 'default', 0, 0, 0, 1, 1, 0, 0, 0, NULL, '2020-02-01 12:40:04');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_codes`
--

CREATE TABLE `coupon_codes` (
  `id` int(10) UNSIGNED NOT NULL,
  `coupon_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percent_off` double(8,2) DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount_off` double(8,2) DEFAULT NULL,
  `duration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'once',
  `max_redemptions` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redeem_by` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_cp_callback_addresses`
--

CREATE TABLE `cp_cp_callback_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `address` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pubkey` text COLLATE utf8mb4_unicode_ci,
  `ipn_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dest_tag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_cp_conversions`
--

CREATE TABLE `cp_cp_conversions` (
  `id` int(10) UNSIGNED NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dest_tag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_cp_deposits`
--

CREATE TABLE `cp_cp_deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `txn_id` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `status_text` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirms` tinyint(3) UNSIGNED NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amounti` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fee` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feei` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dest_tag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_cp_ipns`
--

CREATE TABLE `cp_cp_ipns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ipn_version` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ipn_id` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ipn_mode` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merchant` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ipn_type` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `txn_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `status_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirms` tinyint(3) UNSIGNED DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amounti` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feei` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dest_tag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buyer_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom` text COLLATE utf8mb4_unicode_ci,
  `send_tx` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_confirms` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_cp_log`
--

CREATE TABLE `cp_cp_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `log` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_cp_mass_withdrawals`
--

CREATE TABLE `cp_cp_mass_withdrawals` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_cp_transactions`
--

CREATE TABLE `cp_cp_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency1` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency2` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fee` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dest_tag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buyer_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buyer_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom` text COLLATE utf8mb4_unicode_ci,
  `ipn_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `txn_id` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirms_needed` tinyint(3) UNSIGNED NOT NULL,
  `timeout` int(10) UNSIGNED NOT NULL,
  `status_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qrcode_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `status_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_confirms` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_cp_transfers`
--

CREATE TABLE `cp_cp_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merchant` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pbntag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auto_confirm` tinyint(1) NOT NULL DEFAULT '0',
  `ref_id` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_cp_withdrawals`
--

CREATE TABLE `cp_cp_withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mass_withdrawal_id` int(10) UNSIGNED DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amounti` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency2` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pbntag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dest_tag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ipn_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auto_confirm` tinyint(1) NOT NULL DEFAULT '0',
  `note` text COLLATE utf8mb4_unicode_ci,
  `ref_id` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `status_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `txn_id` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `directors`
--

CREATE TABLE `directors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biography` longtext COLLATE utf8mb4_unicode_ci,
  `place_of_birth` mediumtext COLLATE utf8mb4_unicode_ci,
  `DOB` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donater_lists`
--

CREATE TABLE `donater_lists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `method` varchar(191) DEFAULT NULL,
  `donor_msg` longtext,
  `amount` varchar(191) DEFAULT NULL,
  `payment_id` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `episodes`
--

CREATE TABLE `episodes` (
  `id` int(10) UNSIGNED NOT NULL,
  `seasons_id` int(10) UNSIGNED NOT NULL,
  `tmdb_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `episode_no` int(11) DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmdb` char(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci,
  `a_language` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` tinyint(1) DEFAULT NULL,
  `subtitle_list` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle_files` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `released` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` char(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'E',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(10) UNSIGNED NOT NULL,
  `question` longtext COLLATE utf8mb4_unicode_ci,
  `answer` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `footer_translations`
--

CREATE TABLE `footer_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footer_translations`
--

INSERT INTO `footer_translations` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'terms and condition', '{\"en\":\"Terms and condition\",\"nl\":\"Terms and condition2\",\"de\":\"Gesch\\u00e4ftsbedingung\"}', NULL, '2018-04-24 03:31:15'),
(2, 'privacy policy', '{\"en\":\"Privacy policy\",\"nl\":\"Privacy policy2\",\"de\":\"Datenschutz-Bestimmungen\"}', NULL, '2018-04-24 03:31:15'),
(3, 'refund policy', '{\"en\":\"Refund policy\",\"nl\":\"Refund policy2\",\"de\":\"R\\u00fcckgaberecht\"}', NULL, '2018-04-24 03:31:15'),
(4, 'help', '{\"en\":\"Help\",\"nl\":\"Help2\",\"de\":\"Hilfe\"}', NULL, '2018-04-24 03:31:15'),
(5, 'corporate', '{\"en\":\"Corporate\",\"nl\":\"Corporate2\",\"de\":\"Unternehmen\"}', NULL, '2018-04-24 03:31:15'),
(6, 'sitemap', '{\"en\":\"Sitemap\",\"nl\":\"Sitemap2\",\"de\":\"Seitenverzeichnis\"}', NULL, '2018-04-24 03:31:15'),
(7, 'subscribe', '{\"en\":\"Subscribe\",\"nl\":\"Subscribe2\",\"de\":\"Abonnieren\"}', NULL, '2018-04-24 03:31:15'),
(8, 'subscribe text', '{\"en\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.\",\"nl\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.2\",\"de\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.\"}', NULL, '2018-04-24 03:33:44');

-- --------------------------------------------------------

--
-- Table structure for table `front_slider_updates`
--

CREATE TABLE `front_slider_updates` (
  `id` int(10) UNSIGNED NOT NULL,
  `item_show` int(11) UNSIGNED DEFAULT NULL,
  `orderby` int(11) DEFAULT '1',
  `sliderview` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `front_slider_updates`
--

INSERT INTO `front_slider_updates` (`id`, `item_show`, `orderby`, `sliderview`) VALUES
(1, 6, 1, 1),
(2, 6, 0, 1),
(3, 3, 1, 1),
(4, 3, 0, 0),
(5, 2, 1, 0),
(6, 1, 1, 0),
(7, 1, 1, 0),
(8, 2, 1, 0),
(9, 1, 1, 1),
(10, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `header_translations`
--

CREATE TABLE `header_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `header_translations`
--

INSERT INTO `header_translations` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(4, 'dashboard', '{\"en\":\"Dashboard\",\"nl\":\"Dashboard\",\"de\":\"Instrumententafel\"}', NULL, '2019-02-11 09:31:22'),
(5, 'faqs', '{\"en\":\"Faq\'s\",\"nl\":\"Faq\'s\",\"de\":\"Faq\'s\"}', NULL, '2018-04-24 03:30:15'),
(6, 'sign in', '{\"en\":\"Sign In\",\"nl\":\"Sign In\",\"de\":\"Anmelden\"}', NULL, '2018-04-24 03:30:15'),
(7, 'sign out', '{\"en\":\"Sign Out\",\"nl\":\"Sign Out\",\"de\":\"Ausloggen\"}', NULL, '2018-04-24 03:30:15'),
(8, 'watchlist', '{\"en\":\"Watchlist\",\"nl\":\"Watchlist\",\"de\":\"Beobachtungsliste\"}', NULL, '2018-04-24 03:30:15'),
(9, 'register', '{\"en\":\"Register\",\"nl\":\"Register\",\"de\":\"Registrieren\"}', NULL, '2018-04-24 03:30:15'),
(10, 'donation', '{\"en\":\"Donation\"}', NULL, '2019-10-02 03:43:51'),
(11, 'Free Trial', '{\"en\":\"Free Trial\"}', NULL, '2019-10-22 02:05:02'),
(12, 'Free Trial Text', '{\"en\":\"Your Free Member Ship has Started\"}', NULL, '2019-10-22 05:08:44'),
(13, 'watch history', '{\"en\":\"Watch History\"}', NULL, '2019-11-11 02:36:51'),
(14, 'average rating', '{\"en\":\"Avg Rating\"}', NULL, '2019-11-11 04:46:54');

-- --------------------------------------------------------

--
-- Table structure for table `home_sliders`
--

CREATE TABLE `home_sliders` (
  `id` int(10) UNSIGNED NOT NULL,
  `movie_id` int(10) UNSIGNED DEFAULT NULL,
  `tv_series_id` int(10) UNSIGNED DEFAULT NULL,
  `slide_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_translations`
--

CREATE TABLE `home_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_translations`
--

INSERT INTO `home_translations` (`id`, `key`, `value`, `status`, `created_at`, `updated_at`) VALUES
(1, 'watch next tv series and movies', '{\"en\":\"Watch Next TV Series And Movies\",\"nl\":\"Watch Nexot TV Seriesee And Moviessk\",\"de\":\"Schaue n\\u00e4chste TV-Serie und Filme\"}', 1, NULL, '2019-05-06 12:54:11'),
(2, 'watch next movies', '{\"en\":\"Watch Next Movies\",\"nl\":\"Watch Next Movies5\",\"de\":\"Sieh dir die n\\u00e4chsten Filme an\"}', 1, NULL, '2019-05-06 12:54:01'),
(3, 'watch next tv series', '{\"en\":\"Watch Next TV Series\",\"nl\":\"Watch Next TV Series5\",\"de\":\"Sehen Sie sich die n\\u00e4chste TV-Serie an\"}', 1, NULL, '2019-05-06 12:37:21'),
(4, 'view all', '{\"en\":\"View all\",\"nl\":\"View all5\",\"de\":\"Alle ansehen\"}', 1, NULL, '2019-02-10 11:10:32'),
(5, 'featured', '{\"en\":\"Featured\",\"nl\":\"featured5\",\"de\":\"gekennzeichnet\"}', 1, NULL, '2019-07-24 23:37:51'),
(7, 'movies in', '{\"en\":\"Movies  in\",\"nl\":\"movies  in5\",\"de\":\"Filme in\"}', 1, NULL, '2019-05-06 12:53:12'),
(8, 'tv shows in', '{\"en\":\"Tv Shows in\",\"nl\":\"tv shows in5\",\"de\":\"Fernsehshows in\"}', 1, NULL, '2019-07-24 23:50:09'),
(9, 'at the big screen at home', '{\"en\":\"at the big screen at home\",\"nl\":\"at the big screen at home5\",\"de\":\"auf dem gro\\u00dfen Bildschirm zu Hause\"}', 1, NULL, '2018-04-24 03:36:54'),
(10, 'recently added', '{\"en\":\"Recently Added\",\"nl\":\"Recently Added5\",\"de\":\"K\\u00fcrzlich hinzugef\\u00fcgt\"}', 1, NULL, '2018-04-24 03:36:54'),
(11, 'found for', '{\"en\":\"Found for\",\"nl\":\"found for5\",\"de\":\"gefunden f\\u00fcr\"}', 1, NULL, '2018-04-24 03:39:13'),
(12, 'directors', '{\"en\":\"Directors\",\"nl\":\"Directors5\",\"de\":\"Direktoren\"}', 1, NULL, '2018-04-24 03:36:54'),
(13, 'starring', '{\"en\":\"Starring\",\"nl\":\"Starring5\",\"de\":\"Mit\"}', 1, NULL, '2018-04-24 03:36:54'),
(14, 'genres', '{\"en\":\"Genres\",\"nl\":\"Genres5\",\"de\":\"Genres\"}', 1, NULL, '2018-04-24 03:36:54'),
(15, 'audio languages', '{\"en\":\"Audio Languages\",\"nl\":\"Audio Languages5\",\"de\":\"Audio-Sprachen\"}', 1, NULL, '2018-04-24 03:36:54'),
(16, 'customers also watched', '{\"en\":\"Customers also watched\",\"nl\":\"Customers also watched5\",\"de\":\"Kunden haben auch zugeschaut\"}', 1, NULL, '2018-04-24 03:36:54'),
(17, 'episodes', '{\"en\":\"Episodes\",\"nl\":\"Episodes5\",\"de\":\"Episoden\"}', 1, NULL, '2018-04-24 03:36:54'),
(18, 'series', '{\"en\":\"Series\",\"nl\":\"Series5\",\"de\":\"Serie\"}', 1, NULL, '2018-04-24 03:36:54'),
(19, 'frequently asked questions', '{\"en\":\"Frequently Asked Questions\",\"nl\":\"Frequently Asked Questions5\",\"de\":\"H\\u00e4ufig gestellte Fragen\"}', 1, NULL, '2018-04-24 03:36:54'),
(20, 'movies', '{\"en\":\"Movies\",\"nl\":\"Movies5\",\"de\":\"Filme\"}', 1, NULL, '2019-05-07 12:03:39'),
(21, 'tv shows', '{\"en\":\"Tv Shows\",\"nl\":\"Tv Shows5\",\"de\":\"Fernsehshows\"}', 1, NULL, '2019-05-07 12:03:17'),
(22, 'Actor DOB', '{\"en\":\"Date Of Birth\"}', 1, NULL, '2019-11-02 05:38:41'),
(23, 'Actor Place Of Birth', '{\"en\":\"Place Of Birth\"}', 1, NULL, '2019-11-02 05:38:41'),
(24, 'TMDB Rating', '{\"en\":\"Rating\"}', 1, NULL, '2019-11-25 04:47:46');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `landing_pages`
--

CREATE TABLE `landing_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `heading` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci,
  `button` tinyint(1) NOT NULL DEFAULT '1',
  `button_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `left` tinyint(1) NOT NULL DEFAULT '1',
  `position` int(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `landing_pages`
--

INSERT INTO `landing_pages` (`id`, `image`, `heading`, `detail`, `button`, `button_text`, `button_link`, `left`, `position`, `created_at`, `updated_at`) VALUES
(1, 'landing_page_1524556124home_1.jpg', '{\"en\":\"Welcome!  Join Next Hour\",\"de\":\"Herzlich willkommen! Beitreten Next Hour\"}', '{\"en\":\"Join Next Hour to watch the most recent motion pictures, elite TV appears and grant winning Next Hour membership at simply least cost.\",\"de\":\"Nehmen Sie an der Next Hour teil und schauen Sie sich die neuesten Filme an, das Elite-TV-Programm erscheint und gew\\u00e4hrt Ihnen die beste Mitgliedschaft in der n\\u00e4chsten Stunde zu den niedrigsten Kosten.\"}', 1, '{\"en\":\"Join Next Hour\",\"de\":\"Join Next Hour\"}', 'login', 0, 1, '2018-04-24 02:18:44', '2018-04-24 03:26:57'),
(2, 'landing_page_1524556182home_3.jpg', '{\"en\":\"Don\'t Miss TV Shows\",\"de\":\"Vermisse Fernsehserien nicht\"}', '{\"en\":\"With your Next Hour membership, you approach select US and all TV shows, grant winning Next Hour Original Series and kids and children shows.\",\"de\":\"Mit Ihrer Mitgliedschaft bei der n\\u00e4chsten Stunde n\\u00e4hern Sie sich ausgew\\u00e4hlten US- und allen TV-Shows, gewinnen Next-Hour-Serien und Kinder- und Kindershows.\"}', 1, '{\"en\":\"Register Now\",\"de\":\"Register Now\"}', 'register', 1, 2, '2018-04-24 02:19:42', '2018-04-24 03:27:48'),
(3, 'landing_page_1524556261home_5.jpg', '{\"en\":\"Membership for Movies & TV shows\",\"de\":\"Mitgliedschaft f\\u00fcr Filme und TV-Sendungen\"}', '{\"en\":\"Notwithstanding boundless gushing, your Next Hour membership incorporates elite Bollywood, Hollywood films, US and all TV shows, grant winning Next Hour Series and kids shows.\",\"de\":\"Trotz grenzenloser Begeisterung enth\\u00e4lt Ihre Next Hour-Mitgliedschaft Elite-Bollywood, Hollywood-Filme, US-amerikanische und alle TV-Shows, die Grant Winning Next Hour Series und Kindershows.\"}', 1, '{\"en\":\"Login Now\",\"de\":\"Login Now\"}', 'login', 0, 3, '2018-04-24 02:21:01', '2018-04-24 03:28:09'),
(4, 'landing_page_1524556322home_9.jpg', '{\"en\":\"Kids Special\",\"de\":\"Kinder Spezial\"}', '{\"en\":\"With simple to utilize parental controls and a committed children page, you can appreciate secure, advertisement free children and kids diversion. Children and kids can appreciate famous TV shows\",\"de\":\"Mit einfach zu verwenden Kindersicherung und eine engagierte Kinder Seite k\\u00f6nnen Sie sicher, werbefreie Kinder und Kinder Ablenkung sch\\u00e4tzen. Kinder und Kinder k\\u00f6nnen ber\\u00fchmte Fernsehshows genie\\u00dfen\"}', 1, '{\"en\":\"Get Now\",\"de\":\"Get Now\"}', 'register', 0, 4, '2018-04-24 02:22:02', '2018-04-24 03:28:28');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `local` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `def` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(13) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `added` varchar(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_videos`
--

CREATE TABLE `menu_videos` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `movie_id` int(10) UNSIGNED DEFAULT NULL,
  `tv_series_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2015_03_07_311070_create_tracker_paths_table', 1),
(4, '2015_03_07_311071_create_tracker_queries_table', 1),
(5, '2015_03_07_311072_create_tracker_queries_arguments_table', 1),
(6, '2015_03_07_311073_create_tracker_routes_table', 1),
(7, '2015_03_07_311074_create_tracker_routes_paths_table', 1),
(8, '2015_03_07_311075_create_tracker_route_path_parameters_table', 1),
(9, '2015_03_07_311076_create_tracker_agents_table', 1),
(10, '2015_03_07_311077_create_tracker_cookies_table', 1),
(11, '2015_03_07_311078_create_tracker_devices_table', 1),
(12, '2015_03_07_311079_create_tracker_domains_table', 1),
(13, '2015_03_07_311080_create_tracker_referers_table', 1),
(14, '2015_03_07_311081_create_tracker_geoip_table', 1),
(15, '2015_03_07_311082_create_tracker_sessions_table', 1),
(16, '2015_03_07_311083_create_tracker_errors_table', 1),
(17, '2015_03_07_311084_create_tracker_system_classes_table', 1),
(18, '2015_03_07_311085_create_tracker_log_table', 1),
(19, '2015_03_07_311086_create_tracker_events_table', 1),
(20, '2015_03_07_311087_create_tracker_events_log_table', 1),
(21, '2015_03_07_311088_create_tracker_sql_queries_table', 1),
(22, '2015_03_07_311089_create_tracker_sql_query_bindings_table', 1),
(23, '2015_03_07_311090_create_tracker_sql_query_bindings_parameters_table', 1),
(24, '2015_03_07_311091_create_tracker_sql_queries_log_table', 1),
(25, '2015_03_07_311092_create_tracker_connections_table', 1),
(26, '2015_03_07_311093_create_tracker_tables_relations', 1),
(27, '2015_03_13_311094_create_tracker_referer_search_term_table', 1),
(28, '2015_03_13_311095_add_tracker_referer_columns', 1),
(29, '2015_11_23_311096_add_tracker_referer_column_to_log', 1),
(30, '2015_11_23_311097_create_tracker_languages_table', 1),
(31, '2015_11_23_311098_add_language_id_column_to_sessions', 1),
(32, '2015_11_23_311099_add_tracker_language_foreign_key_to_sessions', 1),
(33, '2015_11_23_311100_add_nullable_to_tracker_error', 1),
(34, '2017_01_31_311101_fix_agent_name', 1),
(35, '2017_06_20_311102_add_agent_name_hash', 1),
(36, '2017_11_11_083037_create_movies_table', 1),
(37, '2017_11_12_054912_create_directors_table', 1),
(38, '2017_11_12_055733_create_actors_table', 1),
(39, '2017_11_12_060041_create_genres_table', 1),
(40, '2017_11_12_060748_create_packages_table', 1),
(41, '2017_11_12_061316_create_faqs_table', 1),
(42, '2017_11_12_061432_create_configs_table', 1),
(43, '2018_01_09_083026_add_cashier_table_fields', 1),
(44, '2018_01_09_090132_create_permission_tables', 1),
(45, '2018_01_11_040258_create_coupon_codes_table', 1),
(46, '2018_01_16_110614_create_movie_series_table', 1),
(47, '2018_01_16_153532_create_audio_languages_table', 1),
(48, '2018_01_24_123038_create_tv_series_table', 1),
(49, '2018_02_03_073641_create_wishlists_table', 1),
(50, '2018_03_14_132728_create_home_sliders_table', 1),
(51, '2018_03_14_135038_create_seasons_table', 1),
(52, '2018_03_14_140100_create_episodes_table', 1),
(53, '2018_03_25_132517_create_videolinks_table', 1),
(54, '2018_04_02_140524_create_paypal_subscriptions_table', 1),
(55, '2018_04_12_035533_create_languages_table', 1),
(56, '2018_04_14_053616_create_home_translations_table', 2),
(57, '2018_04_14_172143_create_header_translations_table', 3),
(58, '2018_04_14_172228_create_footer_translations_table', 3),
(59, '2018_04_14_180413_create_popover_translations_table', 4),
(60, '2018_04_16_065808_create_menus_table', 5),
(61, '2018_04_16_070130_create_menu_videos_table', 5),
(62, '2018_04_16_080456_create_menu_videos_table', 6),
(63, '2016_12_03_000000_create_payu_payments_table', 7),
(64, '2018_04_19_163952_create_landing_pages_table', 8),
(65, '2018_04_22_163308_create_manage_packages_table', 9),
(66, '2018_04_22_165105_create_auth_customizes_table', 10),
(67, '2018_07_20_113202_create_subs_table', 11),
(68, '2018_07_20_171234_create_seos_table', 11),
(69, '2018_07_21_053731_create_plans_table', 12),
(70, '2018_07_31_115802_create_buttons_table', 13),
(72, '2019_02_10_115619_create_pricing_texts_table', 14),
(73, '2019_09_14_061904_create_notifications_table', 15),
(74, '2016_06_01_000001_create_oauth_auth_codes_table', 16),
(75, '2016_06_01_000002_create_oauth_access_tokens_table', 16),
(76, '2016_06_01_000003_create_oauth_refresh_tokens_table', 16),
(77, '2016_06_01_000004_create_oauth_clients_table', 16),
(78, '2016_06_01_000005_create_oauth_personal_access_clients_table', 16),
(79, '2019_11_07_141409_create_jobs_table', 17),
(80, '2017_09_15_051156_setup_coinpayment_tables', 18),
(81, '2018_03_24_032432_create_callback_address_table', 18),
(82, '2018_05_07_123123_fix_transactions_table', 18),
(83, '2018_05_08_037214_cp_create_mass_withdrawal', 18),
(84, '2018_07_01_112608_add_column_dest_tag_to_transactions_table', 18);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(10) UNSIGNED NOT NULL,
  `tmdb_id` int(11) DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `duration` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poster` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmdb` char(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fetch_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `director_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actor_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `genre_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trailer_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci,
  `rating` int(11) DEFAULT NULL,
  `maturity_rating` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` tinyint(1) DEFAULT NULL,
  `subtitle_list` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle_files` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publish_year` int(11) DEFAULT NULL,
  `released` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upload_video` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` tinyint(1) DEFAULT NULL,
  `series` tinyint(1) DEFAULT NULL,
  `a_language` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audio_files` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` char(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'M',
  `live` tinyint(1) DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movie_comments`
--

CREATE TABLE `movie_comments` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `tv_series_id` int(11) DEFAULT NULL,
  `comment` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `movie_series`
--

CREATE TABLE `movie_series` (
  `id` int(10) UNSIGNED NOT NULL,
  `movie_id` int(10) UNSIGNED NOT NULL,
  `series_movie_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movie_subcomments`
--

CREATE TABLE `movie_subcomments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `reply` varchar(200) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `multiplescreens`
--

CREATE TABLE `multiplescreens` (
  `id` int(11) UNSIGNED NOT NULL,
  `screen1` varchar(50) DEFAULT NULL,
  `screen2` varchar(50) DEFAULT NULL,
  `screen3` varchar(50) DEFAULT NULL,
  `screen4` varchar(50) DEFAULT NULL,
  `screen5` varchar(50) DEFAULT NULL,
  `screen6` varchar(50) DEFAULT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `activescreen` varchar(191) DEFAULT NULL,
  `pkg_id` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table for multiple screens for user ';

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `tv_id` int(11) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0089401daa90d3762f58a89e8293b5daf7ccec3fdaa1b71e0f2609b14677a5234f91d54f4d014087', 7, 2, NULL, '[]', 0, '2019-12-13 05:49:01', '2019-12-13 05:49:01', '2020-12-13 11:19:01'),
('0165da9b4bd9460ccdabf3531e5b2a3943b894bc6b45ad799d90e15779bba78548f35935274460c6', 7, 2, NULL, '[]', 0, '2019-12-16 06:54:58', '2019-12-16 06:54:58', '2020-12-16 12:24:58'),
('020ea46a0c8127e2242afb4b4aec41b59029806bf2e235bbb9b86a4c1e6882006ec677646047e7e0', 5, 2, NULL, '[]', 0, '2019-12-09 04:36:29', '2019-12-09 04:36:29', '2020-12-09 10:06:29'),
('031da479ac44e56c39bdec9121429d6e24b35bb8c4ad59e66ece568c8e38dec51a1158e67d287825', 1, 2, NULL, '[]', 0, '2019-12-11 06:23:27', '2019-12-11 06:23:27', '2020-12-11 11:53:27'),
('03efdbb210ab330282ef326df8a455f61ac976eabecfd4c87283baac1a9088af94890fa974d47071', 7, 2, NULL, '[]', 0, '2019-12-16 04:45:13', '2019-12-16 04:45:13', '2020-12-16 10:15:13'),
('043acc71e7bc4fa2f8d15c3abb29649df083fa5bd680a085761ef6836e79df9fce97b8fcd60592e6', 7, 2, NULL, '[]', 0, '2019-12-16 01:50:00', '2019-12-16 01:50:00', '2020-12-16 07:20:00'),
('072d4e64cd6a15a9985f1f0a84360db5b827109a28e0ca2849558d26c53dd406e8e7ea4054a29c2d', 7, 2, NULL, '[]', 0, '2019-12-12 00:02:34', '2019-12-12 00:02:34', '2020-12-12 05:32:34'),
('0b9b1a89dfd04f607726e0351eb5fe20fb89681999fdd1ecbee77e92d213d4fad9a82d212b7dde13', 7, 2, NULL, '[]', 0, '2019-12-14 04:45:28', '2019-12-14 04:45:28', '2020-12-14 10:15:28'),
('0ba02396d44032a48402a804382a13ca7f702ad03212f9ab5f5a76296aecbd4ec165f88bee4f89b8', 7, 2, NULL, '[]', 0, '2019-12-14 05:03:30', '2019-12-14 05:03:30', '2020-12-14 10:33:30'),
('0d70c840804fd8452a115933fa8166012e7936e4aa79e60018dee623b66e9f756ec33d3eaa9c2108', 7, 2, NULL, '[]', 0, '2019-12-15 23:38:51', '2019-12-15 23:38:51', '2020-12-16 05:08:51'),
('11a8611ddda072e502dc837ca83c9fd9a85606a3ef0764daa932e78811d039819ad432ab2aa47faf', 7, 2, NULL, '[]', 0, '2019-12-16 01:56:22', '2019-12-16 01:56:22', '2020-12-16 07:26:22'),
('131525a140141c88835e6288070cc7781632e7d19b63cfcf888c3dd98e39edc470889a95c7327907', 7, 2, NULL, '[]', 0, '2019-12-14 00:54:38', '2019-12-14 00:54:38', '2020-12-14 06:24:38'),
('17f9e1d284d89d7b16e58f8608fa10081a24d04bd2f5ce59fe242faab1e2ee33be603f6e52eb48d9', 7, 2, NULL, '[]', 0, '2019-12-16 07:24:27', '2019-12-16 07:24:27', '2020-12-16 12:54:27'),
('190135e2ea10693b2ee7b794a73678e30f386876c9f98d6bf6518c6a2bd9690aa8a18244c690340c', 7, 2, NULL, '[]', 0, '2019-12-13 01:35:52', '2019-12-13 01:35:52', '2020-12-13 07:05:52'),
('1b43e6c609931dc7b85ac0217e2cf6e1cce3173b33acc15c27d687c3bcd96cfe66bda3b0d0ffe9d0', 7, 2, NULL, '[]', 0, '2019-12-19 23:26:26', '2019-12-19 23:26:26', '2020-12-20 04:56:26'),
('1e34290ca3a996fff89bd1a4995e2377f35c8b3dc5c2380269f5d2f84d811df954ffe8e18943f622', 7, 2, NULL, '[]', 0, '2019-12-16 00:53:11', '2019-12-16 00:53:11', '2020-12-16 06:23:11'),
('24fe9b74a0d5d82006d0fc8409b5ca1a14ec1292af11f9570d9941febe2c68b082610f10f82a7e5b', 7, 2, NULL, '[]', 0, '2019-12-17 06:39:52', '2019-12-17 06:39:52', '2020-12-17 12:09:52'),
('251dbaf78d8463c17828f1c1eec7f7486fd81ad36910995a65575f95f04ec6e74c2dc004b1c27965', 7, 2, NULL, '[]', 0, '2019-12-20 00:06:08', '2019-12-20 00:06:08', '2020-12-20 05:36:08'),
('29d9165424adfe3968d77c7d7ee8bf1aaf7ab119fe446fc426a22ab0273781cfc22468baf3b64b7e', 7, 2, NULL, '[]', 0, '2019-12-14 04:41:54', '2019-12-14 04:41:54', '2020-12-14 10:11:54'),
('2a88ee907f487e1e4e5693a8fcdde003c5e0c90b9d541533b66049c29543d456fc41b3ababf0b458', 7, 2, NULL, '[]', 0, '2019-12-16 06:58:43', '2019-12-16 06:58:43', '2020-12-16 12:28:43'),
('2aa01970f1f76e24511bf6d0e76d6b46f972713fda765ecffff6a662d05449580aa4121e92e63876', 7, 2, NULL, '[]', 0, '2019-12-14 00:53:03', '2019-12-14 00:53:03', '2020-12-14 06:23:03'),
('2d7149c9f31b6100bb1779a5b918dab9438b0f0c2e674aaf85956154ca22b4cdb4794c7eb6a811cd', 7, 2, NULL, '[]', 0, '2019-12-16 06:53:15', '2019-12-16 06:53:15', '2020-12-16 12:23:15'),
('2e6d19459a737e39f1c118f21c7fd77a442e9ce233eab66eff15d4dfce15c1fe101885ff22e8e032', 7, 2, NULL, '[]', 0, '2019-12-14 05:02:50', '2019-12-14 05:02:50', '2020-12-14 10:32:50'),
('3194d8ffb180fd370ba1505311f75d5608e3f02d6ca331a032b841030ce5e61dc7ae619c9921bf43', 7, 2, NULL, '[]', 0, '2019-12-12 01:44:33', '2019-12-12 01:44:33', '2020-12-12 07:14:33'),
('3434090ba6953dce622f042113454477b4ae56f358b22b38cd565d2a4f43ce79157b9570984d13b9', 7, 2, NULL, '[]', 0, '2019-12-15 23:30:45', '2019-12-15 23:30:45', '2020-12-16 05:00:45'),
('3691e408be3fdaa7c864b3a93fc407e508ed79ece5712553f42fc82c85d88de23bceb491474a51e5', 7, 2, NULL, '[]', 0, '2019-12-12 00:48:33', '2019-12-12 00:48:33', '2020-12-12 06:18:33'),
('386be5cc96e9eeae10f62d4c4b9a98ac403f1f81ca1c8529be2fd0555f1982627895797f8c800b8e', 7, 2, NULL, '[]', 0, '2019-12-12 03:53:56', '2019-12-12 03:53:56', '2020-12-12 09:23:56'),
('3fc8ebc7aee93b3d57cf20cbffe2a993f2225e310db4cdf8f0b7a182b0aab5d84de276870b1af8e9', 7, 2, NULL, '[]', 0, '2019-12-20 00:22:39', '2019-12-20 00:22:39', '2020-12-20 05:52:39'),
('42c6e2e0c2cbbead6e526af5d3f8d4e4fb5d8d1f1a64ae4b4bbe1e93ceac4ac1cb404a66d9a96cbf', 7, 2, NULL, '[]', 0, '2019-12-14 04:43:35', '2019-12-14 04:43:35', '2020-12-14 10:13:35'),
('44d0bb305998af570ffb1033832bf304679790bf5f2c0930d9d724dca554dd7208b73d4e20546ca8', 7, 2, NULL, '[]', 0, '2019-12-13 00:53:44', '2019-12-13 00:53:44', '2020-12-13 06:23:44'),
('482c2ea3c2197a57628beb6b4ffa19a3e580ee44ad0b269945246476f7b44aab3b96abe80c2c8a22', 7, 2, NULL, '[]', 0, '2019-12-16 23:11:27', '2019-12-16 23:11:27', '2020-12-17 04:41:27'),
('4a15349f36de62f0f6af4587faef1711f85f1f3a52563776ad31cd9e665dd75a55a2eb946be5aa79', 7, 2, NULL, '[]', 0, '2019-12-16 07:03:43', '2019-12-16 07:03:43', '2020-12-16 12:33:43'),
('4b7d5cf955d2150f5934c2fbe52c61158f4df04c6ebb3a4b1d3f0888d3e1965b2aea935ccc46cb14', 7, 2, NULL, '[]', 0, '2019-12-15 23:48:53', '2019-12-15 23:48:53', '2020-12-16 05:18:53'),
('4c52ebace1961d6a47e86152784cd53adcef42a93d99fa1e143c53a8c1a4d99cedb9e2c6c87067c4', 7, 2, NULL, '[]', 0, '2019-12-14 01:13:08', '2019-12-14 01:13:08', '2020-12-14 06:43:08'),
('4ddaa1ba565904672a66e234261bbb3b456108be1e85777a44c412ca21dd15f2a5ad32bb5aff699c', 7, 2, NULL, '[]', 0, '2019-12-14 04:04:18', '2019-12-14 04:04:18', '2020-12-14 09:34:18'),
('4e538a90bb17331250a8da79de372c34f5d9401f6b18f2c9c5926717de4399be418822381bf9bbc7', 7, 2, NULL, '[]', 0, '2019-12-14 01:51:34', '2019-12-14 01:51:34', '2020-12-14 07:21:34'),
('4f1c67fe9f8f51a1f001ee82d7d67fa74476066d99896a5beceed3741e26624d7e02a4d04d4a1dc1', 7, 2, NULL, '[]', 0, '2019-12-12 04:06:49', '2019-12-12 04:06:49', '2020-12-12 09:36:49'),
('4f8c3b5fb48f0cd1ef4118cf50eff21ede3f0f04a4ca0d84907381a77c646c1757d5a4a201121488', 7, 2, NULL, '[]', 0, '2019-12-16 01:31:35', '2019-12-16 01:31:35', '2020-12-16 07:01:35'),
('5150176a84637b2cbabc99bd62f09aba4fb4e241fa68f581c6eee5dcfe659b7fff8323b53251ff26', 7, 2, NULL, '[]', 0, '2019-12-13 06:37:04', '2019-12-13 06:37:04', '2020-12-13 12:07:04'),
('52f0fb3668ceaabcbb5fce4499b32569a089e86650713bddfb8f5a95c334c447cf5a61680fe1bee2', 7, 2, NULL, '[]', 0, '2019-12-12 00:51:11', '2019-12-12 00:51:11', '2020-12-12 06:21:11'),
('552c25775beb4dafc90f69cd338ada75edc02eb5d775693959308a26ac46b1d9d051b66a7722126a', 7, 2, NULL, '[]', 0, '2019-12-12 00:38:29', '2019-12-12 00:38:29', '2020-12-12 06:08:29'),
('559da40ee0a5496ebb36bde8152bbde0e7a6be62322da8048e202a7af4b9f0b9895a2ed612c3e154', 7, 2, NULL, '[]', 0, '2019-12-12 06:01:40', '2019-12-12 06:01:40', '2020-12-12 11:31:40'),
('5792992d82ff3e9f4046b527dfd6771720b95468b9a8b1490ff298c77852f07e57736706bcce29c4', 7, 2, NULL, '[]', 0, '2019-12-19 23:24:13', '2019-12-19 23:24:13', '2020-12-20 04:54:13'),
('5b4a7072b049e1fd177c6e5bc71b6ef42d50c624b6830b530f62c8faee191a21b1678b8628b9e95f', 7, 2, NULL, '[]', 0, '2019-12-16 04:44:02', '2019-12-16 04:44:02', '2020-12-16 10:14:02'),
('5d0e1cace9e598aef531af14e6023733ceaab0239761190d8f4b1d100d593890b0d76db2070fd675', 7, 2, NULL, '[]', 0, '2019-12-17 07:12:44', '2019-12-17 07:12:44', '2020-12-17 12:42:44'),
('5e45125d4a6daef70882819524cd702d08c87d437b8d32de413b021e470a69aecd07dca77ad50ec7', 7, 2, NULL, '[]', 0, '2019-12-12 01:02:44', '2019-12-12 01:02:44', '2020-12-12 06:32:44'),
('5ec7a4ca154d85804284483bc99e3aea8f760915236515ebb1a83dd1a443c4f84eeacea0459e8f7d', 7, 2, NULL, '[]', 0, '2019-12-14 01:46:37', '2019-12-14 01:46:37', '2020-12-14 07:16:37'),
('5fb77bc2344de0afb046168125b197f515157c6466aeea2e9c130ea7ec7439f24e27722cb3199309', 7, 2, NULL, '[]', 0, '2019-12-16 07:11:06', '2019-12-16 07:11:06', '2020-12-16 12:41:06'),
('63bd53b161fd6713d9d46058d692c597e329116f62156f4f38f98fb1a048df549dd8c78513fb9f6d', 7, 2, NULL, '[]', 0, '2019-12-14 05:09:36', '2019-12-14 05:09:36', '2020-12-14 10:39:36'),
('64411e83be3c5714e169eca698f28b4dd1be041bce5e3bc9d3a923c808eae986d975560d82992561', 7, 2, NULL, '[]', 0, '2019-12-14 01:21:34', '2019-12-14 01:21:34', '2020-12-14 06:51:34'),
('64ceeb9eb0d30c1dc06deac46d48c61abfd3a80179680ad7343d15fb0cbab0642c6d243304133c5e', 7, 2, NULL, '[]', 0, '2019-12-16 06:53:44', '2019-12-16 06:53:44', '2020-12-16 12:23:44'),
('66053da911d815e35fef44e4051240eb319083d99947a1bfdc5d0ec918474e975ffd1bf952690f2a', 7, 2, NULL, '[]', 0, '2019-12-12 05:24:18', '2019-12-12 05:24:18', '2020-12-12 10:54:18'),
('67005670ca3c87c4826bfe9a6dd26e0907dcdc701fd1443222e49172482902c7e784547c0acee3d5', 7, 2, NULL, '[]', 0, '2019-12-14 01:31:48', '2019-12-14 01:31:48', '2020-12-14 07:01:48'),
('69993d8e8d425b42f6e7eafc14b5d833eee7b7cc2e70b9272ff7c03f2f2d82ffd4d96bdc3c314778', 7, 2, NULL, '[]', 0, '2019-12-13 05:43:20', '2019-12-13 05:43:20', '2020-12-13 11:13:20'),
('6a44e82f07f8de2925fea368255a38a43739649efa73f52aefe0efb6a2196be8bc0c043d28dee26e', 7, 2, NULL, '[]', 0, '2019-12-16 06:52:36', '2019-12-16 06:52:36', '2020-12-16 12:22:36'),
('6a5fba9656e693b49e7646240d9d1304f23702a679380bf40961a557e9363388e20e208645177282', 1, 2, NULL, '[]', 0, '2019-12-09 04:39:09', '2019-12-09 04:39:09', '2020-12-09 10:09:09'),
('6b33d12b1ba3b5d8d394c646c3190c366efb785a8f61ba02ba2240017a55acc19c4699a8ba108137', 7, 2, NULL, '[]', 0, '2019-12-14 04:37:10', '2019-12-14 04:37:10', '2020-12-14 10:07:10'),
('6bd39a8694d155f70a850145b4ac005262808f699eab4bef1174bae4362ef9d167ed78046271c65c', 7, 2, NULL, '[]', 0, '2019-12-12 03:57:38', '2019-12-12 03:57:38', '2020-12-12 09:27:38'),
('6ca64c92a6e322701b1cb8e7469b0ab0b7cb6681f33f2bd3026c3065ee3ef37b534bc2ffedef58a0', 7, 2, NULL, '[]', 0, '2019-12-12 01:35:24', '2019-12-12 01:35:24', '2020-12-12 07:05:24'),
('6e1224574fe3bd31b5666896708fd28c8b4383c7e866cb9e524c2882e5bd28551d821629199f551e', 7, 2, NULL, '[]', 0, '2019-12-12 03:56:46', '2019-12-12 03:56:46', '2020-12-12 09:26:46'),
('6e16862ceaa8a625fa97245fe90aa1c4c2df1c6a3c0d6ff9aaf35d01b0c1fd86fde274f262b28423', 7, 2, NULL, '[]', 0, '2019-12-14 05:06:48', '2019-12-14 05:06:48', '2020-12-14 10:36:48'),
('720027f67e24c6ad3d54a8d5f56deb6c2c5e0ded2c1537c0454885c0851e94528d134b60dab9c6ba', 7, 2, NULL, '[]', 0, '2019-12-16 07:11:38', '2019-12-16 07:11:38', '2020-12-16 12:41:38'),
('7358a1c4b875d18ef60a0bd259877b30c95274b1ec5d090be4ebdb6cfe9864e97ddfced93d07dc38', 7, 2, NULL, '[]', 0, '2019-12-12 00:55:04', '2019-12-12 00:55:04', '2020-12-12 06:25:04'),
('74622bbfffc0d81c66c82b99fbc58c62098e1208f92c0617a02f848e718de75f8776ddf4f9d1a6fd', 7, 2, NULL, '[]', 0, '2019-12-14 04:51:45', '2019-12-14 04:51:45', '2020-12-14 10:21:45'),
('75207d82a5fa57e06cebc72d99cd1ea0d9497313d718bc59afe084fed60207f950ca1c32f707f709', 7, 2, NULL, '[]', 0, '2019-12-16 04:40:19', '2019-12-16 04:40:19', '2020-12-16 10:10:19'),
('75d5c3441481f01f90b0b46174a9360ca32fe66510def356192ce110dbf29161715ed60498442de2', 7, 2, NULL, '[]', 0, '2019-12-11 06:38:41', '2019-12-11 06:38:41', '2020-12-11 12:08:41'),
('7812eab39dbbb2d61cd41acd5f175720d58aa50784651b1e3bd2509ea454faa73b60f142c1a883a3', 7, 2, NULL, '[]', 0, '2019-12-12 04:48:48', '2019-12-12 04:48:48', '2020-12-12 10:18:48'),
('7867725a836f0e387a75a742ff63756dcfcf7f4eaf7adb39df61b3a72ccaf9a139538294919f20da', 7, 2, NULL, '[]', 0, '2019-12-16 04:22:29', '2019-12-16 04:22:29', '2020-12-16 09:52:29'),
('7a707755becc4f20eeb3fc5da0d9ee628689d189440972dd211f02aed89bce8f19ed6fdd095b995d', 7, 2, NULL, '[]', 0, '2019-12-14 01:22:07', '2019-12-14 01:22:07', '2020-12-14 06:52:07'),
('7aa0bb7a5a2fcf3cc09ff5e82cc65feeb5204b66b2af79da71fd046a23d7e34554b98bb7fdd5a380', 7, 2, NULL, '[]', 0, '2019-12-16 06:01:01', '2019-12-16 06:01:01', '2020-12-16 11:31:01'),
('7ba59cddd0d155bd3be851c068597f341d75b6c716aae37ed2a3607f2ed07d431b06f6000fd5d736', 7, 2, NULL, '[]', 0, '2019-12-16 01:25:05', '2019-12-16 01:25:05', '2020-12-16 06:55:05'),
('7c2da41720da91ccf7069bf7888d090c41d1f27d7c04db3244b932668f1e3bc77d8f6a17fdd833ff', 7, 2, NULL, '[]', 0, '2019-12-12 23:29:10', '2019-12-12 23:29:10', '2020-12-13 04:59:10'),
('7ed577f4e37c7f544fa8255e768973c08f78cf3302d7de221ab337d7760327620c31fb7daf6b82b1', 7, 2, NULL, '[]', 0, '2019-12-14 05:13:48', '2019-12-14 05:13:48', '2020-12-14 10:43:48'),
('81e695e4c74f843499278f89879162b59f01feda9c578eced4f1b9e787084206b6441a5b5512bc27', 7, 2, NULL, '[]', 0, '2019-12-12 00:34:22', '2019-12-12 00:34:22', '2020-12-12 06:04:22'),
('82a29873c624dda51f22e0c5eb49afecfbf44f5e03bf624f21994ec7b62787812972a36d2cbf0afc', 7, 2, NULL, '[]', 0, '2019-12-12 04:01:50', '2019-12-12 04:01:50', '2020-12-12 09:31:50'),
('84d01b7932bb9a0965e2d45395f3eb0a2e9fea161748ab98a0e3d0472c1f2ac993c37a2deaa8c899', 7, 2, NULL, '[]', 0, '2019-12-12 01:59:54', '2019-12-12 01:59:54', '2020-12-12 07:29:54'),
('85bf7e2de8e2ec2a974fdbca3a9fdd0e68c5d052ab2a0e1490e001242283a61c2605f4825b07e15d', 7, 2, NULL, '[]', 0, '2019-12-16 02:00:42', '2019-12-16 02:00:42', '2020-12-16 07:30:42'),
('8d581ba7eda66e73c646d0e803f2b80f9304e992c34a93e13afd1f381cce7a7cfb4a45512fd1ea31', 7, 2, NULL, '[]', 0, '2019-12-12 02:11:33', '2019-12-12 02:11:33', '2020-12-12 07:41:33'),
('904062a5afb7143f7551e74b5a30f5bc9c51c41458e2563aa92ddf2daba441899d159b87e23bd5e0', 7, 2, NULL, '[]', 0, '2019-12-14 04:53:32', '2019-12-14 04:53:32', '2020-12-14 10:23:32'),
('981c53477981eaf5bc81eada2e513604068b51ebd7c052323a51f799d12e97110e4fd83343a12de5', 7, 2, NULL, '[]', 0, '2019-12-14 01:56:20', '2019-12-14 01:56:20', '2020-12-14 07:26:20'),
('99f4c9e0226277a25235bf911e58b04a3983ebe2ee2747b6103d836ba1a4b1d5525a2938b18f42e7', 7, 2, NULL, '[]', 0, '2019-12-16 03:43:57', '2019-12-16 03:43:57', '2020-12-16 09:13:57'),
('a07869cff00597cbbd7e44c8a3808b615a75ed38d2fa83f7e14a13d55929ca695377dcc84eaeb19b', 7, 2, NULL, '[]', 0, '2019-12-13 05:57:35', '2019-12-13 05:57:35', '2020-12-13 11:27:35'),
('a3050bfe700261cba01c53ce278f9201fda8396ab9c34ecf3c0a644ede519d6439d317b6ac5920f7', 7, 2, NULL, '[]', 0, '2019-12-14 01:49:26', '2019-12-14 01:49:26', '2020-12-14 07:19:26'),
('a42622de9a37bbec812a2dfb9070ecd36dc3191f703e1f3ed00ddf6128ec91185e63dc5ac270fe82', 7, 2, NULL, '[]', 0, '2019-12-16 07:04:20', '2019-12-16 07:04:20', '2020-12-16 12:34:20'),
('a788ac13d46a2ffc7debd80fe88ef8cef6039187cebcaddd5c5c05d14af1165e53449b97ba836652', 7, 2, NULL, '[]', 0, '2019-12-14 04:34:15', '2019-12-14 04:34:15', '2020-12-14 10:04:15'),
('a8e39bdf3150bc2a7856f3d97211cbf4a206ac8dc08475184e8fac8870a3dbda4e1cbf40ef6c8d33', 7, 2, NULL, '[]', 0, '2019-12-16 23:39:28', '2019-12-16 23:39:28', '2020-12-17 05:09:28'),
('af3b8e1a724f631bc41a5ef20dec93110ce2ef25364ea35060988bc03e7e70ea3e5dc5fa9833a797', 7, 2, NULL, '[]', 0, '2019-12-14 05:18:38', '2019-12-14 05:18:38', '2020-12-14 10:48:38'),
('b142cda690a7135d24674dc194482be3ca9e0d7b5eb419bbeb30b68f47ea50cd25124e8c660e9792', 7, 2, NULL, '[]', 0, '2019-12-13 05:58:12', '2019-12-13 05:58:12', '2020-12-13 11:28:12'),
('b215e91501fbeef405645af04978b8f8e0f05b46d21c1d915cefe6ffeaeb695c708cf0a6a8310838', 7, 2, NULL, '[]', 0, '2019-12-12 01:28:32', '2019-12-12 01:28:32', '2020-12-12 06:58:32'),
('b2396e8fb3f91d12914c653bd1dfdf54055af669f1a00044f7e504388a328acfc16a9b94bb48bdf6', 7, 2, NULL, '[]', 0, '2019-12-14 01:19:46', '2019-12-14 01:19:46', '2020-12-14 06:49:46'),
('b75b9cfc2bccd7be5edb3ede3205bfae72c4f2c73807ae1332e83f57882696ae8699cc6c9591309f', 7, 2, NULL, '[]', 0, '2019-12-14 04:44:28', '2019-12-14 04:44:28', '2020-12-14 10:14:28'),
('bc0df1e0b9c75c5a974e56379d0c7279e70f7d8598dd2496ba24da0e933a3791105e8f724f20d93f', 7, 2, NULL, '[]', 0, '2019-12-15 23:22:58', '2019-12-15 23:22:58', '2020-12-16 04:52:58'),
('be01b54803bef3813d7df1efdae03cd005bdf5e98026c81ed5e6e0bbdb1cd97c39c49fb382ae4a37', 6, 2, NULL, '[]', 0, '2019-12-11 06:35:09', '2019-12-11 06:35:09', '2020-12-11 12:05:09'),
('bf6b524499d48a21d3b6a2501f21f18399e79acbaa4462edfcbf27af42916ec95a62ce6c408c5c9b', 7, 2, NULL, '[]', 0, '2019-12-14 04:21:34', '2019-12-14 04:21:34', '2020-12-14 09:51:34'),
('c176b5501a0925f169d02274b1eb7d9b69c05516024aa8961ef56034b356176e990b5fdd4f04744c', 7, 2, NULL, '[]', 0, '2019-12-12 04:22:18', '2019-12-12 04:22:18', '2020-12-12 09:52:18'),
('c230f96a6f9c7f595d683301a1cb7eb838554531946c2724aba5eddaf3075162181e0a25a498b734', 7, 2, NULL, '[]', 0, '2019-12-12 06:06:21', '2019-12-12 06:06:21', '2020-12-12 11:36:21'),
('c267d02e7f9e67f603c18f5e0ba1966678127c525618a8285e8b40a27a37077d9b155f541106aea7', 7, 2, NULL, '[]', 0, '2019-12-16 01:18:31', '2019-12-16 01:18:31', '2020-12-16 06:48:31'),
('c292cf0c039d024738b7478502928a496d7e3655da73065e7de29d77197d8b987627296be2a919be', 7, 2, NULL, '[]', 0, '2019-12-12 00:53:54', '2019-12-12 00:53:54', '2020-12-12 06:23:54'),
('c6595c20dfad1c41179a507e1d71f750e0af48a3298d5183f45c75aadaf43eaa944962ff3e727a41', 7, 2, NULL, '[]', 0, '2019-12-14 04:46:00', '2019-12-14 04:46:00', '2020-12-14 10:16:00'),
('c9a0818e2a34caabf256c0a2d84eed7771da9b53b105e37d5564d6b7ddb22a7a6be1c0a3f5a30517', 3, 2, NULL, '[]', 0, '2019-12-12 02:25:48', '2019-12-12 02:25:48', '2020-12-12 07:55:48'),
('c9c8ab6d8197a5d3aa7d7a231098afd84badec04b9efe46605f07df84d9a6961b23aef30ea109fcf', 7, 2, NULL, '[]', 0, '2019-12-16 06:59:31', '2019-12-16 06:59:31', '2020-12-16 12:29:31'),
('cb4af0b333160134f934e4572c529f65117e77c47a51ba533293437893dea6713a0fd98e9fb3a56c', 7, 2, NULL, '[]', 0, '2019-12-13 05:55:40', '2019-12-13 05:55:40', '2020-12-13 11:25:40'),
('d0e2277daf482f2990539fd5893bd373b43d385eb32e3a92555c342ac275149594bf1699f5f35cd1', 7, 2, NULL, '[]', 0, '2019-12-16 23:20:24', '2019-12-16 23:20:24', '2020-12-17 04:50:24'),
('d88d27a36c960f948d73ff57aeaec0de0a32e1f4cfec8e68aaf6399ef60cba294fa0d0c335a4a550', 7, 2, NULL, '[]', 0, '2019-12-12 06:11:59', '2019-12-12 06:11:59', '2020-12-12 11:41:59'),
('d9a398ebd5977bb6810dad70bc3901d171a0aa496daf7073d64c2f53d953edebb1a973537ca34fe4', 7, 2, NULL, '[]', 0, '2019-12-17 00:44:26', '2019-12-17 00:44:26', '2020-12-17 06:14:26'),
('da073596c689102518d8a699b71417fb94acf96808c47cef823a67ed3a5dfacc0732714836638109', 7, 2, NULL, '[]', 0, '2019-12-14 01:57:07', '2019-12-14 01:57:07', '2020-12-14 07:27:07'),
('dbc1ba25911946b36a16f66f179908d5a755849b641b284e4f3c6ae845c0bd6a0a004ecb55de92b1', 7, 2, NULL, '[]', 0, '2019-12-14 05:14:26', '2019-12-14 05:14:26', '2020-12-14 10:44:26'),
('dd2e2e02d70af559f87c18dbc166d8ccb1598946518f40ff1c234e01fc2824e530c18256afe61c23', 7, 2, NULL, '[]', 0, '2019-12-16 04:50:31', '2019-12-16 04:50:31', '2020-12-16 10:20:31'),
('de7f39dc67bb091ed26cb6cc5a87c7f43ffdc90e541c2534d2fbd0ab5d4f062093be70506dc4110b', 7, 2, NULL, '[]', 0, '2019-12-12 03:59:17', '2019-12-12 03:59:17', '2020-12-12 09:29:17'),
('df457950fc6d666738c08144fdc60b5886d36cb7983f9e0df5ae020e432b611ef47759a041748b25', 7, 2, NULL, '[]', 0, '2019-12-15 23:45:02', '2019-12-15 23:45:02', '2020-12-16 05:15:02'),
('e1957e5d7355e4d849caa5f290d38512fbd0cd51953334dc6b7dbb15cea1785e1b976483539ea796', 3, 2, NULL, '[]', 0, '2019-12-16 05:07:50', '2019-12-16 05:07:50', '2020-12-16 10:37:50'),
('e2e0cd65e86202fde88adb63c43ab8ace60e5d248628986ab045a0bb3ea0558285f0d1173902ea34', 7, 2, NULL, '[]', 0, '2019-12-16 04:17:48', '2019-12-16 04:17:48', '2020-12-16 09:47:48'),
('e48887607a1879ebc193f982f670e5114801b32b33fbc4dcd875cc7dfb934d5e9b7caf823b88da1e', 7, 2, NULL, '[]', 0, '2019-12-14 01:37:15', '2019-12-14 01:37:15', '2020-12-14 07:07:15'),
('e61d66740e72dfd87d08827474fd3ce1033051014aacf8dac701d2d539be037d979167d3fc7fc5db', 7, 2, NULL, '[]', 0, '2019-12-16 07:26:42', '2019-12-16 07:26:42', '2020-12-16 12:56:42'),
('eb4a87ac164afdf9a5b3e07b838a3514ca182ce60dc7a47b584cea96d062fde136ec636996ef8df7', 7, 2, NULL, '[]', 0, '2019-12-12 01:36:53', '2019-12-12 01:36:53', '2020-12-12 07:06:53'),
('ef6f5f5a4da54ecbffc51fc63ccf838885e71007f2ba02dbed6ecb6af4142e71d27c73ca4e03e26a', 7, 2, NULL, '[]', 0, '2019-12-16 01:58:56', '2019-12-16 01:58:56', '2020-12-16 07:28:56'),
('f15ef9480ad6c988c3b4f015511f2a7cf22f9457c5d7eb18610b02c6011444672456da4da25ed21a', 7, 2, NULL, '[]', 0, '2019-12-16 06:59:57', '2019-12-16 06:59:57', '2020-12-16 12:29:57'),
('f4d5ee4a16a8af99e1240e8cf076a5b95435d9075151eca03196e35dade898ba8a8deaff5e6c4926', 7, 2, NULL, '[]', 0, '2019-12-19 23:29:43', '2019-12-19 23:29:43', '2020-12-20 04:59:43'),
('f629039f59ca17c387df93e07d18f2c311acb131573a1db41691ddcddd6d0c82cf3375796d9fa1ca', 7, 2, NULL, '[]', 0, '2019-12-14 00:49:25', '2019-12-14 00:49:25', '2020-12-14 06:19:25'),
('f76311af0db83296c86607e82eb418549fca9c292ac1e13f7a14a25c28c46fdb9787102a021d396d', 7, 2, NULL, '[]', 0, '2019-12-12 02:36:05', '2019-12-12 02:36:05', '2020-12-12 08:06:05'),
('fc251626eabb4dd31ce3597ef7fb5df2c75221dddf904324f7f90f048796ff70c752f882faa9b892', 7, 2, NULL, '[]', 0, '2019-12-16 04:51:00', '2019-12-16 04:51:00', '2020-12-16 10:21:00'),
('fd5bb9676286816afb868b07a4d4b5b425a4d2899e20482571c3125d44f30e6bc1615313992e0bf7', 7, 2, NULL, '[]', 0, '2019-12-12 03:52:42', '2019-12-12 03:52:42', '2020-12-12 09:22:42'),
('fec2ace5c37ea4116f8ef3531533af78dcc4ef9bf9de265429841dd753fd79dcb231e1cfddacecc7', 7, 2, NULL, '[]', 0, '2019-12-16 01:13:55', '2019-12-16 01:13:55', '2020-12-16 06:43:55'),
('ff8f3dfa3e7936028040107662282d0c6d9ca7c27c11975bb56981c2320e62089f99a112d9c2f04c', 7, 2, NULL, '[]', 0, '2019-12-12 01:03:20', '2019-12-12 01:03:20', '2020-12-12 06:33:20');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
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

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Nexthour Personal Access Client', 'Z9kvpHyT5nzRQrGKvLoKxXces8bxDzexeqZVP5sA', 'http://localhost', 1, 0, 0, '2019-12-09 04:29:26', '2019-12-09 04:29:26'),
(2, NULL, 'Nexthour Password Grant Client', 'C2VrZuB5yr78fKGJcbPMtS4k6U1DAWePGhNu4Uq8', 'http://localhost', 0, 1, 0, '2019-12-09 04:29:27', '2019-12-09 04:29:27');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-12-09 04:29:27', '2019-12-09 04:29:27');

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
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) UNSIGNED NOT NULL,
  `plan_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_symbol` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `interval` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `interval_count` int(11) DEFAULT NULL,
  `trial_period_days` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `screens` int(11) UNSIGNED DEFAULT '1',
  `delete_status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_menu`
--

CREATE TABLE `package_menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(11) NOT NULL,
  `package_id` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paypal_subscriptions`
--

CREATE TABLE `paypal_subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `payment_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `price` double(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscription_from` timestamp NULL DEFAULT NULL,
  `subscription_to` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `player_settings`
--

CREATE TABLE `player_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_enable` tinyint(1) DEFAULT NULL,
  `cpy_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `share_opt` tinyint(1) DEFAULT NULL,
  `auto_play` tinyint(1) DEFAULT NULL,
  `speed` tinyint(1) DEFAULT NULL,
  `thumbnail` tinyint(1) DEFAULT NULL,
  `info_window` tinyint(1) DEFAULT NULL,
  `skin` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loop_video` tinyint(1) DEFAULT NULL,
  `is_resume` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `player_settings`
--

INSERT INTO `player_settings` (`id`, `logo`, `logo_enable`, `cpy_text`, `share_opt`, `auto_play`, `speed`, `thumbnail`, `info_window`, `skin`, `loop_video`, `is_resume`, `created_at`, `updated_at`) VALUES
(1, 'logo.png', NULL, '2018 Nexthour', 1, NULL, NULL, NULL, 1, 'classic_skin_dark', NULL, 1, NULL, '2019-12-04 07:03:58');

-- --------------------------------------------------------

--
-- Table structure for table `popover_translations`
--

CREATE TABLE `popover_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `popover_translations`
--

INSERT INTO `popover_translations` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'mins', '{\"en\":\"Mins\",\"nl\":\"mins2\",\"de\":\"Minuten\"}', NULL, '2018-04-24 03:38:42'),
(2, 'season', '{\"en\":\"Season\",\"nl\":\"season2\",\"de\":\"Jahreszeit\"}', NULL, '2018-04-24 03:38:42'),
(3, 'all age', '{\"en\":\"All age\",\"nl\":\"all age2\",\"de\":\"jedes Alter\"}', NULL, '2018-04-24 03:38:42'),
(4, 'read more', '{\"en\":\"Read more\",\"nl\":\"Read more2\",\"de\":\"Weiterlesen\"}', NULL, '2018-04-24 03:38:04'),
(5, 'less', '{\"en\":\"Less\",\"nl\":\"Less2\",\"de\":\"Weniger\"}', NULL, '2018-04-24 03:38:04'),
(6, 'play', '{\"en\":\"Play Now\",\"nl\":\"play2\",\"de\":\"abspielen\"}', NULL, '2018-04-24 03:38:42'),
(7, 'watch trailer', '{\"en\":\"Watch trailer\",\"nl\":\"watch trailer2\",\"de\":\"Trailer ansehen\"}', NULL, '2018-04-24 03:38:42'),
(8, 'add to watchlist', '{\"en\":\"Add to watchlist\",\"nl\":\"add to watchlist2\",\"de\":\"Auf die Beobachtungsliste\"}', NULL, '2018-04-24 03:38:42'),
(9, 'remove from watchlist', '{\"en\":\"Remove  from watchlist\",\"nl\":\"remove  from watchlist2\",\"de\":\"aus der Beobachtungsliste entfernen\"}', NULL, '2018-04-24 03:38:42'),
(10, 'subtitles', '{\"en\":\"Subtitles\",\"nl\":\"subtitles2\",\"de\":\"Untertitel\"}', NULL, '2018-04-24 03:38:42'),
(11, 'Download', '{\"en\":\"Download\"}', NULL, '2019-10-23 04:40:27');

-- --------------------------------------------------------

--
-- Table structure for table `pricing_texts`
--

CREATE TABLE `pricing_texts` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `title1` mediumtext,
  `title2` mediumtext,
  `title3` mediumtext,
  `title4` mediumtext,
  `title5` mediumtext,
  `title6` mediumtext,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seasons`
--

CREATE TABLE `seasons` (
  `id` int(10) UNSIGNED NOT NULL,
  `tv_series_id` int(10) UNSIGNED NOT NULL,
  `tmdb_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `season_no` bigint(20) NOT NULL,
  `tmdb` char(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publish_year` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poster` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actor_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `a_language` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` tinyint(1) DEFAULT NULL,
  `subtitle_list` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `type` char(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'S',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seos`
--

CREATE TABLE `seos` (
  `id` int(10) UNSIGNED NOT NULL,
  `author` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb` text COLLATE utf8mb4_unicode_ci,
  `google` text COLLATE utf8mb4_unicode_ci,
  `metadata` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seos`
--

INSERT INTO `seos` (`id`, `author`, `fb`, `google`, `metadata`, `description`, `keyword`, `created_at`, `updated_at`) VALUES
(1, '{\"en\":\"Mediacity\"}', 'sdf', 'sdfg', '{\"en\":\"this ts a next hour\"}', '', '', NULL, '2019-04-29 08:04:31');

-- --------------------------------------------------------

--
-- Table structure for table `social_icons`
--

CREATE TABLE `social_icons` (
  `id` int(11) NOT NULL,
  `url1` varchar(191) DEFAULT NULL,
  `url2` varchar(191) DEFAULT NULL,
  `url3` varchar(191) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `social_icons`
--

INSERT INTO `social_icons` (`id`, `url1`, `url2`, `url3`, `created_at`, `updated_at`) VALUES
(1, 'http://facebook.com', 'http://twitter.com', 'http://youtube.com', '2019-03-29 05:22:39', '2019-03-28 23:52:39');

-- --------------------------------------------------------

--
-- Table structure for table `subcomments`
--

CREATE TABLE `subcomments` (
  `id` int(13) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `reply` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `subscription_from` timestamp NULL DEFAULT NULL,
  `subscription_to` timestamp NULL DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subtitles`
--

CREATE TABLE `subtitles` (
  `id` int(11) UNSIGNED NOT NULL,
  `sub_lang` varchar(100) DEFAULT NULL,
  `sub_t` varchar(191) DEFAULT NULL,
  `m_t_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tv_series`
--

CREATE TABLE `tv_series` (
  `id` int(10) UNSIGNED NOT NULL,
  `keyword` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmdb_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmdb` char(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fetch_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poster` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `genre_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci,
  `rating` double(8,2) DEFAULT NULL,
  `episode_runtime` double(8,2) DEFAULT NULL,
  `maturity_rating` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `type` char(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'T',
  `status` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `created_by` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verifyToken` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(11) NOT NULL DEFAULT '0',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gitlab_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `age` int(11) DEFAULT '0',
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `braintree_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_assistant` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_blocked` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `image`, `email`, `verifyToken`, `status`, `password`, `google_id`, `facebook_id`, `gitlab_id`, `dob`, `age`, `mobile`, `braintree_id`, `code`, `stripe_id`, `card_brand`, `card_last_four`, `trial_ends_at`, `is_admin`, `is_assistant`, `remember_token`, `is_blocked`, `created_at`, `updated_at`) VALUES
(1, 'Mediacity', NULL, 'admin@mediacity.co.in', 'yxfQQLE3nIsxcpS1iWOxp2LNlmqAgb1VEH3mLdSi', 0, '$2y$10$OoDjADPbFSxIdD/BA8vBg.S.JGEJOKthUDHvmYgdE4jNoeu5Mzeoy', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, 0, '2020-02-01 11:58:46', '2020-02-01 11:58:46');

-- --------------------------------------------------------

--
-- Table structure for table `user_ratings`
--

CREATE TABLE `user_ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tv_id` int(11) DEFAULT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `rating` double DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `videolinks`
--

CREATE TABLE `videolinks` (
  `id` int(10) UNSIGNED NOT NULL,
  `movie_id` int(10) UNSIGNED DEFAULT NULL,
  `episode_id` int(10) UNSIGNED DEFAULT NULL,
  `upload_video` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iframeurl` longtext COLLATE utf8mb4_unicode_ci,
  `ready_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_360` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_480` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_720` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_1080` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` int(10) UNSIGNED NOT NULL,
  `viewable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `viewable_id` bigint(20) UNSIGNED NOT NULL,
  `visitor` text COLLATE utf8mb4_unicode_ci,
  `collection` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `viewed_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `watch_histories`
--

CREATE TABLE `watch_histories` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `tv_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `season_id` int(11) DEFAULT NULL,
  `added` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adsenses`
--
ALTER TABLE `adsenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audio_languages`
--
ALTER TABLE `audio_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_customizes`
--
ALTER TABLE `auth_customizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buttons`
--
ALTER TABLE `buttons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_codes`
--
ALTER TABLE `coupon_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_cp_callback_addresses`
--
ALTER TABLE `cp_cp_callback_addresses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cp_callback_addresses_address_currency_unique` (`address`,`currency`);

--
-- Indexes for table `cp_cp_conversions`
--
ALTER TABLE `cp_cp_conversions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cp_conversions_ref_id_unique` (`ref_id`),
  ADD KEY `cp_conversions_from_index` (`from`),
  ADD KEY `cp_conversions_to_index` (`to`);

--
-- Indexes for table `cp_cp_deposits`
--
ALTER TABLE `cp_cp_deposits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cp_deposits_txn_id_unique` (`txn_id`),
  ADD KEY `cp_deposits_address_index` (`address`);

--
-- Indexes for table `cp_cp_ipns`
--
ALTER TABLE `cp_cp_ipns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cp_ipns_ipn_id_unique` (`ipn_id`),
  ADD KEY `cp_ipns_address_index` (`address`);

--
-- Indexes for table `cp_cp_log`
--
ALTER TABLE `cp_cp_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_cp_mass_withdrawals`
--
ALTER TABLE `cp_cp_mass_withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_cp_transactions`
--
ALTER TABLE `cp_cp_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cp_transactions_txn_id_unique` (`txn_id`);

--
-- Indexes for table `cp_cp_transfers`
--
ALTER TABLE `cp_cp_transfers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cp_transfers_ref_id_unique` (`ref_id`),
  ADD KEY `cp_transfers_status_index` (`status`);

--
-- Indexes for table `cp_cp_withdrawals`
--
ALTER TABLE `cp_cp_withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cp_withdrawals_ref_id_unique` (`ref_id`),
  ADD UNIQUE KEY `cp_withdrawals_txn_id_unique` (`txn_id`),
  ADD KEY `cp_withdrawals_mass_withdrawal_id_index` (`mass_withdrawal_id`);

--
-- Indexes for table `directors`
--
ALTER TABLE `directors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donater_lists`
--
ALTER TABLE `donater_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `episodes`
--
ALTER TABLE `episodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `episodes_seasons_id_foreign` (`seasons_id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer_translations`
--
ALTER TABLE `footer_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_slider_updates`
--
ALTER TABLE `front_slider_updates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `header_translations`
--
ALTER TABLE `header_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_sliders`
--
ALTER TABLE `home_sliders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `home_sliders_movie_id_foreign` (`movie_id`),
  ADD KEY `home_sliders_tv_series_id_foreign` (`tv_series_id`);

--
-- Indexes for table `home_translations`
--
ALTER TABLE `home_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `landing_pages`
--
ALTER TABLE `landing_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_videos`
--
ALTER TABLE `menu_videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_videos_menu_id_foreign` (`menu_id`),
  ADD KEY `menu_videos_movie_id_foreign` (`movie_id`),
  ADD KEY `menu_videos_tv_series_id_foreign` (`tv_series_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie_comments`
--
ALTER TABLE `movie_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie_series`
--
ALTER TABLE `movie_series`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_series_movie_id_foreign` (`movie_id`);

--
-- Indexes for table `movie_subcomments`
--
ALTER TABLE `movie_subcomments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `multiplescreens`
--
ALTER TABLE `multiplescreens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_id_notifiable_type_index` (`notifiable_id`(191),`notifiable_type`);

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
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_menu`
--
ALTER TABLE `package_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `paypal_subscriptions`
--
ALTER TABLE `paypal_subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plans_email_unique` (`email`);

--
-- Indexes for table `player_settings`
--
ALTER TABLE `player_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `popover_translations`
--
ALTER TABLE `popover_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pricing_texts`
--
ALTER TABLE `pricing_texts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `seasons`
--
ALTER TABLE `seasons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seasons_tv_series_id_foreign` (`tv_series_id`);

--
-- Indexes for table `seos`
--
ALTER TABLE `seos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_icons`
--
ALTER TABLE `social_icons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcomments`
--
ALTER TABLE `subcomments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subtitles`
--
ALTER TABLE `subtitles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tv_series`
--
ALTER TABLE `tv_series`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `google_id` (`google_id`),
  ADD UNIQUE KEY `facebook_id` (`facebook_id`),
  ADD UNIQUE KEY `gitlab_id` (`gitlab_id`),
  ADD UNIQUE KEY `code` (`code`) USING BTREE;

--
-- Indexes for table `user_ratings`
--
ALTER TABLE `user_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videolinks`
--
ALTER TABLE `videolinks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videolinks_movie_id_foreign` (`movie_id`),
  ADD KEY `videolinks_episode_id_foreign` (`episode_id`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `views_viewable_type_viewable_id_index` (`viewable_type`,`viewable_id`);

--
-- Indexes for table `watch_histories`
--
ALTER TABLE `watch_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actors`
--
ALTER TABLE `actors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adsenses`
--
ALTER TABLE `adsenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audio_languages`
--
ALTER TABLE `audio_languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_customizes`
--
ALTER TABLE `auth_customizes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(13) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buttons`
--
ALTER TABLE `buttons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(13) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `configs`
--
ALTER TABLE `configs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon_codes`
--
ALTER TABLE `coupon_codes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cp_cp_callback_addresses`
--
ALTER TABLE `cp_cp_callback_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cp_cp_conversions`
--
ALTER TABLE `cp_cp_conversions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cp_cp_deposits`
--
ALTER TABLE `cp_cp_deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cp_cp_ipns`
--
ALTER TABLE `cp_cp_ipns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cp_cp_log`
--
ALTER TABLE `cp_cp_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cp_cp_mass_withdrawals`
--
ALTER TABLE `cp_cp_mass_withdrawals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cp_cp_transactions`
--
ALTER TABLE `cp_cp_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cp_cp_transfers`
--
ALTER TABLE `cp_cp_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cp_cp_withdrawals`
--
ALTER TABLE `cp_cp_withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `directors`
--
ALTER TABLE `directors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donater_lists`
--
ALTER TABLE `donater_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `episodes`
--
ALTER TABLE `episodes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footer_translations`
--
ALTER TABLE `footer_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `front_slider_updates`
--
ALTER TABLE `front_slider_updates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `header_translations`
--
ALTER TABLE `header_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `home_sliders`
--
ALTER TABLE `home_sliders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_translations`
--
ALTER TABLE `home_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `landing_pages`
--
ALTER TABLE `landing_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(13) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_videos`
--
ALTER TABLE `menu_videos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movie_comments`
--
ALTER TABLE `movie_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movie_series`
--
ALTER TABLE `movie_series`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movie_subcomments`
--
ALTER TABLE `movie_subcomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `multiplescreens`
--
ALTER TABLE `multiplescreens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package_menu`
--
ALTER TABLE `package_menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paypal_subscriptions`
--
ALTER TABLE `paypal_subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `player_settings`
--
ALTER TABLE `player_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `popover_translations`
--
ALTER TABLE `popover_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pricing_texts`
--
ALTER TABLE `pricing_texts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seasons`
--
ALTER TABLE `seasons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seos`
--
ALTER TABLE `seos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `social_icons`
--
ALTER TABLE `social_icons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subcomments`
--
ALTER TABLE `subcomments`
  MODIFY `id` int(13) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subtitles`
--
ALTER TABLE `subtitles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tv_series`
--
ALTER TABLE `tv_series`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_ratings`
--
ALTER TABLE `user_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `videolinks`
--
ALTER TABLE `videolinks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `watch_histories`
--
ALTER TABLE `watch_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cp_cp_deposits`
--
ALTER TABLE `cp_cp_deposits`
  ADD CONSTRAINT `cp_deposits_address_foreign` FOREIGN KEY (`address`) REFERENCES `cp_cp_callback_addresses` (`address`) ON UPDATE CASCADE;

--
-- Constraints for table `cp_cp_withdrawals`
--
ALTER TABLE `cp_cp_withdrawals`
  ADD CONSTRAINT `cp_withdrawals_mass_withdrawal_id_foreign` FOREIGN KEY (`mass_withdrawal_id`) REFERENCES `cp_cp_mass_withdrawals` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `episodes`
--
ALTER TABLE `episodes`
  ADD CONSTRAINT `episodes_seasons_id_foreign` FOREIGN KEY (`seasons_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `home_sliders`
--
ALTER TABLE `home_sliders`
  ADD CONSTRAINT `home_sliders_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `home_sliders_tv_series_id_foreign` FOREIGN KEY (`tv_series_id`) REFERENCES `tv_series` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
