-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2026 at 02:00 PM
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
-- Database: `talktome`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `aemail` varchar(255) NOT NULL,
  `apassword` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aemail`, `apassword`) VALUES
('admin@ttm.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appoid` int(11) NOT NULL,
  `pid` int(10) DEFAULT NULL,
  `apponum` int(3) DEFAULT NULL,
  `scheduleid` int(10) DEFAULT NULL,
  `appodate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appoid`, `pid`, `apponum`, `scheduleid`, `appodate`) VALUES
(1, 1, 1, 1, '2022-06-03'),
(7, 3, 1, 11, '2025-04-10'),
(8, 7, 1, 13, '2026-05-16'),
(9, 21, 1, 15, '2026-05-19'),
(10, 21, 1, 14, '2026-05-19');

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
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `docid` int(11) NOT NULL,
  `docemail` varchar(255) DEFAULT NULL,
  `docname` varchar(255) DEFAULT NULL,
  `docpassword` varchar(255) DEFAULT NULL,
  `docnic` varchar(15) DEFAULT NULL,
  `doctel` varchar(15) DEFAULT NULL,
  `specialties` int(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`docid`, `docemail`, `docname`, `docpassword`, `docnic`, `doctel`, `specialties`) VALUES
(1, 'doctor@ttm.com', 'ttm Doctor', '123', '000000000', '0110000000', 1),
(2, 'deeya@gmail.com', 'deeya', '123', '555', '98616880', 8),
(3, 'sarita@gmail.com', 'Sarita Neupane', '111', '', '98616880', 2);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_availability`
--

CREATE TABLE `doctor_availability` (
  `id` int(11) NOT NULL,
  `docid` int(11) NOT NULL,
  `available_date` date DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `slot_duration` int(11) DEFAULT 30,
  `status` varchar(20) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_availability`
--

INSERT INTO `doctor_availability` (`id`, `docid`, `available_date`, `start_time`, `end_time`, `slot_duration`, `status`) VALUES
(5, 2, '2026-05-20', '10:10:00', '11:11:00', 30, 'active'),
(6, 2, '2026-05-21', '16:20:00', '17:15:00', 30, 'active'),
(7, 2, '2026-05-22', '09:00:00', '11:00:00', 30, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_slots`
--

CREATE TABLE `doctor_slots` (
  `slot_id` int(11) NOT NULL,
  `docid` int(11) NOT NULL,
  `slot_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` varchar(20) DEFAULT 'available',
  `is_booked` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_slots`
--

INSERT INTO `doctor_slots` (`slot_id`, `docid`, `slot_date`, `start_time`, `end_time`, `status`, `is_booked`) VALUES
(1, 2, '2026-05-24', '17:55:00', '18:25:00', 'available', 0),
(2, 2, '2026-05-24', '18:25:00', '18:55:00', 'available', 0),
(3, 2, '2026-05-24', '17:55:00', '18:25:00', 'available', 0),
(4, 2, '2026-05-24', '18:25:00', '18:55:00', 'available', 0),
(5, 2, '2026-05-24', '17:55:00', '18:25:00', 'available', 0),
(6, 2, '2026-05-24', '18:25:00', '18:55:00', 'available', 0),
(7, 2, '2026-05-20', '11:10:00', '11:40:00', 'available', 0),
(8, 2, '2026-05-20', '11:40:00', '12:10:00', 'available', 0),
(9, 2, '2026-05-20', '12:10:00', '12:40:00', 'available', 0),
(10, 2, '2026-05-20', '12:40:00', '13:10:00', 'available', 0),
(11, 2, '2026-05-20', '13:10:00', '13:40:00', 'available', 0),
(12, 2, '2026-05-20', '13:40:00', '14:10:00', 'available', 0),
(13, 2, '2026-05-20', '14:10:00', '14:40:00', 'available', 0),
(14, 2, '2026-05-20', '14:40:00', '15:10:00', 'available', 0),
(15, 2, '2026-05-20', '15:10:00', '15:40:00', 'available', 0),
(16, 2, '2026-05-20', '15:40:00', '16:10:00', 'available', 0),
(17, 2, '2026-05-20', '16:10:00', '16:40:00', 'available', 0),
(18, 2, '2026-05-20', '16:40:00', '17:10:00', 'available', 0),
(19, 2, '2026-05-20', '17:10:00', '17:40:00', 'available', 0),
(20, 2, '2026-05-20', '17:40:00', '18:10:00', 'available', 0),
(21, 2, '2026-05-20', '18:10:00', '18:40:00', 'available', 0),
(22, 2, '2026-05-20', '18:40:00', '19:10:00', 'available', 0),
(23, 2, '2026-05-20', '19:10:00', '19:40:00', 'available', 0),
(24, 2, '2026-05-20', '19:40:00', '20:10:00', 'available', 0),
(25, 2, '2026-05-24', '09:20:00', '09:50:00', 'available', 0),
(26, 2, '2026-05-24', '09:50:00', '10:20:00', 'available', 0),
(27, 2, '2026-05-24', '10:20:00', '10:50:00', 'available', 0),
(28, 2, '2026-05-24', '10:50:00', '11:20:00', 'available', 0),
(29, 2, '2026-05-24', '11:20:00', '11:50:00', 'available', 0),
(30, 2, '2026-05-24', '11:50:00', '12:20:00', 'available', 0),
(31, 2, '2026-05-24', '12:20:00', '12:50:00', 'available', 0),
(32, 2, '2026-05-24', '12:50:00', '13:20:00', 'available', 0),
(33, 2, '2026-05-24', '13:20:00', '13:50:00', 'available', 0),
(34, 2, '2026-05-24', '13:50:00', '14:20:00', 'available', 0),
(35, 2, '2026-05-24', '14:20:00', '14:50:00', 'available', 0),
(36, 2, '2026-05-24', '14:50:00', '15:20:00', 'available', 0),
(37, 2, '2026-05-24', '15:20:00', '15:50:00', 'available', 0),
(38, 2, '2026-05-24', '15:50:00', '16:20:00', 'available', 0),
(39, 2, '2026-05-24', '16:20:00', '16:50:00', 'available', 0),
(40, 2, '2026-05-24', '16:50:00', '17:20:00', 'available', 0),
(41, 2, '2026-05-24', '17:20:00', '17:50:00', 'available', 0),
(42, 2, '2026-05-24', '17:50:00', '18:20:00', 'available', 0),
(43, 2, '2026-05-24', '18:20:00', '18:50:00', 'available', 0),
(44, 2, '2026-05-24', '18:50:00', '19:20:00', 'available', 0),
(45, 2, '2026-05-24', '19:20:00', '19:50:00', 'available', 0),
(46, 2, '2026-05-24', '19:50:00', '20:20:00', 'available', 0),
(47, 2, '2026-05-24', '20:20:00', '20:50:00', 'available', 0),
(48, 2, '2026-05-24', '20:50:00', '21:20:00', 'available', 0);

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
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `problem` text NOT NULL,
  `matched_specialties` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `matched_specialties_ids` text DEFAULT NULL,
  `recommended_doctors` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `user_id`, `problem`, `matched_specialties`, `timestamp`, `matched_specialties_ids`, `recommended_doctors`) VALUES
