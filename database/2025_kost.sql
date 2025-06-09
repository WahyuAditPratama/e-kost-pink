-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2025 at 04:56 PM
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
-- Database: `2025_kost`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_room` int(11) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `harga_bulanan` int(11) NOT NULL DEFAULT 500000,
  `status` enum('draft','konfirmasi','proses','aktif','selesai','batal') NOT NULL DEFAULT 'proses',
  `deposit_amount` int(11) DEFAULT 0,
  `catatan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `id_customer`, `id_room`, `start_date`, `end_date`, `harga_bulanan`, `status`, `deposit_amount`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-04-25', '2025-04-30', 800000, 'selesai', NULL, '-', '2025-04-25 21:46:28', '2025-05-09 14:51:40'),
(2, 2, 3, '2025-05-02', '2025-12-27', 800000, 'selesai', NULL, '-', '2025-04-26 19:19:23', '2025-05-07 18:53:17'),
(3, 2, 2, '2025-04-30', '2025-06-30', 800000, 'selesai', 800000, '-', '2025-04-27 00:00:46', '2025-05-07 18:49:29'),
(4, 2, 4, '2025-05-01', '2025-07-31', 500000, 'aktif', 500000, '-', '2025-04-27 02:14:18', '2025-05-09 10:00:47'),
(5, 4, 2, '2025-05-01', '2025-06-30', 800000, 'selesai', 800000, '-', '2025-04-27 03:24:33', '2025-05-07 17:26:02'),
(6, 5, 3, '2025-05-12', '2025-05-31', 800000, 'selesai', 800000, '', '2025-05-09 06:39:04', '2025-05-09 14:51:13');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('9cs8aoof33iccgv999m34aeuhen58nhi', '180.243.25.202', 1690990835, 0x5f5f63695f6c6173745f726567656e65726174657c693a313639303939303833353b),
('esc5iv9umsakpbnnptl862hrkjvii7l3', '180.254.173.96', 1694791904, 0x5f5f63695f6c6173745f726567656e65726174657c693a313639343739313832343b6c6f67696e5f73657373696f6e7c613a353a7b733a373a227365735f756964223b733a313a2231223b733a383a227365735f6e616d61223b733a373a22427564696d616e223b733a393a227365735f6c6576656c223b733a31333a2241646d696e6973747261746f72223b733a393a226c6f676765645f696e223b623a313b733a393a2274696d657374616d70223b693a313639343739313838353b7d),
('etsjbhng35luq2542f7jitm6ojsj8fda', '36.69.227.225', 1690798472, 0x5f5f63695f6c6173745f726567656e65726174657c693a313639303739383437323b),
('ivs46vrsghgv9c3i6e8fesqb42eps6as', '36.69.227.225', 1690689594, 0x5f5f63695f6c6173745f726567656e65726174657c693a313639303638393539343b),
('km9uvtjn65kbahvpd7tlscsc83mon0t5', '180.254.173.96', 1694449659, 0x5f5f63695f6c6173745f726567656e65726174657c693a313639343434393535393b),
('nag8m6g3pvnp3p07rsk7qtpvipptqbno', '140.213.11.30', 1690798472, 0x5f5f63695f6c6173745f726567656e65726174657c693a313639303739383437323b),
('to3vt87ab50b16v24guuvgbgt5c7s4kq', '::1', 1719226586, 0x5f5f63695f6c6173745f726567656e65726174657c693a313731393232363435343b6c6f67696e5f73657373696f6e7c613a353a7b733a373a227365735f756964223b733a313a2231223b733a383a227365735f6e616d61223b733a373a22427564696d616e223b733a393a227365735f6c6576656c223b733a31333a2241646d696e6973747261746f72223b733a393a226c6f676765645f696e223b623a313b733a393a2274696d657374616d70223b693a313731393232363532373b7d);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `nama_customer` varchar(25) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telepon` varchar(14) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `status` enum('aktif','tidak aktif') DEFAULT NULL,
  `session` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `nama_customer`, `email`, `telepon`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `username`, `password`, `avatar`, `status`, `session`, `created_at`, `updated_at`) VALUES
(1, 'Agus Hidayat', 'customer@mbt.com', '09384204234322', '2024-07-27', 'Laki-Laki', 'Jakarta Selatan', 'customer', '$2y$10$lYAniTzJDy8elhG/9UKOj.hH7O5GiuJllo0dZCyKIENRA4tOlHV.G', '', 'aktif', NULL, '2025-04-27 03:23:12', '2025-04-26 20:23:12'),
(2, 'Ahmad Fatoni', 'afahernandes@gmail.com', '0678678678678', '2024-07-02', 'Laki-Laki', 'Jakarta Selatan', 'ahmad', '$2y$10$K5tsWelQhrvcih0q8Gjy1u/HXzDu4AHlkmsIkdH2e.6l6.ODUnRNm', '', 'aktif', 'utkkj8j304nknabcl42ke6i9t46hphhh', '2025-04-27 03:23:18', '2025-04-26 20:23:18'),
(3, 'bagas', 'baga2s@gmail.com', '09802580435', '2022-10-12', 'Laki-Laki', 'Jakarta Selatan', 'bagas2', '$2y$10$skIeaeiOUS.jq6E42WpIt.oVuswELCndXImOxHSM5rIxKLIUcAivu', 'user.png', 'aktif', NULL, '2025-04-27 05:32:13', '2025-04-26 22:32:13'),
(4, 'Budiman', 'budiman@mail.com', '08234203', NULL, NULL, NULL, 'budiman', '$2y$10$LgaA21AnPxop4ssmu5BJKO1arEBvSo8u.ViatQTlMrkj303RMiaOq', 'user.png', 'aktif', NULL, '2025-04-27 10:23:14', NULL),
(5, 'Nico Marvels', 'nico@gmail.com', '0855456466461', NULL, NULL, NULL, 'nico', '$2y$10$x9BOa0ZbldkCiaAGg4xxK.4RTsUebU1J5YouVXI1615wi8SVjnw2e', 'user.png', 'aktif', NULL, '2025-05-09 13:38:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pesan` text DEFAULT NULL,
  `penerima` varchar(45) DEFAULT NULL,
  `pengirim` int(11) NOT NULL,
  `dibaca` enum('belum','sudah') NOT NULL DEFAULT 'belum',
  `judul` varchar(255) DEFAULT NULL,
  `parameter` varchar(255) DEFAULT NULL,
  `ref_id` varchar(255) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` varchar(100) DEFAULT NULL,
  `dihapus` enum('ya','tidak') NOT NULL DEFAULT 'tidak',
  `created_by` varchar(80) DEFAULT NULL,
  `updated_by` varchar(80) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `deletedby` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `pesan`, `penerima`, `pengirim`, `dibaca`, `judul`, `parameter`, `ref_id`, `booking_id`, `invoice_id`, `status`, `created_at`, `dihapus`, `created_by`, `updated_by`, `updated_at`, `deleted`, `deletedby`) VALUES
(1, 'Booking Anda telah dikonfirmasi dengan status: aktif', '2', 0, 'belum', 'Konfirmasi Booking', 'booking', '2', 2, NULL, '', '2025-04-27 02:28:41', 'tidak', NULL, NULL, NULL, NULL, NULL),
(2, 'Booking Anda telah dikonfirmasi dengan status: aktif', '2', 0, 'belum', 'Konfirmasi Booking', 'booking', '4', 4, NULL, '', '2025-04-27 09:17:53', 'tidak', NULL, NULL, NULL, NULL, NULL),
(3, 'Booking Anda telah dikonfirmasi dengan status: aktif', '4', 0, 'belum', 'Konfirmasi Booking', 'booking', '5', 5, NULL, '', '2025-04-27 10:25:42', 'tidak', NULL, NULL, NULL, NULL, NULL),
(4, 'Booking Anda telah dikonfirmasi dengan status: terima', '2', 0, 'belum', 'Konfirmasi Booking', 'booking', '3', 3, NULL, '', '2025-05-04 07:53:49', 'tidak', NULL, NULL, NULL, NULL, NULL),
(5, 'Booking Anda telah dikonfirmasi dengan status: aktif', '4', 0, 'belum', 'Konfirmasi Booking', 'booking', '5', 5, NULL, '', '2025-05-04 07:59:45', 'tidak', NULL, NULL, NULL, NULL, NULL),
(6, 'Booking Anda telah dikonfirmasi dengan status: aktif', '4', 0, 'belum', 'Konfirmasi Booking', 'booking', '5', 5, NULL, '', '2025-05-04 08:03:14', 'tidak', NULL, NULL, NULL, NULL, NULL),
(7, 'Booking Anda telah dikonfirmasi dengan status: aktif', '2', 0, 'belum', 'Konfirmasi Booking', 'booking', '4', 4, NULL, '', '2025-05-04 10:22:21', 'tidak', NULL, NULL, NULL, NULL, NULL),
(8, 'Booking Anda telah dikonfirmasi dengan status: aktif', '2', 0, 'belum', 'Konfirmasi Booking', 'booking', '3', 3, NULL, '', '2025-05-07 17:30:04', 'tidak', NULL, NULL, NULL, NULL, NULL),
(9, 'Booking Anda telah dikonfirmasi dengan status: aktif', '2', 0, 'belum', 'Konfirmasi Booking', 'booking', '2', 2, NULL, '', '2025-05-07 18:49:57', 'tidak', NULL, NULL, NULL, NULL, NULL),
(10, 'Booking Anda telah dikonfirmasi dengan status: aktif', '1', 0, 'belum', 'Konfirmasi Booking', 'booking', '1', 1, NULL, '', '2025-05-07 18:51:52', 'tidak', NULL, NULL, NULL, NULL, NULL),
(11, 'Booking Anda telah dikonfirmasi dengan status: aktif', '5', 0, 'belum', 'Konfirmasi Booking', 'booking', '6', 6, NULL, '', '2025-05-09 13:43:18', 'tidak', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_room` varchar(100) DEFAULT NULL,
  `fitur` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga_bulanan` int(11) DEFAULT 500000,
  `gambar` text NOT NULL,
  `status` enum('tersedia','disewa','maintenance') DEFAULT 'tersedia',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `nama_room`, `fitur`, `deskripsi`, `harga_bulanan`, `gambar`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Kamar 1', 'Kamar ini berada di lantai 2 dan kamar ini mempunyai luas 4x6 m.  ada jendela, kasur dan lemari. kamar mandi di dalam', 'Kamar ini berada di lantai 2 dan kamar ini mempunyai luas 4x6 m.  ada jendela, kasur dan lemari. kamar mandi di dalam', 800000, '81719905761_5892bb186e22f303ffe3.png', 'tersedia', '2025-05-09 14:51:40', NULL),
(2, 'Kamar 2', 'Kamar ini berada di lantai 1 dan kamar ini mempunyai luas 4x6 m. ada jendela, kasur dan lemari. kamar mandi di dalam', 'Kamar ini berada di lantai 1 dan kamar ini mempunyai luas 4x6 m. ada jendela, kasur dan lemari. kamar mandi di dalam', 800000, '81719905921_1ee6029bb596e07e77dc.png', 'tersedia', '2025-05-07 18:49:29', NULL),
(3, 'Kamar 3', 'Kamar ini berada di lantai 1 dan kamar ini mempunyai luas 4x6 m. ada jendela, kasur dan lemari. kamar mandi di dalam', 'Kamar ini berada di lantai 1 dan kamar ini mempunyai luas 4x6 m. ada jendela, kasur dan lemari. kamar mandi di dalam', 800000, '81719905951_bb55264232a616bc8d02.png', 'tersedia', '2025-05-09 14:51:13', NULL),
(4, 'Kamar 4', 'Kamar ini berada di lantai 1 dan kamar ini mempunyai luas 4x6 m. ada jendela, kasur dan lemari. kamar mandi di dalam', 'Kamar ini berada di lantai 1 dan kamar ini mempunyai luas 4x6 m. ada jendela, kasur dan lemari. kamar mandi di dalam', 500000, '81719905982_06956726896402408fff.png', 'tersedia', '2025-05-07 18:47:24', NULL),
(5, 'Kamar 5', 'Kamar ini berada di lantai 1 dan kamar ini mempunyai luas 4x6 m. ada jendela, kasur dan lemari. kamar mandi di dalam', 'Kamar ini berada di lantai 1 dan kamar ini mempunyai luas 4x6 m. ada jendela, kasur dan lemari. kamar mandi di dalam', 550000, '81719906005_6d3103e053bfbf7bb839.png', 'tersedia', '2025-04-27 02:18:56', NULL),
(6, 'Kamar 6', 'Kamar ini berada di lantai 1 dan kamar ini mempunyai luas 4x6 m. ada jendela, kasur dan lemari. kamar mandi di dalam', 'Kamar ini berada di lantai 1 dan kamar ini mempunyai luas 4x6 m. ada jendela, kasur dan lemari. kamar mandi di dalam', 500000, '81719906033_622660c28fb9639819d0.png', 'tersedia', '2025-04-27 02:19:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `room_status_history`
--

CREATE TABLE `room_status_history` (
  `id` int(11) NOT NULL,
  `id_room` int(11) UNSIGNED NOT NULL,
  `status` enum('available','occupied','maintenance') NOT NULL,
  `changed_by` int(11) DEFAULT NULL COMMENT 'user_id who changed the status',
  `reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tagihan_bulanan`
--

CREATE TABLE `tagihan_bulanan` (
  `id` int(11) NOT NULL,
  `id_booking` int(11) NOT NULL,
  `no_invoice` varchar(255) NOT NULL,
  `bulan` tinyint(2) NOT NULL,
  `tahun` year(4) NOT NULL,
  `due_date` date NOT NULL,
  `nominal` int(11) NOT NULL,
  `status` enum('pending','proses','lunas','batal','overdue') DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tagihan_bulanan`
