<?php 
include "../mesin/function.php";

// Update Status Order
if ( isset($_POST['checked_status']) && $_POST['checked_status']==GLOBAL_FORM ) {
	$data = secure_string($_POST['data']);
    $idorder = secure_string($_POST['idorder']);
    $id_user = current_user_id();
    $date = strtotime("now");
    $data_item = '1|'.$id_user.'|'.$date;
    
	if( $data == 'checker_1' ){ $field = 'status_1_checker'; }
    elseif( $data == 'helper_1' ){ $field = 'status_1_helper'; }
    elseif( $data == 'checker_2' ){ $field = 'status_2_checker'; }
    elseif( $data == 'helper_2' ){ $field = 'status_2_helper'; }
    elseif( $data == 'driver_2' ){ $field = 'status_2_driver'; }
    elseif( $data == 'driver_3' ){ $field = 'status_3_driver'; }
    elseif( $data == 'cust_3' ){ $field = 'status_3_cust'; }
    
    $args_cek = "SELECT id_checker FROM pesanan WHERE id='$idorder'";
    $result_cek = mysqli_query( $dbconnect, $args_cek );
    $datacek = mysqli_fetch_array($result_cek);
    if( $datacek['id_checker'] !== '0' ){
        $nama_checker = querydata_user($datacek['id_checker']);
        echo "terverifikasi!!!".$nama_checker."!!!";
    }else{
        //Update table pesanana
        $args ="UPDATE pesanan SET $field='$data_item', id_checker='$id_user', status='20' WHERE id='$idorder'";
        $result = mysqli_query( $dbconnect, $args );
        //Update table trans_order
        $args_trans ="UPDATE trans_order SET status_jual='1' WHERE id_pesanan='$idorder' AND type='out'";
        $result_trans = mysqli_query( $dbconnect, $args_trans );
        //Update Stok produk
        //$update_stok = update_stokproduk_id($idorder,'jual');

        if ($result){
            echo "berhasil";
        } else {
            echo "gagal";
        }
    }
   
}

// Submit Suspend
if ( isset($_POST['submit_suspend']) && $_POST['submit_suspend']==GLOBAL_FORM ) {
    $idorder = secure_string($_POST['idorder']);
    $typesuspend = secure_string($_POST['typesuspend']);
    
    $date = strtotime("now");
    /*
    if ( $typesuspend == 'start' ){
        if( $data == 'suspend1' ){ $field_db = 'time_1_suspend'; }
        elseif( $data == 'suspend2' ){ $field_db = 'time_2_suspend'; }
        else{ $field_db = ''; }
    }elseif( $typesuspend == 'finish' ){
        if( $data == 'suspend1' ){ $field_db = 'time_1_to_suspend'; }
        elseif( $data == 'suspend2' ){ $field_db = 'time_2_to_suspend'; }
        else{ $field_db = ''; }
    }else{ $field_db = ''; }
    */    
    if ( $typesuspend == 'start' ){
        $field_db = 'time_1_suspend';
    }elseif( $typesuspend == 'finish' ){
        $field_db = 'time_1_to_suspend';
    }else{ $field_db = ''; }
    
    if( $field_db !== '' ){
        $args ="UPDATE pesanan SET $field_db='$date' WHERE id='$idorder'";
        $result = mysqli_query( $dbconnect, $args );

        if ($result){
            echo "berhasil";
        } else {
            echo "gagal";
        }
    } else {
		echo "gagal";
	}
}

// Update Status Helper Order
if ( isset($_POST['helper_order']) && $_POST['helper_order']==GLOBAL_FORM ) {
    $idorder = secure_string($_POST['idorder']);
    $idhelper = secure_string($_POST['idhelper']);
    
    $args ="UPDATE pesanan SET id_helper='$idhelper' WHERE id='$idorder'";
    $result = mysqli_query( $dbconnect, $args );

    if ($result){
        echo "berhasil";
    } else {
        echo "gagal";
    }
}

// Update Status Pengemasan
if ( isset($_POST['status_kemas']) && $_POST['status_kemas']==GLOBAL_FORM ) {
    $idorder = secure_string($_POST['idorder']);
    $id_status = secure_string($_POST['id_status']);
    
    $args ="UPDATE pesanan SET status_kemas='$id_status' WHERE id='$idorder'";
    $result = mysqli_query( $dbconnect, $args );

    if ($result){
        echo "berhasil";
    } else {
        echo "gagal";
    }
}

