<?php
require_once("../mesin/function.php");
if( is_admin() ){
	
	$idreq = $_GET['data_req'];
	sendemail_pdf($idreq,'wa');
}
?>
