<?php

if (isset($_GET['command'])) { // format: 9_2016
	$month = $_GET['month'];
	$year = $_GET['year'];
	$baseurl = "online=konfrimsaldo&month=".$month."&year=".$year."&command=Go!";
} else {
	$month = date('n');
	$year = date('Y');
}
$from = mktime(0,0,0,$month,1,$year);
$to = mktime(0,0,0,$month+1,1,$year);
$bulantahun = date('F Y',$from);

//if( isset($_POST['newkonfrim']) ) { include 'new_konfrim.php'; }

// query
$args = "SELECT * FROM konfirmasi_saldo WHERE tanggal >= $from AND tanggal < $to ORDER BY tanggal DESC";
$result = mysqli_query( $dbconnect, $args );
   
?>

<div class="bloktengah" id="blokkonfrimsaldo">
    <div class="option_body kategori_body">
    	<div class="adminarea">
            <h2 class="topbar">Konfirmasi Pembayaran</h2>
            
            <div class="tooltop">
                <div class="ltool">
                    <div class="rtrans" onclick="open_konfirm()" title="Transfer Stock">Tambah Konfirmasi</div>
                    <form method="get" name="thetop">
                    <input type="hidden" name="online" value="konfrimsaldo"/>
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
                    <th scope="col" style="width:200px;">Customer</th>
                    <th scope="col" style="width:200px;">Pembayaran dari</th>
                    <th scope="col">Pembayaran ke</th>
                    <th scope="col">Nominal Transfer</th>
                    <th scope="col">ID Order</th>
                    <th scope="col">Struk Pembayaran</th>
                    <th scope="col" style="width: 30px;">Check</th>
                    <th scope="col" style="width: 30px;">Aksi</th>
                </tr>
            </thead>  
            <tbody>  
            <?php
                while ( $trans = mysqli_fetch_array($result) ) { 
                    $reqsaldo_id = $trans['id_reqsaldo'];
                    $idpesan_reqsaldo = querydata_reqsaldo($reqsaldo_id,'id_pesanan');
                    $strukimg_pesan = querydata_pesanan($idpesan_reqsaldo,'imgstruk');

                    $nama_inpesan = querydata_pesanan($trans['id_pesanan'],'nama_user');
            ?>
                <tr class="trans_<?php echo $trans['id']; ?> <?php if($trans['type'] == 'pesanan'){ echo 'light_blue'; }else{ echo 'light_grey'; } ?>">
                    <td class="center">
                        <?php echo $trans['id']; ?>
                    </td>
                    <td class="nowrap center" data-order="<?php echo $trans['tanggal']; ?>">
                        <?php echo date('d M Y', $trans['tanggal']); ?>
                    </td>
                    <td>
                        <?php
                            if($reqsaldo_id !== '0' && $trans['pesanan']){
                                //echo $reqsaldo_id;
                                $getuser = querydata_pesanan($trans['id_pesanan'],'id_user'); echo "ID : ".$getuser."<br />".querydata_user($getuser,'nama')."<br />".querydata_user($getuser,'email');
                            }else{
                                echo $nama_inpesan;
                            }
                            ?>
                        
                    </td>
                    <td>
                        Bank : <?php echo $trans['bankuser']; ?><br>
                        <!--No.Rek : <?php //echo $trans['rekuser']; ?><br>-->
                        Atas Nama : <?php echo $trans['namauser']; ?>
                    </td>
                    <td> <?php echo $trans['rekideasmart']; ?></td>

                    <td class="right" style="white-space: nowrap;" data-order="<?php echo $trans['uang_tf']; ?>">
                        <?php echo uang($trans['uang_tf']); ?>
                    </td>
                    
                    <td class="right" style="white-space: nowrap;">
                        <a href='?page=ordersaldo&id_current=<?php echo $trans['id_reqsaldo']; ?>' title="Buka Order Pembayaran ID <?php echo $trans['id_reqsaldo']; ?>">
                            <?php if($trans['id_reqsaldo'] == '0'){ echo '';}else{echo $trans['id_reqsaldo'];} ?>
                        </a>    
                    </td> 
                    <td class="center" style="white-space: nowrap;">
                        <?php if( $strukimg_pesan !== '' && $reqsaldo_id !== '0' ){?>
                            <a href="<?php echo GLOBAL_URL;?>/penampakan/images/php/uploaduser/<?php echo $strukimg_pesan;?>" class="a_img_itemorder">
                                <img src="<?php echo GLOBAL_URL;?>/penampakan/images/php/uploaduser/<?php echo $strukimg_pesan;?>" width="40" height="40" class="img_itemorder">
                            </a>
                        <?php } ?>
                    </td>
                    
                    <td id="opsi_<?php echo $trans['id']; ?>" rowspan="1" class="center nowrap">
                        <?php if( $trans['check_rek'] == '1' ){ ?>
                            <img src="penampakan/images/check_ok.png" alt="Done" title="Done" class="status_check" onclick="status_konfrimsaldo('<?php echo $trans['id']; ?>','0')">
                        <?php } else { ?>
                            <img src="penampakan/images/check_no.png" alt="Checked" title="Checked" class="status_check" onclick="status_konfrimsaldo('<?php echo $trans['id']; ?>','1')">
                        <?php } ?>
                    </td>
                    <td class="nowrap center">
                        <?php if( $trans['id_pesanan'] !== '0'){?>
                            <img src="penampakan/images/tab_edit.png" class="tabicon" onclick="edit_konfrim('<?php echo $trans['id']?>')">
                        <?php }?>
                        <?php if( $trans['check_rek'] == '0' ){ ?>
                        <img class="tabicon" src="penampakan/images/tab_delete.png" width="20" height="20" alt="Hapus Transaksi Konfrimasi Top-up" title="Hapus Transaksi Konfrimasi Top-up"
                            onclick="open_del_konfrimsaldo('<?php echo $trans['id']; ?>')"/>
                        <?php } ?>
                        <input type="hidden" id="konfrim_id_<?php echo $trans['id'];?>" value="<?php echo $trans['id'];?>">
                        <input type="hidden" id="konfrim_idpesan_<?php echo $trans['id'];?>" value="<?php echo $trans['id_pesanan'];?>">
                        <input type="hidden" id="konfrim_iduser_<?php echo $trans['id'];?>" value="<?php echo $trans['iduser'];?>">
                        <input type="hidden" id="konfrim_name_<?php echo $trans['id'];?>" value="<?php echo $trans['namauser'];?>">
                        <input type="hidden" id="konfrim_telp_<?php echo $trans['id'];?>" value="<?php echo querydata_user($trans['iduser'],'telp');?>">
                        <input type="hidden" id="konfrim_date_<?php echo $trans['id'];?>" value="<?php echo date('j F Y',$trans['tanggal']);?>">
                        <input type="hidden" id="konfrim_hour_<?php echo $trans['id'];?>" value="<?php echo date('H',$trans['tanggal']);?>">
                        <input type="hidden" id="konfrim_minute_<?php echo $trans['id'];?>" value="<?php echo date('i',$trans['tanggal']);?>">
                        <input type="hidden" id="konfrim_payfrom_<?php echo $trans['id'];?>" value="<?php echo $trans['bankuser'];?>">
                        <input type="hidden" id="konfrim_nominal_<?php echo $trans['id'];?>" value="<?php echo $trans['uang_tf'];?>">
                    </td>
                </tr>   
                <?php } ?>
            </tbody>      
            </table>
        </div>

        <?php //new box inventaris ?>
        <div class="popkat" id="pop_addkonfrim" style="width: 450px;">
            <h3><span id="titlekonfrim">Tambah</span> Konfirmasi <span id="titlekonfrimid"></span></h3>
            <table class="stdtable">
                <tr>
                    <td>ID Pesanan <span class="harus">*</span></td>
                    <td><span title="Isikan sesuai nomor pesanan"><input type="text" name="idpesan" id="idpesan" style="width: 200px;" oninput="get_namekonfrim();"></span></td>
                </tr>
                <tr>
                    <td>Nama Pembeli <span class="harus">*</span></td>
                    <td><span title="Isikan nama sesuai nomor pesanan"><input type="text" name="name_cust" id="name_cust" style="width: 200px;"></td>
                </tr>
                <!--<tr>
                    <td>Telepon</td>
                    <td><input type="text" name="telp_konfirm" id="telp_konfirm" style="width: 200px;"></td>
                </tr>-->
                 <tr>
                    <td>Tanggal <span class="harus">*</span></td>
                    <td>
                        <input type="text" class="date datepicker" name="date" id="date" value="<?php echo date('j F Y'); ?>"/>
                        &nbsp;
                        <select name="hour" id="hour">
                            <?php $hnow = date('H'); $h = 0; while($h <= 23) { $hshow = sprintf("%02d", $h); ?>
                            <option value="<?php echo $hshow; ?>" <?php auto_select($hnow,$hshow); ?> ><?php echo $hshow; ?></option>
                            <?php $h++; } ?>
                        </select>
                        <select name="minute" id="minute">
                            <?php $mnow = date('i'); $m = 0; while($m <= 59) { $mshow = sprintf("%02d", $m); ?>
                            <option value="<?php echo $mshow; ?>" <?php auto_select($mnow,$mshow); ?> ><?php echo $mshow; ?></option>
                            <?php $m++; } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Pembayaran Dari <span class="harus">*</span></td>
                    <td><input type="text" name="pay_from" id="pay_from" style="width: 200px;"></td>
                </tr>
                <tr>
                    <td>Nominal Transfer <span class="harus">*</span></td>
                    <td><input type="text" name="nominal_trans" id="nominal_trans" class="jnumber" style="width: 200px;"></td>
                </tr>
               
            </table>
            <div class="submitarea">
                <input type="button" value="Batal" name="inv_cancel" id="addkofrim_back" class="btn batal_btn" onclick="close_addkonfrim()" title="Tutup window ini"/>
                <input type="button" value="Simpan" name="trans_inv" id="trans_inv" class="btn save_btn" onclick="save_newkonfrim()"/>
                <input type="hidden" id="konfrim_id" value="0" />
                <div class="notif" id="notif_konfrim" style="display:none; margin-top: 4px;"></div>
                <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" id="konfrim_loader" alt="Mohon ditunggu..." />
            </div>
        </div>
        <?php // End new box inventaris ?>

    </div>
