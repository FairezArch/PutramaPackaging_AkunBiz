<?php require "function.php";

// LIST KATEGORI HOME
if ( isset($_POST['get_kategori']) && $_POST['get_kategori']==MOBILE_FORM ) {
	$args="SELECT * FROM kategori";
    $result = mysqli_query( $dbconnect, $args );
	$kategori = array();
	if ( $result ) {
		while ( $data_kategori = mysqli_fetch_array($result) ) {
			$kategori[] = array(
				"id" => $data_kategori['id'],
				"kategori" => $data_kategori['kategori'],
				"deskripsi" => $data_kategori['deskripsi'],
				"imgkategori" => $data_kategori['imgkategori'],
				"jml_produk" => $data_kategori['jumlah_produk'],
			);
		}
		$oke = '1';
		$keterangan = "berhasil";
	} else {
		$oke = '0';
		$keterangan = "gagal";
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"kategori" => $kategori,
	);
	echo json_encode($jawaban);
}

// LIST PRODUK
if ( isset($_POST['get_produk']) && $_POST['get_produk']==MOBILE_FORM ) {
	$limit = secure_string($_POST['limit']);
	if ( $limit == 1 ) {
		$args="SELECT * FROM produk ORDER BY id DESC LIMIT 9";
	} else {
		$args="SELECT * FROM produk ORDER BY id DESC";
	}
	$result = mysqli_query( $dbconnect, $args );
	$produk = array();
	if ( $result ) {
		while ( $data_produk = mysqli_fetch_array($result) ) {
			$produk[] = array(
				"id" => $data_produk['id'],
				"idcabang" => $data_produk['idcabang'],
				"idkategori" => $data_produk['idkategori'],
				"cabang" => $data_produk['cabang'],
				"kategori" => $data_produk['kategori'],
				"title" => $data_produk['title'],
				"trim_title" => excerptmobile($data_produk['title'],40),
				"harga" => $data_produk['harga'],
				"deskripsi" => $data_produk['deskripsi'],
				"stock" => $data_produk['stock'],
				"image" => $data_produk['image'],
				"filter" => all_stok_prod($data_produk['id'],'stock_tersedia'),
			);
		}
		$oke = '1';
		$keterangan = "berhasil";
	} else {
		$oke = '0';
		$keterangan = "gagal";
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"produk" => $produk,
	);
	echo json_encode($jawaban);
}

// LIST PRODUK PER KATEGOLI
if ( isset($_POST['prodkat']) && $_POST['prodkat']==MOBILE_FORM ) {
	$tabelname = secure_string($_POST['tabelname']);
	$idkategori = secure_string($_POST['id_kategori']);
	$kategori_name = data_tabel($tabelname, $idkategori, 'kategori');
	$args="SELECT * FROM produk WHERE idkategori='$idkategori' ORDER BY id DESC";
    $result = mysqli_query( $dbconnect, $args );
	$jumlah = mysqli_num_rows($result);
	$produk = array();
	if ( $result ) {
		while ( $data_produk = mysqli_fetch_array($result) ) {
			$produk[] = array(
				"id" => $data_produk['id'],
				"idcabang" => $data_produk['idcabang'],
				"idkategori" => $data_produk['idkategori'],
				"cabang" => $data_produk['cabang'],
				"kategori" => $data_produk['kategori'],
				"title" => $data_produk['title'],
				"trim_title" => excerptmobile($data_produk['title'],40),
				"harga" => $data_produk['harga'],
				"deskripsi" => $data_produk['deskripsi'],
				"stock" => $data_produk['stock'],
				"image" => $data_produk['image'],
				"filter" => all_stok_prod($data_produk['id'],'stock_tersedia'),
			);
		}
		$oke = '1';
		$keterangan = "berhasil";
	} else {
		$oke = '0';
		$keterangan = "gagal";
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"produk" => $produk,
		"kategori_name" => $kategori_name,
		"jumlah" => $jumlah,
	);
	echo json_encode($jawaban);
}

