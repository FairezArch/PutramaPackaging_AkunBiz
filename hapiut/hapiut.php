<?php 
if( is_admin() ){
	if( 'hutang' == $_GET['hapiut']){
		$hptype = 'hutang';
		$hptype_acap = 'HUTANG';
		$hptype_cap = 'Hutang';
		$hptype_en = 'debt';
		$hpber = 'berhutang';
		$hpfrom = 'dari';
		$hpto = 'kepada';
		$hpinout = 'Pemasukan';
		$hpcashcat = 'in';
	}else{
		$hptype = 'piutang';
		$hptype_acap = 'PIUTANG';
		$hptype_cap = 'Piutang';
		$hptype_en = 'credit';
		$hpber = 'berpiutang';
		$hpfrom = 'kepada';
		$hpto = 'dari';
		$hpinout = 'Pengeluaran';
		$hpcashcat = 'out';
	}

	if ( isset($_GET['command']) ) { // format: 9_2016
		$tgl_from = strtotime($_GET['datefrom']);
		$tgl_to = strtotime($_GET['dateto']) + 86399;
		$baseurl = "hapiut=".$hptype."&datefrom=".$tgl_from."&dateto=".$tgl_to."&command=Go!";
	} else {
	    $tgl_from = mktime(0,0,0,date('n'),1,date('Y'));
	    $tgl_to = mktime(0,0,0,date('n'),date('t'),date('Y')) + 86399;

	}
$url_download = "date_from=".$tgl_from."&date_to=".$tgl_to;
?>

<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
    	<?php if ( isset($_GET['viewdebt'])) { include 'debt-view.php'; }else{ ?> 
        <h2 class="topbar">Daftar <?php echo $hptype_cap;?></h2>
        <div class="tooltop" style="height: 34px;">
        	<div class="ltool">
                <form method="get" name="thetop">
	                <input type="hidden" name="hapiut" value="<?php echo $hptype; ?>"/>
	                <?php if ( isset($_GET['datefrom']) ) { $inputfrom = $_GET['datefrom']; }
	                else { $inputfrom = '1 '.date('F Y',mktime(0,0,0,date('n'),1,date('Y'))); } ?>
	                <input type="text" class="datepicker" style="width:120px;" name="datefrom" id="datefrom" value="<?php echo $inputfrom; ?>"/>
	                &nbsp;Sampai&nbsp; 
	                <?php if ( isset($_GET['dateto']) ) { $inputto = $_GET['dateto']; }
	                else { $inputto = date('t F Y'); } ?>
	                <input type="text" class="datepicker" style="width:120px;" name="dateto" id="dateto" value="<?php echo $inputto; ?>"/>    
	                &nbsp; 
	                <input type="submit" class="btn save_btn" name="command" value="Go"/>
                </form>
            </div>
            <div class="rtrans" onclick="open_debt()" title="Tambah <?php echo $hptype_acap;?>">Tambah <?php echo $hptype_cap;?></div>
                <a href="<?php echo GLOBAL_URL;?>/export_excel/xls_laporanHutang.php?<?php echo $url_download;?>" title="Download dalam bentuk file Ms Excel">
	                <div class="rtrans xls" style="margin-right: 200px;"><img src="<?php echo GLOBAL_URL;?>/penampakan/images/excel.png"></div>
                </a>
            </div>
            <div class="clear"></div>
            <div class="loadnotif" id="loadnotif">
	            <img src="penampakan/images/loading-notif.gif" width="42" height="42" alt="please wait" />
	            <div class="reportloadtext">Memuat data, mohon ditunggu...</div>
            </div>
    	<div class="adminarea">
        	<table class="dataTable" width="100%" border="0" id="datatable_hapiut">
            <thead>
                <tr>
                    <th scope="col">Status</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Klien</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">ID</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>   
            <tbody> 
                <?php
                $args = "SELECT * FROM hapiut WHERE type='$hptype_en' AND aktif='1' AND date >= '$tgl_from' AND date < '$tgl_to' ORDER BY status DESC, date DESC";
                $result = mysqli_query( $dbconnect, $args );
                while ( $data_hapiut = mysqli_fetch_array($result) ) { ?>
                <tr id="hapiut_<?php echo $data_hapiut['id'];?>">
                    <td class="center"><?php if( '1' == $data_hapiut['status']){ echo 'Hutang';}else{ echo 'Lunas'; } ?></td>
                    <td class="center"><?php echo $ambil_tanggal = date("d M Y",$data_hapiut['date']); ?></td>
                    <td class="center"><?php echo $data_hapiut['person']; ?></td>
                    <td class="center">
                    	<?php echo uang($data_hapiut['saldonow']); ?><br />
                    	<small><?php echo $hptype_cap; ?> Awal: <?php echo uang($data_hapiut['saldostart']);?></small>
                    </td>
                    <td class="center"><?php echo $data_hapiut['description']; ?></td>
                    <td class="center"><?php echo $data_hapiut['id']; ?></td>
                    <td class="center">
                    	<img class="tabicon" src="penampakan/images/list-plus.png" width="20" height="20" alt="plus"
		                	onclick="plusmin_hapiut('plus','<?php echo $data_hapiut['id']; ?>')"
		                	title="Tambah <?php echo $hptype;?> lagi dari <?php echo $data_hapiut['person']; ?>" />
		                &nbsp;
		                <img class="tabicon" src="penampakan/images/list-min.png" width="20" height="20" alt="min"
		                	onclick="plusmin_hapiut('min','<?php echo $data_hapiut['id']; ?>')"
		                    title="Bayar sebagian atau seluruh hutang kepada <?php echo $data_hapiut['person']; ?>"/>
		                &nbsp;
                    	<a href="?hapiut=<?php echo $hptype;?>&viewdebt=<?php echo $data_hapiut['id']; ?>">
                			<img class="tabicon" src="penampakan/images/tab_detail.png" width="20" height="20" alt="detail" title="Lihat, edit, hapus riwayat pembayaran atau penambahan <?php echo $hptype_cap; ?>"/>
               			 </a>

               			<input type="hidden" id="person_<?php echo $data_hapiut['id']?>" value="<?php echo $data_hapiut['person']; ?>" />
               			<input type="hidden" id="date_<?php echo $data_hapiut['id']?>" value="<?php echo date('j F Y', $data_hapiut['date']); ?>" />
               			<input type="hidden" id="hour_<?php echo $data_hapiut['id']?>" value="<?php echo date('H', $data_hapiut['date']); ?>" />
               			<input type="hidden" id="minute_<?php echo $data_hapiut['id']?>" value="<?php echo date('i', $data_hapiut['date']); ?>" />
               			<input type="hidden" id="amount_<?php echo $data_hapiut['id']?>" value="<?php echo $data_hapiut['saldostart']; ?>" />
               			<input type="hidden" id="desc_<?php echo $data_hapiut['id']?>" value="<?php echo $data_hapiut['description']; ?>" />
               			<input type="hidden" id="saldonowtext_<?php echo $data_hapiut['id']?>" value="<?php echo uang($data_hapiut['saldonow']); ?>" />
               			<input type="hidden" id="saldonow_<?php echo $data_hapiut['id']?>" value="<?php echo $data_hapiut['saldonow']; ?>" />
               			<?php $catkas = catkas($data_hapiut['id']); ?>
		                <input type="hidden" id="catkas_<?php echo $data_hapiut['id']; ?>" value="<?php echo $catkas[0]; ?>"/>
		                <input type="hidden" id="cash_book_<?php echo $data_hapiut['id']; ?>" value="<?php echo $catkas[1]; ?>"/>
		                <input type="hidden" id="cash_category_<?php echo $data_hapiut['id']; ?>" value="<?php echo $catkas[2]; ?>"/>
               			<input type="hidden" id="hptype_<?php echo $data_hapiut['id']; ?>" value="<?php echo $hptype_en;?>"/>
                    </td>
                </tr>
                <?php } ?>
            </tbody>       
            </table>
        </div>

        <?php //new box hapiut ?>
        <div class="popkat" id="pop_debt" style="width: 430px;">
        	<h3><span id="titlepop">Tambah</span> <?php echo $hptype_cap;?> <span id="titlepopid"></span></h3>
        	<table class="stdtable">
        		<tr>
		          	<td>Klien <span class="harus">*</span></td>
		          	<td><input type="text" name="person" id="person" style="width: 200px;" title="Kepada siapa Anda <?php echo $hpber;?>?" /></td>
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
		            	Catat sebagai <?php echo $hpinout;?> pada Buku Kas? &nbsp;
		                <select name="catkas" id="catkas" onchange="catatkas()"
		                	title="Jika ini adalah <?php echo $hpinout;?> uang tunai, Anda bisa sekaligus mencatatnya sebagai <?php echo $hpinout;?> pada buku Kas">
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
							<?php $catout = query_cat('out'); while ( $cat = mysqli_fetch_array($catout) ) { ?>
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
		        <input type="button" value="Batal" name="debt_cancel" id="debt_cancel" class="btn batal_btn" onclick="close_debt()" title="Tutup window ini"/>
		        <input type="button" value="Simpan" name="debt_save" id="debt_save" class="btn save_btn" onclick="save_debt()"/>
		        <input type="hidden" id="debtid" value="0" />
		        <input type="hidden" id="pmhptype" value="<?php echo $hptype_en;?>" />
		        <input type="hidden" id="hptype" value="<?php echo $hptype_en;?>" />
		        <div class="notif" id="debt_notif" style="display:none;"></div>
		        <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" id="debt_loader" alt="Mohon ditunggu..." />
			</div>
        </div>
        <?php // End new box hutang ?>

        <?php //new box plus/min hutang ?>
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
		            	Catat sebagai <strong id="pminout"><?php echo $hpinout;?></strong> pada Buku Kas? &nbsp;
		                <select name="catkaspm" id="catkaspm" onchange="catatkaspm()">
		                	<option value="0">Tidak</option>
		                    <option value="1">Ya</option>
		                </select>
		            </td>
				</tr>
		        <tr class="cashinpm none">
					<td>Buku Kas <span class="harus">*</span></td>
					<td>
		            	<select name="cash_book" id="cash_book" style="width: auto; max-width: 260px;">
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
		                    <?php $catout = query_cat('out'); while ( $cat = mysqli_fetch_array($catout) ) { ?>
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
		        <input type="hidden" id="pmhptype" value="<?php echo $hptype_en;?>" />
		        <input type="hidden" id="pmtype" value="" />
		        <div class="notif" id="pm_notif" style="display:none;"></div>
		        <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" id="pm_loader" alt="Mohon ditunggu..." />
			</div>
        </div>
        <?php // End new box hutang ?>
<?php } ?>
</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$("#loadnotif").show();
	$('#datatable_hapiut').DataTable({
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
	    },
        fnInitComplete : function() {
            $("#loadnotif").hide();
            $("#datatable_hapiut").show();
        }
	});
});
</script>

<?php }?>