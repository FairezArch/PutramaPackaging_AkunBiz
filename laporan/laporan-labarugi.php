<?php 
if( is_admin() ){
if ( isset($_GET['command']) ) { // format: 9_2016
    $tgl_from = strtotime($_GET['datefrom']);
    $tgl_to = strtotime($_GET['dateto']) + 86399;
    $baseurl = "report=laporan-jualrugi&datefrom=".$tgl_from."&dateto=".$tgl_to."&command=Go!";
} else {
    $tgl_from = mktime(0,0,0,date('n'),1,date('Y'));
    $tgl_to = mktime(0,0,0,date('n'),date('t'),date('Y')) + 86399;
}

$month= date('n',$tgl_from);
$year = date('Y',$tgl_from);

$pre_month_year = ($month-1).'_'.$year;
$month_year = $month.'_'.$year;

$url_download = "date_from=".$tgl_from."&date_to=".$tgl_to;

//$args = "SELECT * FROM pesanan WHERE status_cek_bayar != '0' AND aktif='1'";
//$result = mysqli_query($dbconnect,$args);
?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
        <h2 class="topbar">Laporan Laba Rugi <?php echo $tgl_to;?></h2>
        <div class="tooltop" style="height: 34px;">
            <div class="ltool">
                <form method="get" name="thetop">
                    <input type="hidden" name="report" value="laporan-labarugi"/>
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
                <a href="<?php echo GLOBAL_URL;?>/export_excel/xls_laporanLabarugi.php?<?php echo $url_download;?>" title="Download dalam bentuk file Ms Excel">
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
                <?php 
                        /*
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

                        $result_hargaApp   = array_sum($hasil_totalharga_app);
                        $result_hargaKasir = array_sum($hasil_totalharga_kasir);
                        $total_akhir       = $result_hargaApp + $result_hargaKasir;

                        $result_hppApp   = array_sum($hasil_total_hpp_app);
                        $result_hppKasir = array_sum($hasil_total_hpp_kasir);
                        $total_akhir_hpp = $result_hppApp + $result_hppKasir;

                        $diskonApp    = diskon_pesanan('aplikasi',$tgl_from,$tgl_to);
                        $diskonkasir  = diskon_pesanan('kasir',$tgl_from,$tgl_to);
                        $total_diskon = $diskonApp + $diskonkasir;

                        $allneraca   = neraca_inv(1,$tgl_from,$tgl_to);
                        $total_value = inv_total_value(1,$tgl_from,$tgl_to);
                        $menyusut    = $allneraca - $total_value;

                        $allneraca_gudang   = neraca_inv(2,$tgl_from,$tgl_to);
                        $total_value_gudang = inv_total_value(2,$tgl_from,$tgl_to);
                        $menyusut_gudang    = $allneraca_gudang - $total_value_gudang;

                        $hutang = neraca_hapiut('debt',$tgl_from,$tgl_to);
                        //$akumulasi = $total_akhir - $total_diskon;
                        //$laba_kotor = $akumulasi - $total_akhir_hpp; 
                        //$laba_bersih = $laba_kotor - $total_akhir_hpp; 

                        $pendapatan_penjualan = report_mastercat('pd_jual_tambah',$tgl_from,$tgl_to);

                        $retur       = report_mastercat('pg_retur',$tgl_from,$tgl_to);
                        $diskon      = report_mastercat('pg_diskon',$tgl_from,$tgl_to);
                        $bebanbeli   = report_mastercat('pg_beli_tambah',$tgl_from,$tgl_to);
                        $gajibeli    = report_mastercat('pg_beli_gaji',$tgl_from,$tgl_to);
                        $gajijual    = report_mastercat('pg_jual_gaji',$tgl_from,$tgl_to);
                        $iklan       = report_mastercat('pg_promo',$tgl_from,$tgl_to);
                        $bebanjual   = report_mastercat('pg_jual_tambah',$tgl_from,$tgl_to);
                        $gajikantor  = report_mastercat('pg_kantor_gaji',$tgl_from,$tgl_to);
                        $bebankantor = report_mastercat('pg_kantor',$tgl_from,$tgl_to);
                        $pajak       = report_mastercat('pg_pajak',$tgl_from,$tgl_to);

                        $returdiskonjual = $retur + $diskon;
                        $returdiskonbeli = $retur + $diskon;
                        //$hpp             = $total_akhir_hpp - $returdiskonbeli;
                        $ongkir          = report_mastercatbyid('16',$tgl_from,$tgl_to);

                        $pembelian_produk = buy_logistic($tgl_from,$tgl_to);

                        $data_produk = query_produk();
                        $awal_produk = array();
                        $akhir_produk = array();
                        $awal_jml = array();
                        $akhir_jml = array();

                        while( $fetch_produk = mysqli_fetch_array($data_produk) ){
                            $awal_produk[]  = product_price($tgl_from,$tgl_to,$fetch_produk['id']) * jml_stok('awal',$tgl_from,$tgl_to,$fetch_produk['id']);
                            $akhir_produk[] = product_price($tgl_from,$tgl_to,$fetch_produk['id']) * jml_stok('akhir',$tgl_from,$tgl_to,$fetch_produk['id']);
                        }

                        $sum_awal     = array_sum($awal_produk);
                        $sum_akhir    = array_sum($akhir_produk);
                        //$sum_jmlawal  = array_sum($awal_jml);
                        //$sum_jmlakhir = array_sum($akhir_jml);

                        $total_awalproduk = $sum_awal;
                        $total_akhirproduk = $sum_akhir;
                        $hpp = $pembelian_produk+$total_awalproduk-$total_akhirproduk;

                        $penjualan_bersih = $total_akhir + $pendapatan_penjualan - $returdiskonjual;
                        $laba_kotor       = $penjualan_bersih - $hpp;

                        $total_beban_jual   = $gajijual + $iklan + $bebanjual;
                        $total_beban_kantor = $gajikantor + $bebankantor;
                        $total_beban_beli   = $bebanbeli + $gajibeli;
                        $beban_operasional  = $total_beban_beli + $total_beban_jual + $total_beban_kantor;
                        $laba_sebelum_pajak = $laba_kotor - $beban_operasional;
                        $laba_bersih        = $laba_sebelum_pajak - $pajak;
                        $pemasukan          = $total_akhir + $pendapatan_penjualan;
                        
                ?>
                <table class="stdtable">
                    <tr><td colspan="4">&nbsp;</td></tr>
                    <tr>
                        <td><strong>PENDAPATAN PENJUALAN</strong></td><td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Penjualan</td>
                        <td> + </td>
                        <td><?php echo uang($total_akhir);?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php if( $pendapatan_penjualan > 0 ){ ?>
                    <tr>
                        <td>Pendapatan Penjualan Lainnya</td>
                        <td> + </td>
                        <td><?php echo uang($pendapatan_penjualan);?></td>
                        <td>&nbsp;</td>
                    </tr>

                    <?php } if($returdiskonjual > 0){?>
                    <tr>
                        <td>Diskon Penjualan</td>
                        <td> - </td>
                        <td><?php echo uang($returdiskonjual);?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php } ?>
                    <?php /* <tr>
                        <td>Ongkir Penjualan</td>
                        <td> - </td>
                        <td><?php if( $ongkir > 0 ){ echo uang($ongkir); }else{echo uang(0);}?></td>
                        <td>&nbsp;</td>
                    </tr> */?>
                    <tr class="tl_green">
                        <td><strong>Total Penjualan Bersih</strong></td>
                        <td> + </td>
                        <td><strong><?php echo uang($penjualan_bersih); ?></strong></td>
                    </tr>
                    <tr><td colspan="4">&nbsp;</td></tr>
                    <tr>
                        <td><strong>HARGA POKOK PENJUALAN</strong></td><td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Pembelian Produk</td>
                        <td> + </td>
                        <td><?php if($pembelian_produk > 0 ){echo uang($pembelian_produk);}else{echo uang(0);}?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Persediaan Awal Produk</td>
                        <td> + </td>
                        <td><?php echo uang($total_awalproduk);?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Persediaan Akhir Produk</td>
                        <td> - </td>
                        <td><?php echo $total_akhirproduk;?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php /*if($returdiskonbeli > 0){?>
                    <tr>
                        <td>Diskon Pembelian Produk</td>
                        <td> + </td>
                        <td><?php echo uang($returdiskonbeli);?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php } */?>
                    <tr class="tl_red">
                        <td><strong>Total Harga Pokok Penjualan</strong></td> 
                        <td> + </td>
                        <td><strong><?php echo uang($hpp); ?></strong></td>
                    </tr>
                    <tr><td colspan="4">&nbsp;</td></tr>
                    <tr class="tl_green">
                        <td><strong>LABA KOTOR</strong></td>
                        <td>&nbsp;</td>
                        <td class="right">+</td>
                        <td class="right"><strong><?php echo uang($laba_kotor)?></strong></td>
                    </tr>
                    <tr><td colspan="4">&nbsp;</td></tr>
                    <tr>
                        <td><strong>Beban</strong></td><td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong>a. Pembelian</strong></td>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Beban Pembelian</td>
                        <td> + </td>
                        <td><?php echo uang($bebanbeli);?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Beban Gaji Staff Pembelian</td>
                        <td> + </td>
                        <td><?php if($gajibeli > 0){ echo uang($gajibeli); }else{echo uang(0);}?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class="tl_red">
                        <td><strong>Total Beban Pembelian</strong></td>
                        <td> + </td>
                        <td><strong><?php echo uang($total_beban_beli);?></strong></td>
                    </tr>
                    <tr><td colspan="4">&nbsp;</td></tr>
                    <tr>
                        <td><strong>b. Penjualan</strong></td><td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Beban Gaji Staff Penjualan</td>
                        <td> + </td>
                        <td><?php if($gajijual > 0){ echo uang($gajijual); }else{ echo uang(0);}?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Beban Iklan dan Promosi</td>
                        <td> + </td>
                        <td><?php echo uang($iklan);?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Beban Penjualan</td>
                        <td> + </td>
                        <td><?php if($bebanjual > 0){ echo uang($bebanjual); }else{ echo uang(0);}?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class="tl_red">
                        <td><strong>Total beban Penjualan</strong></td>
                        <td> + </td>
                        <td><strong><?php echo uang($total_beban_jual);?></strong></td>
                    </tr>
                    <tr><td colspan="4">&nbsp;</td></tr>
                    <tr>
                        <td><strong>c. Kantor</strong></td><td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Beban Gaji Staff Kantor</td>
                        <td> + </td>
                        <td><?php echo uang($gajikantor);?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Beban Kantor</td>
                        <td> + </td>
                        <td><?php if($bebankantor > 0){ echo uang($bebankantor); }else{ echo uang(0);}?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class="tl_red">
                        <td><strong>Total Beban Kantor</strong></td>
                        <td> + </td>
                        <td><strong><?php echo uang($total_beban_kantor);?></strong></td>
                    </tr>
                    <tr><td colspan="4">&nbsp;</td></tr>
                    <tr class="tl_red">
                        <td><strong>TOTAL BEBAN OPERASIONAL</strong></td>
                        <td>&nbsp;</td>
                        <td class="right">-</td>
                        <td class="right"><strong><?php echo uang($beban_operasional);?></strong></td></tr>
                    <tr><td colspan="4">&nbsp;</td></tr>

                    <tr class="tl_green">
                        <td><strong>LABA SEBELUM PAJAK</strong></td>
                        <td>&nbsp;</td>
                        <td class="right">+</td>
                        <td class="right"><strong><?php echo uang($laba_sebelum_pajak);?></strong></td>

                    </tr>
                    <tr>
                        <td>Pajak</td>
                        <td>&nbsp;</td>
                        <td class="right"> - </td>
                        <td class="right"><?php if($pajak > 0){ echo uang($pajak); }else{ echo uang(0);}?></td>
                    </tr>
                    <tr><td colspan="4">&nbsp;</td></tr>
                    <tr class="tl_green">
                        <td><strong>LABA BERSIH</strong></td>
                        <td colspan="2">&nbsp;</td>
                        <td class="right"><strong><?php echo uang($laba_bersih);?></strong></td>
                    </tr>

                    <?php /*<tr>
                        <td><strong>HUTANG</strong></td><td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Hutang</td>
                        <td> + </td>
                        <td><?php echo uang($hutang);?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class="tl_red"><td><strong>Total Hutang</strong></td><td colspan="2">&nbsp;</td><td><strong><?php echo uang($hutang)?></strong></td></tr>*/?>
                    
                </table>
                <br />
            </div>
        </div>
        <div class="lapblock lapright laprightpad reportright" style="width:39%; margin-top: 50px;">
    
            <?php //$pemasukan = $penjualan + $pendapatan_penjualan;
            if ( $pemasukan > 0 ) { ?>
            <div style="margin-top: -24px;">
                <h3 align="center"><strong>Income</strong></h3>
                <canvas class="blockchart" id="chart_pemasukan" width="260" height="260"/>
            </div>
            <?php }
            $pengeluaran = $returdiskonjual + $total_akhir_hpp + $beban_operasional + $pajak;
            if ( $pengeluaran > 0 ) { ?>
            <div class="fullchart" style="padding-top: 36px;">
                <h3 align="center"><strong>Outcome</strong></h3>
                <canvas class="blockchart" id="chart_pengeluaran" width="260" height="260"/>
            </div>
            <?php } ?>
            <div class="clear"></div>
            
            <div class="fullchart">
                <canvas class="blockchart" id="chart_all" width="380" height="360"/>
            </div>
            
        </div>
        <div class="clear" style="height: 32px;"></div>
    </div>
</div>
<?php // chart script ?>
<script type="text/javascript" src="sekrip/chart-1.0.2.min.js"></script>
<script type="text/javascript">
var pemasukanData = [
    <?php if ( $pemasukan > 0 ) { ?>
    {
        value: <?php echo round( ($total_akhir/$pemasukan)*100 ,2); ?>,
        color:"#0f5959",
        highlight: "#167575",
        label: "Penjualan Produk"
    },
    {
        value: <?php echo round( ($pendapatan_penjualan/$pemasukan)*100 ,2); ?>,
        color:"#17a697",
        highlight: "#16b4a3",
        label: "Pendapatan Penjualan Lainnya"
    }
    <?php } ?>
];

var pengeluaranData = [
    <?php 
        if ( $pengeluaran > 0 ) { 
        $round_hargapokok = round( ($total_akhir_hpp/$pengeluaran)*100 ,2);
        $value_hargapokok = number_format((float)$round_hargapokok, 2, '.', '');

        $round_retur = round( ($returdiskonjual/$pengeluaran)*100 ,2);
        $value_retur = number_format((float)$round_retur, 2, '.', '');

        $round_pembelian = round( ($total_beban_beli/$pengeluaran)*100 ,2);
        $value_pembelian = number_format((float)$round_pembelian, 2, '.', '');

        $round_beban = round( ($total_beban_jual/$pengeluaran)*100 ,2);
        $value_beban = number_format((float)$round_beban, 2, '.', '');

        $round_bebankantor = round( ($total_beban_kantor/$pengeluaran)*100 ,2);
        $value_bebankantor = number_format((float)$round_bebankantor, 2, '.', '');

        $round_pajak = round( ($total_beban_kantor/$pengeluaran)*100 ,2);
        $value_pajak = number_format((float)$round_pajak, 2, '.', '');
    ?>
    {
        value: "<?php echo $value_hargapokok; ?>",
        color:"#d93240",
        highlight: "#e43f4d",
        label: "Harga Pokok Penjualan"
    },
    {
        value: "<?php echo $value_retur; ?>",
        color:"#c22b37",
        highlight: "#c03540",
        label: "Retur dan Diskon"
    },
    {
        value: "<?php echo $value_pembelian; ?>",
        color:"#f78a3c",
        highlight: "#f59754",
        label: "Beban Pembelian"
    },
    {
        value: "<?php echo $value_beban; ?>",
        color:"#d9763b",
        highlight: "#dc7e45",
        label: "Beban Penjualan"
    },
    {
        value: "<?php echo $value_bebankantor; ?>",
        color:"#c88338",
        highlight: "#c68845",
        label: "Beban Kantor"
    },
    {
        value: "<?php echo $value_pajak; ?>",
        color:"#f7753c",
        highlight: "#f07c49",
        label: "Pajak"
    }
    <?php } ?>
];

<?php $pengeluarandua = $total_akhir_hpp + $beban_operasional + $pajak; ?>
var alldata =
    {
        labels : ["Laba Rugi"],
        datasets : [
            {
                label: "Penjualan Bersih",
                fillColor : "rgba(23,166,151,0.5)",
                strokeColor : "rgba(23,166,151,0.8)",
                highlightFill: "rgba(25,179,163,0.75)",
                highlightStroke: "rgba(25,179,163,1)",
                data : [<?php echo $penjualan_bersih; ?>]
            },
            {
                label: "Total HPP, Beban Operasional, dan Pajak",
                fillColor : "rgba(217,50,64,0.5)",
                strokeColor : "rgba(217,50,64,0.8)",
                highlightFill: "rgba(215,71,83,0.75)",
                highlightStroke: "rgba(215,71,83,1)",
                data : [<?php echo $pengeluarandua; ?>]
            }
        ]
    }

window.onload = function(){
    <?php if ( $pemasukan > 0 ) { ?>
    var pemasukan = document.getElementById("chart_pemasukan").getContext("2d");
    window.myDoughnutpemasukan = new Chart(pemasukan).Doughnut(pemasukanData, {
        tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value.toLocaleString() %>%",
        tooltipFontSize: 11
    });
    <?php }
    if ( $pengeluaran > 0 ) { ?>
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
   // tipelaporankas();
};
</script>
<script type="text/javascript">
    $(document).ready(function(e) {
        $('#loadnotif').fadeOut(500);
    });
</script>
<?php } ?>