// Update and Submit Driver
if ( isset($_POST['submit_driver']) && $_POST['submit_driver']==GLOBAL_FORM ) {
    $idorder = secure_string($_POST['idorder']);
    $iddriver = secure_string($_POST['iddriver']);
    
    $args ="UPDATE pesanan SET id_driver='$iddriver' WHERE id='$idorder'";
    $result = mysqli_query( $dbconnect, $args );

    if ($result){
        echo "berhasil";
    } else {
        echo "gagal";
    }
}

// Update and Submit Start Shipping
if ( isset($_POST['submit_shipping']) && $_POST['submit_shipping']==GLOBAL_FORM ) {
    $idorder = secure_string($_POST['idorder']);
    $iddriver = secure_string($_POST['iddriver']);
    $status_order = secure_string($_POST['status_order']);
    
    $id_user = current_user_id();
    $date = strtotime("now");
    $data_item = '1|'.$id_user.'|'.$date;
    
    if( $status_order == '20' ){
        $statusupdate = '30';
        $field_status = 'status_2_driver';
    }elseif( $status_order == '30' ){
        $statusupdate = '40';
        $field_status = 'status_3_driver';
    }
    
    $args ="UPDATE pesanan SET $field_status='$data_item', status='$statusupdate' WHERE id='$idorder'";
    $result = mysqli_query( $dbconnect, $args );

    if ($result){
        echo "berhasil";
    } else {
        echo "gagal";
    }
}

// Customer konfirmasi pesanan
if ( isset($_POST['cust_confrim']) && $_POST['cust_confrim']==GLOBAL_FORM ) {
    $idorder = secure_string($_POST['idorder']);

    $id_user = current_user_id();
    $date = strtotime("now");
    $data_item = '1|'.$id_user.'|'.$date;
    
    $args ="UPDATE pesanan SET status_3_cust='$data_item', status='50' WHERE id='$idorder'";
    $result = mysqli_query( $dbconnect, $args );

    if ($result){
        echo "berhasil";
    } else {
        echo "gagal";
    }
}

// Update data order
if ( isset($_POST['save_updatedataorder']) && $_POST['save_updatedataorder']==GLOBAL_FORM ) {
    $tanggal =  secure_string($_POST['tanggal']);
	$jam = secure_string($_POST['jam']);
	$menit = secure_string($_POST['menit']);
    $date_sendorder = strtotime($tanggal." ".$jam.":".$menit);
    
    $id_order = secure_string($_POST['id_order']);
    $order_telp = secure_string($_POST['order_telp']);
    $order_alamat = secure_string($_POST['order_alamat']);
    $order_catatan = secure_string($_POST['order_catatan']);
    
    $args ="UPDATE pesanan SET telp='$order_telp', catatan='$order_catatan', alamat_kirim='$order_alamat', waktu_kirim='$date_sendorder' WHERE id='$id_order'";
    $result = mysqli_query( $dbconnect, $args );

    if ($result){
        echo "berhasil";
    } else {
        echo "gagal";
    }
}

// Pembatalan Order
if ( isset($_POST['batal_order']) && $_POST['batal_order']==GLOBAL_FORM ) {
    $idorder = secure_string($_POST['idorder']);
    $iduser = querydata_pesanan($idorder,'id_user');
    
    // Data Transaksi Order
	$args_order = "DELETE FROM trans_order WHERE id_pesanan='$idorder'";
	$del_order = mysqli_query( $dbconnect, $args_order );
    
    // Data Transaksi Saldo
    $args_transsaldo = "DELETE FROM trans_saldo WHERE id_pesanan='$idorder'";
    $result_transsaldo = mysqli_query( $dbconnect, $args_transsaldo );
    $saldouser = update_saldo_user($iduser);
    
    // Data Request saldo
    $args_reqsaldo = "SELECT * FROM request_saldo WHERE id_pesanan='$idorder'";
    $result_reqsaldo = mysqli_query( $dbconnect, $args_reqsaldo );
	while ( $item_req = mysqli_fetch_array($result_reqsaldo) ) {
        // Data Konfirmasi Saldo
        $idreqsaldo = $item_req['id'];
        $args_konfrimsaldo = "DELETE FROM konfirmasi_saldo WHERE id_reqsaldo='$idreqsaldo'";
        $result_konfrimsaldo = mysqli_query( $dbconnect, $args_konfrimsaldo );
    }
    $args_delreqsaldo = "DELETE FROM request_saldo WHERE id_pesanan='$idorder'";
    $result_delreqsaldo = mysqli_query( $dbconnect, $args_delreqsaldo );
    
    // Data Pesanan
	$args ="UPDATE pesanan SET aktif='0' WHERE id='$idorder'";
    $result = mysqli_query( $dbconnect, $args );

    if ($result){
        echo "berhasil";
    } else {
        echo "gagal";
    }
}

