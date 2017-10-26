-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2017 at 08:56 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_groups`
--

INSERT INTO `account_groups` (`id`, `parent_id`, `name`, `created_at`, `updated_at`) VALUES
(26, 0, 'Non Revenue - Primary Groups', '2017-10-24 17:01:07', '2017-10-25 12:35:54'),
(27, 0, 'Capital Account', '2017-10-24 17:01:28', '2017-10-24 17:01:28'),
(28, 0, 'Current Assets', '2017-10-24 17:02:10', '2017-10-24 17:02:10'),
(29, 28, 'Bank Accounts', '2017-10-24 17:03:43', '2017-10-24 17:03:43'),
(30, 29, 'Current account', '2017-10-24 17:04:07', '2017-10-24 17:04:07'),
(31, 29, 'savings account', '2017-10-24 17:04:30', '2017-10-24 17:04:30'),
(32, 28, 'Cash-in hand', '2017-10-24 17:04:58', '2017-10-24 17:04:58'),
(33, 28, 'Deposits (Asset)', '2017-10-24 17:05:14', '2017-10-24 17:05:14'),
(34, 28, 'Loans & Advances (Asset)', '2017-10-25 12:24:47', '2017-10-25 12:24:47'),
(36, 28, 'Stock-in-hand', '2017-10-25 12:26:18', '2017-10-25 12:26:18'),
(38, 28, 'Integrated Accounts-cum-Invent', '2017-10-25 12:34:52', '2017-10-25 12:34:52'),
(39, 28, 'Non-integrated Accounts-cum-In', '2017-10-26 10:26:27', '2017-10-26 10:26:27'),
(40, 28, 'Sundry Debtors', '2017-10-26 10:27:07', '2017-10-26 10:27:07'),
(41, 0, 'Current Liabilities', '2017-10-26 10:27:44', '2017-10-26 10:27:44'),
(42, 41, 'Duties and Taxes', '2017-10-26 10:28:02', '2017-10-26 10:28:02'),
(43, 41, 'Provisions', '2017-10-26 10:28:36', '2017-10-26 10:28:54'),
(44, 41, 'Sundry Creditors', '2017-10-26 10:29:03', '2017-10-26 10:29:03'),
(45, 0, 'Investments', '2017-10-26 10:29:16', '2017-10-26 10:29:16'),
(46, 0, 'Loans (Liability)', '2017-10-26 10:30:04', '2017-10-26 10:30:04'),
(47, 46, 'Bank OD Accounts [Bank OCC Accounts]', '2017-10-26 10:30:18', '2017-10-26 10:49:53'),
(48, 46, 'Bank OCC A/c', '2017-10-26 10:30:38', '2017-10-26 10:50:12'),
(49, 46, 'Secured Loans', '2017-10-26 10:31:15', '2017-10-26 10:31:15'),
(50, 46, 'Unsecured Loans', '2017-10-26 10:31:31', '2017-10-26 10:31:31'),
(51, 0, 'Suspense Account', '2017-10-26 10:32:23', '2017-10-26 10:32:23'),
(52, 51, 'Loans and Advances (Asset) Group', '2017-10-26 10:32:39', '2017-10-26 10:45:30'),
(53, 0, 'Miscellaneous Expenses (Asset)', '2017-10-26 10:32:53', '2017-10-26 10:32:53'),
(55, 0, 'Branch/Divisions', '2017-10-26 10:33:24', '2017-10-26 10:33:24'),
(56, 0, 'Revenue - Primary Groups', '2017-10-26 10:33:38', '2017-10-26 10:42:54'),
(57, 0, 'Sales Account', '2017-10-26 10:34:10', '2017-10-26 10:34:10'),
(58, 0, 'Purchase Account', '2017-10-26 10:34:44', '2017-10-26 10:34:44'),
(59, 0, 'Direct Income [Income Direct]', '2017-10-26 10:35:05', '2017-10-26 10:35:05'),
(60, 0, 'Indirect Income [Income Indirect]', '2017-10-26 10:36:22', '2017-10-26 10:42:03'),
(61, 0, 'Direct Expenses [Expenses Direct]', '2017-10-26 10:36:34', '2017-10-26 10:41:50'),
(62, 0, 'Indirect Expenses [Expenses Indirect]', '2017-10-26 10:36:50', '2017-10-26 10:41:43'),
(63, 0, 'Common and Possible Errors in Grouping and Account Classification', '2017-10-26 10:37:04', '2017-10-26 10:40:53'),
(64, 0, 'Debtor/Creditor classification', '2017-10-26 10:37:16', '2017-10-26 10:37:16'),
(65, 0, 'Opening Two Accounts Of The Same Party', '2017-10-26 10:37:26', '2017-10-26 10:41:06');

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `account_no` varchar(255) NOT NULL,
  `account_group_id` int(11) DEFAULT NULL,
  `opening_type` varchar(255) DEFAULT NULL,
  `opening_amount` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `address` text,
  `mobile1` varchar(255) DEFAULT NULL,
  `mobile2` varchar(255) DEFAULT NULL,
  `office_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `created_at`, `updated_at`) VALUES
