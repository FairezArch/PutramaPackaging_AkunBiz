<?php 
error_reporting(E_ALL);
include "function.php";

// Add cabang
if ( isset($_POST['updatecabang']) && $_POST['updatecabang']==GLOBAL_FORM ) {
	$idcabang = secure_string($_POST['idcabang']);
	$cabang = secure_string($_POST['cabang']);
	$alamat = secure_string($_POST['alamat']);
	$telp = secure_string($_POST['telp']);
	
	// perintah SQL
	if ( $idcabang == '0' || $idcabang == '' ) {
		$upcabang ="INSERT INTO cabang ( nama, telp, alamat ) VALUES ( '$cabang', '$telp', '$alamat' )";
		$result = mysqli_query( $dbconnect, $upcabang );
	} else {
		$upcabang ="UPDATE cabang SET nama='$cabang', alamat='$alamat', telp='$telp' WHERE id='$idcabang'";
		$result = mysqli_query( $dbconnect, $upcabang );
	}
	if ($result){
		echo "berhasil";
	} else {
		echo "gagal";
	}
}

// Add & Update Kategori
if ( isset($_POST['updatekat']) && $_POST['updatekat']==GLOBAL_FORM ) {
	$idkategori = secure_string($_POST['idkategori']);
	$kat_name = secure_string($_POST['kat_name']);
	$imgkategori = secure_string($_POST['imgkategori']);
    $urutan = secure_string($_POST['urutan']);
	
	// perintah SQL
	if ( $idkategori == '0' || $idkategori == '' ) {
		$updatekat ="INSERT INTO kategori ( kategori, imgkategori, urutan ) VALUES ( '$kat_name', '$imgkategori', '$urutan' )";
		$result = mysqli_query( $dbconnect, $updatekat );
	} else {
		$updatekat ="UPDATE kategori SET kategori='$kat_name', imgkategori='$imgkategori', urutan='$urutan' WHERE id='$idkategori'";
		$result = mysqli_query( $dbconnect, $updatekat );
	}
	if ($result){
		echo "berhasil";
	} else {
		echo "gagal";
	}
}
// Add Produk
if ( isset($_POST['upproduk']) && $_POST['upproduk']==GLOBAL_FORM ) {
	$idproduk = secure_string($_POST['idproduk']);
	$idparcel = secure_string($_POST['idparcel']);
	$idcabang = secure_string($_POST['idcabang']);
	$idkategori_child = secure_string($_POST['idkategori']);
    $idkategori_master = data_kategori($idkategori_child,'id_master');
	//$cabang = secure_string($_POST['cabang']);
	//$kategori = secure_string($_POST['kategori']);
    $barcode = secure_string($_POST['barcode']);
	$title = secure_string($_POST['title']);
	$sku = secure_string($_POST['sku']);
	$harga = secure_string($_POST['harga']);
	$deskripsi = secure_string($_POST['deskripsi']);
	//$stock = secure_string($_POST['stock']);
	//$stock_order = secure_string($_POST['prodorder']);
	$imgproduk = secure_string($_POST['imgproduk']);

	$status_promo = secure_string($_POST['status_promo']);
	$harga_promo = secure_string($_POST['harga_promo']);
	
	//$idkatnow = secure_string($_POST['idkatnow']);
	//$idkatchange = secure_string($_POST['idkatchange']);
	//$produkpram = secure_string($_POST['produkpram']);
    
    $nama_produk = secure_string($_POST['nama_produk']);
    $satuan = secure_string($_POST['satuan']);
    $jml_satuan = secure_string($_POST['jml_satuan']);
    $harga_beli = secure_string($_POST['harga_beli']);
    $url_tokped = secure_string($_POST['url_tokped']);
    $url_bl = secure_string($_POST['url_bl']);
    $url_shopee = secure_string($_POST['url_shopee']);
    $url_wa = secure_string($_POST['url_wa']);

 	//$idparcel = secure_string($_POST['list_idparcel']);
    $nama_prod= secure_string($_POST['list_id_namaprod']);
    $itemtotal= secure_string($_POST['list_jumlah']);

    $status_parcel = secure_string($_POST['status_parcel']);
    $stock_limit = secure_string($_POST['stock_limit']);
    $status_grosir = secure_string($_POST['status_grosir']);

    $list_min_grosir = secure_string($_POST['list_min_grosir']);
    //$list_max_grosir = secure_string($_POST['list_max_grosir']);
    $list_harga_grosir = secure_string($_POST['list_harga_grosir']);

    $exp_min_grosir = explode('|', $list_min_grosir);
    //$exp_max_grosir = explode('|', $list_max_grosir);
    $exp_harga_grosir = explode('|', $list_harga_grosir);

    $berat = secure_string($_POST['berat']);
    $pilih_berat = secure_string($_POST['pilih_berat']);

  
    /*$array_min = array();
    $array_max = array();
    $y=0;
    while($y <= $count_grosir){
    	if($exp_min_grosir[$y] !== '' && $count_grosir[$y] !== '0'){
    		$array_min[] = $exp_min_grosir[$y];
    		$array_max[] = $exp_max_grosir[$y];
    	}
    }*/
    //$stock_produksi = secure_string($_POST['stock_produksi']);

 	//$get_idparcel = explode('|', $idparcel);
    $get_namaprod = explode('|', $nama_prod);
    $get_itemtotal= explode('|', $itemtotal);

    $jumlah_parcel = count($get_namaprod) - 1;
    //$arraynew_idparcel = array(); 
    $arraynew_namaprod = array(); 
    $arraynew_itemtotal = array();
    $a = 0;
    while($a <= $jumlah_parcel) {
        if($get_namaprod[$a] !== '' && $get_namaprod[$a] !== '0'){
            $arraynew_namaprod[] = $get_namaprod[$a];
            $arraynew_itemtotal[] = $get_itemtotal[$a];

        } 
        $a++;
    }

    $list_namaprod = join('|', $arraynew_namaprod);
    $list_itemtotal = join('|', $arraynew_itemtotal);

    $str_time = strtotime("now");
    $transorder_get_namaprod = explode("|", $nama_prod);

    $jml_parcel = count($transorder_get_namaprod) -1;
    $number = 0;

    /*$query = "SELECT max(id) as maxKode FROM produk";
    $hasil = mysqli_query($dbconnect,$query);
    $data = mysqli_fetch_array($hasil);
    $kodeBarang = $data['maxKode'];
    $noUrut = (int) substr($kodeBarang, 0, 3);
    $noUrut++;
    $kodeBarang = sprintf("%08u", $noUrut);
	/*echo $kodeBarang;
 	$num_barcode = '023111';
    $get_str = substr($num_barcode, 2, 4);
    $get_str +1; //echo $get_str;//$date = date('dmY'); echo $date;*/
    
   // $status_promo = secure_string($_POST['status_promo']);
   // $harga_promo = secure_string($_POST['harga_promo']);
	
	// perintah SQL
	if ( $idproduk == '0' || $idproduk == '') {
		$upproduk ="INSERT INTO produk ( idcabang, idkategori, idsubkategori, title, short_title, sku, deskripsi, harga, promo, harga_promo, stock_limit, image, link_tokped, link_bl, link_shopee, satuan, jml_persatuan, harga_produk, berat_barang, satuan_berat ) VALUES ( '$idcabang', '$idkategori_master', '$idkategori_child', '$title', '$nama_produk', '$sku', '$deskripsi', '$harga', '$status_promo', '$harga_promo', '$stock_limit', '$imgproduk', '$url_tokped', '$url_bl', '$url_shopee', '$satuan', '$jml_satuan', '$harga_beli', '$berat', '$pilih_berat' )";
		$result = mysqli_query( $dbconnect, $upproduk );
		$idproduk = mysqli_insert_id($dbconnect);
		
		if($barcode == ''){$get_barcode = sprintf("%08u", $idproduk);}else{$get_barcode = $barcode;}
		$args_bar = "UPDATE produk set barcode='$get_barcode' WHERE id='$idproduk'";
		$result_bar = mysqli_query( $dbconnect, $args_bar);
	} else {
		$upproduk ="UPDATE produk SET idcabang='$idcabang', idkategori='$idkategori_master', idsubkategori='$idkategori_child', barcode='$barcode', title='$title', short_title='$nama_produk', sku='$sku', deskripsi='$deskripsi', harga='$harga', promo='$status_promo', harga_promo='$harga_promo', stock_limit='$stock_limit', image='$imgproduk', link_tokped='$url_tokped', link_bl='$url_bl', link_shopee='$url_shopee', satuan='$satuan', jml_persatuan='$jml_satuan', harga_produk='$harga_beli', berat_barang='$berat', satuan_berat='$pilih_berat' WHERE id='$idproduk'";
		$result = mysqli_query( $dbconnect, $upproduk );
	}
	//$result = mysqli_query( $dbconnect, $upproduk );

	if($status_grosir == '1'){

		$cek_grosir = "SELECT * FROM daftar_grosir WHERE id_produk='$idproduk'";
		$result_grosir = mysqli_query($dbconnect,$cek_grosir);
		$data_grosir = mysqli_num_rows($result_grosir);
		$array_grosir = mysqli_fetch_array($result_grosir);

		if($data_grosir > $number){
			$upproduk_gro = "UPDATE daftar_grosir SET qty_from='$list_min_grosir', harga_satuan='$list_harga_grosir' WHERE id_produk='$idproduk'";
		}else{
			$upproduk_gro = "INSERT INTO daftar_grosir ( qty_from, id_produk, harga_satuan ) VALUES ( '$list_min_grosir', '$idproduk', '$list_harga_grosir' )";

		}
		$result_gro = mysqli_query( $dbconnect, $upproduk_gro );
		/*$angka=0;
		while($angka <= $count_grosir ){
			if($data_grosir > $number){
				$upproduk_gro = "DELETE FROM daftar_grosir WHERE id_produk='$idproduk'";
				$result_gro = mysqli_query( $dbconnect, $upproduk_gro );
				if($data_grosir < $number){
					$upproduk_gro = "INSERT INTO daftar_grosir ( qty_from, qty_to, id_produk, harga_satuan ) VALUES ( '$exp_min_grosir[$angka]', '$exp_max_grosir[$angka]', '$idproduk', '$exp_harga_grosir[$angka]' )";
					$result_gro = mysqli_query( $dbconnect, $upproduk_gro );
				}
			}else{
				
				$upproduk_gro = "INSERT INTO daftar_grosir ( qty_from, qty_to, id_produk, harga_satuan ) VALUES ( '$exp_min_grosir[$angka]', '$exp_max_grosir[$angka]', '$idproduk', '$exp_harga_grosir[$angka]' )";
				$result_gro = mysqli_query( $dbconnect, $upproduk_gro );
			}
			
			$angka++;
		}*/
		/*if($data_grosir > $number){
				$upproduk_gro = "UPDATE daftar_grosir SET qty_from='$list_min_grosir', qty_to='$list_max_grosir', harga_satuan='$list_harga_grosir' WHERE id_produk='$idproduk'";
			}else{
				$upproduk_gro = "INSERT INTO daftar_grosir ( qty_from, qty_to, id_produk, harga_satuan ) VALUES ( '$list_min_grosir', '$list_max_grosir', '$idproduk', '$list_harga_grosir' )";
			}*/
			

	}else{
		$result_gro = true;
		$del_produk = "DELETE FROM daftar_grosir WHERE id_produk='$idproduk'";
		$result_del = mysqli_query( $dbconnect,$del_produk );
	}
		/*
	}
	if($status_parcel == '1'){
		$lihat_produkitem = "SELECT * FROM produk_item WHERE id_prod_master='$idproduk'";
		$result_lihatproditem = mysqli_query( $dbconnect,$lihat_produkitem );
		$data = mysqli_num_rows($result_lihatproditem);
		
		$number = 0;
			if($data > $number){

				$upproduk_item="UPDATE produk_item SET id_prod_master='$idproduk', id_prod_item='$list_namaprod', jumlah_prod='$list_itemtotal' WHERE id_prod_master='$idproduk'";
			}else{

				$upproduk_item="INSERT INTO produk_item ( id_prod_master, id_prod_item, jumlah_prod ) VALUES ( '$idproduk', '$list_namaprod', '$list_itemtotal' )";	
			}
			$result_item=mysqli_query($dbconnect,$upproduk_item);

	} else {
		$result_item = true;	
		$del_upproduk = "DELETE FROM produk_item WHERE id_prod_master='$idproduk'";
		$result_del = mysqli_query( $dbconnect,$del_upproduk );
	}*/

	
	if ($result && $result_gro) {
        balance_jmlprodukkategori();
		echo "berhasil"; 
	} else {
		echo "gagal";
	}
}

