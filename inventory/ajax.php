<?php 
error_reporting(E_ALL);
include "../mesin/function.php";

if( isset($_POST['save_office']) && $_POST['save_office']==GLOBAL_FORM ){
	$kd_nameitem = secure_string($_POST['kd_nameitem']);
	$name_item = secure_string($_POST['name']);
	$jumlah_item = secure_string($_POST['jumlah_item']);
	$amount_item = secure_string($_POST['amount']);
	$date = secure_string($_POST['date']);
	$hour = secure_string($_POST['hour']);
	$minute = secure_string($_POST['minute']);
	$klien = secure_string($_POST['klien']);
	$fluktuasi = secure_string($_POST['fluktuasi']);
	$ecoage = secure_string($_POST['ecoage']);
	$desc = secure_string($_POST['desc']);
	$inv_id = secure_string($_POST['inv_id']);
	$inv_type = secure_string($_POST['inv_type']);
	//$inv_status = secure_string($_POST['inv_status']);
	$catkas = secure_string($_POST['catkas']);
	$cash_book = secure_string($_POST['cash_book']);
	$cash_category = secure_string($_POST['cash_category']);

	// persiapan
	$datedb = strtotime($date.' '.$hour.':'.$minute);
	$month = date('n',$datedb);
	$year = date('Y',$datedb);

	if( 'min' == $fluktuasi ){
		$ecomonth = 12 * $ecoage;
		$fluk_val = ceil( $amount_item / $ecomonth );
	}else{
		$ecoage = 0;
		$fluk_val = 0;
	}

	if( 0 == $inv_id ){
		$args = "INSERT INTO inventory ( type, kd_barang, name, jumlah_barang, description, date, price_start, fluktuasi_type, fluktuasi_val, inv_age, klien) VALUES ( '$inv_type', '$kd_nameitem', '$name_item', '$jumlah_item', '$desc', '$datedb', '$amount_item', '$fluktuasi', '$fluk_val', '$ecoage', '$klien')";
		$insert = mysqli_query($dbconnect,$args);
		$inv_id = mysqli_insert_id($dbconnect);

		// insert cash
		if ( '1' == $catkas ) {
			$inout = get_type_cat($cash_category);
			$argskas = "INSERT INTO transaction_kas ( date, amount, type, category, cash, person, inventory )
				VALUES ( '$datedb', '$amount_item', '$inout', '$cash_category', '$cash_book', '$klien', '$inv_id' )";
			$insertkas = mysqli_query( $dbconnect, $argskas );
			$updatebalance = balance_cat($month,$year,$cash_category,$cash_book);
		} else {
			$insertkas = true;
			$updatebalance = true;
		}
		if ( $insert && $insertkas && $updatebalance ) { echo "berhasil"; } else { echo "gagal"; }
	}else{
		$args = "UPDATE inventory SET type='$inv_type', kd_barang='$kd_nameitem', name='$name_item', jumlah_barang='$jumlah_item', description='$decs', date='$datedb', price_start='$amount_item', fluktuasi_type='$fluktuasi', fluktuasi_val='$fluk_val', inv_age='$ecoage', klien='$klien' WHERE id='$inv_id'";
		$update = mysqli_query( $dbconnect, $args );
		// cek apakah sebelumnya dicatat pada kas
		$catkas_asli = catkas_inv($inv_id);
		// jika sebelumnya dicatat
		if ( $catkas_asli[0] == '1' ) {
			$cashbook_asli = $catkas_asli[1];
			$category_asli = $catkas_asli[2];
			$month_asli = date('n',$catkas_asli[3]);
			$year_asli = date('Y',$catkas_asli[3]);
			$trans_id = $catkas_asli[4];
			// jika tetap dicatat pada buku kas, berarti diupdate
			if ( $catkas == '1' ) {
				$inout = get_type_cat($cash_category);
				$argskas = "UPDATE transaction_kas SET date='$datedb', amount='$amount_item', type='$inout', category='$cash_category', cash='$cash_book',
					person='$klien' WHERE id='$trans_id'";
				$updatekas = mysqli_query( $dbconnect, $argskas );
				// totalan asli
				$updatebalance_asli = balance_cat($month_asli,$year_asli,$category_asli,$cashbook_asli);
				// totalan baru
				$updatebalance = balance_cat($month,$year,$cash_category,$cash_book);
			// jika gak dicatat lagi pada buku kas, berarti transaksi dihapus
			} else {
				$argskas = "DELETE FROM transaction_kas WHERE id='$trans_id'";
				$updatekas = mysqli_query( $dbconnect, $argskas );
				// totalan terhapus
				$updatebalance_asli = balance_cat($month_asli,$year_asli,$category_asli,$cashbook_asli);
				$updatebalance = true;
			}
		// jika sebelumnya gak dicatat
		}else{
			// jika sekarang dicatat, maka di insert
			if ( $catkas == '1' ) {
				// insert cash
				$inout = get_type_cat($cash_category);
				$argskas = "INSERT INTO transaction_kas ( date, amount, type, category, cash, person, inventory )
					VALUES ( '$datedb', '$amount_item', '$inout', '$cash_category', '$cash_book', '$klien', '$inv_id' )";
				$updatekas = mysqli_query( $dbconnect, $argskas );
				// jumlahkan
				$updatebalance_asli = true;
				$updatebalance = balance_cat($month,$year,$cash_category,$cash_book);
			} else {
				$updatekas = true;
				$updatebalance_asli = true;
				$updatebalance = true;
			}
		}
		if ( $update && $updatekas && $updatebalance_asli && $updatebalance ) { echo "berhasil"; } else { echo "gagal"; }
	}

}

