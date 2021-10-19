-- Generation time: Tue, 29 May 2018 19:00:02 +0000
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

INSERT INTO `alamat_order` VALUES ('1','22','tta','DANUREJAN','SURYATMAJAN','Kota Yogyakarta','Ya'),
('2','31','Kusuma negara 64','UMBUL HARJO','WARUNGBOTO','Kota Yogyakarta','Tidak'),
('3','30','Jl.kusumanegara no 66','UMBUL HARJO','WARUNGBOTO','Kota Yogyakarta','Tidak'),
('4','41','Paula dewi','KRATON','PATEHAN','KOTA YOGYAKARTA',''),
('5','42','Jl. Wulung no 16 Papringan','DEPOK','CATURTUNGGAL','KABUPATEN SLEMAN','Ya'),
('6','30','Jl. Kusumanegara no. 64-66','UMBUL HARJO','WARUNGBOTO','KOTA YOGYAKARTA','Tidak'),
('7','41','Jl.Taman KT 1 no 426 Patehan Kraton DIY','KRATON','PATEHAN','KOTA YOGYAKARTA',''),
('8','46','Jalan Magelang km7.2. Perempatan pasar mlati k timur. 400 mt ada masjid. Sebelah masjid pagar hitam.','MLATI','SENDANGADI','KABUPATEN SLEMAN',''),
('9','30','Apartment Mataram City 718 palagan','NGAGLIK','SARIHARJO','KABUPATEN SLEMAN','Tidak'),
('10','49','kampung sanggrahan rt 08 rw 09 no. 82','GAMPING','BANYURADEN','KABUPATEN SLEMAN',''),
('11','55','Jl. Kusumanegara No. 64-66','1004','13','71','Ya'),
('12','56','Kijing Bu Pri Sadjid, Jalan Menteri Supeno No 53','1005','13','71','Ya'),
('13','57','Jln suryopranoto no 11','1002','11','71','Ya'),
('14','59','Jalan godean km 7.5 griya munggur 8 no 9','2006','02','04','Ya'),
('15','60','Jl. Godean Km. 4,5 Gang Rama No. 95 A  RT. 05/RW. 05 Kwarasan','2004','01','04','Ya'),
('16','22','hzshakk','2002','02','04','Tidak'),
('17','42','Jl. Malioboro 153','1001','05','71','Tidak'); 


