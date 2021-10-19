<?php 
header("Access-Control-Allow-Origin: *");
session_start();

// Global config
require('../mesin/configuration.php');
$dbconnect = mysqli_connect('localhost',DB_USER,DB_PASS,DB_NAME);

date_default_timezone_set(DEFAULT_TIME);

// login salt
if ( is_login() ) { $salt = md5( current_user_id() ); }
else { $salt = md5('milyader_muda'); }
define('GLOBAL_FORM', md5('|Zm-{8H2Bk$Ftu+B'.date('yj').'oh2HK'.date('zn').'F8m1&;-Y').md5('G#gVmd^}#|N'.date('zj').'WrB|`E*'.$salt.'?o8bOM;~L'));

// check cookie
if ( isset($_COOKIE[USER_COOKIE]) && $_COOKIE[USER_COOKIE] != '' ) { $_SESSION[USER_SESSION] = $_COOKIE[USER_COOKIE]; }

// logout
if ( isset($_GET['logout']) && $_GET['logout']=='true' ) {
	unset($_SESSION[USER_SESSION]);
	if ( isset($_COOKIE[USER_COOKIE]) && $_COOKIE[USER_COOKIE] != '' ) { setcookie(USER_COOKIE, '', time()-3600, "/"); }
	header( "Location: ".GLOBAL_URL );
}

//secure input form
function secure_string($string) { 
	global $dbconnect;
	$string = strip_tags($string);
	$string = htmlspecialchars($string, ENT_QUOTES);
	$string = trim($string);
	if (get_magic_quotes_gpc()) { $string = stripslashes($string); }
	$string = mysqli_real_escape_string($dbconnect,$string);
	return $string;
}

// is logged in
function is_login() {
	if  ( isset($_SESSION[USER_SESSION]) ) {
		$id = $_SESSION[USER_SESSION] / USER_HASH;
		if ( containsDecimal($id) ) { return false; }
		else { return true; }
	} else if ( isset($_COOKIE[USER_COOKIE]) ) {
		$id = $_COOKIE[USER_COOKIE] / USER_HASH;
		if ( containsDecimal($id) ) { return false; }
		else { return true; }
	} else { return false; }
}

// current user id
function current_user_id() {
	if  ( is_login() && isset($_SESSION[USER_SESSION]) ) {
		$session = $_SESSION[USER_SESSION];
		return $session / USER_HASH;
	} else if ( is_login() && isset($_COOKIE[USER_COOKIE]) ) {
		$cookie = $_COOKIE[USER_COOKIE];
		return $cookie / USER_HASH;
	} else { return '0'; }
}

// current user data
function current_user($data) {
	global $dbconnect;
	if  ( is_login() ) {
		$userid = current_user_id();
		if ( $userid && $userid !='' && $userid !='0' ) {
			$args = "SELECT $data FROM user WHERE id='$userid'";
			$result = mysqli_query( $dbconnect, $args );
			if ($result) {
				$user = mysqli_fetch_array($result);
				return $user[$data];
			} else { return false; }
		} else { return false; }	
	} else { return false; }
}

// Get data table User
function querydata_user($id,$data='nama'){
    global $dbconnect;
    $args = "SELECT * FROM user WHERE id='$id'";
    $result = mysqli_query( $dbconnect, $args );
	$order = mysqli_fetch_array($result);
    return $order[$data];
}

//Get data Alamat Full 
function alamatpesanan_full($idalamat,$iduser) {
    global $dbconnect;
    $args = "SELECT * FROM alamat_order where id='$idalamat' AND iduser='$iduser'";
    $result = mysqli_query( $dbconnect, $args );
    $data = mysqli_fetch_array($result);
    
    $kota       = $data['kota'];
    $kecamatan  = $data['kecamatan'];
    $kelurahan  = $data['kelurahan'];
    $alamat     = $data['alamat'];
    
    $data_kota      = data_lokasi($kota,'00','0000','lokasi_nama');
	$data_kecamatan = data_lokasi($kota,$kecamatan,'0000','lokasi_nama');
	$data_kelurahan = data_lokasi($kota,$kecamatan,$kelurahan,'lokasi_nama');
	$alamat_full    = $alamat.' '.$data_kecamatan.' '.$data_kelurahan.' '.$data_kota;
	
	return $alamat_full;
    
}

// Get Val data Options
function value_dataoption($optname){
    global $dbconnect;
    $args = "SELECT * FROM dataoption where optname='$optname'";
    $result = mysqli_query( $dbconnect, $args);
    $option = mysqli_fetch_array($result);
    return $option['optvalue'];
}

// Split Status Pesanan
function split_status_order($data,$type){
   //tipe 0 = status, 1 = ID user, 2 = time
   $item = explode('|',$data);
   return $item[$type];
}

function nama_user() {
	$user = current_user('nama');
	return ucwords($user);
}