// Add Produk
if ( isset($_POST['upproduk123']) && $_POST['upproduk123']==GLOBAL_FORM ) {
	$idproduk = secure_string($_POST['idproduk']);
	//$idparcel = secure_string($_POST['idparcel']);
	$idcabang = secure_string($_POST['idcabang']);
	$idkategori_child = secure_string($_POST['idkategori']);
    $idkategori_master = data_kategori($idkategori_child,'id_master');
	$cabang = secure_string($_POST['cabang']);
	//$kategori = secure_string($_POST['kategori']);
    $barcode = secure_string($_POST['barcode']);
	$title = secure_string($_POST['title']);
	$harga = secure_string($_POST['harga']);
	$deskripsi = secure_string($_POST['deskripsi']);
	$stock = secure_string($_POST['stock']);
	//$stock_order = secure_string($_POST['prodorder']);
	$imgproduk = secure_string($_POST['imgproduk']);

	$status_promo = secure_string($_POST['status_promo']);
	$harga_promo = secure_string($_POST['harga_promo']);
	//$idkatnow = secure_string($_POST['idkatnow']);
	//$idkatchange = secure_string($_POST['idkatchange']);
	//$produkpram = secure_string($_POST['produkpram']);
    
    $nama_produk = secure_string($_POST['nama_produk']);
    $satuan = secure_string($_POST['satuan']);
    $jml_satuan = secure_string($_POST['jml_satuan']);
    $harga_beli = secure_string($_POST['harga_beli']);

 	//$idparcel = secure_string($_POST['list_idparcel']);
    $nama_prod= secure_string($_POST['list_id_namaprod']);
    $itemtotal= secure_string($_POST['list_jumlah']);

    $status_parcel = secure_string($_POST['status_parcel']);

 	//$get_idparcel = explode('|', $idparcel);
    $get_namaprod = explode('|', $nama_prod);
    $get_itemtotal= explode('|', $itemtotal);

    $jumlah_parcel = count($get_namaprod) - 1;
    //$arraynew_idparcel = array(); 
    $arraynew_namaprod = array(); 
    $arraynew_itemtotal = array();
    $a = 0;
    while($a <= $jumlah_parcel) {
        if($get_namaprod[$a] !== '' && $get_namaprod[$a] !== '0'){
            //$arraynew_idparcel[] = $get_idparcel[$a];
            $arraynew_namaprod[] = $get_namaprod[$a];
            $arraynew_itemtotal[] = $get_itemtotal[$a];
        } 
        $a++;
    }

    //$list_id_parcel = join('|', $arraynew_idparcel);
    $list_namaprod = join('|', $arraynew_namaprod);
    $list_itemtotal = join('|', $arraynew_itemtotal);
    // $status_promo = secure_string($_POST['status_promo']);
    // $harga_promo = secure_string($_POST['harga_promo']);
	
	// perintah SQL

	if ( $idproduk == '0' || $idproduk == '' ) {
		$upproduk ="INSERT INTO produk ( idcabang, idkategori, idsubkategori, barcode, title, short_title, deskripsi, harga, promo, harga_promo, stock, image, satuan, jml_persatuan, harga_beli ) VALUES ( '$idcabang', '$idkategori_master', '$idkategori_child', '$barcode', '$title', '$nama_produk', '$deskripsi', '$harga', '$status_promo', '$harga_promo', '$stock', 
		'$imgproduk', '$satuan', '$jml_satuan', '$harga_beli')";
		$result = mysqli_query( $dbconnect, $upproduk );
		$last_id = mysqli_insert_id($dbconnect);
	} else {
		$upproduk ="UPDATE produk SET idcabang='$idcabang', idkategori='$idkategori_master', idsubkategori='$idkategori_child', barcode='$barcode', title='$title', short_title='$nama_produk', deskripsi='$deskripsi', harga='$harga', promo='$status_promo', harga_promo='$harga_promo', stock='$stock', image='$imgproduk', satuan='$satuan', jml_persatuan='$jml_satuan', harga_beli='$harga_beli' WHERE id='$idproduk'";
		$result = mysqli_query( $dbconnect, $upproduk );
		//$upproduk="UPDATE produk_item SET id_prod_item='$list_namaprod', jumlah_prod='$list_itemtotal' WHERE id_prod_master='$idproduk'";
		//$result = mysqli_query( $dbconnect, $upproduk );	
	}

	if($idproduk == '0' || $idproduk == '' && $status_parcel == '1'){
		$upproduk="INSERT INTO produk_item (id_prod_master, id_prod_item, jumlah_prod) VALUES ('$last_id', '$list_namaprod', '$list_itemtotal')";
		$result = mysqli_query( $dbconnect, $upproduk );

	}elseif($status_parcel == '1'){
		$upproduk = "DELETE FROM produk_item WHERE id_prod_master='$idproduk'";
		$result = mysqli_query($dbconnect,$upproduk);

		$upproduk="INSERT INTO produk_item (id_prod_master, id_prod_item, jumlah_prod) VALUES ('$idproduk', '$list_namaprod', '$list_itemtotal')";
		$result = mysqli_query( $dbconnect, $upproduk );
	}else{
		$upproduk = "DELETE FROM produk_item WHERE id_prod_master='$idproduk'";
		$result = mysqli_query($dbconnect,$upproduk);
	}

	if ($result) {
        balance_jmlprodukkategori();
		echo "berhasil"; 
	} else {
		echo "gagal";
	}
	
    /*
	if ( $produkpram == 'baru' ) {
		$jml_prod = jmlprodkat($idkategori);
	} else {
		if ( $idkategori == $idkatnow && $idkatchange == '' ) {
			$jml_prod = jmlprodkat($idkatnow);
		} else {
			$jml_prod = jmlprodkatmin($idkatnow,$idkatchange);
		}
	}
    */
}

// add new member
if ( isset($_POST['save_newperson']) && $_POST['save_newperson'] == GLOBAL_FORM){
	$member_id = secure_string($_POST['member_id']);
	$name_member = secure_string($_POST['name_member']);
	$pass_member = secure_string($_POST['pass_member']);
	$db_pass = md5($pass_member.USER_PASS);
	$tgl_database = strtotime('now');
	$status_user = secure_string($_POST['status_user']);
	$email_member = secure_string($_POST['email_member']);
	$tgl_lahir = secure_string($_POST['tgl_lahir']);
	$db_tgllahir = strtotime($tgl_lahir);

	$args_telp = "SELECT telp FROM user_member WHERE telp='$member_id'";
	$cari_telp = mysqli_query($dbconnect,$args_telp);

	$args_email = "SELECT email FROM user_member WHERE email='$email_member'";
	$cari_email = mysqli_query($dbconnect,$args_email);
	if( mysqli_num_rows($cari_telp) ){
		echo "nomorsudahdigunakan";
	}else if(mysqli_num_rows($cari_email)){
		echo "emailsudahdigunakan"; 
	}else{
		if($status_user == 1){
			$preg_str = preg_replace('/0/','62',$member_id);
			$verifcode = md5($email.USER_GETPASS).md5(strtotime('now').USER_GETPASS);
			$veriftime = strtotime('now') + 172800;
			$veriflink = GLOBAL_URL.'/verification/?checkup=verification&token='.$verifcode;
			$adduser ="INSERT INTO user_member ( nama, tanggal_lahir, email, telp, password, status_user, tanggal_daftar, passcode, passtime ) VALUES ( '$name_member', '$db_tgllahir', '$email_member', '$member_id', '$db_pass', '$status_user', '$tgl_database', '$verifcode', '$veriftime' )";
		}else{
			$adduser ="INSERT INTO user_member ( nama, tanggal_lahir, email, telp, password, status_user, tanggal_daftar ) VALUES ( '$name_member', '$db_tgllahir', '$email_member', '$member_id', '$db_pass', '$status_user', '$tgl_database' )";
			$preg_str = '';
			$veriflink='';
		}
		$result = mysqli_query( $dbconnect, $adduser );
		if ($result){
			echo "berhasil##".$veriflink."##".$preg_str;
		} else {
			echo "gagal";
		}
	}
}

