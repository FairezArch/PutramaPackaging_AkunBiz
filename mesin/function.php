<?php session_start();

// Global config
require('configuration.php');
setlocale(LC_ALL, "id_ID");
include 'Mobile_Detect.php';

require('barcode/vendor/autoload.php');
require('excel_mesin/PHPExcel.php');
require('excel_mesin/PHPExcel/IOFactory.php');
require("pdf_mesin/tcpdf.php");
require("PHPMailer/src/phpmailer.php");
require('PHPMailer/src/Exception.php');
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
    $number = str_replace(".00", "", $number);
	return $cur.number_format($number,2,",",".");
}
// format angka uang
function uang_false($number) {
	$number = str_replace(".00", "", $number);
	return number_format($number,2,",",".");
}

// format angka uang to grosir
function uang_grosir($number) {
	$number = str_replace(".00", "", $number);
	return number_format($number,2,".","");
}

//function GENERATE BARCODE
function generate_barcode($value, $jarak=1, $height=30){
	$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
	return '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($value, $generator::TYPE_CODE_128_C, $jarak, $height)) . '">';
	//$generator = new \Picqer\Barcode\BarcodeGeneratorHTML();
	//return $generator->getBarcode($value, $generator::TYPE_CODE_128_C, $jarak, $height);
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

function active_menu($get=null,$value=null) {
	if ( $get == null ) { if ( empty($_GET) ) { echo 'current_menu'; }else{ echo ''; } }
	else if ( $value == null ) { if ( isset($_GET[$get]) ) { echo 'current_menu'; }else{ echo ''; } }
	else { if ( isset($_GET[$get]) && $_GET[$get] == $value ) { echo 'current_menu'; }else{ echo ''; } }
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

function data_custom($table,$target,$id,$select){
	global $dbconnect;
	$args = "SELECT * FROM $table WHERE $target='$id'";
	$get = mysqli_query($dbconnect,$args);
	$data = mysqli_fetch_array($get);
	return $data[$select];
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

// select data user
function get_userapp(){
	global $dbconnect;

	$args = "SELECT * FROM user_member WHERE verification='1' AND status_user='1'";
	$result = mysqli_query($dbconnect,$args);
	return $result;
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
        $filterdate = "WHERE waktu_pesan >=  '$datefrom' AND waktu_pesan <= '$dateto'";
    }else{
        $filterdate = "WHERE waktu_pesan !='0'";
    }
    //open = OR ( status='50' AND status_cek_bayar = 0 AND tipe_bayar='cod' )"close=AND status_cek_bayar = 0 
    if( !empty($jenis) ){
        if($jenis == 'open'){
            $filter_type = "AND status != '50' AND status_kasir ='0' AND status_cek_bayar != 0 AND aktif = '1'";
        }elseif($jenis == 'close'){
            $filter_type = "AND status = '50' AND status_kasir ='0' AND aktif = '1' AND status_cek_bayar !=0 OR ( status = '50' AND aktif = '1'  AND tipe_bayar !='cod') ";
        }elseif($jenis == 'cancel'){
            $filter_type = "AND aktif = '0' AND status_kasir ='0'";
        }else{
            $filter_type = "AND aktif = '1' AND status_kasir ='0' OR aktif='0'";
        }
    }else{
        	$filter_type = "AND aktif = '1' AND status_kasir ='0'";
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
    //$array_pesan = mysqli_fetch_array($result);
    return $result;
}
//list diskon table produk
function querylist_diskonprod($list){
	global $dbconnect;

    if( !empty($list) ){
        if($list == 'open'){
            $filter_type = "WHERE promo='1' AND harga_promo !='0'";
        }elseif($list == 'non'){
            $filter_type = "WHERE promo='0'";
       	}elseif($list == 'all'){
       		$filter_type = "WHERE promo = '0' OR promo ='1' ";
       	}
    }else{
        $filter_type = " ";
    }

    $args = "SELECT * FROM produk $filter_type ORDER BY id";
    $result = mysqli_query( $dbconnect, $args );

    return $result;

}

function query_produk(){
	global $dbconnect;
	$args = "SELECT * FROM produk";
	$result = mysqli_query($dbconnect,$args);

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

// Get data table User
function querydata_usermember($id,$data='nama'){
    global $dbconnect;
    $args = "SELECT * FROM user_member WHERE id='$id'";
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

//Produk query
function queryprod($id){
	global $dbconnect;
	$args = "SELECT * FROM produk WHERE id='$id'";
	$result = mysqli_query($dbconnect,$args);
	return $result;
}

function querydata_memberuser(){
	global $dbconnect;
    $args = "SELECT * FROM user_member";
    $result = mysqli_query( $dbconnect, $args );

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

//Get data product from kategori
function prod_fromkat($idkat){
	global $dbconnect;
	$args_prod = "SELECT * FROM produk WHERE idkategori='$idkat'";
	$result_prod = mysqli_query($dbconnect,$args_prod);
	return $result_prod;
}

function randomGreen() {
	$red = rand(14,23);
	$green = rand(96,166);
	$blue = rand(87,151);
	return "rgba(".$red.",".$green.",".$blue.",0.9)";
}

function randomRed() {
	$red = rand(217,247);
	$green = rand(50,138);
	$blue = rand(60,64);
	return "rgba(".$red.",".$green.",".$blue.",0.9)";
}

//Get all Stock in trans order
function datastock_transorder($id,$from,$to,$stock){
	global $dbconnect;
	if($stock == '3'){
		$args = "SELECT * FROM trans_order WHERE id_produk='$id' AND date >= '$from' AND date < '$to' AND (trans_from ='$stock' || trans_to ='$stock') AND ( type='in' || type='trans' ) OR id_produk='$id' AND date >= '$from' AND date < '$to' AND status_jual='1' AND type='out'";
	}else if($stock == '2'){	
		$args = "SELECT * FROM trans_order WHERE date >= '$from' AND date < '$to' AND id_produk='$id' AND status_jual='0' AND  type='in' AND id_pembelian !='0' OR (trans_from ='$stock' || trans_to ='$stock') AND id_produk='$id' AND status_jual='0' AND  ( type='in' || type='trans' ) ";
	}else{
		$args = "SELECT * FROM trans_order WHERE date >= '$from' AND date < '$to' AND id_produk='$id' AND (trans_from ='$stock' || trans_to ='$stock') AND id_produk='$id' AND status_jual='0' AND ( type='in' || type='trans' )";
	}
	$result = mysqli_query($dbconnect,$args);
	return $result;
}

//data metode bayar
function querydata_metodebayar(){
	global $dbconnect;

	$args = "SELECT * FROM list_pay";
	$result = mysqli_query($dbconnect,$args);

	return $result;
}

//List metode bayar pesanan
function title_metodebayar($data){
	global $dbconnect;

	$args_pay = "SELECT * FROM list_pay WHERE pay_name='$data'";
	$result_pay = mysqli_query($dbconnect,$args_pay);
	$array_pay = mysqli_fetch_array($result_pay);
	$title = $array_pay['title_name'];

	return $title;
}

//List Laporan Penjualan
function all_totalpesanan($idkatprod,$tipe,$from,$to,$list_cek,$hpp_harga){
	global $dbconnect;

	if($list_cek == 'aplikasi'){
		$args_pesanan = "SELECT * FROM pesanan WHERE tipe_bayar='pay_transfer' AND metode_bayar='nonsaldo' AND status_kasir='0' AND aktif='1' AND waktu_pesan >= '$from' AND waktu_pesan <= '$to' ";
	}else{
		$args_pesanan = "SELECT * FROM pesanan WHERE status_kasir='1' AND aktif='1' AND waktu_pesan >= '$from' AND waktu_pesan <= '$to'";
	}

	$result_pesanan = mysqli_query($dbconnect,$args_pesanan);

	$data_order = array();
	$data_totalnominal = array();
	$data_total_hpp = array();
	
	while ($data_pesanan = mysqli_fetch_array($result_pesanan)) {
		$get_idprod = $data_pesanan['idproduk'];
		$list_idprod = explode("|", $get_idprod);

		$get_jmlprod = $data_pesanan['jml_order'];
		$list_jmlprod = explode("|", $get_jmlprod);

		$get_hargaprod = $data_pesanan['harga_item'];
		$list_hargaprod = explode("|", $get_hargaprod);

		$count_id = count($list_idprod);
		$x=0;
		$y=1;

		while ($y <= $count_id) {
			${'cek_id'.$x} = $list_idprod[$x];
			${'cek_jml'.$x} = $list_jmlprod[$x];
			${'cek_harga'.$x} = $list_hargaprod[$x];
			${'total_prod'.$x} = ${'cek_harga'.$x} * ${'cek_jml'.$x};
			${'total_hpp'.$x} = $hpp_harga * ${'cek_jml'.$x};

			if( ${'cek_id'.$x} == $idkatprod){
				$data_order[] = ${'cek_jml'.$x};
				$data_totalnominal[] = ${'total_prod'.$x}; 
				$data_total_hpp[] = ${'total_hpp'.$x};
			}
			$x++; $y++;
		}
	}

	if( $tipe == 'totalharga' ){
		$result_total = array_sum($data_totalnominal);
	}else{
		if( $tipe == 'hpp' ){
			$result_total = array_sum($data_total_hpp);
		}else{
			$result_total = array_sum($data_order);
		}
	}

	if($result_total){
		return $result_total;
	}else{
		return '0';
	}
	//$data_pesanan = mysqli_fetch_array($result_pesanan);
	//$sat = $data_pesanan;
	//$prod_pesan = $data_pesanan['idproduk'];
	//$exp_prodpesan = explode("|", $prod_pesan);

	//$countt = count($exp_prodpesan)-1;
	//$x=0;
	/*$args_product = "SELECT * FROM produk WHERE idkategori='$idkat'";
	$result_product = mysqli_query($dbconnect,$args_product);
	while($jumlah_prod = mysqli_fetch_array($result_product)){
	$idnya = $jumlah_prod['id'];	
	//$count = count($idnya)-1;	
	//$x=0;
	//while ($x <= $count) {
	//	$balance = $idnya[$x];
	//	$x++;
	//}
	
	*/
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
        $keterangan = 'Menggunakan Pembayaran Sebagian';
    }elseif( $status == 'saldo' ){
        $keterangan = 'Menggunakan Saldo';
    }elseif( $status == 'cash'){
    	$keterangan = 'Menggunakan Pembayaran Cash';
    }else {
        $keterangan = ' --- ';
    }
    return $keterangan;
}

function ket_typebayarpesanan($status){
    if( $status == 'pay_debit'){
        $keterangan = ' - Debit Transfer';
    }elseif( $status == 'pay_credit' ){
        $keterangan = ' - Kredit';
    }elseif ($status == 'cod') {
    	$keterangan = ' - Bayar Tunai';
    }elseif ( $status == 'ovo') {
    	$keterangan = ' - OVO';
    }elseif ( $status == 'gopay') {
    	$keterangan = ' - GOPAY';
    }elseif ( $status == 'cash'){
    	$keterangan = ' - Cash/Tunai';
    }elseif ( $status == 'inSaldo'){
        $keterangan = ' - Saldo Putrama Packaging';
    }elseif ( $status == 'pay_transfer'){
    	$keterangan = ' - Transfer';
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
        $new_item[] = '&bull; <a class="linkprod" title="Lihat Detail Produk '.$nama.'" href="?prokat=produk&viewproduk='.$array.'" target="_blank"> <strong>'.$nama.'</strong></a>: '.$jml[$n].' Pcs';
        $n++;
    }
    return implode('<br />',$new_item);
}

function tampil_itemExcel($item_id,$jumlah){
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
        $new_item[] = "•".$nama.": ".$jml[$n]." Pcs";
        $n++;
    }
    return implode("\n",$new_item);
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

//All Stock to Display
function allstock_display($idprod, $field_stock){
	global $dbconnect;

	if($field_stock == '1'){
			$args = "SELECT
			( SELECT stock FROM produk WHERE id='$idprod')
			+
			(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE id_produk='$idprod' AND type='in' AND trans_from='$field_stock')
			-(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE id_produk='$idprod' AND type='out' AND trans_from='$field_stock')
			+
			( SELECT COALESCE(SUM(jumlah),0) FROM trans_order WHERE id_produk='$idprod' AND type='trans' AND trans_to='$field_stock' )
			-( SELECT COALESCE(SUM(jumlah),0) FROM trans_order WHERE id_produk= '$idprod' AND type='trans' AND trans_from='$field_stock' )

			AS total_stock";
	}elseif($field_stock == '2'){
		$args = "SELECT
			(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE id_produk='$idprod' AND type='in' AND trans_from='$field_stock')
			-(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE id_produk='$idprod' AND type='out' AND trans_from='$field_stock')
			+
			( SELECT COALESCE(SUM(jumlah),0) FROM trans_order WHERE id_produk='$idprod' AND type='trans' AND trans_to='$field_stock' )
			-( SELECT COALESCE(SUM(jumlah),0) FROM trans_order WHERE id_produk= '$idprod' AND type='trans' AND trans_from='$field_stock' )
			+
			( SELECT COALESCE(SUM(jumlah),0) FROM trans_order WHERE id_produk= '$idprod' AND type='in' AND id_pembelian !='0')
			AS total_stock";
	}elseif ($field_stock == '3') {
		$args = "SELECT
			(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE id_produk='$idprod' AND type='in' AND trans_from='$field_stock')
			-(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE id_produk='$idprod' AND type='out' AND trans_from='$field_stock')
			+
			( SELECT COALESCE(SUM(jumlah),0) FROM trans_order WHERE id_produk='$idprod' AND type='trans' AND trans_to='$field_stock' )
			-
			( SELECT COALESCE(SUM(jumlah),0) FROM trans_order WHERE id_produk= '$idprod' AND type='trans' AND trans_from='$field_stock' )
			-
			( SELECT COALESCE(SUM(jumlah),0) FROM trans_order WHERE id_produk= '$idprod' AND type='out' AND status_jual='1' )
			AS total_stock";
	}else{}

	$result = mysqli_query($dbconnect,$args);
	$sum_produk = mysqli_fetch_array($result);
	return $sum_produk['total_stock'];
}

//Product Stock update
function productstock_update($idproduk, $trans_stock){
	global $dbconnect;

	$sum_stock = allstock_display($idproduk, $trans_stock);
	if($trans_stock == '1'){ $field = 'stock_produksi'; }
	elseif($trans_stock == '2'){ $field = 'stock_toko'; }
	elseif($trans_stock == '3'){ $field = 'stock_display'; }
	$args = "UPDATE produk SET $field = '$sum_stock' WHERE id='$idproduk'";
	$result = mysqli_query($dbconnect,$args);
	return true;
}



function name_transstock($idtrans){
	if($idtrans == '1'){ $field = 'Stock Produksi'; }
	elseif($idtrans == '2'){ $field = 'Stock Toko'; }
	elseif($idtrans == '3'){ $field = 'Stock Display'; }
	return $field;
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

// Transaksi saldo User
function usersaldo_trans_item($type) {
	if ($type == 'plus') { return "Penambahan"; } elseif($type == 'none') { return "None";}
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
    $args = "SELECT * FROM pesanan WHERE aktif='1' AND status_kasir='0' AND status_cek_bayar !=='0' ORDER BY waktu_pesan DESC";
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

// test query dari penjualan
function querynotif_ordernew_penjualan(){
	global $dbconnect;
	$args = "SELECT * FROM pesanan WHERE aktif='1' AND status_kasir='0' AND status_cek_bayar !='0' AND status <='10' ORDER BY waktu_pesan DESC";
	$result = mysqli_query($dbconnect,$args);
	return $result;
}

// Count order update
function count_order_update(){
    global $dbconnect;
    $args ="SELECT COUNT(id) AS jumlah FROM pesanan WHERE aktif='1' AND status_kasir='0' AND status_cek_bayar !='0' AND status <='10'";
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

function alamat_customer_pesanan($datacust){
	 if( is_numeric($datacust) ){
        global $dbconnect;
        // Cari Alamat Order
        $args_carialamat = "SELECT * FROM alamat_order where id='$datacust'";
        $result_cari = mysqli_query( $dbconnect, $args_carialamat);
        if( $result_cari ) {
            $data_cari = mysqli_fetch_array($result_cari);
		    $alamat = $data_cari['alamat'];
            $provinsi   = split_status_order($data_cari['provinsi'],'1');
		    $kabupaten  = split_status_order($data_cari['kabupaten'],'1');
		    $kecamatan  = split_status_order($data_cari['dt_kecamatan'],'1');
            $data_alamat = $alamat.', '.$kabupaten.', '.$kecamatan.', '.$provinsi;
        } else {
            $data_alamat = ' --- ';
        }
    }else{
        $data_alamat = $datacust;
    }
    return $data_alamat;
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
//Get data option
function get_dataoption($opt_name){
    global $dbconnect;
    
    $sql_dtopt = "SELECT * FROM dataoption WHERE optname='$opt_name'";
    $query_dtopt = mysqli_query( $dbconnect, $sql_dtopt );
    $array_dtopt = mysqli_fetch_array( $query_dtopt );
    return $array_dtopt['optvalue'];
}
// Pembatan Pesanan
function pesanan_batal($idorder){
    global $dbconnect;
    $iduser = querydata_pesanan($idorder,'id_user');
    $idprod = querydata_pesanan($idorder,'idproduk');
    $n=0;
    $exp_prod = explode("|", $idprod);
    $count_prod = count($exp_prod)-1;

    
    // Data Transaksi Order
	$args_order = "DELETE FROM trans_order WHERE id_pesanan='$idorder'";
	$del_order = mysqli_query( $dbconnect, $args_order );
		if($del_order){
			while($n <= $count_prod){
	    		productstock_update($exp_prod[$n],'3');
	    		$n++;
	    	}
		}
    
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
        $args_konfrimsaldo = "DELETE FROM konfirmasi_saldo WHERE id_reqsaldo='$idreqsaldo'";
        $result_konfrimsaldo = mysqli_query( $dbconnect, $args_konfrimsaldo );
    }
    $args_delreqsaldo = "DELETE FROM request_saldo WHERE id_pesanan='$idorder'";
    $result_delreqsaldo = mysqli_query( $dbconnect, $args_delreqsaldo );
    
    // Data Pesanan
	$args ="UPDATE pesanan SET aktif='0' WHERE id='$idorder'";
    $result = mysqli_query( $dbconnect, $args );

    // cek apakah ada transaksi di buku kas
	$args_cek = "SELECT * FROM transaction_kas WHERE pesanan='$idorder'";
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

    if ($result){
        return true;
    } else {
        return false;
    }
}

// auto konfirm pesanan user 
function auto_konfir_user($idorder){
    global $dbconnect;

    $userdb = current_user_id();
    $datedb = strtotime('now');
   	//$x= 0;
    //$countid = count($idorder)-1;

    //while($x <= $countid){
    	//$listid =  $idorder[$x];
    	//if($listid == $idorder){
		    $args_pesan = "SELECT * FROM pesanan WHERE id='$idorder' AND aktif='1' AND status_2_driver !=0 AND status_3_driver !=0 AND status_3_cust = 0";
		    $result_pesan = mysqli_query($dbconnect,$args_pesan);
		    while($konfir_user = mysqli_fetch_array($result_pesan)){
		    	$waktu_kirim = $konfir_user['status_2_driver'];
		    	$list_id = $konfir_user['id'];
		    	$exp_waktu = split_status_order($waktu_kirim,'2');
		    	$count_time = $exp_waktu*1;
		    	$batas_waktu = $count_time+60*60*336;
		    	$hasil = '1|'.$userdb.'|'.$batas_waktu;
		    		if($batas_waktu < $datedb){
			    		$args_konfirm = "UPDATE pesanan SET status_3_cust='$hasil', status='50' WHERE id='$list_id'";
			       		$result_konfirm = mysqli_query($dbconnect,$args_konfirm);
		    		}
		    }
	    //}
    	//x++;
   // }
}

// Auto Batal Pesanan
function auto_pesanan_batal($iduser){
    global $dbconnect;
    $date_db = strtotime("now");
    // Data User di Pesanan
    $args_datapesanan = "SELECT * FROM pesanan WHERE id_user='$iduser' AND status='5' AND aktif='1' AND status_kasir ='0'";
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
    	        $count_time = get_dataoption('waktu_countdown')*3600;
    	        $date_timeout = ($item_pesanan['waktu_pesan'] * 1) + $count_time;
    	        $date_timeout2 = '1jam';
    	        //Pengecekan Timeout
        		if( $date_timeout < $date_db ){
        			//Batalkan Pesanan
        			pesanan_batal($idpesanan);
        		}
    	    }else{
    	        $date_timeout = ($item_pesanan['waktu_pesan'] * 1) + 7200;
    	        $date_timeout2 = '2jam';
    	        //Pengecekan Timeout
        		if( $date_timeout < $date_db ){
        			//Batalkan Pesanan
        			pesanan_batal($idpesanan);
        		}
    	    }
	    }
	    $count_time = get_dataoption('waktu_countdown')*3600;
    	$date_timeout = ($item_pesanan['waktu_pesan'] * 1) + $count_time;
    	$date_timeout2 = '1jam';
    	//Pengecekan Timeout
        	if( $date_timeout < $date_db ){
        		//Batalkan Pesanan
        		pesanan_batal($idpesanan);
        	}
		
    }
    return true;
}

//Get Produk Item
function prod_item($id){
	global $dbconnect;
	$args = "SELECT * FROM produk_item WHERE id_prod_master='$id'";
	$query = mysqli_query( $dbconnect, $args );
	$array = mysqli_fetch_array($query);
	return $array;
}

//Get produk_item
function minus_produk_item($id,$idpesan_transorder){
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

//status pesanan cod
function status_pesancod($id){
	global $dbconnect;
	$args = "SELECT * FROM pesanan WHERE id='$id'";
	$query_statuspesan = mysqli_query($dbconnect, $args);
	$array_statuspesan = mysqli_fetch_array($query_statuspesan);

	$idpesan = $array_statuspesan['id'];
	$lihat_statuspesan = $array_statuspesan['status'];
	$tipe_bayarpesan = $array_statuspesan['tipe_bayar'];

	if ($tipe_bayarpesan == 'cod') {
		$pilih = "UPDATE pesanan SET status='10' WHERE id='$idpesan'";
	}else{
		echo '....';
	}
}

/*function pembelian_produk($id){
	global $dbconnect;

	$args = "SELECT * FROM pesanan WHERE id='$id'";
	$result = mysqli_query($dbconnect,$args);
	$array = mysqli_fetch_array($result);

	$get_tipebayar = $array['tipe_bayar'];

	if ( $get_tipebayar == 'cod') {
		$up_pesanan = "UPDATE pesanan SET status='10' WHERE id='$id'";		
	}else{
		 echo "gagal";
	}
	$result = mysqli_query($dbconnect, $up_pesanan);
	return $result;
}*/

//mengubah status = 10 untuk cod
function change_status($id){
	global $dbconnect;

	$list_tipebayar = querydata_pesanan($id,'tipe_bayar');

	if ( $list_tipebayar == 'cod' ) {
		$udp_pesanan = "UPDATE pesanan SET status='10' WHERE id='$id'";
		$result_tipebayar = mysqli_query( $dbconnect, $udp_pesanan );
	}else{
		echo "Gagal";
	}
		

}
//Query trans_saldo, saldo sebagian
function saldo_sebagian($id_pesansebagian){
	global $dbconnect;

	$args_saldosebagian = "SELECT * FROM trans_saldo WHERE id_pesanan='$id_pesansebagian' AND type='minus'";
	$result_saldo = mysqli_query( $dbconnect, $args_saldosebagian );
	$array_saldo = mysqli_fetch_array($result_saldo);

	return $array_saldo;
}

//Cek parcel
function cek_parcel($idparcel){
	global $dbconnect;

	$args = "SELECT * FROM produk_item WHERE id_prod_master='$idparcel'";
	$result = mysqli_query($dbconnect,$args);
	$list_parcel = mysqli_fetch_array($result);
	if($list_parcel){
		$parcel = "1";
	}else{
		$parcel = "0";
	}

	return $parcel;
}

// Query Penjualan in table Pesanan
function query_penjualan($id){
    global $dbconnect;
    $args = "SELECT * FROM pesanan WHERE id='$id' AND status_bayar='tunai' AND status_kasir='1'";
    $result = mysqli_query( $dbconnect, $args );
	$order = mysqli_fetch_array($result);
    return $order;
}
// Get data Penjualan in table Pesanan
function querydata_penjualan($id,$data='nama'){
    global $dbconnect;
    $args = "SELECT * FROM pesanan WHERE id='$id' AND status_bayar='tunai' AND status_kasir='1'";
    $result = mysqli_query( $dbconnect, $args );
	$order = mysqli_fetch_array($result);
    return $order[$data];
}

// query email konfir bayar
function email_transorder($idpesan){
	global $dbconnect;
	$args = "SELECT * FROM trans_order WHERE id_pesanan='$idpesan' AND type='out' ORDER BY id ASC";
	$result = mysqli_query($dbconnect,$args);
	$struktur = "";
	if($result){
		$struktur .= "<table class='nexttable'>";
		$struktur .= "<thead>";
		$struktur .= "<tr>";
		$struktur .= "<th width='202'>Produk</th>";
		$struktur .= "<th width='50'>Jumlah</th>";
		$struktur .= "<th width='126'>Harga Satuan</th>";
		$struktur .= "<th width='126'>Harga</th>";
		$struktur .= "<tr>";
		$struktur .= "</thead>";
		$struktur .= "<tbody>";
		while($data_pesan = mysqli_fetch_array($result)){
			$struktur .= "<tr>";
		    $struktur .= "<td>".data_tabel('produk', $data_pesan['id_produk'], 'title')."</td>";
		    $struktur .= "<td><center>".$data_pesan['jumlah']."</center></td>";
		    $struktur .= "<td>Rp ".format_angka( $data_pesan['harga'] )."</td>";
		    $struktur .= "<td>Rp ".format_angka( $data_pesan['jumlah'] * $data_pesan['harga'] )."</td>";
		    $struktur .= "</tr>";
		}
		$struktur .= "</tbody>";
		$struktur .= "<tr>";
	    $struktur .= "<td colspan='3'><center>Biaya Pengiriman</center></td>";
	    $struktur .= "<td>Rp ".format_angka( data_tabel('pesanan', $pesanan, 'ongkos_kirim') )."</td>";
	    $struktur .= "</tr>";
		$struktur .= "<tr style='background: #e9e9e9;'>";
	    $struktur .= "<td colspan='3'><center><strong>Sub Total</strong></center></td>";
	    $struktur .= "<td>Rp ".format_angka( data_tabel('pesanan', $pesanan, 'total') )."</td>";
	    $struktur .= "</tr>";
		$struktur .= "</table>";
	}
	return $struktur;
}

// get name payment
function payment_name($payment_id){
	global $dbconnect;

	$args = "SELECT * FROM list_pay WHERE id='$payment_id'";
	$query = mysqli_query($dbconnect,$args);
	$result = mysqli_fetch_array($query);
	$data_pay = $result['pay_name'];

	return $data_pay;
}

function table_inv($status){
	global $dbconnect;
	$args = "SELECT * FROM inventory WHERE type='$status'";
	$result = mysqli_query($dbconnect,$args);
	return $result;
}

function inv_status($status){
	switch ($status) {
		case '1': $return = 'Aktif'; break;
		case '2': $return = 'Dijual'; break;
		case '3': $return = 'Dibuang'; break;
		default: $return = 'Disembunyikan'; break;
	}
	return $return;
}

function inv_type($type){
	switch ($type) {
		case '1': $return = 'kantor'; break;
		default: $return = ''; break;
	}
	return $return;
}



// umur inventaris
function inv_umur($inv_id,$month='now',$year='now',$output='tahun') {
	global $dbconnect;
	if ( $month == 'now' ) { $month = date('n'); }
	if ( $year == 'now' ) { $year = date('Y'); }
	$args = "SELECT date FROM inventory WHERE id='$inv_id'";
	$result = mysqli_query( $dbconnect, $args );
	$inv = mysqli_fetch_array($result);
	$month_start = date('n',$inv['date']);
	$year_start = date('Y',$inv['date']);
	$umur = ( $month + ( 12*$year ) ) - ( $month_start + ( 12*$year_start ) );
	if ( 'bulan' == $output ) {
		return $umur;
	} else {
		$tahun = floor( $umur / 12 );
		$bulan = $umur - ($tahun*12);
		return $tahun." tahun ".$bulan." bulan";
	}
}

function neraca_inv($type,$from,$to) {
	global $dbconnect;

	$args = "SELECT SUM(price_start) AS inventaris FROM inventory
		WHERE type='$type' AND (date >= '$from' AND date < '$to') AND date_sell >= '$to'";
	$result = mysqli_query( $dbconnect, $args );
	$inventaris = mysqli_fetch_array($result);
	return $inventaris['inventaris'];
}

function inv_total_value($type,$month='now',$year='now') {
	global $dbconnect;
	if ( $month == 'now' ) { $month = date('n'); }
	if ( $year == 'now' ) { $year = date('Y'); }

	$args = "SELECT id FROM inventory WHERE type='$type' (date >= '$month' AND date < '$year') AND date_sell > $year";
	$result = mysqli_query( $dbconnect, $args );
	$total = 0;
	if ($result) { while ( $inv = mysqli_fetch_array($result) ) {
			$total = $total + inv_value($inv['id']);
				} 
	}
	return $total;
}

// get list grosir
function data_grosir($idproduk){
	global $dbconnect;

	$args = "SELECT * FROM daftar_grosir WHERE id_produk='$idproduk'";
	$result = mysqli_query($dbconnect,$args);
	$array = mysqli_fetch_array($result);

	return $array;
}

//get user from telp
function user_byphone($telp,$data='id'){
	global $dbconnect;

	$args = "SELECT * FROM user WHERE telp='$telp'";
	$result = mysqli_query($dbconnect,$args);
	$array = mysqli_fetch_array($result);

	return $array[$data];
}

// cek jumlah termasuk grosir
function cek_hargagrosir($idprod,$jumlah,$harga){
	global $dbconnect;

	$harga_tetap = array();
	$args = "SELECT * FROM daftar_grosir";
	$result = mysqli_query($dbconnect,$args);

	while ($array_data = mysqli_fetch_array($result) ) {
		$a=0;
		$grosir_idprod = $array_data['id_produk'];
		$grosir_from = $array_data['qty_from'];
		$grosir_to = $array_data['qty_to'];
		$grosir_harga = $array_data['harga_satuan'];

		$exp_idprod = explode('|', $idprod);
		$exp_jumlah = explode('|', $jumlah);
		$exp_harga = explode('|', $harga);

		$data_id = count($exp_idprod)-1;
		while ($a <= $data_id) {
				$x=0;
				$exp_from = explode('|', $grosir_from);
				$exp_to = explode('|', $grosir_to);
				$exp_hargaGrosir = explode('|', $grosir_harga);

				$count_data = count($grosir_from)-1;
				while ( $x <= $count_data){
					if( $exp_idprod[$a] == $grosir_idprod ){
						if( $exp_jumlah[$x] >= $exp_from[$x] && $exp_jumlah[$x] < $exp_to[$x] ){
							$harga_tetap[] = $exp_hargaGrosir[$x];
						}
					}else{
						$harga_tetap[] = $harga;
					}
					$result_harga = join('|',$harga_tetap);
					$x++;
				}
			$a++;
		}

	}

	return $result_harga;
}

function cicilan_byidpesan($idpesan){
	global $dbconnect;

	$args = "SELECT * FROM log_kredit WHERE id_pesanan='$idpesan'";
	$result = mysqli_query($dbconnect,$args);

	return $result;
}

function query_cicilan($idkredit){
	global $dbconnect;

	$args = "SELECT * FROM log_kredit WHERE id='$idkredit'";
	$result = mysqli_query($dbconnect,$args);
	$array_data = mysqli_fetch_array($result);

	return $array_data;
}

function querydata_cicilan($idkredit,$data){
	global $dbconnect;

	$args= "SELECT * FROM log_kredit WHERE id='$idkredit'";
	$result = mysqli_query($dbconnect,$args);
	$kredit = mysqli_fetch_array($result);

	return $kredit[$data];
}

function orderby_cicilan($idpesan,$data,$remaining){
	global $dbconnect;

	$array = array();
	$args= "SELECT * FROM log_kredit WHERE id_pesanan='$idpesan'";
	$result = mysqli_query($dbconnect,$args);
	while($kredit = mysqli_fetch_array($result)){
		$array[]  = $kredit[$data];
	}

	$data_kredit = array_sum($array);
	$data_result = $remaining - $data_kredit;
	$test = $data_result.".00";

	return $test;
}

// jumlah hutang piutang, $tipe = debt atau credit
function neraca_hapiut($tipe,$from,$to) {
	global $dbconnect;
	
	$args_hapiut = "SELECT id FROM hapiut WHERE type='$tipe' AND date >= $from AND date <= $to";
	$result_hapiut = mysqli_query( $dbconnect, $args_hapiut );
	if ( $result_hapiut ) {
		$listhapiut = array();
		while ( $hapiut = mysqli_fetch_array($result_hapiut) ) { $listhapiut[] = "parenthp='".$hapiut['id']."'"; }
		$allhapiut = "AND ( ".implode(" OR ",$listhapiut)." )";
	} else {
		$allhapiut = '';
	}
	$args = "SELECT
			( SELECT COALESCE(SUM(amount),0) FROM hapiut_item WHERE type='plus' AND date >= $from AND date <= $to $allhapiut )
			- ( SELECT COALESCE(SUM(amount),0) FROM hapiut_item WHERE type='minus' AND date >= $from AND date <= $to $allhapiut )
			+ ( SELECT COALESCE(SUM(saldostart),0) FROM hapiut WHERE type='$tipe' AND date >= $from AND date <= $to )
		AS baltotal";
	$result = mysqli_query( $dbconnect, $args );
	if ( $result ) {
		$array = mysqli_fetch_array($result);
		return $array['baltotal'];
	} else {
		return 0;
	}
}

//Jumlah Piutang lebih dari 1 tahun
function more_neracahapiut($type,$from,$to){
	global $dbconnect;

	$date_now = strtotime('now');

	$args = "SELECT id,date FROM hapiut WHERE type='$type' AND status='1'";
	$result = mysqli_query($dbconnect,$args);
	if( $result ){
		$listhapiut = array();
		while($fetch_hapiut = mysqli_fetch_array($result)){
			$hapiut_date = $fetch_hapiut['date'];
			/*$day = date('j',$hapiut_date);
			$month = date('n',$hapiut_date);
			$year = date('Y',$hapiut_date);

			$hour = date('h',$hapiut_date);
			$minute = date('i',$hapiut_date);
			$second = date('s',$hapiut_date);
			$mkt = mktime($hour,$minute,$second,$month,$day,$year+1);*/
			$futuredate = strtotime('+1 year',$hapiut_date);
			if($futuredate >= $from && $futuredate < $to){
				$listhapiut[] = "parenthp='".$fetch_hapiut['id']."'";
			}else{
				$listhapiut[] = "";
			}
		}
		$allhapiut = " AND (".implode(" OR ",$listhapiut).")";
	}else{
		$allhapiut = '';
	}

	$args_item = "SELECT
			  ( SELECT COALESCE(SUM(amount),0) FROM hapiut_item WHERE type='plus' $allhapiut )
			- ( SELECT COALESCE(SUM(amount),0) FROM hapiut_item WHERE type='minus' $allhapiut )
			+ ( SELECT COALESCE(SUM(saldostart),0) FROM hapiut WHERE type='$type'   )
		AS baltotal";
	$result_item = mysqli_query($dbconnect, $args_item);
	if ( $result_item ) {
		$array = mysqli_fetch_array($result_item);
		return $array['baltotal'];
	} else {
		return 0;
	}
}

// jumlah hutang sekarang, berdasarkan id hapiut
function total_hapiutid($id) {
	global $dbconnect;
	$args = "SELECT
			( SELECT COALESCE(SUM(amount),0) FROM hapiut_item WHERE type='plus' AND parenthp='$id' )
			- ( SELECT COALESCE(SUM(amount),0) FROM hapiut_item WHERE type='minus' AND parenthp='$id' )
			+ ( SELECT saldostart FROM hapiut WHERE id='$id' )
		AS baltotal";
	// $args = "SELECT saldostart AS debttotal FROM pro_hapiut WHERE id='$id' ";
	$result = mysqli_query( $dbconnect, $args );
	$array = mysqli_fetch_array($result);
	$total = $array['baltotal'];
	if ( $total < 0 ) { $total = 0; }
	return $array['baltotal'];
}
// update saldo hapiut
function update_saldo_hapiut($id) {
	global $dbconnect;
	$saldo = total_hapiutid($id);
	if ( $saldo <= 0 ) { $status = 0; } else { $status = 1; }
	$args = "UPDATE hapiut SET saldonow='$saldo', status='$status' WHERE id='$id'";
	$update = mysqli_query( $dbconnect, $args );
	if ( $update ) { return true; } else { return false; }
}
// hapiut query
function hapiut_query($id) {
	global $dbconnect;
	$args = "SELECT * FROM hapiut WHERE id='$id'";
	$result = mysqli_query( $dbconnect, $args );
	if ($result) { return mysqli_fetch_array($result); }
	else { return array(); }
}

// last trans hp
function last_hp_trans($id) {
	global $dbconnect;
	$args = "SELECT date FROM hapiut_item WHERE parenthp='$id' ORDER BY date ASC LIMIT 1";
	$result = mysqli_query( $dbconnect, $args );
	if (mysqli_num_rows($result)) {
		$array = mysqli_fetch_array($result);
		return date('j F Y', $array['date']);
	} else {
		return '-';
	}
}

// jumlah trans hp
function jml_hp_trans($id) {
	global $dbconnect;
	$args = "SELECT id FROM hapiut_item WHERE parenthp='$id'";
	$result = mysqli_query($dbconnect, $args);
	return mysqli_num_rows($result);
}

// hapiut data
function hapiut_item_data($id,$data) {
	global $dbconnect;
	$args = "SELECT * FROM hapiut_item WHERE id='$id'";
	$result = mysqli_query( $dbconnect, $args );
	if ($result) {
		$hapiut = mysqli_fetch_array($result);
		return $hapiut[$data];
	} else { return ''; }
}

// hapiut item type
function hp_item_type($type) {
	global $dbconnect;

	if ($type == 'plus') { return "Penambahan"; }
	else { return "Pengurangan"; };
}

// delete detail hutang
function del_det_hp($id) {
	global $dbconnect;
	
	// delete item
	$parent = hapiut_item_data($id,'parenthp');
	$args = "DELETE FROM hapiut_item WHERE id='$id'";
	$update = mysqli_query( $dbconnect, $args );
	$balance_debt = update_saldo_hapiut($parent);
	if ( $update && $balance_debt ) { return true; }
	else { return false; }
}

function total_sellinventaris($type,$from,$to){
	global $dbconnect;

	//Total sell
	$args = "SELECT COALESCE(SUM(price_sell),0) AS all_selinv FROM inventory WHERE type='$type' AND date >= '$from'  AND date <= '$to'";
	$result = mysqli_query($dbconnect,$args);
	$fetch = mysqli_fetch_array($result);
	return $fetch['all_selinv'];
}

//cek semua pemasukan
function cek_allamount($data,$total,$tunai){
	global $dbconnect;

	if( $data == 'cicil' || $total < $tunai ){
		$get = "SELECT COALESCE(SUM(nominal_pembayaran),0) as total_cicilan FROM log_kredit";
		$getresult = mysqli_query($dbconnect,$get);
		$fetch = mysqli_fetch_array($getresult);
		$total = $fetch['total_cicilan'] + $tunai;
	}else{
		$get_pesan = "SELECT COALESCE(SUM(total),0) as total_akhir FROM pesanan WHERE status_cek_bayar != '0' AND aktif='1'";
		$get_result = mysqli_query($dbconnect,$get_pesan);
		$fetch_pesan = mysqli_fetch_array($get_result);
		$total = $fetch_pesan['total_akhir'];
	}

	return $total;
}

function diskon_pesanan($data,$from,$to){
	global $dbconnect;

	if ( $data == 'aplikasi' ) {
		$args = "SELECT SUM(diskon) as get_discount FROM pesanan WHERE aktif='1' AND status_kasir='0' AND tipe_bayar='pay_transfer' AND metode_bayar='nonsaldo' AND waktu_pesan >= '$from' AND waktu_pesan <= '$to' ";
	}else{
		$args= "SELECT SUM('jml_diskon') as get_discount FROM pesanan WHERE status_kasir='1' AND aktif='1' AND waktu_pesan >= '$from' AND waktu_pesan <= '$to' ";
	}

	$result = mysqli_query($dbconnect,$args);
	$fetch_data = mysqli_fetch_array($result);

	$diskon = $fetch_data['get_discount'];
	return $diskon;
}

function data_rating($idprod){
	global $dbconnect;

	$args = "SELECT * FROM item_ranking WHERE id_produk='$idprod'";
	$result = mysqli_query($dbconnect,$args);

	return $result;
}

function querydata_cashbook(){
	global $dbconnect;

	$args = "SELECT * FROM cash_book WHERE active='1' ORDER BY name ASC";
	$result = mysqli_query($dbconnect,$args);

	return $result;
}

function data_cashbook($id,$data='name'){
	global $dbconnect;

	$args = "SELECT $data FROM cash_book WHERE id='$id'";
	$result = mysqli_query($dbconnect,$args);
	$fetch_cash = mysqli_fetch_array($result);

	return $fetch_cash[$data];
}

// category data, return array(data,parent)
function cat_data($id,$data='name',$parent=false) {
	global $dbconnect;
	if ( "" == $id || "0" == $id ) {
		if ( false == $parent ) { return "Transfer"; }
		else { return array("Transfer",""); }
	} else {
		$args = "SELECT $data, master FROM category_kas WHERE id='$id'";
		$result = mysqli_query( $dbconnect, $args );
		if ($result) {
			$array = mysqli_fetch_array($result);
			if ( false == $parent ) { return $array[$data]; }
			else { return array($array[$data], catmaster($array['master'])); }
		} else { return ""; }
	}
}

// function catkas, return array $yes, cash, category, date, idtrans
function catkas($idhutang) {
	global $dbconnect;
	$args = "SELECT * FROM transaction_kas WHERE hapiut='$idhutang'";
	$result = mysqli_query( $dbconnect, $args );
	if (mysqli_num_rows($result)) {
		$trans = mysqli_fetch_array($result);
		return array(1,$trans['cash'],$trans['category'],$trans['date'],$trans['id']);
	} else { return array(0,1,'','',0); }
}

// jumlahkan kategori
function balance_cat($month,$year,$cat,$cash) {
	global $dbconnect;
	// jumlahkan
	$from = mktime(0,0,0,$month,1,$year);
	$to = mktime(0,0,0,$month+1,1,$year);
	$args = "SELECT SUM(amount) AS cattotal FROM transaction_kas WHERE category='$cat' AND cash='$cash' AND active='1' AND date >= $from AND date < $to";
	$result = mysqli_query( $dbconnect, $args );
	$array = mysqli_fetch_array($result);
	$jumlah = $array['cattotal'];
	// insert/update balance
	$args_bal = "SELECT id FROM balance_kas WHERE cat_id='$cat', cash_id='$cash' AND month='$month' AND year='$year'";
	$result_bal = mysqli_query( $dbconnect, $args_bal );
	// jika ada maka diupdate
	if ( $result_bal && mysqli_num_rows($result_bal) ) {
		$balarray = mysqli_fetch_array($result_bal);
		$bal_id = $balarray['id'];
		$args_update = "UPDATE balance_kas SET balance='$jumlah' WHERE id='$bal_id'";
	// jika gak ada maka diisi
	} else { 
		//$type = get_type_cat($cat);
		$args_update = "INSERT INTO balance_kas ( cat_id, cash_id, month, year, balance )
				VALUES ( '$cat', '$cash', '$month', '$year', '$jumlah')";
	}
	$balance = mysqli_query( $dbconnect, $args_update );
	if ( $balance ) { return $jumlah; }
	else { return false; }
}

// saldo kas sekarang, date: bulan sebelum, format= 2016_2 (tahun_bulan)
function cash_balance($cashid=0,$date='now',$waktu='bulanan') {
	global $dbconnect;
	if ( 0 == $cashid ) {
		$argskas = "SELECT id,saldoawal FROM cash_book WHERE active='1'";
		$resultkas = mysqli_query( $dbconnect, $argskas );
		$saldoawal = 0;
		$kasid = array();
		while ( $kas = mysqli_fetch_array($resultkas) ) {
			$kasid[] = "cash_id='".$kas['id']."'";
			$saldoawal = $saldoawal + $kas['saldoawal'];
		}
		$cash_query = " AND (".implode(" OR ",$kasid).") ";
	} else {
		$cash_query = "AND cash_id='".$cashid."'";
		$saldoawal = data_cashbook($cashid,'saldoawal');
	}
	if ( 'now' == $date ) {
		$datequery = "";
	} else {
		$yearmonth = explode("_",$date);
		$year = $yearmonth[0];
		if ( 'tahunan' == $waktu ) {
			$month = 12;
		} else {
			$month = $yearmonth[1];
		}
		$datequery ="AND ( (year = ".$year." AND month <= ".$month.") OR year < ".$year." )";
	}
	// hitung transaksi
	$args = "SELECT ( SELECT COALESCE(SUM(balance),0) FROM balance_kas WHERE type='in' $cash_query $datequery ) -
		( SELECT COALESCE(SUM(balance),0) FROM balance_kas WHERE type='out' $cash_query $datequery ) AS baltotal";
	$result = mysqli_query( $dbconnect, $args );
	$array = mysqli_fetch_array($result);
	$transaksi = $array['baltotal'];
	return $saldoawal+$transaksi;
}

function queryfetchdata_hapiut($id,$data){
	global $dbconnect;

	$args = "SELECT * FROM hapiut WHERE id='$id'";
	$result = mysqli_qurey($dbconnect,$args);
	$fetch = mysqli_fetch_array($result);
	return $fetch[$data];
}
// hapiut data
function hapiut_data($id,$data) {
	global $dbconnect;
	$args = "SELECT * FROM hapiut WHERE id='$id'";
	$result = mysqli_query( $dbconnect, $args );
	if ($result) {
		$hapiut = mysqli_fetch_array($result);
		return $hapiut[$data];
	} else { return ''; }
}

// jumlahkan transfer
function balance_trans($month,$year,$cash) {
	global $dbconnect;
	$from = mktime(0,0,0,$month,1,$year);
	$to = mktime(0,0,0,$month+1,1,$year);
	
	// jumlahkan cash out
	$args = "SELECT SUM(amount) AS cash_out FROM transaction_kas WHERE category='0'AND active='1' AND cash='$cash' AND date >= $from AND date < $to";
	$result = mysqli_query( $dbconnect, $args );
	$array = mysqli_fetch_array($result);
	$cash_out = $array['cash_out'];
	// insert/update balance
	$args_bal = "SELECT id FROM balance_kas WHERE cat_id='0' AND cash_id='$cash' AND type='out' AND month='$month' AND year='$year'";
	$result_bal = mysqli_query( $dbconnect, $args_bal );
	// jika ada maka diupdate
	if ( $result_bal && mysqli_num_rows($result_bal) ) {
		$balarray = mysqli_fetch_array($result_bal);
		$bal_id = $balarray['id'];
		$args_update = "UPDATE balance_kas SET balance='$cash_out' WHERE id='$bal_id'";
	// jika gak ada maka diisi
	} else {
		$args_update = "INSERT INTO balance_kas ( cash_id, month, year, type, balance )
				VALUES (  '$cash', '$month', '$year', 'out', '$cash_out')";
	}
	$balance_cash_out = mysqli_query( $dbconnect, $args_update );
	
	// jumlahkan cash in
	$args = "SELECT SUM(amount) AS cash_in FROM transaction_kas WHERE category='0' AND active='1' AND cash_to='$cash' AND date >= $from AND date < $to";
	$result = mysqli_query( $dbconnect, $args );
	$array = mysqli_fetch_array($result);
	$cash_in = $array['cash_in'];
	// insert/update balance
	$args_bal = "SELECT id FROM balance_kas WHERE cat_id='0' AND cash_id='$cash' AND type='in' AND month='$month' AND year='$year'";
	$result_bal = mysqli_query( $dbconnect, $args_bal );
	// jika ada maka diupdate
	if ( $result_bal && mysqli_num_rows($result_bal) ) {
		$balarray = mysqli_fetch_array($result_bal);
		$bal_id = $balarray['id'];
		$args_update = "UPDATE balance_kas SET balance='$cash_in' WHERE id='$bal_id'";
	// jika gak ada maka diisi
	} else {
		$args_update = "INSERT INTO balance_kas ( cash_id, month, year, type, balance )
				VALUES ( '$cash', '$month', '$year', 'in', '$cash_in')";
	}
	$balance_cash_in = mysqli_query( $dbconnect, $args_update );
	return array($balance_cash_out,$balance_cash_in);
}

function query_transorder($id_prod,$data,$from,$to,$type = 'out'){
	global $dbconnect;
 	
 	$data_fetch = array();
	$args = "SELECT * FROM trans_order WHERE id_produk='$id_prod' AND type='$type' AND status_jual='1' AND trans_from='0' AND trans_to='0' AND date >= $from AND date <= $to";
	$result = mysqli_query($dbconnect,$args);
	while($fetch = mysqli_fetch_array($result)){
		$data_fetch[] = $fetch[$data];
	}

	$data_sum = array_sum($data_fetch);

	return $data_sum;
}

// display in out
function inout($inout) {
	if ('in'==$inout) { return "Pemasukan"; }
	else { return "Pengeluaran"; }
}

// daftar master kategori nama
function catmaster($master) {
	switch ($master) {
		case '': return ''; break;
		case '0': return ''; break;
		
		// PENGELUARAN
		// pembelian & produksi
		case 'pg_beli': return 'Pembelian'; break;
		case 'pg_beli_tambah': return 'Beban Pembelian'; break;
		case 'pg_beli_gaji': return 'Gaji Pembelian'; break;
		case 'pg_prod_gaji': return 'Gaji Produksi'; break;
		case 'pg_prod_tambah': return 'Beban Produksi'; break;
		// penjualan 
		case 'pg_jual_tambah': return 'Beban Penjualan'; break;
		case 'pg_jual_gaji': return 'Gaji Penjualan'; break;
		case 'pg_promo': return 'Iklan'; break;
		case 'pg_retur': return 'Retur Penjualan'; break;
		case 'pg_diskon': return 'Diskon Penjualan'; break;
		// beban kantor
		case 'pg_kantor': return 'Beban Kantor'; break;
		case 'pg_kantor_gaji': return 'Gaji Kantor'; break;
		// Modal & Utang // non laba rugi  == pg_modal
		case 'pg_hutang': return 'Pembayaran Hutang'; break;
		case 'pg_piutang': return 'Pengeluaran Piutang'; break;
		case 'pg_prive': return 'Prive'; break;
		case 'pg_inventaris': return 'Pembelian Inventaris'; break; 
		case 'pg_lain': return 'Pengeluaran Lainnya'; break;
		// pajak ==   == pg_pajak
		case 'pg_pajak': return 'Pajak'; break;
		
		// PEMASUKAN
		// penjualan
		case 'pd_jual': return 'Penjualan'; break;
		case 'pd_jual_tambah': return 'Pendapatan Penjualan'; break;
		// pendapatan pembelian
		case 'pd_beli_tambah': return 'Pendapatan Pembelian'; break;
		case 'pd_retur': return 'Retur Pembelian'; break;
		case 'pd_diskon': return 'Diskon Pembelian'; break;
		// Modal & Piutang // non laba rugi == pd_modal
		case 'pd_piutang': return 'Pemasukan Piutang'; break;
		case 'pd_hutang': return 'Pemasukan Hutang'; break;
		case 'pd_modal': return 'Modal'; break;
		case 'pd_inventaris': return 'Penjualan Inventaris'; break;
		case 'pd_lain': return 'Pemasukan Lain'; break;

    	default: return '';
	}
}

// query cat in/out
function query_cat($type) {
	global $dbconnect;
	$args = "SELECT * FROM category_kas WHERE type='$type' AND active='1' ORDER BY name ASC";
	return mysqli_query( $dbconnect, $args );
}

// apakah sebuah kategori itu pemasukan atau pengeluaran?
function get_type_cat($cat_id) {
	global $dbconnect;
	$args = "SELECT type FROM category_kas WHERE id='$cat_id'";
	$result = mysqli_query( $dbconnect, $args );
	$type = mysqli_fetch_array($result);
	return $type['type'];
}

// function catkas, return array $yes, cash, category, date, idtrans
function catkas_inv($id_inv) {
	global $dbconnect;
	$args = "SELECT * FROM transaction_kas WHERE inventory='$id_inv'";
	$result = mysqli_query( $dbconnect, $args );
	if (mysqli_num_rows($result)) {
		$trans = mysqli_fetch_array($result);
		return array(1,$trans['cash'],$trans['category'],$trans['date'],$trans['id']);
	} else { return array(0,1,'','',0); }
}

// cari in out dari master kategori
function cat_inout_master($master) {
	$arr = explode('_',$master);
	if ( 'pd' == $arr[0] ) { return 'in'; }
	else { return 'out'; }
}


// report by category
function report_cat($cat_id,$from,$to,$cash="all") {
	global $dbconnect;
	//$pecah = explode('_',$month_year);
	//$month = $pecah[0]; $year = $pecah[1];

	$from_n = date('n',$from);
	$from_y = date('Y',$from);

	$to_n = date('n',$to);
	$to_y = date('Y',$to);
	if ( "all" == $cash ) { $cashquery = ""; } else { $cashquery = "AND cash_id='$cash'"; }
	$args_bal = "SELECT SUM(balance) AS saldo FROM balance_kas WHERE cat_id='$cat_id' $cashquery AND ( month >= $from_n AND month <= $to_n) AND (year >= $from_y AND year <= $to_y)";
	$result_bal = mysqli_query( $dbconnect, $args_bal );
	if ( $result_bal ) {
		$balarray = mysqli_fetch_array($result_bal);
		return $balarray['saldo'];
	} else { return 0; }
}

// report by category daily
function report_cat_day($cat_id,$from,$to,$cash="all") {
	global $dbconnect;
	if ( "all" == $cash ) { $cashquery = ""; } else { $cashquery = "AND cash='$cash'"; }
	$args_bal = "SELECT SUM(amount) AS saldo FROM transaction_kas WHERE category='$cat_id' AND date >= $from AND date <= $to $cashquery";
	$result_bal = mysqli_query( $dbconnect, $args_bal );
	if ( $result_bal ) {
		$balarray = mysqli_fetch_array($result_bal);
		return $balarray['saldo'];
	} else { return 0; }
}
//cari data
function search_data($table,$search,$where,$where_to){
	global $dbconnect;

	$args = "SELECT $search FROM $table WHERE $where='$where_to'";
	$result = mysqli_query($dbconnect,$args);
	$fetch = mysqli_fetch_array($result);

	return $fetch[$search];
}

// data transaksi
function trans_data($id,$data) {
	global $dbconnect;
	$args = "SELECT * FROM transaction_kas WHERE id='$id'";
	$result = mysqli_query( $dbconnect, $args );
	if ($result) {
		$trans = mysqli_fetch_array($result);
		return $trans[$data];
	} else { return ''; }
}

function inventatis_peryear($type,$month='now',$year='now'){
	global $dbconnect;

	//$month=12; 
	//$year_from=date('Y',$tgl_from); 
	//$year_to=date('Y',$tgl_to); 

	if ( $month == 'now' ) { $month = date('n'); }
	if ( $year == 'now' ) { $year = date('Y'); }
	
	$nominal_tahunini = array();//AND (date >= '$tgl_from' AND date < '$tgl_to') 
	$table = '';
	$fluktuasi = 0;
	$inv_pertahun = "SELECT * FROM inventory WHERE type='$type' AND aktif='1'";
	$inv_result = mysqli_query($dbconnect,$inv_pertahun);
	if($row_inv = mysqli_num_rows($inv_result)){
		while( $inv_fetch = mysqli_fetch_array($inv_result)){
		    $date_inv = $inv_fetch['date'];
		    $month_start = date('n',$date_inv);
			$year_start = date('Y',$date_inv);
			$umurmax = $inv_fetch['inv_age'] * 12;
			//$umur = ( 9 + ( 12*2020 ) ) - ( 9 + ( 12*2019 ) );
			$umur = ( $month + ( 12*$year ) ) - ( $month_start + ( 12*$year_start ) );

			if( 'zero' != $inv_fetch['fluktuasi_type']){ $fluk_now = $inv_fetch['fluktuasi_val'] * $umur; }

			if ( '1' == $inv_fetch['aktif'] ) { $data_value = uang(inv_value($inv_fetch['id'],$month,$year))."<br />"; } else { $data_value = uang(0)."<br />"; }


			if( 'min' == $inv_fetch['fluktuasi_type'] ){ 
	            $fluktuasi_type =  "Menurun <br /><small> Nilai penurunan: ".uang($inv_fetch['fluktuasi_val'])." Per bulan.<br /> Umur: ".inv_umur($inv_fetch['id']).", max ".$inv_fetch['inv_age']." tahun.</small>"; 
	            //}else{ 
	            	//echo "Tetap";
	        }
	        
			//$last = $nominal_tahunini;
			//if( $month < $month_start && $year < $year_start ){
				$table .= "<tr id='inventaris_".$inv_fetch['id']."'>";
				$table .= "<td class='center'>".$inv_fetch['id']."</td>";
				$table .= "<td class='center'>".$inv_fetch['kd_barang']."</td>";
				$table .= "<td class='center'>".date("d M Y",$inv_fetch['date'])."</td>";
				$table .= "<td class='center'>".$inv_fetch['jumlah_barang']."</td>";
				$table .= "<td class='center'>".$data_value."<small>Dari nilai awal ".uang($inv_fetch['price_start'])."</small></td>";
				$table .= "<td class='center'>".$fluktuasi_type."</td>";
				$table .= "<td class='center'>".$inv_fetch['klien']."</td>";
				$table .= "<td class='center'>".uang($fluk_now)."</td>";
				$table .= "</tr>";
			//}
		    //$cnv_dateinv = date('Y',$date_inv);
			    //if($cnv_dateinv == $year){
			    	/*$bulan = date('n',$date_inv);
			    	$tahun = date('Y',$date_inv);
			    	if($tahun >= $year_from && $tahun < $year_to){
			    		$fluktuasi = $fluktuasi * $inv_fetch['fluktuasi_val'];
			    		$nominal_tahunini[] = $fluktuasi;
						//$sisa_bulan = $month - $bulan;
						//$nominal_tahunini[] = $inv_fetch['fluktuasi_val'] * $sisa_bulan;
					}else{
						$nominal_tahunini[] = $inv_fetch['fluktuasi_val'];
					}
						$last = $nominal_tahunini;
			    //}
						$fluktuasi++;*/
		}
		$result_last = $table;
	}else{
		$result_last = $table;
	}
	return $result_last;
}

// nilai inventory sekarang, $month=9, $year=2016 (September 2016)
function inv_value($inv_id,$month='now',$year='now') {
	global $dbconnect;
	if ( $month == 'now' ) { $month = date('n'); }
	if ( $year == 'now' ) { $year = date('Y'); }
	$args = "SELECT * FROM inventory WHERE id='$inv_id'";
	$result = mysqli_query( $dbconnect, $args );
	$inv = mysqli_fetch_array($result);
	$month_start = date('n',$inv['date']);
	$year_start = date('Y',$inv['date']);
	if ( 'zero' != $inv['fluktuasi_type'] ) {
		$umurmax = $inv['inv_age'] * 12;
		$umur = ( $month + ( 12*$year ) ) - ( $month_start + ( 12*$year_start ) );
		if ( 'min' == $inv['fluktuasi_type'] ) {
			$val_now = $inv['price_start'] - ( ( $inv['price_start']/$umurmax ) * $umur  );
			if ( $val_now <= 0 ) { $val_now = 0; }
		}
		return round($val_now);
	} else {
		return $inv['price_start'];
	}
}


function querydata_reward($idtarget,$target,$from,$to){
	global $dbconnect;

	$args = "SELECT * FROM counter_reward WHERE $target='$idtarget' AND date >= '$from' AND date < '$to' ORDER BY id ASC LIMIT 1";
	$result = mysqli_query($dbconnect,$args);
	return $result;
}

function data_reward($idtarget,$target){
	global $dbconnect;

	$args = "SELECT * FROM counter_reward WHERE $target='$idtarget' ORDER BY id ASC LIMIT 1";
	$result = mysqli_query($dbconnect,$args);
	return $result;
}

function query_reward($idtarget,$target,$from,$to){
	global $dbconnect;

	$args = "SELECT COALESCE(SUM(amount),0) as akumulasi FROM counter_reward WHERE $target='$idtarget' AND date >= '$from' AND date <= '$to'";
	$result = mysqli_query($dbconnect,$args);
	$fetch = mysqli_fetch_array($result);
	return $fetch['akumulasi'];
}

function claim_reward($iduser){
	global $dbconnect;

	$args = "SELECT * FROM claim_reward WHERE id_user='$iduser' ORDER BY date_expired DESC LIMIT 1";//AND date >= '$from' AND date < '$to'
	$result = mysqli_query($dbconnect,$args);

	return $result;
}

function querydata_claim($iduser){
	global $dbconnect;

	$args = "SELECT * FROM claim_reward WHERE id_user='$iduser'";
	$result = mysqli_query($dbconnect,$args);
	return $result;
}

function check_claimreward(){
	global $dbconnect;

	$datedb = strtotime('now');
	$daydb = date('d',$datedb);
	$args_user = get_userapp();

	$args_claim = "INSERT INTO claim_reward ( date, date_expired, id_user, akumulasi, amount, pick_discount ) VALUES ";
	while($data_member = mysqli_fetch_array($args_user)){
		$member_person = $data_member['id'];
	    $user_reward = data_reward($member_person,'id_user');
	    $fetch_userreward = mysqli_fetch_array($user_reward);
	    $date_userreward  = $fetch_userreward['date'];
	    $day    = date('d',$date_userreward);
	    if( $daydb < $day ){ $month = date('m')-1; }else{ $month = date('m'); }   
	    $year   = date('Y');
	    $hour   = date('H',$date_userreward);
	    $minute = date('i',$date_userreward);
	    $from   = $day."-".$month."-".$year.",".$hour.":".$minute;
	    $to     = $day."-".$month."-".$year.",".$hour.":".$minute;
	    //$from = mktime(13,45,0,10,20,2019);
	    //$to = mktime($hour,$minute,0,10,20,2019);
	    //$time_to   = $to;
	    $min_month = strtotime($from);
	    $time_from = strtotime("-1 months",$min_month);
	   	$time_too  = strtotime($to);
		$time_to   = strtotime("-1 days",$time_too);
	    $nowplus   = strtotime("+1 months",$time_too);

	        if( $datedb >= $time_to ){//1566268800 $datedb >= $time_from && $datedb <= $time_to
	        	$total = query_reward($member_person,'id_user',$time_from,$time_to);
	            if( $total != '0' ){
	                if( $total >= 1000000 && $total <= 1999999 ){
	                    $discount = 5;
	                    $amount   = $total/100*$discount;
	                }else if( $total >= 2000000 && $total <= 4999999 ){
	                    $discount = 7.5;
	                    $amount   = $total/100*$discount;
	                }else if( $total >= 5000000 && $total <= 24999999 ){
	                    $discount = 10;
	                    $amount   = $total/100*$discount;
	                }else if( $total >= 25000000 ){
	                    $discount = 30;
	                    $amount   = $total/100*$discount;
	                }else{
	                    $discount = 0;
	                    $amount   = 0;
	                }

	                if( $discount != '0' && $amount != '0' ){
	                    $data_claim = claim_reward($member_person);//,$time_from,$time_to
	                    $fetch_claim = mysqli_fetch_array($data_claim);
	                    $claim_from = $fetch_claim['date'];
	                    $claim_to = $fetch_claim['date_expired'];

	                    if( mysqli_num_rows($data_claim) <= 0 ){
	                        $args_claim .= "( '$time_too', '$nowplus', '$member_person', '$total', '$amount', '$discount' ), ";
	                        //$result_claim = mysqli_query($dbconnect,$args_claim);
	                    }else{
	                    	if($fetch_claim['id_user'] == $member_person && $datedb < $claim_to){
	                    		$args_claim .= true;
	                    		//$result_claim = '';
	                    	}else if( $fetch_claim['id_user'] == $member_person && $claim_to == $nowplus ){
	                    		$args_claim .= true;
	                    	}else{
	                    		$args_claim .= "( '$time_too', '$nowplus', '$member_person', '$total', '$amount', '$discount' ), ";
	                        	//$result_claimm = mysqli_query($dbconnect,$args_claimm);//$result_claim = '';
	                    	}
	                    }
	                    
	                }
	            }
	        }else{
	        	$discount = 0;
	            $amount   = 0;
	        }

	    $expired_claim = querydata_claim($member_person);
	    while($data_expired = mysqli_fetch_array($expired_claim)){
		    if($datedb >= $data_expired['date_expired'] && $data_expired['status_reward'] !=='1'){
		    	$up_expired = "UPDATE claim_reward SET status='0' WHERE id_user='$member_person'";
		    	$result_expired = mysqli_query($dbconnect,$up_expired);
		    }
	    }
	}

	$args_claim = rtrim($args_claim,', ');
    $result_claim = mysqli_query($dbconnect,$args_claim);

	return;
}

function rewardd($idpesan,$iduser,$date,$money,$use_discount,$id_claim){
	global $dbconnect;

	$datedb = strtotime('now');
	$datedb_to = strtotime("+1 months",$datedb);
	$data_claim = claim_reward($iduser);
	//$in_reward = "INSERT INTO counter_reward ( id_pesanan, date, id_user, amout ) VALUES ( '$idpesan', '$date', '$iduser', '$money' )";
	//$result = mysqli_query($dbconnect,$in_reward);

	//if($result){
		$in_reward = "INSERT INTO counter_reward ( id_pesanan, date, id_user, amout ) VALUES";
		$cek_reward   = data_reward($iduser,'id_user');
		if( mysqli_num_rows($cek_reward) <= 0 ){
			$in_reward .= "( '$idpesan', '$date', '$iduser', '$money' ), ";
		}else{
			$in_reward .= "( '$idpesan', '$date', '$iduser', '$money' ), ";
			
	    	}/*else{
	    		while($fetch_claim = mysqli_fetch_array($data_claim)){
	    			$from_claim = $fetch_claim['date'];
	    			$to_claim = $fetch_claim['date_expired'];
	    			if( $datedb >= $from_claim && $datedb < $to_claim ){
	    				$in_reward .= true;
	    			}else{
	    				$in_reward .= "( '$idpesan', '$date', '$iduser', '$money' ), ";
	    			}
	    		}
	    	}*/
 
    $in_reward = rtrim($in_reward,', ');
    $result_in = mysqli_query($dbconnect,$in_reward);

    if( $use_discount == '1' ){
    	$args_use = "UPDATE claim_reward SET status_reward='1' WHERE id='$id_claim'";
    	$result = mysqli_query($dbconnect,$args);
    }
	//}
}
/*


function date_reward($idpesan,$iduser,$date,$money,$purchase_prizes){
	global $dbconnect;

	
}*/

function date_rewardd($idpesan,$iduser,$date,$money,$purchase_prizes){
	global $dbconnect;

	//$ketentuan = uang_false(100000);
	//$ketentuan = 100000.00;
	$purchase = number_format($purchase_prizes,2);
	$rule_purchase = str_replace(',','',$purchase);

	$in_reward = "INSERT INTO counter_reward ( id_pesanan, date, id_user, first_date, end_date, rule_date, first_status, amout, total_money, status_reward ) VALUES";
    $data = querydata_reward($iduser,'id_user');
    if( mysqli_num_rows($data) <= 0 ){
        $to_date = strtotime("+1 months", $date);
        if( $money > $rule_purchase ){
        	$in_reward .= "('$idpesan', '$date', '$iduser', '$date', '$date', '$to_date', '1', '$money', '$money', '1'), ";
        }else{
        	$in_reward .= "('$idpesan', '$date', '$iduser', '$date', '0', '$to_date', '1', '$money', '$money', ''), ";
        }
    }else{
        $fetch_data = mysqli_fetch_array($data);
        $first = $fetch_data['first_date'];
        $date_rule = $fetch_data['rule_date'];
        $status_reward = $fetch_data['status_reward'];
        $amout = $fetch_data['total_money'];
        $total = $money + $amout;
        $to_date = strtotime("+1 months", $date);
        if( $status_reward == '1' ){
        	if( $money > $rule_purchase ){
        		$in_reward .= "('$idpesan', '$date', '$iduser', '$date', '$date', '$to_date', '1', '$money', '$money', '1'), ";
	        }else{
	        	if( $date > $date_rule ){
	        		$in_reward .= "('$idpesan', '$date', '$iduser', '$date', '0', '$to_date', '1', '$money', '$money', ''), ";
	        	}else{
	        		$in_reward .= "('$idpesan', '$date', '$iduser', '$date', '0', '$date_rule', '1', '$money', '$money', ''), ";
	        	}
	        }
        }else if( $status_reward == '' && $total < $rule_purchase ){
        	if( $date < $date_rule ){
        		$in_reward .= "('$idpesan', '$date', '$iduser', '0', '0', '$date_rule', '0', '$money', '$total', ''), ";
        	}else{
        		$in_reward .= "('$idpesan', '$date', '$iduser', '0', '$date', '$date_rule', '0', '$money', '$total', '0'), ";
        	}
        }else if( $status_reward == '' && ( $total > $rule_purchase || ( $date < $date_rule && $total > $rule_purchase ) ) ){
        	$in_reward .= "('$idpesan', '$date', '$iduser', '0', '$date', '$date_rule', '0', '$money', '$total', '1'), ";
        }else{
        	if( $status_reward == '0' ){
        		if( $money > $rule_purchase ){
        			$in_reward .= "('$idpesan', '$date', '$iduser', '$date', '$date', '$to_date', '1', '$money', '$money', '1'), ";
	        	}else{
		        	if($date > $date_rule ){
		        		$in_reward .= "('$idpesan', '$date', '$iduser', '$date', '0', '$to_date', '1', '$money', '$money', ''), ";
		        	}else{
		        		$in_reward .= "('$idpesan', '$date', '$iduser', '$date', '0', '$date_rule', '1', '$money', '$money', ''), ";
		        	}
	        	}
        	//}else{
        		//$in_reward .= "('$idpesan', '$date', '$iduser', '0', '$date', '$date_rule', '0', '$money', '$total', '0'), ";
        	}
        }
    }
    $in_reward = rtrim($in_reward,', ');
    $result_in = mysqli_query($dbconnect,$in_reward);
}


function report_mastercat($master,$from,$to) {
	global $dbconnect;

	$args_cat = "SELECT id FROM category_kas WHERE master='$master'";
	$result_cat = mysqli_query( $dbconnect, $args_cat );
	$listcat = array();
	while ( $cat = mysqli_fetch_array($result_cat) ) { $listcat[] = "category='".$cat['id']."'"; }
	$allcat = implode(" OR ",$listcat);
	$args = "SELECT SUM(amount) AS totaltrans FROM transaction_kas
		WHERE date >= $from AND date <= $to AND ( $allcat )";
	$result = mysqli_query( $dbconnect, $args );
	if ( $result ) {
		$tkpb = mysqli_fetch_array($result);
		return $tkpb['totaltrans'];
	} else { return 0; }
}

function report_mastercatbyid($id,$from,$to) {
	global $dbconnect;

    
	$args_cat = "SELECT * FROM category_kas WHERE id='$id'";
	$result_cat = mysqli_query( $dbconnect, $args_cat );
	$listcat = array();
	$cat = mysqli_fetch_array($result_cat);
    $data_id = "category=".$cat['id'];
	
	$args = "SELECT SUM(amount) AS totaltrans FROM transaction_kas
		WHERE date >= $from AND date <= $to AND ( $data_id )";
	$result = mysqli_query( $dbconnect, $args );
	if ( $result ) {
		$tkpb = mysqli_fetch_array($result);
		return $tkpb['totaltrans'];
	} else { return 0; }
}

function sendemail_pdf($idreq,$status_send){

	$idpesanan  = querydata_reqsaldo($idreq,'id_pesanan');
    $get_user   = querydata_pesanan($idpesanan,'nama_user');
    $iduser 	= current_user_id();
    $datedb 	= $tgl_database = strtotime('now');
    $id_user 	= querydata_pesanan($idpesanan,'id_user');
    $telp_user 	= querydata_pesanan($idpesanan,'telp');
    $email_user = data_tabel('user_member',$id_user,'email');
    $totalbayar = querydata_reqsaldo($idreq,'total_bayar');
    $cek_tipebayar = querydata_pesanan($idpesanan,'tipe_bayar');
    $filename = 'Nota Pembayaran Dengan Pesanan No '.$idpesanan.' - '.date('d M Y',strtotime('now'));
	   // Extend the TCPDF class to create custom Header and Footer
        class MYPDF extends TCPDF{
        	//Page Header
        	public function Header(){}

        	//Page Footer
        	public function Footer(){
	        //$this->SetY(-30); // Position at 15 mm from bottom
			//$this->SetFont('helvetica', 'I', 7);
			//$this->SetTextColor(160, 160, 160);
			//$this->SetDrawColor(160, 160, 160);
	        //$this->Cell(0, 4, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 'B', 0, 'L', 0, '', 0, true, 'M', 'C');
	        //$this->Cell(0, 4, _('Created on www.akun.pro'), 'B', 0, 'R', 0, '', 0, true, 'M', 'C'); }
        	}
        }

        $pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('www.akun.pro');
		$pdf->SetTitle( _('Nota Pembayaran'));
		$pdf->SetSubject( 'Nota Pembayaran' );
		$pdf->SetKeywords('akun.pro');
		// set footer fonts
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		// set margins
		$pdf->SetHeaderMargin(0);
		$pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 40);
		// set image scale factor
		$pdf->AddPage();

		$html  = '';
		$html .= '<style type="text/css">
					.center{text-align:center;}
					.left{text-align:left;}
					.right{text-align:right;}
					.pagecontent{display: inline-block; position: relative;}
					.tableemail, .nexttable{ width: 95%; }
		            .tableemail td{line-height: 20px;}
		            .nexttable td{border-bottom: 1px solid #ccc; line-height: 1.5;}
		            .newlinetable {background: #075489; height: 8px;}
		            .font{font-size: 16px;}
		            .address{width: 50px;}
		            .title{ background-color:#157bd2; color:#ffffff; line-height:18px;}
				 </style>';
		$html .= '<div class="left">';
		$html .= 	'<img src="../penampakan/images/logo-putrama.png" width="140" height="60"><br />';
		$html .=     '<small>Hotline Kami : '.querydata_dataoption('hotline').'<br />';
		$html .=     'Telepon : '.querydata_dataoption('telepon_view').'</small><br />';
		$html .= '</div>';
		$html .= '<div class="pagecontent">';
		$html .= 	'<table class="tableemail">';
		$html .= 		'<tbody>';
		$html .= 			'<tr>';
		$html .= 				'<td colspan="4" class="center fontbold title"><strong>Pembayaran ID: '.$idreq.'</strong></td>';
		$html .= 			'</tr>';
		$html .= 			'<tr>';
		$html .= 				'<td>No. Pesanan </td>';
		$html .= 				'<td>&nbsp;</td>';
		$html .= 				'<td>&nbsp;</td>';
		$html .= 				'<td>'.$idpesanan.'</td>';
		$html .= 			'</tr>';
		$html .=			'<tr>';
		$html .= 				'<td colspan="2">Pembayaran diterima pada tanggal</td>';
		$html .= 				'<td>&nbsp;</td>';
		$html .= 				'<td>'.date('j M Y', $datedb).'</td>';
		$html .=    		'</tr>';
		$html .=			'<tr>';
		$html .= 				'<td>Atas Nama</td>';
		$html .= 				'<td>&nbsp;</td>';
		$html .= 				'<td>&nbsp;</td>';
		$html .= 				'<td>'.$get_user.'</td>';
		$html .=    		'</tr>';
		$html .=			'<tr>';
		$html .= 				'<td colspan="2">Total Pembayaran</td>';
		$html .= 				'<td>&nbsp;</td>';
		$html .= 				'<td>'.uang($totalbayar).'</td>';
		$html .=    		'</tr>';
		$html .=			'<tr>';
		$html .= 				'<td colspan="4" class="newlinetable">&nbsp;</td>';
		$html .=    		'</tr>';
		$html .=			'<tr>';
		$html .= 				'<td colspan="4" class="newlinetable">&nbsp;</td>';
		$html .=    		'</tr>';
		$html .= 		'</tbody>';
		$html .= 	'</table>';
		$html .= 	'<table class="nexttable">';
		$html .=		'<thead>';
		$html .=			'<tr class="title">';
		$html .=				'<th width="112" class="center">Produk</th>';
		$html .=				'<th width="120" class="center">Jumlah</th>';
		$html .=				'<th width="100" class="right">Harga Satuan</th>';
		$html .=				'<th width="100" class="right">Harga</th>';
		$html .=			'</tr>';
		$html .=		'</thead>';
		$html .=		''.data_pesananpdf($idpesanan).'';
		$html .= 	'</table>';
		$html .= '</div>';
		
		$pdf->writeHTML($html,false,false,true,false,'');
			// ---------------------------------------------------------

		if($status_send == 'email'){
			ob_end_clean();
			
			//Close and output PDF document
			$attachment = $pdf->Output($filename.'.pdf', 'S');

			//Create Message on Email
			$body  = 'Hai '.$get_user.', Terimakasih telah percaya berbelanja di Putrama Packaging, berikut rincian nota pesanan Anda';
			//$msg = 'Test attachment pdf using email';

			// Mailing
			$mail = new PHPMailer\PHPMailer\PHPMailer();
			$mail->setFrom('autoreply@PutramaPackaging.id','Putrama Packaging');
			$mail->addReplyTo('send@PutramaPackaging.id','Putrama Packaging');
			$mail->addAddress('#','#');
			$mail->Subject = 'Nota Pembayaran';
			$mail->Body=$body;
			$mail->AddStringAttachment($attachment, $filename.'.pdf');

			if(!$mail->send() ){
				$link_wa = $mail->ErrorInfo;
			}else{
				$link_wa = 'sukses';
			}
		}else{
			ob_end_clean();
			$link_wa = $pdf->Output($filename.'.pdf', 'I');
		}
	return $link_wa;
}

function data_pesananpdf($idpesanan){
	global $dbconnect;

	$table = '';
	$produk_pesanan    = querydata_pesanan($idpesanan,'idproduk');
    $jmlorder_pesanan  = querydata_pesanan($idpesanan,'jml_order');
    $hargaitem_pesanan = querydata_pesanan($idpesanan,'harga_item');
    $nama_produk       = querydata_pesanan($idpesanan,'nama_produk');
    
    $exp_idprod    	   = explode("|", $produk_pesanan);
    $exp_orderprod 	   = explode("|", $jmlorder_pesanan);
    $exp_hargaprod     = explode("|", $hargaitem_pesanan);
    $exp_nama 		   = explode("|",$nama_produk);
    $count_idprod 	   = count($exp_idprod)-1;

    	$table .= '<tbody>';
    for($y=0; $y <= $count_idprod; $y++) {
    $data_akhir = $exp_orderprod[$y] * $exp_hargaprod[$y];
	    $table .= '<tr>
					 <td>'.$exp_nama[$y].'</td>
				     <td class="center">'.$exp_orderprod[$y].'</td>
				     <td class="right">'.uang($exp_hargaprod[$y]).'</td>
				     <td class="right">'.uang($exp_orderprod[$y] * $exp_hargaprod[$y]).'</td>
				   </tr>';
    }
	    $table .= '</tbody>';
	    $table .= '<tr>
			        	<td>Biaya Pengiriman</td>
			        	<td>&nbsp;</td><td>&nbsp;</td>
			        	<td class="right">'.uang( data_tabel('pesanan', $idpesanan, 'ongkos_kirim') ).'</td>
			       </tr>
			       <tr>
			         	<td><strong>Sub Total</strong></td>
			         	<td>&nbsp;</td><td>&nbsp;</td>
			         	<td class="right"><strong>'.uang( data_tabel('pesanan', $idpesanan, 'total') ).'</strong></td>
			        </tr>';
    return $table;
}

function buy_logistic($from,$to){
	global $dbconnect;

	$args = "SELECT SUM( harga * jumlah ) AS total_beli FROM trans_order WHERE date >= '$from' AND date < '$to' AND status_jual='0' AND type='in' AND trans_from='0' AND trans_to='0'";
	$result = mysqli_query($dbconnect,$args);
	$fetch = mysqli_fetch_array($result);

	return $fetch['total_beli'];
}
function product_price($tgl_from,$tgl_to,$product_id){
	global $dbconnect;

	/*if ($month=='now') {
		$bulan = date('n');
		$tahun = date('Y');
	} else {
		$pecah = explode("_",$month);
		$bulan = $pecah[0];
		$tahun = $pecah[1];
	}

	$bulan_from = date('n',$tgl_from);

	$date_now  = mktime(0,0,0,$bulan,1,$tahun);
	$date_next = mktime(0,0,0,$bulan+1,1,$tahun);*/

	//$date_from

	//$date_from = mktime()

	$args = "SELECT harga FROM trans_order WHERE date >= '$tgl_from' AND date <= '$tgl_to' AND status_jual='0' AND type='in' AND id_produk='$product_id'";
	$result = mysqli_query($dbconnect,$args);
	$fetch = mysqli_fetch_array($result);
	$harga = $fetch['harga'];

	if($harga > 0){
		return $harga;
	}else{
		$args_limit = "SELECT harga FROM trans_order WHERE date <= '$tgl_from' AND type='in' AND id_produk='$product_id' ORDER BY date DESC LIMIT 1";
		$result_limit = mysqli_query( $dbconnect, $args_limit );
		if (mysqli_num_rows($result_limit)) {
			$array = mysqli_fetch_array($result_limit);
			return $array['harga'];
		} else { return 0; }
	}
}

// stok awal / akhir
function jml_stok($tipe,$tgl_from,$tgl_to,$product_id) {
	global $dbconnect;
	//$pecah = explode('_',$month_year);
	//$bulan = $pecah[0]; $tahun = $pecah[1];
	//$bulan_sebelum = $bulan-1;

	if ( 'awal' == $tipe) {
		//$start = mktime(0,0,0,$bulan-1,1,$tahun);
		$end = $tgl_from;
	} else {
		//$start = mktime(0,0,0,$bulan,1,$tahun);
		$end = $tgl_to;
	}
	$args = "SELECT (
				(SELECT COALESCE(SUM(jumlah),0) FROM trans_order WHERE date <= '$end' AND type='in' AND trans_from='0' AND trans_to='0' AND id_produk='$product_id' )
				- (SELECT COALESCE(SUM(jumlah),0) FROM trans_order WHERE date <= '$end' AND type='out' AND status_jual='1' AND id_produk='$product_id' )
				+ (
					(
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='in' AND trans_from='1')
						-
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='out' AND trans_from='1')
						+
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='trans' AND trans_to='1')
						-
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='trans' AND trans_from='1')
					)

					+

					(
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='in' AND trans_from='2')
						-
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='out' AND trans_from='2')
						+
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='trans' AND trans_to='2')
						-
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='trans' AND trans_from='2')
					)

					+

					(
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='in' AND trans_from='3')
						-
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='out' AND trans_from='3')
						+
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='trans' AND trans_to='3')
						-
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='trans' AND trans_from='3')
					)

				  )
			) AS jml_persediaan";
	$result = mysqli_query( $dbconnect, $args );
	$hasil = mysqli_fetch_array($result);
	return $hasil['jml_persediaan'];
}
/*
function product_price($month='now',$product_id){
	global $dbconnect;

	if ($month=='now') {
		$bulan = date('n');
		$tahun = date('Y');
	} else {
		$pecah = explode("_",$month);
		$bulan = $pecah[0];
		$tahun = $pecah[1];
	}

	$date_now = mktime(0,0,0,$bulan,1,$tahun);
	$date_next = mktime(0,0,0,$bulan+1,1,$tahun);

	$args = "SELECT harga FROM trans_order WHERE date >= '$date_now' AND date < '$date_next' AND status_jual='0' AND type='in' AND id_produk='$product_id'";
	$result = mysqli_query($dbconnect,$args);
	$fetch = mysqli_fetch_array($result);
	$harga = $fetch['harga'];

	if($harga > 0){
		return $harga;
	}else{
		$args_limit = "SELECT harga FROM trans_order WHERE date <= '$date_now' AND type='in' AND id_produk='$product_id' ORDER BY date DESC LIMIT 1";
		$result_limit = mysqli_query( $dbconnect, $args_limit );
		if (mysqli_num_rows($result_limit)) {
			$array = mysqli_fetch_array($result_limit);
			return $array['harga'];
		} else { return 0; }
	}
}

// stok awal / akhir
function jml_stok($tipe,$month_year,$product_id) {
	global $dbconnect;
	$pecah = explode('_',$month_year);
	$bulan = $pecah[0]; $tahun = $pecah[1];
	$bulan_sebelum = $bulan-1;
	if ( 'awal' == $tipe) {
		$start = mktime(0,0,0,$bulan-1,1,$tahun);
		$end = mktime(0,0,0,$bulan,1,$tahun);
	} else {
		$start = mktime(0,0,0,$bulan,1,$tahun);
		$end = mktime(0,0,0,$bulan+1,1,$tahun);
	}
	$args = "SELECT (
				(SELECT COALESCE(SUM(jumlah),0) FROM trans_order WHERE date <= '$end' AND type='in' AND trans_from='0' AND trans_to='0' AND id_produk='$product_id' )
				- (SELECT COALESCE(SUM(jumlah),0) FROM trans_order WHERE date <= '$end' AND type='out' AND status_jual='1' AND id_produk='$product_id' )
				+ (
					(
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='in' AND trans_from='1')
						-
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='out' AND trans_from='1')
						+
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='trans' AND trans_to='1')
						-
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='trans' AND trans_from='1')
					)

					+

					(
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='in' AND trans_from='2')
						-
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='out' AND trans_from='2')
						+
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='trans' AND trans_to='2')
						-
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='trans' AND trans_from='2')
					)

					+

					(
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='in' AND trans_from='3')
						-
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='out' AND trans_from='3')
						+
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='trans' AND trans_to='3')
						-
						(SELECT coalesce(sum(jumlah),0) FROM trans_order WHERE date <= '$end' AND id_produk='$product_id' AND type='trans' AND trans_from='3')
					)

				  )
			) AS jml_persediaan";
	$result = mysqli_query( $dbconnect, $args );
	$hasil = mysqli_fetch_array($result);
	return $hasil['jml_persediaan'];
}
*/

?>