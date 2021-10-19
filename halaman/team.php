<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
    <?php 
		if ( isset($_GET['idteam']) && $_GET['idteam'] == 'new' ) { include 'team-baru.php'; } 
		else if ( isset($_GET['idteam']) && $_GET['idteam'] !== 'new' ) { include 'team-edit.php'; } 
        else if ( isset($_GET['viewteam']) && $_GET['viewteam'] !== 'new' ) { include 'team-view.php'; } 
		else { ?>
        <h2 class="topbar">Internal Team</h2>
        
        <div class="tooltop" style="height: 34px;">
            <div class="rtrans" onclick="location.href='?option=team&idteam=new'" title="Tambah Team">Tambah Team</div> 
            <div class="clear"></div>
        </div>
        
    	<div class="adminarea">
        	<table class="dataTable" width="100%" border="0" id="datatable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">email</th>
                    <th scope="col">Telepon</th>
                    <th scope="col">Peran</th>
                    <th scope="col" width="50">opsi</th>
                </tr>
            </thead>   
            <tbody> 
                <?php
                $result = query_roleuser('internal_team');
                while ( $data_user = mysqli_fetch_array($result) ) { ?>
                <tr>
                    <td class="center" id="id_<?php echo $data_user['id']; ?>" ><?php echo $data_user['id']; ?></td>
                    <td data-order="<?php echo $data_user['nama']; ?>" data-search="<?php echo $data_user['nama']; ?>">
                        <?php echo $data_user['nama']; ?>
                    </td>
                    <td style="text-transform:none;"><?php echo $data_user['email']; ?></td>
                    <td><?php echo $data_user['telp']; ?></td>
                    <td data-order="<?php echo peran($data_user['user_role']); ?>" data-search="<?php echo peran($data_user['user_role']); ?>">
                        <?php echo peran($data_user['user_role']); ?>
                    </td>
                    <td class="center nowrap">
                        <a href="?option=team&idteam=<?php echo $data_user['id']; ?>">
                            <img src="penampakan/images/tab_edit.png" title="Edit Team <?php echo $data_user['nama']; ?>" alt="Edit Team <?php echo $data_user['nama']; ?>">
                        </a>
                        &nbsp;
                        <a href="?option=team&viewteam=<?php echo $data_user['id']; ?>">
                            <img src="penampakan/images/tab_detail.png" title="Lihat detail Team <?php echo $data_user['nama']; ?>" alt="Lihat detail Team <?php echo $data_user['nama']; ?>">
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>       
            </table>
        </div>
    <?php } ?>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('#datatable').DataTable({
		"pageLength": 25,
		"order": [[ 1, "asc" ]],
		"lengthChange": true,
		"searching": true,
		"paging": true,
		"info": false,
        "columnDefs": [
            { "orderable": false, "targets": 3 },
			{ "orderable": false, "targets": 5 }
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