// check mengandung desimal
function containsDecimal( $value ) {
    if ( strpos( $value, "." ) !== false ) { return true; }
	else { return false; }
}

// auto select
function auto_select($value,$sumber) {
	if ( $value == $sumber ) { echo ' selected="selected" '; }
}

// auto tampil
function auto_tampil($value,$sumber) {
	if ( $value != $sumber ) { echo ' style="display:none;" '; }
}

// auto disabled
function auto_hide($value) {
	$date_now = strtotime('now'); //+ 7200
	$jam = date('H',$date_now);
	if ( $value <= $jam ) { return 'disabled'; }
}

// autoselect main menu
function autoselect_mainmenu($page=null,$home=null) {
	if ( !isset($_GET['page']) && $home=='home' ) {
		echo 'current_menu';
	} else if ( isset($_GET['page']) && $_GET['page'] == $page ) {
		echo 'current_menu';
	} else { echo ''; }
}

// potong text per huruf
function excerpt($text,$max) {
	$content = substr($text, 0, $max);
	echo $content;
}
// potong text per huruf
function excerptmobile($text,$max) {
	$counttext = strlen($text);
	$content = substr($text, 0, $max);
	if ( $counttext > $max ) {
		$textjoin = $content.'...';
	} else {
		$textjoin = $content;
	}
	return $textjoin;
}

// data tabel
function data_tabel($tabel, $id, $kolom) {
	global $dbconnect;
	$args="SELECT * FROM $tabel WHERE id='$id'";
    $result = mysqli_query( $dbconnect, $args );
	$data = mysqli_fetch_array($result);
	return $data[$kolom];
}

// data Kategori
function data_kategori($id, $kolom) {
	global $dbconnect;
	$args="SELECT * FROM kategori WHERE id='$id'";
    $result = mysqli_query( $dbconnect, $args );
	$mobil = mysqli_fetch_array($result);
	return $mobil[$kolom];
}

// data Kategori
function data_transorder($idpesanan, $kolom) {
	global $dbconnect;
	$args="SELECT * FROM trans_order WHERE id_pesanan='$idpesanan'";
    $result = mysqli_query( $dbconnect, $args );
	$pesanan = mysqli_fetch_array($result);
	return $pesanan[$kolom];
}

// data Request Saldo
function data_requestsaldo($idpesanan, $kolom) {
    global $dbconnect;
    $args = "SELECT * FROM request_saldo WHERE id_pesanan='$idpesanan'";
    $result = mysqli_query( $dbconnect, $args );
    $pesanan = mysqli_fetch_array($result);
    return $pesanan[$kolom];
}

// data trans Saldo
function data_transsaldo($idpesanan,$tipe,$kolom) {
    global $dbconnect;
    $args = "SELECT * FROM trans_saldo WHERE id_pesanan='$idpesanan' AND type ='$tipe'";
    $result = mysqli_query( $dbconnect, $args );
    $pesanan = mysqli_fetch_array($result);
    return $pesanan[$kolom];
}

// cek ketersediaan data di konfirmasi saldo
function jum_konfirmasi_saldo($id_reqsaldo,$tipe) {
    global $dbconnect;
    $args = "SELECT * FROM konfirmasi_saldo WHERE id_reqsaldo='$id_reqsaldo' AND type ='$tipe'";
    $result = mysqli_query( $dbconnect, $args );
    $jumlah = mysqli_num_rows($result);
    return $jumlah;
}

// select user role
function peran($value) {
	if ( 'user0' == $value ) { echo 'Admin'; }
	else if ( 'user1' == $value ) { echo 'Operator'; }
	else if ( 'user2' == $value ) { echo 'Driver'; }
	else { echo 'User'; }
}

function jmlprodkat($id) {
	global $dbconnect;
	$args = "SELECT * FROM produk WHERE idkategori='$id'";
	$result = mysqli_query( $dbconnect, $args );
	$jumlah = mysqli_num_rows($result);
	$upkate = "UPDATE kategori SET jumlah_produk='$jumlah' WHERE id='$id'";
	$result2 = mysqli_query( $dbconnect, $upkate );
}
function jmlprodkatmin($idlama,$idbaru) {
	global $dbconnect;
	$args = "SELECT * FROM kategori WHERE id='$idlama'";
	$result = mysqli_query( $dbconnect, $args );
	$kat = mysqli_fetch_array($result);
	$katjum = $kat['jumlah_produk'];
	$jumlah = $katjum - 1;
	$upkate = "UPDATE kategori SET jumlah_produk='$jumlah' WHERE id='$idlama'";
	$result2 = mysqli_query( $dbconnect, $upkate );
	
	$argsw = "SELECT * FROM kategori WHERE id='$idbaru'";
	$resultw = mysqli_query( $dbconnect, $argsw );
	$katw = mysqli_fetch_array($resultw);
	$katjumw = $katw['jumlah_produk'];
	$jumlahw = $katjumw + 1;
	$upkatew = "UPDATE kategori SET jumlah_produk='$jumlahw' WHERE id='$idbaru'";
	$result2w = mysqli_query( $dbconnect, $upkatew );
}

