-- Generation time: Fri, 25 May 2018 19:00:21 +0000
-- Host: localhost
-- DB name: ideasmart_apps1d3asMart
/*!40030 SET NAMES UTF8 */;

DROP TABLE IF EXISTS `request_saldo`;
CREATE TABLE `request_saldo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `harga_awal` decimal(10,2) NOT NULL,
  `kode_unik` int(11) NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `date_checkout` int(11) NOT NULL,
  `type` varchar(128) NOT NULL DEFAULT 'saldo' COMMENT 'saldo/pesanan',
  `id_pesanan` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `aktif` int(2) NOT NULL DEFAULT '1',
  `id_trans_saldo` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

INSERT INTO `request_saldo` VALUES ('22','30','300000.00','22','300022.00','1524247921','saldo','0','1','1','1'),
('24','31','300000.00','24','300024.00','1524267468','saldo','0','1','1','5'),
('35','30','300000.00','35','300035.00','1524889033','saldo','0','1','1','8|9'),
('37','41','300000.00','37','300037.00','1524982463','saldo','0','1','1','11|12'),
('41','42','300000.00','41','300041.00','1524990578','saldo','0','1','1','14|15'),
('53','46','150000.00','53','150053.00','1525400698','saldo','0','1','1','19'),
('56','49','150000.00','56','150056.00','1525869631','saldo','0','1','1','24'),
('57','51','500000.00','57','500057.00','1526587891','saldo','0','1','1','26'),
('61','31','28202.00','0','28202.00','1526634335','pesanan','12','1','1','0'); 


