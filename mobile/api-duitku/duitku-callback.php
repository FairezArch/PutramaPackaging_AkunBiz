<?php require "../functionv2.php";

$apiKey = '7549507e3d3cf35744d5e58671b4314e'; // Your api key
$merchantCode = isset($_POST['merchantCode']) ? $_POST['merchantCode'] : null; 
$amount = isset($_POST['amount']) ? $_POST['amount'] : null; 
$merchantOrderId = isset($_POST['merchantOrderId']) ? $_POST['merchantOrderId'] : null; 
$productDetail = isset($_POST['productDetail']) ? $_POST['productDetail'] : null; 
$additionalParam = isset($_POST['additionalParam']) ? $_POST['additionalParam'] : null; 
$paymentMethod = isset($_POST['paymentCode']) ? $_POST['paymentCode'] : null; 
$resultCode = isset($_POST['resultCode']) ? $_POST['resultCode'] : null; 
$merchantUserId = isset($_POST['merchantUserId']) ? $_POST['merchantUserId'] : null; 
$reference = isset($_POST['reference']) ? $_POST['reference'] : null; 
$signature = isset($_POST['signature']) ? $_POST['signature'] : null; 

$issuer_name = isset($_POST['issuer_name']) ? $_POST['issuer_name'] : null; // Hanya untuk ATM Bersama
$issuer_bank = isset($_POST['issuer_bank']) ? $_POST['issuer_bank'] : null; // Hanya untuk ATM Bersama

$tgl_database = strtotime('now');

if(!empty($merchantCode) && !empty($amount) && !empty($merchantOrderId) && !empty($signature)) {
    $params = $merchantCode . $amount . $merchantOrderId . $apiKey;
    $calcSignature = md5($params);

    if($signature == $calcSignature) {
        
    	if($resultCode == "00") {
            echo "SUCCESS"; // Save to database
            
            $args = "INSERT INTO test_saldo ( tanggal, user_detil, paymentCode, reference_payment, jumlah_topup ) VALUES ( '$tgl_database', '$merchantUserId', '$paymentMethod', '$reference', '$amount' )";
            $result = mysqli_query( $dbconnect, $args );
            
       	} else {
            echo "FAILED"; // Please update the status to FAILED in database
        }
    } else {
        throw new Exception('Bad Signature');
    }
} else {
    throw new Exception('Bad Parameter');
}
?>