// data lokasi
function data_lokasi($idkota, $idkecamatan, $idkelurahan, $kolom) {
	global $dbconnect;
	$args="SELECT * FROM inf_lokasi WHERE lokasi_propinsi='34' AND lokasi_kabupatenkota='$idkota' AND lokasi_kecamatan='$idkecamatan' AND lokasi_kelurahan='$idkelurahan'";
    $result = mysqli_query( $dbconnect, $args );
	$data = mysqli_fetch_array($result);
	return $data[$kolom];
}

// Get data All Stok produk
function all_stok_prod($idproduk,$type){
   // $type option ( stock_tersedia / stok_order )
   global $dbconnect;

       if ( $type == 'stock_tersedia' ){
           $args ="Select (
               (select stock from produk where id='$idproduk') 
               +
               (select coalesce(sum(jumlah),0) from trans_order where id_produk='$idproduk' AND type='in')
               - 
               (select coalesce(sum(jumlah),0) from trans_order where id_produk='$idproduk' AND type='out' AND status_jual='1')
               - 
               (select coalesce(sum(jumlah),0) from trans_order where id_produk='$idproduk' AND type='out' AND status_jual='0')
           ) AS jumlah_stok";
       }elseif( $type == 'stok_order' ){
           $args ="Select (
               (select coalesce(sum(jumlah),0) from trans_order where id_produk='$idproduk' AND type='out' AND status_jual='0')
           ) AS jumlah_stok";
       }
       $result = mysqli_query( $dbconnect, $args );
       $data = mysqli_fetch_array($result);
       $jml_stok = $data['jumlah_stok'];
       return $jml_stok;
   
}

// proses tanggal
function proses_tanggal($tanggal) {
	$tanggal = trim($tanggal);
	$pecah = explode(' ',$tanggal);
	$tanggal = $pecah[0] * 1;
	if ( !is_numeric($tanggal) ) { $tanggal = date('j'); }
	$tahun = $pecah[2] * 1;
	if ( !is_numeric($tahun) ) { $tahun = date('Y'); }
	$bulan = ucfirst($pecah[1]);
	$bulan_en = array('January','February','March','April','May','June','July','August','September','October','November','December');
	$bulan_id = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
	if ( !in_array( $bulan, $bulan_en ) ) {
		switch ($bulan) {
			case 'Januari': $bulan = 'January'; break;
			case 'Februari': $bulan = 'February'; break;
			case 'Pebruari': $bulan = 'February'; break;
			case 'Maret': $bulan = 'March'; break;
			case 'Mei': $bulan = 'May'; break;
			case 'Juni': $bulan = 'June'; break;
			case 'Juli': $bulan = 'July'; break;
			case 'Agustus': $bulan = 'August'; break;
			case 'Oktober': $bulan = 'October'; break;
			case 'Nopember': $bulan = 'November'; break;
			case 'Desember': $bulan = 'December'; break;
			default: $bulan = date('F');
		}
	}
	else if ( !in_array( $bulan, $bulan_id ) ) {
		switch ($bulan) {
			case 'January': $bulan = 'Januari'; break;
			case 'February': $bulan = 'Februari'; break;
			case 'March': $bulan = 'Maret'; break;
			case 'May': $bulan = 'Mei'; break;
			case 'June': $bulan = 'Juni'; break;
			case 'July': $bulan = 'Juli'; break;
			case 'August': $bulan = 'Agustus'; break;
			case 'October': $bulan = 'Oktober'; break;
			case 'November': $bulan = 'Nopember'; break;
			case 'December': $bulan = 'Desember'; break;
			default: $bulan = date('F');
		}
	}
	return $tanggal.' '.$bulan.' '.$tahun;
}

// FORMAT TANGGAL KIRIM
function date_order($slottime,$picktime) {
	$date_now = strtotime('now');
	$day = date('d',$date_now);
	$month = date('F',$date_now);
	$year = date('Y',$date_now);
	$jam = $picktime;
	$menit = '00';
	$detik = '00';
	if ($slottime == '0') {
		$tanggal = $day." ".$month." ".$year;
	} else {
		$tomorrow = $day + 1;
		$tanggal = $tomorrow." ".$month." ".$year;
	}
	$waktu_kirim = $tanggal." ".$jam.":".$menit.":".$detik;
	$waktujadi = strtotime($waktu_kirim);
	return $waktujadi;
}

