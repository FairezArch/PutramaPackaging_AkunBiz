-- Generation time: Thu, 24 May 2018 19:00:01 +0000
-- Host: localhost
-- DB name: ideasmart_apps1d3asMart
/*!40030 SET NAMES UTF8 */;

DROP TABLE IF EXISTS `alamat_order`;
CREATE TABLE `alamat_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `kelurahan` text NOT NULL,
  `kecamatan` text NOT NULL,
  `kota` varchar(200) NOT NULL,
  `main_address` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

INSERT INTO `alamat_order` VALUES ('1','22','tta','DANUREJAN','SURYATMAJAN','Kota Yogyakarta','Ya'),
('2','31','Kusuma negara 64','UMBUL HARJO','WARUNGBOTO','Kota Yogyakarta','Tidak'),
('3','30','Jl.kusumanegara no 66','UMBUL HARJO','WARUNGBOTO','Kota Yogyakarta','Tidak'),
('4','41','Paula dewi','KRATON','PATEHAN','KOTA YOGYAKARTA',''),
('5','42','Jl. Wulung no 16 Papringan','DEPOK','CATURTUNGGAL','KABUPATEN SLEMAN',''),
('6','30','Jl. Kusumanegara no. 64-66','UMBUL HARJO','WARUNGBOTO','KOTA YOGYAKARTA','Tidak'),
('7','41','Jl.Taman KT 1 no 426 Patehan Kraton DIY','KRATON','PATEHAN','KOTA YOGYAKARTA',''),
('8','46','Jalan Magelang km7.2. Perempatan pasar mlati k timur. 400 mt ada masjid. Sebelah masjid pagar hitam.','MLATI','SENDANGADI','KABUPATEN SLEMAN',''),
('9','30','Apartment Mataram City 718 palagan','NGAGLIK','SARIHARJO','KABUPATEN SLEMAN','Tidak'),
('10','49','kampung sanggrahan rt 08 rw 09 no. 82','GAMPING','BANYURADEN','KABUPATEN SLEMAN',''),
('11','55','Jl. Kusumanegara No. 64-66','1004','13','71','Ya'),
('12','56','Kijing Bu Pri Sadjid, Jalan Menteri Supeno No 53','1005','13','71','Ya'),
('13','57','Jln suryopranoto no 11','1002','11','71','Ya'); 


