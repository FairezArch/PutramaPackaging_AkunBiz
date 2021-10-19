<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
    	<?php 
		if ( isset($_GET['newuser'])) { include 'user-baru.php'; } 
		else if ( isset($_GET['edituser'])) { include 'user-edit.php'; } 
        else if ( isset($_GET['viewuser'])) { include 'user-view.php'; } 
		else { ?>
        <h2 class="topbar">Customer</h2>
        <div class="tooltop" style="height: 34px;">
            <div class="rtrans" onclick="location.href='?option=user&newuser=true'" title="Tambah User">Tambah User</div> 
            <div class="clear"></div>
        </div>
        <?php 

        echo strtotime('now');

        /*Offkan dulu
        <div class="tooltop" style="height: 34px;">
            <div class="rtrans" onclick="location.href='?page=user&newuser=true'" title="Tambah User">Tambah User</div> 
            <div class="clear"></div>
        </div>
        $date = "06 Juli 1998";
        $strtotime_date = strtotime("6 Juli 1998");
        $hari = date('d',$strtotime_date);
        $bulan = date('n',$strtotime_date);
        $tahun = date('Y',$strtotime_date);
        echo $strtotime_date;*/
        ?>
        
    	<div class="adminarea">
        	<table class="dataTable" width="100%" border="0" id="datatable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">email</th>
                    <th scope="col">Telepon</th>
                    <th scope="col">Foto</th>
                    <!--<th scope="col">Saldo</th>-->
                    <th scope="col" width="50">opsi</th>
                </tr>
            </thead>
            <tbody>   
                <?php
                $result = querydata_memberuser();
                while ( $data_user = mysqli_fetch_array($result) ) { ?>
                <tr>
                    <td class="center" id="id_<?php echo $data_user['id']; ?>" ><?php echo $data_user['id']; ?></td>
                    <td data-order="<?php echo $data_user['nama']; ?>" data-search="<?php echo $data_user['nama']; ?>">
                        <?php echo $data_user['nama']; ?>
                    </td>
                    <td style="text-transform:none;"><?php echo $data_user['email']; ?></td>
                    <td><?php echo $data_user['telp']; ?></td>
                    <td class="center">
                        <?php $userpic = $data_user['imguser'];
                        if  ( '' == $userpic ) { $src = "penampakan/images/user-noimg.png"; }
                        else { $src = GLOBAL_URL."/penampakan/images/php/uploaduser/".$userpic; } ?>
                        <img src="<?php echo $src; ?>" width="24" height="24"/>
                    </td>
                    <!--<td class="right nowrap"><?php //echo uang($data_user['saldo']); ?></td>-->
                    <td class="center nowrap">

                        <a href="?option=user&edituser=<?php echo $data_user['id']; ?>">
                            <img src="penampakan/images/tab_edit.png" title="Edit User <?php echo $data_user['nama']; ?>" alt="Edit User <?php echo $data_user['nama']; ?>">
                        </a>
                        &nbsp;
                       
                        <a href="?option=user&viewuser=<?php echo $data_user['id']; ?>">
                            <img src="penampakan/images/tab_detail.png" title="Lihat detail User <?php echo $data_user['nama']; ?>" alt="Lihat detail User <?php echo $data_user['nama']; ?>">
                        </a>
                        <?php /*
                        &nbsp;
                        <a href="?page=user&transuser=<?php echo $data_user['id']; ?>">
                            <img src="penampakan/images/tab_saldo.png" title="Lihat Transaksi Saldo User <?php echo $data_user['nama']; ?>" alt="Lihat Transaksi Saldo User <?php echo $data_user['nama']; ?>">
                        </a>
                        */ ?>
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
		"order": [[ 0, "desc" ]],
		"lengthChange": true,
		"searching": true,
		"paging": true,
		"info": false,
        "columnDefs": [
            { "orderable": false, "targets": 3 },
			{ "orderable": false, "targets": 4 },
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