// DETAIL PRODUK
if ( isset($_POST['detilproduk']) && $_POST['detilproduk']==MOBILE_FORM ) {
	$tabelname = secure_string($_POST['tabelname']);
	$idproduk = secure_string($_POST['idproduk']);
	$produk_cabang_id = data_tabel($tabelname, $idproduk, 'idcabang');
	$produk_cabang = data_tabel('cabang', $produk_cabang_id, 'nama');
	$produk_kategori_id = data_tabel($tabelname, $idproduk, 'idkategori');
	$produk_kategori = data_tabel('kategori', $produk_kategori_id, 'kategori');
	$title_full = data_tabel($tabelname, $idproduk, 'title');
	$produk_deskripsi = data_tabel($tabelname, $idproduk, 'deskripsi');
	$produk_harga = data_tabel($tabelname, $idproduk, 'harga');
	$produk_stock = data_tabel($tabelname, $idproduk, 'stock');
	$produk_image = data_tabel($tabelname, $idproduk, 'image');
	
	$jawaban = array(
		"oke" => "1",
		"keterangan" => "berhasil",
		"produk_id" => $idproduk,
		"produk_cabang_id" => $produk_cabang_id,
		"produk_cabang" => $produk_cabang,
		"produk_kategori_id" => $produk_kategori_id,
		"produk_kategori" => $produk_kategori,
		"produk_title" => $title_full,
		"produk_deskripsi" => $produk_deskripsi,
		"produk_harga" => $produk_harga,
		"produk_stock" => $produk_stock,
		"produk_image" => $produk_image,
	);
	echo json_encode($jawaban);
}

// PRODUK SEJENIS
if ( isset($_POST['similar_produk']) && $_POST['similar_produk']==MOBILE_FORM ) {
	$idkategori = secure_string($_POST['idkategori']);
	$idproduk = secure_string($_POST['idproduk']);
	$args="SELECT * FROM produk WHERE id !='$idproduk' AND idkategori='$idkategori' ORDER BY id DESC LIMIT 15";
    $result = mysqli_query( $dbconnect, $args );
	$jumlah = mysqli_num_rows($result);
	$produk = array();
	if ( $result ) {
		while ( $data_produk = mysqli_fetch_array($result) ) {
			$produk[] = array(
				"id" => $data_produk['id'],
				"idcabang" => $data_produk['idcabang'],
				"idkategori" => $data_produk['idkategori'],
				"cabang" => $data_produk['cabang'],
				"kategori" => $data_produk['kategori'],
				"title" => $data_produk['title'],
				"trim_title" => excerptmobile($data_produk['title'],40),
				"harga" => $data_produk['harga'],
				"deskripsi" => $data_produk['deskripsi'],
				"stock" => $data_produk['stock'],
				"stock_order" => $data_produk['stock_order'],
				"image" => $data_produk['image'],
				"filter" => all_stok_prod($data_produk['id'],'stock_tersedia'),
			);
		}
		$oke = '1';
		$keterangan = "berhasil";
	} else {
		$oke = '0';
		$keterangan = "gagal";
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"produk" => $produk,
		"kategori_name" => $kategori_name,
		"jumlah" => $jumlah,
	);
	echo json_encode($jawaban);
}

// CARI PRODUK
if ( isset($_POST['getdatacari']) && $_POST['getdatacari']==MOBILE_FORM ) {
	$val = secure_string($_POST['val']);
	$args="SELECT * FROM produk WHERE title LIKE '%$val%' ORDER BY id DESC";
    $result = mysqli_query( $dbconnect, $args );
	$produk = array();
	if ( $result ) {
		while ( $data_produk = mysqli_fetch_array($result) ) {
			$produk[] = array(
				"id" => $data_produk['id'],
				"idcabang" => $data_produk['idcabang'],
				"idkategori" => $data_produk['idkategori'],
				"cabang" => $data_produk['cabang'],
				"kategori" => $data_produk['kategori'],
				"title" => $data_produk['title'],
				"trim_title" => excerptmobile($data_produk['title'],40),
				"harga" => $data_produk['harga'],
				"deskripsi" => $data_produk['deskripsi'],
				"stock" => $data_produk['stock'],
				"image" => $data_produk['image'],
				"filter" => all_stok_prod($data_produk['id'],'stock_tersedia'),
			);
		}
		$oke = '1';
		$keterangan = "berhasil";
	} else {
		$oke = '0';
		$keterangan = "gagal";
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"hasil" => $produk,
	);
	echo json_encode($jawaban);
}

