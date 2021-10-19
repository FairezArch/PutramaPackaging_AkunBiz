<?php 
header("Access-Control-Allow-Origin: *");
require "functionv2.php";

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
		$args="SELECT * FROM produk WHERE promo='0' ORDER BY id DESC LIMIT 9";
	} else {
		$args="SELECT * FROM produk ORDER BY id DESC";
	}
	$result = mysqli_query( $dbconnect, $args );
	$produk = array();
	if ( $result ) {
		while ( $data_produk = mysqli_fetch_array($result) ) {
		    $parcel     = parcel($data_produk['id']);
		    $stok       = all_stok_prod($data_produk['id'],'stock_tersedia');
		    if ($parcel == '0'){
		        $data_stock = all_stok_prod($data_produk['id'],'stock_tersedia');
		    }else{
		        if($stok > 0){
		          $data_stock = parcelformaster($data_produk['id']);  
		        }else{
		          $data_stock = 0;  
		        }
		    }
			$produk[] = array(
				"id" => $data_produk['id'],
				"idcabang" => $data_produk['idcabang'],
				"idkategori" => $data_produk['idkategori'],
				"title" => $data_produk['title'],
				"trim_title" => excerptmobile($data_produk['short_title'],40),
				"harga" => $data_produk['harga'],
				"promo" => $data_produk['promo'],
				"hargapromo" => $data_produk['harga_promo'],
				"deskripsi" => $data_produk['deskripsi'],
				"stock" => $data_produk['stock'],
				"image" => $data_produk['image'],
				"filter" => $data_stock,
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
	$args="SELECT * FROM produk WHERE idkategori='$idkategori' ORDER BY promo DESC";
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
		    $parcel     = parcel($data_produk['id']);
		    $stok       = all_stok_prod($data_produk['id'],'stock_tersedia');
		    if ($parcel == '0'){
		        $data_stock = all_stok_prod($data_produk['id'],'stock_tersedia');
		    }else{
		        if($stok > 0){
		          $data_stock = parcelformaster($data_produk['id']);  
		        }
		        
		    }
			$produk[] = array(
				"id" => $data_produk['id'],
				"idcabang" => $data_produk['idcabang'],
				"idkategori" => $data_produk['idkategori'],
				"cabang" => $data_produk['cabang'],
				"kategori" => $data_produk['kategori'],
				"title" => $data_produk['title'],
				"trim_title" => excerptmobile($data_produk['short_title'],40),
				"harga" => $data_produk['harga'],
				"promo" => $data_produk['promo'],
				"hargapromo" => $data_produk['harga_promo'],
				"deskripsi" => $data_produk['deskripsi'],
				"stock" => $data_produk['stock'],
				"image" => $data_produk['image'],
				"filter" => $data_stock,
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
	$args="SELECT * FROM produk WHERE idsubkategori='$idkategori' ORDER BY promo DESC";
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
				"trim_title" => excerptmobile($data_produk['short_title'],40),
				"harga" => $data_produk['harga'],
				"promo" => $data_produk['promo'],
				"hargapromo" => $data_produk['harga_promo'],
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
	$tabelname          = secure_string($_POST['tabelname']);
	$idproduk           = secure_string($_POST['idproduk']);
	$produk_cabang_id   = data_tabel($tabelname, $idproduk, 'idcabang');
	$produk_cabang      = data_tabel('cabang', $produk_cabang_id, 'nama');
	$produk_kategori_id = data_tabel($tabelname, $idproduk, 'idkategori');
	$produk_kategori    = data_tabel('kategori', $produk_kategori_id, 'kategori');
	$title_full         = data_tabel($tabelname, $idproduk, 'title');
	$title_short        = data_tabel($tabelname, $idproduk, 'short_title');
	$produk_deskripsi   = data_tabel($tabelname, $idproduk, 'deskripsi');
	$produk_harga       = data_tabel($tabelname, $idproduk, 'harga');
	$produk_hargapromo  = data_tabel($tabelname, $idproduk, 'harga_promo');
	$produk_promo       = data_tabel($tabelname, $idproduk, 'promo');
	$produk_stock       = data_tabel($tabelname, $idproduk, 'stock');
	$produk_image       = data_tabel($tabelname, $idproduk, 'image');
    
    //cari produk parcel
	$args                   = "SELECT * FROM produk_item WHERE id_prod_master='$idproduk'";
    $result                 = mysqli_query( $dbconnect, $args );
	$data_parcel            = mysqli_fetch_array($result);
	$array_id_prod_item     = $data_parcel['id_prod_item'];
    $array_item_pisah       = explode('|',$array_id_prod_item);
    $array_jumlahprod       = $data_parcel['jumlah_prod'];
	$get_array_jumlah       = explode("|", $array_jumlahprod);
	$jumlah_item            = count($array_item_pisah) - 1;
	$x = 0;
	$produk                 = array();
	
	while($x <= $jumlah_item) {
	    $idproduk_tampil = $array_item_pisah[$x];
	    $nproduk_tampil  = $get_array_jumlah[$x];
	    $args_produk     = "SELECT * FROM produk WHERE id='$idproduk_tampil'";
        $result_produk   = mysqli_query($dbconnect, $args_produk);
        $args_prod      = "SELECT * FROM produk WHERE id='$idproduk'";
        $result_prod    = mysqli_query($dbconnect, $args_prod);
        $data_prod      = mysqli_fetch_array($resul_prodt);
        if($result_produk){
            $data_produk= mysqli_fetch_array($result_produk);
            $filterawal = all_stok_prod($idproduk_tampil,'stock_tersedia');
            if ($filterawal >= $nproduk_tampil){
                $filter = 1;
                $data_stock = parcelformaster($data_prod['id']);
            }else{
                $filter = 0;
                $data_stock = all_stok_prod($data_prod['id'],'stock_tersedia');
            }
            $produk[]=array(
                "id"            => $data_produk['id'],
                "nama"          => $data_produk['title'],
                "trim"          => $data_produk['short_title'],
                "harga"         => $data_produk['harga'],
                "promo"         => $data_produk['promo'],
                "hargapromo"    => $data_produk['harga_promo'],
                "image"         => $data_produk['image'],
                "data_stock"    => $data_stock,
                "filter"        => $filter,
		        "jumlahitem"    => $nproduk_tampil,
            );
        }$x++;
    }
    
    if ( $data_parcel ) {
	    $parcel     = "1";
	    $error      = "";
	} else {
	   $parcel     = "0";
	   $error      = mysqli_error($dbconnect);
	}
    
	$jawaban = array(
		"oke"               => "1",
		"keterangan"        => "berhasil",
		"produk_id"         => $idproduk,
		"produk_cabang_id"  => $produk_cabang_id,
		"produk_cabang"     => $produk_cabang,
		"produk_kategori_id"=> $produk_kategori_id,
		"produk_kategori"   => $produk_kategori,
		"produk_title"      => $title_full,
		"produk_trim"       => $title_short,
		"produk_deskripsi"  => $produk_deskripsi,
		"produk_harga"      => $produk_harga,
		"produk_hargapromo" => $produk_hargapromo,
		"produk_promo"      => $produk_promo,
		"produk_stock"      => $produk_stock,
		"produk_image"      => $produk_image,
		"parcel"            => $parcel,
		"produk"            => $produk,
	);
	echo json_encode($jawaban);
}

// PRODUK SEJENIS
if ( isset($_POST['similar_produk']) && $_POST['similar_produk']==MOBILE_FORM ) {
	$idkategori = secure_string($_POST['idkategori']);
	$idproduk = secure_string($_POST['idproduk']);
	$args="SELECT * FROM produk WHERE id !='$idproduk' AND idkategori='$idkategori' ORDER BY promo DESC LIMIT 15";
    $result = mysqli_query( $dbconnect, $args );
	$jumlah = mysqli_num_rows($result);
	$produk = array();
	if ( $result ) {
		while ( $data_produk = mysqli_fetch_array($result) ) {
			$produk[] = array(
				"id" => $data_produk['id'],
				"idcabang" => $data_produk['idcabang'],
				"idkategori" => $data_produk['idkategori'],
				"idsubkategori" => $data_produk['idsubkategori'],
				"title" => $data_produk['title'],
				"trim_title" => excerptmobile($data_produk['short_title'],40),
				"harga" => $data_produk['harga'],
				"promo" => $data_produk['promo'],
				"hargapromo" => $data_produk['harga_promo'],
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
	
	$kategori_name="SELECT kategori FROM kategori WHERE id !='$idkategori'";
    $result = mysqli_query( $dbconnect, $kategori_name );
	
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
	$args="SELECT * FROM produk WHERE title LIKE '$val%' ORDER BY promo DESC";
    $result = mysqli_query( $dbconnect, $args );
    $jumlah = mysqli_num_rows($result);
	$produk = array();
	if ( $result ) {
		while ( $data_produk = mysqli_fetch_array($result) ) {
		    $parcel     = parcel($data_produk['id']);
		    $stok       = all_stok_prod($data_produk['id'],'stock_tersedia');
		    if ($parcel == '0'){
		        $data_stock = all_stok_prod($data_produk['id'],'stock_tersedia');
		    }else{
		        if($stok > 0){
		          $data_stock = parcelformaster($data_produk['id']);  
		        }
		        
		    }
			$produk[] = array(
				"id" => $data_produk['id'],
				"idcabang" => $data_produk['idcabang'],
				"idkategori" => $data_produk['idkategori'],
				"cabang" => $data_produk['cabang'],
				"kategori" => $data_produk['kategori'],
				"title" => $data_produk['title'],
				"trim_title" => excerptmobile($data_produk['short_title'],40),
				"harga" => $data_produk['harga'],
				"promo" => $data_produk['promo'],
				"hargapromo" => $data_produk['harga_promo'],
				"deskripsi" => $data_produk['deskripsi'],
				"stock" => $data_produk['stock'],
				"image" => $data_produk['image'],
				"filter" => $data_stock,
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
		"jumlah" => $jumlah,
	);
	echo json_encode($jawaban);
}

// CEK DATA ARRAY CART
if ( isset($_POST['get_array_cart']) && $_POST['get_array_cart']==MOBILE_FORM ) {
	$product_id = secure_string($_POST['product_id']);
	$product_name = secure_string($_POST['product_name']);
	$product_price = secure_string($_POST['product_price']);
	$product_pricepromo = secure_string($_POST['product_pricepromo']);
	$product_countorder = secure_string($_POST['product_countorder']);
	$product_image = secure_string($_POST['product_image']);
	$product_array_cart = secure_string($_POST['product_array_cart']);
	$simpan_array = array();
	$array_status = array();
	if ( $product_array_cart == '' ) {
		$simpan_array_1 = $product_id.'|'.$product_name.'|'.$product_price.'|'.$product_pricepromo.'|'.$product_image.'|'.$product_countorder;
		$datakembali = $simpan_array_1;
	} else {
		$array_kode_item = explode('!!!',$product_array_cart);
		$simpan_array_1 = $product_id.'|'.$product_name.'|'.$product_price.'|'.$product_pricepromo.'|'.$product_image.'|'.$product_countorder;
		
		$jumlah_item = count($array_kode_item) - 1;
		$x = 0;
		while($x <= $jumlah_item) {
			$arraydata = explode('|',$array_kode_item[$x]);
			$idproduk_tampil = $arraydata[0];
        	$args_produk="SELECT * FROM produk WHERE id='$idproduk_tampil'";
            $result_produk=mysqli_query($dbconnect, $args_produk);
            $row        =mysqli_num_rows($result_produk);
            if($result_produk){
                if($row > 0){
    				if ($arraydata[0] == $product_id) {
    					if ($product_countorder == 0) {
    						$array_status[] = 1;
    					} else {
    						$simpan_array[] = $product_id.'|'.$product_name.'|'.$product_price.'|'.$product_pricepromo.'|'.$product_image.'|'.$product_countorder;
    						$array_status[] = 1;
    					}
    				} else {
    					$simpan_array[] = $array_kode_item[$x];
    					$array_status[] = 0;
    				}
                }else{}
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
				$stock = $arraydata[5];
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
	$tabelname       = secure_string($_POST['tabelname']);
	$datatest        = secure_string($_POST['product_array_cart']);
	$datastatus      = array();
	$hasil           = array();
	$idcart          = array();
	$array_kode_item = explode('!!!',$datatest);
	$jumlah_item     = count($array_kode_item) - 1;
	$x               = 0;
	while($x <= $jumlah_item) {
		$arraydata  = explode('|',$array_kode_item[$x]);
		$data_id    = $arraydata[0];
		$parcel     = parcel($data_id);
		$stok       = all_stok_prod($arraydata[0],"stock_tersedia");
		
		if ($parcel == '0'){
			$data_stock = all_stok_prod($arraydata[0],"stock_tersedia");
			  
			  if ($data_stock < $arraydata[5]) {
				$datastatus[] = 1;
				$hasil[]      = '1|'.$data_id;
				$idcart[]     = $arraydata[0];
			  } else {
				$datastatus[] = 0;
				$hasil[]      = '0|'.$data_id;
				$idcart[]     = $arraydata[0];
			  }
			  
		}else{
            if($stok > 0){
		        $data_stockparcel = parcelstock($arraydata[0],$arraydata[5]);  
		        if($data_stockparcel > 0){
		            $datastatus[] = 0;
    			    $hasil[]      = '0|'.$data_id;
    				$idcart[]     = $arraydata[0]; 
		        }else{
		            $datastatus[] = 1;
    				$hasil[]      = '1|'.$data_id;
    				$idcart[]     = $arraydata[0];
		        }
		    }else{
		        $datastatus[] = 1;
				$hasil[]      = '1|'.$data_id;
				$idcart[]     = $arraydata[0];
		    }
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
		"cek1" => $data_stockparcel,
		"cek2" => $data_stock,
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
	$produkid   = secure_string($_POST['product_id']);
	$datasimpancart = secure_string($_POST['product_array_cart']);
	$datasimpan = update_userCart_data($datasimpancart);
    $minim_pembelian = value_dataoption('minim_pembelian');
    $biaya_ongkir    = value_dataoption('biaya_ongkir');
	$struktur       = array();
	$jumlahharga    = array();
	$idprodukcart   = array();
	$totalbelanja   = array();
	$totaldiskon    = array();
	
	$array_kode_item   = explode('!!!',$datasimpan);
	$jumlah_item       = count($array_kode_item) - 1;
	
	
	$x = 0;
	while($x <= $jumlah_item) {
		$arraydata      = explode('|',$array_kode_item[$x]);
		$hargaasli      = hargaasli($arraydata[0]);
		$statuspromo    = promo($arraydata[0]);
		$idproduk       = $arraydata[0];
		$title          = html_entity_decode($arraydata[1]);
		$image          = $arraydata[4];
		$product_countorder = $arraydata[5];
		
		$args_produk="SELECT * FROM produk WHERE id='$idproduk'";
        $result_produk=mysqli_query($dbconnect, $args_produk);
        $row        =mysqli_num_rows($result_produk);
        if($result_produk){
            if($row > 0){
                $data = mysqli_fetch_array( $result_produk );
                $harga          = get_promo($data['id']);
        		if($statuspromo =='1'){
        		    $hargapromo  = $harga;
        		} else{
        		    $hargapromo  = 0;
        		}
        		
        		$iddb       = $data['id'];
        		$idarray    = $arraydata[0];
        		if($idarray == $iddb){
        			$id_new         = $arraydata[0];
        			$title_new      = html_entity_decode($arraydata[1]);
        			$harga_new      = $hargaasli;
        			$hargapromo_new = $hargapromo;
        			$image_new      = $arraydata[4];
        			$jumlah_new     = $arraydata[5];
        			$totalharga_new = $harga * $arraydata[5];
        			$promo_new      = $statuspromo;
        		}else{
        			$id_new         = '';
        			$title_new      = '';
        			$harga_new      = '';
        			$hargapromo_new = '';
        			$image_new      = '';
        			$jumlah_new     = '';
        			$totalharga_new = '';
        			$promo_new      = '';
        		}
        		
        		$struktur[]     = array(
        			"id"         => $id_new,
        			"title"      => $title_new,
        			"harga"      => $harga_new,
        			"hargapromo" => $hargapromo_new,
        			"image"      => $image_new,
        			"jumlah"     => $jumlah_new,
        			"totalharga" => $totalharga_new,
        			"promo"      => $promo_new,
        		 );
        		 
        		$totalhargadata[]        = $harga_new * $jumlah_new;
        		$totalhargadiskondata[]  = $hargapromo_new * $jumlah_new;
        		$idprodukcart[]          = $id_new;
        		$jumlahharga[]           = $totalharga_new;
            }else{}		
		}$x++;
	}
	$totalharga        = array_sum($totalhargadata);
	$totalhargadiskon  = array_sum($totalhargadiskondata);
	$totalbelanja      = array_sum($jumlahharga);
	$idprodukcart_join = join("|",$idprodukcart);
	$totaldiskon       = $totalharga - $totalbelanja;
	
	if($totalbelanja >= $minim_pembelian){
	    $biayakirim = 0;
	    $total      = $totalbelanja;
	}else{
	    $biayakirim = $biaya_ongkir;
	    $total      = $totalbelanja + $biayakirim;
	}
	
	$simpan_array[] = $idproduk.'|'.$title.'|'.$hargaasli.'|'.$hargapromo.'|'.$image.'|'.$product_countorder;
	$array_jadi = join("!!!",$simpan_array);
	$jawaban = array(
		"oke"           => "1",
		"keterangan"    => "berhasil",
		"struktur"      => $struktur,
		"total"         => $total,
		"subtotal"      => $totalbelanja,
		"promo"         => $statuspromo,
		"totalbelanja"  => $totalharga,
		"totaldiskon"   => $totaldiskon,
		"idprodukcart"  => $idprodukcart_join,
		"biayakirim"    => $biayakirim,
		"minim_pembelian"=> $minim_pembelian,
	);
	echo json_encode($jawaban);
}

// UPDATE JUMLAH STOK PRODUK
if ( isset($_POST['hitungstock']) && $_POST['hitungstock']==MOBILE_FORM ) {
	$datatest           = secure_string($_POST['product_array_cart']);
	$id_user            = secure_string($_POST['id_user']);
	$telp_user          = secure_string($_POST['telp_user']);
	$cart_total_harga   = secure_string($_POST['cart_total_harga']);
	$cart_total_belanja = secure_string($_POST['cart_total_belanja']);
	$cart_total_diskon  = secure_string($_POST['cart_total_diskon']);
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
	$ongkir             = value_dataoption('biaya_ongkir');
	$minim_belanja      = value_dataoption('minim_pembelian');
	$x = 0;
	
	
	
	while($x <= $jumlah_item) {
		$arraydata      = explode('|',$array_kode_item[$x]);
		$harga          = get_promo($arraydata[0]);
		$promocode      = promo($arraydata[0]);
		$hargaasli      = hargaasli($arraydata[0]);
		$array_id[]     = $arraydata[0];
		$array_stock[]  = $arraydata[5];
		$array_harga[]  = $harga; //$harga;
		$array_hargaasli[] = $hargaasli;
		$array_title[]  = $arraydata[1];
		$array_image[]  = $arraydata[4];
		if($promocode == "1"){
		   $array_hargapromo[]  = $harga;
		   $promo[] = 1;
		}else{
		    $array_hargapromo[]  = 0;
		    $promo[] = 0;
		}
		
		$totalhargadata[]        = $hargaasli * $arraydata[5];
		$totalhargabayardata[]  = $harga * $arraydata[5];
		
		$x++;
	}
	
	if ( $pay_method == 'inSaldo' || $pay_method == 'cod'  ) {
	    $status = '10';
	} else {
	    $status = '5';
	}
	
	$cart_total_belanja = array_sum($totalhargadata);
	$cart_hargatotal_bayar = array_sum($totalhargabayardata);
	$cart_total_diskon = $cart_total_belanja - $cart_hargatotal_bayar;
	
	$penggunaaan_ongkir = $cart_total_belanja - $cart_total_diskon;
	if ($penggunaaan_ongkir >= $minim_belanja){
	    $biayaongkir = '0';
	}else{$biayaongkir = $ongkir;}
	
	$cart_total_harga = $penggunaaan_ongkir + $biayaongkir;
	
	$id_jadi = join("|",$array_id);
	$promo_jadi = join("|",$promo);
	$title_jadi = join("|",$array_title);
	$image_jadi = join("|",$array_image);
	$stock_jadi = join("|",$array_stock);
	$harga_jadi = join("|",$array_hargaasli);
	$harga_gabungan = join("|",$array_harga);
	$hargapromo_jadi = join("|",$array_hargapromo);
	$upstock = "INSERT INTO pesanan ( id_user, telp, catatan, idproduk, nama_produk, gambar_produk, status_promo, jml_order, harga_item, hargadiskon_item, sub_total, total, diskon, ongkos_kirim, alamat_kirim, waktu_pesan, waktu_kirim, metode_bayar, tipe_bayar, status) 
	                         VALUES ( '$id_user', '$telp_user', '$catatan', '$id_jadi', '$title_jadi', '$image_jadi', '$promo_jadi', '$stock_jadi', '$harga_jadi','$hargapromo_jadi','$cart_total_belanja', '$cart_total_harga', '$cart_total_diskon', '$biayaongkir', '$alamat_order', '$tgl_database','$order_date','$metode_bayar','$pay_method','$status' )";
	                         
	$result = mysqli_query( $dbconnect, $upstock );
	$neworder_id = mysqli_insert_id($dbconnect);
	$args_cartuser = "UPDATE user SET array_cart='' WHERE id='$id_user'";
	
	
	$result_cartuser = mysqli_query( $dbconnect, $args_cartuser );
    $id_pesanan = $neworder_id;
	if ( $metode_bayar == 'nonsaldo' || $metode_bayar == 'cash' ) {
	    $type_transsaldo = 'none';
	    $deskripsi_pesanan  = "Transaksi pesanan ID $neworder_id";
        $minussaldo = "INSERT INTO trans_saldo ( date, type, nominal, id_user, deskripsi ,id_pesanan) VALUES ( '$tgl_database', '$type_transsaldo', '$cart_total_harga', '$id_user', '$deskripsi_pesanan','$neworder_id' )";
	    $result_minussaldo = mysqli_query( $dbconnect, $minussaldo );
	    
	    if ( $pay_method == 'pay_debit') {
    	    $args_reqsaldo = "INSERT INTO request_saldo (id_user,harga_awal,total_bayar,date_checkout,type,id_pesanan,status,aktif,id_trans_saldo) VALUES ('$id_user','$cart_total_harga','$cart_total_harga','$tgl_database','pesanan','$id_pesanan','0','1','0')";
    	    $result_reqsaldo  = mysqli_query ( $dbconnect, $args_reqsaldo );
	   } else {}
	} else if ( $metode_bayar == 'saldo' ) {
	        $type_transsaldo = 'minus';
	        $deskripsi_pesanan  = "Transaksi pesanan ID $neworder_id";
            $minussaldo = "INSERT INTO trans_saldo ( date, type, nominal, id_user, deskripsi ,id_pesanan) VALUES ( '$tgl_database', '$type_transsaldo', '$cart_total_harga', '$id_user', '$deskripsi_pesanan','$neworder_id' )";
	        $result_minussaldo = mysqli_query( $dbconnect, $minussaldo );
	        $result_user_saldo = update_saldo_user($id_user);
	} else {
	        // Kurangi Saldo dulu 
	        $type_transsaldo = 'minus';
	        $deskripsi_pesanan  = "Transaksi pesanan ID $neworder_id";
            $minussaldo = "INSERT INTO trans_saldo ( date, type, nominal, id_user, deskripsi ,id_pesanan) VALUES ( '$tgl_database', '$type_transsaldo', '$saldo_user', '$id_user', '$deskripsi_pesanan','$neworder_id' )";
	        $result_minussaldo = mysqli_query( $dbconnect, $minussaldo );
	        $idtranssaldo = mysqli_insert_id( $dbconnect );
	        $result_user_saldo = update_saldo_user($id_user);
	        
	        if ( $pay_method == 'pay_debit') {
	            $type_transsaldo = 'none';
        	    $args_reqsaldo = "INSERT INTO request_saldo (id_user,harga_awal,total_bayar,date_checkout,type,id_pesanan,status,aktif,id_trans_saldo) VALUES ('$id_user','$selisih','$selisih','$tgl_database','pesanan','$id_pesanan','0','1','0')";
        	    $result_reqsaldo  = mysqli_query ( $dbconnect, $args_reqsaldo );
        	    $args_saldo = "INSERT INTO trans_saldo ( date, type, nominal, id_user, deskripsi ,id_pesanan) VALUES ( '$tgl_database', '$type_transsaldo', '$selisih', '$id_user', '$deskripsi_pesanan','$neworder_id' )";
    	        $result_saldo = mysqli_query( $dbconnect, $args_saldo );
	        } else if ( $pay_method == 'cod'){
	            $type_transsaldo = 'none';
	            $args_saldo = "INSERT INTO trans_saldo ( date, type, nominal, id_user, deskripsi ,id_pesanan) VALUES ( '$tgl_database', '$type_transsaldo', '$selisih', '$id_user', '$deskripsi_pesanan','$neworder_id' )";
	            $result_saldo = mysqli_query( $dbconnect, $args_saldo );
	        }
	}
	
	
	// INPUT TRANS ORDER
	$arrayid_pisah = explode('|',$id_jadi);
	$arrayid_jadi = count($arrayid_pisah);
	$arraycount_pisah = explode('|',$stock_jadi);
	$arraycount_jadi = count($arraycount_pisah);
	$arrayharga_pisah = explode('|',$harga_gabungan);
	$arrayharga_jadi = count($arrayharga_pisah);
	$y = 0;
	while($y <= $jumlah_item) {
		$idproduk_transorder = $arrayid_pisah[$y];
		$count_transorder = $arraycount_pisah[$y];
		$harga_transorder = $arrayharga_pisah[$y];
		$type_transorder = 'out';
		$uptrans_order = "INSERT INTO trans_order ( id_pesanan, id_produk, jumlah, harga, type, date ) VALUES ( '$neworder_id', '$idproduk_transorder', '$count_transorder', '$harga_transorder', '$type_transorder', '$tgl_database' )";
		$result_trans_order = mysqli_query( $dbconnect, $uptrans_order );
		
		$kodeparcel     = parcel($idproduk_transorder);
		if($kodeparcel == '1'){
		    $args = "SELECT * FROM produk_item WHERE id_prod_master='$idproduk_transorder'";
	        $query = mysqli_query( $dbconnect, $args);
	        $array_check = mysqli_fetch_array($query);

	        $array_namaprod = $array_check['id_prod_item'];
	        $get_array_nama = explode("|", $array_namaprod);
	        $array_jumlahprod = $array_check['jumlah_prod'];
	        $get_array_jumlah = explode("|", $array_jumlahprod);
	        $number_parcelprod = count($get_array_nama)-1;
	        $sum_number = 0;
	
	        while ( $sum_number <= $number_parcelprod ) {
        		$total_parcel_nama = $get_array_nama[$sum_number];
        		$total_parcel_jumlah = $get_array_jumlah[$sum_number];
        		$n_item_parcel       = $total_parcel_jumlah * $count_transorder;
        		$ins_transorder = "INSERT INTO trans_order (id_pesanan, id_produk, jumlah, harga, type, date,deskripsi ) VALUES ('$neworder_id', '$total_parcel_nama', '$n_item_parcel', '0', '$type_transorder', '$tgl_database', 'Parcel Pesanan $neworder_id')";
        		$query_transorder = mysqli_query( $dbconnect,$ins_transorder );

        	$sum_number++;
        	}
		}else{
		}
		$y++;
	}
	
	$alamat_full = alamatpesanan_full($alamat_order,$id_user);
	//$total_saldo_user = total_saldo_userid($id_user);
	//$result_user_saldo = update_saldo_user($id_user);
	
	
	
	if ( $result && $result_cartuser && $result_trans_order ) {
		$oke = "1";
		$keterangan = "berhasil";
		
		$send_email  = kirim_email_order($nama_user, $email_user, $telp_user, $id_user, $saldo_user, $id_pesanan, $cart_total_harga, $alamat_full, $tgl_database, $order_date, $pay_method);
	} else {
		$oke = "0";
		$keterangan = "gagal";
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"orderbaru" => $neworder_id,
		"slottime" => $slottime,
		"picktime" => $picktime
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
	//$hasil = '<option value="00" '.auto_hide('00').'>00:00 WIB sd 02:00 WIB</option>';
	for ($n = 3; $n <= 9; $n++) {
		$num = $n * 2 + 2;
		$valnum = $num + 2;
		$num_padded = sprintf("%02d", $num);
		$valnum_padded = sprintf("%02d", $valnum);
			$hasil = '<option value="'.$num_padded.'" '.auto_hide($num_padded).'>'.$num_padded.':00 WIB sd '.$valnum_padded.':00 WIB </option>';
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
	$user_id = secure_string($_POST['user_id']);
	$status = secure_string($_POST['status']);
	$idpesanan = secure_string($_POST['idpesanan']);
    $batal = auto_pesanan_batal($user_id);
    
    
    
	
   
	    if( $status != "" ){
	       if ( $status  == '60') {
	           $stat ="aktif ='0' AND";
	       } else {
	            $stat ="status ='$status' AND aktif='1' AND";
                
	       }
	     
	    } else {
	        $stat = "";
	    }
	    if ( $idpesanan != '' ) {
	        $idpesan = "id ='$idpesanan' AND ";
	    } else {
	        $idpesan = "";
	    }
	
	$args="SELECT * FROM pesanan WHERE $stat $idpesan id_user='$user_id' ORDER by waktu_pesan DESC";
    $result = mysqli_query( $dbconnect, $args );
	$riwayat = array();
	$jumlah = mysqli_num_rows($result);
	if ( $result ) {
		while ( $data_pesanan = mysqli_fetch_array($result) ) {
		    
		    $idpesanan = $data_pesanan['id'];
		    $aktif     = $data_pesanan['aktif'];
		    $id_alamat = $data_pesanan['alamat_kirim'];
		    $tipe_bayar= $data_pesanan['tipe_bayar'];
		    //cek sudah bayar apa belum;
	        $id_request = data_requestsaldo($idpesanan,"id");
	        $pembayaran = jum_konfirmasi_saldo($id_request,"pesanan");
	     
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
				"id_pesanan"     => $data_pesanan['id'],
				"idproduk"       => $data_pesanan['idproduk'],
				"total"          => $data_pesanan['total'],
				"waktu_pesan"    => date('d M Y, H.i', $data_pesanan['waktu_pesan']),
				"waktu_kirim"    => show_datesendorder($data_pesanan['waktu_kirim'],'notspace'),
				"alamat_kirim"   => $alamat_kirim,
				"status"         => $data_pesanan['status'],
				"aktif"          => $aktif,
				"pembayaran"     => $pembayaran,
				"tipe_bayar"     => $tipe_bayar,
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
		"stat" => $stat,
		"aktif" => $aktif_status,
		"error" => $error
	);
	echo json_encode($jawaban);
}


// DETIL RIWAYAT ORDER
if ( isset($_POST['detil_riwayatorder']) && $_POST['detil_riwayatorder']==MOBILE_FORM ) {
	$idpesanan = secure_string($_POST['idpesanan']);
	
	//cari pesanan
	$args="SELECT * FROM pesanan WHERE id='$idpesanan'";
    $result = mysqli_query( $dbconnect, $args );
    
	if ( $result ) {
		$data_pesanan     = mysqli_fetch_array($result);
		$status_pemesanan = $data_pesanan['status'];
	    $total_bayar      = $data_pesanan['total'];
	    $subtotal_bayar   = $data_pesanan['sub_total'];
	    $total_diskon     = $data_pesanan['diskon'];
	    $ongkir           = $data_pesanan['ongkos_kirim'];
	    $alamat_kirim     = $data_pesanan['alamat_kirim'];
	    $waktu_pesan      = date('d M Y, H.i',$data_pesanan['waktu_pesan']);
	    $waktu_kirim      = show_datesendorder($data_pesanan['waktu_kirim'],'notspace');
	    $tipe_bayar       = $data_pesanan['tipe_bayar'];
	    $metode_bayar     = $data_pesanan['metode_bayar'];
		if ( $metode_bayar == 'sebagian' ) {
	          $penggunaan_saldo = data_transsaldo($idpesanan,"minus",'nominal');
	          $kekurangan_bayar = $total_bayar - $penggunaan_saldo;
	     } else if ( $metode_bayar == 'nonsaldo' ) {
	          $penggunaan_saldo = '0';
	          $kekurangan_bayar = $total_bayar;
	     } else if ( $metode_bayar == 'saldo' ) {
	          $penggunaan_saldo = data_transsaldo($idpesanan,"minus",'nominal');
	          $kekurangan_bayar = '0';
	     }else if ( $metode_bayar == 'cash' ) {
	          $penggunaan_saldo = data_transsaldo($idpesanan,"minus",'nominal');
	          $kekurangan_bayar = $total_bayar;
	     }
		
		//cek sudah bayar apa belum;
	     $id_request = data_requestsaldo($idpesanan,"id");
	     $pembayaran = jum_konfirmasi_saldo($id_request,"pesanan");
	     
	     $status_tgl       = array();
	     //Ambil Waktu Sesuai Status
	        //Waktu Pemesanan
	        //Pembayaran 
            if( $data_pesanan['metode_bayar'] == 'saldo' ){	
                if($data_pesanan['waktu_pesan'] !== '0'){ $tanggal_bayar = date('d M Y, H.i', $data_pesanan['waktu_pesan']); }else { $tanggal_bayar = '-'; } 
            }else if( $data_pesanan['metode_bayar'] == 'cash' ){ $tanggal_bayar = '-';
            }else{
                if( split_status_order($data_pesanan['status_cek_bayar'],'2') !== '0'){ $tanggal_bayar = date('d M Y, H.i', split_status_order($data_pesanan['status_cek_bayar'],'2')); }else { $tanggal_bayar = '-'; }
            }
            //Pengemasan
            if( split_status_order($data_pesanan['status_2_driver'],'2') !== '0') { $tanggal_pengemasan = date('d M Y, H.i', split_status_order($data_pesanan['status_1_checker'],'2')); }else { $tanggal_pengemasan = '-';} 

            //Pengiriman
            if( split_status_order($data_pesanan['status_2_driver'],'2') !== '0') { $tanggal_kirim      = date('d M Y, H.i', split_status_order($data_pesanan['status_2_driver'],'2')); }else { $tanggal_kirim = '-'; } 
       
            //Pesanan sampai 
            if( split_status_order($data_pesanan['status_3_driver'],'2') !== '0') { $tanggal_sampai     = date('d M Y, H.i', split_status_order($data_pesanan['status_3_driver'],'2')); }else { $tanggal_sampai = '-'; } 
       
            //Customer
            if( split_status_order($data_pesanan['status_3_cust'],'2') !== '0')   { $tanggal_konfirm    = date('d M Y, H.i', split_status_order($data_pesanan['status_3_cust'],'2')); }else { $tanggal_konfirm = '-'; }
		    
		    $status_tgl[] = array(
	                
	            "tgl_bayar"     => $tanggal_bayar,
	            "tgl_kemas"     => $tanggal_pengemasan,
	            "tgl_kirim"     => $tanggal_kirim,
	            "tgl_sampai"    => $tanggal_sampai,
	            "tgl_konfirm"   => $tanggal_konfirm
	       );
	     
         $aktif            = $data_pesanan['aktif'];
		
		// Cari id Pesanan dan di lemparkan ke data produk untuk di ambil datanya
		    $idproduk1      = $data_pesanan['idproduk'];
            $jumlah_order1  = $data_pesanan['jml_order'];
            $harga1         = $data_pesanan['harga_item'];
	        $hargapromo1    = $data_pesanan['hargadiskon_item'];
	        $statuspromo1   = $data_pesanan['status_promo'];
	        $gambarproduk1  = $data_pesanan['gambar_produk'];
	        $namaproduk1    = $data_pesanan['nama_produk'];
            $idproduk       = explode("|",$idproduk1);
            $jumlah_order   = explode("|",$jumlah_order1);
            $harga          = explode("|",$harga1);
            $hargapromo     = explode("|",$hargapromo1);
            $statuspromo    = explode("|",$statuspromo1);
            $gambarproduk   = explode("|",$gambarproduk1);
            $namaproduk     = explode("|",$namaproduk1);
            $jumlah_idproduk= count($idproduk)-1;
            $x = 0;
            $produk = array();
            while($x <= $jumlah_idproduk){
                $idproduk_tampil = $idproduk[$x];
                $jml_order_tampil= $jumlah_order[$x];
                $harga_tampil    = $harga[$x];
                $statuspromo_tampil   = $statuspromo[$x];
                $gambarproduk_tampil  = $gambarproduk[$x];
                $namaproduk_tampil    = $namaproduk[$x];
                $hargapromo_tampil    = $hargapromo[$x];
                $produk[]=array(
                    "idproduk"  => $idproduk_tampil,
                    "trim"      => $namaproduk_tampil,
                    "harga"     => $harga_tampil,
                    "promo"     => $statuspromo_tampil,
                    "hargapromo"=> $hargapromo_tampil,
                    "gambar"    => $gambarproduk_tampil,
                    "jumlah"    => $jml_order_tampil,
                );
                $x++;
            }
            
		     // Cari Alamat Order
	         $args_carialamat = "SELECT * FROM alamat_order where id='$alamat_kirim'";
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
			
		$oke = '1';
		$keterangan = "berhasil";
	} else {
		$oke = '0';
		$keterangan = "gagal";
	}
	$jawaban = array(
		"oke"               => $oke,
		"keterangan"        => $keterangan,
		"idpesanan"         => $idpesanan,
		"produk"            => $produk,
		"total_bayar"       => $total_bayar,
		"diskon"            => $total_diskon,
		"penggunaan_saldo"  => $penggunaan_saldo,
		"kekurangan_bayar"  => $kekurangan_bayar,
		"waktu_pesan"       => $waktu_pesan,
		"waktu_kirim"       => $waktu_kirim,
		"alamat_kirim"      => $alamat_kirim,
		"status"            => $status_pemesanan,
		"aktif"             => $aktif,
		"pembayaran"        => $pembayaran,
		"tipe_bayar"        => $tipe_bayar,
		"metode_bayar"      => $metode_bayar,
		"status_tgl"        => $status_tgl,
		"subtotal"          => $subtotal_bayar,
		"ongkir"            => $ongkir,
		
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
    $args_cek = "SELECT id FROM request_saldo WHERE type='saldo' AND id_user='$iduser' AND status='0'";
    $result_cek = mysqli_query( $dbconnect, $args_cek );
    if ($result_cek){
        $args_del = "DELETE FROM request_saldo WHERE type='saldo' AND id_user='$iduser' AND status='0'";
        $result_del = mysqli_query( $dbconnect, $args_del );
    }
    
    // Insert Request Saldo Baru
    $args = "INSERT INTO request_saldo ( id_user, harga_awal, date_checkout, type ) VALUES ( '$iduser', '$nominal', '$date_db', 'saldo' )";
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
	     $args_aa = "SELECT * FROM request_saldo WHERE id_user='$iduser' AND status='0' AND type='saldo'";
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
		        //$id_trans_saldo = $data_reqsaldo['id_trans_saldo'];
		        $kode_unik = $data_reqsaldo['kode_unik'];
		
	        } else {
		        $idreq = '';
		        $iduser = '';
		        $harga_awal = '';
		        $total_bayar = '';
		        $date_checkout = '';
		        $status = '';
		        $aktif = '';
		        //$id_trans_saldo = '';
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

if ( isset($_POST['konfrim_topup']) && $_POST['konfrim_topup']==MOBILE_FORM ) {
    $id_user = secure_string($_POST['id_user']);
    $nama_user = secure_string($_POST['nama_user']);
    $email_user = secure_string($_POST['email_user']);
	$idreq = secure_string($_POST['idreq']);
	$tanggal_trans = proses_tanggal($_POST['tanggal_trans']);
	$tanggal_db = strtotime($tanggal_trans.' 01:00');
	$uang_trans = secure_string($_POST['uang_trans']);
	$nominal_trans = secure_string($_POST['nominal_trans']);
	$norek_user = secure_string($_POST['norek_user']);
	$bankuser_user = secure_string($_POST['bankuser_user']);
	$namarek_user = secure_string($_POST['namarek_user']);
	$idsm_rek = secure_string($_POST['idsm_rek']);
	$ipp = $_SERVER['REMOTE_ADDR'];
	
	$emailautosend = 'autosend@ideasmart.id';
	$email_admin = value_dataoption('sendmail_admin');
	//$id_reqsaldo = data_requestsaldo($id_pembelian,"id");
	$args = "INSERT INTO konfirmasi_saldo ( tanggal, uang_saldo, uang_tf, rekuser, bankuser, namauser, rekideasmart, iduser, type, id_reqsaldo ) VALUES ( '$tanggal_db', '$nominal_trans', '$uang_trans', '$norek_user', '$bankuser_user', '$namarek_user', '$idsm_rek', '$id_user', 'saldo', '$idreq')";
    $result = mysqli_query( $dbconnect, $args );
    
    
    
$textmail = "
------------------------------------------
DATA PENGGUNA
------------------------------------------
User ID: ".$id_user."
Nama User: ".$nama_user."
Email User: ".$email_user."

------------------------------------------
TRANSFER SALDO
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
$subjectmail = 'Notifikasi Pembayaran TOPUP SALDO User ID '.$id_user;

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


// cek userr reqsaldo
if ( isset($_POST['cek_reqsaldo']) && $_POST['cek_reqsaldo']==MOBILE_FORM ) {
    $iduser = secure_string($_POST['user_id']);
    
    //$args = "SELECT * FROM request_saldo WHERE id_user='$iduser' AND status='0'";
    $args = "SELECT * FROM `request_saldo` WHERE type='saldo' AND id_user='$iduser' AND status='0'";
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
		//$id_trans_saldo = $data_reqsaldo['id_trans_saldo'];
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
		//"id_trans_saldo" => $id_trans_saldo,
		"kode_unik" => $kode_unik,
	);
	echo json_encode($jawaban);
}

// Hapus Request Saldo User
if ( isset($_POST['del_reqsaldo']) && $_POST['del_reqsaldo']==MOBILE_FORM ) {	
	$idreqsaldo = secure_string($_POST['id_reqsaldo']);
	$kredit     = secure_string($_POST['kredit']);
	
	if($kredit == "0"){
	    $oke = '1';
		$keterangan = 'berhasil';
	}else{
        $args_del = "DELETE FROM request_saldo WHERE id='$idreqsaldo'";
        $result_del = mysqli_query( $dbconnect, $args_del );
        
    	if ( $result_del ) {
    	    $oke = '1';
    		$keterangan = 'berhasil';
    	} else { 	
    	    $oke = '0';
    		$keterangan = 'gagal';
    	}
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
	$idpesanan = secure_string($_POST['idpesanan']);
	$ipp = $_SERVER['REMOTE_ADDR'];
	
	$emailautosend = 'autosend@ideasmart.id';
	$email_admin = value_dataoption('sendmail_admin');
	$id_reqsaldo = data_requestsaldo($id_pembelian,"id");
	$args = "INSERT INTO konfirmasi_saldo ( tanggal, uang_saldo, uang_tf, rekuser, bankuser, namauser, rekideasmart, iduser, type, id_reqsaldo ) VALUES ( '$tanggal_db', '$nominal_trans', '$uang_trans', '$norek_user', '$bankuser_user', '$namarek_user', '$idsm_rek', '$id_user', 'pesanan', '$id_reqsaldo')";
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
	$tanggallahir = proses_tanggal(secure_string($_POST['tanggallahir']));
	$tanggallahirdb = strtotime($tanggallahir);
	$email = secure_string($_POST['email']);
	$telp = secure_string($_POST['telp']);
	
	$args = "UPDATE user SET nama='$nama', tanggal_lahir='$tanggallahirdb', email='$email', telp='$telp' WHERE id='$iduser'";
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
	$tanggallahir = secure_string($_POST['tanggallahirsignup']);
	$tanggallahirdb = strtotime($tanggallahir);
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
			$adduser = "INSERT INTO user ( nama, tanggal_lahir, email, telp, password, user_role, tanggal_daftar, array_cart ) VALUES ( '$nama', '$tanggallahirdb', '$email', '$telp', '$password_db', '$peranuser', '$tgl_database', '$array_cart' )";
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
				$user_tanggallahir = proses_tanggal(date("j F Y",$data_user["tanggal_lahir"]));
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
				$user_tanggallahir = '';
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
		"tanggallahir" => $user_tanggallahir,
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
	
	$cart_lokal = secure_string($_POST['cart']);
	
	$args = "SELECT * FROM user WHERE telp='$telp' AND password='$password_db'";
	$result = mysqli_query( $dbconnect, $args );
	if ( mysqli_num_rows($result) ) {
		$data_user = mysqli_fetch_array($result);
		$oke = '1';
		$keterangan = "berhasil";
		$user_id = $data_user["id"];
		$user_nama = $data_user["nama"];
		$user_tanggallahir = proses_tanggal(date("j F Y",$data_user["tanggal_lahir"]));
		$user_email = $data_user["email"];
		$user_telp = $data_user["telp"];
		$user_alamat = $data_user["alamat"];
		$user_tanggal_daftar = $data_user["tanggal_daftar"];
		$user_saldo = $data_user["saldo"];
		$cart_database = $data_user["array_cart"];
		if($cart_lokal == "" AND $cart_database == "") {
		    $array_jadi ="";
		} else {
		    $array_jadi = gabung_array_cart($cart_database,$cart_lokal);
		}
		
		$uparray = "UPDATE user SET array_cart='$array_jadi' WHERE id='$user_id'";
	    $result = mysqli_query( $dbconnect, $uparray );
	    
	} else {
		$oke = '0';
		$keterangan = "gagal";
		$user_id = '';
		$user_nama = '';
		$user_tanggallahir = '';
		$user_email = '';
		$user_telp = '';
		$user_alamat = '';
		$user_tanggal_daftar = '';
		$user_saldo = '';
		$array_cart = '';
		$array_jadi = '';
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"id" => $user_id,
		"nama" => $user_nama,
		"tanggallahir" => $user_tanggallahir,
		"email" => $user_email,
		"telp" => $user_telp,
		"alamat" => $user_alamat,
		"tanggal_daftar" => $user_tanggal_daftar,
		"saldo" => $user_saldo,
		"array_jadi" => $array_jadi
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
		$user_tanggallahir = $data_user["tanggal_lahir"];
		if($user_tanggallahir == '' || $user_tanggallahir == null){
		    $user_tanggallahirdb = '';
		}else{
		    $user_tanggallahirdb = proses_tanggal(date("j F Y",$data_user["tanggal_lahir"]));
		}
		$user_email = $data_user["email"];
		$user_telp = $data_user["telp"];
		$user_tanggal_daftar = $data_user["tanggal_daftar"];
		$user_saldo = $data_user["saldo"];
		$array_cart = $data_user["array_cart"];
		$wishlist = $data_user["array_wishlist"];
		
		$array_wishlist         = explode('|',$wishlist);
    	$jumlah_item            = count($array_wishlist) - 1;
    	$x = 0;
    	while($x <= $jumlah_item) {
        	$idproduk_tampil = $array_wishlist[$x];
        	$args_produk="SELECT * FROM produk WHERE id='$idproduk_tampil'";
            $result_produk=mysqli_query($dbconnect, $args_produk);
            $row        =mysqli_num_rows($result_produk);
            if($result_produk){
                if($row > 0){
                    $data_produk=mysqli_fetch_array($result_produk);
                    $idprod[] = $data_produk['id'];
                }else{}
            }$x++;
    	}
    	$user_wishlist = join('|',$idprod);
        $args_wishlist   = "UPDATE user SET array_wishlist ='$user_wishlist' WHERE id ='$user_id'";
        $result_wishlist = mysqli_query( $dbconnect, $args_wishlist);
	} else {
		$oke = '0';
		$keterangan = "gagal";
		$user_nama = '';
		$user_tanggallahir = '';
		$user_email = '';
		$user_telp = '';
		$user_tanggal_daftar = '';
		$user_saldo = '';
		$array_cart = '';
		$user_wishlist = '';
		$appversion ='';
	}
	$jawaban = array(
		"oke" => $oke,
		"keterangan" => $keterangan,
		"nama" => $user_nama,
		"tanggallahir" => $user_tanggallahirdb,
		"email" => $user_email,
		"telp" => $user_telp,
		"tanggal_daftar" => $user_tanggal_daftar,
		"saldo" => $user_saldo,
		"array_cart" => $array_cart,
		"user_wishlist" => $user_wishlist,
	);
	echo json_encode($jawaban);
}

//Abot Us
if ( isset($_POST['data_tab']) && $_POST['data_tab'] ==MOBILE_FORM ) {
    $tgl_database  = strtotime('now');   
    $args ="SELECT * FROM dataoption ORDER BY id";
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
        "now" => $tgl_database,
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
    
    $args = "SELECT waktu_pesan FROM pesanan where id_user ='$iduser' AND id='$idorder'";
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

if( isset($_POST['cek_jumlahalamat']) && $_POST['cek_jumlahalamat'] == MOBILE_FORM ) {
    $iduser = secure_string( $_POST['iduser'] );
    $jumlah_alamat = get_addressorder($iduser);
    $oke = '1';
    $keterangan = 'berhasil';
    $jawaban = array(
		    "oke" => $oke,
		    "keterangan" => $keterangan,
		    "jumlah_alamat" => $jumlah_alamat,
    	);
    echo json_encode($jawaban);
    
}
if( isset($_POST['konfirm_order']) && $_POST['konfirm_order'] == MOBILE_FORM ) {
    $id_pesanan = secure_string($_POST['idorder']);
    $id_user    = secure_string($_POST['iduser']);
    $tgl_database  = strtotime('now');
    
    $string  = '1|'.$id_user.'|'.$tgl_database;
    
    $args =  "UPDATE pesanan set status_3_cust='$string', status='50' WHERE id='$id_pesanan' AND id_user='$id_user'";
    $result = mysqli_query( $dbconnect, $args );
     if ( $result ) {
         $oke = '1';
         $keterangan = 'berhasil';
         $error  ='0';
     } else {
         $oke = '0';
         $keterangan = 'gagal';
         $error = mysqli_error( $dbconnect );
     }
      $jawaban = array(
		    "oke" => $oke,
		    "keterangan" => $keterangan,
		    "error" => $error,
    	);
    echo json_encode($jawaban);
}


if( isset($_POST['kirim_welcome']) && $_POST['kirim_welcome'] == MOBILE_FORM ) {
    $nama       = secure_string($_POST['nama']);
    $telp       = secure_string($_POST['telp']);
    $email      = secure_string($_POST['email']);
    $date       = strtotime('now');
    
    $args   = "INSERT INTO data_pengguna ( nama, email, telp ,date) VALUES ( '$nama', '$email', '$telp' , '$date')";
    $result = mysqli_query( $dbconnect, $args );
     if ( $result ) {
         $oke        = '1';
         $keterangan = 'berhasil';
         $error      ='0';
     } else {
         $oke        = '0';
         $keterangan = 'gagal';
         $error      = mysqli_error( $dbconnect );
     }
      $jawaban = array(
		    "oke"        => $oke,
		    "keterangan" => $keterangan,
		    "error"      => $error,
    	);
    echo json_encode($jawaban);
}
if ( isset($_POST['pass_serial']) && $_POST['pass_serial']==MOBILE_FORM ) {
	
	$user_mail = secure_string($_POST['emailforget']);
	
	if ( !check_mail($user_mail) ) {
	    
	        $oke ='2';
		    $keterangan ="gagal";
		    $error ="Noemail";
	    
	}
	else {
		// generate code & insert
		$passcode = md5($user_mail.USER_GETPASS).md5( strtotime('now').USER_GETPASS );
		$passtime = strtotime('now') + 172800;
		$passlink = 'https://www.ideasmart.id/recoverpass/?user=recoverpass&token='.$passcode;
		
		$args = "UPDATE user SET passcode='$passcode', passtime='$passtime' WHERE email='$user_mail'";
		$update = mysqli_query( $dbconnect, $args );
		$mail = "autosend@ideasmart.id";
		$mail_rep = "reply@ideamsart.id";
		

$textmail = "
Halo,
Kami telah menerima permintaan untuk mereset password akun IdeaSmart milik Anda.
Silahkan klik link berikut untuk mengganti password Anda.

".$passlink."

Link ini hanya aktif selama 24 jam.
Jika Anda memang tidak pernah meminta untuk mengganti password,
maka mohon abaikan atau hapus saja email ini.

Regards,
IdeaSmart team

-------------------------------------------------------
Ini hanyalah email notifikasi. Jangan dibalas.";

$subjectmail = 'Penggantian Password';




		$theheader = "From: ".$mail." \r\n";
		$theheader.= "Reply-To: ".$mail_rep." \r\n";
		$theheader.= "X-Mailer: PHP/".phpversion()." \r\n"; 
		$theheader.= "MIME-Version: 1.0" . " \r\n";
		$theheader.= "Content-Type: text/plain; charset=utf-8 \r\n";
		
		// sendmail
		$sendmail = mail( $user_mail, $subjectmail, $textmail, $theheader );
		
		if (  $update ) { 
		   
		    $oke ='1';
		    $keterangan ="berhasil";
		    $error ="None";
		    
		}
		else { 
		    $oke ='1';
		    $keterangan ="berhasil";
		    $error =mysqli_error($dbconnect);
		    }
	}
	
	$jawaban = array(
		    "oke" => $oke,
		    "keterangan" => $keterangan,
		    "error" => $error,
    	);
    echo json_encode($jawaban);
	
}


if( isset($_POST['addwishlist']) && $_POST['addwishlist'] == MOBILE_FORM ) {
    $idproduk_lokal         = $_POST['idproduk'];
    $iduser                 = $_POST['iduser'];
    $array_wishlist_user    = querydata_user($iduser,'array_wishlist');
    $simpan_array           = array();
	$array_status           = array();
	$produk                 = array();
	
	    if ( $array_wishlist_user == '' ) {
		    $simpan_array_1 = $idproduk_lokal;
		    $datakembali    = $simpan_array_1;
	    } else {
	        $array_wishlist = explode('|',$array_wishlist_user);
	    	$simpan_array_1 = $idproduk_lokal;
	    	$jumlah_item = count($array_wishlist) - 1;
	    	$x = 0;
	    	while($x <= $jumlah_item) {
			    $arraydata = explode('|',$array_wishlist[$x]);
				    if ($arraydata[0] == $idproduk_lokal) {
						$array_status[] = 1;
				    } else {
					    $simpan_array[] = $array_wishlist[$x];
					    $array_status[] = 0;
				    }
			    $x++;
		    }
		    $jumlah = array_sum($array_status);
		    $array_jadi = join("|",$simpan_array);
		    
		    if ( $jumlah == 0 ) {
			    $datakembali = $simpan_array_1.'|'.$array_jadi;
	        } else {
			    $datakembali = $array_jadi;
		    }
	    }
	           
	    $update_wishlist = "UPDATE user set array_wishlist='$datakembali' where id='$iduser'";
	    $result          = mysqli_query( $dbconnect, $update_wishlist );
	    
	        if ( $result ) {
	            $oke        = "1";
	            $keterangan = "berhasil";
	            $wishlist   = $datakembali;
	            $error      = "";
	        } else {
	            $oke        = "0";
	            $keterangan = "gagal";
	            $wishlist   = "";
	            $error      = mysqli_error($dbconnect);
	        }

        $jawaban = array(
		    "oke" => $oke,
		    "keterangan" => $keterangan,
		    "wishlist" => $wishlist,
		    "produk" => $produk,
		    "error" => $error,
    	);
        
        echo json_encode($jawaban);
}

if( isset($_POST['getwishlist']) && $_POST['getwishlist'] == MOBILE_FORM ) {
    $iduser                 = $_POST['id'];
    
    //cari pesanan
	$args                   = "SELECT * FROM user WHERE id='$iduser'";
    $result                 = mysqli_query( $dbconnect, $args );
	$data_wishlist          = mysqli_fetch_array($result);
	$array_wishlist_user    = $data_wishlist['array_wishlist'];
    $array_wishlist         = explode('|',$array_wishlist_user);
	$jumlah_item            = count($array_wishlist) - 1;
	$x = 0;
	$produk                 = array();
	
	while($x <= $jumlah_item) {
    	$idproduk_tampil = $array_wishlist[$x];
    	$args_produk="SELECT * FROM produk WHERE id='$idproduk_tampil'";
        $result_produk=mysqli_query($dbconnect, $args_produk);
        $row        =mysqli_num_rows($result_produk);
        if($result_produk){
            if($row > 0){
               $data_produk=mysqli_fetch_array($result_produk);
               $parcel     = parcel($data_produk['id']);
    		    $stok       = all_stok_prod($data_produk['id'],'stock_tersedia');
    		    if ($parcel == '0'){
    		        $data_stock = all_stok_prod($data_produk['id'],'stock_tersedia');
    		    }else{
    		        if($stok > 0){
    		          $data_stock = parcelformaster($data_produk['id']);  
    		        }  
    		    }
                $produk[]=array(
                    "id"            => $data_produk['id'],
                    "title"         => $data_produk['title'],
                    "trim"          => $data_produk['short_title'],
                    "harga"         => $data_produk['harga'],
                    "promo"         => $data_produk['promo'],
                    "hargapromo"    => $data_produk['harga_promo'],
                    "image"         => $data_produk['image'],
                    "filter"        => $data_stock,
                ); 
            }else{}
        }$x++;
	}
	if ( $result ) {
	  $oke        = "1";
	  $keterangan = "berhasil";
	  $error      = "";
	} else {
	  $oke        = "0";
	  $keterangan = "gagal";
	  $error      = mysqli_error($dbconnect);
	}

    $jawaban = array(
		"oke"        => $oke,
		"keterangan" => $keterangan,
		"produk"     => $produk,
		"error"      => $error,
		"row_wishlist" => $row_wishlist,
		
    );
    echo json_encode($jawaban);
}


if(isset($_POST['searchproduk']) && $_POST['searchproduk'] == MOBILE_FORM){
    $produk     = secure_string($_POST['produk']);
    $args       = "SELECT * FROM produk WHERE title LIKE '$produk%'";
    $result     = mysqli_query($dbconnect,$args);
    $jumlah     = mysqli_num_rows($result);

    if($result){
        while($data = mysqli_fetch_array($result)){
            $parcel     = parcel($data['id']);
		    $stok       = all_stok_prod($data['id'],'stock_tersedia');
		    if ($parcel == '0'){
		        $data_stock = all_stok_prod($data['id'],'stock_tersedia');
		    }else{
		        if($stok > 0){
		          $data_stock = parcelformaster($data['id']);  
		        }
		        
		    }
            $search[]=array(
                "nama"=>$data['title'],
                "promo"=>$data['promo'],
                "id"=>$data['id'],
                "data_stock"=>$data_stock,
            );
        }
        
            $oke ='1';
		    $keterangan ="berhasil";
		    $error ="None";
		    
    }else { 
		    $oke ='1';
		    $keterangan ="berhasil";
		    $error =mysqli_error($dbconnect);
    } 
        
    $jawaban = array(
        "oke"=>$oke,
        "keterangan"=>$keterangan,
        "error"=>$error,
        "title"=>$search,
        "jumlah" =>$jumlah
        );    
        
    echo json_encode($jawaban);
}

// LIST PRODUK PROMO
if ( isset($_POST['get_promo']) && $_POST['get_promo']==MOBILE_FORM ) {
	$limit = secure_string($_POST['limit']);
	if ( $limit == 1 ) {
		$args="SELECT * FROM produk WHERE promo = '1' ORDER BY id DESC LIMIT 9";
	} else {
		$args="SELECT * FROM produk WHERE promo = '1' ORDER BY id DESC";
	}
	
	$result = mysqli_query( $dbconnect, $args );
	$produk = array();
	
	if ( $result ) {
		while ( $data_produk = mysqli_fetch_array($result) ) {
		    $parcel     = parcel($data_produk['id']);
		    $stok       = all_stok_prod($data_produk['id'],'stock_tersedia');
		    if ($parcel == '0'){
		        $data_stock = all_stok_prod($data_produk['id'],'stock_tersedia');
		    }else{
		        if($stok > 0){
		          $data_stock = parcelformaster($data_produk['id']);  
		        }
		        
		    }
			$produk[] = array(
				"id" => $data_produk['id'],
				"idcabang" => $data_produk['idcabang'],
				"idkategori" => $data_produk['idkategori'],
				"cabang" => $data_produk['idcabang'],
				"kategori" => $data_produk['idkategori'],
				"title" => $data_produk['title'],
				"trim_title" => excerptmobile($data_produk['short_title'],40),
				"harga" => $data_produk['harga'],
				"promo" => $data_produk['promo'],
				"hargapromo" => $data_produk['harga_promo'],
				"deskripsi" => $data_produk['deskripsi'],
				"stock" => $data_produk['stock'],
				"image" => $data_produk['image'],
				"filter" => $data_stock,
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

//save_time_version
if( isset($_POST['save_time_version']) && $_POST['save_time_version'] ==MOBILE_FORM ) {
    $iduser     = secure_string($_POST['iduser']);
    $waktu_show = strtotime('now');
    $args_simpanwaktu   = "UPDATE user SET time_version_show ='$waktu_show' WHERE id ='$iduser'";
    $result_simpanwaktu = mysqli_query( $dbconnect, $args_simpanwaktu);
}

//get_time_version
if( isset($_POST['get_time_version']) && $_POST['get_time_version'] ==MOBILE_FORM ) {
    $iduser     = secure_string($_POST['iduser']);
    $args = "SELECT time_version_show FROM user WHERE id ='$iduser'";
    $result = mysqli_query( $dbconnect, $args);
     
      if( $result ) {
          
          $data = mysqli_fetch_array( $result );
          
          $ambil_waktu = value_dataoption("waktu_notifikasi_version"); // 1
          $waktu_total = $ambil_waktu * 3600;
          $waktu_akhir = $data['time_version_show'] + $waktu_total;
          $ambil_versi = value_dataoption('App_Version');
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
		    "ambil_versi" => $ambil_versi,
    	);
	    echo json_encode($jawaban);
}

//get data from duitku
if( isset($_POST['get_duitku']) && $_POST['get_duitku'] ==MOBILE_FORM ) {
    $reference_id     = secure_string($_POST['reference_id']);
    $args = "SELECT * FROM callback_duitku WHERE reference_payment ='$reference_id'";
    $result = mysqli_query( $dbconnect, $args);
     
      if( $result ) {
          $data = mysqli_fetch_array( $result );
          $jenis_pembayaran = $data['jenis_pembayaran'];
          $oke = '1';
          $keterangan = 'berhasil';
         
      } else {
          $oke = '0';
          $keterangan = 'gagal';
          $jenis_pembayaran = '0';
      }
      
      $jawaban = array(
		    "oke" => $oke,
		    "keterangan" => $keterangan,
		    "pembayaran" => $jenis_pembayaran,
    	);
	    echo json_encode($jawaban);
}

?>