// del inv
if ( isset($_POST['inv_del']) && $_POST['inv_del']==GLOBAL_FORM ){
	$inv_id = secure_string($_POST['delid']);
	// cek apakah ada transaksi di buku kas
	$args_cek = "SELECT * FROM transaction_kas WHERE inventory='$inv_id'";
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

	
	$args = "DELETE FROM inventory WHERE id='$inv_id'";
	$update = mysqli_query($dbconnect,$args);
	if ( $update ) { echo "berhasil"; } else { echo "gagal"; }
}

// dump inv
if ( isset($_POST['inv_dump']) && $_POST['inv_dump']==GLOBAL_FORM ) {
	$dump_id = secure_string($_POST['dumpid']);
	$datedb = strtotime('now');
	$args = "UPDATE inventory SET date_sell='$datedb', aktif='3' WHERE id='$dump_id'";
	$update = mysqli_query( $dbconnect, $args );
	if ( $update ) { echo "berhasil"; } else { echo "gagal"; }
}

// sell inv
if ( isset($_POST['save_invsell']) && $_POST['save_invsell']==GLOBAL_FORM ){
	$sell_id = secure_string($_POST['sellinvid']);
	$amountsell = secure_string($_POST['amountsell']);
	$catkas = secure_string($_POST['catkassell']);
	$cash_book = secure_string($_POST['cash_book_sell']);
	$cash_category = secure_string($_POST['cash_category_sell']);
	$datedb = strtotime('now');
	$args = "UPDATE inventory SET date_sell='$datedb', price_sell='$amountsell', aktif='2' WHERE id='$sell_id'";
	$update = mysqli_query($dbconnect,$args);
	// insert cash
	$month = date('n');
	$year = date('Y');
	if ( '1' == $catkas ) {
		$inout = get_type_cat($cash_category);
		$argskas = "INSERT INTO transaction_kas ( date, amount, type, category, cash, inventory_sell )
			VALUES ( '$datedb', '$amountsell', '$inout', '$cash_category', '$cash_book', '$sell_id' )";
		$insertkas = mysqli_query( $dbconnect, $argskas );
		$updatebalance = balance_cat($month,$year,$cash_category,$cash_book);
	} else {
		$insertkas = true;
		$updatebalance = true;
	}
	if ( $update && $insertkas && $updatebalance ) { echo "berhasil"; } else { echo "gagal"; }
}

// back inv
if ( isset($_POST['inv_back']) && $_POST['inv_back']==GLOBAL_FORM ){
	$back_id = secure_string($_POST['backid']);
	$datedb = strtotime('now');
	$args = "UPDATE inventory SET date_sell='99999999999999', price_sell='0', aktif='1' WHERE id='$back_id'";
	$update = mysqli_query($dbconnect,$args);
	// cek apakah ada transaksi di buku kas
	$args_cek = "SELECT * FROM transaction_kas WHERE inventory_sell='$back_id'";
	$cek = mysqli_query( $dbconnect, $args_cek );
	if ( mysqli_num_rows($cek) ) {
		$arr = mysqli_fetch_array($cek);
		$month = date('n',$arr['date']);
		$year = date('Y',$arr['date']);
		$cat = $arr['category'];
		$cash = $arr['cash'];
		$args_trans = "DELETE FROM transaction_kas WHERE inventory_sell='$back_id'";
		$del_trans = mysqli_query( $dbconnect, $args_trans );
		$balance = balance_cat($month,$year,$cat,$cash);
	} else {
		$del_trans = true; $balance = true;
	}
	if ( $update && $del_trans && $balance) { echo "berhasil"; } else { echo "gagal"; }
}

?>