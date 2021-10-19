<?php

if (isset($_GET['command'])) { // format: 9_2016
	$month = $_GET['month'];
	$year = $_GET['year'];
	$baseurl = "online=ordersaldo&month=".$month."&year=".$year."&command=Go!";
} else {
	$month = date('n');
	$year = date('Y');
}
$from = mktime(0,0,0,$month,1,$year);
$to = mktime(0,0,0,$month+1,1,$year);
$bulantahun = date('F Y',$from);

// query
$args = "SELECT * FROM request_saldo WHERE date_checkout >= $from AND date_checkout < $to ORDER BY date_checkout DESC";
$result = mysqli_query( $dbconnect, $args );

?>
    
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">

    	<?php
        if ( isset($_GET['type']) ) { include 'beli_new.php'; }
		else { ?>
    	<div class="adminarea">
            <h2 class="topbar">Daftar Pesanan Masuk <span id="text"></span><?php /*
            $produk_pesanan    = querydata_pesanan(20,'idproduk');
            $jmlorder_pesanan  = querydata_pesanan(20,'jml_order');
           
            $exp_idprod        = explode("|", $produk_pesanan);
            $exp_orderprod     = explode("|", $jmlorder_pesanan);
             $count_idprod     = count($exp_idprod)-1;

            $x=0;
            while ($x <= $count_idprod ) {
                echo $exp_idprod[$x].'<br />';
                $x++;
            }*/

            //for($x=0; $x <= $count_idprod; $x++) {
               // echo $exp_idprod[$x].'<br />';
           // }
            

            ?></h2>
            
            <div class="tooltop">
                <div class="ltool">
                    <form method="get" name="thetop">
                    <input type="hidden" name="online" value="ordersaldo"/>
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
                <?php /*
                <div class="rtrans" onclick="location.href='?page=pembelian&type=new'" title="Tambah Transaksi">Tambah Transaksi</div>
                */ ?>
                <div class="clear"></div>
                <div class="loadnotif" id="loadnotif">
                    <img src="penampakan/images/loading-notif.gif" width="42" height="42" alt="please wait" />
                    <div class="reportloadtext">Memuat data, mohon ditunggu...</div>
                </div>
            </div>
            
        	<table class="datatable" width="100%" border="0" id="datatable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Nama User</th>
                    <!--<th scope="col">Saldo</th>-->
                    <th scope="col">Total Pembayaran</th>
                    <th scope="col" style="width: 54px;">Check</th>
                    <th scope="col" style="width: 30px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
                while ( $trans = mysqli_fetch_array($result) ) {
                $idtrans = $trans['id'];
                $id_pesanana = $trans['id_pesanan'];
                $status_pesanan = querydata_pesanan($id_pesanana,'status');
                if($trans['type'] == 'pesanan'){
                    $css_tr = 'light_blue';
                    $type_name = 'Transaksi Pesanan';
                    if( $status_pesanan < 20 ){
                        //$name_onchange_0="status_reqsaldo_pesanan('$idtrans','0')";
                        //$name_onchange_1="status_reqsaldo_pesanan('$idtrans','1')";
                        $name_onchange_0 ="open_reqsaldo_pesanan('$idtrans','0')";
                        $name_onchange_1 ="open_reqsaldo_pesanan('$idtrans','1')";
                    }else{
                        $name_onchange_0 = "";
                        $name_onchange_1 = "";
                    }
                }else{
                    $css_tr = 'light_grey';
                    $type_name = 'Top-Up';
                    $name_onchange_0="status_reqsaldo('$idtrans','0')";
                    $name_onchange_1="status_reqsaldo('$idtrans','1')";
                }
                if( isset($_GET['id_current']) && $_GET['id_current'] == $trans['id'] ){$css_current='active';}else{$css_current='';}
                if( querydata_pesanan($id_pesanana,'tipe_bayar') !== 'cod' && querydata_pesanan($id_pesanana,'metode_bayar') !== 'cash' ){
                ?>
                <tr class="trans_<?php echo $trans['id']; ?> <?php echo $css_tr; ?> <?php echo $css_current; ?>">
                    <td class="center">
                        <?php echo $trans['id']; ?>
                    </td>
                    <td class="nowrap center" data-order="<?php echo $trans['date_checkout']; ?>">
                        <?php echo date('d M Y, H.i', $trans['date_checkout']); ?>
                    </td>
                    <td>
                        <?php echo querydata_usermember($trans['id_user'],'nama'); ?><br>
                        <?php echo querydata_usermember($trans['id_user'],'email'); ?><br>
                        <strong><?php echo $type_name; ?></strong>
                    </td>
                    <!--<td class="right" style="white-space: nowrap;" data-order="<?php //echo $trans['harga_awal']; ?>">
                        <?php //echo uang($trans['harga_awal']); ?>
                    </td>-->
                    <td class="right" style="white-space: nowrap;" data-order="<?php echo $trans['total_bayar']; ?>">
                        <?php echo uang($trans['total_bayar']); ?>
                    </td>
                    <td id="opsi_<?php echo $trans['id']; ?>" rowspan="1" class="center nowrap">
                        <?php if( $trans['status'] == '1' ){ ?>
                            <img src="penampakan/images/check_ok.png" alt="Done" title="Done" class="status_check">
                        <?php } else { ?>
                            <img src="penampakan/images/check_no.png" alt="Checked" title="Checked" class="status_check" onclick="open_reqsaldo_pesanan('<?php echo $trans['id'];?>','<?php echo $trans['status'];?>');">
                        <?php } ?>
                    </td>
                    <td class="nowrap center">
                        <?php if( $trans['status'] == '0' && $trans['type'] == 'saldo' ){ ?>
                        <img class="tabicon" src="penampakan/images/tab_delete.png" width="20" height="20" alt="Hapus Transaksi Order Saldo" title="Hapus Transaksi Order Saldo"
                            onclick="open_del_reqsaldo('<?php echo $trans['id']; ?>')"/>
                        <?php } ?>

                        <?php if( $trans['status'] == '1'){?>
                        <img src="penampakan/images/check_no.png" alt="Checked" title="Checked" class="status_check" onclick="remove_checkpay('<?php echo $trans['id'];?>','<?php echo $trans['status'];?>');">
                        <?php } ?>
                    </td>
                </tr>
                <?php } }?>
            </tbody>
            </table>
        </div>
        <?php } ?>
