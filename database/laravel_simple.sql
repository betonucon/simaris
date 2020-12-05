-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2020 at 04:06 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `polda`
--

-- --------------------------------------------------------

--
-- Table structure for table `judul_halaman`
--

CREATE TABLE `judul_halaman` (
  `id` int(5) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `judul` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `judul_halaman`
--

INSERT INTO `judul_halaman` (`id`, `name`, `judul`) VALUES
(1, 'home', 'Halaman Utama');

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
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `title`
--

CREATE TABLE `title` (
  `id` int(5) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `title` text DEFAULT NULL,
  `isi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `title`
--

INSERT INTO `title` (`id`, `name`, `title`, `isi`) VALUES
(1, 'siswa', 'fdsdsf dfdsdsf dfdsfdsf dfdsf', 'ewrewrewrewv fdsfdsf dsfdsdsf dsfdsfd dfdsfds afdsf'),
(2, 'tambah_siswa', 'dsfsd ', 'sgdgdd dgdsgs dgds'),
(3, 'tambah_tahun', 'ya sudah lah', 'fdsf xczx zxczx zxc zxczxczxc czxcefaf dfdf afafafa afaf adfdaf afad'),
(4, 'tambah_title', 'Halaman Ubah Judul Halaman', 'Sialhkan ubah'),
(5, 'title', 'Halaman Judul', 'Proses data sesuai pedoman'),
(6, 'view_siswa', 'Halaman Detail Kelas', 'Terlampir data riwayat kelas '),
(7, 'spp', 'Halaman Master SPP', 'Master pembuatan biaya SPP per tahun ajaran dan per kelas'),
(8, 'rekapan_spp', 'Halaman Rekapan SPP', 'Halaman Rekapan SPP'),
(9, 'rekapan_daftar', 'Halaman Rekapan Daftar Ulang', 'Halaman Rekapan Daftar Ulang'),
(10, 'siswa_kelas', 'Halaman Kelas SIswa', 'Halaman Kelas SIswa'),
(11, 'rekapan_keuangan', 'Halaman Rekapan Keuangan', 'Halaman Rekapan Keuangan'),
(12, 'donasi', 'Halaman Pendataan Donasi ererere', 'Halaman Pendataan Donasi'),
(14, 'daftar_ulang', 'Halaman Master Daftar Ulang', 'Halaman Master Daftar Ulang'),
(15, 'transaksi_keuangan', 'Halaman Transaksi Keuangan', 'Halaman Transaksi Keuangan'),
(16, 'home_admin', 'Halaman Utama', 'Halaman Utama'),
(17, 'titlenya', 'test kegiatan sss', 'sddfdsf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `kode`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`) VALUES
(1, '12345678', 'arkan', 'uconbeton@gmail.com', NULL, '$2y$10$UyycqKOuN1uN1O62pDv6SOOElB.XxyTv7QPmaOwLlogwXsOIeUDWe', NULL, '2020-10-13 19:53:59', '2020-10-13 19:53:59', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `judul_halaman`
--
ALTER TABLE `judul_halaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `title`
--
ALTER TABLE `title`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_kode_unique` (`kode`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `judul_halaman`
--
ALTER TABLE `judul_halaman`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `title`
--
ALTER TABLE `title`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
