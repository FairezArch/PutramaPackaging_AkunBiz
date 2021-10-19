<?php if( is_admin() || is_ho_logistik() ) { ?>
<h2 class="topbar">Pembelian Baru</h2>
<div class="inner" id="style-pembelian">
    <div class="floatleft boxleft" style="width:48%;">
        <table class="stdtable"> 
            <tr>
           	  	<td>Tanggal <span class="harus">*</span></td>
            	<td>
                	<input type="text" class="datepicker" name="tanggal" id="tanggal" value="<?php echo date('j F Y'); ?>"/> &nbsp; 
                    <select name="jam" id="jam">
                        <?php $hnow = date('H'); $h = 0; while($h <= 23) { $hshow = sprintf("%02d", $h); ?>
                        <option value="<?php echo $hshow; ?>" <?php auto_select($hnow,$hshow); ?> ><?php echo $hshow; ?></option>
                        <?php $h++; } ?>
                    </select>
                    <select name="menit" id="menit">
                        <?php $mnow = date('i'); $m = 0; while($m <= 59) { $mshow = sprintf("%02d", $m); ?>
                        <option value="<?php echo $mshow; ?>" <?php auto_select($mnow,$mshow); ?> ><?php echo $mshow; ?></option>
                        <?php $m++; } ?>
                    </select>
                </td>
          	</tr>
        <?php /*    
            <tr>
           	  	<td>#Invoice</td>
            	<td><input style="width:128px;" id="invoice" name="invoice" type="text"></td>
          	</tr>
        */ ?>    
            <tr>
           	  	<td>Nama Supplier <span class="harus">*</span></td>
            	<td><input style="width:128px;" id="suplayer" name="suplayer" type="text"></td>
          	</tr>
            <tr>
           	  	<td>Alamat / Telepon</td>
            	<td><input style="width:72%;" id="suplayer_contact" name="suplayer_contact" type="text"></td>
          	</tr>
            <tr>
           	  	<td>Keterangan</td>
            	<td><textarea name="keterangan" id="keterangan" style="width:92%;"></textarea></td>
          	</tr>
		</table>
    </div>
    <div class="boxright">
    	<table class="stdtable" style="width:100%;">
        <tbody>
        	<tr>
           	  	<td colspan="5" class="green"><strong>ITEM PEMBELIAN</strong></td>
                <td class="green center">
                	<img class="tabicon" src="penampakan/images/plus_white.png" width="20" height="20" alt="plus" onclick="tambah_item_beli()" />
                </td>
       	  	</tr>
            <tr>
           	  	<td class="grey center"><strong>Barcode</strong></td>
                <td class="grey center"><strong>Nama Produk <span class="harus">*</span></strong></td>
                <td class="grey center"><strong>Total Item <span class="harus">*</span></strong></td>
                <td class="grey center"><strong>Harga Satuan <span class="harus">*</span></strong></td>
                <td class="grey center"><strong>Total Harga</strong></td>
                <td class="grey center">&nbsp;</td>
            </tr>
		  </tbody>
        <tbody id="daftar_item">
        	<input id="row_product" name="row_product" type="hidden" value="1"/>
            <tr class="tr_item" id="tr_item_1">
           	  	<td>
                    <?php /*
                	<select class="barcode" name="barcode" id="barcode_1" style="width:130px;">
                        <option value=""></option>
                        <?php $barcode_query = query_beli_produk('barcode'); while ( $list_barcode = mysqli_fetch_array($barcode_query) ) { ?>
                            <option value="<?php echo $list_barcode['barcode']; ?>"><?php echo $list_barcode['barcode']; ?></option>
                        <?php } ?>
                    </select>
                    */ ?>
                    <input type="text" class="barcode" name="barcode" id="barcode_1" style="min-width:125px;" onchange="beli_select_data('1','barcode')">
                </td>    
                <td class="center">  
                	<select class="namaprod" name="namaprod" id="namaprod_1" style="min-width: 575px;" onchange="beli_select_data('1','id')">
                        <option value="">Nama Produk</option>
                        <?php $nama_query = query_beli_produk('nama'); while ( $list_nama = mysqli_fetch_array($nama_query) ) { ?>
                            <option value="<?php echo $list_nama['id']; ?>"><?php echo $list_nama['title']; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td class="center nowrap">
                	<input class="itemtotal right" type="text" name="itemtotal" id="itemtotal_1" placeholder="0" style="width: 70px;" onchange="total_row(1)"/> Pcs
                </td>
           	  	<td class="center nowrap">
                	Rp <input class="hargasatuan jnumber right" type="text" name="hargasatuan" id="hargasatuan_1" placeholder="0,00"
                    	style="width: 100px;" value="" onchange="total_row(1)"/>
                </td>
                <td class="center nowrap">
                	Rp <input readonly="readonly" class="hargatotal jnumber right" type="text" name="hargatotal" id="hargatotal_1"
                    	placeholder="0,00" style="width: 100px;"/>
                </td>
                <td class="center">&nbsp;</td>
           	</tr>
		</tbody>           
        <tbody>
        	<tr>
           	  	<td colspan="3" class="grey right"><strong>Total Pembelian</strong></td>
           	  	<td class="grey center">
					<input readonly="readonly" class="right" type="number" name="jumlahtotalitem" id="jumlahtotalitem" placeholder="0.00"
                    	style="width: 70px;"/> Pcs
                </td>
                <td class="grey center">
                	Rp <input readonly="readonly" class="jnumber right" type="text" name="hargatotalitem" id="hargatotalitem"
                    	placeholder="0,00" style="width: 100px;"/>
                </td>
                <td class="grey center">&nbsp;</td>
           	</tr>
        </tbody>
<?php /*             
        <tbody>
        	<tr>
           	  	<td colspan="7" class="center">&nbsp;</td>
       	  	</tr>
        	<tr>
           	  	<td colspan="6" class="green" title="Biaya tambahan yang dikenakan kepada Anda saat membeli barang ini">
                	<strong>BEBAN PEMBELIAN (+)</strong>
                </td>
                <td class="green center"><img class="tabicon" src="theme/images/plus_white.png" width="20" height="20" alt="plus" onclick="tambah_biaya()" /></td>
       	  	</tr>
		</tbody>
        <tbody id="daftar_tambahan">
        	<input id="row_tambahan" name="row_tambahan" type="hidden" value="1"/>
       	  	<tr class="tr_tambahan" id="tr_tambahan_1">
           	  	<td colspan="3">
                	<input class="deskripsikat" type="text" name="deskripsikat" id="deskripsikat_1" placeholder="Deskripsi" style="width: 90%;"/>
                </td>
           	  	<td colspan="2">
                    <select class="kategori" id="kategori_1">
						<option value="0">Pilih Kategori</option>
						<?php $args = "SELECT * FROM pro_category WHERE master='pg_beli_tambah' AND active='1' ORDER BY name ASC";
						$result = mysqli_query( $dbconnect, $args ); while ( $kategori = mysqli_fetch_array($result) ) {  ?>
                        <option value="<?php echo $kategori['id']; ?>"><?php echo $kategori['name']; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td class="center">
                	Rp <input class="hargatambah jnumber right" type="text" id="hargatambah_1" placeholder="0,00" style="width: 100px;" onchange="total_semua()"/>
                </td>
                <td class="center">&nbsp;</td>
           	</tr>
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
           	  	<td colspan="4">
                	<input type="text" name="diskonket" id="diskonket" placeholder="Deskripsi" style="width: 92%;"/>
                </td>
                <td>&nbsp;</td>
                <td class="center">
                	Rp <input class="jnumber right" type="text" name="jmldiskon" id="jmldiskon" onchange="total_semua()" placeholder="0,00" style="width: 100px;"/>
              </td>
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
                <td class="grey center">
                	<span class="center">Rp </span>
                	<input readonly="readonly" class="jnumber right" type="text" name="hargasemua" id="hargasemua" placeholder="0,00" style="width: 100px;"/>
              </td>
              <td class="grey center">&nbsp;</td>
           	</tr>
		</tbody>
        </table>
  	</div>
    <div class="clear"></div>
    
<div class="submitarea submitjual" style="width:auto; text-align:right;">
	<input class="btn back_btn" value="&laquo; Batal" name="back" id="back" onclick="window.history.back();" type="button"/> &nbsp; 
	<input class="btn save_btn" value="Simpan" name="save_general" id="save_general" onclick="save_beli()" type="button"/>
    <input type="hidden" name="id_beli" id="id_beli" value="0"/>
    <div class="notif floatleft none" id="general_notif" style="width:60%;"></div>  
    <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:0px; right:195px;" id="general_loader" alt="Mohon ditunggu...">
    <div class="clear"></div>
</div>
</div>

<table class="mastertab none" id="mastertab">
	<tbody id="item_row">   
        <tr class="tr_item" id="">
           	<td>
                <input type="text" class="barcode" name="barcode" id="" style="min-width:125px;" onchange="">
            </td>    
            <td class="center">  
                <select class="namaprod" name="namaprod" id="" style="width: 575px;" onchange="">
                    <option value="">Nama Produk</option>
                    <?php $nama_query = query_beli_produk('nama'); while ( $list_nama = mysqli_fetch_array($nama_query) ) { ?>
                        <option value="<?php echo $list_nama['id']; ?>"><?php echo $list_nama['title']; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td class="center nowrap">
                <input class="itemtotal right" type="text" name="itemtotal" id=""
                    	placeholder="0" style="width: 70px;" onchange=""/> Pcs
            </td>
           	<td class="center nowrap">
                Rp <input class="hargasatuan jnumber right" type="text" name="hargasatuan" id="" placeholder="0,00"
                    	style="width: 100px;" value="" onchange=""/>
            </td>
            <td class="center nowrap">
                Rp <input readonly="readonly" class="hargatotal jnumber right" type="text" name="hargatotal" id=""
                	placeholder="0,00" style="width: 100px;"/>
            </td>
            <td class="center"><img class="tabicon" src="penampakan/images/minus.png" width="20" height="20" alt="minus" onclick="" /></td>
        </tr>    
	</tbody>
</table>    

<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#namaprod_1').select2();
    jQuery('.select2-selection__rendered').removeAttr('title');
});
</script>

<?php /*
<script type="text/javascript">
function barcode_autocomplete() {
	var availableTags = [<?php barcode_complete(); ?>];
    $( ".barcode" ).autocomplete({source: availableTags});
}
$(document).ready(function () {
	barcode_autocomplete();
});
</script>
*/ ?>

<?php  } ?>
