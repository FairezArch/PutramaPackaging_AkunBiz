<?php if( is_admin() ){ ?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
        <h2 class="topbar">Daftar Kategori</h2>
        <div class="tooltop" style="height: 34px;">
            <div class="rtrans" onclick="open_newcategory()" title="Buat Kategori">Buat Kategori</div> 
            <div class="clear"></div>
        </div>

        <div class="adminarea">
        	<?php 
        		$topquery = array(
        						array( "urutan"=>"1", "title"=>"Pembelian", "query"=>"master='pg_beli' OR master='pg_beli_tambah' OR master='pd_beli_tambah'
									OR master='pd_retur' OR master='pd_diskon' OR master='pg_beli_gaji' OR master='pg_prod_gaji' OR master='pg_prod_tambah'" ),
								array( "urutan"=>"2", "title"=>"Penjualan",
									"query"=>"master='pd_jual' OR master='pg_jual_tambah' OR master='pd_jual_tambah'
									OR master='pg_retur' OR master='pg_diskon' OR master='pg_jual_gaji' OR master='pg_promo'" ),
							
								array( "urutan"=>"3", "title"=>"Kantor", "query"=>"master='pg_kantor' OR master='pg_kantor_gaji'" ),
								array( "urutan"=>"4", "title"=>"Modal, Hutang Piutang, Pajak",
									"query"=>"master='pg_hutang' OR master='pg_piutang' OR master='pg_prive' OR master='pg_inventaris' OR master='pg_lain' OR master='pg_pajak'
										OR master='pd_piutang' OR master='pd_hutang' OR master='pd_modal' OR master='pd_inventaris' OR master='pd_lain' OR master='pg_pajak'"
								),
							);

        		foreach ($topquery as $segment) {
        			
        	?>
        	<div class="wraptranssaldo" style="border-top: unset; padding-top: 20px;">
        	<h3><?php echo $segment['title'];?></h3>
        	<table class="dataTable" width="100%" id="dataTable_<?php echo $segment['urutan'];?>">
        		<thead>
			      	<tr>
				        <th scope="col">Master</th>
				        <th scope="col">Nama Kategori</th>
				        <th scope="col">Tipe</th>
				        <th scope="col">Keterangan</th>
				        <th scope="col">ID</th>
				        <th scope="col">Aksi</th>
			      	</tr>
			  	</thead>
			  	<tbody>
			  		<?php 
			  			$jangan_hapus = array(1,2,3);
			  			$catquery = $segment["query"];
						$args = "SELECT * FROM category_kas WHERE active='1' AND ( $catquery ) ORDER BY type DESC, master ASC, name ASC";
						$result = mysqli_query( $dbconnect, $args );
						while ( $category = mysqli_fetch_array($result) ) { 
					?>
			  		<tr id="category_<?php echo $category['id'];?>" class="row_<?php echo $category['type']; ?>">
			  			<td class="center"><?php echo catmaster($category['master']); ?></td>
				        <td class="center"><?php echo $category['name']; ?></td>
				        <td class="center"><?php echo inout($category['type']); ?></td>
				        <td><?php echo $category['description']; ?></td>
				        <td class="center" style="width: 64px;"><?php echo $category['id']; ?></td>
				        <td class="center" style="width: 72px;">
				            <input type="hidden" id="pop_name_<?php echo $category['id']; ?>" value="<?php echo $category['name']; ?>"/>
				            <input type="hidden" id="pop_master_<?php echo $category['id']; ?>" value="<?php echo $category['master']; ?>"/>
				            <input type="hidden" id="pop_desc_<?php echo $category['id']; ?>" value="<?php echo $category['description']; ?>"/>
				            <input type="hidden" id="pop_type_<?php echo $category['id']; ?>" value="<?php echo $category['type']; ?>"/>
				   	    	<?php if( !in_array($category['id'], $jangan_hapus) ){ ?>
				            <img class="tabicon" src="penampakan/images/tab_edit.png" width="20" height="20" alt="edit" title="Edit Kategori <?php echo $category['name']; ?>"
				            	onclick="open_editcategory('<?php echo $category['id']; ?>')"/>
				            &nbsp;
				            <img class="tabicon" src="penampakan/images/tab_delete.png" width="20" height="20" alt="edit" title="Hapus Kategori <?php echo $category['name']; ?>"
				            	onclick="open_del_category('<?php echo $category['id']; ?>','<?php echo $category['name']; ?>','<?php echo $category['type']; ?>')"/>
				            <?php } ?>
				        </td>
			  		</tr>
			  		<?php } ?>
			  	</tbody>
        	</table>
        	</div>
        	<script type="text/javascript">
			$(document).ready(function() {
			    //$("#loadnotif").show();
				$('#dataTable_<?php echo $segment['urutan']; ?>').DataTable({
					"paging": false,
					"info": false,
					"bFilter": false,
					"columnDefs": [
						{ "orderable": false, "targets": 3 },
						{ "orderable": false, "targets": 5 }
					],
					language: {
			    		"emptyTable":     "Tidak ada Kategori",
			    		"info":           "Menampilkan _START_ sampai _END_ dari total _TOTAL_ Kategori",
			    		"infoEmpty":      "",
			    		"infoFiltered":   "Tampilkan _MAX_ total Kategori",
			    		"infoPostFix":    "",
			    		"thousands":      ",",
			    		"lengthMenu":     "Tampilkan _MENU_ Kategori",
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
			        //fnInitComplete : function() {
			          //  $("#loadnotif").hide();
			          //  $("#datatable").show();
			          //  $(".catbox").show();
			       // }
				});
			});
			</script>
        	<?php } ?>
        </div>
    </div>
</div>

<?php // start new/edit box ?>
<div class="popkat" id="popnewcategory" style="width: 450px;
">
	<h3><span id="titlepop">BUAT</span> KATEGORI <span id="titlepopid"></span></h3>
	<table class="stdtable">
		<tr>
			<td style="width:116px;">Nama Kategori <span class="harus">*</span></td>
			<td><input maxlength="64" style="width:180px;" type="text" id="category_name" name="category_name"/></td>
		</tr>
		<tr>
			<td>Master <span class="harus">*</span></td>
			<td>
            	<select id="category_master" name="category_master">
            		<optgroup label="Pembelian">
                    	<option class="pg" value="pg_beli">Pembelian</option>
                        <option class="pg" value="pg_beli_tambah">Beban Pembelian</option>
                        <option class="pd" value="pd_beli_tambah">Pendapatan Pembelian</option>
                        <option class="pg" value="pg_beli_gaji">Gaji Pembelian</option>
                        <option class="pg" value="pg_diskon">Diskon Penjualan</option>
                        <?php /*<option class="pd" value="pd_retur">Retur Pembelian</option>
                        <option class="pd" value="pd_diskon">Diskon Pembelian</option>
						<option class="pg" value="pg_retur">Retur Penjualan</option>*/ ?>
                    </optgroup>
                	<optgroup label="Penjualan">
                    	<option class="pd" value="pd_jual">Penjualan</option>
                        <option class="pg" value="pg_jual_tambah">Beban Penjualan</option> 
                        <option class="pd" value="pd_jual_tambah">Pendapatan Penjualan</option>
                        <option class="pg" value="pg_jual_gaji">Gaji Penjualan</option>
                        <option class="pg" value="pg_promo">Iklan</option>     
                    </optgroup>
                    <optgroup label="Kantor">
                    	<option class="pg" value="pg_kantor">Beban Kantor</option>
                        <option class="pg" value="pg_kantor_gaji">Gaji Kantor</option>
                    </optgroup>
                    <optgroup label="Modal, Hutang Piutang, Pajak">
                    	<option class="pg" value="pg_hutang">Pembayaran Hutang</option>
                        <option class="pd" value="pd_hutang">Pemasukan Hutang</option>
                        <option class="pg" value="pg_piutang">Pengeluaran Piutang</option>
                        <option class="pd" value="pd_piutang">Pemasukan Piutang</option>
                        <option class="pg" value="pg_prive">Prive</option>
                        <option class="pd" value="pd_modal">Modal</option>
                        <option class="pg" value="pg_inventaris">Pembelian Inventaris</option>
                        <option class="pd" value="pd_inventaris">Penjualan Inventaris</option>
                        <option class="pg" value="pg_pajak">Pajak</option>
                        <option class="pd" value="pg_lain">Pengeluaran Lain</option>
                        <option class="pd" value="pd_lain">Pemasukan Lain</option>
                    </optgroup>
                </select>
            </td>
		</tr>
		<tr>
		  <td colspan="2">Keterangan</td>
	  </tr>
		<tr>
			<td colspan="2">
            	<textarea id="category_desc" name="category_desc" style="width:98%; height: 64px;"></textarea>
			</td>
		</tr>
	</table>
    <div class="submitarea">
        <input type="button" value="Batal" name="category_cancel" id="category_cancel" class="btn batal_btn" onclick="close_newcategory()" title="Tutup window ini"/>
        <input type="button" value="Simpan" name="category_save" id="category_save" class="btn save_btn" onclick="save_category()"/>
        <input type="hidden" id="categoryid" value="0" />
        <div class="notif none" id="addcategory_notif" style="margin: 10px auto 5px;"></div>
        <img class="loader " src="penampakan/images/conloader.gif" width="32" height="32" id="addcategory_loader" alt="Mohon ditunggu..." />
  </div>
</div>

<?php // start del box ?>
<div class="popup popdel" id="popdelcategory" style="left: 52%;">
	<div id="delquest">
    	<strong>Apakah Anda yakin ingin menghapus Kategori <span class="delcategoryname"></span>?</strong><br />
		Kategori yang sudah dihapus tidak dapat ditampilkan kembali.
        <br /><br />
    	<input type="button" id="delquestcategorycancel" name="delquestcategorycancel" value="Batal" class="btn back_btn" onclick="cancel_del_category()"/>
    	&nbsp;&nbsp;
    	<input type="button" id="delquestcategoryok" name="delquestcategoryok" value="Hapus!" class="btn delete_btn" onclick="del_quest_category()"/>
    	<input type="hidden" id="delcategoryid" name="delcategoryid" value="0"/>
    </div>
    <div id="deloption" class="none">
    	Kategori <span class="delcategoryname"></span><br />
		mungkin sudah memiliki beberapa transaksi di dalamnya,<br />
		<strong>Apa yang harus dilakukan?</strong>
        <br /><br />
        <select name="catdeloption" id="catdeloption">
        	<option value="delete">Hapus semua transaksi itu</option>
            <?php $args_del = "SELECT id, name, type FROM category_kas WHERE active='1' ORDER BY name ASC";
				$result_del = mysqli_query( $dbconnect, $args_del );
				while ( $cat_del = mysqli_fetch_array($result_del) ) { ?>
            	<option class="type_<?php echo $cat_del['type']; ?> none thecatmove" value="move_<?php echo $cat_del['id']; ?>">
                	Pindahkan ke kategori: <?php echo $cat_del['name']; ?>
				</option>
            <?php } ?>
        </select>
        <br /><br />
    	<input type="button" id="delcategorycancel" name="delcategorycancel" value="Batal" class="btn back_btn" onclick="cancel_del_category()"/>
    	&nbsp;&nbsp;
    	<input type="button" id="delcategoryok" name="delcategoryok" value="Hapus!" class="btn delete_btn" onclick="del_category()"/>
    	<input type="hidden" id="delcategoryid" name="delcategoryid" value="0"/>
    </div>
    
</div>
<?php } ?>