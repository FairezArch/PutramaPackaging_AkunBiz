<?php 
$id = $_GET["viewproduk"];
$args = "SELECT * FROM produk where id='$id'";
$result = mysqli_query( $dbconnect, $args );
$data_produk = mysqli_fetch_array($result);
?>
<div class="topbar">Detail Produk ID: <?php echo $data_produk['id']; ?></div>
<div class="reportleft">
    <table class="detailtab tabcabang" width="100%">
        <tr>
            <td class="tebal" style="width:105px;">Kategori<span class="harus">*</span></td>
            <td>
                <?php echo data_kategori($data_produk['idsubkategori'],'kategori'); ?>
                ( <strong><?php echo data_kategori($data_produk['idkategori'],'kategori'); ?></strong> )
            </td>
        </tr>
        <tr>
            <td class="tebal">Barcode</td>
            <td><strong style="line-height: 25px;"><?php echo $data_produk['barcode']; ?></strong> &nbsp; <img src="penampakan/images/printer.png" style="cursor: pointer; width: 25px; float: right;" onclick="open_printprodbarcode(<?php echo $data_produk['id']; ?>)"><div class="clear"></div></td>
        </tr>
        <tr>
            <td class="tebal">SKU</td>
            <td><?php echo $data_produk['sku']; ?></td>
        </tr>
        <tr>
            <td class="tebal">Nama Lengkap Produk</td>
            <td><?php echo $data_produk['title']; ?></td>
        </tr>
        <tr class="none">
            <td class="tebal">Nama Produk</td>
            <td><?php echo $data_produk['short_title']; ?></td>
        </tr>
        <tr>
            <td class="tebal">Harga Beli</td>
            <td><?php echo uang_false($data_produk['harga_beli']); ?></td>
        </tr>
        <tr>
            <td class="tebal">Harga Jual</td>
            <td><?php echo uang($data_produk['harga']); ?></td>
        </tr>
        <tr>
            <td class="tebal">Stok Limit</td>
            <td><?php echo $data_produk['stock_limit']; ?></td>
        </tr>
        <tr>
            <td class="tebal">Deskripsi</td>
            <td><?php echo nl2br($data_produk['deskripsi']); ?></td>
        </tr>
        <tr>
            <td class="tebal">Stock Produksi</td>
            <td class="nowrap"><?php echo allstock_display($data_produk['id'],'1'); ?></td>
        </tr>
        <tr>
            <td class="tebal">Stock Toko</td>
            <td class="nowrap"><?php echo allstock_display($data_produk['id'],'2'); ?></td>
        </tr>
        <tr>
            <td class="tebal">Stock Display</td>
            <td class="nowrap"><?php echo allstock_display($data_produk['id'],'3'); ?></td>
        </tr>
        <tr>
            <td class="tebal">Url Tokopedia</td>
            <td class="ln"><?php echo $data_produk['link_tokped'];?></td>
        </tr>
        <tr>
            <td class="tebal">Url Bukalapak</td>
            <td class="ln"><?php echo $data_produk['link_bl'];?></td>
        </tr>
        <tr>
            <td class="tebal">Url Shopee</td>
            <td class="ln"><?php echo $data_produk['link_shopee'];?></td>
        </tr>
        <?php /*
        <tr>
            <td class="tebal">Stok Tersedia</td>
            <td><?php echo all_stok_prod($data_produk['id'],'stock_tersedia'); ?></td>
        </tr>
        <tr>
            <td class="tebal">Stok Order</td>
            <td><?php echo all_stok_prod($data_produk['id'],'stok_order'); ?></td>
        </tr>*/ ?>
        <?php if( $data_produk['promo'] == '0' || $data_produk['promo'] == '' || ($data_produk['promo'] !== '0' || $data_produk['promo'] !== '') && $data_produk['harga_promo'] == '0'){ ?>
        <tr class="none">
            <td class="tebal">Harga Diskon</td>
            <td><?php echo uang($data_produk['harga_promo']); ?></td>
        </tr>
        <?php }else{  ?>
        <tr>
            <td class="tebal">Harga Diskon</td>
            <td><?php echo uang($data_produk['harga_promo']); ?></td>
        </tr>
        <?php } ?>
    </table>
    <table class="stdtable" style="margin-bottom:0px;">
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td>
                <input type="button" class="btn back_btn" value="Kembali" onclick="kembali()" />
            </td>
        </tr>
    </table>
