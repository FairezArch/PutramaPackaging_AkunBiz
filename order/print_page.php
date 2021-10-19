<?php include "../mesin/function.php";
if( is_admin() || is_ho() || is_checker() ) {
//if ( isset($_POST['print_order']) && $_POST['print_order']==GLOBAL_FORM ) {
    
$idorder = secure_string($_GET['idorder']);
$order = query_pesanan($idorder);

$nama_cust = strtoupper(querydata_user($order['id_user'],'nama'));
$telp_cust = $order['telp'];
$subtotal_harga = uang(querydata_pesanan($idorder,'sub_total'));
$diskon = uang(querydata_pesanan($idorder,'diskon'));
$totalharga = uang(querydata_pesanan($idorder,'total'));
$date_pesan = date('d M Y, H.i', $order['waktu_pesan']);
$date_kirim = date('d M Y, H.i', $order['waktu_kirim']);
$alamat_kirim = ucwords(strtolower(alamat_cust_pesanan($order['alamat_kirim'])));

$list_order = querydata_pesanan($idorder,'idproduk');
$list_jml = querydata_pesanan($idorder,'jml_order');
$list_harga = querydata_pesanan($idorder,'harga_item');
$list_promo_peritem = querydata_pesanan($idorder,'hargadiskon_item');
$list_ongkir = querydata_pesanan($idorder,'ongkos_kirim');
$list_total = querydata_pesanan($idorder,'total');

$array_promo_peritem = explode('|',$list_promo_peritem);
$array_order = explode('|',$list_order);
$array_jml = explode('|',$list_jml);
$array_harga = explode('|',$list_harga);

$list_saldosebagian = saldo_sebagian($idorder);
$cek_saldo = $list_saldosebagian['nominal'];

?>

<html>
<head>
<style>
    @font-face {
        font-family: dotmatri;
        src: url(../penampakan/font/DOTMATRI.TTF);
    }
    body { font-family: sans-serif; font-size: 10pt; width:76mm;}
	/*
	    body { font-family: dotmatri; font-size: 12pt; width:76mm;}
	    body { font-family: monospace; font-size: 9pt; width:76mm;}
	 */
	.wrap { padding-bottom:7mm; overflow: hidden; padding-left:4mm; padding-right:4mm; }
    .center { text-align: center; }
    .right { text-align: right; }
    .stdtable{ font-size: 9pt; width: 100%; margin: 0 auto;}
    .itemorder .stdtable{ font-size: 8pt; }
    span.top { display: block; margin-top:7px; overflow: hidden;}
    span.middle{ display: block; overflow: hidden;}
    span.bottom { display: block; margin-bottom:7px; overflow: hidden;}
    span.namacust { display:inline-block; width:140px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;}
    .ver-top { vertical-align: top; }
</style>
</head>
<body onload="window.print()">
<div class="wrap">   
    <div class="center">
        IDEASMART<br>
        Jl. Kusuma Negara 64 - 66, Warungboto<br>
        Umbulharjo, Yogyakarta<br>
        Hotline:  0823 2830 9900<br>
        Telp:  (0274) 389 304<br>
    </div>
    <span class="top">===================================================</span>
    <div class="dataorder">
        <table class="stdtable">
            <tr>
                <td style="width:100px">ID Order</td>
                <td> : </td>
                <td><?php echo $idorder; ?></td>
            </tr>
            <tr>
                <td>Nama Customer</td>
                <td> : </td>
                <td><span class="namacust"><?php echo $nama_cust; ?></span></td>
            </tr>
            <tr>
                <td>Waktu Pesan</td>
                <td> : </td>
                <td><?php echo $date_pesan; ?></td>
            </tr>
            <tr>
                <td>Waktu Pengiriman</td>
                <td> : </td>
                <td><?php echo $date_kirim; ?></td>
            </tr>
            <tr>
                <td class="ver-top">Alamat</td>
                <td class="ver-top"> : </td>
                <td><?php echo $alamat_kirim; ?></td>
            </tr>
        </table>
    </div>
    <span class="bottom">===================================================</span>
    <div class="itemorder">
        <table class="stdtable">
    <?php     
        $jumlah_item = count($array_order) - 1;
        $x = 0;
        $no = 1;
        $c_item = array();
        $total_harga_item = 0;
         $hasil = 0;
        while($x <= $jumlah_item) {
            $harga_item = $array_harga[$x];
            $total_harga_item = $harga_item * $array_jml[$x];
            $namaprod = strtoupper(querydata_prod($array_order[$x],'short_title'));
            $jml = $array_jml[$x];
            $harga = uang($array_harga[$x]);
            $sub_total = uang($total_harga_item);
            $c_item[] = $jml;
            $promo_item = $array_promo_peritem[$x];
            $total_diskon =  $harga_item - $promo_item;
            $total_bayar = $harga_item-$total_diskon;
            $jml_Andahemat = $harga_item * $array_jml[$x];
            $hasil += $jml_Andahemat;
            $ket_Andahemat = $hasil + $list_ongkir - $list_total;
            $jumlah_harga = $list_total - $cek_saldo;
    ?>        
        <tr>
            <td colspan=2><?php echo $namaprod; ?></td>
        </tr>
        <tr>
            <td><?php echo $jml; ?> X <?php echo $harga; ?></td>
            <td class="right" style="width:102px; white-space: nowrap;">
                <?php if( $promo_item == '0'){ echo uang( $total_harga_item ); }else{ $dengan_diskon = $total_bayar*$array_jml[$x]; echo uang( $dengan_diskon ); } ?>
            </td>
        </tr>
        <tr>
            <td><?php if( $promo_item == '0'){ echo " "; }else{ echo "(Diskon : ".uang($total_diskon).")"; }?></td>
        </tr>
    <?php
            $x++;
            $no++;
        }
    ?>
    </table>
    </div>
    <?php $jmlitem = array_sum($c_item); ?>
    <span class="top">===================================================</span>
    <div class="totalorder">
        <table class="stdtable">
            <tr>
                <td>SUBTOTAL</td>
                <td><?php echo $jmlitem; ?> Item</td>
                <td class="right"><?php echo uang( querydata_pesanan($idorder,'sub_total') ); ?></td>
            </tr>
            <?php if( $ket_Andahemat == '0' || $ket_Andahemat == ''){ echo " "; }else{?>
            <tr>
                <td>Diskon</td>
                <td colspan="1">&nbsp;</td>
                <td class="right"><?php echo uang($ket_Andahemat);?></td>
            </tr>
            <?php }?>
            <tr>
                <td>Biaya Kirim</td>
                <td colspan="1">&nbsp;</td>
                <td class="right"><?php echo uang(querydata_pesanan($idorder,'ongkos_kirim'));?></td>
            </tr>
            
        </table>
    </div>
    <span class="middle">===================================================</span>
    <div class="totalorder">
        <table class="stdtable">
            <?php if( $list_saldosebagian = saldo_sebagian($idorder) && querydata_pesanan($idorder,'metode_bayar') == 'sebagian' ){ ?>
                <tr> 
                    <td>Penggunaan Saldo</td>
                    <td colspan="1">&nbsp;</td>
                    <td class="right"><?php echo uang( $cek_saldo );?></td>
                </tr>
                <tr>
                    <td><strong>TOTAL</strong></td>
                    <td colspan="1">&nbsp;</td>
                    <td class="right">
                        <?php 
                            echo "<strong>".uang($jumlah_harga)."</strong>"; 
                        ?>
                    </td>
                </tr>
            <?php }else{ ?>
                <tr>
                    <td><strong>TOTAL</strong></td>
                    <td colspan="1">&nbsp;</td>
                    <td class="right">
                        <?php echo "<strong>".uang(querydata_pesanan($idorder,'total'))."</strong>";?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <span class="bottom">===================================================</span>
    <div class="thanks">
        <div class="center">Terima kasih</div>
    </div>
</div>  
</body>
</html>
<?php } ?>