--

INSERT INTO `tagihan_bulanan` (`id`, `id_booking`, `no_invoice`, `bulan`, `tahun`, `due_date`, `nominal`, `status`, `payment_method`, `payment_date`, `payment_proof`, `created_at`, `updated_at`) VALUES
(1, 5, 'INV-05040001', 5, '2025', '2025-05-01', 800000, 'lunas', NULL, NULL, NULL, '2025-05-04 01:03:14', '2025-05-07 18:27:26'),
(2, 5, 'INV-05040002', 6, '2025', '2025-06-01', 800000, 'lunas', NULL, NULL, NULL, '2025-05-04 01:03:14', '2025-05-07 18:27:26'),
(3, 4, 'INV-05040003', 5, '2025', '2025-05-01', 500000, 'lunas', 'Transfer', '2025-05-04 10:23:29', '1746354209_79aeaa84a3df37203a62.jpg', '2025-05-04 03:22:21', '2025-05-09 10:02:04'),
(4, 4, 'INV-05040004', 6, '2025', '2025-06-01', 500000, 'lunas', 'Cash', '2025-05-04 10:23:46', NULL, '2025-05-04 03:22:21', '2025-05-09 10:09:19'),
(5, 4, 'INV-05040005', 7, '2025', '2025-07-01', 500000, 'lunas', NULL, NULL, NULL, '2025-05-04 03:22:21', '2025-05-07 18:27:26'),
(6, 3, 'INV-05070006', 4, '2025', '2025-04-30', 800000, 'lunas', NULL, NULL, NULL, '2025-05-07 10:30:04', '2025-05-07 18:27:26'),
(7, 3, 'INV-05070007', 5, '2025', '2025-05-30', 800000, 'lunas', NULL, NULL, NULL, '2025-05-07 10:30:04', '2025-05-07 18:27:26'),
(8, 3, 'INV-05070008', 6, '2025', '2025-06-30', 800000, 'lunas', NULL, NULL, NULL, '2025-05-07 10:30:04', '2025-05-07 18:27:26'),
(9, 3, 'INV/681BAA1D21B8E', 8, '2025', '2025-06-30', 800000, 'batal', NULL, NULL, NULL, '2025-05-07 18:44:45', '2025-05-07 18:49:29'),
(10, 4, 'INV/681BAA1D237D5', 8, '2025', '2025-06-30', 500000, 'batal', NULL, NULL, NULL, '2025-05-07 18:44:45', '2025-05-07 18:47:24'),
(11, 2, 'INV-05070011', 5, '2025', '2025-05-02', 800000, 'batal', NULL, NULL, NULL, '2025-05-07 11:49:57', '2025-05-07 18:53:17'),
(12, 2, 'INV-05070012', 6, '2025', '2025-06-02', 800000, 'batal', NULL, NULL, NULL, '2025-05-07 11:49:57', '2025-05-07 18:53:17'),
(13, 2, 'INV-05070013', 7, '2025', '2025-07-02', 800000, 'batal', NULL, NULL, NULL, '2025-05-07 11:49:57', '2025-05-07 18:53:17'),
(14, 2, 'INV-05070014', 8, '2025', '2025-08-02', 800000, 'batal', NULL, NULL, NULL, '2025-05-07 11:49:57', '2025-05-07 18:53:17'),
(15, 2, 'INV-05070015', 9, '2025', '2025-09-02', 800000, 'batal', NULL, NULL, NULL, '2025-05-07 11:49:57', '2025-05-07 18:53:17'),
(16, 2, 'INV-05070016', 10, '2025', '2025-10-02', 800000, 'batal', NULL, NULL, NULL, '2025-05-07 11:49:57', '2025-05-07 18:53:17'),
(17, 2, 'INV-05070017', 11, '2025', '2025-11-02', 800000, 'batal', NULL, NULL, NULL, '2025-05-07 11:49:57', '2025-05-07 18:53:17'),
(18, 2, 'INV-05070018', 12, '2025', '2025-12-02', 800000, 'batal', NULL, NULL, NULL, '2025-05-07 11:49:57', '2025-05-07 18:53:17'),
(19, 1, 'INV-05070019', 4, '2025', '2025-04-25', 800000, 'batal', NULL, NULL, NULL, '2025-05-07 11:51:52', '2025-05-09 14:51:40'),
(20, 1, 'INV/681BABE6108C3', 11, '2025', '2025-06-30', 800000, 'batal', NULL, NULL, NULL, '2025-05-07 18:52:22', '2025-05-09 14:51:40'),
(21, 6, 'INV-05090021', 5, '2025', '2025-05-12', 800000, 'lunas', 'Transfer', '2025-05-09 13:47:25', '1746798445_5f3c3cc506b9a577476d.jpg', '2025-05-09 06:43:18', '2025-05-09 13:48:23'),
(22, 1, 'INV/681E1620DC968', 6, '2025', '2025-06-30', 800000, 'batal', NULL, NULL, NULL, '2025-05-09 14:50:08', '2025-05-09 14:51:40'),
(23, 6, 'INV/681E1620DDE30', 6, '2025', '2025-06-30', 800000, 'batal', NULL, NULL, NULL, '2025-05-09 14:50:08', '2025-05-09 14:51:13');

