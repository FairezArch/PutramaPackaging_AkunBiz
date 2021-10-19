	<h2 class="topbar">Penjualan Baru</h2>
	<?php 
		/*$url = 'https://bit.ly/2K5MU16';
		$data_header = get_headers($url,1);
		$url = $data_header['Location'];
		//echo $look;
		if (is_array($url)) {
		foreach ($url as $url) {
			echo $url . "\n";
		}
	} else {
		echo $url;
	}

	$data = number_format(querydata_dataoption('purchase_prizes'),2);
	$rule_purchase = str_replace(',','',$data);
	if(35000.00 > $rule_purchase  ){
		echo $data;
	}else{
		echo $data." Kurang";
	}

	//echo number_format(querydata_dataoption('purchase_prizes'),2);*/
	 //echo date('d M Y, H:i',1568789880);
	 //echo mktime(13,32,15,9,19,2019);
	?>
	    <div class="adminarea">
	    	<div class="reportleft">
		    	<table class="detailtab tabcabang" width="100%">
				    <tr>
				    	<td>Tanggal</td>
			            <td>
			            	<input type="text" class="date datepicker" name="tanggal" id="tanggal" value="<?php echo date('j F Y'); ?>" /> &nbsp; 
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
			        <tr>
		           	  	<td>Member ID </td>
		                <td>
		                    <select class="member_person" name="member_person[]" id="member_person" onchange="get_data_person()" style="min-width:130px;">
								<option value="">&nbsp;</option>
								<?php  $person_member = get_userapp();
		                        while ( $list = mysqli_fetch_array($person_member) ) {   ?>
		                        <option value="<?php echo $list['id']; ?>"><?php echo $list['telp']; ?></option>
		                        <?php } ?>
		                    </select>
		                    <sub onclick="jual_open_newperson()" class="pointer vertical-bottom ">&nbsp; Member Baru</sub>

		                    <strong><sub onclick="open_personhistory()" class="pointer vertical-bottom none" id="member_history">&nbsp; </sub></strong>
		                </td>
		          	</tr>
			        <tr>
			        	<td>Nama Konsumen </td>
			        	<td><input type="text" class="pkonsumen" name="pkonsumen" id="pkonsumen" />&nbsp;</td>
			        </tr>
			        <tr>
			        	<td>Keterangan</td>
			        	<td><textarea class="pketerangan" id="pketerangan" style="width:92%;"></textarea></td>
			        </tr>
			        <tr>
						<td class="center" colspan="3">&nbsp;</td>
					</tr>
					<div></div>
					<tr>
						<td colspan="3">
							<input type="text" id="s_barcode" class="s_barcode" placeholder="Scan Barcode" onchange="jualadditem_listprod('s_barcode');" style="width:200px;"> &nbsp;Atau&nbsp; 
							<select id="s_namaprod" class="s_namaprod" onchange="jualadditem_listprod('s_namaprod');" style="width:200px;">
								<option value="" style="width:200px;"> -- Pilih Produk -- </option>
								<?php 
									$args_productvarian = "SELECT * FROM produk";
									$query_productvarian = mysqli_query( $dbconnect, $args_productvarian );
									while( $productvarian = mysqli_fetch_array($query_productvarian) ){ ?>
									<option value="<?php echo $productvarian['barcode']; ?>"><?php echo $productvarian['title']; ?></option>
								<?php } ?>
							</select>
							<div class="notif smallnotif nomargin" id="getproduct_notif" style="display: none;"></div>
						</td>
					</tr>
		    	</table>
	    	</div>
	    	
	    	<div class="reportright">
	    	<div id="form_newmember" class="none">
	    		<h3><strong><span id="titlepop">Buat</span> Pengguna Baru</strong></h3>
	    		<table class="detailtab tabcabang" width="100%">
	    			<tr>
	    				<td>Pengguna ID <span class="harus">*</span><br /><small>(Nomor HP)</small></td>
	    				<td><input type="text" name="new_memberId" id="new_memberId"></td>
	    			</tr>
	    			<tr>
	    				<td>Nama</td>
	    				<td><input type="text" name="new_memberName" id="new_memberName"></td>
	    			</tr>
	    			<tr>
			            <td>Tanggal Lahir</td>
			            <td><input type="text" id="tgl_lahir" name="tgl_lahir" class="datepicker" value="<?php //echo date('j F Y'); ?>" /></td>
			        </tr>
	    			<tr>
	    				<td>E-mail</td>
	    				<td><input type="email" name="new_memberEmail" id="new_memberEmail"></td>
	    			</tr>
	    			<tr>
	    				<td>Password <span class="harus">*</span></td>
	    				<td><input type="password" name="new_memberPass" id="new_memberPass"></td>
	    			</tr>
	    			<tr>
	    				<td>Status Pengguna <span class="harus">*</span></td>
	    				<td><select id="status_user">
	    						<option value="0">Non Member</option>
	    						<option value="1">Member</option>
	    					</select>
	    				</td>
	    			</tr>
	    		</table>
	    		<div class="submitarea" style="margin-top: 25px; width: 90%;">
					<input type="button" value="Tutup" name="person_cancel" id="person_cancel" class="btn back_btn" onclick="jual_close_newperson()" title="Tutup window ini"/>
					<input type="button" value="Simpan" name="person_save" id="person_save" class="btn save_btn" onclick="jual_newsave_person()"/>
					<input type="hidden" id="personid" value="0" />
					<img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:0px; left:185px;" id="addperson_loader" alt="Mohon ditunggu..." />
					
					<div class="notif" id="addperson_notif" style="display: none;"></div>
				</div>
	    	</div>
	    	</div>
	    	<div class="clear"></div>
	    	<br />
	    	<div class="popkat" id="open_linkverif">
	    		<h3>Link verifikasi</h3>
	    		<table class="detailtab" width="100%"> 
	    			<tr>
	    				<td>
	    					<div class="boxverif"><a target="_blank" id="link_direct"></a></div>
	    					<?php /*<a href="https://wa.me/62866726361232?text=http%3A%2F%2Flocalhost%2Fappsdemo%2Fverification%2F%3Fcheckup%3Dverification%26token%3Df0958d8b8988f99a87f44c30243e2d36b28c504abb71964d227ed5c2fc1dbf09" target="_blank"><textarea class="text_verif">https://wa.me/62866726361232?text=http%3A%2F%2Flocalhost%2Fappsdemo%2Fverification%2F%3Fcheckup%3Dverification%26token%3Df0958d8b8988f99a87f44c30243e2d36b28c504abb71964d227ed5c2fc1dbf09</textarea></a>*/ ?>
	    				</td>
	    			</tr>
	    		</table>
	    		<div class="submitarea">
	    			<input type="button" value="Tutup" name="close_verif" id="close_verif" class="btn back_btn" onclick="close_verif()" title="Tutup window ini"/>	
	    		</div>
	    	</div>
	    	<table class="stdtable">
	    		<input readonly="readonly" class="jnumber right none" type="text" name="hargasemua_view" id="hargasemua_view" placeholder="0,00"/>
	    		<tbody>
		    		<tr>
		           	  	<td colspan="5" class="green"><strong>ITEM PENJUALAN <span class="harus">*</span></strong></td>
		                <td class="green center" width="40">
		                	&nbsp;
		                </td>
		       	  	</tr>
		            <tr>
		                <td class="grey center" style="width:200px;"><strong>Barcode</strong></td>
		           	  	<td class="grey center" style="width:40%;"><strong>Nama Produk</strong></td>
		           	  	<td class="grey center"><strong>Harga</strong></td>
		           	  	<td class="grey center"><strong>Jumlah</strong></td>
		                <td class="grey center"><strong>Total</strong></td>
		                <td class="grey center">&nbsp;</td>
		            </tr>
	            </tbody>
	        	<tbody id="daftar_item">
		        	<input id="row_product" name="row_product" type="hidden" value="0"/>
						<tr class="tr_item" id="tr_item_1">
							<td class="center nowrap">
								<span class="try_barcode">-</span>
							</td>
							<td>
								<span class="prodvarian">-</span>
								<input readonly="readonly" class="idprodvarian" type="hidden" name="Nama Produk" value=""/>
								<input readonly="readonly" class="varian_nameprod" type="hidden" name="varianprod" value=""/>
								<input readonly="readonly" class="varian_imageprod" type="hidden" name="varian_imageprod" value=""/>
							</td>
							<td class="center nowrap">
								<span class="hargasatuan">-</span>
								<?php /*<input class="hargasatuan jnumber right" type="text" name="hargasatuan" id="hargasatuan" placeholder="0,00" style="width: 100px;" />*/ ?>
							</td>
							<td class="center nowrap">
								 <input class="jumlah right" type="number" name="jumlah" id="" placeholder="0" style="width: 50px;" step="1" value=""/> Pcs
							</td>
							<td class="center nowrap">
								<span class="hargatotal">-</span>
							</td>
							<td class="center">
								&nbsp;
							</td>
						</tr>
				</tbody>
				<tbody>
		        	<tr>
		           	  	<td colspan="3" class="grey right"><strong>Total Penjualan</strong></td>
		           	  	<td class="grey center">
							<input readonly="readonly" class="right" type="number" name="jumlahtotalitem" id="jumlahtotalitem" placeholder="0.00"
		                    	style="width: 50px;" step="0.01"/> Pcs
		                </td>
		                <td class="grey center">
		                	Rp <input readonly="readonly" class="jnumber right" type="text" name="hargatotalitem" id="hargatotalitem"
		                    	placeholder="0,00" style="width: 100px;"/>
		                </td>
		                <td class="grey center">&nbsp;</td>
		           	</tr>
		        </tbody>
		        <tbody>
		        	<tr>
		           	  	<td colspan="6" class="center">&nbsp;</td>
		       	  	</tr>
		        	<tr>
		           	  	<td colspan="5" class="green"><strong>DISKON (-)</strong></td>
		                <td class="green center">&nbsp;</td>
		       	  	</tr>
					<tr class="">
		           	  	<td colspan="3">
		           	  		<label><strong><p class="right">Diskon</p></strong></label>
		                	<?php /*<input type="text" name="diskon_voucher" id="diskon_voucher" placeholder="Kode Voucher" style="width: 300px;" onchange="jual_check_voucher()"/>
							<img src="penampakan/images/tab_delete.png" id="btn_hapusvoucher" class="tabicon none" onclick="jual_hapusvoucher()" title="Batalkan untuk menggunakan Kode Voucher"
						 alt="Batalkan untuk menggunakan Kode Voucher" style="vertical-align: middle; margin-left: 10px;">*/ ?>
						</td>
						<td class="center">
							<input type="number" name="jmlpersen" id="jmlpersen" onchange="hitung_persen()" style="width: 40px;"/>&nbsp; %
						</td>
						<?php /*
						<td colspan="2">
							<div class="notif smallnotif nomargin" id="checkvoucher_notif" style="display: none;"></div>
		                </td>
		                */ ?>
		                <td class="center">
		                	<?php /* Rp <input class="jnumber right" type="text" readonly="readonly" name="jmldiskon" id="jmldiskon" placeholder="0,00" style="width: 100px;"/> */ ?>
							Rp <input class="jnumber right" type="text" onchange="jual_totalsemua()" name="jmldiskon" id="jmldiskon" placeholder="0,00" style="width: 100px;"/>
						</td>
		                <td class="center">&nbsp;</td>
		           	</tr>
		           	<tr>
		           	  	<td colspan="6" class="center">&nbsp;</td>
		       	  	</tr>
		       	  	<tr>
		       	  		<td colspan="5" class="green"><strong>DISKON RESELLER (-)</strong></td>
		                <td class="green center">&nbsp;</td>
		       	  	</tr>
		       	  	<tr class="">
		           	  	<td colspan="3">
		           	  		<label><strong><p class="right">Diskon</p></strong></label>
						</td>
						<td class="center">
							<input type="number" name="jmlpersen_reseller" id="jmlpersen_reseller" onchange="persen_reseller();" disabled style="width: 40px;" />&nbsp; %
						</td>
		                <td class="center">
							Rp <input class="jnumber right" type="text" name="jmldiskon_reseller" id="jmldiskon_reseller" onchange="jual_totalkembalian()" disabled placeholder="0,00" style="width: 100px;" />
						</td>
		                <td class="center"><img src="penampakan/images/check_ok.png" onclick="change_reseller('0');" id="img_disc_reseller" class="filtergray" title="Klik untuk diskon member sebagai reseller" alt="Klik untuk diskon member sebagai reseller"></td>
		           	</tr>
		           	<tr class="row_bonusdiskon none">
		           	  	<td colspan="6" class="center">&nbsp;</td>
		       	  	</tr>
		       	  	<tr class="row_bonusdiskon none">
		       	  		<td colspan="5" class="green"><strong>BONUS DISKON MEMBER (-)</strong></td>
		                <td class="green center">&nbsp;</td>
		       	  	</tr>
		       	  	<tr class="row_bonusdiskon none">
		       	  		<input type="hidden" id="select_bonusdiskon">
		           	  	<td colspan="3">
		           	  		<label><strong><p class="right">Diskon</p></strong></label>
						</td>
						<td class="center">
							<input type="number" name="jmlpersen_bonusdiskon" id="jmlpersen_bonusdiskon"  style="width: 40px;" />&nbsp; %
						</td>
		                <td class="center">
							Rp <input class="jnumber right" type="text" name="jmldiskon_bonus" id="jmldiskon_bonus" disabled placeholder="0,00" style="width: 100px;" />
						</td>
		                <td class="center"><img src="penampakan/images/check_ok.png" onclick="use_discount('0');" id="img_disc_bonus" title="Klik untuk tambahan diskon" alt="Klik untuk tambahan diskon" class="filtergray"><input type="hidden" id="use_discount" value="0"></td>
		           	</tr>
		            <tr>
		           	  	<td colspan="6" class="center">&nbsp;</td>
		       	  	</tr>
		            <tr>
		       	  	  <td colspan="4" class="grey right"><strong>Total Transaksi</strong></td>
		                <td  class="grey right">
		                	<span class="center">Rp </span>
		                	<input class="jnumber right biginput" type="text" name="hargasemua" id="hargasemua" placeholder="0,00"/>
		              </td>
		              <td class="grey center">&nbsp;</td>
		           	</tr>
		           	<tr id="payment">
		       	  	  	<td colspan="4" class="grey right"><strong>Pembayaran <span class="harus">*</span></strong></td>
		                <td class="grey right">
		                	<select name="list_bayar" id="list_bayar"><?php // onchange="use_payment();"?>
		                		<option value="0">-- Pilih Pembayaran --</option>
		                		<?php 
		                			$query_pay = querydata_metodebayar();
		                			while( $result_pay = mysqli_fetch_array($query_pay) ){
		                		?>
		                			<option value="<?php echo $result_pay['id'];?>"><?php echo ucwords($result_pay['title_name']);?></option>
		                		<?php } ?>
		                	</select>
		              	</td>
		              <td class="grey center"><img src="penampakan/images/list-plus.png" title="Tambah tipe pembayaran" class="tabicon" onclick="add_payment();"><input type="hidden" id="inpart" value="0" /></td>
		           	</tr>
		           	<tr id="payment_amount">
		       	  	  	<td colspan="4" class="grey right"><strong>Dibayarkan <span class="harus">*</span></strong></td>
		                <td class="grey right">
		                	<span class="center">Rp </span>
		                	<input class="jnumber right biginput" type="text" name="hargabayar" id="hargabayar" placeholder="0,00" onchange="jual_totalkembalian();"/>
		              	</td>
		              	<td class="grey center">&nbsp;</td>
		           	</tr>

					<tr class="none" id="payment_2">
		       	  	  	<td colspan="4" class="aquamarine right"><strong>Pembayaran <span class="harus">*</span></strong></td>
		                <td class="aquamarine right">
		                	<select name="list_bayar_2" id="list_bayar_2">
								<option value="0">-- Pilih Pembayaran --</option>
		                		<?php 
		                			$query_pay = querydata_metodebayar();
		                			while( $result_pay = mysqli_fetch_array($query_pay) ){
		                		?>
		                			<option value="<?php echo $result_pay['id'];?>"><?php echo ucwords($result_pay['title_name']);?></option>
		                		<?php } ?>
							</select>
		              </td>
		              <td class="aquamarine center"><img src="penampakan/images/minus.png" title="Hapus tipe pembayaran" class="tabicon" onclick="close_payment();"></td>
		           	</tr>
		           	<tr class="none" id="payment_amount_2">
		       	  	  	<td colspan="4" class="aquamarine right"><strong>Kekurangan <span class="harus">*</span></strong></td>
		                <td class="aquamarine right">
		                	<span class="center">Rp </span>
		                	<input class="jnumber right biginput" type="text" name="hargabayar_2" id="hargabayar_2" placeholder="0,00" onchange="jual_totalkembalian();"/>
		              	</td>
		              	<td class="aquamarine center">&nbsp;</td>
		           	</tr>
		           	<tr id="row_deficiency" class="none">
		           		<td colspan="4" class="grey right"><input type="checkbox" id="check_deficiency" value='0' onchange="ok_deficiency();" title="Jadikan Hutang" alt="Jadikan Hutang"> &nbsp; <strong>Kekurangan Sebesar </strong></td>
		           		<td class="grey"><strong><div id="text_deficiency" class="right"></div></strong></td>
		           		<td class="grey center">&nbsp;</td>
		           	</tr>
		           	<tr>
		       	  	  	<td colspan="4" class="grey right"><strong>Kembalian</strong></td>
		                <td class="grey right">
		                	<span class="center">Rp </span>
		                	<input readonly="readonly" class="jnumber right biginput" type="text" name="hargakembali" id="hargakembali" placeholder="0,00"/>
		              	</td>
		              	<td class="grey center">&nbsp;</td>
		           	</tr>
		        </tbody>
	    	</table>
	    	<table class="mastertab none" id="mastertab">
				<tbody id="item_row">
			        <tr class="tr_item" id="">
						<input type="hidden" name="item_idgroup" class="item_idgroup" value="">
			            <td class="center nowrap">
							<span class="view_barcode"></span>
							<input readonly="readonly" class="barcode" type="hidden" name="Barcode Produk" id="" value=""/>
						</td>
						<td>
							<span class="prodvarian"></span>
							<input readonly="readonly" class="idprodvarian" type="hidden" name="Nama Produk" id="" value=""/>
							<input readonly="readonly" class="varian_nameprod" type="hidden" name="varianprod" value=""/>
							<input readonly="readonly" class="varian_imageprod" type="hidden" name="varian_imageprod" value=""/>
							<a class="a_img_itemorder a_imgproditem" id="a_imgproditem" style="float: right;" href="">
								<img src="" id="img_proditem" class="img_proditem img_itemorder" width="30" height="30">
							</a>
							<div class="clear"></div>
						</td>
						<td class="nowrap">
							@ <span class="view_hargasatuan"></span>
							<input readonly="readonly" class="hargasatuan" type="hidden" name="Harga Satuan" id="" value=""/>

						</td>
			            <td class="center nowrap">
			                 <input class="jumlah right" type="number" name="jumlah" id="" placeholder="0" style="width: 50px;" step="1" value="1"/> Pcs
			            </td>
						<td class="center nowrap">
							<span class="view_hargatotal"></span>
							<input readonly="readonly" class="hargatotal" type="hidden" name="Harga Total Item" id="" value=""/>
						</td>
			            <td class="center">
			                <img class="tabicon" src="penampakan/images/minus.png" width="20" height="20" alt="minus" onclick="" />
			            </td>
			        </tr>
				</tbody>
			</table>

			<table class="stdtable">
			    <tr>
			        <td colspan="2">&nbsp;</td>
			    </tr>
			    <tr>
			        <td>&nbsp;</td>
			        <td class="right aksi">
			            <input type="hidden" name="id_jual" id="id_jual" value="0"/>
			            <img id="general_loader" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="right:270px;">
			            <input type="button" class="btn back_btn" value="&laquo; Batal" style="display:block; float: left;" onclick="kembali()" />
			           <input value="Simpan" name="save_general" id="save_general" class="btn save_btn" onclick="save_jual('normal')" type="button"/> &nbsp;
			           <input value="Simpan dan Print" name="save_general" id="save_general" class="btn save_btn" onclick="save_jual('print')" type="button"/>
			        </td>
			    </tr>
			</table>
		<div class="notif nomargin-center" id="general_notif" style="display:none;"></div>
		<div class="clear"></div>
		<?php /*<div class="submitarea submitjual" style="width:auto; text-align:right;">
			<input value="&laquo; Batal" name="back" id="back" onclick="window.history.back();" type="button" style="display:block; float: left;" class="btn back_btn" /> &nbsp; 
			<input value="Simpan" name="save_general" id="save_general" class="btn save_btn" onclick="save_jual()" type="button"/> &nbsp; 
			<!--<input value="Simpan dan Print" name="save_general" id="save_general" class="btn save_btn" onclick="save_jual('print')" type="button"/>-->
		    <input type="hidden" name="id_jual" id="id_jual" value="0"/>
			<input type="hidden" name="bukukas" id="bukukas" class="bukukas" value="1"> <?php // Bukukas Penjualan ?>
			<input type="hidden" name="type_trans" id="type_trans" value="normal">
		    <div class="notif nomargin-center" id="general_notif" style="width:90%;"></div>
		    <img class="loader" src="penampakan/images/conloader.gif" id="general_loader" alt="Mohon ditunggu..." height="32" width="32" style="right:300px;">
		</div> */ ?>

	</div>

<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#s_namaprod, #member_person').select2();
    jQuery('.select2-selection__rendered').removeAttr('title');
});
</script>

<script>
jQuery(document).ready(function() {
	jQuery('body').magnificPopup({
		delegate: '.a_img_itemorder',
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