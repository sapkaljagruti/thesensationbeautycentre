-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2017 at 03:54 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thesensationbeautycentre`
--
CREATE DATABASE IF NOT EXISTS `thesensationbeautycentre` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `thesensationbeautycentre`;

-- --------------------------------------------------------

--
-- Table structure for table `account_groups`
--

CREATE TABLE `account_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `opening_balance` double DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `gst_state_code_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile1` varchar(255) DEFAULT NULL,
  `mobile2` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_branch` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `bank_account_no` varchar(255) DEFAULT NULL,
  `pan` varchar(255) DEFAULT NULL,
  `gst_type_id` int(11) DEFAULT NULL,
  `gstin` varchar(255) DEFAULT NULL,
  `brand_ids` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_groups`
--

INSERT INTO `account_groups` (`id`, `parent_id`, `name`, `opening_balance`, `contact_person`, `area`, `city`, `pincode`, `gst_state_code_id`, `email`, `mobile1`, `mobile2`, `bank_name`, `bank_branch`, `ifsc_code`, `bank_account_no`, `pan`, `gst_type_id`, `gstin`, `brand_ids`, `is_default`, `is_deleted`, `created_at`, `updated_at`) VALUES
(26, 0, 'Non Revenue - Primary Groups', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-24 17:01:07', '2017-11-03 10:31:40'),
(27, 0, 'Capital Account', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-24 17:01:28', '2017-11-03 10:31:40'),
(28, 0, 'Current Assets', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-24 17:02:10', '2017-11-03 10:31:40'),
(29, 28, 'Bank Accounts', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-24 17:03:43', '2017-11-03 10:31:40'),
(30, 29, 'Current account', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-24 17:04:07', '2017-11-03 10:31:40'),
(31, 29, 'savings account', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-24 17:04:30', '2017-11-03 10:31:40'),
(32, 28, 'Cash-in hand', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-24 17:04:58', '2017-11-03 10:31:40'),
(33, 28, 'Deposits (Asset)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-24 17:05:14', '2017-11-03 10:31:40'),
(34, 28, 'Loans & Advances (Asset)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-25 12:24:47', '2017-11-03 10:31:40'),
(36, 28, 'Stock-in-hand', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-25 12:26:18', '2017-11-03 10:31:40'),
(38, 28, 'Integrated Accounts-cum-Invent', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-25 12:34:52', '2017-11-03 10:31:40'),
(39, 28, 'Non-integrated Accounts-cum-In', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:26:27', '2017-11-03 10:31:40'),
(40, 28, 'Sundry Debtors', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:27:07', '2017-11-03 10:31:40'),
(41, 0, 'Current Liabilities', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:27:44', '2017-11-03 10:31:40'),
(42, 41, 'Duties and Taxes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:28:02', '2017-11-03 10:31:40'),
(43, 41, 'Provisions', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:28:36', '2017-11-03 10:31:40'),
(44, 41, 'Sundry Creditors', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:29:03', '2017-11-03 10:31:40'),
(45, 0, 'Investments', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:29:16', '2017-11-03 10:31:40'),
(46, 0, 'Loans (Liability)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:30:04', '2017-11-03 10:31:40'),
(47, 46, 'Bank OD Accounts [Bank OCC Accounts]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:30:18', '2017-11-03 10:31:40'),
(48, 46, 'Bank OCC A/c', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:30:38', '2017-11-03 10:31:40'),
(49, 46, 'Secured Loans', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:31:15', '2017-11-03 10:31:40'),
(50, 46, 'Unsecured Loans', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:31:31', '2017-11-03 10:31:40'),
(51, 0, 'Suspense Account', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:32:23', '2017-11-03 10:31:40'),
(52, 51, 'Loans and Advances (Asset) Group', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:32:39', '2017-11-03 10:31:40'),
(53, 0, 'Miscellaneous Expenses (Asset)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:32:53', '2017-11-03 10:31:40'),
(55, 0, 'Branch/Divisions', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:33:24', '2017-11-03 10:31:40'),
(56, 0, 'Revenue - Primary Groups', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:33:38', '2017-11-03 10:31:40'),
(57, 0, 'Sales Account', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:34:10', '2017-11-03 10:31:40'),
(58, 0, 'Purchase Account', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:34:44', '2017-11-03 10:31:40'),
(59, 0, 'Direct Income [Income Direct]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:35:05', '2017-11-03 10:31:40'),
(60, 0, 'Indirect Income [Income Indirect]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:36:22', '2017-11-03 10:31:40'),
(61, 0, 'Direct Expenses [Expenses Direct]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:36:34', '2017-11-03 10:31:40'),
(62, 0, 'Indirect Expenses [Expenses Indirect]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:36:50', '2017-11-03 10:31:40'),
(63, 0, 'Common and Possible Errors in Grouping and Account Classification', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:37:04', '2017-11-03 10:31:40'),
(64, 0, 'Debtor/Creditor classification', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:37:16', '2017-11-03 10:31:40'),
(65, 0, 'Opening Two Accounts Of The Same Party', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2017-10-26 10:37:26', '2017-11-03 10:31:40'),
(66, 64, 'test', 0, '', '', '', '', 0, '', '', '', '', '', '', '', '', 3, '', NULL, 0, 0, '2017-11-15 13:41:35', '2017-11-15 13:41:35'),
(67, 40, 'salon party', 0, 'jagruti', '', '', '', 24, '', '', '', '', '', '', '', 'FKXPS6536R', 3, '24FKXPS6536R1Z5', '11,9', 0, 0, '2017-11-15 16:17:46', '2017-11-23 15:49:08'),
(68, 58, 'domestic purchase', 0, '', '', '', '', 0, '', '', '', '', '', '', '', '', 3, '', '', 0, 0, '2017-11-15 17:35:07', '2017-11-15 17:35:07'),
(69, 44, 'salon party1', 0, 'jagruti', '', '', '', 24, '', '', '', '', '', '', '', '', 3, '', '', 0, 0, '2017-11-18 10:50:28', '2017-11-23 17:24:22'),
(70, 57, 'domestic sales', 0, '', '', '', '', 0, '', '', '', '', '', '', '', '', 3, '', '', 0, 0, '2017-11-18 11:31:30', '2017-11-18 11:31:30'),
(71, 44, 'patel trading co', 0, '', '', '', '', 0, '', '', '', 'bank Of Baroda', 'tithal road valsad', 'BARB0TITHAL', '121212121', '', 3, '', '', 0, 0, '2017-12-05 14:27:55', '2017-12-07 12:10:03'),
(72, 40, 'beauty salon', 0, 'Mahi', '', '', '', 0, '', '', '', '', '', '', '', '', 3, '', '', 0, 0, '2017-12-08 14:27:54', '2017-12-08 14:27:54');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `current_login_ips` text COLLATE utf8_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `fname`, `lname`, `email`, `mobile`, `username`, `password`, `profile_picture`, `last_login_ip`, `last_login_at`, `current_login_ips`, `created_at`, `updated_at`) VALUES
(1, 'lakhan', 'sen', 'lakhan.vapi@gmail.com', 9727612000, 'lakhansen', '1f406e5ff9b178e9c506e363bf1716ad', NULL, NULL, NULL, NULL, '2017-09-11 11:33:02', '2017-10-24 11:17:29');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `address` text,
  `city` varchar(30) DEFAULT NULL,
  `state` varchar(30) DEFAULT NULL,
  `pincode` varchar(30) DEFAULT NULL,
  `phone_nums` text,
  `mobile_nums` text,
  `manager_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `is_deleted`, `created_at`, `updated_at`) VALUES
(9, 'sensation', 0, '2017-09-13 12:42:20', '2017-10-26 15:22:36'),
(11, 'lakme', 0, '2017-09-29 15:31:09', '2017-10-26 15:22:29'),
(12, 'test', 1, '2017-11-14 12:37:35', '2017-11-14 12:37:52'),
(13, 'test', 1, '2017-11-14 12:37:38', '2017-11-14 12:37:52'),
(14, 'test', 1, '2017-11-14 12:37:42', '2017-11-14 12:37:54'),
(15, 'test', 1, '2017-11-14 14:49:17', '2017-11-14 14:58:38'),
(16, 'test', 1, '2017-11-14 14:49:20', '2017-11-14 14:58:38'),
(17, 'test', 1, '2017-11-14 14:58:13', '2017-11-14 14:58:38'),
(18, 'test', 1, '2017-11-14 14:58:53', '2017-11-14 15:00:37'),
(19, 'test2', 1, '2017-11-14 14:59:16', '2017-11-14 15:00:37');

-- --------------------------------------------------------

--
-- Table structure for table `contra_vouchers`
--

CREATE TABLE `contra_vouchers` (
  `id` int(11) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `entry_data` longtext,
  `total_amount` double DEFAULT NULL,
  `narration` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contra_vouchers`
--

INSERT INTO `contra_vouchers` (`id`, `date`, `entry_data`, `total_amount`, `narration`, `created_at`, `updated_at`) VALUES
(1, '2017-11-03', 'cr_4_500,dr_3_500', 500, '', '2017-11-03 15:41:33', '2017-11-03 15:41:33'),
(2, '2017-11-06', 'cr_4_500,dr_3_200,dr_2_300', 500, '', '2017-11-06 11:54:48', '2017-11-06 11:54:48');

-- --------------------------------------------------------

--
-- Table structure for table `credit_notes`
--

CREATE TABLE `credit_notes` (
  `id` int(11) UNSIGNED NOT NULL,
  `credit_note_no` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `party_id` int(11) DEFAULT NULL,
  `sales_invoice_data` longtext,
  `narration` longtext,
  `total_amount` double DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `credit_notes`
--

INSERT INTO `credit_notes` (`id`, `credit_note_no`, `date`, `party_id`, `sales_invoice_data`, `narration`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, '123', '2017-11-02', 16, '1_600', '', 600, '2017-11-02 12:13:19', '2017-11-02 12:13:19');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `mobile1` varchar(255) DEFAULT NULL,
  `mobile2` varchar(255) DEFAULT NULL,
  `residence_no` varchar(255) DEFAULT NULL,
  `office_no` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `doa` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upadted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `gender`, `area`, `city`, `pincode`, `mobile1`, `mobile2`, `residence_no`, `office_no`, `dob`, `doa`, `email`, `is_deleted`, `created_at`, `upadted_at`) VALUES
(16, 'jagruti', 'female', 'surat', '', '394510', '9327434007', '', '', '', '1992-06-22', '', '', 1, '2017-10-24 16:01:03', '2017-12-05 14:07:20'),
(17, 'test', 'male', '', '', '', '', '', '', '', '', '', '', 1, '2017-11-14 12:34:02', '2017-11-14 12:34:12'),
(18, 'test', 'male', '', '', '', '', '', '', '', '', '', '', 1, '2017-11-14 12:34:07', '2017-11-14 12:34:12'),
(19, 'test', 'male', 'area', 'city', 'pincode', '9327434007', '9327434007', '0263249772', '02632249772', '1992-06-22', '1992-06-22', 'jagrutisapkal@gmail.com', 1, '2017-12-05 14:06:29', '2017-12-05 14:07:20');

-- --------------------------------------------------------

--
-- Table structure for table `debit_notes`
--

CREATE TABLE `debit_notes` (
  `id` int(11) UNSIGNED NOT NULL,
  `debit_note_no` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `party_id` int(11) DEFAULT NULL,
  `purchase_invoice_data` longtext,
  `narration` text,
  `total_amount` double DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `debit_notes`
--

INSERT INTO `debit_notes` (`id`, `debit_note_no`, `date`, `party_id`, `purchase_invoice_data`, `narration`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, '123', '2017-11-02', 16, '3_600', '', 600, '2017-11-02 13:08:41', '2017-11-02 13:08:41'),
(2, '123', '2017-11-02', 16, '3_1200', '', 1200, '2017-11-02 13:09:32', '2017-11-02 13:09:32'),
(3, '1234', '2017-11-02', 16, '3_600', '', 600, '2017-11-02 13:11:26', '2017-11-02 13:11:26');

-- --------------------------------------------------------

--
-- Table structure for table `distributors`
--

CREATE TABLE `distributors` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text,
  `city` varchar(30) DEFAULT NULL,
  `state` varchar(30) DEFAULT NULL,
  `pincode` varchar(30) DEFAULT NULL,
  `phones` text,
  `mobiles` text,
  `email` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gst_state_codes`
--

CREATE TABLE `gst_state_codes` (
  `id` int(11) UNSIGNED NOT NULL,
  `state` varchar(255) NOT NULL,
  `state_code` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gst_state_codes`
--

INSERT INTO `gst_state_codes` (`id`, `state`, `state_code`, `created_at`, `updated_at`) VALUES
(1, 'Jammu & Kashmir', '01', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(2, 'Himachal Pradesh', '02', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(3, 'Punjab', '03', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(4, 'Chandigarh', '04', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(5, 'Uttarakhand', '05', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(6, 'Haryana', '06', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(7, 'Delhi', '07', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(8, 'Rajasthan', '08', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(9, 'Uttar Pradesh', '09', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(10, 'Bihar', '10', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(11, 'Sikkim', '11', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(12, 'Arunachal Pradesh', '12', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(13, 'Nagaland', '13', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(14, 'Manipur', '14', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(15, 'Mizoram', '15', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(16, 'Tripura', '16', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(17, 'Meghalaya', '17', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(18, 'Assam', '18', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(19, 'West Bengal', '19', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(20, 'Jharkhand', '20', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(21, 'Orissa', '21', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(22, 'Chhattisgarh', '22', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(23, 'Madhya Pradesh', '23', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(24, 'Gujarat', '24', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(25, 'Daman & Diu', '25', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(26, 'Dadra & Nagar Haveli', '26', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(27, 'Maharashtra', '27', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(28, 'Andhra Pradesh', '28', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(29, 'Karnataka', '29', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(30, 'Goa', '30', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(31, 'Lakshadweep', '31', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(32, 'Kerala', '32', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(33, 'Tamil Nadu', '33', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(34, 'Puducherry', '34', '2017-10-17 13:54:54', '2017-10-17 13:54:54'),
(35, 'Andaman & Nicobar Islands', '35', '2017-10-17 13:54:54', '2017-10-17 13:54:54');

-- --------------------------------------------------------

--
-- Table structure for table `gst_types`
--

CREATE TABLE `gst_types` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gst_types`
--

INSERT INTO `gst_types` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'composition', '2017-09-18 15:25:00', '2017-09-18 15:25:00'),
(2, 'consumer', '2017-09-18 15:25:00', '2017-09-18 15:25:00'),
(3, 'regular', '2017-09-18 15:25:17', '2017-09-18 15:25:17'),
(4, 'unregistered', '2017-09-18 15:25:17', '2017-09-18 15:25:17'),
(5, 'unknown', '2017-10-24 11:44:46', '2017-10-24 11:44:52');

-- --------------------------------------------------------

--
-- Table structure for table `journal_vouchers`
--

CREATE TABLE `journal_vouchers` (
  `id` int(11) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `entry_data` longtext,
  `total_amount` double DEFAULT NULL,
  `narration` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `journal_vouchers`
--

INSERT INTO `journal_vouchers` (`id`, `date`, `entry_data`, `total_amount`, `narration`, `created_at`, `updated_at`) VALUES
(2, '2017-11-06', 'cr_4_500,dr_3_500', 500, '', '2017-11-06 13:01:25', '2017-11-06 13:01:25');

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE `managers` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile_nums` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`id`, `name`, `email`, `mobile_nums`, `created_at`, `updated_at`) VALUES
(2, 'lakhan sen', 'lakhan.vapi@gmail.com', '9727612000,', '2017-09-09 16:34:01', '2017-09-11 11:36:34');

-- --------------------------------------------------------

--
-- Table structure for table `old_purchase_types`
--

CREATE TABLE `old_purchase_types` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `old_purchase_types`
--

INSERT INTO `old_purchase_types` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'input purchase', '2017-09-22 10:23:04', '2017-09-22 10:23:04'),
(2, 'interstate purchase', '2017-09-22 10:23:04', '2017-09-22 10:23:04'),
(3, 'interstate purchase gst', '2017-09-22 10:23:28', '2017-09-22 10:23:28'),
(4, 'local purchase', '2017-09-22 10:23:28', '2017-09-22 10:23:28'),
(5, 'local purchase gst', '2017-09-22 10:23:38', '2017-09-22 10:23:38');

-- --------------------------------------------------------

--
-- Table structure for table `on_item_rate_values`
--

CREATE TABLE `on_item_rate_values` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `greater_than` varchar(255) DEFAULT NULL,
  `up_to` varchar(255) DEFAULT NULL,
  `tax_type` varchar(255) DEFAULT NULL,
  `integrated_tax` varchar(255) DEFAULT NULL,
  `cess` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE `parties` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text,
  `contact_person` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile1` varchar(255) DEFAULT NULL,
  `mobile2` varchar(255) DEFAULT NULL,
  `residence_no` varchar(255) DEFAULT NULL,
  `office_no` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_branch` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `bank_account_no` varchar(255) DEFAULT NULL,
  `pan` varchar(255) DEFAULT NULL,
  `gst_state_code_id` int(11) DEFAULT '0',
  `gst_type_id` int(11) DEFAULT '0',
  `gstin` varchar(255) DEFAULT NULL,
  `brand_ids` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`id`, `name`, `address`, `contact_person`, `email`, `mobile1`, `mobile2`, `residence_no`, `office_no`, `bank_name`, `bank_branch`, `ifsc_code`, `bank_account_no`, `pan`, `gst_state_code_id`, `gst_type_id`, `gstin`, `brand_ids`, `is_deleted`, `created_at`, `updated_at`) VALUES
(16, 'salon party', 'valsad', 'jagr', 'jagruti@mjinfoworld.com', '9327434007', '', '', '', 'bob', 'tithal road valsad', '', '', 'FKXPS6536R', 24, 3, '24FKXPS6536R1Z5', '11,9', 0, '2017-11-14 12:29:55', '2017-11-14 12:29:55'),
(17, 'test', '', 'test', '', '', '', '', '', '', '', '', '', '', 0, 3, '', '9', 1, '2017-11-14 12:28:01', '2017-11-14 12:28:01'),
(20, 'test', '', 'test', '', '', '', '', '', '', '', '', '', '', 0, 3, '', '', 1, '2017-11-14 12:28:01', '2017-11-14 12:28:01'),
(21, 'test', '', 'test', '', '', '', '', '', '', '', '', '', '', 0, 3, '', '', 1, '2017-11-14 13:52:15', '2017-11-14 13:52:15'),
(22, 'test', '', 'test', '', '', '', '', '', '', '', '', '', '', 0, 3, '', '', 1, '2017-11-14 13:52:15', '2017-11-14 13:52:15'),
(23, 'test', '', 'test', '', '', '', '', '', '', '', '', '', '', 0, 3, '', '', 1, '2017-11-14 14:46:19', '2017-11-14 14:46:19'),
(24, 'test', '', 'test', '', '', '', '', '', '', '', '', '', '', 0, 3, '', '', 1, '2017-11-14 14:46:48', '2017-11-14 14:46:48'),
(25, 'teste', '', 'test', '', '', '', '', '', '', '', '', '', '', 0, 3, '', '', 1, '2017-11-14 14:46:50', '2017-11-14 14:46:50');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `parent_id`, `name`, `is_deleted`, `created_at`, `updated_at`) VALUES
(23, 0, 'hair products', 0, '2017-11-15 12:26:05', '2017-11-15 12:26:05'),
(24, 0, 'face products', 0, '2017-11-15 12:26:19', '2017-11-22 15:22:28'),
(25, 23, 'shampoos', 1, '2017-11-15 12:26:27', '2017-11-22 15:23:48');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `qty1` int(11) NOT NULL DEFAULT '0',
  `qty2` int(11) NOT NULL DEFAULT '0',
  `price` varchar(255) NOT NULL DEFAULT '0.00',
  `description` longtext,
  `hsn_code` varchar(255) DEFAULT NULL,
  `calculation_type` varchar(255) DEFAULT NULL,
  `taxability` varchar(255) DEFAULT NULL,
  `cgst` varchar(255) DEFAULT NULL,
  `sgst` varchar(255) DEFAULT NULL,
  `integrated_tax` varchar(255) DEFAULT NULL,
  `cess` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_category_id`, `brand_id`, `product_code`, `name`, `qty1`, `qty2`, `price`, `description`, `hsn_code`, `calculation_type`, `taxability`, `cgst`, `sgst`, `integrated_tax`, `cess`, `is_deleted`, `created_at`, `updated_at`) VALUES
(5, 23, 9, '', 'sensation smoothing shampoo', 1182, 64, '399', '', '33049910', 'on_value', 'taxable', '14', '14', '0.00', '0.00', 0, '2017-10-26 16:07:58', '2017-12-06 16:29:26'),
(6, 23, 9, '', 'sensation smoothing hair conditioner', 1161, 11, '400', '', '33049910', 'on_value', 'taxable', '14', '14', '0.00', '0.00', 0, '2017-10-26 18:20:12', '2017-12-08 18:40:47'),
(13, 24, 9, '', 'magic toner', 150, 20, '300', '', '330330020', 'on_value', 'taxable', '0.00', '0.00', '0.00', '0.00', 0, '2017-11-15 17:59:51', '2017-11-22 15:22:55');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_types`
--

CREATE TABLE `purchase_types` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_types`
--

INSERT INTO `purchase_types` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'interstate purchase', '2017-09-22 10:23:04', '2017-11-17 16:14:36'),
(2, 'local purchase', '2017-09-22 10:23:28', '2017-11-17 16:14:47');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_vouchers`
--

CREATE TABLE `purchase_vouchers` (
  `id` int(11) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `purchase_ledger_id` int(11) DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `purchase_type_id` int(11) DEFAULT NULL,
  `party_id` int(11) DEFAULT NULL,
  `products_data` longtext COMMENT 'product_id, target_account_id, product_name, hsn_code, mrp, qty, final_updated_qty, price, discount_percentage, discount_rs, cgst_percentage, cgst_rs, sgst_percentage, sgst_rs, igst_percentage, igst_rs, total_amount',
  `total_qty` int(11) DEFAULT NULL,
  `total_rate_per_unit` double DEFAULT NULL,
  `total_discount_percentage` double DEFAULT NULL,
  `total_discount_rs` double DEFAULT NULL,
  `total_cgst_percentage` double DEFAULT NULL,
  `total_cgst_rs` double DEFAULT NULL,
  `total_sgst_percentage` double DEFAULT NULL,
  `total_sgst_rs` double DEFAULT NULL,
  `total_igst_percentage` double DEFAULT NULL,
  `total_igst_rs` double DEFAULT NULL,
  `total_bill_amount` double DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_vouchers`
--

INSERT INTO `purchase_vouchers` (`id`, `date`, `purchase_ledger_id`, `invoice_no`, `invoice_date`, `purchase_type_id`, `party_id`, `products_data`, `total_qty`, `total_rate_per_unit`, `total_discount_percentage`, `total_discount_rs`, `total_cgst_percentage`, `total_cgst_rs`, `total_sgst_percentage`, `total_sgst_rs`, `total_igst_percentage`, `total_igst_rs`, `total_bill_amount`, `is_deleted`, `created_at`, `updated_at`) VALUES
(8, '2017-12-06', 68, '1234', '2014-03-12', 2, 71, '6_1_sensation smoothing hair conditioner_33049910_350_50_1562_250_0.00_0.00_18_2250.00_18_2250.00_0.00_0.00_17000.00', 50, 250, 0, 0, 18, 2250, 18, 2250, 0, 0, 17000, 0, '2017-12-05 14:27:55', '2017-12-05 15:13:14'),
(9, '2017-12-06', 68, '123', '2014-03-12', 1, 71, '6_2_sensation smoothing hair conditioner_33049910_800_5_11_250_0.00_0.00_0.00_0.00_0.00_0.00_0.00_0.00_1250.00', 5, 250, 0, 0, 0, 0, 0, 0, 0, 0, 1250, 0, '2017-12-05 15:03:33', '2017-12-05 15:18:59'),
(10, '2017-12-06', 68, '12345', '2017-07-12', 2, 69, '5_2_sensation smoothing shampoo_33049910_800_2_64_250_0.00_0.00_12_60.00_12_60.00_0.00_0.00_620.00', 2, 250, 0, 0, 12, 60, 12, 60, 0, 0, 620, 0, '2017-12-05 15:25:19', '2017-12-05 15:25:19'),
(11, '2017-12-06', 68, '12456', '2016-07-12', 2, 69, '6_1_sensation smoothing hair conditioner_33049910_900_10_1572_250_0.00_0.00_12_300.00_0.00_0.00_0.00_0.00_2800.00', 10, 250, 0, 0, 12, 300, 0, 0, 0, 0, 2800, 1, '2017-12-05 15:28:22', '2017-12-07 14:07:33'),
(12, '2017-12-07', 68, '456', '2012-05-11', 2, 71, '6_1_sensation smoothing hair conditioner_33049910_1000_25_1597_600_0.00_0.00_18_2700.00_18_2700.00_0.00_0.00_20400.00,5_1_sensation smoothing shampoo_33049910_1000_52_1176_600_0.00_0.00_0.00_0.00_0.00_0.00_0.00_0.00_31200.00', 77, 1200, 0, 0, 18, 2700, 18, 2700, 0, 0, 51600, 0, '2017-12-06 15:01:55', '2017-12-06 15:01:55'),
(13, '2017-12-07', 68, '2323', '1992-06-22', 2, 71, '6_1_sensation smoothing hair conditioner_33049910_80_24_1621_45.45_0.00_0.00_14_152.71_14_152.71_0.00_0.00_1396.22,5_1_sensation smoothing shampoo_33049910_399_6_1182_226.71_0.00_0.00_14_190.44_14_190.44_0.00_0.00_1741.13', 30, 272.16, 0, 0, 28, 343.15, 28, 343.15, 0, 0, 3137.35, 0, '2017-12-06 16:29:26', '2017-12-06 16:29:26'),
(14, '2017-12-09', 68, '232', '2017-06-22', 2, 71, '6_1_sensation smoothing hair conditioner_33049910_400_40_1661_350_0.00_0.00_14_1960.00_14_1960.00_0.00_0.00_17920.00', 40, 350, 0, 0, 14, 1960, 14, 1960, 0, 0, 17920, 0, '2017-12-08 15:14:59', '2017-12-08 15:14:59');

-- --------------------------------------------------------

--
-- Table structure for table `sale_types`
--

CREATE TABLE `sale_types` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale_types`
--

INSERT INTO `sale_types` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'interstate\n sale', '2017-11-01 15:31:37', '2017-12-08 12:18:57'),
(2, 'local sale', '2017-11-01 15:31:37', '2017-12-08 12:19:10');

-- --------------------------------------------------------

--
-- Table structure for table `sale_vouchers`
--

CREATE TABLE `sale_vouchers` (
  `id` int(11) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `sales_ledger_id` int(11) DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `sales_type_id` int(11) DEFAULT NULL,
  `party_id` int(11) DEFAULT NULL,
  `products_data` longtext COMMENT 'product_id, target_account_id, product_name, hsn_code, mrp, qty, final_updated_qty, discount_percentage, discount_rs, cgst_percentage, cgst_rs, sgst_percentage, sgst_rs, igst_percentage, igst_rs, total_amount',
  `total_qty` int(11) DEFAULT NULL,
  `total_rate_per_unit` double DEFAULT NULL,
  `total_discount_percentage` double DEFAULT NULL,
  `total_discount_rs` double DEFAULT NULL,
  `total_cgst_percentage` double DEFAULT NULL,
  `total_cgst_rs` double DEFAULT NULL,
  `total_sgst_percentage` double DEFAULT NULL,
  `total_sgst_rs` double DEFAULT NULL,
  `total_igst_percentage` double DEFAULT NULL,
  `total_igst_rs` double DEFAULT NULL,
  `total_bill_amount` double DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale_vouchers`
--

INSERT INTO `sale_vouchers` (`id`, `date`, `sales_ledger_id`, `invoice_no`, `invoice_date`, `sales_type_id`, `party_id`, `products_data`, `total_qty`, `total_rate_per_unit`, `total_discount_percentage`, `total_discount_rs`, `total_cgst_percentage`, `total_cgst_rs`, `total_sgst_percentage`, `total_sgst_rs`, `total_igst_percentage`, `total_igst_rs`, `total_bill_amount`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, '2017-12-09', 70, '123', '2017-05-12', 2, 72, '6_1_sensation smoothing hair conditioner_33049910_400_500_1161_0.00_0.00_18_36000.00_18_36000.00_0.00_0.00_272000.00', 500, 400, 0, 0, 18, 36000, 18, 36000, 0, 0, 272000, 0, '2017-12-08 18:40:47', '2017-12-08 18:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `staff_members`
--

CREATE TABLE `staff_members` (
  `id` int(11) UNSIGNED NOT NULL,
  `staff_code` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL DEFAULT 'male',
  `address` text,
  `permanent_address` text,
  `mobile1` varchar(255) DEFAULT NULL,
  `mobile2` varchar(255) DEFAULT NULL,
  `residence_no` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `doa` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `insurance_type` varchar(255) DEFAULT NULL,
  `insurance_name` varchar(255) DEFAULT NULL,
  `insurance_amount` double DEFAULT NULL,
  `insurance_from` varchar(255) DEFAULT NULL,
  `insurance_to` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upadted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_members`
--

INSERT INTO `staff_members` (`id`, `staff_code`, `name`, `designation`, `gender`, `address`, `permanent_address`, `mobile1`, `mobile2`, `residence_no`, `dob`, `doa`, `email`, `insurance_type`, `insurance_name`, `insurance_amount`, `insurance_from`, `insurance_to`, `is_deleted`, `created_at`, `upadted_at`) VALUES
(12, 'code#1', 'jagruti staff', 'owner', 'female', 'valsad', 'surat', '9327434007', '9099584007', '02632249772', '1992-06-22', '2016-04-28', 'jagruti@mjinfoworld.com', 'madical', 'Floater', 100.5, '2015-06-11', '2017-06-22', 0, '2017-10-24 16:03:05', '2017-11-15 13:38:08'),
(13, 'tr', 'test', '', 'male', '', '', '', '', '', '', '', '', '', '', 0, '', '', 1, '2017-11-14 12:35:48', '2017-11-14 12:36:00'),
(14, 'tr', 'test', '', 'male', '', '', '', '', '', '', '', '', '', '', 0, '', '', 1, '2017-11-14 12:35:53', '2017-11-14 12:36:00'),
(15, '001', 'test', 'ggf', 'male', 'gfg', 'gfg', '9327434007', '9327434007', '', '2016-12-31', '', '', '', '', 0, '2014-08-31', '2015-08-31', 0, '2017-12-05 14:09:12', '2017-12-05 14:09:12');

-- --------------------------------------------------------

--
-- Table structure for table `target_accounts`
--

CREATE TABLE `target_accounts` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `target_accounts`
--

INSERT INTO `target_accounts` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'asha', '2017-11-15 17:52:56', '2017-11-15 17:52:56'),
(2, 'lakhan', '2017-11-15 17:52:56', '2017-11-15 17:52:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_groups`
--
ALTER TABLE `account_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contra_vouchers`
--
ALTER TABLE `contra_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit_notes`
--
ALTER TABLE `credit_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `debit_notes`
--
ALTER TABLE `debit_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `distributors`
--
ALTER TABLE `distributors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gst_state_codes`
--
ALTER TABLE `gst_state_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gst_types`
--
ALTER TABLE `gst_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal_vouchers`
--
ALTER TABLE `journal_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `old_purchase_types`
--
ALTER TABLE `old_purchase_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `on_item_rate_values`
--
ALTER TABLE `on_item_rate_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_types`
--
ALTER TABLE `purchase_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_vouchers`
--
ALTER TABLE `purchase_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_types`
--
ALTER TABLE `sale_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_vouchers`
--
ALTER TABLE `sale_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_members`
--
ALTER TABLE `staff_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `target_accounts`
--
ALTER TABLE `target_accounts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_groups`
--
ALTER TABLE `account_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `contra_vouchers`
--
ALTER TABLE `contra_vouchers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `credit_notes`
--
ALTER TABLE `credit_notes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `debit_notes`
--
ALTER TABLE `debit_notes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `distributors`
--
ALTER TABLE `distributors`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gst_state_codes`
--
ALTER TABLE `gst_state_codes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `gst_types`
--
ALTER TABLE `gst_types`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `journal_vouchers`
--
ALTER TABLE `journal_vouchers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `managers`
--
ALTER TABLE `managers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `old_purchase_types`
--
ALTER TABLE `old_purchase_types`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `on_item_rate_values`
--
ALTER TABLE `on_item_rate_values`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `purchase_types`
--
ALTER TABLE `purchase_types`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `purchase_vouchers`
--
ALTER TABLE `purchase_vouchers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `sale_types`
--
ALTER TABLE `sale_types`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sale_vouchers`
--
ALTER TABLE `sale_vouchers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `staff_members`
--
ALTER TABLE `staff_members`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `target_accounts`
--
ALTER TABLE `target_accounts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
