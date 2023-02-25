-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Des 2022 pada 13.25
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nzm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `api_routeros`
--

CREATE TABLE `api_routeros` (
  `id` int(11) NOT NULL,
  `id_server` varchar(10) DEFAULT NULL,
  `nama_server` varchar(100) DEFAULT NULL,
  `ip_address` text,
  `port` int(11) DEFAULT NULL,
  `username` text,
  `password` text,
  `country` varchar(100) DEFAULT NULL,
  `is_active` enum('0','1','','') DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `api_routeros`
--

INSERT INTO `api_routeros` (`id`, `id_server`, `nama_server`, `ip_address`, `port`, `username`, `password`, `country`, `is_active`) VALUES
(1, 'id-27', 'Server 1', '103.189.234.43', 1899, '597445783073577672464631447a784268316d6449673d3d', '597445783073577672464631447a784268316d6449673d3d', 'Indonesia', '1'),
(2, 'id-30', 'Server 2', '192.168.80.107', 0, '6841774d614b44486c657a592f776b436954377330513d3d', '422f615362325768476836614833727a336241666e773d3d', 'Indonesia', '1'),
(3, 'id-33', 'Server 3', '192.168.43.208', 0, '6841774d614b44486c657a592f776b436954377330513d3d', '6841774d614b44486c657a592f776b436954377330513d3d', 'Indonesia', '1');

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
  `password` text,
  `port` int(11) DEFAULT NULL,
  `tanggal_order` date DEFAULT NULL,
  `berlangganan` int(11) DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `harga_beli` int(11) DEFAULT NULL,
  `status` enum('Aktif','Non Aktif','','') DEFAULT NULL,
  `status_debit` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_activity_user`
--

CREATE TABLE `log_activity_user` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `logs` text,
  `category` enum('Create','Update','Delete') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_method`
--

CREATE TABLE `payment_method` (
  `id` int(11) NOT NULL,
  `payment` varchar(100) DEFAULT NULL,
  `nomor_payment` varchar(25) DEFAULT NULL,
  `an` text,
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
  `id_telegram` varchar(50) DEFAULT NULL,
  `user_remote` varchar(100) DEFAULT NULL,
  `server` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`, `last_login`, `saldo`, `id_telegram`, `user_remote`, `server`) VALUES
(3, 'tulus', 'admin@gmail.com', 'default.jpg', '$2a$12$LkoHNWMwCAnDF.B2wmM6lOPGiQ2MwP0MoujH95HEKPbLG4YFO4r3K', 1, 1, 1666681911, '2022-12-13 16:35:19', 870000, '789695166', 'texa.net', 'texa.my.id');

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
  `lokasi` text,
  `status` enum('Aktif','Non Aktif') DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `vpn_master`
--

INSERT INTO `vpn_master` (`id`, `id_server`, `nama`, `harga`, `lokasi`, `status`) VALUES
(1, 'id-33', 'VPN Remote ID27', 20000, 'Indonesia', 'Aktif'),
(2, 'id-33', 'VPN Remote ID30', 30000, 'Indonesia', 'Aktif'),
(3, 'id-33', 'vpn.nzmwifi.my.id', 3000, 'Indonesia', 'Aktif');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `data_order`
--
ALTER TABLE `data_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `log_activity_user`
--
ALTER TABLE `log_activity_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `top_up`
--
ALTER TABLE `top_up`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
