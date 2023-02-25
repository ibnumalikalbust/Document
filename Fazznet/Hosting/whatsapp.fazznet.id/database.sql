-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 07, 2022 at 02:03 PM
-- Server version: 10.5.18-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ridpedco_p-beta`
--

-- --------------------------------------------------------

--
-- Table structure for table `autoreply_button`
--

CREATE TABLE `autoreply_button` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` varchar(255) NOT NULL,
  `footer` varchar(255) NOT NULL,
  `make_by` varchar(40) NOT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `text_button` varchar(255) DEFAULT NULL,
  `keyword_auto_reply` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `external_link` mediumtext DEFAULT NULL,
  `external_link_name` varchar(40) DEFAULT NULL,
  `external_telp` varchar(40) DEFAULT NULL,
  `external_telp_name` varchar(40) DEFAULT NULL,
  `keyword_auto_replytwo` varchar(255) DEFAULT NULL,
  `text_button_two` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auto_reply`
--

CREATE TABLE `auto_reply` (
  `id` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `response` text DEFAULT NULL,
  `media` longtext DEFAULT NULL,
  `nomor` varchar(40) DEFAULT NULL,
  `make_by` varchar(255) NOT NULL,
  `typemedia` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auto_reply`
--

INSERT INTO `auto_reply` (`id`, `keyword`, `response`, `media`, `nomor`, `make_by`, `typemedia`) VALUES
(58, 'yui', 'Yuiiii', NULL, '6285872054160', 'ridahcorp', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blast_list`
--

CREATE TABLE `blast_list` (
  `id` int(11) NOT NULL,
  `sender` varchar(40) NOT NULL,
  `nomor` varchar(40) NOT NULL,
  `text_small` longtext NOT NULL,
  `footer` longtext NOT NULL,
  `title` longtext NOT NULL,
  `buttonText` longtext NOT NULL,
  `title_section` longtext NOT NULL,
  `title_rows_one` varchar(255) NOT NULL,
  `title_rows_two` varchar(255) NOT NULL,
  `title_rows_three` varchar(255) NOT NULL,
  `title_rows_four` varchar(255) NOT NULL,
  `title_rows_five` varchar(255) NOT NULL,
  `title_rows_six` varchar(255) NOT NULL,
  `title_rows_seven` varchar(255) NOT NULL,
  `title_rows_delapan` varchar(255) NOT NULL,
  `title_rows_one_keyword` varchar(255) DEFAULT NULL,
  `title_rows_two_keyword` varchar(255) DEFAULT NULL,
  `title_rows_three_keyword` varchar(255) DEFAULT NULL,
  `title_rows_four_keyword` varchar(255) DEFAULT NULL,
  `title_rows_five_keyword` varchar(255) DEFAULT NULL,
  `title_rows_six_keyword` varchar(255) DEFAULT NULL,
  `title_rows_seven_keyword` varchar(255) DEFAULT NULL,
  `title_rows_delapan_keyword` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `jadwal` varchar(255) NOT NULL,
  `make_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_code_reply`
--

CREATE TABLE `custom_code_reply` (
  `id` int(11) NOT NULL,
  `file_name` longtext DEFAULT NULL,
  `mynumb` varchar(40) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `def_permission`
--

CREATE TABLE `def_permission` (
  `id` int(11) NOT NULL,
  `send_msg` varchar(10) NOT NULL,
  `send_button` varchar(10) NOT NULL,
  `datanumber` varchar(10) NOT NULL,
  `def_msg` varchar(10) NOT NULL,
  `rest_api` varchar(10) NOT NULL,
  `day_x` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `def_permission`
--

INSERT INTO `def_permission` (`id`, `send_msg`, `send_button`, `datanumber`, `def_msg`, `rest_api`, `day_x`) VALUES
(1, '1', '1', '1', '1', '1', '7');

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `id` int(11) NOT NULL,
  `pemilik` varchar(111) NOT NULL,
  `nomor` varchar(14) NOT NULL,
  `link_webhook` varchar(100) NOT NULL,
  `state` char(20) DEFAULT 'DISCONNECTED',
  `status` char(20) DEFAULT 'notLogged',
  `qrcode` mediumtext DEFAULT NULL,
  `auto_read` varchar(10) NOT NULL,
  `profile_name` varchar(255) DEFAULT NULL,
  `status_wa` varchar(255) DEFAULT NULL,
  `pp` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `device`
--

INSERT INTO `device` (`id`, `pemilik`, `nomor`, `link_webhook`, `state`, `status`, `qrcode`, `auto_read`, `profile_name`, `status_wa`, `pp`) VALUES
(585, 'ridahcorp', '6285872054160', 'https://project-beta.ridped.com/filewebhook/webhook.php', 'CONNECTED', 'isLogged', 'null', '1', 'nothing', 'Tidak dapat bicara, WhatsApp saja', 'https://www.ridped.com/way/mypp2.png');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `lang_keyword` varchar(250) NOT NULL,
  `lang_code` varchar(40) NOT NULL,
  `str` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `lang_keyword`, `lang_code`, `str`) VALUES
(1, 'connection_closed', 'en', 'connection lost'),
(2, 'connecting', 'en', 'Connecting...'),
(3, 'close2', 'en', 'WaWeb Logout'),
(4, 'connected', 'en', 'Connected'),
(5, 'succes_register', 'en', 'Success register, welcome back!'),
(6, 'system_error', 'en', 'Error system'),
(7, 'username_registered', 'en', 'Username has been registered'),
(8, 'succces_login', 'en', 'login successfully, welcome back!'),
(9, 'username_password_notfound', 'en', 'wrong username or password'),
(10, 'add_numb', 'en', 'Add number'),
(11, 'add_numb_desc', 'en', 'Start with the country code. e.g. 62815xxx, don\'t using space'),
(12, 'number', 'en', 'Number'),
(13, 'save', 'en', 'Save'),
(14, 'cancel', 'en', 'Cancel'),
(15, 'logout', 'en', 'Log out'),
(16, 'languages', 'en', 'Languages'),
(17, 'Login', 'en', 'Login'),
(18, 'username', 'en', 'Username'),
(19, 'password', 'en', 'Password'),
(20, 'register', 'en', 'Register'),
(21, 'not_have_account', 'en', 'Don\'t have an account?'),
(22, 'connection_closed', 'id', 'Koneksi terputus'),
(23, 'connecting', 'id', 'Menghubungkan...'),
(24, 'close2', 'id', 'WaWeb Logout'),
(25, 'connected', 'id', 'Terhubung'),
(26, 'success_register', 'id', 'Berhasil mendaftar, selamat datang kembali!'),
(27, 'system_error', 'id', 'Ada kesalahan system'),
(28, 'username_registered', 'id', 'Username telah terdaftar'),
(29, 'succces_login', 'id', 'Berhasil login, selamat datang kembali!'),
(30, 'username_password_notfound', 'id', 'Username atau password salah'),
(31, 'add_numb', 'id', 'Tambah nomor'),
(32, 'add_numb_desc', 'id', 'Awali nomor dengan kode negara. cth : 628157xxxx'),
(33, 'number', 'id', 'Nomor'),
(34, 'save', 'id', 'Simpan'),
(35, 'cancel', 'id', 'Batal'),
(36, 'logout', 'id', 'Keluar'),
(37, 'languages', 'id', 'Bahasa'),
(38, 'Login', 'id', 'Login'),
(39, 'username', 'id', 'Username'),
(40, 'password', 'id', 'Kata sandi'),
(41, 'register', 'id', 'Daftar'),
(42, 'not_have_account', 'id', 'Tidak mempunyai akun?'),
(44, 'button_message', 'en', 'Button message'),
(45, 'button_message', 'id', 'Pesan button'),
(46, 'list_button', 'en', 'Message Button List'),
(47, 'list_button', 'id', 'Pesan list button'),
(48, 'test_send', 'en', 'Test send'),
(49, 'test_send', 'id', 'Tes kirim'),
(50, 'contact_admin', 'en', 'Contact Admin'),
(51, 'contact_admin', 'id', 'Hubungi admin'),
(52, 'want_this', 'en', 'Want this?'),
(53, 'want_this', 'id', 'minat dengan aplikasi ini?'),
(54, 'not_connected', 'en', 'Not connected'),
(55, 'not_connected', 'id', 'Tidak terhubung'),
(56, 'time_hasro', 'en', 'Time has run out'),
(57, 'time_hasro', 'id', 'Waktu telah habis'),
(58, 'logout_wa', 'en', 'Please Log out the connection before deleting'),
(59, 'logout_wa', 'id', 'Harap Logout koneksi sebelum menghapus'),
(60, 's_delete_wa', 'en', 'Successfully delete number'),
(61, 's_delete_wa', 'id', 'Sukses hapus nomor'),
(62, 'already_number', 'en', 'Number already in database'),
(63, 'already_number', 'id', 'Nomor sudah ada di database'),
(64, 's_add_number', 'en', 'Number added successfully'),
(65, 's_add_number', 'id', 'Nomor berhasil di tambahkan'),
(66, 'number_saved', 'en', 'Number saved'),
(67, 'number_saved', 'id', 'Nomor disimpan'),
(68, 'message_sent', 'en', 'Message sent'),
(69, 'message_sent', 'id', 'Pesan terkirim'),
(70, 'wait_m_schedule', 'en', 'WAITING FOR DELIVERY SCHEDULE'),
(71, 'wait_m_schedule', 'id', ' MENUNGGU JADWAL PENGIRIMAN'),
(72, 'delete', 'en', 'Delete'),
(73, 'delete', 'id', 'Hapus'),
(75, 'auto_reply', 'en', 'Auto reply'),
(76, 'auto_reply', 'id', 'Auto reply'),
(77, 'auto_reply_btn', 'en', 'Auto reply with button'),
(78, 'auto_reply_btn', 'id', 'Auto reply dengan button'),
(79, 'dat_number', 'en', 'Data number'),
(80, 'dat_number', 'id', 'Data nomor'),
(81, 'dat_contact', 'en', 'Data contact'),
(82, 'dat_contact', 'id', 'Data kontak'),
(83, 'send_bulk_schedule', 'en', 'Send bulk / schedule'),
(84, 'send_bulk_schedule', 'id', 'kirim massal / jadwal'),
(85, 'def_message', 'en', 'Default message'),
(86, 'def_message', 'id', 'Pesan default'),
(87, 'setting', 'en', 'Setting'),
(88, 'setting', 'id', 'Pengaturan'),
(89, 'success_delete', 'en', 'Successfully deleted'),
(90, 'success_delete', 'id', 'Berhasil dihapus'),
(91, 'numb_with_key_already', 'en', 'The number with the keyword already exists'),
(92, 'numb_with_key_already', 'id', 'Nomor dengan keyword tersebut sudah ada'),
(93, 'success_added', 'en', 'Successfully added'),
(94, 'success_added', 'id', 'Berhasil menambakan'),
(95, 'add_auto_reply', 'en', 'Add auto reply'),
(96, 'add_auto_reply', 'id', 'Tambah auto reply'),
(97, 'contacts_from_numb', 'en', 'Contact from number ?'),
(98, 'contacts_from_numb', 'id', 'Kontak dari nomor ?'),
(99, 'numb_has_scanned', 'en', 'choose number has scanned'),
(100, 'numb_has_scanned', 'id', 'pastikan nomor tersebut sudah scan dan terhubung'),
(101, 'get_contacts', 'en', 'Get Contacts'),
(102, 'get_contacts', 'id', 'Dapatkan kontak'),
(103, 'name', 'en', 'Name'),
(104, 'name', 'id', 'Nama'),
(105, 'starting_from_line', 'en', 'Starting from line'),
(106, 'starting_from_line', 'id', 'Mulai dari baris ke'),
(107, 'message', 'en', 'Message'),
(108, 'message', 'id', 'Pesan'),
(109, 'change', 'en', 'Change'),
(110, 'change', 'id', 'Ubah'),
(111, 'new_password', 'en', 'New Password'),
(112, 'new_password', 'id', 'Password baru'),
(113, 'enable', 'en', 'Enable'),
(114, 'enable', 'id', 'Aktifkan'),
(115, 'disable', 'en', 'Disable'),
(116, 'disable', 'id', 'Nonaktifkan'),
(117, 'send', 'en', 'Send'),
(118, 'send', 'id', 'Kirim'),
(119, 'schedule', 'en', 'Schedule'),
(120, 'schedule', 'id', 'Jadwal'),
(121, 'sent', 'en', 'Sent'),
(122, 'sent', 'id', 'Terkirim'),
(123, 'fail', 'en', 'Fail'),
(124, 'fail', 'id', 'Gagal'),
(125, 'button_message_desc', 'en', 'Can send multiple destination numbers separated by comma. eg 62815xxx,62815xxx'),
(126, 'button_message_desc', 'id', 'Bisa mengirim multi nomor tujuan dipisahkan dengan comma. cth 62815xxx,62815xxx'),
(127, 'button_message_desc2', 'en', 'Image url * fill if the message wants with a picture'),
(128, 'button_message_desc2', 'id', 'Url gambar * isi jika pesan nya ingin dengan gambar'),
(129, 'button_message_desc3', 'en', 'Empty this form if you only send 1 button'),
(130, 'button_message_desc3', 'id', 'kosongkan form ini jika hanya mengirim 1 button saja'),
(131, 'sure', 'en', 'Are u sure?'),
(132, 'sure', 'id', 'Apakah kamu yakin?'),
(133, 'close', 'en', 'Close'),
(134, 'close', 'id', 'Tutup');

-- --------------------------------------------------------

--
-- Table structure for table `list_button`
--

CREATE TABLE `list_button` (
  `id` int(11) NOT NULL,
  `keyword` varchar(250) NOT NULL,
  `text_small` longtext NOT NULL,
  `footer` varchar(250) NOT NULL,
  `title_message` varchar(250) NOT NULL,
  `buttontext` varchar(250) NOT NULL,
  `title_section` varchar(250) NOT NULL,
  `title_list_1` varchar(250) NOT NULL,
  `title_list_keyword_1` varchar(250) NOT NULL,
  `title_list_desc_1` varchar(250) NOT NULL,
  `title_list_2` varchar(250) NOT NULL,
  `title_list_keyword_2` varchar(250) NOT NULL,
  `title_list_desc_2` varchar(250) NOT NULL,
  `title_list_3` varchar(250) NOT NULL,
  `title_list_keyword_3` varchar(250) NOT NULL,
  `title_list_desc_3` varchar(250) NOT NULL,
  `number` varchar(40) NOT NULL,
  `username` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nomor`
--

CREATE TABLE `nomor` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nomor` varchar(255) NOT NULL,
  `pesan` mediumtext NOT NULL,
  `make_by` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nomor`
--

INSERT INTO `nomor` (`id`, `nama`, `nomor`, `pesan`, `make_by`, `tag`) VALUES
(3663, 'RId', '6281572885606', 'Oi', 'ridahcorp', '');

-- --------------------------------------------------------

--
-- Table structure for table `pesan`
--

CREATE TABLE `pesan` (
  `id` int(11) NOT NULL,
  `sender` varchar(15) NOT NULL,
  `nomor` varchar(255) NOT NULL,
  `pesan` mediumtext NOT NULL,
  `media` varchar(255) DEFAULT NULL,
  `status` enum('MENUNGGU JADWAL','GAGAL','TERKIRIM') NOT NULL DEFAULT 'MENUNGGU JADWAL',
  `jadwal` datetime NOT NULL,
  `make_by` varchar(255) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesan_default`
--

CREATE TABLE `pesan_default` (
  `id` int(11) NOT NULL,
  `pesan` varchar(255) NOT NULL,
  `make_by` varchar(255) NOT NULL,
  `nomor` varchar(40) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rid_account`
--

CREATE TABLE `rid_account` (
  `id` int(11) NOT NULL,
  `rid_username` varchar(250) NOT NULL,
  `rid_password` varchar(250) NOT NULL,
  `rid_level` varchar(40) NOT NULL,
  `api_key` longtext DEFAULT NULL,
  `nd` varchar(10) DEFAULT NULL,
  `send_msg` varchar(10) NOT NULL,
  `send_button` varchar(10) NOT NULL,
  `datanumber` varchar(10) NOT NULL,
  `def_msg` varchar(10) NOT NULL,
  `rest_api` varchar(10) NOT NULL,
  `total_device` varchar(100) NOT NULL,
  `limit_device` longtext NOT NULL,
  `rid_start` date NOT NULL,
  `rid_expired` date NOT NULL,
  `c_wa` varchar(40) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `v_otp` varchar(255) DEFAULT NULL,
  `cookie` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rid_account`
--

INSERT INTO `rid_account` (`id`, `rid_username`, `rid_password`, `rid_level`, `api_key`, `nd`, `send_msg`, `send_button`, `datanumber`, `def_msg`, `rest_api`, `total_device`, `limit_device`, `rid_start`, `rid_expired`, `c_wa`, `full_name`, `email`, `v_otp`, `cookie`) VALUES
(184, 'ridahcorp', '$2y$10$xW0NPotGgyLPHqZKzFUNSeA/cWxKhpbJSO5xZk98K.3PsWLrKZT9G', '1', '9e3cee11bdb2981e67a0c5745a526eb7322b5442', '2', '1', '1', '1', '1', '1', '1', '3', '2022-11-28', '2023-12-28', '628575757', 'Anjay aku heker', 'ridah@gmail.com', '', 'e24b2904b4d6808ed4c71b5592500482'),
(185, 'azran', '$2y$10$X/TabcOFMoOm1G/JWbWVzeJd4sjhZj1PHgsdFl1u/rKCiJHp8jvre', '2', 'ec6c5e9be24ae8e8384b199503a67c8a84d6bc18', '2', '1', '1', '1', '1', '1', '0', '3', '2022-11-28', '2022-12-05', '6285255646434', 'M Asran', 'azranmu@gmail.com', '', ''),
(186, 'yogis', '$2y$10$nN8MGE/yWBlPjrj8isHE4OZ0.Wif6M8hzWiibtfZCHagRPowIctmC', '2', '9e72399f5aeeefda3b64d9b24859b3dd4098cc43', '2', '1', '1', '1', '1', '1', '0', '3', '2022-11-29', '2022-12-06', '6281366997008', 'yogi', 'idtelnetwork@gmail.com', '', ''),
(187, 'demouser', '$2y$10$FOWppDUyoraWvH67Ezy4zOHQDeEfsalv5cYmu6HMDewRSpW3FI3QO', '1', '7bd77f56d1e7fc38a07739594d0b4b7c0f0e594c', '2', '1', '1', '1', '1', '1', '0', '3', '2022-12-07', '2022-12-14', '628175737535', 'Just demo', 'demo@gmail.com', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `Rid_Users`
--

CREATE TABLE `Rid_Users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` mediumtext NOT NULL,
  `type` int(4) NOT NULL,
  `banned` int(4) NOT NULL,
  `banned_reason` mediumtext DEFAULT NULL,
  `euy` varchar(255) NOT NULL,
  `wallet` varchar(50) NOT NULL,
  `registered` date DEFAULT NULL,
  `nowa` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `pin` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `Rid_Users`
--

INSERT INTO `Rid_Users` (`id`, `username`, `password`, `type`, `banned`, `banned_reason`, `euy`, `wallet`, `registered`, `nowa`, `email`, `full_name`, `pin`) VALUES
(1, 'ridah', '$2y$10$LhVIFigHfyTmPaDqcZDP8O.AzoMTmJ..XzB88s71YYQdsH4zJFGy6', 2, 0, 'No Reason', 'Euy', '0', '2022-11-02', '6281572885606', 'ridahh23@gmail.com', 'RIDAH AJA', ''),
(7, 'demouser', '$2y$10$shkkQBAU0PMsy3eu5HCMtOZtSzca72sEkvwK.TkWDmPggv9V7eyjG', 2, 0, 'No Reason', 'Euy', '0', '2022-11-02', '00000000', 'demo@gmail.com', 'DEMO USER', '');

-- --------------------------------------------------------

--
-- Table structure for table `tag_number`
--

CREATE TABLE `tag_number` (
  `id` int(11) NOT NULL,
  `tag_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tag_number`
--

INSERT INTO `tag_number` (`id`, `tag_name`, `username`) VALUES
(1, 'MyTeam', 'anji');

-- --------------------------------------------------------

--
-- Table structure for table `web_setting`
--

CREATE TABLE `web_setting` (
  `id` int(11) NOT NULL,
  `title` longtext NOT NULL,
  `footer` longtext NOT NULL,
  `nd_default` varchar(10) NOT NULL,
  `send_msg` varchar(10) NOT NULL,
  `datanumber` varchar(10) NOT NULL,
  `auto_reply` varchar(10) NOT NULL,
  `autoreply_button` varchar(10) NOT NULL,
  `send_bulk` varchar(10) NOT NULL,
  `def_msg` varchar(10) NOT NULL,
  `rest_api` varchar(10) NOT NULL,
  `description` longtext NOT NULL,
  `register` varchar(10) NOT NULL,
  `send_button` varchar(10) NOT NULL,
  `limit_device` varchar(10) NOT NULL,
  `rid_key` varchar(255) NOT NULL,
  `no_wa` varchar(40) NOT NULL,
  `msg_verification` varchar(255) NOT NULL,
  `themes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `web_setting`
--

INSERT INTO `web_setting` (`id`, `title`, `footer`, `nd_default`, `send_msg`, `datanumber`, `auto_reply`, `autoreply_button`, `send_bulk`, `def_msg`, `rest_api`, `description`, `register`, `send_button`, `limit_device`, `rid_key`, `no_wa`, `msg_verification`, `themes`) VALUES
(1, 'WaY', 'Way', '2', '1', '1', '1', '1', '1', '1', '1', 'WaY is tools for whatsapp', '1', '1', '3', 'Enter here your key', '6285872054160', 'YOUR VERIFICATION OTP : *[OTP]*', 'sb_admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autoreply_button`
--
ALTER TABLE `autoreply_button`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auto_reply`
--
ALTER TABLE `auto_reply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blast_list`
--
ALTER TABLE `blast_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_code_reply`
--
ALTER TABLE `custom_code_reply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `def_permission`
--
ALTER TABLE `def_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_button`
--
ALTER TABLE `list_button`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nomor`
--
ALTER TABLE `nomor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesan_default`
--
ALTER TABLE `pesan_default`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rid_account`
--
ALTER TABLE `rid_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Rid_Users`
--
ALTER TABLE `Rid_Users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag_number`
--
ALTER TABLE `tag_number`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_setting`
--
ALTER TABLE `web_setting`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `autoreply_button`
--
ALTER TABLE `autoreply_button`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `auto_reply`
--
ALTER TABLE `auto_reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `blast_list`
--
ALTER TABLE `blast_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `custom_code_reply`
--
ALTER TABLE `custom_code_reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `def_permission`
--
ALTER TABLE `def_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=586;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `list_button`
--
ALTER TABLE `list_button`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `nomor`
--
ALTER TABLE `nomor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3664;

--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1655;

--
-- AUTO_INCREMENT for table `pesan_default`
--
ALTER TABLE `pesan_default`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `rid_account`
--
ALTER TABLE `rid_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `Rid_Users`
--
ALTER TABLE `Rid_Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tag_number`
--
ALTER TABLE `tag_number`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `web_setting`
--
ALTER TABLE `web_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
