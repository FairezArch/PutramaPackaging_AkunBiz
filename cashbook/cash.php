<?php 
if(is_admin()){
	$cash_id = $_GET['listcash'];
	$data_cashbook = data_cashbook($cash_id);
	if (isset($_GET['command'])) { // format: 9_2016
		$month = $_GET['month'];
		$year = $_GET['year'];
		$baseurl = "listcash=".$cash_id."&month=".$month."&year=".$year."&command=Go!";
	} else {
		$month = date('n');
		$year = date('Y');
		$baseurl = "listcash=".$cash_id;
	}
$from = mktime(0,0,0,$month,1,$year);
$to = mktime(0,0,0,$month+1,1,$year);
$bulantahun = date('F Y',$from);

$from_before = mktime(0,0,0,$month-1,1,$year);
$start_date = date('Y_n',$from_before);	

//Tambahan, array untuk saldo
$args_saldo   = "SELECT * FROM transaction_kas WHERE date >= $from AND date < $to AND active='1' AND (cash='$cash_id' OR cash_to='$cash_id') ORDER BY id ASC";
$result_saldo = mysqli_query( $dbconnect, $args_saldo ); 
$saldo_array  = array();
$saldo        = cash_balance($cash_id,$start_date);
?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
    	<h2 class="topbar">Daftar <?php echo $data_cashbook;?></h2>
        <div class="tooltop" style="height: 34px;">
        	<div class="ltool">
                <form method="get" name="thetop">
                    <input type="hidden" name="listcash" value="<?php echo $cash_id; ?>"/>
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
            <div class="rtrans" onclick="open_takenote()" title="Tambah Hutang">CATAT</div>
                <a href="<?php echo GLOBAL_URL;?>/export_excel/xls_cashbook.php?cash=<?php echo $cash_id; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>" title="Download dalam bentuk file Ms Excel">
	                <div class="rtrans xls" style="margin-right: 110px;">
	                   	<img src="<?php echo GLOBAL_URL;?>/penampakan/images/excel.png">
	                </div>
                </a>
            </div>
            <div class="clear"></div>
            <div class="loadnotif" id="loadnotif">
                <img src="penampakan/images/loading-notif.gif" width="42" height="42" alt="please wait" />
                <div class="reportloadtext">Memuat data, mohon ditunggu...</div>
            </div>

            <table class="datatable" width="100%" border="0" id="datatable_cashbook">
            	<thead>
            		<tr>
            			<th scope="col">Tanggal</th>
            			<th scope="col">Status</th>
            			<th scope="col">Keterangan</th>
            			<th scope="col">Klien</th>
            			<th scope="col">ID</th>
            			<th scope="col">Nominal</th>
            			<th scope="col">Saldo</th>
            			<th scope="col">Aksi</th>
            		</tr>
            	</thead>
            	<tbody>
            		<?php 
            			if ( $result_saldo ) { 
            				while( $transaksi = mysqli_fetch_array($result_saldo) ) {
            				if( $transaksi['type'] == 'in' ){ $smlket= "Pemasukkan"; }else{ $smlket= "Pengeluaran"; }

					        if ( 'in' == $transaksi['type'] || ('0' == $transaksi['category'] && $cash_id != $transaksi['cash']) ) {
					            $saldo = $saldo + $transaksi['amount'];
					        }
					        if ( 'out' == $transaksi['type'] ||  ('0' == $transaksi['category'] && $cash_id == $transaksi['cash']) ) {
					        	if( $saldo == uang(0) ){
					            	$saldo = $transaksi['amount'];
					            }else{
					            	$saldo = $saldo - $transaksi['amount'];
					            }
					        }
					            $saldo_array[] =  $transaksi['id'].'##'.uang($saldo,false);

						   	/*if( $transaksi['pesanan'] != '0' ){
						    	$result_pesanan = querydata_pesanan($transaksi['pesanan'],'status_kasir');
						    	if( $result_pesanan == 1 ){ $srtket= 'penjualan'; }else{ $srtket = 'pesanan'; } 
						    }else if( $transaksi['hapiut'] != '0' ){
						    	$result_hapiut = queryfetchdata_hapiut($transaksi['hapiut'],'type');
						    	if( $result_hapiut == 'debt' ){ $srtket='hutang'; }else{$srtket='piutang';}
						    }else{
						    	$smlket =''; $srtket='';
						    }*/

						    if( $transaksi['category'] == 0 ){
						    	if( $cash_id != $transaksi['cash'] ){
						    		$trans_cat = "Transfer dari ".data_tabel('cash_book',$transaksi['cash'],'name');
						    	}else{
						    		$trans_cat = "Transfer menuju ".data_tabel('cash_book',$transaksi['cash_to'],'name');
						    	}
						    }else{
						    	$child_kat = catmaster(data_tabel('category_kas',$transaksi['category'],'master'));
						    	$trans_cat = data_tabel('category_kas',$transaksi['category'],'name')."<br /><small>".$child_kat;
						    }

						    if( $transaksi['hapiut'] > 0 ){
						    	$type_hapiut = data_tabel('hapiut',$transaksi['hapiut'],'type');
						    	if( $type_hapiut == 'debt' ){
						    		$desc_transkas = '<a href="?hapiut=hutang&viewdebt='.$transaksi['hapiut'].'"> Hutang Piutang '.$transaksi['hapiut'].'</a>';
						    	}else{
						    		$desc_transkas = '<a href="?hapiut=piutang&viewdebt='.$transaksi['hapiut'].'"> Hutang Piutang '.$transaksi['hapiut'].'</a>';
						    	}
						    }else if( $transaksi['hapiut_item'] > 0 ){
						    	$type_hapiutparent = data_tabel('hapiut',$transaksi['hapiut_item'],'parenthp');
						    	$type_hapiut = data_tabel('hapiut',$type_hapiutparent,'type');
						    	if($type_hapiut == 'debt'){
						    		$desc_transkas = '<a href="?hapiut=hutang&viewdebt='.$transaksi['hapiut'].'">Hutang ID '.$transaksi['hapiut'].'</a>';
						    	}else{
						    		$desc_transkas = '<a href="?hapiut=piutang&viewdebt='.$transaksi['hapiut'].'">Piutang ID '.$transaksi['hapiut'].'</a>';
						    	}
						    }else if( $transaksi['inventory'] > 0 || $transaksi['inventory_sell'] > 0 ){
						    	if($transaksi['inventory'] > 0){ $type_inv = $transaksi['inventory']; }else{$type_inv = $transaksi['inventory_sell'];}
						 		$type_hapiut = data_tabel('inventory',$type_inv,'type');
						 		if($type_hapiut == 1 ){
						    		$desc_transkas = '<a href="?inv=office&current='.$type_inv.'">Inventaris ID '.$transaksi['inventory'].'</a>';
							    }else{
							    	$desc_transkas = '<a href="?inv=warehouse&current='.$type_inv.'">Inventaris ID '.$transaksi['inventory'].'</a>';
							    }
						    }else if ( $transaksi['pesanan'] > 0 ) {
						    	$result_pesanan = data_tabel('pesanan',$transaksi['pesanan'],'status_kasir');
						    	if( $result_pesanan == 0 ){ 
						    		$desc_transkas= '<a href="?online=pesanan&detailorder='.$transaksi['pesanan'].'">Transaksi Pesanan ID '.$transaksi['pesanan'].'</a>'; 
						    	}else{ 
						    		$desc_transkas = '<a href="?offline=kasir&detailpenjualan='.$transaksi['pesanan'].'">Transaksi Penjualan ID '.$transaksi['pesanan'].'</a>'; } 
						   	}else if ( $transaksi['logistic'] > 0){
						   		$desc_transkas = '<a href="?logistics=pembelian&beliview='.$transaksi['logistic'].'">Transaksi Pembelian Logistic ID '.$transaksi['logistic'].'</a>';
						   	}else if( $transaksi['cicilan'] > 0 ){
						   		$get_data = data_tabel('log_kredit',$transaksi['cicilan'],'id_pesanan');
						   		$desc_transkas = '<a href="?offline=kasir&cicilanpenjualan='.$get_data.'">Pembayaran Cicilan Pesanan ID '.$get_data.'</a>';
						    }else{
						    	$desc_transkas = $transaksi['description'];
						    }

						    $iduser_trans = querydata_pesanan($transaksi['pesanan'],'id_user');
						    if($transaksi['pesanan'] !='0'){
						    	if( $iduser_trans != '0' ){
						    		$klien = "<a href='?option=user&viewuser=".$iduser_trans."'> Customer ID :".querydata_pesanan($transaksi['pesanan'],'id_user')."<br />".querydata_pesanan($transaksi['pesanan'],'nama_user')."</a>";
						    	}else{
						    		$klien = querydata_pesanan($transaksi['pesanan'],'nama_user');
						    	}
						    }else if($transaksi['cicilan'] !='0'){
						    	$klien = querydata_usermember($transaksi['person'],'nama');
						    }else{
						    	$klien = $transaksi['person'];
						    }


						    $list_saldo_array = join("|",$saldo_array);
						    $array_saldo = explode('|',$list_saldo_array);
						    $count_saldo =  count($array_saldo);
            		?>
            		<tr class="cashbook_<?php echo $transaksi['id'];?>">
            			<td class="center"><?php echo date('d M Y, h.i',$transaksi['date']);?></td>
            			<td><?php echo $trans_cat; ?></td>
            				<?php /*<strong><?php echo ucfirst($srtket);?></strong>
            				<br />
            				<small><?php echo ucfirst($smlket)." ".ucfirst($srtket); ?></small>."".$list_saldo_array;*/ ?>
            			<td><?php echo $desc_transkas; ?></td>
            			<td class="center"><?php echo $klien;?></td>
            			<td class="center"><?php echo $transaksi['id'];?></td>
            			<td><?php echo uang($transaksi['amount']);?></td>
            			<td>
            				<?php 
	            				for( $r=0; $count_saldo > $r; $r++ ){ 
	            					$data_saldo = explode('##', $array_saldo[$r]);
	            					$id_saldo = $data_saldo[0];
	            					$amout_saldo = $data_saldo[1];

	            					if( $id_saldo == $transaksi['id'] ){
	            						echo $amout_saldo;
	            					}
	            				}
            				?>
            			</td>
            			<td class="center">
            				<?php 
            					if($transaksi['inventory'] == '0' && $transaksi['hapiut'] == '0' && $transaksi['logistic'] == '0' && $transaksi['cicilan'] == '0' && $transaksi['pesanan'] == '0' ){
            				?>
                            <img src="penampakan/images/tab_edit.png" title="Edit Transaksi <?php echo $transaksi['id']; ?>" alt="Edit Transaksi <?php echo $transaksi['id']; ?>" class="tabicon" onclick="edit_trans('<?php echo $transaksi['id'];?>')">
                            &nbsp;
                            <img src="penampakan/images/tab_delete.png" title="Hapus Transaksi <?php echo $transaksi['id']; ?>" alt="Hapus Transaksi <?php echo $transaksi['id']; ?>" class="tabicon" onclick="open_del_trans('<?php echo $transaksi['id'];?>')"> 
                            <?php } ?>
                            &nbsp;
                            <input type="hidden" id="type_<?php echo $transaksi['id'];?>" value="<?php echo $transaksi['type']; ?>">
                            <input type="hidden" id="date_<?php echo $transaksi['id'];?>" value="<?php echo date('j F Y',$transaksi['date']); ?>">
                            <input type="hidden" id="month_<?php echo $transaksi['id'];?>" value="<?php echo date('n',$transaksi['date']); ?>">
                            <input type="hidden" id="year_<?php echo $transaksi['id'];?>" value="<?php echo date('Y',$transaksi['date']); ?>">
                            <input type="hidden" id="hour_<?php echo $transaksi['id'];?>" value="<?php echo date('H',$transaksi['date']); ?>">
                            <input type="hidden" id="minute_<?php echo $transaksi['id'];?>" value="<?php echo date('i',$transaksi['date']); ?>">
                            <input type="hidden" id="category_<?php echo $transaksi['id'];?>" value="<?php echo $transaksi['category']; ?>">
                            <input type="hidden" id="cash_from_<?php echo $transaksi['id'];?>" value="<?php echo $transaksi['cash']; ?>">
                            <input type="hidden" id="cash_to_<?php echo $transaksi['id'];?>" value="<?php echo $transaksi['cash_to']; ?>">
                            <input type="hidden" id="person_<?php echo $transaksi['id'];?>" value="<?php echo $transaksi['person']; ?>">
                            <input type="hidden" id="amount_<?php echo $transaksi['id'];?>" value="<?php echo $transaksi['amount']; ?>">
                            <input type="hidden" id="desc_<?php echo $transaksi['id'];?>" value="<?php echo $transaksi['description']; ?>">
            			</td>
            		</tr>
            		<?php }}?>
            	</tbody>
            </table>
        </div>

        <?php //new box hutang ?>
        <div class="popkat" id="pop_cashbook" style="width: 430px;">
        	<h3><span id="titlepop">CATAT</span> TRANSAKSI <span id="titlepopid"></span></h3>
        	<table class="stdtable">
        		<tr id="trtypeselect">
					<td style="width:86px;">Tipe <span class="harus">*</span></td>
					<td>
		                <select name="type" id="type" onchange="trans_tipe()">
		                    <option value="out">Pengeluaran</option>
		                    <option value="in">Pemasukan</option>
		                    <option value="trans">Transfer</option>
		                </select>
		            </td>
				</tr>
				<tr id="trtypestat" class="none">
					<td style="width:86px;">Tipe</td>
					<td id="typetransedit"></td>
				</tr>
        		<tr>
					<td><span title="Tanggal hutang">Tanggal<span class="harus">*</span></span></td>
					<td>
		            	<input type="text" class="date" name="date" id="date" value="<?php echo date('j F Y'); ?>" title="Tanggal mulai berhutang" />
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
				<tr class="trcat">
					<td style="width:86px;">Kategori <span class="harus">*</span></td>
					<td>
		                <select name="category" id="category" style="width: auto; max-width: 260px;">
		                    <option value="">Pilih Kategori..</option>
							<?php $catout = query_cat('out'); while ( $cat = mysqli_fetch_array($catout) ) { ?>
		                    <option value="<?php echo $cat['id']; ?>" class="catout"><?php echo $cat['name']; ?></option>
		                    <?php }
							$catin = query_cat('in'); while ( $cat = mysqli_fetch_array($catin) ) { ?>
		                    <option value="<?php echo $cat['id']; ?>" class="catin none"><?php echo $cat['name']; ?></option>
		                    <?php } ?>
		                </select>
		            </td>
				</tr>
				<tr class="trtrans none cashout">
					<td style="width:86px;">Dari <span class="harus">*</span></td>
					<td>
		                <select name="cash_from" id="cash_from" style="width: auto; max-width: 260px;">
		                    <?php $cash_query = querydata_cashbook(); while ( $cash = mysqli_fetch_array($cash_query) ) { ?>
		                    <option value="<?php echo $cash['id']; ?>"  <?php auto_select($cash_id,$cash['id']); ?> ><?php echo $cash['name']; ?></option>
		                    <?php } ?>
		                </select>
		            </td>
				</tr>
		        <tr class="trtrans none cashin">
					<td style="width:86px;">Menuju <span class="harus">*</span></td>
					<td>
		                <select name="cash_to" id="cash_to" style="width: auto; max-width: 260px;">
		                    <option value="">Pilih Buku Kas..</option>
							<?php //$cash_query = cash_query_form_id($data_cashbook_new); 
								$cash_query = querydata_cashbook(); while ( $cash = mysqli_fetch_array($cash_query) ) { ?>
		                    <option value="<?php echo $cash['id']; ?>"><?php echo $cash['name']; ?></option>
		                    <?php } ?>
		                </select>
		            </td>
				</tr>
				<tr>
					<td>Jumlah <span class="harus">*</span></td>
					<td>
						Rp. &nbsp; 
		                <input type="text" class="jnumber right" name="amount" id="amount" value="0" style="width: 96px;" />
					</td>
				</tr>
				<tr>
					<td>Klien</td>
					<td><input type="text" name="person_cashbook" id="person_cashbook" style="width: 92%;" /></td>
				</tr>
				<tr>
					<td>Keterangan</td>
					<td><textarea name="desc" id="desc" style="width: 92%; height: 48px;"></textarea></td>
				</tr>
				
        	</table>
        	<div class="submitarea">
		        <input type="button" value="Batal" name="debt_cancel" id="debt_cancel" class="btn batal_btn" onclick="close_cashbook()" title="Tutup window ini"/>
		        <input type="button" value="Simpan" name="debt_save" id="debt_save" class="btn save_btn" onclick="save_cashbook()"/>
		        <input type="hidden" id="transid" value="0" />		        
		        <input type="hidden" id="premonth" value="" />
		        <input type="hidden" id="preyear" value="" />
		        <input type="hidden" id="precat" value="" />
		        <input type="hidden" id="precashfrom" value="" />
		        <input type="hidden" id="precashto" value="" />
		        <input type="hidden" id="person_cash" value="" />
		        <input type="hidden" id="cashid" value="<?php echo $cash_id; ?>" />
		        <div class="notif" id="cashbook_notif" style="display:none;"></div>
		        <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" id="cashbook_loader" alt="Mohon ditunggu..." />
			</div>
        </div>
        <?php // End new box hutang ?>

        <?php // START DEL BOX ?>
		<div class="popup popdel" id="popdeltrans" style="left: 50%;">
			<strong>Apakah Anda yakin ingin transaksi ID: <span id="textdelid"></span>?</strong><br />
			Transaksi yang sudah dihapus tidak dapat ditampilkan kembali.
		    <br /><br />
		    <input type="button" id="delcancel" name="delcancel" value="Batal" class="btn back_btn" onclick="cancel_del_trans()"/>
		    &nbsp;&nbsp;
		    <input type="button" id="delok" name="delok" value="Hapus!" class="btn delete_btn" onclick="del_trans()"/>
		    <input type="hidden" id="delid" name="delid" value=""/>
		    <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" id="deltrans_loader" alt="Mohon ditunggu..." />
		</div>
		<?php // END DEL BOX ?>
    </div>
</div>
<?php }?>
<script type="text/javascript">
$(document).ready(function() {
	$("#loadnotif").show();
	$('#datatable_cashbook').DataTable({
        responsive: true,
		"pageLength": 25,
		"order": [[ 0, "asc" ]],
		"lengthChange": true,
		"searching": true,
		"paging": true,
		"info": false,
        "columnDefs": [
        	{ "orderable": false, "targets": 1 },
            { "orderable": false, "targets": 2 },
            { "orderable": false, "targets": 3 },
			{ "orderable": false, "targets": 6 },
			{ "orderable": false, "targets": 7 }
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