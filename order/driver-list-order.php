<?php $role = current_user('user_role'); ?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
    	<?php 
        if ( isset($_GET['detailorder']) ) { include 'driver-pesanan-detail.php'; } 
		else { ?>
    	<div class="adminarea">
            <h2 class="topbar">Daftar Pengiriman Order</h2>
        	<table class="datatable" width="100%" border="0" id="datatable">
            <thead>     
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Telp</th>
                    <th scope="col">Total Order</th>
                    <th scope="col">Permintaan Kirim</th>
                    <th scope="col" style="width:300px;">Alamat</th>
                    <th scope="col">Opsi</th>
                </tr>
            </thead>
            <tbody>     
                <?php
                $result = query_list_pesanan('driver','','','');
                while ( $data_pesan = mysqli_fetch_array($result) ) { ?>
                <tr class="coba <?php if((( is_admin() || is_ho() ) && $data_pesan['id_driver'] !== '0') || ((!is_admin() || !is_ho()) && $data_pesan['id_driver'] !== '0' && $data_pesan['status'] == '40')) { echo 'light_blue'; } ?>">
                    <td class="center" id="id_<?php echo $data_pesan['id']; ?>" rowspan="1">
                        <?php echo $data_pesan['id']; ?>
                    </td>
                    <td data-order="<?php echo querydata_user($data_pesan['id_user'],'nama'); ?>" data-search="<?php echo querydata_user($data_pesan['id_user'],'nama'); ?>">
                        <?php echo querydata_user($data_pesan['id_user'],'nama'); ?>
                    </td>
                    <td data-order="<?php echo $data_pesan['telp']; ?>" data-search="<?php echo $data_pesan['telp']; ?>">
                        <?php echo $data_pesan['telp']; ?>
                    </td>
                    <td class="nowrap right" data-order="<?php echo $data_pesan['total']; ?>">
                        <?php echo uang($data_pesan['total']); ?>
                    </td>
                    <td class="nowrap center" data-order="<?php echo $data_pesan['waktu_kirim']; ?>">
                        <?php echo show_datesendorder($data_pesan['waktu_kirim']); ?>
                    </td>
                    <td><?php if( $data_pesan['alamat_kirim'] !== '' ) { ?>
                        <a href="https://www.google.co.id/maps/search/<?php echo ucwords(strtolower(alamat_cust_pesanan($data_pesan['alamat_kirim']))); ?>" target="_blank" alt="Buka Peta" title="Buka Peta" class="link black"><?php echo ucwords(strtolower(alamat_cust_pesanan($data_pesan['alamat_kirim']))); ?>
                        </a>
                        <?php } ?>
                    </td>
                    <td id="opsi_<?php echo $data_pesan['id']; ?>" rowspan="1"  class="center">
                        <a href="?page=order-driver&detailorder=<?php echo $data_pesan['id']; ?>">
                            <img src="penampakan/images/tab_detail.png" title="Lihat detail pesanan ID <?php echo $data_pesan['id']; ?>" alt="Lihat detail pesanan ID <?php echo $data_pesan['id']; ?>">
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
        responsive: true,
		"pageLength": 25,
		"order": [[ 4, "asc" ]],
		"lengthChange": true,
		"searching": true,
		"paging": true,
		"info": false,
        "columnDefs": [
			{ "orderable": false, "targets": 5 },
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
