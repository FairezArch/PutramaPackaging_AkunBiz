<?php require "functionv2.php";

// LIST KATEGORI HOME
if ( isset($_POST['get_kategori']) && $_POST['get_kategori']==MOBILE_FORM ) {
	$args="SELECT * FROM kategori WHERE id_master='0' order by urutan";
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
	
	//$subkategori = getsubkat($idkategori);
	$args_subkat="SELECT * FROM kategori WHERE id_master='$idkategori'";
	$result_subkat = mysqli_query( $dbconnect, $args_subkat );
	$subkat_array = array();
	
	$kategori_name = data_tabel($tabelname, $idkategori, 'kategori');
	$args="SELECT * FROM produk WHERE idkategori='$idkategori' ORDER BY id DESC";
    $result = mysqli_query( $dbconnect, $args );
	$jumlah = mysqli_num_rows($result);
	$produk = array();
	if ( $result && $result_subkat ) {
		while ( $data_subkat = mysqli_fetch_array($result_subkat) ) {
			$subkat_array[] = array(
				"id" => $data_subkat['id'],
				"subkat_name" => $data_subkat['kategori'],
			);
		};
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
		"subkategori" => $subkat_array,
	);
	echo json_encode($jawaban);
}

// LIST PRODUK PER SUB KATEGORI
if ( isset($_POST['goto_prodsubkat']) && $_POST['goto_prodsubkat']==MOBILE_FORM ) {
	$tabelname = secure_string($_POST['tabelname']);
	$idkategori = secure_string($_POST['id_kategori']);
	
	$kategori_name = data_tabel($tabelname, $idkategori, 'kategori');
	$args="SELECT * FROM produk WHERE idsubkategori='$idkategori' ORDER BY id DESC";
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
				$data_stock = all_stok_prod($arraydata[0],"stock_tersedia");
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
	$datasimpan = update_userCart_data($datasimpan);
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
			"title" => html_entity_decode($arraydata[1]),
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
	$datatest           = secure_string($_POST['product_array_cart']);
	$id_user            = secure_string($_POST['id_user']);
	$telp_user          = secure_string($_POST['telp_user']);
	$cart_total_harga   = secure_string($_POST['cart_total_harga']);
	$catatan            = secure_string($_POST['catatan']);
    $slottime           = secure_string($_POST['val_slot']);
	$picktime           = secure_string($_POST['picktime']);
	$pay_method         = secure_string($_POST['pay_method']);
	$metode_bayar       = secure_string($_POST['metode_bayar']);
	$tgl_database       = strtotime('now');
	$array_id           = array();
	$array_stock        = array();
	$array_harga        = array();
	$array_kode_item    = explode('!!!',$datatest);
	$jumlah_item        = count($array_kode_item) - 1;
	$order_date         = date_order($slottime,$picktime);
	$alamat_order       = secure_string($_POST['alamat_order']);
	$saldo_user         = secure_string($_POST['saldo_user']);
	$selisih            = secure_string($_POST['selisih']);
	$nama_user          = secure_string($_POST['nama_user']);
	$email_user         = secure_string($_POST['email_user']);
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
	$upstock = "INSERT INTO pesanan ( id_user, telp, idproduk, jml_order, harga_item, sub_total, total, alamat_kirim, waktu_pesan, waktu_kirim, metode_bayar, tipe_bayar) 
	                         VALUES ( '$id_user', '$telp_user', '$id_jadi', '$stock_jadi', '$harga_jadi', '$cart_total_harga', '$cart_total_harga','$alamat_order', '$tgl_database','$order_date','$metode_bayar','$pay_method' )";
	$result = mysqli_query( $dbconnect, $upstock );
	$neworder_id = mysqli_insert_id($dbconnect);
	$args_cartuser = "UPDATE user SET array_cart='' WHERE id='$id_user'";
	$result_cartuser = mysqli_query( $dbconnect, $args_cartuser );
    $id_pesanan = $neworder_id;
	if ( $metode_bayar == 'nonsaldo' ) {
	    
	    $args_reqsaldo = "INSERT INTO request_saldo (id_user,harga_awal,total_bayar,date_checkout,type,status,aktif,id_trans_saldo) VALUES ('$id_user','$cart_total_harga','$cart_total_harga','$tgl_database','pesanan','1','1','0')";
	    $result_reqsaldo  = mysqli_query ( $dbconnect, $args_reqsaldo );
	   if ( $pay_method == 'pay_debit' ) {
	       
	    $type_transsaldo = 'none';
	    $deskripsi_pesanan  = "Transaksi pesanan ID $neworder_id";
        $minussaldo = "INSERT INTO trans_saldo ( date, type, nominal, id_user, deskripsi ,id_pesanan) VALUES ( '$tgl_database', '$type_transsaldo', '$cart_total_harga', '$id_user', '$deskripsi_pesanan','$neworder_id' )";
	    $result_minussaldo = mysqli_query( $dbconnect, $minussaldo );
	   } else {
	       //kosong
	   }
	    
	} else {
	    
	    if ( $metode_bayar == 'sebagian' ) {
	        
	        // Kurangi Saldo dulu 
	        $type_transsaldo = 'minus';
	        $deskripsi_pesanan  = "Transaksi pesanan ID $neworder_id";
            $minussaldo = "INSERT INTO trans_saldo ( date, type, nominal, id_user, deskripsi ,id_pesanan) VALUES ( '$tgl_database', '$type_transsaldo', '$saldo_user', '$id_user', '$deskripsi_pesanan','$neworder_id' )";
	        $result_minussaldo = mysqli_query( $dbconnect, $minussaldo );
	        
	         if( $result_minussaldo ) {
	             $result_user_saldo = update_saldo_user($id_user);
	             $type_transsaldo = 'none';
	             $deskripsi_pesanan  = "Transaksi pesanan ID $neworder_id";
                 $args_saldo = "INSERT INTO trans_saldo ( date, type, nominal, id_user, deskripsi ,id_pesanan) VALUES ( '$tgl_database', '$type_transsaldo', '$selisih', '$id_user', '$deskripsi_pesanan','$neworder_id' )";
	             $result_saldo = mysqli_query( $dbconnect, $args_saldo );
	             
	             if( $result_saldo ) {
	                 $args_reqsaldo = "INSERT INTO request_saldo (id_user,harga_awal,total_bayar,date_checkout,type,status,aktif,id_trans_saldo) VALUES ('$id_user','$selisih','$selisih','$tgl_database','pesanan','1','1','0')";
	                 $result_reqsaldo  = mysqli_query ( $dbconnect, $args_reqsaldo );
	             }
	         }
	        
	    } else if ( $metode_bayar == 'saldo' ) {
	        $type_transsaldo = 'minus';
	        $deskripsi_pesanan  = "Transaksi pesanan ID $neworder_id";
            $minussaldo = "INSERT INTO trans_saldo ( date, type, nominal, id_user, deskripsi ,id_pesanan) VALUES ( '$tgl_database', '$type_transsaldo', '$saldo_user', '$id_user', '$deskripsi_pesanan','$neworder_id' )";
	        $result_minussaldo = mysqli_query( $dbconnect, $minussaldo );
	        $result_user_saldo = update_saldo_user($id_user);
	        
	    }
	}
	
	
	// INPUT TRANS ORDER
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
	
	
	//$total_saldo_user = total_saldo_userid($id_user);
	//$result_user_saldo = update_saldo_user($id_user);
	
	if ( $result && $result_cartuser && $result_trans_order ) {
		$oke = "1";
		$keterangan = "berhasil";
	} else {
		$oke = "0";
		$keterangan = "gagal";
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"orderbaru" => $neworder_id,
		//"total_saldo" => $total_saldo_user,
	);
	echo json_encode($jawaban);
}

