<?php require "functionv2.php";

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
            //echo "SUCCESS"; // Save to database
            $pisah_detil_ser = explode('|',$merchantUserId);
            $user_id = $pisah_detil_ser[0];
            $user_email = $pisah_detil_ser[1];
            $user_telp = $pisah_detil_ser[2];
            
            $pisah_detil_produk = explode('|',$productDetail);
            $idpesanan = $pisah_detil_produk[0];
            $tipe_bayar = $pisah_detil_produk[1];
            $paket_topup = $pisah_detil_produk[3];
            
            if($tipe_bayar == 'pay_credit'){
                $product = 'Transaksi pesanan ID ' .$idpesanan;
                $jenis_pembayaran = 'pesanan';
                $type = 'none';
                $id_pesanan = $idpesanan;
                $args_statuspesanan = "UPDATE pesanan SET status = '10' WHERE id='$idpesanan'";
                $result1 = mysqli_query( $dbconnect, $args_statuspesanan );
            }else{
              $product = 'Topup '.$amount.' dari User ID '.$user_id;
              $jenis_pembayaran = 'saldo';
              $type = 'plus';
              $id_pesanan = '0';
            }
            
            
            $args_callback = "INSERT INTO callback_duitku ( detil_user,jenis_pembayaran, detil_order, paymentCode, reference_payment, tanggal, jumlah_topup ) VALUES ( '$merchantUserId', '$jenis_pembayaran','$product', '$paymentMethod', '$reference', '$tgl_database', '$amount' )";
            $result1 = mysqli_query( $dbconnect, $args_callback );
            if ($result1) {
                $to_trans_saldo = "INSERT INTO trans_saldo ( date, type, nominal, id_user, deskripsi, id_pesanan, id_reqsaldo ) VALUES ( '$tgl_database', '$type', '$amount', '$user_id', '$product', '$idpesanan', '0' )";
                $result2 = mysqli_query( $dbconnect, $to_trans_saldo );
                if ($result2) {
                    $update_user_saldo = update_saldo_user($user_id);
                }
            }
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