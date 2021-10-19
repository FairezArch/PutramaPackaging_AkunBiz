-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2019 at 02:34 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `akunpro_putramamobile_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `alamat_order`
--

CREATE TABLE `alamat_order` (
  `id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `provinsi` text NOT NULL,
  `kabupaten` text NOT NULL,
  `dt_kecamatan` text NOT NULL,
  `kelurahan` text NOT NULL,
  `kecamatan` text NOT NULL,
  `kota` varchar(200) NOT NULL,
  `main_address` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alamat_order`
--

INSERT INTO `alamat_order` (`id`, `iduser`, `alamat`, `provinsi`, `kabupaten`, `dt_kecamatan`, `kelurahan`, `kecamatan`, `kota`, `main_address`) VALUES
(4, 28, 'asd', '', '', '', 'GEDONGTENGEN', 'PRINGGOKUSUMAN', 'KOTA YOGYAKARTA', 'Tidak'),
(5, 28, 'a', '', '', '', 'DANUREJAN', 'BAUSASRAN', 'KOTA YOGYAKARTA', 'Tidak'),
(8, 28, 'a', '', '', '', 'DANUREJAN', 'BAUSASRAN', 'KOTA YOGYAKARTA', 'Tidak'),
(9, 28, 'a', '', '', '', 'DANUREJAN', 'BAUSASRAN', 'KOTA YOGYAKARTA', 'Tidak'),
(10, 28, 'a', '', '', '', 'DANUREJAN', 'BAUSASRAN', 'KOTA YOGYAKARTA', 'Tidak'),
(11, 28, 'a', '', '', '', 'DANUREJAN', 'BAUSASRAN', 'KOTA YOGYAKARTA', 'Tidak'),
(12, 27, 'Jl mawar', '', '', '', '1002', '02', '71', 'Tidak'),
(13, 27, 'Vhbbb', '', '', '', '1002', '10', '71', 'Tidak'),
(14, 27, 'Gggg', '', '', '', '1002', '02', '71', 'Tidak'),
(15, 27, 'Bhjbabb', '', '', '', '2003', '01', '04', 'Tidak'),
(16, 27, 'Vhhhbb', '', '', '', '2004', '01', '04', 'Tidak'),
(17, 22, 'bbddbk', '', '', '', '2003', '01', '04', 'Ya'),
(20, 28, 'a', '', '', '', 'DANUREJAN', 'BAUSASRAN', 'KOTA YOGYAKARTA', 'Ya'),
(22, 27, 'xcxvxc', '', '', '', '2001', '08', '02', 'Tidak'),
(23, 27, 'ugygug', '', '', '', '2004', '17', '04', 'Ya'),
(24, 29, 'Sa', '', '', '', '1001', '02', '71', 'Ya'),
(33, 31, 'sew', '', '', '', '1003', '04', '71', 'Tidak'),
(37, 31, 'sa', '', '', '', '1004', '03', '71', 'Ya'),
(57, 30, 'A', '', '', '', '1003', '04', '71', 'Ya'),
(58, 34, 'Jl. SukaMaju 17', '', '', '', '1002', '05', '71', 'Ya'),
(60, 36, 'tse', '', '', '', '1001', '05', '71', 'Ya'),
(69, 37, 'Abc', '', '', '', '2005', '10', '02', 'Ya'),
(73, 35, 'Jl. Purbaya, RT 1, Dusun Ledok, Warak, Sumberadi, Mlati, Sayidan, Sumberadi, Kec. Sleman, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55288', '', '', '', '2003', '03', '04', 'Ya'),
(74, 38, 'k', '', '', '', '2003', '10', '04', 'Ya'),
(77, 22, 'mojogedang', '', '', '', '2004', '01', '04', 'Tidak'),
(133, 32, 'Jl. Nergara Amba', '10|Jawa Tengah', '91|Boyolali', '1244|Cepogo', '', '', '', 'Tidak'),
(134, 32, 'Jl.Amperangan Warna N0.7', '5|DI Yogyakarta', '39|Bantul', '542|Jetis', '', '', '', 'Ya'),
(135, 32, 'Jl. Supra Arya 7', '11|Jawa Timur', '42|Banyuwangi', '606|Glagah', '', '', '', 'Tidak'),
(137, 32, 'Jl. Keramat Pulo', '3|Banten', '402|Serang', '5548|Cinangka', '', '', '', 'Tidak');

-- --------------------------------------------------------

--
-- Table structure for table `cabang`
--

CREATE TABLE `cabang` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `telp` int(11) NOT NULL,
  `img_cabang` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cabang`
--

INSERT INTO `cabang` (`id`, `nama`, `alamat`, `telp`, `img_cabang`) VALUES
(1, 'Yogyakarta', 'Daerah Istimewa Yogyakarta', 2147483647, ''),
(2, 'Semarang', 'jl semarang', 2147483647, '');

-- --------------------------------------------------------

--
-- Table structure for table `callback_duitku`
--

