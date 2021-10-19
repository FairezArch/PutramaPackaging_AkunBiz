<?php 
if ( isset($_GET['command']) ) { // format: 9_2016
    $tgl_from = strtotime($_GET['datefrom']);
    $tgl_to = strtotime($_GET['dateto']) + 86399;
    $baseurl = "offline=kasir&datefrom=".$tgl_from."&dateto=".$tgl_to."&command=Go!";
} else {
    $tgl_from = mktime(0,0,0,date('n'),1,date('Y'));
    $tgl_to = mktime(0,0,0,date('n'),date('t'),date('Y')) + 86399;
}
$url_download = "date_from=".$tgl_from."&date_to=".$tgl_to;
check_claimreward();
?>
<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body">
        <?php if( isset($_GET['newsale'])) { include 'penjualan-new.php'; }
              else if(isset($_GET['detailpenjualan'])) { include 'penjualan-view.php'; }
              else if(isset($_GET['cicilanpenjualan'])){ include 'penjualan-cicilan.php'; } else { 
        ?>
            <h2 class="topbar">Daftar Penjualan <?php //echo mktime(13,45,0,10,20,2019);//$timee=  mktime(9,40,0,8,20,2019); echo date('d M Y, H:i:s',$timee);//echo mktime(0,0,0,8,31,2019)." ".date('d M Y, H:i',1574997840);//?></h2>
                <div class="tooltop" style="height: 34px;">
                    <div class="rtrans" onclick="location.href='?offline=kasir&newsale=true'" title="Tambah Transaksi">Tambah Transaksi</div>
                    <div class="ltool">
                        <form method="get" name="thetop">
                        <input type="hidden" name="offline" value="kasir"/>
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
                        <a href="<?php echo GLOBAL_URL;?>/export_excel/xls_laporanDaftarPenjualan.php?<?php echo $url_download;?>" title="Download dalam bentuk file Ms Excel">
                            <div class="rtrans xls" style="margin-right: 225px;"><img src="<?php echo GLOBAL_URL;?>/penampakan/images/excel.png"></div>
                        </a>
                    </div>

                </div>
            <div class="clear"></div>
            <div class="loadnotif" id="loadnotif">
                <img src="penampakan/images/loading-notif.gif" width="42" height="42" alt="please wait" />
                <div class="reportloadtext">Memuat data, mohon ditunggu...</div>
            </div>

        <div class="adminarea">
            <table class="dataTable" width="100%" border="0" id="datatable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Nama/Telp</th>
                    <th scope="col">Nama/Deskripsi Produk</th>
                    <th scope="col">Total</th>
                    <th scope="col" width="50">opsi</th>
                </tr>
            </thead>  
            <tbody> 
                <?php
                $args = "SELECT * FROM pesanan WHERE status_kasir='1' AND waktu_pesan >= '$tgl_from' AND waktu_pesan <= '$tgl_to' ORDER BY waktu_pesan DESC";
                $result = mysqli_query( $dbconnect, $args);
                while ( $data_pesanan = mysqli_fetch_array($result) ) { 
                    //if( $data_pesanan['tipe_bayar'] == 'pay_credit' && $data_pesanan['pembayaran_tunai'] < $data_pesanan['total'] ){
                       //$list_color = 'pay_tipe';
                   // }else{
                    //    $list_color = 'light_blue';
                   // }
                    ?>
                <tr class="<?php //echo $list_color;?>">
                    <td class="center" id="id_<?php echo $data_pesanan['id']; ?>" ><?php echo $data_pesanan['id']; ?></td>
                    <td class="center">
                        <?php echo date('d M Y, H.i s',$data_pesanan['waktu_pesan']); ?>
                    </td>
                    <td style="text-transform:none;">
                    <?php 
                    if( $data_pesanan['id_user'] !== '0' ){
                        $data_nama = querydata_usermember($data_pesanan['id_user'],'nama');
                    }else{
                        $data_nama = $data_pesanan['nama_user'];
                    }
                    echo $data_nama."<br/>".$data_pesanan['telp']; 

                    ?></td>
                    <td class="nowrap"><?php echo tampil_item($data_pesanan['idproduk'],$data_pesanan['jml_order']); ?></td>
                    <td class="center">
                        <?php echo uang($data_pesanan['sub_total']); ?>
                    </td>
                    <td class="center nowrap"><?php //$strr = mktime(0,0,0,3,5,2019); echo $strr;?>
                        <a href="?offline=kasir&detailpenjualan=<?php echo $data_pesanan['id']; ?>">
                            <img src="penampakan/images/tab_detail.png" title="Lihat detail Penjualan <?php echo $data_pesanan['id']; ?>" alt="Lihat detail Penjualan <?php echo $data_pesanan['id']; ?>">
                        </a>
                    <?php if( $data_pesanan['pembayaran_tunai'] + $data_pesanan['pembayaran_tunai_2'] < $data_pesanan['total'] ){?>
                        &nbsp;
                                <a href="?offline=kasir&cicilanpenjualan=<?php echo $data_pesanan['id']; ?>">
                                    <img src="penampakan/images/debt-icon.png" title="Lihat detail cicilan <?php echo $data_pesanan['id']; ?>" alt="Lihat detail cicilan <?php echo $data_pesanan['id']; ?>" width="22" height="22">
                                </a>
                    <?php } ?>
                        &nbsp;
                        <img src="penampakan/images/tab_delete.png" title="Hapus Penjualan <?php echo $data_pesanan['id'];?>" alt="Hapus Penjualan <?php echo $data_pesanan['id'];?>" onclick="hapus_penjualan(<?php echo $data_pesanan['id'];?>);">
                        <input type="hidden" id="idpenjualanprod_del" value="<?php echo $data_pesanan['idproduk'];?>">

                    </td>
                </tr>
                <?php } ?>
            </tbody>       
            </table> 
        </div>
       <?php }?>
    </div> 