</div>
<?php /* 
JANGAN DIHAPUS, INI BUAT PENGEMBANGAN
JANGAN DIHAPUS, INI BUAT PENGEMBANGAN
JANGAN DIHAPUS, INI BUAT PENGEMBANGAN
JANGAN DIHAPUS, INI BUAT PENGEMBANGAN
JANGAN DIHAPUS, INI BUAT PENGEMBANGAN

<div class="reportright">
	<div class="title_upload tebal">Upload Gambar<span class="harus">*</span></div>
    <table class="detailtab tabcabang" width="100%">
        <tr>
            <td class="center">
            	<div style="padding:8px 0;">
                    <label for="fileupload" class="btn upload_btn">Pilih Gambar</label>
                    <input id="fileupload" style="display:none;" class="fileupload" type="file" name="files[]" onclick="uploadfile()" multiple="multiple"/>
                </div>
                
            </td>
            <td class="center" style="width:320px;">
            	<div id="progress" class="progress none">
                    <div class="progress-bar progress-bar-success"></div>
                    <div id="proses" class="proses">Mengupload...</div>
                    <div class="clear"></div>
                </div>
                
            </td>
        </tr>
        <tr>
            <td colspan="2">
            	<table class="innertable" style="width:99%;" id="tabs_img_file">
                </table>
            </td>
        </tr>
        
        <input type="hidden" id="imgproduk" name="imgproduk"/>
    </table>
</div>
*/ ?>
<div class="reportright">
	<div class="title_upload tebal">Gambar produk</div>
    <table class="detailtab tabcabang" width="100%">
        <tr>
            <td>
                <?php if ( $data_produk['image'] == '' ){ ?>
					<img id="ganti_img" src="<?php echo GLOBAL_URL; ?>/penampakan/images/upload-image.png" title="Ukuran yang disarankan 240x240 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="240" />
				<?php } else { ?>
                	<img id="ganti_img" src="<?php echo GLOBAL_URL.$data_produk['image']; ?>" title="Ukuran yang disarankan 240x240 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="240" />
            	<?php } ?>
            </td>
        </tr>
    </table>
    <table class="stdtable hidden">
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td class="tebal center" colspan="2">Data Pembelian</td>
        </tr>
        <tr>
            <td class="tebal" style="width:40%;">Satuan</td>
            <td style="width:55%;"><?php echo $data_produk['satuan']; ?></td>
        </tr>
        <tr>
            <td class="tebal">Jumlah dalam satuan</td>
            <td><?php echo $data_produk['jml_persatuan']; ?></td>
        </tr>
        <tr>
            <td class="tebal">Harga beli</td>
            <td><?php echo uang($data_produk['harga_beli']); ?></td>
        </tr>
    </table>
