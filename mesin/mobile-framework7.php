<?php require "function.php";

// LIST PRODUK
if ( isset($_POST['listproduk']) && $_POST['listproduk']==MOBILE_FORM ) {
	$args="SELECT * FROM produk ORDER BY id DESC";
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
				"harga" => $data_produk['harga'],
				"deskripsi" => $data_produk['deskripsi'],
				"stock" => $data_produk['stock'],
				"stock_order" => $data_produk['stock_order'],
				"image" => $data_produk['image'],
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
	$idkategori = secure_string($_POST['idkategori']);
	$kategori_name = data_tabel($tabelname, $idkategori, 'kategori');
	$kategori_deskripsi = data_tabel($tabelname, $idkategori, 'deskripsi');
	$args="SELECT * FROM produk WHERE idkategori='$idkategori'";
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
				"harga" => $data_produk['harga'],
				"deskripsi" => $data_produk['deskripsi'],
				"stock" => $data_produk['stock'],
				"stock_order" => $data_produk['stock_order'],
				"image" => $data_produk['image'],
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
		"kategori_deskripsi" => $kategori_deskripsi,
		"jumlah" => $jumlah,
	);
	echo json_encode($jawaban);
}

// DETAIL PRODUK
if ( isset($_POST['detailproduk']) && $_POST['detailproduk']==MOBILE_FORM ) {
	
}

// LIST KATEGORI HOME
if ( isset($_POST['listkategori']) && $_POST['listkategori']==MOBILE_FORM ) {
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
?>