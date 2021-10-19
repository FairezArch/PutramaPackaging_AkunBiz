-- Generation time: Sun, 27 May 2018 19:00:07 +0000
-- Host: localhost
-- DB name: ideasmart_apps1d3asMart
/*!40030 SET NAMES UTF8 */;

DROP TABLE IF EXISTS `dataoption`;
CREATE TABLE `dataoption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `optname` varchar(128) NOT NULL,
  `optvalue` text NOT NULL,
  `urutan` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

INSERT INTO `dataoption` VALUES ('1','hotline','0823 2830 9900','1'),
('2','telepon_view','(0274) 389 304','2'),
('3','telepon_value','0274 389 304','3'),
('4','email_kontak','belanjayuk@ideasmart.id','4'),
('5','instagram_url','https://www.instagram.com/ideasmart.id/','5'),
('6','facebook_url','https://www.facebook.com/ideasmart.id/','6'),
('7','web_url','https://ideasmart.id/','7'),
('8','about_us','Ideasmart adalah aplikasi tempat berbelanja online kebutuhan sehari-hari (groceries) untuk area Kota Yogyakarta. Berbagai keperluan rumah tangga dengan harga istimewa tersedia lengkap di sini. Pilih sendiri waktu pengantaran, seluruh pesanan bisa sampai pada hari yang sama, tanpa ongkos kirim.\n\nIdeasmart menyediakan solusi berbelanja online dengan cara yang mudah, hemat, dan cepat tanpa harus capek mengantri di supermarket, spesial untuk warga Kota Yogyakarta.','8'),
('9','terms','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ac ullamcorper tellus. Aliquam ligula erat, tempus id dignissim ac, pharetra a risus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis mattis auctor purus, eu fringilla odio ullamcorper ac. Quisque fermentum mauris nec risus facilisis, eu faucibus ante ornare. Donec porta risus eget sodales posuere. Duis egestas feugiat sem nec varius.\n\nPellentesque eros eros, vulputate eu odio id, posuere varius elit. Mauris a tempus eros. Aliquam volutpat orci quis sapien imperdiet efficitur. Sed sagittis leo enim. Nulla faucibus turpis sit amet sem facilisis, ac lacinia nisl blandit. Ut vel orci blandit, iaculis tortor vel, porta risus. Mauris ultrices ex vel sem placerat, et pulvinar tortor vulputate. Donec eleifend risus a magna tempus aliquam.','9'),
('10','privacy','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ac ullamcorper tellus. Aliquam ligula erat, tempus id dignissim ac, pharetra a risus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis mattis auctor purus, eu fringilla odio ullamcorper ac. Quisque fermentum mauris nec risus facilisis, eu faucibus ante ornare. Donec porta risus eget sodales posuere. Duis egestas feugiat sem nec varius.\n\nPellentesque eros eros, vulputate eu odio id, posuere varius elit. Mauris a tempus eros. Aliquam volutpat orci quis sapien imperdiet efficitur. Sed sagittis leo enim. Nulla faucibus turpis sit amet sem facilisis, ac lacinia nisl blandit. Ut vel orci blandit, iaculis tortor vel, porta risus. Mauris ultrices ex vel sem placerat, et pulvinar tortor vulputate. Donec eleifend risus a magna tempus aliquam.','10'),
('11','sendmail_admin','kondangnikmatfood@gmail.com,yolizz.ayu@gmail.com','11'),
('12','global_bnstopup','0','12'),
('13','waktu_countdown','1','40'); 


