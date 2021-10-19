<?php 
if( is_admin() ){
if ( isset($_GET['command']) ) { // format: 9_2016
    $tgl_from = strtotime($_GET['datefrom']);
    $tgl_to = strtotime($_GET['dateto']) + 86399;
    $baseurl = "report=laporan-produk&datefrom=".$tgl_from."&dateto=".$tgl_to."&command=Go!";
} else {
    $tgl_from = mktime(0,0,0,date('n'),1,date('Y'));
    $tgl_to = mktime(0,0,0,date('n'),date('t'),date('Y')) + 86399;

}
$url_download = "date_from=".$tgl_from."&date_to=".$tgl_to;

//$args = "SELECT * FROM pesanan WHERE status_cek_bayar != '0' AND aktif='1'";
//$result = mysqli_query($dbconnect,$args);
?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
    	<h2 class="topbar">Laporan Produk</h2>
    	<div class="tooltop" style="height: 34px;">
	       	<div class="ltool">
                <form method="get" name="thetop">
                    <input type="hidden" name="report" value="laporan-produk"/>
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
            <a href="<?php echo GLOBAL_URL;?>/export_excel/xls_laporanproduk.php?<?php echo $url_download;?>" title="Download dalam bentuk file Ms Excel">
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
                <table class="dataTable" width="100%" style="border-bottom: 1px solid;">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col" style="width: 40%;">Nama Produk</th>
                            <th scope="col" style="width: 20%;">HPP</th>
                            <th scope="col" style="width: 20%;">Harga Jual Produk</th>
                            <th scope="col">Jumlah Terjual</th>
                            <th scope="col">Nomilal Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $lap_produk = query_produk(); 
                            $data_totaljumlah = array();
                            $data_totalnominal = array();
                            while($lap_dataproduk = mysqli_fetch_array($lap_produk)){
                                $data_idprod = $lap_dataproduk['id'];
                                $data_jmltransorder = query_transorder($data_idprod,'jumlah',$tgl_from,$tgl_to);
                                $data_hargatransorder = query_transorder($data_idprod,'harga',$tgl_from,$tgl_to);
                                $data_totaljumlah[]  = $data_jmltransorder;
                                $data_totalnominal[] = $data_hargatransorder;
                        ?>
                        <tr id="lap_idprod_<?php echo $lap_dataproduk['id'];?>">
                            <td><?php echo $lap_dataproduk['id'];?></td>
                            <td><?php echo $lap_dataproduk['title'];?></td>
                            <td><?php echo uang($lap_dataproduk['harga_produk']);?></td>
                            <td><?php echo uang($lap_dataproduk['harga']);?></td>
                            <td class="center"><?php echo $data_jmltransorder;?></td>
                            <td><?php echo uang($data_hargatransorder);?></td>
                        </tr>
                        <?php } $total_akhir = array_sum($data_totalnominal); $jumlah_akhir = array_sum($data_totaljumlah);?>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                            <td><strong>Total Keseluruhan</strong></td>
                            <td class="center"><?php echo $jumlah_akhir;?></td>
                            <td><?php echo uang($total_akhir);?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(e) {
        $('#loadnotif').fadeOut(500);
    });
</script>
<?php } ?>