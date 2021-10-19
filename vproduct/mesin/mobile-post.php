<?php require "function.php";

if ( isset($_POST['newpass_setup']) && $_POST['newpass_setup']==GLOBAL_FORM ) {
	$kunci = md5( secure_string($_POST['newpass1']).USER_PASS );
	$newpass_code = secure_string($_POST['newpass_code']);
	$user_id = userid_by('passcode',$newpass_code);
	$args = "UPDATE user_member SET password='$kunci', verification='1' WHERE passcode='$newpass_code'";
	$update = mysqli_query( $dbconnect, $args );
	if ( $update ) {
		$args = "UPDATE user_member SET passcode='', passtime='0' WHERE id='$user_id'";
		$update_code = mysqli_query( $dbconnect, $args );
		echo 'berhasil';
	} else { echo 'gagal'; }	
}
mysqli_close($dbconnect); ?>

?>