<?php 
include "../mesin/function.php";

// Update Status Order
if ( isset($_POST['beli_select_data']) && $_POST['beli_select_data']==GLOBAL_FORM ) {
	$no = secure_string($_POST['no']);
    $type = secure_string($_POST['type']);
    $barcode = secure_string($_POST['barcode']);
    $idprod = secure_string($_POST['idprod']);
    
    if( $type == 'barcode' ){
        $idprod = querydata_prod($barcode,'id','barcode');
        $satuan = querydata_prod($barcode,'satuan','barcode');
        $jml_persatuan = querydata_prod($barcode,'jml_persatuan','barcode');
        $harga_beli = querydata_prod($barcode,'harga_produk','barcode');
    }else{
        $barcode = querydata_prod($idprod,'barcode');
        $satuan = querydata_prod($idprod,'satuan');
        $jml_persatuan = querydata_prod($idprod,'jml_persatuan');
        $harga_beli = querydata_prod($idprod,'harga_produk');
    }

    $alldata = $barcode.'|'.$idprod.'|'.$satuan.'|'.$jml_persatuan.'|'.$harga_beli;
    if( isset($alldata) ){
         echo "berhasil!!!".$alldata."!!!";
    }else{
        echo "gagal";
    } 
}

if ( isset($_POST['save_pembelian']) && $_POST['save_pembelian']==GLOBAL_FORM ) {	
	$tanggal =  secure_string($_POST['tanggal']);
	$jam = secure_string($_POST['jam']);
	$menit = secure_string($_POST['menit']);
	//$invoice = secure_string($_POST['invoice']);
    $invoice = '';
	$suplayer = secure_string($_POST['suplayer']);
	$suplayer_contact = secure_string($_POST['suplayer_contact']);
	$keterangan = secure_string($_POST['keterangan']);
	$id_beli = secure_string($_POST['id_beli']);
	
    $get_id_produk = secure_string($_POST['list_id_produk']);
    $get_jumlah = secure_string($_POST['list_jumlah']);
	$get_hargasatuan = secure_string($_POST['list_hargasatuan']);

    // Filter data pembelian Item
    $array_get_id = explode('|',$get_id_produk);
    $array_get_jumlah = explode('|',$get_jumlah);
    $array_get_hargasatuan = explode('|',$get_hargasatuan);

    $jumlah_getitem = count($array_get_id) - 1;
    $arraynew_id = array(); 
    $arraynew_jumlah = array(); 
    $arraynew_get_hargasatuan = array();
    $a = 0;
    while($a <= $jumlah_getitem) {
        if($array_get_id[$a] !== '' && $array_get_id[$a] !== '0'){
            $arraynew_id[] = $array_get_id[$a];
            $arraynew_jumlah[] = $array_get_jumlah[$a];
            $arraynew_get_hargasatuan[] = $array_get_hargasatuan[$a];
        } 
        $a++;
    }

    $list_id_produk = join("|",$arraynew_id);
    $list_jumlah = join("|",$arraynew_jumlah);
    $list_hargasatuan = join("|",$arraynew_get_hargasatuan);
    
	// PERSIAPAN
	$datedb = strtotime($tanggal." ".$jam.":".$menit);
	$month = date('n',$datedb);
	$year = date('Y',$datedb);
    
	$array_id_produk = explode('|',$list_id_produk);
	$array_jumlah = explode('|',$list_jumlah);
    $array_hargasatuan = explode('|',$list_hargasatuan);

    $id_user = current_user_id();
    
    // total Pembelian = $total_beli
    $jumlah_item = count($array_id_produk) - 1;
    $x = 0;
    $total_beli = 0;
    while($x <= $jumlah_item) {
        $pembelian_item = $array_jumlah[$x] * $array_hargasatuan[$x];
        $total_beli = $total_beli + $pembelian_item;
        $x++;
    }

    // total transaksi
    $total_tambah = 0;
    $jmldiskon = 0;
    $total_transaksi = $total_beli + $total_tambah - $jmldiskon;
 
    // JIKA PEMBELIAN BARU
    if ( '0' == $id_beli ) {
        $args_logistik = "
            INSERT INTO logistik (
                tanggal, invoice, suplayer, contact, keterangan,
                produk_id, jumlah, hargasatuan,
                total_diskon, total_beli, total_tambah, total_transaksi, user_id
                ) VALUES (
                    '$datedb', '$invoice', '$suplayer', '$suplayer_contact', '$keterangan',
                    '$list_id_produk', '$list_jumlah', '$list_hargasatuan',
                    '$jmldiskon', '$total_beli', '$total_tambah', '$total_transaksi', '$id_user'
                )";
            // insert or update
            $database_beli = mysqli_query( $dbconnect, $args_logistik );
            $id_beli = mysqli_insert_id($dbconnect);

            $args_transkas = "INSERT INTO transaction_kas (date,amount,type,category,cash,person,logistic) VALUES ('$datedb', '$total_transaksi','out','3','29','$suplayer','$id_beli')";
            $result_transkas = mysqli_query($dbconnect,$args_transkas);
            
        // JIKA PEMBELIAN EDIT
        } else { 
            $args = "UPDATE logistik SET
                tanggal='$datedb', invoice='$invoice', suplayer='$suplayer', contact='$suplayer_contact', keterangan='$keterangan',
                produk_id='$list_id_produk', jumlah='$list_jumlah', hargasatuan='$list_hargasatuan',
                total_diskon='$jmldiskon', total_beli='$total_beli', total_tambah='$total_tambah', total_transaksi='$total_transaksi', user_id='$id_user'
                WHERE id='$id_beli'";
            $database_beli = mysqli_query( $dbconnect, $args );

            $args_transkas = "UPDATE transaction_kas SET date='$datedb',amount='$total_transaksi',type='out',category='3',cash='29',person='$suplayer', logistic='$id_beli' WHERE logistic='$id_beli'";
            $result_transkas = mysqli_query($dbconnect,$args_transkas);
        
            // del Transaksi
            $args_trans = "SELECT id FROM trans_order WHERE id_pembelian='$id_beli'";
            $cari = mysqli_query( $dbconnect, $args_trans );
            while ( $trans = mysqli_fetch_array($cari) ) {
                $id = $trans['id'];
                $args_trans = "DELETE FROM trans_order WHERE id='$id'";
                $del_trans = mysqli_query( $dbconnect, $args_trans );
            }
        }

        // insert stok
        $desc_stok = "Pembelian ID ".$id_beli;
        $x = 0;
        $item_beli = array();
        $daftar_id = array();
        while($x <= $jumlah_item) {
            if ( $array_jumlah[$x] > 0 ) {
                $id_produk= $array_id_produk[$x];
                $total_jml_item = $array_jumlah[$x];
                $harga_peritem = $array_hargasatuan[$x];
                
                $args = "INSERT INTO trans_order ( id_pembelian, id_produk, jumlah, harga, type, date, deskripsi )
                VALUES ( '$id_beli', '$id_produk', '$total_jml_item', '$harga_peritem', 'in', '$datedb', '$desc_stok' )";
                $database_trans_order = mysqli_query( $dbconnect, $args );
            }
            $x++;
        }
        // RESULT
        if ( $database_beli && $result_transkas ) { echo 'berhasil'; }
        else { echo 'gagal'; }
}

