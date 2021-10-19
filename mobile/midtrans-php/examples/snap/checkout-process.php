<?php
$user_id = $_GET['user_id'];
$nominal_topup = $_GET['nominal_topup'];
$name_topup_id = $_GET['name_topup_id'];
$nama_topup = $_GET['nama_topup'];
$email_topup = $_GET['email_topup'];
$telp_topup = $_GET['telp_topup'];
$alamat_topup = $_GET['alamat_topup'];
$zip_topup = $_GET['zip_topup'];

require_once(dirname(__FILE__) . '/../../Veritrans.php');
	//Set Your server key
	Veritrans_Config::$serverKey = "SB-Mid-server-jtSIP1S2yGIE7_qy1tQ5Feaj";
	
	// Uncomment for production environment
	Veritrans_Config::$isProduction = true;
	
	// Enable sanitization
	Veritrans_Config::$isSanitized = true;
	
	// Enable 3D-Secure
	Veritrans_Config::$is3ds = true;
	
	// Required
	$transaction_details = array(
	  'order_id' => rand(),
	  'gross_amount' => 90000, // no decimal allowed for creditcard
	);
	
	// Optional
	$item1_details = array(
	  'id' => $user_id,
	  'price' => $nominal_topup,
	  'quantity' => 1,
	  'name' => $name_topup_id
	);
	
	// Optional
	$item_details = array ($item1_details);
	
	// Optional
	$billing_address = array(
	  'address'       => $alamat_topup,
	  'city'          => "Yogyakarta",
	  'postal_code'   => $zip_topup,
	  'country_code'  => 'IDN'
	);
	
	// Optional
	$customer_details = array(
	  'first_name'    => $nama_topup,
	  'email'         => $email_topup,
	  'phone'         => $telp_topup,
	  'address'		  => $billing_address,
	);
	
	// Optional, remove this to display all available payment methods
	$enable_payments = array('credit_card');
	
	// Fill transaction details
	$transaction = array(
	  'enabled_payments' => $enable_payments,
	  'transaction_details' => $transaction_details,
	  'customer_details' => $customer_details,
	  'item_details' => $item_details,
	);
	
	$snapToken = Veritrans_Snap::getSnapToken($transaction);
	//echo "snapToken = ".$snapToken;
	
	
?>


<script type="text/javascript">
document.addEventListener("deviceready", onDeviceReady, false);
function onDeviceReady() {
// SnapToken acquired from previous step
	snap.pay('<?=$snapToken?>', {
	// Optional
		onSuccess: function(result){
			var mobile_form = "c6UXevafg8DJb8yKUNSYKXAps9vyEgzafEBhs3UD3UBGFycL";
			var id_user = <?=$user_id?>;
			var stringfi = JSON.stringify(result, null, 2); 
			var obj = JSON.parse(stringfi);
			var saldo_topup = obj.gross_amount;
			var date_topup = obj.transaction_time;
			$.ajax({ type: "POST", url: site_url, data: {
				id_user: id_user,
				saldo_topup: saldo_topup,
				date_topup: date_topup,
							
				result_topup: mobile_form
			}, dataType: "json", timeout: 60000, success: function(data) {
					//document.getElementById("result-json").innerHTML = saldo_topup + ", " + id_user + ", " + date_topup + ", " + data.total_saldo_user;
					window.localStorage.setItem("idsm_user_saldo",data.total_saldo_user);
					//window.location.reload();
				}, error: function(request, status, err) {
					
				}
			});
			return;
		},
		// Optional
		onPending: function(result){
			/* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
		},
		// Optional
		onError: function(result){
			/* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
		}
	});
}


