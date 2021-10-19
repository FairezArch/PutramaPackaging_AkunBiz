-- Generation time: Mon, 28 May 2018 19:00:14 +0000
-- Host: localhost
-- DB name: ideasmart_apps1d3asMart
/*!40030 SET NAMES UTF8 */;

DROP TABLE IF EXISTS `konfirmasi_saldo`;
CREATE TABLE `konfirmasi_saldo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` int(11) NOT NULL,
  `uang_saldo` decimal(11,2) NOT NULL,
  `uang_tf` decimal(11,2) NOT NULL,
  `rekuser` varchar(50) NOT NULL,
  `bankuser` varchar(100) NOT NULL,
  `namauser` varchar(100) NOT NULL,
  `rekideasmart` varchar(30) NOT NULL,
  `iduser` int(11) NOT NULL DEFAULT '0',
  `type` varchar(128) NOT NULL COMMENT 'saldo/pesanan	',
  `check_rek` int(11) NOT NULL DEFAULT '0',
  `id_reqsaldo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

INSERT INTO `konfirmasi_saldo` VALUES ('3','1524247200','300000.00','300024.00','7735133900','Bca','Raymond rendabel','BCA','31','saldo','1','24'),
('2','1524247200','300000.00','300022.00','7735133900','Bca','Raymond rendabel','BCA','30','saldo','1','22'),
('4','1524852000','300000.00','300035.00','7735133900','Bca','Raymond rendabel','BCA','30','saldo','1','35'),
('5','1524938400','300000.00','300037.00','1540005798891','Mandiri','Paula','BCA','41','saldo','1','37'),
('6','1524938400','300000.00','300041.00','0373717778','Bca','Danila enda b','BCA','42','saldo','1','41'),
('7','0','300000.00','300048.00','5325015567','Bca','C ideas pramudityo','BCA','43','saldo','0','48'),
('8','0','300000.00','300048.00','5325015567','BCA','C Ideas Pramudityo','BCA','43','saldo','0','48'),
('9','0','300000.00','150123.00','0373418053','BCA','Hans Nicholas','BCA','46','saldo','0','53'),
('10','0','300000.00','150058.00','7735133900','Bca','Raymond rendabel','BCA','31','saldo','0','58'),
('11','0','500000.00','500057.00','8175137579','BCA','Dany Kristiawan','BCA','51','saldo','0','57'),
('12','0','500000.00','500057.00','8175137579','BCA','Dany Kristiawan','BCA','51','saldo','0','57'),
('13','1526580000','0.00','28202.00','7735133900','Bca','Raymond rendabel','BCA','31','pesanan','1','61'),
('16','1527271200','300000.00','300064.00','1260662984','Bca','Lingga yomni','BCA','59','saldo','1','64'),
('17','1527444000','0.00','341431.00','0373717778','Danila enda b','Danila','BCA','42','pesanan','1','65'); 