// jumlah Saldo berdasarkan User di transaksi saldo
function total_saldo_userid($id) {
	global $dbconnect;
	$args = "SELECT
	( SELECT COALESCE(SUM(nominal),0) FROM trans_saldo WHERE type='plus' AND id_user='$id' )
	- ( SELECT COALESCE(SUM(nominal),0) FROM trans_saldo WHERE type='minus' AND id_user='$id' )
	+ ( SELECT saldoawal FROM user WHERE id='$id' )
	AS baltotal";
	// $args = "SELECT saldostart AS debttotal FROM pro_hapiut WHERE id='$id' ";
	$result = mysqli_query( $dbconnect, $args );
	$array = mysqli_fetch_array($result);
	$total = $array['baltotal'];
	if ( $total < 0 ) { $total = 0; }
	return $array['baltotal'];
}
	
// Update saldo NOW User
function update_saldo_user($id) {
	global $dbconnect;
	$saldo = total_saldo_userid($id);
	$args = "UPDATE user SET saldo='$saldo' WHERE id='$id'";
	$update = mysqli_query( $dbconnect, $args );
	if ( $update ) { return true; } else { return false; }
}

// Get Sub KAtegori
function getsubkat($idkat) {
	global $dbconnect;
	$args = "SELECT * FROM kategori WHERE id_master='$idkat'";
	$result = mysqli_query( $dbconnect, $args );
	if ( $result ) { return true; } else { return false; }
}

// format angka
function format_angka( $angka ) {
	return number_format("$angka",2,",",".");
}

// Tampilan Waktu permintaan kirim pesanan
function show_datesendorder($date,$type="space"){
    if( $date == '0' ){
        return ' --- ';
    }else{
        $hari_kirim = date('d', $date);
        $hari_ini = date('d');
        $tanggal_now = strtotime( date('d M Y') );
        $tanggal_besok = $tanggal_now + 86400;
        $hari_besok = date('d', $tanggal_besok);

        $jam_kirim = date('H.i', $date);
        $jam_kirim_to = date('H.i', ($date + 7200 ) );

        if( $hari_kirim == $hari_ini ){
            $datalengkap = "Hari ini<br>".$jam_kirim." - ".$jam_kirim_to;
            $datalengkap_2 = "Hari ini Jam ".$jam_kirim." - ".$jam_kirim_to;
        }elseif ( $hari_kirim == $hari_besok ){
            $datalengkap = "Besok<br>".$jam_kirim." - ".$jam_kirim_to;
            $datalengkap_2 = "Besok Jam ".$jam_kirim." - ".$jam_kirim_to;
        }else{
            $datalengkap = date('d M Y', $date)."<br>".$jam_kirim." - ".$jam_kirim_to;
            $datalengkap_2 = date('d M Y', $date)." Jam ".$jam_kirim." - ".$jam_kirim_to;
        }
        if ( $type == 'notspace' ){
            return $datalengkap_2;
        }else{
            return $datalengkap;
        }
    }
}

// Query data Request Saldo
function query_reqsaldo($iduser){
    global $dbconnect;
    $args = "SELECT * FROM request_saldo WHERE id_user='$iduser' AND status='0' order by date_checkout";
    $result = mysqli_query( $dbconnect, $args );
    return $result;
}

// Query data Request Saldo
function query_transorder($pesanan){
    global $dbconnect;
    $args = "SELECT * FROM trans_order WHERE id_pesanan='$pesanan' AND type='out' order by id ASC";
    $result = mysqli_query( $dbconnect, $args );
    $struktur = '';
    if ( $result ) {
        $struktur .= "<html><body>";
	    $struktur .= '<table rules="all" style="border: 1px solid #bdc3be;" cellpadding="10">';
		$struktur .= "<tr style='background: #41b647; text-align:center; color:#fff;'>";
	    $struktur .= "<td><strong>Produk</strong></td>";
	    $struktur .= "<td><strong>Jumlah</strong></td>";
	    $struktur .= "<td><strong>Harga Satuan</strong></td>";
	    $struktur .= "<td><strong>Harga</strong></td>";
	    $struktur .= "</tr>";
		while ( $data_pesanan = mysqli_fetch_array($result) ) {
		    $struktur .= "<tr>";
		    $struktur .= "<td>".data_tabel('produk', $data_pesanan['id_produk'], 'title')."</td>";
		    $struktur .= "<td><center>".$data_pesanan['jumlah']."</center></td>";
		    $struktur .= "<td>Rp ".format_angka( $data_pesanan['harga'] )."</td>";
		    $struktur .= "<td>Rp ".format_angka( $data_pesanan['jumlah'] * $data_pesanan['harga'] )."</td>";
		    $struktur .= "</tr>";
		}
		$struktur .= '<tr>';
	    $struktur .= '<td colspan="3"><center>Biaya Pengiriman</center></td>';
	    $struktur .= "<td>Rp ".format_angka( data_tabel('pesanan', $pesanan, 'ongkos_kirim') )."</td>";
	    $struktur .= "</tr>";
		$struktur .= '<tr style="background: #e9e9e9;">';
	    $struktur .= '<td colspan="3"><center><strong>Sub Total</strong></center></td>';
	    $struktur .= "<td>Rp ".format_angka( data_tabel('pesanan', $pesanan, 'total') )."</td>";
	    $struktur .= "</tr>";
		$struktur .= "</table>";
		$struktur .= "</body></html>";
	}
	return $struktur;
}

