<div class="bloktengah" id="blokkategori">
    <div class="option_body kategori_body body_produklist">
        <?php 
        /*if( isset($_GET['command']) ){
            $type = $_GET['type'];
            $url = "prokat=?produk&type=".$type."&command=Go!";
    
            if( $type == 'open' ){ $type_name=" - Diskon"; }
            elseif( $type == 'non'){ $type_name=" - Non Diskon"; }
            elseif($type == 'all' ){ $type_name=' - Semua Produk'; }
        }else{
            $type='all';
            
        }*/

        $type_name = ' - Semua Produk';
        
        if ( isset($_GET['newproduk'])) { include 'produk-baru.php'; } 
        else if ( isset($_GET['editproduk'])) { include 'produk-edit.php'; } 
        else if ( isset($_GET['viewproduk'])) { include 'produk-view.php'; }
        elseif( isset($_GET['inout_stock'])) { include 'stock_inout.php'; }
        elseif( isset($_GET['viewstock'])){ include 'stock_detail.php'; }
        elseif( isset($_GET['transstock'])) { include 'stock_transfer.php'; }
        //else if ( isset($_GET['checkparcel'])) { include 'check-parcel.php'; } 
        else { ?>
        <h2 class="topbar">Produk<?php 
            
        echo $type_name; ?></h2>
        
        <?php //if( is_admin() || is_ho_logistik() ){ ?>
        <div class="tooltop" style="height: 34px;">
            <div class="ltool none">
                <form method="get" name="thetop">
                    <input type="hidden" name="prokat" value="produk"/>
                    <select name="type" id="type">
                        <option value="all" <?php auto_select($type,'all'); ?>>Semua Produk</option>
                        <option value="open" <?php auto_select($type,'open'); ?>>Diskon</option>
                        <option value="non" <?php auto_select($type,'non'); ?>>Non Diskon</option>
                    </select>
                    <input type="submit" class="btn save_btn" name="command" value="Go"/>
                </form>
            </div>
            <div class="clear"></div>
            <div class="ltrans" onclick="location.href='?prokat=produk&newproduk=true'" title="Tambah Produk">Tambah Produk</div>
            <div class="ltrans" title="Import Product by Excel" style="margin-left: 193px;" onclick="importprod_excel();">Import</div>
            <div class="rtrans" onclick="location.href='?prokat=produk&transstock=true'" title="Transfer Stock" style="margin-right: 250px;" >Transfer Stok</div>
            <div class="rtrans" onclick="location.href='?prokat=produk&inout_stock=true'" title="Tambah/Kurangi Stock">Tambah/Kurangi Stock</div>
             <!--<div class="rtrans" onclick="location.href='?page=produk&checkparcel=true'" title="Check parcel" style="right:200px">Check parcel</div>-->
            <div class="clear"></div>
            <div class="loadnotif" id="loadnotif">
                <img src="penampakan/images/loading-notif.gif" width="42" height="42" alt="please wait" />
                <div class="reportloadtext">Memuat data, mohon ditunggu...</div>
            </div>
        </div>
        <?php// } ?>
        
        <div class="adminarea">
        <?php $listproduk = querylist_diskonprod('all'); ?>
        <table class="dataTable" width="100%" border="0" id="datatable_katmaster">
            <thead>
                <tr>
                    <th scope="col" rowspan="2">ID</th>
                    <th scope="col" rowspan="2">Judul Produk</th>
                    <th scope="col" rowspan="2">Deskripsi</th>
                    <th scope="col" rowspan="2">Harga</th>
                    <th scope="col" colspan="3" style="padding: 5px 0px;">Stock Produk</th>
                    <?php /*<th scope="col" style="display:none">Kategori</th>
                    <th scope="col" style="display:none" >Cabang</th>*/ ?>
                    <th scope="col" rowspan="2">opsi</th>
                    <th class="hidden" rowspan="2">hidden</th>
                </tr>
                <tr>
                    <th scope="col" style="padding: 8px 5px;">Produksi</th>
                    <th scope="col" style="padding: 8px 5px;">Toko</th>
                    <th scope="col" style="padding: 8px 5px;">Display</th>
                </tr>
            </thead>    
            <tbody>
                <?php
                    while ( $data_produk = mysqli_fetch_array($listproduk) ) {
                        if( $data_produk['stock_display'] <= $data_produk['stock_limit']){
                            $css_tr = 'alert_limit';
                        }else{
                            $css_tr = '';
                        }
                ?>
                    <tr class="<?php echo $css_tr;?>">
                        <td class="center" id="id_<?php echo $data_produk['id']; ?>" ><?php echo $data_produk['id']; ?></td>
                        <td>
                            <?php echo $data_produk['title']; ?><br>
                            <strong><small>
                                <?php echo $data_produk['barcode']; ?><br>
                                <?php echo data_kategori($data_produk['idsubkategori'],'kategori'); ?>
                            </small></strong>
                        </td>
                        <td><?php echo excerpt($data_produk['deskripsi'], 100); ?></td>
                        <td class="nowrap right" data-order="<?php echo $data_produk['harga']; ?>">
                            <?php echo uang($data_produk['harga']) ?>
                        </td>
                        <td class="nowrap">
                            <?php echo allstock_display($data_produk['id'],'1'); ?>
                        </td>
                        <td class="nowrap">
                            <?php echo allstock_display($data_produk['id'],'2'); ?>
                        </td>
                        <td class="nowrap">
                            <?php echo allstock_display($data_produk['id'],'3'); ?>
                        </td>
                        <?php /*
                        <td style="display:none">
                            <?php echo data_kategori($data_produk['idsubkategori'],'kategori'); ?><br>
                            <small><strong><?php echo data_kategori($data_produk['idkategori'],'kategori'); ?></strong></small>
                        </td>
                        <td style="display:none"><?php echo $data_produk['cabang']; ?></td>*/?>
                        <td class="center nowrap">
                            <?php if( is_admin() || is_ho_logistik() ){ ?>
                            <a href="?prokat=produk&editproduk=<?php echo $data_produk['id']; ?>">
                                <img src="penampakan/images/tab_edit.png" title="Edit Produk <?php echo $data_produk['title']; ?>" alt="Edit Produk <?php echo $data_produk['title']; ?>">
                            </a>
                            &nbsp;
                            <?php } ?>
                            <a href="?prokat=produk&viewproduk=<?php echo $data_produk['id']; ?>">
                                <img src="penampakan/images/tab_detail.png" title="Lihat detail Produk <?php echo $data_produk['title']; ?>" alt="Lihat detail Produk <?php echo $data_produk['title']; ?>">
                            </a>
                            &nbsp;
                            <a href="?prokat=produk&viewstock=<?php echo $data_produk['id']; ?>">
                                <img src="penampakan/images/warehouse.png" title="Lihat detail Stock Produk <?php echo $data_produk['title']; ?>" alt="Lihat detail Stock Produk <?php echo $data_produk['title']; ?>">
                            </a>
                        </td>
                        <td class="hidden"><?php echo $data_produk['barcode']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>        
        </table>
        </div>
        <?php } ?>
    </div>
    
<?php //Pop up limit product ?>
<?php if( is_admin() ){
    $product = query_produk();
    $id_prodlimit = array();
    $stock_prodlimit = array();
    while($while_prod = mysqli_fetch_array($product)){
        $idproduct = $while_prod['id'];
        $product_limit = $while_prod['stock_limit']; 
        $cek_stock = allstock_display($idproduct,'3');

        if($cek_stock < $product_limit){
            $id_prodlimit[] = $idproduct;
            $stock_prodlimit[] = $product_limit;
        }
    }
    //add
    $id_prodimplode = implode("|", $id_prodlimit);
    $stock_prodimplode = implode("|", $stock_prodlimit);

    //separate
    $id_prodexplode = explode("|", $id_prodimplode);
    $stock_prodexplode = explode("|", $stock_prodimplode);

    if( !empty($id_prodimplode) ){ $rest = 'display: block'; }else{ $rest = 'display: none'; }

?>
<div class="popnotifhome" style="<?php echo $rest;?>" id="popup_limitproduct">
    <div class="popnotif" style="width: 380px;" id="notif_limit">
        <h3>Notifikasi Limit Produk</h3>
        <table class="stdtable">
            <?php 
            $no = 1;
            $count_id = count($id_prodexplode)-1;
            $count_stock = count($stock_prodexplode)-1;
            for($a=0; $a<=$count_id; $a++){
            ?>
            <tr>
                <td><?php echo $no;?></td>
                <td>
                    <a href="?prokat=produk&viewproduk=<?php echo $id_prodexplode[$a];?>" title="Lihat Detail Produk" alt="Lihat Detail Produk" class="link black">Jumlah stock Produk <strong>ID <?php echo $id_prodexplode[$a];?></strong> kurang dari <strong><?php echo $stock_prodexplode[$a];?></strong>
                </td>
            </tr>
            <?php $no++; }?>
            <tr>
                <td colspan="2" class="right">
                    <input type="button" class="btn save_btn" value="Close" onclick="close_notif_limit();">
                </td>
            </tr>
        </table>
    </div>
<?php } ?>
</div>

<div class="popkat" id="open_importprod">
    <h3>Import Excel</h3>
    <form enctype="multipart/form-data" method="POST" action="halaman/proses.php">
    <table class="detailtab" width="100%"> 
        <tr><td class="tebal"><label>Import File Excel</label></td><td><input type="file" name="excelprod" id="excelprod" onchange="checkfileExcel(this);" multiple="multiple"></td></tr> <?php /* accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"onclick="save_importprod();*/?>
    </table>
    <div class="submitarea">
        <input type="button" value="Tutup" name="close_import" id="close_import" class="btn back_btn" onclick="close_importprod();" title="Tutup window ini"/>  
        <input type="submit" value="Simpan" name="save_import" id="save_import" class="btn save_btn" title="Simpan"/>
        <div id="notif_import" class="notif" style="display:none;margin: 10px auto 5px;"></div>  
        <img id="loader_import" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:0px;right:190px;">
    </div>
    </form>
</div>



<script type="text/javascript">
$(document).ready(function() {
    $("#loadnotif").show();
    $('#datatable_katmaster').DataTable({
        "pageLength": 25,
        "order": [[ 1, "asc" ]],
        "lengthChange": true,
        "searching": true,
        "paging": true,
        "info": false,
        "columnDefs": [
            { "orderable": false, "targets": 2 },
            { "orderable": false, "targets": 3 },
            { "orderable": false, "targets": 4 },
            { "orderable": false, "targets": 5 },
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