if ( isset($_POST['update_verif']) && $_POST['update_verif']==GLOBAL_FORM ){
	$verif_id    = secure_string($_POST['verif_id']);
	$verif_telp  = secure_string($_POST['verif_telp']);
	$verif_email = secure_string($_POST['verif_email']);

	$preg_str = preg_replace('/0/','62',$verif_telp);
	$verifcode = md5($verif_email.USER_GETPASS).md5(strtotime('now').USER_GETPASS);
	$veriftime = strtotime('now') + 172800;
	$veriflink = GLOBAL_URL.'/verification/?checkup=verification&token='.$verifcode;

	$args_verif = "UPDATE user_member SET passcode='$verifcode', passtime='$veriftime' WHERE id='$verif_id'";
	$result = mysqli_query( $dbconnect, $args_verif );

	if($result){
		echo "berhasil##".$veriflink."##".$preg_str;
	}else{
		echo "gagal";
	}

}

// Add User
if ( isset($_POST['adduser']) && $_POST['adduser']==GLOBAL_FORM ) {
	$iduser = secure_string($_POST['iduser']);
	$nama = secure_string($_POST['nama']);
	$email = secure_string($_POST['email']);
	$password = secure_string($_POST['password']);
	$db_pass = md5($password.USER_PASS);
	$user_role = secure_string($_POST['user_role']);
	$telp = secure_string($_POST['telp']);
	$alamat = secure_string($_POST['alamat']);
	$tgl_lahir = secure_string($_POST['tgl_lahir']);
	$imguser = secure_string($_POST['imguser']);
	$tgl_database = strtotime('now');
	//$saldo = secure_string($_POST['saldo']);
	$select_sendlink = secure_string($_POST['select_sendlink']);

	$time_tgllahir = strtotime($tgl_lahir);
	$bulan = date('n',$time_tgllahir);
	$tahun = date('Y',$time_tgllahir);

	$email_to = 'fairez942013@gmail.com';
	$add_userstatus = secure_string($_POST['add_userstatus']);
	$args_telp = "SELECT telp FROM user_member WHERE telp='$telp'";
	$cari_telp = mysqli_query($dbconnect,$args_telp);
	// perintah SQL
	$args_email = "SELECT email FROM user_member WHERE email='$email'";
	$cari_email = mysqli_query($dbconnect,$args_email);
	if( mysqli_num_rows($cari_telp) ){
		echo "nomorsudahdigunakan";
	}else if(mysqli_num_rows($cari_email)){
		echo "emailsudahdigunakan"; 
	} else {
		$adduser ="INSERT INTO user_member ( nama, tanggal_lahir, email, telp, alamat, password, status_user, tanggal_daftar, imguser, passcode, passtime ) VALUES ";

		$verifcode = md5($email_to.USER_GETPASS).md5(strtotime('now').USER_GETPASS);
		$veriftime = strtotime('now') + 172800;
		$veriflink = GLOBAL_URL.'/verification/?checkup=verification&token='.$verifcode;
		if( $add_userstatus == 1 ){
			if($select_sendlink == '0'){
				$preg_str = preg_replace('/0/','62',$telp);
				$adduser .= "( '$nama', '$time_tgllahir', '$email', '$telp', '$alamat', '$db_pass', '$add_userstatus', '$tgl_database', '$imguser', '$verifcode', '$veriftime' )";
			}else{
				$mail = "autosend@PutramaPackaging.id";
				$mail_rep = "reply@PutramaPackaging.id";

				$adduser .= "( '$nama', '$time_tgllahir', '$email', '$telp', '$alamat', '$db_pass', '$add_userstatus', '$tgl_database', '$imguser', '$verifcode', '$veriftime' )";

				$textmail = "
				Halo ".$nama.",

				Silahkan klik tautan berikut untuk memverifikasi akun kamu untuk menjadi member.

				".$veriflink."

				Link ini hanya aktif selama 24 jam.

				Regards,
				Putrama Packaging team

				-------------------------------------------------------
				Ini hanyalah email notifikasi. Jangan dibalas.";

				$subjectmail = 'Verifikasi Akun';

				$theheader = "From: ".$mail." \r\n";
				$theheader.= "Reply-To: ".$mail_rep." \r\n";
				$theheader.= "X-Mailer: PHP/".phpversion()." \r\n"; 
				$theheader.= "MIME-Version: 1.0" . " \r\n";
				$theheader.= "Content-Type: text/plain; charset=utf-8 \r\n";
				
				// sendmail
				$sendmail = mail( $email_to, $subjectmail, $textmail, $theheader );
				$preg_str='';
			}
		}else{
			$adduser .= "( '$nama', '$time_tgllahir', '$email', '$telp', '$alamat', '$db_pass', '$add_userstatus', '$tgl_database', '$imguser' )";
			$preg_str = '';
			$veriflink = '';
		}
		$result = mysqli_query( $dbconnect, $adduser );

		if ($result){
			echo "berhasil##".$veriflink."##".$preg_str;
		} else {
			echo "gagal";
		}
	}
}

// Edit User
if ( isset($_POST['edituser']) && $_POST['edituser']==GLOBAL_FORM ) {
	$iduser = secure_string($_POST['iduser']);
	$nama = secure_string($_POST['nama']);
	$email = secure_string($_POST['email']);
	$user_role = secure_string($_POST['user_role']);
	$telp = secure_string($_POST['telp']);
	$alamat = secure_string($_POST['alamat']);
	$tgl_lahir = secure_string($_POST['tgl_lahir']);
	$imguser = secure_string($_POST['imguser']);
	$tanggal_daftar = secure_string($_POST['tanggal_daftar']);
	$jam = secure_string($_POST['jam']);
	$menit = secure_string($_POST['menit']);
	$tgl_database = strtotime($tanggal_daftar.' '.$jam.':'.$menit);
	//$saldo = secure_string($_POST['saldo']);
	$edit_userstatus = secure_string($_POST['edit_userstatus']);

	$time_tgllahir = strtotime($tgl_lahir);

	$datedb = strtotime('now');
	$data_userpasscode = querydata_usermember($iduser,'passcode');
	$data_userpasstime = querydata_usermember($iduser,'passtime');
	$data_usermember = querydata_usermember($iduser,'status_user');

	$add_day = strtotime("+ 2 days",$data_userpasstime);

	if( $edit_userstatus == '1' && $datedb > $data_userpasstime ){
		$preg_str = preg_replace('/0/','62',$telp);
		$verifcode = md5($email.USER_GETPASS).md5(strtotime('now').USER_GETPASS);
		$veriftime = strtotime('now') + 172800;
		$veriflink = GLOBAL_URL.'/verification/?checkup=verification&token='.$verifcode;
			$mail = "autosend@PutramaPackaging.id";
		$mail_rep = "reply@PutramaPackaging.id";
		// perintah SQL
		$edituser ="UPDATE user_member SET nama='$nama', email='$email', telp='$telp', alamat='$alamat', tanggal_lahir='$time_tgllahir', status_user='$edit_userstatus', tanggal_daftar='$tgl_database', imguser='$imguser', passcode='$verifcode', passtime='$veriftime' WHERE id='$iduser'";

		$textmail = "
		Halo ".$nama.",

		Silahkan klik tautan berikut untuk memverifikasi akun kamu untuk menjadi member.

		".$veriflink."

		Link ini hanya aktif selama 24 jam.

		Regards,
		Putrama Packaging team

		-------------------------------------------------------
		Ini hanyalah email notifikasi. Jangan dibalas.";

		$subjectmail = 'Verifikasi Akun';

		$theheader = "From: ".$mail." \r\n";
		$theheader.= "Reply-To: ".$mail_rep." \r\n";
		$theheader.= "X-Mailer: PHP/".phpversion()." \r\n"; 
		$theheader.= "MIME-Version: 1.0" . " \r\n";
		$theheader.= "Content-Type: text/plain; charset=utf-8 \r\n";
		
		// sendmail
		$sendmail = mail( $email, $subjectmail, $textmail, $theheader );
	}else if( $edit_userstatus == '1' && $data_usermember == '0' ){ // dari non member ke member
		// perintah SQL
		$edituser ="UPDATE user_member SET nama='$nama', email='$email', telp='$telp', alamat='$alamat', tanggal_lahir='$time_tgllahir', status_user='$edit_userstatus', tanggal_daftar='$tgl_database', imguser='$imguser', passcode='$', passtime='0' WHERE id='$iduser'";
		$preg_str = preg_replace('/0/','62',$telp);
		$verifcode = md5($email.USER_GETPASS).md5(strtotime('now').USER_GETPASS);
		$veriftime = strtotime('now') + 172800;
		$veriflink = GLOBAL_URL.'/verification/?checkup=verification&token='.$verifcode;
			$mail = "autosend@PutramaPackaging.id";
		$mail_rep = "reply@PutramaPackaging.id";
		// perintah SQL
		$edituser ="UPDATE user_member SET nama='$nama', email='$email', telp='$telp', alamat='$alamat', tanggal_lahir='$time_tgllahir', status_user='$edit_userstatus', tanggal_daftar='$tgl_database', imguser='$imguser', passcode='$verifcode', passtime='$veriftime' WHERE id='$iduser'";

		$textmail = "
		Halo ".$nama.",

		Silahkan klik tautan berikut untuk memverifikasi akun kamu untuk menjadi member.

		".$veriflink."

		Link ini hanya aktif selama 24 jam.

		Regards,
		Putrama Packaging team

		-------------------------------------------------------
		Ini hanyalah email notifikasi. Jangan dibalas.";

		$subjectmail = 'Verifikasi Akun';

		$theheader = "From: ".$mail." \r\n";
		$theheader.= "Reply-To: ".$mail_rep." \r\n";
		$theheader.= "X-Mailer: PHP/".phpversion()." \r\n"; 
		$theheader.= "MIME-Version: 1.0" . " \r\n";
		$theheader.= "Content-Type: text/plain; charset=utf-8 \r\n";
		
		// sendmail
		$sendmail = mail( $email, $subjectmail, $textmail, $theheader );
	}else if($edit_userstatus == '0' || $data_usermember == '1'){ // dari member ke non member
		// perintah SQL
		$edituser ="UPDATE user_member SET nama='$nama', email='$email', telp='$telp', alamat='$alamat', tanggal_lahir='$time_tgllahir', status_user='$edit_userstatus', tanggal_daftar='$tgl_database', imguser='$imguser', passcode='', passtime='0', end_member='$datedb' WHERE id='$iduser'";
		$preg_str = '';
		$veriflink = '';
	}else{
		// perintah SQL
		$edituser ="UPDATE user_member SET nama='$nama', email='$email', telp='$telp', alamat='$alamat', tanggal_lahir='$time_tgllahir', status_user='$edit_userstatus', tanggal_daftar='$tgl_database', imguser='$imguser' WHERE id='$iduser'";
		$preg_str = '';
		$veriflink = '';
	}
	$result = mysqli_query( $dbconnect, $edituser );

	if ($result){
		echo "berhasil##".$veriflink."##".$preg_str;
	} else {
		echo "gagal";
	}
}

