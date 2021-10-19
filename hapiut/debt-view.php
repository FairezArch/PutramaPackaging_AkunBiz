<?php 
$debt_id = $_GET['viewdebt'];
$hapiut = hapiut_query($debt_id);
if ( 'debt' == $hapiut['type'] ) {
	$hptype = 'hutang';
	$hptype_acap = 'HUTANG';
	$hptype_cap = 'Hutang';
	$hptype_en = 'debt';
	$hpber = 'berhutang';
	$hpfrom = 'dari';
	$hpto = 'kepada';
	$hpinout = 'Pemasukan';
	$hpcashcat = 'in';
	$viewrole = 'debt_view';
	$titleplus = 'Tambah hutang lagi dari '.$hapiut['person'];
	$titlemin = 'Bayar sebagian atau seluruh hutang kepada '.$hapiut['person'];
	//$userakses = user_can('debt_edit');
} else {
	$hptype = 'piutang';
	$hptype_acap = 'PIUTANG';
	$hptype_cap = 'Piutang';
	$hptype_en = 'credit';
	$hpber = 'berpiutang';
	$hpfrom = 'kepada';
	$hpto = 'dari';
	$hpinout = 'Pengeluaran';
	$hpcashcat = 'out';
	$viewrole = 'credit_view';
	$titleplus = 'Beri piutang lagi kepada '.$hapiut['person'];
	$titlemin = 'Pembayaran sebagian atau seluruh piutang dari '.$hapiut['person'];
	//$userakses = user_can('credit_edit');
}
?>
		<h2 class="topbar">Detail <?php echo $hptype_cap." ID ".$debt_id;?> </h2>
    	<div class="tooltop" style="height: 34px;">
            <div class="rtrans" onclick="parent.history.back()" >Kembali</div>
        </div>
       	<div class="clear"></div>

       	<div class="adminarea">
       		<div class="boxeditdet">
       			<?php if( ( 'debt' == $hapiut['type'] || 'credit' == $hapiut['type'] ) ){?>
       			<img src="penampakan/images/grey_del.png" width="28" height="32" alt="delete" title="Hapus keseluruhan data <?php echo $hptype_cap; ?> ini"
			    	onclick="open_del_hapiut('<?php echo $hapiut['id']; ?>')"/>
			    &nbsp;
			    <img src="penampakan/images/grey_edit2.png" width="32" height="32" alt="edit" title="Edit data awal <?php echo $hptype_cap; ?> ini"
			    	onclick="edit_hapiut('<?php echo $hapiut['id']; ?>')"/>
       			<?php } ?>
       			<input type="hidden" id="person_<?php echo $hapiut['id']; ?>" value="<?php echo $hapiut['person']; ?>"/>
			    <input type="hidden" id="date_<?php echo $hapiut['id']; ?>" value="<?php echo date('j F Y', $hapiut['date']); ?>"/>
			    <input type="hidden" id="hour_<?php echo $hapiut['id']; ?>" value="<?php echo date('H', $hapiut['date']); ?>"/>
			    <input type="hidden" id="minute_<?php echo $hapiut['id']; ?>" value="<?php echo date('i', $hapiut['date']); ?>"/>
			    <input type="hidden" id="amount_<?php echo $hapiut['id']; ?>" value="<?php echo $hapiut['saldostart']; ?>"/>
			    <input type="hidden" id="desc_<?php echo $hapiut['id']; ?>" value="<?php echo $hapiut['description']; ?>"/>
			    <input type="hidden" id="saldonowtext_<?php echo $hapiut['id']; ?>" value="<?php echo uang($hapiut['saldonow']); ?>"/>
    			<input type="hidden" id="saldonow_<?php echo $hapiut['id']; ?>" value="<?php echo $hapiut['saldonow']; ?>"/>
    			<?php $catkas = catkas($hapiut['id']); ?>
		        <input type="hidden" id="catkas_<?php echo $hapiut['id']; ?>" value="<?php echo $catkas[0]; ?>"/>
		        <input type="hidden" id="cash_book_<?php echo $hapiut['id']; ?>" value="<?php echo $catkas[1]; ?>"/>
		        <input type="hidden" id="cash_category_<?php echo $hapiut['id']; ?>" value="<?php echo $catkas[2]; ?>"/>
    			<input type="hidden" id="hptype_<?php echo $hapiut['id']; ?>" value="<?php echo $hapiut['type']; ?>"/>
       			<div class="clear"></div>

       		</div>
       		<table class="stdtable" style="max-width: 560px;">
       			<tr>
       				<td style="116px;"><?php echo $hptype_cap.' '.$hpto; ?></td>
				    <td><?php echo $hapiut['person']; ?></td>
				    <td style="width: 16px;">&nbsp;</td>
				    <td style="116px;"><?php echo $hptype_cap; ?> Awal</td>
				    <td><?php echo uang($hapiut['saldostart']); ?></td>
       			</tr>
       			<tr>
				    <td>Tanggal Mulai</td>
				    <td><?php echo date('j F Y', $hapiut['date']); ?></td>
				    <td>&nbsp;</td>
				    <td><?php echo $hptype_cap; ?> Sekarang</td>
				    <td><?php echo uang($hapiut['saldonow']); ?></td>
    			</tr>
    			<tr>
				    <td>Transaksi Terakhir</td>
				    <td><?php echo last_hp_trans($debt_id); ?></td>
				    <td>&nbsp;</td>
				    <td>Keterangan</td>
				    <td><?php echo nl2br($hapiut['description']); ?></td>
				 </tr>
				 <tr>
				    <td>Jumlah Transaksi</td>
				    <td><?php echo jml_hp_trans($debt_id); ?></td>
				    <td>&nbsp;</td>
				    <td>Status</td>
				    <td><?php if ('1' == $hapiut['status']) { echo $hptype_cap; } else { echo "Lunas"; } ?></td>
				 </tr>
       		</table>
       	</div>
       	<br />
       	<h3>DAFTAR TRANSAKSI</h3>
       	<br />
       	<?php if( ( 'debt' == $hapiut['type'] || 'credit' == $hapiut['type'] ) ){?>
       	<div class="tooltop" style="height: 34px;">
            <div class="rtrans" onclick="plusmin_hapiut('plus','<?php echo $hapiut['id']; ?>')" style="margin-right: 200px;" />Tambah <?php echo $hptype_cap; ?></div>
             <div class="rtrans" onclick="plusmin_hapiut('minus','<?php echo $hapiut['id']; ?>')"  />Kurangi <?php echo $hptype_cap; ?></div>
        </div>
    	<?php } ?>
    	<div class="adminarea">
    	<table class="stdtable" id="datatable_viewhp">
    		<thead>
			    <tr>
			        <th scope="col" style="width: 80px;">Tanggal</th>
			        <th scope="col" style="width: 100px;">Type</th>
			        <th scope="col" style="width: 100px;">Nominal</th>
			        <th scope="col">Deskripsi</th>
			        <th scope="col" style="width: 100px;">Saldo</th>
			        <th scope="col" style="width: 64px;">ID</th>
			        <?php //if ( 0 == $hapiut['orderan'] ) { ?>
			        <th scope="col" style="width: 48px;">Aksi</th>
			        <?php //} ?>
			     </tr>
			</thead>
			<tbody>
				<?php
					$args = "SELECT * FROM hapiut_item WHERE parenthp='$debt_id' ORDER BY date ASC";
					$result = mysqli_query($dbconnect,$args);
					$saldo = $hapiut['saldostart'];

					while ( $hpitem = mysqli_fetch_array($result) ) {
						if ( 'plus' == $hpitem['type'] ) { $saldo = $saldo + $hpitem['amount']; }
						if ( 'minus' == $hpitem['type'] ) { $saldo = $saldo - $hpitem['amount']; }
				?>
				<tr class="<?php echo $hpitem['type']; ?>" id="hpitem_<?php echo $hpitem['id']; ?>">
		            <td class="center"><?php echo date('d M Y', $hpitem['date']); ?></td>
		            <td class="center"><?php echo hp_item_type($hpitem['type']); ?></td>
		            <td class="right"><?php echo uang($hpitem['amount'], false); ?></td>
		            <td><?php echo nl2br($hpitem['description']); ?></td>
		            <td class="right"><?php echo uang($saldo, false); ?></td>
		            <td class="center"><?php echo $hpitem['id']; ?></td>
		            <td class="center">
		            	<?php //if ( is_admin() ) { ?>
		                    <?php if ( is_admin() ) { ?>
		                    <img class="tabicon" src="penampakan/images/tab_delete.png" width="20" height="20" alt="edit" title="Hapus"
		                        onclick="open_del_hapiut_item('<?php echo $hpitem['id']; ?>')"/>
		                    <?php } ?>
		                <?php //} ?>
		            </td>
		        </tr>
		        <?php } ?>
			</tbody>
    	</table>
    	</div>
	