function kirim_email_order($namauser, $emailuser, $telpuser, $iduser, $usersaldo, $idpesanan, $totalharga, $almat_lengkap, $waktupesan, $waktukirim, $tipe_bayar) {
    global $dbconnect;
    
    if( $tipe_bayar == 'pay_debit' ) {
        $bayar_dengan = 'Transfer Bank';
    } else if ( $tipe_bayar == 'pay_credit' ) {
        $bayar_dengan = 'Kartu Kredit';
    } else if ( $tipe_bayar == 'cod' ) {
        $bayar_dengan = 'Bayar Tunai';
    } else if ( $tipe_bayar == 'inSaldo' ) {
        $bayar_dengan = 'Saldo IdeaSmart';
    } else {
        $bayar_dengan = '-';
    }
    
    $args = "SELECT * FROM dataoption";
    $result = mysqli_query($dbconnect,$args);
    $hotline='';
    $telepon='';
    $email_admin='';
    $emailryplay ="autosend@ideasmart.id";
    $email_admin2 = "avistakautsar01@gmail.com";
     while($data = mysqli_fetch_array($result))  {
         if($data['optname'] == 'hotline'){
             $hotline.= $data['optvalue'];
         }else if ($data['optname'] == 'telepon_view'){
             $telepon.= $data['optvalue'];
         }else if ($data['optname'] =='sendmail_admin'){
             $email_admin.=  $data['optvalue'];
         }
        
    } 
    
    //$emailuser = "avistakautsar01@gmail.com";
    $ipp = $_SERVER['REMOTE_ADDR'];
    
    /*--- Start SendMail to Admin ---*/
    
        $textmail = "
        ------------------------------------------<br />
        DATA USER<br />
        ------------------------------------------<br />
        User ID: ".$iduser."<br />
        Nama User: ".$namauser."<br />
        Email User: ".$emailuser."<br />
        Telepon User: ".$telpuser."<br />
        IP User: ".$ipp."<br />
        ------------------------------------------<br />
        DATA PESANAN<br />
        ------------------------------------------<br />
        Pesanan ID: ".$idpesanan."<br />
        Waktu Pemesanan: ".date('d M Y, H.i', data_tabel('pesanan', $idpesanan, 'waktu_pesan'))."<br />
        Permintaan Pengiriman: ".date('d M Y', $waktukirim).", ".date('H.i', $waktukirim)." - ".date('H.i', ($waktukirim + 7200 ) )."<br />
        Alamat Pengiriman: ".$almat_lengkap."<br />
        Dibayar Melalui : ".$bayar_dengan."<br />
        ------------------------------------------<br />
        RINCIAN PESANAN<br />
        ------------------------------------------<br />
        ".query_transorder($idpesanan)."<br />
        
        
        -------------------------------------------------------<br />
        Ini hanya email pemberitahuan. Tolong jangan balas.";

        $subjectmail = 'Notifikasi Pesanan Baru';
        $theheader = "From: ".$emailryplay." \r\n";
        //$theheader.= "Reply-To: ".$email_admin2." \r\n";
        //$theheader.= "Cc: ".$cc." \r\n";
        $theheader.= "X-Mailer: PHP/".phpversion()." \r\n"; 
        $theheader.= "MIME-Version: 1.0" . " \r\n";
        $theheader.= "Content-Type: text/html; charset=UTF-8\r\n";

        // sendmail
       // $sendmail = mail( $email_admin, $subjectmail, $textmail, $theheader );
    
    /* End Sendmail Admin */
    
    /*--- Start SendMail to User ---*/
        
        $textmail_touser = "
        
        Hallo ".$namauser.",<br /><br /><br /><br />
        
        <b>
        Terimakasih atas kepercayaan Bapak/Ibu yang telah berbelanja di Ideasmart.<br /><br />
        Melaui email ini kami inforasikan untuk detail pesanan yang Bapak/Ibu pesan.
        </b><br /><br />
        
        ------------------------------------------<br />
        DATA PESANAN<br />
        ------------------------------------------<br />
        Pesanan ID: ".$idpesanan."<br />
        Waktu Pemesanan: ".date('d M Y, H.i', data_tabel('pesanan', $idpesanan, 'waktu_pesan'))."<br />
        Permintaan Pengiriman: ".date('d M Y', $waktukirim).", ".date('H.i', $waktukirim)." - ".date('H.i', ($waktukirim + 7200 ) )."<br />
        Alamat Pengiriman: ".$almat_lengkap."<br />
        ------------------------------------------<br />
        RINCIAN PESANAN<br />
        ------------------------------------------<br />
        ".query_transorder($idpesanan)."<br />
        
        
        -------------------------------------------------------<br /><br /><br />
        
        Jika Bapak/Ibu memiliki pertanyaan lainnya, silahkan menghubungi kami di nomor berikut <br /><br />
        
        Hotline : ".$hotline."<br />
        
        Telp : ".$telepon."
        ";

        $subjectmail_user = 'Notifikasi Pesananan Ideasmart';
        $theheader_user = "From: ".$emailryplay." \r\n";
        //$theheader.= "Reply-To: ".$emailuser." \r\n";
        //$theheader.= "Cc: ".$cc." \r\n";
        $theheader_user.= "X-Mailer: PHP/".phpversion()." \r\n"; 
        $theheader_user.= "MIME-Version: 1.0" . " \r\n";
        $theheader_user.= "Content-Type: text/html; charset=UTF-8\r\n";

        // sendmail
       // $sendmail = mail( $emailuser, $subjectmail_user, $textmail_touser, $theheader_user );
    
     /* End Sendmail to User */
    

}