if ( isset($_POST['del_beli']) && $_POST['del_beli']==GLOBAL_FORM ) {	
	$id_beli = secure_string($_POST['id_beli']);
    
    // data Transaksi Order
	$args_order = "DELETE FROM trans_order WHERE id_pembelian='$id_beli'";
	$del_order = mysqli_query( $dbconnect, $args_order );
    
    // data Logistik
	$args_logistik = "DELETE FROM logistik WHERE id='$id_beli'";
	$del_logistik = mysqli_query( $dbconnect, $args_logistik );

    // RESULT
    if ( $del_order && $del_logistik ) { echo 'berhasil'; }
    else { echo 'gagal'; }
}

if ( isset($_POST['find_dataprod']) && $_POST['find_dataprod']==GLOBAL_FORM){
    $getBarcode = secure_string($_POST['barcode']);

    $args = "SELECT * FROM produk WHERE barcode='$getBarcode'";
    $result = mysqli_query( $dbconnect, $args);
    if( $getItem = mysqli_fetch_array($result) ){
        echo "berhasil###".$getItem['id']."###".$getItem['title']."###".$getItem['image'];
    }else{ echo "gagal"; }
}

if ( isset($_POST['find_hargajual']) && $_POST['find_hargajual']==GLOBAL_FORM){
    $list_idprodvarian = secure_string($_POST['list_idprodvarian']);
    $list_jumlah = secure_string($_POST['list_jumlah']);
    $totaljumlah = secure_string($_POST['totaljumlah']);

    $args = "SELECT * FROM produk WHERE id='$list_idprodvarian'";
    $result = mysqli_query( $dbconnect, $args);

    $x = 0;
    $list_newharga = array();
    if( mysqli_num_rows($result) ){
         $getItem = mysqli_fetch_array($result);
            //$get_harga = $getItem['harga'];
            $get_id = $getItem['id'];
            $cek_promo = $getItem['promo'];
            
            $number = 0;
            $args_cekgrosir = "SELECT * FROM daftar_grosir WHERE id_produk='$list_idprodvarian'";
            $result_cekgrosir = mysqli_query($dbconnect,$args_cekgrosir);
            if( $rows = mysqli_num_rows($result_cekgrosir) ){
                
                $fetch_grosir = mysqli_fetch_array($result_cekgrosir);
                $data_qtymin = $fetch_grosir['qty_from'];
                //$data_qtymax = $fetch_grosir['qty_to'];
                $data_hargasatuan = $fetch_grosir['harga_satuan'];

                //Explode
                $exp_qtymin =  explode('|', $data_qtymin);
                //$exp_qtymax =  explode('|', $data_qtymax);
                $exp_hargasatuan = explode('|', $data_hargasatuan);
                        
                //$count = count($exp_qtymin)-1;

                if( $list_jumlah < $exp_qtymin[0] ){
                    if( $cek_promo == '1'){
                        $harga = $getItem['harga_promo'];
                    }else{
                        $harga = $getItem['harga'];
                    }
                    //$harga = $getItem['harga'];
                }else{
                    for ( $i = 0; $i < count($exp_qtymin); $i++ ) 
                        if ( $list_jumlah < $exp_qtymin[$i] ) break;
                            $col = $i-1;
                            $harga = $exp_hargasatuan[$col];
                }
                        
                       /*while( $number < $count ){
                            if( $exp_qtymax[$number] == '0' ){
                                $new_max[$number] =  '';
                            }else{
                                $new_max[$number] = $exp_qtymax[$number];
                            }

                            if( $list_jumlah >= $exp_qtymin[$number] && $list_jumlah < $new_max[$number] ){
                                $data_grosir = $exp_hargasatuan[$number];
                            }else{
                                $data_grosir = $getItem['harga'];
                            }
                            $result_data = $data_grosir;
                            $number++;
                        }*/
                $getdata_grosir = $harga;
                //}
            }else{
                if( $cek_promo == '1'){
                    $getdata_grosir = $getItem['harga_promo'];
                }else{
                    $getdata_grosir = $getItem['harga'];
                }
            }

            $subtotal = $list_jumlah * $getdata_grosir;
            $list_newharga[] = $getItem['barcode']."!!!".uang_grosir($getdata_grosir)."!!!".uang($getdata_grosir)."!!!".$subtotal."!!!".uang($subtotal);
        $listresult = join("###", $list_newharga);
        echo "berhasil###".$listresult;
    } else { echo "gagal"; }
}