CREATE TABLE `callback_duitku` (
  `id` int(11) NOT NULL,
  `detil_user` text NOT NULL,
  `jenis_pembayaran` text NOT NULL,
  `detil_order` text NOT NULL,
  `paymentCode` varchar(50) NOT NULL,
  `reference_payment` text NOT NULL,
  `tanggal` bigint(20) NOT NULL,
  `jumlah_topup` decimal(10,0) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `daftar_grosir`
--

CREATE TABLE `daftar_grosir` (
  `id` int(11) NOT NULL,
  `qty_from` varchar(512) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `harga_satuan` varchar(712) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daftar_grosir`
--

INSERT INTO `daftar_grosir` (`id`, `qty_from`, `id_produk`, `harga_satuan`) VALUES
(3, '2|6', 226, '2650000|2500000'),
(4, '10|15', 228, '24000|22000'),
(5, '20|25', 229, '14000|16000'),
(6, '10|20', 230, '24000|22000');

-- --------------------------------------------------------

--
-- Table structure for table `datakurir`
--

CREATE TABLE `datakurir` (
  `id` int(11) NOT NULL,
  `tanggal` bigint(20) NOT NULL,
  `nama_kurir` varchar(120) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `datakurir`
--

INSERT INTO `datakurir` (`id`, `tanggal`, `nama_kurir`, `status`) VALUES
(2, 1553593556, 'jne|pos|tiki', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dataoption`
--

CREATE TABLE `dataoption` (
  `id` int(11) NOT NULL,
  `optname` varchar(128) NOT NULL,
  `optvalue` text NOT NULL,
  `urutan` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dataoption`
--

INSERT INTO `dataoption` (`id`, `optname`, `optvalue`, `urutan`) VALUES
(1, 'hotline', '0823 2830 9900', 1),
(2, 'telepon_view', '(0274) 389 304', 2),
(3, 'telepon_value', '0274 389 304', 3),
(4, 'email_kontak', 'belanjayuk@putrama.id', 4),
(5, 'instagram_url', 'https://www.instagram.com/putrama.id/', 5),
(6, 'facebook_url', 'https://www.facebook.com/putrama.id/', 6),
(7, 'web_url', 'https://putrama.id/', 7),
(8, 'about_us', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ac ullamcorper tellus. Aliquam ligula erat, tempus id dignissim ac, pharetra a risus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis mattis auctor purus, eu fringilla odio ullamcorper ac. Quisque fermentum mauris nec risus facilisis, eu faucibus ante ornare. Donec porta risus eget sodales posuere. Duis egestas feugiat sem nec varius.  Pellentesque eros eros, vulputate eu odio id, posuere varius elit. Mauris a tempus eros. Aliquam volutpat orci quis sapien imperdiet efficitur. Sed sagittis leo enim. Nulla faucibus turpis sit amet sem facilisis, ac lacinia nisl blandit. Ut vel orci blandit, iaculis tortor vel, porta risus. Mauris ultrices ex vel sem placerat, et pulvinar tortor vulputate. Donec eleifend risus a magna tempus aliquam.', 8),
(14, 'tutorial_deposit_topup', 'https://putrama.id/Tutorial-cara-deposit-topup', 0),
(15, 'tutorial_belanja', 'https://putrama.id/Tutorial-cara-belanja', 0),
(16, 'minim_pembelian', '', 0),
(17, 'tentang_kami', 'https://putrama.id/AboutUs', 0),
(18, 'help', 'https://putrama.id/Help', 0),
(19, 'biaya_ongkir', '', 0),
(9, 'terms', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ac ullamcorper tellus. Aliquam ligula erat, tempus id dignissim ac, pharetra a risus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis mattis auctor purus, eu fringilla odio ullamcorper ac. Quisque fermentum mauris nec risus facilisis, eu faucibus ante ornare. Donec porta risus eget sodales posuere. Duis egestas feugiat sem nec varius.  Pellentesque eros eros, vulputate eu odio id, posuere varius elit. Mauris a tempus eros. Aliquam volutpat orci quis sapien imperdiet efficitur. Sed sagittis leo enim. Nulla faucibus turpis sit amet sem facilisis, ac lacinia nisl blandit. Ut vel orci blandit, iaculis tortor vel, porta risus. Mauris ultrices ex vel sem placerat, et pulvinar tortor vulputate. Donec eleifend risus a magna tempus aliquam.', 9),
(10, 'privacy', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ac ullamcorper tellus. Aliquam ligula erat, tempus id dignissim ac, pharetra a risus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis mattis auctor purus, eu fringilla odio ullamcorper ac. Quisque fermentum mauris nec risus facilisis, eu faucibus ante ornare. Donec porta risus eget sodales posuere. Duis egestas feugiat sem nec varius.  Pellentesque eros eros, vulputate eu odio id, posuere varius elit. Mauris a tempus eros. Aliquam volutpat orci quis sapien imperdiet efficitur. Sed sagittis leo enim. Nulla faucibus turpis sit amet sem facilisis, ac lacinia nisl blandit. Ut vel orci blandit, iaculis tortor vel, porta risus. Mauris ultrices ex vel sem placerat, et pulvinar tortor vulputate. Donec eleifend risus a magna tempus aliquam.', 10),
(13, 'waktu_countdown', '1', 40),
(11, 'sendmail_admin', 'faizal@gravis-design.com', 11),
(12, 'global_bnstopup', '', 12),
(20, 'App_Version', '1.1.2', 0),
(22, 'waktu_notifikasi_version', '1', 0),
(23, 'alamat', 'Jl. Godean No.KM. 4,5, Kwarasan, Nogotirto, Gamping, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55599', 0),
(25, 'datakurir', 'jne|pos|tiki|ninja', 0);

-- --------------------------------------------------------

--
-- Table structure for table `data_pengguna`
--

CREATE TABLE `data_pengguna` (
  `id` int(11) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `telp` varchar(50) NOT NULL,
  `email` varchar(128) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_pengguna`
--

INSERT INTO `data_pengguna` (`id`, `nama`, `telp`, `email`, `date`) VALUES
(209, 'Rutu', '0899613822281074', '', 1557197764),
(208, 'Loki', '08996313288667', '', 1557120422),
(207, 'Hugu', '089763318209641', '', 1557120037),
(206, 'Lopu', '08553129996187', '', 1557118760),
(205, 'Huti', '086621349599733', '', 1557118543),
(204, 'yuyu', '0875136416321322', '', 1557117859),
(203, 'Gufy', '08663125818979', '', 1557112932),
(202, 'Iuy', '08663213721641', '', 1557112585),
(201, 'Tui', '0877632131232', '', 1557105595),
(200, 'Yri', '08626417341241', '', 1556871112),
(199, 'Ilu', '08663721371241', '', 1556870519),
(198, 'Yola', '0896462361237', '', 1556868999),
(197, 'Ila', '0899321747412', '', 1556868714),
(196, 'kika', '089773646263432', '', 1556867718),
(195, 'yuyu', '0897312417727731', '', 1556866776),
(194, 'Japri', '087763213188123', '', 1556865203),
(193, 'Hgfbbhhnn', '08225667588', '', 1556863982),
(192, 'Komo', '08221664888199', '', 1556863402),
(191, 'Dudu', '08332619948818', '', 1556857046),
(190, 'Ggggg', '082226885552', '', 1556855865),
(189, 'Kupo', '08553166494979', '', 1556855246),
(188, 'Jono', '08666136599979', '', 1556851608),
(187, 'Huni', '086466199963132', '', 1556844131),
(186, 'Urmu', '087743261627111', '', 1556087784),
(185, 'Hendro', '08665327717821', '', 1556067993),
(184, 'Handika', '08632771372123', '', 1556011842),
(183, 'Hendra', '08663188118828', '', 1556009548),
(182, 'Fernando', '0866531532517', '', 1556007199),
(181, 'Rumiari', '08774632166366', '', 1555896763),
(180, 'Ningrum', '085747581987', '', 1555712586),
(179, 'Mega Septia M', '082242435238', 'megamrd11@gmail.com', 1555597241),
(178, 'Praa', '085228707924', 'goprazt@gmail.com', 1555389363),
(177, 'mzmxm', '087730684718', '', 1555388688),
(176, 'Rendy', '085728059135', '', 1555316194),
(175, 'Juno', '08777546619995', '', 1555316052),
(174, 'Jihan', '082216995959948', '', 1555315440),
(173, 'List', '08661346921661', '', 1555314495),
(172, 'Rema', '0866135999218', '', 1555313684),
(171, 'Johan', '08576451263188', '', 1555313253),
(170, 'Suptu', '0846466164646', '', 1555312502);

-- --------------------------------------------------------

--
-- Table structure for table `data_voucher`
--

CREATE TABLE `data_voucher` (
  `id` int(11) NOT NULL,
  `kode` varchar(128) NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `tgl_expired` bigint(20) NOT NULL,
  `active` int(2) NOT NULL,
  `tgl_now` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_voucher`
--

INSERT INTO `data_voucher` (`id`, `kode`, `nominal`, `tgl_expired`, `active`, `tgl_now`) VALUES
(1, 'KODEPERTAMA', '5000.00', 1551718800, 1, 1551373200);

-- --------------------------------------------------------

--
-- Table structure for table `hapiut`
--

CREATE TABLE `hapiut` (
  `id` int(11) NOT NULL,
  `type` varchar(8) NOT NULL,
  `date` bigint(11) NOT NULL,
  `saldostart` decimal(15,2) NOT NULL,
  `saldonow` decimal(15,2) NOT NULL,
  `person` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '0: lunas, 1: masih',
  `aktif` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hapiut`
--

INSERT INTO `hapiut` (`id`, `type`, `date`, `saldostart`, `saldonow`, `person`, `description`, `status`, `aktif`) VALUES
(2, 'credit', 1560749160, '400000.00', '350000.00', 'Raharjo', '', 1, 1),
(3, 'debt', 1560749220, '600000.00', '600000.00', 'Kumara', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hapiut_item`
--

CREATE TABLE `hapiut_item` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `parenthp` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hapiut_item`
--

INSERT INTO `hapiut_item` (`id`, `date`, `type`, `description`, `parenthp`, `amount`) VALUES
(4, 1560749220, 'plus', '', 3, '20000.00'),
(5, 1560749400, 'minus', '', 2, '50000.00'),
(6, 1561003320, 'minus', '', 3, '20000.00');

-- --------------------------------------------------------

--
-- Table structure for table `inf_lokasi`
--

CREATE TABLE `inf_lokasi` (
  `lokasi_ID` int(11) NOT NULL,
  `lokasi_kode` varchar(50) NOT NULL DEFAULT '',
  `lokasi_nama` varchar(100) NOT NULL DEFAULT '',
  `lokasi_propinsi` int(2) NOT NULL,
  `lokasi_kabupatenkota` int(2) UNSIGNED ZEROFILL DEFAULT NULL,
  `lokasi_kecamatan` int(2) UNSIGNED ZEROFILL NOT NULL,
  `lokasi_kelurahan` int(4) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inf_lokasi`
--

INSERT INTO `inf_lokasi` (`lokasi_ID`, `lokasi_kode`, `lokasi_nama`, `lokasi_propinsi`, `lokasi_kabupatenkota`, `lokasi_kecamatan`, `lokasi_kelurahan`) VALUES
(14, '34.00.00.0000', 'DI Yogyakarta', 34, 00, 00, 0000),
(129, '34.01.00.0000', 'KABUPATEN KULONPROGO', 34, 01, 00, 0000),
(130, '34.02.00.0000', 'KABUPATEN BANTUL', 34, 02, 00, 0000),
(131, '34.03.00.0000', 'KABUPATEN GUNUNG KIDUL', 34, 03, 00, 0000),
(132, '34.04.00.0000', 'KABUPATEN SLEMAN', 34, 04, 00, 0000),
(133, '34.71.00.0000', 'KOTA YOGYAKARTA', 34, 71, 00, 0000),
(642, '34.01.01.0000', 'TEMON', 34, 01, 01, 0000),
(643, '34.01.02.0000', 'WATES', 34, 01, 02, 0000),
(644, '34.01.03.0000', 'PANJATAN', 34, 01, 03, 0000),
(645, '34.01.04.0000', 'GALUR', 34, 01, 04, 0000),
(646, '34.01.05.0000', 'LENDAH', 34, 01, 05, 0000),
(647, '34.01.06.0000', 'SENTOLO', 34, 01, 06, 0000),
(648, '34.01.07.0000', 'PENGASIH', 34, 01, 07, 0000),
(649, '34.01.08.0000', 'KOKAP', 34, 01, 08, 0000),
(650, '34.01.09.0000', 'GIRIMULYO', 34, 01, 09, 0000),
(651, '34.01.10.0000', 'NANGGULAN', 34, 01, 10, 0000),
(652, '34.01.11.0000', 'SAMIGALUH', 34, 01, 11, 0000),
(653, '34.01.12.0000', 'KALIBAWANG', 34, 01, 12, 0000),
(654, '34.02.01.0000', 'SRANDAKAN', 34, 02, 01, 0000),
(655, '34.02.02.0000', 'SADEN', 34, 02, 02, 0000),
(656, '34.02.03.0000', 'KRETEK', 34, 02, 03, 0000),
(657, '34.02.04.0000', 'PUNDONG', 34, 02, 04, 0000),
(658, '34.02.05.0000', 'BAMBANG LIPURO', 34, 02, 05, 0000),
(659, '34.02.06.0000', 'PANDAK', 34, 02, 06, 0000),
(660, '34.02.07.0000', 'PAJANGAN', 34, 02, 07, 0000),
(661, '34.02.08.0000', 'BANTUL', 34, 02, 08, 0000),
(662, '34.02.09.0000', 'JETIS', 34, 02, 09, 0000),
(663, '34.02.10.0000', 'IMOGIRI', 34, 02, 10, 0000),
(664, '34.02.11.0000', 'DLINGO', 34, 02, 11, 0000),
(665, '34.02.12.0000', 'BANGUNTAPAN', 34, 02, 12, 0000),
(666, '34.02.13.0000', 'PLERET', 34, 02, 13, 0000),
(667, '34.02.14.0000', 'PIYUNGAN', 34, 02, 14, 0000),
(668, '34.02.15.0000', 'SEWON', 34, 02, 15, 0000),
(669, '34.02.16.0000', 'KASIHAN', 34, 02, 16, 0000),
(670, '34.02.17.0000', 'SEDAYU', 34, 02, 17, 0000),
(671, '34.03.01.0000', 'WONOSARI', 34, 03, 01, 0000),
(672, '34.03.02.0000', 'NGLIPAR', 34, 03, 02, 0000),
(673, '34.03.03.0000', 'PLAYEN', 34, 03, 03, 0000),
(674, '34.03.04.0000', 'PATUK', 34, 03, 04, 0000),
(675, '34.03.05.0000', 'PALIYAN', 34, 03, 05, 0000),
(676, '34.03.06.0000', 'PANGGANG', 34, 03, 06, 0000),
(677, '34.03.07.0000', 'TEPUS', 34, 03, 07, 0000),
(678, '34.03.08.0000', 'SEMANU', 34, 03, 08, 0000),
(679, '34.03.09.0000', 'KARANGMOJO', 34, 03, 09, 0000),
(680, '34.03.10.0000', 'PONJONG', 34, 03, 10, 0000),
(681, '34.03.11.0000', 'RONGKOP', 34, 03, 11, 0000),
(682, '34.03.12.0000', 'SEMIN', 34, 03, 12, 0000),
(683, '34.03.13.0000', 'NGAWEN', 34, 03, 13, 0000),
(684, '34.03.14.0000', 'GEDANGSARI', 34, 03, 14, 0000),
(685, '34.03.15.0000', 'SAPTOSARI', 34, 03, 15, 0000),
(686, '34.03.16.0000', 'GIRISUBO', 34, 03, 16, 0000),
(687, '34.03.17.0000', 'TANJUNGSARI', 34, 03, 17, 0000),
(688, '34.03.18.0000', 'PURWOSARI', 34, 03, 18, 0000),
(841, '34.04.01.0000', 'GAMPING', 34, 04, 01, 0000),
(842, '34.04.02.0000', 'GODEAN', 34, 04, 02, 0000),
(843, '34.04.03.0000', 'MOYUDAN', 34, 04, 03, 0000),
(844, '34.04.04.0000', 'MINGGIR', 34, 04, 04, 0000),
(845, '34.04.05.0000', 'SEYEGAN', 34, 04, 05, 0000),
(846, '34.04.06.0000', 'MLATI', 34, 04, 06, 0000),
(847, '34.04.07.0000', 'DEPOK', 34, 04, 07, 0000),
(848, '34.04.08.0000', 'BERBAH', 34, 04, 08, 0000),
(849, '34.04.09.0000', 'PRAMBANAN', 34, 04, 09, 0000),
(850, '34.04.10.0000', 'KALASAN', 34, 04, 10, 0000),
(851, '34.04.11.0000', 'NGEMPLAK', 34, 04, 11, 0000),
(852, '34.04.12.0000', 'NGAGLIK', 34, 04, 12, 0000),
(853, '34.04.13.0000', 'SLEMAN', 34, 04, 13, 0000),
(854, '34.04.14.0000', 'TEMPEL', 34, 04, 14, 0000),
(855, '34.04.15.0000', 'TURI', 34, 04, 15, 0000),
(856, '34.04.16.0000', 'PAKEM', 34, 04, 16, 0000),
(857, '34.04.17.0000', 'CANGKRINGAN', 34, 04, 17, 0000),
(858, '34.71.01.0000', 'TEGALREJO', 34, 71, 01, 0000),
(859, '34.71.02.0000', 'JETIS', 34, 71, 02, 0000),
(860, '34.71.03.0000', 'GONDOKUSUMAN', 34, 71, 03, 0000),
(861, '34.71.04.0000', 'DANUREJAN', 34, 71, 04, 0000),
(862, '34.71.05.0000', 'GEDONGTENGEN', 34, 71, 05, 0000),
(863, '34.71.06.0000', 'NGAMPILAN', 34, 71, 06, 0000),
(864, '34.71.07.0000', 'WIROBRAJAN', 34, 71, 07, 0000),
(865, '34.71.08.0000', 'MANTRIJERON', 34, 71, 08, 0000),
(866, '34.71.09.0000', 'KRATON', 34, 71, 09, 0000),
(867, '34.71.10.0000', 'GONDOMANAN', 34, 71, 10, 0000),
(868, '34.71.11.0000', 'PAKUALAMAN', 34, 71, 11, 0000),
(869, '34.71.12.0000', 'MERGANGSAN', 34, 71, 12, 0000),
(870, '34.71.13.0000', 'UMBUL HARJO', 34, 71, 13, 0000),
(871, '34.71.14.0000', 'KOTA GEDE', 34, 71, 14, 0000),
(14744, '34.01.01.2001', 'JANGKARAN', 34, 01, 01, 2001),
(14745, '34.01.01.2002', 'SINDUTAN', 34, 01, 01, 2002),
(14746, '34.01.01.2003', 'PALIHAN', 34, 01, 01, 2003),
(14747, '34.01.01.2004', 'GLAGAH', 34, 01, 01, 2004),
(14748, '34.01.01.2005', 'KALIDENGEN', 34, 01, 01, 2005),
(14749, '34.01.01.2006', 'PLUMBON', 34, 01, 01, 2006),
(14750, '34.01.01.2007', 'KEDUNDANG', 34, 01, 01, 2007),
(14751, '34.01.01.2008', 'DEMEN', 34, 01, 01, 2008),
(14752, '34.01.01.2009', 'KULUR', 34, 01, 01, 2009),
(14753, '34.01.01.2010', 'KALIGINTUNG', 34, 01, 01, 2010),
(14754, '34.01.01.2011', 'TEMON WETAN', 34, 01, 01, 2011),
(14755, '34.01.01.2012', 'TEMON KULON', 34, 01, 01, 2012),
(14756, '34.01.01.2013', 'KEBON REJO', 34, 01, 01, 2013),
(14757, '34.01.01.2014', 'JANTEN', 34, 01, 01, 2014),
(14758, '34.01.01.2015', 'KARANG WULUH', 34, 01, 01, 2015),
(14759, '34.01.02.2001', 'KARANGWUNI', 34, 01, 02, 2001),
(14760, '34.01.02.2002', 'SOGAN', 34, 01, 02, 2002),
(14761, '34.01.02.2003', 'KULWARU', 34, 01, 02, 2003),
(14762, '34.01.02.2004', 'NGESTlHARJO', 34, 01, 02, 2004),
(14763, '34.01.02.2005', 'BENDUNGAN', 34, 01, 02, 2005),
(14764, '34.01.02.2006', 'TRIHARJO', 34, 01, 02, 2006),
(14765, '34.01.02.2007', 'GIRl PENI', 34, 01, 02, 2007),
(14766, '34.01.02.2008', 'WATES', 34, 01, 02, 2008),
(14767, '34.01.03.2001', 'GARONGAN', 34, 01, 03, 2001),
(14768, '34.01.03.2002', 'PLERET', 34, 01, 03, 2002),
(14769, '34.01.03.2003', 'BUGEL', 34, 01, 03, 2003),
(14770, '34.01.03.2004', 'KANOMAN', 34, 01, 03, 2004),
(14771, '34.01.03.2005', 'DEPOK', 34, 01, 03, 2005),
(15000, '34.01.03.2006', 'BOJONG', 34, 01, 03, 2006),
(15001, '34.01.03.2007', 'TAYUBAN', 34, 01, 03, 2007),
(15002, '34.01.03.2008', 'GOTAKAN', 34, 01, 03, 2008),
(15003, '34.01.03.2009', 'PANJATAN', 34, 01, 03, 2009),
(15004, '34.01.03.2010', 'CERME', 34, 01, 03, 2010),
(15005, '34.01.03.2011', 'KREMBANGAN', 34, 01, 03, 2011),
(15006, '34.01.04.2001', 'BANARAN', 34, 01, 04, 2001),
(15007, '34.01.04.2002', 'KRANGGAN', 34, 01, 04, 2002),
(15008, '34.01.04.2003', 'NOMPOREJO', 34, 01, 04, 2003),
(15009, '34.01.04.2004', 'KARANG SEWU', 34, 01, 04, 2004),
(15010, '34.01.04.2005', 'TIRTORAHAYU', 34, 01, 04, 2005),
(15011, '34.01.04.2006', 'PANDOWAN', 34, 01, 04, 2006),
(15012, '34.01.04.2007', 'BROSOT', 34, 01, 04, 2007),
(15013, '34.01.05.2001', 'WAHYUHARJO', 34, 01, 05, 2001),
(15014, '34.01.05.2002', 'BUMIREJO', 34, 01, 05, 2002),
(15015, '34.01.05.2003', 'JATIREJO', 34, 01, 05, 2003),
(15016, '34.01.05.2004', 'SIDOREJO', 34, 01, 05, 2004),
(15017, '34.01.05.2005', 'GULUREJO', 34, 01, 05, 2005),
(15018, '34.01.05.2006', 'NGENTAKREJO', 34, 01, 05, 2006),
(15019, '34.01.06.2001', 'DEMANGREJO', 34, 01, 06, 2001),
(15020, '34.01.06.2002', 'SRIKAYANGAN', 34, 01, 06, 2002),
(15021, '34.01.06.2003', 'TUKSONO', 34, 01, 06, 2003),
(15022, '34.01.06.2004', 'SALAMREJO', 34, 01, 06, 2004),
(15023, '34.01.06.2005', 'SUKORENO', 34, 01, 06, 2005),
(15024, '34.01.06.2006', 'KALI AGUNG', 34, 01, 06, 2006),
(15025, '34.01.06.2007', 'SENTOLO', 34, 01, 06, 2007),
(15026, '34.01.06.2008', 'BANGUNCIPTO', 34, 01, 06, 2008),
(15027, '34.01.07.2001', 'TAWANGSARI', 34, 01, 07, 2001),
(15028, '34.01.07.2002', 'KARANGSARI', 34, 01, 07, 2002),
(15029, '34.01.07.2003', 'KEDUNGSARI', 34, 01, 07, 2003),
(15030, '34.01.07.2004', 'MARGOSARI', 34, 01, 07, 2004),
(15031, '34.01.07.2005', 'PENGASIH', 34, 01, 07, 2005),
(15032, '34.01.07.2006', 'SENDANGSARI', 34, 01, 07, 2006),
(15033, '34.01.07.2007', 'SIDOMULYO', 34, 01, 07, 2007),
(15034, '34.01.08.2001', 'HARGOMULYO', 34, 01, 08, 2001),
(15035, '34.01.08.2002', 'HARGOREJO', 34, 01, 08, 2002),
(15036, '34.01.08.2003', 'HARGOWILIS', 34, 01, 08, 2003),
(15037, '34.01.08.2004', 'KALIREJO', 34, 01, 08, 2004),
(15038, '34.01.08.2005', 'HARGOTIRTO', 34, 01, 08, 2005),
(15039, '34.01.09.2001', 'JATIMULYO', 34, 01, 09, 2001),
(15040, '34.01.09.2002', 'GIRIPURWO', 34, 01, 09, 2002),
(15041, '34.01.09.2003', 'PENDOWOREJO ', 34, 01, 09, 2003),
(15042, '34.01.09.2004', 'PURWOSARI', 34, 01, 09, 2004),
(15043, '34.01.10.2001', 'BANYUROTO', 34, 01, 10, 2001),
(15044, '34.01.10.2002', 'DONOMULYO', 34, 01, 10, 2002),
(15045, '34.01.10.2003', 'WIJIMULYO', 34, 01, 10, 2003),
(15046, '34.01.10.2004', 'TANJUNG HAR]O', 34, 01, 10, 2004),
(15047, '34.01.10.2005', 'JATISARONO', 34, 01, 10, 2005),
(15048, '34.01.10.2006', 'KEMBANG', 34, 01, 10, 2006),
(15049, '34.01.11.2001', 'KEBONHARJO', 34, 01, 11, 2001),
(15050, '34.01.11.2002', 'BANJARSARI', 34, 01, 11, 2002),
(15051, '34.01.11.2003', 'PURWOHARJO', 34, 01, 11, 2003),
(15052, '34.01.11.2004', 'SIDOHARJO', 34, 01, 11, 2004),
(15053, '34.01.11.2005', 'GERBOSARI', 34, 01, 11, 2005),
(15054, '34.01.11.2006', 'NGARGOSARI', 34, 01, 11, 2006),
(15055, '34.01.11.2007', 'PAGERHARJO', 34, 01, 11, 2007),
(15056, '34.01.12.2001', 'BANJARARUM', 34, 01, 12, 2001),
(15057, '34.01.12.2002', 'BANJAR ASRI', 34, 01, 12, 2002),
(15058, '34.01.12.2003', 'BANJARHARJO', 34, 01, 12, 2003),
(15059, '34.01.12.2004', 'BANJAROYO', 34, 01, 12, 2004),
(15060, '34.02.01.1001', 'PONCOSARI', 34, 02, 01, 1001),
(15061, '34.02.01.1002', 'TRIMURTI', 34, 02, 01, 1002),
(15062, '34.02.02.2001', 'GADINGSARI', 34, 02, 02, 2001),
(15063, '34.02.02.2002', 'GADINGHARJO', 34, 02, 02, 2002),
(15064, '34.02.02.2003', 'SRI GADING', 34, 02, 02, 2003),
(15065, '34.02.02.2004', 'MURTIGADING', 34, 02, 02, 2004),
(15066, '34.02.03.2001', 'TIRTOMULYO', 34, 02, 03, 2001),
(15067, '34.02.03.2002', 'PARANGTRITIS', 34, 02, 03, 2002),
(15068, '34.02.03.2003', 'DONOTIRTO', 34, 02, 03, 2003),
(15069, '34.02.03.2004', 'TIRTOSARI', 34, 02, 03, 2004),
(15070, '34.02.03.2005', 'TIRTOHARGO', 34, 02, 03, 2005),
(15071, '34.02.04.2001', 'SELOHARJO', 34, 02, 04, 2001),
(15072, '34.02.04.2002', 'PANJANG REJO', 34, 02, 04, 2002),
(15073, '34.02.04.2003', 'SRI HARDONO', 34, 02, 04, 2003),
(15074, '34.02.05.2001', 'SIDOMULYO', 34, 02, 05, 2001),
(15075, '34.02.05.2002', 'MULYODADI', 34, 02, 05, 2002),
(15076, '34.02.05.2003', 'SUMBER MULYO', 34, 02, 05, 2003),
(15077, '34.02.06.2001', 'CATURHARJO', 34, 02, 06, 2001),
(15078, '34.02.06.2002', 'TRI HARJO', 34, 02, 06, 2002),
(15079, '34.02.06.2003', 'GILANG HARJO', 34, 02, 06, 2003),
(15080, '34.02.06.2004', 'WIJIREJO', 34, 02, 06, 2004),
(15081, '34.02.07.2001', 'TRI WIDADI', 34, 02, 07, 2001),
(15082, '34.02.07.2002', 'SENDANGSARI', 34, 02, 07, 2002),
(15083, '34.02.07.2003', 'GUWOSARI', 34, 02, 07, 2003),
(15084, '34.02.08.2001', 'PALBAPANG', 34, 02, 08, 2001),
(15085, '34.02.08.2002', 'RINGIN HARJO', 34, 02, 08, 2002),
(15086, '34.02.08.2003', 'BANTUL', 34, 02, 08, 2003),
(15087, '34.02.08.2004', 'TRI RENGGO', 34, 02, 08, 2004),
(15088, '34.02.08.2005', 'SABDODADI', 34, 02, 08, 2005),
(15089, '34.02.09.2001', 'PATALAN', 34, 02, 09, 2001),
(15090, '34.02.09.2002', 'CANDEN', 34, 02, 09, 2002),
(15091, '34.02.09.2003', 'SUMBER AGUNG', 34, 02, 09, 2003),
(15092, '34.02.09.2004', 'TRIMULYO', 34, 02, 09, 2004),
(15093, '34.02.10.2001', 'SELOPAMIORO', 34, 02, 10, 2001),
(15094, '34.02.10.2002', 'SRlHARJO', 34, 02, 10, 2002),
(15095, '34.02.10.2003', 'WUKIRSARI', 34, 02, 10, 2003),
(15096, '34.02.10.2004', 'KEBONAGUNG', 34, 02, 10, 2004),
(15097, '34.02.10.2005', 'KARANG TENGAH', 34, 02, 10, 2005),
(15098, '34.02.10.2006', 'GIRl REJO', 34, 02, 10, 2006),
(15099, '34.02.10.2007', 'KARANG TALUN', 34, 02, 10, 2007),
(15100, '34.02.10.2008', 'IMOGIRI', 34, 02, 10, 2008),
(15101, '34.02.11.2001', 'MANGUNAN', 34, 02, 11, 2001),
(15102, '34.02.11.2002', 'MUNTUK', 34, 02, 11, 2002),
(15103, '34.02.11.2003', 'DLINGO', 34, 02, 11, 2003),
(15104, '34.02.11.2004', 'TEMUWUH', 34, 02, 11, 2004),
(15105, '34.02.11.2005', 'TERONG', 34, 02, 11, 2005),
(15106, '34.02.11.2006', 'JATIMULYO', 34, 02, 11, 2006),
(15107, '34.02.12.2001', 'BATURETNO', 34, 02, 12, 2001),
(15108, '34.02.12.2002', 'BANGUNTAPAN', 34, 02, 12, 2002),
(15109, '34.02.12.2003', 'JAGALAN', 34, 02, 12, 2003),
(15110, '34.02.12.2004', 'SINGOSAREN', 34, 02, 12, 2004),
(15111, '34.02.12.2005', 'JAMBITAN', 34, 02, 12, 2005),
(15112, '34.02.12.2006', 'POTORONO', 34, 02, 12, 2006),
(15113, '34.02.12.2007', 'TAMANAN', 34, 02, 12, 2007),
(15114, '34.02.12.2008', 'WIROKERTEN', 34, 02, 12, 2008),
(15115, '34.02.13.2001', 'WONOKROMO', 34, 02, 13, 2001),
(15116, '34.02.13.2002', 'PLERET', 34, 02, 13, 2002),
(15117, '34.02.13.2003', 'SEGOROYOSO', 34, 02, 13, 2003),
(15118, '34.02.13.2004', 'BAWURAN', 34, 02, 13, 2004),
(15119, '34.02.13.2005', 'WONOLELO', 34, 02, 13, 2005),
(15120, '34.02.14.2001', 'SITIMULYO', 34, 02, 14, 2001),
(15121, '34.02.14.2002', 'SRIMULYO', 34, 02, 14, 2002),
(15122, '34.02.14.2003', 'SRlMARTANI', 34, 02, 14, 2003),
(15123, '34.02.15.2001', 'PENDOWOHARJO', 34, 02, 15, 2001),
(15124, '34.02.15.2002', 'TIMBULHARJO', 34, 02, 15, 2002),
(15125, '34.02.15.2003', 'BANGUNHARJO', 34, 02, 15, 2003),
(15126, '34.02.15.2004', 'PANGGUNGHARJO', 34, 02, 15, 2004),
(15127, '34.02.16.2001', 'BANGUNJIWO', 34, 02, 16, 2001),
(15128, '34.02.16.2002', 'TIRTO NIRMOLO', 34, 02, 16, 2002),
(15129, '34.02.16.2003', 'TAMAN TIRTO', 34, 02, 16, 2003),
(15130, '34.02.16.2004', 'NGESTlHARJO', 34, 02, 16, 2004),
(15131, '34.02.17.2001', 'ARGODADI', 34, 02, 17, 2001),
(15132, '34.02.17.2002', 'ARGOREJO', 34, 02, 17, 2002),
(15133, '34.02.17.2003', 'ARGOSARI', 34, 02, 17, 2003),
(15134, '34.02.17.2004', 'ARGOMULYO', 34, 02, 17, 2004),
(15135, '34.03.01.2001', 'WONOSARI', 34, 03, 01, 2001),
(15136, '34.03.01.2002', 'KEPEK', 34, 03, 01, 2002),
(15137, '34.03.01.2003', 'PIYAMAN', 34, 03, 01, 2003),
(15138, '34.03.01.2004', 'GARI', 34, 03, 01, 2004),
(15139, '34.03.01.2005', 'KARANG TENGAH', 34, 03, 01, 2005),
(15140, '34.03.01.2006', 'SELANG', 34, 03, 01, 2006),
(15141, '34.03.01.2007', 'BALEHARJO', 34, 03, 01, 2007),
(15142, '34.03.01.2008', 'SIRAMAN', 34, 03, 01, 2008),
(15143, '34.03.01.2009', 'PULUTAN', 34, 03, 01, 2009),
(15144, '34.03.01.2010', 'WARENG', 34, 03, 01, 2010),
(15145, '34.03.01.2011', 'DUWET', 34, 03, 01, 2011),
(15146, '34.03.01.2012', 'MULO', 34, 03, 01, 2012),
(15147, '34.03.01.2013', 'WUNUNG', 34, 03, 01, 2013),
(15148, '34.03.01.2014', 'KARANG REJEK', 34, 03, 01, 2014),
(15149, '34.03.02.2001', 'NATAH', 34, 03, 02, 2001),
(15150, '34.03.02.2002', 'PILANG REJO', 34, 03, 02, 2002),
(15151, '34.03.02.2003', 'KEDUNGPOH', 34, 03, 02, 2003),
(15152, '34.03.02.2004', 'PENGKOL', 34, 03, 02, 2004),
(15153, '34.03.02.2005', 'KEDUNGKERIS', 34, 03, 02, 2005),
(15154, '34.03.02.2006', 'NGLIPAR', 34, 03, 02, 2006),
(15155, '34.03.02.2007', 'KATONGAN', 34, 03, 02, 2007),
(15156, '34.03.03.2001', 'BANYUSOCO', 34, 03, 03, 2001),
(15157, '34.03.03.2002', 'PLEMBUTAN', 34, 03, 03, 2002),
(15158, '34.03.03.2003', 'BLEBERAN', 34, 03, 03, 2003),
(15159, '34.03.03.2004', 'GETAS', 34, 03, 03, 2004),
(15160, '34.03.03.2005', 'DENGOK', 34, 03, 03, 2005),
(15161, '34.03.03.2006', 'NGUNUT', 34, 03, 03, 2006),
(15162, '34.03.03.2007', 'PLAYEN', 34, 03, 03, 2007),
(15163, '34.03.03.2008', 'NGAWU', 34, 03, 03, 2008),
(15164, '34.03.03.2009', 'BANDUNG', 34, 03, 03, 2009),
(15165, '34.03.03.2010', 'LOGANDENG', 34, 03, 03, 2010),
(15166, '34.03.03.2011', 'GADING', 34, 03, 03, 2011),
(15167, '34.03.03.2012', 'BANARAN', 34, 03, 03, 2012),
(15168, '34.03.03.2013', 'NGLERI', 34, 03, 03, 2013),
(15169, '34.03.04.2001', 'BUNDER', 34, 03, 04, 2001),
(15170, '34.03.04.2002', 'BEJI', 34, 03, 04, 2002),
(15171, '34.03.04.2003', 'PENGKOK', 34, 03, 04, 2003),
(15172, '34.03.04.2004', 'SEMOYO', 34, 03, 04, 2004),
(15173, '34.03.04.2005', 'SALAM', 34, 03, 04, 2005),
(15174, '34.03.04.2006', 'PATUK', 34, 03, 04, 2006),
(15175, '34.03.04.2007', 'NGORO - ORO', 34, 03, 04, 2007),
(15176, '34.03.04.2008', 'NGLANGGERAN', 34, 03, 04, 2008),
(15177, '34.03.04.2009', 'PUTAT', 34, 03, 04, 2009),
(15178, '34.03.04.2010', 'NGLEGI', 34, 03, 04, 2010),
(15179, '34.03.04.2011', 'TERBAH', 34, 03, 04, 2011),
(15180, '34.03.05.2001', 'SODO', 34, 03, 05, 2001),
(15181, '34.03.05.2002', 'PAMPANG', 34, 03, 05, 2002),
(15182, '34.03.05.2003', 'GROGOL', 34, 03, 05, 2003),
(15183, '34.03.05.2004', 'KARANG DUW''ET', 34, 03, 05, 2004),
(15184, '34.03.05.2005', 'KARANG ASEM', 34, 03, 05, 2005),
(15185, '34.03.05.2006', 'MULUSAN', 34, 03, 05, 2006),
(15186, '34.03.05.2007', 'GIRING', 34, 03, 05, 2007),
(15187, '34.03.06.2001', 'GIRIKARTO', 34, 03, 06, 2001),
(15188, '34.03.06.2002', 'GIRISEKAR', 34, 03, 06, 2002),
(15189, '34.03.06.2003', 'GIRIMULYO', 34, 03, 06, 2003),
(15190, '34.03.06.2004', 'GIRIWUNGU', 34, 03, 06, 2004),
(15191, '34.03.06.2005', 'GIRIHARJO', 34, 03, 06, 2005),
(15192, '34.03.06.2006', 'GIRISUKO', 34, 03, 06, 2006),
(15193, '34.03.07.2001', 'GIRIPANGGUNG', 34, 03, 07, 2001),
(15194, '34.03.07.2002', 'SUMBERWUNGU', 34, 03, 07, 2002),
(15195, '34.03.07.2003', 'SIDOHARJO', 34, 03, 07, 2003),
(15196, '34.03.07.2004', 'TEPUS', 34, 03, 07, 2004),
(15197, '34.03.07.2005', 'PURWODADI', 34, 03, 07, 2005),
(15198, '34.03.08.2001', 'NGEPOSARI', 34, 03, 08, 2001),
(15199, '34.03.08.2002', 'SEMANU', 34, 03, 08, 2002),
(15200, '34.03.08.2003', 'PACA REJO', 34, 03, 08, 2003),
(15201, '34.03.08.2004', 'CANDI REJO', 34, 03, 08, 2004),
(15202, '34.03.08.2005', 'DADAPAYU', 34, 03, 08, 2005),
(15203, '34.03.09.2001', 'BEJI HARJO', 34, 03, 09, 2001),
(15204, '34.03.09.2002', 'WILADEG', 34, 03, 09, 2002),
(15205, '34.03.09.2003', 'BENDUNGAN', 34, 03, 09, 2003),
(15206, '34.03.09.2004', 'KELOR', 34, 03, 09, 2004),
(15207, '34.03.09.2005', 'NGIPAK', 34, 03, 09, 2005),
(15208, '34.03.09.2006', 'KARANGMOJO', 34, 03, 09, 2006),
(15209, '34.03.09.2007', 'GEDANGREJO', 34, 03, 09, 2007),
(15210, '34.03.09.2008', 'NGAWIS', 34, 03, 09, 2008),
(15211, '34.03.09.2009', 'JATIAYU', 34, 03, 09, 2009),
(15212, '34.03.10.2001', 'UMBULREJO', 34, 03, 10, 2001),
(15213, '34.03.10.2002', 'SAWAHAN', 34, 03, 10, 2002),
(15214, '34.03.10.2003', 'TAMBAK ROMO', 34, 03, 10, 2003),
(15215, '34.03.10.2004', 'KENTENG', 34, 03, 10, 2004),
(15216, '34.03.10.2005', 'SUMBER GIRI', 34, 03, 10, 2005),
(15217, '34.03.10.2006', 'GENJAHAN', 34, 03, 10, 2006),
(15218, '34.03.10.2007', 'PONJ0NG', 34, 03, 10, 2007),
(15219, '34.03.10.2008', 'KARANG ASEM', 34, 03, 10, 2008),
(15220, '34.03.10.2009', 'BEDOYO', 34, 03, 10, 2009),
(15221, '34.03.10.2010', 'SIDOREJO', 34, 03, 10, 2010),
(15222, '34.03.10.2011', 'GOMBANG', 34, 03, 10, 2011),
(15223, '34.03.11.2001', 'BOHOL', 34, 03, 11, 2001),
(15224, '34.03.11.2002', 'PRINGOMBO', 34, 03, 11, 2002),
(15225, '34.03.11.2003', 'BOTODAYAAN', 34, 03, 11, 2003),
(15226, '34.03.11.2004', 'PETIR', 34, 03, 11, 2004),
(15227, '34.03.11.2005', 'PUCANGANOM', 34, 03, 11, 2005),
(15228, '34.03.11.2006', 'SEMUGIH', 34, 03, 11, 2006),
(15229, '34.03.11.2007', 'MELIKAN', 34, 03, 11, 2007),
(15230, '34.03.11.2008', 'KARANGWUNI', 34, 03, 11, 2008),
(15231, '34.03.12.2001', 'KALITEKUK', 34, 03, 12, 2001),
(15232, '34.03.12.2002', 'KEMEJING', 34, 03, 12, 2002),
(15233, '34.03.12.2003', 'BULUREJO', 34, 03, 12, 2003),
(15234, '34.03.12.2004', 'SUMBER REJO', 34, 03, 12, 2004),
(15235, '34.03.12.2005', 'BENDUNG', 34, 03, 12, 2005),
(15236, '34.03.12.2006', 'CANDIREJO', 34, 03, 12, 2006),
(15237, '34.03.12.2007', 'REJOSARI', 34, 03, 12, 2007),
(15238, '34.03.12.2008', 'KARANGSARI ', 34, 03, 12, 2008),
(15239, '34.03.12.2009', 'PUNDUNGSARI', 34, 03, 12, 2009),
(15240, '34.03.12.2010', 'SEMIN', 34, 03, 12, 2010),
(15241, '34.03.13.2001', 'TANCEP', 34, 03, 13, 2001),
(15242, '34.03.13.2002', 'SEMBI REJO', 34, 03, 13, 2002),
(15243, '34.03.13.2003', 'JURANGJERO', 34, 03, 13, 2003),
(15244, '34.03.13.2004', 'KAMPUNG', 34, 03, 13, 2004),
(15245, '34.03.13.2005', 'BEJI', 34, 03, 13, 2005),
(15246, '34.03.13.2006', 'WATUSIGAR', 34, 03, 13, 2006),
(15247, '34.03.14.2001', 'HARGOMULYO', 34, 03, 14, 2001),
(15248, '34.03.14.2002', 'MERTELU', 34, 03, 14, 2002),
(15249, '34.03.14.2003', 'WATUGAJAH', 34, 03, 14, 2003),
(15250, '34.03.14.2004', 'SAMPANG', 34, 03, 14, 2004),
(15251, '34.03.14.2005', 'SERUT', 34, 03, 14, 2005),
(15252, '34.03.14.2006', 'NGALANG', 34, 03, 14, 2006),
(15253, '34.03.14.2007', 'TEGALREJO', 34, 03, 14, 2007),
(15254, '34.03.15.2001', 'KRAMBILSAWIT', 34, 03, 15, 2001),
(15255, '34.03.15.2002', 'NGLORO', 34, 03, 15, 2002),
(15256, '34.03.15.2003', 'JETIS', 34, 03, 15, 2003),
(15257, '34.03.15.2004', 'KEPEK', 34, 03, 15, 2004),
(15258, '34.03.15.2005', 'KANIGORO', 34, 03, 15, 2005),
(15259, '34.03.15.2006', 'MONGGOL', 34, 03, 15, 2006),
(15260, '34.03.15.2007', 'PLANJAN', 34, 03, 15, 2007),
(15261, '34.03.16.2001', 'BALONG', 34, 03, 16, 2001),
(15262, '34.03.16.2002', 'JEPITU', 34, 03, 16, 2002),
(15263, '34.03.16.2003', 'KARANGAWEN', 34, 03, 16, 2003),
(15264, '34.03.16.2004', 'NGLINDUR', 34, 03, 16, 2004),
(15265, '34.03.16.2005', 'JERUKWUDEL', 34, 03, 16, 2005),
(15266, '34.03.16.2006', 'TILENG', 34, 03, 16, 2006),
(15267, '34.03.16.2007', 'PUCUNG', 34, 03, 16, 2007),
(15268, '34.03.16.2008', 'SONGBANYU', 34, 03, 16, 2008),
(15269, '34.03.17.2001', 'HARGOSARI', 34, 03, 17, 2001),
(15270, '34.03.17.2002', 'KEMIRI', 34, 03, 17, 2002),
(15271, '34.03.17.2003', 'KEMADANG', 34, 03, 17, 2003),
(15272, '34.03.17.2004', 'BANJAREJO', 34, 03, 17, 2004),
(15273, '34.03.17.2005', 'NGESTIREJO', 34, 03, 17, 2005),
(15274, '34.03.18.2001', 'GIRIPURWO', 34, 03, 18, 2001),
(15275, '34.03.18.2002', 'GIRICAHYO', 34, 03, 18, 2002),
(15276, '34.03.18.2003', 'GIRIJATI', 34, 03, 18, 2003),
(15277, '34.03.18.2004', 'GIRIASIH', 34, 03, 18, 2004),
(15278, '34.03.18.2005', 'GIRITIRTO', 34, 03, 18, 2005),
(15279, '34.04.01.2001', 'BALECATUR', 34, 04, 01, 2001),
(15280, '34.04.01.2002', 'AMBAR KETAWANG', 34, 04, 01, 2002),
(15281, '34.04.01.2003', 'BANYURADEN', 34, 04, 01, 2003),
(15282, '34.04.01.2004', 'NOGOTIRTO', 34, 04, 01, 2004),
(15283, '34.04.01.2005', 'TRIHANGGO', 34, 04, 01, 2005),
(15284, '34.04.02.2001', 'SIDOREJO', 34, 04, 02, 2001),
(15285, '34.04.02.2002', 'SIDOLUHUR', 34, 04, 02, 2002),
(15286, '34.04.02.2003', 'SIDOMULYO', 34, 04, 02, 2003),
(15287, '34.04.02.2004', 'SIDOAGUNG', 34, 04, 02, 2004),
(15288, '34.04.02.2005', 'SIDOKARTO', 34, 04, 02, 2005),
(15289, '34.04.02.2006', 'SIDOARUM', 34, 04, 02, 2006),
(15290, '34.04.02.2007', 'SIDOMOYO', 34, 04, 02, 2007),
(15291, '34.04.03.2001', 'SUMBERAHAYU', 34, 04, 03, 2001),
(15292, '34.04.03.2002', 'SUMBER SARI ', 34, 04, 03, 2002),
(15293, '34.04.03.2003', 'SUMBER AGUNG', 34, 04, 03, 2003),
(15294, '34.04.03.2004', 'SUMBER ARUM', 34, 04, 03, 2004),
(15295, '34.04.04.2001', 'SENDANG ARUM', 34, 04, 04, 2001),
(15296, '34.04.04.2002', 'SENDANG MULYO', 34, 04, 04, 2002),
(15297, '34.04.04.2003', 'SENDANG AGUNG', 34, 04, 04, 2003),
(15298, '34.04.04.2004', 'SENDANG SARI', 34, 04, 04, 2004),
(15299, '34.04.04.2005', 'SENDANG REJO', 34, 04, 04, 2005),
(15300, '34.04.05.2001', 'MARGOLUWIH', 34, 04, 05, 2001),
(15301, '34.04.05.2002', 'MARGODADI', 34, 04, 05, 2002),
(15302, '34.04.05.2003', 'MARGOKATON', 34, 04, 05, 2003),
(15303, '34.04.05.2004', 'MARGOMULYO', 34, 04, 05, 2004),
(15304, '34.04.05.2005', 'MARGOAGUNG', 34, 04, 05, 2005),
(15305, '34.04.06.2001', 'SINDUADI', 34, 04, 06, 2001),
(15306, '34.04.06.2002', 'SENDANGADI', 34, 04, 06, 2002),
(15307, '34.04.06.2003', 'TLOGOADI', 34, 04, 06, 2003),
(15308, '34.04.06.2004', 'TIRTOADI', 34, 04, 06, 2004),
(15309, '34.04.06.2005', 'SUMBERADI', 34, 04, 06, 2005),
(15310, '34.04.07.2001', 'CATURTUNGGAL', 34, 04, 07, 2001),
(15311, '34.04.07.2002', 'MAGUWOHARJO', 34, 04, 07, 2002),
(15312, '34.04.07.2003', 'CONDONGCATUR', 34, 04, 07, 2003),
(15313, '34.04.08.2001', 'SENDANGTIRTO', 34, 04, 08, 2001),
(15314, '34.04.08.2002', 'TEGALTIRTO', 34, 04, 08, 2002),
(15315, '34.04.08.2003', 'KALITIRTO', 34, 04, 08, 2003),
(15316, '34.04.08.2004', 'JOGOTIRTO', 34, 04, 08, 2004),
(15317, '34.04.09.2001', 'SUMBERHARJO', 34, 04, 09, 2001),
(15318, '34.04.09.2002', 'WUKIRHARJO', 34, 04, 09, 2002),
(15319, '34.04.09.2003', 'GAYAMHARJO', 34, 04, 09, 2003),
(15320, '34.04.09.2004', 'SAMBIREJO', 34, 04, 09, 2004),
(15321, '34.04.09.2005', 'MADUREJO', 34, 04, 09, 2005),
(15322, '34.04.09.2006', 'BOKOHARJO', 34, 04, 09, 2006),
(15323, '34.04.10.2001', 'PURWOMARTANI', 34, 04, 10, 2001),
(15324, '34.04.10.2002', 'TIRTOMARTANI', 34, 04, 10, 2002),
(15325, '34.04.10.2003', 'TAMANMARTANI', 34, 04, 10, 2003),
(15326, '34.04.10.2004', 'SELOMARTANI', 34, 04, 10, 2004),
(15327, '34.04.11.2001', 'SINDUMARTANI', 34, 04, 11, 2001),
(15328, '34.04.11.2002', 'BIMOMARTANI', 34, 04, 11, 2002),
(15329, '34.04.11.2003', 'WIDODOMARTANI', 34, 04, 11, 2003),
(15330, '34.04.11.2004', 'WEDOMARTANI', 34, 04, 11, 2004),
(15331, '34.04.11.2005', 'UMBULMARTANI', 34, 04, 11, 2005),
(15332, '34.04.12.2001', 'SARIHARJO', 34, 04, 12, 2001),
(15333, '34.04.12.2002', 'MINOMARTANI', 34, 04, 12, 2002),
(15334, '34.04.12.2003', 'SINDUHARJO', 34, 04, 12, 2003),
(15335, '34.04.12.2004', 'SUKOHARJO', 34, 04, 12, 2004),
(15336, '34.04.12.2005', 'SARDONOHARJO', 34, 04, 12, 2005),
(15337, '34.04.12.2006', 'DONOHARJO', 34, 04, 12, 2006),
(15338, '34.04.13.2001', 'CATURHARJO', 34, 04, 13, 2001),
(15339, '34.04.13.2002', 'TRIHARJO', 34, 04, 13, 2002),
(15340, '34.04.13.2003', 'TRIDADI', 34, 04, 13, 2003),
(15341, '34.04.13.2004', 'PANOWOHARJO', 34, 04, 13, 2004),
(15342, '34.04.13.2005', 'TRIMULYO', 34, 04, 13, 2005),
(15343, '34.04.14.2001', 'BAYUREJO', 34, 04, 14, 2001),
(15344, '34.04.14.2002', 'TAMBAKREJO', 34, 04, 14, 2002),
(15345, '34.04.14.2003', 'SUMBER REJO', 34, 04, 14, 2003),
(15346, '34.04.14.2004', 'PONDOKREJO', 34, 04, 14, 2004),
(15347, '34.04.14.2005', 'MOROREJO', 34, 04, 14, 2005),
(15348, '34.04.14.2006', 'MARGOREJO', 34, 04, 14, 2006),
(15349, '34.04.14.2007', 'LUMBUNGREJO', 34, 04, 14, 2007),
(15350, '34.04.14.2008', 'MERDIKOREJO', 34, 04, 14, 2008),
(15351, '34.04.15.2001', 'BANGUNKERTO', 34, 04, 15, 2001),
(15352, '34.04.15.2002', 'DONOKERTO', 34, 04, 15, 2002),
(15353, '34.04.15.2003', 'GIRIKERTO', 34, 04, 15, 2003),
(15354, '34.04.15.2004', 'WONOKERTO', 34, 04, 15, 2004),
(15355, '34.04.16.2001', 'PURWOBINANGUN', 34, 04, 16, 2001),
(15356, '34.04.16.2002', 'CANDIBINANGUN', 34, 04, 16, 2002),
(15357, '34.04.16.2003', 'HARJOBINANGUN', 34, 04, 16, 2003),
(15358, '34.04.16.2004', 'PAKEMBINANGUN', 34, 04, 16, 2004),
(15359, '34.04.16.2005', 'HARGOBINANGUN', 34, 04, 16, 2005),
(15360, '34.04.17.2001', 'ARGOMULYO', 34, 04, 17, 2001),
(15361, '34.04.17.2002', 'WUKIRSARI', 34, 04, 17, 2002),
(15362, '34.04.17.2003', 'GLAGAHARJO', 34, 04, 17, 2003),
(15363, '34.04.17.2004', 'KEPUHARJO', 34, 04, 17, 2004),
(15364, '34.04.17.2005', 'UMBULHARJO', 34, 04, 17, 2005),
(15365, '34.71.01.1001', 'KRICAK', 34, 71, 01, 1001),
(15366, '34.71.01.1002', 'KARANGAWARU', 34, 71, 01, 1002),
(15367, '34.71.01.1003', 'TEGALREJO', 34, 71, 01, 1003),
(15368, '34.71.01.1004', 'BENER', 34, 71, 01, 1004),
(15369, '34.71.02.1001', 'BUMIJO', 34, 71, 02, 1001),
(15370, '34.71.02.1002', 'COKRODININGRATAN', 34, 71, 02, 1002),
(15371, '34.71.02.1003', 'GOWONGAN', 34, 71, 02, 1003),
(15372, '34.71.03.1001', 'DEMANGAN', 34, 71, 03, 1001),
(15373, '34.71.03.1002', 'KOTABARU', 34, 71, 03, 1002),
(15374, '34.71.03.1003', 'KLITREN', 34, 71, 03, 1003),
(15375, '34.71.03.1004', 'BACIRO', 34, 71, 03, 1004),
(15376, '34.71.03.1005', 'TERBAN', 34, 71, 03, 1005),
(15377, '34.71.04.1001', 'SURYATMAJAN', 34, 71, 04, 1001),
(15378, '34.71.04.1002', 'TEGAL PANGGUNG', 34, 71, 04, 1002),
(15379, '34.71.04.1003', 'BAUSASRAN', 34, 71, 04, 1003),
(15380, '34.71.05.1001', 'SOSROMENDURAN', 34, 71, 05, 1001),
(15381, '34.71.05.1002', 'PRINGGOKUSUMAN', 34, 71, 05, 1002),
(15382, '34.71.06.1001', 'NGAMPILAN', 34, 71, 06, 1001),
(15383, '34.71.06.1002', 'NOTOPRAJAN', 34, 71, 06, 1002),
(15384, '34.71.07.1001', 'PAKUNCEN', 34, 71, 07, 1001),
(15385, '34.71.07.1002', 'WIROBRAJAN', 34, 71, 07, 1002),
(15386, '34.71.07.1003', 'PATANGPULUHAN', 34, 71, 07, 1003),
(15387, '34.71.08.1001', 'GEDONGKIWO', 34, 71, 08, 1001),
(15388, '34.71.08.1002', 'SURYODININGRATAN', 34, 71, 08, 1002),
(15389, '34.71.08.1003', 'MANTRIJERON', 34, 71, 08, 1003),
(15390, '34.71.09.1001', 'PATEHAN', 34, 71, 09, 1001),
(15391, '34.71.09.1002', 'PANEMBAHAN', 34, 71, 09, 1002),
(15392, '34.71.09.1003', 'KADIPATEN', 34, 71, 09, 1003),
(15393, '34.71.10.1001', 'NGUPASAN', 34, 71, 10, 1001),
(15394, '34.71.10.1002', 'PRAWIRODIRJAN', 34, 71, 10, 1002),
(15395, '34.71.11.1001', 'PURWOKINANTI', 34, 71, 11, 1001),
(15396, '34.71.11.1002', 'GUNUNGKETUR', 34, 71, 11, 1002),
(15397, '34.71.12.1001', 'KEPARAKAN', 34, 71, 12, 1001),
(15398, '34.71.12.1002', 'WIROGUNAN', 34, 71, 12, 1002),
(15399, '34.71.12.1003', 'BRONTOKUSUMAN', 34, 71, 12, 1003),
(15400, '34.71.13.1001', 'SEMAKI', 34, 71, 13, 1001),
(15401, '34.71.13.1002', 'MUJA-MUJU', 34, 71, 13, 1002),
(15402, '34.71.13.1003', 'TAHUNAN', 34, 71, 13, 1003),
(15403, '34.71.13.1004', 'WARUNGBOTO', 34, 71, 13, 1004),
(15404, '34.71.13.1005', 'PANDEYAN', 34, 71, 13, 1005),
(15405, '34.71.13.1006', 'SOROSUTAN', 34, 71, 13, 1006),
(15406, '34.71.13.1007', 'GIWANGAN', 34, 71, 13, 1007),
(15407, '34.71.14.1001', 'REJOWINANGUN', 34, 71, 14, 1001),
(15408, '34.71.14.1002', 'PRENGGAN .', 34, 71, 14, 1002),
(15409, '34.71.14.1003', 'PURBAYAN', 34, 71, 14, 1003);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `type` int(2) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` varchar(213) NOT NULL,
  `date` bigint(20) NOT NULL,
  `date_sell` bigint(20) NOT NULL,
  `price_start` decimal(15,2) NOT NULL,
  `price_sell` decimal(15,2) NOT NULL,
  `fluktuasi_type` varchar(5) NOT NULL,
  `fluktuasi_val` decimal(15,2) NOT NULL,
  `inv_age` int(3) NOT NULL,
  `klien` varchar(128) NOT NULL,
  `aktif` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `type`, `name`, `description`, `date`, `date_sell`, `price_start`, `price_sell`, `fluktuasi_type`, `fluktuasi_val`, `inv_age`, `klien`, `aktif`) VALUES
(1, 1, 'Keyboard Logitech M120', '', 1558406880, 1560751956, '250000.00', '0.00', 'min', '4167.00', 5, 'CV.indocomp', 1),
(2, 1, 'Eks Comp', '', 1560926220, 0, '200000.00', '0.00', 'zero', '0.00', 0, 'Hardi', 1),
(3, 1, 'Abdi', '', 1560927660, 0, '500000.00', '0.00', 'min', '4167.00', 10, 'Abdi', 1),
(4, 1, 'Hardi', '', 1560927720, 0, '900000.00', '0.00', 'min', '4688.00', 16, 'Hardi', 1),
(5, 1, 'Kursi Roda', 'Perabotan kantor', 1561708140, 0, '300000.00', '0.00', 'min', '1471.00', 17, 'PT.Pertama Indo', 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_ranking`
--

CREATE TABLE `item_ranking` (
  `id` int(11) NOT NULL,
  `get_star` int(11) NOT NULL,
  `date` bigint(20) NOT NULL,
  `title_review` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_pesan` int(11) NOT NULL,
  `change_rating` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_ranking`
--

INSERT INTO `item_ranking` (`id`, `get_star`, `date`, `title_review`, `description`, `id_produk`, `id_user`, `id_pesan`, `change_rating`) VALUES
(1, 3, 1560408588, 'Barang Menarik', '', 211, 32, 930, 0),
(2, 5, 1560391639, 'Barang', 'Sangat Bagus', 207, 32, 900, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `imgkategori` text NOT NULL,
  `urutan` int(11) NOT NULL,
  `jumlah_produk` int(11) NOT NULL,
  `id_master` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kategori`, `deskripsi`, `imgkategori`, `urutan`, `jumlah_produk`, `id_master`) VALUES
(104, 'Makanan', '', '/penampakan/images/php/files/bowl-23425_640.png', 1, 8, 0),
(105, 'Minuman', '', '/penampakan/images/php/files/Lovepik_com-400636513-hot-drink%20%281%29.png', 2, 3, 0),
(106, 'Makanan Instant', '', '/penampakan/images/php/files/3558106-cup-food-instant-noodles-precooked_107817.png', 0, 8, 104),
(107, 'Minuman kemasan', '', '/penampakan/images/php/files/8d19e02d3d00fd5b8262a2a9726a82fa.png', 0, 3, 105),
(108, 'Bumbu Masakan', '', '/penampakan/images/php/files/food.png', 3, 5, 0),
(109, 'Bumbu Dapur', '', '/penampakan/images/php/files/img_480184.png', 0, 5, 108),
(110, 'standing pouch merah', '', '/penampakan/images/upload_image_kat.png', 0, 1, 0),
(111, '915', '', '/penampakan/images/upload_image_kat.png', 0, 1, 110);

-- --------------------------------------------------------

--
-- Table structure for table `konfirmasi_saldo`
--

CREATE TABLE `konfirmasi_saldo` (
  `id` int(11) NOT NULL,
  `tanggal` int(11) NOT NULL,
  `uang_saldo` decimal(11,2) NOT NULL,
  `uang_tf` decimal(11,2) NOT NULL,
  `rekuser` varchar(50) NOT NULL,
  `bankuser` varchar(100) NOT NULL,
  `namauser` varchar(100) NOT NULL,
  `rekideasmart` varchar(30) NOT NULL,
  `iduser` int(11) NOT NULL DEFAULT '0',
  `type` varchar(128) NOT NULL COMMENT 'saldo/pesanan',
  `id_pesanan` int(11) NOT NULL,
  `check_rek` int(11) NOT NULL DEFAULT '0',
  `id_reqsaldo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `konfirmasi_saldo`
--

INSERT INTO `konfirmasi_saldo` (`id`, `tanggal`, `uang_saldo`, `uang_tf`, `rekuser`, `bankuser`, `namauser`, `rekideasmart`, `iduser`, `type`, `id_pesanan`, `check_rek`, `id_reqsaldo`) VALUES
(332, 1555869600, '0.00', '30000.00', '77299182831777', 'MANDIRI', 'User', 'BCA', 32, 'pesanan', 0, 1, 692),
(327, 1555005600, '0.00', '36500.00', '438492192831', 'Bank Jateg', 'sew', 'BCA', 32, 'pesanan', 0, 1, 686),
(328, 1555005600, '0.00', '26500.00', '324234122222', 'BRI', 'sew', 'BCA', 32, 'pesanan', 0, 1, 684),
(325, 1555005600, '0.00', '18500.00', '48384299010293', 'MANDIRI', 'sew', 'BCA', 32, 'pesanan', 0, 1, 683),
(326, 1555005600, '0.00', '20500.00', '413762173188821', 'BNI', 'sew', 'BCA', 32, 'pesanan', 0, 1, 685),
(349, 1557338400, '0.00', '39000.00', '078392671', 'BCA', 'User', 'BCA', 32, 'pesanan', 0, 1, 707),
(324, 1555005600, '0.00', '26500.00', '994893010298753821', 'BCA', 'sew', 'BCA', 32, 'pesanan', 0, 0, 682),
(351, 1558318500, '0.00', '2350.00', '', 'BCA', 'User', 'BCA', 32, 'pesanan', 933, 0, 0),
(354, 1561102860, '0.00', '6300.00', '', 'BNI', 'Ruko1', 'BCA', 0, 'pesanan', 991, 0, 0),
(355, 1562222100, '0.00', '20000.00', '', 'BCA', 'user', 'BCA', 32, 'pesanan', 1011, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `list_pay`
--

CREATE TABLE `list_pay` (
  `id` int(11) NOT NULL,
  `pay_name` varchar(128) NOT NULL,
  `title_name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `list_pay`
--

INSERT INTO `list_pay` (`id`, `pay_name`, `title_name`) VALUES
(1, 'pay_debit', 'Transfer'),
(2, 'cash', 'Cash'),
(3, 'ovo', 'OVO'),
(4, 'gopay', 'GOPAY'),
(5, 'pay_credit', 'Cicilan');

-- --------------------------------------------------------

--
-- Table structure for table `logistik`
--

CREATE TABLE `logistik` (
  `id` int(11) NOT NULL,
  `tanggal` bigint(11) NOT NULL DEFAULT '0',
  `invoice` varchar(64) DEFAULT NULL,
  `suplayer` varchar(128) DEFAULT NULL,
  `contact` varchar(128) DEFAULT NULL,
  `keterangan` tinytext,
  `produk_id` varchar(256) DEFAULT NULL,
  `barcode` varchar(1424) NOT NULL,
  `jumlah` varchar(256) DEFAULT NULL,
  `satuan` varchar(712) NOT NULL,
  `jml_persatuan` varchar(712) NOT NULL,
  `hargasatuan` varchar(256) DEFAULT NULL,
  `deskripsikat` text,
  `hargatambah` varchar(256) DEFAULT NULL,
  `diskonket` varchar(128) DEFAULT NULL,
  `total_diskon` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_beli` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_tambah` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_transaksi` decimal(15,2) NOT NULL DEFAULT '0.00',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logistik`
--

INSERT INTO `logistik` (`id`, `tanggal`, `invoice`, `suplayer`, `contact`, `keterangan`, `produk_id`, `barcode`, `jumlah`, `satuan`, `jml_persatuan`, `hargasatuan`, `deskripsikat`, `hargatambah`, `diskonket`, `total_diskon`, `total_beli`, `total_tambah`, `total_transaksi`, `user_id`) VALUES
(1, 1531463880, '', 'Kino', 'Jl. Sari Asi', 'Pembelian produk minuman', '3', '', '48', '', '', '6800', NULL, NULL, NULL, '0.00', '326400.00', '0.00', '326400.00', 4),
(2, 1531720500, '', 'Arga Marta', 'Jl. Geningan Merah', 'Pembelian Produk Fiesta', '27', '', '89', '', '', '25000', NULL, NULL, NULL, '0.00', '2225000.00', '0.00', '2225000.00', 4),
(3, 1531738740, '', 'Ghong Ju', 'Jl. Ngemplak', 'Pembelian produk minuman', '3', '', '25', '', '', '6800', NULL, NULL, NULL, '0.00', '170000.00', '0.00', '170000.00', 4),
(4, 1531902480, '', 'Coblu', 'Jl. Rempak 321', 'Pembelian Produk', '74|41', '', '60|30', '', '', '7800|18900', NULL, NULL, NULL, '0.00', '1035000.00', '0.00', '1035000.00', 4),
(5, 1532053680, '', 'Ching Ku', 'Jl. Suka Mardi', 'Pembelian produk', '73', '', '26', '', '', '6500', NULL, NULL, NULL, '0.00', '169000.00', '0.00', '169000.00', 4),
(6, 1532659500, '', 'Kong Di', 'Jl Mekar Sari III', 'Pembelian porudk minuman', '73', '', '12', '', '', '6500', NULL, NULL, NULL, '0.00', '78000.00', '0.00', '78000.00', 4),
(7, 1533001080, '', '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, '0.00', '0.00', '0.00', '0.00', 4),
(8, 1533120600, '', 'Pola Chu', 'Jl. Pandawa Cawan II', 'Pembelian produk minuman', '72', '', '25', '', '', '25000', NULL, NULL, NULL, '0.00', '625000.00', '0.00', '625000.00', 4),
(9, 1533278700, '', 'Celvo', 'Jl. Perintis 77 No,7', 'Pembelian Produk', '152', '', '16', '', '', '30000', NULL, NULL, NULL, '0.00', '480000.00', '0.00', '480000.00', 4),
(10, 1534218300, '', 'Crel', 'Jl. Kuningan 9', 'pembelian produk', '148', '', '12', '', '', '250000', NULL, NULL, NULL, '0.00', '3000000.00', '0.00', '3000000.00', 4),
(11, 1534406940, '', 'Bunyu', 'Jl. Cobdras', 'Pembelian Produk', '140', '', '10', '', '', '50000', NULL, NULL, NULL, '0.00', '500000.00', '0.00', '500000.00', 4),
(12, 1534728900, '', 'Linggar', 'Jl. Ramju/089923123108', 'Pembelian Produk', '175', '', '10', '', '', '12000', NULL, NULL, NULL, '0.00', '120000.00', '0.00', '120000.00', 4),
(13, 1534996920, '', 'Lutroh', 'Jl. Demani III/0866723218278', 'Pembelian produk', '105', '', '12', '', '', '12500', NULL, NULL, NULL, '0.00', '150000.00', '0.00', '150000.00', 4);

-- --------------------------------------------------------

--
-- Table structure for table `log_kredit`
--

CREATE TABLE `log_kredit` (
  `id` int(11) NOT NULL,
  `id_user` int(120) NOT NULL,
  `id_pesanan` varchar(512) NOT NULL,
  `date` bigint(20) NOT NULL,
  `total_harga_pesanan` varchar(512) NOT NULL,
  `nominal_pembayaran` decimal(10,2) NOT NULL,
  `list_cicilan` int(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(128) NOT NULL,
  `telp` varchar(128) NOT NULL,
  `catatan` text NOT NULL,
  `idproduk` varchar(512) NOT NULL,
  `nama_produk` text NOT NULL,
  `gambar_produk` text NOT NULL,
  `kode_diskon` varchar(128) NOT NULL COMMENT 'Untuk pembayaran tunai/kasir',
  `jml_diskon` int(11) NOT NULL COMMENT 'Untuk pembayaran tunai/kasir',
  `barcode` varchar(128) NOT NULL,
  `status_promo` text NOT NULL,
  `jml_order` varchar(512) NOT NULL,
  `harga_item` varchar(712) NOT NULL,
  `hargadiskon_item` varchar(712) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `diskon` decimal(10,2) NOT NULL,
  `layanan_pengiriman` varchar(128) NOT NULL,
  `no_resi` varchar(120) NOT NULL,
  `ongkos_kirim` decimal(10,2) NOT NULL,
  `total_beratbarang` varchar(120) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `pembayaran_tunai` decimal(10,2) NOT NULL,
  `imgstruk` text NOT NULL,
  `cabang` varchar(200) NOT NULL,
  `alamat_kirim` text NOT NULL,
  `waktu_pesan` bigint(20) NOT NULL,
  `waktu_kirim` bigint(20) NOT NULL,
  `metode_bayar` varchar(128) NOT NULL COMMENT 'nonsaldo/sebagian/saldo/cash',
  `tipe_bayar` varchar(128) NOT NULL COMMENT 'transfer / kredit / cod',
  `status` int(11) NOT NULL DEFAULT '5' COMMENT '5=Pending pembayaran,10=pembayaran Oke,20=Pengemasan,30=Pengiriman,40=Pesanan Sampai,50=Selesai',
  `status_kasir` int(11) NOT NULL COMMENT '1=untuk pembayaran lewat kasir, 0=tidak melewati kasir',
  `status_kemas` int(11) NOT NULL DEFAULT '0' COMMENT '0: belum dikas, 1: Sudah di kemas',
  `status_cek_bayar` varchar(128) NOT NULL DEFAULT '0|0|0',
  `status_1_checker` varchar(128) NOT NULL DEFAULT '0|0|0',
  `status_2_driver` varchar(128) NOT NULL DEFAULT '0|0|0',
  `status_3_driver` varchar(128) NOT NULL DEFAULT '0|0|0',
  `status_3_cust` varchar(128) NOT NULL DEFAULT '0|0|0' COMMENT '1|iduser|tanggalklik',
  `time_1_suspend` bigint(20) NOT NULL DEFAULT '0',
  `time_1_to_suspend` bigint(20) NOT NULL DEFAULT '0',
  `id_checker` int(11) NOT NULL DEFAULT '0',
  `id_helper` int(11) NOT NULL DEFAULT '0',
  `id_driver` int(11) NOT NULL DEFAULT '0',
  `aktif` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `id_user`, `nama_user`, `telp`, `catatan`, `idproduk`, `nama_produk`, `gambar_produk`, `kode_diskon`, `jml_diskon`, `barcode`, `status_promo`, `jml_order`, `harga_item`, `hargadiskon_item`, `sub_total`, `diskon`, `layanan_pengiriman`, `no_resi`, `ongkos_kirim`, `total_beratbarang`, `total`, `pembayaran_tunai`, `imgstruk`, `cabang`, `alamat_kirim`, `waktu_pesan`, `waktu_kirim`, `metode_bayar`, `tipe_bayar`, `status`, `status_kasir`, `status_kemas`, `status_cek_bayar`, `status_1_checker`, `status_2_driver`, `status_3_driver`, `status_3_cust`, `time_1_suspend`, `time_1_to_suspend`, `id_checker`, `id_helper`, `id_driver`, `aktif`) VALUES
(895, 37, '', '085728012345', 'Pembelian ditempat', '207', 'Pop Mie Rasa Ayam', '/penampakan/images/php/files/popmie-ayam.png', '', 0, '00000207', '', '1', '4500', '', '4500.00', '0.00', '', '', '0.00', '', '4500.00', '5000.00', '', '', '', 1555033920, 0, 'nonsaldo', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(896, 32, '', '085664499385', 'Pembelian dengan aplikasi', '207', 'Pop Mie Rasa Ayam', '/penampakan/images/php/files/popmie-ayam.png', '', 0, '', '0', '1', '4500.00', '0', '4500.00', '0.00', 'pos|Paket Kilat Khusus|2-3 HARI HARI', '', '22000.00', '300 gram', '26500.00', '0.00', '', '', '137', 1555034429, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(897, 32, '', '085664499385', '', '207', 'Pop Mie Rasa Ayam', '/penampakan/images/php/files/popmie-ayam.png', '', 0, '', '0', '1', '4500.00', '0', '4500.00', '0.00', 'jne|CTCYES|1-1 HARI', '', '14000.00', '300 gram', '18500.00', '0.00', '', '', '134', 1555034509, 0, 'nonsaldo', 'pay_debit', 10, 0, 0, '1|4|1555038083', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(898, 32, '', '085664499385', '', '207', 'Pop Mie Rasa Ayam', '/penampakan/images/php/files/popmie-ayam.png', '', 0, '', '0', '1', '4500.00', '0', '4500.00', '0.00', 'tiki|ONS|2 HARI', 'JOGSOC7372718Q', '22000.00', '300 gram', '26500.00', '0.00', '', '', '133', 1555034575, 0, 'nonsaldo', 'pay_debit', 50, 0, 0, '1|4|1555038082', '0|0|0', '1|4|1555306936', '1|4|1557382632', '1|4|1557382632', 0, 0, 0, 0, 0, 1),
(899, 32, '', '085664499385', '', '207', 'Pop Mie Rasa Ayam', '/penampakan/images/php/files/popmie-ayam.png', '', 0, '', '0', '1', '4500.00', '0', '4500.00', '0.00', 'tiki|REG|3 HARI', '', '16000.00', '300 gram', '20500.00', '0.00', '', '', '133', 1555034848, 0, 'nonsaldo', 'pay_debit', 10, 0, 0, '1|4|1555038081', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(900, 32, '', '085664499385', '', '207', 'Pop Mie Rasa Ayam', '/penampakan/images/php/files/popmie-ayam.png', '', 0, '', '0', '3', '4500.00', '0', '13500.00', '0.00', 'jne|OKE|7-10 HARI', 'SOCTY992831', '23000.00', '900 gram', '36500.00', '0.00', '', '', '137', 1555035192, 0, 'nonsaldo', 'pay_debit', 50, 0, 0, '1|4|1555038082', '0|0|0', '1|4|1555305380', '1|4|1557382632', '1|4|1557382632', 0, 0, 0, 0, 0, 1),
(902, 32, '', '085664499385', '', '208|209', 'COCA COLA SOFT DRINK PET|Bumbu Racik Tempe Goreng (Indofood)', '/penampakan/images/php/files/cola.png|/penampakan/images/php/files/racik%20%282%29.png', '', 0, '', '0|0', '1|1', '6300.00|2350.00', '0|0', '8650.00', '0.00', '|REG|4 HARI', '', '26000.00', '470 gram', '34650.00', '0.00', '', '', '135', 1555038270, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(903, 32, '', '085664499385', '', '208|209', 'COCA COLA SOFT DRINK PET|Bumbu Racik Tempe Goreng (Indofood)', '/penampakan/images/php/files/cola.png|/penampakan/images/php/files/racik%20%282%29.png', '', 0, '', '0|0', '1|1', '6300.00|2350.00', '0|0', '8650.00', '0.00', 'jne|Paket Kilat Khusus|2-3 HARI HARI', '', '38000.00', '470 gram', '46650.00', '0.00', '', '', '135', 1555040045, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(904, 32, '', '085664499385', '', '208|209', 'COCA COLA SOFT DRINK PET|Bumbu Racik Tempe Goreng (Indofood)', '/penampakan/images/php/files/cola.png|/penampakan/images/php/files/racik%20%282%29.png', '', 0, '', '0|0', '1|1', '6300.00|2350.00', '0|0', '8650.00', '0.00', 'jne|OKE|7-10 HARI', '', '23000.00', '470 gram', '31650.00', '0.00', '', '', '137', 1555040167, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(905, 32, '', '085664499385', '', '209|208|207', 'Bumbu Racik Tempe Goreng (Indofood)|COCA COLA SOFT DRINK PET|Pop Mie Rasa Ayam', '/penampakan/images/php/files/racik%20%282%29.png|/penampakan/images/php/files/cola.png|/penampakan/images/php/files/popmie-ayam.png', '', 0, '', '0|0|0', '2|1|1', '2350.00|6300.00|4500.00', '0|0|0', '15500.00', '0.00', 'jne|REG|1-2 HARI', '', '10000.00', '790 gram', '25500.00', '0.00', '', '', '134', 1555040263, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(907, 32, '', '085664499385', 'Test apk', '212|211|208|209', 'Seafermart iFood Rendang Sapi|La Pasta Spicy Barbeque Spaghetti Instant|COCA COLA SOFT DRINK PET|Bumbu Racik Tempe Goreng (Indofood)', '/penampakan/images/php/files/ifoof.png|/penampakan/images/php/files/lapasta.png|/penampakan/images/php/files/cola.png|/penampakan/images/php/files/racik%20%282%29.png', '', 0, '', '0|0|0|0', '1|1|1|1', '24000.00|14500.00|6300.00|2350.00', '0|0|0|0', '47150.00', '0.00', 'pos|Paket Kilat Khusus|1-2 HARI HARI', '', '14000.00', '1545 gram', '61150.00', '0.00', '', '', '134', 1555312687, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(908, 0, '', '', '', '212', 'Seafermart iFood Rendang Sapi', '/penampakan/images/php/files/ifoof.png', '', 0, '00000212', '', '2', '24000', '', '48000.00', '0.00', '', '', '0.00', '', '48000.00', '48000.00', '', '', '', 1555314240, 0, 'nonsaldo', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(909, 0, '', '', '', '213', 'standing pouch merah 915', '/penampakan/images/php/files/2019.jpg', '', 0, '00000213', '', '3000', '500', '', '1500000.00', '0.00', '', '', '0.00', '', '1500000.00', '1500000.00', '', '', '', 1555314360, 0, 'nonsaldo', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(910, 32, '', '085664499385', '', '214', 'Nabati Richeese Keju Wafer', '/penampakan/images/php/files/nabati_richeese.png', '', 0, '', '0', '1', '20000.00', '0', '20000.00', '0.00', 'jne|REG|1-2 HARI', '', '10000.00', '350 gram', '30000.00', '0.00', '', '', '134', 1555904540, 0, 'nonsaldo', 'pay_debit', 10, 0, 0, '1|4|1555905299', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(911, 32, '', '085664499385', '', '214', 'Nabati Richeese Keju Wafer', '/penampakan/images/php/files/nabati_richeese.png', '', 0, '', '0', '1', '20000.00', '0', '20000.00', '0.00', 'pos|Paket Kilat Khusus|1-2 HARI HARI', '', '7000.00', '350 gram', '27000.00', '0.00', '', '', '134', 1555905404, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(912, 32, '', '085664499385', '', '214', 'Nabati Richeese Keju Wafer', '/penampakan/images/php/files/nabati_richeese.png', '', 0, '', '0', '18', '20000.00', '0', '360000.00', '0.00', 'jne|REG|1-2 HARI', '', '60000.00', '6300 gram', '420000.00', '0.00', '', '', '134', 1555906604, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(914, 32, '', '085664499385', '', '214', 'Nabati Richeese Keju Wafer', '/penampakan/images/php/files/nabati_richeese.png', '', 0, '', '0', '1', '20000.00', '0', '20000.00', '0.00', 'pos|Paket Kilat Khusus|1-2 HARI HARI', '', '7000.00', '350 gram', '27000.00', '0.00', '', '', '134', 1555909426, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(915, 32, '', '085664499385', '', '211|208|209', 'La Pasta Spicy Barbeque Spaghetti Instant|COCA COLA SOFT DRINK PET|Bumbu Racik Tempe Goreng (Indofood)', '/penampakan/images/php/files/lapasta.png|/penampakan/images/php/files/cola.png|/penampakan/images/php/files/racik%20%282%29.png', '', 0, '', '0|0|0', '3|2|5', '14500.00|6300.00|2350.00', '0|0|0', '67850.00', '0.00', 'jne|REG|1-2 HARI', '', '10000.00', '1225 gram', '77850.00', '0.00', '', '', '134', 1556007738, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(916, 32, '', '085664499385', '', '211', 'La Pasta Spicy Barbeque Spaghetti Instant', '/penampakan/images/php/files/lapasta.png', '', 0, '', '0', '6', '14500.00', '0', '87000.00', '0.00', 'jne|REG|1-2 HARI', '', '10000.00', '450 gram', '97000.00', '0.00', '', '', '134', 1556009236, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(917, 32, '', '085664499385', '', '208', 'COCA COLA SOFT DRINK PET', '/penampakan/images/php/files/cola.png', '', 0, '', '0', '5', '6300.00', '0', '31500.00', '0.00', 'jne|REG|1-2 HARI', '', '20000.00', '2250 gram', '51500.00', '0.00', '', '', '134', 1556011128, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(918, 32, '', '085664499385', '', '212', 'Seafermart iFood Rendang Sapi', '/penampakan/images/php/files/ifoof.png', '', 0, '', '0', '1', '24000.00', '0', '24000.00', '0.00', 'pos|Paket Kilat Khusus|1-2 HARI HARI', '', '7000.00', '1000 gram', '31000.00', '0.00', '', '', '134', 1556073471, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(919, 32, '', '085664499385', '', '212', 'Seafermart iFood Rendang Sapi', '/penampakan/images/php/files/ifoof.png', '', 0, '', '0', '15', '24000.00', '0', '360000.00', '0.00', 'pos|REG|1-2 HARI', '', '150000.00', '15000 gram', '510000.00', '0.00', '', '', '134', 1556077627, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(920, 32, '', '085664499385', '', '212', 'Seafermart iFood Rendang Sapi', '/penampakan/images/php/files/ifoof.png', '', 0, '', '0', '1', '24000.00', '0', '24000.00', '0.00', 'jne|REG|1-2 HARI', '', '10000.00', '1000 gram', '34000.00', '0.00', '', '', '134', 1556080213, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(921, 32, '', '085664499385', '', '208', 'COCA COLA SOFT DRINK PET', '/penampakan/images/php/files/cola.png', '', 0, '00000208', '', '2', '6300', '', '12600.00', '0.00', '', '', '0.00', '', '12600.00', '20000.00', '', '', '', 1556240160, 0, 'nonsaldo', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(922, 32, '', '085664499385', '', '210|211', 'Toserda Sambal Bawang Mertua Lv 3|La Pasta Spicy Barbeque Spaghetti Instant', '/penampakan/images/php/files/sambal.png|/penampakan/images/php/files/lapasta.png', '', 0, '', '0|0', '2|2', '36000.00|14500.00', '0|0', '101000.00', '0.00', 'tiki|ECO|4 HARI', '', '14000.00', '1550 gram', '115000.00', '0.00', '', '', '134', 1556523233, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(923, 32, '', '085664499385', '', '214|209', 'Nabati Richeese Keju Wafer|Bumbu Racik Tempe Goreng (Indofood)', '/penampakan/images/php/files/nabati_richeese.png|/penampakan/images/php/files/racik%20%282%29.png', '', 0, '00000214|00000209', '0|0', '1|2', '20000.00|2350.00', '0|0', '24700.00', '0.00', 'jne|REG|1-2 HARI', '', '10000.00', '390 gram', '34700.00', '0.00', '', '', '134', 1556525555, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(924, 32, '', '085664499385', '', '209|214', 'Bumbu Racik Tempe Goreng (Indofood)|Nabati Richeese Keju Wafer', '/penampakan/images/php/files/racik%20%282%29.png|/penampakan/images/php/files/nabati_richeese.png', '', 5000, '00000209|00000214', '', '5|5', '2350|20000', '', '111750.00', '0.00', '', '', '0.00', '', '106750.00', '200000.00', '', '', '', 1556526240, 0, 'nonsaldo', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(925, 32, '', '085664499385', '', '208', 'COCA COLA SOFT DRINK PET', '/penampakan/images/php/files/cola.png', '', 0, '00000208', '0', '6', '6300.00', '0', '37800.00', '0.00', 'jne|REG|1-2 HARI', '', '30000.00', '2700 gram', '74100.00', '0.00', '', '', '134', 1556593593, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(926, 32, '', '085664499385', '', '209', 'Bumbu Racik Tempe Goreng (Indofood)', '/penampakan/images/php/files/racik%20%282%29.png', '', 0, '00000209', '0', '15', '2350.00', '0', '35250.00', '0.00', 'tiki|ECO|4 HARI', '', '7000.00', '300 gram', '42250.00', '0.00', '', '', '134', 1556593939, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(927, 32, '', '085664499385', '', '211', 'La Pasta Spicy Barbeque Spaghetti Instant', '/penampakan/images/php/files/lapasta.png', '', 0, '00000211', '0', '2', '14500.00', '0', '29000.00', '0.00', 'pos|Paket Kilat Khusus|1-2 HARI HARI', '', '7000.00', '150 gram', '36000.00', '0.00', '', '', '134', 1556596741, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(928, 32, '', '085664499385', '', '210', 'Toserda Sambal Bawang Mertua Lv 3', '/penampakan/images/php/files/sambal.png', '', 0, '00000210', '0', '1', '36000.00', '0', '36000.00', '0.00', 'jne|REG|1-2 HARI', '', '10000.00', '700 gram', '46000.00', '0.00', '', '', '134', 1557211903, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(929, 32, '', '085664499385', '', '210', 'Toserda Sambal Bawang Mertua Lv 3', '/penampakan/images/php/files/sambal.png', '', 0, '00000210', '0', '2', '36000.00', '0', '72000.00', '0.00', 'jne|REG|1-2 HARI', '', '20000.00', '1400 gram', '92000.00', '0.00', '', '', '134', 1557212021, 0, 'nonsaldo', 'pay_debit', 5, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0),
(930, 32, '', '085664499385', '', '211', 'La Pasta Spicy Barbeque Spaghetti Instant', '/penampakan/images/php/files/lapasta.png', '', 0, '00000211', '0', '2', '14500.00', '0', '29000.00', '0.00', 'jne|REG|1-2 HARI', 'UIUI7884831723', '10000.00', '150 gram', '39000.00', '0.00', 'image_receipt1557994212.jpg', '', '134', 1557384619, 0, 'nonsaldo', 'pay_debit', 50, 0, 0, '1|4|1557384982', '0|0|0', '1|4|1557386916', '1|4|1557391635', '1|32|1557391778', 0, 0, 0, 0, 0, 1),
(931, 32, '', '085664499385', '', '209', 'Bumbu Racik Tempe Goreng (Indofood)', '/penampakan/images/php/files/racik%20%282%29.png', '', 2500, '00000209', '', '5', '2350', '', '11750.00', '0.00', '', '', '0.00', '', '9250.00', '20000.00', '', '', '', 1558318140, 0, 'nonsaldo', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(932, 32, '', '085664499385', '', '209', 'Bumbu Racik Tempe Goreng (Indofood)', '/penampakan/images/php/files/racik%20%282%29.png', '', 0, '00000209', '', '1', '2350', '', '2350.00', '0.00', '', '', '0.00', '', '2350.00', '5000.00', '', '', '', 1558318260, 0, 'nonsaldo', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(933, 32, '', '085664499385', '', '209', 'Bumbu Racik Tempe Goreng (Indofood)', '/penampakan/images/php/files/racik%20%282%29.png', '', 0, '00000209', '', '1', '2350', '', '2350.00', '0.00', '', '', '0.00', '', '2350.00', '10000.00', '', '', '', 1558318500, 0, 'nonsaldo', 'pay_debit', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(934, 32, '', '085664499385', '', '211', 'La Pasta Spicy Barbeque Spaghetti Instant', '/penampakan/images/php/files/lapasta.png', '', 0, '00000211', '', '1', '14500', '', '14500.00', '0.00', '', '', '0.00', '', '14500.00', '20000.00', '', '', '', 1558663620, 0, 'nonsaldo', 'ovo', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(937, 32, '', '085664499385', '', '224', 'Mie Tepra', '/penampakan/images/php/files/logo_tepra1%20%283%29.png', '', 0, '00000224', '', '12', '22000|18000', '', '264000.00', '0.00', '', '', '0.00', '', '264000.00', '400000.00', '', '', '', 1558668420, 0, '', 'ovo', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(939, 32, '', '085664499385', '', '224', 'Mie Tepra', '/penampakan/images/php/files/logo_tepra1%20%283%29.png', '', 0, '00000224', '', '1', '25000', '', '25000.00', '0.00', '', '', '0.00', '', '25000.00', '30000.00', '', '', '', 1558668600, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(940, 32, '', '085664499385', '', '224', 'Mie Tepra', '/penampakan/images/php/files/logo_tepra1%20%283%29.png', '', 0, '00000224', '', '1', '25000', '', '25000.00', '0.00', '', '', '0.00', '', '25000.00', '25000.00', '', '', '', 1558668660, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(962, 32, '', '085664499385', '', '225', 'Upload', '/penampakan/images/php/files/upload%20%282%29.png', '', 0, '00000225', '', '6', '17500', '', '105000.00', '0.00', '', '', '0.00', '', '105000.00', '200000.00', '', '', '', 1558678740, 0, '', 'pay_debit', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(970, 32, '', '085664499385', '', '225', 'Upload', '/penampakan/images/php/files/upload%20%282%29.png', '', 0, '00000225', '', '6', '17500', '', '105000.00', '0.00', '', '', '0.00', '', '105000.00', '150000.00', '', '', '', 1558680300, 0, '', 'pay_debit', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(975, 32, '', '085664499385', '', '225', 'Upload', '/penampakan/images/php/files/upload%20%282%29.png', '', 0, '00000225', '', '12', '16200', '', '194400.00', '0.00', '', '', '0.00', '', '194400.00', '300000.00', '', '', '', 1558680660, 0, '', 'gopay', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(976, 32, '', '085664499385', '', '225', 'Upload', '/penampakan/images/php/files/upload%20%282%29.png', '', 0, '00000225', '', '6', '17500', '', '105000.00', '0.00', '', '', '0.00', '', '105000.00', '150000.00', '', '', '', 1558680720, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(977, 32, '', '085664499385', '', '214', 'Nabati Richeese Keju Wafer', '/penampakan/images/php/files/nabati_richeese.png', '', 0, '00000214', '', '5', '20000|20000', '', '100000.00', '0.00', '', '', '0.00', '', '100000.00', '50000.00', '', '', '', 1559022720, 0, '', 'pay_credit', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(978, 32, '', '085664499385', '', '209', 'Bumbu Racik Tempe Goreng (Indofood)', '/penampakan/images/php/files/racik%20%282%29.png', '', 0, '00000209', '', '1', '2350|2350', '', '2350.00', '0.00', '', '', '0.00', '', '2350.00', '5000.00', '', '', '', 1559118420, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(984, 32, '', '085664499385', '', '209', 'Bumbu Racik Tempe Goreng (Indofood)', '/penampakan/images/php/files/racik%20%282%29.png', '', 0, '00000209', '', '1', '2350|2350', '', '2350.00', '0.00', '', '', '0.00', '', '2350.00', '2000.00', '', '', '', 1559120760, 0, '', 'pay_credit', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(985, 32, '', '085664499385', '', '210', 'Toserda Sambal Bawang Mertua Lv 3', '/penampakan/images/php/files/sambal.png', '', 0, '00000210', '', '1', '36000|36000', '', '36000.00', '0.00', '', '', '0.00', '', '36000.00', '36000.00', '', '', '', 1559266860, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(986, 32, '', '085664499385', '', '210', 'Toserda Sambal Bawang Mertua Lv 3', '/penampakan/images/php/files/sambal.png', '', 0, '00000210', '', '1', '36000|36000', '', '36000.00', '0.00', '', '', '0.00', '', '36000.00', '36000.00', '', '', '', 1559267340, 0, '', 'pay_debit', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(987, 32, '', '085664499385', '', '210', 'Toserda Sambal Bawang Mertua Lv 3', '/penampakan/images/php/files/sambal.png', '', 0, '00000210', '', '1', '36000|36000', '', '36000.00', '0.00', '', '', '0.00', '', '36000.00', '36000.00', '', '', '', 1559267460, 0, '', 'pay_debit', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(988, 32, '', '085664499385', '', '210', 'Toserda Sambal Bawang Mertua Lv 3', '/penampakan/images/php/files/sambal.png', '', 0, '00000210', '', '1', '36000|36000', '', '36000.00', '0.00', '', '', '0.00', '', '36000.00', '36000.00', '', '', '', 1559268180, 0, '', 'pay_debit', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(989, 32, '', '085664499385', '', '209', 'Bumbu Racik Tempe Goreng (Indofood)', '/penampakan/images/php/files/racik%20%282%29.png', '', 0, '00000209', '', '1', '2350', '', '2350.00', '0.00', '', '', '0.00', '', '2350.00', '500.00', '', '', '', 1561007280, 0, '', 'pay_credit', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(991, 0, 'Ruko', '', '', '208', 'COCA COLA SOFT DRINK PET', '/penampakan/images/php/files/cola.png', '', 0, '00000208', '', '1', '6300', '', '6300.00', '0.00', '', '', '0.00', '', '6300.00', '6300.00', '', '', '', 1561101840, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(992, 0, 'Riza', '', '', '210', 'Toserda Sambal Bawang Mertua Lv 3', '/penampakan/images/php/files/sambal.png', '', 0, '00000210', '', '1', '36000', '', '36000.00', '0.00', '', '', '0.00', '', '36000.00', '40000.00', '', '', '', 1561342200, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(993, 32, 'User', '085664499385', '', '227', 'Bappeda', '/penampakan/images/php/files/bepeda1%20%281%29.png', '', 0, '00000227', '', '1', '30000', '', '30000.00', '0.00', '', '', '0.00', '', '30000.00', '30000.00', '', '', '', 1561346940, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(994, 43, 'Bayu', '08997765566621', '', '208', 'COCA COLA SOFT DRINK PET', '/penampakan/images/php/files/cola.png', '', 0, '00000208', '', '1', '6300', '', '6300.00', '0.00', '', '', '0.00', '', '6300.00', '6300.00', '', '', '', 1561521360, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(995, 32, 'User', '085664499385', '', '209', 'Bumbu Racik Tempe Goreng (Indofood)', '/penampakan/images/php/files/racik%20%282%29.png', '', 0, '00000209', '', '1', '2350', '', '2350.00', '0.00', '', '', '0.00', '', '2350.00', '5000.00', '', '', '', 1561687440, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(996, 0, '', '', '', '209', 'Bumbu Racik Tempe Goreng (Indofood)', '/penampakan/images/php/files/racik%20%282%29.png', '', 0, '00000209', '', '3', '2350', '', '7050.00', '0.00', '', '', '0.00', '', '7050.00', '10000.00', '', '', '', 1561694580, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(997, 32, 'User', '085664499385', '', '226', 'Ale-Ale', '/penampakan/images/php/files/bg_about%20%286%29.png', '', 0, '00000226', '', '2', '', '', '530.00', '0.00', '', '', '0.00', '', '530.00', '100000.00', '', '', '', 1561694580, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(998, 0, '', '', '', '209|226', 'Bumbu Racik Tempe Goreng (Indofood)|Ale-Ale', '/penampakan/images/php/files/racik%20%282%29.png|/penampakan/images/php/files/bg_about%20%286%29.png', '', 0, '00000209|00000226', '', '3|2', '2350|265', '', '7580.00', '0.00', '', '', '0.00', '', '7580.00', '70000.00', '', '', '', 1561694640, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(999, 32, 'User', '085664499385', '', '209|226', 'Bumbu Racik Tempe Goreng (Indofood)|Ale-Ale', '/penampakan/images/php/files/racik%20%282%29.png|/penampakan/images/php/files/bg_about%20%286%29.png', '', 0, '00000209|00000226', '', '2|2', '2350|265', '', '5230.00', '0.00', '', '', '0.00', '', '5230.00', '60000.00', '', '', '', 1561694940, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(1000, 0, '', '', '', '226|208', 'Ale-Ale|COCA COLA SOFT DRINK PET', '/penampakan/images/php/files/bg_about%20%286%29.png|/penampakan/images/php/files/cola.png', '', 0, '00000226|00000208', '', '2|4', '265|6300', '', '25730.00', '0.00', '', '', '0.00', '', '25730.00', '100000.00', '', '', '', 1561695300, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(1001, 32, 'User', '085664499385', '', '226', 'Ale-Ale', '/penampakan/images/php/files/bg_about%20%286%29.png', '', 0, '00000226', '', '2', '265', '', '530.00', '0.00', '', '', '0.00', '', '530.00', '60000.00', '', '', '', 1561695360, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(1002, 0, '', '', '', '226', 'Ale-Ale', '/penampakan/images/php/files/bg_about%20%286%29.png', '', 0, '00000226', '', '2', '265', '', '530.00', '0.00', '', '', '0.00', '', '530.00', '60000.00', '', '', '', 1561695360, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(1003, 32, 'User', '085664499385', '', '226', 'Ale-Ale', '/penampakan/images/php/files/bg_about%20%286%29.png', '', 0, '00000226', '', '2', '265', '', '530.00', '0.00', '', '', '0.00', '', '530.00', '60000.00', '', '', '', 1561695420, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(1004, 32, 'User', '085664499385', '', '226', 'Ale-Ale', '/penampakan/images/php/files/bg_about%20%286%29.png', '', 0, '00000226', '', '2', '265', '', '530.00', '0.00', '', '', '0.00', '', '530.00', '60000.00', '', '', '', 1561695480, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(1005, 0, '', '', '', '226', 'Ale-Ale', '/penampakan/images/php/files/bg_about%20%286%29.png', '', 0, '00000226', '', '2', '26500', '', '53000.00', '0.00', '', '', '0.00', '', '53000.00', '60000.00', '', '', '', 1561696020, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(1006, 0, '', '', '', '226', 'Ale-Ale', '/penampakan/images/php/files/bg_about%20%286%29.png', '', 0, '00000226', '', '2', '26500', '', '53000.00', '0.00', '', '', '0.00', '', '53000.00', '60000.00', '', '', '', 1561696020, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(1007, 32, 'User', '085664499385', '', '226', 'Ale-Ale', '/penampakan/images/php/files/bg_about%20%286%29.png', '', 0, '00000226', '', '2', '26500', '', '53000.00', '0.00', '', '', '0.00', '', '53000.00', '60000.00', '', '', '', 1561696260, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(1008, 32, 'User', '085664499385', '', '230', 'Contact', '/penampakan/images/php/files/bg_contact%20%284%29.png', '', 0, '00000230', '', '1', '25000', '', '25000.00', '0.00', '', '', '0.00', '', '25000.00', '30000.00', '', '', '', 1561701360, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(1009, 32, 'User', '085664499385', '', '230', 'Contact', '/penampakan/images/php/files/bg_contact%20%284%29.png', '', 0, '00000230', '', '10', '24000', '', '240000.00', '0.00', '', '', '0.00', '', '240000.00', '300000.00', '', '', '', 1561704120, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(1010, 0, '', '', '', '230', 'Contact', '/penampakan/images/php/files/bg_contact%20%284%29.png', '', 0, '00000230', '', '1', '25000', '', '25000.00', '0.00', '', '', '0.00', '', '25000.00', '25000.00', '', '', '', 1561704180, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1),
(1011, 32, 'User', '085664499385', '', '208', 'COCA COLA SOFT DRINK PET', '/penampakan/images/php/files/cola.png', '', 0, '00000208', '', '1', '6300', '', '6300.00', '0.00', '', '', '0.00', '', '6300.00', '10000.00', '', '', '', 1561712640, 0, '', 'cash', 5, 1, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `idcabang` int(11) NOT NULL,
  `idkategori` int(11) NOT NULL,
  `idsubkategori` int(11) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `short_title` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga_produk` decimal(10,2) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `promo` int(2) NOT NULL,
  `harga_promo` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `stock_limit` int(11) NOT NULL,
  `stock_order` int(11) NOT NULL,
  `stock_produksi` int(11) NOT NULL,
  `stock_toko` int(11) NOT NULL,
  `stock_display` int(11) NOT NULL,
  `image` text NOT NULL,
  `satuan` varchar(128) NOT NULL,
  `jml_persatuan` int(11) NOT NULL,
  `harga_beli` decimal(10,2) NOT NULL,
  `berat_barang` int(120) NOT NULL,
  `satuan_berat` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `idcabang`, `idkategori`, `idsubkategori`, `barcode`, `title`, `short_title`, `deskripsi`, `harga_produk`, `harga`, `promo`, `harga_promo`, `stock`, `stock_limit`, `stock_order`, `stock_produksi`, `stock_toko`, `stock_display`, `image`, `satuan`, `jml_persatuan`, `harga_beli`, `berat_barang`, `satuan_berat`) VALUES
(207, 1, 104, 106, '00000207', 'Pop Mie Rasa Ayam', 'Pop Mie', 'Mie siap saji', '0.00', '4500.00', 0, '0.00', 18, 0, 0, 13, 7, 6, '/penampakan/images/php/files/popmie-ayam.png', 'Dus/Box', 0, '0.00', 300, 'gram'),
(208, 1, 105, 107, '00000208', 'COCA COLA SOFT DRINK PET', 'Cola-cola', '', '0.00', '6300.00', 0, '0.00', 24, 6, 0, 19, 8, -1, '/penampakan/images/php/files/cola.png', 'Dus/Box', 0, '0.00', 450, 'gram'),
(209, 1, 108, 109, '00000209', 'Bumbu Racik Tempe Goreng (Indofood)', 'Bumbu Racik Tempe Goreng', '', '1200.00', '2350.00', 0, '0.00', 37, 5, 0, 15, 15, -4, '/penampakan/images/php/files/racik%20%282%29.png', 'Dus/Box', 0, '1200.00', 20, 'gram'),
(210, 1, 108, 109, '00000210', 'Toserda Sambal Bawang Mertua Lv 3', 'Toserda Sambal Bawang', 'Sambal ekstra pedas', '0.00', '36000.00', 0, '0.00', 24, 0, 0, 15, 10, 9, '/penampakan/images/php/files/sambal.png', 'Dus/Box', 0, '0.00', 700, 'gram'),
(211, 1, 104, 106, '00000211', 'La Pasta Spicy Barbeque Spaghetti Instant', 'La Pasta Spicy Barbeque Spaghetti', '', '0.00', '14500.00', 0, '0.00', 31, 30, 0, 16, 16, 11, '/penampakan/images/php/files/lapasta.png', 'Dus/Box', 0, '12000.00', 75, 'gram'),
(212, 1, 104, 106, '00000212', 'Seafermart iFood Rendang Sapi', 'iFood Rendang Sapi', '', '0.00', '24000.00', 0, '0.00', 27, 0, 0, 11, 10, 16, '/penampakan/images/php/files/ifoof.png', 'Dus/Box', 0, '0.00', 1, 'kg'),
(213, 1, 110, 111, '00000213', 'standing pouch merah 915', 'pouch merah 915', 'tes', '0.00', '500.00', 0, '0.00', 2000, 0, 0, 0, 0, 0, '/penampakan/images/php/files/2019.jpg', 'Dus/Box', 0, '0.00', 20, 'gram'),
(214, 1, 104, 106, '00000214', 'Nabati Richeese Keju Wafer', 'Richeese Keju Wafer', '', '0.00', '20000.00', 0, '0.00', 100, 0, 0, 50, 20, 10, '/penampakan/images/php/files/nabati_richeese.png', 'Dus/Box', 0, '0.00', 350, 'gram'),
(224, 1, 104, 106, '00000224', 'Mie Tepra', 'Mie Tepra', '', '0.00', '25000.00', 0, '0.00', 120, 20, 0, 80, 18, 8, '/penampakan/images/php/files/logo_tepra1%20%283%29.png', 'Dus/Box', 0, '20000.00', 0, ''),
(225, 1, 105, 107, '00000225', 'Upload', 'Upload', '', '0.00', '20000.00', 0, '0.00', 100, 0, 0, 30, 15, 25, '/penampakan/images/php/files/upload%20%282%29.png', 'Dus/Box', 0, '15000.00', 0, ''),
(226, 1, 105, 107, '00000226', 'Ale-Ale', 'Ale-Ale', '', '0.00', '27000.00', 1, '20000.00', 100, 10, 0, 30, 30, 24, '/penampakan/images/php/files/bg_about%20%286%29.png', 'Dus/Box', 0, '25000.00', 0, ''),
(227, 1, 108, 109, '00000227', 'Bappeda', 'Bappeda', '', '0.00', '30000.00', 0, '0.00', 0, 26, 0, 1000, 500, 199, '/penampakan/images/php/files/bepeda1%20%281%29.png', 'Dus/Box', 0, '26000.00', 0, ''),
(228, 1, 104, 106, '00000228', 'Bappeda #', 'Bappeda #', '', '0.00', '30000.00', 0, '0.00', 0, 30, 0, 0, 0, 0, '/penampakan/images/php/files/bapeda3.png', 'Dus/Box', 0, '25000.00', 0, ''),
(229, 1, 108, 109, '00000229', 'Bappeda 2', 'Bappeda 2', '', '0.00', '20000.00', 0, '0.00', 0, 20, 0, 0, 0, 0, '/penampakan/images/php/files/bapeda2.png', 'Dus/Box', 0, '15000.00', 0, ''),
(230, 1, 104, 106, '00000230', 'Contact', 'Contact', '', '0.00', '25000.00', 0, '0.00', 0, 26, 0, 0, 0, 88, '/penampakan/images/php/files/bg_contact%20%284%29.png', 'Dus/Box', 0, '20000.00', 0, ''),
(231, 1, 104, 106, '00000231', 'tep', 'tep', '', '0.00', '39000.00', 0, '0.00', 0, 25, 0, 0, 0, 0, '/penampakan/images/php/files/logo_tepra1%20%284%29.png', 'Dus/Box', 0, '25000.00', 0, ''),
(232, 1, 108, 109, '00000232', 'Pempek', 'Pempek', '', '0.00', '25000.00', 0, '0.00', 0, 50, 0, 0, 0, 0, '/penampakan/images/php/files/Makanan-Terenak-di-Indonesia-yang-Terkenal-Hingga-Mancanegara-12-Pempek-Finansialku.jpg', 'Dus/Box', 0, '20000.00', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `produk_item`
--

CREATE TABLE `produk_item` (
  `id` int(11) NOT NULL,
  `id_prod_master` int(11) NOT NULL,
  `id_prod_item` varchar(225) NOT NULL,
  `jumlah_prod` varchar(225) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_saldo`
--

CREATE TABLE `request_saldo` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `harga_awal` decimal(10,2) NOT NULL,
  `kode_unik` int(11) NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `date_checkout` int(11) NOT NULL,
  `type` varchar(128) NOT NULL COMMENT 'saldo/pesanan',
  `id_pesanan` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `aktif` int(2) NOT NULL DEFAULT '1',
  `id_trans_saldo` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request_saldo`
--

INSERT INTO `request_saldo` (`id`, `id_user`, `harga_awal`, `kode_unik`, `total_bayar`, `date_checkout`, `type`, `id_pesanan`, `status`, `aktif`, `id_trans_saldo`) VALUES
(683, 32, '18500.00', 0, '18500.00', 1555034509, 'pesanan', 897, 1, 1, '0'),
(684, 32, '26500.00', 0, '26500.00', 1555034575, 'pesanan', 898, 1, 1, '0'),
(685, 32, '20500.00', 0, '20500.00', 1555034848, 'pesanan', 899, 1, 1, '0'),
(686, 32, '36500.00', 0, '36500.00', 1555035192, 'pesanan', 900, 1, 1, '0'),
(692, 32, '30000.00', 0, '30000.00', 1555904540, 'pesanan', 910, 1, 1, '0'),
(707, 32, '39000.00', 0, '39000.00', 1557384619, 'pesanan', 930, 1, 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `trans_order`
--

CREATE TABLE `trans_order` (
  `id` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `jumlah` bigint(20) NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `status_jual` int(11) NOT NULL DEFAULT '0' COMMENT '0 belum terjual, 1 sudah terjual',
  `type` varchar(5) NOT NULL COMMENT 'in atau out',
  `date` int(11) NOT NULL,
  `trans_from` int(11) NOT NULL,
  `trans_to` int(11) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trans_order`
--

INSERT INTO `trans_order` (`id`, `id_pesanan`, `id_pembelian`, `id_produk`, `id_penjualan`, `jumlah`, `harga`, `status_jual`, `type`, `date`, `trans_from`, `trans_to`, `deskripsi`) VALUES
(1319, 895, 0, 207, 895, 1, '4500.00', 1, 'out', 1555033920, 0, 0, 'Penjualan via kasir'),
(1321, 897, 0, 207, 0, 1, '4500.00', 1, 'out', 1555034509, 0, 0, ''),
(1322, 898, 0, 207, 0, 1, '4500.00', 1, 'out', 1555034575, 0, 0, ''),
(1323, 899, 0, 207, 0, 1, '4500.00', 1, 'out', 1555034848, 0, 0, ''),
(1324, 900, 0, 207, 0, 3, '4500.00', 1, 'out', 1555035192, 0, 0, ''),
(1343, 908, 0, 212, 908, 2, '24000.00', 1, 'out', 1555314240, 0, 0, 'Penjualan via kasir'),
(1344, 909, 0, 213, 909, 3000, '500.00', 1, 'out', 1555314360, 0, 0, 'Penjualan via kasir'),
(1345, 0, 0, 214, 0, 5, '20000.00', 0, 'trans', 1555901880, 1, 2, ''),
(1346, 0, 0, 214, 0, 40, '20000.00', 0, 'trans', 1555902360, 1, 2, ''),
(1347, 0, 0, 214, 0, 20, '20000.00', 0, 'trans', 1555902360, 2, 3, ''),
(1348, 910, 0, 214, 0, 1, '20000.00', 1, 'out', 1555904540, 0, 0, ''),
(1351, 0, 0, 212, 0, 12, '24000.00', 0, 'trans', 1555907520, 1, 2, ''),
(1352, 0, 0, 212, 0, 8, '24000.00', 0, 'trans', 1555907520, 2, 3, ''),
(1353, 0, 0, 211, 0, 10, '14500.00', 0, 'trans', 1555907640, 1, 2, ''),
(1354, 0, 0, 211, 0, 7, '14500.00', 0, 'trans', 1555907640, 2, 3, ''),
(1355, 0, 0, 210, 0, 14, '36000.00', 0, 'trans', 1555907700, 1, 2, ''),
(1356, 0, 0, 210, 0, 9, '36000.00', 0, 'trans', 1555907700, 2, 3, ''),
(1357, 0, 0, 207, 0, 10, '4500.00', 0, 'trans', 1555907760, 1, 2, ''),
(1358, 0, 0, 207, 0, 8, '4500.00', 0, 'trans', 1555907760, 2, 3, ''),
(1359, 0, 0, 209, 0, 20, '2350.00', 0, 'trans', 1555907820, 1, 2, ''),
(1360, 0, 0, 209, 0, 18, '2350.00', 0, 'trans', 1555907820, 2, 3, ''),
(1361, 0, 0, 208, 0, 15, '6300.00', 0, 'trans', 1555907880, 1, 2, ''),
(1362, 0, 0, 211, 0, 10, '14500.00', 0, 'trans', 1555907880, 1, 2, ''),
(1363, 0, 0, 211, 0, 2, '14500.00', 0, 'trans', 1555907880, 2, 3, ''),
(1364, 0, 0, 209, 0, 7, '2350.00', 0, 'trans', 1555907880, 2, 3, ''),
(1365, 0, 0, 209, 0, 7, '2350.00', 0, 'trans', 1555908000, 1, 2, ''),
(1366, 0, 0, 212, 0, 5, '24000.00', 0, 'trans', 1555908000, 1, 2, ''),
(1367, 0, 0, 208, 0, 8, '6300.00', 0, 'trans', 1555908060, 2, 3, ''),
(1373, 0, 0, 209, 0, 18, '2350.00', 0, 'in', 1556007840, 2, 0, ''),
(1374, 0, 0, 209, 0, 5, '2350.00', 0, 'out', 1556007900, 2, 0, ''),
(1375, 0, 0, 209, 0, 5, '2350.00', 0, 'out', 1556008380, 3, 0, ''),
(1376, 0, 0, 214, 0, 5, '20000.00', 0, 'out', 1556008560, 2, 0, ''),
(1377, 0, 0, 214, 0, 1, '20000.00', 0, 'in', 1556008680, 3, 0, ''),
(1378, 0, 0, 214, 0, 5, '20000.00', 0, 'out', 1556008740, 1, 0, ''),
(1379, 0, 0, 208, 0, 1, '6300.00', 0, 'trans', 1556008560, 1, 2, ''),
(1380, 0, 0, 208, 0, 11, '6300.00', 0, 'in', 1556008800, 1, 0, ''),
(1383, 0, 0, 212, 0, 10, '24000.00', 0, 'in', 1556073360, 3, 0, ''),
(1384, 0, 0, 212, 0, 1, '24000.00', 0, 'in', 1556073360, 2, 0, ''),
(1385, 0, 0, 212, 0, 1, '24000.00', 0, 'in', 1556073420, 1, 0, ''),
(1389, 0, 0, 209, 0, 5, '2350.00', 0, 'in', 1556087460, 1, 0, ''),
(1390, 0, 0, 210, 0, 5, '36000.00', 0, 'in', 1556087460, 1, 0, ''),
(1391, 0, 0, 207, 0, 5, '4500.00', 0, 'in', 1556087460, 1, 0, ''),
(1392, 0, 0, 211, 0, 5, '14500.00', 0, 'in', 1556087460, 1, 0, ''),
(1393, 0, 0, 207, 0, 5, '4500.00', 0, 'in', 1556087580, 2, 0, ''),
(1394, 0, 0, 210, 0, 5, '36000.00', 0, 'in', 1556087580, 2, 0, ''),
(1395, 0, 0, 211, 0, 5, '14500.00', 0, 'in', 1556087580, 2, 0, ''),
(1396, 0, 0, 211, 0, 5, '14500.00', 0, 'in', 1556087580, 3, 0, ''),
(1397, 0, 0, 210, 0, 5, '36000.00', 0, 'in', 1556087580, 3, 0, ''),
(1398, 0, 0, 207, 0, 5, '4500.00', 0, 'in', 1556087580, 3, 0, ''),
(1399, 921, 0, 208, 921, 2, '6300.00', 1, 'out', 1556240160, 0, 0, 'Penjualan via kasir'),
(1400, 0, 0, 209, 0, 5, '2350.00', 0, 'out', 1556509800, 3, 0, ''),
(1401, 0, 0, 209, 0, 5, '2350.00', 0, 'in', 1556509800, 3, 0, ''),
(1406, 924, 0, 209, 924, 5, '2350.00', 1, 'out', 1556526240, 0, 0, 'Penjualan via kasir'),
(1407, 924, 0, 214, 924, 5, '20000.00', 1, 'out', 1556526240, 0, 0, 'Penjualan via kasir'),
(1413, 0, 0, 209, 0, 10, '2350.00', 0, 'out', 1557375660, 3, 0, ''),
(1414, 0, 0, 209, 0, 10, '2350.00', 0, 'in', 1557375900, 3, 0, ''),
(1415, 930, 0, 211, 0, 2, '14500.00', 1, 'out', 1557384619, 0, 0, ''),
(1417, 931, 0, 209, 931, 5, '2350.00', 1, 'out', 1558318140, 0, 0, 'Penjualan via kasir'),
(1418, 932, 0, 209, 932, 1, '2350.00', 1, 'out', 1558318260, 0, 0, 'Penjualan via kasir'),
(1419, 933, 0, 209, 933, 1, '2350.00', 1, 'out', 1558318500, 0, 0, 'Penjualan via kasir'),
(1420, 0, 0, 224, 0, 20, '25000.00', 0, 'trans', 1558506180, 1, 2, ''),
(1421, 0, 0, 224, 0, 20, '25000.00', 0, 'trans', 1558506240, 2, 3, ''),
(1422, 0, 0, 224, 0, 20, '25000.00', 0, 'trans', 1558506240, 1, 2, ''),
(1423, 0, 0, 224, 0, 2, '25000.00', 0, 'trans', 1558506300, 2, 3, ''),
(1427, 934, 0, 211, 934, 1, '14500.00', 1, 'out', 1558663620, 0, 0, 'Penjualan via kasir'),
(1430, 937, 0, 224, 937, 12, '25000.00', 1, 'out', 1558668420, 0, 0, 'Penjualan via kasir'),
(1432, 939, 0, 224, 939, 1, '25000.00', 1, 'out', 1558668600, 0, 0, 'Penjualan via kasir'),
(1433, 940, 0, 224, 940, 1, '25000.00', 1, 'out', 1558668660, 0, 0, 'Penjualan via kasir'),
(1435, 0, 0, 225, 0, 70, '20000.00', 0, 'trans', 1558670340, 1, 2, ''),
(1436, 0, 0, 225, 0, 55, '20000.00', 0, 'trans', 1558670340, 2, 3, ''),
(1458, 962, 0, 225, 962, 6, '17500.00', 1, 'out', 1558678740, 0, 0, 'Penjualan via kasir'),
(1473, 970, 0, 225, 970, 6, '17500.00', 1, 'out', 1558680300, 0, 0, 'Penjualan via kasir'),
(1478, 975, 0, 225, 975, 12, '16200.00', 1, 'out', 1558680660, 0, 0, 'Penjualan via kasir'),
(1479, 976, 0, 225, 976, 6, '17500.00', 1, 'out', 1558680720, 0, 0, 'Penjualan via kasir'),
(1480, 977, 0, 214, 977, 5, '20000.00', 1, 'out', 1559022720, 0, 0, 'Penjualan via kasir'),
(1481, 978, 0, 209, 978, 1, '2350.00', 1, 'out', 1559118420, 0, 0, 'Penjualan via kasir'),
(1487, 984, 0, 209, 984, 1, '2350.00', 1, 'out', 1559120760, 0, 0, 'Penjualan via kasir'),
(1488, 985, 0, 210, 985, 1, '36000.00', 1, 'out', 1559266860, 0, 0, 'Penjualan via kasir'),
(1489, 986, 0, 210, 986, 1, '36000.00', 1, 'out', 1559267340, 0, 0, 'Penjualan via kasir'),
(1490, 987, 0, 210, 987, 1, '36000.00', 1, 'out', 1559267460, 0, 0, 'Penjualan via kasir'),
(1491, 988, 0, 210, 988, 1, '36000.00', 1, 'out', 1559268180, 0, 0, 'Penjualan via kasir'),
(1492, 0, 0, 226, 0, 70, '27000.00', 0, 'trans', 1560486060, 1, 2, ''),
(1493, 0, 0, 226, 0, 40, '27000.00', 0, 'trans', 1560486120, 2, 3, ''),
(1494, 989, 0, 209, 989, 1, '2350.00', 1, 'out', 1561007280, 0, 0, 'Penjualan via kasir'),
(1500, 991, 0, 208, 991, 1, '6300.00', 1, 'out', 1561101840, 0, 0, 'Penjualan via kasir'),
(1501, 992, 0, 210, 992, 1, '36000.00', 1, 'out', 1561342200, 0, 0, 'Penjualan via kasir'),
(1502, 0, 0, 227, 0, 1000, '30000.00', 0, 'in', 1561346880, 1, 0, ''),
(1503, 0, 0, 227, 0, 500, '30000.00', 0, 'in', 1561346940, 2, 0, ''),
(1504, 0, 0, 227, 0, 200, '30000.00', 0, 'in', 1561346940, 3, 0, ''),
(1505, 993, 0, 227, 993, 1, '30000.00', 1, 'out', 1561346940, 0, 0, 'Penjualan via kasir'),
(1506, 994, 0, 208, 994, 1, '6300.00', 1, 'out', 1561521360, 0, 0, 'Penjualan via kasir'),
(1507, 995, 0, 209, 995, 1, '2350.00', 1, 'out', 1561687440, 0, 0, 'Penjualan via kasir'),
(1508, 996, 0, 209, 996, 3, '2350.00', 1, 'out', 1561694580, 0, 0, 'Penjualan via kasir'),
(1509, 997, 0, 226, 997, 2, '0.00', 1, 'out', 1561694580, 0, 0, 'Penjualan via kasir'),
(1510, 998, 0, 209, 998, 3, '2350.00', 1, 'out', 1561694640, 0, 0, 'Penjualan via kasir'),
(1511, 998, 0, 226, 998, 2, '265.00', 1, 'out', 1561694640, 0, 0, 'Penjualan via kasir'),
(1512, 999, 0, 209, 999, 2, '2350.00', 1, 'out', 1561694940, 0, 0, 'Penjualan via kasir'),
(1513, 999, 0, 226, 999, 2, '265.00', 1, 'out', 1561694940, 0, 0, 'Penjualan via kasir'),
(1514, 1000, 0, 226, 1000, 2, '0.00', 1, 'out', 1561695300, 0, 0, 'Penjualan via kasir'),
(1515, 1000, 0, 208, 1000, 4, '0.00', 1, 'out', 1561695300, 0, 0, 'Penjualan via kasir'),
(1516, 1001, 0, 226, 1001, 2, '265.00', 1, 'out', 1561695360, 0, 0, 'Penjualan via kasir'),
(1517, 1002, 0, 226, 1002, 2, '265.00', 1, 'out', 1561695360, 0, 0, 'Penjualan via kasir'),
(1518, 1003, 0, 226, 1003, 2, '265.00', 1, 'out', 1561695420, 0, 0, 'Penjualan via kasir'),
(1519, 1006, 0, 226, 1006, 2, '26500.00', 1, 'out', 1561696020, 0, 0, 'Penjualan via kasir'),
(1520, 0, 0, 230, 0, 100, '25000.00', 0, 'in', 1561701360, 3, 0, ''),
(1521, 1008, 0, 230, 1008, 1, '25000.00', 1, 'out', 1561701360, 0, 0, 'Penjualan via kasir'),
(1522, 1009, 0, 230, 1009, 10, '24000.00', 1, 'out', 1561704120, 0, 0, 'Penjualan via kasir'),
(1523, 1010, 0, 230, 1010, 1, '25000.00', 1, 'out', 1561704180, 0, 0, 'Penjualan via kasir'),
(1524, 1011, 0, 208, 1011, 1, '6300.00', 1, 'out', 1561712640, 0, 0, 'Penjualan via kasir');

-- --------------------------------------------------------

--
-- Table structure for table `trans_saldo`
--

CREATE TABLE `trans_saldo` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `type` varchar(10) NOT NULL COMMENT 'plus / minus / none',
  `nominal` decimal(15,2) NOT NULL,
  `id_user` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_reqsaldo` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trans_saldo`
--

INSERT INTO `trans_saldo` (`id`, `date`, `type`, `nominal`, `id_user`, `deskripsi`, `id_pesanan`, `id_reqsaldo`) VALUES
(909, 1555034509, 'none', '18500.00', 32, 'Transaksi pesanan ID 897', 897, 0),
(910, 1555034575, 'none', '26500.00', 32, 'Transaksi pesanan ID 898', 898, 0),
(911, 1555034848, 'none', '20500.00', 32, 'Transaksi pesanan ID 899', 899, 0),
(912, 1555035192, 'none', '36500.00', 32, 'Transaksi pesanan ID 900', 900, 0),
(918, 1555904540, 'none', '30000.00', 32, 'Transaksi pesanan ID 910', 910, 0),
(933, 1557384619, 'none', '39000.00', 32, '', 930, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tanggal_lahir` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `telp` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `kecamatan` text NOT NULL,
  `kelurahan` text NOT NULL,
  `kota` text NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_role` int(11) NOT NULL,
  `tanggal_daftar` int(11) NOT NULL,
  `saldoawal` decimal(10,2) NOT NULL,
  `saldo` decimal(10,2) NOT NULL,
  `imguser` text NOT NULL,
  `array_cart` text NOT NULL,
  `array_wishlist` text NOT NULL,
  `time_version_show` bigint(20) NOT NULL,
  `passcode` text NOT NULL,
  `passtime` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `tanggal_lahir`, `email`, `telp`, `alamat`, `kecamatan`, `kelurahan`, `kota`, `password`, `user_role`, `tanggal_daftar`, `saldoawal`, `saldo`, `imguser`, `array_cart`, `array_wishlist`, `time_version_show`, `passcode`, `passtime`) VALUES
(4, 'admin', '', 'admin@putrama.com', '081234567891', 'Jl. Godean No.KM. 4,5, Kwarasan, Nogotirto, Gamping, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55599', '', '', '', '077b9877b29a40103f33d9f9aba91c2d', 99, 1515542400, '0.00', '50000000.00', '/penampakan/images/php/files/administrator_male1600.png', '15|Daging Segar|30000|http://de-mo.site/ideasmart/penampakan/images/php/files/KARAKTERISTIK%20DAGING.jpg|4', '', 0, '', 0),
(32, 'User', '964976400', 'fairez942013@gmail.com', '085664499385', '', '', '', '', '190e0ae1aba1553a36e4fdf9d40c1450', 3, 1528185014, '0.00', '0.00', 'images1557200705.png', '', '', 1555316601, '1bae422aad2fe3f05e6d46c51a79ef6559863734bc9bf8b432969d3a8722f8a9', 1556956843),
(41, 'Pras', '1554051600', 'goprazt@gmail.com', '085228707924', '', '', '', '', 'e18350bb6134eba4c3b91867d13f2fb8', 3, 1555390497, '0.00', '0.00', '', '212|Seafermart iFood Rendang Sapi|24000.00|0.00|/penampakan/images/php/files/ifoof.png|1|1|kg!!!207|Pop Mie Rasa Ayam|4500.00|0.00|/penampakan/images/php/files/popmie-ayam.png|1|300|gram', '', 1555408067, '', 0),
(42, 'Ningrum', '1555952400', 'subkhityo@gmail.com', '085747581987', '', '', '', '', 'b727756c9aa21a1fbdd786685b0839fd', 3, 1555712823, '0.00', '0.00', '', '210|Toserda Sambal Bawang Mertua Lv 3|36000.00|0.00|/penampakan/images/php/files/sambal.png|1|700|gram!!!211|La Pasta Spicy Barbeque Spaghetti Instant|14500.00|0.00|/penampakan/images/php/files/lapasta.png|1|75|gram!!!212|Seafermart iFood Rendang Sapi|24000.00|0.00|/penampakan/images/php/files/ifoof.png|1|1|kg', '', 1555712875, '', 0),
(43, 'Bayu', '', '', '08997765566621', '', '', '', '', 'e31cc109a7ac1c927f90e4c6f6426bec', 3, 1561362787, '0.00', '0.00', '', '', '', 0, '', 0),
(47, 'Jihan', '', '', '08776537737333', '', '', '', '', 'c0393a80c0a3bf529bb6702182b43fc3', 3, 1561526932, '0.00', '0.00', '', '', '', 0, '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alamat_order`
--
ALTER TABLE `alamat_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cabang`
--
ALTER TABLE `cabang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `callback_duitku`
--
ALTER TABLE `callback_duitku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daftar_grosir`
--
ALTER TABLE `daftar_grosir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `datakurir`
--
ALTER TABLE `datakurir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dataoption`
--
ALTER TABLE `dataoption`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_pengguna`
--
ALTER TABLE `data_pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_voucher`
--
ALTER TABLE `data_voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hapiut`
--
ALTER TABLE `hapiut`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hapiut_item`
--
ALTER TABLE `hapiut_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inf_lokasi`
--
ALTER TABLE `inf_lokasi`
  ADD PRIMARY KEY (`lokasi_ID`),
  ADD KEY `lokasi_kode` (`lokasi_kode`),
  ADD KEY `lokasi_propinsi` (`lokasi_propinsi`),
  ADD KEY `lokasi_kabupatenkota` (`lokasi_kabupatenkota`),
  ADD KEY `lokasi_kecamatan` (`lokasi_kecamatan`),
  ADD KEY `lokasi_kelurahan` (`lokasi_kelurahan`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_ranking`
--
ALTER TABLE `item_ranking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `konfirmasi_saldo`
--
ALTER TABLE `konfirmasi_saldo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_pay`
--
ALTER TABLE `list_pay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik`
--
ALTER TABLE `logistik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `log_kredit`
--
ALTER TABLE `log_kredit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk_item`
--
ALTER TABLE `produk_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_saldo`
--
ALTER TABLE `request_saldo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans_order`
--
ALTER TABLE `trans_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans_saldo`
--
ALTER TABLE `trans_saldo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alamat_order`
--
ALTER TABLE `alamat_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;
--
-- AUTO_INCREMENT for table `cabang`
--
ALTER TABLE `cabang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `callback_duitku`
--
ALTER TABLE `callback_duitku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
--
-- AUTO_INCREMENT for table `daftar_grosir`
--
ALTER TABLE `daftar_grosir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `datakurir`
--
ALTER TABLE `datakurir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `dataoption`
--
ALTER TABLE `dataoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `data_pengguna`
--
ALTER TABLE `data_pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;
--
-- AUTO_INCREMENT for table `data_voucher`
--
ALTER TABLE `data_voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hapiut`
--
ALTER TABLE `hapiut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `hapiut_item`
--
ALTER TABLE `hapiut_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `inf_lokasi`
--
ALTER TABLE `inf_lokasi`
  MODIFY `lokasi_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15410;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `item_ranking`
--
ALTER TABLE `item_ranking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;
--
-- AUTO_INCREMENT for table `konfirmasi_saldo`
--
ALTER TABLE `konfirmasi_saldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=356;
--
-- AUTO_INCREMENT for table `list_pay`
--
ALTER TABLE `list_pay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `logistik`
--
ALTER TABLE `logistik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `log_kredit`
--
ALTER TABLE `log_kredit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1012;
--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;
--
-- AUTO_INCREMENT for table `produk_item`
--
ALTER TABLE `produk_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `request_saldo`
--
ALTER TABLE `request_saldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=708;
--
-- AUTO_INCREMENT for table `trans_order`
--
ALTER TABLE `trans_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1525;
--
-- AUTO_INCREMENT for table `trans_saldo`
--
ALTER TABLE `trans_saldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=934;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
