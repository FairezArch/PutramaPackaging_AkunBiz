<?php include "../mesin/function.php";
if( is_admin() ) {
//if ( isset($_POST['print_order']) && $_POST['print_order']==GLOBAL_FORM ) {
    
$idkredit = secure_string($_GET['idtrans_cicilan']);
$data_kredit = query_cicilan($idkredit);

$data_pesan = querydata_cicilan($idkredit,'id_pesanan');
$data_user = querydata_pesanan($data_pesan,'id_user');
$total_bayar = querydata_pesanan($data_pesan,'total');
$dp_bayar = querydata_pesanan($data_pesan,'pembayaran_tunai');
$name_user = querydata_pesanan($data_pesan,'nama_user');
$waktu_cicilan = querydata_cicilan($idkredit,'date');

$hitung_dp = querydata_pesanan($data_pesan,'pembayaran_tunai');
$bayar = $data_kredit['nominal_pembayaran'];
$total_kredit = $data_kredit['sisa'];
 if( 0 == $data_kredit['status'] ){
    $status = 'Hutang/Cicil';
 }else{
    $status = 'Lunas';
 }
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
                <td style="width:6mm">ID Cicilan</td>
                <td> : </td>
                <td><?php echo $idkredit; ?></td>
            </tr>
            <tr>
                <td style="width:6mm">ID Pesan</td>
                <td> : </td>
                <td><?php echo $data_pesan; ?></td>
            </tr>
            <tr>
                <td>Member</td>
                <td> : </td>
                <td><span class="namacust"><?php echo $name_user; ?></span></td>
            </tr>
            <tr>
                <td>Waktu Bayar</td>
                <td> : </td>
                <td><?php echo date('j M Y, H.i', $waktu_cicilan); ?></td>
            </tr>
        </table>
		<div class="clear"></div>
    </div>
    

    <span class="top">===================================================</span>
    <div class="totalorder">
        <table class="stdtable">
            <tr>
                <td>Nominal Pesanan</td>
				<td>&nbsp;</td>
                <td class="right"><?php echo uang($total_bayar); ?></td>
            </tr>
            <tr>
                <td colspan="2">DP Pembayaran</td>
                <td class="right"><?php echo uang($dp_bayar); ?></td>
            </tr>
            <tr>
                <td colspan="2">Pembayaran ke-<?php echo $data_kredit['list_cicilan'];?></td>
                <td class="right"><?php echo uang($data_kredit['nominal_pembayaran']); ?></td>
            </tr>
            <tr>
                <td colspan="2">Sisa Cicilan</td>
                <td class="right"><?php echo uang($total_kredit);?></td>
            </tr>
            <tr>
                <td colspan="2">Status</td>
                <td class="right"><?php echo $status;?></td>
            </tr>
        </table>
    </div>
    <span class="bottom">===================================================</span>
    <div class="thanks">
        <div class="center">Terima kasih <?php echo $name_user; ?>!<br></div>
    </div>
</div>  
</body>
</html>
<?php } ?>
