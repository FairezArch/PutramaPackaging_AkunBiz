<?php if( is_admin() || is_ho_logistik() ){ ?>
<div class="topbar">Tambah Produk</div>
<div class="reportleft">
    <table class="detailtab tabcabang" width="100%">
        <?php /*
        <tr>
            <td class="tebal">Cabang<span class="harus">*</span></td>
            <td>
                <select id="idcabang" name="idcabang" disabled="disabled" style="cursor:not-allowed;">
                    <!--<option hidden="hidden" value="">Pilih Cabang</option>-->
                    <?php $args="SELECT * FROM cabang WHERE id='1'";
                    $result = mysqli_query( $dbconnect, $args );
                    while ( $data_cabang = mysqli_fetch_array($result) ) { ?>
                        <option data-cabang="<?php echo $data_cabang['nama']; ?>" value="<?php echo $data_cabang['id']; ?>"><?php echo $data_cabang['nama']; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
     */ 
        ?>
        <tr>
            <td class="tebal">Kategori<span class="harus">*</span></td>
            <td>
                <select id="idkategori" name="idkategori" style="width:250px;">
                    <option hidden="hidden" value="">Pilih Kategori</option>
                    <?php $master_kat = query_list_kategori('master'); 
                    while ( $datamaster = mysqli_fetch_array($master_kat) ) { ?>
                        <option value="<?php echo $datamaster['id']; ?>" class="masterct" disabled>
                            <?php echo $datamaster['kategori']; ?>
                        </option>
                    <?php $child_kat = query_list_kategori_from_master($datamaster['id']);
                            while ( $datachild = mysqli_fetch_array($child_kat) ) { ?>
                                <option value="<?php echo $datachild['id']; ?>">
                                    <?php echo $datachild['kategori']; ?>
                                </option>                                                  
                        <?php } 
                    } ?>

                </select>
                <input type="hidden" id="produkpram" value="baru" />
            </td>
        </tr>
        <tr>
            <td class="tebal">Barcode</td>
            <td><input type="text" id="barcode" name="barcode" style="width:175px;" /></td>
            <?php 
                /*$query = "SELECT max(id) as maxKode FROM produk";
                $hasil = mysqli_query($dbconnect,$query);
                $data = mysqli_fetch_array($hasil);
                $kodeBarang = $data['maxKode'];
                $noUrut = (int) substr($kodeBarang, 0, 3);
                $noUrut++;
                $kodeBarang = sprintf("%08u", $noUrut);*/
                //echo $kodeBarang;
                //$date = date('dmY'); echo $date; HPP
            ?>
        </tr>
        <tr>
            <td class="tebal">SKU<span class="harus">*</span></td>
            <td><input type="text" id="sku" name="sku" style="width:325px;" /></td>
        </tr>
        <tr>
            <td class="tebal">Nama Lengkap Produk<span class="harus">*</span></td>
            <td><input type="text" id="title" name="title" style="width:325px;" /></td>
        </tr>
        <tr class="none">
            <td class="tebal">Nama Produk<span class="harus">*</span></td>
            <td><input type="text" id="nama_produk" name="nama_produk" style="width:300px;"  maxlength="35"/></td>
        </tr>
        <tr>
            <td class="tebal">Harga Beli<span class="harus">*</span></td>
            <td><input type="text" class="jnumber" id="harga_beli" name="harga_beli" style="width:175px;" /></td>
        </tr>
        <tr>
            <td class="tebal">Harga Jual<span class="harus">*</span></td>
            <td><input type="text" class="jnumber" id="harga" name="harga" style="width:175px;" /></td>
        </tr>
        <tr class="none">
            <td class="tebal">Stok Awal<span class="harus">*</span></td>
            <td><input type="number" id="stock" name="stock" style="width:175px;" /></td>
        </tr>
        <tr>
            <td class="tebal">Stok Limit<span class="harus">*</span></td>
            <td><input type="number" id="stock_limit" name="stock_limit" style="width:175px;" /></td>
        </tr>
        <tr>
            <td class="tebal">Deskripsi</td>
            <td><textarea id="deskripsi" name="deskripsi" rows="10" style="width:325px;"></textarea></td>
        </tr>
        <tr>
            <td class="tebal">Berat Barang</td>
            <td>
                <input type="text" name="berat" id="berat">
                <select id="pilih_berat" name="pilih_berat">
                    <option value="gram">Gram</option>
                    <option value="kg">KG</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="tebal">Url Tokopedia</td>
            <td><input type="text" id="url_tokped" name="url_tokped" style="width:325px;" /></td>
        </tr>
        <tr>
            <td class="tebal">Url Bukalapak</td>
            <td><input type="text" id="url_bl" name="url_bl" style="width:325px;" /></td>
        </tr>
        <tr>
            <td class="tebal">Url Shopee</td>
            <td><input type="text" id="url_shopee" name="url_shopee" style="width:325px;" /></td>
        </tr>
        <tr class="none">
            <td class="tebal">Url Whatsapp</td>
            <td><input type="text" id="url_wa" name="url_wa" style="width:325px;" /></td>
        </tr>
        <tr class="none">
            <td colspan="2" class="tebal">
                <input id="status_promo_prod" type="checkbox" onchange="open_promo_prod()" > Produk Promo
            </td>
        </tr>
        <tr class="diskon_box none">
            <td class="tebal">Harga Diskon</td>
            <td>Rp <input type="text" class="jnumber nom_promo_prod" id="nom_promo_prod"></td>
        </tr>
        <tr class="none">
            <td colspan="2" class="tebal">
            <input id="status_parcel" type="checkbox" onchange="open_promo_parcel()" > Parcel
            </td>
        </tr>
        <tr>
            <td colspan="2" class="tebal">
            <input id="status_grosir" type="checkbox" onchange="open_grosir()"> Harga Grosir
            </td>
        </tr>
    </table>
    </div>

    <div class="reportright">
    <div class="title_upload tebal">Upload Gambar<span class="harus">*</span></div>
    <table class="detailtab tabcabang" width="100%">
        <tr>
            <td class="center">
                <img id="ganti_img" src="<?php echo GLOBAL_URL; ?>/penampakan/images/upload-image.png" title="Ukuran yang disarankan 240x240 pixel. Hanya jpg, gif, dan png file yang diijinkan. Maksimum ukuran file 1 Mb." width="240" height="240" />
            </td>
            <td></td>
        </tr>
        <tr>
            <td class="center">
                <div id="progress" class="progress">
                    <div class="progress-bar progress-bar-success"></div>
                    <div id="proses" class="proses">Mengupload...</div>
                    <div class="clear"></div>
                </div>
                
            </td>
            <td class="center">
                <div style="padding:8px 0;">
                    <label for="fileupload" class="btn upload_btn">Pilih Gambar</label>
                    <input id="fileupload" style="display:none;" class="fileupload" type="file" name="files[]" onclick="upload_gambar()" multiple="multiple"/>
                </div>
            </td>
            
        </tr>
        <input type="hidden" id="imgproduk" name="imgproduk"/>
    </table>

    <table class="stdtable none">
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td class="tebal center" colspan="2">Data Pembelian</td>
        </tr>
        <tr>
            <td class="tebal">Satuan</td>
            <td>
                <select id="satuan" name="satuan" class="satuan" style="width:185px;" >
                    <option value="Dus/Box">Dus/Box</option>
                    <option value="Satuan">Satuan</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="tebal">Jumlah dalam satuan</td>
            <td><input type="text" id="jml_satuan" name="jml_satuan" style="width:175px;" /></td>
        </tr>
        <tr>
            <td class="tebal">Harga beli</td>
            <td><input type="text" class="jnumber" id="harga_beli1" name="harga_beli1" style="width:175px;" /></td>
        </tr>
    </table>
    </div>


        <?php /*
        <tr class="diskon_box none">
            <td class="tebal">Diskon</td>
            <td><input type="text" class="right jnumber diskon_prod" id="diskon_prod" style="width:50px;"> %</td>
        </tr>
        <tr>
            <td>Status Produk</td>
            <td>
                <select name="status_prod" id="status_prod" style="width:175px;">
                    <option value='normal'>Normal</option>
                    <option value='promo'>Promo</option>
                </select>
            </td>
        </tr>
        */ ?>
 

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

<div class="clear"></div>
<br /><br />
<div class="tab-grosir none">
    <table class="stdtable" style="width: 100%;">
        <tbody>
            <tr>
                <td colspan="3" class="green"><strong>HARGA GROSIR</strong></td>
                <td class="green center" style="width: 30px;">
                    <img class="tabicon" src="penampakan/images/plus_white.png" width="20" height="20" alt="plus" onclick="tambah_item_grosir()">
                </td>
            </tr>
            <tr>
                <td class="grey center"><strong class="center">Min Qty</strong></td>
                <!--<td class="grey center"><strong class="center">Max Qty</strong></td>-->
                <td class="grey center"><strong class="center">Harga Satuan</strong></td>
                <td class="grey center">&nbsp;</td>
            </tr>
        </tbody>

        <tbody id="list_grosir">
            <input id="row_grosir" name="row_grosir" type="hidden" value="1" />
            <tr class="tr_item" id="tr_item_1">
                <td class="grey center"><input type="number" name="min_grosir" id="min_grosir_1" class="center min_grosir" placeholder="Min"></td>
                <!--<td class="grey center"><input type="number" name="max_grosir" id="max_grosir_1" class="center max_grosir" placeholder="Max"></td>-->
                <td class="grey center"><input type="text" name="harga_grosir" id="harga_grosir_1" class="jnumber center harga_grosir" placeholder="Harga Satuan"></td>
                <td class="grey center">&nbsp;</td>
            </tr>
        </tbody>

        <table class="childrow_grosir none" id="childrow_grosir">
            <tbody id="child_row">
                <tr class="tr_item" id="">
                    <td class="grey center"><input type="number" name="min_grosir" id="" class="center min_grosir" placeholder="Min"></td>
                    <!--<td class="grey center"><input type="number" name="max_grosir" id="" class="center max_grosir" placeholder="Max"></td>-->
                    <td class="grey center"><input type="text" name="harga_grosir" id="" class="jnumber center harga_grosir" placeholder="Harga Satuan"></td>
                    <td class="center"><img class="tabicon" src="penampakan/images/minus.png" width="20" height="20" alt="minus" onclick="" /></td>
                </tr>
            </tbody>
        </table>
    </table>
</div>

<div class="clark none">
<div class="boxright">
<table class="stdtable" style="width:100%;">
     <tbody>
            <tr>
                <td colspan="3" class="green"><strong>ITEM PRODUK</strong></td>
                <td class="green center">
                    <img class="tabicon" src="penampakan/images/plus_white.png" width="20" height="20" alt="plus" onclick="tambah_item_beli()" />
                </td>
            </tr>
            <tr>
                <!--<td class="grey center"><strong>ID</strong></td>-->
                <td class="grey center" style="padding-right:80px"><strong>Barcode</strong></td>
                <td class="grey center"><strong>Nama Produk*</strong></td>
                <td class="grey center"><strong>Jumlah Stok*</strong></td>
                <td class="grey center">&nbsp;</td>
            </tr>
        </tbody>

        <tbody id="daftar_item">
            <input id="row_product" name="row_product" type="hidden" value="1"/>
            <tr class="tr_item" id="tr_item_1">
                <!--<td><input type="text" class="idparcel" name="idparcel" id="idparcel_1" style="min-width: 125px;" ></td>-->
                <td>
                    <?php /*
                    <select class="barcode" name="barcode" id="barcode_1" style="width:130px;">
                        <option value=""></option>
                        <?php $barcode_query = query_beli_produk('barcode'); while ( $list_barcode = mysqli_fetch_array($barcode_query) ) { ?>
                            <option value="<?php echo $list_barcode['barcode']; ?>"><?php echo $list_barcode['barcode']; ?></option>
                        <?php } ?>
                    </select>
                    */ ?>
                    <input type="text" class="barcode" name="barcode" id="barcode_1" style="min-width:125px;" onchange="beli_select_data('1','barcode')">
                </td>    
                <td class="center">  
                    <select class="namaprod" name="namaprod" id="namaprod_1" style="width:550px;" onchange="beli_select_data('1','id')">
                        <option value="">Nama Produk</option>
                        <?php $nama_query = query_beli_produk('nama'); while ( $list_nama = mysqli_fetch_array($nama_query) ) { ?>
                            <option value="<?php echo $list_nama['id']; ?>"><?php echo $list_nama['title']; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td class="center nowrap">
                    <input class="itemtotal right" type="text" name="itemtotal" id="itemtotal_1" placeholder="0" style="width: 70px;" onchange="total_row(1)"/> Pcs
                </td>
               
                <td class="center">&nbsp;</td>
            </tr>
        </tbody> 
  
        <div class="clear"></div>
        <table class="mastertab none" id="mastertab">
            <tbody id="item_row">   
                <tr class="tr_item" id="">
                    <!--<td><input type="text" class="idparcel" name="parcel" id="idparcel" style="min-width: 125px;"></td>-->
                    <td>
                        <input type="text" class="barcode" name="barcode" id="" style="min-width:125px;" onchange="">
                    </td>    
                    <td class="center">  
                        <select class="namaprod" name="namaprod" id="" style="width:550px;" onchange="">
                            <option value="">Nama Produk</option>
                            <?php $nama_query = query_beli_produk('nama'); while ( $list_nama = mysqli_fetch_array($nama_query) ) { ?>
                                <option value="<?php echo $list_nama['id']; ?>"><?php echo $list_nama['title']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td class="center nowrap">
                        <input class="itemtotal right" type="text" name="itemtotal" id=""  placeholder="0" style="width: 70px;" onchange=""/> Pcs
                    </td>
                    <td class="center"><img class="tabicon" src="penampakan/images/minus.png" width="20" height="20" alt="minus" onclick="" /></td>
                </tr>    
            </tbody>
        </table>
    </table>
</div>
</div>



<table class="stdtable">
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
            <td class="right aksi">
                <input type="hidden" id="idcabang" name="idcabang" value="1" />
                <input type="hidden" id="idproduk" name="idproduk" />
                <input type="hidden" id="idparcel" name="idparcel" />
                <img id="loader" class="loader" src="penampakan/images/conloader.gif" width="32" height="32" style="right:210px;">
                <input type="button" class="btn back_btn" value="&laquo; Batal" onclick="kembali()" />
                <input type="button" class="btn save_btn" value="Simpan" onclick="upproduk()" />
            </td>
        </tr>
</table>

    <div id="notif" class="notif" style="display:none;"></div>
<div class="clear"></div>

<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#idkategori').select2();
    jQuery('.select2-selection__rendered').removeAttr('title');
});


jQuery(document).ready(function() {
   // open_promo_parcel();
    jQuery('#namaprod_1').select2();
    jQuery('.select2-selection__rendered').removeAttr('title');
});
</script>

<?php } ?>
