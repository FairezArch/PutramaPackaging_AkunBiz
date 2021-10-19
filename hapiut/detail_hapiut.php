<?php if( is_admin() ){
if (isset($_GET['command'])) { // format: 9_2016
    //$month = $_GET['month'];
    $year = $_GET['year'];
    $type = $_GET['type_hapiut'];
    $baseurl = "hapiut=detailhapiut&detailhapiut=".$type."&year=".$year."&command=Go!";
    if( $type == 'debt' ){ $nametype= 'Hutang'; $link='hutang';}else{ $nametype='Piutang'; $link='piutang';}
} else {
    $type = 'debt';
    //$month = date('n');
    $year = date('Y');
    $nametype= 'Hutang';
   
    $link='hutang';
}
$to_year = mktime(0,0,0,1,1,$year);
$url_download = "type=".$type."&year=".$year;
?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
        <h2 class="topbar"><?php echo $nametype;?> Sebelum Awal <?php echo $year;?></h2>
        <div class="tooltop" style="height: 34px;">
        	<div class="ltool">
                <form method="get" name="thetop">
                <input type="hidden" name="hapiut" value="detailhapiut"/>
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
                 <input type="text" class="datepicker" style="width:120px;" name="dateto" id="dateto" value="<?php echo $inputto; ?>"/> */?> 
                <select id="type_hapiut" name="type_hapiut">
                    <option value="debt" <?php echo auto_select('debt',$type);?>>Hutang</option>
                    <option value="credit" <?php echo auto_select('credit',$type);?>>Piutang</option>
                </select>  
                &nbsp; <span style="color: white;font-size: 19px;font-weight: 500;">&#60;</span> &nbsp;
                <select class="datetop" name="year" id="year">
                        <?php $yfrom = startfrom('year'); $yto = date('Y');
                        while( $yfrom <= $yto ) { ?>
                        <option value="<?php echo $yfrom; ?>" <?php auto_select($year,$yfrom); ?> ><?php echo $yfrom; ?></option>
                        <?php $yfrom++; } ?>
                    </select>
                <input type="submit" class="btn save_btn" name="command" value="Go"/>
                </form>
                <a href="<?php echo GLOBAL_URL;?>/export_excel/xls_detailHapiut.php?<?php echo $url_download;?>" title="Download dalam bentuk file Ms Excel">
                   <div class="rtrans xls"><img src="<?php echo GLOBAL_URL;?>/penampakan/images/excel.png"></div>
                </a>
            </div>
            <?php /*
            <div class="rtrans" onclick="open_debt()" title="Tambah Hutang">Tambah Hutang</div>
                <a href="<?php echo GLOBAL_URL;?>/export_excel/xls_laporanHutang.php?<?php echo $url_download;?>" title="Download dalam bentuk file Ms Excel">
	               <div class="rtrans xls" style="margin-right: 200px;"><img src="<?php echo GLOBAL_URL;?>/penampakan/images/excel.png"></div>
                </a>
            </div>
            */ ?>
        </div>
        <div class="clear"></div>
        <div class="loadnotif" id="loadnotif">
            <img src="penampakan/images/loading-notif.gif" width="42" height="42" alt="please wait" />
            <div class="reportloadtext">Memuat data, mohon ditunggu...</div>
        </div>

        <div class="adminarea">
            <table class="dataTable" width="100%" border="0" id="datatable_list">
                <thead>
                    <tr>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Klien</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">ID</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>   
                <tbody> 
                    <?php
                    $date_now = strtotime('now');
                    $args = "SELECT * FROM hapiut WHERE type='$type' AND aktif='1' AND status='1' ORDER BY status DESC, date DESC";
                    $result = mysqli_query( $dbconnect, $args );
                    while ( $data_hapiut = mysqli_fetch_array($result) ) { 
                        $add_year = strtotime('+1 year',$data_hapiut['date']);
                        $year_hapiut = date('Y',$data_hapiut['date']);
                        if( $data_hapiut['date'] < $to_year ){
                    ?>
                    <tr id="hapiut_<?php echo $data_hapiut['id'];?>">
                        <td class="center"><?php if( '1' == $data_hapiut['status']){ echo 'Hutang';}else{ echo 'Lunas'; } ?></td>
                        <td class="center"><?php echo $ambil_tanggal = date("d M Y",$data_hapiut['date']); ?></td>
                        <td class="center"><?php echo $data_hapiut['person']; ?></td>
                        <td class="center">
                            <?php echo uang($data_hapiut['saldonow']); ?><br />
                            <small>Hutang Awal: <?php echo uang($data_hapiut['saldostart']);?></small>
                        </td>
                        <td class="center"><?php echo $data_hapiut['description']; ?></td>
                        <td class="center"><?php echo $data_hapiut['id']; ?></td>
                        <td class="center">
                            <a href="?hapiut=<?php echo $link;?>&viewdebt=<?php echo $data_hapiut['id']; ?>">
                            <img src="penampakan/images/tab_detail.png" title="Lihat detail <?php echo $nametype;?> ID <?php echo $data_hapiut['id']; ?>" alt="Lihat detail <?php echo $nametype;?> ID <?php echo $data_hapiut['id']; ?>">
                        </a>
                        </td>
                    </tr>
                    <?php } } ?>
                </tbody>       
            </table>
        </div>

<script type="text/javascript">
$(document).ready(function() {
    $("#loadnotif").show();
    $('#datatable_list').DataTable({
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
            { "orderable": false, "targets": 6 }
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