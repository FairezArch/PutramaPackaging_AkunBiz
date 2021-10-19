<?php if( is_admin() ){ 

	$data_inventory = table_inv(2);
?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
            <h2 class="topbar">Inventaris Gudang</h2>
                <div class="tooltop" style="height: 34px;">
                    <div class="rtrans" onclick="new_invoffice()" title="Tambah Inventaris">Tambah Inventaris</div>
                </div>
                <div class="clear"></div>

         <div class="adminarea">
            <table class="dataTable" width="100%" border="0" id="datatable_inventaris">
	            <thead>
	                <tr>
	                    <th scope="col">Status</th>
	                    <th scope="col">Kode Barang</th>
	                    <th scope="col">Nama</th>
	                    <th scope="col">Deskripsi</th>
	                    <th scope="col">Tanggal Beli</th>
	                    <th scope="col">Jumlah</th>
	                    <th scope="col">Nilai Sekarang</th>
	                    <th scope="col">Fluktuasi</th>
	                    <th scope="col">Klien</th>
	                    <th scope="col">ID</th>
	                    <th scope="col" width="50">opsi</th>
	                </tr>
	            </thead>
	            <tbody>
	            	<?php while( $data = mysqli_fetch_array($data_inventory) ){ ?>
	            	<tr id="inv_<?php echo $data['id']?>">
	            		<td class="center"><?php echo inv_status($data['aktif']);?></td>
	            		<td class="center"><?php if( $data['kd_barang'] != 0 ){ echo $data['kd_barang']; }?></td>
	            		<td><?php echo $data['name'];?></td>
	            		<td class="center"><?php echo $data['description'];?></td>
	            		<td class="center"><?php echo date('j M Y',$data['date']);?></td>
	            		<td class="center"><?php if( $data['jumlah_barang'] !='0' ){ echo $data['jumlah_barang']; }?></td>
	            		<td><?php if ( 1 == $data['aktif'] ) { echo uang(inv_value($data['id']))."<br />"; } else { echo uang('0')."<br />"; } ?>
			                <small>Dari nilai awal <?php echo uang($data['price_start']); ?></small>
			            </td>
	            		<td><?php if( 1 == $data['aktif'] ) { if( 'min' == $data['fluktuasi_type'] ){ 
	            			echo "Menurun <br /><small> Nilai penurunan: ".uang($data['fluktuasi_val'])." Per bulan.<br /> Umur: ".inv_umur($data['id']).", max ".$data['inv_age']." tahun.</small>"; }else{ echo "Tetap";}
	            			} else if( 2 == $data['aktif'] ){ echo "<small>Dijual tanggal ".date('j M Y', $data['date'])." dengan harga ".uang($data['price_sell']);
	            			} else if( 3 == $data['aktif'] ){ echo "Dibuang tanggal ".date('j M Y',$data['date']); 
	            			} else{}?>
	            		</td>
	            		<td><?php echo $data['klien'];?></td>
	            		<td><?php echo $data['id'];?></td>
	            		<td class="center nowrap">
	            			<?php if( 1 == $data['aktif'] ){ ?>
		            			<img src="penampakan/images/tab_sell.png" class="tabicon" title="Jual invertaris ini" onclick="open_sell_inv('<?php echo $data["id"];?>')">
		            			<img src="penampakan/images/tab_bin.png" class="tabicon" title="Buang inventaris ini" onclick="open_dump_inv('<?php echo $data["id"];?>')">
		            			<img src="penampakan/images/tab_edit.png" class="tabicon" title="tab detail" onclick="open_edit_inv('<?php echo $data["id"];?>')">
		            			<img src="penampakan/images/tab_delete.png" class="tabicon" title="tab detail" onclick="open_del_inv('<?php echo $data["id"];?>')">
	            			<?php } else{ ?>
	            				<img src="penampakan/images/tab_reload.png" class="tabicon" title="Kembalikan status inventaris menjadi aktif kembali" onclick="open_back_inv('<?php echo $data["id"];?>')">
	            			<?php } ?>
	            			<input type="hidden" id="name_<?php echo $data['id']; ?>" value="<?php echo $data['name']; ?>"/>
	            			<input type="hidden" id="Jumlah_<?php echo $data['id'];?>" value="<?php echo $data['jumlah_barang'];?>" />
			                <input type="hidden" id="amount_<?php echo $data['id']; ?>" value="<?php echo $data['price_start']; ?>"/>
			                <input type="hidden" id="date_<?php echo $data['id']; ?>" value="<?php echo date('j F Y', $data['date']); ?>"/>
			                <input type="hidden" id="hour_<?php echo $data['id']; ?>" value="<?php echo date('H', $data['date']); ?>"/>
			                <input type="hidden" id="minute_<?php echo $data['id']; ?>" value="<?php echo date('i', $data['date']); ?>"/>
			                <input type="hidden" id="fluktype_<?php echo $data['id']; ?>" value="<?php echo $data['fluktuasi_type']; ?>"/>
			                <input type="hidden" id="ecoage_<?php echo $data['id']; ?>" value="<?php echo $data['inv_age']; ?>"/>
                			<input type="hidden" id="desc_<?php echo $data['id']; ?>" value="<?php echo $data['description']; ?>"/>
                			<input type="hidden" id="person_<?php echo $data['id']; ?>" value="<?php echo $data['klien']; ?>"/>
                			<?php $catkas = catkas_inv($data['id']); ?>
			                <input type="hidden" id="catkas_<?php echo $data['id']; ?>" value="<?php echo $catkas[0]; ?>"/>
			                <input type="hidden" id="cash_book_<?php echo $data['id']; ?>" value="<?php echo $catkas[1]; ?>"/>
			                <input type="hidden" id="cash_category_<?php echo $data['id']; ?>" value="<?php echo $catkas[2]; ?>"/>
	            		</td>
	            	</tr>
	            	<?php } ?>
	            </tbody>
        	</table>
        </div>

        <?php //new box inventaris ?>
        <div class="popkat" id="pop_inventaris" style="width: 430px; top: 36%;">
        	<h3 style="padding-bottom: 5px;"><span id="titlepop">Tambah</span> Inventaris Gudang <span id="titlepopid"></span></h3>
        	<table class="stdtable">
        		<tr>
        			<td>Kode Barang <span class="harus">*</span></td>
        			<td><input type="text" name="kd_nameitem" id="kd_nameitem" style="width: 200px;"/></td>
        		</tr>
        		<tr>
        			<td>Nama Barang <span class="harus">*</span></td>
        			<td><input type="text" name="name_item" id="name_item" style="width: 200px;"/></td>
        		</tr>
        		<tr>
        			<td>Jumlah Barang</td>
        			<td><input type="number" name="jumlah_item" id="jumlah_item" style="width: 200px;"/></td>
        		</tr>
        		<tr>
        			<td>Harga <span class="harus">*</span></td>
        			<td><input type="text" name="amount_item" id="amount_item" class="jnumber right" style="width: 200px;"/></td>
        		</tr>
        		<tr>
					<td><span title="Tanggal pembelian">Tanggal<span class="harus">*</span></span></td>
					<td>
		            	<input type="text" class="date" name="date" id="date" value="<?php echo date('j F Y'); ?>"/>
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
					<td>Klien</td>
					<td><input type="text" name="person" id="person" style="width: 200px;" title="Dari siapa Anda membeli?" /></td>
				</tr>
				<tr>
					<td>Fluktuasi Nilai <span class="harus">*</span></td>
					<td>
						<select name="fluk_type" id="fluk_type" title="Menurun: misalnya komputer, meja, kursi, kendaraan.">
							<option value="min">Menurun</option>
							<option value="zero">Tetap</option>
						</select>
					</td>
				</tr>
				<tr class="flukmin">
					<td>Umur Ekonomis <span class="harus">*</span></td>
					<td><select name="item_age" id="item_age">
						<?php $x=1; while($x <= 20){ ?>
								<option value="<?php echo $x;?>"><?php echo $x;?></option>
							<?php $x++;} ?>
					</select></td>
				</tr>
				<tr>
					<td>Deskripsi</td>
					<td><input type="text" name="desc" id="desc" style="width: 92%;" /></td>
				</tr>
				<tr>
					<td colspan="2">
		            	Catat sebagai Pengeluaran pada Buku Kas? &nbsp;
		                <select name="catkas" id="catkas" onchange="catatkas()"
		                	title="Jika Anda membelinya secara tunai, Anda bisa sekaligus mencatatnya sebagai pengeluaran pada buku Kas">
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
					<td>Kategori <span class="harus">*</span></td>
					<td>
		            	<select name="cash_category" id="cash_category" style="width: auto; max-width: 260px;">
		                    <option value="">Pilih Kategori..</option>
							<?php $catout = query_cat('out'); while ( $cat = mysqli_fetch_array($catout) ) { ?>
		                    <option value="<?php echo $cat['id']; ?>" class="catout"><?php echo $cat['name']; ?></option>
		                    <?php } ?>
		                </select>
		            </td>
				</tr>
        	</table>
        	<div class="submitarea">
		        <input type="button" value="Batal" name="inv_cancel" id="inv_cancel" class="btn batal_btn" onclick="close_invoffice()" title="Tutup window ini"/>
		        <input type="button" value="Simpan" name="trans_inv" id="trans_inv" class="btn save_btn" onclick="save_invoffice()"/>
		        <input type="hidden" id="inv_id" value="0" />
		        <input type="hidden" id="inv_type" value="2" />
		        <input type="hidden" id="inv_status" value="1">
		        <div class="notif" id="notif" style="display:none;"></div>
		        <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" id="inv_loader" alt="Mohon ditunggu..." />
			</div>
        </div>
        <?php // End new box inventaris ?>

        <?php // del box ?>
        <div class="popup popdel" id="popupdelinv" style="left: 50%;">
        	<strong>Apakah Anda yakin ingin menghapus Inventaris ID <span id="del_invid"></span> ?</strong><br />
        	Seluruh transaksi yang berkaitan dengan Inventaris ini juga akan terhapus serta tidak dapat ditampilkan kembali.
    		Hal ini juga berpengaruh terhadap seluruh Laporan yang berkaitan dengan Inventaris dan transaksi-transaksi tersebut.
    		<br /><br />
    		<input type="button" id="delcancel_inv" name="delcancel_inv" class="btn back_btn" value="Batal" onclick="cancel_del_inv()"/>
		    &nbsp;&nbsp;
		    <input type="button" id="delinvok" name="delinvok" class="btn delete_btn" value="Hapus!" onclick="del_inv()"/>
		    <input type="hidden" id="delinvid" name="delinvid" value="0"/>
        </div>
        <?php // End del box ?>

        <?php // dump box ?>
        <div class="popup popdel" id="popdumpinv" style="left: 50%;">
			Apakah Anda yakin ingin membuang Inventaris ID <span id="dump_invid"></span> ?
		    <br /><br />
		    <input type="button" id="deldump_inv" name="deldump_inv" class="btn back_btn" value="Batal" onclick="cancel_dump_inv()"/>
		    &nbsp;&nbsp;
		    <input type="button" id="dumpinvok" name="dumpinvok" class="btn delete_btn" value="Buang!" onclick="dump_inv()"/>
		    <input type="hidden" id="dumpinvid" name="dumpinvid" value="0"/>
		</div>
		<?php // End dump box ?>

		<?php // start reload box ?>
		<div class="popup popdel" id="popreloadinv" style="left: 50%;">
			Apakah Anda yakin ingin mengembalikan status Inventaris ID <span id="backinvid_text"></span><br />
			<strong>menjadi aktif</strong> kembali?<br />
			Transaksi Buku Kas yang terkait dengan penjualan Inventaris ini<br />
			juga akan ikut terhapus.
		    <br /><br />
		    <input type="button" id="delreloadcancel" name="delreloadcancel" class="btn back_btn" value="Batal" onclick="cancel_back_inv()"/>
		    &nbsp;&nbsp;
		    <input type="button" id="reloadinvok" name="reloadinvok" class="btn delete_btn" value="Kembalikan!" onclick="back_inv()"/>
		    <input type="hidden" id="reloadinvid" name="reloadinvid" value="0"/>
		</div>
		<?php // End reload box ?>

		<?php // start sell box ?>
		<div class="poptrans cashout" id="popsellinv" style="top: 70%; left: 50%;">
			<h3>JUAL INVENTARIS ID <span id="titlesellid"></span></h3>
			<table class="stdtable">
		        <tr>
					<td>Harga Penjualan*</td>
					<td>
		                <input type="text" class="jnumber right" name="amountsell" id="amountsell" value="0" style="width: 96px;"/>
					</td>
				</tr>
				<tr>
					<td colspan="2">
		            	Catat sebagai Pemasukan pada Buku Kas? &nbsp;
		                <select name="catkassell" id="catkassell" onchange="catatkassell()"
		                	title="Jika Anda menjualnya secara tunai, Anda bisa sekaligus mencatatnya sebagai pemasukan pada buku Kas">
		                	<option value="0">Tidak</option>
		                    <option value="1">Ya</option>
		                </select>
		            </td>
				</tr>
		        <tr class="cashinsell none">
					<td>Buku Kas <span class="harus">*</span></td>
					<td>
		            	<select name="cash_book_sell" id="cash_book_sell" style="width: auto; max-width: 260px;">
		                    <?php $cash_query = querydata_cashbook(); while ( $cash = mysqli_fetch_array($cash_query) ) { ?>
		                    <option value="<?php echo $cash['id']; ?>"><?php echo $cash['name']; ?></option>
		                    <?php } ?>
		                </select>
		            </td>
				</tr>
		        <tr class="cashinsell none">
					<td>Kategori <span class="harus">*</span></td>
					<td>
		            	<select name="cash_category_sell" id="cash_category_sell" style="width: auto; max-width: 260px;">
		                    <option value="">Pilih Kategori..</option>
							<?php $catin = query_cat('in'); while ( $cat = mysqli_fetch_array($catin) ) { ?>
		                    <option value="<?php echo $cat['id']; ?>" class="catin"><?php echo $cat['name']; ?></option>
		                    <?php } ?>
		                </select>
		            </td>
				</tr>
			</table>
		    <div class="submitarea">
		        <input type="button" value="Batal" name="sell_cancel" id="sell_cancel" class="btn batal_btn" onclick="close_sell()" title="Tutup window ini"/>
		        <input type="button" value="Jual!" name="trans_sell" id="trans_sell" class="btn save_btn" onclick="save_sell()"/>
		        <input type="hidden" id="sellinvid" value="0" />
		        <div class="notif" id="sell_notif" style="display:none;"></div>
		        <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" id="sell_loader" alt="Mohon ditunggu..." />
			</div>
		</div>
		<?php // End sell box ?>
</div>
</div>
<?php } ?>
<script type="text/javascript">
$(document).ready(function() {
    $('#datatable_inventaris').DataTable({
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
            { "orderable": false, "targets": 5 },
            { "orderable": false, "targets": 6 },
            { "orderable": false, "targets": 8 },
            { "orderable": false, "targets": 9 },
            { "orderable": false, "targets": 10 }
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