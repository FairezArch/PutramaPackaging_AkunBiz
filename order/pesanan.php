<?php

$args = "SELECT * FROM pesanan";
$result = mysqli_query( $dbconnect, $args);

while ( $array_pesan = mysqli_fetch_array($result) ) {
        $list_id = $array_pesan['id'];
        $list_idusr = $array_pesan['id_user'];
        $status_bayar = $array_pesan['status'];
        $status_tipebayar = $array_pesan['tipe_bayar'];
        
        if( $status_tipebayar == 'cod' && $status_bayar < '10' ){
            $query = "UPDATE pesanan SET status='10' WHERE id='$list_id'";
            $result_query = mysqli_query( $dbconnect, $query);
        }
        auto_pesanan_batal($list_idusr);
         

        $status_konfir_user = $array_pesan['status_3_cust'];
        $split_datakonfir = split_status_order($status_konfir_user,'2');
        $cek_kirim = $array_pesan['status_2_driver'];
        $split_kirim = split_status_order($cek_kirim,'2');
        
        auto_konfir_user($list_id);
        //if($cek_kirim !='0' && $status_konfir_user ='0'){
            //
        //}
}
                  
if ( isset($_GET['command']) ) { // format: 9_2016
    $type = $_GET['type'];
	$tgl_from = strtotime($_GET['datefrom']);
	$tgl_to = strtotime($_GET['dateto']) + 86399;
	$baseurl = "online=pesanan&type=".$type."&datefrom=".$tgl_from."&dateto=".$tgl_to."&command=Go!";
	if( $type == 'open'){ $type_name = ' - Aktif'; }
	elseif( $type == 'close'){ $type_name = ' - Selesai'; }
	elseif( $type == 'cancel'){ $type_name = ' - Batal'; }
	elseif( $type == 'all'){ $type_name = ' - Semua'; }
} else {
    $type = 'open';
	$tgl_from = mktime(0,0,0,date('n'),1,date('Y'));
	$tgl_to = mktime(0,0,0,date('n'),date('t'),date('Y'))+ 86399;
	$type_name = ' - Aktif'; 
}



/*$data =  mktime(16,35,12,5,13,2019);
$count = '1557709512';
$day = 60*60*336;
$to_day = 14;

$sum = $count+$day;//15 Aug 2018, 15.12
$dt = date('d M Y, H:i,s',$sum);
$datedb = strtotime('now');
$dt2 = date('d M Y, H:i,s',$datedb);

    if($sum < $datedb){
        $out = 'Barang sudah diterima';
    }else{
        $out = 'Masih dalam perjalanan';
    }*/

