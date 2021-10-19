-- Generation time: Mon, 28 May 2018 19:00:16 +0000
-- Host: localhost
-- DB name: ideasmart_apps1d3asMart
/*!40030 SET NAMES UTF8 */;

DROP TABLE IF EXISTS `logistik`;
CREATE TABLE `logistik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



