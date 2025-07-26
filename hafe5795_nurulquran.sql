-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 17, 2025 at 09:16 PM
-- Server version: 11.4.7-MariaDB-cll-lve
-- PHP Version: 8.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hafe5795_nurulquran`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int(15) NOT NULL,
  `kode_admin` varchar(4) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `kode_admin`, `nama`, `nip`, `email`) VALUES
(20, 'A020', 'Ade Maulana', '120703', 'ademaulana0127@gmail.com'),
(24, 'A021', 'MOH. MUHTAROM, S.Sy', '18041993', 'mohmuhtarom18@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_guru`
--

CREATE TABLE `tbl_guru` (
  `id_guru` int(15) NOT NULL,
  `kode_guru` varchar(4) DEFAULT NULL,
  `nama_guru` varchar(255) DEFAULT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `id_kelas` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_guru`
--

INSERT INTO `tbl_guru` (`id_guru`, `kode_guru`, `nama_guru`, `nip`, `email`, `alamat`, `no_telp`, `foto`, `id_kelas`) VALUES
(22, 'G021', 'IRFAN SULISTYO, S.Ag', '30091998', 'irpanxzyss@gmail.com', 'Kp. Cidokom Rt.02/02 Ds. Cidokom Kec. Rumpin Kab. Bogor', '081514440939', 'fotoustad1.jpg', NULL),
(26, 'G023', 'RIZKI AINURRAFIK, SQ. S.Pd', '31052001', 'rizkiainurrafik485@gmail.com', 'JL. Siliwangi No. 15 RT/RW 001/001 Pondok Benda, Pamulang', '085890281925', 'fotoustad2.jpg', NULL),
(27, 'G027', 'MOH. MUHTAROM, S. Sy', '18041993', 'mohmuhtarom18@gmail.com', 'Kp. Cigihing Rt001/002 Dsa. Cidokom Kec. Rumpin Kab. Bogor', '085648432121', 'fotoustad4.jpg', NULL),
(28, 'G028', 'MUHAMMAD NIZAR AL - MUNAWWAR, SQ. S.Pd', '20042002', 'almunawwarnizar@gmail.com', 'Dsn. Segel RT/RW 02/01 Desa Mangkubumi Kecamatan Sadananya Kabupaten Ciamis', '085895402651', 'fotoustad5.jpg', NULL),
(29, 'G029', 'RM. DAFFA FADHILA IHSANY, SQ. S.Ag', '11022002', 'rm.daffafadhilaihsany@mhs.ptiq.ac.id', 'Perum Kota Baru Blok A 11/02 RT/012/RW/004 Desa. Campaka Kec. Campaka Kab. Karawang', '081399021686', 'WhatsApp Image 2025-07-13 at 21.17.47_99c4dd82.jpg', NULL),
(30, 'G030', 'ABDUL AJIZ, SQ. S.Pd', '04111994', 'azizanwar842@gmail.com', 'Kp. Pasireurih Rt/014/Rw004 Desa. Margaluyu Kec. Purbalaya Kab. Sukabumi', '085885982199', 'foto_default.png', NULL),
(31, 'G031', 'FAUZIL ADIM, S.E', '05062004', 'fauziladim05@gmail.com', 'Jl. H. Mali Rt/010/001 Desa. Duri Kosambi Kec. Cengkareng Kota. Jakarta', '085811409023', 'fotoustad3.jpg', NULL),
(32, 'G032', 'IKROM TAQIYYURROHMAN', '18041993', 'mohmuhtarom18@gmail.com', 'Kp. cigihing Rt001/002 Dsa. Cidokom Kec. Rumpin Kab. Bogor', '085648432121', 'foto_default.png', NULL),
(33, 'G033', 'IZDIHARUDDIN', '18041993', 'mohmuhtarom18@gmail.com', 'Kp. cigihing Rt001/002 Dsa. Cidokom Kec. Rumpin Kab. Bogor', '085648432121', 'foto_default.png', NULL),
(34, 'G034', 'MUHAMMAD HIDAYAT', '18041993', 'mohmuhtarom18@gmail.com', 'Kp. cigihing Rt001/002 Dsa. Cidokom Kec. Rumpin Kab. Bogor', '085648432121', 'foto_default.png', NULL),
(35, 'G035', 'IKRAR AMMAR ANDRIAS LAU', '18041993', 'mohmuhtarom18@gmail.com', 'Kp. cigihing Rt001/002 Dsa. Cidokom Kec. Rumpin Kab. Bogor', '085648432121', 'foto_default.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hafalan`
--

CREATE TABLE `tbl_hafalan` (
  `id_hafalan` int(15) NOT NULL,
  `id_santri` int(15) NOT NULL,
  `id_kelas` int(15) NOT NULL,
  `id_surat` int(15) NOT NULL,
  `juz` int(15) NOT NULL,
  `tgl_hafalan` date DEFAULT NULL,
  `status` enum('Lanjut','Ulang') DEFAULT 'Lanjut',
  `ayat` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_hafalan`
--

INSERT INTO `tbl_hafalan` (`id_hafalan`, `id_santri`, `id_kelas`, `id_surat`, `juz`, `tgl_hafalan`, `status`, `ayat`, `keterangan`) VALUES
(81, 55, 2, 49, 26, '2025-07-15', 'Lanjut', '18', 'Membacanya harus lebih tartil'),
(83, 94, 3, 69, 29, '2025-07-14', 'Ulang', '35-52', 'Mengulang hafalan sebelumnya'),
(84, 65, 2, 47, 26, '2025-07-14', 'Lanjut', '12-19', 'Terdapat beberapa gunnah yang masih kurang dan beberapa kalimat yang salah baca'),
(85, 64, 2, 43, 25, '2025-07-14', 'Lanjut', '23', 'alhamdulillah lancar'),
(86, 69, 2, 78, 30, '2025-07-14', 'Lanjut', '1-40', 'Binadzari'),
(87, 92, 3, 34, 22, '2025-07-14', 'Lanjut', '8-31', ''),
(88, 75, 2, 89, 30, '2025-07-14', 'Lanjut', '1-30', 'Panjang pendek masih beberapa kelewatan'),
(89, 68, 2, 47, 26, '2025-07-14', 'Ulang', '11', 'Mengulang hafalan sebelumnya'),
(90, 74, 2, 71, 29, '2025-07-14', 'Ulang', '11-20', 'Terdapat ghunnah yang masih kurang dan beberapa kalimat yang salah baca.'),
(91, 93, 3, 40, 24, '2025-07-14', 'Lanjut', '67-75 - Al Fussilat : 11', 'Melanjutkan hafalannya'),
(92, 70, 2, 74, 29, '2025-07-14', 'Lanjut', '17', 'kurang lancar'),
(93, 63, 2, 51, 26, '2025-07-14', 'Lanjut', '28', 'Lebih tartil lagi'),
(94, 91, 3, 17, 15, '2025-07-14', 'Ulang', '17', 'Mengulang hafalan sebelumnya'),
(95, 81, 3, 49, 26, '2025-07-14', 'Lanjut', '16-18', 'Panjang pendek harus diperhatikan'),
(96, 72, 2, 69, 29, '2025-07-14', 'Ulang', '9-52', 'Lebih lancarkan kembali'),
(97, 90, 3, 39, 24, '2025-07-14', 'Lanjut', '48-74', ''),
(98, 78, 3, 33, 22, '2025-07-14', 'Lanjut', '62', 'lumayan lancar'),
(99, 82, 3, 43, 25, '2025-07-14', 'Ulang', '61-73', 'Terdapat beberapa kalimat yang salah baca'),
(100, 84, 3, 46, 26, '2025-07-14', 'Lanjut', '1-5', 'Baik'),
(101, 73, 2, 45, 25, '2025-07-14', 'Ulang', '23', 'Bacaan nya kurang Tartil dan masih ada perbaikan dari tahsinnya'),
(102, 71, 2, 50, 26, '2025-07-14', 'Lanjut', '16 - Ad dzariyat: 30', 'Setoran morojaah.- Ketika ngaji tempo terlalu cepat, kedepannya lebih diperlambat lagi perihal tempo bacaan agar makhraj dan tajwid dapat tetap terjaga!'),
(103, 79, 3, 40, 24, '2025-07-14', 'Lanjut', '27', 'Tajwid nya cukup baik tapi harus teliti panjang pendeknya'),
(105, 80, 3, 48, 26, '2025-07-14', 'Lanjut', '1-23', 'Setoran murojaah.- Murojaahnya diperkuat lagi!'),
(107, 89, 3, 64, 28, '2025-07-14', 'Ulang', '1 - 15', 'Setoran murojaah.- Murojaah lebih diperkuat lagi!'),
(108, 91, 3, 17, 15, '2025-07-15', 'Lanjut', '27', 'Menambah Hafalan'),
(109, 74, 2, 71, 29, '2025-07-15', 'Lanjut', '11-20', 'Hafalannya sudah bagus'),
(110, 69, 2, 83, 30, '2025-07-15', 'Lanjut', '1-36', 'Binadzari'),
(111, 88, 3, 33, 21, '2025-07-15', 'Lanjut', '1-4', 'Baik'),
(112, 78, 3, 33, 22, '2025-07-15', 'Lanjut', '73', 'alhamdulillah lancar'),
(114, 94, 3, 54, 27, '2025-07-15', 'Ulang', '55', 'Setoran ulang satu juz'),
(115, 67, 2, 78, 30, '2025-07-15', 'Lanjut', '1-16', ''),
(117, 75, 2, 90, 30, '2025-07-15', 'Lanjut', '1-20', 'Diperhatikan panjang pendeknya'),
(118, 68, 2, 47, 26, '2025-07-15', 'Lanjut', '19', 'Menambah hafalan'),
(119, 80, 3, 48, 26, '2025-07-15', 'Lanjut', '28', 'Mantap. Murojaah lebih diperkuat lagi!'),
(120, 92, 3, 34, 22, '2025-07-15', 'Ulang', '15-39', 'Mengulang hafalannya,'),
(121, 71, 2, 90, 30, '2025-07-15', 'Lanjut', '20', 'Alhamdulillah,- 8.5/10 ðŸ’¥'),
(123, 82, 3, 43, 25, '2025-07-15', 'Lanjut', '61-73', 'Hafalannya sudah bagus'),
(124, 64, 2, 43, 25, '2025-07-15', 'Lanjut', '60', 'alhamdulillah lancar'),
(126, 84, 3, 46, 26, '2025-07-15', 'Lanjut', '6-10', 'Baik'),
(127, 90, 3, 39, 24, '2025-07-15', 'Lanjut', '57-75 - Al Ghafir :7', 'Melanjutkan hafalannya'),
(130, 72, 2, 69, 29, '2025-07-15', 'Lanjut', '9-52', 'Lanjut halaman selanjutnya'),
(133, 81, 3, 48, 26, '2025-07-15', 'Lanjut', '1-29', 'Persiapan tes akumulatif'),
(134, 93, 3, 40, 24, '2025-07-15', 'Lanjut', '67-75 - Al Fussilat : 11', 'Melanjutkan hafalannya'),
(135, 70, 2, 74, 29, '2025-07-15', 'Lanjut', '31', 'alhamdulillah lancar'),
(136, 55, 2, 50, 26, '2025-07-15', 'Lanjut', '1-15', 'Tajiwidnya diperhatikan'),
(137, 89, 3, 65, 28, '2025-07-15', 'Lanjut', '5', 'Alhamdulillah, perlahan tapi pasti InsyaAllah'),
(138, 73, 2, 46, 26, '2025-07-15', 'Lanjut', '21 - 23', 'Bacaan nya kurang Tartil harus di perbaiki lagi'),
(139, 79, 3, 41, 24, '2025-07-15', 'Lanjut', '8 - 11', 'Bagus bacaan nya dan sesuai tajwid'),
(140, 65, 2, 47, 26, '2025-07-15', 'Lanjut', '20-23', 'Hafalannya sudah bagus'),
(141, 71, 2, 91, 30, '2025-07-16', 'Lanjut', 'Ù¡Ù¥', 'Alhamdulillah hafalan lancar. 9/10'),
(142, 64, 2, 43, 25, '2025-07-16', 'Lanjut', '89', 'alhamdulillah lancar'),
(143, 94, 3, 55, 27, '2025-07-16', 'Ulang', '78', 'Mengulang hafalan sebelumnya'),
(144, 72, 2, 70, 29, '2025-07-16', 'Lanjut', '1-44', 'Lanjut ke halaman selanjutnya'),
(145, 81, 3, 46, 26, '2025-07-16', 'Lanjut', '1-28', 'Bacanya yang Tartil jangan terburu-buru'),
(146, 65, 2, 47, 26, '2025-07-16', 'Lanjut', '24-29', 'Terdapat beberapa kalimat yang masih salah baca'),
(147, 78, 3, 34, 22, '2025-07-16', 'Lanjut', '7', 'alhamdulillah lancar'),
(148, 55, 2, 50, 26, '2025-07-16', 'Lanjut', '16 - 26', 'Terus semangat semoga bisa 1 hari 1 halaman'),
(149, 68, 2, 47, 27, '2025-07-16', 'Lanjut', '29', 'Hafalan baru'),
(150, 84, 3, 46, 26, '2025-07-16', 'Lanjut', '11-14', 'Baik'),
(151, 69, 2, 84, 30, '2025-07-16', 'Lanjut', '1-25', 'Tajwidnya diperhatikan lagi'),
(152, 69, 2, 85, 30, '2025-07-16', 'Lanjut', '1-22', 'Tajwidnya diperhatikan'),
(153, 88, 3, 33, 21, '2025-07-16', 'Lanjut', '5-6', 'Baik'),
(155, 69, 2, 86, 30, '2025-07-16', 'Lanjut', '1-17', 'Tajwidnya diperhatikan'),
(156, 90, 3, 39, 24, '2025-07-16', 'Lanjut', '57-75 - Al Ghafir : 1-12', 'Lanjut'),
(157, 67, 2, 86, 30, '2025-07-16', 'Lanjut', '1-17', 'Binnazar'),
(158, 93, 3, 40, 24, '2025-07-16', 'Lanjut', '12-25', 'Good Lancar'),
(159, 69, 2, 87, 30, '2025-07-16', 'Lanjut', '1-19', 'Tajwidnya diperhatikan'),
(160, 80, 3, 49, 26, '2025-07-16', 'Lanjut', '4', 'Ada 1 jali, perkuat lagi dan semangat selalu !'),
(161, 73, 2, 46, 26, '2025-07-16', 'Lanjut', '24 - 25', 'Sudah bagus tetapi harus ditekankan lagi panjang dan pendek nya'),
(162, 74, 2, 71, 26, '2025-07-16', 'Lanjut', '21-28', 'Hafalannya sudah bagus'),
(163, 79, 3, 41, 24, '2025-07-16', 'Lanjut', '12 - 14', 'Bagus bacaan nya dan sesuai dengan tajwid'),
(164, 75, 2, 91, 30, '2025-07-16', 'Lanjut', '1-15', 'Lebih Tartil lagi'),
(165, 70, 2, 74, 29, '2025-07-16', 'Lanjut', '40', 'alhamdulillah lancar'),
(166, 70, 2, 74, 29, '2025-07-16', 'Lanjut', '40', 'alhamdulillah lancar'),
(167, 92, 3, 34, 22, '2025-07-16', 'Ulang', '23-48', 'Kurang Lancar'),
(168, 91, 3, 17, 15, '2025-07-16', 'Lanjut', '38', 'Hafalan baru'),
(169, 82, 3, 43, 25, '2025-07-16', 'Lanjut', '74-85', 'Hafalannya sudah bagus'),
(170, 89, 3, 65, 28, '2025-07-16', 'Lanjut', '9', 'Semangat lagi, jangan berkecil hati. Perubahan itu keliatan meskipun perlahan âœŠ'),
(171, 94, 3, 56, 27, '2025-07-17', 'Ulang', '96', 'Setoran ulang satu juz'),
(172, 92, 3, 34, 22, '2025-07-17', 'Lanjut', '23-48', 'Melanjutkan hafalannya'),
(173, 69, 2, 88, 30, '2025-07-17', 'Lanjut', '1-36', 'Tajwidnya lebih diperhatikan lagi'),
(174, 64, 2, 44, 25, '2025-07-17', 'Lanjut', '39', 'alhamdulillah lancar'),
(176, 69, 2, 89, 30, '2025-07-17', 'Lanjut', '1-30', 'Panjang pendek lebih diperhatikan lagi'),
(177, 55, 2, 50, 26, '2025-07-17', 'Lanjut', '26 - 39', 'Lebih tartil lagi'),
(178, 71, 2, 92, 30, '2025-07-17', 'Lanjut', '14', 'Alhamdulillah hafalan kali ini cukup lancar hanya saja masih ada beberapa ayat yang tertukar dengan ayat yang hampir mirip disurat lain.'),
(179, 69, 2, 90, 30, '2025-07-17', 'Lanjut', '1-20', 'Binadzari'),
(180, 69, 2, 91, 30, '2025-07-17', 'Lanjut', '1-15', 'Binadzari (panjang pendek diperhatikan lagi)'),
(181, 69, 2, 92, 30, '2025-07-17', 'Lanjut', '1-21', 'Binadzri'),
(182, 69, 2, 93, 30, '2025-07-17', 'Lanjut', '1-11', 'Binadzri'),
(183, 72, 2, 70, 29, '2025-07-17', 'Lanjut', '11-44, Nuh (1-12)', 'Sudah cukup baik dari sebelumnya'),
(184, 69, 2, 94, 30, '2025-07-17', 'Lanjut', '1-8', 'Binadzri'),
(185, 93, 3, 41, 24, '2025-07-17', 'Lanjut', '1-29', 'Lancar'),
(186, 82, 3, 43, 25, '2025-07-17', 'Lanjut', '86-89', 'Alhamdulillah hafalannya sudah bagus'),
(187, 95, 3, 69, 29, '2025-07-14', 'Ulang', '35-52, Al-Maarij (1-44)', 'Perlu dilancarkan lagi'),
(188, 69, 2, 92, 30, '2025-07-17', 'Lanjut', '1-21', 'Tajwidnya diperhatikan lagi'),
(189, 70, 2, 74, 29, '2025-07-17', 'Lanjut', '56', 'alhamdulillah lancar'),
(190, 69, 2, 93, 30, '2025-07-17', 'Lanjut', '1-11', 'Tajwid dan panjang pendek diperhatikan'),
(191, 69, 2, 94, 30, '2025-07-17', 'Lanjut', '1-8', 'Tajwidnya diperhatikan'),
(192, 95, 3, 69, 29, '2025-07-17', 'Lanjut', '40-44, Al-Maarij (1-44), Nuh (1-28)', 'Lanjut ke halaman selanjutnya'),
(193, 95, 3, 70, 29, '2025-07-17', 'Lanjut', '11-44, Nuh (1-28)', 'Lanjut ke halaman selanjutnya'),
(194, 95, 3, 70, 29, '2025-07-17', 'Ulang', '11-44, Nuh (1-28), Jin (1-5)', 'Masih ada kekeliruan dalam membaca mad'),
(195, 90, 3, 39, 24, '2025-07-17', 'Lanjut', '57-75 - Al Ghafir : 1-16', 'Lancar'),
(196, 84, 3, 46, 26, '2025-07-17', 'Lanjut', '15-16', 'Baik'),
(197, 63, 2, 51, 26, '2025-07-15', 'Lanjut', '29 - 30', 'Lebih dilancarkan kembali'),
(198, 88, 3, 33, 21, '2025-07-17', 'Lanjut', '7-12', 'Baik'),
(199, 68, 2, 47, 27, '2025-07-17', 'Ulang', '33', 'Perlu mengulang hafalan sebelumnya'),
(200, 67, 2, 91, 30, '2025-07-17', 'Lanjut', '1-15', 'Binnzar'),
(201, 80, 3, 49, 26, '2025-07-17', 'Lanjut', '11', 'Diperbaiki lagi dari segi kelancaran, bacaan, dan temponya. Semangattt!'),
(202, 63, 2, 78, 30, '2025-07-17', 'Lanjut', '1-40', 'Lebih tartil lagi'),
(203, 63, 2, 49, 26, '2025-07-16', 'Lanjut', '5 -18', 'Bagus, mengulang persiapan tasmi akumulatif'),
(204, 81, 3, 47, 26, '2025-07-17', 'Lanjut', '1-29', 'Dilancarkan lagi'),
(205, 78, 3, 34, 22, '2025-07-17', 'Lanjut', '14', 'alhamdulillah lancar'),
(206, 65, 2, 47, 26, '2025-07-17', 'Lanjut', '24-29', 'Alhamdulillah hafalannya sudah lancar'),
(207, 89, 3, 65, 28, '2025-07-17', 'Lanjut', '11', 'Semangat trus. Panjang-pendek lebih diperhatikan lagi'),
(208, 73, 2, 46, 26, '2025-07-17', 'Ulang', '26', 'Masih perlu diajarkan lagi tahsinnya'),
(209, 79, 3, 41, 24, '2025-07-17', 'Lanjut', '15 - 17', 'Bagus dan maksimal bacaannya');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jumlah_juz`
--

CREATE TABLE `tbl_jumlah_juz` (
  `id_juz` int(11) NOT NULL,
  `id_santri` int(11) NOT NULL,
  `jumlah_juz` varchar(20) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_jumlah_juz`
--

INSERT INTO `tbl_jumlah_juz` (`id_juz`, `id_santri`, `jumlah_juz`, `keterangan`) VALUES
(5, 55, '1', '26'),
(6, 72, '2', '26,30'),
(7, 68, '8 halaman', '26'),
(8, 94, '4', '27-30'),
(9, 63, '1', 'Juz 29'),
(10, 82, '5 Â½', 'Juz 26-30'),
(11, 75, '1 Â½ ', '26 & 30'),
(12, 81, '5', '26-30'),
(13, 91, '15', '16-30'),
(14, 64, '5 Â½', '25-30'),
(15, 92, '8', '30-22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kelas`
--

CREATE TABLE `tbl_kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_kelas`
--

INSERT INTO `tbl_kelas` (`id_kelas`, `nama_kelas`) VALUES
(1, 'MTS - 1'),
(2, 'MTS - 2'),
(3, 'MTS - 3');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_santri`
--

CREATE TABLE `tbl_santri` (
  `id_santri` int(15) NOT NULL,
  `kode_santri` varchar(4) DEFAULT NULL,
  `nama_santri` varchar(255) DEFAULT NULL,
  `nis` varchar(15) NOT NULL,
  `nama_ortu` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `id_kelas` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_santri`
--

INSERT INTO `tbl_santri` (`id_santri`, `kode_santri`, `nama_santri`, `nis`, `nama_ortu`, `alamat`, `no_telp`, `foto`, `id_kelas`) VALUES
(55, 'S054', 'ALDIANSYAH SAPUTRA', '0111714057', 'HERMANTO', 'Jl. Raya PLN Rt025/Rt025 Desa. Gandul Kec. Cinere Kota. Depok', '087874689770', 'Pas Foto Santri_20250712_233709_0000.png', 2),
(63, 'S056', 'ARFI ABDULLAH FAQIH', '3118192813', 'AHMAD ARIF ULIN NUHA', 'JL PAJAJARAN NO 31 ASRAMA MTsN PAMULANG RT001/002 Tambun, Kec. Tambun Selatan  Kab. Bekasi', '085772066030', 'Pas Foto Santri_20250712_233233_0000.png', 2),
(64, 'S064', 'HASAN', '3118491499', 'DAHMANI SAMIR', 'JL. Kavling DKI 1,rt 006 rw,oo1 Desa. Cipayung Kec. Cipayung Kota. ADM Jakarta Timur', '082111853024', 'Pas Foto Santri_20250712_232559_0000.png', 2),
(65, 'S065', 'M RIZKY NUGRAHA MULYONO', '3117045110', 'CONDRO MULYONO', 'JL. KAMPAR 1 NO. 86 RT/RW 045/010 DESA. SIALANG KEC. SANO KAB. KOTA PALEMBANG', '08980159334', 'Pas Foto Santri_20250712_233931_0000.png', 2),
(66, 'S066', 'MUHAMAD DAMAR GESANG', '0111370838', 'SUKARYO', 'Kp. cigihing Rt001/002 Dsa. Cidokom Kec. Rumpin Kab. Bogor', '0895365423357', 'Pas Foto Santri_20250712_233651_0000.png', 2),
(67, 'S067', 'MUHAMAD FARDAN NUR WAHID', '0125780977', 'SUHANDI', 'Kp Bojong Lio Rt/003/007 Desa. Cidokom Kec. Rumpin', '08388489065', 'Pas Foto Santri_20250712_233219_0000.png', 2),
(68, 'S068', 'MUHAMAD GALIH PRASETIA', '0123964026', 'PENDI MULYANTO', 'Dsn. Karang senbung Rt04/05 Karangsembung Kec. Sonngom Kec. Brebes', '0895373543956', 'Pas Foto Santri_20250712_233632_0000.png', 2),
(69, 'S069', 'MUHAMAD IQBAL FIRDAUS', '0113927552', 'JUNYATI', 'Kp. cigihing Rt001/002 Dsa. Cidokom Kec. Rumpin Kab. Bogor', '081400787589', 'Pas Foto Santri_20250712_234327_0000.png', 2),
(70, 'S070', 'MUHAMAD RAFFA AL BASIR', '0117474737', 'ASEP CAHYANA', 'Kp. cigihing Rt001/002 Dsa. Cidokom Kec. Rumpin Kab. Bogor', '085608124105', 'Pas Foto Santri_20250712_233951_0000.png', 2),
(71, 'S071', 'MUHAMAD RIDWAN', '0123612280', 'DARGONO', 'Kp. Leuwihalang Rt.002/005 Desa. Gobang Kec. Rumpin Kab. Bogor', '085892688775', 'Pas Foto Santri_20250712_234310_0000.png', 2),
(72, 'S072', 'RIZWAN JULIANSYAH', '181901018', 'MUHAMMAD BAKRI', 'Kp. Cigihing Rt001/002 Dsa. Cidokom Kec. Rumpin Kab. Bogor', '085810658553', 'Pas Foto Santri_20250712_234227_0000.png', 2),
(73, 'S073', 'ZAKY HAIDAR FIRDAUS', '0114694024', 'MUHAMMAD RIKI', 'Jln. Utsman Naim Rt/013/011 No.37 Kel. Kelapa Dua Wetan Kec. Ciracas Jakarta Timur', '081298827696', 'Pas Foto Santri_20250712_232733_0000.png', 2),
(74, 'S074', 'MUHAMMAD NABIL', '3115232196', 'ACHMAD ROFII', 'Plogebang Cakung Jakarta Timur', '085951377929', 'Pas Foto Santri_20250712_234203_0000.png', 2),
(75, 'S075', 'MUHAMMAD IBNU DHIYAUL HAQ', '312021`7727', 'SUHAIMI', 'Jln. Soekarno Hatta 1 No 151 Rt4/2 Anggut Dalam Bengkulu', '085129598072', 'Pas Foto Santri_20250712_234347_0000.png', 2),
(78, 'S076', 'ABI YAHYA AL HULAMA', '0102608851', 'ASEP HAERUDIN', 'Jatijajar 1 Rt.03/01 No. 23 Kec.Tapos Kota. Depok', '082122932236', 'Pas Foto Santri_20250712_232617_0000.png', 3),
(79, 'S079', 'ABISALI ABDILLAH SALIMAN', '0118277979', 'FACHRUDI ALI', 'Jln. Raya Centek gang mangga,Rt005/03 Ciracas Jakarta Timur', '082122932236', 'Pas Foto Santri_20250712_234145_0000.png', 3),
(80, 'S080', 'DAFA ADITIYA ALFAKHRI', '0111711322', 'TARWACI', 'Kp. Parung Badak, Desa Cidokom, Kec. Rumpin, Kab. Bogor', '083893568084', 'Pas Foto Santri_20250712_233050_0000.png', 3),
(81, 'S081', 'ULIL AZZAM CHOIRURROHIM', '103972563', 'M. ROHIM', 'Gang Mesjid Rt 01/Rw 02 no.54 Kel.Pabuaran Kec. Cibinong Kab. Bogor', '081908701711', 'Pas Foto Santri_20250712_233001_0000.png', 3),
(82, 'S082', 'AHMAD ERLANGGA HAVID', '3110507813', 'ABDUL HAKAM', 'Perum Griyagundala jln Aliandong blok D15 Bojongsari Depok', '08568927371', 'Pas Foto Santri_20250712_233505_0000.png', 3),
(84, 'S083', 'HAICAL ROHMATULLAH', '0107625311', 'YADI SUPRIYADI', 'Kp. cigihing Rt001/002 Dsa. Cidokom Kec. Rumpin Kab. Bogor', '083870983517', 'Pas Foto Santri_20250712_233204_0000.png', 3),
(85, 'S085', 'MUHAMMAD FIKRAN AL - URSY', '3103441669', 'DENI HARTANA', 'Kenanga No 27 Rt 04/01 Kel Kenanga Kec Cipondoh Kota Tangerang', '081298517273', 'Pas Foto Santri_20250712_234402_0000.png', 3),
(88, 'S086', 'MUHAMMAD MARIE MUAZZAM', '3117337607', 'HIDAYATUL GUFRON', 'Griya Ciracas Asri Kv No 6 Jl. Pengantin Ali GG AMD RT 1 RW 06 Kel Ciracas Kec. Ciracas Jakarta Timur', '081317131781', 'Pas Foto Santri_20250712_232750_0000.png', 3),
(89, 'S089', 'HABIBIE RAHAYU SYABANIE', '3117807242', 'SULISTYO', 'Jl Pintu air no 38  01/18 Cilangkap, Tapos, Depok', '089614504102', 'Pas Foto Santri_20250712_233436_0000.png', 3),
(90, 'S090', 'ADEN RAFLY', '0113200896', 'DIDI', 'Kp. Leuwihalang Kec. Gobang Kab. Bogor', '085694329254', 'Pas Foto Santri_20250712_234113_0000.png', 3),
(91, 'S091', 'FADIL NURROCHMAN', '0113200896', 'SUHARTO', 'Dusun Gulon RT 005 RW 001 Desa Tanjung Kec. Klego Kab. Boyolali Jawa Tengah', '085640316505', 'Pas Foto Santri_20250712_232805_0000.png', 3),
(92, 'S092', 'SYAHRUL MUBAROK ZUHDI', '0102881511', 'MUHAMMAD SAKAKI', 'Parung Villa Blok C91 RT. 07 RW. 02 Desa Waru Jaya Kec. Parung Kab. Bogor', '0817361078', 'Pas Foto Santri_20250712_233452_0000.png', 3),
(93, 'S093', 'FAHRY ALL HABSY', '0105354435', 'DEDI NANDHIKA SIDIK', 'Kp. cigihing Rt001/002 Dsa. Cidokom Kec. Rumpin Kab. Bogor', '083871697838', 'Pas Foto Santri_20250712_232227_0000.png', 3),
(94, 'S094', 'MUHAMMAD SYAM SHAQIR', '119765914', 'SYAMSURI', 'jl cilandak tengah III no 40 RT/Rw 03/01 Desa Cilandak Barat Kec. Cilandak Kota Jakarta Selatan', '081282472019', 'Pas Foto Santri_20250712_233911_0000.png', 3),
(95, 'S095', 'MUHAMMAD ARIFAN SHOLIH', '3103220478', 'HENDRA KUSUMA', 'BSD Tangerang', '081399669971', 'Pas Foto Santri_20250712_232946_0000.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_surat`
--

CREATE TABLE `tbl_surat` (
  `id_surat` int(11) NOT NULL,
  `nama_surat` varchar(100) NOT NULL,
  `jumlah_ayat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_surat`
--

INSERT INTO `tbl_surat` (`id_surat`, `nama_surat`, `jumlah_ayat`) VALUES
(1, 'Al-Fatihah', 7),
(2, 'Al-Baqarah', 286),
(3, 'Ali Imran', 200),
(4, 'An-Nisa', 176),
(5, 'Al-Maidah', 120),
(6, 'Al-Anam', 165),
(7, 'Al-Araf', 206),
(8, 'Al-Anfal', 75),
(9, 'At-Taubah', 129),
(10, 'Yunus', 109),
(11, 'Hud', 123),
(12, 'Yusuf', 111),
(13, 'Ar-Rad', 43),
(14, 'Ibrahim', 52),
(15, 'Al-Hijr', 99),
(16, 'An-Nahl', 128),
(17, 'Al-Isra', 111),
(18, 'Al-Kahf', 110),
(19, 'Maryam', 98),
(20, 'Ta-Ha', 135),
(21, 'Al-Anbiya', 112),
(22, 'Al-Hajj', 78),
(23, 'Al-Muminun', 118),
(24, 'An-Nur', 64),
(25, 'Al-Furqan', 77),
(26, 'Asy-Syuara', 227),
(27, 'An-Naml', 93),
(28, 'Al-Qasas', 88),
(29, 'Al-Ankabut', 69),
(30, 'Ar-Rum', 60),
(31, 'Luqman', 34),
(32, 'As-Sajdah', 30),
(33, 'Al-Ahzab', 73),
(34, 'Saba', 54),
(35, 'Fatir', 45),
(36, 'Ya-Sin', 83),
(37, 'As-Saffat', 182),
(38, 'Sad', 88),
(39, 'Az-Zumar', 75),
(40, 'Ghafir', 85),
(41, 'Fussilat', 54),
(42, 'Asy-Syura', 53),
(43, 'Az-Zukhruf', 89),
(44, 'Ad-Dukhan', 59),
(45, 'Al-Jathiyah', 37),
(46, 'Al-Ahqaf', 35),
(47, 'Muhammad', 38),
(48, 'Al-Fath', 29),
(49, 'Al-Hujurat', 18),
(50, 'Qaf', 45),
(51, 'Az-Zariyat', 60),
(52, 'At-Tur', 49),
(53, 'An-Najm', 62),
(54, 'Al-Qamar', 55),
(55, 'Ar-Rahman', 78),
(56, 'Al-Waqiah', 96),
(57, 'Al-Hadid', 29),
(58, 'Al-Mujadilah', 22),
(59, 'Al-Hasyr', 24),
(60, 'Al-Mumtahanah', 13),
(61, 'As-Saff', 14),
(62, 'Al-Jumuah', 11),
(63, 'Al-Munafiqun', 11),
(64, 'At-Taghabun', 18),
(65, 'At-Talaq', 12),
(66, 'At-Tahrim', 12),
(67, 'Al-Mulk', 30),
(68, 'Al-Qalam', 52),
(69, 'Al-Haqqah', 52),
(70, 'Al-Maarij', 44),
(71, 'Nuh', 28),
(72, 'Al-Jinn', 28),
(73, 'Al-Muzzammil', 20),
(74, 'Al-Muddathir', 56),
(75, 'Al-Qiyamah', 40),
(76, 'Al-Insan', 31),
(77, 'Al-Mursalat', 50),
(78, 'An-Naba', 40),
(79, 'An-Naziat', 46),
(80, 'Abasa', 42),
(81, 'At-Takwir', 29),
(82, 'Al-Infitar', 19),
(83, 'Al-Mutaffifin', 36),
(84, 'Al-Insyiqaq', 25),
(85, 'Al-Buruj', 22),
(86, 'At-Tariq', 17),
(87, 'Al-Ala', 19),
(88, 'Al-Ghashiyah', 26),
(89, 'Al-Fajr', 30),
(90, 'Al-Balad', 20),
(91, 'Asy-Syams', 15),
(92, 'Al-Lail', 21),
(93, 'Ad-Duha', 11),
(94, 'Asy-Syarh', 8),
(95, 'At-Tin', 8),
(96, 'Al-Alaq', 19),
(97, 'Al-Qadr', 5),
(98, 'Al-Bayyinah', 8),
(99, 'Az-Zalzalah', 8),
(100, 'Al-Adiyat', 11),
(101, 'Al-Qariah', 11),
(102, 'At-Takatsur', 8),
(103, 'Al-Asr', 3),
(104, 'Al-Humazah', 9),
(105, 'Al-Fil', 5),
(106, 'Quraisy', 4),
(107, 'Al-Maun', 7),
(108, 'Al-Kautsar', 3),
(109, 'Al-Kafirun', 6),
(110, 'An-Nasr', 3),
(111, 'Al-Masad', 5),
(112, 'Al-Ikhlas', 4),
(113, 'Al-Falaq', 5),
(114, 'An-Nas', 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tasmi`
--

CREATE TABLE `tbl_tasmi` (
  `id_tasmi` int(11) NOT NULL,
  `id_santri` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `tambah_juz` varchar(50) DEFAULT NULL,
  `juz_tasmi` varchar(50) DEFAULT NULL,
  `khofi` text DEFAULT NULL,
  `jali` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Lanjut',
  `penyimak` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_tasmi`
--

INSERT INTO `tbl_tasmi` (`id_tasmi`, `id_santri`, `tanggal`, `tambah_juz`, `juz_tasmi`, `khofi`, `jali`, `status`, `penyimak`, `keterangan`) VALUES
(30, 63, '2025-07-16', '26', '1', '15', '7', 'Lanjut', 'Ustadz Daffa', 'Bagus');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(15) NOT NULL,
  `kode_pengguna` varchar(4) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `kode_pengguna`, `username`, `password`, `level`) VALUES
(135, 'S054', 'ALDIANSYAH SAPUTRA 24062011', '865e1502627348593ce4b503d9865658', 'Santri'),
(138, 'A020', 'admin', 'aff4b352312d5569903d88e0e68d3fbb', 'Admin'),
(144, 'G021', 'Irfansulistyo', '62550a0162ef70c7e307aea58c9c87fa', 'Guru'),
(153, 'A021', 'muhtarom', '827ccb0eea8a706c4c34a16891f84e7b', 'Admin'),
(154, 'G023', 'rizkiainurrafik', '62550a0162ef70c7e307aea58c9c87fa', 'Guru'),
(155, 'G027', 'mohmuhtarom', '62550a0162ef70c7e307aea58c9c87fa', 'Guru'),
(156, 'G028', 'nizaralmunawwar', '62550a0162ef70c7e307aea58c9c87fa', 'Guru'),
(157, 'G029', 'rmdaffafadhilaihsany', '62550a0162ef70c7e307aea58c9c87fa', 'Guru'),
(158, 'G030', 'ajizanwar', '62550a0162ef70c7e307aea58c9c87fa', 'Guru'),
(159, 'G031', 'fauziladim', '62550a0162ef70c7e307aea58c9c87fa', 'Guru'),
(160, 'G032', 'ikromtaqiyyurrahman', '62550a0162ef70c7e307aea58c9c87fa', 'Guru'),
(161, 'G033', 'izdiharuddin', '62550a0162ef70c7e307aea58c9c87fa', 'Guru'),
(162, 'G034', 'muhammadhidayat', '62550a0162ef70c7e307aea58c9c87fa', 'Guru'),
(163, 'G035', 'ikrarammarandriaslau', '62550a0162ef70c7e307aea58c9c87fa', 'Guru'),
(164, 'S056', 'ARFI ABDULLAH FAQIH 20082011', '952d0b7ac0438eb493894e46f14857dc', 'Santri'),
(165, 'S064', 'HASAN 08082011', '0e84b41559ed3070779f85f0c8a78eb6', 'Santri'),
(166, 'S065', 'M. RIZKY NUGRAHA MULYONO 20112011', 'f3674879f5e18c7989e02235da302cc9', 'Santri'),
(167, 'S066', 'MUHAMAD DAMAR GESANG 10102011', '7ca63eb7a4a7a3fb2f5239ba1d69297f', 'Santri'),
(168, 'S067', 'MUHAMAD FARDAN NUR WAHID 01012012', 'c5c7c2d4cf781812aa15b68b27f3944c', 'Santri'),
(169, 'S068', 'MUHAMAD GALIH PRASETIA 16032012', '2037b0568ca48a97990a8429fa2a4e9b', 'Santri'),
(170, 'S069', 'MUHAMAD IQBAL FIRDAUS 12102012', '23598280f3a9f0e3eca2b2b595a4602d', 'Santri'),
(171, 'S070', 'MUHAMAD RAFFA AL BASIR 06112011', 'EidQI{C5H2,!Kw?L', 'Santri'),
(172, 'S071', 'MUHAMAD RIDWAN 09032012', '78e407f94c740d4b839ce461b0854d5b', 'Santri'),
(173, 'S072', 'RIZWAN JULIANSYAH 16072012', 'f9a20df7620331f8e4d1519415f63cb0', 'Santri'),
(174, 'S073', 'ZAKY HAIDAR FIRDAUS 28072011', '42e80dfb8ec427b8ad2a908d2c753d46', 'Santri'),
(175, 'S074', 'MUHAMMAD NABIL 31082011', '04412888c9353b8a7b19728d4cadfa48', 'Santri'),
(176, 'S075', 'MUHAMMAD IBNU DHIYAUL HAQ 05032012', 'EidQI{C5H2,!Kw?L', 'Santri'),
(183, 'S076', 'ABI YAHYA AL HULAMA 02092010', '937d75fb72e57984814fe9fb90e62d3b', 'Santri'),
(184, 'S079', 'ABISALI ABDILLAH SALIMAN 29042011', '4cf6aa882aa8c20e701d482bb3766add', 'Santri'),
(185, 'S080', 'DAFA ADITIYA ALFAKHRI 03032011', '3b338bf57f04982f73b80a289f61a886', 'Santri'),
(186, 'S081', 'ULIL AZZAM CHOIRURROHIM 05082010', 'bf33d09bc777e3e45085906d0ed4d81d', 'Santri'),
(187, 'S082', 'AHMAD ERLANGGA HAVID 23012011', '9d3af8f71ea0005ed9c009b1a857982b', 'Santri'),
(188, 'S083', 'HAICAL ROHMATULLAH 27042010', 'EidQI{C5H2,!Kw?L', 'Santri'),
(189, 'S085', 'MUHAMMAD FIKRAN AL - URSY 06122010', '711af0ca96f840afed9e5bc125a5c73f', 'Santri'),
(192, 'S086', 'MUHAMMAD MARIE MUAZZAM 02062011', '03055a69553664e6a58c22674f7376cf', 'Santri'),
(193, 'S089', 'HABIBIE RAHAYU SYABANIE 11072011', 'EidQI{C5H2,!Kw?L', 'Santri'),
(194, 'S090', 'ADEN RAFLY 25062011', '0e29c5a4af9eb1c154c2b9d71e8d365a', 'Santri'),
(195, 'S091', 'FADIL NURROCHMAN 29012010', 'EidQI{C5H2,!Kw?L', 'Santri'),
(196, 'S092', 'SYAHRUL MUBAROK ZUHDI 31082010', 'aa2227b136ef63967b9c5469c5769af4', 'Santri'),
(197, 'S093', 'FAHRY ALL HABSY 04112010', 'e11fd1fac4febf388e9f517a59b8c3a9', 'Santri'),
(198, 'S094', 'MUHAMMAD SYAM SHAQIR 08072011', '68620c9ea8da5a87d63cdc736a00d03e', 'Santri'),
(199, 'S095', 'MUHAMMAD ARIFAN SHOLIH 20112011', 'f3674879f5e18c7989e02235da302cc9', 'Santri');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `kode_admin` (`kode_admin`);

--
-- Indexes for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  ADD PRIMARY KEY (`id_guru`),
  ADD KEY `kode_guru` (`kode_guru`),
  ADD KEY `fk_guru_kelas` (`id_kelas`);

--
-- Indexes for table `tbl_hafalan`
--
ALTER TABLE `tbl_hafalan`
  ADD PRIMARY KEY (`id_hafalan`),
  ADD KEY `id_santri` (`id_santri`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_surat` (`id_surat`);

--
-- Indexes for table `tbl_jumlah_juz`
--
ALTER TABLE `tbl_jumlah_juz`
  ADD PRIMARY KEY (`id_juz`),
  ADD KEY `id_santri` (`id_santri`);

--
-- Indexes for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `tbl_santri`
--
ALTER TABLE `tbl_santri`
  ADD PRIMARY KEY (`id_santri`),
  ADD KEY `kode_mahasiswa` (`kode_santri`),
  ADD KEY `fk_mahasiswa_kelas` (`id_kelas`);

--
-- Indexes for table `tbl_surat`
--
ALTER TABLE `tbl_surat`
  ADD PRIMARY KEY (`id_surat`);

--
-- Indexes for table `tbl_tasmi`
--
ALTER TABLE `tbl_tasmi`
  ADD PRIMARY KEY (`id_tasmi`),
  ADD KEY `id_santri` (`id_santri`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `kode_pengguna` (`kode_pengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  MODIFY `id_guru` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tbl_hafalan`
--
ALTER TABLE `tbl_hafalan`
  MODIFY `id_hafalan` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `tbl_jumlah_juz`
--
ALTER TABLE `tbl_jumlah_juz`
  MODIFY `id_juz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_santri`
--
ALTER TABLE `tbl_santri`
  MODIFY `id_santri` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `tbl_surat`
--
ALTER TABLE `tbl_surat`
  MODIFY `id_surat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `tbl_tasmi`
--
ALTER TABLE `tbl_tasmi`
  MODIFY `id_tasmi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  ADD CONSTRAINT `fk_guru_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `tbl_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_hafalan`
--
ALTER TABLE `tbl_hafalan`
  ADD CONSTRAINT `tbl_hafalan_ibfk_1` FOREIGN KEY (`id_santri`) REFERENCES `tbl_santri` (`id_santri`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_hafalan_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `tbl_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_hafalan_ibfk_4` FOREIGN KEY (`id_surat`) REFERENCES `tbl_surat` (`id_surat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_jumlah_juz`
--
ALTER TABLE `tbl_jumlah_juz`
  ADD CONSTRAINT `tbl_jumlah_juz_ibfk_1` FOREIGN KEY (`id_santri`) REFERENCES `tbl_santri` (`id_santri`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_santri`
--
ALTER TABLE `tbl_santri`
  ADD CONSTRAINT `fk_mahasiswa_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `tbl_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_tasmi`
--
ALTER TABLE `tbl_tasmi`
  ADD CONSTRAINT `tbl_tasmi_ibfk_1` FOREIGN KEY (`id_santri`) REFERENCES `tbl_santri` (`id_santri`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
