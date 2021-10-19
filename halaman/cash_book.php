<?php if( is_admin() ){ ?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
        <h2 class="topbar">Daftar Buku Kas</h2>
        <div class="tooltop" style="height: 34px;">
            <div class="rtrans" onclick="opennew_cashbook()" title="Tambah Buku Kas">Tambah Buku Kas</div> 
            <div class="clear"></div>
        </div>
        
    	<div class="adminarea">
        	<table class="dataTable" width="100%" border="0" id="datatable">
            <thead>
                <tr>
                    <th scope="col" style="width: 280px;">Nama Buku Kas</th>
                    <th scope="col" >Keterangan</th>
                    <th scope="col" style="width: 200px;">Saldo Awal</th>
                    <th scope="col" style="width: 80px;">ID</th>
                    <!--<th scope="col">Saldo</th>-->
                    <th scope="col" width="50">opsi</th>
                </tr>
            </thead>
            <tbody>   
                <?php
                $result = querydata_cashbook();
                while ( $data_cashbook = mysqli_fetch_array($result) ) { ?>
                <tr id="cash_<?php echo $data_cashbook['id'];?>">
                    <td class="center" data-order="<?php echo $data_cashbook['name']; ?>" data-search="<?php echo $data_cashbook['name']; ?>"><?php echo $data_cashbook['name']; ?></td>
                    <td><?php echo $data_cashbook['description']; ?></td>
                    <td class="center"><?php echo uang($data_cashbook['saldoawal']); ?></td>
                    <td class="center"><?php echo $data_cashbook['id']; ?></td>
                    <td class="center nowrap">
                        <input type="hidden" id="pop_name_<?php echo $data_cashbook['id']; ?>" value="<?php echo $data_cashbook['name']; ?>"/>
                        <input type="hidden" id="pop_desc_<?php echo $data_cashbook['id']; ?>" value="<?php echo $data_cashbook['description']; ?>"/>
                        <input type="hidden" id="pop_saldo_<?php echo $data_cashbook['id']; ?>" value="<?php echo $data_cashbook['saldoawal']; ?>"/>
                        <img src="penampakan/images/tab_edit.png" title="Edit Cash Book <?php echo $data_cashbook['id']; ?>" alt="Edit Cash Book <?php echo $data_cashbook['id']; ?>" class="tabicon" onclick="open_editcash('<?php echo $data_cashbook['id']; ?>')" />
                        <?php if ( 28 != $data_cashbook['id'] && 29 != $data_cashbook['id']) { ?>
                        &nbsp;
                        <img class="tabicon" src="penampakan/images/tab_delete.png" width="20" height="20" alt="edit"
                            title="Hapus <?php echo $data_cashbook['name']; ?>" onclick="open_del_cash('<?php echo $data_cashbook['id']; ?>','<?php echo $data_cashbook['name']; ?>')"/>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>     
            </table>
        </div>

    <?php // start new/edit box ?>
    <div class="popup popnew" id="popnewcash" style="top: 35%; left: 50%;">
    <h3><span id="titlepop">BUAT</span> BUKU KAS <span id="titlepopid"></span></h3>
    <table class="stdtable">
        <tr>
            <td style="width:128px;">Nama Kas &nbsp;<span class="harus">*</span></td>
            <td><input maxlength="24" style="width:200px;" type="text" id="cash_name" name="cash_name"/></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td><input maxlength="48" style="width:200px;" type="text" id="cash_desc" name="cash_desc"/></td>
        </tr>
        <tr>
            <td>Saldo Awal &nbsp;<span class="harus">*</span></td>
            <td>
                Rp. &nbsp; 
                <input class="jnumber" style="width:100px; text-align:right;" type="text" id="cash_saldo" name="cash_saldo" value="0"/>
            </td>
        </tr>
    </table>
    <div class="submitarea">
        
        <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" id="addcash_loader" alt="Mohon ditunggu..." style="right: 100px; margin: unset;" />
        <input type="button" value="Batal" class="btn back_btn" name="cash_cancel" id="cash_cancel" onclick="close_newcash()" title="Tutup window ini"/>
        <input type="button" value="Simpan" class="btn save_btn" name="cash_save" id="cash_save" onclick="save_cash()"/>
       <div class="notif" id="addcash_notif" style="display: none;"></div>
       <input type="hidden" id="cashidbook" value="0" />
       
    </div>
</div>

<?php // start del box ?>
<div class="popup popdel" id="popdelcash" style="left: 50%;">
    <strong>Apakah Anda yakin ingin menghapus <span id="delcashname"></span>?</strong><br />
    Buku Kas yang sudah dihapus tidak dapat ditampilkan kembali.
    <br /><br />
    <input type="button" id="delcashcancel" name="delcashcancel" value="Batal" class="btn back_btn" onclick="cancel_del_cash()"/>
    &nbsp;&nbsp;
    <input type="button" id="delcashok" name="delcashok" value="Hapus!" class="btn delete_btn" onclick="del_cash()"/>
    <input type="hidden" id="delcashid" name="delcashid" value="0"/>
</div>
    </div>
</div>
<?php }?>
<script type="text/javascript">
$(document).ready(function() {
	$('#datatable').DataTable({
		"pageLength": 25,
		"order": [[ 3, "asc" ]],
		"lengthChange": true,
		"searching": true,
		"paging": true,
		"info": false,
        "columnDefs": [
            { "orderable": false, "targets": 1 },
			{ "orderable": false, "targets": 4 }
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