<?php
    $jumlah = 1;
    $data_qtymin = '2|6|10|15';
    $data_qtymax = '5|9|14|20';
    $data_hargasatuan = '26500|25000|24000|23000';

    //Explode
    $exp_qtymin =  explode('|', $data_qtymin);
    $exp_qtymax =  explode('|', $data_qtymax);
    $exp_hargasatuan = explode('|', $data_hargasatuan);
       
    if( $jumlah < $exp_qtymin[0] ){
        $harga = 'eceran';
    }else{
        for ($i = 0; $i < count($exp_qtymin); $i++) 
           if ($jumlah < $exp_qtymin[$i]) break;
        $col = $i-1;
        $harga = $exp_hargasatuan[$col];
    }
    //echo 'Harga '.$harga;
?>
</div>

<div class="popdel popup" id="popdel" style="left: 50%;">
    <strong>PERHATIAN!</strong><br />Apakah Anda yakin ingin menghapus penjualan ID <span id="show_idpenjualan"></span> ? Data yang terkait akan ikut dihapus dan tidak dapat dikembalikan lagi.<br /><br />
    <input type="button" id="delproductcancel" name="delproductcancel" value="Batal" class="btn back_btn" onclick="cancel_del_kategori()"/>
    &nbsp;&nbsp;
    <input type="hidden" id="idpenjualan_del">
    <input type="button" id="delpenjualan" class="btn delete_btn" name="delpenjualan" value="Hapus!" onclick="del_penjualan()"/>
    <div id="prosesdel" class="none" style="padding-top: 16px; text-align: center;">Menghapus penjualan ini.. tunggu sebentar</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#loadnotif").show();
    $('#datatable').DataTable({
        "pageLength": 25,
        "order": [[ 0, "desc" ]],
        "lengthChange": true,
        "searching": true,
        "paging": true,
        "info": false,
        "columnDefs": [
            { "orderable": false, "targets": 3 },
            { "orderable": false, "targets": 4 },
            { "orderable": false, "targets": 5 }
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