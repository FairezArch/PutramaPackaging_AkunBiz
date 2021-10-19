<?php include "../mesin/function.php";


if ( isset($_POST['save_hutang']) && $_POST['save_hutang']==GLOBAL_FORM ) {	
	$person = secure_string($_POST['person']);
	$date = secure_string($_POST['date']);
	$hour = secure_string($_POST['hour']);
	$minute = secure_string($_POST['minute']);
	$amount = secure_string($_POST['amount']);
	$desc = secure_string($_POST['desc']);
	$debtid = secure_string($_POST['debtid']);
	$hptype = secure_string($_POST['hptype']);
	$catkas = secure_string($_POST['catkas']);
	$cash_book = secure_string($_POST['cash_book']);
	$cash_category = secure_string($_POST['cash_category']);
	if($hptype == 'debt'){
		$listhp = 'debt';
		$inout ='in';
	}else{
		$listhp = 'credit';
		$inout ='out';
	}
	
	$datedb = strtotime($date.' '.$hour.':'.$minute);
	$month = date('n',$datedb);
	$year = date('Y',$datedb);

	if( 0 == $debtid ){
		$args = "INSERT INTO hapiut ( type, date, saldostart, saldonow, person, description ) VALUES ( '$listhp', $datedb, '$amount', '$amount', '$person', '$desc' )";
		$insert = mysqli_query($dbconnect,$args);
		$hapiut_id = mysqli_insert_id($dbconnect);
		$saldohutang = update_saldo_hapiut($hapiut_id);
		if ( '1' == $catkas ) {
			// insert cash
			$inout = get_type_cat($cash_category);
			$argskas = "INSERT INTO transaction_kas ( date, amount, type, category, cash, person, hapiut )
				VALUES ( '$datedb', '$amount', '$inout', '$cash_category', '$cash_book', '$person', '$hapiut_id' )";
			$insertkas = mysqli_query( $dbconnect, $argskas );
			// jumlahkan
			$updatebalance = balance_cat($month,$year,$cash_category ,$cash_book);
		} else {
			$insertkas = true;
			$updatebalance = true;
		}
		if ( $insert && $insertkas && $updatebalance ) { echo "berhasil"; } else { echo "gagal"; }
	}else{
		$args = "UPDATE hapiut SET date='$datedb', saldostart='$amount', person='$person', description='$desc' WHERE id='$debtid'";
		$update = mysqli_query($dbconnect,$args);
		$saldohutang = update_saldo_hapiut($debtid);
		// cek apakah sebelumnya dicatat pada kas
		$catkas_asli = catkas($debtid);
		// jika sebelumnya dicatat
		if ( $catkas_asli[0] == '1' ) {
			$cashbook_asli = $catkas_asli[1];
			$month_asli = date('n',$catkas_asli[2]);
			$year_asli = date('Y',$catkas_asli[2]);
			$trans_id = $catkas_asli[3];
			// jika tetap dicatat pada buku kas, berarti diupdate
			if ( $catkas == '1' ) {
				$inout = get_type_cat($cash_category);
				$argskas = "UPDATE transaction_kas SET date='$datedb', amount='$amount', type='$inout', category='$cash_category', cash='$cash_book', person='$person' WHERE id='$trans_id'";
				$updatekas = mysqli_query( $dbconnect, $argskas );
				// totalan asli
				$updatebalance_asli = balance_cat($month_asli,$year_asli,$cashbook_asli);
				// totalan baru
				$updatebalance = balance_cat($month,$year,$cash_book);
			// jika gak dicatat lagi pada buku kas, berarti transaksi dihapus
			} else {
				$argskas = "DELETE FROM transaction_kas WHERE id='$trans_id'";
				$updatekas = mysqli_query( $dbconnect, $argskas );
				// totalan terhapus
				$updatebalance_asli = balance_cat($month_asli,$year_asli,$cashbook_asli);
				$updatebalance = true;
			}
		// jika sebelumnya gak dicatat
		} else {
			// jika sekarang dicatat, maka di insert
			if ( $catkas == '1' ) {
				// insert cash
				$inout = get_type_cat($cash_category);
				$argskas = "INSERT INTO transaction_kas ( date, amount, type, category, cash, person, hapiut )
					VALUES ( '$datedb', '$amount', '$inout', '$cash_category', '$cash_book', '$person', '$debtid' )";
				$updatekas = mysqli_query( $dbconnect, $argskas );
				// jumlahkan
				$updatebalance_asli = true;
				$updatebalance = balance_cat($month,$year,$cash_book);
			} else {
				$updatekas = true;
				$updatebalance_asli = true;
				$updatebalance = true;
			}
		}
		if ( $update && $updatekas && $updatebalance_asli && $updatebalance ) { echo "berhasil"; } else { echo "gagal"; }
	}
}

