<?php $id_beli = $_GET['beliview'];
$args_beli = "SELECT * FROM logistik WHERE id='$id_beli'";
$result_beli = mysqli_query( $dbconnect, $args_beli );
$beli = mysqli_fetch_array($result_beli); ?>

<h2 class="topbar">PEMBELIAN ID <?php echo $id_beli; ?></h2>
<div class="inner" id="style-pembelian">
    <div class="floatleft boxleft" style="width: 48%;">
        <table class="stdtable">
            <tr>
           	  	<td>Tanggal</td>
            	<td><?php echo date('j F Y, H.i', $beli['tanggal']); ?></td>
          	</tr>

            <tr>
           	  	<td>Nama Supplier</td>
            	<td><?php echo $beli['suplayer']; ?></td>
          	</tr>
            <tr>
           	  	<td>Alamat / Telepon</td>
            	<td><?php echo $beli['contact']; ?></td>
          	</tr>
            <tr>
           	  	<td>Keterangan</td>
            	<td><?php echo nl2br($beli['keterangan']); ?></td>
          	</tr>
		</table>
    </div>
    <div class="boxright">
    	<table class="stdtable" style="width:100%;">
        <tbody>
        	<tr>
           	  	<td colspan="5" class="green"><strong>ITEM PEMBELIAN</strong></td>
                <td class="green center">&nbsp;</td>
       	  	</tr>
            <tr>
           	  	<td class="grey center"><strong>Barcode</strong></td>
                <td class="grey center"><strong>Nama Produk</strong></td>
                <td class="grey center"><strong>Total Item</strong></td>
                <td class="grey right"><strong>Harga Satuan</strong></td>
                <td class="grey right"><strong>Total Harga</strong></td>
                <td class="grey center">&nbsp;</td>
            </tr>
		</tbody>
        <tbody id="daftar_item">
        	<?php 
            //$array_produk_id = str_replace("|", "','", $beli['produk_id']);
            $array_produk_id = explode('|',$beli['produk_id']);
            $array_jumlah = explode('|',$beli['jumlah']);
			$array_hargasatuan = explode('|',$beli['hargasatuan']);
            
			$jml_item = count($array_produk_id);
			$x = 0; $y=1; $jumlah = 0; $total = 0;
			while($y <= $jml_item) {
            $total_item = $array_jumlah[$x];
			$subtotal = $total_item * $array_hargasatuan[$x]; ?>
            <tr class="tr_item" id="tr_item_<?php echo $y; ?>">
           	  	<td class="nowrap center">
				    <?php echo querydata_prod($array_produk_id[$x],'barcode'); ?>
                </td>
                <td  class="nowrap center"><?php echo querydata_prod($array_produk_id[$x]); ?></td>
           	  	<td class="nowrap center"><?php echo $total_item; ?> Pcs</td>
                <td class="right nowrap"><?php echo uang($array_hargasatuan[$x]); ?></td>
                <td class="right nowrap"><?php echo uang($subtotal); ?></td>
                <td class="center">&nbsp;</td>
           	</tr>
            <?php
			$total = $total + $subtotal;
            $jumlah = $jumlah + $total_item;
            $x++; $y++; } ?>
		</tbody>
        <tbody>
        	<tr>
           	  	<td colspan="3" class="grey right"><strong>Total Pembelian</strong></td>
           	  	<td class="grey right"><?php echo $jumlah; ?> Pcs</td>
                <td class="grey right"><?php echo uang($total); ?></td>
                <td class="grey center">&nbsp;</td>
           	</tr>
        </tbody>
<?php /*            
        <tbody>
        	<tr>
           	  	<td colspan="7" class="center">&nbsp;</td>
       	  	</tr>
        	<tr>
           	  	<td colspan="6" class="green" title="Biaya tambahan yang dikenakan kepada konsumen">
                	<strong>BEBAN PEMBELIAN (+)</strong>
                </td>
                <td class="green center">&nbsp;</td>
       	  	</tr>
		</tbody>
        <tbody id="daftar_tambahan">
        	<?php $list_kategori = explode('|',$jualbeli['kategori']);
			$list_deskripsikat = explode('|',$jualbeli['deskripsikat']);
			$list_hargatambah = explode('|',$jualbeli['hargatambah']);
			$jml_item = count($list_kategori); ?>
        	<input id="row_tambahan" name="row_tambahan" type="hidden" value="<?php echo $jml_item; ?>"/>
            <?php $x = 0; $y=1; while($y <= $jml_item) { ?>
       	  	<tr class="tr_tambahan" id="tr_tambahan_<?php echo $y; ?>">
           	  	<td colspan="3"><?php echo $list_deskripsikat[$x]; ?></td>
           	  	<td colspan="2"><?php echo cat_data($list_kategori[$x]); ?></td>
                <td class="right"><?php echo uang($list_hargatambah[$x]); ?></td>
                <td class="center">&nbsp;</td>
           	</tr>
            <?php $total = $total + $list_hargatambah[$x];
			$x++; $y++; } ?>
		</tbody>
        <tbody>
        	<tr>
           	  	<td colspan="7" class="center">&nbsp;</td>
       	  	</tr>
        	<tr>
           	  	<td colspan="6" class="green"><strong>DISKON (-)</strong></td>
                <td class="green center">&nbsp;</td>
       	  	</tr>
        	<tr class="">
           	  	<td colspan="5"><?php echo $jualbeli['diskonket']; ?></td>
                <td class="right"><?php echo uang($jualbeli['total_diskon']); $total = $total - $jualbeli['total_diskon']; ?></td>
                <td class="center">&nbsp;</td>
           	</tr>
        </tbody>
*/ ?>        
        <tbody>
            <tr>
           	  	<td colspan="6" class="center">&nbsp;</td>
       	  	</tr>
            <tr>
       	  	  <td colspan="4" class="grey right"><strong>Total Transaksi</strong></td>
              <td class="grey right"><?php echo uang($total); ?></td>
              <td class="grey center">&nbsp;</td>
           	</tr>
		</tbody>
        </table>
  	</div>
    <div class="clear"></div>
<div class="submitarea submitjual" style="width:auto; text-align:right;">
    <input type="button" class="btn back_btn floatleft" value="Kembali" onclick="window.history.back();">
	<?php if ( is_admin() || is_ho_logistik() ) { ?>
        <input value="Edit" name="save_general" id="save_general" class="btn back_btn" onclick="window.location.href='?logistics=pembelian&beliedit=<?php echo $id_beli; ?>'" type="button"/>
    <?php } ?>
    <div class="clear"></div>
</div>

</div>
