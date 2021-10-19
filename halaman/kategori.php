<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
        <h2 class="topbar">Kategori Produk</h2>
        
        <?php if( is_admin() || is_ho_logistik() ){ ?>
        <div class="tooltop" style="height: 34px;">
            <div class="rtrans" onclick="addkategori()" title="Tambah Kategori">Tambah Kategori</div> 
            <div class="clear"></div>
        </div>
        <?php } ?>
        
    	<div class="adminarea">
            <table class="dataTable" width="100%" border="0" id="datatable_katmaster">
            <thead>
                <tr>
                    <th scope="col" style="width:50px;">ID</th>
                    <th scope="col">Kategori</th>
                    <th scope="col" style="width:100px;">jumlah</th>
                    <th scope="col" style="width:50px;">Urutan</th>
                    <?php if( is_admin() || is_ho_logistik() ){ ?>  
                    <th scope="col" width="100px">opsi</th>
                    <?php } ?>
                </tr>
            </thead>    
            <tbody>   
                <?php
                $result = query_list_kategori('master');
                if($result){
                while ( $data_kategori = mysqli_fetch_array($result) ) {
                $jumlah = get_jmlprod_kategori($data_kategori['id'],'master');?>
                <tr>
                    <td class="center" id="id_<?php echo $data_kategori['id']; ?>" ><?php echo $data_kategori['id']; ?></td>
                    <td ><?php echo $data_kategori['kategori']; ?></td>
                    <td class="right"><?php echo $jumlah; ?> Produk</td>
                    <td class="center"><?php echo $data_kategori['urutan']; ?></td>
                    
                    <?php if( is_admin() || is_ho_logistik() ){ ?>  
                    <td class="center nowrap">
                        <img src="penampakan/images/tab_edit.png" title="Edit Kategori Master <?php echo $data_kategori['kategori']; ?>" alt="Edit Kategori Master <?php echo $data_kategori['kategori']; ?>" onclick="editkat('kategori','<?php echo $data_kategori['id']; ?>')" class="pointer">
                        <?php if( $jumlah == 0){ ?>
                        &nbsp;
                        <img src="penampakan/images/tab_delete.png" title="Hapus Kategori Master <?php echo $data_kategori['kategori']; ?>" alt="Hapus Kategori Master <?php echo $data_kategori['kategori']; ?>" onclick="open_del_kategori('<?php echo $data_kategori['id']; ?>')" class="pointer">
				        <?php } ?>
				    </td>
                    <?php } ?>
                    
                    <input type="hidden" id="idkat_<?php echo $data_kategori['id']; ?>" value="<?php echo $data_kategori['id']; ?>" />
                    <input type="hidden" id="katname_<?php echo $data_kategori['id']; ?>" value="<?php echo $data_kategori['kategori']; ?>" />
                    <input type="hidden" id="image_<?php echo $data_kategori['id']; ?>" value="<?php echo $data_kategori['imgkategori']; ?>" />
                    <input type="hidden" id="urutan_<?php echo $data_kategori['id']; ?>" value="<?php echo $data_kategori['urutan']; ?>" />
                </tr>
                <?php } } ?>
            </tbody>     
            </table>
        </div>
    </div>
    <div class="popkat" id="popkat">
    	<h3>Tambah Kategori</h3>
        <table class="detailtab" width="100%">
			<input type="hidden" id="idkategori" name="idkategori" />
        	<tr>
                <td>Buat Kategori Produk<span class="harus">*</span></td>
                <td><input type="text" name="kat_name" id="kat_name"></td>
            </tr>
            <tr>
                <td>Nomer Urutan<span class="harus"></span></td>
                <td><input type="text" name="urutan" id="urutan"></td>
            </tr>
            <tr>
                <td class="center" colspan="2" id="tmpt_img"></td>
            </tr>
            <tr>
                <td class="center">
                    <div id="progress" class="progress">
                        <div class="progress-bar progress-bar-success"></div>
                        <div id="proses" class="proses">Mengupload...</div>
                        <div class="clear"></div>
                    </div>
                </td>
                <td class="right">
                    <div style="padding:8px 0;">
                        <label for="fileupload" class="btn upload_btn">Pilih Gambar</label>
                        <input id="fileupload" style="display:none;" class="fileupload" type="file" name="files[]" onclick="upload_gambar()"/>
                    </div>
                </td>
            </tr>
            <input type="hidden" id="imgkategori" name="imgkategori" />
        </table>
        <div class="submitarea">
            <input class="btn batal_btn" type="button" value="Batal" onclick="close_kat()" title="Tutup window ini"/>
            <input class="btn save_btn" type="button" value="Simpan" onclick="updatekat()"  title="Simpan update data"/>
            <div id="notif" class="notif" style="display:none;"></div>
            <img id="loader" src="penampakan/images/conloader.gif" width="32" height="32">
        </div>
    </div>
    
    <div class="option_body kategori_body">
        <h2 class="topbar">Sub Kategori Produk</h2>
        
        <?php if( is_admin() || is_ho_logistik() ){ ?>
        <div class="tooltop" style="height: 34px;">
            <div class="rtrans" onclick="addsubkategori()" title="Tambah Sub Kategori">Tambah Sub Kategori</div> 
            <div class="clear"></div>
        </div>
        <?php } ?>
        
    	<div class="adminarea">
            <table class="dataTable" width="100%" border="0" id="datatable_katchild">
            <thead>
                <tr>
                    <th scope="col" style="width:50px;">ID</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Master Kategori</th>
                    <th scope="col" style="width:100px;">jumlah</th>
                    <?php if( is_admin() || is_ho_logistik() ){ ?>  
                    <th scope="col" width="100">opsi</th>
                    <?php } ?>
                </tr>
            </thead>    
            <tbody>   
                <?php
                $result = query_list_kategori('child');
                if($result){
                while ( $data_kategori = mysqli_fetch_array($result) ) {
                $jumlah = get_jmlprod_kategori($data_kategori['id'],'child');  ?>
                <tr>
                    <td class="center" id="id_<?php echo $data_kategori['id']; ?>" ><?php echo $data_kategori['id']; ?></td>
                    <td ><?php echo $data_kategori['kategori']; ?></td>
                    <td data-order="<?php echo data_kategori($data_kategori['id_master'],'kategori'); ?>" data-search="<?php echo data_kategori($data_kategori['id_master'],'kategori'); ?>">
                        <?php echo data_kategori($data_kategori['id_master'],'kategori'); ?>
                    </td>
                    <td class="right"><?php echo $jumlah; ?> Produk</td>
                    
                    <?php if( is_admin() || is_ho_logistik() ){ ?>   
                    <td class="center nowrap">
                        <img src="penampakan/images/tab_edit.png" title="Edit Sub Kategori Master <?php echo $data_kategori['kategori']; ?>" alt="Edit Sub Kategori Master <?php echo $data_kategori['kategori']; ?>" onclick="edit_subkat('<?php echo $data_kategori['id']; ?>')" class="pointer">
                        <?php if( $jumlah == 0){ ?>
                        &nbsp;
                        <img src="penampakan/images/tab_delete.png" title="Hapus Sub Kategori Master <?php echo $data_kategori['kategori']; ?>" alt="Hapus Sub Kategori Master <?php echo $data_kategori['kategori']; ?>" onclick="open_del_kategori('<?php echo $data_kategori['id']; ?>')" class="pointer">
				        <?php } ?>
				    </td>
                    <?php } ?>
                    
                    <input type="hidden" id="sub_idkat_<?php echo $data_kategori['id']; ?>" value="<?php echo $data_kategori['id']; ?>" />
                    <input type="hidden" id="sub_katname_<?php echo $data_kategori['id']; ?>" value="<?php echo $data_kategori['kategori']; ?>" />
                    <input type="hidden" id="sub_idmaster_<?php echo $data_kategori['id']; ?>" value="<?php echo $data_kategori['id_master']; ?>" />
                    <input type="hidden" id="sub_img_<?php echo $data_kategori['id']; ?>" value="<?php echo $data_kategori['imgkategori']; ?>" />
                </tr>
                <?php } } ?>
            </tbody>     
            </table>
        </div>
    </div>
    
    <div class="popkat" id="pop_subkategori" style="width:500px;">
    	<h3>Tambah Sub Kategori</h3>
        <table class="detailtab" width="100%">
			<input type="hidden" id="idsubkategori" name="idsubkategori" value="0"/>
        	<tr>
                <td>Master Kategori<span class="harus">*</span></td>
                <td>
                    <select id="id_masterct" class="id_masterct" style="width:200px; max-width:200px;">
                        <option value="0">Pilih Master Kategori</option>
                        <?php $query_mct = query_list_kategori('master'); while ( $mct = mysqli_fetch_array($query_mct) ) { ?>
                            <option value="<?php echo $mct['id']; ?>" class="catout" ><?php echo $mct['kategori']; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Nama Sub Kategori<span class="harus">*</span></td>
                <td><input type="text" name="sub_namect" id="sub_namect"></td>
            </tr>
            <tr>
                <td class="center" colspan="2" id="tmpt_img_sub"></td>
            </tr>
            <tr>
                <td class="center">
                    <div id="progress" class="progress">
                        <div class="progress-bar progress-bar-success"></div>
                        <div id="proses" class="proses">Mengupload...</div>
                        <div class="clear"></div>
                    </div>
                </td>
                <td class="right">
                    <div style="padding:8px 0;">
                        <label for="fileupload" class="btn upload_btn">Pilih Gambar</label>
                        <input id="fileupload" style="display:none;" class="fileupload" type="file" name="files[]" onclick="upload_gambar()"/>
                    </div>
                </td>
            </tr>
            <input type="hidden" id="imgkategori_sub" name="imgkategori_sub" />
        </table>
        <div class="submitarea">
            <input class="btn batal_btn" type="button" value="Batal" onclick="close_subkat()" title="Tutup window ini"/>
            <input class="btn save_btn" type="button" value="Simpan" onclick="save_subkategori()"  title="Simpan update data"/> 
            <img id="loader_subkat" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:0px; right:120px;">
            <div id="notif_subkat" class="notif" style="display:none;"></div>
        </div>
    </div>
</div>

<?php // start del box ?>
<div class="popup popdel" id="popdel" style="left: 50%;">
	<strong>PERHATIAN!</strong><br />Apakah Anda yakin ingin menghapusnya? Data yang sudah dihapus tidak dapat dikembalikan lagi.
    <br /><br />
    <input type="button" id="delproductcancel" name="delproductcancel" value="Batal" class="btn back_btn" onclick="cancel_del_kategori()"/>
    &nbsp;&nbsp;
    <input type="hidden" id="idkategori_del">
    <input type="button" id="delproductok" class="btn delete_btn" name="delproductok" value="Hapus!" onclick="del_kategori()"/>
    <div id="prosesdel" class="none" style="padding-top:16px; text-align: center;">Menghapus Kategori/Sub Kategori... tunggu sebentar.</div>
</div>


<script type="text/javascript">
$(document).ready(function() {
	$('#datatable_katmaster').DataTable({
		"pageLength": 10,
		"order": [[ 3, "asc" ]],
		"lengthChange": true,
		"searching": true,
		"paging": true,
		"info": false,
        <?php if( is_admin() || is_ho_logistik() ){ ?>  
        "columnDefs": [
			{ "orderable": false, "targets": 4 }
		],
        <?php } ?>
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
    
$(document).ready(function() {
	$('#datatable_katchild').DataTable({
		"pageLength": 25,
		"order": [[ 1, "asc" ]],
		"lengthChange": true,
		"searching": true,
		"paging": true,
		"info": false,
        <?php if( is_admin() || is_ho_logistik() ){ ?>  
        "columnDefs": [
			{ "orderable": false, "targets": 4 }
		],
        <?php } ?>
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