function user_login() {
	global $dbconnect;
	$email = trim($_POST['email']);
	$email = secure_string($email);
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
		return 'berhasil';
	} else { return 'gagal'; }	
} 

function user_logout() {
	unset($_SESSION[USER_SESSION]);
	setcookie(USER_COOKIE, '', time()-3600, "/");
	header( "Location: ".GLOBAL_URL );
}



//Cari Jumlah alamat Order User 
function get_addressorder($id){
    global $dbconnect;
    $iduser = $id;
     
        $args = "SELECT * FROM alamat_order where iduser ='$iduser'";
        $result = mysqli_query( $dbconnect, $args );
        $data = mysqli_num_rows($result);
        
    return $data;
}

// Pembatan Pesanan
function pesanan_batal($idorder){
    global $dbconnect;
    $iduser = querydata_pesanan($idorder,'id_user');
    
    // Data Transaksi Order
	$args_order = "DELETE FROM trans_order WHERE id_pesanan='$idorder'";
	$del_order = mysqli_query( $dbconnect, $args_order );
    
    // Data Transaksi Saldo
    $args_transsaldo = "DELETE FROM trans_saldo WHERE id_pesanan='$idorder'";
    $result_transsaldo = mysqli_query( $dbconnect, $args_transsaldo );
    $saldouser = update_saldo_user($iduser);
    
    // Data Request saldo
    $args_reqsaldo = "SELECT * FROM request_saldo WHERE id_pesanan='$idorder'";
    $result_reqsaldo = mysqli_query( $dbconnect, $args_reqsaldo );
	while ( $item_req = mysqli_fetch_array($result_reqsaldo) ) {
        // Data Konfrimasi Saldo
        $idreqsaldo = $item_req['id'];
        $args_konfrimsaldo = "DELETE FROM konfrimasi_saldo WHERE id_reqsaldo='$idreqsaldo'";
        $result_konfrimsaldo = mysqli_query( $dbconnect, $args_konfrimsaldo );
    }
    $args_delreqsaldo = "DELETE FROM request_saldo WHERE id_pesanan='$idorder'";
    $result_delreqsaldo = mysqli_query( $dbconnect, $args_delreqsaldo );
    
    // Data Pesanan
	$args ="UPDATE pesanan SET aktif='0' WHERE id='$idorder'";
    $result = mysqli_query( $dbconnect, $args );
    if ($result){
        return true;
    } else {
        return false;
    }
}

// Auto Batal Pesanan
function auto_pesanan_batal($iduser){
    global $dbconnect;
    $date_db = strtotime("now");
    // Data User di Pesanan
    $iduser = $user_id;
    $args_datapesanan = "SELECT * FROM pesanan WHERE id_user='$iduser' AND status='5' AND aktif='1'";
    $result_datapesanan = mysqli_query( $dbconnect, $args_datapesanan );
	while ( $item_pesanan = mysqli_fetch_array($result_datapesanan) ) {
	    $idpesanan = $item_pesanan['id'];
	    
	    // Cek data request saldo
	    $args_reqsaldo = "SELECT * FROM request_saldo WHERE id_pesanan='$idpesanan' AND status='0'";
	    $result_reqsaldo = mysqli_query( $dbconnect, $args_reqsaldo );
	    while ( $item_reqsaldo = mysqli_fetch_array($result_reqsaldo) ){
    	    $idreqsaldo = $item_reqsaldo['id'];
    	    
    	    //Cek Data Table Konfrimasi Saldo
    	    $args_konfrimsaldo = "SELECT * FROM konfirmasi_saldo WHERE iduser='$iduser' AND id_reqsaldo='$idreqsaldo' AND type='pesanan'";
    	    $result_konfrimsaldo = mysqli_query( $dbconnect, $args_konfrimsaldo );
    	    $count_konfrimsaldo = mysqli_num_rows($result_konfrimsaldo);
    	    if($count_konfrimsaldo > 0){
    	        $date_timeout = ($item_pesanan['waktu_pesan'] * 1) + 7200;
    	        $date_timeout2 = '2jam';
    	        //Pengecekan Timeout
        		if( $date_timeout < $date_db ){
        			//Batalkan Pesanan
        			pesanan_batal($idpesanan);
        		}
    	    }else{
    	        $date_timeout = ($item_pesanan['waktu_pesan'] * 1) + 3600;
    	        $date_timeout2 = '1jam';
    	        //Pengecekan Timeout
        		if( $date_timeout < $date_db ){
        			//Batalkan Pesanan
        			pesanan_batal($idpesanan);
        		}
    	    }
	    }
		
    }
    return true;
}

