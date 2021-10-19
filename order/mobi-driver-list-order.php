<?php $role = current_user('user_role'); ?>
    <div class="content_body">
    	<?php 
        if ( isset($_GET['detailorder']) ) { include 'mobi-driver-pesanan-detail.php'; } 
		else { ?>
		<h2 class="mobitopbar">Daftar Pengiriman Order</h2>
		<table class="datatable mobi" width="100%" border="0" id="datatable">
            <thead>     
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Pesanan</th>
                    <th scope="col">Kirim</th>
                </tr>
            </thead>
            <tbody>     
                <?php
                $result = query_list_pesanan('driver','','','');
                while ( $data_pesan = mysqli_fetch_array($result) ) { ?>
                <tr class="coba <?php if((( is_admin() || is_ho() ) && $data_pesan['id_driver'] !== '0') || ((!is_admin() || !is_ho()) && $data_pesan['id_driver'] !== '0' && $data_pesan['status'] == '40')) { echo 'light_blue'; } ?>" onclick="window.location.href='?page=order-driver&detailorder=<?php echo $data_pesan['id']; ?>'">
                    <td class="center" id="id_<?php echo $data_pesan['id']; ?>">
                        <?php echo $data_pesan['id']; ?>
                    </td>
                    <td data-order="<?php echo querydata_user($data_pesan['id_user'],'nama'); ?>" data-search="<?php echo querydata_user($data_pesan['id_user'],'nama'); ?>">
                        <?php echo querydata_user($data_pesan['id_user'],'nama'); ?><br>
                        <span class="childtd"><?php echo $data_pesan['telp']; ?></span>
                    </td>
                    <td class="nowrap center" data-order="<?php echo $data_pesan['waktu_kirim']; ?>">
                        <?php echo show_datesendorder($data_pesan['waktu_kirim']); ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>        
            </table>
        <?php } ?>
    </div>



<script type="text/javascript">
$(document).ready(function() {
	$('#datatable').DataTable({
        responsive: true,
		"pageLength": 10,
		"order": [[ 2, "asc" ]],
		"lengthChange": true,
		"searching": false,
		"paging": false,
		"info": false,
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
