<?php session_start();

// Global config
require('configuration.php');
setlocale(LC_ALL, "id_ID");
include 'Mobile_Detect.php';
/*
//require __DIR__ . 'escpos/autoload.php';
require('escpos/autoload.php');
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
$connector = new WindowsPrintConnector("EPSONTM-U220");
//$connector = new FilePrintConnector("php://stdout"); // Add connector for your printer here
*/

$dbconnect = mysqli_connect('localhost',DB_USER,DB_PASS,DB_NAME);

date_default_timezone_set(DEFAULT_TIME);

// Date Full Now
function date_full() {
	return date('d F Y');
}
// Hours NOW
function date_hour() {
	return date('H');
}
// Minute NOW
function date_minute() {
	return date('i');
}

// login salt
if ( is_login() ) { $salt = md5( current_user_id() ); }
else { $salt = md5('milyader_muda'); }
define('GLOBAL_FORM', md5('|Zm-{8H2Bk$Ftu+B'.date('yj').'oh2HK'.date('zn').'F8m1&;-Y').md5('G#gVmd^}#|N'.date('zj').'WrB|`E*'.$salt.'?o8bOM;~L'));

// check cookie
if ( isset($_COOKIE[USER_COOKIE]) && $_COOKIE[USER_COOKIE] != '' ) { $_SESSION[USER_SESSION] = $_COOKIE[USER_COOKIE]; }