// Update Pass User
if ( isset($_POST['editpass']) && $_POST['editpass']==GLOBAL_FORM ) {
	$iduser = secure_string($_POST['iduser']);
	$oldpass = secure_string($_POST['oldpass']);
	$confpass = secure_string($_POST['confpass']);
	
	$passlama_db = md5($oldpass.USER_PASS);
	$password_db = md5($confpass.USER_PASS);

	// cari apakah ada email yang sama
	$args_pass = "SELECT password FROM user_member WHERE password='$passlama_db'";
	$cari_pass = mysqli_query( $dbconnect, $args_pass );
	if ( mysqli_num_rows($cari_pass) ) {
		// Jika password sama, maka dilanjutin simpan data	
		// perintah SQL
		$editpass = "UPDATE user_member SET password='$password_db' WHERE id='$iduser'";
		$result = mysqli_query( $dbconnect, $editpass );
		if ($result){
			echo "berhasil";
		} else { 
			echo "gagal";
		}
	} else {
		echo "passwordsalah"; // jika ternyata tidak ada password sama, ditampilkan kata 'emailsalah'
	}
}

// Add User
if ( isset($_POST['saveteam']) && $_POST['saveteam']==GLOBAL_FORM ) {
	$nama = secure_string($_POST['nama']);
	$email = secure_string($_POST['email']);
	$password = secure_string($_POST['password']);
	$db_pass = md5($password.USER_PASS);
	$user_role = secure_string($_POST['user_role']);
	$telp = secure_string($_POST['telp']);
	$alamat = secure_string($_POST['alamat']);
	$imguser = secure_string($_POST['imguser']);
	$id_team = secure_string($_POST['id_team']);
	
	// perintah SQL
    $args_email = "SELECT email FROM user WHERE email='$email'";
    $cari_email = mysqli_query( $dbconnect, $args_email );
    if ( mysqli_num_rows($cari_email) && $id_team == '0' ) {
            echo "emailsalah";
    } else {
        if( $id_team > '0' ){
            $edituser ="UPDATE user SET nama='$nama', email='$email', telp='$telp', alamat='$alamat', user_role='$user_role', imguser='$imguser' WHERE id='$id_team'";
            $result = mysqli_query( $dbconnect, $edituser );
        }else{
            $adduser ="INSERT INTO user ( nama, email, telp, alamat, password, user_role, imguser ) VALUES ( '$nama', '$email', '$telp', '$alamat', '$db_pass', '$user_role', '$imguser' )";
            $result = mysqli_query( $dbconnect, $adduser );
        }
        if ($result){
            echo "berhasil";
        } else {
            echo "gagal";
        }
    }
}

// opsi hapus
if ( isset($_POST['opsi_hapus']) && $_POST['opsi_hapus']==GLOBAL_FORM ) {
	$metode = secure_string($_POST['metode']);
	//$hapus_parcel = secure_string($_POST['hapus_parcel']);
	$id = secure_string($_POST['id']);
	$idkatnow = secure_string($_POST['idkatnow']);
	$idkatchange = secure_string($_POST['idkatchange']);
	$idkategori = secure_string($_POST['idkategori']);
	if ( $metode == 'kategori' ) {
		$table = 'kategori';
		$args = "DELETE FROM $table WHERE id='$id'";
		$hapus = mysqli_query( $dbconnect, $args );
	} else if ( $metode == 'cabang' ) {
		$table = 'cabang';
		$args = "DELETE FROM $table WHERE id='$id'";
		$hapus = mysqli_query( $dbconnect, $args );
	} else if ( $metode == 'produk' ) {
		$table = 'produk';
		$table_parcel = 'produk_item';

		$args  = "DELETE FROM $table WHERE id='$id'";
		$hapus = mysqli_query( $dbconnect, $args );

		$args = "DELETE FROM daftar_grosir WHERE id_produk='$id'";
		$hapus_grosir = mysqli_query($dbconnect,$args);

		$args_parcel  = "DELETE FROM $table_parcel WHERE id_prod_master='$id'";
		$hapus_parcel = mysqli_query( $dbconnect, $args_parcel ); 
		if ( $idkategori == $idkatnow && $idkatchange == '' ) { $jml_prod = jmlprodkat($idkatnow); } else { $jml_prod = hapusprod($idkatnow); }
	} else if ( $metode == 'user' ) {
		$table = 'user';
		$args = "DELETE FROM $table WHERE id='$id'";
		$hapus = mysqli_query( $dbconnect, $args );
	} else if ( $metode == 'user_member' ) {
		$table = 'user_member';
		$args = "DELETE FROM $table WHERE id='$id'";
		$hapus = mysqli_query( $dbconnect, $args );
	}
	if ($hapus && $hapus_parcel) { echo 'berhasil'; }
}

// Add Produk
if ( isset($_POST['save_subkategori']) && $_POST['save_subkategori']==GLOBAL_FORM ) {
	$sub_namect = secure_string($_POST['sub_namect']);
	$id_masterct = secure_string($_POST['id_masterct']);
	$idsubkategori = secure_string($_POST['idsubkategori']);
    $imgkategori_sub = secure_string($_POST['imgkategori_sub']);
    
	// perintah SQL
	if ( $idsubkategori == '0' || $idsubkategori == '' ) {
		$args ="INSERT INTO kategori ( kategori, id_master, imgkategori ) VALUES ( '$sub_namect', '$id_masterct', '$imgkategori_sub' )";
	} else {
		$args ="UPDATE kategori SET kategori='$sub_namect', id_master='$id_masterct', imgkategori='$imgkategori_sub' WHERE id='$idsubkategori'";
	}
    $result = mysqli_query( $dbconnect, $args );
	if ($result){
		echo "berhasil";
	} else {
		echo "gagal";
	}
}

// plus min Saldo User
if ( isset($_POST['save_pmsaldo']) && $_POST['save_pmsaldo']==GLOBAL_FORM ) {	
	$date = secure_string($_POST['pmdate']);
	$hour = secure_string($_POST['pmhour']);
	$minute = secure_string($_POST['pmminute']);
	$nominal = secure_string($_POST['pmnominal']);
	$desc = secure_string($_POST['pmdesc']);
    
    $trans_id = secure_string($_POST['trans_id']);
	$trans_type = secure_string($_POST['trans_type']);
	$trans_iduser = secure_string($_POST['trans_iduser']);

	// persiapan
	$datedb = strtotime($date.' '.$hour.':'.$minute);
	$month = date('n',$datedb);
	$year = date('Y',$datedb);
    
	// input ke trans_saldo
    if( $trans_id == '0' ){
        $args = "INSERT INTO trans_saldo ( date, type, nominal, id_user, deskripsi )
                VALUES ( '$datedb', '$trans_type', '$nominal', '$trans_iduser', '$desc' )";
        $insert = mysqli_query( $dbconnect, $args );
        $trans_id = mysqli_insert_id($dbconnect);
    }else{
        $args = "UPDATE trans_saldo SET date='$datedb', type='$trans_type', nominal='$nominal', id_user='$trans_iduser', deskripsi='$desc' WHERE id='$trans_id'";
        $insert = mysqli_query( $dbconnect, $args );
    }
    $saldouser = update_saldo_user($trans_iduser);
    
	if ( $insert ) { echo "berhasil"; } else { echo "gagal"; }
}

// Delete plus min Saldo User
if ( isset($_POST['del_pmsaldo']) && $_POST['del_pmsaldo']==GLOBAL_FORM ) {	
	$id_pm = secure_string($_POST['id_pm']);
    $id_user = querydata_pmsaldo($id_pm,'id_user');
    
    // data trans saldo
	$args_saldo = "DELETE FROM trans_saldo WHERE id='$id_pm'";
	$del_saldo = mysqli_query( $dbconnect, $args_saldo );
    
    $saldouser = update_saldo_user($id_user);

    // RESULT
    if ( $del_saldo ) { echo 'berhasil'; }
    else { echo 'gagal'; }
}

// Request Saldo User
if ( isset($_POST['save_requestsaldo']) && $_POST['save_requestsaldo']==GLOBAL_FORM ) {	
	$iduser = secure_string($_POST['iduser']);
    $nominal = secure_string($_POST['req_nominal']);
    $req_type = secure_string($_POST['req_type']);
	$date_db = strtotime('now');
    
    // Cek data Request saldo di db
    $args_cek = "SELECT id FROM request_saldo WHERE id_user='$iduser' AND type='$req_type' AND status='0'";
    $result_cek = mysqli_query( $dbconnect, $args_cek );
    $count_cek=mysqli_num_rows($result_cek);
    if ($count_cek >= 1){
        $args_del = "DELETE FROM request_saldo WHERE id_user='$iduser' AND type='$req_type' AND status='0'";
        $result_del = mysqli_query( $dbconnect, $args_del );
    }
    
    // Insert Request Saldo Baru
    $args = "INSERT INTO request_saldo ( id_user, harga_awal, date_checkout, type )
                VALUES ( '$iduser', '$nominal', '$date_db', '$req_type' )";
    $insert = mysqli_query( $dbconnect, $args );
    $idreq = mysqli_insert_id($dbconnect);
    
    // Create Harga Unix
    if( $req_type == 'saldo' ){
        $last = (int) substr($idreq, -2);
        if ( $last >= 200 ) { $last = (int) substr($idreq, -2); }
        $totalbayar = $last + $nominal;
    }else{
        $last = 0;
        $totalbayar = $nominal;
    }

    //update total bayar
	$update = "UPDATE request_saldo SET total_bayar = '$totalbayar', kode_unik = '$last' WHERE id = '$idreq'";
	$result_update = mysqli_query( $dbconnect, $update );
    
	if ( $insert & $result_update ) { echo "berhasil"; } else { echo "gagal"; }
}