-- --------------------------------------------------------

--
-- Table structure for table `termination_requests`
--

CREATE TABLE `termination_requests` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `requested_by` int(11) NOT NULL COMMENT 'customer_id or admin_id',
  `request_date` date NOT NULL,
  `termination_date` date NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `processed_by` int(11) DEFAULT NULL,
  `processed_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `rolesid` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(128) NOT NULL,
  `foto` varchar(255) NOT NULL DEFAULT 'avatar.png',
  `token` varchar(255) DEFAULT NULL,
  `session` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `rolesid`, `username`, `password`, `nama`, `email`, `foto`, `token`, `session`, `status`) VALUES
(8, '1', 'superadmin', '$2y$10$cABy8FM1N2IJX9Uu3W0TQeYB6Q/10OfL./spQS9u4BdagYIAMBNp2', 'Afa hernandes', 'administrator@gmail.com', 'default.png', '2b08da792f73af886deb259feb0c69785d8e21c0', 'ggn3ogfdvqhoicqialh6optim46sah9a', 1),
(9, '1', 'admin2', '$2y$10$ueVaQp6osyrF7vfgrksVEOScDdTaV5BhbgjZRll4Bnr0fP6Dwf0py', 'Ahmad Fatoni', 'afahernandes2@gmail.com', 'avatar.png', '260a0d6d49f90adbc5a58e7e9137d4962bda90f9', NULL, 1),
(10, '9', 'fitriana', '$2y$10$ttn5KOIz45H42Z5f/RugReDNk2vDoeAc0dXcpq91pPUlOshKnMelq', 'Fitriana Amaliah Sari', 'aachmedfatony76@gmail.com', 'avatar.png', '1d2ebe658789a78338dfaa0cf28c5b5be271974d', NULL, 1),
(11, '10', 'owner', '$2y$10$YNEHm66wPlsy4S18Rekon.np0Aov.rFjq3U9fKluxHgTqOWmA3Nf2', 'Adit Setyo Nugroho', 'admin@mbt.com', 'avatar.png', 'abaa3d49f0a56e03b4d86a1f964840a7b64aa84d', NULL, 1),
(12, '1', 'admin', '$2y$10$BYhYLiDhhdfaR2dSHUyV3eU1zTBTUPinVYxxaO22Osdt.Wj6FzwMS', 'Admin Aplikasi', 'adminapp@mail.com', 'avatar.png', 'b1f81f1765a5daa6715b84cc67c1beab3e44de2f', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_log`
--

