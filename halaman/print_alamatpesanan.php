<?php include "../mesin/function.php";
if( is_admin() ) {
$idorder = secure_string($_GET['idpesan']);
$order = query_pesanan($idorder);
$list_id = $order['id'];
$telpUser = $order['telp'];
$alamatuser = ucwords(strtolower(alamat_customer_pesanan($order['alamat_kirim'])));
//Get user
$getUser = querydata_user($order['id_user'],'nama');
//$jeniskurir = strtoupper(split_status_order($order['layanan_pengiriman'],'0'));
$tipekurir = split_status_order($order['layanan_pengiriman'],'1').'('.strtoupper(split_status_order($order['layanan_pengiriman'],'0')).')';
?>
<html>
<head>
    <style>
        @font-face {
        font-family: dotmatri;
        src: url(../theme/font/DOTMATRI.TTF);
    }
    body { font-family: arial; font-size: 8pt; width:110mm;  margin: 8px auto; }
    .adminarea{height: auto;border: 4px groove #c3c3c3;}
    .dataorder{display: inline-block; width: 100%; margin: 7px 0px;}
    .reportleft{ float: left; width:68%;}
    .reportright{ float: right; width:30%;}
    .rightctn{ float: right;}
    .rightinfo{margin: 5px 10px;max-width: 100%;}
    .stdtable{ font-size: 7pt; line-height: 10pt; width: 90%; margin: 0 auto;}
    .clear {clear:both;}
    .imglogo { text-align: center; margin: 5px 12px; display: inline-block; max-width: 27%; height: auto; }
    .center { text-align: center; }
    .head { font-size: 7pt; line-height: 10pt; font-weight: bold; }
    .thanks { font-size: 7pt; line-height: 15pt; margin:0 auto; display: block;}
    </style>
</head>
<body onload="window.print()">
    <div class="center head">
		<img src="/penampakan/images/logo-putrama.png" class="imglogo" style="float:left;">
		<div class="rightctn rightinfo">
		    <table class="stdtable">
		        <tr>
		            <td>Transaksi No</td>
		            <td>:</td>
		            <td><?php echo $list_id; ?></td>
		        </tr>
		        <tr>
		            <td>Kurir</td>
		            <td>:</td>
		            <td><?php echo $tipekurir;?></td>
		        </tr>
		    </table>
		</div>
		<div class="clear"></div>
    </div>
    <div class="dataorder">
        <div class="reportleft" style="border-right: 1px dotted #00000070">
            <table class="stdtable">
                <tr>
                    <td colspan="2">Kepada</td>
                    <td>&nbsp;</td>

                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><?php echo $getUser;?></td>
                </tr>
                <tr>
                    <td>No. Telepon</td>
                    <td>:</td>
                    <td><?php echo $telpUser;?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?php echo $alamatuser;?></td>
                </tr>
            </table>
        </div>
        <div class="reportright">
            <table class="stdtable">
                <tr>
                    <td>Pengirim</td>
                </tr>
                <tr>
                    <td>Putrama Packaging</td>
                </tr>
                <tr>
                    <td><?php echo get_dataoption('hotline');?></td>
                </tr>
                <tr>
                    <td><?php echo get_dataoption('web_url');?></td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="thanks center" style="border-top: 2px double #0000009e;">Terima Kasih atas kepecayaan Anda berbelanja di Putrama Packaging</div>
</body>
</html>
<?php }?>