// Checker Order Saldo
if ( isset($_POST['status_reqsaldo']) && $_POST['status_reqsaldo']==GLOBAL_FORM ) {	
	$idreq= secure_string($_POST['idreq']);
    $status = secure_string($_POST['status']);
    
    $iduser = querydata_reqsaldo($idreq);
    $saldo = querydata_reqsaldo($idreq,'total_bayar');
    $saldouatama = querydata_reqsaldo($idreq,'harga_awal');
    $tgl_database = strtotime('now');
    //$id_trans_saldo = querydata_reqsaldo($idreq,'id_trans_saldo');
    
    $bonus_topup = querydata_dataoption('global_bnstopup');
    
    if( $status == '1' ){
        //update Status 
        $update = "UPDATE request_saldo SET status = '$status' WHERE id = '$idreq'";
        $result_update = mysqli_query( $dbconnect, $update );
    
        // Insert table trans Saldo
        $args_transsaldo = "INSERT INTO trans_saldo ( date, type, nominal, id_user, deskripsi, id_reqsaldo )
                VALUES ( '$tgl_database', 'plus', '$saldo', '$iduser', 'Penambahan Saldo User - Transfer Bank', '$idreq' )";
        $result_transsaldo = mysqli_query( $dbconnect, $args_transsaldo );
        $idtranssaldo = mysqli_insert_id($dbconnect);
        
        if ( $bonus_topup != '' && $bonus_topup != '0' ){
            $nominal_bonus = $saldouatama * $bonus_topup / 100;
             // Bonus Insert table trans Saldo
            $args_bonussaldo = "INSERT INTO trans_saldo ( date, type, nominal, id_user, deskripsi, id_reqsaldo )
                    VALUES ( '$tgl_database', 'plus', '$nominal_bonus', '$iduser', 'Bonus Top-up ID $idreq ($bonus_topup%)', '$idreq' )";
            $result_bonussaldo = mysqli_query( $dbconnect, $args_bonussaldo );
            $idtranssaldo_bonus = mysqli_insert_id($dbconnect);
        }else{
            $idtranssaldo_bonus = '';
        }
        
        if( $idtranssaldo_bonus != '' ){
            $idtranssaldo_total = $idtranssaldo."|".$idtranssaldo_bonus;
        }else{
            $idtranssaldo_total = $idtranssaldo;
        }
        
        /*
        //Update kembali table request saldo
        $update2 = "UPDATE request_saldo SET id_trans_saldo = '$idtranssaldo_total' WHERE id = '$idreq'";
        $result_update2 = mysqli_query( $dbconnect, $update2 );
        */
    }else{
         //update Status 
        $update = "UPDATE request_saldo SET status = '$status' WHERE id = '$idreq'";
        $result_update = mysqli_query( $dbconnect, $update );
        
        // dalete data table trans Saldo
        $args_transsaldo = "DELETE FROM trans_saldo WHERE id_reqsaldo='$idreq'";
        $result_transsaldo = mysqli_query( $dbconnect, $args_transsaldo );
        /*
        $array_idtrans_saldo = explode('|',$id_trans_saldo);
        $jumlah_idtrans_saldo = count($array_idtrans_saldo) - 1;
        $a = 0;
        while($a <= $jumlah_idtrans_saldo) {
            if ( $array_idtrans_saldo[$a] > 0 ){
                $args_transsaldo = "DELETE FROM trans_saldo WHERE id='$array_idtrans_saldo[$a]'";
                $result_transsaldo = mysqli_query( $dbconnect, $args_transsaldo );
            }
            $a++;
        }
        /*
        //Update kembali table request saldo
        $update2 = "UPDATE request_saldo SET id_trans_saldo = '0' WHERE id = '$idreq'";
        $result_update2 = mysqli_query( $dbconnect, $update2 );
        */
    }
    
    $saldouser = update_saldo_user($iduser);
	if ( $result_update && $result_transsaldo && $update2 ) { echo "berhasil"; } else { echo "gagal"; }
}

// Hapus Request Saldo User
if ( isset($_POST['del_reqsaldo']) && $_POST['del_reqsaldo']==GLOBAL_FORM ) {	
	$idreqsaldo = secure_string($_POST['id_reqsaldo']);

    $args_del = "DELETE FROM request_saldo WHERE id='$idreqsaldo'";
    $result_del = mysqli_query( $dbconnect, $args_del );
    
	if ( $result_del ) { echo "berhasil"; } else { echo "gagal"; }
}

// Checker Order Saldo - Pesanan
if ( isset($_POST['status_reqsaldo_pesanan']) && $_POST['status_reqsaldo_pesanan']==GLOBAL_FORM ) {	
	$idreq= secure_string($_POST['idreq']);
    $status = secure_string($_POST['status']);
    
    $idpesanan = querydata_reqsaldo($idreq,'id_pesanan');
    $iduser = current_user_id();
    $datedb = $tgl_database = strtotime('now');

    $cek_tipebayar = querydata_pesanan($idpesanan,'tipe_bayar');

    if( $status == '1' ){
        //update Status 
        $update = "UPDATE request_saldo SET status = '$status' WHERE id = '$idreq'";
        $result_update = mysqli_query( $dbconnect, $update );
        
        //Update table Pesanan
        $status_cek_bayar = '1|'.$iduser.'|'.$datedb;
        $update_pesanan = "UPDATE pesanan SET status = '10', status_cek_bayar='$status_cek_bayar' WHERE id = '$idpesanan'";
        $result_pesanan = mysqli_query( $dbconnect, $update_pesanan );
    }else{
         //update Status 
        $update = "UPDATE request_saldo SET status = '$status' WHERE id = '$idreq'";
        $result_update = mysqli_query( $dbconnect, $update );
        
        //Update table Pesanan
        $status_cek_bayar = '1|'.$iduser.'|0';
        $update_pesanan = "UPDATE pesanan SET status = '5', status_cek_bayar='$status_cek_bayar' WHERE id = '$idpesanan'";
        $result_pesanan = mysqli_query( $dbconnect, $update_pesanan );
    }
    
    //$saldouser = update_saldo_user($iduser);
	if ( $result_update && $result_pesanan ) { echo "berhasil"; } else { echo "gagal"; }
}

// Checker Order Saldo - Pesanan
if ( isset($_POST['save_reqsaldo_pesanan']) && $_POST['save_reqsaldo_pesanan']==GLOBAL_FORM ) {	
	$idreq= secure_string($_POST['idreq']);
    $status = secure_string($_POST['status']);
    $send_nota = secure_string($_POST['send_nota']);
    
    $idpesanan  = querydata_reqsaldo($idreq,'id_pesanan');
    $get_user   = querydata_pesanan($idpesanan,'namauser');
    $iduser 	= current_user_id();
    $datedb 	= $tgl_database = strtotime('now');
    $id_user 	= querydata_pesanan($idpesanan,'id_user');
    $telp_user 	= querydata_pesanan($idpesanan,'telp');
    $email_user = data_tabel('user_member',$id_user,'email');
    $totalbayar = querydata_reqsaldo($idreq,'total_bayar');
    $cek_tipebayar = querydata_pesanan($idpesanan,'tipe_bayar');

    if( $status == '0' ){
        //update Status 
        $update = "UPDATE request_saldo SET status = '1' WHERE id = '$idreq'";
        $result_update = mysqli_query( $dbconnect, $update );
        
        //Update table Pesanan
        $status_cek_bayar = '1|'.$iduser.'|'.$datedb;
        $update_pesanan = "UPDATE pesanan SET status = '10', status_cek_bayar='$status_cek_bayar' WHERE id = '$idpesanan'";
        $result_pesanan = mysqli_query( $dbconnect, $update_pesanan );

        if( $send_nota == '0' ){ $link_wa = sendemail_pdf($idreq,'email'); } else { $link_wa = preg_replace('/0/','62',$telp_user); }
    }else{
         //update Status 
        $update = "UPDATE request_saldo SET status = '0' WHERE id = '$idreq'";
        $result_update = mysqli_query( $dbconnect, $update );
        
        //Update table Pesanan
        $status_cek_bayar = '1|'.$iduser.'|0';
        $update_pesanan = "UPDATE pesanan SET status = '5', status_cek_bayar='$status_cek_bayar' WHERE id = '$idpesanan'";
        $result_pesanan = mysqli_query( $dbconnect, $update_pesanan );

    }
    
    //$saldouser = update_saldo_user($iduser);
	if ( $result_update && $result_pesanan ) { echo "berhasil###".$link_wa; } else { echo "gagal"; }
}


// Checker Konfrim Saldo
if ( isset($_POST['status_konfrimsaldo']) && $_POST['status_konfrimsaldo']==GLOBAL_FORM ) {	
	$idkonfrim= secure_string($_POST['idkonfrim']);
    $status = secure_string($_POST['status']);
    
    $update = "UPDATE konfirmasi_saldo SET check_rek = '$status' WHERE id = '$idkonfrim'";
    $result_update = mysqli_query( $dbconnect, $update );
    
	if ( $result_update ) { echo "berhasil"; } else { echo "gagal"; }
}

// Hapus Konfrimasi Saldo User
if ( isset($_POST['del_konfrimsaldo']) && $_POST['del_konfrimsaldo']==GLOBAL_FORM ) {	
	$id_konfrimsaldo = secure_string($_POST['id_konfrimsaldo']);

    $args_del = "DELETE FROM konfirmasi_saldo WHERE id='$id_konfrimsaldo'";
    $result_del = mysqli_query( $dbconnect, $args_del );
    
	if ( $result_del ) { echo "berhasil"; } else { echo "gagal"; }
}

// Login
if ( isset($_POST['login']) && $_POST['login']==GLOBAL_FORM ) {
	//echo user_login();
	$email = secure_string($_POST['email']);
	$kunci = md5( secure_string($_POST['password']).USER_PASS );
	$ingatsaya = secure_string($_POST['ingatsaya']);
	
	$argsmain = "SELECT * FROM user WHERE email='$email' AND password='$kunci'";
	$resultmain = mysqli_query( $dbconnect, $argsmain );
	if ( $ingatsaya == '1' ) { $time = time()+(86400*7); }
	else { $time = time()+43200; }
	if ( $resultmain && mysqli_num_rows($resultmain) ) {
		$user = mysqli_fetch_array($resultmain);
		$_SESSION[USER_SESSION] = $user['id']*USER_HASH;
		if ( $ingatsaya == 1 ) {
			$setcookie_user = setcookie( USER_COOKIE, $user['id']*USER_HASH, $time, "/");
		}
		echo 'berhasil';
	} else { echo 'gagal'; }	
}