// CEK DATA ARRAY CART
if ( isset($_POST['get_array_cart']) && $_POST['get_array_cart']==MOBILE_FORM ) {
	$product_id = secure_string($_POST['product_id']);
	$product_name = secure_string($_POST['product_name']);
	$product_price = secure_string($_POST['product_price']);
	$product_countorder = secure_string($_POST['product_countorder']);
	$product_image = secure_string($_POST['product_image']);
	$product_array_cart = secure_string($_POST['product_array_cart']);
	$simpan_array = array();
	$array_status = array();
	if ( $product_array_cart == '' ) {
		$simpan_array_1 = $product_id.'|'.$product_name.'|'.$product_price.'|'.$product_image.'|'.$product_countorder;
		$datakembali = $simpan_array_1;
	} else {
		$array_kode_item = explode('!!!',$product_array_cart);
		$simpan_array_1 = $product_id.'|'.$product_name.'|'.$product_price.'|'.$product_image.'|'.$product_countorder;
		
		$jumlah_item = count($array_kode_item) - 1;
		$x = 0;
		while($x <= $jumlah_item) {
			$arraydata = explode('|',$array_kode_item[$x]);
				if ($arraydata[0] == $product_id) {
					if ($product_countorder == 0) {
						$array_status[] = 1;
					} else {
						$simpan_array[] = $product_id.'|'.$product_name.'|'.$product_price.'|'.$product_image.'|'.$product_countorder;
						$array_status[] = 1;
					}
				} else {
					$simpan_array[] = $array_kode_item[$x];
					$array_status[] = 0;
				}
			$x++;
		}
		$jumlah = array_sum($array_status);
		$array_jadi = join("!!!",$simpan_array);
		
		//$datakembali = $array_jadi;
		if ( $jumlah == 0 ) {
			$datakembali = $simpan_array_1.'!!!'.$array_jadi;
		} else {
			$datakembali = $array_jadi;
		}
	}
	
	echo json_encode($datakembali);
}

// CEK TRUE FALSE ID ARRAY
if ( isset($_POST['truefalse']) && $_POST['truefalse']==MOBILE_FORM ) {
	$produkid = secure_string($_POST['product_id']);
	$datatest = secure_string($_POST['product_array_cart']);
	$datastatus = array();
	$array_kode_item = explode('!!!',$datatest);
	$jumlah_item = count($array_kode_item) - 1;
	$x = 0;
	while($x <= $jumlah_item) {
		$arraydata = explode('|',$array_kode_item[$x]);
			if ($arraydata[0] == $produkid) {
				$datastatus[] = 1;
				$stock = $arraydata[4];
			} else {
				$datastatus[] = 0;
			}
		$x++;
	}
	$jumlah = array_sum($datastatus);
	if ( $jumlah == 0 ) {
		$datakembali = '0|0';
	} else {
		$datakembali = '1|'.$stock;
	}
	echo json_encode($datakembali);
}

