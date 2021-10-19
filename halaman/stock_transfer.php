<h2 class="topbar">Transfer Stok</h2>
	<div class="adminarea">
	    <div class="reportleft">
	    	<table class="detailtab tabcabang" width="100%">
	    		<input id="aktivitas" name="aktivitas" type="hidden" value="trans"/>
				    <tr>
				    	<td>Tanggal</td>
			            <td>
			            	<input type="text" class="date" name="tanggal" id="tanggal" value="<?php echo date('j F Y'); ?>" /> &nbsp; 
							<select name="jam" id="jam" >
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
			        <tr>
				    	<td>Transfer Dari</td>
				    	<td>
				    		<select name="trans_from" id="trans_from" style="width: 150px;">
				    			<option value="0">Stok Dari</option>
				    			<option value="1">Stock Produksi</option>
				    			<option value="2">Stock Toko</option>
				    			<option value="3">Stock Display</option>
				    		</select>
				    	</td>
				   	</tr>
				   	<tr>
				    	<td>Transfer Ke</td>
				    	<td>
				    		<select name="trans_to" id="trans_to" style="width: 150px;">
				    			<option value="0">Stok Ke</option>
				    			<option value="1">Stock Produksi</option>
				    			<option value="2">Stock Toko</option>
				    			<option value="3">Stock Display</option>
				    		</select>
				    	</td>
				   	</tr>
				   	<tr>
			        	<td>Keterangan</td>
			        	<td><textarea class="ket_transstock" id="ket_transstock" style="width:92%;"></textarea></td>
			        </tr>
			        <tr>
						<td colspan="2">&nbsp;</td>
					</tr>
			        <tr>
						<td colspan="3">
							<input type="text" id="s_barcode" class="s_barcode" placeholder="Scan Barcode" onchange="stokadditem_listprod('s_barcode');" style="width:200px;"> &nbsp;Atau&nbsp; 
							<select id="s_namaprod" class="s_namaprod" onchange="stokadditem_listprod('s_namaprod');" style="width:200px;">
								<option value="" style="width:200px;"> -- Pilih Produk -- </option>
								<?php 
									$args_productvarian = "SELECT * FROM produk";
									$query_productvarian = mysqli_query( $dbconnect, $args_productvarian );;
									while( $productvarian = mysqli_fetch_array($query_productvarian) ){ ?>
									<option value="<?php echo $productvarian['barcode']; ?>"><?php echo $productvarian['title']; ?></option>
								<?php } ?>
							</select>
							<div class="notif smallnotif nomargin" id="getproduct_notif" style="display: none;"></div>
						</td>
					</tr>
					
			</table>
	    </div>

	    <div class="clear"></div>
			<table class="stdtable">
				<tbody id="daftar_item">
		    		<tr>
		           	  	<td colspan="3" class="green"><strong>ITEM PENJUALAN <span class="harus">*</span></strong></td>
		                <td class="green center" width="40">
		                	&nbsp;
		                </td>
		               
		       	  	</tr>
		            <tr>
		               	<td class="grey center"><strong>Barcode</strong></td>
		                <td class="grey center"><strong>Nama Produk</strong></td>
		                <td class="grey center"><strong>Jumlah Stok</strong></td>
		                <td class="grey center">&nbsp;</td>
		                <input id="row_stock" name="row_stock" type="hidden" value="0"/>
		            </tr>
	            </tbody>
	            <tbody>
					<tr>
						<td colspan="4" class="grey center">&nbsp;</td>
					</tr>
				</tbody>
			</table>

			<div class="submitarea" style="width:auto; text-align:right;">
				<input value="&laquo; Batal" name="back" id="back" onclick="window.history.back();" type="button" class="btn back_btn" style="display:block; float: left;" /> &nbsp; 
				<input value="Simpan" name="save_general" id="save_general" class="btn save_btn" onclick="save_transferstock()" type="button"/>
			    <div class="notif nomargin-center" id="general_notif" style="display:none;"></div>
			    <img class="loader" src="penampakan/images/conloader.gif" id="general_loader" alt="Mohon ditunggu..." height="32" width="32" style="right: 230px; left: auto;">
			    <div class="clear"></div>
			</div>
			<table class="mastertab none" id="mastertab">
				<tbody id="item_row">
				    <tr class="tr_item" id="">
				        <td class="center nowrap">
							<span class="barcode_trans">-</span>
						</td>
						<td class="center nowrap">
							<span class="prodvarian_trans">-</span>
							<input readonly="readonly" class="idprodvarian_trans" type="hidden" name="idprodvarian_trans" value=""/>
							<input readonly="readonly" class="hargaprodvarian_trans" type="hidden" name="hargaprodvarian_trans" value=""/>
						</td>
						<td class="center nowrap">
							<input class="jumlah_trans right" type="number" name="jumlah_trans" id="" placeholder="0" style="width: 50px;" step="1" value=""/> Pcs
						</td>
						<td class="center">
				            <img class="tabicon" src="penampakan/images/minus.png" width="20" height="20" alt="minus" onclick="" />
				        </td>
				    </tr>
				</tbody>
			</table>
	</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#s_namaprod').select2();
    jQuery('.select2-selection__rendered').removeAttr('title');
});
</script>