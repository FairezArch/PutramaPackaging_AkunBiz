<?php 
if( is_admin() ){
if ( isset($_GET['command']) ) { // format: 9_2016
	$tgl_from = strtotime($_GET['datefrom']);
	$tgl_to = strtotime($_GET['dateto']) + 86399;
	$baseurl = "report=laporan-pembayaran&datefrom=".$tgl_from."&dateto=".$tgl_to."&command=Go!";
} else {
    $tgl_from = mktime(0,0,0,date('n'),1,date('Y'));
    $tgl_to = mktime(0,0,0,date('n'),date('t'),date('Y')) + 86399;

}
$url_download = "date_from=".$tgl_from."&date_to=".$tgl_to;
?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
    	<h2 class="topbar">Laporan Pembayaran <?php //echo $tgl_from;?></h2>
	        <div class="tooltop" style="height: 34px;">
	        	 <div class="ltool">
                        <form method="get" name="thetop">
                        <input type="hidden" name="report" value="laporan-pembayaran"/>
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
                   </div>
                   <a href="<?php echo GLOBAL_URL;?>/export_excel/xls_laporanPembayaran.php?<?php echo $url_download;?>" title="Download dalam bentuk file Ms Excel">
	                   <div class="rtrans xls" >
	                   		<img src="<?php echo GLOBAL_URL;?>/penampakan/images/excel.png">
	                   </div>
                   </a>
	        </div>
	    <div class="clear"></div>
	    <div class="loadnotif" id="loadnotif">
            <img src="penampakan/images/loading-notif.gif" width="42" height="42" alt="please wait" />
            <div class="reportloadtext">Memuat data, mohon ditunggu...</div>
        </div>

	    <div class="adminarea">
	    	<div class="reportright">
		    	<h2 class="topbar">Chart Metode Pembayaran</h2>
			    <div class="roundchart" style="margin: 0 32px;">
			        <div class="halfchart">
			            <h4>Pembayaran</h4>
			            <canvas class="blockchart" id="chart_metode_pembayaran" width="180" height="180"/>
			        </div>
			        <div class="clear"></div>
			    </div>
			    <div class="clear" style="height: 86px;"></div>
	    	</div>

	    	<div class="reportleft">
	    		<h2 class="topbar">Laporan Metode Bayar</h2>
	    		<table class="dataTable" width="100%" border="0" id="datatable_laporan" style="border-bottom: 1px solid">
	    			<thead>
	    				<tr>
	    					<th scope="col" style="width:50px;">No</th>
	    					<th scope="col" style="width:50px;">Jenis Pembayaran</th>
	    					<th scope="col" style="width:50px;">Total Order</th>
	    					<th scope="col" style="width:50px;">Total Nominal Bayar</th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				<?php
	    				$total_order = array();
	    				$total_nominal_order = array();
	    				$no=1;
	    				$args = "SELECT tipe_bayar,COUNT(id) as all_id, SUM(total) as total_nominal FROM pesanan WHERE aktif=1 AND waktu_pesan >= $tgl_from AND waktu_pesan < $tgl_to GROUP BY tipe_bayar";
	    				$result = mysqli_query($dbconnect,$args);
	    				while ( $data_bayar = mysqli_fetch_array($result) ){
	    		
	    					$list_metode = $data_bayar['tipe_bayar'];
	    					$data_id = $data_bayar['all_id'];
	    					$data_nominal = $data_bayar['total_nominal'];
	    					$data_metodebayar = title_metodebayar($list_metode);

	    					//array
	    					$total_order[] = $data_id;
	    					$total_nominal_order[] = $data_nominal;
		                ?>
	    				<tr>
	    					<td class="center"><?php echo $no;?></td>
	    					<td class="nowrap"><?php echo $data_metodebayar;?></td>
	    					<td class="nowrap center"><?php echo $data_id;?></td>
	    					<td class="nowrap"><?php echo uang($data_nominal);?></td>
	    					<?php $no++; ?>
	    				</tr>
	    				<?php } $result_order = array_sum($total_order); $result_nominal_order = array_sum($total_nominal_order);?>
	    				<tr>
	    					<td colspan="2" class="center"><Strong>Total Keseluruhan</Strong></td>
	    					<td class="nowrap center"><?php echo $result_order;?></td>
	    					<td class="nowrap"><?php echo uang($result_nominal_order);?></td>
	    				</tr>
	    			</tbody>
	    		</table>
	    	</div>
	    </div>
	</div>
</div>

<script type="text/javascript" src="sekrip/chart-1.0.2.min.js"></script>
<script type="text/javascript">
	var jmlorder_app = [
		<?php  
			$get_query = "SELECT tipe_bayar,COUNT(id) as all_id, SUM(total) as total_nominal FROM pesanan WHERE aktif=1 GROUP BY tipe_bayar";
			$result_listbayar = mysqli_query($dbconnect,$get_query);
			while ( $array_listbayar = mysqli_fetch_array($result_listbayar) ) {
			   	$get_id = $array_listbayar['all_id'];
			   	$list_metode = $array_listbayar['tipe_bayar'];
			   	$data_metodebayar = title_metodebayar($list_metode);
			   	if(empty($result_order)){
			   		$value_app = '0';
			   	}else{
			   		$round_app = round(($get_id/$result_order)*100,2);
			   		$value_app = number_format((float)$round_app, 2, '.', '');
			   	}
		?>
			{
			   	value: "<?php echo $value_app;?>",
			   	color: "<?php echo randomGreen();?>",
			   	highlight: "#0f5959",
			   	label: "<?php echo $data_metodebayar;?>"	
			},

		<?php } ?> 
		];

	$(document).ready(function(){
		<?php if($result_order > 0 ){ ?>
			var cek_jumlah_app = document.getElementById("chart_metode_pembayaran").getContext("2d");
			window.myDougnutapp = new Chart(cek_jumlah_app).Doughnut(jmlorder_app,{
				tooltipTemplate: "<% if(label){%><%=label%>: <%}%><%= value.toLocaleString() %>%",
				tooltopFontSize: 11
			});
		<?php } ?>
	});
</script>
<script type="text/javascript">
	$(document).ready(function(e) {
		$('#loadnotif').fadeOut(500);
	});
</script>
<?php } ?>