// CEK STOCK PRODUK DATABASE
if ( isset($_POST['cek_stock_db']) && $_POST['cek_stock_db']==MOBILE_FORM ) {
	$tabelname = secure_string($_POST['tabelname']);
	$datatest = secure_string($_POST['product_array_cart']);
	$datastatus = array();
	$hasil = array();
	$idcart = array();
	$array_kode_item = explode('!!!',$datatest);
	$jumlah_item = count($array_kode_item) - 1;
	$x = 0;
	while($x <= $jumlah_item) {
		$arraydata = explode('|',$array_kode_item[$x]);
			$data_stock = data_tabel('produk',$arraydata[0],'stock');
			$data_id = $arraydata[0];
			if ($data_stock < $arraydata[4]) {
				$datastatus[] = 1;
				$hasil[] = '1|'.$data_id;
				$idcart[] = $arraydata[0];
			} else {
				$datastatus[] = 0;
				$hasil[] = '0|'.$data_id;
				$idcart[] = $arraydata[0];
			}
		$x++;
	}
	$hasil_join = join("!!!",$hasil);
	$idcart_join = join("|",$idcart);
	$jumlah = array_sum($datastatus);
	if ( $jumlah == 0 ) {
		$status_stock = '0';
	} else {
		$status_stock = '1';
	}
	$jawaban = array(
		"oke" => "1",
		"keterangan" => "berhasil",
		"idcart_join" => $idcart_join,
		"hasil_join" => $hasil_join,
		"status_stock" => $status_stock,
	);
	echo json_encode($jawaban);
}

// UPDATE ARRAY CART DI DATABASE JIKA LOGIN
if ( isset($_POST['uparraycart']) && $_POST['uparraycart']==MOBILE_FORM ) {
	$user_id = secure_string($_POST['user_id']);
	$datarray = secure_string($_POST['datarray']);
	$uparray = "UPDATE user SET array_cart='$datarray' WHERE id='$user_id'";
	$result = mysqli_query( $dbconnect, $uparray );	
}

// SET LIST PRODUK DI CART
if ( isset($_POST['add_to_cart']) && $_POST['add_to_cart']==MOBILE_FORM ) {
	$produkid = secure_string($_POST['product_id']);
	$datasimpan = secure_string($_POST['product_array_cart']);
	$struktur = array();
	$jumlahharga = array();
	$idprodukcart = array();
	
	$array_kode_item = explode('!!!',$datasimpan);
	$jumlah_item = count($array_kode_item) - 1;
	
	$x = 0;
	while($x <= $jumlah_item) {
		$arraydata = explode('|',$array_kode_item[$x]);
		$struktur[] = array(
			"id" => $arraydata[0],
			"title" => $arraydata[1],
			"harga" => $arraydata[2],
			"image" => $arraydata[3],
			"jumlah" => $arraydata[4],
			"totalharga" => $arraydata[2] * $arraydata[4],
		);
		$jumlahharga[] = $arraydata[2] * $arraydata[4];
		$idprodukcart[] = $arraydata[0];
		$x++;
	}
	$subtotal = array_sum($jumlahharga);
	$idprodukcart_join = join("|",$idprodukcart);
	
	$jawaban = array(
		"oke" => "1",
		"keterangan" => "berhasil",
		"struktur" => $struktur,
		"subtotal" => $subtotal,
		"idprodukcart" => $idprodukcart_join,
	);
	echo json_encode($jawaban);
}

