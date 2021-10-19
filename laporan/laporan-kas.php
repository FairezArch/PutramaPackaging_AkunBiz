<?php 
if ( is_admin() ){
if ( isset($_GET['command']) ) { // format: 9_2016
    $tgl_from = strtotime($_GET['datefrom']);
    $tgl_to = strtotime($_GET['dateto']) + 86399;
    $cashbook = $_GET['slt_cashbook'];
    $baseurl = "report=laporan-kas&slt_cashbook=".$cashbook."&datefrom=".$tgl_from."&dateto=".$tgl_to."&command=Go!";
    if( $cashbook == 'all' ){ $data_cashbook = " - All"; }else{ $data_cashbook = " - ".data_cashbook($cashbook,'name'); }
} else {
    $tgl_from = mktime(0,0,0,date('n'),1,date('Y'));
    $tgl_to = mktime(0,0,0,date('n'),date('t'),date('Y')) + 86399;
    $cashbook = 'all';
    $data_cashbook = ' - All';
}
$url_download = "type_cash=".$cashbook."&date_from=".$tgl_from."&date_to=".$tgl_to;

//$args = "SELECT * FROM pesanan WHERE status_cek_bayar != '0' AND aktif='1'";
//$result = mysqli_query($dbconnect,$args);
?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
        <h2 class="topbar">Laporan KAS <?php echo $data_cashbook;?></h2>
        <div class="tooltop" style="height: 34px;">
            <div class="ltool">
                <form method="get" name="thetop">
                	<input type="hidden" name="report" value="laporan-kas"/>
                	<select id="slt_cashbook" name="slt_cashbook">
	            		<option value="all" <?php auto_select($cashbook,'all');?> >Semua Buku Kas</option>
	            		<?php $list_cashbook = querydata_cashbook(); while( $row = mysqli_fetch_array($list_cashbook) ){ ?>
	            		<option value="<?php echo $row['id'];?>" <?php auto_select($cashbook,$row['id']);?> ><?php echo $row['name'];?></option>
	            		<?php } ?>
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
            </div>
                <a href="<?php echo GLOBAL_URL;?>/export_excel/xls_laporanKas.php?<?php echo $url_download;?>" title="Download dalam bentuk file Ms Excel">
                    <div class="rtrans xls"><img src="<?php echo GLOBAL_URL;?>/penampakan/images/excel.png"></div>
                </a>
        </div>
        <div class="clear"></div>
        <div class="loadnotif" id="loadnotif">
            <img src="penampakan/images/loading-notif.gif" width="42" height="42" alt="please wait" />
            <div class="reportloadtext">Memuat data, mohon ditunggu...</div>
        </div>
        <div class="adminarea">
        	<div class="reportleft">
		        <table class="stdtable">
		        	<tr><td colspan="5">&nbsp;</td></tr>
		        	<tr><td><strong>PEMASUKAN</strong></td><td colspan="4">&nbsp;</td></tr>
		        	<?php 
		        		$query_cat = query_cat('in'); $saldo_in = 0;
		        		while ( $cat = mysqli_fetch_array($query_cat) ) {
		        			$saldo_cat = report_cat_day($cat['id'],$tgl_from,$tgl_to,$cashbook);
		        			if ( $saldo_cat > 0 ) { $saldo_in = $saldo_in + $saldo_cat; 
		        	?>
		        	<tr>
			            <td><?php echo $cat['name']; ?></td>
			            <td class="center" >+</td>
			            <td class="right"><?php echo uang($saldo_cat); ?></td>
			            <td class="center" >&nbsp;</td>
			            <td class="right">&nbsp;</td>
		        	</tr>
		        	<?php } } ?>
		        	<tr>
				        <td class="tl_green"><strong>Total Pemasukan</strong></td>
				        <td class="center tl_green" >&nbsp;</td>
				        <td class="right tl_green">&nbsp;</td>
				        <td class="center tl_green" >+</td>
				        <td class="right tl_green"><strong><?php echo uang($saldo_in); ?></strong></td>
					</tr>
					<tr><td colspan="5">&nbsp;</td></tr>
					<tr>
					  	<td><strong>PENGELUARAN</strong></td>
					  	<td class="center" >&nbsp;</td>
				        <td class="right">&nbsp;</td>
				        <td class="center">&nbsp;</td>
				        <td class="right">&nbsp;</td>
					</tr>
					<?php 
		        		$query_cat = query_cat('out'); $saldo_out = 0;
		        		while ( $cat = mysqli_fetch_array($query_cat) ) {
		        			$saldo_cat = report_cat_day($cat['id'],$tgl_from,$tgl_to,$cashbook);
		        			if ( $saldo_cat > 0 ) { $saldo_out = $saldo_out + $saldo_cat; 
		        	?>
		        	<tr>
			            <td><?php echo $cat['name']; ?></td>
			            <td class="center" >+</td>
			            <td class="right"><?php echo uang($saldo_cat); ?></td>
			            <td class="center" >&nbsp;</td>
			            <td class="right">&nbsp;</td>
		        	</tr>
		        	<?php } } ?>
		        	<tr class="tl_red">
				        <td><strong>Total Pengeluaran</strong></td>
				        <td class="center" >&nbsp;</td>
				        <td class="right">&nbsp;</td>
				        <td class="center">-</td>
				        <td class="right"><strong><?php echo uang($saldo_out); ?></strong></td>
					</tr>
					<tr>
				        <td>&nbsp;</td>
				        <td class="center">&nbsp;</td>
				        <td class="right">&nbsp;</td>
				        <td class="center">&nbsp;</td>
				        <td class="right">&nbsp;</td>
				  	</tr>
					<tr class="tl_green">
					  	<td><strong>AKUMULASI</strong></td>
					  	<td class="center" >&nbsp;</td>
				        <td class="right">&nbsp;</td>
				        <td class="center">&nbsp;</td>
				        <?php $akumulasi = $saldo_in-$saldo_out; ?>
				        <td class="right"><strong><?php echo uang($akumulasi); ?></strong></td>
					</tr>
		        </table>
    		</div>
    	</div>
    	<div class="lapblock lapright laprightpad reportright">
	
		    <?php if ( $saldo_out + $saldo_in != 0 ) { ?>
		    <div style="padding-bottom: 64px;padding-top: 32px;"><canvas class="blockchart" id="chart_all" width="480" height="240"/></div>
		    <div class="clear"></div>
		    <div class="roundchart" style="margin: 0 32px;">
		        <div class="halfchart">
		            <h3>Pemasukan</h3>
		            <canvas class="blockchart" id="chart_pemasukan" width="220" height="220"/>
		        </div>
		        <div class="halfchart">
		            <h3>Pengeluaran</h3>
		            <canvas class="blockchart" id="chart_pengeluaran" width="220" height="220"/>
		        </div>
		        <div class="clear" style="height: 64px;"></div>
		    </div>
		    <?php } ?>
		    
		</div>
		<div class="clear"></div>

    </div>
</div>
<?php // chart script ?>
<script type="text/javascript" src="sekrip/chart-1.0.2.min.js"></script>
<script type="text/javascript">
var alldata = {
	labels : ["Buku Kas"],
	datasets : [
		{
			label: "Pemasukan",
			fillColor : "rgba(23,166,151,0.5)",
			strokeColor : "rgba(23,166,151,0.8)",
			highlightFill: "rgba(25,179,163,0.75)",
			highlightStroke: "rgba(25,179,163,1)",
			data : [<?php echo $saldo_in; ?>]
		},
		{
			label: "Pengeluaran",
			fillColor : "rgba(217,50,64,0.5)",
			strokeColor : "rgba(217,50,64,0.8)",
			highlightFill: "rgba(215,71,83,0.75)",
			highlightStroke: "rgba(215,71,83,1)",
			data : [<?php echo $saldo_out; ?>]
		}
	]
}

var pemasukanData = [
	<?php if ($saldo_in > 0 ) {
	$query_cat = query_cat('in');
	while ( $cat = mysqli_fetch_array($query_cat) ) {
		$saldo_cat = report_cat_day($cat['id'],$tgl_from,$tgl_to,$cashbook);
		$round_app = round(($saldo_cat/$saldo_out)*100,2);
		$value_app = number_format((float)$round_app, 2, '.', '');
    ?>
		{
			value: "<?php echo $value_app; ?>",
			color: "<?php echo randomGreen(); ?>",
			highlight: "#0f5959",
			label: "<?php echo $cat['name']; ?>"
		},
	<?php } } ?>
];

var pengeluaranData = [
	<?php  if ($saldo_out > 0 ) {
	$query_cat = query_cat('out');
	while ( $cat = mysqli_fetch_array($query_cat) ) {
		$saldo_cat = report_cat_day($cat['id'],$tgl_from,$tgl_to,$cashbook);
		//echo round(($saldo_cat/$saldo_out)*100,2);
		$round_app = round(($saldo_cat/$saldo_out)*100,2);
		$value_app = number_format((float)$round_app, 2, '.', '');
    ?>
		{
			value: "<?php echo $value_app; ?>",
			color: "<?php echo randomRed(); ?>",
			highlight: "#9c232e",
			label: "<?php echo $cat['name']; ?>"
		},
	<?php } } ?>
];

$(document).ready(function() {
    <?php  if ($saldo_in > 0 ) { ?>
	var pemasukan = document.getElementById("chart_pemasukan").getContext("2d");
	window.myDoughnutpemasukan = new Chart(pemasukan).Doughnut(pemasukanData, {
		tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value.toLocaleString() %>%",
		tooltipFontSize: 11
	});
	<?php }
	if ($saldo_out > 0 ) { ?>
	var pengeluaran = document.getElementById("chart_pengeluaran").getContext("2d");
	window.myDoughnutpengeluaran = new Chart(pengeluaran).Doughnut(pengeluaranData, {
		tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value.toLocaleString() %>%",
		tooltipFontSize: 11
	});
	<?php }
	if ( $saldo_out + $saldo_in != 0 ) { ?>
	var allnlb = document.getElementById("chart_all").getContext("2d");
	window.myBar = new Chart(allnlb).Bar(alldata, {
		multiTooltipTemplate: "<%if (label){%><%=datasetLabel %>: <%}%>Rp. <%= value.toLocaleString() %>",
		barDatasetSpacing : 10,
		barValueSpacing  : 0,
		tooltipFontSize: 12
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