<?php require "../functionv2.php";

// PAY CREDIT CART DUITKU
if ( isset($_POST['topup_cc_duitku']) && $_POST['topup_cc_duitku'] == MOBILE_FORM ) {
    $cc_user_id = secure_string($_POST['user_id']);
    $cc_user_telp = secure_string($_POST['user_telp']);
    $cc_user_email = secure_string($_POST['user_email']);
    $nominal_topup = secure_string($_POST['nominal_topup']);
    $paket_topup = secure_string($_POST['paket_topup']);
    
    $merchantCode = 'D4061'; // from duitku
    $merchantKey = '7549507e3d3cf35744d5e58671b4314e'; // from duitku
    $paymentAmount = $nominal_topup;
    $paymentMethod = 'VC'; // WW = duitku wallet, VC = Credit Card, MY = Mandiri Clickpay, BK = BCA KlikPay
    $merchantOrderId = time(); // from merchant, unique
    $productDetails = 'Topup dari User ID '.$cc_user_id;
    $email = $cc_user_email; // your customer email
    $phoneNumber = $cc_user_telp; // your customer phone number (optional)
    $additionalParam = ''; // optional
    $merchantUserInfo = $cc_user_id.'|'.$cc_user_email.'|'.$cc_user_telp; // optional
    $callbackUrl = 'https://www.ideasmart.id/appsdemo/mobile/api-duitku/duitku-callback.php'; // url for callback
    $returnUrl = 'https://www.ideasmart.id'; // url for redirect

    $signature = md5($merchantCode . $merchantOrderId . $paymentAmount . $merchantKey);

    $item1 = array(
        'name' => $paket_topup.' dari User ID '.$cc_user_id,
        'price' => $nominal_topup,
        'quantity' => 1);

    $itemDetails = array(
        $item1
    );

    $params = array(
        'merchantCode' => $merchantCode,
        'paymentAmount' => $paymentAmount,
        'paymentMethod' => $paymentMethod,
        'merchantOrderId' => $merchantOrderId,
        'productDetails' => $productDetails,
        'additionalParam' => $additionalParam,
        'merchantUserInfo' => $merchantUserInfo,
        'email' => $email,
        'phoneNumber' => $phoneNumber,
        'itemDetails' => $itemDetails,
        'callbackUrl' => $callbackUrl,
        'returnUrl' => $returnUrl,
        'signature' => $signature
    );

    $params_string = json_encode($params);
    $url = 'http://sandbox.duitku.com/webapi/api/merchant/inquiry'; // Sandbox
    // $url = 'https://passport.duitku.com/webapi/api/merchant/inquiry'; // Production
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($params_string))                                                                       
    );   
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    //execute post
    $request = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $result = json_decode($request, true);
    if ($httpCode == 200) {
        $url = $result['paymentUrl'];
        $merchantcode = $result['merchantCode'];
        $reference = $result['reference'];
        $oke = "1";
        $keterangan = "berhasil";
        $status = $httpCode;
    } else {
        $url = $result['paymentUrl'];
        $merchantcode = $result['merchantCode'];
        $reference = $result['reference'];
        $oke = "0";
        $keterangan = "gagal";
        $status = $httpCode;
    }
    $jawaban = array(
		"oke" => $oke,
        "keterangan" => $keterangan,
        "url" => $url,
        "merchantcode" => $merchantcode,
        "reference" => $reference,
        "status" => $status,
        "req" => $request,
	);
	echo json_encode($jawaban);

}


?>