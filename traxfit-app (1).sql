-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 12, 2026 at 03:49 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `traxfit-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gym_settings`
--

CREATE TABLE `gym_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_gym` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_struk` text COLLATE utf8mb4_unicode_ci,
  `harga_visit` decimal(10,2) NOT NULL DEFAULT '25000.00' COMMENT 'Harga visit harian',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gym_settings`
--

INSERT INTO `gym_settings` (`id`, `nama_gym`, `alamat`, `telepon`, `logo`, `footer_struk`, `harga_visit`, `created_at`, `updated_at`) VALUES
(1, 'TraxFit Gym', 'Jl. Contoh No. 123, Kota Bau', '0812-3456-7890', 'gym-settings/GokV5d28X5sc4bcEGSUa5EHg7YoTY5wplqVzPczj.png', 'Terima kasih telah berbelanja di TraxFit Gym', 25000.00, '2026-02-20 20:14:28', '2026-04-12 12:31:43');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `role_user` enum('admin','kasir','owner') COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `id_user`, `role_user`, `activity`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 0 member, 0 produk', '2026-02-20 20:14:42', '2026-02-20 20:14:42'),
(2, 1, 'admin', 'Create Category', 'Menambahkan kategori baru: suplemen', '2026-02-20 20:15:11', '2026-02-20 20:15:11'),
(3, 1, 'admin', 'Create Product', 'Menambahkan produk baru: es teh', '2026-02-20 20:15:45', '2026-02-20 20:15:45'),
(4, 1, 'admin', 'Create Membership Package', 'Menambahkan paket membership: 1 bulan', '2026-02-20 20:16:32', '2026-02-20 20:16:32'),
(5, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-02-20 20:17:08', '2026-02-20 20:17:08'),
(6, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 22/01/2026 - 21/02/2026', '2026-02-20 20:17:19', '2026-02-20 20:17:19'),
(7, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-02-20 20:17:31', '2026-02-20 20:17:31'),
(8, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-02-20 20:17:40', '2026-02-20 20:17:40'),
(9, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-02-20 20:17:41', '2026-02-20 20:17:41'),
(10, 1, 'admin', 'Create User', 'Menambahkan user baru: asep ganteng', '2026-02-20 20:30:03', '2026-02-20 20:30:03'),
(11, 1, 'admin', 'Create Product', 'Menambahkan produk baru: Creatine Monohydrate', '2026-02-20 20:30:43', '2026-02-20 20:30:43'),
(12, 1, 'admin', 'Toggle Product Status', 'Mengubah status produk Creatine Monohydrate dari aktif menjadi nonaktif', '2026-02-20 20:30:50', '2026-02-20 20:30:50'),
(13, 1, 'admin', 'Toggle Product Status', 'Mengubah status produk Creatine Monohydrate dari nonaktif menjadi aktif', '2026-02-20 20:31:01', '2026-02-20 20:31:01'),
(14, 2, 'kasir', 'Create Transaction', 'Pembelian Produk: TRX202602210001 dengan total Rp 75.000', '2026-02-20 20:32:02', '2026-02-20 20:32:02'),
(15, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 21:18:29', '2026-02-20 21:18:29'),
(16, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-02-20 21:22:34', '2026-02-20 21:22:34'),
(17, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-02-20 21:27:25', '2026-02-20 21:27:25'),
(18, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-02-20 21:28:06', '2026-02-20 21:28:06'),
(19, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-02-20 21:28:13', '2026-02-20 21:28:13'),
(20, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 1 transaksi hari ini', '2026-02-20 21:28:13', '2026-02-20 21:28:13'),
(21, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-02-20 21:28:21', '2026-02-20 21:28:21'),
(22, 2, 'kasir', 'Create Membership Transaction', 'Transaksi membership baru: TRX-20260221-0001 - Member: salwaafa (MBR-2026-0001)', '2026-02-20 21:29:11', '2026-02-20 21:29:11'),
(23, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-02-20 21:30:11', '2026-02-20 21:30:11'),
(24, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-02-20 21:30:14', '2026-02-20 21:30:14'),
(25, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-02-20 21:50:58', '2026-02-20 21:50:58'),
(26, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-20 21:51:04', '2026-02-20 21:51:04'),
(27, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 1 member, 2 produk', '2026-02-20 21:51:05', '2026-02-20 21:51:05'),
(28, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-02-20 21:51:45', '2026-02-20 21:51:45'),
(29, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-02-20 21:52:43', '2026-02-20 21:52:43'),
(30, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 2 transaksi hari ini', '2026-02-20 21:52:43', '2026-02-20 21:52:43'),
(31, 2, 'kasir', 'View Today Check-ins', 'Kasir melihat daftar check-in hari ini: 0 member', '2026-02-20 21:52:48', '2026-02-20 21:52:48'),
(32, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 21:52:57', '2026-02-20 21:52:57'),
(33, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-02-20 21:53:00', '2026-02-20 21:53:00'),
(34, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 21:53:05', '2026-02-20 21:53:05'),
(35, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 21:53:07', '2026-02-20 21:53:07'),
(36, 2, 'kasir', 'View Today Check-ins', 'Kasir melihat daftar check-in hari ini: 0 member', '2026-02-20 21:53:23', '2026-02-20 21:53:23'),
(37, 2, 'kasir', 'View Today Check-ins', 'Kasir melihat daftar check-in hari ini: 0 member', '2026-02-20 22:02:38', '2026-02-20 22:02:38'),
(38, 2, 'kasir', 'View Today Check-ins', 'Kasir melihat daftar check-in hari ini: 0 member', '2026-02-20 22:02:44', '2026-02-20 22:02:44'),
(39, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 22:02:45', '2026-02-20 22:02:45'),
(40, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 22:02:52', '2026-02-20 22:02:52'),
(41, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 22:07:20', '2026-02-20 22:07:20'),
(42, 2, 'kasir', 'View Today Check-ins', 'Kasir melihat daftar check-in hari ini: 0 member', '2026-02-20 22:07:37', '2026-02-20 22:07:37'),
(43, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 22:07:56', '2026-02-20 22:07:56'),
(44, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-02-20 22:08:07', '2026-02-20 22:08:07'),
(45, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 22:08:25', '2026-02-20 22:08:25'),
(46, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 22:14:29', '2026-02-20 22:14:29'),
(47, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-02-20 22:14:47', '2026-02-20 22:14:47'),
(48, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 22:14:54', '2026-02-20 22:14:54'),
(49, 2, 'kasir', 'Search Member', 'Kasir mencari member dengan kata kunci: \"test\" - ditemukan 0 hasil', '2026-02-20 22:16:18', '2026-02-20 22:16:18'),
(50, 2, 'kasir', 'Search Member', 'Kasir mencari member dengan kata kunci: \"test\" - ditemukan 0 hasil', '2026-02-20 22:20:14', '2026-02-20 22:20:14'),
(51, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 22:20:19', '2026-02-20 22:20:19'),
(52, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 22:22:42', '2026-02-20 22:22:42'),
(53, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 22:23:48', '2026-02-20 22:23:48'),
(54, 2, 'kasir', 'View Today Check-ins', 'Kasir melihat daftar check-in hari ini: 0 member', '2026-02-20 22:24:02', '2026-02-20 22:24:02'),
(55, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 2 transaksi hari ini', '2026-02-20 22:24:23', '2026-02-20 22:24:23'),
(56, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-02-20 22:24:39', '2026-02-20 22:24:39'),
(57, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-02-20 22:24:44', '2026-02-20 22:24:44'),
(58, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 2 transaksi hari ini', '2026-02-20 22:24:45', '2026-02-20 22:24:45'),
(59, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 22:25:45', '2026-02-20 22:25:45'),
(60, 2, 'kasir', 'View Today Check-ins', 'Kasir melihat daftar check-in hari ini: 0 member', '2026-02-20 22:25:48', '2026-02-20 22:25:48'),
(61, 2, 'kasir', 'View Today Check-ins', 'Kasir melihat daftar check-in hari ini: 0 member', '2026-02-20 22:38:57', '2026-02-20 22:38:57'),
(62, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 22:39:01', '2026-02-20 22:39:01'),
(63, 2, 'kasir', 'View Today Check-ins', 'Kasir melihat daftar check-in hari ini: 0 member', '2026-02-20 22:39:19', '2026-02-20 22:39:19'),
(64, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 22:39:21', '2026-02-20 22:39:21'),
(65, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-02-20 22:39:30', '2026-02-20 22:39:30'),
(66, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 22:39:45', '2026-02-20 22:39:45'),
(67, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-20 23:40:28', '2026-02-20 23:40:28'),
(68, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-02-20 23:40:45', '2026-02-20 23:40:45'),
(69, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-02-20 23:40:59', '2026-02-20 23:40:59'),
(70, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-02-20 23:41:00', '2026-02-20 23:41:00'),
(71, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 22/01/2026 - 21/02/2026', '2026-02-20 23:41:38', '2026-02-20 23:41:38'),
(72, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-02-20 23:43:29', '2026-02-20 23:43:29'),
(73, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-02-20 23:43:34', '2026-02-20 23:43:34'),
(74, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 2 transaksi hari ini', '2026-02-20 23:43:35', '2026-02-20 23:43:35'),
(75, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-02-20 23:44:01', '2026-02-20 23:44:01'),
(76, 2, 'kasir', 'Create Transaction', 'Pembelian Produk: TRX202602210002 dengan total Rp 140.000', '2026-02-20 23:44:30', '2026-02-20 23:44:30'),
(77, 2, 'kasir', 'Create Transaction', 'Visit: TRX202602210003 dengan total Rp 25.000', '2026-02-20 23:45:00', '2026-02-20 23:45:00'),
(78, 2, 'kasir', 'Create Transaction', 'Produk + Visit: TRX202602210004 dengan total Rp 35.000', '2026-02-20 23:45:32', '2026-02-20 23:45:32'),
(79, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-02-20 23:45:52', '2026-02-20 23:45:52'),
(80, 2, 'kasir', 'Create Membership Transaction', 'Transaksi membership baru: TRX-20260221-0002 - Member: asep ganteng (MBR-2026-0002)', '2026-02-20 23:47:05', '2026-02-20 23:47:05'),
(81, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-02-20 23:51:21', '2026-02-20 23:51:21'),
(82, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-22 09:18:31', '2026-02-22 09:18:31'),
(83, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-22 09:18:33', '2026-02-22 09:18:33'),
(84, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-22 17:08:52', '2026-02-22 17:08:52'),
(85, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-22 17:08:53', '2026-02-22 17:08:53'),
(86, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-02-22 17:10:32', '2026-02-22 17:10:32'),
(87, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-02-22 17:10:34', '2026-02-22 17:10:34'),
(88, 2, 'kasir', 'View Today Check-ins', 'Kasir melihat daftar check-in hari ini: 0 member', '2026-02-22 17:10:55', '2026-02-22 17:10:55'),
(89, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-02-22 17:11:03', '2026-02-22 17:11:03'),
(90, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-02-22 17:12:12', '2026-02-22 17:12:12'),
(91, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-23 05:13:44', '2026-02-23 05:13:44'),
(92, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-23 05:13:46', '2026-02-23 05:13:46'),
(93, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-23 05:13:59', '2026-02-23 05:13:59'),
(94, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-23 05:57:50', '2026-02-23 05:57:50'),
(95, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-23 05:57:57', '2026-02-23 05:57:57'),
(96, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-02-23 06:22:09', '2026-02-23 06:22:09'),
(97, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-02-23 06:22:17', '2026-02-23 06:22:17'),
(98, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-02-23 06:22:18', '2026-02-23 06:22:18'),
(99, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-02-23 06:22:29', '2026-02-23 06:22:29'),
(100, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-23 06:22:34', '2026-02-23 06:22:34'),
(101, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-23 06:22:36', '2026-02-23 06:22:36'),
(102, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-24 06:02:22', '2026-02-24 06:02:22'),
(103, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-24 06:02:24', '2026-02-24 06:02:24'),
(104, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-24 19:53:07', '2026-02-24 19:53:07'),
(105, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-24 19:53:11', '2026-02-24 19:53:11'),
(106, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-02-24 20:02:00', '2026-02-24 20:02:00'),
(107, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-02-24 20:02:01', '2026-02-24 20:02:01'),
(108, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-02-24 20:02:40', '2026-02-24 20:02:40'),
(109, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-02-24 20:02:41', '2026-02-24 20:02:41'),
(110, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-24 20:05:16', '2026-02-24 20:05:16'),
(111, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 26/01/2026 - 25/02/2026', '2026-02-24 20:07:31', '2026-02-24 20:07:31'),
(112, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-02-24 20:25:53', '2026-02-24 20:25:53'),
(113, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-24 20:31:59', '2026-02-24 20:31:59'),
(114, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-24 20:32:01', '2026-02-24 20:32:01'),
(115, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-02-24 20:32:03', '2026-02-24 20:32:03'),
(116, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-02-24 20:32:07', '2026-02-24 20:32:07'),
(117, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 26/01/2026 - 25/02/2026', '2026-02-24 20:32:15', '2026-02-24 20:32:15'),
(118, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-02-24 20:35:30', '2026-02-24 20:35:30'),
(119, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-02-24 20:47:17', '2026-02-24 20:47:17'),
(120, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-02-24 20:50:33', '2026-02-24 20:50:33'),
(121, 2, 'kasir', 'View Today Check-ins', 'Kasir melihat daftar check-in hari ini: 0 member', '2026-02-24 21:03:13', '2026-02-24 21:03:13'),
(122, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-24 21:03:18', '2026-02-24 21:03:18'),
(123, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-02-24 21:03:21', '2026-02-24 21:03:21'),
(124, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-02-24 21:04:42', '2026-02-24 21:04:42'),
(125, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-02-24 21:11:06', '2026-02-24 21:11:06'),
(126, 2, 'kasir', 'View Today Check-ins', 'Kasir melihat daftar check-in hari ini: 0 member', '2026-02-24 21:11:09', '2026-02-24 21:11:09'),
(127, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-02-24 21:11:11', '2026-02-24 21:11:11'),
(128, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-02-24 21:15:41', '2026-02-24 21:15:41'),
(129, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-02-24 21:15:46', '2026-02-24 21:15:46'),
(130, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-25 05:27:35', '2026-02-25 05:27:35'),
(131, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-25 05:27:40', '2026-02-25 05:27:40'),
(132, 1, 'admin', 'Update User', 'Mengupdate user: asep ganteng', '2026-02-25 05:28:35', '2026-02-25 05:28:35'),
(133, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-02-25 05:28:46', '2026-02-25 05:28:46'),
(134, 4, 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-25 05:28:51', '2026-02-25 05:28:51'),
(135, 4, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-25 05:28:51', '2026-02-25 05:28:51'),
(136, 4, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-25 05:29:11', '2026-02-25 05:29:11'),
(137, 4, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-25 09:20:31', '2026-02-25 09:20:31'),
(138, 4, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-25 09:20:33', '2026-02-25 09:20:33'),
(139, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-25 17:37:31', '2026-02-25 17:37:31'),
(140, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-25 17:37:32', '2026-02-25 17:37:32'),
(141, 1, 'admin', 'Update Membership Package', 'Mengupdate paket membership: 1 de', '2026-02-25 17:54:21', '2026-02-25 17:54:21'),
(142, 1, 'admin', 'Update Membership Package', 'Mengupdate paket membership: 1 bulan', '2026-02-25 17:54:37', '2026-02-25 17:54:37'),
(143, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-25 17:54:55', '2026-02-25 17:54:55'),
(144, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-25 17:55:33', '2026-02-25 17:55:33'),
(145, 1, 'admin', 'Stock Masuk', 'Menambah stok Creatine Monohydrate sebanyak 100 pcs. Keterangan: restock', '2026-02-25 18:17:46', '2026-02-25 18:17:46'),
(146, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-25 18:18:34', '2026-02-25 18:18:34'),
(147, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-25 18:19:52', '2026-02-25 18:19:52'),
(148, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-02-25 18:20:07', '2026-02-25 18:20:07'),
(149, 1, 'admin', 'Create Category', 'Menambahkan kategori baru: dessert', '2026-02-25 18:21:07', '2026-02-25 18:21:07'),
(150, 1, 'admin', 'Create Product', 'Menambahkan produk baru: kue', '2026-02-25 18:21:57', '2026-02-25 18:21:57'),
(151, 1, 'admin', 'Toggle Product Status', 'Mengubah status produk Creatine Monohydrate dari aktif menjadi nonaktif', '2026-02-25 18:22:08', '2026-02-25 18:22:08'),
(152, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-02-25 18:24:00', '2026-02-25 18:24:00'),
(153, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-02-25 18:24:01', '2026-02-25 18:24:01'),
(154, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 27/01/2026 - 26/02/2026', '2026-02-25 18:25:34', '2026-02-25 18:25:34'),
(155, 3, 'owner', 'View Transaction Detail', 'Owner melihat detail transaksi: TRX-20260221-0002', '2026-02-25 18:39:01', '2026-02-25 18:39:01'),
(156, 3, 'owner', 'View Transaction Detail', 'Owner melihat detail transaksi: TRX-20260221-0002', '2026-02-25 18:41:02', '2026-02-25 18:41:02'),
(157, 3, 'owner', 'View Transaction Detail', 'Owner melihat detail transaksi: TRX202602210002', '2026-02-25 18:41:16', '2026-02-25 18:41:16'),
(158, 3, 'owner', 'View Transaction Detail', 'Owner melihat detail transaksi: TRX202602210004', '2026-02-25 18:41:27', '2026-02-25 18:41:27'),
(159, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 27/01/2026 - 26/02/2026', '2026-02-25 18:42:44', '2026-02-25 18:42:44'),
(160, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 27/01/2026 - 26/02/2026', '2026-02-25 20:31:10', '2026-02-25 20:31:10'),
(161, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 27/01/2026 - 26/02/2026', '2026-02-25 20:31:15', '2026-02-25 20:31:15'),
(162, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-25 20:56:35', '2026-02-25 20:56:35'),
(163, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 3 produk', '2026-02-25 20:56:35', '2026-02-25 20:56:35'),
(164, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-28 15:19:07', '2026-02-28 15:19:07'),
(165, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 3 produk', '2026-02-28 15:19:09', '2026-02-28 15:19:09'),
(166, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 3 produk', '2026-02-28 15:28:17', '2026-02-28 15:28:17'),
(167, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 3 produk', '2026-02-28 15:28:20', '2026-02-28 15:28:20'),
(168, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-02-28 20:28:24', '2026-02-28 20:28:24'),
(169, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 3 produk', '2026-02-28 20:28:27', '2026-02-28 20:28:27'),
(170, 1, 'admin', 'Toggle Package Status', 'Mengubah status paket 1 bulan dari aktif menjadi nonaktif', '2026-02-28 20:40:48', '2026-02-28 20:40:48'),
(171, 1, 'admin', 'Toggle Package Status', 'Mengubah status paket 1 bulan dari nonaktif menjadi aktif', '2026-02-28 20:40:54', '2026-02-28 20:40:54'),
(172, 1, 'admin', 'Create Membership Package', 'Menambahkan paket membership: 2 bulan', '2026-02-28 20:41:23', '2026-02-28 20:41:23'),
(173, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-04 06:57:11', '2026-03-04 06:57:11'),
(174, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 3 produk', '2026-03-04 06:57:22', '2026-03-04 06:57:22'),
(175, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 3 produk', '2026-03-04 14:04:06', '2026-03-04 14:04:06'),
(176, 1, 'admin', 'Create Category', 'Menambahkan kategori baru: aaaaa', '2026-03-04 14:05:11', '2026-03-04 14:05:11'),
(177, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-04 14:05:52', '2026-03-04 14:05:52'),
(178, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-04 14:05:53', '2026-03-04 14:05:53'),
(179, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-03-04 14:06:31', '2026-03-04 14:06:31'),
(180, 2, 'kasir', 'Create Membership Transaction', 'Transaksi membership baru: TRX-20260304-0001 - Member: sffsddaffa (MBR-2026-0003)', '2026-03-04 14:07:33', '2026-03-04 14:07:33'),
(181, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-03-04 14:11:37', '2026-03-04 14:11:37'),
(182, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-03-04 14:11:41', '2026-03-04 14:11:41'),
(183, 1, 'admin', 'Update Member', 'Admin mengupdate data member: asep ganteng (MBR-2026-0002). Perubahan pada: telepon, tanggal expired', '2026-03-04 14:25:17', '2026-03-04 14:25:17'),
(184, 1, 'admin', 'Toggle Member Status', 'Admin mengubah status member asep ganteng (MBR-2026-0002) dari active menjadi expired', '2026-03-04 14:25:57', '2026-03-04 14:25:57'),
(185, 2, 'kasir', 'View Today Check-ins', 'Kasir melihat daftar check-in hari ini: 0 member', '2026-03-04 14:41:44', '2026-03-04 14:41:44'),
(186, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-03-04 14:42:07', '2026-03-04 14:42:07'),
(187, 1, 'admin', 'Toggle Member Status', 'Admin mengubah status member asep ganteng (MBR-2026-0002) dari expired menjadi active', '2026-03-04 14:42:55', '2026-03-04 14:42:55'),
(188, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-03-04 14:43:00', '2026-03-04 14:43:00'),
(189, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-05 04:43:51', '2026-03-05 04:43:51'),
(190, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-05 04:43:54', '2026-03-05 04:43:54'),
(191, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-05 05:01:37', '2026-03-05 05:01:37'),
(192, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-05 05:03:17', '2026-03-05 05:03:17'),
(193, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-05 05:03:17', '2026-03-05 05:03:17'),
(194, 2, 'kasir', 'View Today Check-ins', 'Kasir melihat daftar check-in hari ini: 0 member', '2026-03-05 05:03:26', '2026-03-05 05:03:26'),
(195, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-03-05 05:03:31', '2026-03-05 05:03:31'),
(196, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-05 05:04:14', '2026-03-05 05:04:14'),
(197, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-05 05:04:15', '2026-03-05 05:04:15'),
(198, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-03-05 05:04:27', '2026-03-05 05:04:27'),
(199, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-03-05 05:04:47', '2026-03-05 05:04:47'),
(200, 1, 'admin', 'Create User', 'Menambahkan user baru: asasaksakas', '2026-03-05 05:05:29', '2026-03-05 05:05:29'),
(201, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-03-05 05:05:39', '2026-03-05 05:05:39'),
(202, 5, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-05 05:05:53', '2026-03-31 21:16:51'),
(203, 5, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-05 05:05:54', '2026-03-31 21:16:51'),
(204, 5, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-03-05 05:06:02', '2026-03-31 21:16:51'),
(205, 5, 'kasir', 'View Today Check-ins', 'Kasir melihat daftar check-in hari ini: 0 member', '2026-03-05 05:06:04', '2026-03-31 21:16:51'),
(206, 5, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-03-05 05:06:11', '2026-03-31 21:16:51'),
(207, 1, 'admin', 'Toggle User Status', 'Mengubah status user asasaksakas dari aktif menjadi nonaktif', '2026-03-05 05:06:32', '2026-03-05 05:06:32'),
(208, 5, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-03-05 05:06:38', '2026-03-31 21:16:51'),
(209, 5, 'kasir', 'Logout', 'User logout dari sistem', '2026-03-05 05:06:43', '2026-03-31 21:16:51'),
(210, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-05 05:32:19', '2026-03-05 05:32:19'),
(211, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-05 05:32:20', '2026-03-05 05:32:20'),
(212, 2, 'kasir', 'View Today Check-ins', 'Kasir melihat daftar check-in hari ini: 0 member', '2026-03-05 05:32:25', '2026-03-05 05:32:25'),
(213, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-03-05 05:32:41', '2026-03-05 05:32:41'),
(214, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-03-05 05:56:04', '2026-03-05 05:56:04'),
(215, 2, 'kasir', 'View Check-in Page', 'Kasir membuka halaman check-in member', '2026-03-05 05:56:13', '2026-03-05 05:56:13'),
(216, 2, 'kasir', 'View Check-in Page', 'Kasir membuka halaman check-in member', '2026-03-05 05:56:21', '2026-03-05 05:56:21'),
(217, 2, 'kasir', 'Open Member Check', 'Kasir membuka halaman cek member', '2026-03-05 05:57:37', '2026-03-05 05:57:37'),
(218, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-06 04:14:22', '2026-03-06 04:14:22'),
(219, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-06 04:14:23', '2026-03-06 04:14:23'),
(220, 1, 'admin', 'Toggle Member Status', 'Admin mengubah status member asep ganteng (MBR-2026-0002) dari active menjadi expired', '2026-03-06 04:15:58', '2026-03-06 04:15:58'),
(221, 1, 'admin', 'Update Member', 'Admin mengupdate data member: salwaafa (MBR-2026-0001)', '2026-03-06 04:39:42', '2026-03-06 04:39:42'),
(222, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-07 02:33:45', '2026-03-07 02:33:45'),
(223, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-07 02:33:48', '2026-03-07 02:33:48'),
(224, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-03-07 03:02:59', '2026-03-07 03:02:59'),
(225, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-03-07 03:03:45', '2026-03-07 03:03:45'),
(226, 1, 'admin', 'Update Gym Settings', 'Admin mengupdate pengaturan gym (harga visit: Rp 25.000, nama gym: TraxFit Gym)', '2026-03-07 03:04:04', '2026-03-07 03:04:04'),
(227, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-03-07 03:04:05', '2026-03-07 03:04:05'),
(228, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-03-07 03:04:27', '2026-03-07 03:04:27'),
(229, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-07 05:02:32', '2026-03-07 05:02:32'),
(230, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-07 05:02:35', '2026-03-07 05:02:35'),
(231, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-03-07 05:03:49', '2026-03-07 05:03:49'),
(232, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-07 05:03:56', '2026-03-07 05:03:56'),
(233, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-07 05:03:57', '2026-03-07 05:03:57'),
(234, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-07 06:11:47', '2026-03-07 06:11:47'),
(235, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-08 02:35:24', '2026-03-08 02:35:24'),
(236, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-08 02:35:29', '2026-03-08 02:35:29'),
(237, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-03-08 02:36:42', '2026-03-08 02:36:42'),
(238, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-03-08 04:21:22', '2026-03-08 04:21:22'),
(239, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-08 04:21:31', '2026-03-08 04:21:31'),
(240, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-08 04:21:32', '2026-03-08 04:21:32'),
(241, 1, 'admin', 'Toggle Product Status', 'Mengubah status produk Creatine Monohydrate dari nonaktif menjadi aktif', '2026-03-08 04:21:43', '2026-03-08 04:21:43'),
(242, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-03-08 04:21:50', '2026-03-08 04:21:50'),
(243, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-08 04:21:56', '2026-03-08 04:21:56'),
(244, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-08 04:21:57', '2026-03-08 04:21:57'),
(245, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-08 04:43:46', '2026-03-08 04:43:46'),
(246, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-09 00:37:59', '2026-03-09 00:37:59'),
(247, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-09 00:38:02', '2026-03-09 00:38:02'),
(248, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-09 00:48:02', '2026-03-09 00:48:02'),
(249, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-03-09 00:48:57', '2026-03-09 00:48:57'),
(250, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-09 00:49:07', '2026-03-09 00:49:07'),
(251, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-09 00:49:08', '2026-03-09 00:49:08'),
(252, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-03-09 00:49:27', '2026-03-09 00:49:27'),
(253, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-03-09 00:50:01', '2026-03-09 00:50:01'),
(254, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-03-09 00:50:07', '2026-03-09 00:50:07'),
(255, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-03-09 00:52:02', '2026-03-09 00:52:02'),
(256, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-09 00:52:09', '2026-03-09 00:52:09'),
(257, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-09 00:52:10', '2026-03-09 00:52:10'),
(258, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 07/02/2026 - 09/03/2026', '2026-03-09 00:52:38', '2026-03-09 00:52:38'),
(259, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 07/02/2026 - 09/03/2026', '2026-03-09 00:52:53', '2026-03-09 00:52:53'),
(260, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-03-09 00:53:18', '2026-03-09 00:53:18'),
(261, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-09 00:53:25', '2026-03-09 00:53:25'),
(262, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-09 00:53:26', '2026-03-09 00:53:26'),
(263, 1, 'admin', 'Toggle Package Status', 'Mengubah status paket 2 bulan dari aktif menjadi nonaktif', '2026-03-09 00:59:43', '2026-03-09 00:59:43'),
(264, 1, 'admin', 'Toggle Package Status', 'Mengubah status paket 2 bulan dari nonaktif menjadi aktif', '2026-03-09 00:59:46', '2026-03-09 00:59:46'),
(265, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-03-09 01:21:28', '2026-03-09 01:21:28'),
(266, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-03-09 01:31:45', '2026-03-09 01:31:45'),
(267, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-03-09 01:32:33', '2026-03-09 01:32:33'),
(268, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-09 01:32:39', '2026-03-09 01:32:39'),
(269, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-09 01:32:40', '2026-03-09 01:32:40'),
(270, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-03-09 01:33:18', '2026-03-09 01:33:18'),
(271, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-09 01:33:24', '2026-03-09 01:33:24'),
(272, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-09 01:33:25', '2026-03-09 01:33:25'),
(273, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 07/02/2026 - 09/03/2026', '2026-03-09 01:33:41', '2026-03-09 01:33:41'),
(274, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-03-09 02:59:58', '2026-03-09 02:59:58'),
(275, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-09 13:24:25', '2026-03-09 13:24:25'),
(276, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-09 13:24:27', '2026-03-09 13:24:27'),
(277, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-03-09 13:26:23', '2026-03-09 13:26:23'),
(278, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-03-09 13:28:30', '2026-03-09 13:28:30'),
(279, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-03-09 13:28:42', '2026-03-09 13:28:42'),
(280, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-03-09 13:28:48', '2026-03-09 13:28:48'),
(281, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi pencarian \"asep\"', '2026-03-09 13:33:31', '2026-03-09 13:33:31'),
(282, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-03-09 13:33:48', '2026-03-09 13:33:48'),
(283, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-03-09 13:36:01', '2026-03-09 13:36:01'),
(284, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-03-09 13:51:33', '2026-03-09 13:51:33'),
(285, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-03-09 14:08:01', '2026-03-09 14:08:01'),
(286, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-03-09 14:08:04', '2026-03-09 14:08:04'),
(287, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-03-09 14:31:47', '2026-03-09 14:31:47'),
(288, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-09 14:32:08', '2026-03-09 14:32:08'),
(289, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-09 14:32:09', '2026-03-09 14:32:09'),
(290, 3, 'owner', 'View Transaction Detail', 'Owner melihat detail transaksi: TRX-20260221-0002', '2026-03-09 14:34:52', '2026-03-09 14:34:52'),
(291, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-09 23:43:58', '2026-03-09 23:43:58'),
(292, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-09 23:44:00', '2026-03-09 23:44:00'),
(293, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 08/02/2026 - 10/03/2026', '2026-03-09 23:45:03', '2026-03-09 23:45:03'),
(294, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-10 00:45:32', '2026-03-10 00:45:32'),
(295, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-03-10 00:50:52', '2026-03-10 00:50:52'),
(296, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-10 00:55:33', '2026-03-10 00:55:33'),
(297, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-10 00:55:36', '2026-03-10 00:55:36'),
(298, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-10 00:55:54', '2026-03-10 00:55:54'),
(299, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-10 00:55:56', '2026-03-10 00:55:56'),
(300, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-10 00:56:26', '2026-03-10 00:56:26'),
(301, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-10 00:58:19', '2026-03-10 00:58:19'),
(302, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-10 01:03:15', '2026-03-10 01:03:15'),
(303, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-10 01:06:28', '2026-03-10 01:06:28'),
(304, 3, 'owner', 'View Transaction Detail', 'Owner melihat detail transaksi: TRX202602210004', '2026-03-10 01:07:37', '2026-03-10 01:07:37'),
(305, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-03-10 01:25:13', '2026-03-10 01:25:13'),
(306, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-10 01:25:22', '2026-03-10 01:25:22'),
(307, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-10 01:25:23', '2026-03-10 01:25:23'),
(308, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-10 01:26:08', '2026-03-10 01:26:08'),
(309, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-10 01:26:09', '2026-03-10 01:26:09'),
(310, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-10 23:58:28', '2026-03-10 23:58:28'),
(311, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-10 23:58:29', '2026-03-10 23:58:29'),
(312, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-10 23:59:40', '2026-03-10 23:59:40'),
(313, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-11 00:01:25', '2026-03-11 00:01:25'),
(314, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-03-11 00:01:29', '2026-03-11 00:01:29'),
(315, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-11 00:02:19', '2026-03-11 00:02:19'),
(316, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-11 00:02:21', '2026-03-11 00:02:21'),
(317, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-11 00:10:06', '2026-03-11 00:10:06'),
(318, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-03-11 00:10:18', '2026-03-11 00:10:18'),
(319, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-11 00:10:25', '2026-03-11 00:10:25'),
(320, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-11 00:10:26', '2026-03-11 00:10:26'),
(321, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 02:32:28', '2026-03-11 02:32:28'),
(322, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 02:38:55', '2026-03-11 02:38:55'),
(323, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 02:39:19', '2026-03-11 02:39:19'),
(324, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 02:39:25', '2026-03-11 02:39:25'),
(325, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 02:39:45', '2026-03-11 02:39:45'),
(326, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 02:39:50', '2026-03-11 02:39:50'),
(327, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 02:41:02', '2026-03-11 02:41:02'),
(328, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 02:41:10', '2026-03-11 02:41:10'),
(329, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 02:41:46', '2026-03-11 02:41:46'),
(330, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 02:43:42', '2026-03-11 02:43:42'),
(331, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-11 02:55:02', '2026-03-11 02:55:02'),
(332, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-03-11 02:55:09', '2026-03-11 02:55:09'),
(333, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-11 02:56:03', '2026-03-11 02:56:03'),
(334, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-11 02:56:04', '2026-03-11 02:56:04'),
(335, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-11 03:05:39', '2026-03-11 03:05:39'),
(336, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-11 03:07:52', '2026-03-11 03:07:52'),
(337, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-11 03:08:24', '2026-03-11 03:08:24'),
(338, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-03-11 03:11:09', '2026-03-11 03:11:09'),
(339, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-11 03:11:15', '2026-03-11 03:11:15'),
(340, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-11 03:11:15', '2026-03-11 03:11:15'),
(341, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-03-11 03:15:53', '2026-03-11 03:15:53'),
(342, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-11 03:17:44', '2026-03-11 03:17:44'),
(343, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-11 03:17:46', '2026-03-11 03:17:46'),
(344, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-03-11 03:20:36', '2026-03-11 03:20:36'),
(345, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-11 03:24:04', '2026-03-11 03:24:04'),
(346, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-03-11 03:24:32', '2026-03-11 03:24:32'),
(347, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-11 03:24:39', '2026-03-11 03:24:39'),
(348, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-11 03:24:40', '2026-03-11 03:24:40'),
(349, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-03-11 03:25:10', '2026-03-11 03:25:10'),
(350, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-11 03:25:16', '2026-03-11 03:25:16'),
(351, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-11 03:25:17', '2026-03-11 03:25:17'),
(352, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-11 03:35:06', '2026-03-11 03:35:06'),
(353, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-11 03:37:17', '2026-03-11 03:37:17'),
(354, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-03-11 05:04:09', '2026-03-11 05:04:09'),
(355, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-11 05:04:24', '2026-03-11 05:04:24'),
(356, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-11 05:04:25', '2026-03-11 05:04:25'),
(357, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-03-11 05:04:39', '2026-03-11 05:04:39'),
(358, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-11 05:06:49', '2026-03-11 05:06:49'),
(359, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-03-11 05:06:54', '2026-03-11 05:06:54'),
(360, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-11 05:07:00', '2026-03-11 05:07:00'),
(361, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-11 05:07:01', '2026-03-11 05:07:01'),
(362, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 05:07:08', '2026-03-11 05:07:08'),
(363, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 05:07:33', '2026-03-11 05:07:33'),
(364, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 05:08:21', '2026-03-11 05:08:21'),
(365, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 05:18:58', '2026-03-11 05:18:58'),
(366, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-11 11:52:36', '2026-03-11 11:52:36'),
(367, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-11 11:52:36', '2026-03-11 11:52:36'),
(368, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 13:51:17', '2026-03-11 13:51:17'),
(369, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 14:17:17', '2026-03-11 14:17:17'),
(370, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 09/02/2026 - 11/03/2026', '2026-03-11 14:58:43', '2026-03-11 14:58:43'),
(371, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-11 23:21:17', '2026-03-11 23:21:17'),
(372, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-11 23:21:19', '2026-03-11 23:21:19'),
(373, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-03-11 23:49:09', '2026-03-11 23:49:09'),
(374, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-11 23:49:25', '2026-03-11 23:49:25'),
(375, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-11 23:49:26', '2026-03-11 23:49:26'),
(376, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-03-11 23:50:05', '2026-03-11 23:50:05'),
(377, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-11 23:50:11', '2026-03-11 23:50:11'),
(378, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-11 23:50:12', '2026-03-11 23:50:12'),
(379, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-12 00:49:15', '2026-03-12 00:49:15'),
(380, 3, 'owner', 'View Transaction Detail', 'Owner melihat detail transaksi: TRX-20260304-0001', '2026-03-12 00:51:59', '2026-03-12 00:51:59'),
(381, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-12 01:02:31', '2026-03-12 01:02:31'),
(382, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-03-12 02:33:33', '2026-03-12 02:33:33'),
(383, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-12 02:33:40', '2026-03-12 02:33:40'),
(384, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-12 02:33:41', '2026-03-12 02:33:41'),
(385, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-12 03:23:19', '2026-03-12 03:23:19'),
(386, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-03-12 03:23:25', '2026-03-12 03:23:25'),
(387, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-12 03:23:31', '2026-03-12 03:23:31'),
(388, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-12 03:23:32', '2026-03-12 03:23:32'),
(389, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-03-12 03:40:36', '2026-03-12 03:40:36'),
(390, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-12 03:40:43', '2026-03-12 03:40:43'),
(391, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-12 03:40:45', '2026-03-12 03:40:45'),
(392, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-12 21:45:11', '2026-03-12 21:45:11');
INSERT INTO `log` (`id`, `id_user`, `role_user`, `activity`, `keterangan`, `created_at`, `updated_at`) VALUES
(393, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-12 21:45:18', '2026-03-12 21:45:18'),
(394, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-12 21:45:53', '2026-03-12 21:45:53'),
(395, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-03-12 22:06:45', '2026-03-12 22:06:45'),
(396, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-03-12 22:46:34', '2026-03-12 22:46:34'),
(397, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-12 22:46:42', '2026-03-12 22:46:42'),
(398, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-12 22:46:43', '2026-03-12 22:46:43'),
(399, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-12 22:46:55', '2026-03-12 22:46:55'),
(400, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-12 23:24:06', '2026-03-12 23:24:06'),
(401, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-03-12 23:25:37', '2026-03-12 23:25:37'),
(402, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-12 23:25:56', '2026-03-12 23:25:56'),
(403, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-12 23:25:58', '2026-03-12 23:25:58'),
(404, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-03-13 00:01:30', '2026-03-13 00:01:30'),
(405, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-13 00:01:36', '2026-03-13 00:01:36'),
(406, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-13 00:01:37', '2026-03-13 00:01:37'),
(407, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-03-13 00:29:13', '2026-03-13 00:29:13'),
(408, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-03-13 00:35:24', '2026-03-13 00:35:24'),
(409, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-03-13 00:40:05', '2026-03-13 00:40:05'),
(410, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-03-13 00:40:40', '2026-03-13 00:40:40'),
(411, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-03-13 00:40:45', '2026-03-13 00:40:45'),
(412, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-03-13 00:41:42', '2026-03-13 00:41:42'),
(413, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-03-13 00:42:56', '2026-03-13 00:42:56'),
(414, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-13 00:46:59', '2026-03-13 00:46:59'),
(415, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-03-13 00:49:52', '2026-03-13 00:49:52'),
(416, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-03-13 00:55:16', '2026-03-13 00:55:16'),
(417, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-13 00:55:38', '2026-03-13 00:55:38'),
(418, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-13 00:55:39', '2026-03-13 00:55:39'),
(419, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 11/02/2026 - 13/03/2026', '2026-03-13 01:06:19', '2026-03-13 01:06:19'),
(420, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-13 01:14:14', '2026-03-13 01:14:14'),
(421, 3, 'owner', 'View Transaction Detail', 'Owner melihat detail transaksi: TRX-20260304-0001', '2026-03-13 01:15:59', '2026-03-13 01:15:59'),
(422, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 11/02/2026 - 13/03/2026', '2026-03-13 01:17:33', '2026-03-13 01:17:33'),
(423, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 11/02/2026 - 13/03/2026', '2026-03-13 01:21:04', '2026-03-13 01:21:04'),
(424, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-28 00:35:53', '2026-03-28 00:35:53'),
(425, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-28 00:35:58', '2026-03-28 00:35:58'),
(426, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-28 01:03:34', '2026-03-28 01:03:34'),
(427, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-28 01:03:36', '2026-03-28 01:03:36'),
(428, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-28 01:04:03', '2026-03-28 01:04:03'),
(429, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-28 01:04:04', '2026-03-28 01:04:04'),
(430, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-03-28 01:08:09', '2026-03-28 01:08:09'),
(431, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-28 01:09:49', '2026-03-28 01:09:49'),
(432, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-28 01:10:13', '2026-03-28 01:10:13'),
(433, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-28 01:11:03', '2026-03-28 01:11:03'),
(434, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-28 01:17:52', '2026-03-28 01:17:52'),
(435, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-28 01:27:33', '2026-03-28 01:27:33'),
(436, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-03-28 01:30:36', '2026-03-28 01:30:36'),
(437, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-29 10:52:14', '2026-03-29 10:52:14'),
(438, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-29 10:52:16', '2026-03-29 10:52:16'),
(439, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-30 01:55:45', '2026-03-30 01:55:45'),
(440, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-30 01:55:47', '2026-03-30 01:55:47'),
(441, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-30 02:03:30', '2026-03-30 02:03:30'),
(442, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-03-30 02:04:59', '2026-03-30 02:04:59'),
(443, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-30 02:05:28', '2026-03-30 02:05:28'),
(444, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-30 02:05:32', '2026-03-30 02:05:32'),
(445, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-03-30 02:58:32', '2026-03-30 02:58:32'),
(446, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-03-30 02:58:38', '2026-03-30 02:58:38'),
(447, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-03-30 02:58:39', '2026-03-30 02:58:39'),
(448, 2, 'kasir', 'Create Transaction', 'Produk + Visit: TRX202603300001 dengan total Rp 90.000', '2026-03-30 02:59:44', '2026-03-30 02:59:44'),
(449, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 1 transaksi hari ini', '2026-03-30 03:11:20', '2026-03-30 03:11:20'),
(450, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 1 transaksi hari ini', '2026-03-30 03:11:34', '2026-03-30 03:11:34'),
(451, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-03-30 03:11:38', '2026-03-30 03:11:38'),
(452, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-30 14:14:40', '2026-03-30 14:14:40'),
(453, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-30 14:14:42', '2026-03-30 14:14:42'),
(454, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 28/02/2026 - 30/03/2026', '2026-03-30 14:56:47', '2026-03-30 14:56:47'),
(455, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-30 23:20:05', '2026-03-30 23:20:05'),
(456, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-30 23:20:08', '2026-03-30 23:20:08'),
(457, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 01/03/2026 - 31/03/2026', '2026-03-30 23:20:33', '2026-03-30 23:20:33'),
(458, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 01/03/2026 - 31/03/2026', '2026-03-30 23:21:04', '2026-03-30 23:21:04'),
(459, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 01/03/2026 - 31/03/2026', '2026-03-30 23:53:12', '2026-03-30 23:53:12'),
(460, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 01/03/2026 - 31/03/2026', '2026-03-31 00:16:33', '2026-03-31 00:16:33'),
(461, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 01/03/2026 - 31/03/2026', '2026-03-31 00:27:05', '2026-03-31 00:27:05'),
(462, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-31 00:32:46', '2026-03-31 00:32:46'),
(463, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-31 21:02:03', '2026-03-31 21:02:03'),
(464, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-31 21:02:05', '2026-03-31 21:02:05'),
(465, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 02/03/2026 - 01/04/2026', '2026-03-31 21:02:27', '2026-03-31 21:02:27'),
(466, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 02/03/2026 - 01/04/2026', '2026-03-31 21:02:37', '2026-03-31 21:02:37'),
(467, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 02/03/2026 - 01/04/2026', '2026-03-31 21:03:24', '2026-03-31 21:03:24'),
(468, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 02/03/2026 - 01/04/2026', '2026-03-31 21:03:35', '2026-03-31 21:03:35'),
(469, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 02/03/2026 - 01/04/2026', '2026-03-31 21:03:58', '2026-03-31 21:03:58'),
(470, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-03-31 21:06:42', '2026-03-31 21:06:42'),
(471, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-31 21:06:51', '2026-03-31 21:06:51'),
(472, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-31 21:06:52', '2026-03-31 21:06:52'),
(473, 1, 'admin', 'Delete User', 'Menghapus user: asasaksakas', '2026-03-31 21:16:51', '2026-03-31 21:16:51'),
(474, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-03-31 21:16:59', '2026-03-31 21:16:59'),
(475, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-03-31 21:17:06', '2026-03-31 21:17:06'),
(476, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-03-31 21:17:07', '2026-03-31 21:17:07'),
(477, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 02/03/2026 - 01/04/2026', '2026-03-31 21:17:15', '2026-03-31 21:17:15'),
(478, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-03-31 21:20:08', '2026-03-31 21:20:08'),
(479, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-03-31 21:20:14', '2026-03-31 21:20:14'),
(480, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-03-31 21:20:15', '2026-03-31 21:20:15'),
(481, 1, 'admin', 'Delete Product', 'Menghapus produk: kue', '2026-03-31 21:20:31', '2026-03-31 21:20:31'),
(482, 1, 'admin', 'Delete Category', 'Menghapus kategori: aaaaa', '2026-03-31 21:20:43', '2026-03-31 21:20:43'),
(483, 1, 'admin', 'Delete Membership Package', 'Menghapus paket membership: 2 bulan', '2026-03-31 21:20:58', '2026-03-31 21:20:58'),
(484, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-01 00:21:37', '2026-04-01 00:21:37'),
(485, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 2 produk', '2026-04-01 00:21:38', '2026-04-01 00:21:38'),
(486, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-01 03:44:57', '2026-04-01 03:44:57'),
(487, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 2 produk', '2026-04-01 03:44:58', '2026-04-01 03:44:58'),
(488, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-04 01:57:21', '2026-04-04 01:57:21'),
(489, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 2 produk', '2026-04-04 01:57:23', '2026-04-04 01:57:23'),
(490, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-05 14:05:43', '2026-04-05 14:05:43'),
(491, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 2 produk', '2026-04-05 14:05:46', '2026-04-05 14:05:46'),
(492, 1, 'admin', 'Delete Member (Soft)', 'Admin menghapus member (soft delete): sffsddaffa (MBR-2026-0003). Member memiliki 1 transaksi.', '2026-04-05 14:07:05', '2026-04-05 14:07:05'),
(493, 1, 'admin', 'Update Member', 'Admin mengupdate data member: asep ganteng (MBR-2026-0002). Perubahan pada: telepon', '2026-04-05 14:09:53', '2026-04-05 14:09:53'),
(494, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-04-05 14:10:16', '2026-04-05 14:10:16'),
(495, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-04-05 14:10:22', '2026-04-05 14:10:22'),
(496, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-04-05 14:10:27', '2026-04-05 14:10:27'),
(497, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-05 14:10:35', '2026-04-05 14:10:35'),
(498, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-05 14:10:36', '2026-04-05 14:10:36'),
(499, 2, 'kasir', 'Create Transaction', 'Pembelian Produk: TRX202604050001 dengan total Rp 50.000', '2026-04-05 14:12:00', '2026-04-05 14:12:00'),
(500, 2, 'kasir', 'Create Transaction', 'Visit: TRX202604050002 dengan total Rp 25.000', '2026-04-05 14:12:12', '2026-04-05 14:12:12'),
(501, 2, 'kasir', 'Create Transaction', 'Produk + Visit: TRX202604050003 dengan total Rp 155.000', '2026-04-05 14:12:41', '2026-04-05 14:12:41'),
(502, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-05 14:13:00', '2026-04-05 14:13:00'),
(503, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-04-05 14:20:17', '2026-04-05 14:20:17'),
(504, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-04-05 14:20:18', '2026-04-05 14:20:18'),
(505, 3, 'owner', 'View Transaction Detail', 'Owner melihat detail transaksi: TRX202604050003', '2026-04-05 14:27:06', '2026-04-05 14:27:06'),
(506, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-04-05 14:28:05', '2026-04-05 14:28:05'),
(507, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-05 14:28:12', '2026-04-05 14:28:12'),
(508, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-04-05 14:28:13', '2026-04-05 14:28:13'),
(509, 1, 'admin', 'Delete Member (Soft)', 'Admin menghapus member (soft delete): asep ganteng (MBR-2026-0002). Member memiliki 1 transaksi.', '2026-04-05 14:28:25', '2026-04-05 14:28:25'),
(510, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-05 14:42:56', '2026-04-05 14:42:56'),
(511, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-05 14:51:26', '2026-04-05 14:51:26'),
(512, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-05 15:12:53', '2026-04-05 15:12:53'),
(513, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 3 transaksi hari ini', '2026-04-05 15:12:55', '2026-04-05 15:12:55'),
(514, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-05 15:13:08', '2026-04-05 15:13:08'),
(515, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 3 transaksi hari ini', '2026-04-05 15:32:15', '2026-04-05 15:32:15'),
(516, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 3 transaksi hari ini', '2026-04-05 16:03:55', '2026-04-05 16:03:55'),
(517, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-05 16:04:48', '2026-04-05 16:04:48'),
(518, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-05 16:06:10', '2026-04-05 16:06:10'),
(519, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-05 16:08:00', '2026-04-05 16:08:00'),
(520, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-05 16:18:41', '2026-04-05 16:18:41'),
(521, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-05 16:21:08', '2026-04-05 16:21:08'),
(522, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-05 16:26:44', '2026-04-05 16:26:44'),
(523, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-05 16:32:02', '2026-04-05 16:32:02'),
(524, 2, 'kasir', 'Create Membership Transaction', 'Transaksi membership baru: TRX-20260405-0001 - Member: hdfhjdfdgdsk (MBR-202604-0001)', '2026-04-05 16:32:35', '2026-04-05 16:32:35'),
(525, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-05 16:32:43', '2026-04-05 16:32:43'),
(526, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-06 01:46:40', '2026-04-06 01:46:40'),
(527, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-06 01:46:41', '2026-04-06 01:46:41'),
(528, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-06 01:50:01', '2026-04-06 01:50:01'),
(529, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-04-06 01:50:02', '2026-04-06 01:50:02'),
(530, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in', '2026-04-06 02:21:57', '2026-04-06 02:21:57'),
(531, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-04-06 02:36:19', '2026-04-06 02:36:19'),
(532, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-04-06 02:36:27', '2026-04-06 02:36:27'),
(533, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-04-06 02:36:27', '2026-04-06 02:36:27'),
(534, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-06 05:59:45', '2026-04-06 05:59:45'),
(535, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 2 produk', '2026-04-06 05:59:46', '2026-04-06 05:59:46'),
(536, 1, 'admin', 'Create User', 'Menambahkan user baru: ibuuu yati ningsih', '2026-04-06 06:02:03', '2026-04-06 06:02:03'),
(537, 1, 'admin', 'Update User', 'Mengupdate user: ibuuu yati icicii', '2026-04-06 06:02:38', '2026-04-06 06:02:38'),
(538, 1, 'admin', 'Create Category', 'Menambahkan kategori baru: makanan', '2026-04-06 06:03:33', '2026-04-06 06:03:33'),
(539, 1, 'admin', 'Create Product', 'Menambahkan produk baru: sosis', '2026-04-06 06:04:23', '2026-04-06 06:04:23'),
(540, 1, 'admin', 'Create Membership Package', 'Menambahkan paket membership: 3 bulan', '2026-04-06 06:04:58', '2026-04-06 06:04:58'),
(541, 1, 'admin', 'Toggle Package Status', 'Mengubah status paket 3 bulan dari aktif menjadi nonaktif', '2026-04-06 06:05:14', '2026-04-06 06:05:14'),
(542, 1, 'admin', 'Toggle Package Status', 'Mengubah status paket 3 bulan dari nonaktif menjadi aktif', '2026-04-06 06:05:18', '2026-04-06 06:05:18'),
(543, 1, 'admin', 'Stock Masuk', 'Menambah stok sosis sebanyak 12 pcs. Keterangan: nambah', '2026-04-06 06:05:58', '2026-04-06 06:05:58'),
(544, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-04-06 06:06:13', '2026-04-06 06:06:13'),
(545, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-04-06 06:13:33', '2026-04-06 06:13:33'),
(546, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-04-06 06:14:13', '2026-04-06 06:14:13'),
(547, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-06 06:53:59', '2026-04-06 06:53:59'),
(548, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-06 06:54:00', '2026-04-06 06:54:00'),
(549, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 2 member, 3 produk', '2026-04-06 07:22:46', '2026-04-06 07:22:46'),
(550, 1, 'admin', 'Toggle User Status', 'Mengubah status user ibuuu yati icicii dari aktif menjadi nonaktif', '2026-04-06 07:23:40', '2026-04-06 07:23:40'),
(551, 1, 'admin', 'Toggle Product Status', 'Mengubah status produk Creatine Monohydrate dari aktif menjadi nonaktif', '2026-04-06 07:23:52', '2026-04-06 07:23:52'),
(552, 1, 'admin', 'Toggle Package Status', 'Mengubah status paket 3 bulan dari aktif menjadi nonaktif', '2026-04-06 07:24:19', '2026-04-06 07:24:19'),
(553, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-04-06 07:24:55', '2026-04-06 07:24:55'),
(554, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-06 07:25:07', '2026-04-06 07:25:07'),
(555, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-06 07:25:27', '2026-04-06 07:25:27'),
(556, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-04-06 07:27:57', '2026-04-06 07:27:57'),
(557, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-04-06 07:28:11', '2026-04-06 07:28:11'),
(558, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-04-06 07:28:18', '2026-04-06 07:28:18'),
(559, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-04-06 07:28:19', '2026-04-06 07:28:19'),
(560, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 07/03/2026 - 06/04/2026', '2026-04-06 07:29:56', '2026-04-06 07:29:56'),
(561, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-04-06 07:31:57', '2026-04-06 07:31:57'),
(562, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-06 07:32:03', '2026-04-06 07:32:03'),
(563, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-06 07:32:04', '2026-04-06 07:32:04'),
(564, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-06 07:41:08', '2026-04-06 07:41:08'),
(565, 2, 'kasir', 'Create Transaction', 'Visit: TRX202604060001 dengan total Rp 25.000', '2026-04-06 07:42:01', '2026-04-06 07:42:01'),
(566, 2, 'kasir', 'Create Transaction', 'Pembelian Produk: TRX202604060002 dengan total Rp 100.000', '2026-04-06 07:42:19', '2026-04-06 07:42:19'),
(567, 2, 'kasir', 'Create Transaction', 'Produk + Visit: TRX202604060003 dengan total Rp 125.000', '2026-04-06 07:42:32', '2026-04-06 07:42:32'),
(568, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-06 07:42:37', '2026-04-06 07:42:37'),
(569, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-07 00:07:15', '2026-04-07 00:07:15'),
(570, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-07 00:07:16', '2026-04-07 00:07:16'),
(571, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-07 00:12:17', '2026-04-07 00:12:17'),
(572, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-07 00:12:22', '2026-04-07 00:12:22'),
(573, 2, 'kasir', 'Create Transaction', 'Produk + Visit: TRX202604070001 dengan total Rp 425.000', '2026-04-07 00:15:16', '2026-04-07 00:15:16'),
(574, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 00:15:21', '2026-04-07 00:15:21'),
(575, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 00:30:10', '2026-04-07 00:30:10'),
(576, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 00:30:16', '2026-04-07 00:30:16'),
(577, 2, 'kasir', 'Create Membership Transaction', 'Transaksi membership baru: TRX-20260407-0001 - Member: jkasdhakshdaksd (MBR-202604-0002)', '2026-04-07 00:31:44', '2026-04-07 00:31:44'),
(578, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 00:32:53', '2026-04-07 00:32:53'),
(579, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-04-07 00:33:04', '2026-04-07 00:33:04'),
(580, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-07 00:33:58', '2026-04-07 00:33:58'),
(581, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 3 member, 3 produk', '2026-04-07 00:33:58', '2026-04-07 00:33:58'),
(582, 1, 'admin', 'Create User', 'Menambahkan user baru: dzikri pangestu', '2026-04-07 00:48:19', '2026-04-07 00:48:19'),
(583, 1, 'admin', 'Delete User', 'Menghapus user: ibuuu yati icicii', '2026-04-07 00:52:18', '2026-04-07 00:52:18'),
(584, 1, 'admin', 'Toggle Product Status', 'Mengubah status produk Creatine Monohydrate dari nonaktif menjadi aktif', '2026-04-07 00:52:42', '2026-04-07 00:52:42'),
(585, 1, 'admin', 'Toggle Product Status', 'Mengubah status produk sosis dari aktif menjadi nonaktif', '2026-04-07 00:56:02', '2026-04-07 00:56:02'),
(586, 1, 'admin', 'Create Category', 'Menambahkan kategori baru: minuman', '2026-04-07 00:56:16', '2026-04-07 00:56:16'),
(587, 1, 'admin', 'Toggle Package Status', 'Mengubah status paket 3 bulan dari nonaktif menjadi aktif', '2026-04-07 00:57:19', '2026-04-07 00:57:19'),
(588, 1, 'admin', 'Delete Category', 'Menghapus kategori: minuman', '2026-04-07 00:58:30', '2026-04-07 00:58:30'),
(589, 1, 'admin', 'Toggle Member Status', 'Admin mengubah status member jkasdhakshdaksd (MBR-202604-0002) dari active menjadi expired', '2026-04-07 00:58:59', '2026-04-07 00:58:59'),
(590, 1, 'admin', 'Toggle Member Status', 'Admin mengubah status member jkasdhakshdaksd (MBR-202604-0002) dari expired menjadi active', '2026-04-07 00:59:12', '2026-04-07 00:59:12'),
(591, 1, 'admin', 'Toggle Member Status', 'Admin mengubah status member salwaafa (MBR-2026-0001) dari active menjadi expired', '2026-04-07 00:59:18', '2026-04-07 00:59:18'),
(592, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-07 01:06:58', '2026-04-07 01:06:58'),
(593, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 2 transaksi hari ini', '2026-04-07 01:06:59', '2026-04-07 01:06:59'),
(594, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 01:07:23', '2026-04-07 01:07:23'),
(595, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 01:18:08', '2026-04-07 01:18:08'),
(596, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 01:18:15', '2026-04-07 01:18:15'),
(597, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 01:23:21', '2026-04-07 01:23:21'),
(598, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 01:26:00', '2026-04-07 01:26:00'),
(599, 2, 'kasir', 'Create Membership Transaction', 'Transaksi membership baru: TRX-20260407-0002 - Member: jkhjhhhhhhhhhh (MBR-202604-0003)', '2026-04-07 01:26:51', '2026-04-07 01:26:51'),
(600, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 01:27:15', '2026-04-07 01:27:15'),
(601, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 3 transaksi hari ini', '2026-04-07 01:27:25', '2026-04-07 01:27:25'),
(602, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-04-07 01:28:01', '2026-04-07 01:28:01'),
(603, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-04-07 01:28:02', '2026-04-07 01:28:02'),
(604, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 08/03/2026 - 07/04/2026', '2026-04-07 01:29:18', '2026-04-07 01:29:18'),
(605, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-04-07 02:02:23', '2026-04-07 02:02:23'),
(606, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-04-07 02:02:28', '2026-04-07 02:02:28'),
(607, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-04-07 02:12:59', '2026-04-07 02:12:59'),
(608, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 4 member, 3 produk', '2026-04-07 02:13:35', '2026-04-07 02:13:35'),
(609, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-04-07 02:21:27', '2026-04-07 02:21:27'),
(610, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-04-07 02:34:37', '2026-04-07 02:34:37'),
(611, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-04-07 02:34:59', '2026-04-07 02:34:59'),
(612, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-04-07 02:45:38', '2026-04-07 02:45:38'),
(613, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-04-07 02:45:49', '2026-04-07 02:45:49'),
(614, 2, 'kasir', 'Create Transaction', 'Pembelian Produk: TRX202604070002 dengan total Rp 720.000', '2026-04-07 02:47:29', '2026-04-07 02:47:29'),
(615, 1, 'admin', 'Stock Masuk', 'Menambah stok es teh sebanyak 1212 pcs. Keterangan: masuk', '2026-04-07 02:49:34', '2026-04-07 02:49:34'),
(616, 1, 'admin', 'Toggle Product Status', 'Mengubah status produk sosis dari nonaktif menjadi aktif', '2026-04-07 02:49:49', '2026-04-07 02:49:49'),
(617, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-04-07 02:53:05', '2026-04-07 02:53:05'),
(618, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-04-07 03:22:06', '2026-04-07 03:22:06'),
(619, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-04-07 03:22:53', '2026-04-07 03:22:53'),
(620, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-07 03:29:22', '2026-04-07 03:29:22'),
(621, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 4 transaksi hari ini', '2026-04-07 03:29:23', '2026-04-07 03:29:23'),
(622, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 4 transaksi hari ini', '2026-04-07 03:29:43', '2026-04-07 03:29:43'),
(623, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 03:29:51', '2026-04-07 03:29:51'),
(624, 2, 'kasir', 'Create Transaction', 'Visit: TRX202604070003 dengan total Rp 25.000', '2026-04-07 03:30:40', '2026-04-07 03:30:40'),
(625, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-04-07 03:30:50', '2026-04-07 03:30:50'),
(626, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-04-07 03:31:22', '2026-04-07 03:31:22'),
(627, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-04-07 03:31:32', '2026-04-07 03:31:32'),
(628, 2, 'kasir', 'Create Transaction', 'Produk + Visit: TRX202604070004 dengan total Rp 105.000', '2026-04-07 03:54:21', '2026-04-07 03:54:21'),
(629, 2, 'kasir', 'Create Transaction', 'Pembelian Produk: TRX202604070005 dengan total Rp 65.000', '2026-04-07 03:54:30', '2026-04-07 03:54:30'),
(630, 2, 'kasir', 'Create Transaction', 'Visit: TRX202604070006 dengan total Rp 25.000', '2026-04-07 03:54:40', '2026-04-07 03:54:40'),
(631, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 03:54:53', '2026-04-07 03:54:53'),
(632, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 04:03:26', '2026-04-07 04:03:26'),
(633, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-07 14:47:29', '2026-04-07 14:47:29'),
(634, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 4 member, 3 produk', '2026-04-07 14:47:30', '2026-04-07 14:47:30'),
(635, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-04-07 14:48:18', '2026-04-07 14:48:18'),
(636, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-04-07 14:48:27', '2026-04-07 14:48:27'),
(637, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-07 14:48:38', '2026-04-07 14:48:38'),
(638, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 8 transaksi hari ini', '2026-04-07 14:48:40', '2026-04-07 14:48:40'),
(639, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-04-07 14:50:00', '2026-04-07 14:50:00'),
(640, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-04-07 14:50:05', '2026-04-07 14:50:05'),
(641, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-04-07 14:50:11', '2026-04-07 14:50:11'),
(642, 2, 'kasir', 'View Transaction Report', 'Kasir melihat laporan transaksi', '2026-04-07 14:50:15', '2026-04-07 14:50:15'),
(643, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 8 transaksi hari ini', '2026-04-07 15:06:08', '2026-04-07 15:06:08'),
(644, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 15:07:02', '2026-04-07 15:07:02'),
(645, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 15:18:17', '2026-04-07 15:18:17'),
(646, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 15:19:37', '2026-04-07 15:19:37'),
(647, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 15:25:56', '2026-04-07 15:25:56'),
(648, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 15:25:59', '2026-04-07 15:25:59'),
(649, 2, 'kasir', 'Create Membership Transaction', 'Transaksi membership baru: TRX-20260407-0003 - Member: kaoaosg (MBR-202604-0004)', '2026-04-07 15:26:48', '2026-04-07 15:26:48'),
(650, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 15:27:01', '2026-04-07 15:27:01'),
(651, 2, 'kasir', 'Create Membership Transaction', 'Transaksi membership baru: TRX-20260407-0004 - Member: cintaaa (MBR-202604-0005)', '2026-04-07 15:27:39', '2026-04-07 15:27:39'),
(652, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 15:27:45', '2026-04-07 15:27:45'),
(653, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 15:42:12', '2026-04-07 15:42:12'),
(654, 2, 'kasir', 'View Reprint Page', 'Kasir melihat halaman cetak ulang struk', '2026-04-07 16:10:21', '2026-04-07 16:10:21'),
(655, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 16:39:44', '2026-04-07 16:39:44'),
(656, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-07 16:57:51', '2026-04-07 16:57:51'),
(657, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 10 transaksi hari ini', '2026-04-07 16:57:52', '2026-04-07 16:57:52'),
(658, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-07 23:07:44', '2026-04-07 23:07:44'),
(659, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-07 23:07:58', '2026-04-07 23:07:58'),
(660, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-07 23:07:59', '2026-04-07 23:07:59'),
(661, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 23:15:23', '2026-04-07 23:15:23'),
(662, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 23:15:43', '2026-04-07 23:15:43'),
(663, 2, 'kasir', 'Create Membership Transaction', 'Transaksi membership baru: TRX-20260408-0001 - Member: gege (MBR-202604-0006)', '2026-04-07 23:18:10', '2026-04-07 23:18:10'),
(664, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 23:18:15', '2026-04-07 23:18:15'),
(665, 2, 'kasir', 'Create Transaction', 'Pembelian Produk: TRX202604080001 dengan total Rp 75.000', '2026-04-07 23:42:22', '2026-04-07 23:42:22'),
(666, 2, 'kasir', 'Create Transaction', 'Produk + Visit: TRX202604080002 dengan total Rp 105.000', '2026-04-07 23:43:28', '2026-04-07 23:43:28'),
(667, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-07 23:44:02', '2026-04-07 23:44:02'),
(668, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-08 06:14:33', '2026-04-08 06:14:33'),
(669, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 3 transaksi hari ini', '2026-04-08 06:14:34', '2026-04-08 06:14:34'),
(670, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-04-08 07:28:36', '2026-04-08 07:28:36'),
(671, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-08 07:28:44', '2026-04-08 07:28:44'),
(672, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 7 member, 3 produk', '2026-04-08 07:28:45', '2026-04-08 07:28:45'),
(673, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-08 11:29:37', '2026-04-08 11:29:37'),
(674, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 7 member, 3 produk', '2026-04-08 11:29:39', '2026-04-08 11:29:39'),
(675, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 7 member, 3 produk', '2026-04-08 11:30:37', '2026-04-08 11:30:37'),
(676, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-04-08 11:43:47', '2026-04-08 11:43:47'),
(677, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-08 11:43:53', '2026-04-08 11:43:53'),
(678, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 3 transaksi hari ini', '2026-04-08 11:43:54', '2026-04-08 11:43:54'),
(679, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-08 11:44:01', '2026-04-08 11:44:01'),
(680, 2, 'kasir', 'Create Membership Transaction', 'Transaksi membership baru: TRX-20260408-0002 - Member: salwalwawl (MBR-202604-0007)', '2026-04-08 11:44:43', '2026-04-08 11:44:43'),
(681, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-04-08 11:44:53', '2026-04-08 11:44:53'),
(682, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-08 11:44:59', '2026-04-08 11:44:59'),
(683, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 8 member, 3 produk', '2026-04-08 11:45:00', '2026-04-08 11:45:00'),
(684, 1, 'admin', 'Update Member', 'Admin mengupdate data member: salwalwawl (MBR-202604-0007)', '2026-04-08 12:29:00', '2026-04-08 12:29:00'),
(685, 1, 'admin', 'Toggle Member Status', 'Admin mengubah status member salwalwawl (MBR-202604-0007) dari active menjadi expired', '2026-04-08 12:29:19', '2026-04-08 12:29:19'),
(686, 1, 'admin', 'Create User', 'Menambahkan user baru: kasirnya traxfit (Role: kasir)', '2026-04-08 13:08:33', '2026-04-08 13:08:33'),
(687, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-04-08 13:09:17', '2026-04-08 13:09:17'),
(688, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-04-08 13:09:31', '2026-04-08 13:09:31'),
(689, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-04-08 13:09:32', '2026-04-08 13:09:32'),
(690, 3, 'owner', 'Update User', 'Mengupdate user: kasirnya traxfit (Role: kasir)', '2026-04-08 13:21:15', '2026-04-08 13:21:15'),
(691, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-04-08 13:21:24', '2026-04-08 13:21:24'),
(692, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-08 13:21:31', '2026-04-08 13:21:31'),
(693, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 8 member, 3 produk', '2026-04-08 13:21:32', '2026-04-08 13:21:32'),
(694, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-04-08 13:46:17', '2026-04-08 13:46:17'),
(695, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-08 13:46:28', '2026-04-08 13:46:28'),
(696, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 4 transaksi hari ini', '2026-04-08 13:46:29', '2026-04-08 13:46:29'),
(697, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-08 21:37:53', '2026-04-08 21:37:53'),
(698, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-08 21:37:54', '2026-04-08 21:37:54'),
(699, 2, 'kasir', 'Member Check-in', 'Member gege (MBR-202604-0006) check-in pada 09/04/2026 05:08:41', '2026-04-08 22:08:41', '2026-04-08 22:08:41'),
(700, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in', '2026-04-08 22:24:05', '2026-04-08 22:24:05'),
(701, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in', '2026-04-08 22:24:11', '2026-04-08 22:24:11'),
(702, 2, 'kasir', 'Member Check-in', 'Member hdfhjdfdgdsk (MBR-202604-0001) check-in pada 09/04/2026 05:24:42', '2026-04-08 22:24:42', '2026-04-08 22:24:42'),
(703, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-09 00:25:21', '2026-04-09 00:25:21'),
(704, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 8 member, 3 produk', '2026-04-09 00:25:22', '2026-04-09 00:25:22'),
(705, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 8 member, 3 produk', '2026-04-09 00:36:30', '2026-04-09 00:36:30'),
(706, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-04-09 00:36:45', '2026-04-09 00:36:45'),
(707, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-04-09 00:38:37', '2026-04-09 00:38:37'),
(708, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-04-09 00:38:45', '2026-04-09 00:38:45'),
(709, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-04-09 00:38:46', '2026-04-09 00:38:46'),
(710, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-04-09 00:44:43', '2026-04-09 00:44:43'),
(711, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-09 00:44:49', '2026-04-09 00:44:49'),
(712, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 8 member, 3 produk', '2026-04-09 00:44:50', '2026-04-09 00:44:50'),
(713, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-09 03:34:41', '2026-04-09 03:34:41'),
(714, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-09 03:35:58', '2026-04-09 03:35:58'),
(715, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-09 03:37:06', '2026-04-09 03:37:06'),
(716, 2, 'kasir', 'Create Transaction', 'Pembelian Produk: TRX202604090001 dengan total Rp 65.000', '2026-04-09 03:37:56', '2026-04-09 03:37:56'),
(717, 2, 'kasir', 'Create Transaction', 'Visit: TRX202604090002 dengan total Rp 25.000', '2026-04-09 03:38:05', '2026-04-09 03:38:05'),
(718, 2, 'kasir', 'Create Transaction', 'Produk + Visit: TRX202604090003 dengan total Rp 35.000', '2026-04-09 03:38:19', '2026-04-09 03:38:19'),
(719, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-09 03:38:24', '2026-04-09 03:38:24'),
(720, 2, 'kasir', 'Create Membership Transaction', 'Transaksi membership baru: TRX-20260409-0001 - Member: padzikri (MBR-202604-0008)', '2026-04-09 03:40:24', '2026-04-09 03:40:24'),
(721, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-09 03:40:29', '2026-04-09 03:40:29'),
(722, 2, 'kasir', 'Create Membership Transaction', 'Transaksi membership baru: TRX-20260409-0002 - Member: sayangku (MBR-202604-0009)', '2026-04-09 03:42:32', '2026-04-09 03:42:32'),
(723, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-09 03:48:15', '2026-04-09 03:48:15'),
(724, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-09 04:14:36', '2026-04-09 04:14:36'),
(725, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-09 06:25:53', '2026-04-09 06:25:53'),
(726, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 10 member, 3 produk', '2026-04-09 06:26:28', '2026-04-09 06:26:28'),
(727, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-04-09 06:26:48', '2026-04-09 06:26:48'),
(728, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-04-09 06:26:55', '2026-04-09 06:26:55'),
(729, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-04-09 06:26:55', '2026-04-09 06:26:55'),
(730, 3, 'owner', 'Toggle User Status', 'Mengubah status user kasirnya traxfit (Role: kasir) dari aktif menjadi nonaktif', '2026-04-09 06:27:22', '2026-04-09 06:27:22'),
(731, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-09 13:22:48', '2026-04-09 13:22:48'),
(732, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 5 transaksi hari ini', '2026-04-09 13:22:49', '2026-04-09 13:22:49'),
(733, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 5 transaksi hari ini', '2026-04-09 13:32:10', '2026-04-09 13:32:10'),
(734, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 5 transaksi hari ini', '2026-04-09 13:32:57', '2026-04-09 13:32:57'),
(735, 2, 'kasir', 'Member Check-in', 'Member cintaaa (MBR-202604-0005) check-in pada 09/04/2026 20:37:24', '2026-04-09 13:37:24', '2026-04-09 13:37:24'),
(736, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-09 14:12:20', '2026-04-09 14:12:20'),
(737, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 5 transaksi hari ini', '2026-04-09 14:12:20', '2026-04-09 14:12:20'),
(738, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-09 23:50:21', '2026-04-09 23:50:21'),
(739, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-09 23:50:24', '2026-04-09 23:50:24'),
(740, 2, 'kasir', 'Member Check-in', 'Member cintaaa (MBR-202604-0005) check-in pada 10/04/2026 06:50:43', '2026-04-09 23:50:43', '2026-04-09 23:50:43'),
(741, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-09 23:51:08', '2026-04-09 23:51:08'),
(742, 2, 'kasir', 'Create Membership Transaction', 'Transaksi membership baru: TRX-20260410-0001 - Member: MARAAA (MBR-202604-0010)', '2026-04-09 23:52:16', '2026-04-09 23:52:16'),
(743, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-09 23:52:21', '2026-04-09 23:52:21'),
(744, 2, 'kasir', 'Member Check-in', 'Member MARAAA (MBR-202604-0010) check-in pada 10/04/2026 06:52:43', '2026-04-09 23:52:45', '2026-04-09 23:52:45'),
(745, 2, 'kasir', 'Open Renew Membership', 'Kasir membuka halaman perpanjangan membership untuk member: salwaafa', '2026-04-10 01:31:15', '2026-04-10 01:31:15'),
(746, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-10 01:31:27', '2026-04-10 01:31:27'),
(747, 2, 'kasir', 'Open Renew Membership', 'Kasir membuka halaman perpanjangan membership untuk member: salwalwawl', '2026-04-10 01:31:48', '2026-04-10 01:31:48'),
(748, 2, 'kasir', 'Renew Membership Transaction', 'Perpanjangan membership: salwalwawl (MBR-202604-0007) | No. Transaksi: TRX-20260410-0002', '2026-04-10 01:32:19', '2026-04-10 01:32:19'),
(749, 2, 'kasir', 'Open Renew Membership', 'Kasir membuka halaman perpanjangan membership untuk member: salwaafa', '2026-04-10 01:45:14', '2026-04-10 01:45:14'),
(750, 2, 'kasir', 'Open Renew Membership', 'Kasir membuka halaman perpanjangan membership untuk member: salwaafa', '2026-04-10 01:45:16', '2026-04-10 01:45:16'),
(751, 2, 'kasir', 'Renew Membership Transaction', 'Perpanjangan membership: salwaafa (MBR-2026-0001) | No. Transaksi: TRX-20260410-0003', '2026-04-10 01:45:26', '2026-04-10 01:45:26'),
(752, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-10 01:45:31', '2026-04-10 01:45:31'),
(753, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-04-10 02:26:08', '2026-04-10 02:26:08'),
(754, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-10 02:56:49', '2026-04-10 02:56:49'),
(755, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 3 transaksi hari ini', '2026-04-10 02:56:50', '2026-04-10 02:56:50'),
(756, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 3 transaksi hari ini', '2026-04-10 03:47:33', '2026-04-10 03:47:33'),
(757, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-10 06:01:00', '2026-04-10 06:01:00'),
(758, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 11 member, 3 produk', '2026-04-10 06:01:01', '2026-04-10 06:01:01'),
(759, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 11 member, 3 produk', '2026-04-10 06:01:42', '2026-04-10 06:01:42'),
(760, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 11 member, 3 produk', '2026-04-10 06:03:55', '2026-04-10 06:03:55'),
(761, 1, 'admin', 'Update User', 'Mengupdate user: kasirnya traxfit (Role: kasir)', '2026-04-10 06:20:10', '2026-04-10 06:20:10'),
(762, 1, 'admin', 'Toggle User Status', 'Mengubah status user kasirnya traxfit (Role: kasir) dari nonaktif menjadi aktif', '2026-04-10 06:25:00', '2026-04-10 06:25:00'),
(763, 1, 'admin', 'Toggle User Status', 'Mengubah status user kasirnya traxfit (Role: kasir) dari aktif menjadi nonaktif', '2026-04-10 06:25:03', '2026-04-10 06:25:03'),
(764, 1, 'admin', 'Update User', 'Mengupdate user: kasirnya traxfit (Role: kasir)', '2026-04-10 06:25:15', '2026-04-10 06:25:15'),
(765, 1, 'admin', 'Toggle User Status', 'Mengubah status user kasirnya traxfit (Role: kasir) dari nonaktif menjadi aktif', '2026-04-10 06:35:00', '2026-04-10 06:35:00'),
(766, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-10 12:14:42', '2026-04-10 12:14:42'),
(767, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 11 member, 3 produk', '2026-04-10 12:14:44', '2026-04-10 12:14:44'),
(768, 1, 'admin', 'Update Member', 'Admin mengupdate data member: MARAAA (MBR-202604-0010). Perubahan pada: tanggal expired', '2026-04-10 12:21:54', '2026-04-10 12:21:54'),
(769, 1, 'admin', 'Update Member', 'Admin mengupdate data member: MARAAA (MBR-202604-0010). Perubahan pada: tanggal expired, status', '2026-04-10 12:22:10', '2026-04-10 12:22:10'),
(770, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-04-10 12:25:12', '2026-04-10 12:25:12');
INSERT INTO `log` (`id`, `id_user`, `role_user`, `activity`, `keterangan`, `created_at`, `updated_at`) VALUES
(771, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-04-10 12:25:31', '2026-04-10 12:25:31'),
(772, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 11 member, 3 produk', '2026-04-10 13:29:28', '2026-04-10 13:29:28'),
(773, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-04-10 13:30:50', '2026-04-10 13:30:50'),
(774, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-10 13:31:03', '2026-04-10 13:31:03'),
(775, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 11 member, 3 produk', '2026-04-10 13:31:04', '2026-04-10 13:31:04'),
(776, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-04-10 13:31:08', '2026-04-10 13:31:08'),
(777, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-10 13:31:15', '2026-04-10 13:31:15'),
(778, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 3 transaksi hari ini', '2026-04-10 13:31:16', '2026-04-10 13:31:16'),
(779, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-11 12:35:01', '2026-04-11 12:35:01'),
(780, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-11 12:35:03', '2026-04-11 12:35:03'),
(781, 2, 'kasir', 'Create Transaction', 'Pembelian Produk: TRX202604110001 dengan total Rp 65.000', '2026-04-11 12:58:38', '2026-04-11 12:58:38'),
(782, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-11 12:58:48', '2026-04-11 12:58:48'),
(783, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-11 13:12:36', '2026-04-11 13:12:36'),
(784, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-11 13:16:02', '2026-04-11 13:16:02'),
(785, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-11 13:17:09', '2026-04-11 13:17:09'),
(786, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-11 13:18:00', '2026-04-11 13:18:00'),
(787, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-11 13:19:12', '2026-04-11 13:19:12'),
(788, 2, 'kasir', 'Open Renew Membership', 'Kasir membuka halaman perpanjangan membership untuk member: MARAAA', '2026-04-11 13:19:57', '2026-04-11 13:19:57'),
(789, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-11 23:24:03', '2026-04-11 23:24:03'),
(790, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-11 23:24:04', '2026-04-11 23:24:04'),
(791, 2, 'kasir', 'Member Check-in', 'Member gege (MBR-202604-0006) check-in pada 12/04/2026 06:24:26', '2026-04-11 23:24:26', '2026-04-11 23:24:26'),
(792, 2, 'kasir', 'Member Check-in', 'Member cintaaa (MBR-202604-0005) check-in pada 12/04/2026 06:24:38', '2026-04-11 23:24:38', '2026-04-11 23:24:38'),
(793, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-04-12 00:58:07', '2026-04-12 00:58:07'),
(794, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-12 00:58:19', '2026-04-12 00:58:19'),
(795, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 11 member, 3 produk', '2026-04-12 00:58:19', '2026-04-12 00:58:19'),
(796, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-04-12 01:02:54', '2026-04-12 01:02:54'),
(797, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-12 01:08:16', '2026-04-12 01:08:16'),
(798, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-12 01:08:17', '2026-04-12 01:08:17'),
(799, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-12 03:24:26', '2026-04-12 03:24:26'),
(800, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-12 03:24:27', '2026-04-12 03:24:27'),
(801, 2, 'kasir', 'Member Check-in', 'Member padzikri (MBR-202604-0008) check-in pada 12/04/2026 10:39:25', '2026-04-12 03:39:25', '2026-04-12 03:39:25'),
(802, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-12 10:09:31', '2026-04-12 10:09:31'),
(803, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 0 transaksi hari ini', '2026-04-12 10:09:32', '2026-04-12 10:09:32'),
(804, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-12 10:10:11', '2026-04-12 10:10:11'),
(805, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-12 10:12:32', '2026-04-12 10:12:32'),
(806, 2, 'kasir', 'Create Membership Transaction', 'Transaksi membership baru: salmafhrz (MBR-202604-0011) | No. Transaksi: TRX-20260412-0001', '2026-04-12 10:13:36', '2026-04-12 10:13:36'),
(807, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-12 10:15:02', '2026-04-12 10:15:02'),
(808, 2, 'kasir', 'Open Membership Transaction', 'Kasir membuka halaman transaksi membership', '2026-04-12 10:21:42', '2026-04-12 10:21:42'),
(809, 2, 'kasir', 'Create Transaction', 'Pembelian Produk: TRX202604120001 dengan total Rp 65.000', '2026-04-12 10:24:02', '2026-04-12 10:24:02'),
(810, 2, 'kasir', 'Create Transaction', 'Visit: TRX202604120002 dengan total Rp 25.000', '2026-04-12 10:24:12', '2026-04-12 10:24:12'),
(811, 2, 'kasir', 'Create Transaction', 'Produk + Visit: TRX202604120003 dengan total Rp 90.000', '2026-04-12 10:24:25', '2026-04-12 10:24:25'),
(812, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in', '2026-04-12 10:26:23', '2026-04-12 10:26:23'),
(813, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in periode 2026-04-01 s/d 2026-04-12', '2026-04-12 10:26:43', '2026-04-12 10:26:43'),
(814, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in periode 2026-04-01 s/d 2026-04-12', '2026-04-12 10:33:47', '2026-04-12 10:33:47'),
(815, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in', '2026-04-12 10:48:50', '2026-04-12 10:48:50'),
(816, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in', '2026-04-12 10:55:44', '2026-04-12 10:55:44'),
(817, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in', '2026-04-12 10:56:02', '2026-04-12 10:56:02'),
(818, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in', '2026-04-12 11:00:44', '2026-04-12 11:00:44'),
(819, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in', '2026-04-12 11:01:31', '2026-04-12 11:01:31'),
(820, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in', '2026-04-12 11:08:50', '2026-04-12 11:08:50'),
(821, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in', '2026-04-12 11:09:02', '2026-04-12 11:09:02'),
(822, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-04-12 12:28:57', '2026-04-12 12:28:57'),
(823, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-12 12:29:09', '2026-04-12 12:29:09'),
(824, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 12 member, 3 produk', '2026-04-12 12:29:11', '2026-04-12 12:29:11'),
(825, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-04-12 12:29:25', '2026-04-12 12:29:25'),
(826, 1, 'admin', 'Update Gym Settings', 'Admin mengupdate pengaturan gym (harga visit: Rp 25.000, nama gym: TraxFit Gym)', '2026-04-12 12:31:43', '2026-04-12 12:31:43'),
(827, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-04-12 12:31:44', '2026-04-12 12:31:44'),
(828, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-04-12 12:40:03', '2026-04-12 12:40:03'),
(829, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-04-12 12:40:04', '2026-04-12 12:40:04'),
(830, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 13/03/2026 - 12/04/2026', '2026-04-12 12:40:55', '2026-04-12 12:40:55'),
(831, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 13/03/2026 - 12/04/2026', '2026-04-12 12:45:56', '2026-04-12 12:45:56'),
(832, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 13/03/2026 - 12/04/2026', '2026-04-12 12:46:00', '2026-04-12 12:46:00'),
(833, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 13/03/2026 - 12/04/2026', '2026-04-12 12:46:06', '2026-04-12 12:46:06'),
(834, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 13/03/2026 - 12/04/2026', '2026-04-12 12:46:17', '2026-04-12 12:46:17'),
(835, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 13/03/2026 - 12/04/2026', '2026-04-12 12:46:23', '2026-04-12 12:46:23'),
(836, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 13/03/2026 - 12/04/2026', '2026-04-12 12:46:34', '2026-04-12 12:46:34'),
(837, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 13/03/2026 - 12/04/2026', '2026-04-12 12:46:37', '2026-04-12 12:46:37'),
(838, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 13/03/2026 - 12/04/2026', '2026-04-12 12:46:39', '2026-04-12 12:46:39'),
(839, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 13/03/2026 - 12/04/2026', '2026-04-12 12:46:41', '2026-04-12 12:46:41'),
(840, 1, 'admin', 'View Gym Settings', 'Admin melihat pengaturan gym', '2026-04-12 12:49:19', '2026-04-12 12:49:19'),
(841, 1, 'admin', 'Create Product', 'Menambahkan produk baru: airrr', '2026-04-12 13:10:31', '2026-04-12 13:10:31'),
(842, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 13/03/2026 - 12/04/2026', '2026-04-12 13:23:11', '2026-04-12 13:23:11'),
(843, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-04-12 13:30:14', '2026-04-12 13:30:14'),
(844, 3, 'owner', 'Login', 'User berhasil login ke sistem', '2026-04-12 13:30:24', '2026-04-12 13:30:24'),
(845, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-04-12 13:30:27', '2026-04-12 13:30:27'),
(846, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-04-12 13:47:07', '2026-04-12 13:47:07'),
(847, 3, 'owner', 'View Profile', 'Owner melihat halaman profil', '2026-04-12 13:47:16', '2026-04-12 13:47:16'),
(848, 3, 'owner', 'Update Profile', 'Owner mengupdate profil sendiri', '2026-04-12 13:47:30', '2026-04-12 13:47:30'),
(849, 3, 'owner', 'View Profile', 'Owner melihat halaman profil', '2026-04-12 13:47:31', '2026-04-12 13:47:31'),
(850, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-04-12 13:47:35', '2026-04-12 13:47:35'),
(851, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-04-12 13:47:40', '2026-04-12 13:47:40'),
(852, 3, 'owner', 'View Profile', 'Owner melihat halaman profil', '2026-04-12 13:47:48', '2026-04-12 13:47:48'),
(853, 3, 'owner', 'View Profile', 'Owner melihat halaman profil', '2026-04-12 13:48:27', '2026-04-12 13:48:27'),
(854, 3, 'owner', 'Update Profile', 'Owner mengupdate profil sendiri', '2026-04-12 13:48:33', '2026-04-12 13:48:33'),
(855, 3, 'owner', 'View Profile', 'Owner melihat halaman profil', '2026-04-12 13:48:33', '2026-04-12 13:48:33'),
(856, 3, 'owner', 'View Profile', 'Owner melihat halaman profil', '2026-04-12 13:53:08', '2026-04-12 13:53:08'),
(857, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-04-12 14:01:32', '2026-04-12 14:01:32'),
(858, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 13/03/2026 - 12/04/2026', '2026-04-12 14:01:44', '2026-04-12 14:01:44'),
(859, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-04-12 15:04:42', '2026-04-12 15:04:42'),
(860, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 13/03/2026 - 12/04/2026', '2026-04-12 15:06:20', '2026-04-12 15:06:20'),
(861, 3, 'owner', 'View Profile', 'Owner melihat halaman profil', '2026-04-12 15:06:42', '2026-04-12 15:06:42'),
(862, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-04-12 15:06:46', '2026-04-12 15:06:46'),
(863, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 13/03/2026 - 12/04/2026', '2026-04-12 15:07:50', '2026-04-12 15:07:50'),
(864, 3, 'owner', 'View Activity Report', 'Owner melihat laporan aktivitas user periode 13/03/2026 - 12/04/2026', '2026-04-12 15:08:44', '2026-04-12 15:08:44'),
(865, 3, 'owner', 'View Dashboard', 'Owner melihat dashboard', '2026-04-12 15:09:39', '2026-04-12 15:09:39'),
(866, 3, 'owner', 'Logout', 'User logout dari sistem', '2026-04-12 15:09:46', '2026-04-12 15:09:46'),
(867, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-12 15:09:53', '2026-04-12 15:09:53'),
(868, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 4 transaksi hari ini', '2026-04-12 15:09:54', '2026-04-12 15:09:54'),
(869, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in', '2026-04-12 15:18:57', '2026-04-12 15:18:57'),
(870, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in', '2026-04-12 15:19:02', '2026-04-12 15:19:02'),
(871, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in', '2026-04-12 15:19:07', '2026-04-12 15:19:07'),
(872, 2, 'kasir', 'View Check-in History', 'Kasir melihat riwayat check-in', '2026-04-12 15:19:35', '2026-04-12 15:19:35'),
(873, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 4 transaksi hari ini', '2026-04-12 15:30:54', '2026-04-12 15:30:54'),
(874, 2, 'kasir', 'Open Renew Membership', 'Kasir membuka halaman perpanjangan membership untuk member: MARAAA', '2026-04-12 15:31:13', '2026-04-12 15:31:13'),
(875, 2, 'kasir', 'Logout', 'User logout dari sistem', '2026-04-12 15:31:30', '2026-04-12 15:31:30'),
(876, 1, 'admin', 'Login', 'User berhasil login ke sistem', '2026-04-12 15:31:37', '2026-04-12 15:31:37'),
(877, 1, 'admin', 'View Dashboard', 'Admin melihat dashboard dengan statistik: 12 member, 4 produk', '2026-04-12 15:31:38', '2026-04-12 15:31:38'),
(878, 1, 'admin', 'Logout', 'User logout dari sistem', '2026-04-12 15:37:14', '2026-04-12 15:37:14'),
(879, 2, 'kasir', 'Login', 'User berhasil login ke sistem', '2026-04-12 15:37:20', '2026-04-12 15:37:20'),
(880, 2, 'kasir', 'View Dashboard', 'Kasir melihat dashboard dengan 4 transaksi hari ini', '2026-04-12 15:37:21', '2026-04-12 15:37:21');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_member` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `id_paket` bigint UNSIGNED DEFAULT NULL,
  `no_identitas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_identitas` enum('KTP','SIM') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `foto_identitas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_daftar` date NOT NULL,
  `tgl_expired` date NOT NULL,
  `status` enum('active','expired','suspended') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `kode_member`, `nama`, `telepon`, `alamat`, `id_paket`, `no_identitas`, `jenis_identitas`, `tgl_lahir`, `foto_identitas`, `tgl_daftar`, `tgl_expired`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'MBR-2026-0001', 'salwaafa', '6982031098302', 'asasak', 3, '32545678654324', 'SIM', '2000-11-09', 'identitas/F5YJTkn3ePAXRecANHZjWO7ADcGyAWqBG7Xl6Hi6.jpg', '2026-02-21', '2026-07-09', 'active', '2026-02-20 21:29:11', '2026-04-10 01:45:26', NULL),
(4, 'MBR-2026-0002', 'asep ganteng', '90900909009090', 'tanjungsiang', 1, '08877766754545', 'KTP', '2008-11-01', 'identitas/ZCE0k22RlOgW4tblZTknH0s1BP4RBRTGsIXdCAF1.jpg', '2026-02-21', '2026-03-05', 'expired', '2026-02-20 23:47:05', '2026-04-05 14:28:25', '2026-04-05 14:28:25'),
(5, 'MBR-2026-0003', 'sffsddaffa', '6526we67685', 'hffffffffff', 1, '645325678089765', 'SIM', '2000-12-02', 'identitas/TK3RcOFR4kecGR2q4AOvJc91N9tqaAVJy1BACC8V.jpg', '2026-03-04', '2026-04-03', 'active', '2026-03-04 14:07:33', '2026-04-05 14:07:05', '2026-04-05 14:07:05'),
(6, 'MBR-202604-0001', 'hdfhjdfdgdsk', '8459822892', 'mvvvvvvvvvvvvx', 1, '246323443', 'KTP', '2008-12-22', 'identitas/q5iEKDINreirhmdX7kWLhtJvCKaLHXtUpGtuc82M.jpg', '2026-04-05', '2026-05-05', 'active', '2026-04-05 16:32:35', '2026-04-05 16:32:35', NULL),
(7, 'MBR-202604-0002', 'jkasdhakshdaksd', '87582059395', 'husdhushauhu', 3, '973709268934', 'KTP', '2000-11-09', 'identitas/8Wx3mb42HSQgbAMzcabG4gM7SLrbEBULENlix130.jpg', '2026-04-07', '2026-07-06', 'active', '2026-04-07 00:31:44', '2026-04-07 00:59:12', NULL),
(8, 'MBR-202604-0003', 'jkhjhhhhhhhhhh', '234676524', 'fggfdfgdgfdgdf', 3, '233132332', 'SIM', '2000-11-12', 'identitas/tTFF61JvcEgLxZu6RlebyO0U67hebu902mfkvYZI.jpg', '2026-04-07', '2026-07-06', 'active', '2026-04-07 01:26:51', '2026-04-07 01:26:51', NULL),
(9, 'MBR-202604-0004', 'kaoaosg', '55235354545', 'fjgflgjlglkfjglk', 1, '124445554323', 'KTP', '2000-11-12', 'identitas/rlKqPFF6QhmIOe7N7CFkm13Dhf8qnkTHaFq8NkX6.jpg', '2026-04-07', '2026-05-07', 'active', '2026-04-07 15:26:48', '2026-04-07 15:26:48', NULL),
(10, 'MBR-202604-0005', 'cintaaa', '845430394609', 'gdffdg', 3, '22116564654653', 'KTP', '2009-11-04', 'identitas/7PzVBycRe7AXza6hkdIqDH2vhBXW6aU9Q5g7jITv.png', '2026-04-07', '2026-07-06', 'active', '2026-04-07 15:27:39', '2026-04-07 15:27:39', NULL),
(11, 'MBR-202604-0006', 'gege', '55323323213', 'ghfghfghf', 1, '43546456233543', 'KTP', '2000-10-11', 'identitas/XJZRcwvEXSu5Rr36tUS0nhuZ1qspGcYbsadgE35d.jpg', '2026-04-08', '2026-05-08', 'active', '2026-04-07 23:18:10', '2026-04-07 23:18:10', NULL),
(12, 'MBR-202604-0007', 'salwalwawl', '4433452332553', 'fgdfgdgfd', 1, 'e5577685732', 'KTP', '2000-10-09', 'identitas/identitas_MBR-202604-0007_1775651340.jpg', '2026-04-08', '2026-05-10', 'active', '2026-04-08 11:44:43', '2026-04-10 01:32:19', NULL),
(13, 'MBR-202604-0008', 'padzikri', '12121121212121', 'kajkajdalkdjlsda', 1, '2334354555666', 'KTP', '2009-12-09', 'identitas/ZGoER99LXkKTYj2N8tjFbFfRLXMSgQMTqx7RzA2G.jpg', '2026-04-09', '2026-05-09', 'active', '2026-04-09 03:40:23', '2026-04-09 03:40:23', NULL),
(14, 'MBR-202604-0009', 'sayangku', '45354556767', 'kajskasjkasak', 3, '0989567986754', 'KTP', '2009-08-23', 'identitas/fUF90VnrATI49Z1Pruf1S4JgyTj3FDL8e9UwjKkY.jpg', '2026-04-09', '2026-07-08', 'active', '2026-04-09 03:42:32', '2026-04-09 03:42:32', NULL),
(15, 'MBR-202604-0010', 'MARAAA', '6757578945634', 'jhgghjjji', 3, '78797798989', 'KTP', '2009-10-09', 'identitas/kbGj1YhNdP7fXoQLRNiknscVTN2vrj4DGGL9XxLd.jpg', '2026-04-10', '2026-04-09', 'expired', '2026-04-09 23:52:16', '2026-04-10 12:22:10', NULL),
(16, 'MBR-202604-0011', 'salmafhrz', '081234567890', 'tjs', 1, '092834092329898', 'SIM', '2005-12-05', 'identitas/rYJSUdPIULROZji2P0PXI0fwkBFRWJgjFnUN9Af7.jpg', '2026-04-12', '2026-05-12', 'active', '2026-04-12 10:13:36', '2026-04-12 10:13:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `membership_packages`
--

CREATE TABLE `membership_packages` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_paket` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `durasi_hari` int NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `membership_packages`
--

INSERT INTO `membership_packages` (`id`, `nama_paket`, `durasi_hari`, `harga`, `status`, `created_at`, `updated_at`) VALUES
(1, '1 bulan', 30, 350000.00, 1, '2026-02-20 20:16:32', '2026-02-28 20:40:54'),
(3, '3 bulan', 90, 1000000.00, 1, '2026-04-06 06:04:58', '2026-04-07 00:57:19');

-- --------------------------------------------------------

--
-- Table structure for table `member_checkin`
--

CREATE TABLE `member_checkin` (
  `id` bigint UNSIGNED NOT NULL,
  `id_member` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `id_kasir` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member_checkin`
--

INSERT INTO `member_checkin` (`id`, `id_member`, `tanggal`, `jam_masuk`, `id_kasir`, `created_at`, `updated_at`) VALUES
(1, 11, '2026-04-09', '05:08:41', 2, '2026-04-08 22:08:41', '2026-04-08 22:08:41'),
(2, 6, '2026-04-09', '05:24:42', 2, '2026-04-08 22:24:42', '2026-04-08 22:24:42'),
(3, 10, '2026-04-09', '20:37:24', 2, '2026-04-09 13:37:24', '2026-04-09 13:37:24'),
(4, 10, '2026-04-10', '06:50:43', 2, '2026-04-09 23:50:43', '2026-04-09 23:50:43'),
(5, 15, '2026-04-10', '06:52:43', 2, '2026-04-09 23:52:43', '2026-04-09 23:52:43'),
(6, 11, '2026-04-12', '06:24:26', 2, '2026-04-11 23:24:26', '2026-04-11 23:24:26'),
(7, 10, '2026-04-12', '06:24:38', 2, '2026-04-11 23:24:38', '2026-04-11 23:24:38'),
(8, 13, '2026-04-12', '10:39:25', 2, '2026-04-12 03:39:25', '2026-04-12 03:39:25');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_07_025137_create_membership_packages_table', 1),
(5, '2026_02_07_025138_create_members_table', 1),
(6, '2026_02_07_025139_create_product_categories_table', 1),
(7, '2026_02_07_025139_create_products_table', 1),
(8, '2026_02_07_025140_create_transactions_table', 1),
(9, '2026_02_07_025141_create_transaction_details_table', 1),
(10, '2026_02_07_025142_create_log_table', 1),
(11, '2026_02_07_025142_create_stok_log_table', 1),
(12, '2026_02_07_025143_create_member_checkin_table', 1),
(13, '2026_02_07_025436_create_gym_settings_table', 1),
(14, '2026_04_01_041335_add_soft_deletes_to_users_and_logs', 2),
(15, '2026_04_01_042942_add_soft_deletes_to_members_table', 3),
(16, '2026_04_12_193908_drop_email_from_gym_settings_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `kategori` bigint UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `nama_produk`, `harga`, `stok`, `kategori`, `status`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'es teh', 10000.00, 1182, 1, 1, NULL, '2026-02-20 20:15:45', '2026-04-10 01:32:19'),
(2, 'Creatine Monohydrate', 65000.00, 95, 1, 1, NULL, '2026-02-20 20:30:43', '2026-04-12 10:24:25'),
(4, 'sosis', 100000.00, 25, 4, 1, NULL, '2026-04-06 06:04:23', '2026-04-07 15:26:48'),
(5, 'airrr', 400000.00, 1110, 1, 1, 'assalamualaikum', '2026-04-12 13:10:31', '2026-04-12 13:10:31');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'suplemen', '2026-02-20 20:15:11', '2026-02-20 20:15:11'),
(2, 'dessert', '2026-02-25 18:21:07', '2026-02-25 18:21:07'),
(4, 'makanan', '2026-04-06 06:03:33', '2026-04-06 06:03:33');

-- --------------------------------------------------------

--
-- Table structure for table `stok_log`
--

CREATE TABLE `stok_log` (
  `id` bigint UNSIGNED NOT NULL,
  `id_product` bigint UNSIGNED NOT NULL,
  `tipe` enum('masuk','keluar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `id_user` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok_log`
--

INSERT INTO `stok_log` (`id`, `id_product`, `tipe`, `qty`, `keterangan`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 2, 'keluar', 1, 'Penjualan transaksi TRX202602210001', 2, '2026-02-20 20:32:02', '2026-02-20 20:32:02'),
(2, 1, 'keluar', 1, 'Penjualan transaksi TRX202602210001', 2, '2026-02-20 20:32:02', '2026-02-20 20:32:02'),
(3, 2, 'keluar', 2, 'Penjualan transaksi TRX202602210002', 2, '2026-02-20 23:44:30', '2026-02-20 23:44:30'),
(4, 1, 'keluar', 1, 'Penjualan transaksi TRX202602210002', 2, '2026-02-20 23:44:30', '2026-02-20 23:44:30'),
(5, 1, 'keluar', 1, 'Penjualan transaksi TRX202602210004', 2, '2026-02-20 23:45:32', '2026-02-20 23:45:32'),
(6, 2, 'masuk', 100, 'restock', 1, '2026-02-25 18:17:46', '2026-02-25 18:17:46'),
(7, 2, 'keluar', 1, 'Penjualan transaksi TRX202603300001', 2, '2026-03-30 02:59:44', '2026-03-30 02:59:44'),
(8, 1, 'keluar', 5, 'Penjualan transaksi TRX202604050001', 2, '2026-04-05 14:12:00', '2026-04-05 14:12:00'),
(9, 2, 'keluar', 2, 'Penjualan transaksi TRX202604050003', 2, '2026-04-05 14:12:41', '2026-04-05 14:12:41'),
(10, 4, 'masuk', 12, 'nambah', 1, '2026-04-06 06:05:58', '2026-04-06 06:05:58'),
(11, 4, 'keluar', 1, 'Penjualan transaksi TRX202604060002', 2, '2026-04-06 07:42:19', '2026-04-06 07:42:19'),
(12, 4, 'keluar', 1, 'Penjualan transaksi TRX202604060003', 2, '2026-04-06 07:42:32', '2026-04-06 07:42:32'),
(13, 4, 'keluar', 4, 'Penjualan transaksi TRX202604070001', 2, '2026-04-07 00:15:16', '2026-04-07 00:15:16'),
(14, 1, 'keluar', 72, 'Penjualan transaksi TRX202604070002', 2, '2026-04-07 02:47:29', '2026-04-07 02:47:29'),
(15, 1, 'masuk', 1212, 'masuk', 1, '2026-04-07 02:49:34', '2026-04-07 02:49:34'),
(16, 1, 'keluar', 8, 'Penjualan transaksi TRX202604070004', 2, '2026-04-07 03:54:21', '2026-04-07 03:54:21'),
(17, 2, 'keluar', 1, 'Penjualan transaksi TRX202604070005', 2, '2026-04-07 03:54:30', '2026-04-07 03:54:30'),
(18, 2, 'keluar', 1, 'Penjualan transaksi TRX202604080001', 2, '2026-04-07 23:42:22', '2026-04-07 23:42:22'),
(19, 1, 'keluar', 1, 'Penjualan transaksi TRX202604080001', 2, '2026-04-07 23:42:22', '2026-04-07 23:42:22'),
(20, 1, 'keluar', 8, 'Penjualan transaksi TRX202604080002', 2, '2026-04-07 23:43:28', '2026-04-07 23:43:28'),
(21, 2, 'keluar', 1, 'Penjualan transaksi TRX202604090001', 2, '2026-04-09 03:37:56', '2026-04-09 03:37:56'),
(22, 1, 'keluar', 1, 'Penjualan transaksi TRX202604090003', 2, '2026-04-09 03:38:19', '2026-04-09 03:38:19'),
(23, 2, 'keluar', 1, 'Penjualan transaksi TRX202604110001', 2, '2026-04-11 12:58:38', '2026-04-11 12:58:38'),
(24, 2, 'keluar', 1, 'Penjualan transaksi TRX202604120001', 2, '2026-04-12 10:24:02', '2026-04-12 10:24:02'),
(25, 2, 'keluar', 1, 'Penjualan transaksi TRX202604120003', 2, '2026-04-12 10:24:25', '2026-04-12 10:24:25');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_member` bigint UNSIGNED DEFAULT NULL,
  `nomor_unik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'produk' COMMENT 'produk, visit, membership, produk_visit, produk_membership',
  `total_harga` decimal(10,2) NOT NULL,
  `uang_bayar` decimal(10,2) NOT NULL,
  `uang_kembali` decimal(10,2) NOT NULL,
  `metode_bayar` enum('cash','debit','credit','qris') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `status_transaksi` enum('pending','success','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'success',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `data_tambahan` json DEFAULT NULL COMMENT 'Menyimpan data visit dan membership',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `id_user`, `id_member`, `nomor_unik`, `jenis_transaksi`, `total_harga`, `uang_bayar`, `uang_kembali`, `metode_bayar`, `status_transaksi`, `catatan`, `data_tambahan`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 'TRX202602210001', 'produk', 75000.00, 500000.00, 425000.00, 'cash', 'success', NULL, NULL, '2026-02-20 20:32:02', '2026-02-20 20:32:02'),
(2, 2, 3, 'TRX-20260221-0001', 'membership', 350000.00, 1000000.00, 650000.00, 'cash', 'success', NULL, '{\"produk\": [], \"tgl_mulai\": \"2026-02-21T04:28\", \"tgl_selesai\": \"2026-03-23 04:28:00\", \"subtotal_produk\": 0, \"paket_membership\": {\"id\": 1, \"nama\": \"1 bulan\", \"harga\": \"350000.00\", \"durasi_hari\": 30}}', '2026-02-20 21:29:11', '2026-02-20 21:29:11'),
(3, 2, NULL, 'TRX202602210002', 'produk', 140000.00, 200000.00, 60000.00, 'cash', 'success', NULL, NULL, '2026-02-20 23:44:30', '2026-02-20 23:44:30'),
(4, 2, NULL, 'TRX202602210003', 'visit', 25000.00, 100000.00, 75000.00, 'cash', 'success', NULL, '{\"tgl_visit\": \"2026-02-21T06:44\", \"harga_visit\": 25000}', '2026-02-20 23:45:00', '2026-02-20 23:45:00'),
(5, 2, NULL, 'TRX202602210004', 'produk_visit', 35000.00, 50000.00, 15000.00, 'cash', 'success', NULL, '{\"tgl_visit\": \"2026-02-21T06:45\", \"harga_visit\": 25000}', '2026-02-20 23:45:32', '2026-02-20 23:45:32'),
(6, 2, 4, 'TRX-20260221-0002', 'membership', 350000.00, 500000.00, 150000.00, 'cash', 'success', NULL, '{\"produk\": [], \"tgl_mulai\": \"2026-02-21T06:45\", \"tgl_selesai\": \"2026-03-23 06:45:00\", \"subtotal_produk\": 0, \"paket_membership\": {\"id\": 1, \"nama\": \"1 bulan\", \"harga\": \"350000.00\", \"durasi_hari\": 30}}', '2026-02-20 23:47:05', '2026-02-20 23:47:05'),
(7, 2, 5, 'TRX-20260304-0001', 'membership', 350000.00, 350000.00, 0.00, 'cash', 'success', NULL, '{\"produk\": [], \"id_paket\": 1, \"tgl_mulai\": \"2026-03-04T21:06\", \"nama_paket\": \"1 bulan\", \"durasi_hari\": 30, \"harga_paket\": \"350000.00\", \"tgl_selesai\": \"2026-04-03 21:06:00\", \"subtotal_produk\": 0}', '2026-03-04 14:07:33', '2026-03-04 14:07:33'),
(8, 2, NULL, 'TRX202603300001', 'produk_visit', 90000.00, 100000.00, 10000.00, 'cash', 'success', NULL, '{\"tgl_visit\": \"2026-03-30T09:58\", \"harga_visit\": 25000}', '2026-03-30 02:59:44', '2026-03-30 02:59:44'),
(9, 2, NULL, 'TRX202604050001', 'produk', 50000.00, 200000.00, 150000.00, 'cash', 'success', NULL, NULL, '2026-04-05 14:12:00', '2026-04-05 14:12:00'),
(10, 2, NULL, 'TRX202604050002', 'visit', 25000.00, 100000.00, 75000.00, 'cash', 'success', NULL, '{\"tgl_visit\": \"2026-04-05T21:12\", \"harga_visit\": 25000}', '2026-04-05 14:12:12', '2026-04-05 14:12:12'),
(11, 2, NULL, 'TRX202604050003', 'produk_visit', 155000.00, 500000.00, 345000.00, 'cash', 'success', 'makasi', '{\"tgl_visit\": \"2026-04-05T21:12\", \"harga_visit\": 25000}', '2026-04-05 14:12:41', '2026-04-05 14:12:41'),
(12, 2, 6, 'TRX-20260405-0001', 'membership', 350000.00, 500000.00, 150000.00, 'cash', 'success', NULL, '{\"produk\": [], \"id_paket\": 1, \"tgl_mulai\": \"2026-04-05T23:32\", \"nama_paket\": \"1 bulan\", \"durasi_hari\": 30, \"harga_paket\": \"350000.00\", \"tgl_selesai\": \"2026-05-05 23:32:00\", \"subtotal_produk\": 0}', '2026-04-05 16:32:35', '2026-04-05 16:32:35'),
(13, 2, NULL, 'TRX202604060001', 'visit', 25000.00, 100000.00, 75000.00, 'cash', 'success', NULL, '{\"tgl_visit\": \"2026-04-06T14:41\", \"harga_visit\": 25000}', '2026-04-06 07:42:01', '2026-04-06 07:42:01'),
(14, 2, NULL, 'TRX202604060002', 'produk', 100000.00, 200000.00, 100000.00, 'cash', 'success', NULL, NULL, '2026-04-06 07:42:19', '2026-04-06 07:42:19'),
(15, 2, NULL, 'TRX202604060003', 'produk_visit', 125000.00, 125000.00, 0.00, 'cash', 'success', NULL, '{\"tgl_visit\": \"2026-04-06T14:42\", \"harga_visit\": 25000}', '2026-04-06 07:42:32', '2026-04-06 07:42:32'),
(16, 2, NULL, 'TRX202604070001', 'produk_visit', 425000.00, 500000.00, 75000.00, 'cash', 'success', NULL, '{\"tgl_visit\": \"2026-04-07T07:15\", \"harga_visit\": 25000}', '2026-04-07 00:15:16', '2026-04-07 00:15:16'),
(17, 2, 7, 'TRX-20260407-0001', 'membership', 1000000.00, 1000000.00, 0.00, 'cash', 'success', NULL, '{\"produk\": [], \"tgl_mulai\": \"2026-04-07T07:30\", \"tgl_selesai\": \"2026-07-06 07:30:00\", \"subtotal_produk\": 0, \"paket_membership\": {\"nama\": \"3 bulan\", \"harga\": \"1000000.00\", \"id_paket\": 3, \"durasi_hari\": 90}}', '2026-04-07 00:31:44', '2026-04-07 00:31:44'),
(18, 2, 8, 'TRX-20260407-0002', 'membership', 1000000.00, 1000000.00, 0.00, 'cash', 'success', NULL, '{\"produk\": [], \"tgl_mulai\": \"2026-04-07T08:26\", \"tgl_selesai\": \"2026-07-06 08:26:00\", \"subtotal_produk\": 0, \"paket_membership\": {\"nama\": \"3 bulan\", \"harga\": \"1000000.00\", \"id_paket\": 3, \"durasi_hari\": 90}}', '2026-04-07 01:26:51', '2026-04-07 01:26:51'),
(19, 2, NULL, 'TRX202604070002', 'produk', 720000.00, 1000000.00, 280000.00, 'cash', 'success', NULL, NULL, '2026-04-07 02:47:28', '2026-04-07 02:47:28'),
(20, 2, NULL, 'TRX202604070003', 'visit', 25000.00, 25000.00, 0.00, 'cash', 'success', NULL, '{\"tgl_visit\": \"2026-04-08T10:30\", \"harga_visit\": 25000}', '2026-04-07 03:30:40', '2026-04-07 03:30:40'),
(21, 2, NULL, 'TRX202604070004', 'produk_visit', 105000.00, 200000.00, 95000.00, 'cash', 'success', NULL, '{\"tgl_visit\": \"2026-04-07 10:54:00\", \"harga_visit\": 25000}', '2026-04-07 03:54:21', '2026-04-07 03:54:21'),
(22, 2, NULL, 'TRX202604070005', 'produk', 65000.00, 500000.00, 435000.00, 'cash', 'success', NULL, NULL, '2026-04-07 03:54:30', '2026-04-07 03:54:30'),
(23, 2, NULL, 'TRX202604070006', 'visit', 25000.00, 100000.00, 75000.00, 'cash', 'success', NULL, '{\"tgl_visit\": \"2026-04-07 10:54:00\", \"harga_visit\": 25000}', '2026-04-07 03:54:40', '2026-04-07 03:54:40'),
(24, 2, 9, 'TRX-20260407-0003', 'produk_membership', 525000.00, 1000000.00, 475000.00, 'cash', 'success', NULL, '{\"produk\": [{\"qty\": 1, \"subtotal\": 10000, \"product_id\": 1, \"nama_produk\": \"es teh\", \"harga_satuan\": 10000}, {\"qty\": 1, \"subtotal\": 65000, \"product_id\": 2, \"nama_produk\": \"Creatine Monohydrate\", \"harga_satuan\": 65000}, {\"qty\": 1, \"subtotal\": 100000, \"product_id\": 4, \"nama_produk\": \"sosis\", \"harga_satuan\": 100000}], \"tgl_mulai\": \"2026-04-07T22:25\", \"tgl_selesai\": \"2026-05-07 22:25:00\", \"subtotal_produk\": 175000, \"paket_membership\": {\"nama\": \"1 bulan\", \"harga\": 350000, \"id_paket\": 1, \"durasi_hari\": 30}}', '2026-04-07 15:26:48', '2026-04-07 15:26:48'),
(25, 2, 10, 'TRX-20260407-0004', 'membership', 1000000.00, 1000000.00, 0.00, 'cash', 'success', NULL, '{\"produk\": [], \"tgl_mulai\": \"2026-04-07T22:27\", \"tgl_selesai\": \"2026-07-06 22:27:00\", \"subtotal_produk\": 0, \"paket_membership\": {\"nama\": \"3 bulan\", \"harga\": 1000000, \"id_paket\": 3, \"durasi_hari\": 90}}', '2026-04-07 15:27:39', '2026-04-07 15:27:39'),
(26, 2, 11, 'TRX-20260408-0001', 'membership', 350000.00, 500000.00, 150000.00, 'cash', 'success', NULL, '{\"produk\": [], \"tgl_mulai\": \"2026-04-08T06:15\", \"tgl_selesai\": \"2026-05-08 06:15:00\", \"subtotal_produk\": 0, \"paket_membership\": {\"nama\": \"1 bulan\", \"harga\": 350000, \"id_paket\": 1, \"durasi_hari\": 30}}', '2026-04-07 23:18:10', '2026-04-07 23:18:10'),
(27, 2, NULL, 'TRX202604080001', 'produk', 75000.00, 100000.00, 25000.00, 'cash', 'success', NULL, NULL, '2026-04-07 23:42:22', '2026-04-07 23:42:22'),
(28, 2, NULL, 'TRX202604080002', 'produk_visit', 105000.00, 200000.00, 95000.00, 'cash', 'success', NULL, '{\"tgl_visit\": \"2026-04-08 06:43:00\", \"harga_visit\": 25000}', '2026-04-07 23:43:28', '2026-04-07 23:43:28'),
(29, 2, 12, 'TRX-20260408-0002', 'produk_membership', 415000.00, 500000.00, 85000.00, 'cash', 'success', NULL, '{\"produk\": [{\"qty\": 1, \"subtotal\": 65000, \"product_id\": 2, \"nama_produk\": \"Creatine Monohydrate\", \"harga_satuan\": 65000}], \"tgl_mulai\": \"2026-04-08T18:44\", \"tgl_selesai\": \"2026-05-08 18:44:00\", \"subtotal_produk\": 65000, \"paket_membership\": {\"nama\": \"1 bulan\", \"harga\": 350000, \"id_paket\": 1, \"durasi_hari\": 30}}', '2026-04-08 11:44:43', '2026-04-08 11:44:43'),
(30, 2, NULL, 'TRX202604090001', 'produk', 65000.00, 100000.00, 35000.00, 'cash', 'success', NULL, NULL, '2026-04-09 03:37:56', '2026-04-09 03:37:56'),
(31, 2, NULL, 'TRX202604090002', 'visit', 25000.00, 200000.00, 175000.00, 'cash', 'success', NULL, '{\"tgl_visit\": \"2026-04-09 10:38:00\", \"harga_visit\": 25000}', '2026-04-09 03:38:05', '2026-04-09 03:38:05'),
(32, 2, NULL, 'TRX202604090003', 'produk_visit', 35000.00, 200000.00, 165000.00, 'cash', 'success', NULL, '{\"tgl_visit\": \"2026-04-09 10:38:00\", \"harga_visit\": 25000}', '2026-04-09 03:38:19', '2026-04-09 03:38:19'),
(33, 2, 13, 'TRX-20260409-0001', 'membership', 350000.00, 500000.00, 150000.00, 'cash', 'success', NULL, '{\"produk\": [], \"tgl_mulai\": \"2026-04-09T10:38\", \"tgl_selesai\": \"2026-05-09 10:38:00\", \"subtotal_produk\": 0, \"paket_membership\": {\"nama\": \"1 bulan\", \"harga\": 350000, \"id_paket\": 1, \"durasi_hari\": 30}}', '2026-04-09 03:40:24', '2026-04-09 03:40:24'),
(34, 2, 14, 'TRX-20260409-0002', 'produk_membership', 1070000.00, 1070000.00, 0.00, 'cash', 'success', NULL, '{\"produk\": [{\"qty\": 7, \"subtotal\": 70000, \"product_id\": 1, \"nama_produk\": \"es teh\", \"harga_satuan\": 10000}], \"tgl_mulai\": \"2026-04-09T10:40\", \"tgl_selesai\": \"2026-07-08 10:40:00\", \"subtotal_produk\": 70000, \"paket_membership\": {\"nama\": \"3 bulan\", \"harga\": 1000000, \"id_paket\": 3, \"durasi_hari\": 90}}', '2026-04-09 03:42:32', '2026-04-09 03:42:32'),
(35, 2, 15, 'TRX-20260410-0001', 'membership', 1000000.00, 1000000.00, 0.00, 'cash', 'success', NULL, '{\"produk\": [], \"tgl_mulai\": \"2026-04-10T06:51\", \"tgl_selesai\": \"2026-07-09 06:51:00\", \"subtotal_produk\": 0, \"paket_membership\": {\"nama\": \"3 bulan\", \"harga\": 1000000, \"id_paket\": 3, \"durasi_hari\": 90}}', '2026-04-09 23:52:16', '2026-04-09 23:52:16'),
(36, 2, 12, 'TRX-20260410-0002', 'produk_membership', 390000.00, 500000.00, 110000.00, 'cash', 'success', NULL, '{\"produk\": [{\"qty\": 4, \"subtotal\": 40000, \"product_id\": 1, \"nama_produk\": \"es teh\", \"harga_satuan\": 10000}], \"tgl_mulai\": \"2026-04-10T08:31\", \"is_renewal\": true, \"tgl_selesai\": \"2026-05-10 08:31:00\", \"subtotal_produk\": 40000, \"paket_membership\": {\"nama\": \"1 bulan\", \"harga\": 350000, \"id_paket\": 1, \"durasi_hari\": 30}}', '2026-04-10 01:32:19', '2026-04-10 01:32:19'),
(37, 2, 3, 'TRX-20260410-0003', 'membership', 1000000.00, 1000000.00, 0.00, 'cash', 'success', NULL, '{\"produk\": [], \"tgl_mulai\": \"2026-04-10T08:45\", \"is_renewal\": true, \"tgl_selesai\": \"2026-07-09 08:45:00\", \"subtotal_produk\": 0, \"paket_membership\": {\"nama\": \"3 bulan\", \"harga\": 1000000, \"id_paket\": 3, \"durasi_hari\": 90}}', '2026-04-10 01:45:26', '2026-04-10 01:45:26'),
(38, 2, NULL, 'TRX202604110001', 'produk', 65000.00, 200000.00, 135000.00, 'cash', 'success', NULL, NULL, '2026-04-11 12:58:37', '2026-04-11 12:58:37'),
(39, 2, 16, 'TRX-20260412-0001', 'membership', 350000.00, 1000000.00, 650000.00, 'cash', 'success', 'asik', '{\"produk\": [], \"tgl_mulai\": \"2026-04-12T17:12\", \"is_renewal\": false, \"tgl_selesai\": \"2026-05-12 17:12:00\", \"subtotal_produk\": 0, \"paket_membership\": {\"nama\": \"1 bulan\", \"harga\": 350000, \"id_paket\": 1, \"durasi_hari\": 30}}', '2026-04-12 10:13:36', '2026-04-12 10:13:36'),
(40, 2, NULL, 'TRX202604120001', 'produk', 65000.00, 100000.00, 35000.00, 'cash', 'success', NULL, NULL, '2026-04-12 10:24:02', '2026-04-12 10:24:02'),
(41, 2, NULL, 'TRX202604120002', 'visit', 25000.00, 50000.00, 25000.00, 'cash', 'success', NULL, '{\"tgl_visit\": \"2026-04-12 17:24:00\", \"harga_visit\": 25000}', '2026-04-12 10:24:12', '2026-04-12 10:24:12'),
(42, 2, NULL, 'TRX202604120003', 'produk_visit', 90000.00, 100000.00, 10000.00, 'cash', 'success', NULL, '{\"tgl_visit\": \"2026-04-12 17:24:00\", \"harga_visit\": 25000}', '2026-04-12 10:24:25', '2026-04-12 10:24:25');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id` bigint UNSIGNED NOT NULL,
  `id_transaction` bigint UNSIGNED NOT NULL,
  `id_product` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`id`, `id_transaction`, `id_product`, `qty`, `harga_satuan`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 65000.00, 65000.00, '2026-02-20 20:32:02', '2026-02-20 20:32:02'),
(2, 1, 1, 1, 10000.00, 10000.00, '2026-02-20 20:32:02', '2026-02-20 20:32:02'),
(3, 3, 2, 2, 65000.00, 130000.00, '2026-02-20 23:44:30', '2026-02-20 23:44:30'),
(4, 3, 1, 1, 10000.00, 10000.00, '2026-02-20 23:44:30', '2026-02-20 23:44:30'),
(5, 5, 1, 1, 10000.00, 10000.00, '2026-02-20 23:45:32', '2026-02-20 23:45:32'),
(6, 8, 2, 1, 65000.00, 65000.00, '2026-03-30 02:59:44', '2026-03-30 02:59:44'),
(7, 9, 1, 5, 10000.00, 50000.00, '2026-04-05 14:12:00', '2026-04-05 14:12:00'),
(8, 11, 2, 2, 65000.00, 130000.00, '2026-04-05 14:12:41', '2026-04-05 14:12:41'),
(9, 14, 4, 1, 100000.00, 100000.00, '2026-04-06 07:42:19', '2026-04-06 07:42:19'),
(10, 15, 4, 1, 100000.00, 100000.00, '2026-04-06 07:42:32', '2026-04-06 07:42:32'),
(11, 16, 4, 4, 100000.00, 400000.00, '2026-04-07 00:15:16', '2026-04-07 00:15:16'),
(12, 19, 1, 72, 10000.00, 720000.00, '2026-04-07 02:47:29', '2026-04-07 02:47:29'),
(13, 21, 1, 8, 10000.00, 80000.00, '2026-04-07 03:54:21', '2026-04-07 03:54:21'),
(14, 22, 2, 1, 65000.00, 65000.00, '2026-04-07 03:54:30', '2026-04-07 03:54:30'),
(15, 24, 1, 1, 10000.00, 10000.00, '2026-04-07 15:26:48', '2026-04-07 15:26:48'),
(16, 24, 2, 1, 65000.00, 65000.00, '2026-04-07 15:26:48', '2026-04-07 15:26:48'),
(17, 24, 4, 1, 100000.00, 100000.00, '2026-04-07 15:26:48', '2026-04-07 15:26:48'),
(18, 27, 2, 1, 65000.00, 65000.00, '2026-04-07 23:42:22', '2026-04-07 23:42:22'),
(19, 27, 1, 1, 10000.00, 10000.00, '2026-04-07 23:42:22', '2026-04-07 23:42:22'),
(20, 28, 1, 8, 10000.00, 80000.00, '2026-04-07 23:43:28', '2026-04-07 23:43:28'),
(21, 29, 2, 1, 65000.00, 65000.00, '2026-04-08 11:44:43', '2026-04-08 11:44:43'),
(22, 30, 2, 1, 65000.00, 65000.00, '2026-04-09 03:37:56', '2026-04-09 03:37:56'),
(23, 32, 1, 1, 10000.00, 10000.00, '2026-04-09 03:38:19', '2026-04-09 03:38:19'),
(24, 34, 1, 7, 10000.00, 70000.00, '2026-04-09 03:42:32', '2026-04-09 03:42:32'),
(25, 36, 1, 4, 10000.00, 40000.00, '2026-04-10 01:32:19', '2026-04-10 01:32:19'),
(26, 38, 2, 1, 65000.00, 65000.00, '2026-04-11 12:58:37', '2026-04-11 12:58:37'),
(27, 40, 2, 1, 65000.00, 65000.00, '2026-04-12 10:24:02', '2026-04-12 10:24:02'),
(28, 42, 2, 1, 65000.00, 65000.00, '2026-04-12 10:24:25', '2026-04-12 10:24:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','kasir','owner') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kasir',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `role`, `status`, `last_login`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', '$2y$12$7xgo2UmYRNRiKa2j5MgVS.KWyvk/0oQZMjJeiRRt9zRLD28hbkhEq', 'Administrator', 'admin', 1, '2026-04-12 15:31:37', '2026-02-20 20:14:28', '2026-04-12 15:31:37', NULL),
(2, 'kasir', '$2y$12$pY63YyP5rHAN2B2y8dz55OzOJJvqh3nB4S94LTkKBc9w/9o1yKUUq', 'Kasir Utama', 'kasir', 1, '2026-04-12 15:37:20', '2026-02-20 20:14:29', '2026-04-12 15:37:20', NULL),
(3, 'owner', '$2y$12$tkKMS8Mrhv3M3B0z690DT.6VNvmKEVOczU.8lm7O9X.7ONrHcuR46', 'Pemilik Gym', 'owner', 1, '2026-04-12 13:30:23', '2026-02-20 20:14:31', '2026-04-12 13:48:33', NULL),
(4, 'asep', '$2y$12$lnTziNBr.YJiPLy22fAhlOun/xf6Dc4gRPZiR9.t0iO0ed0tz/QAy', 'asep ganteng', 'admin', 1, '2026-02-25 12:28:51', '2026-02-20 20:30:03', '2026-02-25 05:28:51', NULL),
(5, 'asaikaa', '$2y$12$puYRp0ue3E50993xKGgTz.TYzWnkEZXt4aWUUFMuF7JbhQ9x4zgle', 'asasaksakas', 'kasir', 0, '2026-03-05 05:05:53', '2026-03-05 05:05:29', '2026-03-31 21:16:51', '2026-03-31 21:16:51'),
(6, 'buyati', '$2y$12$XO7oU3haKbV2taosfVv1oOf/5LYsqQyBEyEMjj5/OH7WWUA/drS3i', 'ibuuu yati icicii', 'kasir', 0, NULL, '2026-04-06 06:02:03', '2026-04-07 00:52:18', '2026-04-07 00:52:18'),
(7, 'padzikri', '$2y$12$R/g.12silGd/LnwUNFm55ugT1HTSrW7KInJ63DOvshTbCTK1ahtsy', 'dzikri pangestu', 'admin', 1, NULL, '2026-04-07 00:48:19', '2026-04-07 00:48:19', NULL),
(8, 'kasiroo', '$2y$12$DvXyUuyQTQXszbT7zjaQSOEj1TGZQQqqPA9EJfHHNO9QY.UT0ntgq', 'kasirnya traxfit', 'kasir', 1, NULL, '2026-04-08 13:08:33', '2026-04-10 06:35:00', NULL);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gym_settings`
--
ALTER TABLE `gym_settings`
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
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_id_user_foreign` (`id_user`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `members_kode_member_unique` (`kode_member`),
  ADD UNIQUE KEY `members_no_identitas_unique` (`no_identitas`),
  ADD KEY `members_id_paket_foreign` (`id_paket`),
  ADD KEY `members_nama_telepon_index` (`nama`,`telepon`);

--
-- Indexes for table `membership_packages`
--
ALTER TABLE `membership_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_checkin`
--
ALTER TABLE `member_checkin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_checkin_id_member_foreign` (`id_member`),
  ADD KEY `member_checkin_id_kasir_foreign` (`id_kasir`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_kategori_foreign` (`kategori`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok_log`
--
ALTER TABLE `stok_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stok_log_id_product_foreign` (`id_product`),
  ADD KEY `stok_log_id_user_foreign` (`id_user`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_nomor_unik_unique` (`nomor_unik`),
  ADD KEY `transactions_id_user_foreign` (`id_user`),
  ADD KEY `transactions_id_member_foreign` (`id_member`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_details_id_transaction_foreign` (`id_transaction`),
  ADD KEY `transaction_details_id_product_foreign` (`id_product`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gym_settings`
--
ALTER TABLE `gym_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=881;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `membership_packages`
--
ALTER TABLE `membership_packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `member_checkin`
--
ALTER TABLE `member_checkin`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stok_log`
--
ALTER TABLE `stok_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_id_paket_foreign` FOREIGN KEY (`id_paket`) REFERENCES `membership_packages` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `member_checkin`
--
ALTER TABLE `member_checkin`
  ADD CONSTRAINT `member_checkin_id_kasir_foreign` FOREIGN KEY (`id_kasir`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `member_checkin_id_member_foreign` FOREIGN KEY (`id_member`) REFERENCES `members` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_kategori_foreign` FOREIGN KEY (`kategori`) REFERENCES `product_categories` (`id`);

--
-- Constraints for table `stok_log`
--
ALTER TABLE `stok_log`
  ADD CONSTRAINT `stok_log_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `stok_log_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_id_member_foreign` FOREIGN KEY (`id_member`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `transactions_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `transaction_details_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `transaction_details_id_transaction_foreign` FOREIGN KEY (`id_transaction`) REFERENCES `transactions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