</div>
<div class="clear"></div>
<?php 
    $list_parcel = prod_item($id); 
    $lihat_idparcel = $list_parcel['id_prod_master'];
    $lihat_nameparcel = $list_parcel['id_prod_item'];
    $lihat_jmlparcel = $list_parcel['jumlah_prod'];
        if($lihat_nameparcel || $lihat_jmlparcel != ''){
                      
?>
<table class="stdtable " style="width:100%; margin-top: 30px;">
        <tbody>
            <tr>
                <td class="green" colspan="3"><strong>ITEM PRODUK</strong></td>
                <!--<td class="green">&nbsp;</td>-->
            </tr>
            <tr>
                <!--<td class="grey center"><strong>ID</strong></td>-->
                <td class="grey center" style="width: 200px;"><strong>Barcode</strong></td>
                <td class="grey center" style="width: 700px;"><strong>Nama Produk</strong></td>
                <td class="grey center"><strong>Jumlah Stok</strong></td>
                <!--<td class="grey center">&nbsp;</td>-->
            </tr>
        </tbody>
        <tbody id="daftar_item">
           <tr class="tr_item" id="tr_item_1">
                 <?php
                $view_parcel = prod_item($id);
                $view_parcelitem =  explode('|', $view_parcel['id_prod_item']);
                $view_parceljumlah =  explode('|', $view_parcel['jumlah_prod']);
            
                $jml_parcel = count($view_parcelitem);
                $x=0; $y=1;
                while($y <= $jml_parcel){
            ?>
            <input id="row_product" name="row_product" type="hidden" value="<?php echo $jml_parcel;?>"/>
            <tr class="tr_item" id="tr_item_<?php echo $y; ?>">
               <td class="center nowrap"> 
                    <?php echo querydata_prod($view_parcelitem[$x],'barcode'); ?>
                </td>    
                <td class="center nowrap">
                    <?php echo querydata_prod($view_parcelitem[$x],'title');?>
                </td>
                <td class="center nowrap">
                    <?php echo $view_parceljumlah[$x]; ?> Pcs
                </td>
                <!--<td class="center <?php //if($y == 1){echo 'none';}?>"><img class="tabicon" src="penampakan/images/minus.png" width="20" height="20" alt="minus" onclick="min_row(<?php //echo $y; ?>)" /></td>
                <td class="center">&nbsp;</td>
                onchange="total_row(<?php //echo $y; ?>)"-->
            </tr>
            <?php $x++; $y++;} ?>
            </tr>
        </tbody>
    </table>
<?php }else{}?>
<div class="clear"></div>
<?php /*
<div class="wraptrans wraptranssaldo">
    <h3>Daftar Transaksi Stok</h3>
    <div class="daftrans">
        <div class="daftransbutton">
	<input type="button" class="btn save_btn" id="newuser" value="Tambah Stok" onclick="plusmin_stok('in','<?php echo $id; ?>')"
    	title="Tambah Stok"/>
    &nbsp;
    <input type="button" class="btn batal_btn" id="newuser" value="Kurangi Stok" onclick="plusmin_stok('out','<?php echo $id; ?>')"
    	title="Kurangi Stok" /> 
</div>
    <table class="dataTable" width="100%" border="0" id="datatable_produkview">
        <thead>
            <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">ID</th>
                <th scope="col">Type</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Deskripsi</th>
                <th scope="col">Stok Tersedia</th>
                <th scope="col">Opsi</th>
             </tr>
        </thead>
        <tbody>
  		<?php 
            $args = "SELECT * FROM trans_order WHERE id_produk='$id' ORDER BY date ASC";
    		$result = mysqli_query( $dbconnect, $args );
            $stok = $data_produk['stock'];
    		while ( $transitem = mysqli_fetch_array($result) ) {
                $get_idpesan = $transitem['id_penjualan'];
                $get_statusprod = querydata_pesanan($get_idpesan,'status_bayar');
                if( $transitem['type'] == 'out' ){ $csstd = 'minus'; }
                elseif( $transitem['type'] == 'in' ){ $csstd = 'plus'; }
                elseif( $transitem['type'] == 'trans') { $csstd = 'Transfer Stock'; }
                else{ $csstd = ''; }
                
                if ( 'in' == $transitem['type'] ) { $stok = $stok + $transitem['jumlah']; }
    			if ( 'out' == $transitem['type'] ) { $stok = $stok - $transitem['jumlah']; }  

                /*if ( $transitem['trans_from'] < $transitem['trans_to'] ){
                    $stok = $stok - $transitem['jumlah'];
                    $rst = 'Transfer Stock dari'." ".name_transstock($transitem['trans_from'])." ke ".name_transstock($transitem['trans_to']);
                }elseif ( $transitem['trans_from'] > $transitem['trans_to'] ){
                    $stok = $stok + $transitem['jumlah'];
                    $rst = 'Dikembalikan dari'." ".name_transstock($transitem['trans_from'])." ke ".name_transstock($transitem['trans_to']);
                }else{
                    $rst = $transitem['deskripsi'];
                }
                
                if( $transitem['id_pesanan'] == '0' && $transitem['id_pembelian'] == '0' && $transitem['id_penjualan'] == '0' ){
                    $desc_trans = $transitem['deskripsi'];
                }else{
                    if( $transitem['type'] == 'out' && $transitem['id_penjualan'] !== '0' && $get_statusprod == 'tunai' ){ 
                        $desc_trans = "<a href='?page=penjualan&detailpenjualan=".$transitem['id_pesanan']."' title='Transaksi Penjualan ID ".$transitem['id_pesanan']."' target='_blank'>Transaksi Penjualan ID ".$transitem['id_pesanan']."</a>";

                    }elseif ( $transitem['type'] == 'out' && $transitem['id_pesanan'] !== '0' && $get_statusprod !== 'tunai'){
                        $desc_trans = "<a href='?page=pesanan&detailorder=".$transitem['id_pesanan']."' title='Transaksi Pesanan ID ".$transitem['id_pesanan']."' target='_blank'>Transaksi Pesanan ID ".$transitem['id_pesanan']."</a>";
                    }elseif( $transitem['type'] == 'in' ){ 
                        $desc_trans = "<a href='?page=pembelian&beliview=".$transitem['id_pembelian']."' title='Transaksi Pembelian ID ".$transitem['id_pembelian']."' target='_blank'>Transaksi Pembelian ID ".$transitem['id_pembelian']."</a>"; 
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
            <td><?php //echo $rst; ?></td>
            <td class="right nowrap">
                <strong><?php //echo $stok; ?></strong>
            </td>
            <td class="center">
                <?php if( $transitem['id_pesanan'] == '0' && $transitem['id_pembelian'] == '0' ){ ?>
                    <input type="hidden" id="pmdate_<?php echo $transitem['id']; ?>" value="<?php echo date('d F Y', $transitem['date']); ?>">
                    <input type="hidden" id="pmhour_<?php echo $transitem['id']; ?>" value="<?php echo date('H', $transitem['date']); ?>">
                    <input type="hidden" id="pmminute_<?php echo $transitem['id']; ?>" value="<?php echo date('i', $transitem['date']); ?>">
                    <input type="hidden" id="pmjumlah_<?php echo $transitem['id']; ?>" value="<?php echo $transitem['jumlah']; ?>">
                    <input type="hidden" id="pmdesc_<?php echo $transitem['id']; ?>" value="<?php echo $transitem['deskripsi']; ?>">
                    <input type="hidden" id="trans_id_<?php echo $transitem['id']; ?>" value="<?php echo $transitem['id']; ?>">
                    <input type="hidden" id="trans_type_<?php echo $transitem['id']; ?>" value="<?php echo $transitem['type']; ?>">
                    <input type="hidden" id="trans_idprod_<?php echo $transitem['id']; ?>" value="<?php echo $transitem['id_produk']; ?>">
                    
                    <img class="tabicon" src="penampakan/images/tab_edit.png" width="20" height="20" alt="Edit Transaksi" title="Edit Transaksi"
                            onclick="edit_plusmin_stok('<?php echo $transitem['id']; ?>')"/>
                    &nbsp;
                    <img class="tabicon" src="penampakan/images/tab_delete.png" width="20" height="20" alt="Hapus Transaksi" title="Hapus Transaksi"
                            onclick="open_del_pm_stok('<?php echo $transitem['id']; ?>')"/>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</div>
<?php // start plusminus stok box ?>
<div class="poptrans" id="debtplusminus">
	<h3><span id="penkur">PENAMBAHAN</span> STOK</h3>
	<table class="stdtable">
		<tr>
			<td>Tanggal*</td>
			<td>
            	<input type="text" class="datepicker" name="pmdate" id="pmdate" value="<?php echo date('j F Y'); ?>"
                	title="Tanggal mulai <?php //echo $hpber; ?>"/>
                &nbsp;
                <select name="pmhour" id="pmhour">
                    <?php $hnow = date('H'); $h = 0; while($h <= 23) { $hshow = sprintf("%02d", $h); ?>
                    <option value="<?php echo $hshow; ?>" <?php auto_select($hnow,$hshow); ?> ><?php echo $hshow; ?></option>
                    <?php $h++; } ?>
                </select>
                <select name="pmminute" id="pmminute">
                    <?php $mnow = date('i'); $m = 0; while($m <= 59) { $mshow = sprintf("%02d", $m); ?>
                    <option value="<?php echo $mshow; ?>" <?php auto_select($mnow,$mshow); ?> ><?php echo $mshow; ?></option>
                    <?php $m++; } ?>
                </select>
            </td>
		</tr>
        <tr>
			<td>Jumlah*</td>
			<td>
                <input type="text" class="right" name="pmjumlah" id="pmjumlah" style="width: 96px;" placeholder="0" value="" />
			</td>
		</tr>
		<tr>
			<td>Deskripsi</td>
			<td><textarea name="pmdesc" id="pmdesc" style="width: 92%; height: 48px;"></textarea></td>
		</tr>
	</table>
    <div class="submitarea">
        <input type="button" value="Batal" class="btn batal_btn" name="pm_cancel" id="pm_cancel" onclick="close_pm_stok()" title="Tutup window ini"/>
        <input type="button" value="Simpan" class="btn save_btn" name="pm_save" id="pm_save" onclick="save_pm_stok()"/>
        <input type="hidden" id="trans_id" value="0" />
        <input type="hidden" id="trans_type" value="" />
        <input type="hidden" id="trans_idprod" value="0" />
        <div class="notif none" id="pm_notif"></div>
        <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="top:0px; right:60px;" id="pm_loader" alt="Mohon ditunggu...">
	</div>
</div>

<div class="popup popdel" id="popdel_pm_stok">
	<strong>Apakah Anda yakin ingin menghapus Transaksi ID <span id="delete_idpm_text"></span> ?</strong><br />
	Transaksi lain yang berkaitan juga akan terhapus serta tidak dapat ditampilkan kembali.
    <br /><br />
    <input type="button" class="btn back_btn" id="delusercancel" name="delusercancel" value="Batal" onclick="cancel_del_pm_stok()"/>
    &nbsp;&nbsp;
    <input type="button" class="btn delete_btn"  id="deluserok" name="deluserok" value="Hapus!" onclick="del_pm_stok()"/>
    <div id="prosesdel" class="none" style="padding-top:16px; text-align: center;">Menghapus Pembelian... tunggu sebentar.</div>
    <input type="hidden" id="delete_idpm" name="delete_idpm" value="0"/>
</div> */?>
<div class="wraptranssaldo">
    <h3>DAFTAR HARGA GROSIR</h3>
