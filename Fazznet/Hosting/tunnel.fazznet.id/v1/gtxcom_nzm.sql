-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 30 Nov 2022 pada 22.20
-- Versi server: 10.3.36-MariaDB-cll-lve
-- Versi PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gtxcom_nzm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `api_routeros`
--

CREATE TABLE `api_routeros` (
  `id` int(11) NOT NULL,
  `ip_address` text DEFAULT NULL,
  `port` int(11) DEFAULT NULL,
  `username` text DEFAULT NULL,
  `password` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `api_routeros`
--

INSERT INTO `api_routeros` (`id`, `ip_address`, `port`, `username`, `password`) VALUES
(1, '103.189.234.43', 1899, '597445783073577672464631447a784268316d6449673d3d', '597445783073577672464631447a784268316d6449673d3d');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_order`
--

CREATE TABLE `data_order` (
  `id` int(11) NOT NULL,
  `deleted_date` date DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nomor_order` int(11) DEFAULT NULL,
  `id_server` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `port` int(11) DEFAULT NULL,
  `tanggal_order` date DEFAULT NULL,
  `berlangganan` int(11) DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `harga_beli` int(11) DEFAULT NULL,
  `status` enum('Aktif','Non Aktif','','') DEFAULT NULL,
  `status_debit` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_order`
--

INSERT INTO `data_order` (`id`, `deleted_date`, `id_user`, `nomor_order`, `id_server`, `username`, `password`, `port`, `tanggal_order`, `berlangganan`, `expired_date`, `harga_beli`, `status`, `status_debit`) VALUES
(1, '2022-11-30', 7, 1, 3, 'x240@nzm.net', 'x2400', 8298, '2022-11-29', 1, '2022-12-29', 3000, 'Aktif', '1'),
(2, '2022-11-30', 6, 2, 3, 'maliktes@nzm.net', 'maliktes', 8291, '2022-11-29', 1, '2022-12-29', 3000, 'Aktif', '1'),
(3, NULL, 7, 3, 3, 'gundawan@nzm.net', 'gundul', 1234, '2022-11-30', 1, '2022-12-30', 3000, 'Aktif', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_activity_user`
--

CREATE TABLE `log_activity_user` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `logs` text DEFAULT NULL,
  `category` enum('Create','Update','Delete') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `log_activity_user`
--

INSERT INTO `log_activity_user` (`id`, `id_user`, `tanggal`, `logs`, `category`) VALUES
(1, 7, '2022-11-29 23:13:42', 'Membuat VPN Remote Baru x240@nzm.net', 'Create'),
(2, 7, '2022-11-29 23:15:49', 'Edit VPN Remote x240@nzm.net', 'Update'),
(3, 6, '2022-11-29 23:56:35', 'Membuat VPN Remote Baru maliktes@nzm.net', 'Create'),
(4, 6, '2022-11-29 23:57:59', 'Delete VPN Remote maliktes@nzm.net@nzm.net', 'Delete'),
(5, 6, '2022-11-30 00:00:20', 'Delete VPN Remote maliktes@nzm.net@nzm.net', 'Delete'),
(6, 7, '2022-11-30 08:29:57', 'Membuat VPN Remote Baru gundawan@nzm.net', 'Create'),
(7, 7, '2022-11-30 08:31:44', 'Edit VPN Remote x240@nzm.net', 'Update'),
(8, 7, '2022-11-30 08:32:22', 'Delete VPN Remote x240@nzm.net@nzm.net', 'Delete'),
(9, 7, '2022-11-30 08:33:17', 'Edit VPN Remote gundawan@nzm.net', 'Update'),
(10, 11, '2022-11-30 09:11:32', 'Isi Saldo 10.000', 'Create'),
(11, 6, '2022-11-30 09:15:56', 'Isi Saldo 50.000', 'Create'),
(12, 6, '2022-11-30 09:16:54', 'Isi Saldo 10.000', 'Create'),
(13, 6, '2022-11-30 09:58:55', 'Isi Saldo 50.000', 'Create'),
(14, 6, '2022-11-30 10:56:24', 'Isi Saldo 50.000', 'Create'),
(15, 6, '2022-11-30 10:57:31', 'Isi Saldo 50.000', 'Create'),
(16, 6, '2022-11-30 10:57:52', 'Isi Saldo 50.000', 'Create'),
(17, 6, '2022-11-30 10:59:58', 'Isi Saldo 50.000', 'Create'),
(18, 6, '2022-11-30 11:00:54', 'Isi Saldo 50.000', 'Create'),
(19, 6, '2022-11-30 11:01:19', 'Isi Saldo 50.000', 'Create'),
(20, 6, '2022-11-30 11:15:57', 'Isi Saldo 50.000', 'Create'),
(21, 6, '2022-11-30 11:16:40', 'Isi Saldo 50.000', 'Create'),
(22, 6, '2022-11-30 11:16:55', 'Isi Saldo 50.000', 'Create'),
(23, 6, '2022-11-30 11:23:56', 'Isi Saldo 50.000', 'Create'),
(24, 6, '2022-11-30 11:26:16', 'Isi Saldo 50.000', 'Create'),
(25, 6, '2022-11-30 17:03:31', 'Isi Saldo 50.000', 'Create'),
(26, 6, '2022-11-30 17:04:50', 'Isi Saldo 50.000', 'Create'),
(27, 6, '2022-11-30 17:05:11', 'Isi Saldo 50.000', 'Create'),
(28, 6, '2022-11-30 17:05:32', 'Isi Saldo 50.000', 'Create'),
(29, 6, '2022-11-30 17:06:09', 'Isi Saldo 50.000', 'Create'),
(30, 6, '2022-11-30 17:09:52', 'Isi Saldo 50.000', 'Create'),
(31, 6, '2022-11-30 17:09:52', 'Isi Saldo 50.000', 'Create'),
(32, 6, '2022-11-30 17:32:46', 'Isi Saldo 50.000', 'Create'),
(33, 6, '2022-11-30 17:34:06', 'Isi Saldo 50.000', 'Create'),
(34, 6, '2022-11-30 17:35:07', 'Isi Saldo 50.000', 'Create'),
(35, 6, '2022-11-30 17:36:16', 'Isi Saldo 50.000', 'Create'),
(36, 6, '2022-11-30 17:48:34', 'Isi Saldo 50.000', 'Create'),
(37, 6, '2022-11-30 18:51:17', 'Isi Saldo 50.000', 'Create'),
(38, 6, '2022-11-30 18:54:35', 'Isi Saldo 50.000', 'Create'),
(39, 11, '2022-11-30 19:34:11', 'Isi Saldo 50.000', 'Create');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_method`
--

CREATE TABLE `payment_method` (
  `id` int(11) NOT NULL,
  `payment` varchar(100) DEFAULT NULL,
  `nomor_payment` varchar(25) DEFAULT NULL,
  `an` text DEFAULT NULL,
  `status` enum('Aktif','Non Aktif') DEFAULT 'Aktif'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `payment_method`
--

INSERT INTO `payment_method` (`id`, `payment`, `nomor_payment`, `an`, `status`) VALUES
(1, 'Shopee Pay', '089674618300', 'Tulussubakti27', 'Aktif'),
(2, 'OVO', '089674618300', 'Mukroni', 'Aktif'),
(3, 'DANA', '089674618300', 'Mukroni', 'Aktif'),
(4, 'Link Aja', '089674618300', 'Mukroni', 'Aktif'),
(5, 'Transfer BRI', '390301018370539', 'Mukroni', 'Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `top_up`
--

CREATE TABLE `top_up` (
  `id` int(11) NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `jenis_pembayaran` varchar(150) DEFAULT NULL,
  `nomor_tujuan` varchar(100) DEFAULT NULL,
  `an` varchar(100) DEFAULT NULL,
  `status` enum('Sukses','Cancel','Pending') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `top_up`
--

INSERT INTO `top_up` (`id`, `tanggal`, `id_user`, `nominal`, `jenis_pembayaran`, `nomor_tujuan`, `an`, `status`) VALUES
(1, '2022-11-30 18:51:17', 6, 50000, 'DANA', NULL, NULL, 'Sukses'),
(2, '2022-11-30 18:54:35', 6, 50000, 'Bank Transfer BRI', NULL, NULL, 'Sukses'),
(3, '2022-11-30 19:34:11', 11, 50000, 'ShopeePay Indonesia', NULL, NULL, 'Sukses'),
(4, '2022-11-30 21:45:07', 3, 10000, 'Shopee Pay', NULL, NULL, 'Pending'),
(5, '2022-11-30 21:54:49', 3, 10000, 'Link Aja', '089674618300', '', 'Pending'),
(6, '2022-11-30 22:10:37', 3, 10000, 'Transfer BRI', '', '', 'Pending'),
(7, '2022-11-30 22:10:58', 3, 10000, 'Link Aja', '089674618300', 'Mukroni', 'Pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `saldo` int(11) DEFAULT NULL,
  `id_telegram` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`, `last_login`, `saldo`, `id_telegram`) VALUES