// Count order
// Add Produk
if ( isset($_POST['count_order']) && $_POST['count_order']==GLOBAL_FORM ) {
	//$sub_namect = secure_string($_POST['sub_namect']);

	// Mysql run
    $args ="SELECT COUNT(id) AS jumlah FROM pesanan";
    $result = mysqli_query( $dbconnect, $args );
	if ($result){
        $jml = mysqli_fetch_array($result);
		echo "berhasil|".$jml['jumlah'];
	} else {
		echo "gagal";
	}
}

//Kurir
if ( isset($_POST['upkurir']) && $_POST['upkurir']==GLOBAL_FORM ){
	$idkurir = secure_string($_POST['idkurir']);
	$datakurir = secure_string($_POST['opsi_datakurir']);

	/*$datedb  = strtotime('now');
	$no = '1';

	$str = htmlspecialchars_decode($nama_kurir);

	if( $idkurir > 0){
		$args = "UPDATE datakurir SET tanggal='$datedb', nama_kurir='$str', status='$no' WHERE id='$idkurir'";
	}else{
		$args = "INSERT INTO datakurir (tanggal, nama_kurir, status) VALUES ('$datedb', '$str', '$no')";
	}

	$result = mysqli_query($dbconnect,$args);

	if($result){
		echo "berhasil";
	}else{
		echo "gagal";
	}*/

	//$data_error = array();
    ////$args = "SELECT * FROM dataoption";
    //$result = mysqli_query( $dbconnect, $args );
    //while ( $opsi = mysqli_fetch_array($result) ) {
        //${"opsi_".$opsi['optname']} = $opsi['optvalue'];
        //$opt_name = $opsi['optname'];
        $args = "UPDATE dataoption SET optvalue = '$datakurir' WHERE optname = 'datakurir'";
        $result = mysqli_query( $dbconnect, $args );
        //if(${"result_".$opt_name}){ $data_error[] = 0; }
        //else { $data_error[] = 1; }
   // }
    
    //$sum_error = array_sum($data_error);
	if ($result){
		echo "berhasil";
	} else {
		echo "gagal";
	}
}

//Save data pengaturan Umum
if ( isset($_POST['save_opsiumum']) && $_POST['save_opsiumum']==GLOBAL_FORM ) {
	$hotline = secure_string($_POST['opsi_hotline']);
    $telepon_view  = secure_string($_POST['opsi_telpview']);
    $telepon_value = secure_string($_POST['opsi_telpvalue']);
    $email_kontak  = secure_string($_POST['opsi_email']);
    $instagram_url = secure_string($_POST['opsi_instagram']);
    $facebook_url  = secure_string($_POST['opsi_facebook']);
    $web_url = secure_string($_POST['opsi_web']);
    $sendmail_admin = secure_string($_POST['opsi_sendmail']);
    
    $about_us = secure_string($_POST['opsi_about_us']);
    $terms = secure_string($_POST['opsi_terms']);
    $privacy = secure_string($_POST['opsi_privacy']);
    $alamat = secure_string($_POST['opsi_alamat']);

   	$tutorial_deposit_topup = secure_string($_POST['opsi_deposit_topup']);
    $tutorial_belanja = secure_string($_POST['opsi_tutorial_belanja']);;
    $minim_pembelian = secure_string($_POST['opsi_minimpembelian']);

    $tentang_kami = secure_string($_POST['opsi_tentang_kami']);
	$help = secure_string($_POST['opsi_help']);
	
	$biaya_ongkir = secure_string($_POST['opsi_ongkir']);
    $waktu_countdown = secure_string($_POST['opsi_timeout']);
    $waktu_notifikasi_version = secure_string($_POST['opsi_notifapp']);
    
    $global_bnstopup = secure_string($_POST['opsi_global_bnstopup']);
    $App_Version = secure_string($_POST['opsi_version']);
    //$datakurir = secure_string($_POST['opsi_datakurir']);
    $admin_konfirpayment = secure_string($_POST['opsi_admin_konfirpayment']);
    $admin_order = secure_string($_POST['opsi_admin_order']);
    $purchase_prizes = secure_string($_POST['opsi_purchase_prizes']);
    
	// Mysql run
    $data_error = array();
    $args = "SELECT * FROM dataoption WHERE optname !='datakurir'";
    $result = mysqli_query( $dbconnect, $args );
    while ( $opsi = mysqli_fetch_array($result) ) {
        //${"opsi_".$opsi['optname']} = $opsi['optvalue'];
        $opt_name = $opsi['optname'];
        ${"args_".$opt_name} = "UPDATE dataoption SET optvalue = '${$opt_name}' WHERE optname = '$opt_name'";
        ${"result_".$opt_name} = mysqli_query( $dbconnect, ${"args_".$opt_name} );
        if(${"result_".$opt_name}){ $data_error[] = 0; }
        else { $data_error[] = 1; }
    }
    
    $sum_error = array_sum($data_error);
	if ($sum_error == '0'){
		echo "berhasil";
	} else {
		echo "gagal";
	}
}

// plus min Stok
if ( isset($_POST['save_pmsstok']) && $_POST['save_pmsstok']==GLOBAL_FORM ) {	
	$date = secure_string($_POST['pmdate']);
	$hour = secure_string($_POST['pmhour']);
	$minute = secure_string($_POST['pmminute']);
	$jumlah = secure_string($_POST['pmjumlah']);
	$desc = secure_string($_POST['pmdesc']);
    
    $trans_id = secure_string($_POST['trans_id']);
	$trans_type = secure_string($_POST['trans_type']);
	$trans_idprod = secure_string($_POST['trans_idprod']);

	// persiapan
	$datedb = strtotime($date.' '.$hour.':'.$minute);
	$month = date('n',$datedb);
	$year = date('Y',$datedb);
    
	// input ke trans_saldo
    if( $trans_id == '0' ){
        $args = "INSERT INTO trans_order ( id_pesanan, id_pembelian, id_produk, jumlah, harga, status_jual, type, date, deskripsi )
                VALUES ( '0', '0', '$trans_idprod', '$jumlah', '0', '1', '$trans_type', '$datedb', '$desc' )";
        $insert = mysqli_query( $dbconnect, $args );
        $trans_id = mysqli_insert_id($dbconnect);
    }else{
        $args = "UPDATE trans_order SET id_pesanan='0', id_pembelian='0', id_produk='$trans_idprod', jumlah='$jumlah', harga='0', status_jual='1', type='$trans_type', date='$datedb', deskripsi='$desc' WHERE id='$trans_id'";
        $insert = mysqli_query( $dbconnect, $args );
    }
    
	if ( $insert ) { echo "berhasil"; } else { echo "gagal"; }
}
// Delete plus min stok
if ( isset($_POST['del_pmstok']) && $_POST['del_pmstok']==GLOBAL_FORM ) {	
	$id_pm = secure_string($_POST['id_pm']);
    
    // data trans order
	$args_stok = "DELETE FROM trans_order WHERE id='$id_pm'";
	$del_stok = mysqli_query( $dbconnect, $args_stok );

    // RESULT
    if ( $del_stok ) { echo 'berhasil'; }
    else { echo 'gagal'; }
}

if ( isset($_POST['get_data_person']) && $_POST['get_data_person'] == GLOBAL_FORM){
	$iduser = secure_string($_POST['idperson']);

	$args = "SELECT * FROM user_member WHERE verification='1' AND id='$iduser'";
	$result = mysqli_query( $dbconnect, $args);
	if($list_user = mysqli_fetch_array($result)){
		$data = $list_user['nama'];
		$data_id = $list_user['id'];
		echo "berhasil!!!".$data."!!!".$data_id;
	}else{
		echo "!!!";
	}
}

if( isset($_POST['del_jual']) && $_POST['del_jual']==GLOBAL_FORM ){
    $idpenjualan = secure_string($_POST['id_penjualan']);
    $idproduk = secure_string($_POST['id_produk']);
    $exp_prod = explode("|", $idproduk);
    $count_prod = count($exp_prod)-1;
    $n=0;

    $data_tipebayar = querydata_pesanan($idpenjualan,'pembayaran_tunai');
    $data_tipebayar_2 = querydata_pesanan($idpenjualan,'pembayaran_tunai_2');
    $data_totalpesanan = querydata_pesanan($idpenjualan,'total');
    if( ($data_tipebayar + $data_tipebayar_2) < $data_totalpesanan ){
    	//$view_logkredit = "SELECT * FROM log_kredit WHERE id_pesanan='$idpenjualan'";
    	//$result_log = mysqli_query($dbconnect,$view_logkredit);
    	//while ($data_logkredit = mysqli_fetch_array($result_log)) {
    		//$data_idkredit = $data_logkredit['id_pesanan'];
    	// cek apakah ada transaksi di buku kas
    //$data_logkredit = data_custom('log_kredit','id_pesanan',$idpenjualan,'id');
	    $args_kredit = "SELECT * FROM log_kredit WHERE id_pesanan='$idpenjualan'";
	    $result_kredit = mysqli_query($dbconnect,$args_kredit);
		while( $data_logkredit = mysqli_fetch_array($result_kredit) ){
			$id_kredit = $data_logkredit['id'];
			$args_cek = "SELECT * FROM transaction_kas WHERE cicilan='$id_kredit'";
			$cek = mysqli_query( $dbconnect, $args_cek );
				if ( mysqli_num_rows($cek) ) {
					while( $trans = mysqli_fetch_array($cek) ) {
						$month = date('n',$trans['date']);
						$year = date('Y',$trans['date']);
						$cat = $trans['category'];
						$cash = $trans['cash'];
						$transid = $trans['id'];
						$args_trans = "DELETE FROM transaction_kas WHERE id='$transid'";
						$del_trans = mysqli_query( $dbconnect, $args_trans );
						$balance = balance_cat($month,$year,$cat,$cash);
					}
				} else { $del_trans = true; $balance = true; }
	    }
	    $del_logkredit = "DELETE FROM log_kredit WHERE id_pesanan='$idpenjualan'";
		$result_del = mysqli_query($dbconnect,$del_logkredit);
    }

    // cek apakah ada transaksi di buku kas
	$args_cek = "SELECT * FROM transaction_kas WHERE pesanan='$idpenjualan'";
	$cek = mysqli_query( $dbconnect, $args_cek );
	if ( mysqli_num_rows($cek) ) {
		while( $trans = mysqli_fetch_array($cek) ) {
			$month = date('n',$trans['date']);
			$year = date('Y',$trans['date']);
			$cat = $trans['category'];
			$cash = $trans['cash'];
			$transid = $trans['id'];
			$args_trans = "DELETE FROM transaction_kas WHERE id='$transid'";
			$del_trans = mysqli_query( $dbconnect, $args_trans );
			$balance = balance_cat($month,$year,$cat,$cash);
		}
	} else { $del_trans = true; $balance = true; }

    $args_transorder = "DELETE FROM trans_order WHERE id_penjualan='$idpenjualan'";
    $result_transorder = mysqli_query($dbconnect,$args_transorder);
    
    if($result_transorder){
    	while($n <= $count_prod){
    		productstock_update($exp_prod[$n],'3');
    		$n++;
    	}
	    $args = "DELETE FROM pesanan WHERE id='$idpenjualan'";
	    $result = mysqli_query($dbconnect,$args);
	    if($result){
	    	$args_reward = "DELETE FROM counter_reward WHERE id_pesanan='$idpenjualan'";
	    	$result_reward = mysqli_query($dbconnect,$args_reward);
	    }
    }
    	
    if( $result){
        echo 'berhasil';
    }else{
        echo 'gagal';
    }
} 

