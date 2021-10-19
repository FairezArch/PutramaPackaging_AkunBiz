<?php 
include "../mesin/function.php";


// add/edit transaksi
if ( isset($_POST['trans_save']) && $_POST['trans_save']==GLOBAL_FORM ) {
	$type = secure_string($_POST['type']);
	$date = secure_string($_POST['date']);
	$hour = secure_string($_POST['hour']);
	$minute = secure_string($_POST['minute']);
	$category = secure_string($_POST['category']);
	$cash_from = secure_string($_POST['cash_from']);
	$cash_to = secure_string($_POST['cash_to']);
	$person = secure_string($_POST['person']);
	$amount = secure_string($_POST['amount']);
	$desc = secure_string($_POST['desc']);
	$transid = secure_string($_POST['transid']);
	$cashid = secure_string($_POST['cashid']);
	// pre value
	$premonth = secure_string($_POST['premonth']);
	$preyear = secure_string($_POST['preyear']);
	$precat = secure_string($_POST['precat']);
	$precashfrom = secure_string($_POST['precashfrom']);
	$precashto = secure_string($_POST['precashto']);
	// persiapan
	$datedb = strtotime($date." ".$hour.":".$minute);
	//$person_id = get_personid_by_name($person);
	$month = date('n',$datedb);
	$year = date('Y',$datedb);
    // Tambahan untuk LOG Cash
    $date_now = strtotime(NOW);
    $id_user = current_user_id();
	// jika baru
	if ( '0' == $transid ) {
		// jika pemasukan & pengeluaran
		if ( 'in' == $type || 'out' == $type ) {
			// insert cash
			$inout = get_type_cat($category); 
			$args = "INSERT INTO transaction_kas ( date, amount, description, type, category, cash, person )
					VALUES ( $datedb, '$amount', '$desc', '$inout', '$category', '$cashid', '$person' )";
			$insert = mysqli_query( $dbconnect, $args );
            $idcash = mysqli_insert_id($dbconnect);
			// jumlahkan
			$updatebalance = balance_cat($month,$year,$cashid);
            
			if ( $insert ) { echo "berhasil"; } else { echo "gagal"; }
		}
		// jika transfer
		if ( 'trans' == $type ) {
			// insert cash
			$args = "INSERT INTO transaction_kas ( date, amount, description, type, cash, cash_to, person )
					VALUES ( $datedb, '$amount', '$desc', 'trans', '$cash_from', '$cash_to', '$person' )";
			$insert = mysqli_query( $dbconnect, $args );
            $idcash = mysqli_insert_id($dbconnect);
			// jumlahkan
			$balance_trans_from = balance_trans($month,$year,$cash_from);
			$balance_trans_to = balance_trans($month,$year,$cash_to);

			if ( $insert ) { echo "berhasil"; } else { echo "gagal"; }
		}
	// jika edit
	} else {
		// jika pemasukan & pengeluaran
		if ( 'in' == $type || 'out' == $type ) {
			// insert cash
			$args = "UPDATE transaction_kas SET date='$datedb', amount='$amount', description='$desc', category='$category', person='$person'
				WHERE id='$transid'";
			$update = mysqli_query( $dbconnect, $args );
			// jumlahkan
			$updatebalance = balance_cat($month,$year,$cashid);
			$updatebalancepre = balance_cat($premonth,$preyear,$cashid);
            
        
            
			// return
			if ( $update ) { echo "berhasil"; } else { echo "gagal"; }
		}
		// jika transfer
		if ( 'trans' == $type ) {
			// insert cash
			$args = "UPDATE transaction_kas SET amount='$amount', date='$datedb', description='$desc', cash='$cash_from', cash_to='$cash_to', person='$person'
				WHERE id='$transid'";
			$update = mysqli_query( $dbconnect, $args );
			// jumlahkan
			$balance_trans_from = balance_trans($month,$year,$cash_from);
			if ( $precashfrom != $cash_from || $month != $premonth || $year != $preyear ) {
				$balance_trans_from = balance_trans($premonth,$preyear,$precashfrom);
			}
			$balance_trans_to = balance_trans($month,$year,$cash_to);
			if ( $precashto != $cash_to || $month != $premonth || $year != $preyear ) {
				$balance_trans_to = balance_trans($premonth,$preyear,$precashto);
			}
           
            
			// return
			if ( $update ) { echo "berhasil"; } else { echo "gagal"; }
		}
	}
}

// del transaksi
if ( isset($_POST['trans_del']) && $_POST['trans_del']==GLOBAL_FORM ) {
	$id = secure_string($_POST['delid']);
	$unixdate = trans_data($id,'date');
	$month = date('n',$unixdate);
	$year = date('Y',$unixdate);
	$category = trans_data($id,'category');
	$type = trans_data($id,'type');
	$cashid = trans_data($id,'cash');
	$cashto = trans_data($id,'cash_to');
    
	// set active 0
	$args = "DELETE FROM transaction_kas WHERE id=$id";
	$save = mysqli_query( $dbconnect, $args );
	// update balance
	if ( 'trans' == $type ) {
		$balance_trans_from = balance_trans($month,$year,$cashid);
		$balance_trans_to = balance_trans($month,$year,$cashto);
	} else {
		$balance = balance_cat($month,$year,$category,$cashid);
	}
}
?>