// UPDATE JUMLAH STOK PRODUK
if ( isset($_POST['hitungstock']) && $_POST['hitungstock']==MOBILE_FORM ) {
	$datatest = secure_string($_POST['product_array_cart']);
	$id_user = secure_string($_POST['id_user']);
	$telp_user = secure_string($_POST['telp_user']);
	$cart_total_harga = secure_string($_POST['cart_total_harga']);
	$tgl_database = strtotime('now');
	$array_id = array();
	$array_stock = array();
	$array_harga = array();
	$array_kode_item = explode('!!!',$datatest);
	$jumlah_item = count($array_kode_item) - 1;	
	$x = 0;
	while($x <= $jumlah_item) {
		$arraydata = explode('|',$array_kode_item[$x]);
			$array_id[] = $arraydata[0];
			$array_stock[] = $arraydata[4];
			$array_harga[] = $arraydata[2];
			
		$x++;
	}
	$id_jadi = join("|",$array_id);
	$stock_jadi = join("|",$array_stock);
	$harga_jadi = join("|",$array_harga);
	$upstock = "INSERT INTO pesanan ( id_user, telp, idproduk, jml_order, sub_total, total, waktu_pesan ) VALUES ( '$id_user', '$telp_user', '$id_jadi', '$stock_jadi', '$cart_total_harga', '$cart_total_harga', '$tgl_database' )";
	$result = mysqli_query( $dbconnect, $upstock );
	$neworder_id = mysqli_insert_id($dbconnect);
	$args_cartuser = "UPDATE user SET array_cart='' WHERE id='$id_user'";
	$result_cartuser = mysqli_query( $dbconnect, $args_cartuser );
	
	
	$arrayid_pisah = explode('|',$id_jadi);
	$arrayid_jadi = count($arrayid_pisah);
	$arraycount_pisah = explode('|',$stock_jadi);
	$arraycount_jadi = count($arraycount_pisah);
	$arrayharga_pisah = explode('|',$harga_jadi);
	$arrayharga_jadi = count($arrayharga_pisah);
	$y = 0;
	while($y <= $jumlah_item) {
		$idproduk_transorder = $arrayid_pisah[$y];
		$count_transorder = $arraycount_pisah[$y];
		$harga_transorder = $arrayharga_pisah[$y];
		$type_transorder = 'out';
		$uptrans_order = "INSERT INTO trans_order ( id_pesanan, id_produk, jumlah, harga, type, date ) VALUES ( '$neworder_id', '$idproduk_transorder', '$count_transorder', '$harga_transorder', '$type_transorder', '$tgl_database' )";
		$result_trans_order = mysqli_query( $dbconnect, $uptrans_order );
		$y++;
	}
	
	$jawaban = array(
		"oke" => "1",
		"keterangan" => "berhasil",
		"orderbaru" => $neworder_id,
	);
	echo json_encode($jawaban);
}

// AMBIL DATA DB LOKASI KECAMATAN
if ( isset($_POST['lokasi_kecamatan']) && $_POST['lokasi_kecamatan']==MOBILE_FORM ) {
	$query = "SELECT * FROM inf_lokasi where lokasi_propinsi='34' and lokasi_kecamatan!=00 and lokasi_kelurahan=0 and lokasi_kabupatenkota='71' order by lokasi_nama";
	$result = mysqli_query( $dbconnect, $query );
	$lokasi = array();
	if ($result) {
		while ( $data_lokasi = mysqli_fetch_array($result) ) {
			$lokasi[] = array(
				"lokasi_ID" => $data_lokasi['lokasi_ID'],
				"lokasi_kode" => $data_lokasi['lokasi_kode'],
				"lokasi_nama" => $data_lokasi['lokasi_nama'],
				"lokasi_propinsi" => $data_lokasi['lokasi_propinsi'],
				"lokasi_kabupatenkota" => $data_lokasi['lokasi_kabupatenkota'],
				"lokasi_kecamatan" => $data_lokasi['lokasi_kecamatan'],
				"lokasi_kelurahan" => $data_lokasi['lokasi_kelurahan'],
			);
		}
		$oke = '1';
		$keterangan = "berhasil";
	} else {
		$oke = '0';
		$keterangan = "gagal";
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"lokasi" => $lokasi,
	);
	echo json_encode($jawaban);
}

