<?php
    include "../mesin/function.php";
    $idorder = $_GET['idorder'];
    $order = query_pesanan($idorder);


$nama_cust = querydata_user($order['id_user'],'nama');
$telp_cust = $order['telp'];
$subtotal_harga = uang(querydata_pesanan($idorder,'sub_total'));
$diskon = uang(querydata_pesanan($idorder,'diskon'));
$totalharga = uang(querydata_pesanan($idorder,'total'));
?>

<html>
<head>
<style>
	body { font-family: sans-serif; font-size: 10pt; }
    .center { text-align: center; }
    .right { text-align: right; }
    .stdtable{ font-size: 9pt; width: 100%; }
	.tabitem {
		font-size: 9pt;
		border-top: 1pt solid #999;
		border-right: 1pt solid #999;
	}
</style>
</head>
<body>
    <div class="center">
    IDEASMART<br>
    Jl Mawar No 9, Mangkubumen, Banjarsari<br>
    Kota Surakarta, Jawa Tengah<br>
    Telp:  (0271) 7466499<br> 
    </div>

    <p>===========================================================================</p>
    <table class='stdtable'>
        <tr>
            <td>ID Order</td>
            <td> : <?php echo $idorder; ?></td>
        </tr>
        <tr>
            <td>Nama Customer</td>
            <td> : <?php echo $nama_cust; ?></td>
        </tr>
        <tr>
            <td>Telp</td>
            <td> : <?php echo $telp_cust; ?></td>
        </tr>
    </table>
    
    <table class='stdtable'>
        <tbody>
            <?php
                $list_order = querydata_pesanan($idorder,'idproduk');
                $list_jml = querydata_pesanan($idorder,'jml_order');
                $array_order = explode('|',$list_order);
                $array_jml = explode('|',$list_jml);
                
                $jumlah_item = count($array_order) - 1;
                $x = 0;
                $no = 1;
                $total_harga_item = 0;
                while($x <= $jumlah_item) {
                    $harga_item = querydata_prod($array_order[$x],'harga');
                    $total_harga_item = $harga_item * $array_jml[$x];
                    $namaprod = querydata_prod($array_order[$x],'title');
                    $jml = $array_jml[$x];
                    $harga = uang(querydata_prod($array_order[$x],'harga'));
                    $sub_total = uang($total_harga_item);

                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $namaprod; ?></td>
                    </tr>
                    <tr>
                        <td class='right nowrap'><?php echo $jml; ?> X </td>
                        <td class='right nowrap'><?php echo $harga; ?></td>
                        <td class='right nowrap'><?php echo $sub_total; ?></td>
                    </tr>
                <?php 
                    $x++;
                    $no++;
                }
                ?>
        </tbody>
    </table> 
    <p>===========================================================================</p>
    <table class='stdtable'>
            <tr class='grey'>
                <td>Subtotal</td>
                <td> : </td>
                <td class='right nowrap'>
                    <?php echo $subtotal_harga; ?>
                </td>
            </tr>
            <tr class='grey'>
                <td>Diskon</td>
                <td> : </td>
                <td class='right nowrap'>
                    <?php echo $diskon; ?>
                </td>
            </tr>
            <tr class='grey'>
                <td>Total</td>
                <td> : </td>
                <td class='right nowrap'>
                    <strong><?php echo $totalharga; ?></strong>
                </td>
            </tr>
    </table>
</body>
</html>