function check_mail($email) {
	global $dbconnect;
	$args = "SELECT email FROM user WHERE email='$email'";
	$result = mysqli_query( $dbconnect, $args );
	if ($result && mysqli_num_rows($result)) { return true; }
	else { return false; }	
}

function gabung_array_cart($product_cart1,$product_cart2) {
    $product_cart1 = explode( '!!!', $product_cart1 ); // Dari database User
    $product_cart2 = explode( '!!!', $product_cart2 ); // Dari Lokal

        //Gabungkan ke 2 Data
        $gabungkan_data = array_merge($product_cart1,$product_cart2);

        //Kelompokan data dengan Foreach
    
        $kelompok = array();
        foreach( $gabungkan_data as $key => $val ) {
            $val = explode( '|', $val );                                        //Ubah  string ke array    
            if ( !isset( $kelompok[ $val[0] ] ) ) $kelompok[ $val[0] ] = $val;  //Jika Data tidak ada yang sama maka akan ditambahkan ke array
            else $kelompok[ $val[0] ][5] += $val[5];                            //Jika Data ada maka hanya ditambahkan jumlah barangnya saja
        }

        //Ubah kembali data ke bentuk String Awal
        foreach( $kelompok as $key => $val ) {
            $kelompok[ $key ] = implode( '|', $val );
        }
        $result = implode( '!!!', $kelompok );
        $result = ltrim($result, '!');
        $result = rtrim($result, '!');
        
         return $result;

}

function update_userCart_data($datasimpancart){
    global $dbconnect;
    $array_data = $datasimpancart;


    $item 	= explode('!!!', $array_data);
    $jumlah = count($item) - 1;
    $x  	= 0;
    $save_array  = array();
     	while( $x <= $jumlah ) {
 		    $arraydata = explode('|',$item[$x]);
 		    $idproduk = $arraydata[0];
 		    $title    = html_entity_decode($arraydata[1]);
 		    $price    = $arraydata[2];
 		    $image    = $arraydata[4];
 		    $amount   = $arraydata[5];
 		    $promoprice = $arraydata[3];

 		    $args 	= "SELECT * FROM produk where id='$idproduk'";
 		    $result	= mysqli_query( $dbconnect, $args );
 		    if ( $result ) {
 		    	$data = mysqli_fetch_array($result);
 		    	$title_prod  = html_entity_decode($data['short_title']);
 		    	$price_prod  = $data['harga'];
 		    	$promoprice_prod  = $data['harga_promo'];
 		    	$image_prod  = $data['image'];

 		    } else {
 		    	$title_prod  = "";
 		    	$price_prod  = "";
 		    	$image_prod  = "";
 		    	$promoprice_prod  = "";
 		    }

 		    if ($title == $title_prod) {
 		    	$end_title = $title;
 		    } else {
 		    	$end_title = $title_prod;
 		    }

 		    if ($price == $price_prod) {
 		    	$end_price = $price;
 		    } else {
 		    	$end_price = $price_prod;
 		    }
 		    
 		    if ($promoprice == $promoprice_prod) {
 		    	$end_promoprice = $promoprice;
 		    } else {
 		    	$end_price = $price_prod;
 		    }

 		    if ($image == $image_prod) {
 		    	$end_image = $image;
 		    } else {
 		    	$end_image = $image_prod;
 		    }

 		    $save_array[] = $idproduk.'|'.$end_title.'|'.$end_price.'|'.$end_promoprice.' |'.$end_image.'|'.$amount;

 		    $x++;
 	    }
 	$array_jadi = join("!!!",$save_array);
 	
 	return $array_jadi;
}

//produk promo
function promo($produkid){
    global $dbconnect;
 	$args 	= "SELECT * FROM produk where id='$produkid'";
 	$result	= mysqli_query( $dbconnect, $args );
 	if ( $result ) {
 		$data             = mysqli_fetch_array($result);
 		$promocode        = $data['promo'];
 		$price_prod       = $data['harga'];
 		$promoprice_prod  = $data['harga_promo'];
    }
 	return $promocode;
}