<div class="popup popdel" id="popdelhapiut">
	<strong>Apakah Anda yakin ingin menghapus <?php echo $hptype_cap;?> ID <span id="deldebtid_text"></span> ?</strong><br />
	Seluruh transaksi yang berkaitan dengan <?php echo $hptype_cap;?> ini juga akan terhapus serta tidak dapat ditampilkan kembali.
    Hal ini juga berpengaruh terhadap Laporan yang berkaitan dengan transaksi-transaksi tersebut.
    <br /><br />
    <input type="button" id="delusercancel" name="delusercancel" class="btn back_btn" value="Batal" onclick="cancel_del_debt()"/>
    &nbsp;&nbsp;
    <input type="button" id="deluserok" name="deluserok" class="btn delete_btn" value="Hapus!" onclick="del_hapiut()"/>
    <input type="hidden" id="deldebtid" name="deldebtid" value="0"/>
    <input type="hidden" id="dellhptype" value="<?php echo $hptype_en; ?>" />
</div>

<div class="popup popdel" id="popdeldethapiut">
	<strong>Apakah Anda yakin ingin menghapus <?php echo $hptype_cap;?> Transaksi ID <span id="deldebtdetid_text"></span> ?</strong><br />
	Transaksi yang berkaitan juga akan terhapus serta tidak dapat ditampilkan kembali.
    <br /><br />
    <input type="button" id="delusercancel" name="delusercancel" class="btn back_btn" value="Batal" onclick="cancel_del_detdebt()"/>
    &nbsp;&nbsp;
    <input type="button" id="deluserok" name="deluserok" class="btn delete_btn"  value="Hapus!" onclick="del_dethapiut()"/>
    <input type="hidden" id="deldetdebtid" name="deldetdebtid" value="0"/>
