<?php

if (isset($_GET['command'])) { // format: 9_2016
	$month = $_GET['month'];
	$year = $_GET['year'];
	$baseurl = "logistics=pembelian&month=".$month."&year=".$year."&command=Go!";
} else {
	$month = date('n');
	$year = date('Y');
}
$from = mktime(0,0,0,$month,1,$year);
$to = mktime(0,0,0,$month+1,1,$year);
$bulantahun = date('F Y',$from);

// query
$args = "SELECT * FROM logistik WHERE tanggal >= '$from' AND tanggal < '$to' ORDER BY tanggal DESC";
$result = mysqli_query( $dbconnect, $args );
   
?>

<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
    	<?php 
		//if ( isset($_GET['newpesanan']) ) { include 'pesanan-baru.php'; } 
		//else if ( isset($_GET['editpesanan']) ) { include 'pesanan-edit.php'; } 
        if ( isset($_GET['type']) ) { include 'beli_new.php'; } 
        elseif ( isset($_GET['beliview']) ) { include 'beli_view.php'; } 
        elseif ( isset($_GET['beliedit']) ) { include 'beli_edit.php'; } 
		else { ?>
    	<div class="adminarea">
            <h2 class="topbar">Logistik / Transaksi Pembelian</h2>
            <div class="tooltop">
                <div class="ltool">
                    <form method="get" name="thetop">
                    <input type="hidden" name="logistics" value="pembelian"/>
                    <?php $cmonth = date('n'); $cyear = date('y'); ?>
                    <select class="datetop" name="month" id="month">
                        <option value="1" <?php auto_select($month,1); ?> >Januari</option>
                        <option value="2" <?php auto_select($month,2); ?> >Februari</option>
                        <option value="3" <?php auto_select($month,3); ?> >Maret</option>
                        <option value="4" <?php auto_select($month,4); ?> >April</option>
                        <option value="5" <?php auto_select($month,5); ?> >Mei</option>
                        <option value="6" <?php auto_select($month,6); ?> >Juni</option>
                        <option value="7" <?php auto_select($month,7); ?> >Juli</option>
                        <option value="8" <?php auto_select($month,8); ?> >Agustus</option>
                        <option value="9" <?php auto_select($month,9); ?> >September</option>
                        <option value="10" <?php auto_select($month,10); ?> >Oktober</option>
                        <option value="11" <?php auto_select($month,11); ?> >Nopember</option>
                        <option value="12" <?php auto_select($month,12); ?> >Desember</option>
                    </select>
                    <select class="datetop" name="year" id="year">
                        <?php $yfrom = startfrom('year'); $yto = date('Y');
                        while( $yfrom <= $yto ) { ?>
                        <option value="<?php echo $yfrom; ?>" <?php auto_select($year,$yfrom); ?> ><?php echo $yfrom; ?></option>
                        <?php $yfrom++; } ?>
                    </select>
                    <input type="submit" class="btn save_btn" name="command" value="Go"/>
                    </form>
                </div>
                <?php if( is_admin() || is_ho_logistik() ) { ?>
                <div class="rtrans" onclick="location.href='?logistics=pembelian&type=new'" title="Tambah Transaksi">Tambah Pembelian</div>
                <div class="rtrans" onclick="name_value('ppk_ekspor');" title="Tambah Transaksi" style="margin-right: 200px;">Barcode</div>
                <?php } ?>
                <div class="clear"></div>
            </div>
            
        	<table class="datatable" width="100%" border="0" id="datatable">
            <thead>  
                <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">ID</th>
                    <th scope="col">Supplier</th>
                    <th scope="col">Nama/Deskripsi</th>
                    <th scope="col">Total Transaksi</th>
                    <th scope="col" style="width: 54px;">Opsi</th>
                </tr>
            </thead>  
            <tbody>  
            <?php
                while ( $beli = mysqli_fetch_array($result) ) { ?>
                <tr class="trans_<?php echo $beli['id']; ?>">
                    <td class="nowrap center" data-order="<?php echo $beli['tanggal']; ?>">
                        <?php echo date('d M Y, H.i', $beli['tanggal']); ?>
                    </td>
                    <td class="center">
                        <?php echo $beli['id']; ?>
                    </td>
                    <td>
                        <?php echo $beli['suplayer']; ?>
                    </td>
                    <td>
                        <?php echo tampil_item($beli['produk_id'],$beli['jumlah']); ?>
                    </td>
                    <td class="right" style="white-space: nowrap;" data-order="<?php echo $beli['total_transaksi']; ?>">
                        <?php echo uang($beli['total_transaksi']); ?>
                    </td>
                    <td id="opsi_<?php echo $beli['id']; ?>" rowspan="1" class="center nowrap">
                        <?php if( is_admin() || is_ho_logistik() ) { ?>
                        <a href="?logistics=pembelian&beliedit=<?php echo $beli['id']; ?>">
                            <img src="penampakan/images/tab_edit.png" title="Edit Pembelian ID <?php echo $beli['id']; ?>" alt="Edit Pembelian ID <?php echo $beli['id']; ?>">
                        </a>
                        &nbsp;
                        <?php } ?>
                        <a href="?logistics=pembelian&beliview=<?php echo $beli['id']; ?>">
                            <img src="penampakan/images/tab_detail.png" title="Lihat detail Pembelian ID <?php echo $beli['id']; ?>" alt="Lihat detail Pembelian ID <?php echo $beli['id']; ?>">
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