(3, 'tulus', 'tulussubakti5@gmail.com', 'default.jpg', '$2a$12$LkoHNWMwCAnDF.B2wmM6lOPGiQ2MwP0MoujH95HEKPbLG4YFO4r3K', 1, 1, 1666681911, '2022-11-30 20:40:04', 1000000, '789695166'),
(6, 'Abdul Malik Ibrahim', 'cuymalik915@gmail.com', 'default.jpg', '$2a$12$LkoHNWMwCAnDF.B2wmM6lOPGiQ2MwP0MoujH95HEKPbLG4YFO4r3K', 2, 1, 1669118643, '2022-11-30 18:54:16', 110000, NULL),
(7, 'gundawan', 'gundawan39@gmail.com', 'default.jpg', '$2y$10$pXZt5robKvvvgqbKoyaq.Om5ieQtRw4i5gMxmpZmfBaBxkmzSKd3G', 2, 1, 1669648520, '2022-11-30 22:20:34', 14000, NULL),
(8, 'Sari saat', 'sarisaat16@gmail.com', 'default.jpg', '$2y$10$rh5exVSF2BIu2PJHMeb2FeX27twDRdLawxj3bT6yW55tBJZfFsWSa', 2, 1, 1669648679, '2022-11-28 22:19:23', 0, NULL),
(9, 'saya', 'saya@siapa.com', 'default.jpg', '$2y$10$QJ52IJEIyyUK51V84iX8R.eM/UNdvnzZBrgnHtyjm06O7JkyI6/hq', 2, 1, 1669773335, '2022-11-30 08:59:43', 0, NULL),
(10, 'saya', 'saya@siapa.net', 'default.jpg', '$2y$10$JQQ.ArRUav0oHA8WFz6I4O2Hi6t/zZTWd9F8Gjli15A7fJ2BE1kOa', 2, 1, 1669773889, NULL, 5000, NULL),
(11, 'efatmunny', 'efatmunny1@gmail.com', 'default.jpg', '$2y$10$r.lgzHKmDSvIc52pPmcVHuIXpFcDDVrN0.EfYimHpZuY2rgn79lna', 2, 1, 1669774029, '2022-11-30 19:31:45', 50000, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Member');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vpn_master`
--

CREATE TABLE `vpn_master` (
  `id` int(11) NOT NULL,
  `id_server` varchar(25) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `lokasi` text DEFAULT NULL,
  `status` enum('Aktif','Non Aktif') DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `vpn_master`
--

INSERT INTO `vpn_master` (`id`, `id_server`, `nama`, `harga`, `lokasi`, `status`) VALUES
(1, 'id-27', 'VPN Remote ID27', 20000, 'Indonesia', 'Non Aktif'),
(2, 'id-30', 'VPN Remote ID30', 30000, 'Indonesia', 'Non Aktif'),
(3, 'vpn', 'vpn.nzmwifi.my.id', 3000, 'singapura', 'Aktif');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `api_routeros`
--
ALTER TABLE `api_routeros`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_order`
--
ALTER TABLE `data_order`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `log_activity_user`
--
ALTER TABLE `log_activity_user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `top_up`
--
ALTER TABLE `top_up`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `vpn_master`
--
ALTER TABLE `vpn_master`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `api_routeros`
--
ALTER TABLE `api_routeros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `data_order`
--
ALTER TABLE `data_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `log_activity_user`
--
ALTER TABLE `log_activity_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `top_up`
--
ALTER TABLE `top_up`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `vpn_master`
--
ALTER TABLE `vpn_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