</div>

		<?php //new box hutang ?>
        <div class="popkat" id="pop_debt" style="width: 430px;">
        	<h3><span id="titlepop">Tambah</span> <?php echo $hptype_cap;?> <span id="titlepopid"></span></h3>
        	<table class="stdtable">
        		<tr>
		          	<td>Klien*</td>
		          	<td><input type="text" name="person" id="person" style="width: 200px;" title="Kepada siapa Anda behutang?" /></td>
		        </tr>
        		<tr>
					<td><span title="Tanggal hutang">Tanggal<span class="harus">*</span></span></td>
					<td>
		            	<input type="text" class="date" name="date" id="date" value="<?php echo date('j F Y'); ?>" title="Tanggal mulai berhutang" />
		                &nbsp;
		                <select name="hour" id="hour">
		                    <?php $hnow = date('H'); $h = 0; while($h <= 23) { $hshow = sprintf("%02d", $h); ?>
		                    <option value="<?php echo $hshow; ?>" <?php auto_select($hnow,$hshow); ?> ><?php echo $hshow; ?></option>
		                    <?php $h++; } ?>
		                </select>
		                <select name="minute" id="minute">
		                    <?php $mnow = date('i'); $m = 0; while($m <= 59) { $mshow = sprintf("%02d", $m); ?>
		                    <option value="<?php echo $mshow; ?>" <?php auto_select($mnow,$mshow); ?> ><?php echo $mshow; ?></option>
		                    <?php $m++; } ?>
		                </select>
		            </td>
				</tr>
				<tr>
					<td>Jumlah<span class="harus">*</span></td>
					<td>
						Rp. &nbsp; 
		                <input type="text" class="jnumber right" name="amount" id="amount" value="0" style="width: 96px;" />
					</td>
				</tr>
				<tr>
					<td>Keterangan</td>
					<td><textarea name="desc" id="desc" style="width: 92%; height: 48px;"></textarea></td>
				</tr>
				<tr>
					<td colspan="2">
		            	Catat sebagai <strong><?php echo $hpinout;?></strong> pada Buku Kas? &nbsp;
		                <select name="catkas" id="catkas" onchange="catatkas();"
		                	title="Jika ini adalah Pemasukan uang tunai, Anda bisa sekaligus mencatatnya sebagai Pemasukan pada buku Kas">
		                	<option value="0">Tidak</option>
		                    <option value="1">Ya</option>
		                </select>
		            </td>
				</tr>
		        <tr class="cashin none">
					<td>Buku Kas <span class="harus">*</span></td>
					<td>
		            	<select name="cash_book" id="cash_book" style="width: auto; max-width: 260px;">
		                    <?php $cash_query = querydata_cashbook(); while ( $cash = mysqli_fetch_array($cash_query) ) { ?>
		                    <option value="<?php echo $cash['id']; ?>"><?php echo $cash['name']; ?></option>
		                    <?php } ?>
		                </select>
		            </td>
				</tr>

		        <tr class="cashin none">
					<td>Kategori*</td>
					<td>
		            	<select name="cash_category" id="cash_category" style="width: auto; max-width: 260px;">
		                    <option value="">Pilih Kategori..</option>
		                    <?php 
		                    $hp_type = hapiut_data($debt_id,'type');
		                    if ($hp_type == 'debt'){
		                        $catout = query_cat('in'); 
		                    } else {
		                        $catout = query_cat('out'); 
		                    }
		                    while ( $cat = mysqli_fetch_array($catout) ) { ?>
		                    <option value="<?php echo $cat['id']; ?>" class="catout"><?php echo $cat['name']; ?></option>
		                    <?php } ?>
							
		                </select>
		            </td>
				</tr> 
        	</table>
        	<div class="submitarea">
		        <input type="button" value="Batal" name="debt_cancel" id="debt_cancel" class="btn batal_btn" onclick="close_debt()" title="Tutup window ini"/>
		        <input type="button" value="Simpan" name="debt_save" id="debt_save" class="btn save_btn" onclick="save_debt()"/>
		        <input type="hidden" id="debtid" value="0" />
		        <input type="hidden" id="hptype" value="<?php echo $hptype_en; ?>" />
		        <div class="notif" id="debt_notif" style="display:none;"></div>
		        <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" id="debt_loader" alt="Mohon ditunggu..." />
			</div>
        </div>
        <?php // End new box hutang ?>

        <?php //new box plus/minus hutang ?>
        <div class="popkat" id="pop_pmdebt" style="width: 430px;">
        	<h3><span id="penkur">Penambahan</span> <?php echo $hptype_cap;?> <span id="titlepopid"></span></h3>
        	<table class="stdtable">
        		<tr>
					<td><span title="Tanggal hutang">Tanggal<span class="harus">*</span></span></td>
					<td>
		            	<input type="text" class="date" name="pmdate" id="pmdate" value="<?php echo date('j F Y'); ?>" title="Tanggal mulai berhutang" />
		                &nbsp;
		                <select name="pmhour" id="pmhour">
		                    <?php $hnow = date('H'); $h = 0; while($h <= 23) { $hshow = sprintf("%02d", $h); ?>
		                    <option value="<?php echo $hshow; ?>" <?php auto_select($hnow,$hshow); ?> ><?php echo $hshow; ?></option>
		                    <?php $h++; } ?>
		                </select>
		                <select name="pmminute" id="pmminute">
		                    <?php $mnow = date('i'); $m = 0; while($m <= 59) { $mshow = sprintf("%02d", $m); ?>
		                    <option value="<?php echo $mshow; ?>" <?php auto_select($mnow,$mshow); ?> ><?php echo $mshow; ?></option>
		                    <?php $m++; } ?>
		                </select>
		            </td>
				</tr>
				<tr>
					<td>Jumlah<span class="harus">*</span></td>
					<td>
						Rp. &nbsp; 
		                <input type="text" class="jnumber right" name="pmamount" id="pmamount" value="0" style="width: 96px;" />
		                <small id="maxtext">Maks: <span id="maxvaltext"></span> (Lunas)</small>
                		<input type="hidden" name="maxval" id="maxval" value="0"/>
					</td>
				</tr>
				<tr>
					<td>Keterangan</td>
					<td><textarea name="pmdesc" id="pmdesc" style="width: 92%; height: 48px;"></textarea></td>
				</tr>
				<tr>
					<td colspan="2">
		            	Catat sebagai <strong id="pminout"><?php echo $hpinout; ?></strong> pada Buku Kas? &nbsp;
		                <select name="catkaspm" id="catkaspm" onchange="catatkaspm()">
		                	<option value="0">Tidak</option>
		                    <option value="1">Ya</option>
		                </select>
		            </td>
				</tr>
		        <tr class="cashinpm none">
					<td>Buku Kas <span class="harus">*</span></td>
					<td>
		            	<select name="pmcash_book" id="pmcash_book" style="width: auto; max-width: 260px;">
		                    <?php $cash_query = querydata_cashbook(); while ( $cash = mysqli_fetch_array($cash_query) ) { ?>
		                    <option value="<?php echo $cash['id']; ?>"><?php echo $cash['name']; ?></option>
		                    <?php } ?>
		                </select>
		            </td>
				</tr>
		        <tr class="cashinpm none">
					<td>Kategori <span class="harus">*</span></td>
					<td>
		            	<select name="pmcash_category" id="pmcash_category" style="width: auto; max-width: 260px;">
		                    <option value="">Pilih Kategori..</option>
							<?php $catout = query_cat($hpcashcat); while ( $cat = mysqli_fetch_array($catout) ) { ?>
		                    <option value="<?php echo $cat['id']; ?>" class="pmcatout"><?php echo $cat['name']; ?></option>
		                    <?php } ?>
		                    <?php $catout = query_cat('in'); while ( $cat = mysqli_fetch_array($catout) ) { ?>
		                    <option value="<?php echo $cat['id']; ?>" class="pmcatin"><?php echo $cat['name']; ?></option>
		                    <?php } ?>
		                </select>
		            </td>
				</tr>
        	</table>
        	<div class="submitarea">
		        <input type="button" value="Batal" name="pm_cancel" id="pm_cancel" class="btn batal_btn" onclick="close_pmhapiut()" title="Tutup window ini"/>
		        <input type="button" value="Simpan" name="pm_save" id="pm_save" class="btn save_btn" onclick="save_pmhapiut()"/>
		        <input type="hidden" id="pmdebtid" value="0" />
		        <input type="hidden" id="pmhptype" value="<?php echo $hptype_en; ?>" />
		        <input type="hidden" id="pmtype" value="" />
		        <div class="notif" id="pm_notif" style="display:none;"></div>
		        <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" id="pm_loader" alt="Mohon ditunggu..." />
			</div>
        </div>
        <?php // End new box hutang ?>