if ( isset($_POST['save_penjualan']) && $_POST['save_penjualan']==GLOBAL_FORM){
    $idjual = secure_string($_POST['idjual']);
    $tanggal =  secure_string($_POST['tanggal']);
    $jam = secure_string($_POST['jam']);
    $menit = secure_string($_POST['menit']);
    $member_person = secure_string($_POST['member_person']);
    $nama_person = secure_string($_POST['nama_konsumen']);
    $keterangan = secure_string($_POST['keterangan']);

    $list_barcode = secure_string($_POST['list_barcode']);
    $list_item_id = secure_string($_POST['list_idprodvarian']);
    $list_hargasatuan = secure_string($_POST['list_hargasatuan']);
    $list_jumlah = secure_string($_POST['list_jumlah']);
    $list_nameprodvarian = secure_string($_POST['list_nameprodvarian']);
    $list_imageprodvarian = secure_string($_POST['list_imageprodvarian']);
    $list_bayar = secure_string($_POST['list_bayar']);
    $list_bayar_2 = secure_string($_POST['list_bayar_2']);

    //$diskon_voucher = secure_string($_POST['diskon_voucher']);
    $jmldiskon_reseller = secure_string($_POST['jmldiskon_reseller']);
    $jmldiskon = secure_string($_POST['jmldiskon']);
    $total_bayar = secure_string($_POST['hargabayar']);
    $total_bayar_2 = secure_string($_POST['hargabayar_2']);
    //$status_user = secure_string($_POST['status_user']);
    //$test_harga = cek_hargagrosir($list_item_id,$list_jumlah,$list_hargasatuan);

    //loyalty discount member
    $use_discount          = secure_string($_POST['use_discount']);
    $jmlpersen_bonusdiskon = secure_string($_POST['jmlpersen_bonusdiskon']);
    $jmldiskon_bonus       = secure_string($_POST['jmldiskon_bonus']);
    $select_bonusdiskon    = secure_string($_POST['select_bonusdiskon']);

    // Pembelian Item
    $array_get_id = explode('|',$list_item_id);
    $array_get_jumlah = explode('|',$list_jumlah);
    $array_get_hargasatuan = explode('|',$list_hargasatuan);

    $jumlah_getitem = count($array_get_id) - 1;
    $arraynew_id = array(); 
    $arraynew_jumlah = array(); 
    $arraynew_get_hargasatuan = array();
    $a = 0;
    while($a <= $jumlah_getitem) {
        if($array_get_id[$a] !== '' && $array_get_id[$a] !== '0'){
            $arraynew_id[] = $array_get_id[$a];
            $arraynew_jumlah[] = $array_get_jumlah[$a];
            $arraynew_get_hargasatuan[] = $array_get_hargasatuan[$a];
        } 
        $a++;
    }

    $list_id_produk_join = join("|",$arraynew_id);
    $list_jumlah_join = join("|",$arraynew_jumlah);
    $list_hargasatuan_join = join("|",$arraynew_get_hargasatuan);

    $array_id_produk = explode('|',$list_id_produk_join);
    $array_jumlah = explode('|',$list_jumlah_join);
    $array_hargasatuan = explode('|',$list_hargasatuan_join);

    //coba
   //$exp_hargaprod = explode('|', $test_harga);

    // total Pembelian = $total_beli
    $jumlah_item = count($array_id_produk) - 1;
    $x = 0;
    $total_beli = 0;
    while($x <= $jumlah_item) {
        $pembelian_item = $array_jumlah[$x] * $array_hargasatuan[$x];
        $total_beli = $total_beli + $pembelian_item;
        $x++;
    }

    //get namaprod
    //total transaksi
    //$total_tambah = 0;
    //$jmldiskon = 0;
    $total_transaksi = $total_beli - ( $jmldiskon + $jmldiskon_reseller + $jmldiskon_bonus );

    $datedb = strtotime($tanggal." ".$jam.":".$menit);
    $month = date('n',$datedb);
    $year = date('Y',$datedb);

    $get_telpuser = querydata_usermember($member_person,'telp');
    $name_paylist = payment_name($list_bayar);
    $name_paylist_2 = payment_name($list_bayar_2);

    /*$cek_akunuser = querydata_user($member_person,'id');
    if($cek_akunuser == '0'){
        $nama_userbaru =  $nama_person;
    }else{
        $nama_userbaru =  '';
    }*/
    //$get_namaprod = get_nameprod($list_item_id);
    //$get_barcode = querydata_prod($list_item_id,'barcode');
    $inpart = secure_string($_POST['inpart']);
    if($inpart == 1){
        $value_inpart = 'sebagian';
    }else{
        $value_inpart = 'nonsaldo';
    }
    if( !empty($total_bayar) && !empty($total_bayar_2) ){
        $juml_bayar = $total_bayar."|".$total_bayar_2;
        $sum_bayar  = $total_bayar+$total_bayar_2;
    }else{
        $juml_bayar = $total_bayar;
        $sum_bayar  = $total_bayar;
    }


    if ( $idjual == 0 || $idjual == '' ){
        $args = "INSERT INTO pesanan( id_user, nama_user, telp, catatan, idproduk, nama_produk, gambar_produk, jml_diskon, diskon_reseller, diskon_member, barcode, jml_order, harga_item, sub_total, total, pembayaran_tunai, pembayaran_tunai_2, waktu_pesan, metode_bayar, tipe_bayar, tipe_bayar_2, status_kasir ) 
        VALUES ( '$member_person', '$nama_person', '$get_telpuser', '$keterangan', '$list_item_id', '$list_nameprodvarian', '$list_imageprodvarian', '$jmldiskon', '$jmldiskon_reseller', '$jmldiskon_bonus', '$list_barcode', '$list_jumlah', '$list_hargasatuan', '$total_beli', '$total_transaksi', '$total_bayar', '$total_bayar_2', '$datedb',  '$value_inpart', '$name_paylist', '$name_paylist_2', '1')";
        $result = mysqli_query( $dbconnect, $args);
        $get_lastid = mysqli_insert_id($dbconnect);

        //$purchase_prizes = querydata_dataoption('purchase_prizes');
        if( $use_discount > 0 ){
           $args_claim = "UPDATE claim_reward SET status_reward='1', date_usediscount='$datedb' WHERE id='$select_bonusdiskon'";
           $result_claim = mysqli_query($dbconnect,$args_claim);
        }

        if( $member_person !== '0' && $member_person !== '' ){
            $args_reward = "INSERT INTO counter_reward ( date, id_pesanan, id_user, amount ) VALUES ( '$datedb', '$get_lastid', '$member_person', '$total_transaksi' )";
            $result_reward = mysqli_query($dbconnect,$args_reward);
            /*$now = strtotime('now');
            //$nowplus = strtotime("-1 months",$now);
            $user_reward = data_reward($member_person,'id_user');
            if( mysqli_num_rows($user_reward) <= 0 ){
                $args_reward = "INSERT INTO counter_reward ( date, id_pesanan, id_user, amount ) VALUES ( '$datedb', '$get_lastid', '$member_person', '$total_transaksi' )";
                $result_reward = mysqli_query($dbconnect,$args_reward);
            }else{
                $fetch_userreward = mysqli_fetch_array($user_reward);
                $date_userreward  = $fetch_userreward['date'];
                $day   = date('d',$date_userreward);
                $month = date('m');
                $year  = date('Y');
                $hour  = date('H');
                $minute = date('i');
                $from = $day."-".$month."-".$year.",".$hour.":".$minute;
                $to   = $day."-".$month."-".$year.",".$hour.":".$minute;
                $min_month = strtotime($from);
                $time_from = strtotime("-1 months",$min_month);
                $time_to   = strtotime($to);
                $nowplus   = strtotime("+1 months",$time_to);

                //if( $date_userreward >= $time_from && $date_userreward < $time_to ){
                    $total = query_reward($member_person,'id_user',$time_from,$time_to);
                    if($total !== '0'){
                        if($total >= 1000000 && $total <= 1999999){
                            $discount = 5;
                            $amount   = $total/100*$discount;
                        }else if($total >= 2000000 && $total <= 4999999){
                            $discount = 7.5;
                            $amount   = $total/100*$discount;
                        }else if($total >= 5000000 && $total <= 24999999){
                            $discount = 10;
                            $amount   = $total/100*$discount;
                        }else if($total >= 25000000){
                            $discount = 30;
                            $amount   = $total/100*$discount;
                        }else{
                            $discount = 0;
                            $amount   = 0;
                        }

                        if( $discount !== '0' ){
                            $data_claim = claim_reward($member_person,$time_from,$time_to);
                            if( mysqli_num_rows($data_claim) <=0 ){
                                $args_claim = "INSERT INTO claim_reward ( date, date_expired, id_user, amount, pick_discount ) VALUES ( '$time_to', '$nowplus', '$member_person', '$amount', '$discount' )";
                                $result_claim = mysqli_query($dbconnect,$args_claim);
                            }
                        }
                    }
                //}else{
                $args_reward = "INSERT INTO counter_reward ( date, id_pesanan, id_user, amount ) VALUES ( '$datedb', '$get_lastid', '$member_person', '$total_transaksi' )";
                $result_reward = mysqli_query($dbconnect,$args_reward);
                //}
            }*/
        }

        //if( $member_person !== '0' && $member_person !== '' ){
            //reward($get_lastid,$member_person,$datedb,$total_transaksi,$use_discount,$select_bonusdiskon);//1574998079
       // }

        $type_kas = 'in';
        $cashbook = '28';
        $jualbeli_cat = '1';
        $exp_jmlbayar = explode("|", $juml_bayar);
        $count_jmlbayar = count($exp_jmlbayar)-1;
        $inout = get_type_cat($jualbeli_cat);
        $insTo_transactionkas = "INSERT INTO transaction_kas (date, amount, type, category, cash, person, pesanan) VALUES";
        for( $x=0; $x <= $count_jmlbayar; $x++ ){
            $insTo_transactionkas .= "('$datedb', '$exp_jmlbayar[$x]', '$inout', '$jualbeli_cat','$cashbook', '$member_person', '$get_lastid'), ";
        }
        $insTo_transactionkas = rtrim($insTo_transactionkas, ', ');
        $result_transkas = mysqli_query($dbconnect,$insTo_transactionkas);
        $updatebalance = balance_cat($month,$year,$jualbeli_cat,$cashbook);

        $inout_disc = get_type_cat('4');
        $in_transkas = "INSERT INTO  transaction_kas (date, amount, type, category, cash, person, pesanan) VALUES";
        if( $jmldiskon > 0 ){
            $in_transkas .= "('$datedb','$jmldiskon','$inout_disc','4','28','$member_person', '$get_lastid'), ";
            $updatebalance_disc = balance_cat($month,$year,'4','28');
        }
        if( $jmldiskon_reseller > 0 ){
            $in_transkas .= "('$datedb','$jmldiskon_reseller','$inout_disc','4','28','$member_person', '$get_lastid'), ";
            $updatebalance_disc = balance_cat($month,$year,'4','28');
        }
        if( $jmldiskon_bonus > 0 ){
            $in_transkas .= "('$datedb','$jmldiskon_bonus','$inout_disc','4','28','$member_person', '$get_lastid'), ";
            $updatebalance_disc = balance_cat($month,$year,'4','28');
        }
        $in_transkas = rtrim($in_transkas, ', ');
        $result_trans = mysqli_query($dbconnect,$in_transkas);  

        $y = 0;
        $insTo_transorder = "INSERT INTO trans_order ( id_pesanan, id_produk, id_penjualan, jumlah, harga, status_jual, type, date, deskripsi) VALUES ";
        while ($y <= $jumlah_item) {
            $idprod_transorder = $array_get_id[$y];
            $jmlprod_transorder = $array_get_jumlah[$y];
            $hargaprod_transorder = $array_get_hargasatuan[$y];
            $type_transorder = 'out';
            $insTo_transorder .= "( '$get_lastid', '$idprod_transorder', '$get_lastid', '$jmlprod_transorder', '$hargaprod_transorder', '1', '$type_transorder', '$datedb', 'Penjualan via kasir'), ";
            productstock_update($idprod_transorder,'3');
            $y++; 
        }
        $insTo_transorder = rtrim($insTo_transorder, ', ');
        $result_order = mysqli_query($dbconnect,$insTo_transorder);

         /* //Cek produk termasuk parcel 
            $kodeparcel = cek_parcel($idprod_transorder);
            if( $kodeparcel == '1' ){
                    $args_prodparcel = "SELECT * FROM produk_item WHERE  id_prod_master = '$idprod_transorder'";
                    $result_prodparcel = mysqli_query($dbconnect,$args_prodparcel);
                    $arraycek_prodparcel = mysqli_fetch_array($result_prodparcel);

                    $idprod_parcel = $arraycek_prodparcel['id_prod_item'];
                    $jmlprod_parcel = $arraycek_prodparcel['jumlah_prod'];

                    $idprod_parcel_explode = explode('|', $idprod_parcel);
                    $jmlprod_parcel_explode = explode('|', $jmlprod_parcel);
                    $num_prodparce = count($idprod_parcel_explode)-1;
                    $z = 0;
                    while ($z <= $num_prodparce) {
                        $get_idprodparcel = $idprod_parcel_explode[$z];
                        $get_jmlprodparcel = $jmlprod_parcel_explode[$z];
                        $type_transorder = 'out';

                        $parcelTo_transorder = "INSERT INTO trans_order ( id_pesanan, id_produk, id_penjualan, jumlah, harga, status_jual, type, date, deskripsi) VALUES ( '$get_lastid', '$get_idprodparcel', '$get_lastid', '$get_jmlprodparcel', '$hargaprod_transorder', '1', '$type_transorder', '$datedb', 'Pembayaran Parcel via kasir')";
                        $resultparcel_transorder = mysqli_query($dbconnect,$parcelTo_transorder);
                        $z++;
                    }
            }
            //if($result){
               
            //}else{}*/
    }
    if( $result && $result_transkas && $result_order ){ echo 'berhasil'; }else{ echo 'Batal'; }
}