(9, 'test', '2017-09-13 12:42:20', '2017-09-13 12:42:20'),
(11, 'kaka', '2017-09-29 15:31:09', '2017-09-29 15:31:09');

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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upadted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `gender`, `area`, `city`, `pincode`, `mobile1`, `mobile2`, `residence_no`, `office_no`, `dob`, `doa`, `email`, `created_at`, `upadted_at`) VALUES
(16, 'jagruti', 'female', 'surat', '', '394510', '9327434007', '', '', '', '1992-06-22', '', '', '2017-10-24 16:01:03', '2017-10-24 16:01:43');

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
  `contact_person` varchar(255) NOT NULL,
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
  `gst_type_id` int(11) NOT NULL DEFAULT '0',
  `gstin` varchar(255) DEFAULT NULL,
  `brand_ids` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`id`, `name`, `address`, `contact_person`, `email`, `mobile1`, `mobile2`, `residence_no`, `office_no`, `bank_name`, `bank_branch`, `ifsc_code`, `bank_account_no`, `pan`, `gst_state_code_id`, `gst_type_id`, `gstin`, `brand_ids`, `created_at`, `updated_at`) VALUES
(16, 'salon party', 'valsad', 'jagr', 'jagruti@mjinfoworld.com', '9327434007', '', '', '', 'bob', 'tithal road valsad', '', '', 'FKXPS6536R', 24, 3, '24FKXPS6536R1Z5', '11,9', '2017-10-24 16:51:34', '2017-10-24 16:51:34');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `parent_id`, `name`, `created_at`, `updated_at`) VALUES
(7, 0, 'test', '2017-09-15 10:59:15', '2017-09-15 10:59:15'),
(8, 7, 'test1', '2017-09-15 10:59:22', '2017-09-15 10:59:22'),
(9, 8, 'Test2', '2017-09-15 10:59:27', '2017-09-15 10:59:30');

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
  `qty` int(11) NOT NULL DEFAULT '0',
  `price` varchar(255) NOT NULL DEFAULT '0.00',
  `description` longtext,
  `hsn_code` varchar(255) DEFAULT NULL,
  `calculation_type` varchar(255) DEFAULT NULL,
  `taxability` varchar(255) DEFAULT NULL,
  `integrated_tax` varchar(255) DEFAULT NULL,
  `cess` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_category_id`, `brand_id`, `product_code`, `name`, `qty`, `price`, `description`, `hsn_code`, `calculation_type`, `taxability`, `integrated_tax`, `cess`, `created_at`, `updated_at`) VALUES
(4, 9, 9, '', 'test', 0, '0', '', '', 'on_value', 'taxable', '0.00', '0.00', '2017-09-29 11:25:10', '2017-09-29 11:25:10');

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
(1, 'input purchase', '2017-09-22 10:23:04', '2017-09-22 10:23:04'),
(2, 'interstate purchase', '2017-09-22 10:23:04', '2017-09-22 10:23:04'),
(3, 'interstate purchase gst', '2017-09-22 10:23:28', '2017-09-22 10:23:28'),
(4, 'local purchase', '2017-09-22 10:23:28', '2017-09-22 10:23:28'),
(5, 'local purchase gst', '2017-09-22 10:23:38', '2017-09-22 10:23:38');

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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upadted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_members`
--

INSERT INTO `staff_members` (`id`, `staff_code`, `name`, `designation`, `gender`, `address`, `permanent_address`, `mobile1`, `mobile2`, `residence_no`, `dob`, `doa`, `email`, `insurance_type`, `insurance_name`, `insurance_amount`, `insurance_from`, `insurance_to`, `created_at`, `upadted_at`) VALUES
(12, 'code#1', 'jagruti staff', 'owner', 'female', 'valsad', 'surat', '9327434007', '9099584007', '02632249772', '1992-06-22', '2016-04-28', 'jagruti@mjinfoworld.com', 'madical', 'Floater', 100000, '2015-06-11', '2017-06-22', '2017-10-24 16:03:05', '2017-10-24 16:47:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_groups`
--
ALTER TABLE `account_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
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
-- Indexes for table `customers`
--
ALTER TABLE `customers`
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
-- Indexes for table `managers`
--
ALTER TABLE `managers`
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
-- Indexes for table `staff_members`
--
ALTER TABLE `staff_members`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_groups`
--
ALTER TABLE `account_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
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
-- AUTO_INCREMENT for table `managers`
--
ALTER TABLE `managers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `on_item_rate_values`
--
ALTER TABLE `on_item_rate_values`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `purchase_types`
--
ALTER TABLE `purchase_types`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `staff_members`
--
ALTER TABLE `staff_members`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
