<?php include "../mesin/function.php";
if( is_admin() ) {
//if ( isset($_POST['print_order']) && $_POST['print_order']==GLOBAL_FORM ) {
    
$idorder = secure_string($_GET['idtrans']);
$order = query_pesanan($idorder);

$telpUser = $order['telp'];
$date_pesan = date('d M Y, H.i', $order['waktu_pesan']);


//Admin Kasir
$getKasir = current_user_id(); 
$getName = querydata_user($getKasir,'nama');

//Get user
$getUser = querydata_pesanan($idorder,'nama_user');

//Get item product
$list_order = querydata_pesanan($idorder,'idproduk');
$list_nameprod = querydata_pesanan($idorder,'nama_produk');
$list_barcode = querydata_pesanan($idorder,'barcode');
$list_jml = querydata_pesanan($idorder,'jml_order');
$list_harga = querydata_pesanan($idorder,'harga_item');

$list_diskon = querydata_pesanan($idorder,'jml_diskon');
$list_reseller = querydata_pesanan($idorder,'diskon_reseller');
$list_diskonmember = querydata_pesanan($idorder,'diskon_member');
$all_diskon = $list_diskon+$list_reseller+$list_diskonmember;
$subtotal_harga = uang(querydata_pesanan($idorder,'sub_total'));
$totalharga = querydata_pesanan($idorder,'total');
//$pembayaran_tunai = querydata_pesanan($idorder,'pembayaran_tunai');
$tipe_bayar = querydata_pesanan($idorder,'tipe_bayar');
$tipe_bayar_2 = querydata_pesanan($idorder,'tipe_bayar_2');

$getExplode_order = explode('|', $list_order);
$getExplode_nameprod = explode('|', $list_nameprod);
$getExplode_barcode = explode('|', $list_barcode);
$getExplode_jmlorder = explode('|', $list_jml);
$getExplode_harga = explode('|', $list_harga);

// Daftar cicilan
$list_credit = cicilan_byidpesan($idorder);
$cek_metod = querydata_pesanan($idorder,'metode_bayar');

$pembayaran_tunai = querydata_pesanan($idorder,'pembayaran_tunai');
$pembayaran_tunai_2 = querydata_pesanan($idorder,'pembayaran_tunai_2');

$name_payment = search_data('list_pay','title_name','pay_name',$tipe_bayar);
$name_payment_2 = search_data('list_pay','title_name','pay_name',$tipe_bayar_2);
?>

<html>
<head>
<style>
    @font-face {
        font-family: dotmatri;
        src: url(../theme/font/DOTMATRI.TTF);
    }
    body { font-family: arial; font-size: 8pt; width:48mm; margin: 8px auto; }
	/*
	    body { font-family: dotmatri; font-size: 12pt; width:76mm;}
	    body { font-family: monospace; font-size: 9pt; width:76mm;}
	 */
	.wrap { padding-bottom:7mm; padding-right:3mm; overflow: hidden; }
    .center { text-align: center; }
    .right { text-align: right; }
    .stdtable{ font-size: 7pt; line-height: 10pt; width: 100%; margin: 0 auto;}
    .itemorder .stdtable{ font-size: 7pt; line-height: 10pt; }
    span.top { display: block; margin-top:7px; overflow: hidden;}
    span.bottom { display: block; margin-bottom:7px; overflow: hidden;}
    span.namacust { display:inline-block; width:135px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;}
    .ver-top { vertical-align: top; }
	.title { font-size: 11pt; margin: 5px auto; display: block; }
	.imglogo { text-align: center; margin: 0px auto 10px; display: block; max-width: 90%; height: auto; }
	.head { font-size: 7pt; line-height: 10pt; font-weight: bold; }
	.thanks { font-size: 7pt; line-height: 10pt; }
    .none { display: none; }
    .block { display: table-row; }
</style>
</head>
<body onload="window.print()">
<div class="wrap">   
    <div class="center head">
        <?php /* <div class="title"><?php echo get_option('user_company'); ?></div> */ ?>
		<img src="../penampakan/images/logo-putrama.png" class="imglogo">
        <?php echo get_dataoption('alamat'); ?><br>
        Telp: <?php echo get_dataoption('telepon_view'); ?><br>
    </div>
    <span class="top">===================================================</span>
    <div class="dataorder">
        <table class="stdtable">
            <tr>
                <td style="width:6mm">ID order</td>
                <td> : </td>
                <td><?php echo $idorder; ?></td>
            </tr>
            <tr>
                <td>Member</td>
                <td> : </td>
                <td><span class="namacust"><?php echo $getUser; ?></span></td>
            </tr>
            <tr>
                <td>Waktu</td>
                <td> : </td>
                <td><?php echo date('j F Y, H.i', $order['waktu_pesan']); ?></td>
            </tr>
			<tr>
                <td>Kasir</td>
                <td> : </td>
                <td><?php echo $getName; ?></td>
            </tr>
        </table>
		<div class="clear"></div>
    </div>
    <span class="bottom">===================================================</span>
    <div class="itemorder">
        <table class="stdtable">
		<?php
			$jml_item = count($getExplode_order);
			$x = 0; $y=1; $jumlah = 0; $total = 0;
			while($y <= $jml_item) {
			$subtotal = $getExplode_harga[$x] * $getExplode_jmlorder[$x]; 
            $namaprod = strtoupper(querydata_prod($getExplode_order[$x],'short_title'));
		?>        
  			<tr>
				<td colspan=2><?php echo $namaprod; ?></td>
			</tr>
			<tr>
				<td><?php echo $getExplode_jmlorder[$x]; ?> Pcs X <?php echo $getExplode_harga[$x]; ?></td>
				<td class="right" style="width:70px; white-space: nowrap;"><?php echo uang($subtotal,false); ?></td>
			</tr>
		<?php
			$total = $total + $subtotal;
			$jumlah = $jumlah + $getExplode_jmlorder[$x];
			$x++;
			$y++;
			}
		?>
		</table>
    </div>

    <span class="top">===================================================</span>
    <div class="totalorder">
        <table class="stdtable">
            <tr>
                <td>Sub Total</td>
				<td><?php echo $jumlah; ?> Pcs</td>
                <td class="right"><?php echo uang($total); ?></td>
            </tr>
            <tr>
                <td colspan="2">Discount (-)</td>
                <td class="right"><?php echo uang($all_diskon); ?></td>
            </tr>
            <tr>
                <td colspan="2">Total</td>
                <td class="right"><?php echo uang($totalharga); ?></td>
            </tr>
            <?php 
                if($cek_metod =='sebagian'){      
            ?>
            <tr>
                <td colspan="2"><?php echo $name_payment;?></td>
                <td class="right"><?php echo uang($pembayaran_tunai);?></td>
            </tr>
            <tr>
                <td colspan="2"><?php echo $name_payment_2;?></td>
                <td class="right"><?php echo uang($pembayaran_tunai_2);?></td>
            </tr>
            <?php }else{ ?>
            <tr>
                <td colspan="2"><?php echo $name_payment;?></td>
                <td class="right"><?php echo uang($pembayaran_tunai);?></td>
            </tr>
            <?php } ?>
            <?php 
                $retur = $pembayaran_tunai + $pembayaran_tunai_2 - $totalharga;

                if( ( $pembayaran_tunai + $pembayaran_tunai_2 ) < $totalharga){ 
                    $display= 'block';
                    $amount = uang('0');
                }else{
                    $display = 'display: none';
                   // $retur = $pembayaran_tunai + $pembayaran_tunai_2 - $totalharga;
                    //if($retur < 100){
                      //  $data = $retur.".00";
                  //  }else{
                    //     $data = $retur;
                   // }
                    $amount = uang($retur);
                }
            ?>
            <tr class="<?php echo $display;?>">
                <td colspan="2">Kekurangan</td>
                <td class="right"><?php echo uang($retur);?></td>
            </tr>
            <tr>
                <td colspan="2">Kembalian</td>
                <td class="right"><?php echo $amount;?></td>
            </tr>
        </table>
    </div>
    <span class="bottom">===================================================</span>
    <div class="thanks">
        <div class="center">Terima kasih <?php echo $getUser; ?>!<br>
		
		</div>
    </div>
</div>  
</body>
</html>
<?php } ?>