$url_download = "typeorder=".$type."&date_from=".$tgl_from."&date_to=".$tgl_to;
?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
    	<?php 
		//if ( isset($_GET['newpesanan']) ) { include 'pesanan-baru.php'; } 
		//else if ( isset($_GET['editpesanan']) ) { include 'pesanan-edit.php'; } 
        if ( isset($_GET['detailorder']) ) { include 'pesanan-detail.php'; } 
		else { ?>
    	<div class="adminarea">
            <h2 class="topbar">Daftar Pesanan <?php echo $type_name; ?></h2>
            <input type="hidden" value="<?php echo $tgl_to; ?>">
            <div class="tooltop">
                <div class="ltool">
                    <form method="get" name="thetop">
                    <input type="hidden" name="online" value="pesanan"/>
                    <select name="type" id="type">
                        <option value="open" <?php auto_select($type,'open'); ?>>Aktif</option>    
                        <option value="close" <?php auto_select($type,'close'); ?>>Selesai</option> 
                        <option value="cancel" <?php auto_select($type,'cancel'); ?>>Batal</option> 
                        <option value="all" <?php auto_select($type,'all'); ?>>Semua</option> 
                    </select>    
                    <?php if ( isset($_GET['datefrom']) ) { $inputfrom = $_GET['datefrom']; }
                    else { $inputfrom = '1 '.date('F Y',mktime(0,0,0,date('n'),1,date('Y'))); } ?>
                    <input type="text" class="datepicker" style="width:120px;" name="datefrom" id="datefrom" value="<?php echo $inputfrom; ?>"/>
                    &nbsp;Sampai&nbsp; 
                    <?php if ( isset($_GET['dateto']) ) { $inputto = $_GET['dateto']; }
                    else { $inputto = date('t F Y'); } ?>
                    <input type="text" class="datepicker" style="width:120px;" name="dateto" id="dateto" value="<?php echo $inputto; ?>"/>    
                    &nbsp; 
                    <input type="submit" class="btn save_btn" name="command" value="Go"/>
                    </form>
                    <a href="<?php echo GLOBAL_URL;?>/export_excel/xls_laporanDaftarPesanan.php?<?php echo $url_download;?>" title="Download dalam bentuk file Ms Excel">
                        <div class="rtrans xls"><img src="<?php echo GLOBAL_URL;?>/penampakan/images/excel.png"></div>
                    </a>
                </div>
                <div class="clear"></div>
            </div>
          
        	<table class="datatable" width="100%" border="0" id="datatable">
            <thead>  
                <tr>
                    <th scope="col" rowspan="2">ID</th>
                    <th scope="col" rowspan="2">Tanggal</th>
                    <th scope="col" rowspan="2">Nama</th>
                    <th scope="col" rowspan="2" style="width: 210px;">Nama/Deskripsi Produk</th>
                    <th scope="col" rowspan="2">Total Order</th>
                    <th scope="col" colspan="3" style="padding: 5px 0px;">Status</th>
                    <th scope="col" rowspan="2">Opsi</th>
                </tr>
                <tr>
                    <?php /*<th scope="col" rowspan="2">Permintaan Kirim</th><th scope="col" style="padding: 8px 5px;">Checker</th><th scope="col" style="padding: 8px 5px;">delivered</th>*/?>
                    <th scope="col" style="padding: 8px 5px;">Payment</th>
                    <th scope="col" style="padding: 8px 5px;">Shipping</th>
                    <th scope="col" style="padding: 8px 5px;">Customer</th>
                </tr>
            </thead>  
            <tbody>  
               <?php
                $result = query_list_pesanan(null,$tgl_from,$tgl_to,$type);
                while ( $data_pesan = mysqli_fetch_array($result) ) { ?>
                <tr class="<?php if($data_pesan['id_checker'] !== '0' && $data_pesan['status'] <= '40' || $data_pesan['status'] == '50' && $data_pesan['tipe_bayar'] == 'cod' && $data_pesan['status_cek_bayar'] == 0 ){ echo 'light_blue'; } ?>">
                    <td class="center" id="id_<?php echo $data_pesan['id']; ?>" rowspan="1">
                        <?php echo $data_pesan['id']; ?>
                    </td>
                    <td data-order="<?php echo $data_pesan['waktu_pesan']; ?>" data-search="<?php echo $data_pesan['waktu_pesan']; ?>" class="center">
                        <?php echo date('d M Y, H.i',$data_pesan['waktu_pesan']); ?>
                    </td>
                    <td data-order="<?php echo $data_pesan['nama_user']; ?>" data-search="<?php echo $data_pesan['nama_user']; ?>">
                        <?php echo $data_pesan['nama_user']."<br>".$data_pesan['telp']; ?>
                    </td>
                    <td class="nowrap">
                        <?php echo tampil_item($data_pesan['idproduk'],$data_pesan['jml_order']); ?>
                    </td>
                    <td class="nowrap right" data-order="<?php echo $data_pesan['total']; ?>">
                        <?php echo uang($data_pesan['total']); ?>
                    </td>
                    <?php /*<td class="nowrap center" data-order="<?php echo $data_pesan['waktu_kirim']; ?>">
                        <?php echo show_datesendorder($data_pesan['waktu_kirim']); ?>
                    </td>*/ ?>
                    <td>
                        <?php if ( $data_pesan['status'] > '5' && $data_pesan['tipe_bayar'] == 'cod' && $data_pesan['status_cek_bayar'] == 0) {?>
                            <img src="penampakan/images/check_hold_active.png" alt="Pembayaran tertunda" title="Pembayaran tertunda" class="status_check">
                        <?php }else if( $data_pesan['status'] > '5' ){ ?>
                            <img src="penampakan/images/check_ok.png" alt="Done" title="Done" class="status_check">
                        <?php } else { ?>
                            <img src="penampakan/images/check_no.png" alt="Checked" title="Checked" class="status_check">
                        <?php } ?>
                    </td>
                    <?php /*<td>
                        <?php if( split_status_order($data_pesan['status_1_checker'],'0') == '1' ){ ?>
                            <img src="penampakan/images/check_ok.png" alt="Done" title="Done" class="status_check">
                        <?php } else { ?>
                            <img src="penampakan/images/check_no.png" alt="Checked" title="Checked" class="status_check">
                        <?php } ?>
                    </td>*/?>
                    <td>
                        <?php if( split_status_order($data_pesan['status_2_driver'],'0') == '1' ){ ?>
                            <img src="penampakan/images/check_ok.png" alt="Done" title="Done" class="status_check">
                        <?php } else { ?>
                            <img src="penampakan/images/check_no.png" alt="Checked" title="Checked" class="status_check">
                        <?php } ?>
                    </td>
                    <?php /*<td>
                        <?php if( split_status_order($data_pesan['status_3_driver'],'0') == '1' ){ ?>
                            <img src="penampakan/images/check_ok.png" alt="Done" title="Done" class="status_check">
                        <?php } else { ?>
                            <img src="penampakan/images/check_no.png" alt="Checked" title="Checked" class="status_check">
                        <?php } ?>
                    </td>*/ ?>
                    <td>
                        <?php if( split_status_order($data_pesan['status_3_cust'],'0') == '1' ){ ?>
                            <img src="penampakan/images/check_ok.png" alt="Done" title="Done" class="status_check">
                        <?php } else { ?>
                            <img src="penampakan/images/check_no.png" alt="Checked" title="Checked" class="status_check">
                        <?php } ?>
                    </td>
                    <td id="opsi_<?php echo $data_pesan['id']; ?>" rowspan="1" class="center">
                        <a href="?online=pesanan&detailorder=<?php echo $data_pesan['id']; ?>">
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
            { "orderable": false, "targets": 7 },
            { "orderable": false, "targets": 8 }

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