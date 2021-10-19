-- Generation time: Tue, 29 May 2018 19:00:12 +0000
-- Host: localhost
-- DB name: ideasmart_apps1d3asMart
/*!40030 SET NAMES UTF8 */;

DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `imgkategori` text NOT NULL,
  `urutan` int(11) NOT NULL,
  `jumlah_produk` int(11) NOT NULL,
  `id_master` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;

INSERT INTO `kategori` VALUES ('1','Minuman','','/penampakan/images/php/files/Kategori-Minuman.jpg','3','81','0'),
('2','Isotonik','','/penampakan/images/upload_image_kat.png','0','3','1'),
('3','Makanan','','/penampakan/images/php/files/Kategori-Makanan.jpg','2','137','0'),
('4','Biskuit','','/penampakan/images/upload_image_kat.png','0','16','3'),
('5','Cookies','','/penampakan/images/upload_image_kat.png','0','7','3'),
('6','Produk Bayi dan Anak','','/penampakan/images/php/files/Kategori-Bayi.jpg','6','99','0'),
('7','Cotton Bud','','/penampakan/images/upload_image_kat.png','0','7','6'),
('8','Bahan dan Bumbu Masakan','','/penampakan/images/php/files/Bahan-dan-Bumbu-Masakan.jpg','4','23','0'),
('9','Santan','','/penampakan/images/upload_image_kat.png','0','1','8'),
('10','Makanan Beku','','/penampakan/images/php/files/Kategori-Makanan-beku.jpg','1','11','0'),
('11','Kentang','','/penampakan/images/upload_image_kat.png','0','0','10'),
('12','Nugget','','/penampakan/images/upload_image_kat.png','0','2','10'),
('13','Makanan Siap Saji','','/penampakan/images/upload_image_kat.png','0','3','10'),
('14','Sosis','','/penampakan/images/upload_image_kat.png','0','6','10'),
('15','Baby Oil','','/penampakan/images/upload_image_kat.png','0','4','6'),
('16','Tissue Basah','','/penampakan/images/upload_image_kat.png','0','4','6'),
('17','Bedak Bayi','','/penampakan/images/upload_image_kat.png','0','16','6'),
('18','Lotion','','/penampakan/images/upload_image_kat.png','0','10','6'),
('19','Pasta Gigi Anak','','/penampakan/images/upload_image_kat.png','0','4','6'),
('20','Sabun Bayi','','/penampakan/images/upload_image_kat.png','0','17','6'),
('21','Shampoo Anak','','/penampakan/images/upload_image_kat.png','0','7','6'),
('22','Shampoo Bayi','','/penampakan/images/upload_image_kat.png','0','11','6'),
('23','Sikat Gigi Anak','','/penampakan/images/upload_image_kat.png','0','2','6'),
('24','Farmasi','','/penampakan/images/php/files/Farmasi.jpg','9','23','0'),
('25','Cairan Antiseptik','','/penampakan/images/upload_image_kat.png','0','6','24'),
('26','Lotion Anti Nyamuk','','/penampakan/images/upload_image_kat.png','0','5','24'),
('27','Kebutuhan Rumah Tangga','','/penampakan/images/php/files/kebutuhan-rumah-tangga.jpg','10','59','0'),
('28','Obat Nyamuk','','/penampakan/images/upload_image_kat.png','0','2','27'),
('29','Pelicin Pakaian','','/penampakan/images/upload_image_kat.png','0','10','27'),
('30','Serbuk','','/penampakan/images/upload_image_kat.png','0','4','1'),
('31','Siap Minum','','/penampakan/images/upload_image_kat.png','0','37','1'),
('32','Susu','','/penampakan/images/php/files/Kategori-Susu.jpg','5','35','0'),
('33','Susu Dewasa','','/penampakan/images/upload_image_kat.png','0','6','32'),
('34','Susu Ibu Hamil','','/penampakan/images/upload_image_kat.png','0','3','32'),
('35','Susu Anak','','/penampakan/images/upload_image_kat.png','0','23','32'),
('36','Kacang','','/penampakan/images/upload_image_kat.png','0','6','3'),
('37','Wafer','','/penampakan/images/upload_image_kat.png','0','13','3'),
('38','Tissue','','/penampakan/images/upload_image_kat.png','0','6','27'),
('39','Perawatan Tubuh','','/penampakan/images/php/files/IMG-20180519-WA0008.jpg','7','81','0'),
('40','Gigi dan Mulut','','/penampakan/images/upload_image_kat.png','0','17','39'),
('41','Sabun Wajah','','/penampakan/images/upload_image_kat.png','0','6','39'),
('42','Perlengkapan Pribadi','','/penampakan/images/php/files/perlengkapan-pribadi.jpg','8','20','0'),
('43','Pantyliner','','/penampakan/images/upload_image_kat.png','0','4','42'),
('44','Kertas Minyak','','/penampakan/images/upload_image_kat.png','0','1','42'),
('45','Gift Box','','/penampakan/images/upload_image_kat.png','0','1','6'),
('46','Cologne','','/penampakan/images/upload_image_kat.png','0','3','6'),
('47','Pembersih Dapur','','/penampakan/images/upload_image_kat.png','0','1','27'),
('48','Pembersih Lantai','','/penampakan/images/upload_image_kat.png','0','7','27'),
('49','Pembersih Toilet','','/penampakan/images/upload_image_kat.png','0','4','27'),
('50','Pembersih Kaca','','/penampakan/images/upload_image_kat.png','0','2','27'),
('51','Pewangi Ruangan','','/penampakan/images/upload_image_kat.png','0','1','27'),
('52','Saus','','/penampakan/images/upload_image_kat.png','0','8','8'),
('53','Pembersih Daerah V','','/penampakan/images/upload_image_kat.png','0','1','24'),
('54','Pembersih Botol Bayi','','/penampakan/images/upload_image_kat.png','0','1','27'),
('55','Permen','','/penampakan/images/upload_image_kat.png','0','10','3'),
('56','Bumbu','','/penampakan/images/upload_image_kat.png','0','3','8'),
('57','Tepung','','/penampakan/images/upload_image_kat.png','0','5','8'),
('58','Makanan Kaleng','','/penampakan/images/upload_image_kat.png','0','0','3'),
('59','Sirup','','/penampakan/images/upload_image_kat.png','0','7','1'),
('60','Sabun Cuci Piring','','/penampakan/images/upload_image_kat.png','0','6','27'),
('61','Bubur Instan','','/penampakan/images/upload_image_kat.png','0','2','3'),
('62','Mie Instan','','/penampakan/images/upload_image_kat.png','0','20','3'),
('63','Sereal','','/penampakan/images/upload_image_kat.png','0','8','3'),
('64','Air Mineral','','/penampakan/images/upload_image_kat.png','0','11','1'),
('65','Kopi','','/penampakan/images/upload_image_kat.png','0','12','1'),
('66','Nori','','/penampakan/images/upload_image_kat.png','0','1','3'),
('67','Keju','','/penampakan/images/upload_image_kat.png','0','3','8'),
('68','Snack Bayi','','/penampakan/images/upload_image_kat.png','0','1','3'),
('69','Susu Kesehatan','','/penampakan/images/upload_image_kat.png','0','2','32'),
('70','Jelly','','/penampakan/images/upload_image_kat.png','0','0','3'),
('71','Snack','','/penampakan/images/upload_image_kat.png','0','22','3'),
('72','Bahan Pokok','','/penampakan/images/upload_image_kat.png','0','6','3'),
('73','Pelembut Pakaian','','/penampakan/images/upload_image_kat.png','0','5','27'),
('74','Shampoo','','/penampakan/images/upload_image_kat.png','0','22','39'),
('75','Sabun Badan','','/penampakan/images/upload_image_kat.png','0','23','39'),
('76','Sabun Tangan','','/penampakan/images/upload_image_kat.png','0','4','39'),
('77','Creamer','','/penampakan/images/upload_image_kat.png','0','0','1'),
('78','Teh','','/penampakan/images/upload_image_kat.png','0','3','1'),
('79','Minyak Goreng','','/penampakan/images/upload_image_kat.png','0','1','8'),
('80','Pembalut Wanita','','/penampakan/images/upload_image_kat.png','0','10','42'),
('81','Popok Dewasa','','/penampakan/images/upload_image_kat.png','0','3','42'),
('82','Popok Bayi','','/penampakan/images/upload_image_kat.png','0','11','6'),
('83','Gula','','/penampakan/images/upload_image_kat.png','0','1','8'),
('84','Krim Otot','','/penampakan/images/upload_image_kat.png','0','1','24'),
('85','Minyak Aromatherapy','','/penampakan/images/upload_image_kat.png','0','5','24'),
('86','Minyak Telon','','/penampakan/images/upload_image_kat.png','0','3','24'),
('87','Madu','','/penampakan/images/upload_image_kat.png','0','1','1'),
('88','Mentega/Margarin','','/penampakan/images/upload_image_kat.png','0','1','8'),
('89','Sabun Cuci Pakaian','','/penampakan/images/upload_image_kat.png','0','10','27'),
('90','Sabun Cuci Piring','','/penampakan/images/upload_image_kat.png','0','1','27'),
('91','Sari Buah','','/penampakan/images/upload_image_kat.png','0','3','1'),
('92','Deodorant','','/penampakan/images/upload_image_kat.png','0','5','39'),
('93','Lotion Tubuh','','/penampakan/images/upload_image_kat.png','0','4','39'),
('94','Pembalut Bersalin','','/penampakan/images/upload_image_kat.png','0','1','42'),
('95','Makanan Bayi','','/penampakan/images/upload_image_kat.png','0','19','3'),
('96','Pelengkap','','/penampakan/images/upload_image_kat.png','0','5','3'),
('97','Pasta','','/penampakan/images/upload_image_kat.png','0','1','3'),
('98','Pembersih Kamar Mandi','','/penampakan/images/upload_image_kat.png','0','3','27'),
('99','Kapas','','/penampakan/images/upload_image_kat.png','0','1','42'),
('100','Minyak Kayu Putih','','/penampakan/images/upload_image_kat.png','0','2','24'),
('101','Sabun Anak','','/penampakan/images/upload_image_kat.png','0','2','6'),
('102','Susu Ibu Menyusui','','/penampakan/images/upload_image_kat.png','0','1','32'),
('103','Parcel','','/penampakan/images/php/files/Kategori-Parcel.jpg','11','6','0'),
('104','Parcel Lebaran','','/penampakan/images/upload_image_kat.png','0','6','103'); 