// AMBIL DATA DB LOKASI KECAMATAN
if ( isset($_POST['lokasi_kecamatan']) && $_POST['lokasi_kecamatan']==MOBILE_FORM ) {
    $idkota = secure_string($_POST['idkota']);
	$query = "SELECT * FROM inf_lokasi where lokasi_propinsi='34' and lokasi_kecamatan!=00 and lokasi_kelurahan=0 and lokasi_kabupatenkota = '$idkota' order by lokasi_nama";
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
	$idkota = secure_string($_POST['idkota']);
	$idkecamatan = secure_string($_POST['idkecamatan']);
	$query = "SELECT * FROM inf_lokasi where lokasi_propinsi = '34' and lokasi_kecamatan = '$idkecamatan' and lokasi_kelurahan != '0000' and lokasi_kabupatenkota = '$idkota' order by lokasi_nama";
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

// SET WAKTU KIRIM
if ( isset($_POST['waktukirim']) && $_POST['waktukirim']==MOBILE_FORM ) {
	//echo '<option value="00" '.auto_hide('00').'>00:00 WIB sd 02:00 WIB</option>';
	$hasil = '<option value="00" '.auto_hide('00').'>00:00 WIB sd 02:00 WIB</option>';
	for ($n = 0; $n <= 10; $n++) {
		$num = $n * 2 + 2;
		$valnum = $num + 2;
		$num_padded = sprintf("%02d", $num);
		$valnum_padded = sprintf("%02d", $valnum);
			$hasil .= '<option value="'.$num_padded.'" '.auto_hide($num_padded).'>'.$num_padded.':00 WIB sd '.$valnum_padded.':00 WIB </option>';
	}
	$jawaban = array(
		"oke" => "1",
		"keterangan" => "berhasil",
		"hasil" => $hasil,
	);
	echo json_encode($jawaban);

}

// ALAMAT KIRIM Alamat ORDER
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
	
	$nama_user = secure_string($_POST['nama_user']);
	$email_user = secure_string($_POST['email_user']);
	$telp_user= secure_string($_POST['telp_user']);
	$saldo_user = secure_string($_POST['saldo_user']);
	$totalharga = secure_string($_POST['totalharga']);
	$idpesanan = secure_string($_POST['idpesanan']);
	
	$order_date = date_order($slottime,$picktime);
	
	$data_kota = data_lokasi($kota,'00','0000','lokasi_nama');
	$data_kecamatan = data_lokasi($kota,$kecamatan,'0000','lokasi_nama');
	$data_kelurahan = data_lokasi($kota,$kecamatan,$kelurahan,'lokasi_nama');
	$alamat_full = $alamat.' '.$data_kecamatan.' '.$data_kelurahan.' '.$data_kota;
	
	$args_pesanan = "UPDATE pesanan SET alamat_kirim='$alamat_full', waktu_kirim='$order_date', catatan='$catatan' WHERE id='$idorder'";
	$args_alamat = "INSERT INTO alamat_order ( iduser, alamat, kelurahan, kecamatan, kota ) VALUES ( '$iduser', '$alamat', '$data_kecamatan', '$data_kelurahan', '$data_kota' )";
	$result_pesanan = mysqli_query( $dbconnect, $args_pesanan );
	$result_alamat = mysqli_query( $dbconnect, $args_alamat );
	
	$send_email = kirim_email_order($nama_user, $email_user, $telp_user, $iduser, $saldo_user, $idpesanan, $totalharga, $alamat_full, $order_date, $order_date);
	
	
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
	$user_id    = secure_string($_POST['user_id']);
	$status     = secure_string($_POST['status']);
	$idpesanan  = secure_string($_POST['idpesanan']);
    $batal      = auto_pesanan_batal($user_id);
    
	    if( $status != "" ){
	       if ( $status  == '60') {
	           $stat ="aktif ='0' AND";
	       } else {$stat ="status ='$status' AND aktif='1' AND";}
	    } else {$stat = "";}
	    if ( $idpesanan != '' ) {
	        $idpesan = "id ='$idpesanan' AND ";
	    } else {
	        $idpesan = "";
	    }
	
	$args="SELECT * FROM pesanan WHERE id_user='$user_id'";
    $result = mysqli_query( $dbconnect, $args );
	$riwayat = array();
	$jumlah = mysqli_num_rows($result);
	if ( $result ) {
		while ( $data_pesanan = mysqli_fetch_array($result) ) {
		    
		    $idpesanan = $data_pesanan['id'];
		    
		    //cek Bayar apa belum
		    $args_pembayaran = "SELECT * FROM konfirmasi_saldo where id_reqsaldo='$idpesanan'";
	        $result_pembayaran = mysqli_query( $dbconnect,$args_pembayaran );
	        if( $result_pembayaran ) {
	            $pembayaran = mysqli_num_rows($result_pembayaran);
	      
	            if( $pembayaran > 0 ) { //Jika Sudah dibayar
	                 $dibayar = "1";
	            } else { // Jika Belum dibayar
	                $dibayar = "0";
	            }
	            
	        }
	        
	        
		    $id_alamat = $data_pesanan['alamat_kirim'];
		     $args_carialamat = "SELECT * FROM alamat_order where id='$id_alamat'";
		     $result_cari = mysqli_query( $dbconnect, $args_carialamat);
		     if( $result_cari ) {
		         $data_cari = mysqli_fetch_array($result_cari);
		         $alamat    = $data_cari['alamat'];
		         $kota      = data_lokasi($data_cari['kota'],"00","0000","lokasi_nama");
                 $kelurahan = data_lokasi($data_cari['kota'],$data_cari['kecamatan'],$data_cari['kelurahan'],"lokasi_nama");
                 $kecamatan = data_lokasi($data_cari['kota'],$data_cari['kecamatan'],"0000","lokasi_nama");
                 $alamat_kirim = $alamat.', '.$kelurahan.', '.$kecamatan.', '.$kota;
		     } else {
		         $alamat    = "";
		         $kota      = "";
                 $kelurahan = "";
                 $kecamatan = "";
                 $alamat_kirim = $alamat.', '.$kelurahan.', '.$kecamatan.', '.$kota;
		     }
			$riwayat[] = array(
				"id_pesanan" => $data_pesanan['id'],
				"idproduk" => $data_pesanan['idproduk'],
				"sub_total" => $data_pesanan['sub_total'],
				"waktu_pesan" => date('d M Y, H.i', $data_pesanan['waktu_pesan']),
				"waktu_kirim" => show_datesendorder($data_pesanan['waktu_kirim'],'notspace'),
				"alamat_kirim" => $alamat_kirim,
				"status" => $data_pesanan['status'],
				"status_bayar" => $dibayar
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
		"jumlah" => $jumlah,
	);
	echo json_encode($jawaban);
}

// DETIL RIWAYAT ORDER
if ( isset($_POST['detil_riwayatorder']) && $_POST['detil_riwayatorder']==MOBILE_FORM ) {
	$idpesanan = secure_string($_POST['idpesanan']);
	$args="SELECT * FROM pesanan WHERE id='$idpesanan'";
    $result = mysqli_query( $dbconnect, $args );
	$riwayat = array();
	$jumlah = mysqli_num_rows($result);
	if ( $result ) {
		while ( $data_pesanan = mysqli_fetch_array($result) ) {
		    $idpesanan = $data_pesanan['id'];
		    $idproduk=$data_pesanan['idproduk'];
            $jumlah_order=$data_pesanan['jml_order'];
            $idproduk   = explode("|",$idproduk);
            $jumlah_order  = explode("|",$jumlah_order);
            $jumlah_idproduk = count($idproduk)-1;
            $x = 0;
            $produk = array();
            while($x <= $jumlah_idproduk){
                $idproduk_tampil = $idproduk[$x];
                $jml_order_tampil= $jumlah_order[$x];
                $args_produk="SELECT * FROM produk WHERE id='$idproduk_tampil'";
                $result_produk=mysqli_query($dbconnect, $args_produk);
                if($result_produk){
                  $data_produk=mysqli_fetch_array($result_produk);
                  $produk[]=array(
                    "idproduk" => $data_produk['id'],
                    "nama" => $data_produk['title'],
                    "harga" => $data_produk['harga'],
                    "gambar" => $data_produk['image'],
                    "jumlah" => $jml_order_tampil
                  );
                }$x++;
            }
            
		    //cek Bayar apa belum
		    $args_pembayaran = "SELECT * FROM konfirmasi_saldo where id_reqsaldo='$idpesanan'";
	        $result_pembayaran = mysqli_query( $dbconnect,$args_pembayaran );
	        if( $result_pembayaran ) {
	            $pembayaran = mysqli_num_rows($result_pembayaran);
	      
	            if( $pembayaran > 0 ) { //Jika Sudah dibayar
	                 $dibayar = "1";
	            } else { // Jika Belum dibayar
	                $dibayar = "0";
	            }
	            
	        }
	        
	        
		    $id_alamat = $data_pesanan['alamat_kirim'];
		     $args_carialamat = "SELECT * FROM alamat_order where id='$id_alamat'";
		     $result_cari = mysqli_query( $dbconnect, $args_carialamat);
		     if( $result_cari ) {
		         $data_cari = mysqli_fetch_array($result_cari);
		         $alamat    = $data_cari['alamat'];
		         $kota      = data_lokasi($data_cari['kota'],"00","0000","lokasi_nama");
                 $kelurahan = data_lokasi($data_cari['kota'],$data_cari['kecamatan'],$data_cari['kelurahan'],"lokasi_nama");
                 $kecamatan = data_lokasi($data_cari['kota'],$data_cari['kecamatan'],"0000","lokasi_nama");
                 $alamat_kirim = $alamat.', '.$kelurahan.', '.$kecamatan.', '.$kota;
		     } else {
		         $alamat    = "";
		         $kota      = "";
                 $kelurahan = "";
                 $kecamatan = "";
                 $alamat_kirim = $alamat.', '.$kelurahan.', '.$kecamatan.', '.$kota;
		     }
			$riwayat[] = array(
				"id_pesanan" => $data_pesanan['id'],
				"sub_total" => $data_pesanan['sub_total'],
				"waktu_pesan" => date('d M Y, H.i', $data_pesanan['waktu_pesan']),
				"waktu_kirim" => show_datesendorder($data_pesanan['waktu_kirim'],'notspace'),
				"alamat_kirim" => $alamat_kirim,
				"status" => $data_pesanan['status'],
				"status_bayar" => $dibayar
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
		"produk" =>$produk,
		"jumlah" => $jumlah,
	);
	echo json_encode($jawaban);
}

// TOP UP SALDO CREDIT CARD
if ( isset($_POST['result_topup']) && $_POST['result_topup']==MOBILE_FORM ) {
	$id_user = secure_string($_POST['id_user']);
	$idorder = secure_string($_POST['idorder']);
	$action = secure_string($_POST['action']);
//	$nominal = secure_string($_POST['saldo_topup']);
	$date = secure_string($_POST['date_topup']);
	
	$date_db = strtotime($date);
	if( $action == 'payment' ) {
	    $type = 'none';
	} else {
	    $type = "plus";
	}
	
	$deskripsi = "Transaksi pesanan ID ".$id_user;
	$args = "INSERT INTO trans_saldo ( date, type, nominal, id_user, deskripsi ,id_pesanan) VALUES ( '$date_db', '$type', '', '$id_user', '$deskripsi' ,'$idorder')";
	$update = mysqli_query( $dbconnect, $args );
	//$result_user_saldo = update_saldo_user($id_user);
	//$total_saldo_user = total_saldo_userid($id_user);
	if ($update) {
		$oke = '1';
		$keterangan = 'berhasil';
	} else {
		$oke = '0';
		$keterangan = 'gagal';
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"total_saldo_user" => $total_saldo_user,
	);
	echo json_encode($jawaban);
	
}

// TOP UP SALDO ATM / BANK
if ( isset($_POST['topup_debit']) && $_POST['topup_debit']==MOBILE_FORM ) {
  
	$iduser = secure_string($_POST['user_id']);
	$namauser = querydata_user($iduser,'nama');
	$emailuser = querydata_user($iduser,'email');
	$email_admin = value_dataoption('sendmail_admin');
	$nominal = secure_string($_POST['nominal_topup']);
    $date_db = strtotime('now');
    $ipp = $_SERVER['REMOTE_ADDR'];
	$emailautosend = 'autosend@ideasmart.id';
	
	// Cek data Request saldo di db
    $args_cek = "SELECT id FROM request_saldo WHERE id_user='$iduser' AND status='0'";
    $result_cek = mysqli_query( $dbconnect, $args_cek );
    if ($result_cek){
        $args_del = "DELETE FROM request_saldo WHERE id_user='$iduser' AND status='0'";
        $result_del = mysqli_query( $dbconnect, $args_del );
    }
    
    // Insert Request Saldo Baru
    $args = "INSERT INTO request_saldo ( id_user, harga_awal, date_checkout ) VALUES ( '$iduser', '$nominal', '$date_db' )";
    $insert = mysqli_query( $dbconnect, $args );
    $idreq = mysqli_insert_id($dbconnect);
    
    // Create Harga Unix
    $last = (int) substr($idreq, -2);
	if ( $last >= 200 ) { $last = (int) substr($idreq, -2); }
	$totalbayar = $last + $nominal;
    
    //update total bayar
	$update = "UPDATE request_saldo SET total_bayar = '$totalbayar', kode_unik = '$last' WHERE id = '$idreq'";
	$result_update = mysqli_query( $dbconnect, $update );
	
	//$query_saldo = query_reqsaldo($iduser);
$textmail = "
------------------------------------------
DATA PENGGUNA
------------------------------------------
User ID: ".$iduser."
Nama User: ".$namauser."
Email User: ".$emailuser."
------------------------------------------
REQUEST TOP UP SALDO
------------------------------------------
Tanggal Request: ".date('d M Y, H.i',$date_db)."
Nominal Top Up Saldo: Rp ".format_angka( $nominal )."
------------------------------------------
IP Anda: ".$ipp;
$subjectmail = 'Notifikasi Request Top Up-User ID '.$iduser;

$theheader = "From: ".$emailautosend." \r\n";
$theheader .= "X-Sender: ".$emailautosend."\r\n";
$theheader.= "Reply-To: ".$emailuser." \r\n";
$theheader .= "Organization: Sender Organization\r\n";
$theheader .= "MIME-Version: 1.0\r\n";
$theheader .= "Content-type: text/plain; charset=iso-8859-1\r\n";
$theheader .= "X-Priority: 1\r\n";
$theheader .= "X-Mailer: PHP\r\n";
		
// sendmail
$sendmail = mail( $email_admin, $subjectmail, $textmail, $theheader );
	
	if ( $insert && $result_update && $sendmail ) {
	     $args_aa = "SELECT * FROM request_saldo WHERE id_user='$iduser' AND status='0'";
         $result = mysqli_query( $dbconnect, $args_aa );
            if ( $data_reqsaldo = mysqli_fetch_array($result) ) {
                //$data_reqsaldo = mysqli_fetch_array($result);
		        $idreq = $data_reqsaldo['id'];
		        $iduser = $data_reqsaldo['id_user'];
		        $harga_awal = $data_reqsaldo['harga_awal'];
		        $total_bayar = $data_reqsaldo['total_bayar'];
		        $date_checkout = $data_reqsaldo['date_checkout'];
		        $status = $data_reqsaldo['status'];
		        $aktif = $data_reqsaldo['aktif'];
		        $id_trans_saldo = $data_reqsaldo['id_trans_saldo'];
		        $kode_unik = $data_reqsaldo['kode_unik'];
		
	        } else {
		        $idreq = '';
		        $iduser = '';
		        $harga_awal = '';
		        $total_bayar = '';
		        $date_checkout = '';
		        $status = '';
		        $aktif = '';
		        $id_trans_saldo = '';
		        $kode_unik = '';
	        }
	    
	    $oke = '1';
		$keterangan = 'berhasil';
	} else {
		$oke = '0';
		$keterangan = 'gagal';
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"total_bayar" => $totalbayar,
		"angka_unik" => $last,
		"id_reqsaldo" => $idreq,
		"harga_awal" => $harga_awal,
		"status" => $status,
		"aktif" => $aktif,
		"id_trans_saldo" => $id_trans_saldo,
		"date_checkout" => $date_checkout,
		"id_user" => $iduser,
		
	);
	echo json_encode($jawaban);
	
}

// cek userr reqsaldo
if ( isset($_POST['cek_reqsaldo']) && $_POST['cek_reqsaldo']==MOBILE_FORM ) {
    $iduser = secure_string($_POST['user_id']);
    
    $args = "SELECT * FROM request_saldo WHERE id_user='$iduser' AND status='0'";
    $result = mysqli_query( $dbconnect, $args );
    if ( $result ) {
        $data_reqsaldo = mysqli_fetch_array($result);
	    $oke = '1';
		$keterangan = 'berhasil';
		$idreq = $data_reqsaldo['id'];
		$iduser = $data_reqsaldo['id_user'];
		$harga_awal = $data_reqsaldo['harga_awal'];
		$total_bayar = $data_reqsaldo['total_bayar'];
		$date_checkout = $data_reqsaldo['date_checkout'];
		$status = $data_reqsaldo['status'];
		$aktif = $data_reqsaldo['aktif'];
		$id_trans_saldo = $data_reqsaldo['id_trans_saldo'];
		$kode_unik = $data_reqsaldo['kode_unik'];
		
	} else {
		$oke = '0';
		$keterangan = 'gagal';
		$idreq = '';
		$iduser = '';
		$harga_awal = '';
		$total_bayar = '';
		$date_checkout = '';
		$status = '';
		$aktif = '';
		$id_trans_saldo = '';
		$kode_unik = '';
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"idreq" => $idreq,
		"id_user" => $iduser,
		"harga_awal" => $harga_awal,
		"total_bayar" => $total_bayar,
		"date_checkout" => $date_checkout,
		"status" => $status,
		"aktif" => $aktif,
		"id_trans_saldo" => $id_trans_saldo,
		"kode_unik" => $kode_unik,
	);
	echo json_encode($jawaban);
}

// Hapus Request Saldo User
if ( isset($_POST['del_reqsaldo']) && $_POST['del_reqsaldo']==MOBILE_FORM ) {	
	$idreqsaldo = secure_string($_POST['id_reqsaldo']);

    $args_del = "DELETE FROM request_saldo WHERE id='$idreqsaldo'";
    $result_del = mysqli_query( $dbconnect, $args_del );
    
	if ( $result_del ) {
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

// TOP UP SALDO ATM / BANK
if ( isset($_POST['konfirmtrans']) && $_POST['konfirmtrans']==MOBILE_FORM ) {
    $id_user = secure_string($_POST['id_user']);
    $nama_user = secure_string($_POST['nama_user']);
    $email_user = secure_string($_POST['email_user']);
	$id_pembelian = secure_string($_POST['id_pembelian']);
	$tanggal_trans = proses_tanggal($_POST['tanggal_trans']);
	$tanggal_db = strtotime($tanggal_trans.' 01:00');
	$uang_trans = secure_string($_POST['uang_trans']);
	//$nominal_trans = secure_string($_POST['nominal_trans']);
	$norek_user = secure_string($_POST['norek_user']);
	$bankuser_user = secure_string($_POST['bankuser_user']);
	$namarek_user = secure_string($_POST['namarek_user']);
	$idsm_rek = secure_string($_POST['idsm_rek']);
	$ipp = $_SERVER['REMOTE_ADDR'];
	
	$emailautosend = 'autosend@ideasmart.id';
	$email_admin = value_dataoption('sendmail_admin');
	
	$args = "INSERT INTO konfirmasi_saldo ( tanggal, uang_saldo, uang_tf, rekuser, bankuser, namauser, rekideasmart, iduser, id_reqsaldo ) VALUES ( '$tanggal_db', '$nominal_trans', '$uang_trans', '$norek_user', '$bankuser_user', '$namarek_user', '$idsm_rek', '$id_user', '$id_pembelian')";
    $result = mysqli_query( $dbconnect, $args );
    
    
    
$textmail = "
------------------------------------------
DATA PENGGUNA
------------------------------------------
User ID: ".$id_user."
Nama User: ".$nama_user."
Email User: ".$email_user."

------------------------------------------
TRANSFER PEMBELIAN
------------------------------------------
Tanggal Transfer: ".$tanggal_trans."
Jumlah Uang: Rp ".format_angka( $uang_trans )."
------------------------------------------
DATA REKENING
------------------------------------------
Nomor Rekening: ".$norek_user."
Bank: ".$bankuser_user."
Atas Nama: ".$namarek_user."
Menuju ke rekening IdeaSmart di: ".$idsm_rek."

------------------------------------------
IP Anda: ".$ipp;
$subjectmail = 'Notifikasi Pembayaran Produk User ID '.$id_user;

    /*$email_tujuan ='vista@gravis-design.com';
    require_once('../mesin/mailer/class.phpmailer.php');
    $mail = new PHPMailer;
    $mail->setFrom($emailautosend, $emailautosend );
    $mail->addReplyTo( $email_tujuan, $email_tujuan );
    $mail->addAddress( $email_tujuan, $email_tujuan );
    $mail->Subject = $subjectmail;
    $mail->Body = $textmail;*/
    
    
$theheader = "From: ".$emailautosend." \r\n";
$theheader .= "X-Sender: ".$emailautosend."\r\n";
$theheader.= "Reply-To: ".$email_user." \r\n";
$theheader .= "Organization: Sender Organization\r\n";
$theheader .= "MIME-Version: 1.0\r\n";
$theheader .= "Content-type: text/plain; charset=iso-8859-1\r\n";
$theheader .= "X-Priority: 1\r\n";
$theheader .= "X-Mailer: PHP\r\n";
		
// sendmail
$sendmail = mail( $email_admin, $subjectmail, $textmail, $theheader );
//$sendmail = mail( 'wachid@gravis-design.com', $subjectmail, $textmail, $theheader );

	if ( $result && $sendmail /*$mail->send()*/) {
	    $oke = '1';
		$keterangan = 'berhasil';
	//	$keterangan_email = 'sukses';
	} else { 	
	    $oke = '0';
		$keterangan = 'gagal';
		//$keterangan_email = $mail->ErrorInfo."||";
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		//"keterangan_email" => $keterangan_email
	);
	echo json_encode($jawaban);
	
}


// EDIT PROFIL
if ( isset($_POST['save_detilakun']) && $_POST['save_detilakun']==MOBILE_FORM ) {
	$iduser = secure_string($_POST['iduser']);
	$nama = secure_string($_POST['nama']);
	$email = secure_string($_POST['email']);
	$telp = secure_string($_POST['telp']);
	
	$args = "UPDATE user SET nama='$nama', email='$email', telp='$telp' WHERE id='$iduser'";
	$result = mysqli_query( $dbconnect, $args );
	if ($result) {
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

if ( isset($_POST['getdataorder']) && $_POST['getdataorder']==MOBILE_FORM ) {
	$idpesanan = secure_string($_POST['idorder']);
	$args="SELECT * FROM trans_order WHERE id_pesanan='$idpesanan'";
    $result = mysqli_query( $dbconnect, $args );
	$pesanan = array();
	if ( $result ) {
		while ( $data_pesanan = mysqli_fetch_array($result) ) {
			$pesanan[] = array(
				"id" => $data_pesanan['id'],
				"id_produk" => $data_pesanan['id_produk'],
				"jumlah" => $data_pesanan['jumlah'],
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
	$nama = secure_string($_POST['namasignup']);
	$email = secure_string($_POST['emailsignup']);
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
			$adduser = "INSERT INTO user ( nama, email, telp, password, user_role, tanggal_daftar, array_cart ) VALUES ( '$nama', '$email', '$telp', '$password_db', '$peranuser', '$tgl_database', '$array_cart' )";
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

// DATA LOGIN
if ( isset($_POST['is_login']) && $_POST['is_login']==MOBILE_FORM ) {
	$user_id = secure_string($_POST['user_id']);
	
	$args="SELECT * FROM user WHERE id='$user_id'";
	$result = mysqli_query( $dbconnect, $args );
    if ( $data_user = mysqli_fetch_array($result) ) {
		$oke = '1';
		$keterangan = "berhasil";
		$user_nama = $data_user["nama"];
		$user_email = $data_user["email"];
		$user_telp = $data_user["telp"];
		$user_tanggal_daftar = $data_user["tanggal_daftar"];
		$user_saldo = $data_user["saldo"];
		$array_cart = $data_user["array_cart"];
	} else {
		$oke = '0';
		$keterangan = "gagal";
		$user_nama = '';
		$user_email = '';
		$user_telp = '';
		$user_tanggal_daftar = '';
		$user_saldo = '';
		$array_cart = '';
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"nama" => $user_nama,
		"email" => $user_email,
		"telp" => $user_telp,
		"tanggal_daftar" => $user_tanggal_daftar,
		"saldo" => $user_saldo,
		"array_cart" => $array_cart,
	);
	echo json_encode($jawaban);
}

//Abot Us
if ( isset($_POST['data_tab']) && $_POST['data_tab'] ==MOBILE_FORM ) {
       
    $args ="SELECT * FROM dataoption ORDER BY urutan";
    $result = mysqli_query( $dbconnect,$args );
    $hasil = array();
    if ($result == 1) {
        while( $data_about = mysqli_fetch_array($result) ) {
            $hasil[] = array(
                "optname" => $data_about['optname'],
                "optvalue" => $data_about['optvalue'],
                );
        }
        $oke       = '1';
        $keterangan = 'berhasil';
    } else {
        $oke     = '0';
        $keterangan = 'gagal';
        $optname = '';
        $optvalue = '';
    }
 
    
    $jawaban = array(
        "oke" => $oke,
        "keterangan" => $keterangan,
        "hasil" => $hasil,
    );
    echo json_encode($jawaban);
} 



//AMBIL ALAMAT ORDER USER

if ( isset($_POST['ambilalamat_user']) && $_POST['ambilalamat_user']==MOBILE_FORM ) {
    $iduser = secure_string($_POST['iduser']);
    
    $args = "SELECT * FROM alamat_order where iduser='$iduser'";
    $result = mysqli_query( $dbconnect, $args);
    $alamat_order = array();
      if($result){
          while( $data = mysqli_fetch_array($result) ) {
            $kota      = data_lokasi($data['kota'],"00","0000","lokasi_nama");
            $kelurahan = data_lokasi($data['kota'],$data['kecamatan'],$data['kelurahan'],"lokasi_nama");
            $kecamatan = data_lokasi($data['kota'],$data['kecamatan'],"0000","lokasi_nama");
            
            $lokasi_id  = $data['kota'].'_'.$data['kecamatan'].'_'.$data['kelurahan'];
            $alamat_order[] = array(
            "idalamat" => $data['id'],
            "lokasi_id" => $lokasi_id,
            "alamat" =>  $data['alamat'],
            "kelurahan" => $kelurahan,
            "kecamatan" => $kecamatan,
            "kota" => $kota,
            "main_addrs" => $data['main_address']
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
		"alamat_order" => $alamat_order
	);
	echo json_encode($jawaban);
        
}

//Simpan Alamat Order User
if ( isset($_POST['simpanalamatorder']) && $_POST['simpanalamatorder']==MOBILE_FORM ) {
    $iduser         = secure_string( $_POST['iduser'] );
    $alamat         = secure_string( $_POST['alamat'] );
    $kecamatan      = secure_string( $_POST['kecamatan'] );
    $kelurahan      = secure_string( $_POST['kelurahan'] );
    $kota           = secure_string( $_POST['kota'] );
    $alamatdefault  = secure_string( $_POST['alamatdefault'] );
        
       // Cari Jumlah Alamat 
       $jumlah_alamat  = get_addressorder($iduser);
         
         //Jika Alamat Lebih dari satu maka Update alamatdefault
         if($jumlah_alamat >= '0') {
             
               if ( $alamatdefault == 'Ya' ) {
                    $args_simpanalamat =  "INSERT INTO alamat_order (iduser,alamat,kelurahan,kecamatan,kota) VALUES ('$iduser','$alamat','$kelurahan','$kecamatan','$kota')";
                    $result_simpanalamat = mysqli_query( $dbconnect, $args_simpanalamat);
                        if($result_simpanalamat) {
                            
                            $idalamat = mysqli_insert_id ( $dbconnect );
                            
                            $args_resetdefault  = "UPDATE alamat_order set main_address='Tidak' where iduser='$iduser'";
                            $args_setdefault    = "UPDATE alamat_order set main_address='$alamatdefault' WHERE iduser='$iduser' AND id='$idalamat'";
                    
                            $result_reset = mysqli_query( $dbconnect, $args_resetdefault);
                                if( $result_reset ) {
                                    $result_set = mysqli_query ( $dbconnect, $args_setdefault);
                                    if( $result_set ) {
                             
                                    $oke = '1';
                                    $keterangan = 'berhasil';
                             
                                    } else {
                                        $oke = '0';
                                        $keterangan = 'gagal';
                                    }
                                    
                                } else {
                                        $oke = '0';
                                        $keterangan = 'gagal';
                                    }
                        }else {
                       $oke = '0';
                      $keterangan = mysqli_error($dbconnect);
                      }
                    
               } else {
                    $args_simpanalamat =  "INSERT INTO alamat_order (iduser,alamat,kelurahan,kecamatan,kota,main_address) VALUES ('$iduser','$alamat','$kelurahan','$kecamatan','$kota','$alamatdefault')";
                    $result_simpanalamat = mysqli_query( $dbconnect, $args_simpanalamat);
                    
                    if ( $result_simpanalamat ) {
                         $oke = '1';
                         $keterangan = 'berhasil';
                    } else {
                       $oke = '0';
                      $keterangan = mysqli_error($dbconnect);
                      }
                     
               }
               
         } else {
             
    $args_simpanalamat =  "INSERT INTO alamat_order (iduser,alamat,kelurahan,kecamatan,kota,main_address) VALUES ('$iduser', '$kelurahan', '$kecamatan', '$kota', '$alamatdefault')";
             $result_simpanalamat = mysqli_query( $dbconnect, $args_simpanalamat);
             
             if ( $result_simpanalamat ) {
                         $oke = '1';
                         $keterangan = 'berhasil';
               }
               else {
                       $oke = '0';
                      $keterangan = mysqli_error($dbconnect);
                      }
             
         }
         
         $jawaban = array(
		    "oke" => $oke,
		    "keterangan" => $keterangan
    	);
	    echo json_encode($jawaban);
         
}

//Hapus Alamat order
if( isset($_POST['deletealamatorder']) && $_POST['deletealamatorder']==MOBILE_FORM ) {
    $iduser     = secure_string($_POST['iduser']);
    $idalamat   = secure_string($_POST['idalamat']);
       
       //cek alamat apakah alamat main 
       $args = "SELECT * FROM alamat_order where iduser ='$iduser' AND id ='$idalamat'";
       $result = mysqli_query( $dbconnect, $args );
       $data= mysqli_fetch_array($result);
       
       // Jika Iya
       if( $data['main_address'] == 'Ya' ) {
           $args_delete = "DELETE FROM alamat_order where iduser='$iduser' AND id='$idalamat'";
           $result_delete = mysqli_query( $dbconnect, $args_delete );
            if ( $result_delete ) {
                $jumlah_alamat  = get_addressorder($iduser);
                $offset = $jumlah_alamat - 1;
                if( $jumlah_alamat > 0) {
                    $args_alamat = "SELECT * FROM alamat_order where iduser='$iduser' LIMIT 1 OFFSET $offset";
                    $result_alamat = mysqli_query( $dbconnect, $args_alamat );
                    $data_alamat = mysqli_fetch_array($result_alamat);
                    $id_alamat = $data_alamat['id'];
                    
                    $update_alamat_default  = "UPDATE alamat_order set main_address ='Ya' WHERE id='$id_alamat'";
                    $result_update = mysqli_query( $dbconnect, $update_alamat_default );
                    
                        if( $result_update ) {
                            $oke = '1';
                            $keterangan = 'berhasil';
                        } else {
                            $oke = '0';
                            $keterangan = 'gagal Update';
                        }
    
                    
                } else {
                    
                    //Tidak ada aksi
                    $oke = '1';
                    $keterangan = 'berhasil';
                    
                }
                
                
            } else {
                
                $oke = '0';
                $keterangan = 'gagal Delete';
                
            }
            
       } else { // Jika Tidak
           
           $args_delete = "DELETE FROM alamat_order where iduser='$iduser' AND id='$idalamat'";
           $result_delete = mysqli_query( $dbconnect, $args_delete );
                
                if( $result_delete ) {
                     $oke = '1';
                     $keterangan = 'berhasil';
                } else {
                     $oke = '0';
                     $keterangan = 'gagal Delete';
                }
           
       }
       
        $jawaban = array(
		    "oke" => $oke,
		    "keterangan" => $keterangan
    	);
	    echo json_encode($jawaban);
       
    
}

//Set Default Alamat Order User

if( isset($_POST['setdefaultaddress']) && $_POST['setdefaultaddress'] ==MOBILE_FORM ) {
    $iduser = secure_string($_POST['iduser']);
    $idalamat = secure_string($_POST['idalamat']);
     
        $args_resetdefault  = "UPDATE alamat_order set main_address='Tidak' where iduser='$iduser'";
        $args_setdefault    = "UPDATE alamat_order set main_address='Ya' WHERE iduser='$iduser' AND id='$idalamat'";
                    
            $result_reset = mysqli_query( $dbconnect, $args_resetdefault);
            if( $result_reset ) {
                 $result_set = mysqli_query ( $dbconnect, $args_setdefault);
                        if( $result_set ) {
                             
                            $oke = '1';
                            $keterangan = 'berhasil';
                             
                        } else {
                            $oke = '0';
                            $keterangan = 'gagal';
                        }
                                    
            } else {
                $oke = '0';
                $keterangan = 'gagal';
            }
            $jawaban = array(
		    "oke" => $oke,
		    "keterangan" => $keterangan
    	);
	    echo json_encode($jawaban);
}

// Ambil Waktu

if( isset($_POST['taketime']) && $_POST['taketime'] ==MOBILE_FORM ) {
    
    $idorder = secure_string($_POST['idorder']);
    $iduser = secure_string($_POST['iduser']);
    
    $args = "SELECT waktu_pesan  FROM pesanan where id_user ='$iduser' AND id='$idorder'";
    $result = mysqli_query( $dbconnect, $args);
     
      if( $result ) {
          
          $data = mysqli_fetch_array( $result );
          
          $ambil_waktu = value_dataoption("waktu_countdown"); // 1
          $waktu_total = $ambil_waktu * 3600;
          $waktu_akhir = $data['waktu_pesan'] + $waktu_total;
          
          $oke = '1';
          $keterangan = 'berhasil';
          
      } else {
          $oke = '0';
          $keterangan = 'gagal';
          $waktu_akhir = '0';
      }
      
      $jawaban = array(
		    "oke" => $oke,
		    "keterangan" => $keterangan,
		    "waktu_jadi" => $waktu_akhir,
    	);
	    echo json_encode($jawaban);
    
}

?>