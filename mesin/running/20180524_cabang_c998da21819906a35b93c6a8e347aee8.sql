-- Generation time: Thu, 24 May 2018 19:00:03 +0000
-- Host: localhost
-- DB name: ideasmart_apps1d3asMart
/*!40030 SET NAMES UTF8 */;

DROP TABLE IF EXISTS `cabang`;
CREATE TABLE `cabang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `telp` int(11) NOT NULL,
  `img_cabang` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `cabang` VALUES ('1','Yogyakarta','Daerah Istimewa Yogyakarta','2147483647',''),
('2','Semarang','jl semarang','2147483647',''); 