<?php /*
    <input type="hidden" id="count_order_update" value="<?php echo count_order_update(); ?>">
    <div class="popnotifhome" style="display:block;">
        
    <?php
        $ordernew_query = querynotif_ordernew_penjualan();
        if( mysqli_num_rows($ordernew_query) ){
    ?>    
    <div class="popnotif <?php if ( isset($_COOKIE['notif_ordernew']) ){ echo "none"; } ?>" id="notifchecker" style="width:425px; margin-left:68px;">
        <h3>Notifikasi Pesanan Terbaru</h3>
        <table class="stdtable">
        <?php 
            $no_ordernew = 1;
            while ( $ordernew = mysqli_fetch_array($ordernew_query) ) {
        ?>
            <tr>
                <td><?php echo $no_ordernew; ?></td>
                <td>
                    <a href="?page=kasir&detailpenjualan=<?php echo $ordernew['id']; ?>" title="Buka Detail Pesanan" alt="Buka Detail Pesanan" class="link black">
                    Pesanan <strong>ID <?php echo $ordernew['id']; ?></strong><?php if(!empty( querydata_user($ordernew['id_user']) )){ ?> atas nama <strong><?php echo querydata_user($ordernew['id_user']); ?></strong><?php } ?>
                    </a> 
                </td>
            </tr>
        <?php $no_ordernew++; } ?>
            <tr>
                <td colspan="2" class="right">
                    <input type="button" class="btn save_btn" value="Close" onclick="close_notif('ordernew')">
                </td>
            </tr>
        </table>
    </div>
<?php } ?>
    </div>
</div>
*/?>
<div class="popup popnew cashin" id="konfrim_orderbayar" style="left: 50%; top: 30%; display: none;">
    <input type="hidden" id="status_req" name="status_req">
    <input type="hidden" id="list_id" name="list_id">
    <h3 style="text-align: center;">Terima dan Kirim Nota Pembayaran</h3><br />
    <strong>Apakah Anda ingin terima & mengirim nota pembayaran id: <span id="id_konfir"></span> ?</strong><br /><br />
    <strong>Mengirim bukti nota via</strong>
     
    <select id="slt_nota" onchange="show_pdf();">
        <option value="0">Email</option>
        <option value="1">Whatsapp</option>
    </select>&nbsp;&nbsp;&nbsp;
    <div class="iconpdf" id="iconpdf" style="position: relative; display: none;">
        
    </div>
    
    <div class="submitarea">
        <input type="button" class="btn batal_btn" id="btn_konfirm_batal" value="Batal" onclick="close_konfirmnota()"> 
        <input type="button" class="btn save_btn" id="konfirm_btn" value="Simpan" onclick="save_konfirmnota()">
        <div class="notif none" id="pm_notif_konfirmnota"></div>
        <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" id="loadernota" alt="Pembayaran telah dikonfirmasi">
    </div>
    <div class="clear"></div> 
</div>

<div class="popup popdel" id="popdel_reqsaldo">
	<strong>Apakah Anda yakin ingin menghapus Transaksi ID <span id="delete_id_text"></span> ?</strong>
    <br /><br />
    <input type="button" class="btn back_btn" id="delusercancel" name="delusercancel" value="Batal" onclick="cancel_del_reqsaldo()"/>
    &nbsp;&nbsp;
    <input type="button" class="btn delete_btn"  id="deluserok" name="deluserok" value="Hapus!" onclick="del_reqsaldo()"/>
    <div id="prosesdel" class="none" style="padding-top:16px; text-align: center;">Menghapus Transaksi... tunggu sebentar.</div>
    <input type="hidden" id="delete_reqsaldo" name="delete_reqsaldo" value="0"/>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#loadnotif").show();
	$('#datatable').DataTable({
        responsive: true,
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
	    },
        fnInitComplete : function() {
            $("#loadnotif").hide();
            $("#datatable_katmaster").show();
        }
	});
});
</script>
