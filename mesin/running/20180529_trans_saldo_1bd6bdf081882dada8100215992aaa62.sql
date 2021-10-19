-- Generation time: Tue, 29 May 2018 19:00:26 +0000
-- Host: localhost
-- DB name: ideasmart_apps1d3asMart
/*!40030 SET NAMES UTF8 */;

DROP TABLE IF EXISTS `trans_saldo`;
CREATE TABLE `trans_saldo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL,
  `type` varchar(10) NOT NULL COMMENT 'plus / minus / none',
  `nominal` decimal(15,2) NOT NULL,
  `id_user` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_reqsaldo` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

INSERT INTO `trans_saldo` VALUES ('1','1524249278','plus','300022.00','30','Penambahan Saldo User - Transfer Bank','0','22'),
('2','1524249720','plus','30000.00','30','bonus top up','0','0'),
('3','1524284397','minus','253212.00','30','Transaksi pesanan ID 1','1','0'),
('5','1524302317','plus','300024.00','31','Penambahan Saldo User - Transfer Bank','0','24'),
('6','1524302280','plus','30000.00','31','tambah Top-up 10% dari 300.000','0','0'),
('7','1524302594','minus','250460.00','31','Transaksi pesanan ID 3','3','0'),
('8','1524890056','plus','300035.00','30','Penambahan Saldo User - Transfer Bank','0','35'),
('9','1524890056','plus','30000.00','30','Bonus Top-up ID 35 (10%)','0','35'),
('10','1524890199','minus','172587.00','30','Transaksi pesanan ID 4','4','0'),
('11','1524984691','plus','300037.00','41','Penambahan Saldo User - Transfer Bank','0','37'),
('12','1524984691','plus','30000.00','41','Bonus Top-up ID 37 (10%)','0','37'),
('13','1524988304','minus','169174.00','41','Transaksi pesanan ID 5','5','0'),
('14','1524991583','plus','300041.00','42','Penambahan Saldo User - Transfer Bank','0','41'),
('15','1524991583','plus','30000.00','42','Bonus Top-up ID 41 (10%)','0','41'),
('16','1525055695','minus','231253.00','42','Transaksi pesanan ID 6','6','0'),
('17','1525095836','minus','107967.00','30','Transaksi pesanan ID 7','7','0'),
('18','1525396519','minus','158143.00','41','Transaksi pesanan ID 8','8','0'),
('19','1525402800','plus','150053.00','46','Penambahan Saldo User - Transfer Bank','0','53'),
('20','1525402860','plus','70.00','46','Data Transfer yang masuk 150.123','0','0'),
('21','1525494536','minus','149861.00','46','Transaksi pesanan ID 9','9','0'),
('22','1525662600','plus','200000.00','22','','0','0'),
('23','1525673937','minus','120697.00','30','Transaksi pesanan ID 10','10','0'),
('24','1525869902','plus','150056.00','49','Penambahan Saldo User - Transfer Bank','0','56'),
('25','1526008913','minus','148207.00','49','Transaksi pesanan ID 11','11','0'),
('26','1526618589','plus','500057.00','51','Penambahan Saldo User - Transfer Bank','0','57'),
('27','1526634335','minus','79564.00','31','Transaksi pesanan ID 12','12','61'),
('28','1526634335','none','28202.00','31','Transaksi pesanan ID 12','12','0'),
('29','1526662372','minus','349309.00','51','Transaksi pesanan ID 13','13','0'),
('31','1526692680','plus','5400.00','51','Update harga 18/5 Jam 13.00. User order 18/5 jam 23.52. Selisih harga 2btl marjan, krn user msh pake versi lama','0','0'),
('33','1527304559','plus','300064.00','59','Penambahan Saldo User - Transfer Bank','0','64'),
('34','1527305859','minus','205631.00','59','Transaksi pesanan ID 21','21','0'),
('35','1527474875','minus','98788.00','42','Transaksi pesanan ID 22','22','65'),
('36','1527474875','none','341431.00','42','Transaksi pesanan ID 22','22','0'),
('38','1527482248','none','118481.00','60','Transaksi pesanan ID 24','24','0'),
('41','1527508828','minus','5594.00','30','Transaksi pesanan ID 27','27','70'),
('42','1527508828','none','138560.00','30','Transaksi pesanan ID 27','27','0'),
('43','1527514020','plus','7338.00','30','ID 27 ganti windex 2 pcs @3.669 krn stok kosong','0','0'),
('44','1527561880','none','540000.00','42','Transaksi pesanan ID 28','28','0'); 