// plus min hapiut
if( isset($_POST['save_pm_hapiut']) && $_POST['save_pm_hapiut']==GLOBAL_FORM ){
	$pmtype = secure_string($_POST['pmtype']);
	$date   = secure_string($_POST['pmdate']);
	$hour   = secure_string($_POST['pmhour']);
	$minute = secure_string($_POST['pmminute']);
	$amount = secure_string($_POST['pmamount']);
	$desc   = secure_string($_POST['pmdesc']);
	$debtid = secure_string($_POST['pmdebtid']);
	$hptype = secure_string($_POST['pmhptype']);
	$catkas = secure_string($_POST['catkas']);
	$cash_book = secure_string($_POST['cash_book']);
	$cash_category = secure_string($_POST['pmcash_category']);

	$datedb = strtotime($date.' '.$hour.':'.$minute);
	$month  = date('n',$datedb);
	$year   = date('Y',$datedb);

	$args   = "INSERT INTO hapiut_item( date, type, description, parenthp, amount ) VALUES ( '$datedb', '$pmtype', '$desc', '$debtid', '$amount' ) ";
	$insert = mysqli_query( $dbconnect, $args );
	$plusmin_id = mysqli_insert_id($dbconnect);
	$person_id = hapiut_data($debtid,'person');
	$saldohutang = update_saldo_hapiut($debtid);

	if ( '1' == $catkas ) {
		// insert cash
		if($pmtype == 'debt'){ $inout ='in';}else{$inout ='out';}
		//$inout = get_type_cat($cash_category);
		$argskas = "INSERT INTO transaction_kas ( date, amount, type, category, cash, person, hapiut_item )
			VALUES ( '$datedb', '$amount', '$inout', '$cash_category', '$cash_book', '$person_id', '$plusmin_id' )";
		$insertkas = mysqli_query( $dbconnect, $argskas );
		// jumlahkan
		$updatebalance = balance_cat($month,$year,$cash_category,$cash_book);
	} else {
		$insertkas = true;
		$updatebalance = true;
	}
	if ( $insert && $insertkas && $updatebalance ) { echo "berhasil"; } else { echo "gagal"; }
}

// delete debt
if ( isset($_POST['hapiut_del']) && $_POST['hapiut_del']==GLOBAL_FORM ) {
	$debt_id = secure_string($_POST['delid']);
	// delete child
	$args_item = "SELECT id FROM hapiut_item WHERE parenthp='$debt_id'";
	$result = mysqli_query( $dbconnect, $args_item );
	if ( mysqli_num_rows($result) ) {
		$delitem = array();
		while ( $hpitem = mysqli_fetch_array($result) ) { $delitem[] = $hpitem['id']; }
		foreach ( $delitem as $item ) { del_det_hp($item); }
	} else { $delitem = true; }
	$args = "DELETE FROM hapiut WHERE id='$debt_id'";
	$update = mysqli_query( $dbconnect, $args );
}

// delete detail hutang
if ( isset($_POST['hapiut_detail_del']) && $_POST['hapiut_detail_del']==GLOBAL_FORM ) {
	$id = secure_string($_POST['delid']);
	// cek apakah ada transaksi di buku kas
	$args_cek = "SELECT * FROM transaction_kas WHERE hapiut_item='$id'";
	$cek = mysqli_query( $dbconnect, $args_cek );
	if ( mysqli_num_rows($cek) ) {
		$arr = mysqli_fetch_array($cek);
		$month = date('n',$arr['date']);
		$year = date('Y',$arr['date']);
		$cat = $arr['category'];
		$cash = $arr['cash'];
		$args_trans = "DELETE FROM transaction_kas WHERE hapiut_item='$id'";
		$del_trans = mysqli_query( $dbconnect, $args_trans );
		$balance = balance_cat($month,$year,$cat,$cash);
	} else {
		$del_trans = true; $balance = true;
	}

	// delete item
	$parent = hapiut_item_data($id,'parenthp');
	$args = "DELETE FROM hapiut_item WHERE id='$id'";
	$update = mysqli_query( $dbconnect, $args );
	$balance_debt = update_saldo_hapiut($parent);
	if ( $update && $balance_debt ) { return true; }
	else { return false; }
}
?>