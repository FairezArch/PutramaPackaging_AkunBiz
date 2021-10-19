<?php
    $idorder = $_GET['detailpenjualan'];
    $order = query_pesanan($idorder);
    //$list_status = change_status($idorder);
?>
<h2 class="topbar">Detail Penjualan ID <?php echo $idorder; ?></h2>
<img src="penampakan/images/printer.png" class="top-icon-print" onclick="window.open('order/print_penjualan.php?idtrans=<?php echo $idorder; ?>')" />
<div class="adminarea reportleft">
    <table class="stdtable">
        <tr>
            <td>ID Order</td>
            <td><?php echo $idorder; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Nama Customer</td>
            <td><?php echo $order['nama_user'] ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Telp</td>
            <td><?php echo $order['telp']; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td rowspan="2">Catatan</td>
            <td rowspan="2" style="max-width:220px;"><?php echo $order['catatan']; ?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><?php echo ket_metodebayarpesanan($order['metode_bayar']); ?><?php echo ket_typebayarpesanan($order['tipe_bayar']); ?><?php echo ket_typebayarpesanan($order['tipe_bayar_2']); ?></td>
            <td>&nbsp;</td> 
        </tr>
        <tr>
        	<td>Waktu Pemesanan</td>
            <td><?php if($order['waktu_pesan'] !== '0'){ echo date('d M Y, H.i', $order['waktu_pesan']); }else { echo '-'; } ?></td>
            <td>&nbsp;</td>
        </tr>
    </table>
</div>
<div class="clear"></div>

    <table class="stdtable produk-list">
        <thead>
            <tr>
                <td class="center grey" style="width:50px;"><strong>No.</strong></td>
                <td class="center grey"><strong>Detail Product</strong></td>
                <td class="center grey" style="width:140px;"><strong>Harga Satuan</strong></td>
                <td class="center grey" style="width:70px;"><strong>Jumlah</strong></td>
                <td class="center grey" style="width:140px;"><strong>Total</strong></td>
            </tr>    
        </thead>
        <tbody>
           <?php 
                $list_order = querydata_pesanan($idorder,'idproduk');
                $list_jml = querydata_pesanan($idorder,'jml_order');
                $list_hargaitem = querydata_pesanan($idorder,'harga_item');
               
                $list_ongkir = querydata_pesanan($idorder,'ongkos_kirim');
                $list_total = querydata_pesanan($idorder,'total');
                $list_diskon = querydata_pesanan($idorder,'jml_diskon');
                $list_reseller = querydata_pesanan($idorder,'diskon_reseller');
                $list_diskonmember = querydata_pesanan($idorder,'diskon_member');

                $all_diskon = $list_diskon+$list_reseller+$list_diskonmember;
                $metode_bayar = querydata_pesanan($idorder,'metode_bayar');
                $tipe_bayar  =  querydata_pesanan($idorder,'tipe_bayar');

                $array_order = explode('|',$list_order);
                $array_jml = explode('|',$list_jml);
                $array_hargaitem = explode('|',$list_hargaitem);
                
                $list_namaprod = querydata_pesanan($idorder,'nama_produk');
                $list_gambarprod = querydata_pesanan($idorder,'gambar_produk');
                $list_barcodeprod = querydata_pesanan($idorder,'barcode');
                $array_namaprod = explode('|',$list_namaprod);
                $array_gambarprod = explode('|',$list_gambarprod);
                $array_barcodeprod = explode('|',$list_barcodeprod);

                $list_saldosebagian = saldo_sebagian($idorder);
                $cek_saldo = $list_saldosebagian['nominal'];
                
                $jumlah_item = count($array_order) - 1;
                $x = 0;
                $no = 1;
                $total_harga_item = 0;
                $hasil = 0;
                while($x <= $jumlah_item) {
                    $harga_item = $array_hargaitem[$x];
                    $total_harga_item = $harga_item * $array_jml[$x];
                    $jumlah_harga = $list_total - $cek_saldo;
                ?>
                    <tr style="height: 50px;">
                        <td><?php echo $no; ?></td>
                        <td class="has_img">
                            <?php echo $array_namaprod[$x]; ?><br>
                            <strong><?php echo querydata_prod($array_order[$x],'barcode');//$array_barcodeprod[$x]; ?></strong>  
                            <a class="a_img_itemorder" href="<?php echo GLOBAL_URL.$array_gambarprod[$x]; ?>">
                                <img src="<?php echo GLOBAL_URL.$array_gambarprod[$x]; ?>" class="img_itemorder">
                            </a>
                        </td>
                        <td class="right nowrap"><?php echo uang($harga_item)."<br>";?></td>
                        <td class="right nowrap"><?php echo $array_jml[$x]; ?> pcs</td>
                        <td class="right nowrap"><?php echo uang($total_harga_item );?></td>
                    </tr>
                <?php $x++; $no++; }
            ?>
            <tr class="grey">
                <td colspan="2">Pembayaran : </td>
                <td class="right" colspan="2">Subtotal</td>
                <td class="right nowrap">
                    <?php echo uang(querydata_pesanan($idorder,'sub_total')); ?>
                </td>
            </tr>
            <tr class="grey">
                 <td colspan="2">
                    <strong><?php echo ket_metodebayarpesanan($order['metode_bayar']); ?><?php echo ket_typebayarpesanan($order['tipe_bayar']); ?><?php echo ket_typebayarpesanan($order['tipe_bayar_2']); ?></strong>
                </td>
                <td class="right" colspan="2">Diskon</td>
                <td class="right" colspan="2"><?php if( $all_diskon > 0 ){ echo uang($all_diskon); }else{ echo uang(0); }?></td>
            </tr>
            <tr class="grey">
            	<td class="right" colspan="4"><strong>Total</strong></td>
                <td class="right nowrap">
                    <strong><?php echo uang(querydata_pesanan($idorder,'total')); ?></strong>
                </td>
            </tr>
        </tbody>
    </table>
    <input type="button" class="btn back_btn floatleft" value="Kembali" onclick="window.history.back();">


<script>
jQuery(document).ready(function() {
  jQuery('.a_img_itemorder').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		closeBtnInside: false,
		fixedContentPos: true,
		mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
		image: {
			verticalFit: true
		},
		zoom: {
			enabled: true,
			duration: 300 // don't foget to change the duration also in CSS
		}
	});
});
</script>