/*
if ( isset($_POST['batal_order']) && $_POST['batal_order']==GLOBAL_FORM ) {
    echo auto_pesanan_batal('27');
}
*/

//Konfirmasi pembayaran khusus Admin
if ( isset($_POST['save_konfrim']) && $_POST['save_konfrim']==GLOBAL_FORM ){

    $idorder_konfirm = secure_string($_POST['idorder']);
    $user = current_user_id();
    $time_konfirm = strtotime('now');
    $alamat_lengkap = alamat_customer_pesanan($idorder_konfirm);
    $list_status = querydata_pesanan($idorder_konfirm,'status');
    $list_nominal = querydata_pesanan($idorder_konfirm,'total');
    $list_iduser = querydata_pesanan($idorder_konfirm,'id_user');
    $diskripsi = "Transaksi pesanan ID";

    $namauser = querydata_user($list_iduser,'nama');
    $emailuser = querydata_user($list_iduser,'email');
    $tipekurir = strtoupper(split_status_order(querydata_pesanan($idorder_konfirm,'layanan_pengiriman'),'0'));
    $hotline = get_dataoption('hotline');
    $telepon = get_dataoption('telepon_view');
    $emailreply ="autosend@PutramaPackaging.id";
    $waktu_pesan = querydata_pesanan($idorder_konfirm,'waktu_pesan');
    $catatan = querydata_pesanan($idorder_konfirm,'catatan');
    $resi = querydata_pesanan($idorder_konfirm,'no_resi');

    $list_konfirm_bayar = '1|'.$user.'|'.$time_konfirm;
    $args_konfirmasi_bayar = "UPDATE pesanan SET status_3_driver='$list_konfirm_bayar' ,status='40' WHERE id='$idorder_konfirm'";
    $result_konfirm = mysqli_query($dbconnect,$args_konfirmasi_bayar);

    $args_order = "SELECT * FROM trans_order WHERE id_pesanan='$idorder_konfirm' AND type='out' ORDER BY id ASC";
    $result_order = mysqli_query($dbconnect,$args_order);

    $ipp =$_SERVER['REMOTE_ADDR'];
    $textmail_touser = "
    <html>
    <head>
        <style type='text/css'>
        *{margin: 0px; padding: 0px;}
            .pageemail{display: block; width: 600px; height: auto; margin: 0 auto; color: #555;}
            .headertop{ background: #075489; height: 70px;}
            .headertop img{display: block; margin: 0 auto; line-height: 15px;}
            .tableemail, .nexttable{ width: 90%; border-bottom: 1px solid #ccc; display: block; margin: 0 auto;}
            .tableemail td{border-bottom: 1px solid #ccc; width: 100%; padding: 0px 10px; line-height: 20px;}
            .nexttable td{border-bottom: 1px solid #ccc; line-height: 1.5;}
            .pagecontent { background: #fff; display: block; margin: 15px auto; width: 560px;}
            .newlinetable {background: #075489; height: 8px;}
        </style>
    </head>
    <body>
        <div class='pageemail'>
            <div class='headertop'>
                <img src='".GLOBAL_URL."/penampakan/images/logo-putrama.png' width='110' height='60'>
            </div>
            <div class='pagecontent'>
                <p>Hai ".$namauser."</p><br>
                <p>Berdasarkan data yang kami terima dari tracking jasa pengiriman, barang telah sampai di tujuan:</p><br />
                <table class='tableemail'>
                    <tbody>
                        <tr>
                            <td colspan='2' style='text-align: center;background: #075489;height: 30px; color: #fff;'>No. Pesanan ".$idorder_konfirm."</td>
                        </tr>
                        <tr>
                            <td>Waktu Pesan</td>
                            <td>".$waktu_pesan."</td>
                        </tr>
                        <tr>
                            <td>Atas Nama</td>
                            <td>".$namauser."</td>
                        </tr>
                        <tr>
                            <td>Jasa Pengiriman</td>
                            <td>".$tipekurir."</td>
                        </tr>
                        <tr>
                            <td>Resi Pengiriman</td>
                            <td>".$resi."</td>
                        </tr>
                        <tr>
                            <td>Catatan</td>
                            <td>".$catatan."</td>
                        </tr>
                        <tr>
                            <td colspan='2' class='newlinetable'></td>
                        </tr>
                    </tbody>
                </table>
                <table class='nexttable'>
                <thead>
                    <tr>
                        <th width='202'>Produk</th>
                        <th width='50'>Jumlah</th>
                        <th width='126'>Harga Satuan</th>
                        <th width='126'>Harga</th>
                    </tr>
                </thead>
                <tbody>
                <?php ".while($data_pesan = mysqli_fetch_array($result_konfirm)){."?>
                    <tr>
                        <td>".data_tabel('produk', $data_pesan['id_produk'], 'title')."</td>
                        <td><center>".$data_pesan['jumlah']."</center></td>
                        <td><center>Rp ".format_angka( $data_pesan['harga'] )."</center></td>
                        <td><center>Rp ".format_angka( $data_pesan['jumlah'] * $data_pesan['harga'] )."</center></td>
                    </tr>
                    
                    ".}."
                </tbody>
                    <tr>
                        <td colspan='3'><center>Biaya Pengiriman</center></td>
                        <td><center>Rp ".format_angka( data_tabel('pesanan', $idpesan, 'ongkos_kirim') )."</center></td>
                    </tr>
                    <tr>
                        <td colspan='3'><center><b>Sub Total</b></center></td>
                        <td><center>Rp ".format_angka( data_tabel('pesanan', $idpesan, 'total') )."</center></td>
                    </tr>
                </table>
                <br />
                <p>Segera lakukan konfirmasi pesanan Anda.</p><br />
                <p>Jika Anda mengalami masalah terhadap barang Anda / memiliki pertanyaan lainnya, silahkan menghubungi kami di nomor berikut :</p><br />
                <p>Hotline : ".$hotline."</p>
                <p>Telepon : ".$telepon."</p>
            </div>
        </div>
    </body>
    </html>";

    $theheader = "From: ".$emailreply." \r\n";
    $theheader .= "X-Sender: ".$emailreply."\r\n";
    $theheader.= "Reply-To: ".$emailuser." \r\n";
    $theheader .= "Organization: Sender Organization\r\n";
    $theheader .= "MIME-Version: 1.0\r\n";
    $theheader .= "Content-type: text/plain; charset=iso-8859-1\r\n";
    $theheader .= "X-Priority: 1\r\n";
    $theheader .= "X-Mailer: PHP\r\n";

        $subjectmail_user = 'Notifikasi Pesananan Putrama Pakaging';
        /*$theheader_user = "From: ".$emailreply." \r\n";
        //$theheader.= "Reply-To: ".$emailuser." \r\n";
        //$theheader.= "Cc: ".$cc." \r\n";
        $theheader_user.= "X-Mailer: PHP/".phpversion()." \r\n"; 
        $theheader_user.= "MIME-Version: 1.0" . " \r\n";
        $theheader_user.= "Content-Type: text/html; charset=UTF-8\r\n";*/

        // sendmail
       $send_email =  mail( $emailuser, $subjectmail_user, $textmail_touser, $theheader );

    
    if ($result_konfirm && $send_email){ //&& $result_trans_saldo) {
        echo "berhasil";
    } else {
        echo "gagal";
    }
}

if ( isset($_POST['status_pembelian_pesan']) && $_POST['status_pembelian_pesan']==GLOBAL_FORM){

    $idorder_statuspesan = secure_string($_POST['idorder_status']);

    $upd_statuspesan = "UPDATE pesanan SET status='10' WHERE id='$idorder_statuspesan'";
    $result_upd_status = mysqli_query($dbconnect,$upd_statuspesan);

    if ($result_upd_status) {
        echo "berhasil";
    }else{
        echo "gagal";
    }
}
?>

