<?php 
$role = current_user('user_role');
?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
    	<?php 
        if ( isset($_GET['detailorder']) ) { include 'checker-pesanan-detail.php'; } 
		else { ?>
    	<div class="adminarea">
            <h2 class="topbar">Daftar Pesanan</h2>
            
        	<table class="datatable" width="100%" border="0" id="datatable">
            <thead>     
                <tr>
                    <th scope="col" rowspan="2">ID</th>
                    <th scope="col" rowspan="2">Nama</th>
                    <th scope="col" rowspan="2">Telp</th>
                    <th scope="col" rowspan="2">Total Order</th>
                    <th scope="col" rowspan="2">Permintaan Kirim</th>
                    <th scope="col" colspan="5" style="padding: 5px 0px;">Status</th>
                    <th scope="col" rowspan="2">Opsi</th>
                </tr>
                <tr>
                    <th scope="col" style="padding: 8px 5px;">Checker</th>
                    <th scope="col" style="padding: 8px 5px;">Pending</th>
                    <th scope="col" style="padding: 8px 5px;">Shipping</th>
                    <th scope="col" style="padding: 8px 5px;">delivered</th>
                    <th scope="col" style="padding: 8px 5px;">Customer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = query_list_pesanan('checker','','','');
                while ( $data_pesan = mysqli_fetch_array($result) ) { ?>
                <tr class="<?php if($data_pesan['id_checker'] !== '0'){ echo 'light_blue'; } ?>">
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
                    <td>
                        <?php if( split_status_order($data_pesan['status_1_checker'],'0') == '1' ){ ?>
                            <img src="penampakan/images/check_ok.png" alt="Done" title="Done" class="status_check" <?php /* if( is_admin() || is_ho() || $role = '10' ) { ?> onchange="checked('checker_1');" <?php } */ ?>>
                        <?php } else { ?>
                            <img src="penampakan/images/check_no.png" alt="Checked" title="Checked" class="status_check">
                        <?php } ?>
                    </td>
                    <td>
                        <?php if( ( $data_pesan['time_1_suspend'] == 0 && $data_pesan['time_1_to_suspend'] == 0 ) || ( $data_pesan['time_1_suspend'] != 0 && $data_pesan['time_1_to_suspend'] != 0 ) ){ ?>
                            <img src="penampakan/images/check_hold.png" alt="Suspend Active" title="Suspend Active" class="status_check">
                        <?php } else { ?>
                            <img src="penampakan/images/check_hold_active.png" alt="Suspend Active" title="Suspend Active" class="status_check">
                        <?php } ?>
                    </td>
                    <td>
                        <?php if( split_status_order($data_pesan['status_2_driver'],'0') == '1' ){ ?>
                            <img src="penampakan/images/check_ok.png" alt="Done" title="Done" class="status_check" <?php /*  if( is_admin() || is_ho() || $role = '30' ) { ?> onchange="checked('driver_3');" <?php } */ ?>>
                        <?php } else { ?>
                            <img src="penampakan/images/check_no.png" alt="Checked" title="Checked" class="status_check">
                        <?php } ?>
                    </td>
                    <td>
                        <?php if( split_status_order($data_pesan['status_3_driver'],'0') == '1' ){ ?>
                            <img src="penampakan/images/check_ok.png" alt="Done" title="Done" class="status_check" <?php /* if( is_admin() || is_ho() || $role = '30' ) { ?> onchange="checked('driver_3');" <?php } */ ?>>
                        <?php } else { ?>
                            <img src="penampakan/images/check_no.png" alt="Checked" title="Checked" class="status_check">
                        <?php } ?>
                    </td>
                    <td>
                        <?php if( split_status_order($data_pesan['status_3_cust'],'0') == '1' ){ ?>
                            <img src="penampakan/images/check_ok.png" alt="Done" title="Done" class="status_check">
                        <?php } else { ?>
                            <img src="penampakan/images/check_no.png" alt="Checked" title="Checked" class="status_check">
                        <?php } ?>
                    </td>
                    <td id="opsi_<?php echo $data_pesan['id']; ?>" rowspan="1"  class="center">
                        <a href="?page=order-checker&detailorder=<?php echo $data_pesan['id']; ?>">
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
		"order": [[ 4, "desc" ]],
		"lengthChange": true,
		"searching": true,
		"paging": true,
		"info": false,
        "columnDefs": [
			{ "orderable": false, "targets": 5 },
            { "orderable": false, "targets": 6 },
            { "orderable": false, "targets": 7 },
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