(1, 7, 'child', 'Child Psychology', '2026-05-16 08:47:52', '2', '3'),
(2, 7, 'child', 'Child Psychology', '2026-05-16 08:51:54', '2', '3'),
(3, 7, 'stress', 'Counseling Psychology, Health Psychology', '2026-05-16 08:52:01', '3,7', ''),
(4, 7, 'child', 'Child Psychology', '2026-05-16 09:41:31', '2', '3'),
(5, 7, 'stress', 'Counseling Psychology, Health Psychology', '2026-05-16 09:41:56', '3,7', ''),
(6, 7, 'stress', 'Counseling Psychology, Health Psychology', '2026-05-16 09:42:01', '3,7', ''),
(7, 7, 'anxiety', 'Clinical Psychology', '2026-05-16 09:42:23', '1', '1'),
(8, 7, 'stress', 'Counseling Psychology, Health Psychology', '2026-05-16 09:46:39', '3,7', ''),
(9, 7, 'stress', 'Counseling Psychology, Health Psychology', '2026-05-16 09:52:31', '3,7', ''),
(10, 7, 'child', 'Child Psychology', '2026-05-16 09:52:37', '2', '3'),
(11, 7, 'child', 'Child Psychology', '2026-05-16 09:59:22', '2', '3'),
(12, 7, 'child', 'Child Psychology', '2026-05-16 10:08:18', '2', '3'),
(13, 7, 'child', 'Child Psychology', '2026-05-16 10:13:02', '2', '3'),
(14, 7, 'child', 'Child Psychology', '2026-05-16 10:18:24', '2', '3'),
(15, 7, 'child', 'Child Psychology', '2026-05-16 10:18:48', '2', '3'),
(16, 7, 'child', 'Child Psychology', '2026-05-16 10:20:42', '2', '3'),
(17, 7, 'child', 'Child Psychology', '2026-05-16 10:23:04', '2', '3'),
(18, 7, 'child', 'Child Psychology', '2026-05-16 10:25:36', '2', '3'),
(19, 7, 'stress', 'Counseling Psychology, Health Psychology', '2026-05-16 10:34:24', '3,7', ''),
(20, 7, 'child, stress', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-16 10:34:34', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(21, 7, 'stress,child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-16 10:59:07', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(22, 7, 'stress', 'Counseling Psychology, Health Psychology', '2026-05-16 12:17:17', '3,7', ''),
(23, 7, 'stress,child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-16 12:17:23', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(24, 7, 'i have been stressed with exams', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-17 04:24:00', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(25, 3, 'stress', 'Counseling Psychology, Health Psychology', '2026-05-17 10:22:55', '3,7', ''),
(26, 3, 'child', 'Child Psychology', '2026-05-17 10:23:03', '2', '3'),
(27, 3, 'child,stress', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-17 10:23:11', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(28, 3, 'stress,child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-18 02:05:56', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(29, 21, 'stress, child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-19 15:19:00', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(30, 21, 'stress, child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-19 15:21:39', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(31, 21, 'stress, child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-19 15:22:19', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(32, 21, 'stress, child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-19 15:40:28', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(33, 21, 'stress, child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-19 15:41:44', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(34, 21, 'stress', 'Counseling Psychology, Health Psychology', '2026-05-19 15:42:17', '3,7', ''),
(35, 21, 'stress, child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-19 15:42:24', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(36, 21, 'stress, child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-19 15:43:17', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(37, 21, 'stress, child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-19 15:44:04', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(38, 21, 'stress,child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-19 15:54:08', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(39, 21, 'stress, child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-19 15:57:38', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(40, 21, 'child', 'Child Psychology', '2026-05-19 16:01:10', '2', '3'),
(41, 21, 'stress,child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-20 02:56:23', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(42, 21, 'child', 'Child Psychology', '2026-05-20 02:58:22', '2', '3'),
(43, 21, 'cjild', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-20 03:25:58', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(44, 21, 'stress', 'Counseling Psychology, Health Psychology', '2026-05-20 03:26:14', '3,7', ''),
(45, 21, 'chigh', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-20 03:26:25', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(46, 21, 'stress', 'Counseling Psychology, Health Psychology', '2026-05-20 03:26:56', '3,7', ''),
(47, 21, 'stress', 'Counseling Psychology, Health Psychology', '2026-05-20 03:27:27', '3,7', ''),
(48, 21, 'stress, child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-20 03:27:35', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(49, 21, 'stress, child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-20 03:27:52', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(50, 21, 'stress, child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-20 03:28:14', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(51, 21, 'stress, child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-20 03:28:36', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(52, 21, 'stress, child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-20 03:29:46', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(53, 21, 'stress, child', 'Clinical Psychology, Child Psychology, Counseling Psychology, Forensic Criminal Psychology, Educational Psychology, Sports Psychology, Health Psychology, Abnormal Psychology, Cognitive Psychology, Rehabilitation Psychology', '2026-05-20 03:32:38', '1,2,3,4,5,6,7,8,9,10', '1,2,3'),
(54, 21, 'child', 'Child Psychology', '2026-05-20 03:34:19', '2', '3');

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
(3, '0001_01_01_000002_create_jobs_table', 1);

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
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `pid` int(11) NOT NULL,
  `pemail` varchar(255) DEFAULT NULL,
  `pname` varchar(255) DEFAULT NULL,
  `ppassword` varchar(255) DEFAULT NULL,
  `paddress` varchar(255) DEFAULT NULL,
  `pnic` varchar(15) DEFAULT NULL,
  `pdob` date DEFAULT NULL,
  `ptel` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`pid`, `pemail`, `pname`, `ppassword`, `paddress`, `pnic`, `pdob`, `ptel`) VALUES
(3, 'shreya@gmail.com', 'Shreya Subedi', '3121', 'Imadol', '3121', '2004-01-19', '0123456789'),
(20, 'deeya12@gmail.com', 'Dee Mhn', '$2y$12$gNrZTNUnVqaAGN3tMhL2qeOPYLCus5sgMN5tClVOkuRv7e1c8ga2i', 'boston', NULL, '2000-01-19', '9876543210'),
(5, 'shreya654@gmail.com', 'Shreya Subedi', '333', 'Imadol, mahalaxmi municipality', '3121', '2025-03-04', '0123456789'),
(16, 'diya@gmail.com', 'Diya Mhj', 'deeya@123D', 'boston', NULL, '1959-09-19', '9876543102'),
(7, 'shreya999@gmail.com', 'Shreya Subedi', '8910', 'Imadol, mahalaxmi municipality', '3121', '2025-03-04', '9877666544'),
(21, 'shreya12@gmail.com', 'Shreya Mhj', '$2y$12$zfWTbq5iSNaPLSVUuJatzOwoakTel06dLYQ/MiEkjuBGnlFhfp6cW', 'ratnapark', NULL, '2003-08-26', '9876543210'),
(18, 'deeya1@gmail.com', 'Dee Mhn', 'deeya@12', 'boston', NULL, '2000-10-19', '9876543210'),
(19, 'deeya12@gmail.com', 'Dee Mhn', '$2y$12$0zouP999s2ETGnFXP1UEJuRTJZCQ4/15lySAMGjk63J6kbVLksJWK', 'boston', NULL, '1999-01-19', '9876543210'),
(17, 'diyaa@ttm.com', 'Diya Mhj', 'deeya@12DEE', 'boston', NULL, '1959-09-19', '987654310'),
(15, 'shreyasubedi4@gmail.com', 'shreya subedi', '12345678Ss*', 'Kalanki', NULL, '2009-04-20', '9861688014');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `scheduleid` int(11) NOT NULL,
  `docid` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `scheduledate` date DEFAULT NULL,
  `scheduletime` time DEFAULT NULL,
  `nop` int(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`scheduleid`, `docid`, `title`, `scheduledate`, `scheduletime`, `nop`) VALUES
(15, '1', 'ttm', '2026-07-16', '08:45:00', 10),
(13, '2', 'ttm new', '2026-06-16', '17:40:00', 6),
(14, '3', 'ttm new2', '2026-06-10', '10:45:00', 7);

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

-- --------------------------------------------------------

--
-- Table structure for table `specialties`
--

CREATE TABLE `specialties` (
  `id` int(2) NOT NULL,
  `sname` varchar(50) DEFAULT NULL,
  `keywords` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `specialties`
--

INSERT INTO `specialties` (`id`, `sname`, `keywords`) VALUES
(1, 'Clinical Psychology', 'clinical, diagnosis, mental disorder, therapy, treatment, psychiatric, depression, anxiety, OCD, PTSD'),
(2, 'Child Psychology', 'child, children, kid, teen, adolescent, behavior, school issues, bullying, developmental delay\r\n'),
(3, 'Counseling Psychology', 'counseling, relationship, breakup, family issues, marriage, divorce, stress, grief, trauma, emotional support'),
(4, 'Forensic Criminal Psychology', 'crime, criminal, forensic, court, legal, offender, investigation, victim, witness, testimony'),
(5, 'Educational Psychology', 'education, learning, academic, memory, study, attention, concentration, school, cognitive development'),
(6, 'Sports Psychology', 'sports, athlete, performance, motivation, confidence, injury recovery, focus, team, competition'),
(7, 'Health Psychology', 'health, illness, chronic pain, coping, medical, stress management, wellbeing, disease, cancer, heart'),
(8, 'Abnormal Psychology', 'abnormal, hallucination, delusion, psychosis, schizophrenia, bipolar, extreme behavior, mood swings'),
(9, 'Cognitive Psychology', 'cognition, memory, perception, attention, decision making, reasoning, thinking, problem solving'),
(10, 'Rehabilitation Psychology', 'rehabilitation,recovery,trauma,injury,disability,adjustment,physical therapy,stroke,loss,addiction,drug,alcohol,substance abuse,relapse,detox,counseling\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `webuser`
--

CREATE TABLE `webuser` (
  `email` varchar(255) NOT NULL,
  `usertype` char(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `webuser`
--

INSERT INTO `webuser` (`email`, `usertype`) VALUES
('admin@ttm.com', 'a'),
('doctor@ttm.com', 'd'),
('patient@edoc.com', 'p'),
('emhashenudara@gmail.com', 'p'),
('shreya@gmail.com', 'p'),
('shreya111@gmail.com', 'p'),
('shreya654@gmail.com', 'p'),
('shreya65432@gmail.com', 'p'),
('shreya999@gmail.com', 'p'),
('shreya678@gmail.com', 'p'),
('deeya@gmail.com', 'd'),
('sarita@gmail.com', 'd'),
('surajo14ry@gmail.com', 'p'),
('deeya333333@gmail.com', 'p'),
('ram@gmail.com', 'p'),
('abc@gmail.com', 'p'),
('ojanmaharjan03@gmail.com', 'p'),
('xyzzz@gmail.com', 'p'),
('shreyasubedi4@gmail.com', 'p'),
('diya@gmail.com', 'p'),
('diyaa@ttm.com', 'p'),
('deeya1@gmail.com', 'p'),
('deeya12@gmail.com', 'p'),
('shreya12@gmail.com', 'p');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aemail`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appoid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `scheduleid` (`scheduleid`);

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
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`docid`),
  ADD KEY `specialties` (`specialties`);

--
-- Indexes for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_slots`
--
ALTER TABLE `doctor_slots`
  ADD PRIMARY KEY (`slot_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`scheduleid`),
  ADD KEY `docid` (`docid`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `specialties`
--
ALTER TABLE `specialties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `webuser`
--
ALTER TABLE `webuser`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `docid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctor_availability`
--
ALTER TABLE `doctor_availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `doctor_slots`
--
ALTER TABLE `doctor_slots`
  MODIFY `slot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `scheduleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