// AMBIL DATA DB LOKASI KELURAHAN
if ( isset($_POST['lokasi_kelurahan']) && $_POST['lokasi_kelurahan']==MOBILE_FORM ) {
	$idkecamatan = secure_string($_POST['idkecamatan']);
	$query = "SELECT * FROM inf_lokasi where lokasi_propinsi = '34' and lokasi_kecamatan = '$idkecamatan' and lokasi_kelurahan != '0000' and lokasi_kabupatenkota = '71' order by lokasi_nama";
	$lokasi = array();
	$result = mysqli_query( $dbconnect, $query );
	if ($result) {
		while ( $data_lokasi = mysqli_fetch_array($result) ) {
			$lokasi[] = array(
				"lokasi_ID" => $data_lokasi['lokasi_ID'],
				"lokasi_kode" => $data_lokasi['lokasi_kode'],
				"lokasi_nama" => $data_lokasi['lokasi_nama'],
				"lokasi_propinsi" => $data_lokasi['lokasi_propinsi'],
				"lokasi_kabupatenkota" => $data_lokasi['lokasi_kabupatenkota'],
				"lokasi_kecamatan" => $data_lokasi['lokasi_kecamatan'],
				"lokasi_kelurahan" => $data_lokasi['lokasi_kelurahan'],
			);
		}
		$oke = '1';
		$keterangan = "berhasil";
	} else {
		$oke = '0';
		$keterangan = "gagal";
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"lokasi" => $lokasi,
	);
	echo json_encode($jawaban);
}

// ALAMAT KIRIM ORDER
if ( isset($_POST['kirimalamat']) && $_POST['kirimalamat']==MOBILE_FORM ) {
	$iduser = secure_string($_POST['iduser']);
	$alamat = secure_string($_POST['alamat']);
	$kecamatan = secure_string($_POST['kecamatan']);
	$kelurahan = secure_string($_POST['kelurahan']);
	$kota = secure_string($_POST['kota']);
	$catatan = secure_string($_POST['catatan']);
	$idorder = secure_string($_POST['idorder']);
	$slottime = secure_string($_POST['val_slot']);
	$picktime = secure_string($_POST['picktime']);
	$order_date = date_order($slottime,$picktime);
	$data_kecamatan = data_lokasi($kecamatan,'0000','lokasi_nama');
	$data_kelurahan = data_lokasi($kecamatan,$kelurahan,'lokasi_nama');
	$alamat_full = $alamat.' '.$data_kecamatan.' '.$data_kelurahan.' '.$kota;
	
	$args_pesanan = "UPDATE pesanan SET alamat_kirim='$alamat_full', waktu_kirim='$order_date' WHERE id='$idorder'";
	$args_alamat = "INSERT INTO alamat_order ( iduser, alamat, kelurahan, kecamatan, kota ) VALUES ( '$iduser', '$alamat', '$data_kecamatan', '$data_kelurahan', '$kota' )";
	$result_pesanan = mysqli_query( $dbconnect, $args_pesanan );
	$result_alamat = mysqli_query( $dbconnect, $args_alamat );
	if ($result_pesanan && $result_alamat) {
		$oke = '1';
		$keterangan = 'berhasil';
	} else {
		$oke = '0';
		$keterangan = 'gagal';
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
	);
	echo json_encode($jawaban);
}

// RIWAYAT ORDER
if ( isset($_POST['open_riwayat']) && $_POST['open_riwayat']==MOBILE_FORM ) {
	$user_id = secure_string($_POST['user_id']);
	
	$args="SELECT * FROM pesanan WHERE id_user='$user_id'";
    $result = mysqli_query( $dbconnect, $args );
	$riwayat = array();
	if ( $result ) {
		while ( $data_pesanan = mysqli_fetch_array($result) ) {
			$riwayat[] = array(
				"id_pesanan" => $data_pesanan['id'],
				"idproduk" => $data_pesanan['idproduk'],
				"sub_total" => $data_pesanan['sub_total'],
				"waktu_pesan" => $data_pesanan['waktu_pesan'],
				"waktu_kirim" => $data_pesanan['waktu_kirim'],
				"alamat_kirim" => $data_pesanan['alamat_kirim'],
				"status" => $data_pesanan['status'],
			);
		}
		$oke = '1';
		$keterangan = "berhasil";
	} else {
		$oke = '0';
		$keterangan = "gagal";
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"riwayat" => $riwayat,
	);
	echo json_encode($jawaban);
}