CREATE TABLE `users_log` (
  `id` bigint(20) NOT NULL,
  `bulan` int(2) DEFAULT NULL,
  `tahun` int(4) DEFAULT NULL,
  `bu` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `username` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `log_ip` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `log_name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `log_date` datetime DEFAULT NULL,
  `log_action` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `log_info` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `roles` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 CHECKSUM=1 COLLATE=utf8mb4_unicode_ci DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`id`, `roles`, `description`, `status`) VALUES
(1, 'administrator', 'Administrator', 1),
(9, 'staff', 'Pengelola Aplikasi', 1),
(10, 'owner', 'Owner', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_bank`
--

CREATE TABLE `user_bank` (
  `id` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `no_rek` varchar(25) NOT NULL,
  `bank` varchar(25) NOT NULL,
  `jenis` enum('Bank Transfer','Cash','E-Wallet') DEFAULT 'Bank Transfer',
  `id_user` varchar(15) NOT NULL,
  `status` enum('aktif','tidak aktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_bank`
--

INSERT INTO `user_bank` (`id`, `nama`, `no_rek`, `bank`, `jenis`, `id_user`, `status`) VALUES
(2, 'Ahmad Fatoni', '7275678934', 'BCA', 'Bank Transfer', '1', 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`id_customer`),
  ADD KEY `room_id` (`id_room`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_status_history`
--
ALTER TABLE `room_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`id_room`);

--
-- Indexes for table `tagihan_bulanan`
--
ALTER TABLE `tagihan_bulanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_month_year` (`id_booking`,`bulan`,`tahun`),
  ADD KEY `booking_id` (`id_booking`),
  ADD KEY `due_date` (`due_date`);

--
-- Indexes for table `termination_requests`
--
ALTER TABLE `termination_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `requested_by` (`requested_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `session` (`session`(191)),
  ADD KEY `email` (`email`),
  ADD KEY `rolesid` (`rolesid`(191)),
  ADD KEY `password` (`password`(191)),
  ADD KEY `all` (`id`,`rolesid`(191),`username`,`nama`(191),`email`);

--
-- Indexes for table `users_log`
--
ALTER TABLE `users_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahun` (`tahun`),
  ADD KEY `log_ip` (`log_ip`) USING BTREE,
  ADD KEY `all` (`id`,`username`,`log_ip`,`log_name`,`log_date`,`log_action`(1)),
  ADD KEY `bulan` (`bulan`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles` (`roles`);

--
-- Indexes for table `user_bank`
--
ALTER TABLE `user_bank`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `room_status_history`
--
ALTER TABLE `room_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tagihan_bulanan`
--
ALTER TABLE `tagihan_bulanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `termination_requests`
--
ALTER TABLE `termination_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users_log`
--
ALTER TABLE `users_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1979;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_bank`
--
ALTER TABLE `user_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