<script type="text/javascript">
$(document).ready(function() {
	$('#datatable_viewhp').DataTable({
		"pageLength": 25,
		"order": [[ 0, "desc" ]],
		"lengthChange": true,
		"searching": true,
		"paging": true,
		"info": false,
		"columnDefs": [
			{ "orderable": false, "targets": 2 },
			{ "orderable": false, "targets": 3 },
			{ "orderable": false, "targets": 4 },
			{ "orderable": false, "targets": 6 }
		],
		language: {
	    	"emptyTable":     "Tidak Ada Data",
	    	"info":           "Menampilkan _START_ sampai _END_ dari total _TOTAL_ Data",
	    	"infoEmpty":      "",
	    	"infoFiltered":   "Tampilkan _MAX_ total Data",
	    	"infoPostFix":    "",
	    	"thousands":      ",",
	    	"lengthMenu":     "Tampilkan _MENU_ Data",
	    	"loadingRecords": "Memuat...",
	    	"processing":     "Memproses...",
	   		 "search":         "",
	   		 "zeroRecords":    "Tidak Ditemukan",
	    	"paginate": {
	        	"first":      "Awal",
	        	"last":       "Akhir",
	        	"next":       "&raquo;",
	        	"previous":   "&laquo;"
	    	},
	    	"aria": {
	        	"sortAscending":  ": Urutkan secara menaik",
	        	"sortDescending": ": Urutkan secara menurun"
	    	}
	    }
	});
});
</script>