if( isset($_POST['save_inputcicil']) && $_POST['save_inputcicil']==GLOBAL_FORM ){
    $tanggal = secure_string($_POST['date']);
    $jam = secure_string($_POST['hour']);
    $menit = secure_string($_POST['minute']);
    $bayar_cicilan = secure_string($_POST['bayar_cicilan']);
    //$payment_to = secure_string($_POST['payment_to']);
    $pesanan_id = secure_string($_POST['pesanan_id']);
    $id_user_cicil = secure_string($_POST['id_user_cicil']);
    $total_amount = secure_string($_POST['total_amount']);
    $cicilan_id = secure_string($_POST['cicilan_id']);
    $dp_amount_user = secure_string($_POST['dp_amount_user']);
    $remaining_payment = secure_string($_POST['remaining_payment']);

    $catkaspm  = secure_string($_POST['catkaspm']);
    $cash_book = secure_string($_POST['cash_book']);
    $pmcash_category  = secure_string($_POST['pmcash_category']);

    $remaining = $remaining_payment-$bayar_cicilan;
    $datedb = strtotime($tanggal." ".$jam.":".$menit);
    $month = date('n',$datedb);
    $year = date('Y',$datedb);

    if($remaining == 0) {
        $status=1;
    }else{
        $status=0;
    }

    //if( 0 == $cicilan_id ){
    $args = "INSERT INTO log_kredit ( id_user, id_pesanan, date, total_harga_pesanan, nominal_pembayaran, sisa, status, list_cicilan ) VALUES ('$id_user_cicil', '$pesanan_id', '$datedb', '$total_amount', '$bayar_cicilan', '$remaining', '$status', '$payment_to')";
    //}else{
       // $args = "UPDATE log_kredit SET date='$datedb', nominal_pembayaran='$bayar_cicilan', sisa='$remaining', status='$status', list_cicilan='$payment_to' WHERE id='$cicilan_id'";
    //}
    $result = mysqli_query($dbconnect,$args);
    $id_kredit = mysqli_insert_id($dbconnect);

    // insert cash
    if ( '1' == $catkaspm ) {
        $inout = get_type_cat($pmcash_category);
        $argskas = "INSERT INTO transaction_kas ( date, amount, type, category, cash, person, penjualan, cicilan ) VALUES ( '$datedb', '$bayar_cicilan', '$inout', '$pmcash_category', '$cash_book', '$id_user_cicil', '$pesanan_id', '$id_kredit' )";
        $insertkas = mysqli_query( $dbconnect, $argskas );
        $updatebalance = balance_cat($month,$year,$pmcash_category,$cash_book);
    } else {
        $insertkas = true;
        $updatebalance = true;
    }

    if( $result && $insertkas && $updatebalance ){ echo "berhasil"; }else{ echo "gagal"; }
}

