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
	
	//$idkatnow = secure_string($_POST['idkatnow']);
	//$idkatchange = secure_string($_POST['idkatchange']);
	//$produkpram = secure_string($_POST['produkpram']);
    
    $nama_produk = secure_string($_POST['nama_produk']);
    $satuan = secure_string($_POST['satuan']);
    $jml_satuan = secure_string($_POST['jml_satuan']);
    $harga_beli = secure_string($_POST['harga_beli']);
    
   // $status_promo = secure_string($_POST['status_promo']);
   // $harga_promo = secure_string($_POST['harga_promo']);
	
	// perintah SQL
	if ( $idproduk == '0' || $idproduk == '' ) {
		$upproduk ="INSERT INTO produk ( idcabang, idkategori, idsubkategori, barcode, title, short_title, deskripsi, harga, stock, image, satuan, jml_persatuan, harga_beli ) VALUES ( '$idcabang', '$idkategori_master', '$idkategori_child', '$barcode', '$title', '$nama_produk', '$deskripsi', '$harga', '$stock', '$imgproduk', '$satuan', '$jml_satuan', '$harga_beli')";
		$result = mysqli_query( $dbconnect, $upproduk );
	} else {
		$upproduk ="UPDATE produk SET idcabang='$idcabang', idkategori='$idkategori_master', idsubkategori='$idkategori_child', barcode='$barcode', title='$title', short_title='$nama_produk', deskripsi='$deskripsi', harga='$harga', stock='$stock', image='$imgproduk', satuan='$satuan', jml_persatuan='$jml_satuan', harga_beli='$harga_beli' WHERE id='$idproduk'";
		$result = mysqli_query( $dbconnect, $upproduk );
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
	$imguser = secure_string($_POST['imguser']);
	$tgl_database = strtotime('now');
	$saldo = secure_string($_POST['saldo']);
	
	// perintah SQL
	$args_email = "SELECT email FROM user WHERE email='$email'";
	$cari_email = mysqli_query( $dbconnect, $args_email );
	if ( mysqli_num_rows($cari_email) ) {
		echo "emailsalah";
	} else {
		$adduser ="INSERT INTO user ( nama, email, telp, alamat, password, user_role, tanggal_daftar, imguser, saldo ) VALUES ( '$nama', '$email', '$telp', '$alamat', '$db_pass', '$user_role', '$tgl_database', '$imguser', '$saldo' )";
		$result = mysqli_query( $dbconnect, $adduser );
		if ($result){
			echo "berhasil";
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
	$imguser = secure_string($_POST['imguser']);
	$tanggal_daftar = secure_string($_POST['tanggal_daftar']);
	$jam = secure_string($_POST['jam']);
	$menit = secure_string($_POST['menit']);
	$tgl_database = strtotime($tanggal_daftar.' '.$jam.':'.$menit);
	$saldo = secure_string($_POST['saldo']);
	
	// perintah SQL
	$edituser ="UPDATE user SET nama='$nama', email='$email', telp='$telp', alamat='$alamat', user_role='$user_role', tanggal_daftar='$tgl_database', imguser='$imguser', saldo='$saldo' WHERE id='$iduser'";
	$result = mysqli_query( $dbconnect, $edituser );
	if ($result){
		echo "berhasil";
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
	$args_pass = "SELECT password FROM user WHERE password='$passlama_db'";
	$cari_pass = mysqli_query( $dbconnect, $args_pass );
	if ( mysqli_num_rows($cari_pass) ) {
		// Jika password sama, maka dilanjutin simpan data	
		// perintah SQL
		$editpass = "UPDATE user SET password='$password_db' WHERE id='$iduser'";
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
		$args = "DELETE FROM $table WHERE id='$id'";
		$hapus = mysqli_query( $dbconnect, $args );
		if ( $idkategori == $idkatnow && $idkatchange == '' ) { $jml_prod = jmlprodkat($idkatnow); } else { $jml_prod = hapusprod($idkatnow); }
	} else if ( $metode == 'user' ) {
		$table = 'user';
		$args = "DELETE FROM $table WHERE id='$id'";
		$hapus = mysqli_query( $dbconnect, $args );
	}
	if ($hapus) { echo 'berhasil'; }
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


// Checker Konfrim Saldo
if ( isset($_POST['status_konfrimsaldo']) && $_POST['status_konfrimsaldo']==GLOBAL_FORM ) {	
	$idkonfrim= secure_string($_POST['idkonfrim']);
    $status = secure_string($_POST['status']);
    
    $update = "UPDATE konfirmasi_saldo SET check_rek = '$status' WHERE id = '$idkonfrim'";
    $result_update = mysqli_query( $dbconnect, $update );
    
	if ( $update ) { echo "berhasil"; } else { echo "gagal"; }
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

// COunt order
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

//Save data pengaturan Umum
if ( isset($_POST['save_opsiumum']) && $_POST['save_opsiumum']==GLOBAL_FORM ) {
	$hotline = secure_string($_POST['opsi_hotline']);
    $telepon_view = secure_string($_POST['opsi_telpview']);
    $telepon_value = secure_string($_POST['opsi_telpvalue']);
    $email_kontak = secure_string($_POST['opsi_email']);
    $instagram_url = secure_string($_POST['opsi_instagram']);
    $facebook_url = secure_string($_POST['opsi_facebook']);
    $web_url = secure_string($_POST['opsi_web']);
    $sendmail_admin = secure_string($_POST['opsi_sendmail']);
    
    $about_us = secure_string($_POST['opsi_aboutus']);
    $terms = secure_string($_POST['opsi_terms']);
    $privacy = secure_string($_POST['opsi_privacy']);
    
    $global_bnstopup = secure_string($_POST['opsi_global_bnstopup']);

	// Mysql run
    $data_error = array();
    $args = "SELECT * FROM dataoption";
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
?>