<table class="stdtable" width="100%" border="0" id="datatable_prodgrosir">
    <thead>
        <tr>
            <th>No</th>
            <th>Min Qty</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
         <?php 
        $args_grosir = "SELECT * FROM daftar_grosir WHERE id_produk='$id'";
        $list_grosir = mysqli_query($dbconnect,$args_grosir);

        //if(mysqli_num_rows($list_grosir)){
        while($fetch_grosir = mysqli_fetch_array($list_grosir)){
            $min = $fetch_grosir['qty_from'];
            $harga = $fetch_grosir['harga_satuan'];
            $x=1;
            //exp
            $exp_min = explode('|',$min);
            $exp_harga = explode('|',$harga);
            $count = count($exp_min);
            $a=0;
           while($x <= $count){
    ?>
        <tr>
            <td class="center"><?php echo $x;?></td>
            <td class="center"><?php echo $exp_min[$a];?></td>
            <td class="center"><?php echo $exp_harga[$a];?></td>
        </tr>
        <?php 
            $a++; 
            $x++;
                } }
        ?>
    </tbody>
</table>
</div>

<div class="wraptranssaldo">
    <h3>DAFTAR RATING PRODUK</h3>
<table class="stdtable" width="100%" border="0" id="datatable_prodratting">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Ratting</th>
            <th>Review</th>
            <th>Pesanan</th>
        </tr>
    </thead>
    <?php 
        $list_rating = data_rating($data_produk['id']);
        while( $fetch_rating = mysqli_fetch_array($list_rating) ){
    ?>
    <tbody>
        <tr>
            <td class="center"><?php echo $fetch_rating['id'];?></td>
            <td class="center"><?php echo date('d F Y', $fetch_rating['date']);?></td>
            <td class="center">
                <?php 
                    for( $i=1; $i<=5; $i++ ){
                        if($i <= $fetch_rating['get_star']){ $addClass = 'star_checked'; }else{ $addClass = ''; }
                        echo "<img src='penampakan/images/star-gold.png' class='star-img ".$addClass."'>";
                    }
                ?>
            </td>
            <td><?php echo "<strong>".$fetch_rating['title_review']."</strong><br />".$fetch_rating['description'];?></td>
            <td class="center"><?php echo $fetch_rating['id_pesan'];?></td>
        </tr>
    </tbody>
    <?php } ?>