</div>

<div class="popup popdel" id="popdel_konfrimsaldo">
	<strong>Apakah Anda yakin ingin menghapus Transaksi ID <span id="delete_id_text"></span> ?</strong>
    <br /><br />
    <input type="button" class="btn back_btn" id="delusercancel" name="delusercancel" value="Batal" onclick="cancel_del_konfrimsaldo()"/>
    &nbsp;&nbsp;
    <input type="button" class="btn delete_btn"  id="deluserok" name="deluserok" value="Hapus!" onclick="del_konfrimsaldo()"/>
    <div id="prosesdel" class="none" style="padding-top:16px; text-align: center;">Menghapus Transaksi... tunggu sebentar.</div>
    <input type="hidden" id="delete_konfrimsaldo" name="delete_konfrimsaldo" value="0"/>
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
            { "orderable": false, "targets": 2 },
            { "orderable": false, "targets": 3 },
			{ "orderable": false, "targets": 4 },
            { "orderable": false, "targets": 7 },
            { "orderable": false, "targets": 8 },
            { "orderable": false, "targets": 9 }
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

<script>
jQuery(document).ready(function() {
  jQuery('.a_img_itemorder').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        closeBtnInside: false,
        fixedContentPos: true,
        mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
        image: {
            verticalFit: true
        },
        zoom: {
            enabled: true,
            duration: 300 // don't foget to change the duration also in CSS
        }
    });
});
</script>