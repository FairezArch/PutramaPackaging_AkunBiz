<?php 
if( is_admin() ){
    $idprod_stock = $_GET['viewstock'];
    $dataprod = queryprod($idprod_stock);
    $result_dataprod = mysqli_fetch_array($dataprod);
    $stok = $result_dataprod['stock'];


if ( isset($_GET['command']) ) { // format: 9_2016
    $page_to = $_GET['viewstock'];
    $tgl_from = strtotime($_GET['datefrom']);
    $tgl_to = strtotime($_GET['dateto']) + 86400;
    $baseurl = "prokat=produk&viewstock=".$page_to."&datefrom=".$tgl_from."&dateto=".$tgl_to."&command=Go!";
} else {
    $tgl_from = mktime(0,0,0,date('n')-1,1,date('Y'));
    $tgl_to = mktime(0,0,0,date('n')+1,date('t'),date('Y'));
}
?>

<h2 class="topbar">Detail Stock ID: <?php echo $idprod_stock; ?></h2>
    <div class="tooltop" style="height: 34px;">
        <div class="ltool">

            <form method="get" name="thetop">
                <input type="hidden" name="prokat" value="produk"/>
                <input type="hidden" name="viewstock" value="<?php echo $idprod_stock;?>"/>
                    <?php if ( isset($_GET['datefrom']) ) { $inputfrom = $_GET['datefrom']; }
                    else { $inputfrom = '1 '.date('F Y',mktime(0,0,0,date('n')-1,1,date('Y'))); } ?>
                    <input type="text" class="datepicker" style="width:120px;" name="datefrom" id="datefrom" value="<?php echo $inputfrom; ?>"/>
                    &nbsp;Sampai&nbsp; 
                   <?php if ( isset($_GET['dateto']) ) { $inputto = $_GET['dateto']; }
                   else { $inputto = date('t F Y'); } ?>
                    <input type="text" class="datepicker" style="width:120px;" name="dateto" id="dateto" value="<?php echo $inputto; ?>"/>    
                    &nbsp; 
                    <input type="submit" class="btn save_btn" name="command" value="Go"/>

            </form>
        </div>
    </div>
    <div class="wraptrans wraptranssaldo" style="border-top: unset!important;padding-top: 20px!important;">
    <h3>Daftar Transaksi Stok Produksi</h3>
    <div class="daftrans">
    <table class="dataTable datatable_stockview" width="100%" border="0">
        <thead>
            <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">ID</th>
                <th scope="col">Type</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Deskripsi</th>
             </tr>
        </thead>
        <tbody>
        <?php 
            $data_stock = datastock_transorder($idprod_stock,$tgl_from,$tgl_to,'1');
            while ( $transitem = mysqli_fetch_array($data_stock) ) {
                $get_idpesan = $transitem['id_penjualan'];
                $get_statusprod = querydata_pesanan($get_idpesan,'status_kasir');
                if( $transitem['type'] == 'out' ){ $csstd = 'minus'; }
                elseif( $transitem['type'] == 'in' ){ $csstd = 'plus'; }
                elseif( $transitem['type'] == 'trans') { $csstd = 'Transfer Stock'; }
                else{ $csstd = ''; }

                if ( 'in' == $transitem['type'] ) { $stok = $stok + $transitem['jumlah']; }
                if ( 'out' == $transitem['type'] ) { $stok = $stok - $transitem['jumlah']; }
                
                if( $transitem['trans_from'] !='0' AND ($transitem['type'] == 'in' || $transitem['type'] == 'out')){
                    $desc_trans = $transitem['deskripsi'];
                }elseif ( $transitem['trans_from'] < $transitem['trans_to'] ){
                    $desc_trans = 'Transfer Stock dari'." ".name_transstock($transitem['trans_from'])." ke ".name_transstock($transitem['trans_to']);
                }elseif ( $transitem['trans_from'] > $transitem['trans_to'] ){
                    $desc_trans = 'Dikembalikan dari'." ".name_transstock($transitem['trans_from'])." ke ".name_transstock($transitem['trans_to']);
                }else{
                    if( $transitem['type'] == 'out' && $transitem['id_penjualan'] !== '0' && $get_statusprod == '1' ){ 
                        $desc_trans = "<a href='?offline=penjualan&detailpenjualan=".$transitem['id_pesanan']."' title='Transaksi Penjualan ID ".$transitem['id_pesanan']."' target='_blank'>Transaksi Penjualan ID ".$transitem['id_pesanan']."</a>";
                    }elseif ( $transitem['type'] == 'out' && $transitem['id_pesanan'] !== '0' && $get_statusprod !== '1'){
                        $desc_trans = "<a href='?online=pesanan&detailorder=".$transitem['id_pesanan']."' title='Transaksi Pesanan ID ".$transitem['id_pesanan']."' target='_blank'>Transaksi Pesanan ID ".$transitem['id_pesanan']."</a>";
                    }else{
                        $desc_trans = $transitem['deskripsi'];
                    }
                }
        ?>
     
        <tr class="<?php echo $csstd; ?>" id="hpitem_<?php echo $transitem['id']; ?>">
            <td class="center nowrap" data-order="<?php echo $transitem['date']; ?>"><?php echo date('d M Y, H:i', $transitem['date']); ?></td>
            <td class="right nowrap"><?php echo $transitem['id']; ?></td>
            <td class="center"><?php echo $csstd; ?></td>
            <td class="right nowrap"><strong><?php echo $transitem['jumlah']; ?></strong></td>
            <td><?php echo $desc_trans; ?></td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</div>

<div class="wraptrans wraptranssaldo" style="border-top: unset!important;padding-top: 20px!important;">
    <h3>Daftar Transaksi Stok Toko</h3>
    <div class="daftrans">
    <table class="dataTable datatable_stockview" width="100%" border="0">
        <thead>
            <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">ID</th>
                <th scope="col">Type</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Deskripsi</th>
             </tr>
        </thead>
        <tbody>
        <?php 
            $data_stock = datastock_transorder($idprod_stock,$tgl_from,$tgl_to,'2');
          
            while ( $transitem = mysqli_fetch_array($data_stock) ) {
                $get_idpesan = $transitem['id_penjualan'];
                $get_statusprod = querydata_pesanan($get_idpesan,'status_kasir');
                if( $transitem['type'] == 'out' ){ $csstd = 'minus'; }
                elseif( $transitem['type'] == 'in' ){ $csstd = 'plus'; }
                elseif( $transitem['type'] == 'trans') { $csstd = 'Transfer Stock'; }
                else{ $csstd = ''; }

                if ( 'in' == $transitem['type'] ) { $stok = $stok + $transitem['jumlah']; }
                if ( 'out' == $transitem['type'] ) { $stok = $stok - $transitem['jumlah']; }
                
                if( $transitem['trans_from'] !='0' AND ($transitem['type'] == 'in' || $transitem['type'] == 'out')){
                    $desc_trans = $transitem['deskripsi'];
                }elseif ( $transitem['trans_from'] < $transitem['trans_to'] ){
                    $desc_trans = 'Transfer Stock dari'." ".name_transstock($transitem['trans_from'])." ke ".name_transstock($transitem['trans_to']);
                }elseif ( $transitem['trans_from'] > $transitem['trans_to'] ){
                    $desc_trans = 'Dikembalikan dari'." ".name_transstock($transitem['trans_from'])." ke ".name_transstock($transitem['trans_to']);
                }else{
                    if( $transitem['type'] == 'out' && $transitem['id_penjualan'] != '0' && $get_statusprod == '1' ){ 
                        $desc_trans = "<a href='?offline=penjualan&detailpenjualan=".$transitem['id_pesanan']."' title='Transaksi Penjualan ID ".$transitem['id_pesanan']."' target='_blank'>Transaksi Penjualan ID ".$transitem['id_pesanan']."</a>";
                    }elseif ( $transitem['type'] == 'out' && $transitem['id_pesanan'] != '0' && $get_statusprod !== '1'){
                        $desc_trans = "<a href='?online=pesanan&detailorder=".$transitem['id_pesanan']."' title='Transaksi Pesanan ID ".$transitem['id_pesanan']."' target='_blank'>Transaksi Pesanan ID ".$transitem['id_pesanan']."</a>";
                    }elseif( $transitem['type'] == 'in' && $transitem['id_pembelian'] != '0' ){ 
                        $desc_trans = "<a href='?logistics=pembelian&beliview=".$transitem['id_pembelian']."' title='Transaksi Pembelian ID ".$transitem['id_pembelian']."' target='_blank'>Transaksi Pembelian Logistic ID ".$transitem['id_pembelian']."</a>"; 
                    }else{
                        $desc_trans = $transitem['deskripsi'];
                    }
                }
        ?>
     
        <tr class="<?php echo $csstd; ?>" id="hpitem_<?php echo $transitem['id']; ?>">
            <td class="center nowrap" data-order="<?php echo $transitem['date']; ?>"><?php echo date('d M Y, H:i', $transitem['date']); ?></td>
            <td class="right nowrap"><?php echo $transitem['id']; ?></td>
            <td class="center"><?php echo $csstd; ?></td>
            <td class="right nowrap"><strong><?php echo $transitem['jumlah']; ?></strong></td>
            <td><?php echo $desc_trans; ?></td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</div>

<div class="wraptrans wraptranssaldo" style="border-top: unset!important;padding-top: 20px!important;">
    <h3>Daftar Transaksi Stok Display</h3>
    <div class="daftrans">
    <table class="dataTable datatable_stockview" width="100%" border="0">
        <thead>
            <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">ID</th>
                <th scope="col">Type</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Deskripsi</th>
             </tr>
        </thead>
        <tbody>
        <?php 
            $data_stock = datastock_transorder($idprod_stock,$tgl_from,$tgl_to,'3');
          
            while ( $transitem = mysqli_fetch_array($data_stock) ) {
                $get_idpesan = $transitem['id_penjualan'];
                $get_statusprod = querydata_pesanan($get_idpesan,'status_kasir');
                if( $transitem['type'] == 'out' ){ $csstd = 'minus'; }
                elseif( $transitem['type'] == 'in' ){ $csstd = 'plus'; }
                elseif( $transitem['type'] == 'trans') { $csstd = 'Transfer Stock'; }
                else{ $csstd = ''; }

                if ( 'in' == $transitem['type'] ) { $stok = $stok + $transitem['jumlah']; }
                if ( 'out' == $transitem['type'] ) { $stok = $stok - $transitem['jumlah']; }

                if( $transitem['trans_from'] !='0' AND ($transitem['type'] == 'in' || $transitem['type'] == 'out')){
                    $desc_trans = $transitem['deskripsi'];
                }elseif ( $transitem['trans_from'] < $transitem['trans_to'] ){
                    $desc_trans = 'Transfer Stock dari'." ".name_transstock($transitem['trans_from'])." ke ".name_transstock($transitem['trans_to']);
                }elseif ( $transitem['trans_from'] > $transitem['trans_to'] ){
                    $desc_trans = 'Dikembalikan dari'." ".name_transstock($transitem['trans_from'])." ke ".name_transstock($transitem['trans_to']);
                }else{
                    if( $transitem['type'] == 'out' && $transitem['id_penjualan'] !== '0' && $get_statusprod == '1' ){ 
                        $desc_trans = "<a href='?offline=kasir&detailpenjualan=".$transitem['id_pesanan']."' title='Transaksi Penjualan ID ".$transitem['id_pesanan']."' target='_blank'>Transaksi Penjualan ID ".$transitem['id_pesanan']."</a>";
                    }elseif ( $transitem['type'] == 'out' && $transitem['id_pesanan'] !== '0' && $get_statusprod !== '1'){
                        $desc_trans = "<a href='?online=pesanan&detailorder=".$transitem['id_pesanan']."' title='Transaksi Pesanan ID ".$transitem['id_pesanan']."' target='_blank'>Transaksi Pesanan ID ".$transitem['id_pesanan']."</a>";
                    }elseif( $transitem['type'] == 'in' ){ 
                        $desc_trans = "<a href='?logistics=pembelian&beliview=".$transitem['id_pembelian']."' title='Transaksi Pembelian ID ".$transitem['id_pembelian']."' target='_blank'>Transaksi Pembelian ID ".$transitem['id_pembelian']."</a>"; 
                    }else{
                        $desc_trans = $transitem['deskripsi'];
                    }
                }
        ?>
     
        <tr class="<?php echo $csstd; ?>" id="hpitem_<?php echo $transitem['id']; ?>">
            <td class="center nowrap" data-order="<?php echo $transitem['date']; ?>"><?php echo date('d M Y, H:i', $transitem['date']); ?></td>
            <td class="right nowrap"><?php echo $transitem['id']; ?></td>
            <td class="center"><?php echo $csstd; ?></td>
            <td class="right nowrap"><strong><?php echo $transitem['jumlah']; ?></strong></td>
            <td><?php echo $desc_trans; ?></td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</div>
<?php } ?>
<script type="text/javascript">
$(document).ready(function() {
    $('.datatable_stockview').DataTable({
        responsive: true,
        "pageLength": 10,
        "order": [[ 1, "asc" ]],
        "lengthChange": true,
        "searching": true,
        "paging": true,
        "info": false,
        "columnDefs": [
            { "orderable": false, "targets": 2 },
            { "orderable": false, "targets": 4 }
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
        }
    });
});
</script>
