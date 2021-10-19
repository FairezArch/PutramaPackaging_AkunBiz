<?php if( is_admin() ){
if (isset($_GET['command'])) { // format: 9_2016
    $month = date('n');
    $year = date('Y');
    $type = $_GET['type_inv'];
    $baseurl = "inv=view-inv&type_inv=".$type."&month=".$month."&year=".$year."&command=Go!";
    if( $type == '1' ){ $nametype='Kantor'; $link='office'; }else{ $nametype='Gudang'; $link='warehouse'; }
} else {
    $type = '1';
    $month = date('n');
    $year = date('Y');
    $nametype= 'Kantor'; 
    $link='office';
}

$url_download = "type=".$type."&month=".$month."&year=".$year;
?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
        <h2 class="topbar">Penurunan Inventaris <?php echo $nametype;?></h2>
        <div class="tooltop" style="height: 34px;">
        	<div class="ltool">
                <form method="get" name="thetop">
                <input type="hidden" name="inv" value="view-inv"/>
                <?php /*<select id="type_hapiut" name="type_hapiut">
                <option value="debt" <?php echo auto_select('debt',$type);?>>Hutang</option>
                <option value="credit" <?php echo auto_select('credit',$type);?>>Piutang</option>
                </select>
                <?php if ( isset($_GET['datefrom']) ) { $inputfrom = $_GET['datefrom']; }
                else { $inputfrom = '1 '.date('F Y',mktime(0,0,0,date('n'),1,date('Y'))); } ?>
                <input type="text" class="datepicker" style="width:120px;" name="datefrom" id="datefrom" value="<?php echo $inputfrom; ?>"/>
                &nbsp;Sampai&nbsp; 
                <?php if ( isset($_GET['dateto']) ) { $inputto = $_GET['dateto']; }
                else { $inputto = date('t F Y'); } ?>
                <input type="text" class="datepicker" style="width:120px;" name="dateto" id="dateto" value="<?php echo $inputto; ?>"/>*/ ?> 
                <select id="type_inv" name="type_inv">
                    <option value="1" <?php echo auto_select(1,$type);?>>Kantor</option>
                    <option value="2" <?php echo auto_select(2,$type);?>>Gudang</option>
                </select>  
                &nbsp;
                <select class="datetop none" name="month" id="month">
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
                <select class="datetop none" name="year" id="year">
                        <?php $yfrom = startfrom('year'); $yto = date('Y');
                        while( $yfrom <= $yto ) { ?>
                        <option value="<?php echo $yfrom; ?>" <?php auto_select($year,$yfrom); ?> ><?php echo $yfrom; ?></option>
                        <?php $yfrom++; } ?>
                    </select>
                <input type="submit" class="btn save_btn" name="command" value="Go"/>
                </form>
                <a href="<?php echo GLOBAL_URL;?>/export_excel/xls_detailInventaris.php?<?php echo $url_download;?>" title="Download dalam bentuk file Ms Excel">
                   <div class="rtrans xls"><img src="<?php echo GLOBAL_URL;?>/penampakan/images/excel.png"></div>
                </a>
            </div>

            <?php /*
            <div class="rtrans" onclick="open_debt()" title="Tambah Hutang">Tambah Hutang</div>
                
            </div>
            */ ?>
        </div>
        <div class="clear"></div>
        <div class="loadnotif" id="loadnotif">
            <img src="penampakan/images/loading-notif.gif" width="42" height="42" alt="please wait" />
            <div class="reportloadtext">Memuat data, mohon ditunggu...</div>
        </div>

        <div class="adminarea">
            <table class="dataTable" width="100%" border="0" id="datatable_listinv">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Kode Barang</th>
                        <th scope="col">Tanggal Beli</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Nilai Sekarang</th>
                        <th scope="col">Fluktuasi</th>
                        <th scope="col">Klien</th>
                        <th scope="col">Total Penurunan</th>
                        
                    </tr>
                </thead>   
                <tbody> 
                    <?php
                    echo inventatis_peryear($type,$month,$year);
                    //$date_now = strtotime('now');
                    //$result = table_inv($type);
                    /*while ( $data_inv = mysqli_fetch_array($result) ) { 
                        $add_year = strtotime('+1 year',$data_inv['date']);
                        $year_hapiut = date('Y',$data_inv['date']);
                        if($data_inv['date'] < $to_year){
                    ?>
                    <tr id="hapiut_<?php echo $data_inv['id'];?>">
                        <td class="center"><?php if( '1' == $data_inv['status']) ){ echo 'Hutang'; }else{ echo 'Lunas'; } ?></td>
                        <td class="center"><?php echo $ambil_tanggal = date("d M Y",$data_inv['date']); ?></td>
                        <td class="center"><?php echo $data_inv['person']; ?></td>
                        <td class="center">
                            <?php echo uang($data_inv['saldonow']); ?><br />
                            <small>Hutang Awal: <?php echo uang($data_inv['saldostart']);?></small>
                        </td>
                        <td class="center"><?php echo $data_inv['description']; ?></td>
                        <td class="center"><?php echo $data_inv['id']; ?></td>
                        <td class="center">
                            <a href="?inv=<?php echo $link;?>">
                            <img src="penampakan/images/tab_detail.png" title="Lihat detail <?php echo $nametype; ?> ID <?php echo $data_inv['id']; ?>" alt="Lihat detail <?php echo $nametype; ?> ID <?php echo $data_inv['id']; ?>">
                        </a>
                        </td>
                    </tr>
                    <?php } } ?>*/?>
                </tbody>       
            </table>
        </div>

<script type="text/javascript">
$(document).ready(function() {
    $("#loadnotif").show();
    $('#datatable_listinv').DataTable({
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
            { "orderable": false, "targets": 5 },
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
<?php } ?>