</table>
</div>
<?php // Open Print
if( is_admin() ){ ?>
<div class="popkat cashtrans" id="pop_openprint" style="width: 450px;">
    <h3>Print Barcode Produk <span id="titlepopid"></span></h3>
    <table class="stdtable">
        <input type="hidden" name="pop_produkid" id="pop_produkid" value="<?php echo $data_produk['id'];?>">
        <input type="hidden" name="pop_produkbarcode" id="pop_produkbarcode" value="<?php echo $data_produk['barcode'];?>">
        <input type="hidden" name="pop_produknama" id="pop_produknama" value="<?php echo $data_produk['title'];?>">
    <tr id="trtypeselect">
            <td style="width:86px;">Barcode</td>
            <td><span id="print_barcode"></span></td>
        </tr>
        <tr id="trtypeselect">
            <td style="width:86px;">Jumlah*</td>
            <td><input type="number" name="print_jml" id="print_jml" value="1"></td>
        </tr>
    </table>
    <div class="submitarea">
        <input type="button" value="Batal" name="cash_cancel" class="btn back_btn" value="« Batal" id="cash_cancel" onclick="batal_printprodbarcode()" title="Tutup window ini"/>
        <input type="button" value="Print" class="btn save_btn" name="cash_save" id="trans_save" onclick="printprodbarcode()"/>
        <input type="hidden" id="print_idprodvar" value="0" />
        <div class="notif" id="openprint_notif"></div>
        <img class="loader" src="penampakan/images/conloader.gif" width="32" height="32" id="openprint" alt="Mohon ditunggu..." />
    </div>
</div>
<?php } ?>

<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#idkategori').select2();
    jQuery('.select2-selection__rendered').removeAttr('title');
});
$(document).ready(function() {
	$('#datatable_prodratting').DataTable({
        responsive: true,
		"pageLength": 10,
		"order": [[ 0, "asc" ]],
		"lengthChange": true,
		"searching": true,
		"paging": true,
		"info": false,
        "columnDefs": [
			{ "orderable": false, "targets": 2},
            { "orderable": false, "targets": 3},
            { "orderable": false, "targets": 4}
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
<script type="text/javascript">
    $(document).ready(function() {
    $('#datatable_prodgrosir').DataTable({
        responsive: true,
        "pageLength": 10,
        "order": [[ 0, "asc" ]],
        "lengthChange": true,
        "searching": true,
        "paging": true,
        "info": false,
        "columnDefs": [
            { "orderable": false, "targets": 2}

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