if( isset($_POST['save_trans_stock']) && $_POST['save_trans_stock']==GLOBAL_FORM ){
    $aktivitas = secure_string($_POST['aktivitas']);
    $trans_from = secure_string($_POST['trans_from']);
    $trans_to = secure_string($_POST['trans_to']);
    $keterangan = secure_string($_POST['keterangan']);
    $tanggal = secure_string($_POST['tanggal']);
    $jam = secure_string($_POST['jam']);
    $menit = secure_string($_POST['menit']);
    $date = strtotime($tanggal.' '.$jam.':'.$menit);
    $datenow = strtotime('now');

    $list_stok_idprodvarian = secure_string($_POST['list_stok_idprodvarian']);
    $list_stok_jumlah = secure_string($_POST['list_stok_jumlah']);
    $list_stok_hargaprod = secure_string($_POST['list_stok_hargaprod']);

    $array_stok_idprodvarian = explode('|', $list_stok_idprodvarian);
    $array_stok_jumlah = explode('|', $list_stok_jumlah);
    $array_stok_hargaprod = explode('|', $list_stok_hargaprod);

    $jumlah_stok_idprodvarian = count($array_stok_idprodvarian) - 1;

    $x=0;
    $value_array = array();
    $array_product = array();

    if($trans_to !== '0'){ $array_product_to = array(); }
    while ($x <= $jumlah_stok_idprodvarian) {
        $id_produk  = $array_stok_idprodvarian[$x];
        $jumlah = $array_stok_jumlah[$x];
        $harga = $array_stok_hargaprod[$x];

        $value_array[] = "( '$id_produk', '$jumlah', '$harga', '0', '$aktivitas', '$trans_from', '$trans_to', '$date', '$keterangan' )";
        $array_product[] = array("id_produk" => $id_produk, "select_trans" => $trans_from);
        if($trans_to !== '0'){ $array_product_to[] = array("id_produk" => $id_produk, "select_trans" => $trans_to); }
        $x++;
    }
    $list_value_array = join(",", $value_array);
    $args = "INSERT INTO trans_order (id_produk,jumlah, harga, status_jual, type, trans_from, trans_to, date, deskripsi) VALUES $list_value_array";
    $save = mysqli_query($dbconnect,$args);

    //Update Stock Product
    foreach ($array_product as $row) {
        $id_produk = $row['id_produk'];
        $select_trans = $row['select_trans'];
        $update_stock = productstock_update($id_produk,$select_trans);
    }
    if($trans_to !== '0'){
        foreach ($array_product_to as $row) {
        $id_produk = $row['id_produk'];
        $select_trans = $row['select_trans'];
        $update_stock = productstock_update($id_produk,$select_trans);
        }
    }

    if ( $save ) { echo "berhasil"; } else { echo "gagal"; }
}

/*if ( isset($_POST['check_voucher']) && $_POST['check_voucher']==GLOBAL_FORM ) {
    $diskon_voucher = strtoupper(secure_string($_POST['diskon_voucher']));
    
    $args = "SELECT * FROM data_voucher WHERE kode='$diskon_voucher' AND active='1'";
    $result = mysqli_query( $dbconnect, $args );
    if ( mysqli_num_rows($result) ) {
        $item = mysqli_fetch_array($result);
        echo "berhasil###".$item ['nominal'];
    } else { echo "gagal"; }
}*/
?>