if( isset($_POST['trans_dataprod']) && $_POST['trans_dataprod']==GLOBAL_FORM ){
	$barcode = secure_string($_POST['barcode']);

	$args = "SELECT * FROM produk WHERE barcode='$barcode'";
	$result = mysqli_query($dbconnect,$args);
	if ( mysqli_num_rows($result) ) {
		$item = mysqli_fetch_array($result);
		echo "berhasil###".$item['id']."###".$item['title']."###".$item['harga_produk'];
	}else{ echo "gagal"; }
}

if ( isset($_POST['upresi']) && $_POST['upresi']==GLOBAL_FORM ){
    $idpesan = secure_string($_POST['id_pesan']);
    $resi    = secure_string($_POST['no_resi']);
    $datedb  = strtotime('now');
    $user    = current_user_id();
    $status_kirimbarang = '1|'.$user.'|'.$datedb;
    
    if($resi == ''){
        $args = "UPDATE pesanan SET no_resi='$resi', status_2_driver='0|0|0', status='10' WHERE id='$idpesan'";
    }else{
        $args = "UPDATE pesanan SET no_resi='$resi', status_2_driver='$status_kirimbarang', status='30' WHERE id='$idpesan'";
    }
        $result = mysqli_query($dbconnect,$args);
    if($result){
        echo "berhasil";
    }else{
        echo "gagal";
    }
}

if ( isset($_POST['save_addkonfrim']) && $_POST['save_addkonfrim']==GLOBAL_FORM ){
	$idpesan = secure_string($_POST['idpesan']);
	$name_cust = secure_string($_POST['name_cust']);
	//$telp_konfirm = secure_string($_POST['telp_konfirm']);
	$date = secure_string($_POST['date']);
	$hour = secure_string($_POST['hour']);
	$minute = secure_string($_POST['minute']);
	$pay_from = secure_string($_POST['pay_from']);
	$nominal_trans = secure_string($_POST['nominal_trans']);

	$get_iduser = querydata_pesanan($idpesan,'id_user');

	// persiapan
	$datedb = strtotime($date.' '.$hour.':'.$minute);
	$month = date('n',$datedb);
	$year = date('Y',$datedb);

	$konfrim_id = secure_string($_POST['konfrim_id']);

	if( 0 == $konfrim_id ){
		$args = "INSERT INTO konfirmasi_saldo ( tanggal, uang_tf, bankuser, namauser, rekideasmart, iduser, type, id_pesanan, check_rek ) VALUES ( '$datedb', '$nominal_trans', '$pay_from', '$name_cust', 'BCA', '$get_iduser', 'pesanan', '$idpesan', '' )";	
	}else{
		$args = "UPDATE konfirmasi_saldo SET tanggal='$datedb', uang_tf='$nominal_trans', bankuser='$pay_from', namauser='$name_cust', type='pesanan', id_pesanan='$idpesan' WHERE id='$konfrim_id'";
	}
	$result = mysqli_query($dbconnect,$args);

	if( $result ){
		echo 'berhasil';
	}else{
		echo 'gagal';
	}
}

if( isset($_POST['dell_cicilan']) && $_POST['dell_cicilan']==GLOBAL_FORM ){
    $cicil_id = secure_string($_POST['cicil_id']);

    // cek apakah ada transaksi di buku kas
	$args_cek = "SELECT * FROM transaction_kas WHERE cicilan='$cicil_id'";
	$cek = mysqli_query( $dbconnect, $args_cek );
	if ( mysqli_num_rows($cek) ) {
		while( $trans = mysqli_fetch_array($cek) ) {
			$month = date('n',$trans['date']);
			$year = date('Y',$trans['date']);
			$cat = $trans['category'];
			$cash = $trans['cash'];
			$transid = $trans['id'];
			$args_trans = "DELETE FROM transaction_kas WHERE id='$transid'";
			$del_trans = mysqli_query( $dbconnect, $args_trans );
			$balance = balance_cat($month,$year,$cat,$cash);
		}
	} else { $del_trans = true; $balance = true; }

    $args_cicilan = "DELETE FROM log_kredit WHERE id='$cicil_id'";
    $result_cicilan = mysqli_query($dbconnect,$args_cicilan);
    if( $result_cicilan ){ echo "berhasil"; }else{ echo "gagal"; }
}

// new edit/cash
if ( isset($_POST['cash_save']) && $_POST['cash_save']==GLOBAL_FORM ) {
	$name = secure_string($_POST['name']);
	$desc = secure_string($_POST['desc']);
	$saldo = secure_string($_POST['saldo']);
	$cashid = secure_string($_POST['cashid']);
	if ( 0 == $cashid ) {
		$args = "INSERT INTO cash_book ( name, description, saldoawal ) VALUES ( '$name', '$desc', '$saldo' )";
		$save = mysqli_query( $dbconnect, $args );
		$cashid = mysqli_insert_id($dbconnect);
	} else {
		$args = "UPDATE cash_book SET name='$name', description='$desc', saldoawal='$saldo' WHERE id='$cashid'";
		$save = mysqli_query( $dbconnect, $args );
	}
	
	if ( $save ) { echo "berhasil"; } else { echo "gagal"; }
}

// delete cash
if ( isset($_POST['cash_del']) && $_POST['cash_del']==GLOBAL_FORM ) {
	$cashid = secure_string($_POST['delid']);
	$args = "UPDATE cash_book SET active='0' WHERE id='$cashid'";
	$delete = mysqli_query( $dbconnect, $args );
	$args = "DELETE FROM balance_kas WHERE cash_id='$cashid'";
	$delete = mysqli_query( $dbconnect, $args );
	if ( $delete ) { echo "berhasil"; } else { echo "gagal"; }
}

// new/edit category
if ( isset($_POST['category_save']) && $_POST['category_save']==GLOBAL_FORM ) {
	$name = secure_string($_POST['name']);
	$desc = secure_string($_POST['desc']);
	$master = secure_string($_POST['master']);
	$type = cat_inout_master($master);
	$categoryid = secure_string($_POST['categoryid']);
	if ( 0 == $categoryid ) {
		$args = "INSERT INTO category_kas ( name, master, type, description ) VALUES ( '$name', '$master', '$type', '$desc' )";
		$save = mysqli_query( $dbconnect, $args );
		$categoryid = mysqli_insert_id($dbconnect);
	} else {
		$args = "UPDATE category_kas SET name='$name', master='$master', type='$type', description='$desc' WHERE id='$categoryid'";
		$save = mysqli_query( $dbconnect, $args );
	}
	if ( $save ) { echo "berhasil"; } else { echo "gagal"; }
}

// delete category
if ( isset($_POST['category_del']) && $_POST['category_del']==GLOBAL_FORM ) {
	$categoryid = secure_string($_POST['delid']);
	$deloption = secure_string($_POST['delopt']);
	if ( 'delete' == $deloption ) {
		$args_trans = "UPDATE transaction_kas SET active='0' WHERE category='$categoryid'";
		$update_trans = mysqli_query( $dbconnect, $args_trans );
		// update db saldo
		$args_saldo = "DELETE FROM balance_kas WHERE cat_id='$categoryid'";
		$balance = mysqli_query( $dbconnect, $args_saldo );
	} else if (strpos($deloption,'_') !== false) {
		$arrcatto = explode('_',$deloption);
		$cat_to = $arrcatto[1];
		// update transaksi
		$args_trans = "UPDATE transaction_kas SET category='$cat_to' WHERE category='$categoryid'";
		$update_trans = mysqli_query( $dbconnect, $args_trans );
		// update db saldo
		$args_cat_trans = "SELECT date, cash FROM transaction_kas WHERE category='$cat_to'";
		$cat_trans = mysqli_query( $dbconnect, $args_cat_trans );
		if ( $cat_trans ) {
			$array_input = array();
			while ( $trans = mysqli_fetch_array($cat_trans) ) {
				$month = date('n',$trans['date']);
				$year = date('Y',$trans['date']);
				$cash = date('Y',$trans['cash']);
				$input = $month.'_'.$year.'_'.$cash;
				if ( !in_array($input, $array_input) ) { $array_input[] = $input; }
			}
			foreach ( $array_input as $datasaldo ) {
				$data = explode('_',$datasaldo);
				$balance = balance_cat($data[0],$data[1],$cat_to,$data[2]);
			}
		}
	} else {
		$update_trans = true;
	}
	$args = "UPDATE category_kas SET active='0' WHERE id='$categoryid'";
	$delete = mysqli_query( $dbconnect, $args );
	if ( $delete && $update_trans ) { echo "berhasil"; } else { echo "gagal"; }
}

