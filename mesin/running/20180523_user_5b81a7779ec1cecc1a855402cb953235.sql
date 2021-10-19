-- Generation time: Wed, 23 May 2018 19:00:28 +0000
-- Host: localhost
-- DB name: ideasmart_apps1d3asMart
/*!40030 SET NAMES UTF8 */;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

INSERT INTO `user` VALUES ('4','admin','admin@ideasmart.com','081234567891','asd','','','','077b9877b29a40103f33d9f9aba91c2d','99','1515542400','0.00','500000.00','','15|Daging Segar|30000|http://de-mo.site/ideasmart/penampakan/images/php/files/KARAKTERISTIK%20DAGING.jpg|4'),
('9','Checker 0001','checker@ideasmart.com','123456789','Jogja','','','','5df5cc7b54ef7746a3f89bb718462463','10','1519201996','0.00','0.00','/penampakan/images/php/files/boy%20%281%29.png',''),
('10','Helper 001','helper@ideasmart.com','123456789','Jogja','','','','427d9853fdc96e962675f08a8bb53dca','20','1519202039','0.00','0.00','',''),
('11','Driver 0001','driver@ideasmart.com','123456789','Jogja','','','','90e02cd8c8c36cc2a9c697249faabbeb','30','1519202072','0.00','0.00','',''),
('12','Head Checker','headchecker@ideasmart.com','123456789','Jogja','','','','60b5d0642652ffa847e93255e8d5d0cb','40','1519202220','0.00','0.00','',''),
('13','Head Driver','headdriver@ideasmart.com','123456789','Jogja','','','','4d887d9ad4ca083c56f827fb733a68ca','50','1519202350','0.00','0.00','',''),
('14','Head Logistic','headlogistic@ideasmart.com','123456789','Jogja','','','','2c727b51f0c5c8417154be5d947db5d3','60','1519202460','0.00','0.00','',''),
('15','test','test@team.com','test','test','','','','780436b9494e5201590f2fc82be942ef','10','1519213530','0.00','0.00','',''),
('16','test23','test223@team.com','1212123','solo23','','','','89c832f220792194e6ee2c66e1c138d7','40','0','0.00','0.00','',''),
('17','Helper 002','helper2@ideasmart.com','123456789','Jogja','','','','00994efccf094ad64bbb32fa172c18ad','20','0','0.00','0.00','/penampakan/images/php/files/girl%20%282%29.png',''),
('18','Driver 0002','driver2@ideasmart.com','123456789','Jogja','','','','9e3c480dc10d06681a4cd3835ea3c02b','30','0','0.00','0.00','',''),
('20','admin office','adminoffice@ideasmart.com','123456','Jogja','','','','a94cff5bf0eff6079b645181e677e835','70','0','0.00','0.00','',''),
('22','akun test','akuntest@mail.com','08123456789','','','','','2ac06efbd3563deadf88282186fbde1b','3','1522764534','0.00','200000.00','',''),
('26','Carl Ideas','idenesiaraia@gmail.com','08118666888','','','','','12d7e2087fa7f0bb6b1fca0d7a6f9797','3','1524238135','0.00','0.00','','168|Dettol body wash 250ml original|19700.00|/penampakan/images/php/files/8993560026004-Dettol-BW-Original-a.jpg|2'),
('27','Joko','wachid@gravis-design.com','081391139399','','','','','6bf2c16e1af7082ecb74c4fb27fbdc15','3','1524238369','0.00','0.00','','349|Lactogen 2 Happynutri 6-12 bulan 180 gr|30900.00|/penampakan/images/php/files/4800361347839-lactogen-2-a.jpg|3!!!350|Lactogrow 3 Happynutri 1-3th Honey 180 gr|28410.00|/penampakan/images/php/files/8992696423930-Lactogrow-a.jpg|5'),
('28','apiary','theodore@apiary.id','082328309998','','','','','0ce9182dd18f59a28bcfe823a161cfeb','3','1524238665','0.00','0.00','','350|Lactogrow 3 Happynutri 1-3th Honey 180 gr|28410.00|/penampakan/images/php/files/8992696423930-Lactogrow-a.jpg|2!!!206|Sariwangi Teh asli box 50S|11560.00|/penampakan/images/php/files/8999999195656-sariwangi-teh-asli-box-50s-c.jpg|2'),
('29','Wawan','setiawanhardika@yahoo.com','081223629891','','','','','042384ec45b5558d9fc69975ead30733','3','1524238778','0.00','0.00','',''),
('30','Nathania bahari','loisegirl_lie@yahoo.com','082328060000','','','','','209f1a800274bafee6be43f34a30d24b','3','1524239832','0.00','5594.00','',''),
('31','Raymond rendabel','raymondcls89@gmail.com','081228060000','','','','','ecfff809be681df72127af130c621399','3','1524267390','0.00','0.00','',''),
('32','Marceltes','gregorymarcel.tandijono@gmail.com','081290889696','','','','','d7fdce4d58087da5737b07f3d7144a8d','3','1524269066','0.00','0.00','','349|Lactogen 2 Happynutri 6-12 bulan 180 gr|30900.00|/penampakan/images/php/files/4800361347839-lactogen-2-a.jpg|5!!!402|Marjan squash leci 450ml|13155.00|/penampakan/images/php/files/8998888170828-Marjan-squash-leci-450ml.jpg|4!!!239|Prochiz cheddar cheese gold 170 gr|15000.00|/penampakan/images/php/files/8997014450216-Prochiz-Gold-Cheddar-a.jpg|7!!!320|Garuda Snack Kedele 75gr|6200.00|/penampakan/images/php/files/8992775217016-Garuda-Snack-Kedele-75gr-a.jpg|6'),
('33','Test akun','test@mail.com','08987654321','','','','','2ac06efbd3563deadf88282186fbde1b','3','1524290746','0.00','0.00','','291|Mamy Poko open new born 52Pcs|129370.00|/penampakan/images/php/files/8851111400430-MamyPoko-New-Born-52-a.jpg|2'),
('34','hanoto','hanotogouw@gmail.com','0818462021','','','','','16dd9c6e4f30193c900a15398384ee8c','3','1524319422','0.00','0.00','','106|Clean&amp;amp;amp;Clear oil control film 60S|26800.00|/penampakan/images/php/files/8850007700050-C%26C-oil-film-60S-a.jpg|7!!!216|Dettol hand sanitizer original 50ml|12900.00|/penampakan/images/php/files/8993560027247-Dettol-Hand-Sanitizer-a.jpg|10!!!367|Pristine 8+ Air Mineral 1500ml|5756.00|/penampakan/images/php/files/8999510785472-pristine-1500.jpg|1!!!403|Marjan squash melon 450ml|13155.00|/penampakan/images/php/files/8998888170224-Marjan-squash-melon-450ml.jpg|1!!!202|Buavita Mango 250ml|7100.00|/penampakan/images/php/files/8998009020193-buavita-mango-a.jpg|1!!!402|Marjan squash leci 450ml|13155.00|/penampakan/images/php/files/8998888170828-Marjan-squash-leci-450ml.jpg|1'),
('35','Stevanus john quezon','stevanus.quezon11@gmail.com','081904776663','','','','','e4ab8f7e7527b59655c7961d0adf11f7','3','1524334012','0.00','0.00','','225|Indocafe coffemix 3in1 box 5x20gr|7700.00|/penampakan/images/php/files/9311931184037-Indocafe-3in1-5x20gr-a.jpg|1!!!206|Sariwangi Teh asli box 50S|11560.00|/penampakan/images/php/files/8999999195656-sariwangi-teh-asli-box-50s-c.jpg|1!!!399|Marjan boudoin leci 460ml|23200.00|/penampakan/images/php/files/8998888110817-Marjan-boudoin-leci-460ml.jpg|1'),
('36','Fajar amin','fajarmazda002@gmail.com','081804156614','','','','','2730a20c0ea0c444ce21d0a0b11ecede','3','1524359433','0.00','0.00','','385|Rinso+molto pink deterjen bubuk 800gr|18803.00|/penampakan/images/php/files/8999999045265-rinso-molto-deterjen-pink-800-a.jpg|1!!!92|Multi Facial 1000gr|38640.00|/penampakan/images/php/files/8992931025080-multi-facial-tissue-1000gr-a.jpg|1!!!208|Le Minerale 1500 ml|4270.00|/penampakan/images/php/files/8996001600399-Le-minerale-1500.jpg|2!!!223|Vaseline Healthy White (pink) 200ml|22655.00|/penampakan/images/php/files/8999999719418-vaseline-HB-lotion-healthy-white-a%20%281%29.jpg|1!!!467|Kapal api mantap 10sx25gr|10590.00|/penampakan/images/php/files/8991002105645-kapal-api-mantab-a.jpg|1'),
('37','Rizal','rizal.artworks@gmail.com','082131520285','','','','','2e1114f9a6b468e27d25f4134ab24958','3','1524392967','0.00','0.00','',''),
('38','Annisa','nisa.est.belle@gmail.com','08179928823','','','','','e3986a61ad9a9fc16fababdb069ad921','3','1524469674','0.00','0.00','','454|Kraft single 10slices 167gr|18290.00|/penampakan/images/php/files/8998009070037-kraft-single.jpg|1!!!406|Gulaku Premium 1Kg|13858.00|/penampakan/images/php/files/8995177101112-Gulaku-premium-1kg-a.jpg|1!!!403|Marjan squash melon 450ml|13155.00|/penampakan/images/php/files/8998888170224-Marjan-squash-melon-450ml.jpg|1'),
('39','Endradi fatriawan','endra.mazdajogja@gmail.com','087738388009','','','','','ba0b75961b19cc015f34d85dce80300e','3','1524540135','0.00','0.00','','140|Besto Sosis sapi 14 pcs|33432.00|/penampakan/images/php/files/8993200662340-besto-sosis-sapi-14pcs.jpg|1'),
('40','Kurniawan Fauzi','elqygalan@gmail.com','0818262777','','','','','ac8a45393af9ef21fb0ed84ca0c253c3','3','1524576771','0.00','0.00','',''),
('41','Paula','paula.herewilla@gmail.com','081344313708','','','','','bc5a03f913d48421757ea7c92c2d0c1b','3','1524982385','0.00','2720.00','',''),
('42','Danila','daneelz_lie@yahoo.com','089675511034','','','','','3fa77c3a3c43cffff3be7765ad442fd8','3','1524990548','0.00','98788.00','',''),
('43','Carl de Ieas','carl.verityindonesia@gmail.com','08562828048','','','','','12d7e2087fa7f0bb6b1fca0d7a6f9797','3','1525098442','0.00','0.00','','488|Potabee Reg Grilled Seaweed 68gr|8127.00|/penampakan/images/php/files/20180423_170020.jpg|1!!!440|Pop Mie ayam bawang 75gr|3790.00|/penampakan/images/php/files/089686060003-popmie-ayambawang.jpg|3!!!270|Madu TJ murni 250gr|30613.00|/penampakan/images/php/files/8993365132535-Madu-TJ-Murni.jpg|1!!!367|Pristine 8+ Air Mineral 1500ml|5066.00|/penampakan/images/php/files/8999510785472-pristine-1500.jpg|5!!!475|Mie kremezz Sambal Balado 30gr|1190.00|/penampakan/images/php/files/8993118937110-mie-kremezz-balado-a.jpg|5!!!476|Mie kremezz ayam panggang 30gr|1190.00|/penampakan/images/php/files/8993118937103-mie-kremezz-aym-panggang-a.jpg|5!!!477|Sedaap mie goreng cup 85gr|4390.00|/penampakan/images/php/files/8998866200813-sedaap-mie-goreng-cup-a.jpg|2!!!519|Pop mie rasa ayam 75gr|3899.00|/penampakan/images/php/files/0-89686060027-Pop-mie-rasa-ayam-75gr-b.jpg|2'),
('44','elga fajar','elfaefk@gmail.com','081329815643','','','','','b750a9db7e2a7dde49e60ae88f41041d','3','1525110389','0.00','0.00','',''),
('45','Yuslim mirsam','tibyus17@gmail.com','087738334253','','','','','268fcecd09d123979e68ccc33e86ab22','3','1525396542','0.00','0.00','','364|Filma minyak goreng refill 2 liter|26452.00|/penampakan/images/php/files/8992826111089-filma-ref-2l-a.jpg|1'),
('46','Hans Nicholas','h4ns_nicholas@yahoo.com','085743239000','','','','','eaf497de03b0431c61f8e2a4550d6e88','3','1525400657','0.00','262.00','',''),
('47','Ernawati handayani','ernawatihandayani7@gmail.com','081379093472','','','','','7b4b5c5dd92368f0c3ca6ffa5bac7de3','3','1525601855','0.00','0.00','',''),
('48','ridife','ridif@live.com','089655663939','','','','','f3cc5d6d51377afd4307722e70b0f768','3','1525651752','0.00','0.00','',''),
('49','Fitria Eka Yulianti','aswinieka@gmail.com','081225443370','','','','','1fd8d5613fcb94153172559bacc0218a','3','1525869601','0.00','1849.00','',''),
('50','Yunita Kurnia Sari','yunitakurnias4@gmail.com','085325667501','','','','','e750ee954abace615d39622ccfe0c867','3','1526448712','0.00','0.00','',''),
('51','Dany okey boss','danykristiawan.dk@gmail.com','087839276279','','','','','99f18cd6b6ba5dc5c154ac21ecddde9a','3','1526587734','0.00','156148.00','',''),
('52','vista','vista@gravis-design.com','087730684718','','','','','d7fdce4d58087da5737b07f3d7144a8d','3','1526606015','0.00','0.00','','566|Dancow full cream fortigro 400gr|48386.00|/penampakan/images/php/files/8992696405486-Dancow-full-cream-fortigro-400gr.jpg|4'),
('53','Yunita Bunga','ybungad@gmail.com','082221043029','','','','','6ebe78dae48f56a6a8c815124c944232','3','1526620201','0.00','0.00','','518|Indomie goreng 85gr|2438.00|/penampakan/images/php/files/0-89686010947-Indomie-goreng-85gr.jpg|2!!!331|Chocolatos hazelnut 33 gr|1840.00|/penampakan/images/php/files/8992775000038-Chocolatos-choco-hazelnut-fam-pack-33-gr.jpg|2!!!544|Citra handbody lotion pearly white UV 120ml|10500.00|/penampakan/images/php/files/8999999003722-Citra-handbody-lotion-pearly-white-UV-120ml.jpg|1!!!328|Gery egg roll 210 gr|26000.00|/penampakan/images/php/files/8992775319048Gery-egg-roll-210-gr-a.jpg|1!!!184|KIS cherry 125 gr|6613.00|/penampakan/images/php/files/8996001326220-kis-cherry-a.jpg|1!!!177|Roma Malkist Chocolate 120 gr|6613.00|/penampakan/images/php/files/8996001302637-roma-mlkst-coklat-b.jpg|1!!!342|Dancow coklat FortiExcNutr UHT 110ml|2400.00|/penampakan/images/php/files/8992696422735-dancow-FEN-UHT-110-a.jpg|10!!!382|Rinso+molto deterjen cair 800ml|18975.00|/penampakan/images/php/files/8999999016128-rinso-molto-800-a.jpg|1'),
('54','Yolis','yolizz.ayu@gmail.com','081282388988','','','','','635f1b7a4a21c57b0a8c7d657bf97ed7','3','1526632865','0.00','0.00','',''),
('55','Hotline Ideasmart','belanjayuk@ideasmart.id','082328309900','','','','','209f1a800274bafee6be43f34a30d24b','3','1526688499','0.00','0.00','','400|Marjan boudoin stroberi 460ml|15900.00|/penampakan/images/php/files/8998888110718-Marjan-boudoin-stroberi-460ml.jpg|1!!!27|Fiesta Ready Meal Chicken Teriyaki w/rice 320gr|18400.00|/penampakan/images/php/files/8993207160504-fiesta-ready-teriyaki.jpg|8'),
('56','WIRATMOKO','wiratmokoko@gmail.com','081222299661','','','','','df4782d701059b27a20d7dd9fdf59f79','3','1526719495','0.00','0.00','',''),
('57','Karin','karin.kecil22@gmail.com','08990122057','','','','','77b1ad1e5feb75559202bd17630bd376','3','1526900646','0.00','0.00','',''),
('58','Ferdy Hidayat','ferdy.hidayat85@gmail.com','081228068448','','','','','694f68c8216dc2f3663b9afd9390ad32','3','1526916782','0.00','0.00','',''); 


