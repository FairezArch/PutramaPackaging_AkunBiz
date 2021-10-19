<?php 
if( is_admin() ){
if ( isset($_GET['command']) ) { // format: 9_2016
	$tgl_from = strtotime($_GET['datefrom']);
	$tgl_to = strtotime($_GET['dateto']) + 86399;
	$year = date('Y',$tgl_from);
	$month = date('n',$tgl_from);
	$baseurl = "report=laporan-neraca&datefrom=".$tgl_from."&dateto=".$tgl_to."&command=Go!";
} else {
    $tgl_from = mktime(0,0,0,date('n'),1,date('Y'));
    $tgl_to = mktime(0,0,0,date('n'),date('t'),date('Y')) + 86399;
    $year = date('Y',$tgl_from);
	$month = date('n',$tgl_from);
}
$year_month = $year.'_'.$month;
$url_download = "date_from=".$tgl_from."&date_to=".$tgl_to;

//$args = "SELECT * FROM pesanan WHERE status_cek_bayar != '0' AND aktif='1'";
//$result = mysqli_query($dbconnect,$args);
?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
    	<h2 class="topbar">Laporan Neraca</h2>
    	<div class="tooltop" style="height: 34px;">
	       	<div class="ltool">
                <form method="get" name="thetop">
                    <input type="hidden" name="report" value="laporan-neraca"/>
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
            <a href="<?php echo GLOBAL_URL;?>/export_excel/xls_laporanNeraca.php?<?php echo $url_download;?>" title="Download dalam bentuk file Ms Excel">
	            <div class="rtrans xls"><img src="<?php echo GLOBAL_URL;?>/penampakan/images/excel.png"></div>
            </a>
	        </div>
	    <div class="clear"></div>
	    <div class="loadnotif" id="loadnotif">
            <img src="penampakan/images/loading-notif.gif" width="42" height="42" alt="please wait" />
            <div class="reportloadtext">Memuat data, mohon ditunggu...</div>
        </div>
	    <div class="adminarea">
	    	<div class="reportleft" style="width: 58%;">
	    		<?php /*
	    				$nominal = 0;
	    				while( $all_order = mysqli_fetch_array($result)){
	    					$status_total = $all_order['total'];
	    					$status_tunai = $all_order['pembayaran_tunai'];
	    					$all_normal = cek_allamount('normal',$status_total,$status_tunai);
	    					$all_cicil = cek_allamount('cicil',$status_total,$status_tunai);

	    				}
	    				$result = $nominal + $all_normal;
	    				$result_1 = $nominal + $all_cicil;*/

	    				$result = query_list_kategori('master');
	    				$hasil_totalharga_app = array();
	    				$hasil_totalharga_kasir = array();
	    				$hasil_total_hpp_app = array();
	    				$hasil_total_hpp_kasir = array();
	    				if($result){
	    					while( $kategori = mysqli_fetch_array($result) ){
	    						$idkat = $kategori['id'];
	    						$list_prod = prod_fromkat($idkat);
	    						while( $data_prod = mysqli_fetch_array($list_prod) ){
	    							$idprod = $data_prod['id'];
	    							$hargaprd = $data_prod['harga_beli'];

	    							$data_total_app = all_totalpesanan($idprod,'totalharga',$tgl_from,$tgl_to,'aplikasi',NULL);
	    							$hasil_totalharga_app []= $data_total_app;

	    							$data_total_kasir = all_totalpesanan($idprod,'totalharga',$tgl_from,$tgl_to,'kasir',NULL);
	    							$hasil_totalharga_kasir []= $data_total_kasir;

	    							$data_total_hpp_app = all_totalpesanan($idprod,'hpp',$tgl_from,$tgl_to,'aplikasi',$hargaprd);
	    							$hasil_total_hpp_app []=$data_total_hpp_app;

	    							$data_total_hpp_kasir = all_totalpesanan($idprod,'hpp',$tgl_from,$tgl_to,'kasir',$hargaprd);
	    							$hasil_total_hpp_kasir []=$data_total_hpp_kasir;
	    						}

	    					}
	    				}

	    				$result_hargaApp = array_sum($hasil_totalharga_app);
	    				$result_hargaKasir = array_sum($hasil_totalharga_kasir);
	    				$total_akhir = $result_hargaApp + $result_hargaKasir;

	    				$result_hppApp = array_sum($hasil_total_hpp_app);
	    				$result_hppKasir = array_sum($hasil_total_hpp_kasir);
	    				$total_akhir_hpp = $result_hppApp + $result_hppKasir;

	    				$diskonApp= diskon_pesanan('aplikasi',$tgl_from,$tgl_to);
	    				$diskonkasir= diskon_pesanan('kasir',$tgl_from,$tgl_to);
	    				$total_diskon = $diskonApp + $diskonkasir;

	    				$allneraca = neraca_inv(1,$tgl_from,$tgl_to);
	    				$total_value = inv_total_value(1,$tgl_from,$tgl_to);
	    				$menyusut = $allneraca - $total_value;

	    				$allneraca_gudang = neraca_inv(2,$tgl_from,$tgl_to);
	    				$total_value_gudang = inv_total_value(2,$tgl_from,$tgl_to);
	    				$menyusut_gudang = $allneraca_gudang - $total_value_gudang;

	    				$dataKantor_pertahun = inventatis_peryear('1');
	    				$dataGudang_pertahun = inventatis_peryear('2');

	    				$piutang = neraca_hapiut('credit',$tgl_from,$tgl_to);
	    				$piutang_morethan = more_neracahapiut('credit',$tgl_from,$tgl_to);

	    				$hutang =  neraca_hapiut('debt',$tgl_from,$tgl_to);
	    				$hutang_morethan = more_neracahapiut('debt',$tgl_from,$tgl_to);

	    				$Kantorinv_sell=total_sellinventaris(1,$tgl_from,$tgl_to);
	    				$Gudanginv_sell=total_sellinventaris(2,$tgl_from,$tgl_to);
	    				$kas = cash_balance(0,$year_month);
	    				
	    		?>
				<table class="stdtable">
					<tr>
						<td><strong>ASET</strong></td><td colspan="4">&nbsp;</td>
					</tr>
					<tr>
						<td>Kas</td>
						<td> + </td>
						<td colspan="2"><?php if($kas > 0){ echo uang($kas); } else { echo uang(0); }?></td>
						
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>Piutang usaha</td>
						<td> + </td>
						<td colspan="2"><?php if($piutang > 0){ echo uang($piutang); } else { echo uang(0); }?></td>
						
						<td>&nbsp;</td>
					</tr>
					<?php /*
					<tr>
						<td>Piutang usaha lebih dari Setahun</td>
						<td>&nbsp;</td>
						<td colspan="2"><?php if($piutang_morethan > 0){ echo uang($piutang_morethan); } else { echo uang(0); }?></td>
						
						<td>&nbsp;</td>
					</tr>
					*/?>
					<?php if($allneraca > 0){ ?>
					<tr>
						<td>Inventaris Kantor</td>
						<td> + </td>
						<td colspan="2"><?php if($allneraca > 0){ echo uang($allneraca); }else{ echo uang(0);}?></td>
						
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>Akumulasi Penyusutan Inventaris Kantor</td>
						<td> - </td>
						<td colspan="2"><?php echo uang($menyusut);?></td>
						
						<td>&nbsp;</td>
					</tr>
					<?php } ?>
					<?php /*<tr>
						<td>Akumulasi Penyusutan Inventaris Kantor Tahun <?php echo date("Y",$tgl_from);?></td>
						<td> &nbsp; </td>
						<td colspan="2"><?php echo uang($dataKantor_pertahun);?></td>
						
						<td>&nbsp;</td>
					</tr> */ if( $Kantorinv_sell > 0 ){?>

					<tr>
						<td>Penjualan Inventaris Kantor</td>
						<td> + </td>
						<td colspan="2"><?php echo uang($Kantorinv_sell);?></td>
						<td>&nbsp;</td>
					</tr>
					<?php } ?>
					<?php if($allneraca_gudang > 0){ ?>
					<tr>
						<td>Inventaris Gudang</td>
						<td> + </td>
						<td colspan="2"><?php if($allneraca_gudang > 0){ echo uang($allneraca_gudang); }else{ echo uang(0);}?></td>
						
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>Akumulasi Penyusutan Inventaris Gudang</td>
						<td> - </td>
						<td colspan="2"><?php echo uang($menyusut_gudang);?></td>
						
						<td>&nbsp;</td>
					</tr>
					<?php /*
					<tr>
						<td>Akumulasi Penyusutan Inventaris Gudang Tahun <?php echo date("Y",$tgl_from);?></td>
						<td> &nbsp; </td>
						<td colspan="2"><?php echo uang($dataGudang_pertahun);?></td>
						
						<td>&nbsp;</td>
					</tr> */?>
					<tr>
						<td>Penjualan Inventaris Gudang</td>
						<td> + </td>
						<td colspan="2"><?php echo uang($Gudanginv_sell);?></td>
						
						<td>&nbsp;</td>
					</tr>
					<?php } ?>
					<tr class="tl_green">
						<td colspan="3"><strong>Total Aset</strong></td>
						
						<td colspan="2" class="right"><strong><?php $total_aset = $piutang+$allneraca-$menyusut+$Kantorinv_sell+$allneraca_gudang-$menyusut_gudang+$Gudanginv_sell; echo uang($total_aset);?></strong></td>
					</tr>
					<tr><td colspan="5">&nbsp;</td></tr>
					
					<tr>
						<td><strong>Kewajiban</strong></td><td colspan="4">&nbsp;</td>
					</tr>
					
					<tr>
						<td>Hutang</td>
						<td> + </td>
						<td colspan="2"><?php echo uang($hutang);?></td>
						<td>&nbsp;</td>
					</tr>
					<?php /*
					<tr>
						<td>Hutang Lebih dari setahun</td>
						<td>&nbsp;</td>
						<td colspan="2"><?php echo uang($hutang_morethan);?></td>
						<td>&nbsp;</td>
					</tr>
					*/?>
					<tr class="tl_red">
						<td colspan="2"><strong>Total Kewajiban</strong></td>
						<td><strong><?php echo uang($hutang);?></strong></td>
					</tr>
					
					<tr><td colspan="5">&nbsp;</td></tr>

					<tr>
						<td><strong>Modal</strong></td><td colspan="4">&nbsp;</td>
					</tr>
					<?php 
					$modal = $total_aset - $hutang; 
					?>
					<tr>
						<td>Modal</td>
						<td> + </td>
						<td><?php echo uang($modal);?></td>
						<td>&nbsp;</td>
					</tr>
				
					<tr class="tl_green">
						<td colspan="2"><strong>Total Modal</strong></td>
						<td><strong><?php echo uang($modal);?></strong></td>
					</tr>
					<tr><td colspan="5">&nbsp;</td></tr>
					
					<tr class="tl_green">
						<td colspan="3"><strong>TOTAL KEWAJIBAN DAN MODAL USAHA</strong></td>	
						<td colspan="2" class="right"><strong><?php echo uang($total_aset);?></strong></td>
					</tr>
					<?php /*
					<tr>
						<td><strong>PENDAPATAN PENJUALAN</strong></td><td colspan="3">&nbsp;</td>
					</tr>
					<?php if($total_akhir > 0){ ?>
					<tr>
						<td>Penjualan</td>
						<td> + </td>
						<td><?php echo uang($total_akhir);?></td>
						<td>&nbsp;</td>
					</tr>
					<?php } ?>
					<?php if($total_diskon > 0){?>
					<tr>
						<td>Diskon Penjualan</td>
						<td> - </td>
						<td><?php echo uang($total_diskon);?></td>
						<td>&nbsp;</td>
					</tr>
					<?php } ?>
					<tr class="tl_green">
						<td colspan="3"><strong>Total Penjualan</strong></td>
						<td><strong><?php $akumulasi = $total_akhir - $total_diskon; echo uang($akumulasi); ?></strong></td>
					</tr>
					<tr><td colspan="4">&nbsp;</td></tr>
					<tr>
						<td><strong>HARGA POKOK PENJUALAN</strong></td><td colspan="3">&nbsp;</td>
					</tr>
					<?php if($total_akhir_hpp > 0){?>
					<tr>
						<td>HPP Produk</td>
						<td> + </td>
						<td><?php echo uang($total_akhir_hpp);?></td>
						<td>&nbsp;</td>
					</tr>
					<?php } ?>
					<tr class="tl_green">
						<td colspan="3"><strong>Total Pengeluaran</strong></td>
						<td><strong><?php echo uang($total_akhir_hpp); ?></strong></td>
					</tr>
					<tr><td colspan="4">&nbsp;</td></tr>
					<tr class="tl_red"><td><strong>LABA KOTOR</strong></td><td colspan="2">&nbsp;</td><td><strong><?php $laba_kotor = $total_aset + $akumulasi - $total_akhir_hpp; echo uang($laba_kotor)?></strong></td></tr>
					<tr><td colspan="4">&nbsp;</td></tr>
					<tr>
						<td><strong>HUTANG</strong></td><td colspan="3">&nbsp;</td>
					</tr>
					<?php 
					$totalhpp = neraca_hapiut('debt',$tgl_from,$tgl_to);
					if($totalhpp > 0){?>
					<tr>
						<td>Hutang</td>
						<td> + </td>
						<td><?php  echo uang($totalhpp);?></td>
						<td>&nbsp;</td>
					</tr>
					<?php } ?>
					<tr class="tl_red"><td><strong>Total Hutang</strong></td><td colspan="2">&nbsp;</td><td><strong><?php echo uang($totalhpp)?></strong></td></tr>
					<tr><td colspan="4">&nbsp;</td></tr>
					<tr class="tl_green"><td><strong>LABA BERSIH</strong></td><td colspan="2">&nbsp;</td><td><strong><?php $laba_bersih = $laba_kotor - $totalhpp; echo uang($laba_bersih)?></strong></td></tr>
					*/?>
				</table>
				<br />
	    	</div>
	    </div>
	    <div class="lapblock lapright laprightpad reportright"  style="width: 39%;">
		    <?php if ( $total_aset > 0 ) { ?>
		    <div class="halfchart" style="padding-bottom: 61px;">
		    	<h3 class="center" style="padding-bottom: 12px;"><strong>Aset</strong></h3>
		    	<canvas class="blockchart" id="chart_pemasukan" width="180" height="180"/>
		    </div>
		    <div class="halfchart" style="padding-bottom: 61px;">
		    	<h3 class="center" style="padding-bottom: 12px;"><strong>Kewajiban dan Ekuitas</strong></h3>
		    	<canvas class="blockchart" id="chart_pengeluaran" width="180" height="180"/>
		    </div>
		    <?php } ?>
		    <div class="clear"></div>
		    
		    <div class="fullchart" style="padding-bottom: 64px;padding-top: 32px;">
		    	<canvas class="blockchart" id="chart_all" width="360" height="240"/>
		    </div>
		    
		</div>
		<div class="clear" style="height: 32px;"></div>
    </div>
</div>
<?php // chart script ?>
<script type="text/javascript" src="sekrip/chart-1.0.2.min.js"></script>
<script type="text/javascript">
var pemasukanData = [
	<?php if ( $total_aset > 0 ) { 
		$round_Kas = round( ($kas/$total_aset)*100 ,2);
		$value_Kas = number_format((float)$round_Kas, 2, '.', '');

		$round_Piutang = round( ($piutang/$total_aset)*100 ,2);
		$value_Piutang = number_format((float)$round_Piutang, 2, '.', '');

		$round_Kantor = round( ($total_value/$total_aset)*100 ,2);
		$value_Kantor = number_format((float)$round_Kantor, 2, '.', '');

		$round_Gudang = round( ($total_value_gudang/$total_aset)*100 ,2);
		$value_Gudang = number_format((float)$round_Gudang, 2, '.', '');

		$round_Kewajiban = round( ($hutang/$total_aset)*100 ,2);
		$value_Kewajiban = number_format((float)$round_Kewajiban, 2, '.', '');

		$round_Ekuitas = round( ($modal/$total_aset)*100 ,2);
		$value_Ekuitas = number_format((float)$round_Ekuitas, 2, '.', '');
	?>
	{
		value: "<?php echo $value_Kas; ?>",
		color:"#0f5959",
		highlight: "#167575",
		label: "Kas"
	},
	{
		value: "<?php echo $value_Piutang; ?>",
		color:"#17a697",
		highlight: "#16b4a3",
		label: "Piutang"
	},
	
	{
		value: "<?php echo $value_Kantor; ?>",
		color:"#17a697",
		highlight: "#16b4a3",
		label: "Inventaris Kantor"
	},
	{
		value: "<?php echo $value_Gudang; ?>",
		color:"#0f5959",
		highlight: "#167575",
		label: "Inventaris Gudang"
	},
	<?php } ?>
];

var pengeluaranData = [
	<?php if ( $total_aset > 0 ) { ?>
	{
		value: "<?php echo $value_Kewajiban; ?>",
		color:"#d93240",
		highlight: "#e43f4d",
		label: "Kewajiban"
	},
	{
		value: "<?php echo $value_Ekuitas; ?>",
		color:"#c22b37",
		highlight: "#c03540",
		label: "Ekuitas"
	}
	<?php } ?>
];

var alldata =
	{
		labels : ["Aset VS Kewajiban"],
		datasets : [
			{
				label: "Aset",
				fillColor : "rgba(23,166,151,0.5)",
				strokeColor : "rgba(23,166,151,0.8)",
				highlightFill: "rgba(25,179,163,0.75)",
				highlightStroke: "rgba(25,179,163,1)",
				data : [<?php echo $total_aset; ?>]
			},
			{
				label: "Kewajiban",
				fillColor : "rgba(217,50,64,0.5)",
				strokeColor : "rgba(217,50,64,0.8)",
				highlightFill: "rgba(215,71,83,0.75)",
				highlightStroke: "rgba(215,71,83,1)",
				data : [<?php echo $hutang; ?>]
			}
		]
	}

window.onload = function(){
	<?php if ( $total_aset > 0 ) { ?>
	var pemasukan = document.getElementById("chart_pemasukan").getContext("2d");
	window.myDoughnutpemasukan = new Chart(pemasukan).Doughnut(pemasukanData, {
		tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value.toLocaleString() %>%",
		tooltipFontSize: 11
	});
	var pengeluaran = document.getElementById("chart_pengeluaran").getContext("2d");
	window.myDoughnutpengeluaran = new Chart(pengeluaran).Doughnut(pengeluaranData, {
		tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value.toLocaleString() %>%",
		tooltipFontSize: 11
	});
	<?php } ?>
	var allnlb = document.getElementById("chart_all").getContext("2d");
	window.myBar = new Chart(allnlb).Bar(alldata, {
		multiTooltipTemplate: "<%if (label){%><%=datasetLabel %>: <%}%>Rp <%= value.toLocaleString() %>",
		barDatasetSpacing : 10,
		barValueSpacing  : 0,
		tooltipFontSize: 12
	});
};
</script>
<script type="text/javascript">
	$(document).ready(function(e) {
		$('#loadnotif').fadeOut(500);
	});
</script>
<?php } ?>