if (isset($_POST['save_import']) && $_POST['save_import']==GLOBAL_FORM){
	$data_import = secure_string($_POST['data_import']);
	$file = $_FILES['excelprod']['name'];
	$extensi  = explode(".", $file);
	$file_name = "file-".round(microtime(true)).".".end($extensi);
	$sumber = $_FILES['excelprod']['tmp_name'];
	$target_dir = "../penampakan/";
	$target_file = $target_dir.$data_import;
	move_uploaded_file($sumber, $target_file);
	
	//$inputFileType = PHPExcel_IOFactory::identify($data_import);
	
	//$objectreader = PHPExcel_IOFactory::createReader($inputFileType);
	$object = PHPExcel_IOFactory::load($target_file);
	
	foreach ($object->getWorksheetIterator() as $worksheet ) {
		//$sql = "INSERT INTO produk ( idkategori, idsubkategori, title, sku, deskripsi, harga, stock_limit, link_tokped, link_bl, link_shopee, harga_beli, berat_barang, satuan_berat ) VALUES";
		$highestRow = $worksheet->getHighestRow();
		for($row=4; $row <= $highestRow; $row++){
			$category 		= secure_string($worksheet->getCellByColumnAndRow(1, $row)->getValue());
			$barcode 		= secure_string($worksheet->getCellByColumnAndRow(2, $row)->getValue());
			$sku 			= secure_string($worksheet->getCellByColumnAndRow(3, $row)->getValue());
			$full_name 		= secure_string($worksheet->getCellByColumnAndRow(4, $row)->getValue());
			$purchase_price = secure_string($worksheet->getCellByColumnAndRow(5, $row)->getValue());
			$selling_price  = secure_string($worksheet->getCellByColumnAndRow(6, $row)->getValue());
			$stock_limit 	= secure_string($worksheet->getCellByColumnAndRow(7, $row)->getValue());
			$description 	= secure_string($worksheet->getCellByColumnAndRow(8, $row)->getValue());
			$weight 		= secure_string($worksheet->getCellByColumnAndRow(9, $row)->getValue());
			$unit_weight 	= secure_string($worksheet->getCellByColumnAndRow(10, $row)->getValue());
			$tokopedia 		= secure_string($worksheet->getCellByColumnAndRow(11, $row)->getValue());
			$bukalapak 		= secure_string($worksheet->getCellByColumnAndRow(12, $row)->getValue());
			$shopee 		= secure_string($worksheet->getCellByColumnAndRow(13, $row)->getValue());
			$min_qty 		= secure_string($worksheet->getCellByColumnAndRow(14, $row)->getValue());
			$unit_price 	= secure_string($worksheet->getCellByColumnAndRow(15, $row)->getValue());
			$idkategori 	= data_tabel('kategori',$category,'idmaster');
			$sql = "INSERT INTO produk ( idkategori, idsubkategori, title, sku, deskripsi, harga, stock_limit, link_tokped, link_bl, link_shopee, harga_beli, berat_barang, satuan_berat ) VALUES ( '$idkategori', '$category', '$full_name', '$sku', '$description', '$selling_price', '$stock_limit', '$tokopedia', '$bukalapak', '$shopee', '$purchase_price', '$weight' , '$unit_weight')";
			$result = mysqli_query($dbconnect,$sql);
			$last_id = mysqli_insert_id($result);
			if($barcode == ''){$get_barcode = sprintf("%08u", $idproduk);}else{$get_barcode = $barcode;}
			$args_bar = "UPDATE produk set barcode='$get_barcode' WHERE id='$idproduk'";
			$result_bar = mysqli_query( $dbconnect, $args_bar);

			if($min_qty !== ''){
				$args_qty = "INSERT INTO daftar_grosir (qty_from, id_produk, harga_satuan) VALUES('$min_qty','$last_id','$unit_price')";
				$$result_qty = mysqli_query($dbconnect,$args_qty);
			}
			//$sql .= "( '$idkategori', '$category', '$full_name', '$sku', '$description', '$selling_price', '$stock_limit', '$tokopedia', '$bukalapak', '$shopee', '$purchase_price', '$weight' , '$unit_weight'), ";
		}
		//$data_barcode = $barcode;
		//$sql = rtrim($sql,', ');
		//$result = mysqli_query($dbconnect,$sql);
		//$last_id = mysqli_insert_id($result);
//if()
		
		//$args_bar = "UPDATE produk set barcode='$get_barcode' WHERE id='$idproduk'";
		//$result_bar = mysqli_query( $dbconnect, $args_bar);
	}
	unlink($target_file);

	if($result){echo "berhasil";}else{echo "gagal";}
}

if (isset($_POST['search_name']) && $_POST['search_name']==GLOBAL_FORM){
	$idpesan = secure_string($_POST['idpesan']);

	$data = querydata_pesanan($idpesan, 'nama_user');

	if( $data ){ echo "berhasil##".$data; }else{ echo "gagal"; }
}

if ( isset($_POST['find_amout']) && $_POST['find_amout']==GLOBAL_FORM ){
    $member_person = secure_string($_POST['member_person']);
    $datedb = strtotime('now');

    $pick_claim = claim_reward($member_person);
    $data_pick_claim = mysqli_fetch_array($pick_claim);
    if( $datedb >= $data_pick_claim['date'] && $datedb < $data_pick_claim['date_expired'] && $data_pick_claim['status_reward'] == '0' ){
    	$discount = $data_pick_claim['pick_discount'];
    	$amount   = $data_pick_claim['amount'];
    	$pick_id  = $data_pick_claim['id'];
    }else{
    	$discount = 0;
        $amount   = 0;
        $pick_id  = 0;
    }
    
    /*//$hargasemua    = secure_string($_POST['hargasemua']);
    $datedb = strtotime('now');
	$datedb_to = strtotime("+1 months",$datedb);
	//$data_claim = claim_reward($member_person);
  	$args = "SELECT * FROM claim_reward WHERE id_user='$member_person' AND '$datedb' >= date AND '$datedb' < date_expired";
  	$result = mysqli_query($dbconnect,$args);
  	$fetch = mysqli_fetch_array($result);
  	$id = $fetch['id'];
  	$discount = $fetch['pick_discount'];
  			$cek_reward   = data_reward($member_person,'id_user');
  			$fetch_reward = mysqli_fetch_array($cek_reward);
			$date_user    = $fetch_reward['date'];
			$day   = date('d',$date_user);
			$month = date('m');
			$year  = date('Y');
			$hour = date('H');
			$minute = date('i');
			$from  = $day."-".$month."-".$year.",".$hour.":".$minute;
			$to    = $day."-".$month."-".$year.",".$hour.":".$minute;
			$str_from  = strtotime($from);
			$time_from = strtotime("-10 minutes", $str_from);//-1 months
			$time_to   = strtotime($to);
	    	//$from = strtotime("+15 minutes", $date_user);
	    	//$to   = strtotime("+20 minutes", $date_user);
	    	if( $date_user >= $time_from && $date_user < $time_to ){
	    		$total = query_reward($member_person,'id_user',$time_from,$time_to);
	    		//$in_claim = "INSERT INTO claim_reward ( date, date_expired, id_user, pick_discount ) VALUES";
	    		if($total >= 1000000 && $total <= 1999999){
	    			$discount = 5;
	    			$amount   = $total/100*$discount;
	    			//$in_claim .= "( '$datedb', '$datedb_to', '$iduser', '$discount' ), ";
	    		}else if($total >= 2000000 && $total <= 4999999){
	    			$discount = 7.5;
	    			$amount   = $total/100*$discount;
	    			//$in_claim .= "( '$datedb', '$datedb_to', '$iduser', '$discount' ), ";
	    		}else if($total >= 5000000 && $total <= 24999999){
	    			$discount = 10;
	    			$amount   = $total/100*$discount;
	    			//$in_claim .= "( '$datedb', '$datedb_to', '$iduser', '$discount' ), ";
	    		}else if($total >= 25000000){
	    			$discount = 30;
	    			$amount   = $total/100*$discount;
	    			//$in_claim .= "( '$datedb', '$datedb_to', '$iduser', '$discount' ), ";
	    		}else{
	    			//$in_claim .= true;
	    		}
	    		//$in_claim = rtrim($in_claim,', ');
    		$in_claim = "INSERT INTO claim_reward ( date, date_expired, id_user, pick_discount ) VALUES ( '$datedb', '$datedb_to', '$member_person', '$discount' )";
    		$result_claim = mysqli_query($dbconnect,$in_claim);
    		}


    $args = "SELECT * FROM claim_reward WHERE id_user='$member_person' AND '$datedb' >= date AND '$datedb' < date_expired";
  	$result = mysqli_query($dbconnect,$args);
  	$fetch = mysqli_fetch_array($result);
  	$id = $fetch['id'];
  	$discount = $fetch['pick_discount'];


  		if( $datedb >= $data_from && $datedb < $data_to ){
  			$id[] = $fetch['id'];
  			$discount = $fetch['pick_discount'];
  		}else{
  			$id[] = '';
  			$discount = '';
  		}
  	}*/



   /* $data_reward = querydata_reward($member_person,'id_user');
    if(mysqli_num_rows($data_reward) <= 0 ){
    	$amount = $hargasemua;
    }else{
    	$fetch_reward = mysqli_fetch_array($data_reward);
    	$total = $fetch_reward['total_money'];
    	if( $datedb < $fetch_reward['rule_date'] ){
    		$amount = $total + $hargasemua;
    	}else{
    		if( $total >= 1000000 && $total <= 1999999 ){
    			$discount = 5;
    			$amount = $hargasemua - ($total/100*$discount);
    		}else if( $total >= 2000000 && $total <= 4999999 ){
    			$discount = 7.5;
    			$amount = $hargasemua - ($total/100*$discount);
    		}else if( $total >= 5000000 && $total <= 24999999 ){
    			$discount = 10;
    			$amount = $hargasemua - ($total/100*$discount);
    		}else if( $total >= 25000000 ){
    			$discount = 30;
    			$amount = $hargasemua - ($total/100*$discount);
    		}else{
    			$amount = $hargasemua - ($total);
    		}
    	}
    }*/

    //$replace = str_replace('.', ',', $discount);

    if($pick_claim){echo "berhasil###".$discount."###".$amount."###".$pick_id;}else{echo "gagal";}
}

if( isset($_POST['option_reseller']) && $_POST['option_reseller']==GLOBAL_FORM ){
	$data = querydata_dataoption('purchase_prizes');

	if($data){echo "berhasil###".$data;}else{echo "gagal";}
}

?>