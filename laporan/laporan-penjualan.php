<?php 
if( is_admin() ){
if ( isset($_GET['command']) ) { // format: 9_2016
	$tgl_from = strtotime($_GET['datefrom']);
	$tgl_to = strtotime($_GET['dateto']) + 86399;
	$baseurl = "report=laporan&datefrom=".$tgl_from."&dateto=".$tgl_to."&command=Go!";
} else {
	$tgl_from = mktime(0,0,0,date('n'),1,date('Y'));
    $tgl_to = mktime(0,0,0,date('n'),date('t'),date('Y')) + 86399;
}
$url_download = "date_from=".$tgl_from."&date_to=".$tgl_to;

?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
    	<h2 class="topbar">Laporan Penjualan</h2>
	        <div class="tooltop" style="height: 34px;">
	        	 <div class="ltool">
                        <form method="get" name="thetop">
                        <input type="hidden" name="report" value="laporan"/>
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
                   <a href="<?php echo GLOBAL_URL;?>/export_excel/xls_laporanPenjualan.php?<?php echo $url_download;?>" title="Download dalam bentuk file Ms Excel">
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
		    	<h2 class="topbar">Chart Penjualan</h2>
			    <div class="roundchart" style="margin: 0 32px;">
			        <div class="halfchart">
			            <h4>Aplikasi</h4>
			            <canvas class="blockchart" id="chart_penjualan_aplikasi" width="180" height="180"/>
			        </div>
			        <div class="halfchart">
			            <h4>Kasir<h4>
			            <canvas class="blockchart" id="chart_penjualan_kasir" width="180" height="180"/>
			        </div>
			        <div class="clear"></div>
			    </div>
			    <div class="clear" style="height: 86px;"></div>
	    	</div>
	    
	    	<div class="reportleft">
	    		<h2 class="topbar">Laporan Penjualan Via Aplikasi</h2>
	    		<table class="dataTable" width="100%" border="0" id="datatable_laporan" style="border-bottom: 1px solid">
	    			<thead>
	    				<tr>
	    					<th scope="col" style="width:50px;">No</th>
	    					<th scope="col" style="width:50px;">Kategori</th>
	    					<!--<th scope="col">Jumlah produk</th>-->
	    					<th scope="col" style="width:50px;">Jumlah Order</th>
	    					<th scope="col" style="width:50px;">Total Harga</th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				<?php
	    				$hasil_totalharga_app = array();
	    				$hasil_jmlorder_app = array();
	    				$no=1;
			            $result_kat = query_list_kategori('master');
			                if($result_kat){
			                	while ( $data_kategori = mysqli_fetch_array($result_kat) ) {
			                	$get_idkat = $data_kategori['id'];
			                	$get_dataprod = prod_fromkat($get_idkat);
			                	$result_data_jml_app = array();
			                	$result_data_total_app = array();
			                		while($data_prod = mysqli_fetch_array($get_dataprod)){
			                			$idprod = $data_prod['id'];

			                			//Jumlah produk pesanan aplikasi
		    							${'data_orderapp_'.$idprod} =  all_totalpesanan($idprod,'jmlprod_order',$tgl_from,$tgl_to,'aplikasi',NULL); 
		    							$result_data_jml_app[] = ${'data_orderapp_'.$idprod};
		    							$hasil_jmlorder_app[] = ${'data_orderapp_'.$idprod};
		    							
		    							//harga produk pesanan aplikasi
		    							${'data_hargaapp_'.$idprod} = all_totalpesanan($idprod,'totalharga',$tgl_from,$tgl_to,'aplikasi',NULL); 
		    							$result_data_total_app[] = ${'data_hargaapp_'.$idprod};
		    							$hasil_totalharga_app[] = ${'data_hargaapp_'.$idprod};
		    						}
		                ?>
	    				<tr>
	    					<td class="center"><?php echo $no;?></td>
	    					<td class="nowrap"><?php echo $data_kategori['kategori'];?></td>
	    					<!--<td class="nowrap"><?php //echo get_jmlprod_kategori($data_kategori['id'],'master');?></td>-->
	    					<td class="nowrap" style="width:50px;"><?php ${'cek_orderapp_kat'.$get_idkat} = array_sum($result_data_jml_app); echo "<center>".${'cek_orderapp_kat'.$get_idkat}." pcs</center>"; ?>
	    					</td>
	    					<td class="nowrap"><?php $cek_Nominal = array_sum($result_data_total_app); echo uang($cek_Nominal);?>
	    					</td>
	    					<?php $no++; ?>
	    				</tr>
	    				<?php }} $result_allorder_app = array_sum($hasil_jmlorder_app); $result_allharga_app = array_sum($hasil_totalharga_app); ?>
	    				<tr>
	    					<td colspan="2" class="center"><strong>Total Keseluruhan</strong></td>
	    					<td class="nowrap center"><?php echo $result_allorder_app." pcs";?></td>
	    					<td class="nowrap"><?php echo uang($result_allharga_app);?></td>
	    				</tr>
	    			</tbody>
	    		</table>

	    		<br /><br />
	    		<?php /* Laporan Kasir */?>
	    		<h2 class="topbar">Laporan Penjualan Via Kasir</h2>
	    		<table  class="dataTable" width="100%" border="0" id="datatable_laporan" style="border-bottom: 1px solid">
	    			<thead>
	    				<tr>
	    					<th scope="col" style="width:50px;">ID</th>
	    					<th scope="col" style="width:50px;">Kategori</th>
	    					<th scope="col" style="width:50px;">Jumlah Order</th>
	    					<th scope="col" style="width:50px;">Total Harga</th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				<?php
	    				$hasil_totalharga = array();
	    				$hasil_jmlorder = array();
	    				$no=1;
		                $result = query_list_kategori('master');
		                if($result){
		                while ( $data_kategori = mysqli_fetch_array($result) ) {
		                	$get_idkat = $data_kategori['id'];
		                	$get_dataprod = prod_fromkat($get_idkat);
			                $result_data_jml = array();
			                $result_data_total = array();
			                while($data_prod = mysqli_fetch_array($get_dataprod)){ 
			                	$idprod = $data_prod['id'];

			                	//Jumlah produk pesanan kasir
		    					${'data_order_'.$idprod} =  all_totalpesanan($idprod,'jmlprod_order',$tgl_from,$tgl_to,'kasir',NULL);
		    					$result_data_jml[] = ${'data_order_'.$idprod};
		    					$hasil_jmlorder[] = ${'data_order_'.$idprod};// all total jumlah

		    					//Harga produk pesanan kasir
		    					${'data_harga_'.$idprod} = all_totalpesanan($idprod,'totalharga',$tgl_from,$tgl_to,'kasir',NULL);
		    					$result_data_total[] = ${'data_harga_'.$idprod};
		    					$hasil_totalharga[] = ${'data_harga_'.$idprod};// all total harga
		    				}
		                ?>
	    				<tr>
	    					<td class="center"><?php echo $no;?></td>
	    					<td class="nowrap"><?php echo $data_kategori['kategori'];?></td>
	    					<td class="nowrap" style="width:50px;"><?php ${'cek_order_kat'.$get_idkat} = array_sum($result_data_jml); echo "<center>".${'cek_order_kat'.$get_idkat}." pcs</center>"; ?>
	    					</td>
	    					<td class="nowrap"><?php $cek_Nominal = array_sum($result_data_total); echo uang($cek_Nominal);?>
	    					</td>
	    				</tr>
	    				<?php $no++;?>
	    				<?php }} $result_allorder = array_sum($hasil_jmlorder); $result_allharga = array_sum($hasil_totalharga); ?>
	    				<tr>
	    					<td colspan="2" class="center"><strong>Total Keseluruhan</strong></td>
	    					<td class="nowrap center"><?php echo $result_allorder." pcs";?></td>
	    					<td class="nowrap"><?php echo uang($result_allharga);?></td>
	    				</tr>
	    			</tbody>
	    		</table>
	    		
	    	</div>
	    	<div class="clear"></div>
	    </div>
    </div>
</div>
<script type="text/javascript" src="sekrip/chart-1.0.2.min.js"></script>
<script type="text/javascript">
	var jmlorder_app = [
		<?php  
			$get_katapp = query_list_kategori('master');
			   	while ( $data_kategori = mysqli_fetch_array($get_katapp) ) {
			   		$get_id = $data_kategori['id'];
			   		if(empty($result_allorder_app)){
			   			$value_app = '0';
			   		}else{
			   			$round_app = round((${'cek_orderapp_kat'.$get_id}/$result_allorder_app)*100,2);
			   			$value_app = number_format((float)$round_app, 2, '.', '');
			   		}
		?>
			{
			   	value: "<?php echo $value_app;?>",
			   	color: "<?php echo randomGreen();?>",
			   	highlight: "#0f5959",
			   	label: "<?php echo $data_kategori['kategori'];?>"	
			},

		<?php }?> 
		];

	var jmlorder_kasir = [
	<?php  
		$get_katakasir = query_list_kategori('master');
		   	while ( $data_kategori = mysqli_fetch_array($get_katakasir) ) {
		   		$get_id = $data_kategori['id'];
		   		if(empty($result_allorder)){
			   		$value_kasir = '0';
			   	}else{
			   		$round_kasir = round((${'cek_order_kat'.$get_id}/$result_allorder)*100,2);
			   		$value_kasir = number_format((float)$round_kasir, 2, '.', '');
			   	}
	?>
		{
		   	value: "<?php echo $value_kasir;?>",
		   	color: "<?php echo randomGreen();?>",
		   	highlight: "#0f5959",
		   	label: "<?php echo $data_kategori['kategori'];?>"	
		},

	<?php } ?> 
	];

	$(document).ready(function(){
		<?php if($result_allorder > 0 || $result_allorder_app > 0){ ?>
			var cek_jumlah_app = document.getElementById("chart_penjualan_aplikasi").getContext("2d");
			window.myDougnutapp = new Chart(cek_jumlah_app).Doughnut(jmlorder_app,{
				tooltipTemplate: "<% if(label){%><%=label%>: <%}%><%= value.toLocaleString() %>%",
				tooltopFontSize: 11
			});

			var cek_jumlah_kasir = document.getElementById("chart_penjualan_kasir").getContext("2d");
			window.myDougnutkasir = new Chart(cek_jumlah_kasir).Doughnut(jmlorder_kasir,{
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