<?php
    $merchantCode = 'D4061'; // from duitku
    $merchantKey = '7549507e3d3cf35744d5e58671b4314e'; // from duitku
    $merchantOrderId = '1532019971'; // from merchant, unique // From merchantOrderId

    $signature = md5($merchantCode . $merchantOrderId . $merchantKey);

    $params = array(
        'merchantCode' => $merchantCode,
        'merchantOrderId' => $merchantOrderId,
        'signature' => $signature
    );

    $params_string = json_encode($params);
    $url = 'http://sandbox.duitku.com/webapi/api/merchant/transactionStatus';
    //$url = 'https://passport.duitku.com/webapi/api/merchant/transactionStatus';
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

    if($httpCode == 200)
    {
        $result = json_decode($request, true);
    }
    else
        echo $httpCode;
?>