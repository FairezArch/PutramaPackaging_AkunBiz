<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
    <?php 
		//if ( isset($_GET['idteam']) && $_GET['idteam'] == 'new' ) { include 'team-baru.php'; } 
		//else if ( isset($_GET['idteam']) && $_GET['idteam'] !== 'new' ) { include 'team-edit.php'; } 
        //else if ( isset($_GET['viewteam']) && $_GET['viewteam'] !== 'new' ) { include 'team-view.php'; } 
		//else { ?>
        <h2 class="topbar">Daftar Pengguna Aplikasi</h2>
        
    	<div class="adminarea">
        	<table class="dataTable" width="100%" border="0" id="datatable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Telepon</th>
                    <th scope="col">Email</th>
                    <th scope="col">Tanggal Mendaftar</th>
                </tr>
            </thead>   
            <tbody> 
                <?php
                $args = "SELECT * FROM data_pengguna ORDER BY id desc";
                $result = mysqli_query( $dbconnect, $args );
                while ( $data_user = mysqli_fetch_array($result) ) { ?>
                <tr>
                    <td class="center" id="id_<?php echo $data_user['id']; ?>" ><?php echo $data_user['id']; ?></td>
                    <td><?php echo $data_user['nama']; ?></td>
                    <td style="text-transform:none;"><?php echo $data_user['telp']; ?></td>
                    <td><?php echo $data_user['email']; ?></td>
                    <td class="center"><?php echo $ambil_tanggal = date("d M Y",$data_user['date']); ?></td>
                </tr>
                <?php } ?>
            </tbody>       
            </table>
        </div>
    <?php //} ?>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('#datatable').DataTable({
		"pageLength": 10,
		"order": [[ 0, "desc" ]],
		"lengthChange": true,
		"searching": true,
		"paging": true,
		"info": false,
		"processing": true,
		"columnDefs": [
			{ "orderable": false, "targets": 2 }
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