//ambil harga dari produk promo dan tidak
function get_promo($produkid){
    global $dbconnect;
 	$args 	= "SELECT * FROM produk where id='$produkid'";
 	$result	= mysqli_query( $dbconnect, $args );
 	if ( $result ) {
 		$data             = mysqli_fetch_array($result);
 		$promocode        = $data['promo'];
 		$price_prod       = $data['harga'];
 		$promoprice_prod  = $data['harga_promo'];
 		
 	    if ($promocode == "0") {
 	      $harga = $price_prod;
 	    } else {
 	      $harga = $promoprice_prod;}
 		  $harga = $harga;
 		
    } else {$harga="0";}

   
 	return $harga;
}

//ambil harga asli
function hargaasli($produkid){
    global $dbconnect;
 	$args 	= "SELECT * FROM produk where id='$produkid'";
 	$result	= mysqli_query( $dbconnect, $args );
 	if ( $result ) {
 		$data             = mysqli_fetch_array($result);
 		$promocode        = $data['promo'];
 		$price_prod       = $data['harga'];
 		$promoprice_prod  = $data['harga_promo'];
    }
 	return $price_prod;
}
 	
 	
function pesanan($idpesanan,$kolom){
    global $dbconnect;
 	$args 	= "SELECT * FROM pesanan where id='$idpesanan'";
 	$result	= mysqli_query( $dbconnect, $args );
 	if ( $result ) {
 		$data = mysqli_fetch_array($result);
 		return $data[$kolom];
 	}else{
 	    return mysqli_error($dbconnect);
 	}
 	
}

//Get produk_item/parcel
function minus_produk_item($id,$idpesan_transorder,$arrayid_pisah){
	global $dbconnect;
	$args = "SELECT * FROM produk_item WHERE id_prod_master='$id'";
	$query = mysqli_query( $dbconnect, $args);
	$array_check = mysqli_fetch_array($query);

	$idparcel_proditem = $array_check['id'];
	$id_prodparcel = $array_check['id_prod_master'];

	$time_transorder = strtotime("now");

	$array_namaprod = $array_check['id_prod_item'];
	$get_array_nama = explode("|", $array_namaprod);

	$array_jumlahprod = $array_check['jumlah_prod'];
	$get_array_jumlah = explode("|", $array_jumlahprod);

	$number_parcelprod = count($get_array_nama)-1;
	$sum_number = 0;
	
	while ( $sum_number <= $number_parcelprod ) {
		$total_parcel_nama = $get_array_nama[$sum_number];
		$total_parcel_jumlah = $get_array_jumlah[$sum_number];

		if( $id_prodparcel == $id ){
			$ins_transorder = "INSERT INTO trans_order (id_pesanan, id_parcel, id_produk, jumlah, type, date) VALUES ('$idpesan_transorder', '$idparcel_proditem' ,'$total_parcel_nama', $total_parcel_jumlah, 'out', '$time_transorder')";
				$query_transorder = mysqli_query( $dbconnect,$ins_transorder );
			echo $total_parcel_nama." = ".$total_parcel_jumlah."<br>";
		}else{
			echo "Bukan Parcel";
		}

	$sum_number++;
	}
}

//Get stock produk_item/parcel
function parcelstock($data_id){
	global $dbconnect;
	$args = "SELECT * FROM produk_item WHERE id_prod_master='$data_id'";
	$query = mysqli_query( $dbconnect, $args);
	$array_check = mysqli_fetch_array($query);

	$idparcel_proditem = $array_check['id'];
	$id_prodparcel = $array_check['id_prod_master'];

	$array_namaprod = $array_check['id_prod_item'];
	$get_array_nama = explode("|", $array_namaprod);

	$array_jumlahprod = $array_check['jumlah_prod'];
	$get_array_jumlah = explode("|", $array_jumlahprod);

	$number_parcelprod = count($get_array_nama)-1;
	$sum_number = 0;
	
	while ( $sum_number <= $number_parcelprod ) {
		$total_parcel_nama = $get_array_nama[$sum_number];
		$total_parcel_jumlah = $get_array_jumlah[$sum_number];
        $args_produk     = "SELECT * FROM produk WHERE id='$total_parcel_nama'";
        $result_produk   = mysqli_query($dbconnect, $args_produk);
        if($result_produk){
                $data_produk=mysqli_fetch_array($result_produk);
                if ( $array_check >= 1 ) {
            	    $filterawal    = all_stok_prod($data_produk['id'],'stock_tersedia');
            	    $jumlahitem    = $filterawal - $total_parcel_jumlah;
            	    $filter        = all_stok_prod($jumlahitem,'stock_tersedia');
            	} 
        }$sum_number++;
    }
    return $filter;
}

//its parcel or not
function parcel($data_id){
	global $dbconnect;
	$args                   = "SELECT * FROM produk_item WHERE id_prod_master='$data_id'";
    $result                 = mysqli_query( $dbconnect, $args );
	$data_parcel            = mysqli_fetch_array($result);
	
    if ( $data_parcel >= 1 ) {
	    $parcel     = "1";
	} else {
	   $parcel     = "0";
	}
	return $parcel;
}


?>