// logout
if ( isset($_GET['logout']) && $_GET['logout']=='true' ) {
    setcookie("count_order", "", 0, "/");
    setcookie("notif_ordernew", "", 0, "/");
    setcookie("notif_shippingnew", "", 0, "/");
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
// is admin
function is_admin() {
	if ( '99' == current_user('user_role') ) { return true; }
	else { return false; }
}
// is Head Office
function is_ho() {
	if ( '40' <= current_user('user_role') && current_user('user_role') <= '60' ) { return true; }
	else { return false; }
}
// is Head Office logistik
function is_ho_logistik() {
	if ( current_user('user_role') == '60' ) { return true; }
	else { return false; }
}
// is Head Office Checker
function is_ho_checker() {
	if ( current_user('user_role') == '40' ) { return true; }
	else { return false; }
}
// is Head Office Driver
function is_ho_driver() {
	if ( current_user('user_role') == '50' ) { return true; }
	else { return false; }
}
// is admin Office
function is_adminoffice() {
	if ( '70' == current_user('user_role') ) { return true; }
	else { return false; }
}
function nama_user() {
	$user = current_user('nama');
	return ucwords($user);
}

// is Checker
function is_checker() {
	if ( '10' == current_user('user_role') ) { return true; }
	else { return false; }
}
// is Driver
function is_driver() {
	if ( '30' == current_user('user_role') ) { return true; }
	else { return false; }
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

// auto select
function auto_checked($value,$sumber) {
	if ( $value == $sumber ) { echo ' checked="checked" '; }
}
// format angka uang
function uang($number) {
    $cur = 'Rp ';
	return $cur.number_format($number,2,",",".");
}
// format angka uang
function uang_false($number) {
	return number_format($number,2,",",".");
}

function userid_by($parameter,$value) {
	global $dbconnect;
	$args = "SELECT * FROM user_member WHERE $parameter='$value'";
	$result = mysqli_query( $dbconnect, $args );
	if (mysqli_num_rows($result)) {
		$user = mysqli_fetch_array($result);
		return $user['id'];
	} else { return false; }
}
// user data by id
function user_data($id,$parameter) {
	global $dbconnect;
	$args = "SELECT * FROM user_member WHERE id='$id'";
	$result = mysqli_query( $dbconnect, $args );
	if (mysqli_num_rows($result)) {
		$user = mysqli_fetch_array($result);
		return $user[$parameter];
	} else { return false; }
}

// select first transaction, property: year, month, date, unix
function startfrom($property='unix') {
	global $dbconnect;
	$args = "SELECT MIN(date) as thefirst FROM pro_transaction";
	$result = mysqli_query( $dbconnect, $args );
	$array = mysqli_fetch_array($result);
	if ( 'year' == $property ) { return date('Y',$array['thefirst']); }
	else if ( 'month' == $property ) { return date('n',$array['thefirst']); }
	else if ( 'date' == $property ) { return date('d',$array['thefirst']); }
	else { return $array['thefirst']; }
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
	$content = substr($text, 0, $max);
	return $content;
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

// select user role
function peran($value) {
	if ( '99' == $value ) { echo 'Super Administrator'; }
	else if ( '10' == $value ) { echo 'Checker'; }
	else if ( '20' == $value ) { echo 'Helper'; }
    else if ( '30' == $value ) { echo 'Driver'; }
	else if ( '40' == $value ) { echo 'Head Checker'; }
    else if ( '50' == $value ) { echo 'Head Driver'; }
    else if ( '60' == $value ) { echo 'Head Logistic'; }
    else if ( '70' == $value ) { echo 'Admin Office'; }
	else { echo 'User'; }
}

// update jumlah produk per kategori
function jumlahproduk($id) {
	global $dbconnect;
	$args = "SELECT SUM(stock) FROM produk WHERE idkategori='$id'";
	$result = mysqli_query( $dbconnect, $args );
	$stock = mysqli_fetch_array($result);
//	return $stock[0];
	$jumlah = $stock[0];
	$upkate = "UPDATE kategori SET jumlah_produk='$jumlah' WHERE id='$id'";
	$result2 = mysqli_query( $dbconnect, $upkate );
}
function jmlprodkat($id) {
	global $dbconnect;
	$args = "SELECT * FROM produk WHERE idkategori='$id'";
	$result = mysqli_query( $dbconnect, $args );
	$jumlah = mysqli_num_rows($result);
	$upkate = "UPDATE kategori SET jumlah_produk='$jumlah' WHERE id='$id'";
	$result2 = mysqli_query( $dbconnect, $upkate );
//	return $jumlah;
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
	
//	return $jumlah;
}

function hapusprod($idkatlama) {
	global $dbconnect;
	$args = "SELECT * FROM kategori WHERE id='$idkatlama'";
	$result = mysqli_query( $dbconnect, $args );
	$kat = mysqli_fetch_array($result);
	$katjum = $kat['jumlah_produk'];
	$jumlah = $katjum - 1;
	$upkate = "UPDATE kategori SET jumlah_produk='$jumlah' WHERE id='$idkatlama'";
	$result2 = mysqli_query( $dbconnect, $upkate );
}

//function uplscart($data) {
//	global $dbconnect;
//	if ( is_login() ) {
//		$id = current_user_id();
//		$uparray = "UPDATE user SET array_cart='$data' WHERE id='$id'";
//		$result = mysqli_query( $dbconnect, $uparray );
//	}
//}

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
// Query List table Pesanan
function query_list_pesanan($type,$datefrom,$dateto,$jenis){
    global $dbconnect;
    $id_user= current_user_id();
    if( !empty($datefrom) && !empty($dateto) ){
        $filterdate = "WHERE '$datefrom' <= waktu_pesan AND waktu_pesan <= '$dateto'";
    }else{
        $filterdate = "WHERE waktu_pesan !='0'";
    }
    
    if( !empty($jenis) ){
        if($jenis == 'open'){
            $filter_type = "AND status != '50' AND aktif = '1'";
        }elseif($jenis == 'close'){
            $filter_type = "AND status = '50' AND aktif = '1'";
        }elseif($jenis == 'cancel'){
            $filter_type = "AND aktif = '0'";
        }else{
            $filter_type = "AND aktif = '1'";
        }
    }else{
        $filter_type = "AND aktif = '1'";
    }
    
    if( $type == 'checker' ){
        if( is_admin() || is_ho() ){
            $filter = "AND (status='10' OR status='20') AND ( (time_1_suspend = '0' AND time_1_to_suspend = '0') OR (time_1_suspend > '0' AND time_1_to_suspend > '0') )";
            $order = "waktu_pesan DESC";
        }else{
            $filter = "AND (status='10' OR status='20')  AND ( (time_1_suspend = '0' AND time_1_to_suspend = '0') OR (time_1_suspend > '0' AND time_1_to_suspend > '0') ) AND (id_checker='0' OR id_checker='$id_user')";
            $order = "waktu_pesan DESC";
        }
    }elseif( $type == 'checker-suspend' ){
        if( is_admin() || is_ho() ){
            $filter = "AND (status='10' OR status='20') AND (time_1_suspend > '0' AND time_1_to_suspend = '0')";
            $order = "waktu_pesan DESC";
        }else{
            $filter = "AND (status='10' OR status='20') AND (time_1_suspend > '0' AND time_1_to_suspend='0') AND id_checker='$id_user'";
            $order = "waktu_pesan DESC";
        } 
    }elseif( $type == 'helper' ){
        $filter = "AND status='10' OR status='20'";
        $order = "waktu_pesan DESC";
    }elseif( $type == 'driver' ){
        if( is_admin() || is_ho() ){
            $filter = "AND (status='20' OR status='30' OR status='40')";
            $order = "waktu_pesan DESC";
        }else{
            $filter = "AND (status='20' OR status='30' OR status='40') AND id_driver='$id_user'";
            $order = "waktu_pesan DESC";
        } 
    }elseif( $type == 'admin_proses' ){
        $filter = "AND status != '50'"; 
        $order = "id DESC";
    }elseif( $type == 'admin_selesai' ){
        $filter = "AND status = '50'";  
        $order = "id DESC";
    }else{
        $filter = "";
        $order = "id DESC";
    }
    $args = "SELECT * FROM pesanan $filterdate $filter $filter_type ORDER BY $order";
    $result = mysqli_query( $dbconnect, $args );
    return $result;
}
// Query table Pesanan
function query_pesanan($id){
    global $dbconnect;
    $args = "SELECT * FROM pesanan WHERE id='$id'";
    $result = mysqli_query( $dbconnect, $args );
	$order = mysqli_fetch_array($result);
    return $order;
}
// Get data table Pesanan
function querydata_pesanan($id,$data='nama'){
    global $dbconnect;
    $args = "SELECT * FROM pesanan WHERE id='$id'";
    $result = mysqli_query( $dbconnect, $args );
	$order = mysqli_fetch_array($result);
    return $order[$data];
}
// Split Status Pesaman
function split_status_order($data,$type){
    //tipe 0 = status, 1 = ID user, 2 = time
    $item = explode('|',$data);
    return $item[$type];
}

// Get data table User
function querydata_user($id,$data='nama'){
    global $dbconnect;
    $args = "SELECT * FROM user WHERE id='$id'";
    $result = mysqli_query( $dbconnect, $args );
	$order = mysqli_fetch_array($result);
    return $order[$data];
}
// Query table User - Role
function query_roleuser($type){
    global $dbconnect;
    if( $type == 'checker' ){ $filter = "WHERE user_role='10'"; }
    elseif( $type == 'helper' ){ $filter = "WHERE user_role='20'"; }
    elseif( $type == 'driver' ){ $filter = "WHERE user_role='30'"; }
    elseif( $type == 'hc' ){ $filter = "WHERE user_role='40'"; }
    elseif( $type == 'hd' ){ $filter = "WHERE user_role='50'"; }
    elseif( $type == 'hl' ){ $filter = "WHERE user_role='60'"; }
    elseif( $type == 'cust' ){ $filter = "WHERE user_role='3'"; }
    elseif( $type == 'internal_team' ){ $filter = "WHERE user_role!='3'"; }
    else{ $filter = ""; }
    $args = "SELECT * FROM user $filter ORDER BY nama ASC";
    $result = mysqli_query( $dbconnect, $args );
    return $result;
}

// Get data table Produk
function querydata_prod($id,$data='title',$type='id'){
    global $dbconnect;
    $args = "SELECT * FROM produk WHERE $type='$id'";
    $result = mysqli_query( $dbconnect, $args );
	$order = mysqli_fetch_array($result);
    return $order[$data];
}

function query_prod($id,$type){
	global $dbconnect;

	$args = "SELECT * FROM produk WHERE id='$id'";
	$result = mysqli_query($dbconnect,$args);

	return $result;
}

function data_rating($idprod){
	global $dbconnect;

	$args = "SELECT * FROM item_ranking WHERE id_produk='$idprod'";
	$result = mysqli_query($dbconnect,$args);

	return $result;
}

// Query list table Kategori
function query_list_kategori($type){
    global $dbconnect;
    if( $type == 'master'){
        $filter = "WHERE id_master='0'";
    }else{
        $filter = "WHERE id_master!='0'";
    }
    $args = "SELECT * FROM kategori $filter order by kategori";
    $result = mysqli_query( $dbconnect, $args );
    return $result;
}
// Query list table Kategori
function query_list_kategori_from_master($idmaster){
    global $dbconnect;
    $args = "SELECT * FROM kategori WHERE id_master='$idmaster' order by kategori";
    $result = mysqli_query( $dbconnect, $args );
    return $result;
}


// Count product based kategory
function get_jmlprod_kategori($idkat,$type){
    global $dbconnect;
    if( $type == 'master'){
        $filter = "WHERE idkategori='$idkat'";
    }else{
        $filter = "WHERE idsubkategori='$idkat'";
    }
    $argsjml = "SELECT * FROM produk $filter";
    $resultjml = mysqli_query( $dbconnect, $argsjml );
    $jumlah = mysqli_num_rows($resultjml);
    return $jumlah;
}

// Update Stok produk dari Jual beli
function update_stokproduk_id($idorder,$type){
    global $dbconnect;
    if( $type == 'jual' ){
        if( $idorder !== '' ){
            $list_idproduk_order = querydata_pesanan($idorder,'idproduk');
            $id_produk = explode('|',$list_idproduk_order);
            $jumlah_id_produk = count($id_produk) - 1;
            $x = 0;
            while($x <= $jumlah_id_produk) {
            $args_balance = "Select (
                                (select stock_order from produk where id='$id_produk[$x]') 
                                - 
                                (select coalesce(sum(jumlah),0) from trans_order where id_pesanan='$idorder' AND id_produk='$id_produk[$x]' AND type='out' AND status_jual='1')
                            ) AS jumlah_stokorder";
            $result_balance = mysqli_query( $dbconnect, $args_balance );
            $data_update = mysqli_fetch_array($result_balance);
            $jml_stok = $data_update['jumlah_stokorder'];
                //Update stok order di table produk
                $args_update = "UPDATE produk SET stock_order='$jml_stok' WHERE id='$id_produk[$x]'";  
                $result_update = mysqli_query( $dbconnect, $args_update );
            $x++;    
            }
        }
    }elseif( $type == 'beli' ){
        
    }
}


// Checking suspend atau tidak
// gunakan !status_suspend($order['id']) jika status suspend tidak aktif
// gunakan status_suspend($order['id']) jika status suspend aktif
function status_suspend($id){
    global $dbconnect;
    $suspend_1 = querydata_pesanan($id,'time_1_suspend');
    $suspend_1_to = querydata_pesanan($id,'time_1_to_suspend');
    if( $suspend_1 == '0' || ($suspend_1 !== '0' && $suspend_1_to !== '0' ) ){
        $status1 = '1';
    }else{
        $status1 = '0';
    }
    if( $status1 == '0' ){
        $hasil = true;
    }else{
        $hasil = false;
    }
    return $hasil;
}

function ket_statusorder($idstatus){
    if( $idstatus == '5' ){
        $keterangan = 'Menunggu pembayaran customer';
    }elseif( $idstatus == '10' ){
        $keterangan = 'Pembayaran telah terverifikasi.<br>Pesanan dalam proses pengecekan';
    }elseif( $idstatus == '20' ){
        $keterangan = 'Pesanan dalam proses pengemasan';
    }elseif( $idstatus == '30' ){
        $keterangan = 'Pesanan dalam proses pengiriman';
    }elseif( $idstatus == '40' ){
        $keterangan = 'Pesanan telah sampai dilokasi tujuan';
    }elseif( $idstatus == '50' ){
        $keterangan = 'Pesanan telah dikonfrimasi oleh customer'; 
    }else {
        $keterangan = ' --- ';
    }
    return $keterangan;
}

function ket_metodebayarpesanan($status){
    if( $status == 'nonsaldo' ){
        $keterangan = 'Menggunakan Pembayaran Langsung';
    }elseif( $status == 'sebagian' ){
        $keterangan = 'Menggunakan Pembayaran langsung dan sebagian Saldo';
    }elseif( $status == 'saldo' ){
        $keterangan = 'Menggunakan Saldo';
    }else {
        $keterangan = ' --- ';
    }
    return $keterangan;
}

function ket_typebayarpesanan($status){
    if( $status == 'pay_debit' ){
        $keterangan = ' - Transfer';
    }elseif( $status == 'pay_credit' ){
        $keterangan = ' - Kartu Kredit';
    }else {
        $keterangan = '';
    }
    return $keterangan;
}

// balance jumlah produk di tiap kategori
function balance_jmlprodukkategori(){
	global $dbconnect;
    // Looping master
	$result_master = query_list_kategori('master');
    if($result_master){
        while ( $data_master = mysqli_fetch_array($result_master) ) {
            $idkategori = $data_master['id'];
            $args_prod = "SELECT * FROM produk WHERE idkategori='$idkategori'";
            $result_prod = mysqli_query( $dbconnect, $args_prod );
            $jumlah_prod = mysqli_num_rows($result_prod);
            $update_kategori = "UPDATE kategori SET jumlah_produk='$jumlah_prod' WHERE id='$idkategori'";
            $result_kategori = mysqli_query( $dbconnect, $update_kategori );
        }
    }
    // Looping Sub Master
	$result_sub = query_list_kategori('sub');
    if($result_sub){
        while ( $data_sub = mysqli_fetch_array($result_sub) ) {
            $idkategori = $data_sub['id'];
            $args_prod = "SELECT * FROM produk WHERE idsubkategori='$idkategori'";
            $result_prod = mysqli_query( $dbconnect, $args_prod );
            $jumlah_prod = mysqli_num_rows($result_prod);
            $update_kategori = "UPDATE kategori SET jumlah_produk='$jumlah_prod' WHERE id='$idkategori'";
            $result_kategori = mysqli_query( $dbconnect, $update_kategori );
        }
    } 
}

// Query list table Produk
function query_beli_produk($type){
    global $dbconnect;
    if( $type == 'barcode'){
        $filter = "WHERE barcode!='0' order by barcode";
    }elseif( $type == 'nama'){
        $filter = "order by title";
    }else{
        $filter = "order by title";
    }
    $args = "SELECT * FROM produk $filter";
    $result = mysqli_query( $dbconnect, $args );
    return $result;
}

// tampilan item pada list jual beli
function tampil_item($item_id,$jumlah) {
    global $dbconnect;
	$array = explode('|',$item_id);
	$jml = explode('|',$jumlah);
    //$stn = explode('|',$satuan);
	$new_item = array();
	$codecatitem = '';
	$n = 0;
    foreach ( $array as $array ) {
        //$category_id = categoryproduct_data(product_data($array, 'category'), 'id');
        //$category_nama = categoryproduct_data(product_data($array, 'category'), 'name');

        $nama = querydata_prod($array);
        $new_item[] = '&bull; <strong>'.$nama.'</strong>: '.$jml[$n].' Pcs';
        $n++;
    }
    return implode('<br />',$new_item);
}

// Get data All Stok produk
function all_stok_prod($idproduk,$type){
    // $type option ( stock_tersedia / stok_order )
    global $dbconnect;
    if( $type !== '' && ($idproduk !== '0' || $idproduk !== '') ){
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
}

/*
function print_order($idorder){
$order = query_pesanan($idorder);

/* Left margin & page width demo. */
/*
$printer = new Printer($connector);
    
$nama_cust = querydata_user($order['id_user'],'nama');
$telp_cust = $order['telp'];
$subtotal_harga = uang(querydata_pesanan($idorder,'sub_total'));
$diskon = uang(querydata_pesanan($idorder,'diskon'));
$totalharga = uang(querydata_pesanan($idorder,'total'));
$date_pesan = date('d M Y, H.i', $order['waktu_kirim']);


$printer -> setEmphasis(true);
$printer -> setJustification(Printer::JUSTIFY_CENTER); 
$printer -> text("IDEASMART\n");
$printer -> setEmphasis(false);
$printer -> setJustification(Printer::JUSTIFY_CENTER); 
$printer -> text("Jl Mawar No 9, Mangkubumen, Banjarsari\n");
$printer -> setJustification(Printer::JUSTIFY_CENTER); 
$printer -> text("Kota Surakarta, Jawa Tengah\n");
$printer -> setJustification(Printer::JUSTIFY_CENTER); 
$printer -> text("Telp:  (0271) 7466499\n"); 
$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> text("========================================\n"); 
$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> text("ID Order      : $idorder\n");
$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> text("Waktu Pesan   : $date_pesan\n");
$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> text("Nama Customer : $nama_cust\n");
$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> text("Telp          : $telp_cust\n");

$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> text("========================================\n"); 

$list_order = querydata_pesanan($idorder,'idproduk');
$list_jml = querydata_pesanan($idorder,'jml_order');
$array_order = explode('|',$list_order);
$array_jml = explode('|',$list_jml);
                
$jumlah_item = count($array_order) - 1;
$x = 0;
$no = 1;
$total_harga_item = 0;
while($x <= $jumlah_item) {
$harga_item = querydata_prod($array_order[$x],'harga');
$total_harga_item = $harga_item * $array_jml[$x];
$namaprod = querydata_prod($array_order[$x],'short_title');
$jml = $array_jml[$x];
$harga = uang(querydata_prod($array_order[$x],'harga'));
$sub_total = uang($total_harga_item);

$printer -> text("$no        $namaprod\n");
$printer -> text("   $jml X $harga      $sub_total\n");
$x++;
$no++;
}

$printer -> text("========================================\n"); 
$printer -> text("Subtotal              $subtotal_harga\n");
$printer -> text("Diskon                $diskon\n");
$printer -> text("Total                 $totalharga\n");
$printer -> text("========================================\n"); 
$printer -> setJustification(Printer::JUSTIFY_CENTER); 
$printer -> text("Terima kasih");

/* Printer shutdown */
/*
$printer -> cut();
$printer -> close();
}
*/

// auto complete Barcode
function barcode_complete() {
	global $dbconnect;
	$args = "SELECT barcode FROM produk WHERE barcode!='0' ORDER BY barcode ASC";
	$result = mysqli_query( $dbconnect, $args );
	if ( mysqli_num_rows($result) ) {
		$list = array();
        while ( $barcode = mysqli_fetch_array($result)) { $list[] = '"'.$barcode["barcode"].'"'; }
		echo implode(",",$list);
	} else { echo ""; }
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

// Tenaaksi saldo User
function usersaldo_trans_item($type) {
	if ($type == 'plus') { return "Penambahan"; }
	else { return "Pengurangan"; };
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

// Get data table Trans Saldo
function querydata_pmsaldo($id,$data='type'){
    global $dbconnect;
    $args = "SELECT * FROM trans_saldo WHERE id='$id'";
    $result = mysqli_query( $dbconnect, $args );
	$order = mysqli_fetch_array($result);
    return $order[$data];
}

// Query data table Trans Saldo - Khusus Pesanan
function query_pmsaldo($idorder){
    global $dbconnect;
    $args = "SELECT * FROM trans_saldo WHERE id_pesanan='$idorder'";
    $result = mysqli_query( $dbconnect, $args );
    return $result;
}

// Query data Request Saldo
function query_reqsaldo($iduser){
    global $dbconnect;
    $args = "SELECT * FROM request_saldo WHERE id_user='$iduser' AND status='0' order by date_checkout";
    $result = mysqli_query( $dbconnect, $args );
    return $result;
}

// Get data table Request Saldo
function querydata_reqsaldo($id,$data='id_user'){
    global $dbconnect;
    $args = "SELECT * FROM request_saldo WHERE id='$id'";
    $result = mysqli_query( $dbconnect, $args );
	$order = mysqli_fetch_array($result);
    return $order[$data];
}

// Get data from Data Option
function querydata_dataoption($dataopsi){
    global $dbconnect;
    $args = "SELECT * FROM dataoption";
    $result = mysqli_query( $dbconnect, $args );
	while ( $opsi = mysqli_fetch_array($result) ) {
        if( $opsi['optname'] == $dataopsi ){
            $resultdata = $opsi['optvalue'];
        }
    }
    if(isset($resultdata)){ return $resultdata; }
    else { return ''; }
}

// Query data Notifikasi Pesanan baru
function querynotif_ordernew(){
    global $dbconnect;
    $args = "SELECT * FROM pesanan WHERE (status='10' OR status='20')  AND ( (time_1_suspend = '0' AND time_1_to_suspend = '0') OR (time_1_suspend > '0' AND time_1_to_suspend > '0') ) AND (id_checker='0') AND aktif='1' ORDER BY waktu_pesan DESC";
    $result = mysqli_query( $dbconnect, $args );
    return $result;
}

// Query data Notifikasi Pesanan Antar
function querynotif_shipping(){
    global $dbconnect;
    $args = "SELECT * FROM pesanan WHERE (status='20' OR status='30' OR status='40') AND id_driver='0' AND aktif='1' ORDER BY waktu_pesan DESC";
    $result = mysqli_query( $dbconnect, $args );
    return $result;
}

// Count order update
function count_order_update(){
    global $dbconnect;
    $args ="SELECT COUNT(id) AS jumlah FROM pesanan WHERE status !='5'";
    $result = mysqli_query( $dbconnect, $args );
	if ($result){
        $jml = mysqli_fetch_array($result);
		$totaljml = $jml['jumlah'];
	} else {
		$totaljml = 0;
	}
    return $totaljml;
}
// Count shipping order
function count_order_shipping(){
    global $dbconnect;
    $args ="SELECT COUNT(id) AS jumlah FROM pesanan WHERE status !='10'";
    $result = mysqli_query( $dbconnect, $args );
	if ($result){
        $jml = mysqli_fetch_array($result);
		$totaljml = $jml['jumlah'];
	} else {
		$totaljml = 0;
	}
    return $totaljml;
}

// data lokasi
function data_lokasi($idkota, $idkecamatan, $idkelurahan, $kolom) {
	global $dbconnect;
	$args="SELECT * FROM inf_lokasi WHERE lokasi_propinsi='34' AND lokasi_kabupatenkota='$idkota' AND lokasi_kecamatan='$idkecamatan' AND lokasi_kelurahan='$idkelurahan'";
    $result = mysqli_query( $dbconnect, $args );
	$data = mysqli_fetch_array($result);
	return $data[$kolom];
}
//Alamat Customer di Pesanan
function alamat_cust_pesanan($datacust){
    if( is_numeric($datacust) ){
        global $dbconnect;
        // Cari Alamat Order
        $args_carialamat = "SELECT * FROM alamat_order where id='$datacust'";
        $result_cari = mysqli_query( $dbconnect, $args_carialamat);
        if( $result_cari ) {
            $data_cari = mysqli_fetch_array($result_cari);
		    $alamat = $data_cari['alamat'];
            $kota = data_lokasi($data_cari['kota'],"00","0000","lokasi_nama");
            $kelurahan = data_lokasi($data_cari['kota'],$data_cari['kecamatan'],$data_cari['kelurahan'],"lokasi_nama");
            $kecamatan = data_lokasi($data_cari['kota'],$data_cari['kecamatan'],"0000","lokasi_nama");
            $data_alamat = $alamat.', '.$kelurahan.', '.$kecamatan.', '.$kota;
        } else {
            $data_alamat = ' --- ';
        }
    }else{
        $data_alamat = $datacust;
    }
    return $data_alamat;
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