// NEW USER REGISTER
if ( isset($_POST['user_register']) && $_POST['user_register']==MOBILE_FORM ) {
	$telp = secure_string($_POST['telpsignup']);
	$password = secure_string($_POST['passsignup']);
	$peranuser = secure_string($_POST['peranuser']);
	$array_cart = secure_string($_POST['array_cart']);
	$password_db = md5($password.USER_PASS);
	$tgl_database = strtotime('now');
	
	// cari apakah ada telepon yang sama
	$args_email = "SELECT telp FROM user WHERE telp='$telp'";
	$cari_email = mysqli_query( $dbconnect, $args_email );
		if ( mysqli_num_rows($cari_email) ) {
			$oke = '3';
			$keterangan = "teleponsalah";
		} else {
			$adduser = "INSERT INTO user ( telp, password, user_role, tanggal_daftar, array_cart ) VALUES ( '$telp', '$password_db', '$peranuser', '$tgl_database', '$array_cart' )";
			$result = mysqli_query( $dbconnect, $adduser );
			if ($result){
				$newuserid = mysqli_insert_id($dbconnect);
				$argsdata = "SELECT * FROM user WHERE id='$newuserid'";
				$resultdata = mysqli_query( $dbconnect, $argsdata );
				$data_user = mysqli_fetch_array($resultdata);
				$oke = '1';
				$keterangan = "berhasil";
				$user_id = $data_user["id"];
				$user_nama = $data_user["nama"];
				$user_email = $data_user["email"];
				$user_telp = $data_user["telp"];
				$user_alamat = $data_user["alamat"];
				$user_tanggal_daftar = $data_user["tanggal_daftar"];
				$user_saldo = $data_user["saldo"];
				$array_cart = $data_user["array_cart"];
			} else {
				$oke = '0';
				$keterangan = "gagal";
				$user_id = '';
				$user_nama = '';
				$user_email = '';
				$user_telp = '';
				$user_alamat = '';
				$user_tanggal_daftar = '';
				$user_saldo = '';
				$array_cart = '';
			}
		}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"id" => $user_id,
		"nama" => $user_nama,
		"email" => $user_email,
		"telp" => $user_telp,
		"alamat" => $user_alamat,
		"tanggal_daftar" => $user_tanggal_daftar,
		"saldo" => $user_saldo,
		"array_cart" => $array_cart,
	);
	echo json_encode($jawaban);
}

// USER LOGIN
if ( isset($_POST['user_login']) && $_POST['user_login']==MOBILE_FORM ) {
	$telp = secure_string($_POST['telplogin']);
	$password = secure_string($_POST['passlogin']);
	$password_db = md5($password.USER_PASS);
	
	$args = "SELECT * FROM user WHERE telp='$telp' AND password='$password_db'";
	$result = mysqli_query( $dbconnect, $args );
	if ( mysqli_num_rows($result) ) {
		$data_user = mysqli_fetch_array($result);
		$oke = '1';
		$keterangan = "berhasil";
		$user_id = $data_user["id"];
		$user_nama = $data_user["nama"];
		$user_email = $data_user["email"];
		$user_telp = $data_user["telp"];
		$user_alamat = $data_user["alamat"];
		$user_tanggal_daftar = $data_user["tanggal_daftar"];
		$user_saldo = $data_user["saldo"];
		$array_cart = $data_user["array_cart"];
	} else {
		$oke = '0';
		$keterangan = "gagal";
		$user_id = '';
		$user_nama = '';
		$user_email = '';
		$user_telp = '';
		$user_alamat = '';
		$user_tanggal_daftar = '';
		$user_saldo = '';
		$array_cart = '';
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"id" => $user_id,
		"nama" => $user_nama,
		"email" => $user_email,
		"telp" => $user_telp,
		"alamat" => $user_alamat,
		"tanggal_daftar" => $user_tanggal_daftar,
		"saldo" => $user_saldo,
		"array_cart" => $array_cart,
	);
	echo json_encode($jawaban);
}

?>